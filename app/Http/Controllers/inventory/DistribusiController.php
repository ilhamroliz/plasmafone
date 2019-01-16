<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
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
                ->where('d_stock.s_position', Auth::user()->m_comp)
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
                ->where('d_stock.s_position', Auth::user()->m_comp)
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
                ->where('d_stock.s_position', Auth::user()->m_comp)
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
                ->where('d_stock.s_position', Auth::user()->m_comp)
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
                ->where('d_stock.s_position', Auth::user()->m_comp)
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
                ->where('d_stock.s_position', Auth::user()->m_comp)
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

        if (!isset($data['idStock']) || $data['outlet'] == null) 
        { 
            return "lengkapi data";
        } else {
            $nota = GenerateCode::codeInventory('d_distribusi', 'd_nota', 9, 10, 3, 'DST');

            DB::beginTransaction();
            try {

                $arr_hpp = [];
                $outlet_user = Auth::user()->m_comp;
                $member = Auth::user()->m_id;

                $distribusiId = DB::table('d_distribusi')->insertGetId([
                                    'd_from' => Auth::user()->m_comp,
                                    'd_destination' => $data['outlet'],
                                    'd_nota' => $nota,
                                    'd_date' => Carbon::now('Asia/Jakarta'),
                                    'd_mem' => Auth::user()->m_id
                                ]);

                for ($i=0; $i < count($data['idStock']); $i++) { 
                    $get_countiddetail = DB::table('d_distribusi_dt')->where('dd_distribusi', $distribusiId)->count()+1;

                    $compitem = DB::table('d_stock')->select('s_comp', 's_position', 's_item')->where('s_id', $data['idStock'][$i])->first();

                    $namaItem = DB::table('d_stock')->select('s_comp', 's_item', 'i_nama')->where('s_id', $data['idStock'][$i])->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')->first();
                    
                    DB::table('d_distribusi_dt')->insert([
                        'dd_distribusi' => $distribusiId,
                        'dd_detailid' => $get_countiddetail,
                        'dd_comp' => $compitem->s_comp,
                        'dd_item' => $compitem->s_item,
                        'dd_qty' => $data['qtyTable'][$i],
                        'dd_qty_received' => 0,
                        'dd_qty_sisa' => $data['qtyTable'][$i],
                        'dd_status' => 'On Going'
                    ]);
                    Access::logActivity('Membuat distribusi barang ' . $namaItem->i_nama);

                    // insert d_stock
                    $sid = DB::table('d_stock')->max('s_id')+1;
                    DB::table('d_stock')->insert([
                        's_id' => $sid,
                        's_comp' => $compitem->s_comp,
                        's_position' => $data['outlet'],
                        's_item' => $compitem->s_item,
                        's_qty' => $data['qtyTable'][$i],
                        's_status' => 'On Going'
                    ]);
                            
                    $stockId = DB::table('d_stock')->select('s_id')->where([
                                    's_id' => $sid,
                                    's_comp' => $compitem->s_comp,
                                    's_position' => $data['outlet'],
                                    's_item' => $compitem->s_item,
                                    's_qty' => $data['qtyTable'][$i],
                                    's_status' => 'On Going'
                                ])->first();
                    $stockId = $stockId->s_id;

                    if ($data['kode'][$i] != null) {
                        $specificcode = $data['kode'][$i];

                        $cnt_stockid = DB::table('d_stock_dt')->where('sd_stock', $stockId)->count()+1;

                        // Insert stock_dt
                        DB::table('d_stock_dt')->insert([
                            'sd_stock' => $stockId,
                            'sd_detailid' => $cnt_stockid,
                            'sd_specificcode' => $specificcode
                        ]);
                        
                    } else {
                        $specificcode = null;
                    }

                    $count_smiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->where('sm_detail', 'PENAMBAHAN');

                    $get_smiddetail = $count_smiddetail->get();

                    foreach ($get_smiddetail as $key => $value) {

                        $get_countiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->count()+1;
                        
                        if ($get_smiddetail[$key]->sm_sisa != 0) {

                            $sm_hpp = $get_smiddetail[$key]->sm_hpp;
                            array_push($arr_hpp, $sm_hpp);

                            $sm_reff = $get_smiddetail[$key]->sm_nota;
                            
                            if ($get_smiddetail[$key]->sm_use != 0) {
                                $sm_use = $data['qtyTable'][$i] + $get_smiddetail[$key]->sm_use;
                                $sm_sisa = $get_smiddetail[$key]->sm_qty - $get_smiddetail[$key]->sm_use - $data['qtyTable'][$i];
                            } else {
                                $sm_use = $data['qtyTable'][$i] + $get_smiddetail[$key]->sm_use;
                                $sm_sisa = $get_smiddetail[$key]->sm_qty - $data['qtyTable'][$i];
                            }

                            // Insert to table d_stock_mutation
                            DB::table('d_stock_mutation')->insert([
                                'sm_stock'          => $data['idStock'][$i],
                                'sm_detailid'       => $get_countiddetail,
                                'sm_date'           => date('Y-m-d H:m:s'),
                                'sm_detail'         => 'PENGURANGAN',
                                'sm_specificcode'   => $specificcode,
                                'sm_qty'            => $data['qtyTable'][$i],
                                'sm_use'            => 0,
                                'sm_sisa'           => 0,
                                'sm_hpp'            => $sm_hpp,
                                'sm_sell'           => $data['harga'][$i],
                                'sm_nota'           => $nota,
                                'sm_reff'           => $sm_reff,
                                'sm_mem'            => $member
                            ]);

                            // Update in table d_stock_mutation
                            DB::table('d_stock_mutation')->where(['sm_stock' => $get_smiddetail[$key]->sm_stock, 'sm_detailid' =>  $get_smiddetail[$key]->sm_detailid])->update([
                                'sm_use' => $sm_use,
                                'sm_sisa' => $sm_sisa
                            ]);

                            // Update d_stock
                            DB::table('d_stock')
                            ->where('s_id', $data['idStock'][$i])
                            ->update([
                                's_qty' => $sm_sisa,
                            ]);

                        }

                    }
                }

                DB::commit();
                return response()->json([
                    'status' => 'sukses',
                    'id' => Crypt::encrypt($distribusiId)
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return "false";
            }
        }

    }

    public function struck($id = null)
    {
        $id = Crypt::decrypt($id);
        $datas = DB::table('d_distribusi')
                ->select('d_distribusi.d_nota as nota', 'd_distribusi.d_date as tanggal', 'm_company.c_name as tujuan', 'd_item.i_nama as nama_barang', 'd_distribusi_dt.dd_qty as qty', 'd_mem.m_name as petugas')
                ->where('d_distribusi.d_id', $id)
                ->join('d_distribusi_dt', 'd_distribusi_dt.dd_distribusi', '=', 'd_distribusi.d_id')
                ->join('m_company', 'm_company.c_id', '=', 'd_distribusi.d_destination')
                ->join('d_mem', 'd_mem.m_id', '=', 'd_distribusi.d_mem')
                ->join('d_item', 'd_item.i_id', '=', 'd_distribusi_dt.dd_item')
                ->get();

        $from = DB::table('d_distribusi')
                ->select('m_company.c_name', 'm_company.c_address')
                ->where('d_distribusi.d_id', $id)
                ->join('m_company', 'm_company.c_id', '=', 'd_distribusi.d_from')
                ->first();
        return view('inventory.distribusi.struck')->with(compact('datas', 'from'));
    }
    
    // End distribusi barang
}
