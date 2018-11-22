<?php

namespace App\Http\Controllers\master\suplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\master\suplier as suplier;

use DB;
use Session;

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
            $sql = DB::table('d_supplier')->insert([
                's_company' => $data['nama_perusahaan'],
                's_name'    => $data['nama_suplier'],
                's_address' => $data['alamat_suplier'],
                's_phone'   => $data['telp_suplier'],
                's_fax'     => $data['fax_suplier'],
                's_note'    => $data['keterangan'],
                's_insert'  => date('Y-m-d H:m:s'),
                's_update'  => date('Y-m-d H:m:s'),
                's_limit'   => $data['limit']
            ]);
            if ($sql) {
                // return redirect('master/suplier/suplier')->with('flash_message_success','Semua Data Supplier Yang Terakhir Anda Input Berhasil Tersimpan Di Database!');
                return  json_encode([
                    'status'    => 'berhasil'
                ]);
            }else{
                // return redirect('master/suplier/suplier')->with('flash_message_error','Semua Data Supplier Yang Terakhir Anda Input Gagal Tersimpan Di Database!');
                return  json_encode([
                    'status'    => 'gagal'
                ]);
            }
            
        }
        return view('master.suplier.tambah_suplier');
    }

    public function multiple_delete(Request $request){
        // return json_encode($request->data);

        DB::table('d_supplier')->whereIn('s_id', $request->data)->delete();
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

    public function edit_multiple(Request $request){
        $data = suplier::whereIn('s_id', $request->data_check)->get();
        return view('master.suplier.edit_suplier', compact('data'));
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

    public function get_supplier($id){
        $data = suplier::find($id);

        return json_encode($data);
    }
}
