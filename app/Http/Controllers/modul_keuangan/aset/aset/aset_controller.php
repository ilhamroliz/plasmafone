<?php

namespace App\Http\Controllers\modul_keuangan\aset\aset;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use keuangan;

class aset_controller extends Controller
{
    public function index(){
    	$data = DB::table('dk_aktiva')
                    ->join('dk_aktiva_golongan', 'dk_aktiva_golongan.ga_id', 'dk_aktiva.at_golongan')
                    ->select('at_nomor', 'at_nama', 'at_harga_beli', 'at_nilai_sisa', 'at_tanggal_habis', 'dk_aktiva_golongan.ga_nama', 'at_status')
    				->get();

    	// return json_encode($data);

    	return view('modul_keuangan.aset.aset.index', compact('data'));
    }

    public function create(){
    	return view('modul_keuangan.aset.aset.form');
    }

    public function form_resource(){
    	$gol = DB::table('dk_aktiva_golongan')
    				->leftJoin('dk_akun as harta', 'harta.ak_id', '=', 'dk_aktiva_golongan.ga_akun_harta')
    				->leftJoin('dk_akun as akumulasi', 'akumulasi.ak_id', '=', 'dk_aktiva_golongan.ga_akun_akumulasi')
    				->leftJoin('dk_akun as beban', 'beban.ak_id', '=', 'dk_aktiva_golongan.ga_akun_beban')
    				->select(
    							'ga_id as id', 
    							 DB::raw('concat(ga_nomor, " - ", ga_nama) as text'),
    							'ga_masa_manfaat',
    							'ga_saldo_menurun',
    							'ga_garis_lurus',
    							'ga_akun_harta',
    							'ga_akun_akumulasi',
    							'ga_akun_beban',
    							'harta.ak_nama as nama_akun_harta',
    							'akumulasi.ak_nama as nama_akun_akumulasi',
    							'beban.ak_nama as nama_akun_beban'
    						)
    				->get();

        $akunKas = DB::table('dk_akun')
                        ->where('ak_kelompok', jurnal()->kelompok_kas)
                        ->where('ak_isactive', '1')
                        ->orWhere('ak_kelompok', jurnal()->kelompok_bank)
                        ->where('ak_isactive', '1')
                        ->orWhere('ak_id', jurnal()->akun_hutang_usaha)
                        ->where('ak_isactive', '1')
                        ->select('ak_id as id', DB::raw("concat(ak_id, ' - ', ak_nama) as text"))
                        ->get();

    	return json_encode([
    		"golongan"	        => $gol,
            "akunKas"           => $akunKas,
    	]);
    }

