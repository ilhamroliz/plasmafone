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

        $getStock = DB::table('d_item')
            ->leftjoin('d_stock', 's_item', '=', 'i_id')
            ->leftjoin('d_stock_mutation', 'sm_stock', '=', 's_id')
            ->select('s_item', 's_position', DB::raw('IFNULL(SUM(sm_sisa), 0) as qty'), 'i_specificcode', 'i_expired')
            ->groupBy('s_item', 's_position')
            ->where('s_item', $idItem)
            ->where('s_position', $idComp)
            ->get();

        $getCE = DB::table('d_item')
            ->select('i_id', 'i_specificcode', 'i_expired')
            ->where('i_id', $idItem)->get();

        $getHPP = DB::table('d_stock')
            ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
            ->select(DB::raw('CAST(MAX(sm_hpp) as UNSIGNED) as hpp'))
            ->where('s_item', $idItem)
            ->where('sm_detail', 'PENAMBAHAN')->get();

        // dd($getStock);
        return json_encode([
            'data' => $getStock,
            'hpp' => $getHPP,
            'ce' => $getCE
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

    public function get_cn(Request $request)
    {
        $getCN = DB::table('m_company')
            ->select('c_name')
            ->where('c_id', $request->cn)
            ->get();

        return json_encode([
            'cn' => $getCN
        ]);
    }

    public function detil_opname($id)
    {

    }

    public function form_tambah()
    {

    }

    public function getDataId($date)
    {
        $cekNota = $date;

        $cek = DB::table('d_opname')
            ->select(DB::raw('select CAST(MID(o_reff, 4, 3) AS UNSIGNED)'))
            ->whereRaw('o_reff like "%' . $cekNota . '%"')
            ->max('o_id');

        if ($cek == 0) {
            $temp = 1;
        } else {
            $temp = ($cek + 1);
        }

        $kode = sprintf("%03s", $temp);

        $tempKode = 'OP-' . $kode . '/' . $cekNota;
        return $tempKode;
    }

    public function tambah(Request $request)
    {
        DB::beginTransaction();
        try {
            $countId = DB::table('d_opname')->max('o_id');
            $o_id = $countId + 1;
            $o_comp = $request->idComp;
            $o_date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $date = Carbon::now('Asia/Jakarta')->format('d/m/Y');
            $o_reff = $this->getDataId($date);
            $o_mem = Auth::user()->m_id;

            $o_status = '';
            $o_action = '';
            if (Auth::user()->m_level < 5) {
                $o_status = 'DONE';
                if ($request->aksi == '1') {
                    $o_action = 'SYSTEM';
                } elseif ($request->aksi == '2') {
                    $o_action = 'REAL';
                }
            } else {
                $o_status = 'PENDING';
            }

            $o_note = $request->note;

            //// Jika tidak ada masukkan table
            DB::table('d_opname')
                ->insert([
                    'o_id' => $o_id,
                    'o_comp' => $o_comp,
                    'o_date' => $o_date,
                    'o_reff' => $o_reff,
                    'o_mem' => $o_mem,
                    'o_status' => $o_status,
                    'o_action' => $o_action,
                    'o_note' => $o_note
                ]);

            ///// Untuk Opname Detail
            $idItem = $request->idItem;
            $imeiR = $request->imeiR;
            $sd_array = array();
            $od_array = array();

            for ($i = 0; $i < count($imeiR); $i++) {
                $cek = DB::table('d_stock')
                    ->join('d_stock_dt', 'sd_stock', '=', 's_id')
                    ->where('sd_specificcode', $imeiR[$i])->count();

                if ($cek == 0) {
                    array_push($sd_array, $imeiR[$i]);
                }

                $aray = ([
                    'od_opname' => $o_id,
                    'od_detailid' => $i + 1,
                    'od_item' => $idItem,
                    'od_qty_real' => 1,
                    'od_qty_system' => $cek,
                    'od_specificcode' => $imeiR[$i]
                ]);
                array_push($od_array, $aray);
            }

            if (!empty($sd_array)) {
                $getIdS = DB::table('d_stock')->where('s_item', $idItem)->select('s_id')->first();
                $maxIdS = DB::table('d_stock_dt')->where('sd_stock', $getIdS->s_id)->max('sd_detailid');
                $usd_array = array();
                for ($j = 0; $j < count($sd_array); $j++) {
                    $aray = ([
                        'sd_stock' => $getIdS->s_id,
                        'sd_detailid' => $maxIdS + ($j + 1),
                        'sd_specificcode' => $sd_array[$j]
                    ]);
                    array_push($usd_array, $aray);
                }

                DB::table('d_stock_dt')->insert($usd_array);

            }

            DB::table('d_opname_dt')->insert($od_array);

            DB::commit();
            return json_encode([
                'status' => 'obSukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return json_encode([
                'status' => 'obGagal',
                'msg' => $e
            ]);
        }

    }

    public function approve_opname($id)
    {

    }

    public function delete_opname($id)
    {

    }

}
