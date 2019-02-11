<?php

namespace App\Http\Controllers\modul_keuangan\transaksi\kas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_transaksi as transaksi;

use DB;
use keuangan;

class transaksi_kas_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.transaksi.kas.index');
    }

    public function form_resource(){

        $kelompok_kas = DB::table('dk_hierarki_penting')->where('hp_id', '4')->first();
        $kelompok_bank = DB::table('dk_hierarki_penting')->where('hp_id', '5')->first();

    	$akunKas = DB::table('dk_akun')
    					->where('ak_kelompok', $kelompok_kas->hp_hierarki)
    					->where('ak_isactive', '1')
    					->select('ak_id as id', DB::raw("concat(ak_id, ' - ', ak_nama) as text"))
    					->get();

    	$akunLawan = DB::table('dk_akun')
    					->where('ak_kelompok', '!=', $kelompok_kas->hp_hierarki)
    					->where('ak_kelompok', '!=', $kelompok_bank->hp_hierarki)
    					->where('ak_isactive', '1')
    					->select('ak_id as id', DB::raw("concat(ak_id, ' - ', ak_nama) as text"))
    					->get();

    	return json_encode([
    		'akunKas'	=> $akunKas,
    		'akunLawan'	=> $akunLawan
    	]);
    }

    public function datatable(Request $request){
        // return json_encode($request->all());
        $tanggal = explode('/', $request->tanggal)[2].'-'.explode('/', $request->tanggal)[1].'-01';
        $tanggalNext = date('Y-m-d', strtotime('+1 months', strtotime($tanggal)));
        $type = substr($request->type, 0, 1);

        $data = transaksi::with('detail')->where(DB::raw('substring(tr_type, 1, 1)'), $type)->get();

        return json_encode($data);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

        // TRANS-1901/03/0001

        // $response = [
        //         "status"    => 'berhasil',
        //         "message"   => 'Transaksi Berhasil Disimpan',
        //     ];

        //     return json_encode($response);

        $detail = []; $jurnalDetail = []; $nomor = 1;

        $date = explode('/', $request->tr_tanggal)[2].'-'.explode('/', $request->tr_tanggal)[1].'-'.explode('/', $request->tr_tanggal)[0];

        $tanggalNomor =  explode('/', $request->tr_tanggal)[2].'-'.explode('/', $request->tr_tanggal)[1].'-01';
        $tanggalNomorNext = date('Y-m-d', strtotime("+1 months", strtotime($tanggalNomor)));

        DB::beginTransaction();

        try {
            
            $numCounter = DB::table('dk_transaksi')
                                ->where('tr_tanggal', '>=', $tanggalNomor)
                                ->where('tr_tanggal', '<', $tanggalNomorNext)
                                ->where('tr_type', $request->tr_type)
                                ->orderBy('tr_nomor', 'desc')
                                ->limit(1)->select('tr_nomor')->first();

            $id = (DB::table('dk_transaksi')->max('tr_id')) ? (DB::table('dk_transaksi')->max('tr_id') + 1) : 1;
            $num = ($numCounter) ? (explode('/', $numCounter->tr_nomor)[2] + 1) : 1;
            $tr_number = 'TRANS-'.$request->tr_type.date('y', strtotime($date)).'/'.date('m', strtotime($date)).date('d', strtotime($date)).'/'.str_pad($num, 4, "0", STR_PAD_LEFT);

            foreach($request->akun as $key => $akun){
                $cek = DB::table('dk_akun')->where('ak_id', $akun)->first();
                $value = 0; $dk = '';

                if($cek){

                    if(!array_key_exists($akun, $detail)){                        
                       foreach ($request->akun as $key => $needle) {
                           if($needle == $akun){
                                if($request->debet[$key] != '0.00'){
                                    if($cek->ak_posisi == 'D')
                                        $value += str_replace(',', '', $request->debet[$key]);
                                    else
                                        $value -= str_replace(',', '', $request->debet[$key]);
                                }else if($request->kredit[$key] != '0.00'){
                                    if($cek->ak_posisi == 'D')
                                        $value -= str_replace(',', '', $request->kredit[$key]);
                                    else
                                        $value += str_replace(',', '', $request->kredit[$key]);
                                }
                           }
                       }

                       if($value < 0){
                            if($cek->ak_posisi == 'D')
                                $dk = 'K';
                            else
                                $dk = 'D';
                       }else{
                            $dk = $cek->ak_posisi;
                       }

                       $detail[$akun] = [
                            'trdt_transaksi'     => $id,
                            'trdt_nomor'         => $nomor,
                            'trdt_akun'          => $akun,
                            'trdt_value'         => str_replace('-', '', $value),
                            'trdt_dk'            => $dk
                       ];


                       // Throttle Add Jurnal Detail

                       $jurnalDetail[$akun] = [
                            'jrdt_akun'          => $akun,
                            'jrdt_value'         => str_replace('-', '', $value),
                            'jrdt_dk'            => $dk
                       ];

                       $nomor ++;
                    }

                }else{
                    $response = [
                        "status"    => 'error',
                        "message"   => 'Beberapa Akun Tidak Ada di Database. Data Gagal Disimpan',
                    ];

                    return json_encode($response);
                }
            }

            if(count($jurnalDetail) == 1){
                $response = [
                    "status"    => 'error',
                    "message"   => 'Sepertinya Ada Kesalahan Pada Detail Akun, Minimal Harus Ada 1 (satu) Akun Yang Berbeda Dengan Akun Lainnya..',
                ];

                return json_encode($response);
            }

            // return json_encode($jurnalDetail);

            DB::table('dk_transaksi')->insert([
                "tr_id"         => $id,
                "tr_comp"       => '1',
                "tr_nomor"      => $tr_number,
                "tr_tanggal"    => $date,
                "tr_keterangan" => $request->tr_nama,
                "tr_type"       => $request->tr_type,
                "tr_value"      => ($request->tr_value) ? str_replace(',', '', $request->tr_value) : 0
            ]);

            DB::table('dk_transaksi_detail')->insert($detail);

            keuangan::jurnal()->addJurnal($jurnalDetail, $date, $tr_number, $request->tr_nama, $request->tr_type, jurnal()->comp, true);

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Transaksi Berhasil Disimpan',
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

        $trans = DB::table('dk_transaksi')->where('tr_id', $request->tr_id);

        if(!$trans->first()){
            $response = [
                "status"    => 'error',
                "message"   => 'Transaksi Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        $detail = []; $jurnalDetail = []; $nomor = 1;
        $date = explode('/', $request->tr_tanggal)[2].'-'.explode('/', $request->tr_tanggal)[1].'-'.explode('/', $request->tr_tanggal)[0];

        $tanggalNomor =  explode('/', $request->tr_tanggal)[2].'-'.explode('/', $request->tr_tanggal)[1].'-01';
        $tanggalNomorNext = date('Y-m-d', strtotime("+1 months", strtotime($tanggalNomor)));

        DB::beginTransaction();

        try {
            
            $numCounter = DB::table('dk_transaksi')
                                ->where('tr_tanggal', '>=', $tanggalNomor)
                                ->where('tr_tanggal', '<', $tanggalNomorNext)
                                ->where('tr_type', $trans->first()->tr_type)
                                ->orderBy('tr_nomor', 'desc')
                                ->limit(1)->select('tr_nomor')->first();
            $id = $trans->first()->tr_id;
            $num = ($numCounter) ? (explode('/', $numCounter->tr_nomor)[2] + 1) : 1;

            if(date('Y-m', strtotime($trans->first()->tr_tanggal)) != date('Y-m', strtotime($date))){
                $tr_number = 'TRANS-'.$trans->first()->tr_type.date('y', strtotime($date)).'/'.date('m', strtotime($date)).date('d', strtotime($date)).'/'.str_pad($num, 4, "0", STR_PAD_LEFT);
            }else{
                $tr_number = 'TRANS-'.$trans->first()->tr_type.date('y', strtotime($date)).'/'.date('m', strtotime($date)).date('d', strtotime($date)).'/'.explode('/', $trans->first()->tr_nomor)[2];
            }

            $trans->update([
                "tr_comp"       => '1',
                "tr_nomor"      => $tr_number,
                "tr_tanggal"    => $date,
                "tr_keterangan" => $request->tr_nama,
                "tr_value"      => ($request->tr_value) ? str_replace(',', '', $request->tr_value) : 0
            ]);

            $idJurnal = DB::table('dk_jurnal')->where('jr_ref', $request->tr_nomor)->first();

            if($idJurnal){
                keuangan::jurnal()->dropJurnal($idJurnal->jr_id);
            }

            DB::table('dk_transaksi_detail')->where('trdt_transaksi', $trans->first()->tr_id)->delete();

            foreach($request->akun as $key => $akun){
                $cek = DB::table('dk_akun')->where('ak_id', $akun)->first();
                $value = 0; $dk = '';

                if($cek){

                    if(!array_key_exists($akun, $detail)){                        
                       foreach ($request->akun as $key => $needle) {
                           if($needle == $akun){
                                if($request->debet[$key] != '0.00'){
                                    if($cek->ak_posisi == 'D')
                                        $value += str_replace(',', '', $request->debet[$key]);
                                    else
                                        $value -= str_replace(',', '', $request->debet[$key]);
                                }else if($request->kredit[$key] != '0.00'){
                                    if($cek->ak_posisi == 'D')
                                        $value -= str_replace(',', '', $request->kredit[$key]);
                                    else
                                        $value += str_replace(',', '', $request->kredit[$key]);
                                }
                           }
                       }

                       if($value < 0){
                            if($cek->ak_posisi == 'D')
                                $dk = 'K';
                            else
                                $dk = 'D';
                       }else{
                            $dk = $cek->ak_posisi;
                       }

                       $detail[$akun] = [
                            'trdt_transaksi'     => $id,
                            'trdt_nomor'         => $nomor,
                            'trdt_akun'          => $akun,
                            'trdt_value'         => str_replace('-', '', $value),
                            'trdt_dk'            => $dk
                       ];


                       // Throttle Add Jurnal Detail

                       $jurnalDetail[$akun] = [
                            'jrdt_akun'          => $akun,
                            'jrdt_value'         => str_replace('-', '', $value),
                            'jrdt_dk'            => $dk
                       ];

                       $nomor ++;
                    }

                }else{
                    $response = [
                        "status"    => 'error',
                        "message"   => 'Beberapa Akun Tidak Ada di Database. Data Gagal Disimpan',
                    ];

                    return json_encode($response);
                }
            }

            if(count($jurnalDetail) == 1){
                $response = [
                    "status"    => 'error',
                    "message"   => 'Sepertinya Ada Kesalahan Pada Detail Akun, Minimal Harus Ada 1 (satu) Akun Yang Berbeda Dengan Akun Lainnya..',
                ];

                return json_encode($response);
            }

            DB::table('dk_transaksi_detail')->insert($detail);
            keuangan::jurnal()->addJurnal($jurnalDetail, $date, $tr_number, $request->tr_nama, $trans->first()->tr_type, jurnal()->comp, 2);

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Transaksi Berhasil Diperbarui',
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

    public function delete(Request $request){
        $trans = DB::table('dk_transaksi')->where('tr_id', $request->tr_id);

        if(!$trans->first()){
            $response = [
                "status"    => 'error',
                "message"   => 'Transaksi Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        DB::beginTransaction();

        try {
            
            $jurnal = DB::table('dk_jurnal')->where('jr_ref', $trans->first()->tr_nomor);

            if($jurnal->first()){
                keuangan::jurnal()->dropJurnal($jurnal->first()->jr_id);
                $trans->delete();
                $jurnal->delete();
            }

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Transaksi Berhasil Dihapus',
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
