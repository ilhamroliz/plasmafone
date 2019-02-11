<?php

namespace App\Http\Controllers\modul_keuangan\laporan\buku_besar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_akun as akun;

use DB;
use Excel;
use PDF;

class laporan_buku_besar_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.laporan.buku_besar.index');
    }

    public function dataResource(Request $request){

    	$tanggal2 = explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0].'-01';
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';
        $d2 = date('Y-m-d', strtotime('+1 months', strtotime($tanggal2)));

        $akun = akun::where('ak_isactive', '1')
                        ->select('ak_id as id', DB::raw('concat(ak_id, " - ", ak_nama) as text'))
                        ->orderBy('ak_id')->get();

        if(!isset($request->semua)){
            $data = akun::whereBetween('ak_id', [$request->akun1, $request->akun2])
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with('detail:jrdt_jurnal,jrdt_akun,jrdt_dk,jrdt_value');
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1')
                        ->select('ak_id', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                        ->get();
        }else{
            $data = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with('detail:jrdt_jurnal,jrdt_akun,jrdt_dk,jrdt_value');
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1')
                        ->select('ak_id', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                        ->get();
        }

    	// return json_encode($data);

    	return json_encode([
    		"data"	        => $data,
            "akun"          => $akun,
    		"requestLawan"  => $request->lawan,
            "requestSemua"  => ($request->semua) ? 'on' : 'off',
            "akun1"         => (!$request->semua) ? $request->akun1 : 'null',
            "akun2"         => (!$request->semua) ? $request->akun2 : 'null',
    	]);
    }

    public function print(Request $request){
        $tanggal2 = explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0].'-01';
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';
        $d2 = date('Y-m-d', strtotime('+1 months', strtotime($tanggal2)));

        if(!isset($request->semua)){
            $res = akun::whereBetween('ak_id', [$request->akun1, $request->akun2])
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with('detail:jrdt_jurnal,jrdt_akun,jrdt_dk,jrdt_value');
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1')
                        ->select('ak_id', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                        ->get();
        }else{
            $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with('detail:jrdt_jurnal,jrdt_akun,jrdt_dk,jrdt_value');
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1')
                        ->select('ak_id', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                        ->get();
        }

        // return json_encode($res[0]->jurnal_detail);

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
        ];

        return view('modul_keuangan.laporan.buku_besar.print.index', compact('data'));
    }

    public function pdf(Request $request){
        $tanggal2 = explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0].'-01';
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';
        $d2 = date('Y-m-d', strtotime('+1 months', strtotime($tanggal2)));

        if(!isset($request->semua)){
            $res = akun::whereBetween('ak_id', [$request->akun1, $request->akun2])
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with('detail:jrdt_jurnal,jrdt_akun,jrdt_dk,jrdt_value');
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1')
                        ->select('ak_id', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                        ->get();
        }else{
            $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with('detail:jrdt_jurnal,jrdt_akun,jrdt_dk,jrdt_value');
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1')
                        ->select('ak_id', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                        ->get();
        }

        // return json_encode($data);

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
        ];

        // return view('modul_keuangan.laporan.jurnal.print.pdf', compact('data'));

        $title = "Laporan_Buku_Besar_".$d1."__".$d2.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.buku_besar.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($title);
    }

    public function excel(Request $request){

        $tanggal2 = explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0].'-01';
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';
        $d2 = date('Y-m-d', strtotime('+1 months', strtotime($tanggal2)));

        if(!isset($request->semua)){
            $res = akun::whereBetween('ak_id', [$request->akun1, $request->akun2])
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with('detail:jrdt_jurnal,jrdt_akun,jrdt_dk,jrdt_value');
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1')
                        ->select('ak_id', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                        ->get();
        }else{
            $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with('detail:jrdt_jurnal,jrdt_akun,jrdt_dk,jrdt_value');
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1')
                        ->select('ak_id', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                        ->get();
        }

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
        ];

        // return json_encode($data);

        $title = "Laporan_Buku_Besar_".$d1."__".$d2.".xlsx";

        // return view('modul_keuangan.laporan.jurnal.print.excel', compact('data'));

        return Excel::download(new exporter('modul_keuangan.laporan.buku_besar.print.excel', $data), $title);
    }
}