    public function datatable(){
        $data = DB::table('dk_aktiva')->where('at_status', 'ST')->get();

        return json_encode($data);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	$golongan = DB::table('dk_aktiva_golongan')->where('ga_id', $request->at_golongan)->first();

    	if(!$golongan){
    		$response = [
                "status"    => 'error',
                "message"   => 'Golongan Aset Dipilih Tidak Bisa Ditemukan. Cobalah Memuat Ulang Halaman'
            ];

            return json_encode($response);
    	}

    	DB::beginTransaction();

        $cek = DB::table('dk_periode_keuangan')->where(DB::raw('YEAR(pk_periode)'), '2019')->get();

        // return json_encode($cek);

    	try {

            $tanggal = explode('/', $request->at_tanggal_beli)[2].'-'.explode('/', $request->at_tanggal_beli)[1].'-'.explode('/', $request->at_tanggal_beli)[0];

            $tanggalEnd = date('Y-m-d', strtotime('+'.(($golongan->ga_masa_manfaat * 12) - 1).' months', strtotime($tanggal)));

    		$detail = [];
    		$id = (DB::table('dk_aktiva')->max('at_id')) ? (DB::table('dk_aktiva')->max('at_id') + 1) : 1;
    		$nomor = 'ATK-'.date('Y/md').'/'.str_pad($id, 4, "0", STR_PAD_LEFT);

    		$at_harga_beli = ($request->at_harga_beli) ? str_replace(',', '', $request->at_harga_beli) : 0;
            $at_nilai_sisa = $at_harga_beli;

            if(jurnal()->allowJurnalToExecute){
                $tanggal_awal = $tanggal;
                $penyusutan = 0;
                $akun_beban = $golongan->ga_akun_beban;
                $akun_akumulasi = $golongan->ga_akun_akumulasi;
                $akun_harta = $golongan->ga_akun_harta;
                $jurnalDetail = $det = [];
                $i = $penyusutan = 0;
                $untilEnd = false;

                $akCek1 = DB::table('dk_akun')->where('ak_id', $akun_beban)->first();
                $akCek2 = DB::table('dk_akun')->where('ak_id', $akun_akumulasi)->first();
                // $akCek3 = DB::table('dk_akun')->where('ak_id', $akun_harta)->first();
                // $akCek4 = DB::table('dk_akun')->where('ak_id', $request->akun_keluaran)->first();

                $firstPeriode = DB::table('dk_periode_keuangan')->orderBy('pk_periode')->first();

                if(!$akCek1 || !$akCek2){
                    $response = [
                        "status"    => 'error',
                        "message"   => 'Beberapa Akun Yang Terkait Tidak Ditemukan, Data Tidak Bisa Disimpan.'
                    ];
                }

                if(!$firstPeriode){
                    $response = [
                        "status"    => 'error',
                        "message"   => 'Periode Keuangan Belum Dibuat. Data Aktiva Tidak Bisa Disimpan'
                    ];
                }
                
                while (strtotime($tanggal_awal) <= strtotime(date('Y-m-d'))){

                    foreach($request->ad_tahun as $key => $tahun){
                        if($tahun == date('Y', strtotime($tanggal_awal))){
                            $penyusutan += (double) str_replace(',', '', $request->ad_penyusutan[$key]) / (int) $request->ad_jumlah_bulan[$key];                            

                            if(strtotime($tanggal_awal) >= strtotime($firstPeriode->pk_periode)){
                                $det[$i] = [
                                    "tanggal"       => date('Y-m', strtotime($tanggal_awal)).'-01',
                                    "penyusutan"    => $penyusutan
                                ];

                                // Jurnal 

                                $jurnalDetail[$akun_beban] = [
                                    'jrdt_akun'          => $akun_beban,
                                    'jrdt_value'         => $penyusutan,
                                    'jrdt_dk'            => 'D'
                                ];

                                $jurnalDetail[$akun_akumulasi] = [
                                    'jrdt_akun'          => $akun_akumulasi,
                                    'jrdt_value'         => $penyusutan,
                                    'jrdt_dk'            => 'K'
                                ];

                                keuangan::jurnal()->addJurnal($jurnalDetail, $tanggal_awal, $nomor.'-(P)', "Penyusutan Aset ".$request->at_nama." (".$nomor.")", "MM", jurnal()->comp);

                                $untilEnd = (date('Y-m', strtotime($tanggal_awal)) == date('Y-m', strtotime($tanggalEnd))) ? true : false;
                                $at_nilai_sisa -= $penyusutan;
                                $penyusutan = 0;
                                $i++;
                            }

                            break;
                        }
                    }

                    $tanggal_awal = date ("Y-m-d", strtotime("+1 month", strtotime($tanggal_awal)));
                }

            }

            foreach($request->ad_tahun as $key => $tahun){
                $detail[$key] = [
                    "atdt_aktiva"           => $id,
                    "atdt_tahun"            => $tahun,
                    "atdt_jumlah_bulan"     => $request->ad_jumlah_bulan[$key],
                    "atdt_penyusutan"       => (double) str_replace(',', '', $request->ad_penyusutan[$key])
                ];
            }

            DB::table('dk_aktiva')->insert([
                "at_id"             => $id,
                "at_golongan"       => $request->at_golongan,
                "at_comp"           => '1',
                "at_nomor"          => $nomor,
                "at_nama"           => $request->at_nama,
                "at_metode"         => $request->at_metode,
                "at_harga_beli"     => $at_harga_beli,
                "at_tanggal_beli"   => $tanggal,
                "at_nilai_sisa"     => $at_nilai_sisa,
                "at_tanggal_habis"  => $tanggalEnd,
                "at_status"         => ($at_nilai_sisa <= 0) ? 'RL' : 'ST'
            ]);

            DB::table('dk_aktiva_detail')->insert($detail);

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Data Aktiva Berhasil Disimpan',
            ];

            return json_encode($response);

    	} catch (\Exception $e) {
    		DB::rollback();
            $response = [
                "status"    => 'error',
                "message"   => 'System Mengalami Masalah. Err: '.$e,
            ];

            return json_encode($response);
    	}
    }

    public function update(Request $request){
        // return json_encode($request->all();)

        $aktiva = DB::table('dk_aktiva')->where('at_id', $request->at_id);

        if(!$aktiva->first()){
            $response = [
                "status"    => 'error',
                "message"   => 'Aset Dipilih Tidak Bisa Ditemukan. Cobalah Memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        DB::beginTransaction();

        try {
            
            $aktiva->update([
                "at_status" => 'SL'
            ]);

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Data Aktiva Berhasil Ditandai Sebagai Aset Terjual',
            ];

            return json_encode($response);

        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                "status"    => 'error',
                "message"   => 'System Mengalami Masalah. Err: '.$e,
            ];

            return json_encode($response);
        }
    }

    public function delete(Request $request){
        // return json_encode($request->all());

        $aktiva = DB::table('dk_aktiva')->where('at_id', $request->at_id);

        if(!$aktiva->first()){
            $response = [
                "status"    => 'error',
                "message"   => 'Aset Dipilih Tidak Bisa Ditemukan. Cobalah Memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        DB::beginTransaction();

        try {
            
            $ref = $aktiva->first()->at_nomor;

            $jurnal = DB::table('dk_jurnal')->where('jr_ref', 'like', $ref.'%')->get();

            foreach ($jurnal as $key => $dataJurnal) {
                keuangan::jurnal()->dropJurnal($dataJurnal->jr_id);
            }

            $aktiva->delete();

            DB::commit();

            $response = [
                "status"    => 'berhasil',
                "message"   => 'Data Aktiva Berhasil Disimpan',
            ];

            return json_encode($response);

        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                "status"    => 'error',
                "message"   => 'System Mengalami Masalah. Err: '.$e,
            ];

            return json_encode($response);
        }
    }

}
