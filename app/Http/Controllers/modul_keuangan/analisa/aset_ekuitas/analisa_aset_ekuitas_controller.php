<?php

namespace App\Http\Controllers\modul_keuangan\analisa\aset_ekuitas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;
use App\Model\modul_keuangan\dk_hierarki_lvl_dua as level_2;

use DB;
use PDF;

class analisa_aset_ekuitas_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.analisa.aset_ekuitas.index');
    }

    public function dataResource(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = [];

    	$kelompokHarta = DB::table('dk_hierarki_penting')->where('hp_id', '1')->first();

    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		$aset = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->where('ak_kelompok', $kelompokHarta->hp_hierarki)
    					->where('ak_isactive', '1')
    					->select(
                            DB::raw('coalesce(sum(as_saldo_awal), 0) as saldo_awal'),
                            DB::raw('coalesce(sum(as_mut_kas_debet + as_mut_bank_debet + as_mut_memorial_debet), 0) as penambahan'),
                            DB::raw('coalesce(sum(as_mut_kas_kredit + as_mut_bank_kredit + as_mut_memorial_kredit), 0) as pengurangan')
                        )->first();

            $ekuitas = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->where(DB::raw('substring(ak_id, 1, 1)'), '3')
    					->where('ak_isactive', '1')
    					->select(
                            DB::raw('coalesce(sum(as_saldo_awal), 0) as saldo_awal'),
                            DB::raw('coalesce(sum(as_mut_kas_kredit + as_mut_bank_kredit + as_mut_memorial_kredit), 0) as penambahan'),
                            DB::raw('coalesce(sum(as_mut_kas_debet + as_mut_bank_debet + as_mut_memorial_debet), 0) as pengurangan')
                        )->first();

    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"aset"			=> $aset,
    				"ekuitas"		=> $ekuitas
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

    	$kelompokHarta = DB::table('dk_hierarki_penting')->where('hp_id', '1')->first();

    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		$aset = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->where('ak_kelompok', $kelompokHarta->hp_hierarki)
    					->where('ak_isactive', '1')
    					->select(
                            DB::raw('coalesce(sum(as_saldo_awal), 0) as saldo_awal'),
                            DB::raw('coalesce(sum(as_mut_kas_debet + as_mut_bank_debet + as_mut_memorial_debet), 0) as penambahan'),
                            DB::raw('coalesce(sum(as_mut_kas_kredit + as_mut_bank_kredit + as_mut_memorial_kredit), 0) as pengurangan')
                        )->first();

            $ekuitas = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->where(DB::raw('substring(ak_id, 1, 1)'), '3')
    					->where('ak_isactive', '1')
    					->select(
                            DB::raw('coalesce(sum(as_saldo_awal), 0) as saldo_awal'),
                            DB::raw('coalesce(sum(as_mut_kas_kredit + as_mut_bank_kredit + as_mut_memorial_kredit), 0) as penambahan'),
                            DB::raw('coalesce(sum(as_mut_kas_debet + as_mut_bank_debet + as_mut_memorial_debet), 0) as pengurangan')
                        )->first();

    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"aset"			=> $aset,
    				"ekuitas"		=> $ekuitas
    			]
    		);
    	}

    	$content = [
    		"data"	=> $data
    	];

    	// return json_encode($data);

    	return view('modul_keuangan.analisa.aset_ekuitas.print.index', compact('content'));
    }

    public function pdf(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = [];

    	$kelompokHarta = DB::table('dk_hierarki_penting')->where('hp_id', '1')->first();

    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		$aset = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->where('ak_kelompok', $kelompokHarta->hp_hierarki)
    					->where('ak_isactive', '1')
    					->select(
                            DB::raw('coalesce(sum(as_saldo_awal), 0) as saldo_awal'),
                            DB::raw('coalesce(sum(as_mut_kas_debet + as_mut_bank_debet + as_mut_memorial_debet), 0) as penambahan'),
                            DB::raw('coalesce(sum(as_mut_kas_kredit + as_mut_bank_kredit + as_mut_memorial_kredit), 0) as pengurangan')
                        )->first();

            $ekuitas = DB::table('dk_akun')
    					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                        ->where('as_periode', $tgl)
    					->where(DB::raw('substring(ak_id, 1, 1)'), '3')
    					->where('ak_isactive', '1')
    					->select(
                            DB::raw('coalesce(sum(as_saldo_awal), 0) as saldo_awal'),
                            DB::raw('coalesce(sum(as_mut_kas_kredit + as_mut_bank_kredit + as_mut_memorial_kredit), 0) as penambahan'),
                            DB::raw('coalesce(sum(as_mut_kas_debet + as_mut_bank_debet + as_mut_memorial_debet), 0) as pengurangan')
                        )->first();

    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"aset"			=> $aset,
    				"ekuitas"		=> $ekuitas
    			]
    		);
    	}

    	$content = [
    		"data"	=> $data
    	];

        $title = "Analisa_Aset_Terhadap_Ekuitas_".$_GET['d1'].".pdf";

        $pdf = PDF::loadView('modul_keuangan.analisa.aset_ekuitas.print.pdf', compact('content'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($title);
    }
}
