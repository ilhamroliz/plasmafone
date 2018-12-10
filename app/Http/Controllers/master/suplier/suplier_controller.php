<?php

namespace App\Http\Controllers\master\suplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Model\master\suplier as suplier;

use DB;
use Session;
use DataTables;

class suplier_controller extends Controller
{
    public function suplier()
    {
    	return view('master/suplier/index');
    }

    public function detail($id)
    {
        $supplier = suplier::where(['s_id' => Crypt::decrypt($id)])->first();
        return response()->json($supplier);
    }

    public function getdataactive()
    {
        $supplier_active = suplier::where('s_isactive', 'Y')->orderBy('s_insert', 'desc')->get();

        $supplier_active = collect($supplier_active);

        return DataTables::of($supplier_active)

        ->addColumn('limit', function($supplier_active){

            return '<p class="text-right">Rp'.number_format($supplier_active->s_limit,2,',','.').'</p>';

        })

        ->addColumn('aksi', function ($supplier_active){ 

            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_active->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($supplier_active->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . Crypt::encrypt($supplier_active->s_id) . '\', \'' . $supplier_active->s_name . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

        })

        ->rawColumns(['aksi', 'limit'])

        ->make(true);
    }

    public function getdataall()
    {
        $supplier_all = suplier::orderBy('s_insert', 'desc')->get();

        $supplier_all = collect($supplier_all);

        return DataTables::of($supplier_all)

        ->addColumn('limit', function($supplier_all){

            return '<p class="text-right">Rp'.number_format($supplier_all->s_limit,2,',','.').'</p>';

        })

        ->addColumn('active', function($supplier_all){

            if ($supplier_all->s_isactive == "Y") {
                
                return '<span class="label label-success">AKTIF</span>';

            } else {

                return '<span class="label label-danger">NON AKTIF</span>';

            }

        })

        ->addColumn('aksi', function ($supplier_all){    

            if ($supplier_all->s_isactive == "Y") {
                
                return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . Crypt::encrypt($supplier_all->s_id) . '\', \'' . $supplier_all->s_name . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

            } else {

                return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Aktifkan" onclick="statusactive(\'' . Crypt::encrypt($supplier_all->s_id) . '\', \'' . $supplier_all->s_name . '\')"><i class="glyphicon glyphicon-check"></i></button></div>';

            }

        })

        ->rawColumns(['aksi', 'limit', 'active'])

        ->make(true);
    }

    public function getdatanonactive()
    {
        $supplier_nonactive = suplier::where('s_isactive', 'N')->orderBy('s_insert', 'desc')->get();

        $supplier_nonactive = collect($supplier_nonactive);

        return DataTables::of($supplier_nonactive)

        ->addColumn('limit', function($supplier_nonactive){

            return '<p class="text-right">Rp'.number_format($supplier_nonactive->s_limit,2,',','.').'</p>';

        })

        ->addColumn('aksi', function ($supplier_nonactive){     

            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_nonactive->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($supplier_nonactive->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Aktifkan" onclick="statusactive(\'' . Crypt::encrypt($supplier_nonactive->s_id) . '\', \'' . $supplier_nonactive->s_name . '\')"><i class="glyphicon glyphicon-check"></i></button></div>';

        })

        ->rawColumns(['aksi', 'limit'])

        ->make(true);
    }

    public function add_suplier(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();

            DB::beginTransaction();

            try {

                $check = suplier::where(['s_company'=>$data['nama_perusahaan'], 's_phone'=>$data['telp_suplier']])->orWhere('s_company', '=', $data['nama_perusahaan'])->count();

                if ($check > 0) {

                    return  json_encode([
                        'status'    => 'ada',
                        'company'   => strtoupper($data['nama_perusahaan'])
                    ]);

                } else {
                    
                    if ($data['fax_suplier'] == "") {

                        $fax = "";

                    } else {

                        $fax = $data['fax_suplier'];

                    }

                    if ($data['keterangan'] == "") {

                        $note = "";

                    } else {

                        $note = strtoupper($data['keterangan']);

                    }

                    if ($data['limit'] == "" || $data['limit'] == 0) {

                        $limit = 0;

                    } else {

                        $limit = $this->formatPrice($data['limit']);

                    }

                    DB::table('d_supplier')->insert([
                        's_company' => strtoupper($data['nama_perusahaan']),
                        's_name'    => strtoupper($data['nama_suplier']),
                        's_address' => strtoupper($data['alamat_suplier']),
                        's_phone'   => $data['telp_suplier'],
                        's_fax'     => $fax,
                        's_note'    => $note,
                        's_limit'   => $limit
                    ]);
                    
                    DB::commit();

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
        return view('master.suplier.add');
    }

    public function edit(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {

            $data       = $request->all();

            DB::beginTransaction();

            try {

                $check = suplier::where('s_id', Crypt::decrypt($id))->count();

                if ($check == 0) {
                    
                    return  json_encode([
                        'status'    => 'tidak ada',
                        'msg'       => $data['nama_perusahaan']
                    ]);

                } else {

                    if ($data['fax_suplier'] == "") {

                        $fax = "";

                    } else {

                        $fax = $data['fax_suplier'];

                    }

                    if ($data['keterangan'] == "") {

                        $note = "";

                    } else {

                        $note = strtoupper($data['keterangan']);

                    }

                    if ($data['limit'] == "" || $data['limit'] == 0) {

                        $limit = 0;

                    } else {

                        $limit = $this->formatPrice($data['limit']);

                    }

                    suplier::where(['s_id' => Crypt::decrypt($id)])->update([
                        's_company'     => strtoupper($data['nama_perusahaan']),
                        's_name'        => strtoupper($data['nama_suplier']),
                        's_address'     => strtoupper($data['alamat_suplier']),
                        's_phone'       => $data['telp_suplier'],
                        's_fax'         => $fax,
                        's_note'        => $note,
                        's_limit'       => $limit,
                        's_isactive'    => strtoupper($data['isactive'])
                    ]);

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
                            'status'    => 'gagal'
                        ]);

            }
        }   

        // ======================Method Get================================
        DB::beginTransaction();

        try {

            $check = suplier::where('s_id', Crypt::decrypt($id))->count();

            if ($check > 0) {

                $suppliers = suplier::where('s_id', Crypt::decrypt($id))->get();

                DB::commit();
                
                return view('master.suplier.edit')->with(compact('suppliers'));

            } else {

                return redirect()->back()->with('flash_message_error', 'Data yang anda edit tidak ada didalam basis data...! Mulai ulang halaman');

            }

        } catch (\Exception $e) {

            DB::rollback();

            // something went wrong
            return redirect()->back()->with('flash_message_error', 'Ada yang tidak beres...! Mohon coba lagi');

        }
        
    }

    public function active($id = null)
    {
        DB::beginTransaction();

        try {

            $check = suplier::where('s_id', Crypt::decrypt($id))->count();

            if ($check == 0) {
                
                return  json_encode([
                    'status'    => 'tidak ada'
                ]);

            } else {

                suplier::where(['s_id' => Crypt::decrypt($id)])->update(['s_isactive' => 'Y']);

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

    public function nonactive($id = null)
    {
        DB::beginTransaction();

        try {

            $check = suplier::where('s_id', Crypt::decrypt($id))->count();

            if ($check == 0) {
                
                return  json_encode([
                    'status'    => 'tidak ada'
                ]);

            } else {

                suplier::where(['s_id' => Crypt::decrypt($id)])->update(['s_isactive' => 'N']);

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

    function formatPrice($data)
    {
        return implode("", explode(".", $data));
    }

}
