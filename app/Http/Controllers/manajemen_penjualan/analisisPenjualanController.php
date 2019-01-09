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
            //=== Berdasarkan Usia PEMBELI
            $get1 = DB::table('d_sales')
                ->join('m_member', 'm_id', '=', 's_member')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->select(
                    DB::raw('CASE
                                WHEN TIMESTAMPDIFF(YEAR, m_birth, CURDATE()) <= 20 THEN "< 20 Tahun"
                                WHEN TIMESTAMPDIFF(YEAR, m_birth, CURDATE()) <= 30 THEN "< 30 Tahun"
                                WHEN TIMESTAMPDIFF(YEAR, m_birth, CURDATE()) <= 40 THEN "< 40 Tahun"
                                END AS cat'),
                    DB::raw('IFNULL(SUM(sd_qty), 0) as sd_qty'),
                    DB::raw('IFNULL(ROUND(SUM(sd_total_net)), 0) as sd_total_net')
                )
                ->groupBy('cat')
                ->orderBy('sd_qty', 'desc')->get();

        } elseif ($by == 2) {
            //=== Berdasarkan Harga ITEM
            $get1 = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->join('d_item', 'i_id', '=', 'sd_item')
                ->select(
                    DB::raw('CASE 
                                WHEN i_price <= 1000000 THEN "Kurang Dari 1jta"
                                WHEN i_price <= 2000000 AND i_price >= 1000000 THEN "1jta-an"
                                WHEN i_price <= 3000000 AND i_price >= 2000000 THEN "2jta-an"
                                END AS cat'),
                    DB::raw('IFNULL(SUM(sd_qty), 0) as sd_qty'),
                    DB::raw('IFNULL(ROUND(SUM(sd_total_net)), 0) as sd_total_net')
                )
                ->groupBy('cat')
                ->orderBy('sd_qty', 'desc')->get();

        } elseif ($by == 3) {
            //=== Berdasarkan Merek ITEM
            $get1 = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->join('d_item', 'i_id', '=', 'sd_item')
                ->select(
                    DB::raw('i_merk as cat'),
                    DB::raw('IFNULL(SUM(sd_qty), 0) as sd_qty'),
                    DB::raw('IFNULL(ROUND(SUM(sd_total_net)), 0) as sd_total_net')
                )
                ->groupBy('i_merk')
                ->orderBy('sd_qty', 'desc')->get();

        } elseif ($by == 4) {
            //=== Berdasarkan Jenis ITEM
            $get1 = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->join('d_item', 'i_id', '=', 'sd_item')
                ->select(
                    DB::raw('i_kelompok as cat'),
                    DB::raw('IFNULL(SUM(sd_qty), 0) as sd_qty'),
                    DB::raw('IFNULL(ROUND(SUM(sd_total_net)), 0) as sd_total_net')
                )
                ->groupBy('i_kelompok')
                ->orderBy('sd_qty', 'desc')->get();

        } elseif ($by == 5) {
            //=== Berdasarkan Warna ITEM

        } elseif ($by == 6) {
            //=== Berdasarkan Outlet PENJUALAN
            $get1 = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->join('m_company', 'c_id', '=', 's_comp')
                ->select(
                    DB::raw('c_name as cat'),
                    DB::raw('IFNULL(SUM(sd_qty), 0) as sd_qty'),
                    DB::raw('IFNULL(ROUND(SUM(sd_total_net)), 0) as sd_total_net')
                )
                ->groupBy('c_id')
                ->orderBy('sd_qty', 'desc')->get();

        } elseif ($by == 7) {
            //=== Berdasarkan Waktu PENJUALAN

        } elseif ($by == 8) {
            //=== Berdasarkan Sales PENJUALAN
            $get1 = DB::table('d_sales')
                ->join('d_sales_dt', 'sd_sales', '=', 's_id')
                ->join('d_mem', 'm_id', '=', 's_salesman')
                ->select(
                    DB::raw('m_name as cat'),
                    DB::raw('IFNULL(SUM(sd_qty), 0) as sd_qty'),
                    DB::raw('IFNULL(ROUND(SUM(sd_total_net)), 0) as sd_total_net')
                )
                ->groupBy('m_id')
                ->orderBy('sd_qty', 'desc')->get();

        }

        return json_encode([
            'data' => $get1
        ]);
    }
}
