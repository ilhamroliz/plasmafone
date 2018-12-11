<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PlasmafoneController as Plasmafone;

// use App\Model\pengaturan\pengguna as Member;
// use App\Model\pengaturan\jabatan as Jabatan;
// use App\Model\pengaturan\outlet as Outlet;

use DB;
use Auth;
use Session;
use Image;
use File;
use ImageOptimizer;
use DataTables;
use Carbon\Carbon;

class manajemenPenggunaController extends Controller
{

    public function tambah_pengguna(){
        $getJabatan = DB::table('d_jabatan')
                ->select('id', 'nama')
                ->get();
        $getOutlet = DB::table('m_company')
                ->select('c_id', 'c_name')
                ->get();
        if(Plasmafone::checkAkses(42, 'insert') == true){
            return view('pengaturan.manajemen_pengguna.tambah', compact('getJabatan', 'getOutlet'));
        }else{
            return view('errors.access_denied');
        }
        // return view('pengaturan.manajemen_pengguna.tambah', compact('getJabatan', 'getOutlet'));

    }

    public function edit_pengguna($id){
        $idm = Crypt::decrypt($id);
        $user = DB::table('d_mem')
                        ->join('d_jabatan', 'id', '=', 'm_level')
                        ->join('m_company', 'c_id', '=', 'm_comp')
                        ->select('d_mem.*', 'd_jabatan.nama', 'm_company.c_name', DB::raw('DATE_FORMAT(m_lastlogin, "%d/%m/%Y %h:%i") as m_lastlogin'), DB::raw('DATE_FORMAT(m_lastlogout, "%d/%m/%Y %h:%i") as m_lastlogout'))
                        ->where('m_id', $idm)->get();
        $getJabatan = DB::table('d_jabatan')
                ->select('id', 'nama')
                ->get();
        $getOutlet = DB::table('m_company')
                ->select('c_id', 'c_name')
                ->get();
        $tgllahir = DB::table('d_mem')
                ->select('m_birth')
                ->where('m_id', $idm)->first();
        $date = [];
        $date = explode('-', $tgllahir->m_birth);
        $day = $date[2]; $month = $date[1]; $year = $date[0];
        
        $id = Crypt::encrypt($idm);
        // dd($user);
        if(Plasmafone::checkAkses(42, 'update') == true){
            return view('pengaturan.manajemen_pengguna.edit')->with(compact('user', 'getJabatan', 'getOutlet','id', 'year', 'month', 'day'));
        }else{
            return view('errors.access_denied');
        }
    }

    public function ganti_pass($id){
        $idm = $id;
        if(Plasmafone::checkAkses(42, 'update') == true){
            return view('pengaturan.manajemen_pengguna.pass')->with(compact('idm'));
        }else{
            return view('errors.access_denied');
        }
    }

    public function hapus_pengguna($id){
        if(Plasmafone::checkAkses(42, 'delete') == true){
            DB::beginTransaction();
            try {
                $idm = Crypt::decrypt($id);
                $cek = DB::table('d_mem')
                        ->select('m_state')
                        ->where('m_id', $idm)
                        ->first();
                // dd($idm);
                if($cek->m_state == "ACTIVE"){
                    DB::table('d_mem')
                        ->where('m_id', $idm)
                        ->update(['m_state' => 'NONACTIVE']);
                }else{
                    DB::table('d_mem')
                        ->where('m_id', $idm)
                        ->update(['m_state' => 'ACTIVE']);
                }
                
                DB::commit();
                return redirect('/pengaturan/akses-pengguna')->with('flash_message_success', 'Set Aktivasi User '.$idm.' berhasil tersimpan !!');
            } catch (\Throwable $e) {

                DB::rollback();
                return redirect('/pengaturan/akses-pengguna')->with('flash_message_error', ''.$e.'');
            } 
        }else{
            return view('errors.access_denied');       
        }
    }

    public function getDataId()
    {
        $cek = DB::table('d_mem')
            ->select(DB::raw('max(right(m_id, 7)) as id'))
            ->get();

        foreach ($cek as $x) {
            $temp = ((int)$x->id + 1);
            $kode = sprintf("%07s",$temp);
        }

        $tempKode = 'MEM' . $kode;
        return $tempKode;
    }

