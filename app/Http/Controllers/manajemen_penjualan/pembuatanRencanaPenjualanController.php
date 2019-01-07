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

    public function get_data_approved()
    {

        $appr = DB::table('d_sales_plan')
            ->join('m_company', 'c_id', '=', 'sp_comp')
            ->leftjoin('d_sales_plan_dt', 'spd_sales_plan', '=', 'sp_id')
            ->select('sp_id', 'sp_comp', 'c_name', 'sp_nota', 'sp_update')->distinct();

        return DataTables::of($appr)
            ->addColumn('aksi', function ($appr) {
                $detil = '<button class="btn btn-circle btn-primary" onclick="detil(\'' . Crypt::encrypt($appr->sp_id) . '\')"><i class="glyphicon glyphicon-list"></i></button>';
                $edit = '<button class="btn btn-circle btn-warning" onclick="edit(\'' . Crypt::encrypt($appr->sp_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>';
                $hapus = '<button class="btn btn-circle btn-danger" onclick="hapus(\'' . Crypt::encrypt($appr->sp_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                if (PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == true) {
                    return '<div class="text-center">' . $detil . '&nbsp;' . $edit . '&nbsp;' . $hapus . '</div>';
                } elseif (PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == false) {
                    return '<div class="text-center">' . $detil . '&nbsp;' . $edit . '</div>';
                } elseif (PlasmafoneController::checkAkses(26, 'update') == false && PlasmafoneController::checkAkses(26, 'delete') == true) {
                    return '<div class="text-center">' . $detil . '&nbsp;' . $hapus . '</div>';
                } else {
                    return '<div class="text-center">' . $detil . '</div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_data_pending()
    {
        $pend = DB::table('d_sales_plan')
            ->join('m_company', 'c_id', '=', 'sp_comp')
            ->join('d_sales_plan_dt_draft', 'spdd_sales_plan', '=', 'sp_id')
            ->select('sp_id', 'sp_comp', 'c_name', 'sp_nota', 'sp_update')->distinct()
            ->whereRaw('sp_id = spdd_sales_plan');

        return DataTables::of($pend)
            ->addColumn('aksi', function ($pend) {
                $approve = '<button class="btn btn-circle btn-success" onclick="approve(\'' . Crypt::encrypt($pend->sp_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                $detil = '<button class="btn btn-circle btn-primary" onclick="detil(\'' . Crypt::encrypt($pend->sp_id) . '\')"><i class="glyphicon glyphicon-list"></i></button>';
                $edit = '<button class="btn btn-circle btn-warning" onclick="edit(\'' . Crypt::encrypt($pend->sp_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>';
                $hapus = '<button class="btn btn-circle btn-danger" onclick="hapus(\'' . Crypt::encrypt($pend->sp_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                if (Auth::user()->m_level > 3 && PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == true) {
                    return '<div class="text-center">' . $detil . '&nbsp;' . $edit . '&nbsp;' . $hapus . '</div>';
                } elseif (Auth::user()->m_level > 3 && PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == false) {
                    return '<div class="text-center">' . $detil . '&nbsp;' . $edit . '</div>';
                } elseif (Auth::user()->m_level < 4 && PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == true) {
                    return '<div class="text-center">' . $approve . '&nbsp;' . $detil . '&nbsp;' . $edit . '&nbsp;' . $hapus . '</div>';
                } elseif (Auth::user()->m_level < 4 && PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == false) {
                    return '<div class="text-center">' . $approve . '&nbsp;' . $detil . '&nbsp;' . $edit . '</div>';
                } elseif (PlasmafoneController::checkAkses(26, 'update') == false && PlasmafoneController::checkAkses(26, 'delete') == true) {
                    return '<div class="text-center">' . $detil . '&nbsp;' . $hapus . '</div>';
                } else {
                    return '<div class="text-center">' . $detil . '</div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
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

    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $cek = DB::table('d_sales_plan')
            ->join('d_sales_plan_dt_draft', 'spdd_sales_plan', '=', 'sp_id')
            ->where('sp_id', $id)->count();
        $data = '';
        if ($cek == 0) {
            $data = DB::table('d_sales_plan_dt')
                ->join('d_item', 'i_id', '=', 'spd_item')
                ->select('i_nama', DB::raw('spd_qty as qty'))
                ->where('spd_sales_plan', $id)->get();
        } else {
            $data = DB::table('d_sales_plan_dt_draft')
                ->join('d_item', 'i_id', '=', 'spdd_item')
                ->select('i_nama', DB::raw('spdd_qty as qty'))
                ->where('spdd_sales_plan', $id)->get();
        }

        $dataSP = DB::table('d_sales_plan')
            ->join('m_company', 'c_id', '=', 'sp_comp')
            ->select('sp_nota', 'c_name')->where('sp_id', $id)->first();

        return json_encode([
            'data' => $data,
            'sp' => $dataSP
        ]);
    }

    public function detail_dt()
    {

    }

    public function cari(Request $request)
    {
        $idComp = $request->z;
        $month = '';
        if ($request->y != '') {
            $pisah = explode('/', $request->y);
            $month = $pisah[1] . '-' . $pisah[0];
        }
        $data = '';
        $aksi = '';
        // dd($month);
        if ($request->x == 'a') {
            if ($idComp == '' && $month != '') {
                $data = DB::table('d_sales_plan')
                    ->join('m_company', 'c_id', '=', 'sp_comp')
                    ->whereRaw('sp_date like "%' . $month . '%"')
                    ->select('sp_id', 'sp_nota', 'c_name', 'sp_update')->get();
            } elseif ($idComp != '' && $month == '') {
                $data = DB::table('d_sales_plan')
                    ->join('m_company', 'c_id', '=', 'sp_comp')
                    ->where('sp_comp', $idComp)
                    ->select('sp_id', 'sp_nota', 'c_name', 'sp_update')->get();
            } elseif ($idComp != '' && $month != '') {
                $data = DB::table('d_sales_plan')
                    ->join('m_company', 'c_id', '=', 'sp_comp')
                    ->whereRaw('sp_date like "%' . $month . '%"')
                    ->where('sp_comp', $idComp)
                    ->select('sp_id', 'sp_nota', 'c_name', 'sp_update')->get();
            }

            return DataTables::of($data)
                ->addColumn('aksi', function ($data) {
                    $detil = '<button class="btn btn-circle btn-primary" onclick="detil(\'' . Crypt::encrypt($data->sp_id) . '\')"><i class="glyphicon glyphicon-list"></i></button>';
                    $edit = '<button class="btn btn-circle btn-warning" onclick="edit(\'' . Crypt::encrypt($data->sp_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>';
                    $hapus = '<button class="btn btn-circle btn-danger" onclick="hapus(\'' . Crypt::encrypt($data->sp_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                    if (PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == true) {
                        return '<div class="text-center">' . $detil . '&nbsp;' . $edit . '&nbsp;' . $hapus . '</div>';
                    } elseif (PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == false) {
                        return '<div class="text-center">' . $detil . '&nbsp;' . $edit . '</div>';
                    } elseif (PlasmafoneController::checkAkses(26, 'update') == false && PlasmafoneController::checkAkses(26, 'delete') == true) {
                        return '<div class="text-center">' . $detil . '&nbsp;' . $hapus . '</div>';
                    } else {
                        return '<div class="text-center">' . $detil . '</div>';
                    }
                })
                ->rawColumns(['aksi'])
                ->make(true);

        } else {
            if ($idComp == '' && $month != '') {
                $data = DB::table('d_sales_plan')
                    ->join('m_company', 'c_id', '=', 'sp_comp')
                    ->join('d_sales_plan_dt_draft', 'spdd_sales_plan', '=', 'sp_id')
                    ->whereRaw('sp_date like "%' . $month . '%"')
                    ->select('sp_id', 'sp_nota', 'c_name', 'sp_update')->distinct()->get();
            } elseif ($idComp != '' && $month == '') {
                $data = DB::table('d_sales_plan')
                    ->join('m_company', 'c_id', '=', 'sp_comp')
                    ->join('d_sales_plan_dt_draft', 'spdd_sales_plan', '=', 'sp_id')
                    ->where('sp_comp', $idComp)
                    ->select('sp_id', 'sp_nota', 'c_name', 'sp_update')->distinct()->get();
            } elseif ($idComp != '' && $month != '') {
                $data = DB::table('d_sales_plan')
                    ->join('m_company', 'c_id', '=', 'sp_comp')
                    ->join('d_sales_plan_dt_draft', 'spdd_sales_plan', '=', 'sp_id')
                    ->whereRaw('sp_date like "%' . $month . '%"')
                    ->where('sp_comp', $idComp)
                    ->select('sp_id', 'sp_nota', 'c_name', 'sp_update')->distinct()->get();
            }

            return DataTables::of($data)
                ->addColumn('aksi', function ($data) {
                    $approve = '<button class="btn btn-circle btn-success" onclick="approve(\'' . Crypt::encrypt($data->sp_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                    $detil = '<button class="btn btn-circle btn-primary" onclick="detil(\'' . Crypt::encrypt($data->sp_id) . '\')"><i class="glyphicon glyphicon-list"></i></button>';
                    $edit = '<button class="btn btn-circle btn-warning" onclick="edit(\'' . Crypt::encrypt($data->sp_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>';
                    $hapus = '<button class="btn btn-circle btn-danger" onclick="hapus(\'' . Crypt::encrypt($data->sp_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                    if (Auth::user()->m_level > 3 && PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == true) {
                        return '<div class="text-center">' . $detil . '&nbsp;' . $edit . '&nbsp;' . $hapus . '</div>';
                    } elseif (Auth::user()->m_level > 3 && PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == false) {
                        return '<div class="text-center">' . $detil . '&nbsp;' . $edit . '</div>';
                    } elseif (Auth::user()->m_level < 4 && PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == true) {
                        return '<div class="text-center">' . $approve . '&nbsp;' . $detil . '&nbsp;' . $edit . '&nbsp;' . $hapus . '</div>';
                    } elseif (Auth::user()->m_level < 4 && PlasmafoneController::checkAkses(26, 'update') == true && PlasmafoneController::checkAkses(26, 'delete') == false) {
                        return '<div class="text-center">' . $approve . '&nbsp;' . $detil . '&nbsp;' . $edit . '</div>';
                    } elseif (PlasmafoneController::checkAkses(26, 'update') == false && PlasmafoneController::checkAkses(26, 'delete') == true) {
                        return '<div class="text-center">' . $detil . '&nbsp;' . $hapus . '</div>';
                    } else {
                        return '<div class="text-center">' . $detil . '</div>';
                    }
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        // dd($data);
        // return json_encode([
        //     'data' => $data
        // ]);

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
                    $cek = DB::table('d_sales_plan')->where('sp_comp', $sp_comp)->whereRaw('RIGHT(sp_nota, 7) like "%' . substr($sp_nota, 7) . '%"')->count();
                    if ($cek > 0) {
                        return json_encode([
                            'status' => 'ada',
                        ]);
                    }

                    $idSP = DB::table('d_sales_plan')->select('sp_id')->max('sp_id');

                    DB::table('d_sales_plan')->insert([
                        'sp_id' => $idSP + 1,
                        'sp_comp' => $sp_comp,
                        'sp_nota' => $sp_nota,
                        'sp_date' => $sp_date,
                        'sp_insert' => $sp_insert,
                        'sp_update' => $sp_insert
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
                } catch (\Exception $e) {
                    DB::rollback();
                    return json_encode([
                        'status' => 'trpGagal'
                    ]);
                }

            }

            return view('manajemen_penjualan.rencana_penjualan.tambah');
        }
    }

    function edit(Request $request, $id = null)
    {
        if (PlasmafoneController::checkAkses(26, 'update') == false) {
            return view('errors.407');
        } else {

            $id = Crypt::decrypt($id);

            if ($request->isMethod('post')) {

                DB::beginTransaction();
                try {
                    $idItem = $request->idItem;
                    $qty = $request->qtyItem;

                    $sp_update = Carbon::now('Asia/Jakarta');

                    DB::table('d_sales_plan')->where('sp_id', $id)->update([
                        'sp_update' => $sp_update
                    ]);

                    $sp_id = DB::table('d_sales_plan')->select('sp_id')->max('sp_id');
                    $detil_array = array();

                    if (Auth::user()->m_level > 3) {

                        for ($i = 0; $i < count($idItem); $i++) {
                            $aray = ([
                                'spdd_sales_plan' => $sp_id,
                                'spdd_detailid' => $i + 1,
                                'spdd_item' => $idItem[$i],
                                'spdd_qty' => $qty[$i]
                            ]);
                            array_push($detil_array, $aray);
                        }

                        $cek = DB::table('d_sales_plan_dt_draft')->where('spdd_sales_plan', $id)->count();
                        if ($cek > 0) {
                            DB::table('d_sales_plan_dt_draft')->where('spdd_sales_plan', $id)->delete();
                        }
                        DB::table('d_sales_plan_dt_draft')->insert($detil_array);

                    } else {

                        for ($i = 0; $i < count($idItem); $i++) {

                            $aray = ([
                                'spd_sales_plan' => $sp_id,
                                'spd_detailid' => $i + 1,
                                'spd_item' => $idItem[$i],
                                'spd_qty' => $qty[$i]
                            ]);

                            array_push($detil_array, $aray);
                        }

                        DB::table('d_sales_plan_dt')->where('spd_sales_plan', $id)->delete();
                        DB::table('d_sales_plan_dt')->insert($detil_array);
                        DB::table('d_sales_plan_dt_draft')->where('spdd_sales_plan', $id)->delete();
                    }

                    DB::commit();

                    return json_encode([
                        'status' => 'erpSukses'
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return json_encode([
                        'status' => 'erpGagal',
                        'msg' => $e
                    ]);
                }
            }

            $sp = DB::table('d_sales_plan')
                ->join('m_company', 'c_id', '=', 'sp_comp')
                ->select('sp_nota', 'sp_update', 'sp_comp', 'sp_keterangan', 'c_name')
                ->where('sp_id', $id)->get();

            $id = Crypt::encrypt($id);

            return view('manajemen_penjualan.rencana_penjualan.edit')->with(compact('sp', 'id'));
        }
    }

    function edit_dt($id)
    {
        $id = Crypt::decrypt($id);
        $ceksp = DB::table('d_sales_plan')->join('d_sales_plan_dt_draft', 'spdd_sales_plan', '=', 'sp_id')->where('spdd_sales_plan', $id)->count();
        $spd = '';
        if ($ceksp == 0) {
            $spd = DB::table('d_sales_plan_dt')
                ->join('d_item', 'i_id', '=', 'spd_item')
                ->select(DB::raw('spd_item as itemId'), DB::raw('spd_qty as qty'), 'i_nama')
                ->where('spd_sales_plan', $id)->get();
        } else {
            $spd = DB::table('d_sales_plan_dt_draft')
                ->join('d_item', 'i_id', '=', 'spdd_item')
                ->select(DB::raw('spdd_item as itemId'), DB::raw('spdd_qty as qty'), 'i_nama')
                ->where('spdd_sales_plan', $id)->get();
        }

        return json_encode([
            'data' => $spd
        ]);
    }

    function approve($id)
    {
        if (PlasmafoneController::checkAkses(26, 'update') == true && Auth::user()->m_level < 4) {

            $id = Crypt::decrypt($id);
            DB::beginTransaction();
            try {

                $getSPDD = DB::table('d_sales_plan_dt_draft')->where('spdd_sales_plan', $id)->get();

                dd($getSPDD);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }

        }
    }

    function hapus($id)
    {
        if (PlasmafoneController::checkAkses(26, 'delete') == false) {
            return view('errors.407');
        } else {

            $id = Crypt::decrypt($id);
            DB::beginTransaction();
            try {
                $getData = DB::table('d_sales_plan')
                    ->join('m_company', 'c_id', '=', 'sp_comp')
                    ->select('sp_nota', 'c_name')
                    ->where('sp_id', $id)->first();

                $nota = $getData->sp_nota;
                $cabang = $getData->c_name;

                DB::table('d_sales_plan')->where('sp_id', $id)->delete();
                DB::table('d_sales_plan_dt')->where('spd_sales_plan', $id)->delete();
                $cek = DB::table('d_sales_plan_dt')->where('spd_sales_plan', $id)->count();
                if ($cek > 0) {
                    DB::table('d_sales_plan_dt')->where('spd_sales_plan', $id)->delete();
                }
                DB::commit();
                $log = 'Menghapus Rencana Pembelian dengan No. Nota : ' . $nota . ' (' . $cabang . ')';
                PlasmafoneController::logActivity($log);
                return json_encode([
                    'status' => 'hrpSukses',
                    'data' => $nota . ' (' . $cabang . ')'
                ]);

            } catch (\Exception $e) {

                DB::rollback();
                return json_encode([
                    'status' => 'hrpGagal',
                    'data' => $nota . ' (' . $cabang . ')',
                    'msg' => $e
                ]);
            }

        }
    }
}
