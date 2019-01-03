<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class ReceptionController extends Controller
{
	// Penerimaan barang dari supplier
    public function index_supplier()
    {
    	// $data = DB::table('d_inventory')
    	// 		->select('d_inventory.*', 'd_supplier.s_company')
    	// 		->where('d_inventory.i_from', '=', 'Supplier')
    	// 		->join('d_supplier', 'd_inventory.i_id_supplier', '=', 'd_supplier.s_id')
    	// 		->get();
    	return view('inventory.receipt_goods.supplier.index');
    }

    public function add_items_from_supplier(Request $request)
    {
    	if ($request->isMethod('post')) {
    		
    		$data = $request->all();
    		// print_r($data); die;
    		$sql = DB::table('d_inventory')->insert([
                'i_po'         => $data['purchase_order'],
                'i_kategori' 	=> $data['kategori'],
                'i_imei'		=> $data['imei'],
                'i_kode_barang'=> $data['kode_barang'],
                'i_nama_barang'=> $data['nama_barang'],
                'i_qty'		=> $data['qty'],
                'i_tgl_masuk'	=> $data['tgl_masuk'],
                'i_id_supplier'=> $data['supplier'],
                'i_from'		=> 'Supplier'
            ]);

            DB::table('d_purchase_order_dt')->where('podt_purchase', $data['purchase_order'])->update([
                'podt_status_inventory' => '1'
            ]);

            if ($sql) {
                return redirect('/inventory/penerimaan/supplier')->with('flash_message_success','Semua Data Yang Terakhir Anda Input Berhasil Tersimpan Di Database!');
            }else{
                return redirect('/inventory/penerimaan/supplier')->with('flash_message_error','Semua Data Yang Terakhir Anda Input Gagal Tersimpan Di Database!');
            }

    	}

    	$data_supplier = DB::table('d_supplier')->get();
        $purchase = DB::table('d_purchase_order_dt')
                    ->where('d_purchase_order_dt.podt_status_inventory', '=', '0')
                    ->get();
        if (count($purchase) == 0) {
            $purchase = 'null';
        }
    	return view('inventory.receipt_goods.supplier.add')->with(compact('data_supplier', 'purchase'));
    }

    public function get_current_receipt($id = null)
    {
    	$data = DB::table('d_inventory')
    			->select('d_inventory.*', 'd_supplier.s_company')
    			->where('d_inventory.i_id', '=', $id)
    			->join('d_supplier', 'd_inventory.i_id_supplier', '=', 'd_supplier.s_id')
    			->first();

        return json_encode($data);
    }

    public function multiple_edit_penerimaan_barang(Request $request)
    {
    	$data = DB::table('d_inventory')
    			->select('d_inventory.*', 'd_supplier.s_company')
    			->whereIn('d_inventory.i_id', $request->data_check)
    			->join('d_supplier', 'd_inventory.i_id_supplier', '=', 'd_supplier.s_id')
    			->get();

    	if(count($data) == 0){
            return view('errors.data_not_found');
        }

    	$data_supplier = DB::table('d_supplier')->get();
        return view('inventory.receipt_goods.supplier.edit', compact('data', 'data_supplier'));
    }

    public function edit(Request $request)
    {
        $data = DB::table('d_inventory')
    			->select('d_inventory.*', 'd_supplier.s_company')
    			->where('d_inventory.i_id', '=', $request->id)
    			->join('d_supplier', 'd_inventory.i_id_supplier', '=', 'd_supplier.s_id')
    			->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        // print_r($data); die;

        $data_supplier = DB::table('d_supplier')->get();
        return view('inventory.receipt_goods.supplier.edit', compact('data', 'data_supplier'));
    }

    public function update_penerimaan_barang(Request $request)
    {
    	$data = DB::table('d_inventory')->where('i_id', $request->i_id);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'i_kategori' 	=> $request->kategori,
                'i_imei'		=> $request->imei,
                'i_kode_barang'=> $request->kode_barang,
                'i_nama_barang'=> $request->nama_barang,
                'i_qty'		=> $request->qty,
                'i_tgl_masuk'	=> $request->tgl_masuk,
                'i_id_supplier'=> $request->supplier,
                'i_from'		=> 'Supplier'
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_delete_penerimaan(Request $request){
        // return json_encode($request->data);

        DB::table('d_inventory')->whereIn('i_id', $request->data)->delete();
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }
    // End penerimaan barang dari supplier

    // Penerimaan barang dari pusat
    public function index_pusat()
    {
    	$data = DB::table('d_inventory')
    			->where('i_from', '=', 'Pusat')
    			->get();
    	return view('inventory.receipt_goods.pusat.index')->with(compact('data'));
    }

    public function add_items_from_pusat(Request $request)
    {
    	if ($request->isMethod('post')) {
    		
    		$data = $request->all();
    		// print_r($data); die;
    		$sql = DB::table('d_inventory')->insert([
                'i_kategori' 	=> $data['kategori'],
                'i_imei'		=> $data['imei'],
                'i_kode_barang'=> $data['kode_barang'],
                'i_nama_barang'=> $data['nama_barang'],
                'i_qty'		=> $data['qty'],
                'i_tgl_masuk'	=> $data['tgl_masuk'],
                'i_id_supplier'=> '0',
                'i_from'		=> 'Pusat'
            ]);
            if ($sql) {
                return redirect('/inventory/penerimaan/pusat')->with('flash_message_success','Semua Data Yang Terakhir Anda Input Berhasil Tersimpan Di Database!');
            }else{
                return redirect('/inventory/penerimaan/pusat')->with('flash_message_error','Semua Data Yang Terakhir Anda Input Gagal Tersimpan Di Database!');
            }

    	}

    	return view('inventory.receipt_goods.pusat.add');
    }

    public function get_current_receipt_pusat($id = null)
    {
    	$data = DB::table('d_inventory')
    			->where('i_id', '=', $id)
    			->first();

        return json_encode($data);
    }

    public function multiple_edit_penerimaan_barang_pusat(Request $request)
    {
    	$data = DB::table('d_inventory')
    			->whereIn('i_id', $request->data_check)
    			->get();

    	if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('inventory.receipt_goods.pusat.edit', compact('data'));
    }

    public function edit_barang_pusat(Request $request)
    {
        $data = DB::table('d_inventory')
    			->where('i_id', '=', $request->id)
    			->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        // print_r($data); die;

        return view('inventory.receipt_goods.pusat.edit', compact('data'));
    }

    public function update_penerimaan_barang_pusat(Request $request)
    {
    	$data = DB::table('d_inventory')->where('i_id', $request->i_id);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'i_kategori' 	=> $request->kategori,
                'i_imei'		=> $request->imei,
                'i_kode_barang'=> $request->kode_barang,
                'i_nama_barang'=> $request->nama_barang,
                'i_qty'		=> $request->qty,
                'i_tgl_masuk'	=> $request->tgl_masuk,
                'i_from'		=> 'Pusat'
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_delete_penerimaan_pusat(Request $request){
        // return json_encode($request->data);

        DB::table('d_inventory')->whereIn('i_id', $request->data)->delete();
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }
    // End penerimaan barang dari pusat

    // Distribusi barang
    // public function index_distribusi()
    // {
    //     $purchase = DB::table('d_inventory')->get();
    //     return view('inventory.distribusi.index')->with(compact('purchase'));
    // }

    // public function show_purchase($id = null)
    // {
    //     $data = DB::table('d_inventory')
    //             ->where('i_po', $id)
    //             ->get();
    //     if (count($data) == 0) {
    //         # code...
    //         $data = null;
    //     }
    //     echo json_encode($data);
    // }
    // End distribusi barang
}
