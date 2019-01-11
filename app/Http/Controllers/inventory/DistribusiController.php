<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CodeGenerator as GenerateCode;
use App\Http\Controllers\PlasmafoneController as Access;
use Carbon\Carbon;
use Response;
Use Auth;
use DB;
use Session;

class DistribusiController extends Controller
{
    // Distribusi barang
    public function index()
    {
        return view('inventory.distribusi.index');
    }

    public function cariOutlet(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('m_company')
            ->where(function ($q) use ($cari){
                $q->orWhere('c_name', 'like', '%'.$cari.'%');
                $q->orWhere('c_id', 'like', '%'.$cari.'%');
            })
            ->where('c_id', '!=', Auth::user()->m_comp)->get();

        

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->c_id, 'label' => $query->c_name . ' ('.$query->c_tlp.')', 'nama' => $query->c_name, 'telp' => $query->c_tlp, 'alamat' => $query->c_address];
            }
        }
        return Response::json($results);
    }

    public function cariStock(Request $request)
    {
        
        $cari = $request->term;
        $kode = [];
        if (isset($request->kode)){
            $kode = $request->kode;
            if (($key = array_search(null, $kode)) !== false) {
                unset($kode[$key]);
            }
            $temp = [];
            foreach ($kode as $code){
                array_push($temp, $code);
            }
            $kode = $temp;
        }
        if (count($kode) > 0){

            $dataN = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('sd_stock', '=', 's_id');
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'N')
                ->groupBy('sm_specificcode');

            $dataY = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                    $q->whereNotIn('sm_specificcode', $kode);
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('sd_stock', '=', 's_id');
                    $a->on('sm_specificcode', '=', 'sd_specificcode');
                    $a->whereNotIn('sd_specificcode', $kode);
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'Y')
                ->groupBy('sm_specificcode');

            $data = $dataN->union($dataY)->get();
        } else {
            $data = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                })
                ->leftJoin('d_stock_dt', function ($a) {
                    $a->on('sd_stock', '=', 's_id');
                    $a->on('sd_specificcode', '=', 'sm_specificcode');
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->groupBy('sm_specificcode')
                ->get();
        }

        $results = [];
        if (count($data) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($data as $query) {
                if($query->i_code == "") {
                    $results[] = ['id' => $query->s_id, 'label' => $query->i_nama . $query->sd_specificcode, 'data' => $query];
                } else {
                    $results[] = ['id' => $query->s_id, 'label' => $query->i_code. ' - ' . $query->i_nama . $query->sd_specificcode, 'data' => $query];
                }
                
            }
        }
        return Response::json($results);
    }

    public function searchStock(Request $request)
    {
        $cari = $request->term;
        $kode = [];
        if (isset($request->kode)){
            $kode = $request->kode;
            if (($key = array_search(null, $kode)) !== false) {
                unset($kode[$key]);
            }
            $temp = [];
            foreach ($kode as $code){
                array_push($temp, $code);
            }
            $kode = $temp;
        }
        if (count($kode) > 0){

            $dataN = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('sd_stock', '=', 's_id');
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'N')
                ->groupBy('sm_specificcode');

            $dataY = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                    $q->whereNotIn('sm_specificcode', $kode);
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('sd_stock', '=', 's_id');
                    $a->on('sm_specificcode', '=', 'sd_specificcode');
                    $a->whereNotIn('sd_specificcode', $kode);
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'Y')
                ->groupBy('sm_specificcode');

            $data = $dataN->union($dataY)->get();
        } else {
            $data = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                })
                ->leftJoin('d_stock_dt', function ($a) {
                    $a->on('sd_stock', '=', 's_id');
                    $a->on('sd_specificcode', '=', 'sm_specificcode');
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->groupBy('sm_specificcode')
                ->get();
        }
        $results = [];
        if (count($data) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($data as $query) {
                $results[] = ['id' => $query->s_id, 'label' => $query->i_code. ' - ' . $query->i_nama . $query->sd_specificcode, 'data' => $query];
            }
        }
        return Response::json($results);
    }

    public function simpan(Request $request)
    {
        $data = $request->all();

        $nota = GenerateCode::codePos('d_distribusi', 'd_id', 3, 'DISTRIBUSI');

        DB::beginTransaction();
        try {
            $distribusiId = DB::table('d_distribusi')->insertGetId([
                                'd_from' => Auth::user()->m_comp,
                                'd_destination' => $data['outlet'],
                                'd_nota' => $nota,
                                'd_date' => Carbon::now('Asia/Jakarta'),
                                'd_mem' => Auth::user()->m_id,
                                'd_status' => 'On Going'
                            ]);

            for ($i=0; $i < count($data['idStock']); $i++) { 
                $get_countiddetail = DB::table('d_distribusi_dt')->where('dd_distribusi', $distribusiId)->count()+1;
                $compitem = DB::table('d_stock')->select('s_comp', 's_item')->where('s_id', $data['idStock'][$i])->first();
                $namaItem = DB::table('d_stock')->select('s_comp', 's_item', 'i_nama')->where('s_id', $data['idStock'][$i])->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')->first();
                DB::table('d_distribusi_dt')->insert([
                    'dd_distribusi' => $distribusiId,
                    'dd_detailid' => $get_countiddetail,
                    'dd_comp' => $compitem->s_comp,
                    'dd_item' => $compitem->s_item,
                    'dd_qty' => $data['qtyTable'][$i]
                ]);
                Access::logActivity('Membuat distribusi barang ' . $namaItem->i_nama);
            }
            DB::commit();
           return "true";
        } catch (\Exception $e) {
            DB::rollback();
            return "false";
        }
    }
    
    // End distribusi barang
}
