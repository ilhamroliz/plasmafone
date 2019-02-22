<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Response;

class RefundController extends Controller
{
    public function index()
    {
        $supplier = DB::table('d_supplier')
            ->join('d_purchase', 'p_supplier', '=', 's_id')
            ->orderBy('s_name')
            ->get();
        return view('pembelian.refund.index', compact('supplier'));
    }

    public function add()
    {
        $supplier = DB::table('d_supplier')
            ->join('d_purchase', 'p_supplier', '=', 's_id')
            ->groupBy('s_id')
            ->orderBy('s_name')
            ->get();

        return view('pembelian.refund.add', compact('supplier'));
    }

    public function getItemRefund(Request $request)
    {
        $keyword = $request->term;
        $supplier = $request->supplier;
        $data = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_stock_dt', 'sd_specificcode', '=', 'pd_specificcode')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->select(DB::raw('upper(i_nama) as i_nama'), 'i_id', 'sd_stock as s_id', 'i_code')
            ->where(function ($q) use ($keyword){
                $q->orWhere('i_nama', 'like', '%'.$keyword.'%');
                $q->orWhere('i_code', 'like', '%'.$keyword.'%');
            })
            ->where('p_supplier', '=', $supplier)
            ->groupBy('i_id')
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

    public function save(Request $request)
    {
        if (!PlasmafoneController::checkAkses('6', 'insert')){
            return Response::json([
                'status' => 'gagal'
            ]);
        }
        DB::beginTransaction();
        try {
            $supplier = $request->supplier;
            $item = $request->item;
            $hargaLama = str_replace('Rp. ', '', $request->hargalama);
            $hargaLama = str_replace('.', '', $hargaLama);
            $hargaBaru = str_replace('Rp. ', '', $request->hargabaru);
            $hargaBaru = str_replace('.', '', $hargaBaru);
            $qty = $request->qty;
            $idStock = $request->id_stock;
            $kode = $request->specificcode;
            $hpp = $request->hargahpp;

            $id = DB::table('d_refund')
                ->max('r_id');
            ++$id;
            $nota = CodeGenerator::codePenambahanPoin('d_refund', 'r_nota', '8', '10', '3', 'RE');
            DB::table('d_refund')
                ->insert([
                    'r_id' => $id,
                    'r_nota' => $nota,
                    'r_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d'),
                    'r_date_approve' => null,
                    'r_supplier' => $supplier,
                    'r_status' => 'P'
                ]);

            $detail = [];
            for ($i = 0; $i < count($kode); $i++){
                $detail[$i] = [
                    'rd_refund' => $id,
                    'rd_detailid' => $i + 1,
                    'rd_item' => $item,
                    'rd_qty' => 1,
                    'rd_specificcode' => $kode[$i],
                    'rd_old_hpp' => $hpp[$i],
                    'rd_new_hpp' => $hargaBaru
                ];
            }

            DB::table('d_refund_dt')
                ->insert($detail);
            PlasmafoneController::logActivity('Pengajuan Refund dengan nota ' . $nota);
            DB::commit();
            return Response::json([
                'status' => 'sukses'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }
}
