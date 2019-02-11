<?php

namespace App\Http\Controllers\modul_keuangan\master\group_akun;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class group_akun_controller extends Controller
{
    public function index(){
    	$data = DB::table('dk_akun_group')->orderBy('ag_type', 'desc')->get();

    	return view('modul_keuangan.master.group-akun.index', compact('data'));
    }

    public function form_resource(){
        $subclass = DB::table('dk_akun_group_subclass')->select('gs_id as id', 'gs_nama as text', 'gs_type', 'gs_kelompok')->get();

        return json_encode([
            "subclass"  => $subclass
        ]);
    }

    public function datatable(Request $request){
    	// return json_encode($request->all());

    	$data = DB::table("dk_akun_group")->where('ag_type', $request->type)->where('ag_kelompok', $request->kel)->get();

    	return json_encode($data);
    }

    public function create(){
    	return view('modul_keuangan.master.group-akun.form');
    }

    public function store(Request $request){

    	// return json_encode($request->all());

    	$response = [
    		"status"	=> 'berhasil',
    		"message"	=> 'Data Group Akun Berhasil Ditambahkan',
    	];

    	DB::beginTransaction();

    	try {
    		
    		$id = (DB::table('dk_akun_group')->max('ag_id')) ? (DB::table('dk_akun_group')->max('ag_id') + 1) : 1;
    		$searchNomor = DB::table('dk_akun_group')->where('ag_type', $request->ag_type)->max('ag_nomor');
    		$nomor = ($searchNomor) ? (substr($searchNomor, '-1') + 1) : 1;

    		DB::table('dk_akun_group')->insert([
    			"ag_id"			=> $id,
    			"ag_nomor"		=> $request->ag_type.'-'.$nomor,
    			"ag_type"		=> $request->ag_type,
    			"ag_nama"		=> $request->ag_nama,
                "ag_subclass"   => $request->ag_subclass,
    			"ag_kelompok"	=> $request->ag_kelompok,
    		]);

    		DB::commit();

    		return json_encode($response);

    	} catch (\Exception $e) {
    		$response = [
    			"status"	=> 'error',
    			"message"	=> 'System Mengalami Masalah. Err: '.$e,
    		];

    		return json_encode($response);
    	}
    }

    public function update(Request $request){
    	$response = [
    		"status"	=> 'berhasil',
    		"message"	=> 'Data Group Akun Berhasil Diubah',
    	];

    	DB::beginTransaction();

    	try {

    		$cek = DB::table('dk_akun_group')->where('ag_id', $request->ag_id);

    		if(!$cek->first()){
    			$response = [
		    		"status"	=> 'error',
		    		"message"	=> 'Data Group Akun Yang Dimaksud Tidak Bisa Ditemukan. Cobalah Untuk Memuat Ulang Halaman',
		    	];

		    	return json_encode($response);
    		}

    		$cek->update([
    			"ag_nama"		=> $request->ag_nama,
    			"ag_kelompok"	=> $request->ag_kelompok,
                "ag_subclass"   => $request->ag_subclass,
    		]);

    		DB::commit();
    		return json_encode($response);

    	} catch (\Exception $e) {
    		$response = [
    			"status"	=> 'error',
    			"message"	=> 'System Mengalami Masalah. Err: '.$e,
    		];

    		return json_encode($response);
    	}
    }

    public function delete(Request $request){
    	// return json_encode($request->all());

    	DB::beginTransaction();

    	try {

    		$active = '';
    		$cek = DB::table('dk_akun_group')->where('ag_id', $request->ag_id);

    		if(!$cek->first()){
    			$response = [
		    		"status"	=> 'error',
		    		"message"	=> 'Data Group Akun Yang Dimaksud Tidak Bisa Ditemukan. Cobalah Untuk Memuat Ulang Halaman',
		    	];

		    	return json_encode($response);
    		}

    		if($cek->first()->ag_isactive == '1'){
    			$cek->update([
	    			"ag_isactive"		=> '0',
	    		]);

	    		$active = '0';

	    		switch ($cek->first()->ag_type) {
	    			case 'N':
	    				DB::table('dk_akun')->where('ak_group_neraca', $request->ag_id)->update([ 'ak_group_neraca' => null ]);
	    				break;

	    			case 'LR':
	    				DB::table('dk_akun')->where('ak_group_lr', $request->ag_id)->update([ 'ak_group_lr' => null ]);
	    				break;
	    			
	    			case 'A':
	    				DB::table('dk_akun')->where('ak_group_ak', $request->ag_id)->update([ 'ak_group_ak' => null ]);
	    				break;
	    		}

    		}else{
    			$cek->update([
	    			"ag_isactive"		=> '1',
	    		]);

	    		$active = '1';
    		}
    		

    		DB::commit();

    		$response = [
	    		"status"	=> 'berhasil',
	    		"message"	=> 'Data Group Akun Berhasil Diubah',
	    		'active'	=> $active
	    	];
    		return json_encode($response);

    	} catch (\Exception $e) {
    		$response = [
    			"status"	=> 'error',
    			"message"	=> 'System Mengalami Masalah. Err: '.$e,
    		];

    		return json_encode($response);
    	}
    }
}
