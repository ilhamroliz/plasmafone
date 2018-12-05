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
        $suppliers = DB::table('d_supplier')->get();
    	return view('master/suplier/index')->with(compact('suppliers'));
    }

    public function getdataactive()
    {
        $supplier_active = suplier::where('s_isactive', 'Y')->orderBy('s_insert', 'desc')->get();

        $supplier_active = collect($supplier_active);

        return DataTables::of($supplier_active)
        ->addColumn('aksi', function ($supplier_active){      
            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_active->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($supplier_active->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button></div>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function getdataall()
    {
        $supplier_all = suplier::orderBy('s_insert', 'desc')->get();

        $supplier_all = collect($supplier_all);

        return DataTables::of($supplier_all)
        ->addColumn('aksi', function ($supplier_all){      
            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button></div>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function getdatanonactive()
    {
        $supplier_nonactive = suplier::where('s_isactive', 'N')->orderBy('s_insert', 'desc')->get();

        $supplier_nonactive = collect($supplier_nonactive);

        return DataTables::of($supplier_nonactive)
        ->addColumn('aksi', function ($supplier_nonactive){      
            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_nonactive->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($supplier_nonactive->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button></div>';
        })
        ->rawColumns(['aksi'])
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

                    if ($data['limit'] == "") {
                        $limit = 0;
                    } else {
                        $limit = $data['limit'];
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

    public function edit(Request $request){
        $data = suplier::where('s_id', $request->id)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('master.suplier.edit_suplier', compact('data'));
    }

    public function update(Request $request){
        // return json_encode($request->all());

        $data = DB::table('d_supplier')->where('s_id', $request->s_id);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                's_name'        => $request->s_name,
                's_company'     => $request->s_company,
                's_phone'       => $request->s_phone,
                's_fax'         => $request->s_fax,
                's_address'     => $request->s_address,
                's_note'        => $request->s_note,
                's_limit'       => $request->s_limit
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

}
