<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        if ($data == null) {
            DB::table('d_saldo_converting')
                ->insert([
                    'sc_id' => 1,
                    'sc_saldo' => 1,
                    'sc_money' => 1
                ]);
            $data = DB::table('d_saldo_converting')
                ->first();
        }
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

    public function getSaldoPoin(Request $request)
    {
        $id = $request->id;
        $data = DB::table('d_saldo')
            ->where('s_member', '=', $id)
            ->first();
        return Response::json(
            $data
        );
    }

    public function saveSaldoPoin(Request $request)
    {
        $member = $request->id_member;
        $saldo = str_replace(' Poin', '', $request->jml_saldo);
        $saldo = str_replace('.', '', $saldo);

        DB::beginTransaction();
        try {
            $nota = CodeGenerator::codePenambahanPoin('d_saldo_purchase', 'sp_nota', '8', '10', '3', 'PP');
            DB::table('d_saldo_purchase')
                ->insert([
                    'sp_date' => Carbon::now('Asia/Jakarta'),
                    'sp_nota' => $nota,
                    'sp_member' => $member,
                    'sp_value' => $saldo
                ]);

            $data = DB::table('d_saldo')
                ->join('d_saldo_mutation', 'sm_saldo', '=', 's_id')
                ->where('s_member', '=', $member)
                ->get();

            if (count($data) > 0) {
                //update
                $saldoAkhir = intval($saldo) + intval($data[0]->s_saldo);
                DB::table('d_saldo')
                    ->where('s_id', '=', $data[0]->s_id)
                    ->update([
                        's_saldo' => $saldoAkhir
                    ]);
                $max = count($data);
                $detailid = $data[$max - 1]->sm_detailid;
                ++$detailid;

                DB::table('d_saldo_mutation')
                    ->insert([
                        'sm_saldo' => $data[0]->s_id,
                        'sm_detailid' => $detailid,
                        'sm_date' => Carbon::now('Asia/Jakarta'),
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_value' => intval($saldo),
                        'sm_note' => 'Penambahan Poin',
                        'sm_nota' => $nota,
                        'sm_reff' => $nota
                    ]);
            } else {
                //create baru
                $getId = DB::table('d_saldo')
                    ->max('s_id');
                ++$getId;
                DB::table('d_saldo')
                    ->insert([
                        's_id' => $getId,
                        's_member' => $member,
                        's_saldo' => $saldo,
                        's_insert' => Carbon::now('Asia/Jakarta'),
                        's_update' => Carbon::now('Asia/Jakarta')
                    ]);
                DB::table('d_saldo_mutation')
                    ->insert([
                        'sm_saldo' => $getId,
                        'sm_detailid' => 1,
                        'sm_date' => Carbon::now('Asia/Jakarta'),
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_value' => intval($saldo),
                        'sm_note' => 'Penambahan Poin',
                        'sm_nota' => $nota,
                        'sm_reff' => $nota
                    ]);
            }
            DB::commit();
            return Response::json([
                'status' => 'sukses',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function getDataSetting($id)
    {
        $idFitur = $id;
        $data = DB::table('d_saldo_setting')
            ->where('ss_fitur', '=', $idFitur)
            ->first();
        return json_encode($data);
    }

    public function updateSetting(Request $request)
    {
        $fitur = $request->fitur;
        $poin = intval(str_replace(' Poin', '', $request->getpoin));
        $trans = str_replace('Rp. ', '', $request->mintrans);
        $trans = intval(str_replace('.', '', $trans));

        DB::beginTransaction();
        try {
            DB::table('d_saldo_setting')
                ->where('ss_fitur', '=', $fitur)
                ->update([
                    'ss_poin' => $poin,
                    'ss_mintransaction' => $trans
                ]);
            DB::commit();
            return Response::json([
                'status' => 'sukses',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json([
                'status' => 'gagal'
            ]);
        }
    }

    public static function addSaldoFromTransaction($member, $transaksi, $nota, $idFitur)
    {
        if ($idFitur == 16 || $idFitur == 17 || $idFitur == 19) {
            $data = DB::table('d_saldo_setting')
                ->where('ss_fitur', '=', $idFitur)
                ->first();

            if ($transaksi >= intval($data->ss_mintransaction)) {
                $kelipatan = $transaksi / $data->ss_mintransaction;
                $kelipatan = intval($kelipatan);
                $getPoin = $data->ss_poin * $kelipatan;
                $getSaldo = DB::table('d_saldo')
                    ->join('d_saldo_mutation', 'sm_saldo', '=', 's_id')
                    ->where('s_member', '=', $member)
                    ->select('s_id', 's_saldo', DB::raw('max(sm_detailid) as sm_detailid'))
                    ->groupBy('s_id')
                    ->get();

                if (count($getSaldo) > 0) {
                    DB::table('d_saldo')
                        ->where('s_member', '=', $member)
                        ->update([
                            's_saldo' => intval($getSaldo[0]->s_saldo) + $getPoin
                        ]);

                    DB::table('d_saldo_mutation')
                        ->insert([
                            'sm_saldo' => $getSaldo[0]->s_id,
                            'sm_detailid' => $getSaldo[0]->sm_detailid + 1,
                            'sm_date' => Carbon::now('Asia/Jakarta'),
                            'sm_detail' => 'PENAMBAHAN',
                            'sm_value' => $getPoin,
                            'sm_note' => 'Penambahan poin transaksi ' . $nota,
                            'sm_nota' => $nota,
                            'sm_reff' => $nota
                        ]);
                } else {
                    $idSaldo = DB::table('d_saldo')
                        ->max('s_id');
                    DB::table('d_saldo')
                        ->insert([
                            's_id' => $idSaldo + 1,
                            's_member' => $member,
                            's_saldo' => $getPoin,
                            's_insert' => Carbon::now('Asia/Jakarta'),
                            's_update' => Carbon::now('Asia/Jakarta')
                        ]);

                    DB::table('d_saldo_mutation')
                        ->insert([
                            'sm_saldo' => $idSaldo + 1,
                            'sm_detailid' => 1,
                            'sm_date' => Carbon::now('Asia/Jakarta'),
                            'sm_detail' => 'PENAMBAHAN',
                            'sm_value' => $getPoin,
                            'sm_note' => 'Penambahan poin transaksi ' . $nota,
                            'sm_nota' => $nota,
                            'sm_reff' => $nota
                        ]);
                }
            }
        }
    }
}