    public function cekUsername(Request $request)
    {
        $user = $request->username;
        $cek = DB::table('d_mem')
            ->where('m_username', '=', $user)
            ->get();
        if (count($cek) > 0){
            return response()->json([
                'status' => 'gagal'
            ]);
        } else {
            return response()->json([
                'status' => 'berhasil'
            ]);
        }
    }

    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return false;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }


    public function simpan_pengguna(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {
            $id = $this->getDataId();
            $nama = ucwords($request->nama);
            $outlet = $request->outlet;
            $jabatan = $request->jabatan;
            $username = $request->username;
            $pass = $request->pass;
            $passconf = $request->passconf;
            $alamat = $request->alamat;
            $tgllahir = $request->tahun.'-'.$request->bulan.'-'.$request->tanggal;
            
            $cek = $this->cekUsername($request);
            $cek = $cek->getData('status')['status'];
            if($cek == 'gagal'){
                // return response()->json([
                //     'status' => 'gagalUser'
                // ]);
                return redirect('/pengaturan/kelola-pengguna/tambah')->with('flash_message_error', 'Username Tidak Tersedia !!');
            }
            if ($pass != $passconf) {
                // return response()->json([
                //     'status' => 'gagalPass'
                // ]);
                return redirect('/pengaturan/kelola-pengguna/tambah')->with('flash_message_error', 'Password Tidak Sesuai !!');
            }

            $pass = sha1(md5('secret_').$pass);
            // $pass = Hash::make("secret_".$pass);
            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            
            if ($request->hasFile('imageUpload')) {

                $image_tmp = Input::file('imageUpload');
                $image_size = $image_tmp->getSize(); //getClientSize()
                $maxsize    = '2097152';

                if ($image_size < $maxsize) {

                   if ($image_tmp->isValid()) {

                        $extension = $image_tmp->getClientOriginalExtension();
                        $filename = date('YmdHms').rand(111, 99999).'.'.$extension;
                        $image_path = 'img/user/'.$filename;

                        //Resize images
                        ini_set('memory_limit', '256M');
                        Image::make($image_tmp)->resize(300, 300)->save($image_path);
                        // ImageOptimizer::optimize($image_path);

                        //Store image name in item table
                        $imgPath = $filename;

                    }
                } else {
                    // return response()->json([
                    //     'status' => 'gagalImg'
                    // ]);
                    return redirect()->back()->with('flash_message_error', 'Ukuran file terlalu besar !!');
                }                
            }else{
                $imgPath = '';
            }

            DB::table('d_mem')
                ->insert([
                    'm_comp' => $outlet,
                    'm_id' => $id,
                    'm_username' => $username,
                    'm_img' => $imgPath,
                    'm_password' => $pass,
                    'm_name' => $nama,
                    'm_level' => $jabatan,
                    'm_birth' => $tgllahir,
                    'm_address' => $alamat,
                    'm_state' => 'ACTIVE',
                    'm_lastlogin' => $tgl,
                    'm_lastlogout' => $tgl,
                    'created_at' => $tgl,
                    'updated_at' => $tgl,
                ]);
            
            DB::commit();
            // Session::flash('sukses', 'Data berhasil disimpan');
            // return redirect('manajemen-pengguna/pengguna');
            return redirect('/pengaturan/akses-pengguna')->with('flash_message_success', 'Data pengguna berhasil tersimpan !!');
            // return response()->json([
            //     'status' => 'sukses'
            // ]);
        } catch (\Throwable $e) {
            DB::rollback();
            // Session::flash('gagal', 'Data gagal disimpan, cobalah sesaat lagi');
            // return redirect('manajemen-pengguna/pengguna');
            return redirect('/pengaturan/kelola-pengguna/tambah')->with('flash_message_error', ''.$e.'');
            // return response()->json([
            //     'status' => 'gagal'
            // ]);
        }

    }

    public function simpan_edit(Request $request){
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($request->id);
            $nama = $request->nama;
            $outlet = $request->outlet;
            $jabatan = $request->jabatan;
            $username = $request->username;
            // $pass = $request->pass;
            // $passconf = $request->passconf;
            $alamat = $request->alamat;
            $tgllahir = $request->tahun.'-'.$request->bulan.'-'.$request->tanggal;
            
            // if ($pass != $passconf) {
            //     // return response()->json([
            //     //     'status' => 'gagalPass'
            //     // ]);
            //     return redirect('/pengaturan/kelola-pengguna/tambah')->with('flash_message_error', 'Password Tidak Sesuai !!');
            // }

            // $pass = Hash::make("secret_".$pass);
            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            
            if ($request->hasFile('imageUpload')) {

                $image_tmp = Input::file('imageUpload');
                $image_size = $image_tmp->getSize(); //getClientSize()
                $maxsize    = '2097152';

                if ($image_size < $maxsize) {

                    if ($image_tmp->isValid()) {

                        $namefile = $request->imageUpload;

                        if ($namefile != "") {

                            $path = 'img/user/'.$namefile;

                            if (File::exists($path)) {
                                # code...
                                File::delete($path);
                            }

                        }

                        $extension = $image_tmp->getClientOriginalExtension();
                        $filename = date('YmdHms').rand(111, 99999).'.'.$extension;
                        $image_path = 'img/user/'.$filename;

                        //Resize images
                        ini_set('memory_limit', '256M');
                        Image::make($image_tmp)->resize(300, 300)->save($image_path);
                        // ImageOptimizer::optimize($image_path);

                        //Store image name in item table
                        $imgPath = $filename;

                    }
                } else {
                    // return response()->json([
                    //     'status' => 'gagalImg'
                    // ]);
                    return redirect()->back()->with('flash_message_error', 'Ukuran file terlalu besar !!');
                }                
            }else{
                $namefile = $request->imageUpload;
            }

            DB::table('d_mem')
                ->where('m_id', '=', $id)
                ->update([
                    'm_comp' => $outlet,
                    'm_username' => $username,
                    'm_img' => $imgPath,
                    'm_name' => $nama,
                    'm_level' => $jabatan,
                    'm_birth' => $tgllahir,
                    'm_address' => $alamat,
                    
                ]);
            
            DB::commit();
            // Session::flash('sukses', 'Data berhasil disimpan');
            // return redirect('manajemen-pengguna/pengguna');
            return redirect('/pengaturan/akses-pengguna')->with('flash_message_success', 'Data pengguna berhasil diperbarui !!');
            // return response()->json([
            //     'status' => 'sukses'
            // ]);
        } catch (\Throwable $e) {
            DB::rollback();
            // Session::flash('gagal', 'Data gagal disimpan, cobalah sesaat lagi');
            // return redirect('manajemen-pengguna/pengguna');
            return redirect('/pengaturan/kelola-pengguna/tambah')->with('flash_message_error', ''.$e.'');
            // return response()->json([
            //     'status' => 'gagal'
            // ]);
        }
    }

    public function simpan_pass(Request $request){
        dd($request);
        DB::beginTransaction();
        try {
            $idm = Crypt::decrypt($request->id);
            $passL = $request->passLama;
            $passB = $request->passBaru;
            $passC = $request->passconf;

            $cekPassL = DB::table('d_mem')->select('m_password')->where('m_id', $idm)->get();

            if(Hash::check('secret_'.$passL, $cekPassL->m_password)){
                if($passB == $passC){
                    $codePass = sha1(md5('secret_').$passB);
                    DB::table('d_mem')->where('m_id', $idm)->update(['m_password' => $codePass]);
                    DB::commit();
                    return response()->json([
                        'status' => 'sukses'
                    ]);
                }else{
                    return response()->json([
                        'status' => 'gagalPassB'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'gagalPassL'
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            // return response()->json([
            //     'status' => 'gagal'
            // ]);
            return redirect('/pengaturan/kelola-pengguna/pass')->with('flash_message_error', ''.$th.'');

        }
    }
}
