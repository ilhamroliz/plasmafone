<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\CodeGenerator as GenerateCode;
use App\Http\Controllers\PlasmafoneController as Access;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\PengelolaanMemberController;
use Response;
use DataTables;
Use Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.penjualan-regular.index');
    }

    public function add_regular()
    {
        return view('penjualan.penjualan-regular.add');
    }

    public function tempo()
    {
        return view('penjualan.penjualan-tempo.index');
    }

    public function add_tempo()
    {
        return view('penjualan.penjualan-tempo.add');
    }

    public function cariSales(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('d_mem')
            ->where(function ($q) use ($cari){
                $q->orWhere('m_id', 'like', '%'.$cari.'%');
                $q->orWhere('m_name', 'like', '%'.$cari.'%');
                $q->where('m_comp', '=', Auth::user()->m_comp);
            })->get();

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->m_id, 'label' => strtoupper($query->m_name)];
            }
        }
        return Response::json($results);
    }

    public function cariMember(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('m_member')
            ->where('m_status', '=', 'AKTIF')
            ->where(function ($q) use ($cari){
                $q->orWhere('m_name', 'like', '%'.$cari.'%');
                $q->orWhere('m_telp', 'like', '%'.$cari.'%');
                $q->orWhere('m_id', 'like', '%'.$cari.'%');
            })->get();

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->m_id, 'label' => strtoupper($query->m_name) . ' ('.$query->m_telp.')'];
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
                        'm_telp' => $nomor,
                        'm_status' => 'AKTIF'
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

    public function searchStock(Request $request)
    {
        $outlet = Auth::user()->m_comp;
        $cari = $request->term;
        $term = explode(" - ",$cari);
        $cari = $term[0];
        $jenis = $request->jenis;
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
                    $q->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                    $q->where('d_stock_mutation.sm_reff', '!=', 'RUSAK');
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->leftjoin('m_group_price', function ($g) use ($jenis){
                    $g->on('m_group_price.gp_item', '=', 'd_stock.s_item');
                    $g->where('m_group_price.gp_group', '=', $jenis);
                })
                ->leftjoin('d_outlet_price', function($o) use ($outlet){
                    $o->on('d_outlet_price.op_item', '=', 'd_stock.s_item');
                    $o->where('d_outlet_price.op_outlet', '=', $outlet);
                })
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_stock.s_comp', '=', $outlet)
                ->where('d_stock.s_position', '=', $outlet)
                ->where('d_stock.s_status', '=', 'On Destination')
                ->where('d_stock.s_condition', '=', 'FINE')
                ->where('d_item.i_specificcode', '=', 'N')
                ->groupBy('d_stock_mutation.sm_specificcode');

            $dataY = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('d_stock_mutation.sm_stock', '=', 's_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                    $q->whereNotIn('d_stock_mutation.sm_specificcode', $kode);
                    $q->where('d_stock_mutation.sm_reff', '!=', 'RUSAK');
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                    $a->on('d_stock_mutation.sm_specificcode', '=', 'd_stock_dt.sd_specificcode');
                    $a->whereNotIn('d_stock_dt.sd_specificcode', $kode);
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->leftjoin('m_group_price', function ($g) use ($jenis){
                    $g->on('m_group_price.gp_item', '=', 'd_stock.s_item');
                    $g->where('m_group_price.gp_group', '=', $jenis);
                })
                ->leftjoin('d_outlet_price', function($o) use ($outlet){
                    $o->on('d_outlet_price.op_item', '=', 'd_stock.s_item');
                    $o->where('d_outlet_price.op_outlet', '=', $outlet);
                })
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_stock.s_comp', '=', $outlet)
                ->where('d_stock.s_position', '=', $outlet)
                ->where('d_stock.s_status', '=', 'On Destination')
                ->where('d_stock.s_condition', '=', 'FINE')
                ->where('d_item.i_specificcode', '=', 'Y')
                ->groupBy('d_stock_mutation.sm_specificcode');

            $data = $dataN->union($dataY)->get();
        } else {
            $data = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
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
                ->leftjoin('m_group_price', function ($g) use ($jenis){
                    $g->on('m_group_price.gp_item', '=', 'd_stock.s_item');
                    $g->where('m_group_price.gp_group', '=', $jenis);
                })
                ->leftjoin('d_outlet_price', function($o) use ($outlet){
                    $o->on('d_outlet_price.op_item', '=', 'd_stock.s_item');
                    $o->where('d_outlet_price.op_outlet', '=', $outlet);
                })
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_stock.s_comp', '=', $outlet)
                ->where('d_stock.s_position', '=', $outlet)
                ->where('d_stock.s_status', '=', 'On Destination')
                ->where('d_stock.s_condition', '=', 'FINE')
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

    public function cariStock(Request $request)
    {
        $outlet = Auth::user()->m_comp;
        $cari = $request->term;
        $jenis = $request->jenis;
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
                    $q->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                    $q->where('d_stock_mutation.sm_reff', '!=', 'RUSAK');
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->leftjoin('m_group_price', function ($g) use ($jenis){
                    $g->on('m_group_price.gp_item', '=', 'd_stock.s_item');
                    $g->where('m_group_price.gp_group', '=', $jenis);
                })
                ->leftjoin('d_outlet_price', function($o) use ($outlet){
                    $o->on('d_outlet_price.op_item', '=', 'd_stock.s_item');
                    $o->where('d_outlet_price.op_outlet', '=', $outlet);
                })
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_stock.s_comp', '=', $outlet)
                ->where('d_stock.s_position', '=', $outlet)
                ->where('d_stock.s_status', '=', 'On Destination')
                ->where('d_stock.s_condition', '=', 'FINE')
                ->where('d_item.i_specificcode', '=', 'N')
                ->groupBy('d_stock_mutation.sm_specificcode');

            $dataY = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $q->where('d_stock_mutation.sm_detail', '=', 'PENAMBAHAN');
                    $q->where('d_stock_mutation.sm_sisa', '>', '0');
                    $q->where('d_stock_mutation.sm_reff', '!=', 'RUSAK');
                    $q->whereNotIn('d_stock_mutation.sm_specificcode', $kode);
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('d_stock_dt.sd_stock', '=', 'd_stock.s_id');
                    $a->on('d_stock_mutation.sm_specificcode', '=', 'd_stock_dt.sd_specificcode');
                    $a->whereNotIn('d_stock_dt.sd_specificcode', $kode);
                })
                ->join('d_item', 'd_item.i_id', '=', 'd_stock.s_item')
                ->leftjoin('m_group_price', function ($g) use ($jenis){
                    $g->on('m_group_price.gp_item', '=', 'd_stock.s_item');
                    $g->where('m_group_price.gp_group', '=', $jenis);
                })
                ->leftjoin('d_outlet_price', function($o) use ($outlet){
                    $o->on('d_outlet_price.op_item', '=', 'd_stock.s_item');
                    $o->where('d_outlet_price.op_outlet', '=', $outlet);
                })
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_stock.s_comp', '=', $outlet)
                ->where('d_stock.s_position', '=', $outlet)
                ->where('d_stock.s_status', '=', 'On Destination')
                ->where('d_stock.s_condition', '=', 'FINE')
                ->where('d_item.i_specificcode', '=', 'Y')
                ->groupBy('d_stock_mutation.sm_specificcode');

            $data = $dataN->union($dataY)->get();
        } else {
            $data = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
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
                ->leftjoin('m_group_price', function ($g) use ($jenis){
                    $g->on('m_group_price.gp_item', '=', 'd_stock.s_item');
                    $g->where('m_group_price.gp_group', '=', $jenis);
                })
                ->leftjoin('d_outlet_price', function($o) use ($outlet){
                    $o->on('d_outlet_price.op_item', '=', 'd_stock.s_item');
                    $o->where('d_outlet_price.op_outlet', '=', $outlet);
                })
                ->where(function ($w) use ($cari){
                    $w->orWhere('d_item.i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('d_item.i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('d_stock_dt.sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('d_stock.s_comp', '=', $outlet)
                ->where('d_stock.s_position', '=', $outlet)
                ->where('d_stock.s_status', '=', 'On Destination')
                ->where('d_stock.s_condition', '=', 'FINE')
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

    public function checkStock($item = null)
    {
        $position = Auth::user()->m_comp;
        $totalqty = 0;

        $check = DB::table('d_stock')
            ->where('s_comp', $position)
            ->where('s_position', $position)
            ->where('s_item', $item)
            ->where('s_status', 'On Destination')
            ->where('s_condition', 'FINE')
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

    public function getDetailMember($id = null)
    {
        $query = DB::table('m_member')
                    ->select('m_member.m_address', 'm_group.g_name', 'm_member.m_jenis')
                    ->join('m_group', 'm_member.m_jenis', '=', 'm_group.g_id')
                    ->where('m_member.m_id', $id)
                    ->first();

        return Response::json(['jenis' => $query->g_name, 'alamat' => $query->m_address, 'id_group' => $query->m_jenis]);
    }

    public function getPenjualanRegular()
    {
        $regular = DB::table('d_sales')
                    ->select('d_sales.s_id as id', DB::raw('DATE_FORMAT(d_sales.s_date, "%d-%m-%Y") as tanggal'), 'd_sales.s_nota as nota')
                    ->join('d_sales_dt', 'd_sales.s_id', '=', 'd_sales_dt.sd_sales')
                    ->where('d_sales.s_jenis', 'C')
                    ->groupBy('d_sales.s_id')
                    ->orderBy('d_sales.s_date', 'desc')->get();

        return DataTables::of($regular)

        ->addColumn('aksi', function ($regular) {

            if (Access::checkAkses(16, 'delete') == false && Access::checkAkses(16, 'update') == false) {

                return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($regular->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

            } else {

                return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($regular->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Penjualan" onclick="edit(\'' . Crypt::encrypt($regular->id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Batalkan" onclick="remove(\'' . Crypt::encrypt($regular->id) . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';

            }

        })

        ->rawColumns(['aksi'])

        ->make(true);
    }

    public function getPenjualanTempo()
    {
        $regular = DB::table('d_sales')
            ->select('d_sales.s_id as id', DB::raw('DATE_FORMAT(d_sales.s_date, "%d-%m-%Y") as tanggal'), 'd_sales.s_nota as nota')
            ->join('d_sales_dt', 'd_sales.s_id', '=', 'd_sales_dt.sd_sales')
            ->where('d_sales.s_jenis', 'T')
            ->groupBy('d_sales.s_id')
            ->orderBy('d_sales.s_date', 'desc')->get();

        return DataTables::of($regular)

            ->addColumn('aksi', function ($regular) {

                if (Access::checkAkses(16, 'delete') == false && Access::checkAkses(16, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($regular->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($regular->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Penjualan" onclick="edit(\'' . Crypt::encrypt($regular->id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Batalkan" onclick="remove(\'' . Crypt::encrypt($regular->id) . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getPenjualanRegularDetail($id = null)
    {
        $id = Crypt::decrypt($id);
        $regular = DB::table('d_sales')
                    ->select('d_sales.*', 'd_sales_dt.*', DB::raw('FORMAT(d_sales_dt.sd_total_net, 0, "de_DE") as total_net'), DB::raw('DATE_FORMAT(d_sales.s_date, "%d-%m-%Y") as tanggal'), 'd_mem.m_name as salesman', 'd_item.i_nama as nama_item', 'd_item.i_code')
                    ->join('d_sales_dt', 'd_sales.s_id', '=', 'd_sales_dt.sd_sales')
                    ->join('d_mem', 'd_sales.s_salesman', '=', 'd_mem.m_id')
                    ->join('d_item', 'd_sales_dt.sd_item', '=', 'd_item.i_id')
                    ->where('d_sales.s_id', $id)->get();
        return json_encode($regular);
    }

    public function editPenjualanRegular($id = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $jenis = DB::table('d_sales')
            ->where('d_sales.s_id', $id)
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id')
            ->first();

        $data = DB::table('d_sales')
                ->select('d_sales.*', 'd_sales_dt.*', DB::raw('DATE_FORMAT(d_sales.s_date, "%d-%m-%Y") as tanggal'), 'd_stock.s_id as idStock', 'd_stock.s_comp as stock_comp',
                    'd_stock.s_position as stock_position', 'd_stock.s_item as stock_item', 'd_stock.s_qty as stock_qty', 'd_stock_mutation.*', 'm_member.*',
                    'm_group.g_name as jenis_member', 'd_mem.m_name as salesman', 'd_item.i_nama as nama_item', 'd_item.i_specificcode as specificcode', 'd_item.i_code', 'd_item.i_price',
                    'm_group_price.gp_price', 'd_outlet_price.op_price')
                ->join('d_sales_dt', 'd_sales.s_id', '=', 'd_sales_dt.sd_sales')
                ->join('d_mem', 'd_sales.s_salesman', '=', 'd_mem.m_id')
                ->join('d_item', 'd_sales_dt.sd_item', '=', 'd_item.i_id')
                ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id')
                ->join('m_group', 'm_member.m_jenis', '=', 'm_group.g_id')
                ->join('d_stock_mutation', 'd_sales.s_nota', '=', 'd_stock_mutation.sm_nota')
                ->join('d_stock', function($y){
                    $y->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                    $y->on('d_stock.s_item', '=', 'd_sales_dt.sd_item');
                })
                ->leftjoin('m_group_price', function ($g) use ($jenis){
                    $g->on('m_group_price.gp_item', '=', 'd_sales_dt.sd_item');
                    $g->where('m_group_price.gp_group', '=', $jenis->m_jenis);
                })
                ->leftjoin('d_outlet_price', function($x){
                    $x->on('d_outlet_price.op_item', '=', 'd_sales_dt.sd_item');
                    $x->where('op_outlet', '=', 'd_stock_detail.sd_comp');
                })
                ->where('d_sales.s_id', $id)
                ->where('d_stock_mutation.sm_detail', '=', 'PENGURANGAN')
                ->groupBy('d_stock_mutation.sm_specificcode')
                ->distinct('d_stock_mutation.sm_specificcode')
                ->get();

        $results = [];

        foreach ($data as $key => $val) {
            $totalqty = 0;
            $check = DB::table('d_stock')
                ->where('s_comp', $val->sd_comp)
                ->where('s_position', $val->sd_comp)
                ->where('s_item', $val->sd_item)
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

            $results[] = array(
                'specificcode' => $val->specificcode,
                'idStock' => $val->idStock,
                'i_code' => $val->i_code,
                'nama_item' => $val->nama_item,
                'stock_qty' => $val->stock_qty,
                'sm_specificcode' => $val->sm_specificcode,
                'sd_value' => $val->sd_value,
                'sd_total_gross' => $val->sd_total_gross,
                'sd_total_net' => $val->sd_total_net,
                'sd_qty' => $val->sd_qty,
                'gp_price' => $val->gp_price,
                'op_price' => $val->op_price,
                'i_price' => $val->i_price,
                'sd_disc_persen' => $val->sd_disc_persen,
                'sd_disc_value' => $val->sd_disc_value,
                'sd_total_gross' => $val->sd_total_gross,
                'sd_sales' => $val->sd_sales,
                'sd_item' => $val->sd_item,
                'stock' => $totalqty
            );
        }

        return view('penjualan.penjualan-regular.edit')->with(compact('results', 'data'));
    }

    public function editPenjualanTempo($id = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $jenis = DB::table('d_sales')
            ->where('d_sales.s_id', $id)
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id')
            ->first();

        $data = DB::table('d_sales')
            ->select('d_sales.*', 'd_sales_dt.*', DB::raw('DATE_FORMAT(d_sales.s_date, "%d-%m-%Y") as tanggal'), 'd_stock.s_id as idStock', 'd_stock.s_comp as stock_comp',
                'd_stock.s_position as stock_position', 'd_stock.s_item as stock_item', 'd_stock.s_qty as stock_qty', 'd_stock_mutation.*', 'm_member.*',
                'm_group.g_name as jenis_member', 'd_mem.m_name as salesman', 'd_item.i_nama as nama_item', 'd_item.i_specificcode as specificcode', 'd_item.i_code', 'd_item.i_price',
                'm_group_price.gp_price', 'd_outlet_price.op_price')
            ->join('d_sales_dt', 'd_sales.s_id', '=', 'd_sales_dt.sd_sales')
            ->join('d_mem', 'd_sales.s_salesman', '=', 'd_mem.m_id')
            ->join('d_item', 'd_sales_dt.sd_item', '=', 'd_item.i_id')
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id')
            ->join('m_group', 'm_member.m_jenis', '=', 'm_group.g_id')
            ->join('d_stock_mutation', 'd_sales.s_nota', '=', 'd_stock_mutation.sm_nota')
            ->join('d_stock', function($y){
                $y->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                $y->on('d_stock.s_item', '=', 'd_sales_dt.sd_item');
            })
            ->leftjoin('m_group_price', function ($g) use ($jenis){
                $g->on('m_group_price.gp_item', '=', 'd_sales_dt.sd_item');
                $g->where('m_group_price.gp_group', '=', $jenis->m_jenis);
            })
            ->leftjoin('d_outlet_price', function($x){
                $x->on('d_outlet_price.op_item', '=', 'd_sales_dt.sd_item');
                $x->where('op_outlet', '=', 'd_stock_detail.sd_comp');
            })
            ->where('d_sales.s_id', $id)
            ->where('d_stock_mutation.sm_detail', '=', 'PENGURANGAN')
            ->groupBy('d_stock_mutation.sm_specificcode')
            ->distinct('d_stock_mutation.sm_specificcode')
            ->get();

        $results = [];

        foreach ($data as $key => $val) {
            $totalqty = 0;
            $check = DB::table('d_stock')
                ->where('s_comp', $val->sd_comp)
                ->where('s_position', $val->sd_comp)
                ->where('s_item', $val->sd_item)
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

            $results[] = array(
                'specificcode' => $val->specificcode,
                'idStock' => $val->idStock,
                'i_code' => $val->i_code,
                'nama_item' => $val->nama_item,
                'stock_qty' => $val->stock_qty,
                'sm_specificcode' => $val->sm_specificcode,
                'sd_value' => $val->sd_value,
                'sd_total_gross' => $val->sd_total_gross,
                'sd_total_net' => $val->sd_total_net,
                'sd_qty' => $val->sd_qty,
                'gp_price' => $val->gp_price,
                'op_price' => $val->op_price,
                'i_price' => $val->i_price,
                'sd_disc_persen' => $val->sd_disc_persen,
                'sd_disc_value' => $val->sd_disc_value,
                'sd_total_gross' => $val->sd_total_gross,
                'sd_sales' => $val->sd_sales,
                'sd_item' => $val->sd_item,
                'stock' => $totalqty
            );
        }

        return view('penjualan.penjualan-tempo.edit')->with(compact('results', 'data'));
    }

    public function savePenjualan(Request $request)
    {
        $data = $request->all();

        if (!isset($data['idStock']) || $data['idMember'] == null || $data['salesman'] == null) 
        { 
            return "lengkapi data";
        } else {
            DB::beginTransaction();
            try{

                $sales = DB::table('d_mem')
                        ->select('m_id', 'm_name')
                        ->where('m_id', $data['salesman'])
                        ->first();

                $arr_hpp = [];

                $outlet_user = Auth::user()->m_comp;
                $member = Auth::user()->m_id;

                if ($data['jenis_pembayaran'] == "T") {
                    // POS-TEM/001/14/12/2018
                    $nota = GenerateCode::codePenjualan('d_sales', 's_nota', 13, 10, 3, 'POS-TEM');
                } else {
                    // POS-REG/001/14/12/2018
                    $nota = GenerateCode::codePenjualan('d_sales', 's_nota', 13, 10, 3, 'POS-REG');
                }

                $Htotal_disc_persen = 0;
                $Htotal_disc_value = 0;

                for ($i=0; $i < count($data['idStock']); $i++) { 

                    $count_smiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->where('sm_specificcode', $data['kode'][$i])->where('sm_detail', 'PENAMBAHAN');

                    $get_smiddetail = $count_smiddetail->get();

                    $discPercent = implode("", explode("%", $data['discp'][$i]));
                    $discValue = implode("", explode(".", $data['discv'][$i]));

                    if ($data['kode'][$i] != null) {
                        $specificcode = $data['kode'][$i];
                        
                        DB::table('d_stock_dt')->where(['sd_stock' => $data['idStock'][$i], 'sd_specificcode' => $specificcode])->delete();
                        
                    } else {
                        $specificcode = null;
                    }

//                    update d_stock
                    $stockQty = DB::table('d_stock')->where('s_id', $data['idStock'][$i])->first();
                    DB::table('d_stock')->where('s_id', $data['idStock'][$i])->update([
                        's_qty' => $stockQty->s_qty - $data['qtyTable'][$i]
                    ]);

                    foreach ($get_smiddetail as $key => $value) {

                        $get_countiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->max('sm_detailid');
                        if ($get_countiddetail == null){
                            $get_countiddetail = 1;
                        } else {
                            $get_countiddetail = $get_countiddetail + 1;
                        }
                        
                        if ($get_smiddetail[$key]->sm_specificcode == $specificcode && $get_smiddetail[$key]->sm_sisa != 0) {

                            // if ($discPercent == 0 && $discValue == 0) {
                            //     $sm_hpp = 1 * $data['harga'][$i];
                            // } else if ($discPercent != 0) {
                            //     $sm_hpp = ((100 - $discPercent)/100) * ($data['harga'][$i] * 1);
                            // } else if ($discValue != 0) {
                            //     $sm_hpp = 1 * $data['harga'][$i] - $discValue;
                            // }

                            $sm_hpp = $get_smiddetail[$key]->sm_hpp;
                            $sm_sell = $get_smiddetail[$key]->sm_sell;
                            array_push($arr_hpp, $sm_hpp);

                            $sm_reff = $get_smiddetail[$key]->sm_nota;
                            
                            if ($get_smiddetail[$key]->sm_use != 0) {
                                $sm_use = $data['qtyTable'][$i] + $get_smiddetail[$key]->sm_use;
                                $sm_sisa = $get_smiddetail[$key]->sm_qty - $get_smiddetail[$key]->sm_use - $data['qtyTable'][$i];
                            } else {
                                $sm_use = $data['qtyTable'][$i] + $get_smiddetail[$key]->sm_use;
                                $sm_sisa = $get_smiddetail[$key]->sm_qty - $data['qtyTable'][$i];
                            }
                            

                            // $Htotal_disc_persen += ($data['grossItem'][$i] / $data['totalGross']) * ($discPercent/100);
                            // $Htotal_disc_value += ($data['grossItem'][$i] / $data['totalGross']) * $discValue;
                            

                            // Insert to table d_stock_mutation
                            DB::table('d_stock_mutation')->insert([
                                'sm_stock'          => $data['idStock'][$i],
                                'sm_detailid'       => $get_countiddetail,
                                'sm_date'           => Carbon::now('Asia/Jakarta'),
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
                            DB::table('d_stock_mutation')->where(['sm_stock' => $get_smiddetail[$key]->sm_stock, 'sm_detailid' => $get_smiddetail[$key]->sm_detailid, 'sm_detail' =>  'PENAMBAHAN', 'sm_specificcode' => $get_smiddetail[$key]->sm_specificcode])->update([
                                'sm_use' => $sm_use,
                                'sm_sisa' => $sm_sisa
                            ]);
                            break;
                        }

                    }
                }

                // Insert to d_sales
                $idsales = DB::table('d_sales')->insertGetId([
                    's_comp'                => $outlet_user,
                    's_member'              => $data['idMember'],
                    's_date'                => Carbon::now('Asia/Jakarta'),
                    's_jenis'               => $data['jenis_pembayaran'],
                    's_nota'                => $nota,
                    's_total_gross'         => $data['totalHarga'],
                    's_total_disc_value'    => 0,
                    's_total_disc_persen'   => 0,
                    's_total_net'           => $data['totalHarga'],
                    's_salesman'            => $sales->m_id
                ]);

                for ($i=0; $i < count($data['idStock']); $i++) {

                    $salesdetailid = DB::table('d_sales_dt')->where('sd_sales', $idsales)->count()+1;

                    $discPercent = implode("", explode("%", $data['discp'][$i]));
                    $discValue = implode("", explode(".", $data['discv'][$i]));

                    $Dtotal_disc_persen = ($data['grossItem'][$i] / $data['totalGross']) * ($discPercent/100);
                    $Dtotal_disc_value = ($data['grossItem'][$i] / $data['totalGross']) * $discValue;

                    $idItem = DB::table('d_stock')->select('s_item')->where('s_id', $data['idStock'][$i])->first();
                    // Insert to table d_sales_dt
                    DB::table('d_sales_dt')->insert([
                        'sd_sales'          => $idsales,
                        'sd_detailid'       => $salesdetailid,
                        'sd_comp'           => $outlet_user,
                        'sd_item'           => $idItem->s_item,
                        'sd_specificcode'   => $data['kode'][$i],
                        'sd_qty'            => $data['qtyTable'][$i],
                        'sd_value'          => $data['harga'][$i],
                        'sd_hpp'            => $arr_hpp[$i],
                        'sd_total_gross'    => $data['totalItem'][$i],
                        'sd_disc_persen'    => $Dtotal_disc_persen,
                        'sd_disc_value'     => $Dtotal_disc_value,
                        'sd_total_net'      => $data['totalItem'][$i]
                    ]);

                }
                
                if ($data['jenis_pembayaran'] == "T") {
                    Access::logActivity('Membuat penjualan tempo ' . $nota);
                } else {
                    Access::logActivity('Membuat penjualan regular ' . $nota);
                }

                $outlet = Auth::user()->m_comp;
                $outlet_payment = DB::table('d_outlet_payment')
                    ->join('m_pembayaran', 'd_outlet_payment.op_pembayaran', '=', 'm_pembayaran.p_id')
                    ->where('d_outlet_payment.op_outlet', $outlet)
                    ->get();
                $payment_method = [];
                $bayar = [];
                foreach ($outlet_payment as $key => $payment) {
                    $payment_method[] = $payment->p_detail;
                    $val = implode("", explode(".", implode("", explode("Rp", implode("", explode(" ",$data[implode("_", explode(" ", $payment->p_detail))]))))));
                    $bayar[] = $val;
                }

                DB::commit();
                return response()->json([
                    'status' => 'sukses',
                    'payment_method' => $payment_method,
                    'payment' => $bayar,
                    'salesman' => $sales->m_name,
                    'idSales' => Crypt::encrypt($idsales),
                    'totHarga' => $data['totalHarga'],
                    'dibayar' => $data['total_pembayaran'],
                    'kembali' => $data['kembali']
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => 'gagal',
                    'data' => 'server gagal menyimpan',
                    'erorr' => $e
                ]);
            }
        }

    }

    public function editPenjualan(Request $request)
    {
        $data = $request->all();
        $totGross = implode("", explode(".", $data['totalGross']));
        $totHarga = implode("", explode(".", $data['totalHarga']));

        if (!isset($data['idStock']) || $data['idMember'] == null || $data['salesman'] == null)
        {
            return "lengkapi data";
        } else {

            DB::beginTransaction();
            try{
                $this->delete($data['idSales']);
                $sales = DB::table('d_mem')
                    ->select('m_id', 'm_name')
                    ->where('m_id', $data['salesman'])
                    ->first();

                $arr_hpp = [];

                $outlet_user = Auth::user()->m_comp;
                $member = Auth::user()->m_id;

                if ($data['jenis_pembayaran'] == "T") {
                    // POS-TEM/001/14/12/2018
                    $nota = GenerateCode::codePenjualan('d_sales', 's_nota', 13, 10, 3, 'POS-TEM');
                } else {
                    // POS-REG/001/14/12/2018
                    $nota = GenerateCode::codePenjualan('d_sales', 's_nota', 13, 10, 3, 'POS-REG');
                }

                $Htotal_disc_persen = 0;
                $Htotal_disc_value = 0;

                for ($i=0; $i < count($data['idStock']); $i++) {

                    $count_smiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->where('sm_specificcode', $data['kode'][$i])->where('sm_detail', 'PENAMBAHAN');

                    $get_smiddetail = $count_smiddetail->get();

                    $discPercent = implode("", explode("%", $data['discp'][$i]));
                    $discValue = implode("", explode(".", $data['discv'][$i]));

                    if ($data['kode'][$i] != null) {
                        $specificcode = $data['kode'][$i];

                        DB::table('d_stock_dt')->where(['sd_stock' => $data['idStock'][$i], 'sd_specificcode' => $specificcode])->delete();

                    } else {
                        $specificcode = null;
                    }

//                    update d_stock
                    $stockQty = DB::table('d_stock')->where('s_id', $data['idStock'][$i])->first();
                    DB::table('d_stock')->where('s_id', $data['idStock'][$i])->update([
                        's_qty' => $stockQty->s_qty - $data['qtyTable'][$i]
                    ]);

                    foreach ($get_smiddetail as $key => $value) {

                        $get_countiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->max('sm_detailid');
                        if ($get_countiddetail == null){
                            $get_countiddetail = 1;
                        } else {
                            $get_countiddetail = $get_countiddetail + 1;
                        }

                        if ($get_smiddetail[$key]->sm_sisa != 0) {

                            // if ($discPercent == 0 && $discValue == 0) {
                            //     $sm_hpp = 1 * $data['harga'][$i];
                            // } else if ($discPercent != 0) {
                            //     $sm_hpp = ((100 - $discPercent)/100) * ($data['harga'][$i] * 1);
                            // } else if ($discValue != 0) {
                            //     $sm_hpp = 1 * $data['harga'][$i] - $discValue;
                            // }

                            $sm_hpp = $get_smiddetail[$key]->sm_hpp;
                            $sm_sell = $get_smiddetail[$key]->sm_sell;
                            array_push($arr_hpp, $sm_hpp);

                            $sm_reff = $get_smiddetail[$key]->sm_nota;

                            if ($get_smiddetail[$key]->sm_use != 0) {
                                $sm_use = $data['qtyTable'][$i] + $get_smiddetail[$key]->sm_use;
                                $sm_sisa = $get_smiddetail[$key]->sm_qty - $get_smiddetail[$key]->sm_use - $data['qtyTable'][$i];
                            } else {
                                $sm_use = $data['qtyTable'][$i] + $get_smiddetail[$key]->sm_use;
                                $sm_sisa = $get_smiddetail[$key]->sm_qty - $data['qtyTable'][$i];
                            }


                            // $Htotal_disc_persen += ($data['grossItem'][$i] / $data['totalGross']) * ($discPercent/100);
                            // $Htotal_disc_value += ($data['grossItem'][$i] / $data['totalGross']) * $discValue;


                            // Insert to table d_stock_mutation
                            DB::table('d_stock_mutation')->insert([
                                'sm_stock'          => $data['idStock'][$i],
                                'sm_detailid'       => $get_countiddetail,
                                'sm_date'           => Carbon::now('Asia/Jakarta'),
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
                            DB::table('d_stock_mutation')->where(['sm_stock' => $get_smiddetail[$key]->sm_stock, 'sm_detailid' => $get_smiddetail[$key]->sm_detailid, 'sm_detail' =>  'PENAMBAHAN', 'sm_specificcode' => $get_smiddetail[$key]->sm_specificcode])->update([
                                'sm_use' => $sm_use,
                                'sm_sisa' => $sm_sisa
                            ]);
                            break;
                        }

                    }
                }

                // Insert to d_sales
                $idsales = DB::table('d_sales')->insertGetId([
                    's_comp'                => $outlet_user,
                    's_member'              => $data['idMember'],
                    's_date'                => Carbon::now('Asia/Jakarta'),
                    's_jenis'               => $data['jenis_pembayaran'],
                    's_nota'                => $nota,
                    's_total_gross'         => $totHarga,
                    's_total_disc_value'    => 0,
                    's_total_disc_persen'   => 0,
                    's_total_net'           => $totHarga,
                    's_salesman'            => $sales->m_id
                ]);

                for ($i=0; $i < count($data['idStock']); $i++) {

                    $salesdetailid = DB::table('d_sales_dt')->where('sd_sales', $idsales)->count()+1;

                    $discPercent = implode("", explode("%", $data['discp'][$i]));
                    $discValue = implode("", explode(".", $data['discv'][$i]));

                    $Dtotal_disc_persen = ($data['grossItem'][$i] / $totGross) * ($discPercent/100);
                    $Dtotal_disc_value = ($data['grossItem'][$i] / $totGross) * $discValue;

                    $idItem = DB::table('d_stock')->select('s_item')->where('s_id', $data['idStock'][$i])->first();
                    // Insert to table d_sales_dt
                    DB::table('d_sales_dt')->insert([
                        'sd_sales'          => $idsales,
                        'sd_detailid'       => $salesdetailid,
                        'sd_comp'           => $outlet_user,
                        'sd_item'           => $idItem->s_item,
                        'sd_specificcode'   => $data['kode'][$i],
                        'sd_qty'            => $data['qtyTable'][$i],
                        'sd_value'          => $data['harga'][$i],
                        'sd_hpp'            => $arr_hpp[$i],
                        'sd_total_gross'    => $data['totalItem'][$i],
                        'sd_disc_persen'    => $Dtotal_disc_persen,
                        'sd_disc_value'     => $Dtotal_disc_value,
                        'sd_total_net'      => $data['totalItem'][$i]
                    ]);

                }

                if ($data['jenis_pembayaran'] == "T") {
                    Access::logActivity('Membuat penjualan tempo ' . $nota);
                    PengelolaanMemberController::addSaldoFromTransaction($data['idMember'], $totHarga, $nota, 16);
                } else {
                    Access::logActivity('Membuat penjualan regular ' . $nota);
                    PengelolaanMemberController::addSaldoFromTransaction($data['idMember'], $totHarga, $nota, 17);
                }

                $outlet = Auth::user()->m_comp;
                $outlet_payment = DB::table('d_outlet_payment')
                    ->join('m_pembayaran', 'd_outlet_payment.op_pembayaran', '=', 'm_pembayaran.p_id')
                    ->where('d_outlet_payment.op_outlet', $outlet)
                    ->get();
                $payment_method = [];
                $bayar = [];
                foreach ($outlet_payment as $key => $payment) {
                    $payment_method[] = $payment->p_detail;
                    $val = implode("", explode(".", implode("", explode("Rp", implode("", explode(" ",$data[implode("_", explode(" ", $payment->p_detail))]))))));
                    $bayar[] = $val;
                }

                DB::commit();
                return response()->json([
                    'status' => 'sukses',
                    'payment_method' => $payment_method,
                    'payment' => $bayar,
                    'salesman' => $sales->m_name,
                    'idSales' => Crypt::encrypt($idsales),
                    'totHarga' => $totHarga,
                    'dibayar' => $data['total_pembayaran'],
                    'kembali' => $data['kembali']
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => 'gagal',
                    'data' => 'server gagal menyimpan',
                    'erorr' => $e
                ]);
            }
        }

    }

    public function detailpembayaran($total = null)
    {
        $outlet = Auth::user()->m_comp;
        $outlet_payment = DB::table('d_outlet_payment')
                            ->join('m_pembayaran', 'd_outlet_payment.op_pembayaran', '=', 'm_pembayaran.p_id')
                            ->where('d_outlet_payment.op_outlet', $outlet)
                            ->get();
        $payment_method = [];
        foreach ($outlet_payment as $key => $payment) {
            $payment_method[] = implode("_", explode(" ", $payment->p_detail));
        }

        return view('penjualan.penjualan-regular.detailPembayaran', compact('total', 'payment_method'));
    }

    public function struck($salesman = null, $id = null, $totHarga = null, $payment_method = array(), $payment = array(), $dibayar = null, $kembali = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $datas = DB::table('d_sales')
                ->select('m_company.c_name as nama_outlet', 'm_company.c_address as alamat_outlet', 'd_sales.s_nota as nota', 'm_member.m_name as nama_member', 'm_member.m_telp as telp_member', 'd_sales.s_date as tanggal', 'd_sales_dt.sd_qty as qty', 'd_item.i_code', 'd_item.i_nama as nama_item', 'd_sales_dt.sd_value as total_item', 'd_sales_dt.sd_total_net as total', DB::raw('coalesce(concat(" (", sm_specificcode, ")"), "") as specificcode'))
                ->where('d_sales.s_id', $id)
                ->join('d_sales_dt', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id')
                ->join('m_company', 'm_company.c_id', '=', 'd_sales.s_comp')
                ->join('m_member', 'm_member.m_id', '=', 'd_sales.s_member')
                ->join('d_item', 'd_item.i_id', '=', 'd_sales_dt.sd_item')
                ->join('d_stock', 'd_sales_dt.sd_item', '=', 'd_stock.s_item')
                ->join('d_stock_mutation', function($x){
                    $x->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
                })
                ->where('d_stock_mutation.sm_detail', '=', 'PENGURANGAN')
                ->groupBy(['d_sales_dt.sd_detailid', 'd_stock_mutation.sm_specificcode'])
                ->distinct('d_stock_mutation.sm_specificcode')
                ->get();

        if ($datas == null) {
            return view('errors/404');
        }

        return view('penjualan.penjualan-regular.struk')->with(compact('datas', 'salesman', 'totHarga', 'payment_method', 'payment', 'dibayar', 'kembali'));
    }

    public function detailpembayaranTempo($total = null)
    {
        $outlet = Auth::user()->m_comp;
        $outlet_payment = DB::table('d_outlet_payment')
            ->join('m_pembayaran', 'd_outlet_payment.op_pembayaran', '=', 'm_pembayaran.p_id')
            ->where('d_outlet_payment.op_outlet', $outlet)
            ->get();
        $payment_method = [];
        foreach ($outlet_payment as $key => $payment) {
            $payment_method[] = implode("_", explode(" ", $payment->p_detail));
        }

        return view('penjualan.penjualan-tempo.detailPembayaran', compact('total', 'payment_method'));
    }

    public function struckTempo($salesman = null, $id = null, $totHarga = null, $payment_method = array(), $payment = array(), $dibayar = null, $kembali = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $datas = DB::table('d_sales')
            ->select('m_company.c_name as nama_outlet', 'm_company.c_address as alamat_outlet', 'd_sales.s_nota as nota', 'm_member.m_name as nama_member', 'm_member.m_telp as telp_member', 'd_sales.s_date as tanggal', 'd_sales_dt.sd_qty as qty', 'd_item.i_code', 'd_item.i_nama as nama_item', 'd_sales_dt.sd_value as total_item', 'd_sales_dt.sd_total_net as total', DB::raw('coalesce(concat(" (", sm_specificcode, ")"), "") as specificcode'))
            ->where('d_sales.s_id', $id)
            ->join('d_sales_dt', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id')
            ->join('m_company', 'm_company.c_id', '=', 'd_sales.s_comp')
            ->join('m_member', 'm_member.m_id', '=', 'd_sales.s_member')
            ->join('d_item', 'd_item.i_id', '=', 'd_sales_dt.sd_item')
            ->join('d_stock', 'd_sales_dt.sd_item', '=', 'd_stock.s_item')
            ->join('d_stock_mutation', function($x){
                $x->on('d_stock_mutation.sm_stock', '=', 'd_stock.s_id');
            })
            ->where('d_stock_mutation.sm_detail', '=', 'PENGURANGAN')
            ->groupBy(['d_sales_dt.sd_detailid', 'd_stock_mutation.sm_specificcode'])
            ->distinct('d_stock_mutation.sm_specificcode')
            ->get();

        if ($datas == null) {
            return view('errors/404');
        }

        return view('penjualan.penjualan-tempo.struk')->with(compact('datas', 'salesman', 'totHarga', 'payment_method', 'payment', 'dibayar', 'kembali'));
    }

    public function deleteItem($sales = null, $item = null, $code)
    {
        try {
            $sales = Crypt::decrypt($sales);
        } catch (DecryptException $e) {
            return json_encode([
                'result'    => "false"
            ]);
        }

        try {
            $item = Crypt::decrypt($item);
        } catch (DecryptException $e) {
            return json_encode([
                'result'    => "false"
            ]);
        }

        DB::beginTransaction();
        try{
            $getSales = DB::table('d_sales')->where('s_id', $sales)->first();

            if ($code == "null") {
                $stockMutasi = DB::table('d_stock_mutation')
                    ->where('sm_nota', $getSales->s_nota)
                    ->where('sm_specificcode', null)
                    ->where('sm_detail', 'PENGURANGAN')->get();
            } else {
                $stockMutasi = DB::table('d_stock_mutation')
                    ->where('sm_nota', $getSales->s_nota)
                    ->where('sm_specificcode', $code)
                    ->where('sm_detail', 'PENGURANGAN')->get();
            }

            foreach ($stockMutasi as $index => $sm){

                $getMutasi = DB::table('d_stock_mutation')
                    ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                    ->where('sm_specificcode', $stockMutasi[$index]->sm_specificcode)
                    ->where('sm_nota', $stockMutasi[$index]->sm_reff)
                    ->where('sm_hpp', $stockMutasi[$index]->sm_hpp)->first();

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
                        ->where('sm_nota', $getSales->s_nota)
                        ->where('sm_specificcode', $stockMutasi[$index]->sm_specificcode)
                        ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                        ->where('sm_detail', 'PENGURANGAN')->delete();

                    // delete d_sales_dt & d_sales
                    DB::table('d_sales_dt')
                        ->where('sd_sales', $sales)
                        ->where('sd_item', $item)
                        ->where('sd_specificcode', $code)
                        ->delete();

                    $check_sales = DB::table('d_sales_dt')
                        ->where('sd_sales', $sales)
                        ->count();

                    if ($check_sales == 0) {
                        DB::table('d_sales')
                            ->where('s_id', $sales)
                            ->delete();

                        $msg = "null";
                    } else {
                        $msg = "available";
                    }
                } else {
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

                    // update dstock
                    $dstock = DB::table('d_stock')->where('s_id', $stockMutasi[$index]->sm_stock)->first();

                    DB::table('d_stock')->where('s_id', $stockMutasi[$index]->sm_stock)->update([
                        's_qty' => $dstock->s_qty + $stockMutasi[$index]->sm_qty
                    ]);

                    // delete stock mutasi
                    DB::table('d_stock_mutation')
                        ->where('sm_nota', $getSales->s_nota)
                        ->where('sm_specificcode', $stockMutasi[$index]->sm_specificcode)
                        ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                        ->where('sm_detail', 'PENGURANGAN')->delete();

                    // delete d_sales_dt & d_sales
                    DB::table('d_sales_dt')
                        ->where('sd_sales', $sales)
                        ->where('sd_item', $item)
                        ->where('sd_specificcode', null)
                        ->delete();

                    $check_sales = DB::table('d_sales_dt')
                        ->where('sd_sales', $sales)
                        ->count();

                    if ($check_sales == 0) {
                        DB::table('d_sales')
                            ->where('s_id', $sales)
                            ->delete();

                        $msg = "null";
                    } else {
                        $msg = "available";
                    }
                }
            }
            DB::commit();
            return json_encode([
                'result'    => "ok",
                'msg'       => $msg
            ]);
        }catch (\Exception $e){
            DB::rollback();
            return json_encode([
                'result'    => "false"
            ]);
        }
    }

    public function delete($id = null)
    {
        $getMutasi = null;
        try{
            $id = Crypt::decrypt($id);
        }catch (DecryptException $r){
            return json_encode('Not Found');
        }

        DB::beginTransaction();
        try{
            $getSales = DB::table('d_sales')->where('s_id', $id)->first();

            $stockMutasi = DB::table('d_stock_mutation')->where('sm_nota', $getSales->s_nota)->where('sm_detail', 'PENGURANGAN')->get();

            foreach ($stockMutasi as $index => $sm){

                $getMutasi = DB::table('d_stock_mutation')
                    ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                    ->where('sm_specificcode', $stockMutasi[$index]->sm_specificcode)
                    ->where('sm_nota', $stockMutasi[$index]->sm_reff)
                    ->where('sm_hpp', $stockMutasi[$index]->sm_hpp)->first();

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
                        ->where('sm_nota', $getSales->s_nota)
                        ->where('sm_specificcode', $stockMutasi[$index]->sm_specificcode)
                        ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                        ->where('sm_detail', 'PENGURANGAN')->delete();

                    // delete d_sales_dt & d_sales
                    DB::table('d_sales_dt')->where('sd_sales', $id)->delete();
                    DB::table('d_sales')->where('s_id', $id)->delete();
                } else {
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

                    // update dstock
                    $dstock = DB::table('d_stock')->where('s_id', $stockMutasi[$index]->sm_stock)->first();

                    DB::table('d_stock')->where('s_id', $stockMutasi[$index]->sm_stock)->update([
                        's_qty' => $dstock->s_qty + $stockMutasi[$index]->sm_qty
                    ]);

                    // delete stock mutasi
                    DB::table('d_stock_mutation')
                        ->where('sm_nota', $getSales->s_nota)
                        ->where('sm_specificcode', $stockMutasi[$index]->sm_specificcode)
                        ->where('sm_stock', $stockMutasi[$index]->sm_stock)
                        ->where('sm_detail', 'PENGURANGAN')->delete();

                    // delete d_sales_dt & d_sales
                    DB::table('d_sales_dt')->where('sd_sales', $id)->delete();
                    DB::table('d_sales')->where('s_id', $id)->delete();
                }
            }

            DB::commit();
            return 'true';
        }catch (\Exception $e){
            DB::rollback();
            return 'false';
        }
    }
    
}
