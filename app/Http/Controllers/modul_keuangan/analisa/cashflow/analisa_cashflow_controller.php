<?php

namespace App\Http\Controllers\modul_keuangan\analisa\cashflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;
use App\Model\modul_keuangan\dk_hierarki_lvl_dua as level_2;

use DB;
use PDF;

class analisa_cashflow_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.analisa.cashflow.index');
    }

    public function dataResource(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = [];

        $kelompok_kas = DB::table('dk_hierarki_penting')->where('hp_id', '4')->first();
        $kelompok_bank = DB::table('dk_hierarki_penting')->where('hp_id', '5')->first();

    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));
            $ocfIn = $ocfOut = $icfIn = $icfOut = $fcfIn = $fcfOut = 0;

            $saldoAwal = DB::table('dk_akun')
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('ak_kelompok', $kelompok_kas->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $tgl)
                        ->orwhere('ak_kelompok', $kelompok_bank->hp_hierarki)
                        ->where('ak_isactive', '1')
                        ->where('as_periode', $tgl)
                        ->select(DB::raw('sum(as_saldo_awal) as saldo_akhir'))
                        ->first();

            $proper = level_2::distinct('hld_cashflow')->whereNotNull('hld_cashflow')
                    ->select('hld_cashflow')
                    ->with([
                            'detail' => function($query) use ($tgl){
                                $query->join('dk_akun', 'ak_kelompok', 'hld_id')
                                        ->join('dk_akun_saldo', 'as_akun', 'ak_id')
                                        ->where('as_periode', $tgl)
                                        ->select(
                                                    'hld_id', 
                                                    'hld_nama', 
                                                    'hld_cashflow',
                                                    'ak_posisi',
                                                    DB::raw('(as_mut_kas_debet + as_mut_bank_debet) as cashflow_debet'),
                                                    DB::raw('(as_mut_kas_kredit + as_mut_bank_kredit) as cashflow_kredit')
                                        );
                            }
                    ])
                    ->get();

            foreach($proper as $key => $cashflow){
                foreach ($cashflow->detail as $key => $detail) {

                    if($cashflow->hld_cashflow == "OCF"){

                        $ocfIn += $detail->cashflow_kredit;
                        $ocfOut += $detail->cashflow_debet;

                    }else if($cashflow->hld_cashflow == "ICF"){

                        $icfIn += $detail->cashflow_kredit;
                        $icfOut += $detail->cashflow_debet;

                    }else{

                        $fcfIn += $detail->cashflow_kredit;
                        $fcfOut += $detail->cashflow_debet;

                    }

                }
            }

    		array_push($data, 
    			[
    				"periode"       => $tgl,
                    "saldo_awal"    => ($saldoAwal->saldo_akhir) ? $saldoAwal->saldo_akhir / 1000 : 0,
                    "ocfIn"         => ($ocfIn) ? $ocfIn / 1000 : 0,
                    "ocfOut"        => ($ocfOut) ? $ocfOut / 1000 : 0,
                    "icfIn"         => ($icfIn) ? $icfIn / 1000 : 0,
                    "icfOut"        => ($icfOut) ? $icfOut / 1000 : 0,
                    "fcfIn"         => ($fcfIn) ? $fcfIn / 1000 : 0,
                    "fcfOut"        => ($fcfOut) ? $fcfOut / 1000 : 0
    			]
    		);
    	}

    	return json_encode([
    		"data"	=> $data
    	]);
    }
}
