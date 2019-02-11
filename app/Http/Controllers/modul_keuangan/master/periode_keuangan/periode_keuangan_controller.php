<?php

namespace App\Http\Controllers\modul_keuangan\master\periode_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Swamsid\Keuangan\Facades\keuangan as keuangan;
use DB;
use Session;

class periode_keuangan_controller extends Controller
{
    public function save(Request $request){
    	// return json_encode($request->all());

    	DB::beginTransaction();

    	try {
    		
    		$bucket = []; $saldo = [];
    		$periode = strtotime($request->tahun.'-'.$request->bulan.'-01');
    		$dateNow = strtotime(date('Y-m').'-01');

    		$cek = DB::table('dk_periode_keuangan')->where('pk_periode', $periode)->first();

	    	if($cek){
	    		Session::flash('message', 'Periode Keuangan Sudah Dibuat Sebelumnya.');
	    		return redirect()->back();
	    	}

	    	$id = (DB::table('dk_periode_keuangan')->max('pk_id')) ? (DB::table('dk_periode_keuangan')->max('pk_id') + 1) : 1;

            if(DB::table('dk_periode_keuangan')->first()){
                $dateNow = $periode;
                $periode = strtotime('+1 months', strtotime(DB::table('dk_periode_keuangan')->max('pk_periode')));

                DB::table('dk_periode_keuangan')->update([
                    'pk_status' => '0'
                ]);
            }

    		while($periode <= $dateNow){

    			array_push($bucket, [
    				"pk_id"			=> $id,
		    		"pk_periode"	=> date('Y-m-d', $periode),
		    		"pk_status"		=> ($periode == $dateNow) ? '1' : '0'
    			]);

                keuangan::akunSaldo()->addNewPeriode(date('Y-m-d', $periode));

                $aktiva = DB::table('dk_aktiva')
                                ->join('dk_aktiva_golongan', 'dk_aktiva_golongan.ga_id', 'dk_aktiva.at_id')
                                ->join('dk_aktiva_detail', 'dk_aktiva_detail.atdt_aktiva', 'dk_aktiva.at_id')
                                ->where('atdt_tahun', date('Y', $periode))
                                ->where('at_status', 'ST')
                                ->where('at_nilai_sisa', '!=', 0)
                                ->select('at_id', 'at_harga_beli', 'at_nilai_sisa', 'ga_akun_beban', 'ga_akun_akumulasi', 'atdt_penyusutan', 'atdt_jumlah_bulan', 'at_nomor', 'at_nama')
                                ->get();

                foreach ($aktiva as $key => $value) {
                    
                    $penyusutan = ($value->at_nilai_sisa - ($value->atdt_penyusutan/$value->atdt_jumlah_bulan));

                    // Jurnal 

                        $jurnalDetail[$value->ga_akun_beban] = [
                            'jrdt_akun'          => $value->ga_akun_beban,
                            'jrdt_value'         => ($value->atdt_penyusutan/$value->atdt_jumlah_bulan),
                            'jrdt_dk'            => 'D'
                        ];

                        $jurnalDetail[$value->ga_akun_akumulasi] = [
                            'jrdt_akun'          => $value->ga_akun_akumulasi,
                            'jrdt_value'         => ($value->atdt_penyusutan/$value->atdt_jumlah_bulan),
                            'jrdt_dk'            => 'K'
                        ];

                    keuangan::jurnal()->addJurnal($jurnalDetail, date('Y-m-d', $periode), $value->at_nomor.'-(P)', "Penyusutan Aset ".$value->at_nama." (".$value->at_nomor.")", "MM", jurnal()->comp);

                    if($penyusutan <= 0){
                        DB::table('dk_aktiva')->where('at_id', $value->at_id)->update([
                            "at_nilai_sisa" => 0,
                            "at_status"     => 'RL'
                        ]);
                    }else{
                         DB::table('dk_aktiva')->where('at_id', $value->at_id)->update([
                            "at_nilai_sisa" => DB::raw("at_nilai_sisa - ".$penyusutan),
                        ]);
                    }

                }

    			$periode = strtotime("+1 month", $periode);
    			$id++;

    		}

	    	DB::table('dk_periode_keuangan')->insert($bucket);

    		DB::commit();

    		Session::flash('message', 'Periode Keuangan Berhasil Dibuat.');
	    	return redirect()->back();

    	} catch (Exception $e) {

    		Session::flash('message', 'Ada Kesalahan :message >> '.$e);

	        DB::rollback();
	        return redirect()->back();
    	}

    }
}
