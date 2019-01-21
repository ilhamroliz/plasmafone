<?php

namespace App\Http\Controllers\manajemen_penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController;
use Illuminate\Support\Facades\Crypt;

use DataTables;
use DB;
use Session;
use Auth;
use Carbon\Carbon;
use Response;


class monitoringPenjualanController extends Controller
{
    public function index()
    {
        if (PlasmafoneController::checkAkses(27, 'read') == false) {
            return view('errors.407');
        } else {
            $startDate = Carbon::now()->startOfMonth()->format('d/m/Y');
            $endDate = Carbon::now()->format('d/m/Y');
            return view('manajemen_penjualan.monitoring_penjualan.index')->with(compact('startDate', 'endDate'));
        }
    }

    public function realtime(Request $request)
    {
        // dd($request->hiddenCount[0]);
        $realtime = DB::table('d_sales')
            ->join('m_member', 'm_id', '=', 's_member')
            ->join('m_company', 'c_id', '=', 's_comp')
            ->select('s_date', 's_nota', 'm_name', 'c_name', 's_id')
            ->where('s_id', $request->hiddenCount)
            ->orderBy('s_date', 'desc')->get();

        return json_encode([
            'real' => $realtime
        ]);

        // return DataTables::of($realtime)
        //     ->addIndexColumn()
        //     ->addColumn('aksi', function ($realtime) {
        //         return '<div class="text-center"><button class="btn btn-circle btn-primary" onclick="detil(\'' . Crypt::encrypt($realtime->s_id) . '\')"><i class="glyphicon glyphicon-list"></i></button></div>';
        //     })
        //     ->rawColumns(['aksi'])
        //     ->make(true);
    }

    public function realtime_dt()
    {

    }

    public function realisasi(Request $request)
    {
        // $carbon = explode(' ', Carbon::now('Asia/Jakarta'));
        // $dash = explode('-', $carbon[0]);
        // $date = $dash[0] . '-' . $dash[1];
        $date = Carbon::now('Asia/Jakarta')->format('Y-m');
        $comp = $request->mpCompId;
        $realisasi = '';

        if ($request->tglAwal == "" && $request->tglAkhir == "" && $comp != "") {

            $realisasi = DB::table('d_sales_plan')
                ->join('m_company', 'c_id', '=', 'sp_comp')
                ->join('d_sales_plan_dt', 'spd_sales_plan', '=', 'sp_id')
                ->join('d_item', 'i_id', '=', 'spd_item')
                ->leftjoin('d_sales_dt', 'sd_item', '=', 'spd_item')
                ->select('sp_comp', 'c_name', 'sp_nota', 'i_nama', DB::raw('IFNULL(SUM(sd_qty), 0)  as qty'), 'spd_qty')
                ->whereRaw('sp_date like "%' . $date . '%"')
                ->where('sp_comp', $comp)
                ->groupBy('c_id', 'sp_nota', 'i_id')
                ->get();

        } elseif ($request->tglAwal != null && $request->tglAkhir != null && $comp == null) {

            $awal = explode('/', $request->tglAwal);
            $akhir = explode('/', $request->tglAkhir);
            $start = $awal[2] . '-' . $awal[1] . '-' . $awal[0];
            $end = $akhir[2] . '-' . $akhir[1] . '-' . $akhir[0];

            $realisasi = DB::table('d_sales_plan')
                ->join('m_company', 'c_id', '=', 'sp_comp')
                ->join('d_sales_plan_dt', 'spd_sales_plan', '=', 'sp_id')
                ->join('d_item', 'i_id', '=', 'spd_item')
                ->leftjoin('d_sales_dt', 'sd_item', '=', 'spd_item')
                ->select('c_name', 'sp_nota', 'i_nama', DB::raw('IFNULL(SUM(sd_qty), 0)  as qty'), 'spd_qty')
                ->where('sp_date', '>=', $start)
                ->where('sp_date', '<=', $end)
                ->groupBy('c_id', 'sp_nota', 'i_id')
                ->get();

        } elseif ($request->tglAwal != null && $request->tglAkhir != null && $comp != null) {

            $awal = explode('/', $request->tglAwal);
            $akhir = explode('/', $request->tglAkhir);
            $start = $awal[2] . '-' . $awal[1] . '-' . $awal[0];
            $end = $akhir[2] . '-' . $akhir[1] . '-' . $akhir[0];

            $realisasi = DB::table('d_sales_plan')
                ->join('m_company', 'c_id', '=', 'sp_comp')
                ->join('d_sales_plan_dt', 'spd_sales_plan', '=', 'sp_id')
                ->join('d_item', 'i_id', '=', 'spd_item')
                ->leftjoin('d_sales_dt', 'sd_item', '=', 'spd_item')
                ->select('c_name', 'sp_nota', 'i_nama', DB::raw('IFNULL(SUM(sd_qty), 0)  as qty'), 'spd_qty')
                ->where('sp_date', '>=', $start)
                ->where('sp_date', '<=', $end)
                ->where('sp_comp', $comp)
                ->groupBy('c_id', 'sp_nota', 'i_id')
                ->get();

        } else {

            $realisasi = DB::table('d_sales_plan')
                ->join('m_company', 'c_id', '=', 'sp_comp')
                ->join('d_sales_plan_dt', 'spd_sales_plan', '=', 'sp_id')
                ->join('d_item', 'i_id', '=', 'spd_item')
                ->leftjoin('d_sales_dt', 'sd_item', '=', 'spd_item')
                ->select('c_name', 'sp_nota', 'i_nama', DB::raw('IFNULL(SUM(sd_qty), 0)  as qty'), 'spd_qty')
                ->whereRaw('sp_date like "%' . $date . '%"')
                ->groupBy('c_id', 'sp_nota', 'i_id')
                ->get();

        }

        return json_encode([
            'data' => $realisasi
        ]);

    }

    public function outlet(Request $request)
    {
        // dd($request);
        $awal = '';
        $akhir = '';
        $outlet = '';

        if ($request->tglAwalOT != '' && $request->tglAkhirOT != '') {
            $daw = explode('/', $request->tglAwalOT);
            $dak = explode('/', $request->tglAkhirOT);

            $awal = $daw[2] . '-' . $daw[1] . '-' . $daw[0];
            $akhir = $dak[2] . '-' . $dak[1] . '-' . $dak[0];
        } else {
            $awal = Carbon::now()->startOfMonth()->format('Y-m-d');
            $akhir = Carbon::now()->format('Y-m-d');
        }

        $outlet = DB::table('m_company')
            ->leftjoin('d_sales', 's_comp', '=', 'c_id')
            ->leftjoin('d_sales_dt', 'sd_sales', '=', 's_id')
            ->select('c_name', DB::raw('IFNULL(SUM(sd_qty), 0) as qty'), DB::raw('IFNULL(SUM(s_total_net), 0) as net'))
            ->where('s_date', '>=', $awal)
            ->where('s_date', '<=', $akhir)
            ->groupBy('c_id')
            ->orderBy('qty', 'desc')
            ->get();       
        

        // dd($outlet);
        return json_encode([
            'data' => $outlet
        ]);
    }
}
