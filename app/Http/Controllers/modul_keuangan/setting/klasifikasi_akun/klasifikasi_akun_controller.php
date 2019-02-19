<?php

namespace App\Http\Controllers\modul_keuangan\setting\klasifikasi_akun;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class klasifikasi_akun_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.setting.klasifikasi_akun.index');
    }

    public function form_resource(){
    	$level1 = DB::table('dk_hierarki_lvl_satu')->select('hls_id as id', 'hls_nama as nama')->get();
    	$level2 = DB::table('dk_hierarki_lvl_dua')->select('hld_id as id', 'hld_nama as nama', 'hld_level_1 as lvl1', 'hld_cashflow as cashflow', 'hld_status as status', 'hld_subclass as subclass')->get();
        $subclass = DB::table('dk_hierarki_subclass')->select('hs_id as id', 'hs_nama as nama', 'hs_level_1 as level1', 'hs_status as status')->get();

    	return json_encode([
    		'level_1'	=> $level1,
    		'level_2'	=> $level2,
            'subclass'  => $subclass
    	]);
    }

    public function simpan_level_1(Request $request){
    	// return json_encode($request->all());

    	DB::beginTransaction();

    	try {
    		
            if(isset($request->id_lama)){
        		foreach($request->id_lama as $index => $id){
    	    		if($request->nama_lama[$index] != $request->lvl1[$index]){
    	    			DB::table('dk_hierarki_lvl_satu')->where('hls_id', $id)->update([
    	    				'hls_nama'	=> $request->lvl1[$index]
    	    			]);
    	    		}
    	    	}
            }

	    	DB::commit();

	    	$level1 = DB::table('dk_hierarki_lvl_satu')->select('hls_id as id', 'hls_nama as nama')->get();

	    	$response = [
                "status"    => 'berhasil',
                "message"   => 'Data Hierarki Level 1 Berhasil Diperbarui',
                "level_1"	=> $level1
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

    public function simpan_level_2(Request $request){

        // return json_encode($request->all());

        DB::beginTransaction();

        try {
            
            $addition = $request->level1;

            if(isset($request->id_lama)){
                foreach($request->id_lama as $key => $value) {
                    DB::table('dk_hierarki_lvl_dua')->where('hld_id', $value)->update([
                        'hld_id'        => $addition.'.'.$request->dataId[$key],
                        'hld_nama'      => $request->data[$key],
                        'hld_cashflow'  => $request->cashflow[$key],
                        'hld_subclass'  => $request->hld_subclass[$key]
                    ]);

                    DB::table('dk_akun')->where('ak_kelompok', $addition.'.'.$request->dataId[$key])->update([
                        'ak_id' => DB::raw('concat(ak_kelompok, ".", ak_sub_id)'),
                    ]);
                }
            }

            if(isset($request->lvl2NewId)){
                foreach ($request->lvl2NewId as $key => $baru) {
                    if(!is_null($baru) && $baru != '' && !is_null($request->lvl2NewNama[$key]) && $request->lvl2NewNama[$key] != ''){
                        DB::table('dk_hierarki_lvl_dua')->insert([
                            'hld_id'        => $addition.'.'.$baru,
                            'hld_nama'      => $request->lvl2NewNama[$key],
                            'hld_level_1'   => $addition,
                            'hld_cashflow'  => $request->lvl2NewCashflow[$key],
                            'hld_subclass'  => $request->hld_subclassNew[$key]
                        ]);
                    }
                }
            }

            DB::commit();

            $level2 = DB::table('dk_hierarki_lvl_dua')->select('hld_id as id', 'hld_nama as nama', 'hld_level_1 as lvl1', 'hld_cashflow as cashflow', 'hld_status as status', 'hld_subclass as subclass')->get();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Data Hierarki Level 2 Berhasil Diperbarui',
                "level_2"   => $level2
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

    public function hapus_level_2(Request $request){
        // return json_encode($request->all());

        $cek = DB::table('dk_hierarki_lvl_dua')->where('hld_id', $request->id);
        $cek2 = DB::table('dk_akun')->where('ak_kelompok', $request->id)->first();

        // return json_encode($cek2);

        if(!$cek){
            $response = [
                "status"    => 'error',
                "message"   => 'Hierarki Tidak Bisa Ditemukan, Cobalah Untuk Memuat Ulang Halaman',
            ];

            return json_encode($response);
        }else if($cek2){
            $response = [
                "status"    => 'error',
                "message"   => 'Beberapa Akun Keuangan Terkait Dengan Hierarki Ini, Sehingga Hierarki Ini Tidak Dapat Dihapus.',
            ];

            return json_encode($response);
        }

        DB::beginTransaction();

        try {
            
            $cek->delete();

            DB::commit();

            $level2 = DB::table('dk_hierarki_lvl_dua')->select('hld_id as id', 'hld_nama as nama', 'hld_level_1 as lvl1', 'hld_cashflow as cashflow', 'hld_status as status')->get();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Data Hierarki Level 2 Berhasil Diperbarui',
                "level_2"   => $level2
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

    public function simpan_subclass(Request $request){
        // return json_encode($request->all());

        DB::beginTransaction();

        try {
            
            if(isset($request->id_lama)){
                foreach($request->id_lama as $key => $value) {
                    DB::table('dk_hierarki_subclass')->where('hs_id', $value)->update([
                        'hs_nama'      => $request->data[$key],
                    ]);
                }
            }

            if(isset($request->lvl2NewNama)){
                foreach ($request->lvl2NewNama as $key => $baru) {
                    if($baru != "" && !is_null($baru)){
                        DB::table('dk_hierarki_subclass')->insert([
                            'hs_nama'      => $baru,
                            'hs_level_1'    => $request->level1
                        ]);
                    }
                }
            }

            DB::commit();

            $subclass = DB::table('dk_hierarki_subclass')->select('hs_id as id', 'hs_nama as nama', 'hs_level_1 as level1')->get();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Data Hierarki Level 2 Berhasil Diperbarui',
                "subclass"   => $subclass
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

    public function hapus_level_subclass(Request $request){
        // return json_encode($request->all());

        $cek = DB::table('dk_hierarki_subclass')->where('hs_id', $request->id);
        $cek2 = DB::table('dk_hierarki_lvl_dua')->where('hld_subclass', $request->id)->first();

        // return json_encode($cek2);

        if(!$cek){
            $response = [
                "status"    => 'error',
                "message"   => 'Hierarki Tidak Bisa Ditemukan, Cobalah Untuk Memuat Ulang Halaman',
            ];

            return json_encode($response);
        }else if($cek2){
            $response = [
                "status"    => 'error',
                "message"   => 'Beberapa Akun Keuangan Terkait Dengan Hierarki Ini, Sehingga Hierarki Ini Tidak Dapat Dihapus.',
            ];

            return json_encode($response);
        }

        DB::beginTransaction();

        try {
            
            $cek->delete();

            DB::commit();

            $subclass = DB::table('dk_hierarki_subclass')->select('hs_id as id', 'hs_nama as nama', 'hs_level_1 as level1')->get();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Data Hierarki Level 2 Berhasil Diperbarui',
                "subclass"   => $subclass
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
