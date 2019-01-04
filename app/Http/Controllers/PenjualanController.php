<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Response;
Use Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.penjualan-regular.index');
    }

    public function cariMember(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('m_member')
            ->where(function ($q) use ($cari){
                $q->orWhere('m_name', 'like', '%'.$cari.'%');
                $q->orWhere('m_telp', 'like', '%'.$cari.'%');
                $q->orWhere('m_id', 'like', '%'.$cari.'%');
            })->get();

        

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->m_id, 'label' => $query->m_name . ' ('.$query->m_telp.')'];
            }
        }
        return Response::json($results);
    }

    public function saveMember(Request $request)
    {
        DB::beginTransaction();
        try {
            $nama = strtoupper($request->nama);
            $nomor = $request->nomor;

            $cek = DB::table('m_member')
                ->where('m_telp', '=', $nomor)
                ->get();

            if (count($cek) > 0){
                DB::rollback();
                return response()->json([
                    'status' => 'nomor'
                ]);
            } else {
                $getId = DB::table('m_member')
                    ->max('m_id');
                DB::table('m_member')
                    ->insert([
                        'm_id' => $getId + 1,
                        'm_name' => $nama,
                        'm_telp' => $nomor
                    ]);
                DB::commit();
                return response()->json([
                    'status' => 'sukses'
                ]);
            }
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal'
            ]);
        }
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
            $outlet_user = Auth::user()->m_comp;

            $dataN = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
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
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'N')
                ->groupBy('sm_specificcode');

            $dataY = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
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
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'Y')
                ->groupBy('sm_specificcode');

            $data = $dataN->union($dataY)->get();
        } else {
            $data = DB::table('d_stock')
                ->select('i_id', 'sm_specificcode','i_specificcode', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
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
                $results[] = ['id' => $query->s_id, 'label' => $query->i_nama . $query->sd_specificcode, 'data' => $query];
            }
        }
        return Response::json($results);
    }

    public function getDetailMember($id = null)
    {
        $query = DB::table('m_member')
                    ->select('m_member.m_address', 'm_group.g_name')
                    ->join('m_group', 'm_member.m_jenis', '=', 'm_group.g_id')
                    ->where('m_member.m_id', $id)
                    ->first();

        return Response::json(['jenis' => $query->g_name, 'alamat' => $query->m_address]);
    }

    public function savePenjualan(Request $request)
    {
        dd($request->all());
    }
}
