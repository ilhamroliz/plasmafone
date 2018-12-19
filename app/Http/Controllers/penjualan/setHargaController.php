<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController as Plasma;
use App\Model\master\d_item as Item;


class setHargaController extends Controller
{
    public function index()
    {
        if (Plasma::checkAkses(15, 'read') == false) {
            return view('errors/407');
        } else {
            return view('penjualan.set_harga.index');
        }
    }

    public function edit(Request $request, $id = null)
    {
        if (Access::checkAkses(15, 'update') == false) {

            return json_encode([
                'status' => 'ditolak'
            ]);

        } else {

            if ($request->isMethod('post')) {

                if (Access::checkAkses(15, 'update') == false) {

                    return json_encode([
                        'status' => 'ditolak'
                    ]);

                } else {



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
