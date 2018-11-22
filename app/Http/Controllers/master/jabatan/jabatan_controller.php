<?php

namespace App\Http\Controllers\master\jabatan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Session;
use Auth;

class jabatan_controller extends Controller
{
    function formatPrice($data)
    {
        $explode_rp =  implode("", explode("Rp", $data));
        return implode("", explode(".", $explode_rp));
    }

    public function index()
    {
    	$data = DB::table('d_jabatan')->get();
    	return view('master.jabatan.index', compact('data'));
    }

    public function add(Request $request)
    {
    	if ($request->isMethod('post')) {
    		# code...
    		$data = $request->all();
    		// print_r($data); die;
            $gaji_pokok = $this->formatPrice($data['gaji_pokok']);
            $tunjangan_jabatan = $this->formatPrice($data['tunjangan_jabatan']);
            $tunjangan_kehadiran = $this->formatPrice($data['tunjangan_kehadiran']);
            $tunjangan_makan = $this->formatPrice($data['tunjangan_makan']);

    		DB::table('d_jabatan')->insert([
	    		'kode'                  => $request->kode_jabatan,
                'nama'                  => $request->nama_jabatan,
                'gaji_pokok'            => $gaji_pokok,
                'tunjangan_jabatan'     => $tunjangan_jabatan,
                'tunjangan_kehadiran'   => $tunjangan_kehadiran,
                'tunjangan_makan'       => $tunjangan_makan
	    	]);

	    	return redirect('/master/jabatan/add')->with('flash_message_success','Data berhasil ditambahkan!');
    	}
    	return view('master.jabatan.add');
    }

    public function multiple_edit_jabatan(Request $request)
    {
    	$data = DB::table('d_jabatan')
    			->whereIn('id', $request->data_check)
    			->get();

    	if(count($data) == 0){
            return view('errors.data_not_found');
        }

    	return view('master.jabatan.edit', compact('data'));
    }

    public function get_jabatan($id){
        $data = DB::table('d_jabatan')->where('id', $id)->first();

        return json_encode($data);
    }

    public function update(Request $request){
        // return json_encode($request->all());
        $data_request = $request->all();
        $gaji_pokok = $this->formatPrice($data_request['gaji_pokok']);
        $tunjangan_jabatan = $this->formatPrice($data_request['tunjangan_jabatan']);
        $tunjangan_kehadiran = $this->formatPrice($data_request['tunjangan_kehadiran']);
        $tunjangan_makan = $this->formatPrice($data_request['tunjangan_makan']);

        $data = DB::table('d_jabatan')->where('id', $request->id_jabatan);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'kode'                  => $request->kode_jabatan,
                'nama'                  => $request->nama_jabatan,
                'gaji_pokok'            => $gaji_pokok,
                'tunjangan_jabatan'     => $tunjangan_jabatan,
                'tunjangan_kehadiran'   => $tunjangan_kehadiran,
                'tunjangan_makan'       => $tunjangan_makan
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
        $data = DB::table('d_jabatan')->where('id', $request->id)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('master.jabatan.edit', compact('data'));
    }

    public function multiple_delete(Request $request){
        // return json_encode($request->data);

        DB::table('d_jabatan')->whereIn('id', $request->data)->delete();
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

}
