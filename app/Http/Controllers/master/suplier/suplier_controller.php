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

    public function add_suplier(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();

            DB::beginTransaction();

            try {
                $check = suplier::where(['s_company'=>$data['nama_perusahaan'], 's_phone'=>$data['telp_suplier']])->count();

                if ($check > 0) {
                    return  json_encode([
                        'status'    => 'ada',
                        'company'   => $data['nama_perusahaan']
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
                        $note = $data['keterangan'];
                    }

                    if ($data['limit'] == "") {
                        $limit = 0;
                    } else {
                        $limit = $data['limit'];
                    }

                    DB::table('d_supplier')->insert([
                        's_company' => $data['nama_perusahaan'],
                        's_name'    => $data['nama_suplier'],
                        's_address' => $data['alamat_suplier'],
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

    public function get_supplier(){
        $data = suplier::get();
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
}
