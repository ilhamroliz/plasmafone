<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController as Access;
use App\Http\Controllers\CodeGenerator as GenerateCode;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use DB;
use Response;
use DataTables;
Use Auth;

class ReturnPenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.return-penjualan.index');
    }

    public function add()
    {
        return view('penjualan.return-penjualan.add');
    }

    public function getDetailReturn($id = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return json_encode('Not Found');
        }

        $datas = DB::table('d_return_penjualan')
            ->select('d_return_penjualan.rp_notareturn as nota_return',
                'd_return_penjualan.rp_status',
                'm_company.c_name as nama_outlet',
                'm_company.c_address as alamat_outlet',
                'm_member.m_name as nama_member',
                'm_member.m_telp as telp_member',
                DB::raw('DATE_FORMAT(d_return_penjualan.rp_date, "%d-%m-%Y") as tgl_return'),
                'd_return_penjualan.rp_aksi as jenis_return',
                'rpd.rpd_qty',
                'a.i_code as rpd_code',
                'rpd.rpd_specificcode',
                'a.i_nama as rpd_item',
                'rpd.rpd_note',
                'd_return_penjualan.rp_notapenjualan as nota_penjualan',
                'rpg.rpg_qty',
                'b.i_code as rpg_code',
                'rpg.rpg_specificcode',
                'b.i_nama as rpg_item')
            ->where('d_return_penjualan.rp_id', $id)
            ->join('d_return_penjualandt as rpd', 'd_return_penjualan.rp_id', '=', 'rpd.rpd_return')
            ->join('d_return_penjualanganti as rpg', 'd_return_penjualan.rp_id', '=', 'rpg.rpg_return')
            ->join('d_sales', 'd_sales.s_nota', '=', 'd_return_penjualan.rp_notapenjualan')
            ->join('m_member', 'm_member.m_id', '=', 'd_sales.s_member')
            ->join('d_item as a', 'a.i_id', '=', 'rpd.rpd_item')
            ->leftjoin('d_item as b', 'b.i_id', '=', 'rpg.rpg_item')
            ->join('m_company', function ($c){
                $c->where('c_id', '=', Auth::user()->m_comp);
            })
            ->get();

        if ($datas == null) {
            return json_encode('Not Found');
        }

        return json_encode($datas);
    }

    public function getProses()
    {
        $data = DB::table('d_return_penjualan')
            ->select('d_return_penjualan.rp_id as id', DB::raw('DATE_FORMAT(d_return_penjualan.rp_date, "%d-%m-%Y") as tanggal'),
                'd_return_penjualan.rp_notareturn as notareturn', 'm_member.m_name as pelanggan')
            ->join('d_sales', 'd_return_penjualan.rp_notapenjualan', '=', 'd_sales.s_nota')
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id')
            ->where('d_return_penjualan.rp_status', 'PROSES');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(16, 'delete') == false && Access::checkAkses(16, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Batalkan" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getDone()
    {
        $data = DB::table('d_return_penjualan')
            ->select('d_return_penjualan.rp_id as id', DB::raw('DATE_FORMAT(d_return_penjualan.rp_date, "%d-%m-%Y") as tanggal'),
                'd_return_penjualan.rp_notareturn as notareturn', 'm_member.m_name as pelanggan')
            ->join('d_sales', 'd_return_penjualan.rp_notapenjualan', '=', 'd_sales.s_nota')
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id')
            ->where('d_return_penjualan.rp_status', 'DONE');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(16, 'delete') == true && Access::checkAkses(16, 'update') == true) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Batalkan" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getCancel()
    {
        $data = DB::table('d_return_penjualan')
            ->select('d_return_penjualan.rp_id as id', DB::raw('DATE_FORMAT(d_return_penjualan.rp_date, "%d-%m-%Y") as tanggal'),
                'd_return_penjualan.rp_notareturn as notareturn', 'm_member.m_name as pelanggan')
            ->join('d_sales', 'd_return_penjualan.rp_notapenjualan', '=', 'd_sales.s_nota')
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id')
            ->where('d_return_penjualan.rp_status', 'CANCEL');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function cancelReturn($id = null)
    {
        $getMutasi = null;
        try{
            $id = Crypt::decrypt($id);
        }catch (DecryptException $r){
            return json_encode('Not Found');
        }

        DB::beginTransaction();
        try{
            $getReturn = DB::table('d_return_penjualan')->where('rp_id', $id)->first();
            //delete reff rusak
            $stockMutasiRusak = DB::table('d_stock_mutation')->where('sm_nota', $getReturn->rp_notareturn)->where('sm_detail', 'PENAMBAHAN')->where('sm_reff', 'RUSAK')->get();

            foreach ($stockMutasiRusak as $index => $smr) {
                if ($stockMutasiRusak[$index]->sm_specificcode != null) {
                    DB::table('d_stock_dt')->where('sd_stock', $stockMutasiRusak[$index]->sm_stock)->where('sd_specificcode', $stockMutasiRusak[$index]->sm_specificcode)->delete();
                }

                $getStock = DB::table('d_stock')
                    ->where('s_id', $stockMutasiRusak[$index]->sm_stock)
                    ->first();

                DB::table('d_stock')
                    ->where('s_id', $stockMutasiRusak[$index]->sm_stock)
                    ->update([
                        's_qty' => $getStock->s_qty - $stockMutasiRusak[$index]->sm_qty
                    ]);
            }

            //delete mutasi
            $stockMutasi = DB::table('d_stock_mutation')->where('sm_nota', $getReturn->rp_notareturn)->where('sm_detail', 'PENGURANGAN')->get();

            foreach ($stockMutasi as $index => $sm){

                $getMutasi = DB::table('d_stock_mutation')
                    ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                    ->where('sm_specificcode', $stockMutasi[$index]->sm_specificcode)
                    ->where('sm_nota', $stockMutasi[$index]->sm_reff)->first();

                if ($stockMutasi[$index]->sm_specificcode != null){
                    // update stock mutasi
                    DB::table('d_stock_mutation')
                        ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                        ->where('sm_specificcode', $stockMutasi[$index]->sm_specificcode)
                        ->where('sm_nota', $stockMutasi[$index]->sm_reff)
                        ->where('sm_detail', 'PENAMBAHAN')
                        ->update([
                            'sm_sisa' => $getMutasi->sm_sisa + $stockMutasi[$index]->sm_qty,
                            'sm_use' => $getMutasi->sm_use - $stockMutasi[$index]->sm_qty
                        ]);

                    $maxStockdt = DB::table('d_stock_dt')->where('sd_stock', $stockMutasi[$index]->sm_stock)->max('sd_detailid');

                    if ($maxStockdt == null){
                        $maxStockdt = 1;
                    } else {
                        $maxStockdt = $maxStockdt + 1;
                    }

                    // insert stock_dt
                    DB::table('d_stock_dt')->insert([
                        'sd_stock' => $stockMutasi[$index]->sm_stock,
                        'sd_detailid' => $maxStockdt,
                        'sd_specificcode' => $stockMutasi[$index]->sm_specificcode
                    ]);

                    // update dstock
                    $dstock = DB::table('d_stock')->where('s_id', $stockMutasi[$index]->sm_stock)->first();

                    DB::table('d_stock')->where('s_id', $stockMutasi[$index]->sm_stock)->update([
                        's_qty' => $dstock->s_qty + $stockMutasi[$index]->sm_qty
                    ]);

                    // delete stock mutasi
                    DB::table('d_stock_mutation')
                        ->where('sm_nota', $getReturn->rp_notareturn)
                        ->where('sm_specificcode', $stockMutasi[$index]->sm_specificcode)
                        ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                        ->where('sm_detail', 'PENGURANGAN')
                        ->delete();

                } else {
                    // update stock mutasi
                    DB::table('d_stock_mutation')
                        ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                        ->where('sm_specificcode', null)
                        ->where('sm_nota', $stockMutasi[$index]->sm_reff)
                        ->where('sm_detail', 'PENAMBAHAN')
                        ->update([
                            'sm_sisa' => $getMutasi->sm_sisa + $stockMutasi[$index]->sm_qty,
                            'sm_use' => $getMutasi->sm_use - $stockMutasi[$index]->sm_qty
                        ]);

                    // update dstock
                    $dstock = DB::table('d_stock')->where('s_id', $stockMutasi[$index]->sm_stock)->first();

                    DB::table('d_stock')->where('s_id', $stockMutasi[$index]->sm_stock)->update([
                        's_qty' => $dstock->s_qty + $stockMutasi[$index]->sm_qty
                    ]);

                    // delete stock mutasi
                    DB::table('d_stock_mutation')
                        ->where('sm_nota', $getReturn->rp_notareturn)
                        ->where('sm_specificcode', null)
                        ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                        ->where('sm_detail', 'PENGURANGAN')->delete();
                }
            }

            // delete mutasi rusak
            DB::table('d_stock_mutation')
                ->where('sm_nota', $getReturn->rp_notareturn)
                ->where('sm_detail', 'PENAMBAHAN')
                ->where('sm_reff', '=', 'RUSAK')
                ->delete();

            // update d_return_penjualan
            //edit cancel
            DB::table('d_return_penjualan')
                ->where('rp_id', $id)
                ->update([
                    'rp_status' => 'CANCEL'
                ]);

            DB::commit();
            return 'true';
        }catch (\Exception $e){
            DB::rollback();
            return 'false';
        }
    }

    public function doneReturn($id = null)
    {
        try{
            $id = Crypt::decrypt($id);
        }catch (DecryptException $r){
            return json_encode('Not Found');
        }

        DB::beginTransaction();
        try{

            // update d_return_penjualan
            DB::table('d_return_penjualan')
                ->where('rp_id', $id)
                ->update([
                    'rp_status' => 'DONE'
                ]);

            DB::commit();
            return 'true';
        }catch (\Exception $e){
            DB::rollback();
            return 'false';
        }
    }

    public function cariMember(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('d_sales')
            ->join('m_member', function ($x) use ($cari){
                $x->on('d_sales.s_member', '=', 'm_member.m_id');
                $x->where('m_member.m_name', 'like', '%'.$cari.'%');
            })
            ->get();

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->m_id, 'label' => strtoupper($query->m_name)];
            }
        }
        return Response::json($results);
    }

    public function cariKode(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('d_sales')
            ->join('d_sales_dt', function ($x) use ($cari){
                $x->on('d_sales.s_id', '=', 'd_sales_dt.sd_sales');
                $x->where('d_sales_dt.sd_specificcode', 'like', '%'.$cari.'%');
            })
            ->get();

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->s_id, 'label' => strtoupper($query->sd_specificcode)];
            }
        }
        return Response::json($results);
    }

    public function cariNota(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('d_sales')
            ->where(function ($x) use ($cari){
                $x->where('s_nota', 'like', '%'.$cari.'%');
            })
            ->get();

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->s_id, 'label' => strtoupper($query->s_nota)];
            }
        }
        return Response::json($results);
    }

    public function cariNotaPenjualan(Request $request)
    {
        $data = DB::table('d_sales')
            ->join('d_sales_dt', 'd_sales.s_id', 'd_sales_dt.sd_sales')
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id');

        if ($request->member != "") {
            $data->where('m_member.m_name', 'like', '%'.$request->member.'%');
        } else if ($request->idmember != "") {
            $data->orWhere('d_sales.s_member', $request->idmember);
        } else if ($request->kode != "") {
            $data->orWhere('d_sales_dt.sd_specificcode', $request->kode);
        } else if ($request->nota != "") {
            $data->orWhere('d_sales.s_nota', $request->nota);
        } else if ($request->tgl_awal != ""  && $request->tgl_akhir == "") {
            $data->orWhere('d_sales.s_date', Carbon::parse($request->tglAwal)->format('Y-m-d'));
        } else if ($request->tgl_awal == "" && $request->tgl_akhir != "") {
            $data->orWhere('d_sales.s_date', Carbon::parse($request->tgl_akhir)->format('Y-m-d'));
        } else if ($request->tgl_awal != "" && $request->tgl_akhir != "") {
            $data->whereBetween('d_sales.s_date', [Carbon::parse($request->tgl_awal)->format('Y-m-d'), Carbon::parse($request->tgl_akhir)->format('Y-m-d')]);
        }

        $data->groupBy('d_sales.s_nota');

        return DataTables::of($data)

            ->addColumn('tanggal', function ($data){
                return Carbon::parse($data->s_date)->format('d-m-Y');
            })

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(20, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Return Penjualan" onclick="returnPenjualan(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-transfer"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function cariNotaDetail($id = null)
    {
        if (Access::checkAkses(20, 'read') == false) {
            return json_encode(array('status' => 'Access denied'));
        }

        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return json_encode(array('status' => 'Not Found'));
        }

        $regular = DB::table('d_sales')
            ->select('d_sales.*', 'd_sales_dt.*', DB::raw('FORMAT(d_sales_dt.sd_total_net, 0, "de_DE") as total_net'),
                DB::raw('DATE_FORMAT(d_sales.s_date, "%d-%m-%Y") as tanggal'), 'd_mem.m_name as salesman', 'd_item.i_nama as nama_item',
                'm_member.m_name', 'm_member.m_telp', 'm_member.m_address', 'd_item.i_code')
            ->join('d_sales_dt', 'd_sales.s_id', '=', 'd_sales_dt.sd_sales')
            ->join('d_mem', 'd_sales.s_salesman', '=', 'd_mem.m_id')
            ->join('d_item', 'd_sales_dt.sd_item', '=', 'd_item.i_id')
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id')
            ->where('d_sales.s_id', $id)->get();

        $row = [];
        foreach ($regular as $key => $penjualan) {
            $row[] = array(
                'tanggal' => $penjualan->tanggal,
                'nota' => $penjualan->s_nota,
                's_total_net' => $penjualan->s_total_net,
                'salesman' => $penjualan->salesman,
                'm_name' => $penjualan->m_name,
                'm_telp' => $penjualan->m_telp,
                'm_address' => $penjualan->m_address,
                'idsales' => Crypt::encrypt($penjualan->sd_sales),
                'iditem' => Crypt::encrypt($penjualan->sd_item),
                'code' => $penjualan->i_code,
                'specificcode' => $penjualan->sd_specificcode,
                'nama_item' => $penjualan->nama_item,
                'qty' => $penjualan->sd_qty,
                'total_net' => $penjualan->total_net
            );
        }
        return json_encode($row);
    }

    public function returnPenjualan($idsales = null, $iditem = null, $spcode = null)
    {
        try {
            $idsales = Crypt::decrypt($idsales);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        try {
            $iditem = Crypt::decrypt($iditem);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        if ($spcode == "null"){
            $spcode = null;
        }

        $data = DB::table('d_sales')
            ->join('d_sales_dt', 'd_sales.s_id', '=', 'd_sales_dt.sd_sales')
            ->join('d_item', 'd_sales_dt.sd_item', '=', 'd_item.i_id')
            ->where('d_sales_dt.sd_sales', $idsales)
            ->where('d_sales_dt.sd_item', $iditem)
            ->where('d_sales_dt.sd_specificcode', $spcode)
            ->first();

        return view('penjualan.return-penjualan.return')->with(compact('data'));
    }

    public function checkStock($item = null)
    {
        $position = Auth::user()->m_comp;
        $totalqty = 0;

        $check = DB::table('d_stock')
            ->where('s_comp', $position)
            ->where('s_position', $position)
            ->where('s_item', Crypt::decrypt($item))
            ->first();

        $checksm = DB::table('d_stock_mutation')
            ->where('sm_stock', $check->s_id)
            ->where('sm_detail', 'PENAMBAHAN')
            ->where('sm_reff', 'RUSAK');

        if ($checksm->count() != 0) {
            $checksm->get();

            $qtysm = 0;

            foreach ($checksm as $key => $sm) {
                $qtysm += $sm->sm_qty;
            }

            $totalqty = $check->s_qty - $qtysm;
        } else {
            $totalqty = $check->s_qty;
        }

        return json_encode($totalqty);
    }

    public function cariItemBaru(Request $request)
    {
        $outlet = Auth::user()->m_comp;
        $cari = $request->term;
        $item = $request->item;

        $data = DB::table('d_stock')
            ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
            ->join('d_stock_mutation', function ($q){
                $q->on('d_stock_mutation.sm_stock', '=', 's_id');
                $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                $q->where('d_stock_mutation.sm_sisa', '>', '0');
                $q->where('d_stock_mutation.sm_reff', '!=', 'RUSAK');
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
            ->where('d_stock.s_position', '=', $outlet)
            ->where('d_stock.s_item', '=', Crypt::decrypt($item))
            ->groupBy('d_stock_mutation.sm_specificcode')
            ->get();

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

    public function cariItemlain(Request $request)
    {
        $outlet = Auth::user()->m_comp;
        $cari = $request->term;

        $data = DB::table('d_stock')
            ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
            ->join('d_stock_mutation', function ($q){
                $q->on('d_stock_mutation.sm_stock', '=', 's_id');
                $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                $q->where('d_stock_mutation.sm_sisa', '>', '0');
                $q->where('d_stock_mutation.sm_reff', '!=', 'RUSAK');
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
            ->where('d_stock.s_position', '=', $outlet)
            ->groupBy('d_stock_mutation.sm_specificcode')
            ->get();

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

    public function returnAdd(Request $request)
    {
        $nota = GenerateCode::codeReturn('d_return_penjualan', 'rp_notareturn', 12, 10, 3, 'RETURN');

        $comp = Auth::user()->m_comp;
        $member = Auth::user()->m_id;

        $rp_id = DB::table('d_return_penjualan')->max('rp_id');
        if ($rp_id == null){
            $rp_id = 1;
        } else {
            $rp_id = $rp_id + 1;
        }

        $rpd_detailid = DB::table('d_return_penjualandt')->where('rpd_return', $rp_id)->max('rpd_detailid');
        if ($rpd_detailid == null){
            $rpd_detailid = 1;
        } else {
            $rpd_detailid = $rpd_detailid + 1;
        }

        $rpg_detailid = DB::table('d_return_penjualanganti')->where('rpg_return', $rp_id)->max('rpg_detailid');
        if ($rpg_detailid == null){
            $rpg_detailid = 1;
        } else {
            $rpg_detailid = $rpg_detailid + 1;
        }

        if ($request->aksi == "Ganti Barang Sejenis")
        {
            DB::beginTransaction();
            try{
                //insert d_stock rusak
                //check item rusak
                $stockRusak = DB::table('d_stock')
                    ->where('s_comp', $comp)
                    ->where('s_position', $comp)
                    ->where('s_item', Crypt::decrypt($request->iditem))
                    ->where('s_status', 'On Destination')
                    ->where('s_condition', 'BROKEN');

                if ($stockRusak->count() == 0) {
                    $idStockRusak = (DB::table('d_stock')->max('s_id')) ? (DB::table('d_stock')->max('s_id') + 1) : 1;
                    DB::table('d_stock')
                        ->insert([
                            's_id'          => $idStockRusak,
                            's_comp'        => $comp,
                            's_position'    => $comp,
                            's_item'        => Crypt::decrypt($request->iditem),
                            's_qty'         => $request->qty,
                            's_status'      => 'On Destination',
                            's_condition'   => 'BROKEN'
                        ]);
                } else {
                    $idStockRusak = $stockRusak->first()->s_id;
                    DB::table('d_stock')
                        ->where('s_id', $idStockRusak)
                        ->update([
                            's_qty'         => $stockRusak->first()->s_qty + $request->qty,
                        ]);
                }

                if ($request->kode != null) {
                    $sd_iddetail = DB::table('d_stock_dt')->where('sd_stock', $idStockRusak)->max('sd_detailid');
                    if ($sd_iddetail == null){
                        $sd_iddetail = 1;
                    } else {
                        $sd_iddetail = $sd_iddetail + 1;
                    }

                    DB::table('d_stock_dt')->insert([
                        'sd_stock' => $idStockRusak,
                        'sd_detailid' => $sd_iddetail,
                        'sd_specificcode' => $request->kode
                    ]);
                }

                //insert stock mutation
                $detalidsm = DB::table('d_stock_mutation')->where('sm_stock', $idStockRusak)->max('sm_detailid');
                if ($detalidsm == null){
                    $detalidsm = 1;
                } else {
                    $detalidsm = $detalidsm + 1;
                }

                $stock_check = DB::table('d_stock')
                    ->where('s_comp', $comp)
                    ->where('s_position', $comp)
                    ->where('s_item', Crypt::decrypt($request->iditem))
                    ->where('s_status', 'On Destination')
                    ->where('s_condition', 'FINE')
                    ->first();

                $sm = DB::table('d_stock_mutation')
                    ->where('sm_stock', $stock_check->s_id)
                    ->where('sm_detail', 'PENAMBAHAN')
                    ->where('sm_specificcode', $request->kode)
                    ->where('sm_reff', '!=', 'RUSAK')
                    ->first();

                DB::table('d_stock_mutation')
                    ->insert([
                        'sm_stock' => $idStockRusak,
                        'sm_detailid' => $detalidsm,
                        'sm_date' => Carbon::now('Asia/Jakarta'),
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_specificcode' => $request->kode,
                        'sm_qty' => $request->qty,
                        'sm_use' => 0,
                        'sm_sisa' => $request->qty,
                        'sm_hpp' => $sm->sm_hpp,
                        'sm_sell' => $sm->sm_sell,
                        'sm_nota' => $nota,
                        'sm_reff' => 'RUSAK',
                        'sm_mem' => $member
                    ]);

                //insert return_penjualan
                DB::table('d_return_penjualan')->insert([
                    'rp_id'             => $rp_id,
                    'rp_notareturn'     => $nota,
                    'rp_notapenjualan'  => $request->nota,
                    'rp_date'           => Carbon::now('Asia/Jakarta'),
                    'rp_aksi'           => 'GBS',
                    'rp_status'         => 'DONE'
                ]);

                //insert return_penjualandt
                DB::table('d_return_penjualandt')->insert([
                    'rpd_return'       => $rp_id,
                    'rpd_detailid'     => $rpd_detailid,
                    'rpd_item'         => Crypt::decrypt($request->iditem),
                    'rpd_qty'          => $request->qty,
                    'rpd_specificcode' => $request->kode,
                    'rpd_note'         => strtoupper($request->ket)
                ]);

                //insert return_penjualanganti
                DB::table('d_return_penjualanganti')->insert([
                    'rpg_return'       => $rp_id,
                    'rpg_returndetail' => $rpd_detailid,
                    'rpg_detailid'     => $rpg_detailid,
                    'rpg_item'         => Crypt::decrypt($request->iditem),
                    'rpg_qty'          => $request->qty_baru,
                    'rpg_specificcode' => $request->codespecific
                ]);

                //pengurangan stock
                $count_smiddetail = DB::table('d_stock_mutation')->where('sm_stock', $request->idstock)->where('sm_specificcode', $request->codespecific)->where('sm_detail', 'PENAMBAHAN');

                $get_smiddetail = $count_smiddetail->get();

                if ($request->codespecific != null) {
                    $specificcode = $request->codespecific;

                    DB::table('d_stock_dt')->where(['sd_stock' => $request->idstock, 'sd_specificcode' => $specificcode])->delete();

                } else {
                    $specificcode = null;
                }

//                    update d_stock
                $stockQty = DB::table('d_stock')->where('s_id', $request->idstock)->first();
                DB::table('d_stock')->where('s_id', $request->idstock)->update([
                    's_qty' => $stockQty->s_qty - $request->qty_baru
                ]);

                foreach ($get_smiddetail as $key => $value) {

                    $get_countiddetail = DB::table('d_stock_mutation')->where('sm_stock', $request->idstock)->max('sm_detailid');
                    if ($get_countiddetail == null){
                        $get_countiddetail = 1;
                    } else {
                        $get_countiddetail = $get_countiddetail + 1;
                    }

                    if ($get_smiddetail[$key]->sm_specificcode == $specificcode && $get_smiddetail[$key]->sm_sisa != 0) {

                        $sm_hpp = $get_smiddetail[$key]->sm_hpp;
                        $sm_sell = $get_smiddetail[$key]->sm_sell;

                        $sm_reff = $get_smiddetail[$key]->sm_nota;

                        if ($get_smiddetail[$key]->sm_use != 0) {
                            $sm_use = $request->qty_baru + $get_smiddetail[$key]->sm_use;
                            $sm_sisa = $get_smiddetail[$key]->sm_qty - $get_smiddetail[$key]->sm_use - $request->qty_baru;
                        } else {
                            $sm_use = $request->qty_baru + $get_smiddetail[$key]->sm_use;
                            $sm_sisa = $get_smiddetail[$key]->sm_qty - $request->qty_baru;
                        }

                        // Insert to table d_stock_mutation
                        DB::table('d_stock_mutation')->insert([
                            'sm_stock'          => $request->idstock,
                            'sm_detailid'       => $get_countiddetail,
                            'sm_date'           => Carbon::now('Asia/Jakarta'),
                            'sm_detail'         => 'PENGURANGAN',
                            'sm_specificcode'   => $specificcode,
                            'sm_qty'            => $request->qty_baru,
                            'sm_use'            => 0,
                            'sm_sisa'           => 0,
                            'sm_hpp'            => $sm_hpp,
                            'sm_sell'           => $sm_sell,
                            'sm_nota'           => $nota,
                            'sm_reff'           => $sm_reff,
                            'sm_mem'            => $member
                        ]);

                        // Update in table d_stock_mutation
                        DB::table('d_stock_mutation')->where(['sm_stock' => $get_smiddetail[$key]->sm_stock, 'sm_detailid' => $get_smiddetail[$key]->sm_detailid, 'sm_detail' =>  'PENAMBAHAN', 'sm_specificcode' => $get_smiddetail[$key]->sm_specificcode])->update([
                            'sm_use' => $sm_use,
                            'sm_sisa' => $sm_sisa
                        ]);
                        break;
                    }

                }

                $msg = 'ok';

                DB::commit();
                return json_encode([
                    'status' => $msg,
                    'id' => Crypt::encrypt($rp_id),
                    'nota' => $nota
                ]);
            }catch (\Exception $e){
                DB::rollback();
                return 'false';
            }
        }
        else if ($request->aksi == "Ganti Barang Lain")
        {
            DB::beginTransaction();
            try{
                //insert d_stock rusak
                //check item rusak
                $stockRusak = DB::table('d_stock')
                    ->where('s_comp', $comp)
                    ->where('s_position', $comp)
                    ->where('s_item', Crypt::decrypt($request->iditem))
                    ->where('s_status', 'On Destination')
                    ->where('s_condition', 'BROKEN');

                if ($stockRusak->count() == 0) {
                    $idStockRusak = (DB::table('d_stock')->max('s_id')) ? (DB::table('d_stock')->max('s_id') + 1) : 1;
                    DB::table('d_stock')
                        ->insert([
                            's_id'          => $idStockRusak,
                            's_comp'        => $comp,
                            's_position'    => $comp,
                            's_item'        => Crypt::decrypt($request->iditem),
                            's_qty'         => $request->qty,
                            's_status'      => 'On Destination',
                            's_condition'   => 'BROKEN'
                        ]);
                } else {
                    $idStockRusak = $stockRusak->first()->s_id;
                    DB::table('d_stock')
                        ->where('s_id', $idStockRusak)
                        ->update([
                            's_qty'         => $stockRusak->first()->s_qty + $request->qty,
                        ]);
                }

                if ($request->kode != null) {
                    $sd_iddetail = DB::table('d_stock_dt')->where('sd_stock', $idStockRusak)->max('sd_detailid');
                    if ($sd_iddetail == null){
                        $sd_iddetail = 1;
                    } else {
                        $sd_iddetail = $sd_iddetail + 1;
                    }

                    DB::table('d_stock_dt')->insert([
                        'sd_stock' => $idStockRusak,
                        'sd_detailid' => $sd_iddetail,
                        'sd_specificcode' => $request->kode
                    ]);
                }

                //insert stock mutation
                $detalidsm = DB::table('d_stock_mutation')->where('sm_stock', $idStockRusak)->max('sm_detailid');
                if ($detalidsm == null){
                    $detalidsm = 1;
                } else {
                    $detalidsm = $detalidsm + 1;
                }

                $stock_check = DB::table('d_stock')
                    ->where('s_comp', $comp)
                    ->where('s_position', $comp)
                    ->where('s_item', Crypt::decrypt($request->iditem))
                    ->where('s_status', 'On Destination')
                    ->where('s_condition', 'FINE')
                    ->first();

                $sm = DB::table('d_stock_mutation')
                    ->where('sm_stock', $stock_check->s_id)
                    ->where('sm_detail', 'PENAMBAHAN')
                    ->where('sm_specificcode', $request->kode)
                    ->where('sm_reff', '!=', 'RUSAK')
                    ->first();

                DB::table('d_stock_mutation')
                    ->insert([
                        'sm_stock' => $idStockRusak,
                        'sm_detailid' => $detalidsm,
                        'sm_date' => Carbon::now('Asia/Jakarta'),
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_specificcode' => $request->kode,
                        'sm_qty' => $request->qty,
                        'sm_use' => 0,
                        'sm_sisa' => $request->qty,
                        'sm_hpp' => $sm->sm_hpp,
                        'sm_sell' => $sm->sm_sell,
                        'sm_nota' => $nota,
                        'sm_reff' => 'RUSAK',
                        'sm_mem' => $member
                    ]);

                //insert return_penjualan
                DB::table('d_return_penjualan')->insert([
                    'rp_id'             => $rp_id,
                    'rp_notareturn'     => $nota,
                    'rp_notapenjualan'  => $request->nota,
                    'rp_date'           => Carbon::now('Asia/Jakarta'),
                    'rp_aksi'           => 'GBL',
                    'rp_status'         => 'DONE'
                ]);

                //insert return_penjualandt
                DB::table('d_return_penjualandt')->insert([
                    'rpd_return'       => $rp_id,
                    'rpd_detailid'     => $rpd_detailid,
                    'rpd_item'         => Crypt::decrypt($request->iditem),
                    'rpd_qty'          => $request->qty,
                    'rpd_specificcode' => $request->kode,
                    'rpd_note'         => strtoupper($request->ket)
                ]);

                //insert return_penjualanganti
                DB::table('d_return_penjualanganti')->insert([
                    'rpg_return'       => $rp_id,
                    'rpg_returndetail' => $rpd_detailid,
                    'rpg_detailid'     => $rpg_detailid,
                    'rpg_item'         => $request->iditem_lain,
                    'rpg_qty'          => $request->qty_lain,
                    'rpg_specificcode' => $request->code_lain
                ]);

                //pengurangan stock
                $count_smiddetail = DB::table('d_stock_mutation')->where('sm_stock', $request->idstock_lain)->where('sm_specificcode', $request->code_lain)->where('sm_detail', 'PENAMBAHAN');

                $get_smiddetail = $count_smiddetail->get();

                if ($request->code_lain != null) {
                    $specificcode = $request->code_lain;

                    DB::table('d_stock_dt')->where(['sd_stock' => $request->idstock, 'sd_specificcode' => $specificcode])->delete();

                } else {
                    $specificcode = null;
                }

//                    update d_stock
                $stockQty = DB::table('d_stock')->where('s_id', $request->idstock_lain)->first();
                DB::table('d_stock')->where('s_id', $request->idstock_lain)->update([
                    's_qty' => $stockQty->s_qty - $request->qty_lain
                ]);

                foreach ($get_smiddetail as $key => $value) {

                    $get_countiddetail = DB::table('d_stock_mutation')->where('sm_stock', $request->idstock_lain)->max('sm_detailid');
                    if ($get_countiddetail == null){
                        $get_countiddetail = 1;
                    } else {
                        $get_countiddetail = $get_countiddetail + 1;
                    }

                    if ($get_smiddetail[$key]->sm_specificcode == $specificcode && $get_smiddetail[$key]->sm_sisa != 0) {

                        $sm_hpp = $get_smiddetail[$key]->sm_hpp;
                        $sm_sell = $get_smiddetail[$key]->sm_sell;

                        $sm_reff = $get_smiddetail[$key]->sm_nota;

                        if ($get_smiddetail[$key]->sm_use != 0) {
                            $sm_use = $request->qty_lain + $get_smiddetail[$key]->sm_use;
                            $sm_sisa = $get_smiddetail[$key]->sm_qty - $get_smiddetail[$key]->sm_use - $request->qty_lain;
                        } else {
                            $sm_use = $request->qty_lain + $get_smiddetail[$key]->sm_use;
                            $sm_sisa = $get_smiddetail[$key]->sm_qty - $request->qty_lain;
                        }

                        // Insert to table d_stock_mutation
                        DB::table('d_stock_mutation')->insert([
                            'sm_stock'          => $request->idstock_lain,
                            'sm_detailid'       => $get_countiddetail,
                            'sm_date'           => Carbon::now('Asia/Jakarta'),
                            'sm_detail'         => 'PENGURANGAN',
                            'sm_specificcode'   => $specificcode,
                            'sm_qty'            => $request->qty_lain,
                            'sm_use'            => 0,
                            'sm_sisa'           => 0,
                            'sm_hpp'            => $sm_hpp,
                            'sm_sell'           => $sm_sell,
                            'sm_nota'           => $nota,
                            'sm_reff'           => $sm_reff,
                            'sm_mem'            => $member
                        ]);

                        // Update in table d_stock_mutation
                        DB::table('d_stock_mutation')->where(['sm_stock' => $get_smiddetail[$key]->sm_stock, 'sm_detailid' => $get_smiddetail[$key]->sm_detailid, 'sm_detail' =>  'PENAMBAHAN', 'sm_specificcode' => $get_smiddetail[$key]->sm_specificcode])->update([
                            'sm_use' => $sm_use,
                            'sm_sisa' => $sm_sisa
                        ]);
                        break;
                    }

                }

                $msg = 'ok';

                DB::commit();
                return json_encode([
                    'status' => $msg,
                    'id' => Crypt::encrypt($rp_id),
                    'nota' => $nota
                ]);
            }catch (\Exception $e){
                DB::rollback();
                return 'false';
            }
        }
        else if ($request->aksi == "Ganti Uang")
        {
            DB::beginTransaction();
            try{
                //insert d_stock rusak
                //check item rusak
                $stockRusak = DB::table('d_stock')
                    ->where('s_comp', $comp)
                    ->where('s_position', $comp)
                    ->where('s_item', Crypt::decrypt($request->iditem))
                    ->where('s_status', 'On Destination')
                    ->where('s_condition', 'BROKEN');

                if ($stockRusak->count() == 0) {
                    $idStockRusak = (DB::table('d_stock')->max('s_id')) ? (DB::table('d_stock')->max('s_id') + 1) : 1;
                    DB::table('d_stock')
                        ->insert([
                            's_id'          => $idStockRusak,
                            's_comp'        => $comp,
                            's_position'    => $comp,
                            's_item'        => Crypt::decrypt($request->iditem),
                            's_qty'         => $request->qty,
                            's_status'      => 'On Destination',
                            's_condition'   => 'BROKEN'
                        ]);
                } else {
                    $idStockRusak = $stockRusak->first()->s_id;
                    DB::table('d_stock')
                        ->where('s_id', $idStockRusak)
                        ->update([
                            's_qty'         => $stockRusak->first()->s_qty + $request->qty,
                        ]);
                }

                if ($request->kode != null) {
                    $sd_iddetail = DB::table('d_stock_dt')->where('sd_stock', $idStockRusak)->max('sd_detailid');
                    if ($sd_iddetail == null){
                        $sd_iddetail = 1;
                    } else {
                        $sd_iddetail = $sd_iddetail + 1;
                    }

                    DB::table('d_stock_dt')->insert([
                        'sd_stock' => $idStockRusak,
                        'sd_detailid' => $sd_iddetail,
                        'sd_specificcode' => $request->kode
                    ]);
                }

                //insert stock mutation
                $detalidsm = DB::table('d_stock_mutation')->where('sm_stock', $idStockRusak)->max('sm_detailid');
                if ($detalidsm == null){
                    $detalidsm = 1;
                } else {
                    $detalidsm = $detalidsm + 1;
                }

                $stock_check = DB::table('d_stock')
                    ->where('s_comp', $comp)
                    ->where('s_position', $comp)
                    ->where('s_item', Crypt::decrypt($request->iditem))
                    ->where('s_status', 'On Destination')
                    ->where('s_condition', 'FINE')
                    ->first();

                $sm = DB::table('d_stock_mutation')
                    ->where('sm_stock', $stock_check->s_id)
                    ->where('sm_detail', 'PENAMBAHAN')
                    ->where('sm_specificcode', $request->kode)
                    ->where('sm_reff', '!=', 'RUSAK')
                    ->first();

                DB::table('d_stock_mutation')
                    ->insert([
                        'sm_stock' => $idStockRusak,
                        'sm_detailid' => $detalidsm,
                        'sm_date' => Carbon::now('Asia/Jakarta'),
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_specificcode' => $request->kode,
                        'sm_qty' => $request->qty,
                        'sm_use' => 0,
                        'sm_sisa' => $request->qty,
                        'sm_hpp' => $sm->sm_hpp,
                        'sm_sell' => $sm->sm_sell,
                        'sm_nota' => $nota,
                        'sm_reff' => 'RUSAK',
                        'sm_mem' => $member
                    ]);

                //insert return_penjualan
                DB::table('d_return_penjualan')->insert([
                    'rp_id'             => $rp_id,
                    'rp_notareturn'     => $nota,
                    'rp_notapenjualan'  => $request->nota,
                    'rp_date'           => Carbon::now('Asia/Jakarta'),
                    'rp_aksi'           => 'GU',
                    'rp_status'         => 'DONE'
                ]);

                //insert return_penjualandt
                DB::table('d_return_penjualandt')->insert([
                    'rpd_return'       => $rp_id,
                    'rpd_detailid'     => $rpd_detailid,
                    'rpd_item'         => Crypt::decrypt($request->iditem),
                    'rpd_qty'          => $request->qty,
                    'rpd_specificcode' => $request->kode,
                    'rpd_note'         => strtoupper($request->ket)
                ]);

                $msg = 'ok';

                DB::commit();
                return json_encode([
                    'status' => $msg,
                    'id' => Crypt::encrypt($rp_id),
                    'nota' => $nota
                ]);
            }catch (\Exception $e){
                DB::rollback();
                return 'false';
            }
        }
    }

    public function struk($id = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $datas = DB::table('d_return_penjualan')
            ->select('d_return_penjualan.rp_notareturn as nota_return',
                'm_company.c_name as nama_outlet',
                'm_company.c_address as alamat_outlet',
                'm_member.m_name as nama_member',
                'm_member.m_telp as telp_member',
                'd_return_penjualan.rp_date as tgl_return',
                'd_return_penjualan.rp_aksi as jenis_return',
                'rpd.rpd_qty',
                'a.i_code as rpd_code',
                'rpd.rpd_specificcode',
                'a.i_nama as rpd_item',
                'rpd.rpd_note',
                'd_return_penjualan.rp_notapenjualan as nota_penjualan',
                'rpg.rpg_qty',
                'b.i_code as rpg_code',
                'rpg.rpg_specificcode',
                'b.i_nama as rpg_item')
            ->where('d_return_penjualan.rp_id', $id)
            ->join('d_return_penjualandt as rpd', 'd_return_penjualan.rp_id', '=', 'rpd.rpd_return')
            ->join('d_return_penjualanganti as rpg', 'd_return_penjualan.rp_id', '=', 'rpg.rpg_return')
            ->join('d_sales', 'd_sales.s_nota', '=', 'd_return_penjualan.rp_notapenjualan')
            ->join('m_member', 'm_member.m_id', '=', 'd_sales.s_member')
            ->join('d_item as a', 'a.i_id', '=', 'rpd.rpd_item')
            ->leftjoin('d_item as b', 'b.i_id', '=', 'rpg.rpg_item')
            ->join('m_company', function ($c){
                $c->where('c_id', '=', Auth::user()->m_comp);
            })
            ->get();

        if ($datas == null) {
            return view('errors/404');
        }

        return view('penjualan.return-penjualan.struk')->with(compact('datas'));
    }
}
