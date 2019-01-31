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
    //// LAMAN AWAL
    public function pusat()
    {
        if (PlasmafoneController::checkAkses(11, 'read') == false) {
            return view('errors.407');
        } else {
            $date = Carbon::now()->format('d/m/Y');
            $outlet = DB::table('m_company')->select('c_id', 'c_name')->get();
            return view('inventory.opname_barang.pusat')->with(compact('date', 'outlet'));
        }
    }

    public function outlet()
    {
        if (PlasmafoneController::checkAkses(12, 'read') == false) {
            return view('errors.407');
        } else {
            $date = Carbon::now()->format('d/m/Y');
            $cid = Auth::user()->m_comp;
            $getCN = '';
            if ($cid != "PF00000001") {
                $getCN = DB::table('m_company')->select('c_name')->where('c_id', $cid)->first();
            }else{
                $getCN = DB::table('m_company')->where('c_id', '!=','PF00000001')->select('c_id', 'c_name')->get();
            }
            return view('inventory.opname_barang.outlet')->with(compact('date', 'getCN'));
        }
    }

    //////////////////////

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

    public function pencarian(Request $request)
    {

        $state = $request->x;
        $tglAwal = $request->awal;
        $tglAkhir = $request->akhir;
        $idItem = $request->ii;
        $idComp = $request->ic;
        $cabang = $request->cb;
        $pcr = '';

        if ($state == 'a') {

            if ($tglAwal != '' && $tglAkhir != '') {
                $pisahAw = explode('/', $tglAwal);
                $awal = $pisahAw[2] . '-' . $pisahAw[1] . '-' . $pisahAw[0];
                $pisahAkh = explode('/', $tglAkhir);
                $akhir = $pisahAkh[2] . '-' . $pisahAkh[1] . '-' . $pisahAkh[0];

                if ($idItem == '' && $idComp == '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir);

                } else if ($idItem != '' && $idComp == '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('od_item', $idItem);
                } else if ($idItem == '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('o_comp', $idComp);

                } else if ($idItem != '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('o_comp', $idComp)
                        ->where('od_item', $idItem);
                }

            } else {
                if ($idItem != '' && $idComp == '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('od_item', $idItem);

                } else if ($idItem == '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_comp', $idComp);

                } else if ($idItem != '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_comp', $idComp)
                        ->where('od_item', $idItem);

                } else {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE');
                }
            }

            if ($cabang == 'pus') {
            // dd($gappr);
                return DataTables::of($pcr)
                    ->addColumn('aksi', function ($pcr) {
                        $delete = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                        $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                        $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                        // $appr = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Approval" onclick="appr(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                        if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == false) {
                            return '<div class="text-center">' . $detail . '</div>';
                        } else if (PlasmafoneController::checkAkses(11, 'delete') == true && PlasmafoneController::checkAkses(11, 'update') == false) {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $delete . '</div>';
                        } else if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == true) {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '</div>';
                        } else {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                        }
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            } else {
                return DataTables::of($pcr)
                    ->addColumn('aksi', function ($pcr) {
                        $delete = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                        $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                        $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                        // $appr = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Approval" onclick="appr(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                        if (PlasmafoneController::checkAkses(12, 'delete') == false && PlasmafoneController::checkAkses(12, 'update') == false) {
                            return '<div class="text-center">' . $detail . '</div>';
                        } else if (PlasmafoneController::checkAkses(12, 'delete') == true && PlasmafoneController::checkAkses(12, 'update') == false) {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $delete . '</div>';
                        } else if (PlasmafoneController::checkAkses(12, 'delete') == false && PlasmafoneController::checkAkses(12, 'update') == true) {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '</div>';
                        } else {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                        }
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

        } else {
            if ($tglAwal != '' && $tglAkhir != '') {
                $pisahAw = explode('/', $tglAwal);
                $awal = $pisahAw[2] . '-' . $pisahAw[1] . '-' . $pisahAw[0];
                $pisahAkh = explode('/', $tglAkhir);
                $akhir = $pisahAkh[2] . '-' . $pisahAkh[1] . '-' . $pisahAkh[0];

                if ($idItem == '' && $idComp == '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir);

                } else if ($idItem != '' && $idComp == '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('od_item', 'o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('od_item', $idItem);

                } else if ($idItem == '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('o_comp', $idComp);

                } else if ($idItem != '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('od_item', 'o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('o_comp', $idComp)
                        ->where('od_item', $idItem);
                }

            } else {
                if ($idItem != '' && $idComp == '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('od_item', 'o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('od_item', $idItem);

                } else if ($idItem == '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_comp', $idComp);

                } else if ($idItem != '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('od_item', 'o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_comp', $idComp)
                        ->where('od_item', $idItem);

                } else {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING');
                }
            }

            if ($cabang == 'pus') {
            // dd($gappr);
                return DataTables::of($pcr)
                    ->addColumn('aksi', function ($pcr) {
                        $delete = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                        $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                        $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                        $appr = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Approval" onclick="appr(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                        if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == false) {
                            return '<div class="text-center">' . $detail . '</div>';
                        } else if (PlasmafoneController::checkAkses(11, 'delete') == true && PlasmafoneController::checkAkses(11, 'update') == false) {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $delete . '</div>';
                        } else if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == true) {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '</div>';
                        } else {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                        }
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            } else {
                return DataTables::of($pcr)
                    ->addColumn('aksi', function ($pcr) {
                        $delete = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                        $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                        $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                        $appr = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Approval" onclick="appr(\'' . Crypt::encrypt($pcr->o_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                        if (PlasmafoneController::checkAkses(12, 'delete') == false && PlasmafoneController::checkAkses(12, 'update') == false) {
                            return '<div class="text-center">' . $detail . '</div>';
                        } else if (PlasmafoneController::checkAkses(12, 'delete') == true && PlasmafoneController::checkAkses(12, 'update') == false) {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $delete . '</div>';
                        } else if (PlasmafoneController::checkAkses(12, 'delete') == false && PlasmafoneController::checkAkses(12, 'update') == true) {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '</div>';
                        } else {
                            return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                        }
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            }
        }

    }

    public function get_approved()
    {
        $date = Carbon::now()->format('d/m/Y');

        $gappr = DB::table('d_opname')
            ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
            ->join('m_company', 'c_id', '=', 'o_comp')
            ->join('d_item', 'i_id', '=', 'od_item')
            ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
            ->where('o_status', 'DONE')
            ->whereRaw('o_reff like "%'.$date.'%"');

        // dd($gappr);
        return DataTables::of($gappr)
            ->addColumn('aksi', function ($gappr) {
                $delete = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($gappr->o_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($gappr->o_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($gappr->o_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                // $appr = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Approval" onclick="appr(\'' . Crypt::encrypt($gappr->o_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == false) {
                    return '<div class="text-center">' . $detail . '</div>';
                } else if (PlasmafoneController::checkAkses(11, 'delete') == true && PlasmafoneController::checkAkses(11, 'update') == false) {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $delete . '</div>';
                } else if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == true) {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '</div>';
                } else {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_pending()
    {
        $date = Carbon::now()->format('d/m/Y');
        $gpend = DB::table('d_opname')
            ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
            ->join('m_company', 'c_id', '=', 'o_comp')
            ->join('d_item', 'i_id', '=', 'od_item')
            ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
            ->where('o_status', 'PENDING')
            ->whereRaw('o_reff like "%'.$date.'%"');

        // dd($gpend);
        return DataTables::of($gpend)
            ->addColumn('aksi', function ($gpend) {
                $delete = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($gpend->o_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($gpend->o_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($gpend->o_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                $appr = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Approval" onclick="appr(\'' . Crypt::encrypt($gpend->o_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == false) {
                    return '<div class="text-center">' . $detail . '</div>';
                } else if (PlasmafoneController::checkAkses(11, 'delete') == true && PlasmafoneController::checkAkses(11, 'update') == false) {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $delete . '</div>';
                } else if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == true) {
                    if (Auth::user()->m_level < 5) {
                        return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '</div>';
                    } else {
                        return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '</div>';
                    }
                } else {
                    if (Auth::user()->m_level < 5) {
                        return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                    } else {
                        return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                    }
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_approved_outlet()
    {
        $date = Carbon::now()->format('d/m/Y');
        $comp = Auth::user()->m_comp;
        if ($comp == "PF00000001") {
            $gappr = DB::table('d_opname')
                ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                ->join('m_company', 'c_id', '=', 'o_comp')
                ->join('d_item', 'i_id', '=', 'od_item')
                ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                ->where('o_status', 'DONE')
                ->where('o_comp', '!=', 'PF00000001')
                ->whereRaw('o_reff like "%'.$date.'%"');
        } else {
            $gappr = DB::table('d_opname')
                ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                ->join('m_company', 'c_id', '=', 'o_comp')
                ->join('d_item', 'i_id', '=', 'od_item')
                ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                ->where('o_status', 'DONE')
                ->where('o_comp', $comp)
                ->whereRaw('o_reff like "%'.$date.'%"');
        }

        // dd($gappr);
        return DataTables::of($gappr)
            ->addColumn('aksi', function ($gappr) {
                $delete = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($gappr->o_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($gappr->o_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($gappr->o_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                $appr = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Approval" onclick="appr(\'' . Crypt::encrypt($gappr->o_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == false) {
                    return '<div class="text-center">' . $detail . '</div>';
                } else if (PlasmafoneController::checkAkses(11, 'delete') == true && PlasmafoneController::checkAkses(11, 'update') == false) {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $delete . '</div>';
                } else if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == true) {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '</div>';
                } else {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_pending_outlet()
    {
        $date = Carbon::now()->format('d/m/Y');
        $comp = Auth::user()->m_comp;
        if ($comp == "PF00000001") {
            $gpend = DB::table('d_opname')
                ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                ->join('m_company', 'c_id', '=', 'o_comp')
                ->join('d_item', 'i_id', '=', 'od_item')
                ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                ->where('o_status', 'PENDING')
                ->where('o_comp', '!=', 'PF00000001')
                ->whereRaw('o_reff like "%'.$date.'%"');
        } else {
            $gpend = DB::table('d_opname')
                ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                ->join('m_company', 'c_id', '=', 'o_comp')
                ->join('d_item', 'i_id', '=', 'od_item')
                ->select('o_id', 'o_reff', DB::raw('DATE_FORMAT(o_date, "%d/%m/%Y") as o_date'), 'c_name', 'i_nama')->distinct('o_reff')
                ->where('o_status', 'PENDING')
                ->where('o_comp', $comp)
                ->whereRaw('o_reff like "%'.$date.'%"');
        }

        // dd($gpend);
        return DataTables::of($gpend)
            ->addColumn('aksi', function ($gpend) {
                $delete = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($gpend->o_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($gpend->o_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($gapend->o_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                $appr = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Approval" onclick="appr(\'' . Crypt::encrypt($gpend->o_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == false) {
                    return '<div class="text-center">' . $detail . '</div>';
                } else if (PlasmafoneController::checkAkses(11, 'delete') == true && PlasmafoneController::checkAkses(11, 'update') == false) {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $delete . '</div>';
                } else if (PlasmafoneController::checkAkses(11, 'delete') == false && PlasmafoneController::checkAkses(11, 'update') == true) {
                    if (Auth::user()->m_level < 5) {
                        return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '</div>';
                    } else {
                        return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '</div>';
                    }
                } else {
                    if (Auth::user()->m_level < 5) {
                        return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                    } else {
                        return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                    }
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
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

    public function detail(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        if($request->dt == "yes"){
            dd($request->dt);
            $dtDetil = DB::table('d_opname_dt')->where('od_id', $id)->select('od_specificcode');

            return DataTables::of($dtDetil)
                ->addIndexRow()
                ->make(true);
        }

        $detil = DB::table('d_opname_dt')
            ->leftjoin('d_opname', 'o_id', '=', 'od_opname')
            ->join('m_company', 'c_id', '=', 'o_comp')
            ->join('d_item', 'i_id', '=', 'od_item')
            ->join('d_mem', 'm_id', '=', 'o_mem')
            ->where('o_id', $id)
            ->select(
                'o_reff',
                'o_action',
                'od_specificcode',
                'c_name',
                'i_nama',
                'm_name',
                'i_specificcode',
                'i_expired',
                'od_qty_real',
                'od_qty_system'
            )
            ->get();

        // dd($detil);
        return json_encode([
            'data' => $detil
        ]);
    }

    public function getDataId($date)
    {
        $cekNota = $date;

        $cek = DB::table('d_opname')
            ->whereRaw('o_reff like "%'.$cekNota.'%"')
            ->select(DB::raw('CAST(MID(o_reff, 4, 3) AS UNSIGNED) as o_reff'))
            ->orderBy('o_id', 'desc')->first();

        if ($cek == null) {
            $temp = 1;
        } else {
            $temp = ($cek->o_reff + 1);
        }
        $kode = sprintf("%03s", $temp);

        $tempKode = 'OP-' . $kode . '/' . $cekNota;
        return $tempKode;
    }

    public function tambah(Request $request)
    {
        if (PlasmafoneController::checkAkses(11, 'insert') == false) {
            return view('errors.407');
        } else {
            if ($request->isMethod('post')) {
            // dd($request);
                DB::beginTransaction();
                try {
            ///?? INISIALISASI Variabel
                    $sc = $request->sc;
                    $ex = $request->ex;

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

                    //// Insert Data ke D_OPNAME
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

                    ////////////////////////////////////////////////
                    ////////////////////////////////////////////////

                    //+++ INSERT OPNAME DT
                    //////////////////////
                    // HANYA dilakukan jika Spec Code == Y
                    // SEMUA data Tabel MASUK SEMUA ke tabel D_OPNAME_DT

                    $idItem = $request->idItem;
                    $idCompM = Auth::user()->m_comp;
                    $imeiR = $request->imeiR;
                    $getSell = DB::table('d_item')->where('i_id', $idItem)->select('i_price')->first();

                    // MEMBUAT D_STOCK Baru jika item untuk lokasi tersebut belum ada di D_STOCK
                    $cekStockExist = DB::table('d_stock')->where('s_item', $idItem)->where('s_position', $o_comp)->count();
                    if ($cekStockExist == 0) {
                        $getMaxStock = DB::table('d_stock')->max('s_id');
                        DB::table('d_stock')->insert([
                            's_id' => $getMaxStock + 1, 's_comp' => $o_comp, 's_position' => $o_comp, 's_item' => $idItem, 's_qty' => 0
                        ]);
                    }

                    $getIdS = DB::table('d_stock')->where('s_item', $idItem)->where('s_position', $o_comp)->select('s_id')->first();

                    if ($sc == 'Y' && $ex == 'N' || $sc == 'Y' && $ex == 'Y') {

                        $sd_array = array();
                        $od_array = array();

                        for ($i = 0; $i < count($imeiR); $i++) {
                            $cek = DB::table('d_stock')
                                ->join('d_stock_dt', 'sd_stock', '=', 's_id')
                                ->where('sd_specificcode', $imeiR[$i])->count();

                            //// Jika Data Item tersebut tidak ada di dalam sistem
                            if ($cek == 0) {
                                array_push($sd_array, $imeiR[$i]);
                            }
                            //////////////////////////////////////////////////////
                            $aray = ([
                                'od_opname' => $o_id,
                                'od_detailid' => $i + 1,
                                'od_item' => $idItem,
                                'od_qty_real' => 1,
                                'od_qty_system' => $cek,
                                'od_specificcode' => strtoupper($imeiR[$i])
                            ]);
                            array_push($od_array, $aray);
                        }

                        DB::table('d_opname_dt')->insert($od_array);

                        /////
                        ////////////////////////////////////////////
                        // ///// UPDATE pada data D_STOCK_DT
                        // ///// Jika Barang tidak memiliki IMEI maka Tidak memasukan ke D_STOCK_DT

                        // Cek untuk Barang Di SISTEM yang tidak ada dalam list REAL
                        $getDH = DB::table('d_stock_dt')
                            ->join('d_stock', 's_id', '=', 'sd_stock')
                            ->where('s_item', $idItem)
                            ->whereNotIn('sd_specificcode', $imeiR)
                            ->select('sd_specificcode')
                            ->get();
                        $arayDH = array();
                        foreach ($getDH as $gdh) {
                            array_push($arayDH, $gdh->sd_specificcode);
                        }

                        // Cek untuk Barang REAL yang tidak ada didalam tabel Barang SISTEM
                        $arayDT = array();
                        for ($rt = 0; $rt < count($imeiR); $rt++) {
                            $cekLebih = DB::table('d_stock_dt')->where('sd_specificcode', $imeiR[$rt])->count();
                            if ($cekLebih == 0) {
                                array_push($arayDT, $imeiR[$rt]);
                            }
                        }


                        /// HAPUS di D_STOCK_DT
                        DB::table('d_stock_dt')->whereIn('sd_specificcode', $arayDH)->delete();

                        /// TAMBAH di D_STOCK_DT
                        $countSD = DB::table('d_stock_dt')->where('sd_stock', $getIdS->s_id)->count();
                        // dd($countSD);

                        $getMax = '';
                        if ($countSD == 0) {
                            $getMax = 0;
                        } else {
                            $getMax = DB::table('d_stock_dt')->where('sd_stock', $getIdS->s_id)->max('sd_detailid');
                        }

                        $arayInsert = array();
                        for ($dt = 0; $dt < count($arayDT); $dt++) {
                            $aray = ([
                                'sd_stock' => $getIdS->s_id,
                                'sd_detailid' => $getMax + ($dt + 1),
                                'sd_specificcode' => strtoupper($arayDT[$dt])
                            ]);
                            array_push($arayInsert, $aray);
                        }
                        DB::table('d_stock_dt')->insert($arayInsert);


                        /////
                        ////////////////////////////////////////////
                        // ///// UPDATE pada data D_STOCK_MUTATION
                        // ///// Mekanisme PENAMBAHAN Barang
                        $countTB = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->count();
                        if ($countTB == 0) {
                            $getMaxSMT = 0;
                        } else {
                            $getMaxSMT = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->max('sm_detailid');
                        }

                        $arayInsPNB = array();
                        for ($dt = 0; $dt < count($arayDT); $dt++) {
                            $arayT = ([
                                'sm_stock' => $getIdS->s_id,
                                'sm_detailid' => $getMaxSMT + ($dt + 1),
                                'sm_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d h:i:s'),
                                'sm_detail' => 'PENAMBAHAN',
                                'sm_specificcode' => strtoupper($arayDT[$dt]),
                                'sm_qty' => 1,
                                'sm_use' => 0,
                                'sm_sisa' => 1,
                                'sm_hpp' => implode(explode('.', $request->hpp)),
                                'sm_sell' => $getSell->i_price,
                                'sm_nota' => $o_reff,
                                'sm_reff' => $o_reff,
                                'sm_mem' => Auth::user()->m_id
                            ]);
                            array_push($arayInsPNB, $arayT);
                        }
                        DB::table('d_stock_mutation')->insert($arayInsPNB);

                        if (!empty($arayDH)) {
                    /// Ambil SM_REFF untuk Specifik Code yang sama pada PENAMBAHAN
                            $getReff = DB::table('d_stock_mutation')->whereIn('sm_specificcode', $arayDH)->select('sm_reff')->get();

                    /// Update SM_USE dan SM_SISA menjadi 1 dan 0
                            DB::table('d_stock_mutation')->whereIn('sm_specificcode', $arayDH)->update(['sm_use' => 1, 'sm_sisa' => 0]);
                            $date = Carbon::now('Asia/Jakarta')->format('Y-m-d h:i:s');
                            $getMaxSMH = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->max('sm_detailid');

                    /// Masukkan Data Pengurangan ke Dalam STOCK MUTATION
                            $arayInsPGR = array();
                            for ($dk = 0; $dk < count($arayDH); $dk++) {

                                $arayK = ([
                                    'sm_stock' => $getIdS->s_id,
                                    'sm_detailid' => $getMaxSMH + ($dk + 1),
                                    'sm_date' => $date,
                                    'sm_detail' => 'PENGURANGAN',
                                    'sm_specificcode' => strtoupper($arayDH[$dk]),
                                    'sm_qty' => 1,
                                    'sm_use' => 1,
                                    'sm_sisa' => 0,
                                    'sm_hpp' => $request->hpp,
                                    'sm_sell' => $getSell->i_price,
                                    'sm_nota' => $o_reff,
                                    'sm_reff' => $getReff[$dk]->sm_reff,
                                    'sm_mem' => Auth::user()->m_id
                                ]);
                                array_push($arayInsPGR, $arayK);
                            }
                            DB::table('d_stock_mutation')->insert($arayInsPGR);
                        }

                        DB::table('d_stock')->where('s_id', $getIdS->s_id)->update(['s_qty' => count($imeiR)]);

                    } else {

                        $pisah = explode(' ', $request->qtyR);
                        $qtyR = $pisah[0];
                        $pisah2 = explode(' ', $request->qtyS);
                        $qtyS = $pisah2[0];
                        $qtyExp = $request->qty;
                        $qty = '';

                        if ($qtyR != '' || $qtyR != null) {
                            $qty = $qtyR;
                        } else {
                            $qty = 0;
                            for ($c = 0; $c < count($qtyExp); $c++) {
                                $qty = $qty + intval($qtyExp[$c]);
                            }
                        }

                        $cekS = DB::table('d_stock')->where('s_item', $idItem)->select('s_qty')->first();

                        DB::table('d_opname_dt')->insert([
                            'od_opname' => $o_id,
                            'od_detailid' => 1,
                            'od_item' => $idItem,
                            'od_qty_real' => $qty,
                            'od_qty_system' => $cekS->s_qty,
                        ]);


                /// UPDATE STOCK MUTASI untuk barang yang tidak memiliki SPESIFIK KODE
                /// == PENAMBAHAN
                        if ($qtyR > $qtyS) {
                            $getMaxSMT = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->max('sm_detailid');
                            DB::table('d_stock_mutation')->insert([
                                'sm_stock' => $getIdS->s_id,
                                'sm_detailid' => $getMaxSMT + 1,
                                'sm_date' => Carbon::now('Asia/Jakarta'),
                                'sm_detail' => 'PENAMBAHAN',
                                'sm_qty' => $qtyR - $qtyS,
                                'sm_use' => 0,
                                'sm_sisa' => $qtyR - $qtyS,
                                'sm_hpp' => implode(explode('.', $request->hpp)),
                                'sm_sell' => $getSell->i_price,
                                'sm_nota' => $o_reff,
                                'sm_reff' => $o_reff,
                                'sm_mem' => Auth::user()->m_id
                            ]);
                        } else {

                    /// == PENGURANGAN
                            $data = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->where('sm_sisa', '!=', 0)->get();

                            for ($smc = 0; $smc < count($data); $smc++) {

                                $opk = abs($qtyR - $qtyS);

                                if ($data[$smc]->sm_sisa < $opk) {

                                    DB::table('d_stock_mutation')
                                        ->where('sm_stock', $data[$smc]->sm_stock)
                                        ->where('sm_detail_id', $data[$smc]->sm_detailid)
                                        ->update([
                                            'sm_use' => $data[$smc]->sm_qty,
                                            'sm_sisa' => 0
                                        ]);

                                    $opk = $opk - $data[$smc]->sm_sisa;
                                    $getMax = DB::table('d_stock_mutation')->where('sm_stock', $data[$smc]->sm_stock)->max('sm_detailid');
                                    DB::table('d_stock_mutation')->insert([
                                        'sm_stock' => $getIdS->s_id,
                                        'sm_detailid' => $getMax + 1,
                                        'sm_date' => Carbon::now('Asia/Jakarta'),
                                        'sm_detail' => 'PENGURANGAN',
                                        'sm_qty' => $data[$smc]->sm_qty,
                                        'sm_use' => 0,
                                        'sm_sisa' => 0,
                                        'sm_hpp' => $data[$smc]->sm_hpp,
                                        'sm_sell' => $getSell->i_price,
                                        'sm_nota' => $o_reff,
                                        'sm_reff' => $data[$smc]->sm_nota,
                                        'sm_mem' => Auth::user()->m_id
                                    ]);

                                } else {

                                    $use = $opk + $data[$smc]->sm_use;
                                    $sisa = $data[$smc]->sm_qty - $use;

                                    DB::table('d_stock_mutation')
                                        ->where('sm_stock', $data[$smc]->sm_stock)
                                        ->where('sm_detailid', $data[$smc]->sm_detailid)
                                        ->update([
                                            'sm_use' => $use,
                                            'sm_sisa' => $sisa
                                        ]);

                                    $getMax = DB::table('d_stock_mutation')->where('sm_stock', $data[$smc]->sm_stock)->max('sm_detailid');
                                    DB::table('d_stock_mutation')->insert([
                                        'sm_stock' => $getIdS->s_id,
                                        'sm_detailid' => $getMax + 1,
                                        'sm_date' => Carbon::now('Asia/Jakarta'),
                                        'sm_detail' => 'PENGURANGAN',
                                        'sm_qty' => $opk,
                                        'sm_use' => 0,
                                        'sm_sisa' => 0,
                                        'sm_hpp' => $data[$smc]->sm_hpp,
                                        'sm_sell' => $getSell->i_price,
                                        'sm_nota' => $o_reff,
                                        'sm_reff' => $data[$smc]->sm_nota,
                                        'sm_mem' => Auth::user()->m_id
                                    ]);

                                    $smc = count($data) + 1;
                                }
                            }
                        }
                    }

                    $log = 'Menambahkan Opname Barang pada PLASMAFONE PUSAT dengan nota ' . $o_reff;
                    DB::commit();
                    PlasmafoneController::logActivity($log);
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

            return view('inventory.opname_barang.tambah');
        }

    }

    public function tambahOutlet(Request $request)
    {
        if (PlasmafoneController::checkAkses(12, 'insert') == false) {
            return view('errors.407;');
        } else {
            if ($request->isMethod('post')) {
                // dd($request);
                DB::beginTransaction();
                try {
            ///?? INISIALISASI Variabel
                    $sc = $request->sc;
                    $ex = $request->ex;

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

                    //// Insert Data ke D_OPNAME
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

                    ////////////////////////////////////////////////
                    ////////////////////////////////////////////////

                    //+++ INSERT OPNAME DT
                    //////////////////////
                    // HANYA dilakukan jika Spec Code == Y
                    // SEMUA data Tabel MASUK SEMUA ke tabel D_OPNAME_DT

                    $idItem = $request->idItem;
                    $idCompM = Auth::user()->m_comp;
                    $imeiR = $request->imeiR;
                    $getSell = DB::table('d_item')->where('i_id', $idItem)->select('i_price')->first();

                    // MEMBUAT D_STOCK Baru jika item untuk lokasi tersebut belum ada di D_STOCK
                    $cekStockExist = DB::table('d_stock')->where('s_item', $idItem)->where('s_position', $o_comp)->count();
                    if ($cekStockExist == 0) {
                        $getMaxStock = DB::table('d_stock')->max('s_id');
                        DB::table('d_stock')->insert([
                            's_id' => $getMaxStock + 1, 's_comp' => $o_comp, 's_position' => $o_comp, 's_item' => $idItem, 's_qty' => 0
                        ]);
                    }

                    $getIdS = DB::table('d_stock')->where('s_item', $idItem)->where('s_position', $o_comp)->select('s_id')->first();
                    // dd($getIdS);
                    if ($sc == 'Y' && $ex == 'N' || $sc == 'Y' && $ex == 'Y') {

                        $sd_array = array();
                        $od_array = array();

                        for ($i = 0; $i < count($imeiR); $i++) {
                            $cek = DB::table('d_stock')
                                ->join('d_stock_dt', 'sd_stock', '=', 's_id')
                                ->where('sd_specificcode', $imeiR[$i])->count();

                            //// Jika Data Item tersebut tidak ada di dalam sistem
                            if ($cek == 0) {
                                array_push($sd_array, $imeiR[$i]);
                            }
                            //////////////////////////////////////////////////////

                            $aray = ([
                                'od_opname' => $o_id,
                                'od_detailid' => $i + 1,
                                'od_item' => $idItem,
                                'od_qty_real' => 1,
                                'od_qty_system' => $cek,
                                'od_specificcode' => strtoupper($imeiR[$i])
                            ]);
                            array_push($od_array, $aray);
                        }

                        DB::table('d_opname_dt')->insert($od_array);

                        /////
                        ////////////////////////////////////////////
                        // ///// UPDATE pada data D_STOCK_DT
                        // ///// Jika Barang tidak memiliki IMEI maka Tidak memasukan ke D_STOCK_DT

                        // Cek untuk Barang Di SISTEM yang tidak ada dalam list REAL
                        $getDH = DB::table('d_stock_dt')
                            ->join('d_stock', 's_id', '=', 'sd_stock')
                            ->where('s_item', $idItem)
                            ->whereNotIn('sd_specificcode', $imeiR)
                            ->select('sd_specificcode')
                            ->get();
                        $arayDH = array();
                        foreach ($getDH as $gdh) {
                            array_push($arayDH, $gdh->sd_specificcode);
                        }

                        // Cek untuk Barang REAL yang tidak ada didalam tabel Barang SISTEM
                        $arayDT = array();
                        for ($rt = 0; $rt < count($imeiR); $rt++) {
                            $cekLebih = DB::table('d_stock_dt')->where('sd_specificcode', $imeiR[$rt])->count();
                            if ($cekLebih == 0) {
                                array_push($arayDT, $imeiR[$rt]);
                            }
                        }

                        /// HAPUS di D_STOCK_DT
                        DB::table('d_stock_dt')->whereIn('sd_specificcode', $arayDH)->delete();
                        // dd($getIdS->s_id);

                        /// TAMBAH di D_STOCK_DT
                        $countSD = DB::table('d_stock_dt')->where('sd_stock', $getIdS->s_id)->count();
                        // dd($countSD);

                        $getMax = '';
                        if ($countSD == 0) {
                            $getMax = 0;
                        } else {
                            $getMax = DB::table('d_stock_dt')->where('sd_stock', $getIdS->s_id)->max('sd_detailid');
                        }

                        $arayInsert = array();
                        for ($dt = 0; $dt < count($arayDT); $dt++) {
                            $aray = ([
                                'sd_stock' => $getIdS->s_id,
                                'sd_detailid' => $getMax + ($dt + 1),
                                'sd_specificcode' => strtoupper($arayDT[$dt])
                            ]);
                            array_push($arayInsert, $aray);
                        }
                        DB::table('d_stock_dt')->insert($arayInsert);


                        /////
                        ////////////////////////////////////////////
                        // ///// UPDATE pada data D_STOCK_MUTATION
                        // ///// Mekanisme PENAMBAHAN Barang
                        $countTB = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->count();
                        if ($countTB == 0) {
                            $getMaxSMT = 0;
                        } else {
                            $getMaxSMT = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->max('sm_detailid');
                        }

                        $arayInsPNB = array();
                        for ($dt = 0; $dt < count($arayDT); $dt++) {
                            $arayT = ([
                                'sm_stock' => $getIdS->s_id,
                                'sm_detailid' => $getMaxSMT + ($dt + 1),
                                'sm_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d h:i:s'),
                                'sm_detail' => 'PENAMBAHAN',
                                'sm_specificcode' => strtoupper($arayDT[$dt]),
                                'sm_qty' => 1,
                                'sm_use' => 0,
                                'sm_sisa' => 1,
                                'sm_hpp' => implode(explode('.', $request->hpp)),
                                'sm_sell' => $getSell->i_price,
                                'sm_nota' => $o_reff,
                                'sm_reff' => $o_reff,
                                'sm_mem' => Auth::user()->m_id
                            ]);
                            array_push($arayInsPNB, $arayT);
                        }
                        DB::table('d_stock_mutation')->insert($arayInsPNB);

                        if (!empty($arayDH)) {
                    /// Ambil SM_REFF untuk Specifik Code yang sama pada PENAMBAHAN
                            $getReff = DB::table('d_stock_mutation')->whereIn('sm_specificcode', $arayDH)->select('sm_reff')->get();

                    /// Update SM_USE dan SM_SISA menjadi 1 dan 0
                            DB::table('d_stock_mutation')->whereIn('sm_specificcode', $arayDH)->update(['sm_use' => 1, 'sm_sisa' => 0]);
                            $date = Carbon::now('Asia/Jakarta')->format('Y-m-d h:i:s');
                            $getMaxSMH = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->max('sm_detailid');

                    /// Masukkan Data Pengurangan ke Dalam STOCK MUTATION
                            $arayInsPGR = array();
                            for ($dk = 0; $dk < count($arayDH); $dk++) {

                                $arayK = ([
                                    'sm_stock' => $getIdS->s_id,
                                    'sm_detailid' => $getMaxSMH + ($dk + 1),
                                    'sm_date' => $date,
                                    'sm_detail' => 'PENGURANGAN',
                                    'sm_specificcode' => strtoupper($arayDH[$dk]),
                                    'sm_qty' => 1,
                                    'sm_use' => 1,
                                    'sm_sisa' => 0,
                                    'sm_hpp' => $request->hpp,
                                    'sm_sell' => $getSell->i_price,
                                    'sm_nota' => $o_reff,
                                    'sm_reff' => $getReff[$dk]->sm_reff,
                                    'sm_mem' => Auth::user()->m_id
                                ]);
                                array_push($arayInsPGR, $arayK);
                            }
                            DB::table('d_stock_mutation')->insert($arayInsPGR);
                        }

                        DB::table('d_stock')->where('s_id', $getIdS->s_id)->update(['s_qty' => count($imeiR)]);

                    } else {

                        $pisah = explode(' ', $request->qtyR);
                        $qtyR = $pisah[0];
                        $pisah2 = explode(' ', $request->qtyS);
                        $qtyS = $pisah2[0];
                        $qtyExp = $request->qty;
                        $qty = '';

                        if ($qtyR != '' || $qtyR != null) {
                            $qty = $qtyR;
                        } else {
                            $qty = 0;
                            for ($c = 0; $c < count($qtyExp); $c++) {
                                $qty = $qty + intval($qtyExp[$c]);
                            }
                        }

                        $cekS = DB::table('d_stock')->where('s_item', $idItem)->select('s_qty')->first();

                        DB::table('d_opname_dt')->insert([
                            'od_opname' => $o_id,
                            'od_detailid' => 1,
                            'od_item' => $idItem,
                            'od_qty_real' => $qty,
                            'od_qty_system' => $cekS->s_qty,
                        ]);


                /// UPDATE STOCK MUTASI untuk barang yang tidak memiliki SPESIFIK KODE
                /// == PENAMBAHAN
                        if ($qtyR > $qtyS) {
                            $getMaxSMT = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->max('sm_detailid');
                            DB::table('d_stock_mutation')->insert([
                                'sm_stock' => $getIdS->s_id,
                                'sm_detailid' => $getMaxSMT + 1,
                                'sm_date' => Carbon::now('Asia/Jakarta'),
                                'sm_detail' => 'PENAMBAHAN',
                                'sm_qty' => $qtyR - $qtyS,
                                'sm_use' => 0,
                                'sm_sisa' => $qtyR - $qtyS,
                                'sm_hpp' => implode(explode('.', $request->hpp)),
                                'sm_sell' => $getSell->i_price,
                                'sm_nota' => $o_reff,
                                'sm_reff' => $o_reff,
                                'sm_mem' => Auth::user()->m_id
                            ]);
                        } else {

                    /// == PENGURANGAN
                            $data = DB::table('d_stock_mutation')->where('sm_stock', $getIdS->s_id)->where('sm_sisa', '!=', 0)->get();

                            for ($smc = 0; $smc < count($data); $smc++) {

                                $opk = abs($qtyR - $qtyS);

                                if ($data[$smc]->sm_sisa < $opk) {

                                    DB::table('d_stock_mutation')
                                        ->where('sm_stock', $data[$smc]->sm_stock)
                                        ->where('sm_detail_id', $data[$smc]->sm_detailid)
                                        ->update([
                                            'sm_use' => $data[$smc]->sm_qty,
                                            'sm_sisa' => 0
                                        ]);

                                    $opk = $opk - $data[$smc]->sm_sisa;
                                    $getMax = DB::table('d_stock_mutation')->where('sm_stock', $data[$smc]->sm_stock)->max('sm_detailid');
                                    DB::table('d_stock_mutation')->insert([
                                        'sm_stock' => $getIdS->s_id,
                                        'sm_detailid' => $getMax + 1,
                                        'sm_date' => Carbon::now('Asia/Jakarta'),
                                        'sm_detail' => 'PENGURANGAN',
                                        'sm_qty' => $data[$smc]->sm_qty,
                                        'sm_use' => 0,
                                        'sm_sisa' => 0,
                                        'sm_hpp' => $data[$smc]->sm_hpp,
                                        'sm_sell' => $getSell->i_price,
                                        'sm_nota' => $o_reff,
                                        'sm_reff' => $data[$smc]->sm_nota,
                                        'sm_mem' => Auth::user()->m_id
                                    ]);

                                } else {

                                    $use = $opk + $data[$smc]->sm_use;
                                    $sisa = $data[$smc]->sm_qty - $use;

                                    DB::table('d_stock_mutation')
                                        ->where('sm_stock', $data[$smc]->sm_stock)
                                        ->where('sm_detailid', $data[$smc]->sm_detailid)
                                        ->update([
                                            'sm_use' => $use,
                                            'sm_sisa' => $sisa
                                        ]);

                                    $getMax = DB::table('d_stock_mutation')->where('sm_stock', $data[$smc]->sm_stock)->max('sm_detailid');
                                    DB::table('d_stock_mutation')->insert([
                                        'sm_stock' => $getIdS->s_id,
                                        'sm_detailid' => $getMax + 1,
                                        'sm_date' => Carbon::now('Asia/Jakarta'),
                                        'sm_detail' => 'PENGURANGAN',
                                        'sm_qty' => $opk,
                                        'sm_use' => 0,
                                        'sm_sisa' => 0,
                                        'sm_hpp' => $data[$smc]->sm_hpp,
                                        'sm_sell' => $getSell->i_price,
                                        'sm_nota' => $o_reff,
                                        'sm_reff' => $data[$smc]->sm_nota,
                                        'sm_mem' => Auth::user()->m_id
                                    ]);

                                    $smc = count($data) + 1;
                                }
                            }
                        }
                    }

                    $getCNLog = DB::table('m_company')->where('c_id', $o_comp)->select('c_name')->first();
                    $log = 'Menambahkan Opname Barang pada Outlet '.$getCNLog->c_name.' dengan nota ' . $o_reff;

                    DB::commit();
                    PlasmafoneController::logActivity($log);
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

            $getCN = '';
            if(Auth::user()->m_comp == "PF00000001"){
                $getCN = DB::table('m_company')->where('c_id', '!=', 'PF00000001')->select('c_id', 'c_name')->get();
            }else{
                $getCN = DB::table('m_company')->where('c_id', Auth::user()->m_comp)->select('c_name')->first();
            }
            return view('inventory.opname_barang.tambah_outlet')->with(compact('getCN'));
        }

    }

    public function get_edit(Request $request)
    {
        $id = Crypt::decrypt($request->id);

        $getDataEdit = DB::table('d_opname')
            ->join('d_opname_dt', 'od_opname', '=', 'o_id')
            ->join('d_item', 'i_id', '=', 'od_item')
            ->join('m_company', 'c_id', '=', 'o_comp')
            ->where('o_id', $id)
            ->select('o_comp', 'c_name', 'od_item', 'i_nama', 'od_qty_real', 'o_action', 'od_specificcode', 'i_specificcode')->get();

        $getHppEdit = DB::table('d_stock')
            ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
            ->where('s_item', $getDataEdit[0]->od_item)
            ->where('s_comp', $getDataEdit[0]->o_comp)
            ->where('sm_detail', 'PENAMBAHAN')
            ->select('sm_hpp', 's_qty')
            ->orderBy('sm_detailid', 'desc')
            ->first();

        // dd($getHppEdit);
        return json_encode([
            'edit' => $getDataEdit,
            'hpp' => $getHppEdit
        ]);
    }

    public function edit(Request $request)
    {
        if (PlasmafoneController::checkAkses(11, 'update') == false) {
            return view('errors.407');
        } else {
            $id = Crypt::decrypt($request->id);
            if ($request->isMethod('post')) {
                // dd($request);
                DB::beginTransaction();
                try {

                    //// ============================================================
                    //// Ambil dari DELETE D_STOCK, D_STOCK_DT, dan D_STOCK_MUTATION
                    //// ============================================================
                    /// SELECT data di Stock Mutation dengan sm_nota sama dengan nota opname
                    /// Untuk detail PENAMBAHAN cukup dihapus row nya
                    /// Untuk detail PENGURANGAN, Update stock mulai dari Id yang paling besar
                    $getNota = DB::table('d_opname')->where('o_id', $id)->select('o_reff')->first();
                    $idCompM = Auth::user()->m_comp;
                    $idPos = $request->idComp;
                    $getItem = DB::table('d_opname_dt')->where('od_opname', $id)->select('od_item')->first();
                    $getSCEX = DB::table('d_item')->where('i_id', $getItem->od_item)->select('i_specificcode')->first();
                    $getNota = DB::table('d_opname')->where('o_id', $id)->select('o_reff')->first();
                    $getStFromO = DB::table('d_stock')->where('s_item', $getItem->od_item)->where('s_position', $idPos)->select('s_id')->first();
                    $idS = $getStFromO->s_id;

                    if ($getSCEX->i_specificcode == 'Y') {
                        ////////////////////////////
                        //== FOR Spesificcode = YES
                        $scSMUpdate = DB::table('d_stock_mutation')
                            ->where('sm_stock', $idS)
                            ->where('sm_detail', 'PENGURANGAN')
                            ->where('sm_nota', $getNota->o_reff)
                            ->select('sm_specificcode')->get();

                        for ($i = 0; $i < count($scSMUpdate); $i++) {
                            DB::table('d_stock_mutation')
                                ->where('sm_detail', 'PENAMBAHAN')
                                ->where('sm_specificcode', $scSMUpdate[$i]->sm_specificcode)
                                ->update([
                                    'sm_use' => 0, 'sm_sisa' => 1
                                ]);
                        }

                        //============
                        // D_STOCK_DT
                        //============
                        DB::table('d_stock_dt')->where('sd_stock', $idS)->delete();
                        $arayDelSD = array();
                        for ($i = 0; $i < count($scSMUpdate); $i++) {
                            $aray = ([
                                'sd_stock' => $idS,
                                'sd_detailid' => $i + 11,
                                'sd_specificcode' => strtoupper($scSMUpdate[$i]->sm_specificcode)
                            ]);
                            array_push($arayDelSD, $aray);
                        }
                        DB::table('d_stock_dt')->insert($arayDelSD);

                        //=========
                        // D_STOCK
                        //=========
                        DB::table('d_stock')->where('s_id', $idS)->update(['s_qty' => count($scSMUpdate)]);

                        DB::table('d_stock_mutation')
                            ->where('sm_stock', $idS)
                            ->where('sm_nota', $getNota->o_reff)->delete();
                    } else {
                        //=========================
                        //== FOR Spesificcode = NO
                        //=========================
                        $noSCSMUpdate = DB::table('d_stock_mutation')
                            ->where('sm_stock', $idS)
                            ->where('sm_detail', 'PENGURANGAN')
                            ->where('sm_nota', $getNota->o_reff)
                            ->select('sm_qty', 'sm_reff')->get();

                        //// JIKA ADA PENGURANGAN yang dibuat oleh OPNAME BARANG
                        if (!empty($noSCSMUpdate)) {
                            $arayNoSCUpdate = array();
                            //// AMBIL sm_use dan sm_sisa
                            for ($i = 0; $i < count($noSCSMUpdate); $i++) {
                                $qtyGETUpdate = DB::table('d_stock_mutation')
                                    ->where('sm_stock', $idS)
                                    ->where('sm_nota', $noSCSMUpdate[$i]->sm_reff)
                                    ->select('sm_sisa', 'sm_use')->first();

                                array_push($arayNoSCUpdate, $qtyGETUpdate);
                            }

                            for ($i = 0; $i < count($noSCSMUpdate); $i++) {
                                $useU = $arayNoSCUpdate[$i]->sm_use - $noSCSMUpdate[$i]->sm_qty;
                                $sisaU = $arayNoSCUpdate[$i]->sm_sisa + $noSCSMUpdate[$i]->sm_qty;
                                // dd($arayNoSCUpdate);

                                DB::table('d_stock_mutation')
                                    ->where('sm_stock', $idS)
                                    ->where('sm_nota', $noSCSMUpdate[$i]->sm_reff)
                                    ->where('sm_detail', 'PENAMBAHAN')
                                    ->update([
                                        'sm_use' => $useU, 'sm_sisa' => $sisaU
                                    ]);
                            }

                        }
                        DB::table('d_stock_mutation')->where('sm_nota', $getNota->o_reff)->delete();
                    }
                    DB::table('d_opname_dt')->where('od_opname', $id)->delete();


                    //// ============================================================
                    //// Ambil dari TAMBAH D_STOCK, D_STOCK_DT, dan D_STOCK_MUTATION
                    //// ============================================================
                    $sc = $request->sc;
                    $ex = $request->ex;
                    $idItem = $request->idItem;
                    $imeiR = $request->imeiR;
                    $getSell = DB::table('d_item')->where('i_id', $idItem)->select('i_price')->first();

                    // MEMBUAT D_STOCK Baru jika item untuk lokasi tersebut belum ada di D_STOCK

                    $cekStockExist = DB::table('d_stock')->where('s_item', $idItem)->where('s_position', $idPos)->count();

                    if ($cekStockExist == 0) {
                        $getMaxStock = DB::table('d_stock')->max('s_id');
                        DB::table('d_stock')->insert([
                            's_id' => $getMaxStock + 1, 's_comp' => "PF00000001", 's_position' => $idPos, 's_item' => $idItem, 's_qty' => 0
                        ]);
                    }

                    if ($sc == 'Y') {

                        //+++ INSERT OPNAME DT
                        //////////////////////
                        // HANYA dilakukan jika Spec Code == Y
                        // SEMUA data Tabel MASUK SEMUA ke tabel D_OPNAME_DT
                        $sd_array = array();
                        $od_array = array();

                        for ($i = 0; $i < count($imeiR); $i++) {
                            $cek = DB::table('d_stock')
                                ->join('d_stock_dt', 'sd_stock', '=', 's_id')
                                ->where('sd_specificcode', $imeiR[$i])->count();

                            //// Jika Data Item tersebut tidak ada di dalam sistem
                            if ($cek == 0) {
                                array_push($sd_array, $imeiR[$i]);
                            }

                            //////////////////////////////////////////////////////
                            $aray = ([
                                'od_opname' => $id,
                                'od_detailid' => $i + 1,
                                'od_item' => $idItem,
                                'od_qty_real' => 1,
                                'od_qty_system' => $cek,
                                'od_specificcode' => strtoupper($imeiR[$i])
                            ]);

                            array_push($od_array, $aray);
                        }

                        DB::table('d_opname_dt')->insert($od_array);


                        /////
                        ////////////////////////////////////////////
                        // ///// UPDATE pada data D_STOCK_DT
                        // ///// Jika Barang tidak memiliki IMEI maka Tidak memasukan ke D_STOCK_DT

                        // Cek untuk Barang Di SISTEM yang tidak ada dalam list REAL
                        $getDH = DB::table('d_stock_dt')
                            ->join('d_stock', 's_id', '=', 'sd_stock')
                            ->where('s_item', $idItem)
                            ->whereNotIn('sd_specificcode', $imeiR)
                            ->select('sd_specificcode')
                            ->get();
                        $arayDH = array();
                        foreach ($getDH as $gdh) {
                            array_push($arayDH, $gdh->sd_specificcode);
                        }

                        // Cek untuk Barang REAL yang tidak ada didalam tabel Barang SISTEM
                        $arayDT = array();
                        for ($rt = 0; $rt < count($imeiR); $rt++) {
                            $cekLebih = DB::table('d_stock_dt')->where('sd_specificcode', $imeiR[$rt])->count();
                            if ($cekLebih == 0) {
                                array_push($arayDT, $imeiR[$rt]);
                            }
                        }


                        /// HAPUS di D_STOCK_DT
                        DB::table('d_stock_dt')->whereIn('sd_specificcode', $arayDH)->delete();

                        /// TAMBAH di D_STOCK_DT
                        $countSD = DB::table('d_stock_dt')->where('sd_stock', $idS)->count();
                        // dd($countSD);

                        $getMax = '';
                        if ($countSD == 0) {
                            $getMax = 0;
                        } else {
                            $getMax = DB::table('d_stock_dt')->where('sd_stock', $idS)->max('sd_detailid');
                        }

                        $arayInsert = array();
                        for ($dt = 0; $dt < count($arayDT); $dt++) {
                            $aray = ([
                                'sd_stock' => $idS,
                                'sd_detailid' => $getMax + ($dt + 1),
                                'sd_specificcode' => strtoupper($arayDT[$dt])
                            ]);
                            array_push($arayInsert, $aray);
                        }
                        DB::table('d_stock_dt')->insert($arayInsert);


                        /////
                        ////////////////////////////////////////////
                        // ///// UPDATE pada data D_STOCK_MUTATION
                        // ///// Mekanisme PENAMBAHAN Barang
                        $countTB = DB::table('d_stock_mutation')->where('sm_stock', $idS)->count();
                        if ($countTB == 0) {
                            $getMaxSMT = 0;
                        } else {
                            $getMaxSMT = DB::table('d_stock_mutation')->where('sm_stock', $idS)->max('sm_detailid');
                        }

                        $arayInsPNB = array();
                        for ($dt = 0; $dt < count($arayDT); $dt++) {
                            $arayT = ([
                                'sm_stock' => $idS,
                                'sm_detailid' => $getMaxSMT + ($dt + 1),
                                'sm_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d h:i:s'),
                                'sm_detail' => 'PENAMBAHAN',
                                'sm_specificcode' => strtoupper($arayDT[$dt]),
                                'sm_expired' => '',
                                'sm_qty' => 1,
                                'sm_use' => 0,
                                'sm_sisa' => 1,
                                'sm_hpp' => implode(explode('.', $request->hpp)),
                                'sm_sell' => $getSell->i_price,
                                'sm_nota' => $getNota->o_reff,
                                'sm_reff' => $getNota->o_reff,
                                'sm_mem' => Auth::user()->m_id
                            ]);
                            array_push($arayInsPNB, $arayT);
                        }
                        DB::table('d_stock_mutation')->insert($arayInsPNB);

                        if (!empty($arayDH)) {

                        /// Ambil SM_REFF untuk Specifik Code yang sama pada PENAMBAHAN
                            $getReff = DB::table('d_stock_mutation')->whereIn('sm_specificcode', $arayDH)->select('sm_reff')->get();

                        /// Update SM_USE dan SM_SISA menjadi 1 dan 0
                            DB::table('d_stock_mutation')->whereIn('sm_specificcode', $arayDH)->update(['sm_use' => 1, 'sm_sisa' => 0]);
                            $date = Carbon::now('Asia/Jakarta')->format('Y-m-d h:i:s');
                            $getMaxSMH = DB::table('d_stock_mutation')->where('sm_stock', $idS)->max('sm_detailid');

                            /// Masukkan Data Pengurangan ke Dalam STOCK MUTATION
                            $arayInsPGR = array();
                            for ($dk = 0; $dk < count($arayDH); $dk++) {
                                // dd($arayDH);
                                $getHPPDH = DB::table('d_stock_mutation')->where('sm_specificcode', $arayDH[$dk])->select('sm_hpp')->first();

                                $arayK = ([
                                    'sm_stock' => $idS,
                                    'sm_detailid' => $getMaxSMH + ($dk + 1),
                                    'sm_date' => $date,
                                    'sm_detail' => 'PENGURANGAN',
                                    'sm_specificcode' => strtoupper($arayDH[$dk]),
                                    'sm_expired' => '',
                                    'sm_qty' => 1,
                                    'sm_use' => 1,
                                    'sm_sisa' => 0,
                                    'sm_hpp' => $getHPPDH->sm_hpp,
                                    'sm_sell' => $getSell->i_price,
                                    'sm_nota' => $getNota->o_reff,
                                    'sm_reff' => $getReff[$dk]->sm_reff,
                                    'sm_mem' => Auth::user()->m_id
                                ]);
                                array_push($arayInsPGR, $arayK);
                            }
                            DB::table('d_stock_mutation')->insert($arayInsPGR);
                        }

                        DB::table('d_stock')->where('s_id', $idS)->update(['s_qty' => count($imeiR)]);

                    } else {

                        $pisah = explode(' ', $request->qtyR);
                        $qtyR = $pisah[0];
                        $pisah2 = explode(' ', $request->qtyS);
                        $qtyS = $pisah2[0];
                        $qtyExp = $request->qty;
                        $qty = '';

                        if ($qtyR != '' || $qtyR != null) {
                            $qty = $qtyR;
                        } else {
                            $qty = 0;
                            for ($c = 0; $c < count($qtyExp); $c++) {
                                $qty = $qty + intval($qtyExp[$c]);
                            }
                        }

                        $cekS = DB::table('d_stock')->where('s_item', $idItem)->select('s_qty')->first();

                        DB::table('d_opname_dt')->insert([
                            'od_opname' => $id,
                            'od_detailid' => 1,
                            'od_item' => $idItem,
                            'od_qty_real' => $qty,
                            'od_qty_system' => $cekS->s_qty,
                            'od_specificcode' => ''
                        ]);


                        /// UPDATE STOCK MUTASI untuk barang yang tidak memiliki SPESIFIK KODE
                        /// == PENAMBAHAN
                        if ($qtyR > $qtyS) {
                            $getMaxSMT = DB::table('d_stock_mutation')->where('sm_stock', $idS)->max('sm_detailid');
                            DB::table('d_stock_mutation')->insert([
                                'sm_stock' => $idS,
                                'sm_detailid' => $getMaxSMT + 1,
                                'sm_date' => Carbon::now('Asia/Jakarta'),
                                'sm_detail' => 'PENAMBAHAN',
                                'sm_specificcode' => '',
                                'sm_expired' => '',
                                'sm_qty' => $qtyR - $qtyS,
                                'sm_use' => 0,
                                'sm_sisa' => $qtyR - $qtyS,
                                'sm_hpp' => implode(explode('.', $request->hpp)),
                                'sm_sell' => $getSell->i_price,
                                'sm_nota' => $getNota->o_reff,
                                'sm_reff' => $getNota->o_reff,
                                'sm_mem' => Auth::user()->m_id
                            ]);
                        } else {

                        /// == PENGURANGAN
                            $data = DB::table('d_stock_mutation')->where('sm_stock', $idS)->where('sm_sisa', '!=', 0)->get();

                            for ($smc = 0; $smc < count($data); $smc++) {

                                $opk = abs($qtyR - $qtyS);

                                if ($data[$smc]->sm_sisa < $opk) {

                                    DB::table('d_stock_mutation')
                                        ->where('sm_stock', $data[$smc]->sm_stock)
                                        ->where('sm_detail_id', $data[$smc]->sm_detailid)
                                        ->update([
                                            'sm_use' => $data[$smc]->sm_qty,
                                            'sm_sisa' => 0
                                        ]);

                                    $opk = $opk - $data[$smc]->sm_sisa;
                                    $getMax = DB::table('d_stock_mutation')->where('sm_stock', $data[$smc]->sm_stock)->max('sm_detailid');
                                    DB::table('d_stock_mutation')->insert([
                                        'sm_stock' => $idS,
                                        'sm_detailid' => $getMax + 1,
                                        'sm_date' => Carbon::now('Asia/Jakarta'),
                                        'sm_detail' => 'PENGURANGAN',
                                        'sm_specificcode' => '',
                                        'sm_expired' => '',
                                        'sm_qty' => $data[$smc]->sm_qty,
                                        'sm_use' => 0,
                                        'sm_sisa' => 0,
                                        'sm_hpp' => $data[$smc]->sm_hpp,
                                        'sm_sell' => $getSell->i_price,
                                        'sm_nota' => $getNota->o_reff,
                                        'sm_reff' => $data[$smc]->sm_nota,
                                        'sm_mem' => Auth::user()->m_id
                                    ]);

                                } else {

                                    $use = $opk + $data[$smc]->sm_use;
                                    $sisa = $data[$smc]->sm_qty - $use;

                                    DB::table('d_stock_mutation')
                                        ->where('sm_stock', $data[$smc]->sm_stock)
                                        ->where('sm_detailid', $data[$smc]->sm_detailid)
                                        ->update([
                                            'sm_use' => $use,
                                            'sm_sisa' => $sisa
                                        ]);

                                    $getMax = DB::table('d_stock_mutation')->where('sm_stock', $data[$smc]->sm_stock)->max('sm_detailid');
                                    DB::table('d_stock_mutation')->insert([
                                        'sm_stock' => $idS,
                                        'sm_detailid' => $getMax + 1,
                                        'sm_date' => Carbon::now('Asia/Jakarta'),
                                        'sm_detail' => 'PENGURANGAN',
                                        'sm_specificcode' => '',
                                        'sm_expired' => '',
                                        'sm_qty' => $opk,
                                        'sm_use' => 0,
                                        'sm_sisa' => 0,
                                        'sm_hpp' => $data[$smc]->sm_hpp,
                                        'sm_sell' => $getSell->i_price,
                                        'sm_nota' => $getNota->o_reff,
                                        'sm_reff' => $data[$smc]->sm_nota,
                                        'sm_mem' => Auth::user()->m_id
                                    ]);

                                    $smc = count($data) + 1;
                                }
                            }
                        }
                    }

                    $log = 'Mengubah Data Opname Barang pada PLASMAFONE PUSAT dengan nota ' . $getNota->o_reff;
                    DB::commit();
                    PlasmafoneController::logActivity($log);
                    return json_encode([
                        'status' => 'eobSukses'
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return json_encode([
                        'status' => 'eobGagal',
                        'msg' => $e
                    ]);
                }

            }

            $id = Crypt::encrypt($id);
            return view('inventory.opname_barang.edit')->with(compact('id'));
        }

    }

    public function editOutlet(Request $request)
    {
        if (PlasmafoneController::checkAkses(12, 'update') == false) {
            return view('errors.407');
        } else {
            $id = Crypt::decrypt($request->id);
            if ($request->isMethod('post')) {
                // dd($request);
                DB::beginTransaction();
                try {
                    // DB::table('d_opname_dt')->where('od_opname', $id)->delete();
                    // DB::table('d_opname')->where('o_id', $id)->update([]);

                    //// ============================================================
                    //// Ambil dari DELETE D_STOCK, D_STOCK_DT, dan D_STOCK_MUTATION
                    //// ============================================================
                    /// SELECT data di Stock Mutation dengan sm_nota sama dengan nota opname
                    /// Untuk detail PENAMBAHAN cukup dihapus row nya
                    /// Untuk detail PENGURANGAN, Update stock mulai dari Id yang paling besar
                    $getNota = DB::table('d_opname')->where('o_id', $id)->select('o_reff')->first();
                    $idCompM = Auth::user()->m_comp;
                    $idPos = $request->idComp;
                    $getItem = DB::table('d_opname_dt')->where('od_opname', $id)->select('od_item')->first();
                    $getSCEX = DB::table('d_item')->where('i_id', $getItem->od_item)->select('i_specificcode')->first();
                    $getNota = DB::table('d_opname')->where('o_id', $id)->select('o_reff')->first();
                    $getStFromO = DB::table('d_stock')->where('s_item', $getItem->od_item)->where('s_position', $idPos)->select('s_id')->first();
                    $idS = $getStFromO->s_id;

                    if ($getSCEX->i_specificcode == 'Y') {
                        ////////////////////////////
                        //== FOR Spesificcode = YES
                        $scSMUpdate = DB::table('d_stock_mutation')
                            ->where('sm_stock', $idS)
                            ->where('sm_detail', 'PENGURANGAN')
                            ->where('sm_nota', $getNota->o_reff)
                            ->select('sm_specificcode')->get();

                        for ($i = 0; $i < count($scSMUpdate); $i++) {
                            DB::table('d_stock_mutation')
                                ->where('sm_detail', 'PENAMBAHAN')
                                ->where('sm_specificcode', $scSMUpdate[$i]->sm_specificcode)
                                ->update([
                                    'sm_use' => 0, 'sm_sisa' => 1
                                ]);
                        }

                        //============
                        // D_STOCK_DT
                        //============
                        DB::table('d_stock_dt')->where('sd_stock', $idS)->delete();
                        $arayDelSD = array();
                        for ($i = 0; $i < count($scSMUpdate); $i++) {
                            $aray = ([
                                'sd_stock' => $idS,
                                'sd_detailid' => $i + 11,
                                'sd_specificcode' => strtoupper($scSMUpdate[$i]->sm_specificcode)
                            ]);
                            array_push($arayDelSD, $aray);
                        }
                        DB::table('d_stock_dt')->insert($arayDelSD);

                        //=========
                        // D_STOCK
                        //=========
                        DB::table('d_stock')->where('s_id', $idS)->update(['s_qty' => count($scSMUpdate)]);

                        DB::table('d_stock_mutation')
                            ->where('sm_stock', $idS)
                            ->where('sm_nota', $getNota->o_reff)->delete();

                    } else {
                        //=========================
                        //== FOR Spesificcode = NO
                        //=========================
                        $noSCSMUpdate = DB::table('d_stock_mutation')
                            ->where('sm_stock', $idS)
                            ->where('sm_detail', 'PENGURANGAN')
                            ->where('sm_nota', $getNota->o_reff)
                            ->select('sm_qty', 'sm_reff')->get();

                        //// JIKA ADA PENGURANGAN yang dibuat oleh OPNAME BARANG
                        if (!empty($noSCSMUpdate)) {
                            $arayNoSCUpdate = array();
                            //// AMBIL sm_use dan sm_sisa
                            for ($i = 0; $i < count($noSCSMUpdate); $i++) {
                                $qtyGETUpdate = DB::table('d_stock_mutation')
                                    ->where('sm_stock', $idS)
                                    ->where('sm_nota', $noSCSMUpdate[$i]->sm_reff)
                                    ->select('sm_sisa', 'sm_use')->first();

                                array_push($arayNoSCUpdate, $qtyGETUpdate);
                            }

                            for ($i = 0; $i < count($noSCSMUpdate); $i++) {
                                $useU = $arayNoSCUpdate[$i]->sm_use - $noSCSMUpdate[$i]->sm_qty;
                                $sisaU = $arayNoSCUpdate[$i]->sm_sisa + $noSCSMUpdate[$i]->sm_qty;
                                // dd($arayNoSCUpdate);

                                DB::table('d_stock_mutation')
                                    ->where('sm_stock', $idS)
                                    ->where('sm_nota', $noSCSMUpdate[$i]->sm_reff)
                                    ->where('sm_detail', 'PENAMBAHAN')
                                    ->update([
                                        'sm_use' => $useU, 'sm_sisa' => $sisaU
                                    ]);
                            }

                        }
                        DB::table('d_stock_mutation')->where('sm_nota', $getNota->o_reff)->delete();
                    }
                    DB::table('d_opname_dt')->where('od_opname', $id)->delete();


                    //// ============================================================
                    //// Ambil dari TAMBAH D_STOCK, D_STOCK_DT, dan D_STOCK_MUTATION
                    //// ============================================================
                    $sc = $request->sc;
                    $ex = $request->ex;
                    $idItem = $request->idItem;
                    $imeiR = $request->imeiR;
                    $getSell = DB::table('d_item')->where('i_id', $idItem)->select('i_price')->first();

                    // MEMBUAT D_STOCK Baru jika item untuk lokasi tersebut belum ada di D_STOCK

                    $cekStockExist = DB::table('d_stock')->where('s_item', $idItem)->where('s_position', $idPos)->count();

                    if ($cekStockExist == 0) {
                        $getMaxStock = DB::table('d_stock')->max('s_id');
                        DB::table('d_stock')->insert([
                            's_id' => $getMaxStock + 1, 's_comp' => "PF00000001", 's_position' => $idPos, 's_item' => $idItem, 's_qty' => 0
                        ]);
                    }

                    if ($sc == 'Y') {

                        //+++ INSERT OPNAME DT
                        //////////////////////
                        // HANYA dilakukan jika Spec Code == Y
                        // SEMUA data Tabel MASUK SEMUA ke tabel D_OPNAME_DT
                        $sd_array = array();
                        $od_array = array();

                        for ($i = 0; $i < count($imeiR); $i++) {
                            $cek = DB::table('d_stock')
                                ->join('d_stock_dt', 'sd_stock', '=', 's_id')
                                ->where('sd_specificcode', $imeiR[$i])->count();

                            //// Jika Data Item tersebut tidak ada di dalam sistem
                            if ($cek == 0) {
                                array_push($sd_array, $imeiR[$i]);
                            }

                            //////////////////////////////////////////////////////
                            $aray = ([
                                'od_opname' => $id,
                                'od_detailid' => $i + 1,
                                'od_item' => $idItem,
                                'od_qty_real' => 1,
                                'od_qty_system' => $cek,
                                'od_specificcode' => strtoupper($imeiR[$i])
                            ]);

                            array_push($od_array, $aray);
                        }

                        DB::table('d_opname_dt')->insert($od_array);


                        /////
                        ////////////////////////////////////////////
                        // ///// UPDATE pada data D_STOCK_DT
                        // ///// Jika Barang tidak memiliki IMEI maka Tidak memasukan ke D_STOCK_DT

                        // Cek untuk Barang Di SISTEM yang tidak ada dalam list REAL
                        $getDH = DB::table('d_stock_dt')
                            ->join('d_stock', 's_id', '=', 'sd_stock')
                            ->where('s_item', $idItem)
                            ->whereNotIn('sd_specificcode', $imeiR)
                            ->select('sd_specificcode')
                            ->get();
                        $arayDH = array();
                        foreach ($getDH as $gdh) {
                            array_push($arayDH, $gdh->sd_specificcode);
                        }

                        // Cek untuk Barang REAL yang tidak ada didalam tabel Barang SISTEM
                        $arayDT = array();
                        for ($rt = 0; $rt < count($imeiR); $rt++) {
                            $cekLebih = DB::table('d_stock_dt')->where('sd_specificcode', $imeiR[$rt])->count();
                            if ($cekLebih == 0) {
                                array_push($arayDT, $imeiR[$rt]);
                            }
                        }


                        /// HAPUS di D_STOCK_DT
                        DB::table('d_stock_dt')->whereIn('sd_specificcode', $arayDH)->delete();

                        /// TAMBAH di D_STOCK_DT
                        $countSD = DB::table('d_stock_dt')->where('sd_stock', $idS)->count();
                        // dd($countSD);

                        $getMax = '';
                        if ($countSD == 0) {
                            $getMax = 0;
                        } else {
                            $getMax = DB::table('d_stock_dt')->where('sd_stock', $idS)->max('sd_detailid');
                        }

                        $arayInsert = array();
                        for ($dt = 0; $dt < count($arayDT); $dt++) {
                            $aray = ([
                                'sd_stock' => $idS,
                                'sd_detailid' => $getMax + ($dt + 1),
                                'sd_specificcode' => strtoupper($arayDT[$dt])
                            ]);
                            array_push($arayInsert, $aray);
                        }
                        DB::table('d_stock_dt')->insert($arayInsert);


                        /////
                        ////////////////////////////////////////////
                        // ///// UPDATE pada data D_STOCK_MUTATION
                        // ///// Mekanisme PENAMBAHAN Barang
                        $countTB = DB::table('d_stock_mutation')->where('sm_stock', $idS)->count();
                        if ($countTB == 0) {
                            $getMaxSMT = 0;
                        } else {
                            $getMaxSMT = DB::table('d_stock_mutation')->where('sm_stock', $idS)->max('sm_detailid');
                        }

                        $arayInsPNB = array();
                        for ($dt = 0; $dt < count($arayDT); $dt++) {
                            $arayT = ([
                                'sm_stock' => $idS,
                                'sm_detailid' => $getMaxSMT + ($dt + 1),
                                'sm_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d h:i:s'),
                                'sm_detail' => 'PENAMBAHAN',
                                'sm_specificcode' => strtoupper($arayDT[$dt]),
                                'sm_expired' => '',
                                'sm_qty' => 1,
                                'sm_use' => 0,
                                'sm_sisa' => 1,
                                'sm_hpp' => implode(explode('.', $request->hpp)),
                                'sm_sell' => $getSell->i_price,
                                'sm_nota' => $getNota->o_reff,
                                'sm_reff' => $getNota->o_reff,
                                'sm_mem' => Auth::user()->m_id
                            ]);
                            array_push($arayInsPNB, $arayT);
                        }
                        DB::table('d_stock_mutation')->insert($arayInsPNB);

                        if (!empty($arayDH)) {
                        /// Ambil SM_REFF untuk Specifik Code yang sama pada PENAMBAHAN
                            $getReff = DB::table('d_stock_mutation')->whereIn('sm_specificcode', $arayDH)->select('sm_reff')->get();

                        /// Update SM_USE dan SM_SISA menjadi 1 dan 0
                            DB::table('d_stock_mutation')->whereIn('sm_specificcode', $arayDH)->update(['sm_use' => 1, 'sm_sisa' => 0]);
                            $date = Carbon::now('Asia/Jakarta')->format('Y-m-d h:i:s');
                            $getMaxSMH = DB::table('d_stock_mutation')->where('sm_stock', $idS)->max('sm_detailid');

                        /// Masukkan Data Pengurangan ke Dalam STOCK MUTATION
                            $arayInsPGR = array();
                            for ($dk = 0; $dk < count($arayDH); $dk++) {
                                // dd($arayDH);

                                $getHPPDH = DB::table('d_stock_mutation')->where('sm_specificcode', $arayDH[$dk])->select('sm_hpp')->first();
                                $arayK = ([
                                    'sm_stock' => $idS,
                                    'sm_detailid' => $getMaxSMH + ($dk + 1),
                                    'sm_date' => $date,
                                    'sm_detail' => 'PENGURANGAN',
                                    'sm_specificcode' => strtoupper($arayDH[$dk]),
                                    'sm_expired' => '',
                                    'sm_qty' => 1,
                                    'sm_use' => 1,
                                    'sm_sisa' => 0,
                                    'sm_hpp' => $getHPPDH->sm_hpp,
                                    'sm_sell' => $getSell->i_price,
                                    'sm_nota' => $getNota->o_reff,
                                    'sm_reff' => $getReff[$dk]->sm_reff,
                                    'sm_mem' => Auth::user()->m_id
                                ]);
                                array_push($arayInsPGR, $arayK);
                            }
                            DB::table('d_stock_mutation')->insert($arayInsPGR);
                        }

                        DB::table('d_stock')->where('s_id', $idS)->update(['s_qty' => count($imeiR)]);


                    } else {

                        $pisah = explode(' ', $request->qtyR);
                        $qtyR = $pisah[0];
                        $pisah2 = explode(' ', $request->qtyS);
                        $qtyS = $pisah2[0];
                        $qtyExp = $request->qty;
                        $qty = '';

                        if ($qtyR != '' || $qtyR != null) {
                            $qty = $qtyR;
                        } else {
                            $qty = 0;
                            for ($c = 0; $c < count($qtyExp); $c++) {
                                $qty = $qty + intval($qtyExp[$c]);
                            }
                        }

                        $cekS = DB::table('d_stock')->where('s_item', $idItem)->select('s_qty')->first();

                        DB::table('d_opname_dt')->insert([
                            'od_opname' => $id,
                            'od_detailid' => 1,
                            'od_item' => $idItem,
                            'od_qty_real' => $qty,
                            'od_qty_system' => $cekS->s_qty,
                            'od_specificcode' => ''
                        ]);


                        /// UPDATE STOCK MUTASI untuk barang yang tidak memiliki SPESIFIK KODE
                        /// == PENAMBAHAN
                        if ($qtyR > $qtyS) {
                            $getMaxSMT = DB::table('d_stock_mutation')->where('sm_stock', $idS)->max('sm_detailid');
                            DB::table('d_stock_mutation')->insert([
                                'sm_stock' => $idS,
                                'sm_detailid' => $getMaxSMT + 1,
                                'sm_date' => Carbon::now('Asia/Jakarta'),
                                'sm_detail' => 'PENAMBAHAN',
                                'sm_specificcode' => '',
                                'sm_expired' => '',
                                'sm_qty' => $qtyR - $qtyS,
                                'sm_use' => 0,
                                'sm_sisa' => $qtyR - $qtyS,
                                'sm_hpp' => implode(explode('.', $request->hpp)),
                                'sm_sell' => $getSell->i_price,
                                'sm_nota' => $getNota->o_reff,
                                'sm_reff' => $getNota->o_reff,
                                'sm_mem' => Auth::user()->m_id
                            ]);
                        } else {

                        /// == PENGURANGAN
                            $data = DB::table('d_stock_mutation')->where('sm_stock', $idS)->where('sm_sisa', '!=', 0)->get();

                            for ($smc = 0; $smc < count($data); $smc++) {

                                $opk = abs($qtyR - $qtyS);

                                if ($data[$smc]->sm_sisa < $opk) {

                                    DB::table('d_stock_mutation')
                                        ->where('sm_stock', $data[$smc]->sm_stock)
                                        ->where('sm_detail_id', $data[$smc]->sm_detailid)
                                        ->update([
                                            'sm_use' => $data[$smc]->sm_qty,
                                            'sm_sisa' => 0
                                        ]);

                                    $opk = $opk - $data[$smc]->sm_sisa;
                                    $getMax = DB::table('d_stock_mutation')->where('sm_stock', $data[$smc]->sm_stock)->max('sm_detailid');
                                    DB::table('d_stock_mutation')->insert([
                                        'sm_stock' => $idS,
                                        'sm_detailid' => $getMax + 1,
                                        'sm_date' => Carbon::now('Asia/Jakarta'),
                                        'sm_detail' => 'PENGURANGAN',
                                        'sm_specificcode' => '',
                                        'sm_expired' => '',
                                        'sm_qty' => $data[$smc]->sm_qty,
                                        'sm_use' => 0,
                                        'sm_sisa' => 0,
                                        'sm_hpp' => $data[$smc]->sm_hpp,
                                        'sm_sell' => $getSell->i_price,
                                        'sm_nota' => $getNota->o_reff,
                                        'sm_reff' => $data[$smc]->sm_nota,
                                        'sm_mem' => Auth::user()->m_id
                                    ]);

                                } else {

                                    $use = $opk + $data[$smc]->sm_use;
                                    $sisa = $data[$smc]->sm_qty - $use;

                                    DB::table('d_stock_mutation')
                                        ->where('sm_stock', $data[$smc]->sm_stock)
                                        ->where('sm_detailid', $data[$smc]->sm_detailid)
                                        ->update([
                                            'sm_use' => $use,
                                            'sm_sisa' => $sisa
                                        ]);

                                    $getMax = DB::table('d_stock_mutation')->where('sm_stock', $data[$smc]->sm_stock)->max('sm_detailid');
                                    DB::table('d_stock_mutation')->insert([
                                        'sm_stock' => $idS,
                                        'sm_detailid' => $getMax + 1,
                                        'sm_date' => Carbon::now('Asia/Jakarta'),
                                        'sm_detail' => 'PENGURANGAN',
                                        'sm_specificcode' => '',
                                        'sm_expired' => '',
                                        'sm_qty' => $opk,
                                        'sm_use' => 0,
                                        'sm_sisa' => 0,
                                        'sm_hpp' => $data[$smc]->sm_hpp,
                                        'sm_sell' => $getSell->i_price,
                                        'sm_nota' => $getNota->o_reff,
                                        'sm_reff' => $data[$smc]->sm_nota,
                                        'sm_mem' => Auth::user()->m_id
                                    ]);

                                    $smc = count($data) + 1;
                                }
                            }
                        }
                    }

                    $getCNLog = DB::table('m_company')->where('c_id', $idPos)->select('c_name')->first();
                    $log = 'Mengubah Data Opname Barang pada Outlet '.$getCNLog->c_name.' dengan nota ' . $getNota->o_reff;

                    DB::commit();
                    PlasmafoneController::logActivity($log);
                    return json_encode([
                        'status' => 'eobSukses'
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return json_encode([
                        'status' => 'eobGagal',
                        'msg' => $e
                    ]);
                }

            }

            $id = Crypt::encrypt($id);
            return view('inventory.opname_barang.edit_outlet')->with(compact('id'));
        }

    }

    public function approve(Request $request)
    {
        if (PlasmafoneController::checkAkses(11, 'update') == true && Auth::user()->m_level < 5) {
            $id = Crypt::decrypt($request->id);
            DB::beginTransaction();
            try {
                DB::table('d_opname')->where('o_id', $id)->update([
                    'o_status' => 'DONE'
                ]);

                $getCNINLog = DB::table('d_opname')
                    ->where('o_id', $id)->select('o_reff')->first();
                $log = 'Mengubah Opname Barang pada PLASMAFONE PUSAT dengan nota ' . $getCNINLog->o_reff;
                DB::commit();
                PlasmafoneController::logActivity($log);
                return json_encode([
                    'status' => 'eobSukses'
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return json_encode([
                    'status' => 'eobGagal',
                    'msg' => $e
                ]);
            }
        } else {
            return view('errors .407');
        }

    }

    public function approveOutlet(Request $request)
    {
        if (PlasmafoneController::checkAkses(12, 'update') == true && Auth::user()->m_level < 5) {
            $id = Crypt::decrypt($request->id);
            DB::beginTransaction();
            try {
                DB::table('d_opname')->where('o_id', $id)->update([
                    'o_status' => 'DONE'
                ]);

                $getCNINLog = DB::table('d_opname')
                    ->join('m_company', 'c_id', '=', 'o_comp')
                    ->where('o_id', $id)->select('c_name', 'o_reff')->first();
                $log = 'Mengubah Opname Barang pada Outlet '.$getCNINLog->c_name.' dengan nota ' . $getCNINLog->o_reff;
                DB::commit();
                PlasmafoneController::logActivity($log);
                return json_encode([
                    'status' => 'eobSukses'
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return json_encode([
                    'status' => 'eobGagal',
                    'msg' => $e
                ]);
            }
        } else {
            return view('errors .407');
        }

    }


    public function hapus(Request $request)
    {
        if (PlasmafoneController::checkAkses(11, 'delete') == false) {
            return view('errors .407');
        } else {
            DB::beginTransaction();
            try {
                $id = Crypt::decrypt($request->id);
                $getNota = DB::table('d_opname')->where('o_id', $id)->select('o_reff')->first();

                $getCNINLog = DB::table('d_opname')
                    ->where('o_id', $id)->select('o_reff')->first();
                $log = 'Menghapus Opname Barang pada PLASMAFONE PUSAT dengan nota ' . $getCNINLog->o_reff;

                /// SELECT data di Stock Mutation dengan sm_nota sama dengan nota opname
                /// Untuk detail PENAMBAHAN cukup dihapus row nya
                /// Untuk detail PENGURANGAN, Update stock mulai dari Id yang paling besar
                $getItem = DB::table('d_opname_dt')->where('od_opname', $id)->select('od_item')->first();
                $getSCEX = DB::table('d_item')->where('i_id', $getItem->od_item)->select('i_specificcode')->first();
                $getNota = DB::table('d_opname')->where('o_id', $id)->select('o_reff')->first();
                $getStFromO = DB::table('d_stock')->where('s_item', $getItem->od_item)->select('s_id')->first();
                $idS = $getStFromO->s_id;

                if ($getSCEX->i_specificcode == 'Y') {
                    ////////////////////////////
                    //== FOR Spesificcode = YES
                    $scSMUpdate = DB::table('d_stock_mutation')
                        ->where('sm_stock', $idS)
                        ->where('sm_detail', 'PENGURANGAN')
                        ->where('sm_nota', $getNota->o_reff)
                        ->select('sm_specificcode')->get();

                    for ($i = 0; $i < count($scSMUpdate); $i++) {
                        DB::table('d_stock_mutation')
                            ->where('sm_detail', 'PENAMBAHAN')
                            ->where('sm_specificcode', $scSMUpdate[$i]->sm_specificcode)
                            ->update([
                                'sm_use' => 0, 'sm_sisa' => 1
                            ]);
                    }

                    //============
                    // D_STOCK_DT
                    //============
                    DB::table('d_stock_dt')->where('sd_stock', $idS)->delete();
                    $arayDelSD = array();
                    for ($i = 0; $i < count($scSMUpdate); $i++) {
                        $aray = ([
                            'sd_stock' => $idS,
                            'sd_detailid' => $i + 11,
                            'sd_specificcode' => $scSMUpdate[$i]->sm_specificcode
                        ]);
                        array_push($arayDelSD, $aray);
                    }
                    DB::table('d_stock_dt')->insert($arayDelSD);

                    //=========
                    // D_STOCK
                    //=========
                    DB::table('d_stock')->where('s_id', $idS)->update(['s_qty' => count($scSMUpdate)]);

                    DB::table('d_stock_mutation')
                        ->where('sm_stock', $idS)
                        ->where('sm_nota', $getNota->o_reff)->delete();

                } else {
                    //=========================
                    //== FOR Spesificcode = NO
                    //=========================
                    $noSCSMUpdate = DB::table('d_stock_mutation')
                        ->where('sm_stock', $idS)
                        ->where('sm_detail', 'PENGURANGAN')
                        ->where('sm_nota', $getNota->o_reff)
                        ->select('sm_qty', 'sm_reff')->get();

                    //// JIKA ADA PENGURANGAN yang dibuat oleh OPNAME BARANG
                    if (!empty($noSCSMUpdate)) {
                        $arayNoSCUpdate = array();
                        //// AMBIL sm_use dan sm_sisa
                        for ($i = 0; $i < count($noSCSMUpdate); $i++) {
                            $qtyGETUpdate = DB::table('d_stock_mutation')
                                ->where('sm_stock', $idS)
                                ->where('sm_nota', $noSCSMUpdate[$i]->sm_reff)
                                ->select('sm_sisa', 'sm_use')->first();

                            array_push($arayNoSCUpdate, $qtyGETUpdate);
                        }

                        for ($i = 0; $i < count($noSCSMUpdate); $i++) {
                            $useU = $arayNoSCUpdate[$i]->sm_use - $noSCSMUpdate[$i]->sm_qty;
                            $sisaU = $arayNoSCUpdate[$i]->sm_sisa + $noSCSMUpdate[$i]->sm_qty;
                            // dd($arayNoSCUpdate);

                            DB::table('d_stock_mutation')
                                ->where('sm_stock', $idS)
                                ->where('sm_nota', $noSCSMUpdate[$i]->sm_reff)
                                ->where('sm_detail', 'PENAMBAHAN')
                                ->update([
                                    'sm_use' => $useU, 'sm_sisa' => $sisaU
                                ]);
                        }

                    }
                    DB::table('d_stock_mutation')->where('sm_nota', $getNota->o_reff)->delete();
                }


                ///////////////////////////////
                DB::table('d_opname')->where('o_id', $id)->delete();
                DB::table('d_opname_dt')->where('od_opname', $id)->delete();

                DB::commit();
                PlasmafoneController::logActivity($log);
                return json_encode([
                    'status' => 'hobSukses'
                ]);

            } catch (\Exception $e) {

                DB::rollback();
                return json_encode([
                    'status' => 'hobGagal',
                    'msg' => $e
                ]);
            }
        }

    }

    public function hapusOutlet(Request $request)
    {
        if (PlasmafoneController::checkAkses(12, 'delete') == false) {
            return view('errors .407');
        } else {
            DB::beginTransaction();
            try {
                $id = Crypt::decrypt($request->id);
                $getCNINLog = DB::table('d_opname')
                    ->join('m_company', 'c_id', '=', 'o_comp')
                    ->where('o_id', $id)->select('c_name', 'o_reff')->first();
                $log = 'Menghapus Opname Barang pada Outlet '.$getCNINLog->c_name.' dengan nota ' . $getCNINLog->o_reff;

                $getNota = DB::table('d_opname')->where('o_id', $id)->select('o_reff')->first();


                /// SELECT data di Stock Mutation dengan sm_nota sama dengan nota opname
                /// Untuk detail PENAMBAHAN cukup dihapus row nya
                /// Untuk detail PENGURANGAN, Update stock mulai dari Id yang paling besar
                $getItem = DB::table('d_opname_dt')->where('od_opname', $id)->select('od_item')->first();
                $getSCEX = DB::table('d_item')->where('i_id', $getItem->od_item)->select('i_specificcode')->first();
                $getNota = DB::table('d_opname')->where('o_id', $id)->select('o_reff')->first();
                $getStFromO = DB::table('d_stock')->where('s_item', $getItem->od_item)->select('s_id')->first();
                $idS = $getStFromO->s_id;

                if ($getSCEX->i_specificcode == 'Y') {
                    ////////////////////////////
                    //== FOR Spesificcode = YES
                    $scSMUpdate = DB::table('d_stock_mutation')
                        ->where('sm_stock', $idS)
                        ->where('sm_detail', 'PENGURANGAN')
                        ->where('sm_nota', $getNota->o_reff)
                        ->select('sm_specificcode')->get();

                    for ($i = 0; $i < count($scSMUpdate); $i++) {
                        DB::table('d_stock_mutation')
                            ->where('sm_detail', 'PENAMBAHAN')
                            ->where('sm_specificcode', $scSMUpdate[$i]->sm_specificcode)
                            ->update([
                                'sm_use' => 0, 'sm_sisa' => 1
                            ]);
                    }

                    //============
                    // D_STOCK_DT
                    //============
                    DB::table('d_stock_dt')->where('sd_stock', $idS)->delete();
                    $arayDelSD = array();
                    for ($i = 0; $i < count($scSMUpdate); $i++) {
                        $aray = ([
                            'sd_stock' => $idS,
                            'sd_detailid' => $i + 11,
                            'sd_specificcode' => $scSMUpdate[$i]->sm_specificcode
                        ]);
                        array_push($arayDelSD, $aray);
                    }
                    DB::table('d_stock_dt')->insert($arayDelSD);

                    //=========
                    // D_STOCK
                    //=========
                    DB::table('d_stock')->where('s_id', $idS)->update(['s_qty' => count($scSMUpdate)]);

                    DB::table('d_stock_mutation')
                        ->where('sm_stock', $idS)
                        ->where('sm_nota', $getNota->o_reff)->delete();

                } else {
                    //=========================
                    //== FOR Spesificcode = NO
                    //=========================
                    $noSCSMUpdate = DB::table('d_stock_mutation')
                        ->where('sm_stock', $idS)
                        ->where('sm_detail', 'PENGURANGAN')
                        ->where('sm_nota', $getNota->o_reff)
                        ->select('sm_qty', 'sm_reff')->get();

                    //// JIKA ADA PENGURANGAN yang dibuat oleh OPNAME BARANG
                    if (!empty($noSCSMUpdate)) {
                        $arayNoSCUpdate = array();
                        //// AMBIL sm_use dan sm_sisa
                        for ($i = 0; $i < count($noSCSMUpdate); $i++) {
                            $qtyGETUpdate = DB::table('d_stock_mutation')
                                ->where('sm_stock', $idS)
                                ->where('sm_nota', $noSCSMUpdate[$i]->sm_reff)
                                ->select('sm_sisa', 'sm_use')->first();

                            array_push($arayNoSCUpdate, $qtyGETUpdate);
                        }

                        for ($i = 0; $i < count($noSCSMUpdate); $i++) {
                            $useU = $arayNoSCUpdate[$i]->sm_use - $noSCSMUpdate[$i]->sm_qty;
                            $sisaU = $arayNoSCUpdate[$i]->sm_sisa + $noSCSMUpdate[$i]->sm_qty;
                            // dd($arayNoSCUpdate);

                            DB::table('d_stock_mutation')
                                ->where('sm_stock', $idS)
                                ->where('sm_nota', $noSCSMUpdate[$i]->sm_reff)
                                ->where('sm_detail', 'PENAMBAHAN')
                                ->update([
                                    'sm_use' => $useU, 'sm_sisa' => $sisaU
                                ]);
                        }

                    }
                    DB::table('d_stock_mutation')->where('sm_nota', $getNota->o_reff)->delete();
                }


                ///////////////////////////////
                DB::table('d_opname')->where('o_id', $id)->delete();
                DB::table('d_opname_dt')->where('od_opname', $id)->delete();

                DB::commit();
                PlasmafoneController::logActivity($log);
                return json_encode([
                    'status' => 'hobSukses'
                ]);

            } catch (\Exception $e) {

                DB::rollback();
                return json_encode([
                    'status' => 'hobGagal',
                    'msg' => $e
                ]);
            }
        }

    }

}
