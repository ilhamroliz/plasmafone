<?php

namespace App\Http\Controllers\master\outlet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\master\outlet as Outlet;

use DB;
use Session;
use Auth;

class outlet_controller extends Controller
{
    public function index()
    {
    	$data = DB::table('d_cabang')
    			->select('d_cabang.*', 'd_kecamatan.*', 'd_kota.*', 'd_provinsi.*')
    			->join('d_kecamatan', 'd_cabang.c_kecamatan', '=', 'd_kecamatan.id')
    			->join('d_kota', 'd_cabang.c_kota', '=', 'd_kota.id')
    			->join('d_provinsi', 'd_cabang.c_provinsi', '=', 'd_provinsi.id')
    			->get();
    	return view('master.outlet.index', compact('data'));
    }

    public function get_kecamatan()
    {
    	$kecamatan = DB::table('d_kecamatan')->get();
    	return json_encode($kecamatan);
    }

    public function get_kota()
    {
    	$kota = DB::table('d_kota')->get();
    	return json_encode($kota);
    }

    public function get_provinsi()
    {
    	$provinsi = DB::table('d_provinsi')->get();
    	return json_encode($provinsi);
    }

    public function outlet_add()
    {
    	return view('master.outlet.tambah_outlet');
    }

    public function add_outlet(Request $request)
    {
    	// print_r($request->all()); die;
    	DB::table('d_cabang')->insert([
    		'c_nama' =>$request->nama_outlet,
    		'c_telephone' =>$request->telephone,
    		'c_alamat' =>$request->alamat,
    		'c_kecamatan' =>$request->kecamatan,
    		'c_kota' =>$request->kota,
    		'c_provinsi' =>$request->provinsi
    	]);
    	return redirect('/master/outlet')->with('flash_message_success','Data berhasil ditambahkan!');
    }

    public function get_outlet($id)
    {
    	$data = DB::table('d_cabang')
    			->select('d_cabang.*', 'd_kecamatan.*', 'd_kota.*', 'd_provinsi.*')
    			->join('d_kecamatan', 'd_cabang.c_kecamatan', '=', 'd_kecamatan.id')
    			->join('d_kota', 'd_cabang.c_kota', '=', 'd_kota.id')
    			->join('d_provinsi', 'd_cabang.c_provinsi', '=', 'd_provinsi.id')
    			->where('c_id', $id)
    			->first();
    	return json_encode($data);
    }

    public function outlet_edit(Request $request)
    {
    	$data = DB::table('d_cabang')
    			->select('d_cabang.*', 'd_kecamatan.*', 'd_kota.*', 'd_provinsi.*')
    			->join('d_kecamatan', 'd_cabang.c_kecamatan', '=', 'd_kecamatan.id')
    			->join('d_kota', 'd_cabang.c_kota', '=', 'd_kota.id')
    			->join('d_provinsi', 'd_cabang.c_provinsi', '=', 'd_provinsi.id')
    			->where('c_id', $request->id)
    			->get();

    	if(count($data) == 0){
            return view('errors.data_not_found');
        }

    	return view('master.outlet.edit_outlet', compact('data'));
    }

    public function update_outlet(Request $request)
    {
    	$data = DB::table('d_cabang')->where('c_id', $request->select_cabang);

    	if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
        	$data->update([
                'c_nama'=>$request->nama_outlet,
                'c_telephone'=>$request->telephone,
                'c_alamat'=>$request->alamat,
                'c_kecamatan'=>$request->kecamatan,
                'c_kota'=>$request->kota,
                'c_provinsi'=>$request->provinsi
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_edit_outlet(Request $request)
    {
    	$data = DB::table('d_cabang')
    			->select('d_cabang.*', 'd_kecamatan.*', 'd_kota.*', 'd_provinsi.*')
    			->join('d_kecamatan', 'd_cabang.c_kecamatan', '=', 'd_kecamatan.id')
    			->join('d_kota', 'd_cabang.c_kota', '=', 'd_kota.id')
    			->join('d_provinsi', 'd_cabang.c_provinsi', '=', 'd_provinsi.id')
    			->whereIn('c_id', $request->data_check)
    			->get();

    	if(count($data) == 0){
            return view('errors.data_not_found');
        }

    	return view('master.outlet.edit_outlet', compact('data'));
    }

    public function multiple_delete_outlet(Request $request)
    {
    	DB::table('d_cabang')->whereIn('c_id', $request->id)->delete();
    	
    	Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
            'status'    => 'berhasil'
        ]);
    }
}
