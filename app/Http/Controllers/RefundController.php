<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;

class RefundController extends Controller
{
    public function index()
    {
        $supplier = DB::table('d_supplier')->orderBy('s_name')->get();
        return view('pembelian.refund.index', compact('supplier'));
    }

    public function add()
    {
        return view('pembelian.refund.add');
    }

    public function getItemRefund(Request $request)
    {
        $keyword = $request->term;
        $data = DB::table('d_stock')
            ->join('d_item', 's_item', '=', 'i_id')
            ->join('m_company as pemilik', 'pemilik.c_id', '=', 's_comp')
            ->join('m_company as posisi', 'posisi.c_id', '=', 's_position')
            ->select(DB::raw('upper(i_nama) as i_nama'), 'i_id', 'pemilik.c_name as pemilik', 's_id', 'posisi.c_name as posisi', 'i_code')
            ->where(function ($q) use ($keyword){
                $q->orWhere('i_nama', 'like', '%'.$keyword.'%');
                $q->orWhere('i_code', 'like', '%'.$keyword.'%');
            })
            ->get();

        $hasil = [];
        if (count($data) == 0) {
            $hasil[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($data as $query) {
                if ($query->i_code == '' || $query->i_code == null){
                    $hasil[] = [
                        'id' => $query->s_id,
                        'label' => $query->i_nama
                    ];
                }
                else {
                    $hasil[] = [
                        'id' => $query->s_id,
                        'label' => $query->i_code . ' - ' . $query->i_nama
                    ];
                }
            }
        }
        return Response::json($hasil);
    }
}
