<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Model\pengaturan\pengguna as Member;
use App\Model\pengaturan\jabatan as Jabatan;
use App\Model\pengaturan\outlet as Outlet;

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
        return view('pengaturan.akses_pengguna.tambah', compact('getJabatan', 'getOutlet'));
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
        dd($request);
        DB::beginTransaction();
        try {
            $id = $this->getDataId();
            $nama = $request->nama;
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
                return redirect('/pengaturan/kelola-pengguna/tambah')->with('flash_message_error', 'Username Tidak Tersedia');
            }
            if ($pass != $passconf) {
                return redirect('/pengaturan/kelola-pengguna/tambah')->with('flash_message_error', 'Password Tidak Sesuai');
            }

            $pass = sha1(md5('passwordAllah') . $request->pass);
            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'template_asset/img/user/' . $id;
            $this->deleteDir($dir);
            $childPath = $dir . '/';
            $path = $childPath;
            $file = $request->file('imageUpload');
            $name = null;
            if ($file != null) {
                $name = $folder . '.' . $file->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                        $file->move($path, $name);
                        $imgPath = $childPath . $name;
                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
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
            return redirect('/pengaturan/kelola-pengguna/tambah')->with('flash_message_success', 'Data pengguna berhasil tersimpan...!');
        } catch (\Throwable $e) {
            DB::rollback();
            // Session::flash('gagal', 'Data gagal disimpan, cobalah sesaat lagi');
            // return redirect('manajemen-pengguna/pengguna');
            return redirect('/pengaturan/kelola-pengguna/tambah')->with('flash_message_error', ''.$e.'');
        }

    }

    public function editUser(){

    }

    public function getUser(){

    }
}
