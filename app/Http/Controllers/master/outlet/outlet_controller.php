<?php

namespace App\Http\Controllers\master\outlet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\master\outlet as Outlet;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\CodeGenerator as GenerateCode;
use DataTables;
use DB;
use Session;
use Auth;

class outlet_controller extends Controller
{
    public function index()
    {
    	return view('master.outlet.index');
    }

    public function detail($id)
    {
        $outlet = Outlet::where(['c_id' => $id])->first();
        return response()->json($outlet);
    }

    public function getdataactive()
    {
        $outlet_active = Outlet::where('c_isactive', 'Y')->orderBy('created_at', 'desc')->get();

        $outlet_active = collect($outlet_active);

        return DataTables::of($outlet_active)

        ->addColumn('aksi', function ($outlet_active){ 

            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $outlet_active->c_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $outlet_active->c_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . $outlet_active->c_id . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';

        })

        ->rawColumns(['aksi'])

        ->make(true);
    }

    public function getdataall()
    {
        $outlet_all = Outlet::orderBy('created_at', 'desc')->get();

        $outlet_all = collect($outlet_all);

        return DataTables::of($outlet_all)

        ->addColumn('aksi', function ($supplier_all){    

            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $supplier_all->c_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $supplier_all->c_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . $supplier_all->c_id . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';

        })

        ->rawColumns(['aksi'])

        ->make(true);
    }

    public function getdatanonactive()
    {
        $outlet_nonactive = Outlet::where('c_isactive', 'N')->orderBy('created_at', 'desc')->get();

        $outlet_nonactive = collect($outlet_nonactive);

        return DataTables::of($outlet_nonactive)

        ->addColumn('aksi', function ($outlet_nonactive){     

            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $outlet_nonactive->c_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $outlet_nonactive->c_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . $outlet_nonactive->c_id . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';

        })

        ->rawColumns(['aksi'])

        ->make(true);
    }

    public function getcode()
    {
        $kode = GenerateCode::code('m_company', 'c_id', 8, 'PF');

        return response()->json($kode);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post'))
        {
           
            $data = $request->all();

            DB::beginTransaction();

            try {

                $check_code = Outlet::where('c_id', '=', $data['code'])->count();
                $check_name = Outlet::where('c_name', '=', $data['name'])->count();

                if ($check_code > 0) {

                    return  json_encode([
                        'status'    => 'kode ada',
                        'code'      => $data['code']
                    ]);

                } else if($check_name > 0) {

                    return  json_encode([
                        'status'    => 'nama ada',
                        'name'      => strtoupper($data['name'])
                    ]);

                }else {

                    if ($data['note'] == "") {

                        $note = "";

                    } else {

                        $note = strtoupper($data['note']);

                    }

                    $outlet = new Outlet();

                    $outlet->c_id = $data['code'];
                    $outlet->c_name = strtoupper($data['name']);
                    $outlet->c_tlp = $data['telp'];
                    $outlet->c_address = strtoupper($data['address']);
                    $outlet->c_note = $note;

                    $outlet->save();
                    
                    DB::commit();

                    return  json_encode([
                        'status'    => 'berhasil',
                        'code'      => GenerateCode::code('m_company', 'c_id', 8, 'PF')
                    ]);

                }

            } catch (\Exception $e) {

                DB::rollback();

                // something went wrong
                return  json_encode([
                    'status'    => 'gagal',
                    'msg'       => $e
                ]);

            }

        }

    	return view('master.outlet.add');
    }

    public function edit(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {

            $data       = $request->all();

            DB::beginTransaction();

            try {

                $check_code = Outlet::where('c_id', $data['code'])->count();
                $check_name = Outlet::where('c_name', '=', $data['name'])->where('c_id', '!=', $data['code'])->count();

                if ($check_code == 0) {
                    
                    return  json_encode([
                        'status'    => 'tidak ada',
                        'code'       => $data['code']
                    ]);

                } else if ($check_name > 0){

                    return  json_encode([
                        'status'    => 'nama ada',
                        'name'       => $data['name']
                    ]);

                } else {

                    if ($data['note'] == "") {

                        $note = "";

                    } else {

                        $note = strtoupper($data['note']);

                    }

                    Outlet::where(['c_id' => $data['code']])->update([
                        'c_name'     => strtoupper($data['name']),
                        'c_tlp'        => strtoupper($data['telp']),
                        'c_address'     => strtoupper($data['address']),
                        'c_note'        => $note,
                        'c_isactive'    => strtoupper($data['isactive'])
                    ]);

                     DB::commit();

                    // all good
                    return  json_encode([
                            'status'    => 'berhasil',
                            'code'      => $data['code']
                        ]);

                }

            } catch (\Exception $e) {

                DB::rollback();

                // something went wrong
                return  json_encode([
                            'status'    => 'gagal',
                            'msg'       => $e
                        ]);

            }
        }   

        // ======================Method Get================================
        DB::beginTransaction();

        try {

            $check = Outlet::where('c_id', $id)->count();

            if ($check > 0) {

                $outlets = Outlet::where('c_id', $id)->get();

                DB::commit();
                
                return view('master.outlet.edit')->with(compact('outlets'));

            } else {

                return redirect()->back()->with('flash_message_error', 'Data yang anda edit tidak ada didalam basis data...! Mulai ulang halaman');

            }

        } catch (\Exception $e) {

            DB::rollback();

            // something went wrong
            return redirect()->back()->with('flash_message_error', 'Ada yang tidak beres...! Mohon coba lagi');

        }
        
    }

    public function delete($id = null)
    {
        DB::beginTransaction();

        try {

            $check = Outlet::where('c_id', $id)->count();
            $check_d_mem = DB::table('d_mem')->where(['m_comp' => $id])->count();

            if ($check == 0) {
                
                return  json_encode([
                    'status'    => 'tidak ada'
                ]);

            } else if ($check_d_mem > 0){

                return  json_encode([
                    'status'    => 'd_mem ada'
                ]);

            } else {

                Outlet::where(['c_id' => $id])->delete();

                DB::commit();

                // all good
                return  json_encode([
                    'status'    => 'berhasil'
                ]);

            }

        } catch (\Exception $e) {

            DB::rollback();
            
            // something went wrong
            return  json_encode([
                'status'    => 'gagal',
                'msg'       => $e
            ]);

        }
    }

}
