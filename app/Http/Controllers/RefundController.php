<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;

class RefundController extends Controller
{
    public function index()
    {
        return view('pembelian.refund.index');
    }

    public function add()
    {
        $supplier = DB::table('d_supplier')
            ->join('d_purchase', 'p_supplier', '=', 's_id')
            ->orderBy('s_name')
            ->get();

        return view('pembelian.refund.add', compact('supplier'));
    }

    public function getItemRefund(Request $request)
    {
        $keyword = $request->term;
        $data = DB::table('d_stock')
            ->join('d_item', 's_item', '=', 'i_id')
            ->select(DB::raw('upper(i_nama) as i_nama'), 'i_id', 's_id', 'i_code')
            ->where(function ($q) use ($keyword){
                $q->orWhere('i_nama', 'like', '%'.$keyword.'%');
                $q->orWhere('i_code', 'like', '%'.$keyword.'%');
            })
            ->groupBy('s_item')
            ->get();

        $hasil = [];
        if (count($data) == 0) {
            $hasil[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($data as $query) {
                if ($query->i_code == '' || $query->i_code == null){
                    $hasil[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_nama
                    ];
                }
                else {
                    $hasil[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_code . ' - ' . $query->i_nama
                    ];
                }
            }
        }
        return Response::json($hasil);
    }

    public function getDataItem(Request $request)
    {
        $idItem = $request->id;
        $supplier = intval($request->supplier);
//        $data = DB::table('d_stock')
//            ->join('d_stock_dt', 'sd_stock', '=', 'd_stock.s_id')
//            ->join('d_stock_mutation', 'sm_stock', '=', 'd_stock.s_id')
//            ->join('m_company as pemilik', 'pemilik.c_id', '=', 's_comp')
//            ->join('m_company as posisi', 'posisi.c_id', '=', 's_position')
//            ->join('d_purchase', 'p_nota', '=', 'sm_nota')
//            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
//            ->select('sd_specificcode', 'sm_hpp', 'posisi.c_name as posisi', 'pemilik.c_name as pemilik', 'd_stock.s_id', 'd_supplier.s_name as supplier', 'd_supplier.s_id as id_supplier')
//            ->where('s_item', '=', $idItem)
//            ->where('p_supplier', '=', $supplier)
//            ->groupBy('sd_specificcode')
//            ->orderBy('sm_date', 'desc')
//            ->get();
        $data = DB::table('d_stock')
            ->join('d_stock_dt', 'sd_stock', '=', 'd_stock.s_id')
            ->join('d_stock_mutation', function ($q){
                $q->on('sm_stock', '=', 'sd_stock');
                $q->on('d_stock.s_id', '=', 'sd_stock');
                $q->on('sd_specificcode', '=', 'sm_specificcode');
            })
            ->join('m_company as posisi', 'posisi.c_id', '=', 's_position')
            ->join('d_purchase', 'p_nota', '=', 'sm_nota')
            ->join('d_supplier', 'd_supplier.s_id', '=', 'p_supplier')
            ->select('sd_specificcode', 'sm_hpp', 'posisi.c_name as posisi', 'd_stock.s_id', 'd_supplier.s_name as supplier', 'd_supplier.s_id as id_supplier')
            ->where('sm_detail', '=', 'PENAMBAHAN')
            ->where('sm_sisa', '=', '1')
            ->where('s_item', '=', $idItem)
            ->where('p_supplier', '=', $supplier)
            ->get();

        return Response::json($data);
    }
}
