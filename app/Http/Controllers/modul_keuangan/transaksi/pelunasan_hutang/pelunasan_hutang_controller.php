<?php

namespace App\Http\Controllers\modul_keuangan\transaksi\pelunasan_hutang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_payable_detail as detail;

use DB;
use keuangan;

class pelunasan_hutang_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.transaksi.pelunasan_hutang.index');
    }

    public function form_resource(Request $request){

    	$chanel = DB::table('dk_payable')->distinct('py_chanel')->select('py_chanel as id', 'py_chanel as text')->get();

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
                                'payable' => function($query){
                                    $query->select(
                                                    'py_id',
                                                    'py_nomor',
                                                    'py_total_tagihan',
                                                    'py_sudah_dibayar',
                                                     DB::raw('concat(ak_1.ak_id, " - ", ak_1.ak_nama) as py_akun_hutang'),
                                                     DB::raw('concat(ak_2.ak_id, " - ", ak_2.ak_nama) as py_akun_titipan')
                                                )
                                                ->leftJoin('dk_akun as ak_1', 'ak_1.ak_id', 'dk_payable.py_akun_hutang')
                                                ->leftJoin('dk_akun as ak_2', 'ak_2.ak_id', 'dk_payable.py_akun_titipan')
                                                ->first();
                                },

                                'jurnal' => function($query){
                                    $query->select('jr_id', 'jr_ref')->with('detail:jrdt_jurnal,jrdt_akun,jrdt_value,jrdt_dk')->first();
                                }
                        ])
                        ->whereIn('pydt_payable', function($query) use ($request){
                            $query->select('py_id')
                                        ->from('dk_payable')
                                        ->where('py_chanel', $request->jenis)->get();
                        })
                        ->where('pydt_tanggal', '>=', $tanggal)
                        ->where('pydt_tanggal', '<', $tanggalNext)->get();

        return json_encode($data);
    }

    public function get_nota(Request $request){

    	$sales = DB::table('dk_payable')
                    ->leftJoin('dk_akun as ak_1', 'ak_1.ak_id', '=', 'dk_payable.py_akun_hutang')
                    ->leftJoin('dk_akun as ak_2', 'ak_2.ak_id', '=', 'dk_payable.py_akun_titipan')
    				->where('dk_payable.py_chanel', $request->chanel)
    				->where(DB::raw('(py_total_tagihan - py_sudah_dibayar)'), '>', '0')
                    ->select(
                            'dk_payable.*',
                            DB::raw('concat(ak_1.ak_id, " - ", ak_1.ak_nama) as py_akun_hutang'),
                            DB::raw('concat(ak_2.ak_id, " - ", ak_2.ak_nama) as py_akun_titipan'),
                            DB::raw('(dk_payable.py_total_tagihan - dk_payable.py_sudah_dibayar) as py_sisa_tagihan'))
    				->get();

    	return json_encode($sales);
    }

    public function store(Request $request){
        // return json_encode($request->all());

        $data = DB::table('dk_payable')->where('py_nomor', $request->rc_sales);

        if(!$data->first()){
            $response = [
                "status"    => 'error',
                "message"   => 'Nomor Hutang Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        DB::beginTransaction();

        try {

            $jurnalDetail = [];
            $cekAk1 = DB::table('dk_akun')->where('ak_id', $request->akun)->first();

            if(!$cekAk1){
                $response = [
                        "status"    => 'gagal',
                        "message"   => 'Beberapa Akun Tidak Bisa Ditemukan, Cobalah Untuk Memuat Ulang Halaman',
                    ];

                    return json_encode($response);
            }

            $tanggal = explode('/', $request->rc_tanggal_trans)[2].'-'.explode('/', $request->rc_tanggal_trans)[1].'-'.explode('/', $request->rc_tanggal_trans)[0];

            $id = (DB::table('dk_payable_detail')->max('pydt_id')) ? (DB::table('dk_payable_detail')->max('pydt_id') + 1) : 1;

            $nomor = (DB::table('dk_payable_detail')->where('pydt_payable', $data->first()->py_id)->max('pydt_nomor')) ? (DB::table('dk_payable_detail')->where('pydt_payable', $data->first()->py_id)->max('pydt_nomor') + 1) : 1;;

            $rc_value = ($request->rc_value) ? str_replace(',', '', $request->rc_value) : 0;
            $dibayar = $rc_value;

            if($rc_value > ($data->first()->py_total_tagihan - $data->first()->py_sudah_dibayar)){
                $dibayar = ($data->first()->py_total_tagihan - $data->first()->py_sudah_dibayar);
            }

            DB::table('dk_payable_detail')->insert([
                'pydt_id'           => $id,
                'pydt_payable'   	=> $data->first()->py_id,
                'pydt_nomor'        => $data->first()->py_nomor.'-'.$nomor,
                'pydt_keterangan'   => $request->rc_keterangan,
                'pydt_tanggal'      => $tanggal,
                'pydt_value'        => $dibayar,
                'pydt_type'         => $request->jenis
            ]);

            $data->update([
                'py_sudah_dibayar' => DB::raw('py_sudah_dibayar + '.$dibayar),
            ]);

            if(isset($request->dana_titipan)){

                $cekPiutang = DB::table('dk_akun')->where('ak_id', $data->first()->py_akun_hutang)->first();
                $cekTitipan = DB::table('dk_akun')->where('ak_id', $data->first()->py_akun_titipan)->first();

                if(!$data->first()->py_akun_hutang || !$cekPiutang){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Hutang Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                if(!$data->first()->py_akun_titipan || !$cekTitipan){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Titipan Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                $jurnalDetail[$request->akun] = [
                    'jrdt_akun'          => $request->akun,
                    'jrdt_value'         => $rc_value,
                    'jrdt_dk'            => 'K'
                ];

                $jurnalDetail[$data->first()->py_akun_hutang] = [
                    'jrdt_akun'          => $data->first()->py_akun_hutang,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'D'
                ];

                $jurnalDetail[$data->first()->py_akun_titipan] = [
                    'jrdt_akun'          => $data->first()->py_akun_titipan,
                    'jrdt_value'         => ($rc_value - $dibayar),
                    'jrdt_dk'            => 'D'
                ];

            }else{
                $cekPiutang = DB::table('dk_akun')->where('ak_id', $data->first()->py_akun_hutang)->first();

                if(!$data->first()->py_akun_hutang || !$cekPiutang){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Hutang Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                $jurnalDetail[$request->akun] = [
                    'jrdt_akun'          => $request->akun,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'K'
                ];

                $jurnalDetail[$data->first()->py_akun_hutang] = [
                    'jrdt_akun'          => $data->first()->py_akun_hutang,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'D'
                ];
            }

            $state = ($request->jenis == 'C') ? 'KK' : 'BK';

            keuangan::jurnal()->addJurnal($jurnalDetail, $tanggal, $data->first()->py_nomor.'-'.$nomor, $request->rc_keterangan, $state, jurnal()->comp, true);

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Pelunasan Hutang Berhasil Disimpan',
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

        $rcdt = DB::table('dk_payable_detail')->where('pydt_id', $request->rc_id);

        if(!$rcdt->first()){
             $response = [
                "status"    => 'error',
                "message"   => 'Data Pelunasan Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        $receivable = DB::table('dk_payable')->where('py_id', $rcdt->first()->pydt_payable);

        if(!$receivable->first()){
             $response = [
                "status"    => 'error',
                "message"   => 'Data Hutang Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return $this->dropAllPenerimaan($rcdt->first()->pydt_payable);

            return json_encode($response);
        }

        $cekAk1 = DB::table('dk_akun')->where('ak_id', $request->akun)->first();

        if(!$cekAk1){
            $response = [
                    "status"    => 'gagal',
                    "message"   => 'Beberapa Akun Tidak Bisa Ditemukan, Cobalah Untuk Memuat Ulang Halaman',
                ];

                return json_encode($response);
        }

        DB::beginTransaction();

        try {
            
            $jurnalDetail = [];

            $tanggal = explode('/', $request->rc_tanggal_trans)[2].'-'.explode('/', $request->rc_tanggal_trans)[1].'-'.explode('/', $request->rc_tanggal_trans)[0];

            $sudah_dibayar_lama = ($receivable->first()->py_sudah_dibayar - $rcdt->first()->pydt_value);
            $sisa_lama = ($receivable->first()->py_total_tagihan - $sudah_dibayar_lama);

            $rc_value = ($request->rc_value) ? str_replace(',', '', $request->rc_value) : 0;
            $dibayar = $rc_value;

            if($rc_value > $sisa_lama){
                $dibayar = ($sisa_lama);
            }

            $rcdt->update([
                'pydt_keterangan'   => $request->rc_keterangan,
                'pydt_tanggal'      => $tanggal,
                'pydt_value'        => $dibayar,
                'pydt_type'         => $request->jenis,
            ]);

            $receivable->update([
                'py_sudah_dibayar' => ($sudah_dibayar_lama + $dibayar),
            ]);

            if(isset($request->dana_titipan)){

                $cekPiutang = DB::table('dk_akun')->where('ak_id', $receivable->first()->py_akun_hutang)->first();
                $cekTitipan = DB::table('dk_akun')->where('ak_id', $receivable->first()->py_akun_titipan)->first();

                if(!$receivable->first()->py_akun_hutang || !$cekPiutang){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Piutang Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                if(!$receivable->first()->py_akun_titipan || !$cekTitipan){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Titipan Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                $jurnalDetail[$request->akun] = [
                    'jrdt_akun'          => $request->akun,
                    'jrdt_value'         => $rc_value,
                    'jrdt_dk'            => 'K'
                ];

                $jurnalDetail[$receivable->first()->py_akun_hutang] = [
                    'jrdt_akun'          => $receivable->first()->py_akun_hutang,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'D'
                ];

                $jurnalDetail[$receivable->first()->py_akun_titipan] = [
                    'jrdt_akun'          => $receivable->first()->py_akun_titipan,
                    'jrdt_value'         => ($rc_value - $dibayar),
                    'jrdt_dk'            => 'D'
                ];

            }else{
                $cekPiutang = DB::table('dk_akun')->where('ak_id', $receivable->first()->py_akun_hutang)->first();

                if(!$receivable->first()->py_akun_hutang || !$cekPiutang){
                    $response = [
                        "status"    => 'gagal',
                        "message"   => 'Akun Piutang Tidak Bisa Ditemukan',
                    ];

                    return json_encode($response);
                }

                $jurnalDetail[$request->akun] = [
                    'jrdt_akun'          => $request->akun,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'K'
                ];

                $jurnalDetail[$receivable->first()->py_akun_hutang] = [
                    'jrdt_akun'          => $receivable->first()->py_akun_hutang,
                    'jrdt_value'         => $dibayar,
                    'jrdt_dk'            => 'D'
                ];
            
            }

            $idJurnal = DB::table('dk_jurnal')->where('jr_ref', $rcdt->first()->pydt_nomor)->first();

            if($idJurnal){
                keuangan::jurnal()->dropJurnal($idJurnal->jr_id);
            }

            $state = ($request->jenis == 'C') ? 'KK' : 'BK';

            keuangan::jurnal()->addJurnal($jurnalDetail, $tanggal, $rcdt->first()->pydt_nomor, $request->rc_keterangan, $state, jurnal()->comp, true);

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Transaksi Pelunasan Berhasil Diperbarui',
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

        $rcdt = DB::table('dk_payable_detail')->where('pydt_id', $request->rc_id);

        if(!$rcdt->first()){
             $response = [
                "status"    => 'error',
                "message"   => 'Data Pelunasan Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        $receivable = DB::table('dk_payable')->where('py_id', $rcdt->first()->pydt_payable);

        if(!$receivable->first()){
             $response = [
                "status"    => 'error',
                "message"   => 'Data Hutang Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return $this->dropAllPenerimaan($rcdt->first()->pydt_payable);

            return json_encode($response);
        }

        DB::beginTransaction();

        try {
            
            $value = $rcdt->first()->pydt_value;
            $nomor = $rcdt->first()->pydt_nomor;

            $rcdt->delete();

            $receivable->update([
                'py_sudah_dibayar' => DB::raw('py_sudah_dibayar - '.$value),
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
}
