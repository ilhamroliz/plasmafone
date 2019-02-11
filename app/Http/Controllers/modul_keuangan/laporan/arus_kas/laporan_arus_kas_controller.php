<?php

namespace App\Http\Controllers\modul_keuangan\laporan\arus_kas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;
use App\Model\modul_keuangan\dk_hierarki_lvl_dua as level_2;

use DB;
use Excel;
use PDF;

class laporan_arus_kas_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.laporan.arus_kas.index');
    }

    public function dataResource(Request $request){
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        $kelompok_kas = DB::table('dk_hierarki_penting')->where('hp_id', '4')->first();
        $kelompok_bank = DB::table('dk_hierarki_penting')->where('hp_id', '5')->first();

        $saldoAwal = DB::table('dk_akun')
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('ak_kelompok', $kelompok_kas->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $d1)
                        ->orwhere('ak_kelompok', $kelompok_bank->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $d1)
                        ->select(DB::raw('sum(as_saldo_awal) as saldo_akhir'))
                        ->first();

        $data = level_2::whereNotNull("hld_cashflow")
        				->with([
        						'akun' => function($query) use ($d1){
        							$query->select('ak_id', 'ak_kelompok', 'ak_nama')
                                            ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->select(
                                                'ak_id',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(IF(ak_posisi = "D", (((as_mut_kas_debet + as_mut_bank_debet) - (as_mut_kas_kredit + as_mut_bank_kredit)) * -1), ((as_mut_kas_kredit + as_mut_bank_kredit) - (as_mut_kas_debet + as_mut_bank_debet))), 2) as saldo_akhir')

                                            );
        						}
        				])
        				->select('hld_id', 'hld_nama', 'hld_cashflow')
        				->get();

        // return json_encode($data);

    	return json_encode([
    		"data"    => $data,
    		"saldo_awal" => ($saldoAwal->saldo_akhir) ? $saldoAwal->saldo_akhir : 0
    	]);
    }

    public function print(Request $request){
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        $kelompok_kas = DB::table('dk_hierarki_penting')->where('hp_id', '4')->first();
        $kelompok_bank = DB::table('dk_hierarki_penting')->where('hp_id', '5')->first();

        $saldoAwal = DB::table('dk_akun')
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('ak_kelompok', $kelompok_kas->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $d1)
                        ->orwhere('ak_kelompok', $kelompok_bank->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $d1)
                        ->select(DB::raw('sum(as_saldo_awal) as saldo_akhir'))
                        ->first();

        $data = level_2::whereNotNull("hld_cashflow")
                        ->with([
                                'akun' => function($query) use ($d1){
                                    $query->select('ak_id', 'ak_kelompok', 'ak_nama')
                                            ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->select(
                                                'ak_id',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(IF(ak_posisi = "D", (((as_mut_kas_debet + as_mut_bank_debet) - (as_mut_kas_kredit + as_mut_bank_kredit)) * -1), ((as_mut_kas_kredit + as_mut_bank_kredit) - (as_mut_kas_debet + as_mut_bank_debet))), 2) as saldo_akhir')

                                            );
                                }
                        ])
                        ->select('hld_id', 'hld_nama', 'hld_cashflow')
                        ->get();

        // return json_encode($res);

        $data = [
            "data"    => $data,
            "saldo_awal" => ($saldoAwal->saldo_akhir) ? $saldoAwal->saldo_akhir : 0
        ];

        return view('modul_keuangan.laporan.arus_kas.print.index', compact('data'));
    }

    public function pdf(Request $request){
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        $kelompok_kas = DB::table('dk_hierarki_penting')->where('hp_id', '4')->first();
        $kelompok_bank = DB::table('dk_hierarki_penting')->where('hp_id', '5')->first();

        $saldoAwal = DB::table('dk_akun')
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('ak_kelompok', $kelompok_kas->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $d1)
                        ->orwhere('ak_kelompok', $kelompok_bank->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $d1)
                        ->select(DB::raw('sum(as_saldo_awal) as saldo_akhir'))
                        ->first();

        $data = level_2::whereNotNull("hld_cashflow")
                        ->with([
                                'akun' => function($query) use ($d1){
                                    $query->select('ak_id', 'ak_kelompok', 'ak_nama')
                                            ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->select(
                                                'ak_id',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(IF(ak_posisi = "D", (((as_mut_kas_debet + as_mut_bank_debet) - (as_mut_kas_kredit + as_mut_bank_kredit)) * -1), ((as_mut_kas_kredit + as_mut_bank_kredit) - (as_mut_kas_debet + as_mut_bank_debet))), 2) as saldo_akhir')

                                            );
                                }
                        ])
                        ->select('hld_id', 'hld_nama', 'hld_cashflow')
                        ->get();

        // return json_encode($res[0]->group[0]->akun[0]->fromKelompok);

        $data = [
            "data"    => $data,
            "saldo_awal" => ($saldoAwal->saldo_akhir) ? $saldoAwal->saldo_akhir : 0
        ];

        // return view('modul_keuangan.laporan.jurnal.print.pdf', compact('data'));

        $title = "Laporan_Arus_Kas_".$d1.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.arus_kas.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($title);
    }

    public function excel(Request $request){

        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        $kelompok_kas = DB::table('dk_hierarki_penting')->where('hp_id', '4')->first();
        $kelompok_bank = DB::table('dk_hierarki_penting')->where('hp_id', '5')->first();

        $saldoAwal = DB::table('dk_akun')
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('ak_kelompok', $kelompok_kas->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $d1)
                        ->orwhere('ak_kelompok', $kelompok_bank->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $d1)
                        ->select(DB::raw('sum(as_saldo_awal) as saldo_akhir'))
                        ->first();

        $data = level_2::whereNotNull("hld_cashflow")
                        ->with([
                                'akun' => function($query) use ($d1){
                                    $query->select('ak_id', 'ak_kelompok', 'ak_nama')
                                            ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->select(
                                                'ak_id',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(IF(ak_posisi = "D", (((as_mut_kas_debet + as_mut_bank_debet) - (as_mut_kas_kredit + as_mut_bank_kredit)) * -1), ((as_mut_kas_kredit + as_mut_bank_kredit) - (as_mut_kas_debet + as_mut_bank_debet))), 2) as saldo_akhir')

                                            );
                                }
                        ])
                        ->select('hld_id', 'hld_nama', 'hld_cashflow')
                        ->get();

        // return json_encode($res[0]->group[0]->akun[0]->fromKelompok);

        $data = [
            "data"    => $data,
            "saldo_awal" => ($saldoAwal->saldo_akhir) ? $saldoAwal->saldo_akhir : 0
        ];

        // return json_encode($data);

        $title = "Laporan_Arus_Kas_".$d1.".xlsx";

        // return view('modul_keuangan.laporan.arus_kas.print.excel', compact('data'));

        return Excel::download(new exporter('modul_keuangan.laporan.arus_kas.print.excel', $data), $title);
    }
}
