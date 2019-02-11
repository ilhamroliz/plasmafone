<?php

namespace App\Http\Controllers\modul_keuangan\master\transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_master_transaksi as transaksi;

use DB;

class transaksi_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.master.transaksi.index');
    }

    public function form_resource(){

    	$kelompok_kas = DB::table('dk_hierarki_penting')->where('hp_id', '4')->select('hp_hierarki')->first();
        $kelompok_bank = DB::table('dk_hierarki_penting')->where('hp_id', '5')->select('hp_hierarki')->first();

    	$akun = DB::table('dk_akun')
    					->where('ak_isactive', '1')
    					->select('ak_id as id', DB::raw("concat(ak_id, ' - ', ak_nama) as text"), 'ak_kelompok as kelompok')
    					->get();

    	return json_encode([
    		'akun'			=> $akun,
    		'kelompok_kas'	=> $kelompok_kas,
    		'kelompok_bank'	=> $kelompok_bank
    	]);
    }

    public function datatable(Request $request){
    	// return json_encode($request->all());

    	$data = transaksi::with('detail')->where('mt_type', $request->type)->get();

		return json_encode($data);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	if(array_search('D', $request->dk) === false || array_search('K', $request->dk) === false){
    		$response = [
                "status"    => 'error',
                "message"   => 'Transaksi Harus Memiliki Minimal 1 Akun Debet Dan 1 Akun Kredit, Data Gagal Disimpan..',
            ];

            return json_encode($response);
    	}

    	DB::beginTransaction();

    	try {

    		$bucket = [];
    		$id = (DB::table('dk_master_transaksi')->max('mt_id')) ? (DB::table('dk_master_transaksi')->max('mt_id') + 1) : 1;

    		DB::table('dk_master_transaksi')->insert([
    			"mt_id"		=> $id,
    			"mt_type"	=> $request->tr_type,
    			"mt_nama"	=> $request->tr_nama,
    		]);

    		foreach($request->akun as $key => $akun){
    			$cek = DB::table('dk_akun')->where('ak_id', $akun)->first();

    			if(!$cek){
    				$response = [
		                "status"    => 'error',
		                "message"   => 'Beberapa Akun Yang Anda Pilih Tidak Bisa Ditemukan, Data Tidak Bisa Disimpan. Cobalah Untuk Memuat Ulang Halaman.',
		            ];

		            return json_encode($response);
    			}

    			if(!array_key_exists($akun, $bucket)){
    				$bucket[$akun]	= [
    					"mtdt_transaksi"	=> $id,
	    				"mtdt_nomor"		=> ($key + 1),
	    				"mtdt_akun"			=> $akun,
	    				"mtdt_posisi"		=> $request->dk[$key]
    				];
    			}
    		}

    		if(count($bucket) == 1){
				$response = [
                    "status"    => 'error',
                    "message"   => 'Sepertinya Ada Kesalahan Pada Detail Akun, Minimal Harus Ada 1 (satu) Akun Yang Berbeda Dengan Akun Lainnya..',
                ];

                return json_encode($response);
    		}

    		DB::table('dk_master_transaksi_detail')->insert($bucket);

    		DB::commit();

    		$response = [
	            "status"    => 'berhasil',
	            "message"   => 'Data Transaksi Berhasil Disimpan',
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

    	$bucket = [];
    	$transaksi = DB::table('dk_master_transaksi')->where('mt_id', $request->tr_id);

    	if(!$transaksi->first()){
    		$response = [
                "status"    => 'error',
                "message"   => 'Transaksi Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
    	}

    	DB::beginTransaction();

    	try {
    		
    		$transaksi->update([
    			"mt_nama"	=> $request->tr_nama
    		]);

    		DB::table('dk_master_transaksi_detail')->where('mtdt_transaksi', $request->tr_id)->delete();

    		foreach($request->akun as $key => $akun){
    			$cek = DB::table('dk_akun')->where('ak_id', $akun)->first();

    			if(!$cek){
    				$response = [
		                "status"    => 'error',
		                "message"   => 'Beberapa Akun Yang Anda Pilih Tidak Bisa Ditemukan, Data Tidak Bisa Disimpan. Cobalah Untuk Memuat Ulang Halaman.',
		            ];

		            return json_encode($response);
    			}

    			if(!array_key_exists($akun, $bucket)){
    				$bucket[$akun]	= [
    					"mtdt_transaksi"	=> $request->tr_id,
	    				"mtdt_nomor"		=> ($key + 1),
	    				"mtdt_akun"			=> $akun,
	    				"mtdt_posisi"		=> $request->dk[$key]
    				];
    			}
    		}

    		if(count($bucket) == 1){
				$response = [
                    "status"    => 'error',
                    "message"   => 'Sepertinya Ada Kesalahan Pada Detail Akun, Minimal Harus Ada 1 (satu) Akun Yang Berbeda Dengan Akun Lainnya..',
                ];

                return json_encode($response);
    		}

    		DB::table('dk_master_transaksi_detail')->insert($bucket);

    		DB::commit();

    		$response = [
	            "status"    => 'berhasil',
	            "message"   => 'Data Transaksi Berhasil Diperbarui',
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
    	// return json_encode($request->all());

    	$transaksi = DB::table('dk_master_transaksi')->where('mt_id', $request->tr_id);

    	if(!$transaksi->first()){
    		$response = [
                "status"    => 'error',
                "message"   => 'Transaksi Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
    	}

    	DB::beginTransaction();

    	try {    		

    		$transaksi->delete();

    		DB::commit();

    		$response = [
	            "status"    => 'berhasil',
	            "message"   => 'Data Transaksi Berhasil Dihapus',
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
