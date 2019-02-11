<?php

namespace App\Http\Controllers\modul_keuangan\aset\group;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use keuangan;

class group_aset_controller extends Controller
{
    public function index(){
    	$data = DB::table('dk_aktiva_golongan')
    				->leftJoin('dk_akun as harta', 'harta.ak_id', '=', 'dk_aktiva_golongan.ga_akun_harta')
    				->leftJoin('dk_akun as akumulasi', 'akumulasi.ak_id', '=', 'dk_aktiva_golongan.ga_akun_akumulasi')
    				->leftJoin('dk_akun as beban', 'beban.ak_id', '=', 'dk_aktiva_golongan.ga_akun_beban')
    				->select(
    							'dk_aktiva_golongan.*',
    							'harta.ak_nama as nama_akun_harta',
    							'akumulasi.ak_nama as nama_akun_akumulasi',
    							'beban.ak_nama as nama_akun_beban'
    						)
    				->orderBy('ga_nama', 'desc')
    				->get();

    	// return json_encode($data);

    	return view('modul_keuangan.aset.group-aset.index', compact('data'));
    }

    public function create(){
    	return view('modul_keuangan.aset.group-aset.form');
    }

    public function form_resource(){

        $kelompokHarta = DB::table('dk_hierarki_penting')->where('hp_id', '1')->first();
        $kelompokAkumulasi = DB::table('dk_hierarki_penting')->where('hp_id', '2')->first();
        $kelompokBeban = DB::table('dk_hierarki_penting')->where('hp_id', '3')->first();

    	$accHarta = DB::table('dk_akun')->where('ak_kelompok', $kelompokHarta->hp_hierarki)->select('ak_id as id', DB::raw('concat(ak_id, " - ", ak_nama) as text'))->where('ak_isactive', '1')->get();

    	$accAkumulasi = DB::table('dk_akun')->where('ak_kelompok', $kelompokAkumulasi->hp_hierarki)->select('ak_id as id', DB::raw('concat(ak_id, " - ", ak_nama) as text'))->where('ak_isactive', '1')->get();

    	$accBeban = DB::table('dk_akun')->where('ak_kelompok', $kelompokBeban->hp_hierarki)->select('ak_id as id', DB::raw('concat(ak_id, " - ", ak_nama) as text'))->where('ak_isactive', '1')->get();

    	return json_encode([
    		'acc_harta'			=> $accHarta,
    		'acc_akumulasi'		=> $accAkumulasi,
    		'acc_beban'			=> $accBeban
    	]);
    }

    public function datatable(Request $request){
    	$data = DB::table('dk_aktiva_golongan')->where('ga_golongan', $request->golongan)->get();

    	return json_encode($data);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	$id = (DB::table('dk_aktiva_golongan')->max('ga_id')) ? (DB::table('dk_aktiva_golongan')->max('ga_id') + 1) : 1;
    	$nomor = 'GA-'.date('Y/md').'/'.str_pad($id, 4, "0", STR_PAD_LEFT);

    	DB::beginTransaction();

        $ak1 = DB::table('dk_akun')->where('ak_id', $request->ga_akun_harta)->first();
        $ak2 = DB::table('dk_akun')->where('ak_id', $request->ga_akun_akumulasi)->first();
        $ak3 = DB::table('dk_akun')->where('ak_id', $request->ga_akun_beban)->first();

        if(!$ak1 || !$ak2 || !$ak3){
            $response = [
                "status"    => 'error',
                "message"   => 'Beberapa Akun Keuangan Tidak Dapat Ditemukan, Cobalah Untuk Memuat Ulang Halaman'.$e,
            ];

            return json_encode($response);
        }

    	try {
    		
    		DB::table('dk_aktiva_golongan')->insert([
    			"ga_id"				=> $id,
    			"ga_nomor"			=> $nomor,
    			"ga_nama"			=> $request->ga_nama,
    			"ga_keterangan"		=> $request->ga_keterangan,
    			"ga_golongan"		=> $request->ga_golongan,
    			"ga_masa_manfaat"	=> $request->ga_masa_manfaat,
    			"ga_garis_lurus"	=> $request->ga_garis_lurus,
    			"ga_saldo_menurun"	=> $request->ga_saldo_menurun,
    			"ga_akun_harta"		=> $request->ga_akun_harta,
    			"ga_akun_akumulasi"	=> $request->ga_akun_akumulasi,
    			"ga_akun_beban"		=> $request->ga_akun_beban 
    		]);

    		DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Data Group Aset Berhasil Disimpan',
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

    	$cek = DB::table('dk_aktiva_golongan')->where('ga_id', $request->ga_id);

    	if(!$cek->first()){
    		$response = [
                "status"    => 'error',
                "message"   => 'Group Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
    	}

    	DB::beginTransaction();

    	try {
    		
    		$cek->update([
    			"ga_nama"			=> $request->ga_nama,
    			"ga_keterangan"		=> $request->ga_keterangan
    		]);

    		DB::commit();

    		$response = [
                "status"    => 'berhasil',
                "message"   => 'Data Group Aset Berhasil Diperbarui',
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

    	$cek = DB::table('dk_aktiva_golongan')->where('ga_id', $request->ga_id);

    	if(!$cek->first()){
    		$response = [
                "status"    => 'error',
                "message"   => 'Group Yang Dimaksud Tidak Bisa Ditemukan, Cobalah Untuk memuat Ulang Halaman'
            ];

            return json_encode($response);
    	}

    	$cek2 = DB::table('dk_aktiva')->where('at_golongan', $request->ga_id)->first();

    	if($cek2){
    		$response = [
                "status"    => 'error',
                "message"   => 'Group Ini Sedang Digunakan Oleh Data Aktiva, Tidak Bisa Dihapus'
            ];

            return json_encode($response);
    	}

    	DB::beginTransaction();

    	try {

    		$cek->delete();

    		DB::commit();

    		$response = [
                "status"    => 'berhasil',
                "message"   => 'Data Group Aset Berhasil Dihapus',
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
