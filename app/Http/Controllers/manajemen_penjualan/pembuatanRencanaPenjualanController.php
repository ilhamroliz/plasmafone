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

class pembuatanRencanaPenjualanController extends Controller
{
    function index()
    {
        if (PlasmafoneController::checkAkses(26, 'read') == false) {
            return view('errors.407');
        } else {
            return view('manajemen_penjualan.rencana_penjualan.index');
        }
    }

    public function auto_comp(Request $request)
    {
        $cari = $request->term;
        $comp = DB::select("select c_id, c_name from m_company where c_name like '%" . $cari . "%'");

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

    public function getDataId()
    {
        $date = explode(' ', Carbon::now('Asia/Jakarta'));
        $tgl = explode('-', $date[0]);

        $cekNota = '/' . $tgl[1] . '/' . $tgl[0];

        $cek = DB::table('d_sales_plan')
            ->select(DB::raw('select CAST(MID(sp_nota, 4, 3) AS UNSIGNED)'))
            ->whereRaw('sp_nota like "%' . $cekNota . '%"')->count();

        if ($cek == 0) {
            $temp = 1;
        } else {
            $temp = ($cek + 1);
        }

        $kode = sprintf("%03s", $temp);

        $tempKode = 'SP-' . $kode . $cekNota;
        return $tempKode;
    }

    function tambah(Request $request)
    {
        if (PlasmafoneController::checkAkses(26, 'insert') == false) {
            return view('errors.407');
        } else {
            if ($request->isMethod('post')) {

                DB::beginTransaction();
                try {

                    $idItem = $request->idItem;
                    $qty = $request->qtyItem;

                    $sp_comp = $request->trpCompId;
                    $sp_nota = $this->getDataId();
                    $sp_insert = Carbon::now('Asia/Jakarta');
                    $date = explode(' ', $sp_insert);
                    $sp_date = $date[0];

                    DB::table('d_sales_plan')->insert([
                        'sp_comp' => $sp_comp,
                        'sp_nota' => $sp_nota,
                        'sp_date' => $sp_date,
                        'sp_insert' => $sp_insert
                    ]);

                    $sp_id = DB::table('d_sales_plan')->select('sp_id')->max('sp_id');

                    $spd_array = array();
                    for ($i = 0; $i < count($idItem); $i++) {
                        $aray = ([
                            'spd_sales_plan' => $sp_id,
                            'spd_detailid' => $i + 1,
                            'spd_item' => $idItem[$i],
                            'spd_qty' => $qty[$i]
                        ]);
                        array_push($spd_array, $aray);
                    }

                    DB::table('d_sales_plan_dt')->insert($spd_array);

                    DB::commit();

                    return json_encode([
                        'status' => 'trpSukses'
                    ]);
                } catch (\Esception $e) {
                    DB::rollback();
                    return json_encode([
                        'status' => 'trpGagal'
                    ]);
                }

            }

            return view('manajemen_penjualan.rencana_penjualan.tambah');
        }
    }

    function edit(Request $request)
    {
        if (PlasmafoneController::checkAkses(26, 'update') == false) {
            return view('errors.407');
        } else {
            if ($request->isMethod('post')) {

                DB::beginTransaction();
                try {

                } catch (\Exception $e) {

                }

            }

            return view('manajemen_penjualan.rencana_penjualan.edit');
        }
    }


    function hapus(Request $request)
    {
        if (PlasmafoneController::checkAkses(26, 'delete') == false) {
            return view('errors.407');
        } else {



        }
    }
}
