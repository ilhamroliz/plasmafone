<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class manajemenPenggunaController extends Controller
{
    public function tambah_pengguna(){
        return view('pengaturan.akses_pengguna.tambah');
    }

    public function getId()
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

    public function simpan_pengguna(Request $request){
        
        DB::beginTransaction();
        try {
            $id = getId();
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
                return redirect('/pengaturan/tambah-pengguna')->with(['gagal' => 'Username tidak tersedia']);
            }
            if ($pass != $passconf) {
                return redirect('/pengaturan/tambah-pengguna')->with(['gagal' => 'Password tidak sesuai']);
            }

            DB::table('d_mem')
                ->insert([
                    'm_id' => $m_id,
                    'm_username' => $username,
                    'm_image' => $imgPath,
                    'm_password' => $pass,
                    'm_name' => $nama,
                    'm_jabatan' => $jabatan,
                    'm_birth' => $birth,
                    'm_address' => $alamat,
                    'm_state' => 'ACTIVE'
                ]);

            
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    public function editUser(){

    }

    public function getUser(){

    }
}
