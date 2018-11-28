<?php

namespace App\Http\Controllers\master\barang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\master\d_item as item;

use DB;
use Auth;
use Session;

class barang_controller extends Controller
{
    public function index(){
    	return view('master.item.index');
    }

    public function add(){
    	return view('master.item.add');
    }

    public function get_form_resources(){
        $kelompok       = DB::table('d_item')->distinct('i_kelompok')->select('i_kelompok')->get();
        $group          = DB::table('d_item')->distinct('i_group')->select('i_group')->get();
        $subgroup       = DB::table('d_item')->distinct('i_sub_group')->select('i_sub_group')->get();
        $merk           = DB::table('d_item')->distinct('i_merk')->select('i_merk')->get();

    	return response()->json([
            'kelompok'  => $kelompok,
            'group'     => $group,
            'subgroup'  => $subgroup,
            'merk'      => $merk
    	]);
    }

    public function insert(Request $request){
        return json_encode($request->all());
    }

    public function edit(){
        return view('master.item.edit');
    }
}
