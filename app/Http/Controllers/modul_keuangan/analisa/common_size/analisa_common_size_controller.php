<?php

namespace App\Http\Controllers\modul_keuangan\analisa\common_size;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;
use App\Model\modul_keuangan\dk_hierarki_lvl_dua as level_2;
use App\Model\modul_keuangan\dk_hierarki_lvl_satu as level_1;

use DB;
use PDF;

class analisa_common_size_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.analisa.common_size.index');
    }

    public function dataResource(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$response = []; $akun = []; $stropper = []; $tot = [];

    	if($request->type == 'neraca'){

    		$level_1 = DB::table('dk_hierarki_lvl_satu')->whereIn('hls_id', ['1', '2', '3'])->select('hls_id', 'hls_nama')->get();

    		$data = DB::table('dk_akun')
    				->whereIn(DB::raw('substring(ak_id, 1, 1)'), ['1', '2', '3'])
    				->select(
    						'dk_akun.ak_id',
    						'dk_akun.ak_posisi',
    						'dk_akun.ak_nama'
    				)
    				->get();

	    	for ($i=0; $i < 12; $i++) {
	    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));
	    		$totAktiva = $totPasiva = 0;
	    		
	    		foreach ($data as $key => $akun) {

	    			$saldo_akhir = DB::table('dk_akun_saldo')
											->where('as_akun', $akun->ak_id)
											->where('as_periode', $tgl)
											->select(DB::raw('coalesce(as_saldo_akhir, 0) as saldo_akhir'))->first();

					if(!$saldo_akhir)
						$saldo_akhir = 0;
					else
						$saldo_akhir = $saldo_akhir->saldo_akhir;

					switch(explode('.', $akun->ak_id)[0]){
						case '1' :
							if($akun->ak_posisi == "D")
								$totAktiva += $saldo_akhir;
							else
								$totAktiva += ($saldo_akhir * -1);
							break;

						default :
							if($akun->ak_posisi == "K")
								$totPasiva += $saldo_akhir;
							else
								$totPasiva += ($saldo_akhir * -1);
							break;
					}


	    			$stropper[$akun->ak_id][$i] = [
	    				"nama" 			=> $akun->ak_nama,
	    				"periode"		=> $tgl,
	    				"saldo_akhir"	=> $saldo_akhir,
	    			];
	    		}

	    		$tot[$i] = [
	    			"aktiva"	=> $totAktiva,
	    			"pasiva" 	=> $totPasiva
	    		];
	    	}

    	}elseif($request->type == 'laba_rugi'){

    		$level_1 = DB::table('dk_hierarki_lvl_satu')->whereIn('hls_id', ['4', '5', '6', '7', '8', '9'])->select('hls_id', 'hls_nama')->get();

    		$data = DB::table('dk_akun')
    				->whereIn(DB::raw('substring(ak_id, 1, 1)'), ['4', '5', '6', '7', '8', '9'])
    				->select(
    						'dk_akun.ak_id',
    						'dk_akun.ak_posisi',
    						'dk_akun.ak_nama'
    				)
    				->get();

	    	for ($i=0; $i < 12; $i++) {
	    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));
	    		$totAktiva = $totPasiva = 0;
	    		
	    		foreach ($data as $key => $akun) {

	    			$saldo_akhir = DB::table('dk_akun_saldo')
											->where('as_akun', $akun->ak_id)
											->where('as_periode', $tgl)
											->select(DB::raw('coalesce(as_saldo_akhir, 0) as saldo_akhir'))->first();

					if(!$saldo_akhir)
						$saldo_akhir = 0;
					else
						$saldo_akhir = $saldo_akhir->saldo_akhir;

					switch(explode('.', $akun->ak_id)[0]){
						case '1' :
							if($akun->ak_posisi == "D")
								$totAktiva += $saldo_akhir;
							else
								$totAktiva += ($saldo_akhir * -1);
							break;

						default :
							if($akun->ak_posisi == "K")
								$totPasiva += $saldo_akhir;
							else
								$totPasiva += ($saldo_akhir * -1);
							break;
					}


	    			$stropper[$akun->ak_id][$i] = [
	    				"nama" 			=> $akun->ak_nama,
	    				"periode"		=> $tgl,
	    				"saldo_akhir"	=> $saldo_akhir,
	    			];
	    		}

	    		$tot[$i] = [
	    			"aktiva"	=> $totAktiva,
	    			"pasiva" 	=> $totPasiva
	    		];
	    	}
    	}

    	$response[0] = [
    		"detail"	=> $stropper,
    		"total"		=> $tot,
    		"level_1" 	=> $level_1
    	];

    	// return json_encode($tot);

    	return json_encode([
    		"data"	=> $response,
    	]);
    }
}
