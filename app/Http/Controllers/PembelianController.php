<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\pembelian\order as order;
use App\Http\Controllers\PlasmafoneController as Plasma;
use DataTables;
use Carbon\Carbon;
use Auth;
use DB;
use Session;
use PDF;
use Response;

class PembelianController extends Controller
{
    public function konfirmasi_pembelian()
    {
        // $data = "Null";
        // $data_supplier = DB::table('d_supplier')
        //                 ->join('d_request_order_dt', 'd_supplier.s_id', '=', 'd_request_order_dt.rdt_supplier')
        //                 ->where('d_request_order_dt.rdt_status', '=', 'Rencana Pembelian')
        //                 ->groupBy('d_supplier.s_name')
        //                 ->get();
        // print_r($data_supplier);
    	// return view('pembelian/konfirmasi_pembelian/index', compact('data', 'data_supplier'));

        return view('pembelian/konfirmasi_pembelian/view_konfirmasi_pembelian');
    }

    public function get_data_order($id)
    {
        $data_order = DB::table('d_request_order_dt')
                        ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                        ->where('d_request_order_dt.rdt_supplier', $id)
                        ->where('d_request_order_dt.rdt_status', '=', 'Rencana Pembelian')
                        ->get();
        $data = $id;
        $data_supplier = DB::table('d_supplier')
                        ->join('d_request_order_dt', 'd_supplier.s_id', '=', 'd_request_order_dt.rdt_supplier')
                        ->where('d_request_order_dt.rdt_status', '=', 'Rencana Pembelian')
                        ->groupBy('d_supplier.s_name')
                        ->get();

        // print_r($data_order); die;

        return view('pembelian/konfirmasi_pembelian/index', compact('data', 'data_supplier', 'data_order'));
    }

    public function generatePDF($id)
    {
        $data_order = DB::table('d_request_order_dt')
                        ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_request_order_dt.rdt_supplier', $id)->get();
        // return view('pembelian/konfirmasi_pembelian/print', compact('data_order'));

        $pdf = PDF::loadView('pembelian/konfirmasi_pembelian/newpdf', compact('data_order'));
        return $pdf->stream();
    }

    public function print($id)
    {
        $data_order = DB::table('d_request_order_dt')
                        ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_request_order_dt.rdt_supplier', $id)->get();
        return view('pembelian/konfirmasi_pembelian/newprint', compact('data_order'));
    }

    public function downloadpdf($id)
    {
        $data_order = DB::table('d_request_order_dt')
                        ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_request_order_dt.rdt_supplier', $id)->get();
        return view('pembelian/konfirmasi_pembelian/pdf', compact('data_order', 'id'));
    }

    public function return_barang()
    {
        $data_return = DB::table('d_purchase_return')
                        ->select('d_purchase_return.*', 'd_purchase_return_dt.*')
                        ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
                        ->get();
                        // print_r($data_return); die;
    	return view('pembelian/return_barang/index')->with(compact('data_return'));
    }

    public function return_barang_add(Request $request)
    {
        if ($request->isMethod('post'))
        {
            // $data               = $request->all();
            // print_r($data); die;

            $count              = DB::table('d_purchase_return')->count();
            $urutan             = $count + 1;
            $pr_code            = 'PR'.date('YmdHms').$urutan;

            $harga_satuan       = $this->formatPrice($request->harga_satuan);
            $total_bayar        = $this->formatPrice($request->total_bayar);
            $total_harga_return = $this->formatPrice($request->total_harga_return);
            // print_r($total_harga_return); die;

            $result_price       = '';

            if ($request->methode_return == 'GB')
            {
                $result_price = $total_bayar;
            }
            elseif ($request->methode_return == 'PT')
            {
                $result_price = $total_bayar - $total_harga_return;
            }
            elseif ($request->methode_return == 'GU')
            {
                $result_price = $total_bayar - $total_harga_return;
            }
            elseif ($request->methode_return == 'PN')
            {
                $result_price = $total_bayar - $total_harga_return;
            }

            $return_brg = DB::table('d_purchase_return')->insertGetId([
                        'pr_po_id'          =>$request->purchase_order,
                        'pr_code'           =>$pr_code,
                        'pr_methode_return' =>$request->methode_return,
                        'pr_total_price'    =>$total_harga_return,
                        'pr_result_price'   =>$result_price,
                        'pr_status_return'  => 'WT'
                    ]);

            DB::table('d_purchase_return_dt')->insert([
                'pr_id'             =>$return_brg,
                'prd_kode_barang'   =>$request->kode_barang,
                'prd_qty'           =>$request->kuantitas_return,
                'prd_unit_price'    =>$harga_satuan,
                'prd_total_price'   =>$total_harga_return
            ]);

            

            return redirect('/pembelian/purchase-return')->with('flash_message_success','Data return barang berhasil ditambahkan!');


        }
        $purchase = DB::table('d_purchase_order_dt')->get();
        return view('pembelian.return_barang.add')->with(compact('purchase'));
    }

