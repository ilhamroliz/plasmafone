<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\CodeGenerator as GenerateCode;
use App\Http\Controllers\PlasmafoneController as Access;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use Response;
use DataTables;
Use Auth;
use DB;
use Session;

class DistribusiController extends Controller
{
    // Distribusi barang
    public function index()
    {
        if (Access::checkAkses(9, 'read') == false) {
            return view('errors/407');
        }
        return view('inventory.distribusi.index');
    }

    public function add()
    {
        if (Access::checkAkses(9, 'insert') == false) {

            return view('errors/407');

        }
        return view('inventory.distribusi.add');
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        dd($data);
    }

    public function getProses()
    {
        $proses = DB::table('d_distribusi')
                    ->select('d_distribusi.d_id as id', 'd_distribusi_dt.dd_detailid', 'd_distribusi.d_nota as nota', 'from.c_name as from', 'destination.c_name as destination', 'd_distribusi_dt.dd_qty_received as qty_received', DB::raw('DATE_FORMAT(d_date, "%d-%m-%Y") as tanggal'))
                    ->join('d_distribusi_dt', 'd_distribusi_dt.dd_distribusi', '=', 'd_distribusi.d_id')
                    ->join('m_company as from', 'from.c_id', '=', 'd_distribusi.d_from')
                    ->join('m_company as destination', 'destination.c_id', '=', 'd_distribusi.d_destination')
                    ->where('d_distribusi_dt.dd_status', 'On Going')
                    ->orWhere('d_distribusi_dt.dd_qty_received', '<', 'd_distribusi_dt.dd_qty')
                    ->orderBy('d_distribusi.d_date', 'desc')
                    ->groupBy('d_distribusi.d_nota');

        return DataTables::of($proses)

        ->addColumn('aksi', function ($proses) {

            if (Access::checkAkses(9, 'update') == false) {

                return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($proses->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

            } else {

                if ($proses->qty_received == 0) {
                    
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($proses->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($proses->id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Batalkan" onclick="remove(\'' . Crypt::encrypt($proses->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                    
                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($proses->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($proses->id) . '\')"><i class="glyphicon glyphicon-edit"></i></button></div>';

                }

            }

        })

        ->rawColumns(['aksi'])

        ->make(true);
    }

    public function getTerima()
    {
        $data = DB::table('d_distribusi')
                ->select('d_distribusi.d_id as id', 'd_distribusi.d_nota as nota', 'from.c_name as from', 'destination.c_name as destination', DB::raw('DATE_FORMAT(d_date, "%d-%m-%Y") as tanggal'))
                ->join('d_distribusi_dt', 'd_distribusi_dt.dd_distribusi', '=', 'd_distribusi.d_id')
                ->join('m_company as from', 'from.c_id', '=', 'd_distribusi.d_from')
                ->join('m_company as destination', 'destination.c_id', '=', 'd_distribusi.d_destination')
                ->where('d_distribusi_dt.dd_qty_received', '!=', 0)
                ->orWhere('d_distribusi_dt.dd_status', 'Received')
                ->groupBy('d_distribusi.d_nota');

        return DataTables::of($data)

        ->addColumn('aksi', function ($data) {

            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detailTerima(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

        })

        ->rawColumns(['aksi'])

        ->make(true);
    }

    public function detail($id = null)
    {
        $id = Crypt::decrypt($id);
        if (Access::checkAkses(10, 'read') == false) {

            return json_encode([
                'status' => 'Access denied'
            ]);

        } else {

            $data = DB::table('d_distribusi')
                    ->select('d_distribusi.d_id as id', 'd_distribusi.d_nota as nota', 'from.c_name as from', 'destination.c_name as destination', 'd_item.i_nama as nama_item', DB::raw('coalesce(concat(" (", dd_specificcode, ")"), "") as specificcode'), 'd_distribusi_dt.dd_qty as qty', 'd_distribusi_dt.dd_qty_received as qty_received', 'd_distribusi.d_date as tanggal', 'd_mem.m_name as by', DB::raw('DATE_FORMAT(d_distribusi.d_date, "%d-%m-%Y %H:%i:%s") as date'))
                    ->join('d_distribusi_dt', 'd_distribusi_dt.dd_distribusi', '=', 'd_distribusi.d_id')
                    ->join('m_company as from', 'from.c_id', '=', 'd_distribusi.d_from')
                    ->join('m_company as destination', 'destination.c_id', '=', 'd_distribusi.d_destination')
                    ->join('d_item', 'd_item.i_id', '=', 'd_distribusi_dt.dd_item')
                    ->join('d_mem', 'd_mem.m_id', '=', 'd_distribusi.d_mem')
                    ->where('d_distribusi.d_id', $id)
                    ->get();
            return response()->json(['status' => 'OK', 'data' => $data]);

        }
    }

    public function detailTerima($id = null)
    {
        $id = Crypt::decrypt($id);
        if (Access::checkAkses(10, 'read') == false) {

            return json_encode([
                'status' => 'Access denied'
            ]);

        } else {

            $data = DB::table('d_distribusi')
                    ->select('d_distribusi.d_id as id', 'd_distribusi.d_nota as nota', 'from.c_name as from', 'destination.c_name as destination', 'd_item.i_nama as nama_item', DB::raw('coalesce(concat(" (", dd_specificcode, ")"), "") as specificcode'), 'd_distribusi_dt.dd_qty as qty', 'd_distribusi_dt.dd_qty_received as qty_received', 'd_distribusi.d_date as tanggal', 'd_mem.m_name as by', DB::raw('DATE_FORMAT(d_distribusi.d_date, "%d-%m-%Y %H:%i:%s") as date'))
                    ->join('d_distribusi_dt', 'd_distribusi_dt.dd_distribusi', '=', 'd_distribusi.d_id')
                    ->join('m_company as from', 'from.c_id', '=', 'd_distribusi.d_from')
                    ->join('m_company as destination', 'destination.c_id', '=', 'd_distribusi.d_destination')
                    ->join('d_item', 'd_item.i_id', '=', 'd_distribusi_dt.dd_item')
                    ->join('d_mem', 'd_mem.m_id', '=', 'd_distribusi.d_mem')
                    ->where('d_distribusi.d_id', $id)
                    ->where('d_distribusi_dt.dd_qty_received', '!=', 0)
                    ->get();
            return response()->json(['status' => 'OK', 'data' => $data]);

        }
    }

    public function detailEdit($id = null)
    {
        $id = Crypt::decrypt($id);

        $comp = Auth::user()->m_comp;

        $data = DB::table('d_distribusi')
                ->select('d_distribusi.d_id as id', 'd_distribusi_dt.dd_item as idItem', 'd_distribusi_dt.dd_comp', 'd_distribusi.d_nota as nota', 'from.c_name as from',
                    'destination.c_name as destination', 'd_item.i_nama as nama_item', 'd_distribusi_dt.dd_qty as qty', 'd_distribusi_dt.dd_qty_received as qty_received',
                    'd_distribusi_dt.dd_status as status', 'd_distribusi.d_date as tanggal', 'd_mem.m_name as by',
                    DB::raw('DATE_FORMAT(d_distribusi.d_date, "%d-%m-%Y %H:%i:%s") as date'), 'd_stock_mutation.sm_specificcode')
                ->join('d_distribusi_dt', 'd_distribusi_dt.dd_distribusi', '=', 'd_distribusi.d_id')
                ->join('d_stock', function($y) use ($comp){
                    $y->on('d_distribusi_dt.dd_item', '=', 'd_stock.s_item');
                    $y->where('s_comp', '=', $comp);
                    $y->where('s_position', '=', $comp);
                })
                ->join('d_stock_mutation', function($x){
                    $x->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $x->where('d_distribusi.d_nota', '=', 'd_stock_mutation.sm_nota');
                    $x->where('d_stock_mutation.sm_detail', 'PENGURANGAN');
                })
                ->join('m_company as from', 'from.c_id', '=', 'd_distribusi.d_from')
                ->join('m_company as destination', 'destination.c_id', '=', 'd_distribusi.d_destination')
                ->join('d_item', 'd_item.i_id', '=', 'd_distribusi_dt.dd_item')
                ->join('d_mem', 'd_mem.m_id', '=', 'd_distribusi.d_mem')
                ->where('d_distribusi.d_id', $id);

        return DataTables::of($data)

        ->addColumn('aksi', function ($data) {

            if (Access::checkAkses(9, 'update') == true) {

                if ($data->status == "Received") {
                    return '<div class="text-center"><button disabled="disabled" class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="glyphicon glyphicon-edit"></i></button></div>';
                }

                return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="ubah(\'' . Crypt::encrypt($data->id) . '\', \'' . Crypt::encrypt($data->idItem) . '\', \'' . Crypt::encrypt($data->dd_comp) .'\', \'' . $data->nama_item .'\', \'' . $data->qty .'\', \'' . $data->qty_received .'\', \'' . $data->sm_specificcode .'\')"><i class="glyphicon glyphicon-edit"></i></button></div>';

            }

        })

        ->rawColumns(['aksi'])

        ->make(true);
    }

    public function detailDelete($id = null)
    {
        $id = Crypt::decrypt($id);

        $data = DB::table('d_distribusi')
                ->select('d_distribusi.d_id as id', 'd_distribusi_dt.dd_detailid as detailid', 'd_distribusi_dt.dd_item as idItem', 'd_distribusi_dt.dd_comp', 'd_distribusi.d_from', 'd_distribusi.d_destination', 'd_distribusi.d_nota as nota', 'from.c_name as from', 'destination.c_name as destination', 'd_item.i_nama as nama_item', 'd_distribusi_dt.dd_qty as qty', 'd_distribusi_dt.dd_qty_received as qty_received', 'd_distribusi_dt.dd_status as status', 'd_distribusi.d_date as tanggal', 'd_mem.m_name as by', DB::raw('DATE_FORMAT(d_distribusi.d_date, "%d-%m-%Y %H:%i:%s") as date'))
                ->join('d_distribusi_dt', 'd_distribusi_dt.dd_distribusi', '=', 'd_distribusi.d_id')
                ->join('m_company as from', 'from.c_id', '=', 'd_distribusi.d_from')
                ->join('m_company as destination', 'destination.c_id', '=', 'd_distribusi.d_destination')
                ->join('d_item', 'd_item.i_id', '=', 'd_distribusi_dt.dd_item')
                ->join('d_mem', 'd_mem.m_id', '=', 'd_distribusi.d_mem')
                ->where('d_distribusi.d_id', $id);

        return DataTables::of($data)

        ->addColumn('aksi', function ($data) {

            if (Access::checkAkses(9, 'update') == true) {

                if ($data->qty_received != 0) {
                    return '<div class="text-center"><button disabled="disabled" class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data"><i class="glyphicon glyphicon-trash"></i></button></div>';
                }

                return '<div class="text-center"><button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="remove(\'' . Crypt::encrypt($data->id) . '\', \'' . Crypt::encrypt($data->detailid) . '\', \'' . $data->nota . '\', \'' . Crypt::encrypt($data->idItem) . '\', \'' . $data->d_from . '\', \'' . $data->d_destination . '\', \'' . $data->qty . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';

            }

        })

        ->rawColumns(['aksi'])

        ->make(true);
    }

    public function hapus($id = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return "Access denied";
        }
        DB::beginTransaction();
        try {
            $getDistribusi = DB::table('d_distribusi')
                            ->where('d_id', '=', $id)
                            ->first();

            $stock_mutasi = DB::table('d_stock_mutation')
                            ->where('sm_nota', $getDistribusi->d_nota)
                            ->where('sm_detail', 'PENGURANGAN')
                            ->get();

            foreach ($stock_mutasi as $key => $mutasi) {
                //update stock mutasi
                $getMutasi = DB::table('d_stock_mutation')
                    ->where('sm_stock', $stock_mutasi[$key]->sm_stock)
                    ->where('sm_detail', 'PENAMBAHAN')
                    ->where('sm_specificcode', $stock_mutasi[$key]->sm_specificcode)
                    ->where('sm_nota', $stock_mutasi[$key]->sm_reff)
                    ->first();

                DB::table('d_stock_mutation')
                    ->where('sm_stock', $stock_mutasi[$key]->sm_stock)
                    ->where('sm_detail', 'PENAMBAHAN')
                    ->where('sm_specificcode', $stock_mutasi[$key]->sm_specificcode)
                    ->where('sm_nota', $stock_mutasi[$key]->sm_reff)
                    ->update([
                        'sm_sisa'   => $getMutasi->sm_sisa + $stock_mutasi[$key]->sm_qty,
                        'sm_use'    => $getMutasi->use - $stock_mutasi[$key]->sm_qty
                    ]);

                if ($stock_mutasi[$key]->sm_specificcode != null) {
                    // insert d_stock_dt
                    $detailStockdt = DB::table('d_stock_dt')
                                    ->where('sd_stock', $stock_mutasi[$key]->sm_stock)
                                    ->max('sd_detailid');

                    if ($detailStockdt == null) {
                        $detailStockdt = 1;
                    } else {
                        $detailStockdt = $detailStockdt + 1;
                    }

                    DB::table('d_stock_dt')
                        ->insert([
                            'sd_stock' => $stock_mutasi[$key]->sm_stock,
                            'sd_detailid' => $detailStockdt,
                            'sd_specificcode' => $stock_mutasi[$key]->sm_specificcode
                        ]);
                }

                //update d_stock
                $getStock = DB::table('d_stock')
                            ->where('s_id', $stock_mutasi[$key]->sm_stock)
                            ->first();

                DB::table('d_stock')
                    ->where('s_id', $stock_mutasi[$key]->sm_stock)
                    ->update([
                        's_qty' => $getStock->s_qty + $stock_mutasi[$key]->sm_qty
                    ]);

                //delete stock mutasi
//                DB::table('d_stock_mutation')
//                    ->where('sm_stock')
//                    ->where('sm_detailid')
//                    ->where('sm_detail')
            }

            DB::commit();
            return "true";
        } catch (\Exception $e) {
            DB::rollback();
            return "false => ".$e;
        }
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
            ->where('c_id', '!=', Auth::user()->m_comp)
            ->get();

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
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q){
                    $q->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                })
                ->leftJoin('d_stock_dt', function ($a){
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_item.i_specificcode', '=', 'N')
                ->where('d_stock.s_position', Auth::user()->m_comp)
                ->groupBy('d_stock_mutation.sm_specificcode');

            $dataY = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                    $q->whereNotIn('d_stock_mutation.sm_specificcode', $kode);
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                    $a->on('d_stock_mutation.sm_specificcode', '=', 'd_stock_dt.sd_specificcode');
                    $a->whereNotIn('d_stock_dt.sd_specificcode', $kode);
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_item.i_specificcode', '=', 'Y')
                ->where('d_stock.s_position', Auth::user()->m_comp)
                ->groupBy('d_stock_mutation.sm_specificcode');

            $data = $dataN->union($dataY)->get();
        } else {
            $data = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q){
                    $q->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                })
                ->leftJoin('d_stock_dt', function ($a) {
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                    $a->on('d_stock_dt.sd_specificcode', '=', 'd_stock_mutation.sm_specificcode');
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_stock.s_position', Auth::user()->m_comp)
                ->groupBy('d_stock_mutation.sm_specificcode')
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
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q){
                    $q->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                })
                ->leftJoin('d_stock_dt', function ($a){
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_item.i_specificcode', '=', 'N')
                ->where('d_stock.s_position', Auth::user()->m_comp)
                ->groupBy('d_stock_mutation.sm_specificcode');

            $dataY = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                    $q->whereNotIn('d_stock_mutation.sm_specificcode', $kode);
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                    $a->on('d_stock_mutation.sm_specificcode', '=', 'd_stock_dt.sd_specificcode');
                    $a->whereNotIn('d_stock_dt.sd_specificcode', $kode);
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_item.i_specificcode', '=', 'Y')
                ->where('d_stock.s_position', Auth::user()->m_comp)
                ->groupBy('d_stock_mutation.sm_specificcode');

            $data = $dataN->union($dataY)->get();
        } else {
            $data = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q){
                    $q->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                })
                ->leftJoin('d_stock_dt', function ($a) {
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                    $a->on('d_stock_dt.sd_specificcode', '=', 'd_stock_mutation.sm_specificcode');
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_stock.s_position', Auth::user()->m_comp)
                ->groupBy('d_stock_mutation.sm_specificcode')
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

                // insert distribusi
                $distribusiId = DB::table('d_distribusi')->insertGetId([
                                    'd_from' => Auth::user()->m_comp,
                                    'd_destination' => $data['outlet'],
                                    'd_nota' => $nota,
                                    'd_date' => Carbon::now('Asia/Jakarta'),
                                    'd_mem' => Auth::user()->m_id
                                ]);

                for ($i=0; $i < count($data['idStock']); $i++) { 
                    $get_countiddetail = DB::table('d_distribusi_dt')->where('dd_distribusi', $distribusiId)->max('dd_detailid');

                    if ($get_countiddetail == null || $get_countiddetail == "") {
                        $get_countiddetail = 1;
                    } else {
                        $get_countiddetail = $get_countiddetail + 1;
                    }

                    $compitem = DB::table('d_stock')->select('s_comp', 's_position', 's_item')->where('s_id', $data['idStock'][$i])->first();

                    $namaItem = DB::table('d_stock')->select('s_comp', 's_item', 'i_nama')->where('s_id', $data['idStock'][$i])->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')->first();
                    
                    // insert distribusi_dt
                    DB::table('d_distribusi_dt')->insert([
                        'dd_distribusi' => $distribusiId,
                        'dd_detailid' => $get_countiddetail,
                        'dd_comp' => $compitem->s_position,
                        'dd_item' => $compitem->s_item,
                        'dd_specificcode' => $data['kode'][$i],
                        'dd_qty' => $data['qtyTable'][$i],
                        'dd_qty_received' => 0,
                        'dd_qty_sisa' => $data['qtyTable'][$i],
                        'dd_status' => 'On Going'
                    ]);
                    Access::logActivity('Membuat distribusi barang ' . $namaItem->i_nama);

                    // insert d_stock
                    $sid = DB::table('d_stock')->max('s_id');
                    if ($sid == null){
                        $sid = 1;
                    } else {
                        $sid = $sid + 1;
                    }

                    // insert d_stock
                    DB::table('d_stock')->insert([
                        's_id' => $sid,
                        's_comp' => $compitem->s_comp,
                        's_position' => $data['outlet'],
                        's_item' => $compitem->s_item,
                        's_qty' => $data['qtyTable'][$i],
                        's_status' => 'On Going'
                    ]);

                    if ($data['kode'][$i] != null) {
                        $specificcode = $data['kode'][$i];

                        // Delete specificcode
                        DB::table('d_stock_dt')->where('sd_stock', $data['idStock'][$i])->where('sd_specificcode', $specificcode)->delete();
                        
                    } else {
                        $specificcode = null;
                    }

                    $get_smiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->where('sm_detail', 'PENAMBAHAN')->get();

                    foreach ($get_smiddetail as $key => $value) {

                        $get_countiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->max('sm_detailid');

                        if ($get_countiddetail == null || $get_countiddetail == "") {
                            $get_countiddetail = 1;
                        } else {
                            $get_countiddetail = $get_countiddetail + 1;
                        }
                        
                        if ($get_smiddetail[$key]->sm_sisa != 0) {

                            $sm_hpp = $get_smiddetail[$key]->sm_hpp;
                            $sm_sell = $get_smiddetail[$key]->sm_sell;
                            array_push($arr_hpp, $sm_hpp);

                            $sm_reff = $get_smiddetail[$key]->sm_nota;
                            
                            if ($get_smiddetail[$key]->sm_use != 0) {
                                $sm_use = $get_smiddetail[$key]->sm_use + $data['qtyTable'][$i];
                                $sm_sisa = $get_smiddetail[$key]->sm_qty - $get_smiddetail[$key]->sm_use - $data['qtyTable'][$i];
                            } else {
                                $sm_use = $get_smiddetail[$key]->sm_use + $data['qtyTable'][$i];
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
                                'sm_sell'           => $sm_sell,
                                'sm_nota'           => $nota,
                                'sm_reff'           => $sm_reff,
                                'sm_mem'            => $member
                            ]);

                            // Update in table d_stock_mutation
                            DB::table('d_stock_mutation')->where(['sm_stock' => $get_smiddetail[$key]->sm_stock, 'sm_detailid' =>  $get_smiddetail[$key]->sm_detailid])->update([
                                'sm_use' => $sm_use,
                                'sm_sisa' => $sm_sisa
                            ]);

                            //                    update d_stock
                            $stockQty = DB::table('d_stock')->where('s_id', $data['idStock'][$i])->first();

                            DB::table('d_stock')->where('s_id', $data['idStock'][$i])->update([
                                's_qty' => $stockQty->s_qty - $data['qtyTable'][$i]
                            ]);
                            break;
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
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $datas = DB::table('d_distribusi')
                ->select('d_distribusi.d_nota as nota', 'd_distribusi.d_date as tanggal', 'm_company.c_name as tujuan', 'd_item.i_nama as nama_barang', DB::raw('coalesce(concat(" (", dd_specificcode, ")"), "") as specificcode'), 'd_distribusi_dt.dd_qty as qty', 'd_mem.m_name as petugas')
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

        if ($datas == null) {
            return view('errors/404');
        }

        return view('inventory.distribusi.struck')->with(compact('datas', 'from'));
    }
    
    // End distribusi barang
}
