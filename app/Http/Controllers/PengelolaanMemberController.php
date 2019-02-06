<?php

namespace App\Http\Controllers;

use DB;
use Response;
use Illuminate\Http\Request;

class PengelolaanMemberController extends Controller
{
    public function index()
    {
        return view('pengelolaan_member.index');
    }

    public function getKonversi()
    {
        $data = DB::table('d_saldo_converting')
            ->first();
        return json_encode($data);
    }

    public function updateKonversi(Request $request)
    {
        $saldo = str_replace(' Poin', '', $request->saldo);
        $saldo = str_replace('.', '', $saldo);
        $uang = str_replace('Rp. ', '', $request->uang);
        $uang = str_replace('.', '', $uang);
        DB::table('d_saldo_converting')
            ->where('sc_id', '=', '1')
            ->update([
                'sc_saldo' => $saldo,
                'sc_money' => $uang
            ]);
        return Response::json([
            'status' => 'sukses'
        ]);
    }
}
