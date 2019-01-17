<?php

namespace App\Http\Controllers\master\barang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Model\master\d_item as Item;
use App\Model\master\outlet as Outlet;
use App\Model\master\outlet_price as OutletPrice;
use App\Http\Controllers\PlasmafoneController as Access;

use DB;
use Auth;
use Session;
use Image;
use File;
use ImageOptimizer;
use DataTables;
use Response;
use Carbon\Carbon;

class barang_controller extends Controller
{
    public function index()
    {
        if (Access::checkAkses(45, 'read') == false) {
            return view('errors/407');
        } else {
            $outlets = DB::table('m_company')
                        ->select('m_company.c_id', 'm_company.c_name', 'd_outlet_price.op_price')
                        ->leftjoin('d_outlet_price', 'm_company.c_id', '=', 'd_outlet_price.op_outlet')
                        ->get();
                        
            return view('master.item.index')->with(compact('outlets'));
        }
    }

    public function detail($id)
    {
        if (Access::checkAkses(45, 'read') == true) {
            $item = Item::select('*', DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as dibuat'))->where(['i_id' => Crypt::decrypt($id)])->first();
            return response()->json(['status' => 'OK', 'data' => $item]);
        } else {
            return json_encode([
                'status' => 'Access denied'
            ]);
        }

    }

    public function getdataactive()
    {
        $items_active = Item::select('i_id', 'i_merk', 'i_nama', 'i_code', 'i_price')->where('i_isactive', 'Y');

        return DataTables::of($items_active)

            ->addColumn('harga', function ($items_active) {

                return '<div class="text-right">Rp' . number_format($items_active->i_price, 2, ',', '.') . '</div>';

            })

            ->addColumn('aksi', function ($items_active) {

                if (Access::checkAkses(45, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_active->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_active->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($items_active->i_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-info btn-circle" data-toggle="tooltip" data-placement="top" title="Pengaturan harga outlet" onclick="setting(\'' . Crypt::encrypt($items_active->i_id) . '\', \'' . $items_active->i_nama . '\')"><i class="glyphicon glyphicon-wrench"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . Crypt::encrypt($items_active->i_id) . '\', \'' . $items_active->i_nama . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                }

            })

            ->rawColumns(['aksi', 'harga'])

            ->make(true);
    }

    public function getdataall()
    {
        $items_all = Item::select('i_id', 'i_merk', 'i_nama', 'i_code', 'i_price', 'i_isactive');

        return DataTables::of($items_all)

            ->addColumn('harga', function ($items_all) {
                return '<div class="text-right">Rp' . number_format($items_all->i_price, 2, ',', '.') . '</div>';
            })

            ->addColumn('active', function ($items_all) {

                if ($items_all->i_isactive == "Y") {

                    return '<span class="label label-success">AKTIF</span>';

                } else {

                    return '<span class="label label-danger">NON AKTIF</span>';

                }

            })

            ->addColumn('aksi', function ($items_all) {

                if ($items_all->i_isactive == "Y") {

                    if (Access::checkAkses(45, 'update') == false) {

                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_all->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                    } else {

                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_all->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($items_all->i_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-info btn-circle" data-toggle="tooltip" data-placement="top" title="Pengaturan harga outlet" onclick="setting(\'' . Crypt::encrypt($items_all->i_id) . '\', \'' . $items_all->i_nama . '\')"><i class="glyphicon glyphicon-wrench"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . Crypt::encrypt($items_all->i_id) . '\', \'' . $items_all->i_nama . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                    }

                } else {

                    if (Access::checkAkses(45, 'update') == false) {

                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_all->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                    } else {

                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_all->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($items_all->i_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-info btn-circle" data-toggle="tooltip" data-placement="top" title="Pengaturan harga outlet" onclick="setting(\'' . Crypt::encrypt($items_all->i_id) . '\', \'' . $items_all->i_nama . '\')"><i class="glyphicon glyphicon-wrench"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Aktifkan" onclick="statusactive(\'' . Crypt::encrypt($items_all->i_id) . '\', \'' . $items_all->i_nama . '\')"><i class="glyphicon glyphicon-check"></i></button></div>';

                    }

                }

            })

            ->rawColumns(['aksi', 'harga', 'active'])

            ->make(true);
    }

    public function getdatanonactive()
    {
        $items_nonactive = Item::select('i_id', 'i_merk', 'i_nama', 'i_code', 'i_price')->where('i_isactive', 'N');

        return DataTables::of($items_nonactive)

            ->addColumn('harga', function ($items_nonactive) {

                return '<div class="text-right">Rp' . number_format($items_nonactive->i_price, 2, ',', '.') . '</div>';

            })

            ->addColumn('aksi', function ($items_nonactive) {

                if (Access::checkAkses(45, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_nonactive->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($items_nonactive->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($items_nonactive->i_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-info btn-circle" data-toggle="tooltip" data-placement="top" title="Pengaturan harga outlet" onclick="setting(\'' . Crypt::encrypt($items_nonactive->i_id) . '\', \'' . $items_nonactive->i_nama . '\')"><i class="glyphicon glyphicon-wrench"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Aktifkan" onclick="statusactive(\'' . Crypt::encrypt($items_nonactive->i_id) . '\', \'' . $items_nonactive->i_nama . '\')"><i class="glyphicon glyphicon-check"></i></button></div>';

                }

            })

            ->rawColumns(['aksi', 'harga'])

            ->make(true);
    }

    public function add()
    {

        if (Access::checkAkses(45, 'insert') == false) {

            return view('errors/407');

        } else {

            return view('master.item.add');

        }

    }

    public function get_form_resources()
    {
        if (Access::checkAkses(45, 'read') == false) {

            return json_encode([

                'status' => 'Access denied'

            ]);

        } else {

            $kelompok = DB::table('d_item')->distinct('i_kelompok')->select('i_kelompok')->orderBy('i_kelompok', 'asc')->get();

            $group = DB::table('d_item')->distinct('i_group')->select('i_group')->orderBy('i_group', 'asc')->get();

            $subgroup = DB::table('d_item')->distinct('i_sub_group')->select('i_sub_group')->orderBy('i_sub_group', 'asc')->get();

            $merk = DB::table('d_item')->distinct('i_merk')->select('i_merk')->orderBy('i_merk', 'asc')->get();

            return response()->json([
                'status' => 'OK',
                'kelompok' => $kelompok,
                'group' => $group,
                'subgroup' => $subgroup,
                'merk' => $merk
            ]);
        }

    }

    public function insert(Request $request)
    {
        if (Access::checkAkses(45, 'insert') == false) {

            return view('errors/407');

        } else {

            $data = $request->all();
            $harga = $this->formatPrice($data['i_harga']);

            // if($data['i_expired'] == ""){
            //     $expired = null;
            // }else{
            //     $expired = date('Y-m-d', strtotime($data['i_expired']));
            // }

            DB::beginTransaction();

            try {

                $check = Item::where(['i_kelompok' => $data['i_kelompok'], 'i_group' => $data['i_group'], 'i_sub_group' => $data['i_sub_group'], 'i_merk' => $data['i_merk'], 'i_nama' => $data['i_nama']])->count();

                if ($check > 0) {

                    return redirect('master/barang/add')->with('flash_message_error', 'Data barang yang Anda masukkan sudah ada didalam basis data!');

                } else {

                    $barang = new Item();
                    $barang->i_kelompok = strtoupper($data['i_kelompok']);
                    $barang->i_group = strtoupper($data['i_group']);
                    $barang->i_sub_group = strtoupper($data['i_sub_group']);
                    $barang->i_merk = strtoupper($data['i_merk']);
                    $barang->i_nama = strtoupper($data['i_nama']);
                    $barang->i_specificcode = strtoupper($data['i_specificcode']);

                    if ($data['i_code'] == "") {

                        $code = "";

                    } else {

                        $code = strtoupper($data['i_code']);

                    }

                    $barang->i_code = $code;
                    $barang->i_isactive = strtoupper($data['i_isactive']);
                    $barang->i_minstock = strtoupper($data['i_minstock']);
                    $barang->i_berat = strtoupper($data['i_berat']);
                    $barang->i_price = $harga;
                    $barang->i_expired = $data['i_expired'];

                    if ($request->hasFile('i_img')) {

                        $image_tmp = Input::file('i_img');
                        $image_size = $image_tmp->getSize(); //getClientSize()
                        $maxsize = '2097152';

                        if ($image_size < $maxsize) {

                            if ($image_tmp->isValid()) {

                                $extension = $image_tmp->getClientOriginalExtension();
                                $filename = date('YmdHms') . rand(111, 99999) . '.' . $extension;
                                $image_path = 'img/items/' . $filename;

                                if (!is_dir($image_path )) {
                                    mkdir("img/items", 0777, true);
                                }

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

                    } else {

                        $barang->i_img = '';

                    }

                    $barang->save();

                    DB::commit();
                    Access::logActivity('Menambahkan Data Barang' . $barang->i_nama);
                    // all good
                    return redirect('master/barang/add')->with('flash_message_success', 'Data barang berhasil tersimpan...!');
                }
            } catch (\Exception $e) {

                DB::rollback();

                // something went wrong
                return redirect('master/barang/add')->with('flash_message_error', 'Data barang gagal disimpan...! "Terjadi kesalahan server" Mohon coba lagi ');

            }

        }

    }

    public function edit(Request $request, $id = null)
    {
        if (Access::checkAkses(45, 'update') == false) {

            return view('errors/407');

        } else {

            if ($request->isMethod('post')) {

                if (Access::checkAkses(45, 'update') == false) {

                    return view('errors/407');

                } else {

                    $data = $request->all();
                    
                    // if($data['i_expired'] == ""){
                    //     $expired = NULL;
                    // }else{
                    //     $expired = date('Y-m-d', strtotime($data['i_expired']));;
                    // }

                    DB::beginTransaction();

                    try {

                        if ($request->hasFile('i_img')) {

                            $image_tmp = Input::file('i_img');
                            $image_size = $image_tmp->getSize(); //getClientSize()
                            $maxsize = '2097152';

                            if ($image_size < $maxsize) {

                                if ($image_tmp->isValid()) {

                                    $namefile = $data['current_img'];

                                    if ($namefile != "") {

                                        $path = 'img/items/' . $namefile;

                                        if (File::exists($path)) {
                                            # code...
                                            File::delete($path);
                                        }

                                    }

                                    $extension = $image_tmp->getClientOriginalExtension();
                                    $filename = date('YmdHms') . rand(111, 99999) . '.' . $extension;
                                    $image_path = 'img/items/' . $filename;

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

                        } else {

                            if ($data['current_img'] == "") {

                                $image = "";

                            } else {

                                $image = $data['current_img'];

                            }

                        }

                        if ($data['i_code'] == "") {

                            $code = "";

                        } else {

                            $code = strtoupper($data['i_code']);

                        }

                        Item::where(['i_id' => Crypt::decrypt($id)])->update([
                            'i_kelompok' => strtoupper($data['i_kelompok']),
                            'i_group' => strtoupper($data['i_group']),
                            'i_sub_group' => strtoupper($data['i_sub_group']),
                            'i_merk' => strtoupper($data['i_merk']),
                            'i_nama' => strtoupper($data['i_nama']),
                            'i_specificcode' => strtoupper($data['i_specificcode']),
                            'i_code' => $code,
                            'i_isactive' => strtoupper($data['i_isactive']),
                            'i_minstock' => strtoupper($data['i_minstock']),
                            'i_berat' => strtoupper($data['i_berat']),
                            'i_price' => $this->formatPrice($data['i_harga']),
                            'i_img' => $image,
                            'i_expired' => $data['i_expired']
                        ]);

                        DB::commit();
                        Access::logActivity('Edit Data Barang' . $data['i_nama']);

                        // all good
                        return redirect('/master/barang/edit/' . $id)->with('flash_message_success', 'Data barang berhasil diubah...!');

                    } catch (\Exception $e) {

                        DB::rollback();

                        // something went wrong
                        return redirect()->back()->with('flash_message_error', 'Data barang gagal diubah...! Mohon coba lagi => ' . $e);

                    }

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

    }

    function deleteimage($id = null)
    {
        if (Access::checkAkses(45, 'delete') == false) {

            return view('errors/407');

        } else {

            DB::beginTransaction();

            try {

                $check = Item::where('i_id', Crypt::decrypt($id))->count();

                if ($check > 0) {

                    $item = Item::where('i_id', Crypt::decrypt($id))->first();

                    $filename = $item->i_img;
                    $path = 'img/items/' . $filename;

                    if (File::exists($path)) {
                        # code...
                        File::delete($path);
                    }

                    Item::where(['i_id' => Crypt::decrypt($id)])->update(['i_img' => ""]);

                    DB::commit();

                    return redirect()->back()->with('flash_message_success', 'Data gambar dari barang "' . $item->i_nama . '" berhasil dihapus...!');

                } else {

                    return redirect()->back()->with('flash_message_error', 'Data yang ingin anda hapus tidak ada didalam basis data...! Mulai ulang halaman');

                }

            } catch (\Exception $e) {

                DB::rollback();
                // something went wrong

                return redirect()->back()->with('flash_message_error', 'Ada yang tidak beres...! Mohon coba lagi');

            }

        }

    }

    public function active($id = null)
    {
        if (Access::checkAkses(45, 'update') == false) {

            return json_encode([
                'status' => 'Access denied'
            ]);

        } else {

            DB::beginTransaction();

            try {

                $check = Item::where('i_id', Crypt::decrypt($id))->count();

                if ($check == 0) {

                    return json_encode([
                        'status' => 'tidak ada'
                    ]);

                } else {

                    Item::where(['i_id' => Crypt::decrypt($id)])->update(['i_isactive' => 'Y']);

                    DB::commit();
                    $data = Item::select('i_nama')->where('i_id', Crypt::decrypt($id))->first();
                    $log = 'Set Data Barang' . $data->i_nama . ' = ACTIVE';
                    Access::logActivity($log);

                    // all good
                    return json_encode([
                        'status' => 'berhasil'
                    ]);

                }

            } catch (\Exception $e) {

                DB::rollback();
                
                // something went wrong
                return json_encode([
                    'status' => 'gagal',
                    'msg' => $e
                ]);

            }

        }

    }

    public function nonactive($id = null)
    {
        if (Access::checkAkses(45, 'update') == false) {

            return json_encode([
                'status' => 'Access denied'
            ]);

        } else {

            DB::beginTransaction();

            try {

                $check = Item::where('i_id', Crypt::decrypt($id))->count();

                if ($check == 0) {

                    return json_encode([
                        'status' => 'tidak ada'
                    ]);

                } else {

                    Item::where(['i_id' => Crypt::decrypt($id)])->update(['i_isactive' => 'N']);

                    DB::commit();
                    $data = Item::select('i_nama')->where('i_id', Crypt::decrypt($id))->first();
                    $log = 'Set Data Barang' . $data->i_nama . ' = NONACTIVE';
                    Access::logActivity($log);

                    // all good
                    return json_encode([
                        'status' => 'berhasil'
                    ]);

                }

            } catch (\Exception $e) {

                DB::rollback();
                
                // something went wrong
                return json_encode([
                    'status' => 'gagal',
                    'msg' => $e
                ]);

            }

        }

    }

    public function getoutlet($item = null)
    {

        $values_outlet = [];

        $outlet = Outlet::select('c_id')->get();

        foreach ($outlet as $key => $value) {
            
            $check = OutletPrice::where('op_outlet', $outlet[$key]->c_id)->where('op_item', Crypt::decrypt($item))->count();
            
            if ($check == 0) {
                array_push($values_outlet, $outlet[$key]->c_id);
            }
        }

        if (count($values_outlet) != 0) {
            
            for ($i=0; $i < count($values_outlet); $i++) { 
                $values[] = array('op_outlet' => $values_outlet[$i], 'op_item' => Crypt::decrypt($item), 'op_price' => 0);
            }
            DB::beginTransaction();

            try{
                DB::table('d_outlet_price')->insert($values);

                DB::commit();

            } catch (\Exception $e) {

                DB::rollback();
                // something went wrong
                return redirect()->back()->with('flash_message_error', 'Gagal memproses...! "Terjadi kesalahan server" Mohon coba lagi ');

            }

        }

        // $get_outlet = OutletPrice::where('op_item', Crypt::decrypt($item));
        $get_outlet = DB::table('d_outlet_price')
                        ->select('m_company.c_name', 'd_item.i_nama', 'd_outlet_price.op_outlet', 'd_outlet_price.op_item', 'd_outlet_price.op_price', 'd_item.i_price')
                        ->join('m_company', 'm_company.c_id', '=', 'd_outlet_price.op_outlet')
                        ->join('d_item', 'd_item.i_id', '=', 'd_outlet_price.op_item')
                        ->where('d_outlet_price.op_item', Crypt::decrypt($item))->get();

        // return DataTables::of($get_outlet)

        //     ->addColumn('harga', function ($get_outlet) {

        //         return '<div class="input-group"><input type="hidden" name="outlet[]" value="'. Crypt::encrypt($get_outlet->op_outlet) .'"><input type="hidden" name="item[]" value="'. Crypt::encrypt($get_outlet->op_item) .'"><input type="text" class="form-control harga-outlet" onkeypress="validate(event)" onkeyup="return formatRupiah(this.value)" name="harga[]" placeholder="Harga" value="' . number_format($get_outlet->op_price,0,',','.') . '"/></div>';

        //     })

        //     ->rawColumns(['harga'])

        //     ->make(true);

        return view('master.item.setharga')->with(compact('get_outlet'));

    }

    public function gethargaperoutlet($outlet = null, $item = null){
        
        if ($outlet != null && $item != null) {
            $decrypt_outlet = $outlet;
            $decrypt_item = $item;

            $outlets = DB::table('m_company')
                        ->select('m_company.c_id', 'm_company.c_name', 'd_outlet_price.op_price')
                        ->leftjoin('d_outlet_price', 'm_company.c_id', '=', 'd_outlet_price.op_outlet')
                        ->where(['m_company.c_id' => $decrypt_outlet, 'd_outlet_price.op_outlet' => $decrypt_item])
                        ->get();

            return $outlets;
        } else {
            return false;
        }
        

    }

    public function addoutletprice(Request $request)
    {

        if (Access::checkAkses(45, 'update') == false) {

            return view('errors/407');

        } else {

            $data = $request->all();

            DB::beginTransaction();

            try{

                $harga = 0;

                if ($data['harga_default'] != null) {
                    DB::table('d_item')->where('i_id', Crypt::decrypt($data['item_id'][0]))->update(['i_price' => $this->formatPrice($data['harga_default'])]);
                } else {
                    DB::table('d_item')->where('i_id', Crypt::decrypt($data['item_id'][0]))->update(['i_price' => 0]);
                }

                for ($i=0; $i < count($data['outlet_id']); $i++) { 
                    if ($data['harga'][$i] != null) {
                        $harga = $this->formatPrice($data['harga'][$i]);
                    } else {
                        $harga = 0;
                    }
                    DB::table('d_outlet_price')->where(['op_outlet' => Crypt::decrypt($data['outlet_id'][$i]), 'op_item' => Crypt::decrypt($data['item_id'][$i])])->update(['op_price' => $harga]);
                }

                DB::commit();
                Access::logActivity('Merubah Harga Barang');
                return redirect('/master/barang')->with('flash_message_success', 'Data harga barang baerhasil diubah...!');

            } catch(\Exception $e) {
                
                DB::rollback();

                // something went wrong
                return redirect()->back()->with('flash_message_error', 'Data harga barang gagal diubah...! Mohon coba lagi => '.$e);

            }

            

        }
        
    }

    public function hargaperoutlet(Request $request)
    {
        if (Access::checkAkses(45, 'update') == false) {

            return json_encode([
                'status' => 'Access denied'
            ]);

        } else {

            $data = $request->all();
            $decrypt_outlet = Crypt::decrypt($data['outlet']);
            $decrypt_item = Crypt::decrypt($data['item']);
            $harga = $this->formatPrice($data['harga']);

            $values = array('op_outlet' => $decrypt_outlet,
                            'op_item' => $decrypt_item,
                            'op_price' => $harga);

            DB::beginTransaction();

            try{

                $check = OutletPrice::where(['op_outlet' => $decrypt_outlet, 'op_item' => $decrypt_item])->count();

                if($check > 0) {

                    DB::table('d_outlet_price')->where(['op_outlet' => $decrypt_outlet, 'op_item' => $decrypt_item])->update($values);

                    DB::commit();
                    Access::logActivity('Merubah Harga Barang "' . $data['namaitem'] . '" untuk outlet ' . $data['namaoutlet']);
                    // all good
                    return json_encode([
                        'status' => 'Success',
                        'message' => 'Merubah Harga Barang "' . $data['namaitem'] . '" untuk outlet ' . $data['namaoutlet']
                    ]);

                } else {

                    DB::table('d_outlet_price')->insert($values);

                    DB::commit();
                    Access::logActivity('Menambah Harga Barang "' . $data['namaitem'] . '" untuk outlet ' . $data['namaoutlet']);
                    // all good
                    return json_encode([
                        'status' => 'Success',
                        'message' => 'Menambah Harga Barang "' . $data['namaitem'] . '" untuk outlet ' . $data['namaoutlet']
                    ]);

                }

                

            } catch(\Exception $e) {
                
                DB::rollback();

                // something went wrong
                return json_encode([
                    'status' => 'Failed'
                ]);

            }

        }
        
    }

    public function cariKelompok(Request $request)
    {
        $cari = $request->term;
        $kelompok = DB::table('d_item')
            ->select('i_kelompok')
            ->where('i_kelompok', 'like', '%'.$cari.'%')->distinct()->get();

        if (count($kelompok) == 0) {
            $results[] = ['label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($kelompok as $query) {
                $results[] = ['label' => $query->i_kelompok];
            }
        }
        return Response::json($results);
    }

    public function cariGroup(Request $request)
    {
        $cari = $request->term;
        $group = DB::table('d_item')
            ->select('i_group')
            ->where('i_group', 'like', '%'.$cari.'%')->distinct()->get();

        if (count($group) == 0) {
            $results[] = ['label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($group as $query) {
                $results[] = ['label' => $query->i_group];
            }
        }
        return Response::json($results);
    }

    public function cariSubGroup(Request $request)
    {
        $cari = $request->term;
        $subgroup = DB::table('d_item')
            ->select('i_sub_group')
            ->where('i_sub_group', 'like', '%'.$cari.'%')->distinct()->get();

        if (count($subgroup) == 0) {
            $results[] = ['label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($subgroup as $query) {
                $results[] = ['label' => $query->i_sub_group];
            }
        }
        return Response::json($results);
    }

    public function cariMerk(Request $request)
    {
        $cari = $request->term;
        $merk = DB::table('d_item')
            ->select('i_merk')
            ->where('i_merk', 'like', '%'.$cari.'%')->distinct()->get();

        if (count($merk) == 0) {
            $results[] = ['label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($merk as $query) {
                $results[] = ['label' => $query->i_merk];
            }
        }
        return Response::json($results);
    }

    public function cariNama(Request $request)
    {
        $cari = $request->term;
        $nama = DB::table('d_item')
            ->select('i_nama')
            ->where('i_nama', 'like', '%'.$cari.'%')->distinct()->get();

        if (count($nama) == 0) {
            $results[] = ['label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['label' => $query->i_nama];
            }
        }
        return Response::json($results);
    }

    public function searchItem(Request $request)
    {

        $data = $request->all();

        if ($data['kelompok'] == "" && $data['group'] == "" && $data['subgroup'] == "" && $data['merk'] == "" && $data['nama'] == "") {
            
            $search = Item::select('i_id', 'i_merk', 'i_nama', 'i_code', 'i_price', 'i_isactive');

        } else if($data['kelompok'] != "" && $data['group'] == "" && $data['subgroup'] == "" && $data['merk'] == "" && $data['nama'] == "") {

            $search = Item::where('i_kelompok', $data['kelompok']);

        } else if($data['kelompok'] == "" && $data['group'] != "" && $data['subgroup'] == "" && $data['merk'] == "" && $data['nama'] == "") {

            $search = Item::where('i_group', $data['group']);

        } else if($data['kelompok'] == "" && $data['group'] == "" && $data['subgroup'] != "" && $data['merk'] == "" && $data['nama'] == "") {

            $search = Item::where('i_sub_group', $data['subgroup']);

        } else if($data['kelompok'] == "" && $data['group'] == "" && $data['subgroup'] == "" && $data['merk'] != "" && $data['nama'] == "") {

            $search = Item::where('i_merk', $data['merk']);

        } else if($data['kelompok'] == "" && $data['group'] == "" && $data['subgroup'] == "" && $data['merk'] == "" && $data['nama'] != "") {

            $search = Item::where('i_nama', $data['nama']);

        } else if($data['kelompok'] != "" && $data['group'] != "" && $data['subgroup'] == "" && $data['merk'] == "" && $data['nama'] == "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_group', $data['group']);

        } else if($data['kelompok'] != "" && $data['group'] == "" && $data['subgroup'] != "" && $data['merk'] == "" && $data['nama'] == "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_sub_group', $data['subgroup']);

        } else if($data['kelompok'] != "" && $data['group'] == "" && $data['subgroup'] == "" && $data['merk'] != "" && $data['nama'] == "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_merk', $data['merk']);

        } else if($data['kelompok'] != "" && $data['group'] == "" && $data['subgroup'] == "" && $data['merk'] == "" && $data['nama'] != "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] == "" && $data['group'] != "" && $data['subgroup'] != "" && $data['merk'] == "" && $data['nama'] == "") {

            $search = Item::where('i_group', $data['group'])
                            ->where('i_sub_group', $data['subgroup']);

        } else if($data['kelompok'] == "" && $data['group'] != "" && $data['subgroup'] == "" && $data['merk'] != "" && $data['nama'] == "") {

            $search = Item::where('i_group', $data['group'])
                            ->where('i_merk', $data['merk']);

        } else if($data['kelompok'] == "" && $data['group'] != "" && $data['subgroup'] == "" && $data['merk'] == "" && $data['nama'] != "") {

            $search = Item::where('i_group', $data['group'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] == "" && $data['group'] == "" && $data['subgroup'] != "" && $data['merk'] != "" && $data['nama'] == "") {

            $search = Item::where('i_sub_group', $data['subgroup'])
                            ->where('i_merk', $data['merk']);

        } else if($data['kelompok'] == "" && $data['group'] == "" && $data['subgroup'] != "" && $data['merk'] == "" && $data['nama'] != "") {

            $search = Item::where('i_sub_group', $data['subgroup'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] == "" && $data['group'] == "" && $data['subgroup'] == "" && $data['merk'] != "" && $data['nama'] != "") {

            $search = Item::where('i_merk', $data['merk'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] != "" && $data['group'] != "" && $data['subgroup'] != "" && $data['merk'] == "" && $data['nama'] == "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_group', $data['group'])
                            ->where('i_sub_group', $data['subgroup']);

        } else if($data['kelompok'] != "" && $data['group'] != "" && $data['subgroup'] == "" && $data['merk'] != "" && $data['nama'] == "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_group', $data['group'])
                            ->where('i_merk', $data['merk']);

        } else if($data['kelompok'] != "" && $data['group'] != "" && $data['subgroup'] == "" && $data['merk'] == "" && $data['nama'] != "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_group', $data['group'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] != "" && $data['group'] == "" && $data['subgroup'] != "" && $data['merk'] != "" && $data['nama'] == "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_sub_group', $data['subgroup'])
                            ->where('i_merk', $data['merk']);

        } else if($data['kelompok'] != "" && $data['group'] == "" && $data['subgroup'] != "" && $data['merk'] == "" && $data['nama'] != "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_sub_group', $data['subgroup'])
                            ->where('i_nama', $data['nama']);

        }  else if($data['kelompok'] != "" && $data['group'] == "" && $data['subgroup'] == "" && $data['merk'] != "" && $data['nama'] != "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_merk', $data['merk'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] == "" && $data['group'] != "" && $data['subgroup'] != "" && $data['merk'] != "" && $data['nama'] == "") {

            $search = Item::where('i_group', $data['group'])
                            ->where('i_sub_group', $data['subgroup'])
                            ->where('i_merk', $data['merk']);

        } else if($data['kelompok'] == "" && $data['group'] != "" && $data['subgroup'] != "" && $data['merk'] == "" && $data['nama'] != "") {

            $search = Item::where('i_group', $data['group'])
                            ->where('i_sub_group', $data['subgroup'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] == "" && $data['group'] != "" && $data['subgroup'] == "" && $data['merk'] != "" && $data['nama'] != "") {

            $search = Item::where('i_group', $data['group'])
                            ->where('i_merk', $data['merk'])
                            ->where('i_nama', $data['nama']);

        }  else if($data['kelompok'] == "" && $data['group'] == "" && $data['subgroup'] != "" && $data['merk'] != "" && $data['nama'] != "") {

            $search = Item::where('i_sub_group', $data['subgroup'])
                            ->where('i_merk', $data['merk'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] != "" && $data['group'] != "" && $data['subgroup'] != "" && $data['merk'] != "" && $data['nama'] == "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_group', $data['group'])
                            ->where('i_sub_group', $data['subgroup'])
                            ->where('i_merk', $data['merk']);

        } else if($data['kelompok'] != "" && $data['group'] != "" && $data['subgroup'] != "" && $data['merk'] == "" && $data['nama'] != "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_group', $data['group'])
                            ->where('i_sub_group', $data['subgroup'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] != "" && $data['group'] != "" && $data['subgroup'] == "" && $data['merk'] != "" && $data['nama'] != "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_group', $data['group'])
                            ->where('i_merk', $data['merk'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] != "" && $data['group'] == "" && $data['subgroup'] != "" && $data['merk'] != "" && $data['nama'] != "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_sub_group', $data['subgroup'])
                            ->where('i_merk', $data['merk'])
                            ->where('i_nama', $data['nama']);

        } else if($data['kelompok'] != "" && $data['group'] != "" && $data['subgroup'] != "" && $data['merk'] != "" && $data['nama'] != "") {

            $search = Item::where('i_kelompok', $data['kelompok'])
                            ->where('i_group', $data['group'])
                            ->where('i_sub_group', $data['subgroup'])
                            ->where('i_merk', $data['merk'])
                            ->where('i_nama', $data['nama']);

        }

        return DataTables::of($search)

        ->addColumn('harga', function ($search) {
            return '<div class="text-right">Rp' . number_format($search->i_price, 2, ',', '.') . '</div>';
        })

        ->addColumn('active', function ($search) {

            if ($search->i_isactive == "Y") {

                return '<span class="label label-success">AKTIF</span>';

            } else {

                return '<span class="label label-danger">NON AKTIF</span>';

            }

        })

        ->addColumn('aksi', function ($search) {

            if ($search->i_isactive == "Y") {

                if (Access::checkAkses(45, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($search->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($search->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($search->i_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-info btn-circle" data-toggle="tooltip" data-placement="top" title="Pengaturan harga outlet" onclick="setting(\'' . Crypt::encrypt($search->i_id) . '\', \'' . $search->i_nama . '\')"><i class="glyphicon glyphicon-wrench"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . Crypt::encrypt($search->i_id) . '\', \'' . $search->i_nama . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                }

            } else {

                if (Access::checkAkses(45, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($search->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($search->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($search->i_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-info btn-circle" data-toggle="tooltip" data-placement="top" title="Pengaturan harga outlet" onclick="setting(\'' . Crypt::encrypt($search->i_id) . '\', \'' . $search->i_nama . '\')"><i class="glyphicon glyphicon-wrench"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Aktifkan" onclick="statusactive(\'' . Crypt::encrypt($search->i_id) . '\', \'' . $search->i_nama . '\')"><i class="glyphicon glyphicon-check"></i></button></div>';

                }

            }

        })

        ->rawColumns(['aksi', 'harga', 'active'])

        ->make(true);

    }

    function formatPrice($data)
    {
        return implode("", explode(".", $data));
    }


}
