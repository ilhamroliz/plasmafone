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
            $date = Carbon::now()->format('d/m/Y');
            return view('inventory.opname_barang.pusat')->with(compact('date'));
        }
    }

    public function outlet()
    {
        if (PlasmafoneController::checkAkses(12, 'read') == false) {
            return view('errors.407');
        } else {
            $date = Carbon::now()->format('d/m/Y');
            $cid = Auth::user()->m_comp;
            if ($cid != "PF00000001") {
                $getCN = DB::table('m_company')->select('c_name')->where('c_id', $cid)->first();
            }
            return view('inventory.opname_barang.outlet')->with(compact('date', 'getCN'));
        }
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
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir);

                } else if ($idItem != '' && $idComp == '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('od_item', $idItem);
                } else if ($idItem == '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('o_comp', $idComp);

                } else if ($idItem != '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
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
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('od_item', $idItem);

                } else if ($idItem == '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_comp', $idComp);

                } else if ($idItem != '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'DONE')
                        ->where('o_comp', $idComp)
                        ->where('od_item', $idItem);

                } else {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
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
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir);

                } else if ($idItem != '' && $idComp == '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('od_item', 'o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('od_item', $idItem);

                } else if ($idItem == '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_date', '>=', $awal)
                        ->where('o_date', '<=', $akhir)
                        ->where('o_comp', $idComp);

                } else if ($idItem != '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('od_item', 'o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
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
                        ->select('od_item', 'o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('od_item', $idItem);

                } else if ($idItem == '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_comp', $idComp);

                } else if ($idItem != '' && $idComp != '') {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('od_item', 'o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
                        ->where('o_status', 'PENDING')
                        ->where('o_comp', $idComp)
                        ->where('od_item', $idItem);

                } else {
                    $pcr = DB::table('d_opname')
                        ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
                        ->join('m_company', 'c_id', '=', 'o_comp')
                        ->join('d_item', 'i_id', '=', 'od_item')
                        ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
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

        $gappr = DB::table('d_opname')
            ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
            ->join('m_company', 'c_id', '=', 'o_comp')
            ->join('d_item', 'i_id', '=', 'od_item')
            ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
            ->where('o_status', 'DONE');

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
        $gpend = DB::table('d_opname')
            ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
            ->join('m_company', 'c_id', '=', 'o_comp')
            ->join('d_item', 'i_id', '=', 'od_item')
            ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
            ->where('o_status', 'PENDING');

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
                    return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '</div>';
                } else {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_approved_outlet()
    {
        $comp = Auth::user()->m_comp;
        $gappr = DB::table('d_opname')
            ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
            ->join('m_company', 'c_id', '=', 'o_comp')
            ->join('d_item', 'i_id', '=', 'od_item')
            ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
            ->where('o_status', 'DONE')
            ->where('o_comp', $comp);

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
        $comp = Auth::user()->m_comp;
        $gpend = DB::table('d_opname')
            ->leftjoin('d_opname_dt', 'od_opname', '=', 'o_id')
            ->join('m_company', 'c_id', '=', 'o_comp')
            ->join('d_item', 'i_id', '=', 'od_item')
            ->select('o_id', 'o_reff', 'o_date', 'c_name', 'i_nama')->distinct('o_reff')
            ->where('o_status', 'PENDING')
            ->where('o_comp', $comp);

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
                    return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '</div>';
                } else {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $appr . '&nbsp;' . $edit . '&nbsp;' . $delete . '</div>';
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

            if ($sc == 'Y' && $ex == 'N' || $sc == 'Y' && $ex == 'Y') {

                $imeiR = $request->imeiR;
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
                        'od_specificcode' => $imeiR[$i]
                    ]);
                    array_push($od_array, $aray);
                }

                DB::table('d_opname_dt')->insert($od_array);

            } else {
                $pisah = explode(' ', $request->qtyR);
                $qtyR = $pisah[0];
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
                    'od_specificcode' => ''
                ]);

            }

            /////
            ////////////////////////////////////////////

            // ///// UPDATE pada data D_STOCK_DT
            // ///// Jika Barang tidak memiliki IMEI maka Tidak memasukan ke D_STOCK_DT
            // if (!empty($sd_array)) {
            //     $getIdS = DB::table('d_stock')->where('s_item', $idItem)->select('s_id')->first();
            //     $maxIdS = DB::table('d_stock_dt')->where('sd_stock', $getIdS->s_id)->max('sd_detailid');
            //     $usd_array = array();
            //     for ($j = 0; $j < count($sd_array); $j++) {
            //         $aray = ([
            //             'sd_stock' => $getIdS->s_id,
            //             'sd_detailid' => $maxIdS + ($j + 1),
            //             'sd_specificcode' => $sd_array[$j]
            //         ]);
            //         array_push($usd_array, $aray);
            //     }

            //     DB::table('d_stock_dt')->insert($usd_array);

            // }


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

    public function tambahOutlet(Request $request)
    {
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

            if ($sc == 'Y' && $ex == 'N' || $sc == 'Y' && $ex == 'Y') {

                $imeiR = $request->imeiR;
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
                        'od_specificcode' => $imeiR[$i]
                    ]);
                    array_push($od_array, $aray);
                }

                DB::table('d_opname_dt')->insert($od_array);

            } else {
                $pisah = explode(' ', $request->qtyR);
                $qtyR = $pisah[0];
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
                    'od_specificcode' => ''
                ]);

            }

            /////
            ////////////////////////////////////////////

            // ///// UPDATE pada data D_STOCK_DT
            // ///// Jika Barang tidak memiliki IMEI maka Tidak memasukan ke D_STOCK_DT
            // if (!empty($sd_array)) {
            //     $getIdS = DB::table('d_stock')->where('s_item', $idItem)->select('s_id')->first();
            //     $maxIdS = DB::table('d_stock_dt')->where('sd_stock', $getIdS->s_id)->max('sd_detailid');
            //     $usd_array = array();
            //     for ($j = 0; $j < count($sd_array); $j++) {
            //         $aray = ([
            //             'sd_stock' => $getIdS->s_id,
            //             'sd_detailid' => $maxIdS + ($j + 1),
            //             'sd_specificcode' => $sd_array[$j]
            //         ]);
            //         array_push($usd_array, $aray);
            //     }

            //     DB::table('d_stock_dt')->insert($usd_array);

            // }


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

    public function hapus(Request $request)
    {
        if (PlasmafoneController::checkAkses(11, 'delete') == false) {
            return view('errors.407');
        } else {
            DB::beginTransaction();
            try {
                $id = Crypt::decrypt($request->id);

                DB::table('d_opname')->where('o_id', $id)->delete();
                DB::table('d_opname_dt')->where('od_opname', $id)->delete();

                DB::commit();
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
        if (PlasmafoneController::checkAkses(11, 'delete') == false) {
            return view('errors.407');
        } else {
            DB::beginTransaction();
            try {
                $id = Crypt::decrypt($request->id);

                DB::table('d_opname')->where('o_id', $id)->delete();
                DB::table('d_opname_dt')->where('od_opname', $id)->delete();

                DB::commit();
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
