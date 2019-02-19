<?php

namespace App\Http\Controllers\modul_keuangan\analisa\rasio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use PDO;

class analisa_rasio_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.analisa.rasio.index');
    }

    public function dataResource(Request $request){
    	// return json_encode($request->all());
    	$d1 = explode('/', $request->d1)[0].'-01-01';
        $data = [];
        $response['likuiditas'] = [];
        $response['profitabilitas'] = [];
        $response['solvabilitas'] = [];

    	for ($i=0; $i < 12; $i++) {
    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));
            
            if(DB::table('dk_periode_keuangan')->where('pk_periode', $tgl)->first()){
                $onPeriode = 'true';
            }else{
                $onPeriode = 'false';
            }

            array_push($response['likuiditas'], [
                "periode"       => $tgl,
                "onPeriode"     => $onPeriode,
                "quickRasio"    => $this->dataRasioLikuiditas($tgl)['quickRasio'],
                "currentRasio"  => $this->dataRasioLikuiditas($tgl)['currentRasio']
            ]);
    	}

        $data[0] = $response;

        return json_encode([
            "data"  => $data
        ]);

    }

    public function dataRasioLikuiditas($periode){
        
        $hutangLancar = $aktiva = $persediaan = 0;

        $idHutangLancar = DB::table('dk_hierarki_lvl_dua')->where('hld_subclass', '15')->select('hld_id')->get()->toArray();
        $idPersediaan   = DB::table('dk_hierarki_penting')->where('hp_id', '6')->select('hp_hierarki')->first();

        // if(array_search('2.001', array_column($idHutangLancar, 'hld_id')) === false)
        //     return 'Tidak Ada';
        // else
        //     return 'ada';

        $data = DB::table('dk_akun')
                    ->whereIn(DB::raw('substring(ak_id, 1, 1)'), ['1', '2'])
                    ->select(
                            'dk_akun.ak_id',
                            'dk_akun.ak_posisi',
                            'dk_akun.ak_nama',
                            'dk_akun.ak_kelompok'
                    )
                    ->get();

        // return $data;

        foreach ($data as $key => $neraca) {
            
            $saldo_akhir = DB::table('dk_akun_saldo')
                                ->where('as_akun', $neraca->ak_id)
                                ->where('as_periode', $periode)
                                ->select(DB::raw('coalesce(as_saldo_akhir, 0) as saldo_akhir'))->first();

            if(!$saldo_akhir)
                $saldo_akhir = 0;
            else
                $saldo_akhir = $saldo_akhir->saldo_akhir;

            if(explode('.', $neraca->ak_id)[0] == '1'){
                if($neraca->ak_posisi == "D")
                    $aktiva += $saldo_akhir;
                else
                    $aktiva += ($saldo_akhir * -1);
            }

            if(array_search($neraca->ak_kelompok, array_column($idHutangLancar, 'hld_id')) !== false){
                if($neraca->ak_posisi == "K")
                    $hutangLancar += $saldo_akhir;
                else
                    $hutangLancar += ($saldo_akhir * -1);
            }

            if($neraca->ak_kelompok == $idPersediaan->hp_hierarki){
                if($neraca->ak_posisi == "D")
                    $persediaan += $saldo_akhir;
                else
                    $persediaan += ($saldo_akhir * -1);
            }

        }

        $aktiva = abs($aktiva);
        $persediaan = abs($persediaan);
        $hutangLancar = abs($hutangLancar);

        return [
            "quickRasio"    => ($hutangLancar > 0) ? number_format((($aktiva - $persediaan) / $hutangLancar), 2) : 0,
            "currentRasio"  => ($hutangLancar > 0) ? number_format($aktiva / $hutangLancar, 2) : 0
        ];

    }
}
