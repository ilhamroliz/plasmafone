<?php

namespace App\Http\Controllers\modul_keuangan\laporan\jurnal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_jurnal as jurnal;

use DB;
use Excel;
use PDF;

class laporan_jurnal_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.laporan.jurnal.index');
    }

    public function dataResource(Request $request){

    	$d1 = explode('/', $request->d1)[2]."-".explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
    	$d2 = explode('/', $request->d2)[2]."-".explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0];
    	$type = $request->type;
    	$nama = $request->nama;

    	$data = jurnal::where(DB::raw('SUBSTR(jr_type, 1, 1)'), $type)
    						->with([
    								'detail' => function($query){
    									$query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_value', 'jrdt_dk', 'ak_nama')
    											->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
    											->get();
    								}
    						])
    						->where('jr_tanggal_trans', ">=", $d1)
    						->where('jr_tanggal_trans', "<=", $d2)
    						->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
    						->orderBy('jr_tanggal_trans', 'asc')
    						->get();

        // return $data;

    	return json_encode([
    		"data"	=> $data,
    		"requestNama" => $request->nama
    	]);
    }

    public function excel(Request $request){

        $d1 = explode('/', $request->d1)[2]."-".explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
        $d2 = explode('/', $request->d2)[2]."-".explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0];
        $type = $request->type;
        $t = "Kas";

        if($type == 'B')
            $t = 'Bank';
        else if($type == 'M')
            $t = 'Memorial';

        $res = jurnal::where(DB::raw('SUBSTR(jr_type, 1, 1)'), $type)
                            ->with([
                                    'detail' => function($query){
                                        $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_value', 'jrdt_dk', 'ak_nama')
                                                ->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                ->get();
                                    }
                            ])
                            ->where('jr_tanggal_trans', ">=", $d1)
                            ->where('jr_tanggal_trans', "<=", $d2)
                            ->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                            ->orderBy('jr_tanggal_trans', 'asc')
                            ->get();

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
        ];

        // return json_encode($data);

        $title = "Laporan_Jurnal_".$t."_".$d1."__".$d2.".xlsx";

        // return view('modul_keuangan.laporan.jurnal.print.excel', compact('data'));

        return Excel::download(new exporter('modul_keuangan.laporan.jurnal.print.excel', $data), $title);
    }

    public function pdf(Request $request){
        $d1 = explode('/', $request->d1)[2]."-".explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
        $d2 = explode('/', $request->d2)[2]."-".explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0];
        $type = $request->type;
        $t = "Kas";

        if($type == 'B')
            $t = 'Bank';
        else if($type == 'M')
            $t = 'Memorial';

        $res = jurnal::where(DB::raw('SUBSTR(jr_type, 1, 1)'), $type)
                            ->with([
                                    'detail' => function($query){
                                        $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_value', 'jrdt_dk', 'ak_nama')
                                                ->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                ->get();
                                    }
                            ])
                            ->where('jr_tanggal_trans', ">=", $d1)
                            ->where('jr_tanggal_trans', "<=", $d2)
                            ->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                            ->orderBy('jr_tanggal_trans', 'asc')
                            ->get();

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
        ];

        // return view('modul_keuangan.laporan.jurnal.print.pdf', compact('data'));

        $title = "Laporan_Jurnal_".$t."_".$d1."__".$d2.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.jurnal.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($title);
    }

    public function print(Request $request){
        $d1 = explode('/', $request->d1)[2]."-".explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
        $d2 = explode('/', $request->d2)[2]."-".explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0];
        $type = $request->type;
        $t = "Kas";

        if($type == 'B')
            $t = 'Bank';
        else if($type == 'M')
            $t = 'Memorial';

        $res = jurnal::where(DB::raw('SUBSTR(jr_type, 1, 1)'), $type)
                            ->with([
                                    'detail' => function($query){
                                        $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_value', 'jrdt_dk', 'ak_nama')
                                                ->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                ->get();
                                    }
                            ])
                            ->where('jr_tanggal_trans', ">=", $d1)
                            ->where('jr_tanggal_trans', "<=", $d2)
                            ->select('jr_id', 'jr_ref', 'jr_tanggal_trans', 'jr_keterangan', 'jr_type')
                            ->orderBy('jr_tanggal_trans', 'asc')
                            ->get();

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
        ];

        return view('modul_keuangan.laporan.jurnal.print.index', compact('data'));
    }

    public function generateRandomString($length = 10) {

    	for ($i=0; $i < 1000; $i++) { 
    		array_push($data, ["id" => $this->generateRandomString(), "name" => 'Dirga Ambara - '.($i+1)]);
    	}

	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
