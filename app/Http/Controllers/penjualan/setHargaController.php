<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController as Plasma;
use Illuminate\Support\Facades\Crypt;

use DataTables;
use DB;
use Session;
use Auth;
use Carbon\Carbon;

class setHargaController extends Controller
{
    public function index()
    {
        if (Plasma::checkAkses(15, 'read') == false) {
            return view('errors/407');
        } else {
            $group = DB::table('m_group')->select('g_id', 'g_name')->get();
            return view('penjualan.set_harga.index')->with(compact('group'));
        }
    }

    public function get_data_harga($id)
    {
        $gp = DB::table('m_group_price')
            ->join('d_item', 'i_id', '=', 'gp_item')
            ->where('gp_group', $id)
            ->select('m_group_price.*', 'i_nama')
            ->orderBy('i_nama', 'asc')->get();

        $gp = collect($gp);

        return DataTables::of($gp)
            ->addColumn('aksi', function ($gp) {
                if (Plasma::checkAkses(15, 'update') == true) {
                    return '<div class="text-center">
                                <button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Set Harga" onclick="edit(\'' . $gp->gp_item . '\')"><i class="glyphicon glyphicon-edit"></i></button>
                            </div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_data_group()
    {
        $group = DB::table('m_group')->get();
        $group = collect($group);

        return DataTables::of($group)
            // ->addIndexColumn()
            ->addColumn('group_name', function ($group) {
                return '<div class="text-center">
                            <a onclick="show(\'' . $group->g_id . '\')">\'' . $group->g_name . '\'</a>
                        </div>';
            })
            ->rawColumns(['group_name'])
            ->make(true);
    }

    public function edit(Request $request, $id = null)
    {
        // dd($id);
        if (Plasma::checkAkses(15, 'update') == false) {

            return json_encode([
                'status' => 'ditolak'
            ]);

        } else {

            // $id = Crypt::decrypt($id);
            if ($request->isMethod('post')) {

                if (Plasma::checkAkses(15, 'update') == false) {

                    return json_encode([
                        'status' => 'ditolak'
                    ]);

                } else {

                    $data = $request->all();
                    DB::beginTransaction();

                    try {

                        $now = Carbon::now('Asia/Jakarta');
                        $harga = implode("", explode(".", $data['harga']));
                        // $dd($harga);
                        if ($data['tipe'] == '1') {
                            Item::where('i_id', $id)->update([
                                'i_price_1' => $harga,
                                'updated_at' => $now
                            ]);
                        } else if ($data['tipe'] == '2') {
                            Item::where('i_id', $id)->update([
                                'i_price_2' => $harga,
                                'updated_at' => $now
                            ]);
                        } else if ($data['tipe'] == '3') {
                            Item::where('i_id', $id)->update([
                                'i_price_3' => $harga,
                                'updated_at' => $now
                            ]);
                        } else if ($data['tipe'] == '4') {
                            Item::where('i_id', $id)->update([
                                'i_price_4' => $harga,
                                'updated_at' => $now
                            ]);
                        }

                        DB::commit();

                        return json_encode([
                            'status' => 'setberhasil'
                        ]);

                    } catch (\Exception $e) {

                        DB::rollback();
                        return json_encode([
                            'status' => 'gagal',
                            'msg' => $e
                        ]);
                    }

                }
            }

            $item = Item::where(['i_id' => $id])->first();
            return response()->json([
                'status' => 'OK',
                'data' => $item
            ]);
        }
    }
}
