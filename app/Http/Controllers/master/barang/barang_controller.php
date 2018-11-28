<?php

namespace App\Http\Controllers\master\barang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Model\master\d_item as Item;

use DB;
use Auth;
use Session;
use Image;
use File;
use ImageOptimizer;

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
        $data = $request->all();

        $barang = new Item();
        $barang->i_kelompok     = $data['i_kelompok'];
        $barang->i_group        = $data['i_group'];
        $barang->i_sub_group    = $data['i_subgroup'];
        $barang->i_merk         = $data['i_merk'];
        $barang->i_nama         = $data['i_nama'];
        $barang->i_specificcode = $data['i_specificcode'];
        $barang->i_code         = $data['i_code'];
        $barang->i_isactive     = $data['i_isactive'];
        $barang->i_minstock     = $data['i_minstock'];
        $barang->i_berat        = $data['i_berat'];
        if ($request->hasFile('i_img')) {
            $image_tmp = Input::file('i_img');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = date('YmdHms').rand(111, 99999).'.'.$extension;
                $image_path = 'img/items/'.$filename;
                //Resize images
                Image::make($image_tmp)->resize(100, 100)->save($image_path);
                ImageOptimizer::optimize($image_path);
                //Store image name in products table
                $barang->i_img = $filename;
                
            }
        } else{
            $barang->i_img = '';
        }
        $barang->save();
        return redirect('master/barang/add')->with('flash_message_success', 'Data barang berhasil tersimpan...!');
    }

    public function edit(){
        return view('master.item.edit');
    }
}
