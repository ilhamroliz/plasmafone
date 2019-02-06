<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController as Access;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;
use Response;
use DataTables;

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

    public function cariNotaPenjualan(Request $request)
    {
        $data = DB::table('d_sales')
            ->join('d_sales_dt', 'd_sales.s_id', 'd_sales_dt.sd_sales');

        if ($request->idmember != "") {
            $data->where('d_sales.s_member', $request->idmember);
        } else if ($request->kode != "") {
            $data->where('d_sales_dt.sd_specificcode', $request->kode);
        } else if ($request->nota != "") {
            $data->where('d_sales.s_nota', $request->nota);
        } else if ($request->tgl_awal != ""  && $request->tgl_akhir == "") {
            $data->where('d_sales.s_date', Carbon::parse($request->tglAwal)->format('Y-m-d'));
        } else if ($request->tgl_awal == "" && $request->tgl_akhir != "") {
            $data->where('d_sales.s_date', Carbon::parse($request->tgl_akhir)->format('Y-m-d'));
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

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Retun Penjualan" onclick="edit(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-transfer"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
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

    public function cariTanggal(Request $request)
    {
        $data = DB::table('d_sales')
            ->whereBetween('s_date', [Carbon::parse($request->tglAwal)->format('Y-m-d'), Carbon::parse($request->tglAkhir)->format('Y-m-d')]);

        return DataTables::of($data)

            ->addColumn('tanggal', function ($data){
                return Carbon::parse($data->s_date)->format('d-m-Y');
            })

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(20, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Retun Penjualan" onclick="edit(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-transfer"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function cariNotaMember(Request $request)
    {
        $data = DB::table('d_sales')
            ->where('s_member', $request->member);

        return DataTables::of($data)

            ->addColumn('tanggal', function ($data){
                return Carbon::parse($data->s_date)->format('d-m-Y');
            })

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(20, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Retun Penjualan" onclick="edit(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-transfer"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }
}
