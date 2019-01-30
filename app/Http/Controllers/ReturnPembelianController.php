<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ReturnPembelianController extends Controller
{
    public function return_barang()
    {

        return view('pembelian/return_barang/index');
    }

    public function return_barang_add(Request $request)
    {
        if ($request->isMethod('post')) {
            // $data               = $request->all();
            // print_r($data); die;

            $count = DB::table('d_purchase_return')->count();
            $urutan = $count + 1;
            $pr_code = 'PR' . date('YmdHms') . $urutan;

            $harga_satuan = $this->formatPrice($request->harga_satuan);
            $total_bayar = $this->formatPrice($request->total_bayar);
            $total_harga_return = $this->formatPrice($request->total_harga_return);
            // print_r($total_harga_return); die;

            $result_price = '';

            if ($request->methode_return == 'GB') {
                $result_price = $total_bayar;
            } elseif ($request->methode_return == 'PT') {
                $result_price = $total_bayar - $total_harga_return;
            } elseif ($request->methode_return == 'GU') {
                $result_price = $total_bayar - $total_harga_return;
            } elseif ($request->methode_return == 'PN') {
                $result_price = $total_bayar - $total_harga_return;
            }

            $return_brg = DB::table('d_purchase_return')->insertGetId([
                'pr_po_id' => $request->purchase_order,
                'pr_code' => $pr_code,
                'pr_methode_return' => $request->methode_return,
                'pr_total_price' => $total_harga_return,
                'pr_result_price' => $result_price,
                'pr_status_return' => 'WT'
            ]);

            DB::table('d_purchase_return_dt')->insert([
                'pr_id' => $return_brg,
                'prd_kode_barang' => $request->kode_barang,
                'prd_qty' => $request->kuantitas_return,
                'prd_unit_price' => $harga_satuan,
                'prd_total_price' => $total_harga_return
            ]);


            return redirect('/pembelian/purchase-return')->with('flash_message_success', 'Data return barang berhasil ditambahkan!');


        }
        $purchase = DB::table('d_purchase')->get();
        return view('pembelian.return_barang.add')->with(compact('purchase'));
    }

    public function show_purchase($id = null)
    {
        $data = DB::table('d_purchase_order_dt')
            ->select('d_purchase_order_dt.*', 'd_purchase_order.*', 'd_supplier.*')
            ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->where(['podt_purchase' => $id, 'po_status' => 'Diterima'])
            ->first();
        echo json_encode($data);
    }

    public function get_current_return($id = null)
    {
        $data = DB::table('d_purchase_return')
            ->select('d_purchase_return.*', 'd_purchase_return_dt.*')
            ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
            ->where(['d_purchase_return.pr_id' => $id])
            ->first();
        echo json_encode($data);
    }

    public function edit_purchase_return(Request $request)
    {
        $data = DB::table('d_purchase_return')
            ->select('d_purchase_return.*', 'd_purchase_return_dt.*', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_supplier.*')
            ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
            ->join('d_purchase_order', 'd_purchase_return.pr_po_id', '=', 'd_purchase_order.po_no')
            ->join('d_purchase_order_dt', 'd_purchase_order.po_no', 'd_purchase_order_dt.podt_purchase')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->where('d_purchase_return.pr_id', $request->id)->get();

        if (count($data) == 0) {
            return view('errors.data_not_found');
        }
        // print_r($data); die;
        return view('pembelian.return_barang.edit', compact('data'));
    }

    public function update_purchase_return(Request $request)
    {
        $harga_satuan = $this->formatPrice($request->harga_satuan);
        $total_bayar = $this->formatPrice($request->total_bayar);
        $total_harga_return = $this->formatPrice($request->total_harga_return);

        $result_price = '';

        if ($request->methode_return == 'GB') {
            $result_price = $total_bayar;
        } elseif ($request->methode_return == 'PT') {
            $result_price = $total_bayar - $total_harga_return;
        } elseif ($request->methode_return == 'GU') {
            $result_price = $total_bayar - $total_harga_return;
        } elseif ($request->methode_return == 'PN') {
            $result_price = $total_bayar - $total_harga_return;
        }

        $data = DB::table('d_purchase_return')->where('pr_id', $request->return_id);

        if (!$data->first()) {

            $response = [
                'status' => 'tidak ada',
                'content' => 'null'
            ];
            return json_encode($response);

        } else {

            if ($request->confirm_return == 'CF') {
                $data->update([
                    'pr_methode_return' => $request->methode_return,
                    'pr_confirm_date'   => date('Y-m-d'),
                    'pr_total_price'    => $total_harga_return,
                    'pr_result_price'   => $result_price,
                    'pr_status_return'  => $request->confirm_return
                ]);

                DB::table('d_purchase_return_dt')
                    ->where('pr_id', $request->return_id)
                    ->update([
                        'prd_qty'         => $request->kuantitas_return,
                        'prd_total_price' => $total_harga_return,
                        'prd_isconfirm'   => 1
                    ]);

                Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
                $response = [
                    'status' => 'berhasil',
                    'content' => null
                ];

                return json_encode($response);
            } else {
                $data->update([
                    'pr_methode_return' => $request->methode_return,
                    'pr_total_price'    => $total_harga_return,
                    'pr_result_price'   => $result_price,
                    'pr_status_return'  => $request->confirm_return
                ]);

                DB::table('d_purchase_return_dt')
                    ->where('pr_id', $request->return_id)
                    ->update([
                        'prd_qty' => $request->kuantitas_return,
                        'prd_total_price' => $total_harga_return
                    ]);

                Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
                $response = [
                    'status' => 'berhasil',
                    'content' => null
                ];

                return json_encode($response);
            }

        }
    }

    public function multiple_edit_purchase_return(Request $request)
    {
        $data = DB::table('d_purchase_return')
            ->select('d_purchase_return.*', 'd_purchase_return_dt.*', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_supplier.*')
            ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
            ->join('d_purchase_order', 'd_purchase_return.pr_po_id', '=', 'd_purchase_order.po_no')
            ->join('d_purchase_order_dt', 'd_purchase_order.po_no', 'd_purchase_order_dt.podt_purchase')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->whereIn('d_purchase_return.pr_id', $request->data_check)->get();

        if (count($data) == 0) {
            return view('errors.data_not_found');
        }
        // print_r($data); die;
        return view('pembelian.return_barang.edit', compact('data'));
    }

    public function get_edit_return($id = null)
    {
        $data = DB::table('d_purchase_return')
            ->select('d_purchase_return.*', 'd_purchase_return_dt.*', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_supplier.*')
            ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
            ->join('d_purchase_order', 'd_purchase_return.pr_po_id', '=', 'd_purchase_order.po_no')
            ->join('d_purchase_order_dt', 'd_purchase_order.po_no', 'd_purchase_order_dt.podt_purchase')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->where('d_purchase_return.pr_id', $id)->first();
        echo json_encode($data);
    }

    public function multiple_delete_purchase_return(Request $request)
    {
        for ($i = 0; $i < count($request->pr_id); $i++) {
            # code...
            // print_r($key);echo ": ";print_r($value); echo "<pre>";
            DB::table('d_purchase_return_dt')->where('pr_id', $request->pr_id[$i])->delete();
            $check_prid_on_d_return = DB::table('d_purchase_order_dt')
                ->where('podt_no', $request->podt_no[$i])
                ->get();
            if (count($check_prid_on_d_return) == 0) {
                $check_prid_on_d_return_dt = DB::table('d_purchase_return')
                    ->where('pr_id', $request->pr_id[$i])
                    ->get();
                if (count($check_prid_on_d_return_dt) != 0) {
                    DB::table('d_purchase_return')->where('pr_id', $request->pr_id[$i])->delete();
                }

            }

        }

        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return json_encode([
            'status' => 'berhasil'
        ]);
    }
}
