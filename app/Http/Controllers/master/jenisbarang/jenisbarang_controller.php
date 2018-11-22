<?php

namespace App\Http\Controllers\master\jenisbarang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\master\JenisBarang;
use DB;
use Session;

class jenisbarang_controller extends Controller
{
    public function index()
    {
        $data = JenisBarang::get();
        return view('master.jenisbarang.index')->with(compact('data'));
    }

    public function add(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		$Jenis = new JenisBarang();
            $Jenis->j_parent 		= $data['parent'];
            $Jenis->j_name 			= $data['jenis_barang'];
            $Jenis->j_description 	= $data['keterangan'];
            // $gudang->save();

            if ($Jenis->save()) {
            	$levels = JenisBarang::where(['j_parent'=>0])->get();
                return  json_encode([
                    'status'    => 'berhasil',
                    'jenis' => $levels
                ]);
            }else{
                return  json_encode([
                    'status'    => 'gagal'
                ]);
            }
    	}
    	return view('master.jenisbarang.add');
    }

    public function get_resource()
    {
    	$levels = JenisBarang::where(['j_parent'=>0])->get();
    	return  json_encode([
                    'status'    => 'berhasil',
                    'jenis' => $levels
                ]);
    }

    public function multiple_delete(Request $request)
    {
    	// 
    }

    public function edit_multiple(Request $request)
    {
    	// 
    }

    public function edit(Request $request)
    {
    	$data = JenisBarang::where('j_id', $request->id)->get();
    	$jenisDetails = JenisBarang::where(['j_id'=>$request->id])->first();
        if(count($data) == 0){
            return view('errors.data_not_found');
        }
        return view('master.jenisbarang.edit', compact('data', 'jenisDetails'));
    }

    public function update(Request $request)
    {
    	// 
    }

    public function get_jenisbarang($id)
    {
    	// 
    }
}
