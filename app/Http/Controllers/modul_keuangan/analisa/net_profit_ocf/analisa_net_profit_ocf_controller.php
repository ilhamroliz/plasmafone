<?php

namespace App\Http\Controllers\modul_keuangan\analisa\net_profit_ocf;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;
use App\Model\modul_keuangan\dk_hierarki_lvl_dua as level_2;

use DB;
use PDF;

class analisa_net_profit_ocf_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.analisa.net_profit_ocf.index');
    }

    public function dataResource(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = [];

    	$kelompokAkun = level_2::where("hld_cashflow", "OCF")
    								->select('hld_id')
        							->get();

    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		$profit = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->where(DB::raw('substring(ak_id, 1, 1)'), '4')
    					->where('ak_isactive', '1')
    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '8')
    					->where('ak_isactive', '1')
    					->where('as_periode', $tgl)
    					->select(
                            DB::raw('coalesce(sum(as_saldo_akhir - as_saldo_awal), 0) as saldo_akhir')
                        )->first();

	        $beban = DB::table('dk_akun')
	    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
	                        ->where('as_periode', $tgl)
	    					->where(DB::raw('substring(ak_id, 1, 1)'), '5')
	    					->where('ak_isactive', '1')
	    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '6')
	    					->where('ak_isactive', '1')
	    					->where('as_periode', $tgl)
	    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '7')
	    					->where('ak_isactive', '1')
	    					->where('as_periode', $tgl)
	    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '9')
	    					->where('ak_isactive', '1')
	    					->where('as_periode', $tgl)
	    					->select(
	                            DB::raw('coalesce(sum(as_saldo_akhir - as_saldo_awal), 0) as saldo_akhir')
	                        )->first();

	        $ocf = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->whereIn('ak_kelompok', function($query) {
    						$query->select('hld_id')->from('dk_hierarki_lvl_dua')->where('hld_cashflow', 'OCF')->get();
    					})
    					->select(
                            DB::raw('coalesce(sum(IF(ak_posisi = "D", (((as_mut_kas_debet + as_mut_bank_debet) - (as_mut_kas_kredit + as_mut_bank_kredit)) * -1), ((as_mut_kas_kredit + as_mut_bank_kredit) - (as_mut_kas_debet + as_mut_bank_debet)))), 0) as saldo_akhir')
                        )->first();

    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"net_profit"	=> ($profit->saldo_akhir - $beban->saldo_akhir),
    				"ocf"			=> $ocf->saldo_akhir
    			]
    		);
    	}

    	return json_encode([
    		"data"	=> $data
    	]);
    }

    public function print(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = [];

    	$kelompokAkun = level_2::where("hld_cashflow", "OCF")
    								->select('hld_id')
        							->get();

    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		$profit = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->where(DB::raw('substring(ak_id, 1, 1)'), '4')
    					->where('ak_isactive', '1')
    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '8')
    					->where('ak_isactive', '1')
    					->where('as_periode', $tgl)
    					->select(
                            DB::raw('coalesce(sum(as_saldo_akhir - as_saldo_awal), 0) as saldo_akhir')
                        )->first();

	        $beban = DB::table('dk_akun')
	    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
	                        ->where('as_periode', $tgl)
	    					->where(DB::raw('substring(ak_id, 1, 1)'), '5')
	    					->where('ak_isactive', '1')
	    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '6')
	    					->where('ak_isactive', '1')
	    					->where('as_periode', $tgl)
	    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '7')
	    					->where('ak_isactive', '1')
	    					->where('as_periode', $tgl)
	    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '9')
	    					->where('ak_isactive', '1')
	    					->where('as_periode', $tgl)
	    					->select(
	                            DB::raw('coalesce(sum(as_saldo_akhir - as_saldo_awal), 0) as saldo_akhir')
	                        )->first();

	        $ocf = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->whereIn('ak_kelompok', function($query) {
    						$query->select('hld_id')->from('dk_hierarki_lvl_dua')->where('hld_cashflow', 'OCF')->get();
    					})
    					->select(
                            DB::raw('coalesce(sum(IF(ak_posisi = "D", (((as_mut_kas_debet + as_mut_bank_debet) - (as_mut_kas_kredit + as_mut_bank_kredit)) * -1), ((as_mut_kas_kredit + as_mut_bank_kredit) - (as_mut_kas_debet + as_mut_bank_debet)))), 0) as saldo_akhir')
                        )->first();

    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"net_profit"	=> ($profit->saldo_akhir - $beban->saldo_akhir),
    				"ocf"			=> $ocf->saldo_akhir
    			]
    		);
    	}

    	$content = [
    		"data"	=> $data
    	];

    	// return json_encode($data);

    	return view('modul_keuangan.analisa.net_profit_ocf.print.index', compact('content'));
    }

    public function pdf(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = [];

    	$kelompokAkun = level_2::where("hld_cashflow", "OCF")
    								->select('hld_id')
        							->get();

    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		$profit = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->where(DB::raw('substring(ak_id, 1, 1)'), '4')
    					->where('ak_isactive', '1')
    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '8')
    					->where('ak_isactive', '1')
    					->where('as_periode', $tgl)
    					->select(
                            DB::raw('coalesce(sum(as_saldo_akhir - as_saldo_awal), 0) as saldo_akhir')
                        )->first();

	        $beban = DB::table('dk_akun')
	    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
	                        ->where('as_periode', $tgl)
	    					->where(DB::raw('substring(ak_id, 1, 1)'), '5')
	    					->where('ak_isactive', '1')
	    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '6')
	    					->where('ak_isactive', '1')
	    					->where('as_periode', $tgl)
	    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '7')
	    					->where('ak_isactive', '1')
	    					->where('as_periode', $tgl)
	    					->orWhere(DB::raw('substring(ak_id, 1, 1)'), '9')
	    					->where('ak_isactive', '1')
	    					->where('as_periode', $tgl)
	    					->select(
	                            DB::raw('coalesce(sum(as_saldo_akhir - as_saldo_awal), 0) as saldo_akhir')
	                        )->first();

	        $ocf = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->whereIn('ak_kelompok', function($query) {
    						$query->select('hld_id')->from('dk_hierarki_lvl_dua')->where('hld_cashflow', 'OCF')->get();
    					})
    					->select(
                            DB::raw('coalesce(sum(IF(ak_posisi = "D", (((as_mut_kas_debet + as_mut_bank_debet) - (as_mut_kas_kredit + as_mut_bank_kredit)) * -1), ((as_mut_kas_kredit + as_mut_bank_kredit) - (as_mut_kas_debet + as_mut_bank_debet)))), 0) as saldo_akhir')
                        )->first();

    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"net_profit"	=> ($profit->saldo_akhir - $beban->saldo_akhir),
    				"ocf"			=> $ocf->saldo_akhir
    			]
    		);
    	}

    	$content = [
    		"data"	=> $data
    	];

        $title = "Analisa_Net_Profit_OCF_".$_GET['d1'].".pdf";

        $pdf = PDF::loadView('modul_keuangan.analisa.net_profit_ocf.print.pdf', compact('content'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($title);
    }
}
