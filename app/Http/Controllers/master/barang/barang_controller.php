<?php

namespace App\Http\Controllers\master\barang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\master\d_item as item;
use App\Model\master\karyawan as karyawan;

use DB;
use Auth;
use Session;

class barang_controller extends Controller
{
    public function index(){
    	$data = karyawan::where('status_karyawan', 1)->with('jabatan:id,nama', 'posisi:id_posisi,nama_posisi', 'kota.provinsi')->get();
    	return view('master.item.index', compact('data'));
    }

    public function add(){
    	return view('master.item.add');
    }

    public function get_form_resources(){
    	$jenis = DB::table('d_item')->distinct('i_jenis')->select('i_jenis')->get();
    	$subjenis = DB::table('d_item')->distinct('i_jenissub')->whereNotNull('i_jenissub')->select('i_jenis', 'i_jenissub')->get();
    	$class = DB::table('d_item')->distinct('i_class')->whereNotNull('i_class')->select('i_jenissub', 'i_class')->get();
    	$classsub = DB::table('d_item')->distinct('i_classsub')->whereNotNull('i_classsub')->select('i_class', 'i_classsub')->get();
        $supplier = DB::table('d_supplier')->select('s_id', 's_name')->orderBy('s_name', 'asc')->get();

    	return response()->json([
    		'jenis' 	=> $jenis,
    		'subjenis'	=> $subjenis,
    		'class'		=> $class,
    		'classsub'	=> $classsub,
            'suplier'   => $supplier,
    	]);
    }

    public function insert(Request $request){
        return json_encode($request->all());
    }
}
