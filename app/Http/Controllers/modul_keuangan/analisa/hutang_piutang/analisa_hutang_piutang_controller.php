<?php

namespace App\Http\Controllers\modul_keuangan\analisa\hutang_piutang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;
use App\Model\modul_keuangan\dk_hierarki_lvl_dua as level_2;

use DB;
use PDF;

class analisa_hutang_piutang_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.analisa.hutang_piutang.index');
    }

    public function dataResource(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = [];

    	$kelompokAkun = level_2::where("hld_cashflow", "OCF")
    								->select('hld_id')
        							->get();
    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		$hutang = DB::table('dk_payable')
    					->where('py_tanggal', '>=', $tgl)
    					->where('py_tanggal', '<', date('Y-m-d', strtotime('+1 month', strtotime($tgl))))
    					->select(DB::raw('coalesce(sum(py_total_tagihan), 0) as total_tagihan'), DB::raw('coalesce(sum(py_sudah_dibayar), 0) as sudah_dibayar'))
    					->first();

    		$piutang = DB::table('dk_receivable')
    					->where('rc_tanggal', '>=', $tgl)
    					->where('rc_tanggal', '<', date('Y-m-d', strtotime('+1 month', strtotime($tgl))))
    					->select(DB::raw('coalesce(sum(rc_total_tagihan), 0) as total_tagihan'), DB::raw('coalesce(sum(rc_sudah_dibayar), 0) as sudah_dibayar'))
    					->first();

    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"hutang"		=> $hutang,
    				"piutang"		=> $piutang
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

    		$hutang = DB::table('dk_payable')
    					->where('py_tanggal', '>=', $tgl)
    					->where('py_tanggal', '<', date('Y-m-d', strtotime('+1 month', strtotime($tgl))))
    					->select(DB::raw('coalesce(sum(py_total_tagihan), 0) as total_tagihan'), DB::raw('coalesce(sum(py_sudah_dibayar), 0) as sudah_dibayar'))
    					->first();

    		$piutang = DB::table('dk_receivable')
    					->where('rc_tanggal', '>=', $tgl)
    					->where('rc_tanggal', '<', date('Y-m-d', strtotime('+1 month', strtotime($tgl))))
    					->select(DB::raw('coalesce(sum(rc_total_tagihan), 0) as total_tagihan'), DB::raw('coalesce(sum(rc_sudah_dibayar), 0) as sudah_dibayar'))
    					->first();

    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"hutang"		=> $hutang,
    				"piutang"		=> $piutang
    			]
    		);
    	}

    	$content = [
    		"data"	=> $data
    	];

    	// return json_encode($data);

    	return view('modul_keuangan.analisa.hutang_piutang.print.index', compact('content'));
    }

    public function pdf(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = [];

    	$kelompokAkun = level_2::where("hld_cashflow", "OCF")
    								->select('hld_id')
        							->get();
    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		$hutang = DB::table('dk_payable')
    					->where('py_tanggal', '>=', $tgl)
    					->where('py_tanggal', '<', date('Y-m-d', strtotime('+1 month', strtotime($tgl))))
    					->select(DB::raw('coalesce(sum(py_total_tagihan), 0) as total_tagihan'), DB::raw('coalesce(sum(py_sudah_dibayar), 0) as sudah_dibayar'))
    					->first();

    		$piutang = DB::table('dk_receivable')
    					->where('rc_tanggal', '>=', $tgl)
    					->where('rc_tanggal', '<', date('Y-m-d', strtotime('+1 month', strtotime($tgl))))
    					->select(DB::raw('coalesce(sum(rc_total_tagihan), 0) as total_tagihan'), DB::raw('coalesce(sum(rc_sudah_dibayar), 0) as sudah_dibayar'))
    					->first();

    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"hutang"		=> $hutang,
    				"piutang"		=> $piutang
    			]
    		);
    	}

    	$content = [
    		"data"	=> $data
    	];

        $title = "Analisa_Hutang_Piutang_".$_GET['d1'].".pdf";

        $pdf = PDF::loadView('modul_keuangan.analisa.hutang_piutang.print.pdf', compact('content'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($title);
    }
}
