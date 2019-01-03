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

    public function cari_comp(Request $request)
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

    function tambah(Request $request)
    {
        if (PlasmafoneController::checkAkses(26, 'insert') == false) {
            return view('errors.407');
        } else {
            if ($request->isMethod('post')) {

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
