<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class DistribusiController extends Controller
{
    // Distribusi barang
    public function index_distribusi()
    {
        $purchase = DB::table('d_inventory')->where('i_status', '!=', '1')->get();
        return view('inventory.distribusi.index')->with(compact('purchase'));
    }

    public function show_purchase($id = null)
    {
        $data = DB::table('d_inventory')
                ->select('d_inventory.*', 'd_cabang.c_nama')
                ->join('d_purchase_order', 'd_inventory.i_po', '=', 'd_purchase_order.po_no')
                ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where(['d_inventory.i_po'=> $id])
                ->where(['d_inventory.i_status'=>0])
                ->get();

        $AWAL = 'BPB';
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $noUrutAkhir = DB::table('d_distribusi')->max('d_no_urut');
        if ($noUrutAkhir == null) {
            $noUrutAkhir = 0;
        }
        $no = 1;
        $no_bukti = "";
        $no_urut = $noUrutAkhir + 1;
        $tgl = sprintf("%01s", abs(date('d')));
        if($noUrutAkhir) {
            $no_bukti = sprintf("%03s", abs($noUrutAkhir + 1)). '/' . $AWAL .'/'. $tgl . '/' . $bulanRomawi[date('n')] .'/' . date('Y');
        }
        else {
            $no_bukti = sprintf("%03s", $no). '/' . $AWAL .'/'. $tgl . '/' . $bulanRomawi[date('n')] .'/' . date('Y');
        }

        if (count($data) == 0) {
            # code...
            $data = null;
        }


        $output = array($no_bukti, $data, $no_urut);
        echo json_encode($output);
    }

    public function print(Request $request)
    {
        $data = $request->all();
        // print_r($data); die;

        DB::table('d_distribusi')->insert([
            'd_no_urut' => $data['nourut'],
            'd_no_bukti'=> $data['no_bukti'],
            'd_po'      => $data['nomor_purchase'],
            'd_tgl'     => date('Y-m-d')
        ]);

        DB::table('d_inventory')->where('i_po', $data['nomor_purchase'])->update(['i_status'=>1, 'i_tgl_keluar'=>date('Y-m-d')]);

        $data_purchase = DB::table('d_inventory')
                        ->where('i_po', $data['nomor_purchase'])
                        ->get();
        $no_bukti      = $data['no_bukti'];
        $tujuan        = $data['tujuan'];
        $no_purchase   = $data['nomor_purchase'];
        $mengeluarkan  = $data['mengeluarkan'];
        $mengetahui    = $data['mengetahui'];
        return view('inventory.distribusi.print')->with(compact('data_purchase', 'no_bukti', 'tujuan', 'no_purchase', 'mengeluarkan', 'mengetahui'));
    }
    // End distribusi barang
}
