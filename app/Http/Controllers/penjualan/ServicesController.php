<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController as Access;
use App\Http\Controllers\CodeGenerator as GenerateCode;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;
use Response;
use DataTables;
Use Auth;

class ServicesController extends Controller
{
    public function index()
    {
        if (Access::checkAkses(21, 'read') == true) {
            return view('penjualan.service-barang.index');
        } else {
            return view('errors.404');
        }
    }

    public function getPending()
    {
        $data = DB::table('d_service_item')
            ->select('d_service_item.si_id as id', DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                'd_service_item.si_nota as nota', 'm_member.m_name as pelanggan')
            ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
            ->where('d_service_item.si_status', 'PENDING');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(21, 'delete') == false && Access::checkAkses(21, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Proses" onclick="proses(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-refresh"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getTolak()
    {
        $data = DB::table('d_service_item')
            ->select('d_service_item.si_id as id', DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                'd_service_item.si_nota as nota', 'm_member.m_name as pelanggan')
            ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
            ->where('d_service_item.si_status', 'TOLAK');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(21, 'delete') == false && Access::checkAkses(21, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Batalkan" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getProses()
    {
        $data = DB::table('d_service_item')
            ->select('d_service_item.si_id as id', DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                'd_service_item.si_nota as nota', 'm_member.m_name as pelanggan')
            ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
            ->where('d_service_item.si_status', 'PROSES');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(21, 'delete') == false && Access::checkAkses(21, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getDone()
    {
        $data = DB::table('d_service_item')
            ->select('d_service_item.si_id as id', DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                'd_service_item.si_nota as nota', 'm_member.m_name as pelanggan')
            ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
            ->where('d_service_item.si_status', 'DONE');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(21, 'delete') == false && Access::checkAkses(21, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Batalkan" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getDetailService($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return json_encode('Not Found');
        }

        $datas = DB::table('d_service_item')
            ->select(
                'm_company.c_name as position',
                DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as date'),
                'd_service_item.si_nota as nota_service',
                'd_service_item.si_notasales as nota_sales',
                'd_service_item.si_status as status',
                'm_member.m_name as buyer',
                'd_item.i_nama as item',
                'd_item.i_code as code',
                'd_service_itemdt.sid_qty as qty',
                'd_service_itemdt.sid_specificcode as specificcode',
                'd_service_itemdt.sid_note as note',
                'd_mem.m_name as officer'
            )
            ->where('d_service_item.si_id', $id)
            ->join('d_service_itemdt', 'd_service_item.si_id', '=', 'd_service_itemdt.sid_serviceitem')
            ->join('d_sales', 'd_sales.s_nota', '=', 'd_service_item.si_notasales')
            ->join('m_member', 'm_member.m_id', '=', 'd_service_item.si_mem')
            ->join('d_item', 'd_item.i_id', '=', 'd_service_itemdt.sid_item')
            ->join('m_company', 'd_service_item.si_position', '=', 'm_company.c_id')
            ->join('d_mem', 'd_service_itemdt.sid_mem', '=', 'd_mem.m_id')
            ->get();

        if ($datas == null) {
            return json_encode('Not Found');
        }

        return json_encode($datas);
    }

    public function add()
    {
        if (Access::checkAkses(21, 'insert') == true) {
            return view('penjualan.service-barang.add');
        } else {
            return view('errors.404');
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

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Service Barang" onclick="servicePenjualan(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-transfer"></i></button></div>';

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

    public function serviceBarang($idsales = null, $iditem = null, $spcode = null)
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

        return view('penjualan.service-barang.service')->with(compact('data'));
    }

    public function addService(Request $request)
    {
        try {
            $idsales = Crypt::decrypt($request->idsales);
        } catch (DecryptException $e) {
            return json_encode(['status' => 'not found']);
        }

        try {
            $iditem = Crypt::decrypt($request->iditem);
        } catch (DecryptException $e) {
            return json_encode(['status' => 'not found']);
        }

        $nota = GenerateCode::codeReturn('d_service_item', 'si_nota', 8, 10, 3, 'PB');

        $notasales = $request->nota;

        $qty = $request->qty;

        $kode = $request->kode;

        $note = strtoupper($request->ket);

        $comp = Auth::user()->m_comp;

        $petugas = Auth::user()->m_id;

        $date = Carbon::now('Asia/Jakarta');

        $idpelanggan = DB::table('d_sales')->where('s_id', $idsales)->first()->s_member;

        $sid = (DB::table('d_service_item')->max('si_id')) ? (DB::table('d_service_item')->max('si_id') + 1) : 1;

        $detailid = (DB::table('d_service_itemdt')->where('sid_serviceitem', $sid)->max('sid_detailid')) ? (DB::table('d_service_itemdt')->where('sid_serviceitem', $sid)->max('sid_detailid') + 1) : 1;

        DB::beginTransaction();
        try{
            $service[] = [
                'si_id' => $sid,
                'si_position' => $comp,
                'si_date' => $date,
                'si_nota' => $nota,
                'si_notasales' => $notasales,
                'si_mem' => $idpelanggan,
                'si_status' => 'PENDING'
            ];

            $item[] = [
                'sid_serviceitem' => $sid,
                'sid_detailid' => $detailid,
                'sid_item' => $iditem,
                'sid_qty' => $qty,
                'sid_specificcode' => $kode,
                'sid_note' => $note,
                'sid_mem' => $petugas
            ];

            DB::table('d_service_item')->insert($service);

            DB::table('d_service_itemdt')->insert($item);

            DB::commit();
            return json_encode(['status' => 'true']);
        }catch (\Exception $e){
            DB::rollback();
            return json_encode(['status' => 'false']);
        }
    }

    public function edit()
    {
        return view('penjualan.service-barang.edit');
    }
}
