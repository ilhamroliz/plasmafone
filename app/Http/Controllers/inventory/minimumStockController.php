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

class minimumStockController extends Controller
{
    public function index()
    {
        if (PlasmafoneController::checkAkses(13, 'read') == false) {
            return view('errors.407');
        } else {
            $getCN = DB::table('m_company')->where('c_id', Auth::user()->m_comp)->select('c_name')->first();
            return view('inventory.minimum_stock.index')->with(compact('getCN'));
        }
    }

    public function get_active()
    {
        $getActive = DB::table('d_stock')
            ->join('m_company', 'c_id', '=', 's_comp')
            ->join('d_item', 'i_id', '=', 's_item')
            ->where('s_min', '>', 0);

        return DataTables::of($getActive)
            ->addColumn('s_min', function ($getActive) {
                return '<div class="text-align-right">' . $getActive->s_min . ' Unit</div>';
            })
            ->addColumn('aksi', function ($getActive) {
                $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($getActive->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($getActive->s_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                $nonactive = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Set Nonactive" onclick="nonactive(\'' . Crypt::encrypt($getActive->s_id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>';
                if (PlasmafoneController::checkAkses(13, 'update') == false) {
                    return '<div class="text-center">' . $detail . '</div>';
                } else {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $edit . '&nbsp;' . $nonactive . '</div>';
                }
            })
            ->rawColumns(['s_min', 'aksi'])
            ->make(true);
    }

    public function get_nonactive()
    {
        $getNonActive = DB::table('d_stock')
            ->join('m_company', 'c_id', '=', 's_comp')
            ->join('d_item', 'i_id', '=', 's_item')
            ->where('s_min', '=', 0);

        return DataTables::of($getNonActive)
            ->addColumn('s_min', function ($getNonActive) {
                return '<div class="text-align-right">' . $getNonActive->s_min . ' Unit</div>';
            })
            ->addColumn('aksi', function ($getNonActive) {
                $detail = '<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($getNonActive->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                $active = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Set Active" onclick="active(\'' . Crypt::encrypt($getNonActive->s_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                if (PlasmafoneController::checkAkses(13, 'update') == false) {
                    return '<div class="text-center">' . $detail . '</div>';
                } else {
                    return '<div class="text-center">' . $detail . '&nbsp;' . $active . '</div>';
                }
            })
            ->rawColumns(['s_min', 'aksi'])
            ->make(true);
    }

    public function cek_warn()
    {

    }

    public function tambah(Request $request)
    {
        if (PlasmafoneController::checkAkses(13, 'insert') == false) {
            return view('errors.407');
        } else {

            $idItem = $request->idItem;
            $idComp = $request->idComp;

            DB::beginTransaction();
            try {

                $cekMS = DB::table('d_stock')->where('s_item', $idItem)->where('s_position', $idComp)->count();
                if ($cekMS == 0) {
                    $getMaxSID = DB::table('d_stock')->max('s_id');
                    DB::table('d_stock')->insert([
                        's_id' => $getMaxSID + 1,
                        's_comp' => $idComp,
                        's_position' => $idComp,
                        's_item' => $idItem,
                        's_qty' => '',
                        's_min' => $request->minStock
                    ]);
                } else {
                    DB::table('d_stock')->where('s_item', $idItem)->where('s_position', $idComp)->update([
                        's_min' => $request->minStock
                    ]);
                }

                $getLog = DB::table('d_stock')->join('m_company', 'c_id', '=', 's_comp')->join('d_item', 'i_id', '=', 's_item')
                    ->where('s_item', $idItem)->where('s_comp', $idComp)->select('c_name', 'i_nama')->first();

                DB::commit();

                $log = 'Menambahkan Set Minimum Stock untuk Item ' . $getLog->i_nama . ' pada Cabang ' . $getLog->c_name;
                PlasmafoneController::logActivity($log);
                return json_encode([
                    'status' => 'msSukses'
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                return json_encode([
                    'status' => 'msGagal'
                ]);

            }
        }
    }

    public function edit(Request $request)
    {

    }

    public function set_active()
    {
        if (PlasmafoneController::checkAkses(13, 'update') == false) {
            return view('errors.407');
        } else {

        }
    }

    public function set_nonactive()
    {
        if (PlasmafoneController::checkAkses(13, 'update') == false) {
            return view('errors.407');
        } else {

        }
    }
}