    public function get_current_return($id = null)
    {
        $data = DB::table('d_purchase_return')
                ->select('d_purchase_return.*', 'd_purchase_return_dt.*')
                ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
                ->where(['d_purchase_return.pr_id'=>$id])
                ->first();
        echo json_encode($data);
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

    public function edit_purchase_return(Request $request)
    {
        $data = DB::table('d_purchase_return')
                ->select('d_purchase_return.*', 'd_purchase_return_dt.*', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_supplier.*')
                ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
                ->join('d_purchase_order', 'd_purchase_return.pr_po_id', '=', 'd_purchase_order.po_no')
                ->join('d_purchase_order_dt', 'd_purchase_order.po_no', 'd_purchase_order_dt.podt_purchase')
                ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
                ->where('d_purchase_return.pr_id', $request->id)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }
        // print_r($data); die;
        return view('pembelian.return_barang.edit', compact('data'));
    }

    public function update_purchase_return(Request $request)
    {
        $harga_satuan       = $this->formatPrice($request->harga_satuan);
        $total_bayar        = $this->formatPrice($request->total_bayar);
        $total_harga_return = $this->formatPrice($request->total_harga_return);

        $result_price       = '';

        if ($request->methode_return == 'GB')
        {
            $result_price = $total_bayar;
        }
        elseif ($request->methode_return == 'PT')
        {
            $result_price = $total_bayar - $total_harga_return;
        }
        elseif ($request->methode_return == 'GU')
        {
            $result_price = $total_bayar - $total_harga_return;
        }
        elseif ($request->methode_return == 'PN')
        {
            $result_price = $total_bayar - $total_harga_return;
        }

        $data = DB::table('d_purchase_return')->where('pr_id', $request->return_id);

        if(!$data->first()){

            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];
            return json_encode($response);

        }else{

            if ($request->confirm_return == 'CF')
            {
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
                    'prd_qty'           =>$request->kuantitas_return,
                    'prd_total_price'   =>$total_harga_return,
                    'prd_isconfirm'     =>1
                ]);

                Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
                $response = [
                    'status'    => 'berhasil',
                    'content'   => null
                ];

                return json_encode($response);
            } 
            else
            {
                $data->update([
                    'pr_methode_return' => $request->methode_return,
                    'pr_total_price'    => $total_harga_return,
                    'pr_result_price'   => $result_price,
                    'pr_status_return'  => $request->confirm_return
                ]);

                DB::table('d_purchase_return_dt')
                ->where('pr_id', $request->return_id)
                ->update([
                    'prd_qty'           =>$request->kuantitas_return,
                    'prd_total_price'   =>$total_harga_return
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

    public function multiple_edit_purchase_return(Request $request)
    {
        $data = DB::table('d_purchase_return')
                ->select('d_purchase_return.*', 'd_purchase_return_dt.*', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_supplier.*')
                ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
                ->join('d_purchase_order', 'd_purchase_return.pr_po_id', '=', 'd_purchase_order.po_no')
                ->join('d_purchase_order_dt', 'd_purchase_order.po_no', 'd_purchase_order_dt.podt_purchase')
                ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
                ->whereIn('d_purchase_return.pr_id', $request->data_check)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }
        // print_r($data); die;
        return view('pembelian.return_barang.edit', compact('data'));
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

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

    public function show_purchase($id = null)
    {
        $data = DB::table('d_purchase_order_dt')
                ->select('d_purchase_order_dt.*', 'd_purchase_order.*', 'd_supplier.*')
                ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
                ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
                ->where(['podt_purchase'=>$id, 'po_status'=>'Diterima'])
                ->first();
        echo json_encode($data);
    }

    public function purchase_order()
    {
        // $data = DB::table('d_purchase_order_dt')
        //         ->select('d_purchase_order_dt.*', 'd_purchase_order.*', 'd_supplier.*')
        //         ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', 'd_purchase_order.po_no')
        //         ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
        //         ->orderBy('d_purchase_order.po_status', 'desc')
        //         ->get();
    	// return view('pembelian/purchase_order/index', compact('data'));
        return view('pembelian/purchase_order/view_purchase_order');
    }

    public function purchase_order_add()
    {
        $data_request = DB::table('d_request_order_dt')
                        ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_purchase_order', 'd_request_order_dt.rdt_no', '=', 'd_purchase_order.po_request_order_no', 'left')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                        ->where('d_request_order_dt.rdt_status', '=', 'Rencana Pembelian')
                        ->get();
        return view('pembelian.purchase_order.tambah_purchase_order')->with(compact('data_request'));
    }

    public function get_request_purchase($id)
    {
        $data = DB::table('d_request_order_dt')
                ->select('d_request_order.*', 'd_request_order_dt.*', 'd_request_order.ro_cabang', 'd_supplier.s_name')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id')
                ->where('d_request_order_dt.rdt_no', $id)
                ->first();
        return json_encode($data);
    }

    public function get_purchase($id)
    {
        // return json_encode($id); die;
        $data = DB::table('d_purchase_order_dt')
                ->select('d_purchase_order.*', 'd_purchase_order_dt.*', 'd_request_order.ro_cabang', 'd_supplier.s_name')
                ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
                ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
                ->where('d_purchase_order_dt.podt_no', $id)
                ->first();
        return json_encode($data);
    }

    function formatPrice($data)
    {
        $explode_rp =  implode("", explode("Rp", $data));
        return implode("", explode(".", $explode_rp));
    }

    function generate_code($table, $field, $lebar=0, $awalan)
    {
        $order = DB::table($table)->select($field)->orderBy($field, 'desc')->limit(1);
        $countData = $order->count();
        if ($countData == 0) {
            $nomor = 1;
        }else{
            $getData = $order->get();
            $row = array();
            foreach ($getData as $value) {
                $row = array($value->$field);
            }
            // print_r($row); die;
            $nomor = intval(substr($row[0], strlen($awalan)))+1;
        }

        if ($lebar > 0) {
            $angka = $awalan.str_pad($nomor, $lebar,"0", STR_PAD_LEFT);
        }else{
            $angka = $awalan.$nomor;
        }

        return $angka;
    }

    public function add_purchase(Request $request)
    {
        // print_r($request->all()); die;
        $total_harga = $this->formatPrice($request->total_harga);
        $total_bayar = $this->formatPrice($request->total_bayar);
        $harga_satuan = $this->formatPrice($request->harga_satuan);
        // echo $harga_satuan; die;
        $po_no = $this->generate_code('d_purchase_order', 'po_no', 4, 'PO'.date('ymd'));
        
        $podt_no = $this->generate_code('d_purchase_order_dt', 'podt_no', 4, 'PODT'.date('dmy'));
        // print_r($po_no); die;
        if ($request->diskon == "") {
            # code...
            $diskon = "0";
        }else{
            $diskon = $request->diskon;
        }

        $insert_purchase_order = DB::table('d_purchase_order')->insert([
                                    'po_no'=>$po_no,
                                    'po_request_order_no'=>$request->request_dt_no,
                                    'po_status'=>$request->status,
                                    'po_type_pembayaran'=>$request->tipe_pembayaran,
                                    'po_total_harga'=>$total_harga,
                                    'po_diskon'=>$diskon,
                                    'po_ppn'=>$request->ppn,
                                    'po_total_bayar'=>$total_bayar
                                ]);

        $inser_purchase_order_dt = DB::table('d_purchase_order_dt')->insert([
                                        'podt_purchase'=>$po_no,
                                        'podt_no'=>$podt_no,
                                        'podt_kode_barang'=>$request->kode_barang,
                                        'podt_kode_suplier'=>$request->id_supplier,
                                        'podt_kuantitas'=>$request->kuantitas,
                                        'podt_harga_satuan'=>$harga_satuan
                                    ]);

        $update_request_order_dt = DB::table('d_request_order_dt')
                                    ->where('rdt_no', $request->request_dt_no)
                                    ->update(['rdt_status'=>$request->status]);

        return redirect('/pembelian/purchase-order')->with('flash_message_success','Data berhasil ditambahkan!');
    }

    public function get_purchase_order($id)
    {
        $data = DB::table('d_purchase_order_dt')
                ->select('d_purchase_order_dt.*', 'd_purchase_order.*', 'd_supplier.*', 'd_request_order.ro_cabang','d_cabang.c_nama')
                ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
                ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
                ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_purchase_order_dt.podt_no', $id)->first();

        return json_encode($data);
    }

    public function edit_purchase_order(Request $request)
    {
        $data = DB::table('d_purchase_order_dt')
                ->select('d_purchase_order.*', 'd_purchase_order_dt.*', 'd_request_order.ro_cabang', 'd_supplier.s_name', 'd_cabang.c_nama')
                ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
                ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_purchase_order_dt.podt_no', $request->id)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }
        // print_r($data); die;
        return view('pembelian.purchase_order.edit_purchase_order', compact('data'));
    }

    public function update_purchase_order(Request $request)
    {
        // print_r($request->all()); die;
        $total_harga = $this->formatPrice($request->total_harga);
        $total_bayar = $this->formatPrice($request->total_bayar);
        $harga_satuan = $this->formatPrice($request->harga_satuan);
        $data = DB::table('d_purchase_order_dt')->where('podt_no', $request->podt_no);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'podt_harga_satuan'=>$harga_satuan
            ]);
            DB::table('d_purchase_order')
            ->where('po_no', $request->po_no)
            ->update([
                'po_status'=>$request->status,
                'po_type_pembayaran'=>$request->tipe_pembayaran,
                'po_total_harga'=>$total_harga,
                'po_diskon'=>$request->diskon,
                'po_ppn'=>$request->ppn,
                'po_total_bayar'=>$total_bayar
            ]);

            DB::table('d_request_order_dt')
            ->where('rdt_no', $request->request_order)
            ->update([
                'rdt_status'=>$request->status
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_edit_purchase_order(Request $request)
    {
        $data = DB::table('d_purchase_order_dt')
                ->select('d_purchase_order.*', 'd_purchase_order_dt.*', 'd_request_order.ro_cabang', 'd_supplier.s_name', 'd_cabang.c_nama')
                ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
                ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->whereIn('d_purchase_order_dt.podt_no', $request->data_check)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('pembelian.purchase_order.edit_purchase_order', compact('data'));
    }

    public function multiple_delete_purchase_order(Request $request)
    {
        for ($i = 0; $i < count($request->podt_no); $i++) {
            # code...
            // print_r($key);echo ": ";print_r($value); echo "<pre>";
            DB::table('d_purchase_order_dt')->where('podt_no', $request->podt_no[$i])->delete();
            $check_podt_no = DB::table('d_purchase_order_dt')
                        ->where('podt_no', $request->podt_no[$i])
                        ->get();
            if (count($check_podt_no) == 0) {
                $check_po = DB::table('d_purchase_order')
                        ->where('po_no', $request->podt_purchase[$i])
                        ->get();
                if (count($check_po) != 0) {
                    DB::table('d_purchase_order')->where('po_no', $request->podt_purchase[$i])->delete();
                }
                
            }
            
        }        
        
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

    public function cetak_purchase()
    {
        $data = "Null";
        $data_supplier = DB::table('d_supplier')
                        ->join('d_request_order_dt', 'd_supplier.s_id', '=', 'd_request_order_dt.rdt_supplier')
                        ->where('d_request_order_dt.rdt_status', '=', 'Menunggu')
                        ->groupBy('d_supplier.s_name')
                        ->get();
        // print_r($data_supplier);
        return view('pembelian/purchase_order/print_purchase', compact('data', 'data_supplier'));
    }

    public function get_purchase_data($id)
    {
        $data_order = DB::table('d_request_order_dt')
                        ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                        ->where('d_request_order_dt.rdt_supplier', $id)
                        ->where('d_request_order_dt.rdt_status', 'Menunggu')
                        ->get();
        $data = $id;
        $data_supplier = DB::table('d_supplier')
                        ->join('d_request_order_dt', 'd_supplier.s_id', '=', 'd_request_order_dt.rdt_supplier')
                        ->where('d_request_order_dt.rdt_status', '=', 'Menunggu')
                        ->groupBy('d_supplier.s_name')
                        ->get();

        // print_r($data_order); die;

        return view('pembelian/purchase_order/print_purchase', compact('data', 'data_supplier', 'data_order'));
    }

    public function print_purchase($id)
    {
        $data_purchase = DB::table('d_purchase_order_dt')
                        ->select('d_supplier.s_company', 'd_supplier.s_phone', 'd_supplier.s_address', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_cabang.c_nama')
                        ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
                        ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', 'd_supplier.s_id')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                        ->where('d_purchase_order_dt.podt_kode_suplier', $id)
                        ->where('d_purchase_order.po_status', 'Menunggu')
                        ->get();
        foreach ($data_purchase as $value) {
            # code...
            $sub_total_bayar = $value->po_total_bayar;

            $total_bayar_sub[] = $sub_total_bayar;
        }

        $jumlah = array_sum($total_bayar_sub);
        return view('pembelian/purchase_order/print_out', compact('data_purchase', 'jumlah', 'id'));
    }

    public function viewpdf_purchase($id)
    {
        $data_purchase = DB::table('d_purchase_order_dt')
                        ->select('d_supplier.s_company', 'd_supplier.s_phone', 'd_supplier.s_address', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_cabang.c_nama')
                        ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
                        ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', 'd_supplier.s_id')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                        ->where('d_purchase_order_dt.podt_kode_suplier', $id)
                        ->where('d_purchase_order.po_status', 'Menunggu')
                        ->get();

        foreach ($data_purchase as $value) {
            # code...
            $sub_total_bayar = $value->po_total_bayar;

            $total_bayar_sub[] = $sub_total_bayar;
        }

        $jumlah = array_sum($total_bayar_sub);
        // print_r(array_sum($total_bayar_sub)); die;

        return view('pembelian/purchase_order/pdf', compact('data_purchase', 'jumlah', 'id'));
        // $pdf = PDF::loadView('pembelian/purchase_order/pdf', compact('data_purchase', 'jumlah'));
        // return $pdf->stream();
    }

    public function pdf_purchase($id)
    {
        $data_purchase = DB::table('d_purchase_order_dt')
                        ->select('d_supplier.s_company', 'd_supplier.s_phone', 'd_supplier.s_address', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_cabang.c_nama')
                        ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
                        ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', 'd_supplier.s_id')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                        ->where('d_purchase_order_dt.podt_kode_suplier', $id)
                        ->where('d_purchase_order.po_status', 'Menunggu')
                        ->get();

        foreach ($data_purchase as $value) {
            # code...
            $sub_total_bayar = $value->po_total_bayar;

            $total_bayar_sub[] = $sub_total_bayar;
        }

        $jumlah = array_sum($total_bayar_sub);
        // print_r(array_sum($total_bayar_sub)); die;

        // return view('pembelian/purchase_order/pdf', compact('data_purchase'));
        $pdf = PDF::loadView('pembelian/purchase_order/newpdf', compact('data_purchase', 'jumlah'));
        return $pdf->stream();
    }

    public function refund()
    {
    	return view('pembelian/refund/refund');
    } 

    // -------------request order-------------------

    public function request_order()
    {
        return view('pembelian/request_order/view_request_order');
    }

    public function request_order_tambah(){
        return view('pembelian/request_order/tambah_request_order');
    }

    public function menunggu(){
        $waiting  = DB::table('purchase_req')
                ->select('purchase_req.id_purchaseReq','m_company.c_name','d_mem.m_name','d_item.i_nama','purchase_req.qtyReq','purchase_req.status')
                ->join('d_item','purchase_req.item_id','=','d_item.i_id')
                ->join('d_mem','purchase_req.idComp','=','d_mem.m_id')
                ->join('m_company','d_mem.m_comp','=','m_company.c_id')
                ->where('purchase_req.status','WAITING')
                ->get();
        $waiting = collect($waiting);

        return DataTables::of($waiting)
            ->addColumn('status', function ($waiting) {

                return "<span class='label label-danger'>WAITING...</span>";

            })

            ->addColumn('aksi', function ($waiting) {
                return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$waiting->id_purchaseReq. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $waiting->id_purchaseReq . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $waiting->id_purchaseReq . '\', \'' .$waiting->id_purchaseReq. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                // if (Plasma::checkAkses(49, 'update') == false) {
                //     return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$waiting->id_purchaseReq. '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                // } else {
                //     return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$waiting->id_purchaseReq. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $waiting->id_purchaseReq . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $waiting->id_purchaseReq . '\', \'' .$waiting->id_purchaseReq. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                // }
            })
            ->rawColumns(['status','aksi'])
            ->make(true);
    }

    public function all(){
        $all  = DB::table('purchase_req')
                ->select('purchase_req.id_purchaseReq','m_company.c_name','d_mem.m_name','d_item.i_nama','purchase_req.qtyReq','purchase_req.status')
                ->join('d_item','purchase_req.item_id','=','d_item.i_id')
                ->join('d_mem','purchase_req.idComp','=','d_mem.m_id')
                ->join('m_company','d_mem.m_comp','=','m_company.c_id')
                ->where('purchase_req.status','PROSES')
                ->get();
        $all = collect($all);

        return DataTables::of($all)
            ->addColumn('aksi', function ($all) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$all->id_purchaseReq. '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$all->id_purchaseReq. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $all->id_purchaseReq . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $all->id_purchaseReq . '\', \'' .$all->id_purchaseReq. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function tampilData(Request $request)
    {

        $list  = DB::table('purchase_req')
                ->select('purchase_req.id_purchaseReq','m_company.c_name','d_mem.m_name','purchase_req.item_id','purchase_req.qtyReq','purchase_req.status')
                ->join('d_mem','purchase_req.idComp','=','d_mem.m_id')
                ->join('m_company','d_mem.m_comp','=','m_company.c_id')
                ->where('purchase_req.status','WAITING')
                ->get();
                
                $data = array();
                foreach ($list as $hasil) {
                   $row = array();
                    $row[] = $hasil->id_purchaseReq;
                    $row[] = $hasil->c_name;
                    $row[] = $hasil->item_id;
                    $row[] = $hasil->qtyReq;
                    if ($hasil->status == 'WAITING') {
                        $row[] = "<span class='label label-danger'>WAITING...</span>";
                    }
                    else if ($hasil->status == 'CONFIRMED') {
                        $row[] = "<span class='label label-warning'>SUBMITTED...</span>";
                    }
                   $data[] = $row;
               }
                echo json_encode(array("data"=>$data));
    }

    public function form_add_request()
    {
        return view('pembelian/request_order/tambah_request_order');
    }

    public function getOutlet(){

        $comp = Auth::user()->m_id;

        $query = DB::table('m_company')
                ->select('m_company.c_name')
                ->join('d_mem', 'm_company.c_id', '=', 'd_mem.m_comp')
                ->where('d_mem.m_id', $comp)->get();

            foreach ($query as $row) {
                $outlet = $row->c_name;
            }

            $data = array(
                "C_NAME"=>$outlet,
            );

        echo json_encode($data);



    }

    public function getKelompok_item(){
        $data  = DB::table('d_item')
        ->select('d_item.i_kelompok')
        ->groupBy('d_item.i_kelompok')
        ->get();
        echo json_encode($data);
    }

    public function getMerk(Request $request){
        $kelompok = $request->input('kelompok');

        $data  = DB::table('d_item')
        ->select('d_item.i_id','d_item.i_merk')
        ->where('d_item.i_kelompok',$kelompok)
        ->groupBy('d_item.i_merk')
        ->get();

        echo json_encode($data);
    }

    public function getBarang(Request $req){
        $kelompok = $req->input('merk');

        $data  = DB::table('d_item')
        ->select('d_item.i_id','d_item.i_nama')
        ->where('d_item.i_id',$kelompok)
        ->get();

        echo json_encode($data);
    }

    public function showItem(Request $request){
        $i_id = $request->input('item_id');

        $data =  DB::table('d_item')
        ->select('d_item.i_merk','d_item.i_nama')
        ->where('d_item.i_id',$i_id)
        ->get();

        echo json_encode($data);
    }

    public function simpanRequest(Request $request)
    {
        
        $comp = Auth::user()->m_id;
        $item = $request->input('i_item');
        $qty = $request->input('i_qty');
        $dateReq = Carbon::now('Asia/Jakarta');
        $status = 'WAITING';
       

       

         $insert =DB::table('purchase_req')->insert([
                
	    		'idComp'                     => $comp,
                'item_id'                    => $item,
                'qtyReq'                     => $qty,
                'dateRequest'                => $dateReq,
                'status'                     => $status,
                
            ]);
            
        if($insert){
            $status ="SUKSES";
        }else{
            $status ="GAGAL";
        }

        echo json_encode($status);
        
    }

    public function request_order_add(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();

            // print_r($data); die;

            $ro_no = $this->generate_code('d_request_order', 'ro_no', 4, 'RO'.date('ymd'));
            // $rdt_no = date('HmsYmd').'1';

            $sql = DB::table('d_request_order')->insert([
                        'ro_no'=>$ro_no,
                        'ro_cabang'=>$data['ro_cabang']
                    ]);
            
            $no = 1;
            foreach ($data['kode_barang'] as $key => $value) {
                $rdt_no = $this->generate_code('d_request_order_dt', 'rdt_no', 4, 'RODT'.date('dmy'));
                if (!empty($value)) {

                    // $check_rdtno = DB::table('d_request_order_dt')->where('rdt_no', $rdt_no)->count();

                    // if ($check_rdtno > 0) {
                    //     $rdt_no = date('HmsYmd').$no;
                    // }
                    
                    $sql2 = DB::table('d_request_order_dt')->insert([
                        'rdt_request'=>$ro_no,
                        'rdt_no'=>$rdt_no,
                        'rdt_kode_barang'=>$data['kode_barang'][$key],
                        'rdt_kuantitas'=>$data['kuantitas'][$key],
                        'rdt_kuantitas_approv'=>'0',
                        'rdt_status'=>'Pending',
                        'rdt_supplier'=>"0"
                    ]);
                }
                $no++;
            }

            return redirect('/pembelian/request-order')->with('flash_message_success','Data berhasil ditambahkan!');
        }
        $data_outlet = DB::table('d_cabang')->get();
        return view('pembelian/request_order/tambah_request_order', compact('data_outlet'));
    }

    public function edit_order(Request $request)
    {
        // $data = order::where('rdt_no', $request->id)->get();
        $data = DB::table('d_request_order_dt')
                ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_request_order_dt.rdt_no', $request->id)->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('pembelian.request_order.edit_request_order', compact('data'));
    }

    public function edit_multiple(Request $request)
    {
        $data = DB::table('d_request_order_dt')
                ->select('d_request_order.ro_no', 'd_request_order.ro_cabang', 'd_request_order_dt.rdt_request', 'd_request_order_dt.rdt_no', 'd_request_order_dt.rdt_kode_barang', 'd_request_order_dt.rdt_kuantitas', 'd_request_order_dt.rdt_kuantitas_approv', 'd_cabang.*')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->whereIn('d_request_order_dt.rdt_no', $request->data_check)->get();
        return view('pembelian.request_order.edit_request_order', compact('data'));
    }

    public function get_order($id)
    {
        // $data = order::find($id);
        $data = DB::table('d_request_order_dt')
                        ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
                        ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                        ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
                        ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_request_order_dt.rdt_no', $id)->first();

        return json_encode($data);
    }

    public function update_order(Request $request)
    {
        // return json_encode($request->all());

        $data = DB::table('d_request_order_dt')->where('rdt_no', $request->rdt_request_no);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'rdt_kode_barang'   => $request->kode_barang,
                'rdt_kuantitas'     => $request->kuantitas
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_delete_order(Request $request)
    {

        // print_r($request); die;

        for ($i = 0; $i < count($request->rdt_request); $i++) {
            # code...
            // print_r($key);echo ": ";print_r($value); echo "<pre>";
            DB::table('d_request_order_dt')->where('rdt_no', $request->rdt_no[$i])->delete();
            $check_rdt_req = DB::table('d_request_order_dt')
                        ->where('rdt_request', $request->rdt_request[$i])
                        ->get();
            if (count($check_rdt_req) == 0) {
                $check_ro = DB::table('d_request_order')
                        ->where('ro_no', $request->rdt_request[$i])
                        ->get();
                if (count($check_ro) != 0) {
                    DB::table('d_request_order')->where('ro_no', $request->rdt_request[$i])->delete();
                }
                
            }
            
        }        
        
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

    public function request_order_status(Request $request)
    {
        $data = $request->all();

        // echo json_encode($data); die;

        if ($data['status'] == "Pending") {
            $check_data = DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->get();
            if (count($check_data) > 0) {
                $getData = DB::table('d_rencana_pembelian')
                            ->where('no_rdt',$data['rdt_no'])
                            ->first();
                DB::table('d_rencana_pembelian_dt')
                    ->where('rpdt_rencana',$getData->rp_no)
                    ->delete();
                DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->delete();
            }
            $sql = DB::table('d_request_order_dt')
                    ->where('rdt_request',$data['rdt_request'])
                    ->where('rdt_no',$data['rdt_no'])
                    ->update([
                'rdt_status'=>""
            ]);
            if ($sql) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "'.$data['rdt_no'].'" berhasil diubah ke "Pending".');
                $response = [
                    'status'    => 'pending',
                    'content'   => null
                ];
                return json_encode($response);
            }else{
                return redirect()->back()->with('flash_message_error','Gagal merubah status order barang!!!');
            }
        } else if ($data['status'] == "Dibatalkan") {
            
            $check_data = DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->get();
            if (count($check_data) > 0) {
                $getData = DB::table('d_rencana_pembelian')
                            ->where('no_rdt',$data['rdt_no'])
                            ->first();
                DB::table('d_rencana_pembelian_dt')
                    ->where('rpdt_rencana',$getData->rp_no)
                    ->delete();
                DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->delete();
            }
            $sql = DB::table('d_request_order_dt')
                    ->where('rdt_request',$data['rdt_request'])
                    ->where('rdt_no',$data['rdt_no'])
                    ->update([
                'rdt_status'=>$data['status']
            ]);
            if ($sql) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "'.$data['rdt_no'].'" berhasil diubah ke "Dibatalkan".');
                $response = [
                    'status'    => 'dibatalkan',
                    'content'   => null
                ];
                return json_encode($response);
            }else{
                return redirect()->back()->with('flash_message_error','Gagal merubah status order barang!!!');
            }
        } else if ($data['status'] == "Ditunda") {
            $check_data = DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->get();
            if (count($check_data) > 0) {
                $getData = DB::table('d_rencana_pembelian')
                            ->where('no_rdt',$data['rdt_no'])
                            ->first();
                DB::table('d_rencana_pembelian_dt')
                    ->where('rpdt_rencana',$getData->rp_no)
                    ->delete();
                DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->delete();
            }
            $sql = DB::table('d_request_order_dt')
                    ->where('rdt_request',$data['rdt_request'])
                    ->where('rdt_no',$data['rdt_no'])
                    ->update([
                'rdt_status'=>$data['status']
            ]);
            if ($sql) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "'.$data['rdt_no'].'" berhasil diubah ke "Ditunda".');
                $response = [
                    'status'    => 'ditunda',
                    'content'   => null
                ];
                return json_encode($response);
            }else{
                return redirect()->back()->with('flash_message_error','Gagal merubah status order barang!!!');
            }
        } else {
            $check = DB::table('d_rencana_pembelian')->get();
            $no_rp = date('Ymd').count($check)+1;

            $check_dt = DB::table('d_rencana_pembelian_dt')->get();
            $no_rpdt = date('dmY').count($check_dt)+1;

            $sql1 = DB::table('d_request_order_dt')
                    ->where('rdt_request',$data['rdt_request'])
                    ->where('rdt_no',$data['rdt_no'])
                    ->update([
                'rdt_status'=>$data['status']
            ]);

            // $sql2 = DB::table('d_rencana_pembelian')->insert([
            //     'rp_no'=>$no_rp,
            //     'no_rdt'=>$data['rdt_no']
            // ]);

            // $sql3 = DB::table('d_rencana_pembelian_dt')->insert([
            //     'rpdt_rencana'=>$no_rp,
            //     'rpdt_no'=>$no_rpdt,
            //     'rpdt_kode_barang'=>$data['kode_barang'],
            //     'rpdt_qty'=>$data['kuantitas'],
            //     'rpdt_kuantitas_approv'=>$data['kuantitas_approv']
            // ]);

            if ($sql1) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "'.$data['rdt_no'].'" berhasil diubah ke "Rencana Pembelian".');
                $response = [
                    'status'    => 'rencana pembelian',
                    'content'   => null
                ];
                return json_encode($response);
            }else{
                return redirect()->back()->with('flash_message_error','Status order barang gagal diubah!!');
            }
        }

    }

    // ----Bagian rencana Pembelian -----

    public function rencana_pembelian()
    {
        
    	return view('pembelian/rencana_pembelian/index');
    }

    public function rencanaMenunggu(){

    }

    public function rencanaDisetujui(){
        
    }

    public function rencanaDitolak(){
        
    }

    public function rencanaSemua(){
        
    }

    public function addRencana()
    {
        return view('pembelian/rencana_pembelian/add');
    }

    public function getItem(Request $request)
    {
        $key = $request->term;
        $nama = DB::table('d_item')
            ->select('i_id', 'i_nama')
            ->where(function ($q) use ($key){
                $q->orWhere('i_nama', 'like', '%'.$key.'%');
                $q->orWhere('i_code', 'like', '%'.$key.'%');
                $q->orWhere('i_kelompok', 'like', '%'.$key.'%');
                $q->orWhere('i_group', 'like', '%'.$key.'%');
                $q->orWhere('i_sub_group', 'like', '%'.$key.'%');
                $q->orWhere('i_merk', 'like', '%'.$key.'%');
            })
            ->groupBy('i_id')
            ->get();

        if ($nama == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->i_id, 'label' => $query->i_nama ];
            }
        }
        return Response::json($results);
    }

    public function multiple_edit_rencana_pembelian(Request $request)
    {
        // print_r($request->all()); die;
        $data = DB::table('d_request_order_dt')
                ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->whereIn('d_request_order_dt.rdt_no', $request->data_check)->get();
        $data_supplier = DB::table('d_supplier')->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('pembelian.rencana_pembelian.edit_rencana_pembelian', compact('data','data_supplier'));
    }

    public function rencana_pembelian_edit(Request $request)
    {
        $data = DB::table('d_request_order_dt')
                ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_request_order_dt.rdt_no', $request->id)->get();
        $data_supplier = DB::table('d_supplier')->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('pembelian.rencana_pembelian.edit_rencana_pembelian', compact('data','data_supplier'));
    }

    public function update_rencana_pembelian(Request $request)
    {
        // return json_encode($request->all());
        // print_r($request->all()); die;

        $data = DB::table('d_request_order_dt')->where('rdt_no', $request->rdt_request_no);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'rdt_kuantitas_approv'     => $request->kuantitas_approv,
                'rdt_supplier' => $request->supplier
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function coba_print()
    {
        $pdf = PDF::loadView('pembelian.coba_cetak');
        return $pdf->stream();
        // return $pdf->download('footballerdetail.pdf');
    }

    public function new_print()
    {
        return view('pembelian.konfirmasi_pembelian.newprint');
    }
    
}
