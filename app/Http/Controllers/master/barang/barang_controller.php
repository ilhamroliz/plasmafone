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
    public function index()
    {
    	return view('master.item.index');
    }

    public function detail($id)
    {
        $item = Item::where(['i_id' => Crypt::decrypt($id)])->first();
        return response()->json($item);
    }

    public function getdataactive()
    {
        $items_active = Item::where('i_isactive', 'Y')->orderBy('created_at', 'desc')->get();

        $items_active = collect($items_active);

        return DataTables::of($items_active)
        ->addColumn('harga', function($items_active){
            return '<div class="text-right">Rp'.number_format($items_active->i_price,2,',','.').'</div>';
        })
        ->addColumn('aksi', function ($items_active){      
            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_active->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($items_active->i_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button></div>';
        })
        ->rawColumns(['aksi', 'harga'])
        ->make(true);
    }

    public function getdataall()
    {
        $items_all = Item::orderBy('created_at', 'desc')->get();

        $items_all = collect($items_all);

        return DataTables::of($items_all)
        ->addColumn('harga', function($items_all){
            return '<div class="text-right">Rp'.number_format($items_all->i_price,2,',','.').'</div>';
        })
        ->addColumn('aksi', function ($items_all){      
            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_all->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($items_all->i_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button></div>';
        })
        ->rawColumns(['aksi', 'harga'])
        ->make(true);
    }

    public function getdatanonactive()
    {
        $items_nonactive = Item::where('i_isactive', 'N')->orderBy('created_at', 'desc')->get();

        $items_nonactive = collect($items_nonactive);

        return DataTables::of($items_nonactive)
        ->addColumn('harga', function($items_nonactive){
            return '<div class="text-right">Rp'.number_format($items_nonactive->i_price,2,',','.').'</div>';
        })
        ->addColumn('aksi', function ($items_nonactive){      
            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_nonactive->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($items_nonactive->i_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button></div>';
        })
        ->rawColumns(['aksi', 'harga'])
        ->make(true);
    }

    public function add()
    {
    	return view('master.item.add');
    }

    public function get_form_resources()
    {
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

    public function insert(Request $request)
    {
        $data       = $request->all();
        $harga      = $this->formatPrice($data['i_harga']);

        DB::beginTransaction();

        try {

            $check = Item::where(['i_kelompok'=>$data['i_kelompok'], 'i_group'=>$data['i_group'], 'i_sub_group'=>$data['i_sub_group'], 'i_merk'=>$data['i_merk'], 'i_nama'=>$data['i_nama']])->count();

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
                if($data['i_code'] == ""){
                    $code = "";
                }else{
                    $code = strtoupper($data['i_code']);
                }
                $barang->i_code         = $code;
                $barang->i_isactive     = strtoupper($data['i_isactive']);
                $barang->i_minstock     = strtoupper($data['i_minstock']);
                $barang->i_berat        = strtoupper($data['i_berat']);
                $barang->i_price        = $harga;

                if ($request->hasFile('i_img')) {

                    $image_tmp = Input::file('i_img');
                    $image_size = $image_tmp->getSize(); //getClientSize()
                    $maxsize    = '2097152';

                    if ($image_size < $maxsize) {

                       if ($image_tmp->isValid()) {

                            $extension = $image_tmp->getClientOriginalExtension();
                            $filename = date('YmdHms').rand(111, 99999).'.'.$extension;
                            $image_path = 'img/items/'.$filename;

                            //Resize images
                            ini_set('memory_limit', '256M');
                            Image::make($image_tmp)->resize(250, 190)->save($image_path);
                            ImageOptimizer::optimize($image_path);

                            //Store image name in item table
                            $barang->i_img = $filename;

                        }
                    } else {

                        return redirect()->back()->with('flash_message_error', 'Data barang gagal disimpan...! Ukuran file terlalu besar');

                    }
                    
                }else{

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
            return redirect('master/barang/add')->with('flash_message_error', 'Data barang gagal disimpan...! Mohon coba lagi');

        }
    }

    public function edit(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {

            $data       = $request->all();

            DB::beginTransaction();

            try {

                if ($request->hasFile('i_img')) {

                    $image_tmp = Input::file('i_img');
                    $image_size = $image_tmp->getSize(); //getClientSize()
                    $maxsize    = '2097152';

                    if ($image_size < $maxsize) {

                       if ($image_tmp->isValid()) {

                            $namefile = $data['current_img'];

                            if ($namefile != "") {

                                $path = 'img/items/'.$namefile;

                                if (File::exists($path)) {
                                    # code...
                                    File::delete($path);
                                }

                            }
                            
                            $extension = $image_tmp->getClientOriginalExtension();
                            $filename = date('YmdHms').rand(111, 99999).'.'.$extension;
                            $image_path = 'img/items/'.$filename;

                            //Resize images
                            ini_set('memory_limit', '256M');
                            Image::make($image_tmp)->resize(250, 190)->save($image_path);
                            ImageOptimizer::optimize($image_path);

                            //Store image name in item table
                            $image = $filename;

                        }
                    } else {

                        return redirect()->back()->with('flash_message_error', 'Data barang gagal disimpan...! Ukuran file terlalu besar');

                    }
                    
                }else{

                    $image = $data['current_img'];

                }

                if($data['i_code'] == ""){
                    $code = "";
                }else{
                    $code = strtoupper($data['i_code']);
                }

                Item::where(['i_id' => Crypt::decrypt($id)])->update([
                    'i_kelompok'    => strtoupper($data['i_kelompok']),
                    'i_group'       => strtoupper($data['i_group']),
                    'i_sub_group'   => strtoupper($data['i_sub_group']),
                    'i_merk'        => strtoupper($data['i_merk']),
                    'i_nama'        => strtoupper($data['i_nama']),
                    'i_specificcode'=> strtoupper($data['i_specificcode']),
                    'i_code'        => $code,
                    'i_isactive'    => strtoupper($data['i_isactive']),
                    'i_minstock'    => strtoupper($data['i_minstock']),
                    'i_berat'       => strtoupper($data['i_berat']),
                    'i_price'       => $this->formatPrice($data['i_harga']),
                    'i_img'         => $image
                ]);

                DB::commit();

                // all good
                return redirect('/master/barang/edit/'.$id)->with('flash_message_success', 'Data barang berhasil diubah...!');

            } catch (\Exception $e) {

                DB::rollback();

                // something went wrong
                return redirect()->back()->with('flash_message_error', 'Data barang gagal diubah...! Mohon coba lagi');

            }
        }

        // ======================Method Get================================
        DB::beginTransaction();

        try {

            $check = Item::where('i_id', Crypt::decrypt($id))->count();

            if ($check > 0) {

                $items = Item::where('i_id', Crypt::decrypt($id))->get();

                DB::commit();
                
                return view('master.item.edit')->with(compact('items'));

            } else {

                return redirect()->back()->with('flash_message_error', 'Data yang anda edit tidak ada didalam basis data...! Mulai ulang halaman');

            }

        } catch (\Exception $e) {

            DB::rollback();

            // something went wrong
            return redirect()->back()->with('flash_message_error', 'Ada yang tidak beres...! Mohon coba lagi');

        }
        
    }

    function deleteimage($id = null)
    {
        DB::beginTransaction();

        try {

            $check = Item::where('i_id', Crypt::decrypt($id))->count();

            if ($check > 0) {

                $item = Item::where('i_id', Crypt::decrypt($id))->first();

                $filename = $item->i_img;
                $path = 'img/items/'.$filename;

                if (File::exists($path)) {
                    # code...
                    File::delete($path);
                }

                Item::where(['i_id' => Crypt::decrypt($id)])->update(['i_img' => ""]);

                DB::commit();
                
                return redirect()->back()->with('flash_message_success', 'Data gambar dari barang "'.$item->i_nama.'" berhasil dihapus...!');

            } else {

                return redirect()->back()->with('flash_message_error', 'Data yang ingin anda hapus tidak ada didalam basis data...! Mulai ulang halaman');

            }

        } catch (\Exception $e) {

            DB::rollback();
            // something went wrong

            return redirect()->back()->with('flash_message_error', 'Ada yang tidak beres...! Mohon coba lagi');

        }
        
    }

    function formatPrice($data)
    {
        return implode("", explode(".", $data));
    }

    
}
