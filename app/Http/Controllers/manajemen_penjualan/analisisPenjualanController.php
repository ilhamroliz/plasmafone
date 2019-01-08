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

class analisisPenjualanController extends Controller
{
    public function index()
    {
        if (PlasmafoneController::checkAkses(27, 'read') == false) {
            return view('errors.407');
        } else {
            return view('manajemen_penjualan.analisis_penjualan.index');
        }
    }

    public function analyze(Request $request)
    {
        $by = $request->nilai;
        $get1 = '';
        if ($by == 1) {
            $get1 = DB::table('d_sales')
                ->join('m_member', 'm_id', '=', 's_member')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->where()->get();
        } elseif ($by == 2) {
            $get1 = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->join('d_item', 'i_id', '=', 'sd_item')
                ->where()->get();
        } elseif ($by == 3) {
            $get1 = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->join('d_item', 'i_id', '=', 'sd_item')
                ->select(DB::raw('i_merk as cat'), DB::raw('IFNULL(SUM(sd_qty), 0) as qty'), DB::raw('IFNULL(ROUND(SUM(sd_total_net)), 0) as net'))
                ->groupBy('sd_item')->get();
        } elseif ($by == 4) {

        } elseif ($by == 5) {

        } elseif ($by == 6) {

        } elseif ($by == 7) {

        } elseif ($by == 8) {

        }

        return json_encode([
            'data' => $get1
        ]);
    }
}
