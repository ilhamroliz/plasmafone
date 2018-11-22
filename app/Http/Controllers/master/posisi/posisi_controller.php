<?php

namespace App\Http\Controllers\master\posisi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Session;
use Auth;

class posisi_controller extends Controller
{
    public function index()
    {
    	$data = DB::table('d_posisi_karyawan')->get();
    	return view('master.posisi.index', compact('data'));
    }

    public function add(Request $request)
    {
    	if ($request->isMethod('post')) {
    		# code...
    		$data = $request->all();
    		// print_r($data); die;
    		DB::table('d_posisi_karyawan')->insert([
	    		'nama_posisi' =>$request->nama_posisi
	    	]);
	    	return redirect('/master/posisi/add')->with('flash_message_success','Data berhasil ditambahkan!');
    	}
    	return view('master.posisi.add');
    }

    public function multiple_edit_posisi(Request $request)
    {
    	$data = DB::table('d_posisi_karyawan')
    			->whereIn('id_posisi', $request->data_check)
    			->get();

    	if(count($data) == 0){
            return view('errors.data_not_found');
        }

    	return view('master.posisi.edit', compact('data'));
    }

    public function get_posisi($id){
        $data = DB::table('d_posisi_karyawan')->where('id_posisi', $id)->first();

        return json_encode($data);
    }

    public function update(Request $request){
        // return json_encode($request->all());

        $data = DB::table('d_posisi_karyawan')->where('id_posisi', $request->id_posisi);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'nama_posisi'        => $request->nama_posisi
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function edit(Request $request){
        $data = DB::table('d_posisi_karyawan')->where('id_posisi', $request->id)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('master.posisi.edit', compact('data'));
    }

    public function multiple_delete(Request $request){
        // return json_encode($request->data);

        DB::table('d_posisi_karyawan')->whereIn('id_posisi', $request->data)->delete();
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

}
