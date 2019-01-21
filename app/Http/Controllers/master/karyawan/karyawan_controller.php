<?php

namespace App\Http\Controllers\master\karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\master\karyawan as karyawan;
use Illuminate\Support\Facades\Hash;

use DB;
use Session;
use Auth;

class karyawan_controller extends Controller
{
    public function index(){
    	$data = karyawan::where('status_karyawan', 1)->with('jabatan:id,nama', 'posisi:id_posisi,nama_posisi', 'kota.provinsi')->get();
    	return view('master.karyawan.index', compact('data'));
    }

    public function add(){
    	return view('master.karyawan.add');
    }

    public function insert(Request $request){
    	// return response()->json($request->all

        $jabatan = DB::table('d_jabatan')->where('id', $request->id_jabatan)->first();
        $posisi = DB::table('d_posisi_karyawan')->where('id_posisi', $request->id_posisi)->first();

        if(!$jabatan){
            return response()->json([
                'status'    => 'jabatan_not_found',
                'content'   => null
            ]);
        }else if(!$posisi){
            return response()->json([
                'status'    => 'posisi_not_found',
                'content'   => null
            ]);
        }

        $ckId = DB::table('d_karyawan')->select('nik_karyawan')->orderBy('created_at', 'desc')->first();
        $nik = ($ckId) ? $jabatan->kode.$posisi->id_posisi.str_pad(((int)substr($ckId->nik_karyawan, -4) + 1), 4, '0', STR_PAD_LEFT) : $jabatan->kode.$posisi->id_posisi.str_pad('1', 4, '0', STR_PAD_LEFT);
        $id = (DB::table('d_karyawan')->max('id_karyawan')) ? (DB::table('d_karyawan')->max('id_karyawan') + 1) : 1;

        // return($id);

        karyawan::insert([
            'id_karyawan'       => $id,
            'nik_karyawan'      => $nik,
            'id_jabatan'        => $request->id_jabatan,
            'id_posisi'         => $request->id_posisi,
            'nama_lengkap'      => $request->nama_lengkap,
            'alamat_rumah'      => $request->alamat_rumah,
            'id_kota'           => $request->id_kota,
            'nomor_telp'        => $request->nomor_telp,
            'kewarganegaraan'   => $request->kewarganegaraan,
            'agama'             => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'pendidikan_sd'     => $request->pendidikan_sd,
            'pendidikan_smp'    => $request->pendidikan_smp,
            'pendidikan_sma'    => $request->pendidikan_sma,
            'pendidikan_kuliah' => $request->pendidikan_kuliah,
            'status_karyawan'   => 1
        ]);

        DB::table('d_mem')->insert([
            'm_username'    => $nik,
            'm_password'    => Hash::make("secret_123456"),
            'id_karyawan'   => $id,
            'cabang'        => '-'
        ]);

        Session::flash('flash_message_success', 'Data Karyawan Terakhir Yang Anda Inputkan Berhasil Kami Simpan.');

        return response()->json([
            'status'    => 'berhasil',
            'content'   => null
        ]);
    }

    public function edit_multiple(Request $request){
        $data = karyawan::whereIn('id_karyawan', $request->data_check)->get();
        return view('master.karyawan.edit', compact('data'));
    }

    public function edit(Request $request){
        $data = karyawan::where('id_karyawan', $request->id)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('master.karyawan.edit', compact('data'));
    }

    public function update(Request $request){
        // return json_encode($request->all());

        $jabatan = DB::table('d_jabatan')->where('id', $request->id_jabatan)->first();
        $posisi = DB::table('d_posisi_karyawan')->where('id_posisi', $request->id_posisi)->first();

        if(!$jabatan){
            return response()->json([
                'status'    => 'jabatan_not_found',
                'content'   => null
            ]);
        }else if(!$posisi){
            return response()->json([
                'status'    => 'posisi_not_found',
                'content'   => null
            ]);
        }else if(!karyawan::find($request->nik_karyawan)){
            return response()->json([
                'status'    => 'data_not_found',
                'content'   => null
            ]);
        }

        $ckId = DB::table('d_karyawan')->where('id_karyawan', $request->nik_karyawan)->select('nik_karyawan')->orderBy('created_at', 'desc')->first();
        $nik = ($ckId) ? $jabatan->kode.$posisi->id_posisi.substr($ckId->nik_karyawan, -4) : $jabatan->kode.$posisi->id_posisi.substr($ckId->nik_karyawan, -4);

        // return json_encode($nik);

        karyawan::where('id_karyawan', $request->nik_karyawan)->update([
            'nik_karyawan'      => $nik,
            'id_jabatan'        => $request->id_jabatan,
            'id_posisi'         => $request->id_posisi,
            'nama_lengkap'      => $request->nama_lengkap,
            'alamat_rumah'      => $request->alamat_rumah,
            'id_kota'           => $request->id_kota,
            'nomor_telp'        => $request->nomor_telp,
            'kewarganegaraan'   => $request->kewarganegaraan,
            'agama'             => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'pendidikan_sd'     => $request->pendidikan_sd,
            'pendidikan_smp'    => $request->pendidikan_smp,
            'pendidikan_sma'    => $request->pendidikan_sma,
            'pendidikan_kuliah' => $request->pendidikan_kuliah,
            'status_karyawan'   => 1
        ]);

        DB::table('d_mem')->where('id_karyawan', $request->nik_karyawan)->update([
            'm_username'    => $nik,
            'cabang'        => '-'
        ]);

        Session::flash('flash_message_success', 'Data Karyawan Terakhir Yang Anda Edit Berhasil Kami Simpan.');

        return response()->json([
            'status'    => 'berhasil',
            'content'   => null
        ]);

    }

    public function multiple_delete(Request $request){
        // return json_encode($request->data);

        DB::table('d_karyawan')->whereIn('id_karyawan', $request->data)->delete();
        DB::table('d_mem')->whereIn('id_karyawan', $request->data)->delete();

        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

    public function get($id){
        $data = karyawan::find($id);

        return response()->json($data);
    }

    public function get_form_resources(Request $request){

    	$jabatan = DB::table('d_jabatan')->select('id', 'nama')->get();
    	$posisi = DB::table('d_posisi_karyawan')->select('id_posisi', 'nama_posisi')->get();
    	$provinsi = DB::table('d_provinsi')->select('id', 'nama_provinsi')->orderBy('nama_provinsi', 'asc')->get();
    	$kota = DB::table('d_kota')->select('id', 'id_provinsi', 'nama_kota')->orderBy('nama_kota', 'asc')->get();

    	return response()->json([
    		'jabatan'	=> $jabatan,
    		'posisi'	=> $posisi,
    		'provinsi'	=> $provinsi,
    		'kota'		=> $kota,
    	]);

    }
}
