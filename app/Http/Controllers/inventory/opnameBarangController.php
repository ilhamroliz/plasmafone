<?php

namespace App\Http\Controllers\inventory;

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

class opnameBarangController extends Controller
{
    public function pusat()
    {
        if (PlasmafoneController::checkAkses(11, 'read') == false) {
            return view('errors.407');
        } else {
            return view('inventory.opname_barang.pusat');
        }
    }

    public function outlet()
    {
        if (PlasmafoneController::checkAkses(12, 'read') == false) {
            return view('errors.407');
        } else {
            return view('inventory.opname_barang.outlet');
        }
    }

    public function auto_comp_noPusat(Request $request)
    {
        $cari = $request->term;
        $company = Auth::user()->m_comp;
        if ($company != "PF00000001") {
            $comp = DB::table('m_company')
                ->select('c_id', 'c_name')
                ->whereRaw('c_name like "%' . $cari . '%"')
                ->where('c_id', $company)
                ->get();
        } else {
            $comp = DB::table('m_company')
                ->select('c_id', 'c_name')
                ->whereRaw("c_name like '%" . $cari . "%'")
                ->where('c_id', '!=', $company)->get();
        }

        if ($comp == null) {
            $hasilcomp[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($comp as $query) {
                $hasilcomp[] = [
                    'id' => $query->c_id,
                    'label' => $query->c_name
                ];
            }
        }
        return Response::json($hasilcomp);
    }

    public function get_approved()
    {

    }

    public function get_pending()
    {

    }

    public function cari_opname(Request $request)
    {

    }

    public function cari_item_stock(Request $request)
    {
        $idItem = $request->idItem;
        $idComp = $request->idComp;
        $getStock = DB::table('d_stock')
            ->leftjoin('d_stock_mutation', 'sm_stock', '=', 's_id')
            ->join('d_item', 'i_id', '=', 's_item')
            ->select('s_item', 's_position', DB::raw('IFNULL(SUM(sm_sisa), 0) as qty'), 'i_specificcode', 'i_expired')
            ->groupBy('s_item', 's_position')
            ->where('s_item', $idItem)
            // ->where('s_position', $idComp)
            ->get();

        return json_encode([
            'data' => $getStock
        ]);
    }

    public function get_stock_code(Request $request)
    {
        // dd($request);
        $idItem = $request->idItem;
        $getCode = DB::table('d_stock')
            ->join('d_stock_dt', 'sd_stock', '=', 's_id')
            ->select('sd_specificcode')
            ->where('s_item', $idItem)->get();

        // dd($getCode);
        return json_encode([
            'code' => $getCode
        ]);
    }

    public function detil_opname($id)
    {

    }

    public function form_tambah()
    {

    }

    public function tambah(Request $request)
    {
        dd($request);
    }

    public function approve_opname($id)
    {

    }

    public function delete_opname($id)
    {

    }

}
