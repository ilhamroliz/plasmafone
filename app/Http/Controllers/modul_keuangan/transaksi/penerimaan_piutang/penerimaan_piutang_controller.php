<?php

namespace App\Http\Controllers\modul_keuangan\transaksi\penerimaan_piutang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_receivable_detail as detail;

use DB;
use keuangan;

class penerimaan_piutang_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.transaksi.penerimaan_piutang.index');
    }

    public function form_resource(Request $request){

    	$chanel = DB::table('dk_receivable')->distinct('rc_chanel')->select('rc_chanel as id', 'rc_chanel as text')->get();

        $kelompok_kas = DB::table('dk_hierarki_penting')->where('hp_id', '4')->first();
        $kelompok_bank = DB::table('dk_hierarki_penting')->where('hp_id', '5')->first();

    	$akunKas = DB::table('dk_akun')
    					->where('ak_kelompok', $kelompok_kas->hp_hierarki)
    					->where('ak_isactive', '1')
    					->select('ak_id as id', DB::raw("concat(ak_id, ' - ', ak_nama) as text"))
    					->get();

    	$akunBank = DB::table('dk_akun')
    					->where('ak_kelompok', $kelompok_bank->hp_hierarki)
    					->where('ak_isactive', '1')
    					->select('ak_id as id', DB::raw("concat(ak_id, ' - ', ak_nama) as text"))
    					->get();

    	$response = [
    		'chanel'	=> $chanel,
    		'akunKas'	=> $akunKas,
    		'akunBank'	=> $akunBank

    	];

    	return json_encode($response);
    }

    public function datatable(Request $request){

        $tanggal = explode('/', $request->tgl)[2].'-'.explode('/', $request->tgl)[1].'-01';
        $tanggalNext = date('Y-m-d', strtotime('+1 months', strtotime($tanggal)));

        $data = detail::with([
                                'receivable' => function($query){
                                    $query->select(
                                                    'rc_id',
                                                    'rc_nomor',
                                                    'rc_total_tagihan',
                                                    'rc_sudah_dibayar',
                                                     DB::raw('concat(ak_1.ak_id, " - ", ak_1.ak_nama) as rc_akun_piutang'),
                                                     DB::raw('concat(ak_2.ak_id, " - ", ak_2.ak_nama) as rc_akun_titipan')
                                                )
                                                ->leftJoin('dk_akun as ak_1', 'ak_1.ak_id', 'dk_receivable.rc_akun_piutang')
                                                ->leftJoin('dk_akun as ak_2', 'ak_2.ak_id', 'dk_receivable.rc_akun_titipan')
                                                ->first();
                                },

                                'jurnal' => function($query){
                                    $query->select('jr_id', 'jr_ref')->with('detail:jrdt_jurnal,jrdt_akun,jrdt_value,jrdt_dk')->first();
                                }
                        ])
                        ->whereIn('rcdt_receivable', function($query) use ($request){
                            $query->select('rc_id')
                                        ->from('dk_receivable')
                                        ->where('rc_chanel', $request->jenis)->get();
                        })
                        ->where('rcdt_tanggal', '>=', $tanggal)
                        ->where('rcdt_tanggal', '<', $tanggalNext)->get();

        return json_encode($data);
    }

    public function get_nota(Request $request){

    	$sales = DB::table('dk_receivable')
                    ->leftJoin('dk_akun as ak_1', 'ak_1.ak_id', '=', 'dk_receivable.rc_akun_piutang')
                    ->leftJoin('dk_akun as ak_2', 'ak_2.ak_id', '=', 'dk_receivable.rc_akun_titipan')
    				->where('dk_receivable.rc_chanel', $request->chanel)
    				->where(DB::raw('(rc_total_tagihan - rc_sudah_dibayar)'), '>', '0')
                    ->select(
                            'dk_receivable.*',
                            DB::raw('concat(ak_1.ak_id, " - ", ak_1.ak_nama) as rc_akun_piutang'),
                            DB::raw('concat(ak_2.ak_id, " - ", ak_2.ak_nama) as rc_akun_titipan'),
                            DB::raw('(dk_receivable.rc_total_tagihan - dk_receivable.rc_sudah_dibayar) as rc_sisa_tagihan'))
    				->get();

    	return json_encode($sales);
    }

    public function store(Request $request){
        // return json_encode($request->all());

        $data = DB::table('dk_receivable')->where('rc_nomor', $request->rc_sales);

        if(!$data->first()){
            $response = [
                "status"    => 'error',
                "message"   => 'Nomor Piutang Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        DB::beginTransaction();

        try {

            $jurnalDetail = [];

            $tanggal = explode('/', $request->rc_tanggal_trans)[2].'-'.explode('/', $request->rc_tanggal_trans)[1].'-'.explode('/', $request->rc_tanggal_trans)[0];
            $cekAk1 = DB::table('dk_akun')->where('ak_id', $request->akun)->first();

            $id = (DB::table('dk_receivable_detail')->max('rcdt_id')) ? (DB::table('dk_receivable_detail')->max('rcdt_id') + 1) : 1;

            $nomor = (DB::table('dk_receivable_detail')->where('rcdt_receivable', $data->first()->rc_id)->max('rcdt_nomor')) ? (DB::table('dk_receivable_detail')->where('rcdt_receivable', $data->first()->rc_id)->max('rcdt_nomor') + 1) : 1;;

            $rc_value = ($request->rc_value) ? str_replace(',', '', $request->rc_value) : 0;
            $dibayar = $rc_value;

            if($rc_value > ($data->first()->rc_total_tagihan - $data->first()->rc_sudah_dibayar)){
                $dibayar = ($data->first()->rc_total_tagihan - $data->first()->rc_sudah_dibayar);
            }

            if(!$cekAk1){
                $response = [
                        "status"    => 'gagal',
                        "message"   => 'Beberapa Akun Tidak Bisa Ditemukan, Cobalah Untuk Memuat Ulang Halaman',
                    ];

                    return json_encode($response);
            }

            DB::table('dk_receivable_detail')->insert([
                'rcdt_id'           => $id,
                'rcdt_receivable'   => $data->first()->rc_id,
                'rcdt_nomor'        => $data->first()->rc_nomor.'-'.$nomor,
                'rcdt_keterangan'   => $request->rc_keterangan,
                'rcdt_tanggal'      => $tanggal,
                'rcdt_value'        => $dibayar,
                'rcdt_type'         => $request->jenis
            ]);

            $data->update([
                'rc_sudah_dibayar' => DB::raw('rc_sudah_dibayar + '.$dibayar),
            ]);

            if(isset($request->dana_titipan)){
                $cekPiutang = DB::table('dk_akun')->where('ak_id', $data->first()->rc_akun_piutang)->first();
                $cekTitipan = DB::table('dk_akun')->where('ak_id', $data->first()->rc_akun_titipan)->first();

                if(!$data->first()->rc_akun_piutang || !$cekPiutang){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Piutang Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                if(!$data->first()->rc_akun_titipan || !$cekTitipan){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Titipan Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                $jurnalDetail[$request->akun] = [
                    'jrdt_akun'          => $request->akun,
                    'jrdt_value'         => $rc_value,
                    'jrdt_dk'            => 'D'
                ];

                $jurnalDetail[$data->first()->rc_akun_piutang] = [
                    'jrdt_akun'          => $data->first()->rc_akun_piutang,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'K'
                ];

                $jurnalDetail[$data->first()->rc_akun_titipan] = [
                    'jrdt_akun'          => $data->first()->rc_akun_titipan,
                    'jrdt_value'         => ($rc_value - $dibayar),
                    'jrdt_dk'            => 'K'
                ];

            }else{
                $cekPiutang = DB::table('dk_akun')->where('ak_id', $data->first()->rc_akun_piutang)->first();

                if(!$data->first()->rc_akun_piutang || !$cekPiutang){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Piutang Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                $jurnalDetail[$request->akun] = [
                    'jrdt_akun'          => $request->akun,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'D'
                ];

                $jurnalDetail[$data->first()->rc_akun_piutang] = [
                    'jrdt_akun'          => $data->first()->rc_akun_piutang,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'K'
                ];
            }

            $state = ($request->jenis == 'C') ? 'KM' : 'BM';

            keuangan::jurnal()->addJurnal($jurnalDetail, $tanggal, $data->first()->rc_nomor.'-'.$nomor, $request->rc_keterangan, $state, jurnal()->comp, true);

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Penerimaan Piutang Berhasil Disimpan',
            ];

            return json_encode($response);
            
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                "status"    => 'error',
                "message"   => 'System Mengalami Masalah. Err: '.$e,
            ];

            return json_encode($response);
        }
    }

    public function update(Request $request){
        // return json_encode($request->all());

        $rcdt = DB::table('dk_receivable_detail')->where('rcdt_id', $request->rc_id);

        if(!$rcdt->first()){
             $response = [
                "status"    => 'error',
                "message"   => 'Data Penerimaan Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        $receivable = DB::table('dk_receivable')->where('rc_id', $rcdt->first()->rcdt_receivable);

        if(!$receivable->first()){
             $response = [
                "status"    => 'error',
                "message"   => 'Data Piutang Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return $this->dropAllPenerimaan($rcdt->first()->rcdt_receivable);

            return json_encode($response);
        }

        DB::beginTransaction();

        try {
            
            $jurnalDetail = [];

            $tanggal = explode('/', $request->rc_tanggal_trans)[2].'-'.explode('/', $request->rc_tanggal_trans)[1].'-'.explode('/', $request->rc_tanggal_trans)[0];

            $sudah_dibayar_lama = ($receivable->first()->rc_sudah_dibayar - $rcdt->first()->rcdt_value);
            $sisa_lama = ($receivable->first()->rc_total_tagihan - $sudah_dibayar_lama);

            $rc_value = ($request->rc_value) ? str_replace(',', '', $request->rc_value) : 0;
            $dibayar = $rc_value;

            if($rc_value > $sisa_lama){
                $dibayar = ($sisa_lama);
            }

            $cekAk1 = DB::table('dk_akun')->where('ak_id', $request->akun)->first();

            if(!$cekAk1){
                $response = [
                        "status"    => 'gagal',
                        "message"   => 'Beberapa Akun Tidak Bisa Ditemukan, Cobalah Untuk Memuat Ulang Halaman',
                    ];

                    return json_encode($response);
            }

            $rcdt->update([
                'rcdt_keterangan'   => $request->rc_keterangan,
                'rcdt_tanggal'      => $tanggal,
                'rcdt_value'        => $dibayar,
                'rcdt_type'         => $request->jenis,
            ]);

            $receivable->update([
                'rc_sudah_dibayar' => ($sudah_dibayar_lama + $dibayar),
            ]);

            if(isset($request->dana_titipan)){

                $cekPiutang = DB::table('dk_akun')->where('ak_id', $receivable->first()->rc_akun_piutang)->first();
                $cekTitipan = DB::table('dk_akun')->where('ak_id', $receivable->first()->rc_akun_titipan)->first();

                if(!$receivable->first()->rc_akun_piutang || !$cekPiutang){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Piutang Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                if(!$receivable->first()->rc_akun_titipan || !$cekTitipan){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Titipan Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                $jurnalDetail[$request->akun] = [
                    'jrdt_akun'          => $request->akun,
                    'jrdt_value'         => $rc_value,
                    'jrdt_dk'            => 'D'
                ];

                $jurnalDetail[$receivable->first()->rc_akun_piutang] = [
                    'jrdt_akun'          => $receivable->first()->rc_akun_piutang,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'K'
                ];

                $jurnalDetail[$receivable->first()->rc_akun_titipan] = [
                    'jrdt_akun'          => $receivable->first()->rc_akun_titipan,
                    'jrdt_value'         => ($rc_value - $dibayar),
                    'jrdt_dk'            => 'K'
                ];

            }else{
                $cekPiutang = DB::table('dk_akun')->where('ak_id', $receivable->first()->rc_akun_piutang)->first();

                if(!$receivable->first()->rc_akun_piutang || !$cekPiutang){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Piutang Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                $jurnalDetail[$request->akun] = [
                    'jrdt_akun'          => $request->akun,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'D'
                ];

                $jurnalDetail[$receivable->first()->rc_akun_piutang] = [
                    'jrdt_akun'          => $receivable->first()->rc_akun_piutang,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'K'
                ];
            
            }

            $idJurnal = DB::table('dk_jurnal')->where('jr_ref', $rcdt->first()->rcdt_nomor)->first();

            if($idJurnal){
                keuangan::jurnal()->dropJurnal($idJurnal->jr_id);
            }

            $state = ($request->jenis == 'C') ? 'KM' : 'BM';

            keuangan::jurnal()->addJurnal($jurnalDetail, $tanggal, $rcdt->first()->rcdt_nomor, $request->rc_keterangan, $state, jurnal()->comp, true);

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Transaksi Penerimaan Berhasil Diperbarui',
            ];

            return json_encode($response);

        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                "status"    => 'error',
                "message"   => 'System Mengalami Masalah. Err: '.$e,
            ];

            return json_encode($response);
        }

        return json_encode($rcdt->first());
    }

    public function delete(Request $request){
        // return json_encode($request->all());

        $rcdt = DB::table('dk_receivable_detail')->where('rcdt_id', $request->rc_id);

        if(!$rcdt->first()){
             $response = [
                "status"    => 'error',
                "message"   => 'Data Penerimaan Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        $receivable = DB::table('dk_receivable')->where('rc_id', $rcdt->first()->rcdt_receivable);

        if(!$receivable->first()){
             $response = [
                "status"    => 'error',
                "message"   => 'Data Piutang Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return $this->dropAllPenerimaan($rcdt->first()->rcdt_receivable);

            return json_encode($response);
        }

        DB::beginTransaction();

        try {
            
            $value = $rcdt->first()->rcdt_value;
            $nomor = $rcdt->first()->rcdt_nomor;

            $rcdt->delete();

            $receivable->update([
                'rc_sudah_dibayar' => DB::raw('rc_sudah_dibayar - '.$value),
            ]);

            $idJurnal = DB::table('dk_jurnal')->where('jr_ref', $nomor)->first();

            if($idJurnal){
                keuangan::jurnal()->dropJurnal($idJurnal->jr_id);
            }

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Transaksi Penerimaan Berhasil Dihapus',
            ];

            return json_encode($response);

        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                "status"    => 'error',
                "message"   => 'System Mengalami Masalah. Err: '.$e,
            ];

            return json_encode($response);
        }
    }

    public function dropAllPenerimaan(String $idPiutang){
        return json_encode($idPiutang);
    }

}