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

    public function get_data_harga()
    {
        $active = Item::where('i_isactive', 'Y')->orderBy('created_at', 'desc')->get();
        $active = collect($active);

        return DataTables::of($active)

            ->addColumn('aksi', function ($active) {
                if (Plasma::checkAkses(15, 'update') == true) {
                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Set Harga" onclick="edit(\'' . $active->i_id . '\')"><i class="glyphicon glyphicon-edit"></i></button></div>';
                }
            })
            ->rawColumns(['aksi'])
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
