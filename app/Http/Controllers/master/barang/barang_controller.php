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
use DataTables;

class barang_controller extends Controller
{
    public function index(){
    	return view('master.item.index');
    }

    public function getdataactive(){
        $items_active       = Item::where('i_isactive', 'Y')->get();

        $items_active = collect($items_active);
        return DataTables::of($items_active)
        ->addColumn('aksi', function ($items_active){      
            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" data-id="'.Crypt::encrypt($items_active->i_id).'"><i class="glyphicon glyphicon-list-alt"></i></button><button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" data-id="'.Crypt::encrypt($items_active->i_id).'"><i class="glyphicon glyphicon-edit"></i></button></div>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function getdataall(){
        $items_all = Item::get();

        $items_all = collect($items_all);
        return DataTables::of($items_all)
        ->addColumn('aksi', function ($items_all){      
            return '<button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" data-id="'.Crypt::encrypt($items_all->i_id).'"><i class="glyphicon glyphicon-list-alt"></i></button><button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" data-id="'.Crypt::encrypt($items_all->i_id).'"><i class="glyphicon glyphicon-edit"></i></button>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function getdatanonactive(){
        $items_nonactive = Item::where('i_isactive', 'N')->get();

        $items_nonactive = collect($items_nonactive);

        return DataTables::of($items_nonactive)
        ->addColumn('aksi', function ($items_nonactive){      
            return '<button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" data-id="'.Crypt::encrypt($items_nonactive->i_id).'"><i class="glyphicon glyphicon-list-alt"></i></button><button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" data-id="'.Crypt::encrypt($items_nonactive->i_id).'"><i class="glyphicon glyphicon-edit"></i></button>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
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
        $data       = $request->all();
        $harga      = $this->formatPrice($data['i_harga']);

        DB::beginTransaction();

        try {
            $check = Item::where(['i_kelompok'=>$data['i_kelompok'], 'i_group'=>$data['i_group'], 'i_sub_group'=>$data['i_sub_group'], 'i_merk'=>$data['i_merk'], 'i_nama'=>$data['i_nama'], 'i_code'=>$data['i_code']])->count();

            if ($check > 0) {
                return redirect('master/barang/add')->with('flash_message_error', 'Data barang yang Anda masukkan sudah ada didalam basis data!');
            } else {
                $barang = new Item();
                $barang->i_kelompok     = strtoupper($data['i_kelompok']);
                $barang->i_group        = strtoupper($data['i_group']);
                $barang->i_sub_group    = strtoupper($data['i_sub_group']);
                $barang->i_merk         = strtoupper($data['i_merk']);
                $barang->i_nama         = strtoupper($data['i_nama']);
                $barang->i_specificcode = strtoupper($data['i_specificcode']);
                $barang->i_code         = strtoupper($data['i_code']);
                $barang->i_isactive     = strtoupper($data['i_isactive']);
                $barang->i_minstock     = strtoupper($data['i_minstock']);
                $barang->i_berat        = strtoupper($data['i_berat']);
                $barang->i_price        = $harga;

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

                DB::commit();
                // all good
                return redirect('master/barang/add')->with('flash_message_success', 'Data barang berhasil tersimpan...!');
            }
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect('master/barang/add')->with('flash_message_error', 'Data barang gagal disimpan...!. Mohon coba lagi');
        }
    }

    public function edit(){
        return view('master.item.edit');
    }

    function formatPrice($data)
    {
        $explode_rp =  implode("", explode("Rp", $data));
        return implode("", explode(".", $explode_rp));
    }
}
