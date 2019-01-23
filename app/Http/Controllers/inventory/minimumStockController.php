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

    public function get_warning()
    {
        $getWarning = DB::table('d_stock')
            ->join('m_company', 'c_id', '=', 's_comp')
            ->join('d_item', 'i_id', '=', 's_item')
            ->where('s_min', '>', 0)
            ->whereRaw('s_qty <= s_min');

        return DataTables::of($getWarning)
            ->addColumn('s_qty', function ($getWarning) {
                return '<div class="text-align-right">' . $getWarning->s_qty . ' Unit</div>';
            })
            ->addColumn('s_min', function ($getWarning) {
                return '<div class="text-align-right">' . $getWarning->s_min . ' Unit</div>';
            })
            ->addColumn('aksi', function ($getWarning) {
                $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($getWarning->s_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                $nonactive = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Set Nonactive" onclick="nonactive(\'' . Crypt::encrypt($getWarning->s_id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>';
                if (PlasmafoneController::checkAkses(13, 'update') == false) {
                    return '<div class="text-center"</div>';
                } else {
                    return '<div class="text-center">'. $edit . '&nbsp;' . $nonactive . '</div>';
                }
            })
            ->rawColumns(['s_qty', 's_min', 'aksi'])
            ->make(true);
    }

    public function get_active()
    {
        $getActive = DB::table('d_stock')
            ->join('m_company', 'c_id', '=', 's_comp')
            ->join('d_item', 'i_id', '=', 's_item')
            ->where('s_min', '>', 0);

        return DataTables::of($getActive)
            ->addColumn('s_qty', function ($getWarning) {
                return '<div class="text-align-right">' . $getWarning->s_qty . ' Unit</div>';
            })
            ->addColumn('s_min', function ($getActive) {
                return '<div class="text-align-right">' . $getActive->s_min . ' Unit</div>';
            })
            ->addColumn('aksi', function ($getActive) {
                $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($getActive->s_id) . '\')"><i class="glyphicon glyphicon-pencil"></i></button>';
                $nonactive = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Set Nonactive" onclick="nonactive(\'' . Crypt::encrypt($getActive->s_id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>';
                if (PlasmafoneController::checkAkses(13, 'update') == false) {
                    return '<div class="text-center"></div>';
                } else {
                    return '<div class="text-center">' . $edit . '&nbsp;' . $nonactive . '</div>';
                }
            })
            ->rawColumns(['s_qty','s_min', 'aksi'])
            ->make(true);
    }

    public function get_nonactive()
    {
        $getNonActive = DB::table('d_stock')
            ->join('m_company', 'c_id', '=', 's_comp')
            ->join('d_item', 'i_id', '=', 's_item')
            ->where('s_min', '=', 0);

        return DataTables::of($getNonActive)
            ->addColumn('s_qty', function ($getWarning) {
                return '<div class="text-align-right">' . $getWarning->s_qty . ' Unit</div>';
            })
            ->addColumn('s_min', function ($getNonActive) {
                return '<div class="text-align-right">' . $getNonActive->s_min . ' Unit</div>';
            })
            ->addColumn('aksi', function ($getNonActive) {
                $active = '<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Set Active" onclick="active(\'' . Crypt::encrypt($getNonActive->s_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>';
                if (PlasmafoneController::checkAkses(13, 'update') == false) {
                    return '<div class="text-center"></div>';
                } else {
                    return '<div class="text-center">' . $active . '</div>';
                }
            })
            ->rawColumns(['s_qty','s_min', 'aksi'])
            ->make(true);
    }

    public function cek_warn()
    {
        $getWarn = '';
        $getCount = '';
        if(Auth::user()->m_comp == "PF00000001"){
            $getWarn = DB::table('d_stock')
                ->join('m_company', 'c_id', '=', 's_comp')
                ->join('d_item', 'i_id', '=', 's_item')
                ->where('s_min', '>', 0)
                ->whereRaw('s_min >= s_qty')->get();
            $getCount = DB::table('d_stock')
                ->join('m_company', 'c_id', '=', 's_comp')
                ->join('d_item', 'i_id', '=', 's_item')
                ->where('s_min', '>', 0)
                ->whereRaw('s_min >= s_qty')->count();
        }else{
            $getWarn = DB::table('d_stock')
                ->join('m_company', 'c_id', '=', 's_comp')
                ->join('d_item', 'i_id', '=', 's_item')
                ->where('s_min', '!=', 0)
                ->where('s_min', '>=', 's_qty')
                ->where('s_position', Auth::user()->m_comp)->get();
            $getCount = DB::table('d_stock')
                ->join('m_company', 'c_id', '=', 's_comp')
                ->join('d_item', 'i_id', '=', 's_item')
                ->where('s_min', '!=', 0)
                ->where('s_min', '>=', 's_qty')
                ->where('s_position', Auth::user()->m_comp)->count();
        }

        // dd($getWarn);
        return json_encode([
            'data' => $getWarn,
            'count' => $getCount
        ]);
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
        if (PlasmafoneController::checkAkses(13, 'update') == false) {
            return view('errors.407');
        } else {
           
            $id = Crypt::decrypt($request->id);
            if($request->isMethod('post')){
                // dd($request);

                DB::beginTransaction();
                try {
                    
                    $min = $request->minStock;

                    DB::table('d_stock')->where('s_id', $id)->update([ 's_min' => $min ]);
            
                    DB::commit();
                    return json_encode([
                        'status' => 'eSukses'
                    ]);

                } catch (\Exception $e) {
                    
                    DB::rollback();
                    return json_encode([
                        'status' => 'eGagal',
                        'msg' => $e
                    ]);
                }
            }
            
            $getData = DB::table('d_stock')
                ->join('m_company', 'c_id', '=', 's_position')
                ->join('d_item', 'i_id', '=', 's_item')
                ->where('s_id', $id)
                ->select('s_position','c_name','s_item','i_nama','s_min')->first();

            return json_encode([
                'data' => $getData
            ]);
        }
    }

    public function set_active(Request $request)
    {
        if (PlasmafoneController::checkAkses(13, 'update') == false) {
            return view('errors.407');
        } else {
           
            DB::beginTransaction();
            try {
                
                $id = Crypt::decrypt($request->id);
                $min = $request->min;

                DB::table('d_stock')->where('s_id', $id)->update([ 's_min' => $min ]);
           
                DB::commit();
                return json_encode([
                    'status' => 'saSukses'
                ]);

            } catch (\Exception $e) {
                
                DB::rollback();
                return json_encode([
                    'status' => 'saGagal',
                    'msg' => $e
                ]);
            }

        }
    }

    public function set_nonactive(Request $request)
    {
        if (PlasmafoneController::checkAkses(13, 'update') == false) {
            return view('errors.407');
        } else {

            DB::beginTransaction();
            try {
                
                $id = Crypt::decrypt($request->id);
                DB::table('d_stock')->where('s_id', $id)->update([ 's_min' => 0 ]);
                
                DB::commit();
                return json_encode([
                    'status' => 'snSukses'
                ]);

            } catch (\Exception $e) {
                
                DB::rollback();
                return json_encode([
                    'status' => 'snGagal',
                    'msg' => $e
                ]);
            }


        }
    }
}
