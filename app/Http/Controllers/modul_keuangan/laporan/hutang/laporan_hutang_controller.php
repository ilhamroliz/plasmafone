<?php

namespace App\Http\Controllers\modul_keuangan\laporan\hutang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_payable as payable;

use DB;
use Excel;
use PDF;

class laporan_hutang_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.laporan.hutang.index');
    }

    public function dataResource(Request $request){
    	// return json_encode($request->all());

    	$d1 = explode('/', $request->d1)[2].'-'.explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
    	$data = [];

        $krediturSupplier = DB::table('sup_supplier')->select('id_supplier as id', 'nama_supplier as text')->get();
        $krediturKaryawan = [];

    	if($request->type == "Hutang_Supplier"){
               if($request->jenis == "rekap"){
                    // Laporan Type Rekap
                    
                        // Sesuaikan Nama Table Supplier Dari Sini Bosss.

                        $sampler = payable::where('py_chanel', 'Hutang_Supplier')
                                    ->join('sup_supplier', 'dk_payable.py_kreditur', '=', 'sup_supplier.id_supplier')
                                    ->distinct('py_kreditur')
                                    ->with([
                                            'detailBySupplier' => function($query){
                                                $query->where(DB::raw('(py_total_tagihan - py_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'py_kreditur',
                                                            'py_due_date',
                                                             DB::raw('(py_total_tagihan - py_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('py_kreditur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'py_kreditur',
                                                    'sup_supplier.nama_supplier',
                                                    DB::raw('sum(py_total_tagihan - py_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('py_kreditur', 'sup_supplier.nama_supplier')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $not = $first = $second = $third = $fourth = 0;

                            foreach($hutang->detailBySupplier as $idx => $detail){
                                $cek = date_diff(date_create($detail->py_due_date), date_create($d1));
                                $flag = $cek->format("%R");
                                $num = $cek->format("%a");

                                if($flag == '+'){

                                    if($num > 90)
                                        $fourth += $detail->total_tagihan;
                                    else if($num > 60)
                                        $third += $detail->total_tagihan;
                                    else if($num > 30)
                                        $second += $detail->total_tagihan;
                                    else
                                        $first += $detail->total_tagihan;

                                }else{
                                    $not += $detail->total_tagihan; 
                                }

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_supplier,
                                "total_hutang"           => $hutang->total_hutang,
                                "belum_jatuh_tempo"      => $not,
                                "first"                  => $first,
                                "second"                 => $second,
                                "third"                  => $third,
                                "fourth"                 => $fourth
                            ];
                        }

                        // Pastikan Sesuai
               }else{
                    // Laporan Type Detail
                        // Sesuaikan Nama Table Supplier Dari Sini Bosss.

                        $sampler = payable::where('py_chanel', 'Hutang_Supplier')
                                    ->join('sup_supplier', 'dk_payable.py_kreditur', '=', 'sup_supplier.id_supplier')
                                    ->distinct('py_kreditur')
                                    ->with([
                                            'detailBySupplier' => function($query){
                                                $query->where(DB::raw('(py_total_tagihan - py_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'py_kreditur',
                                                            'py_due_date',
                                                            'py_ref_nomor',
                                                            'py_tanggal',
                                                             DB::raw('(py_total_tagihan - py_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('py_kreditur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'py_kreditur',
                                                    'sup_supplier.nama_supplier',
                                                    DB::raw('sum(py_total_tagihan - py_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('py_kreditur', 'sup_supplier.nama_supplier')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $detailNota = [];

                            foreach($hutang->detailBySupplier as $idx => $detail){
                                $cek = date_diff(date_create($detail->py_due_date), date_create($d1));
                                $flag = $cek->format("%R");
                                $num = $cek->format("%a");
                                $not = $first = $second = $third = $fourth = 0; 

                                if($flag == '+'){

                                    if($num > 90)
                                        $fourth = $detail->total_tagihan;
                                    else if($num > 60)
                                        $third = $detail->total_tagihan;
                                    else if($num > 30)
                                        $second = $detail->total_tagihan;
                                    else
                                        $first = $detail->total_tagihan;

                                }else{
                                    $not = $detail->total_tagihan; 
                                }

                                array_push($detailNota, [
                                    "tanggal"                => $detail->py_tanggal,
                                    "jatuh_tempo"            => $detail->py_due_date,
                                    "nomor_referensi"        => $detail->py_ref_nomor,
                                    "belum_jatuh_tempo"      => $not,
                                    "first"                  => $first,
                                    "second"                 => $second,
                                    "third"                  => $third,
                                    "fourth"                 => $fourth
                                ]);

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_supplier,
                                "total_hutang"           => $hutang->total_hutang,
                                "id"                     => $hutang->py_kreditur,
                                "detail"                 => $detailNota,
                            ];
                        }

                        // Pastikan Sesuai
               }


    	}else{
    		return "hutang karyawan";
    	}

        return json_encode([
            "data"      => $data,
            "supplier"  => $krediturSupplier,
            "karyawan"  => $krediturKaryawan,
            "requestSemua"  => ($request->semua) ? 'on' : 'off',
            "kreditur"      => (!$request->semua) ? $request->kreditur : 'null',
        ]);
    }

    public function print(Request $request){

        // return json_encode($request->all());

        $d1 = explode('/', $request->d1)[2].'-'.explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
        $data = [];

        $krediturSupplier = DB::table('sup_supplier')->select('id_supplier as id', 'nama_supplier as text')->get();
        $krediturKaryawan = [];

        if($request->type == "Hutang_Supplier"){
               if($request->jenis == "rekap"){
                    // Laporan Type Rekap
                    
                        // Sesuaikan Nama Table Supplier Dari Sini Bosss.

                        $sampler = payable::where('py_chanel', 'Hutang_Supplier')
                                    ->join('sup_supplier', 'dk_payable.py_kreditur', '=', 'sup_supplier.id_supplier')
                                    ->distinct('py_kreditur')
                                    ->with([
                                            'detailBySupplier' => function($query){
                                                $query->where(DB::raw('(py_total_tagihan - py_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'py_kreditur',
                                                            'py_due_date',
                                                             DB::raw('(py_total_tagihan - py_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('py_kreditur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'py_kreditur',
                                                    'sup_supplier.nama_supplier',
                                                    DB::raw('sum(py_total_tagihan - py_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('py_kreditur', 'sup_supplier.nama_supplier')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $not = $first = $second = $third = $fourth = 0;

                            foreach($hutang->detailBySupplier as $idx => $detail){
                                $cek = date_diff(date_create($detail->py_due_date), date_create($d1));
                                $flag = $cek->format("%R");
                                $num = $cek->format("%a");

                                if($flag == '+'){

                                    if($num > 90)
                                        $fourth += $detail->total_tagihan;
                                    else if($num > 60)
                                        $third += $detail->total_tagihan;
                                    else if($num > 30)
                                        $second += $detail->total_tagihan;
                                    else
                                        $first += $detail->total_tagihan;

                                }else{
                                    $not += $detail->total_tagihan; 
                                }

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_supplier,
                                "total_hutang"           => $hutang->total_hutang,
                                "belum_jatuh_tempo"      => $not,
                                "first"                  => $first,
                                "second"                 => $second,
                                "third"                  => $third,
                                "fourth"                 => $fourth
                            ];
                        }

                        // Pastikan Sesuai
               }else{
                    // Laporan Type Detail
                        // Sesuaikan Nama Table Supplier Dari Sini Bosss.

                        $sampler = payable::where('py_chanel', 'Hutang_Supplier')
                                    ->join('sup_supplier', 'dk_payable.py_kreditur', '=', 'sup_supplier.id_supplier')
                                    ->distinct('py_kreditur')
                                    ->with([
                                            'detailBySupplier' => function($query){
                                                $query->where(DB::raw('(py_total_tagihan - py_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'py_kreditur',
                                                            'py_due_date',
                                                            'py_ref_nomor',
                                                            'py_tanggal',
                                                             DB::raw('(py_total_tagihan - py_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('py_kreditur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'py_kreditur',
                                                    'sup_supplier.nama_supplier',
                                                    DB::raw('sum(py_total_tagihan - py_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('py_kreditur', 'sup_supplier.nama_supplier')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $detailNota = [];

                            foreach($hutang->detailBySupplier as $idx => $detail){
                                $cek = date_diff(date_create($detail->py_due_date), date_create($d1));
                                $flag = $cek->format("%R");
                                $num = $cek->format("%a");
                                $not = $first = $second = $third = $fourth = 0; 

                                if($flag == '+'){

                                    if($num > 90)
                                        $fourth = $detail->total_tagihan;
                                    else if($num > 60)
                                        $third = $detail->total_tagihan;
                                    else if($num > 30)
                                        $second = $detail->total_tagihan;
                                    else
                                        $first = $detail->total_tagihan;

                                }else{
                                    $not = $detail->total_tagihan; 
                                }

                                array_push($detailNota, [
                                    "tanggal"                => $detail->py_tanggal,
                                    "jatuh_tempo"            => $detail->py_due_date,
                                    "nomor_referensi"        => $detail->py_ref_nomor,
                                    "belum_jatuh_tempo"      => $not,
                                    "first"                  => $first,
                                    "second"                 => $second,
                                    "third"                  => $third,
                                    "fourth"                 => $fourth
                                ]);

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_supplier,
                                "total_hutang"           => $hutang->total_hutang,
                                "id"                     => $hutang->py_kreditur,
                                "detail"                 => $detailNota,
                            ];
                        }

                        // Pastikan Sesuai
               }


        }else{
            return "hutang karyawan";
        }

        // return json_encode($data);

        return view('modul_keuangan.laporan.hutang.print.index', compact('data'));
    }

    public function pdf(Request $request){

        // return json_encode($request->all());

        $d1 = explode('/', $request->d1)[2].'-'.explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
        $data = [];
        $stage = "";

        $krediturSupplier = DB::table('sup_supplier')->select('id_supplier as id', 'nama_supplier as text')->get();
        $krediturKaryawan = [];

        if($request->type == "Hutang_Supplier"){
               $stage = "Supplier";
               if($request->jenis == "rekap"){
                    // Laporan Type Rekap
                    
                        // Sesuaikan Nama Table Supplier Dari Sini Bosss.

                        $sampler = payable::where('py_chanel', 'Hutang_Supplier')
                                    ->join('sup_supplier', 'dk_payable.py_kreditur', '=', 'sup_supplier.id_supplier')
                                    ->distinct('py_kreditur')
                                    ->with([
                                            'detailBySupplier' => function($query){
                                                $query->where(DB::raw('(py_total_tagihan - py_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'py_kreditur',
                                                            'py_due_date',
                                                             DB::raw('(py_total_tagihan - py_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('py_kreditur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'py_kreditur',
                                                    'sup_supplier.nama_supplier',
                                                    DB::raw('sum(py_total_tagihan - py_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('py_kreditur', 'sup_supplier.nama_supplier')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $not = $first = $second = $third = $fourth = 0;

                            foreach($hutang->detailBySupplier as $idx => $detail){
                                $cek = date_diff(date_create($detail->py_due_date), date_create($d1));
                                $flag = $cek->format("%R");
                                $num = $cek->format("%a");

                                if($flag == '+'){

                                    if($num > 90)
                                        $fourth += $detail->total_tagihan;
                                    else if($num > 60)
                                        $third += $detail->total_tagihan;
                                    else if($num > 30)
                                        $second += $detail->total_tagihan;
                                    else
                                        $first += $detail->total_tagihan;

                                }else{
                                    $not += $detail->total_tagihan; 
                                }

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_supplier,
                                "total_hutang"           => $hutang->total_hutang,
                                "belum_jatuh_tempo"      => $not,
                                "first"                  => $first,
                                "second"                 => $second,
                                "third"                  => $third,
                                "fourth"                 => $fourth
                            ];
                        }

                        // Pastikan Sesuai
               }else{
                    // Laporan Type Detail
                        // Sesuaikan Nama Table Supplier Dari Sini Bosss.

                        $sampler = payable::where('py_chanel', 'Hutang_Supplier')
                                    ->join('sup_supplier', 'dk_payable.py_kreditur', '=', 'sup_supplier.id_supplier')
                                    ->distinct('py_kreditur')
                                    ->with([
                                            'detailBySupplier' => function($query){
                                                $query->where(DB::raw('(py_total_tagihan - py_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'py_kreditur',
                                                            'py_due_date',
                                                            'py_ref_nomor',
                                                            'py_tanggal',
                                                             DB::raw('(py_total_tagihan - py_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('py_kreditur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'py_kreditur',
                                                    'sup_supplier.nama_supplier',
                                                    DB::raw('sum(py_total_tagihan - py_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('py_kreditur', 'sup_supplier.nama_supplier')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $detailNota = [];

                            foreach($hutang->detailBySupplier as $idx => $detail){
                                $cek = date_diff(date_create($detail->py_due_date), date_create($d1));
                                $flag = $cek->format("%R");
                                $num = $cek->format("%a");
                                $not = $first = $second = $third = $fourth = 0; 

                                if($flag == '+'){

                                    if($num > 90)
                                        $fourth = $detail->total_tagihan;
                                    else if($num > 60)
                                        $third = $detail->total_tagihan;
                                    else if($num > 30)
                                        $second = $detail->total_tagihan;
                                    else
                                        $first = $detail->total_tagihan;

                                }else{
                                    $not = $detail->total_tagihan; 
                                }

                                array_push($detailNota, [
                                    "tanggal"                => $detail->py_tanggal,
                                    "jatuh_tempo"            => $detail->py_due_date,
                                    "nomor_referensi"        => $detail->py_ref_nomor,
                                    "belum_jatuh_tempo"      => $not,
                                    "first"                  => $first,
                                    "second"                 => $second,
                                    "third"                  => $third,
                                    "fourth"                 => $fourth
                                ]);

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_supplier,
                                "total_hutang"           => $hutang->total_hutang,
                                "id"                     => $hutang->py_kreditur,
                                "detail"                 => $detailNota,
                            ];
                        }

                        // Pastikan Sesuai
               }
        }else{
            $stage = "Karyawan";
            return "hutang karyawan";
        }

        // return json_encode($data);

        $title = "Laporan_Hutang_".$stage."_".$request->jenis."_".$d1.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.hutang.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream($title);
    }

    public function excel(Request $request){

        // return json_encode($request->all());

        $d1 = explode('/', $request->d1)[2].'-'.explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
        $data = [];
        $stage = "";

        $krediturSupplier = DB::table('sup_supplier')->select('id_supplier as id', 'nama_supplier as text')->get();
        $krediturKaryawan = [];

        if($request->type == "Hutang_Supplier"){
               $stage = "Supplier";
               if($request->jenis == "rekap"){
                    // Laporan Type Rekap
                    
                        // Sesuaikan Nama Table Supplier Dari Sini Bosss.

                        $sampler = payable::where('py_chanel', 'Hutang_Supplier')
                                    ->join('sup_supplier', 'dk_payable.py_kreditur', '=', 'sup_supplier.id_supplier')
                                    ->distinct('py_kreditur')
                                    ->with([
                                            'detailBySupplier' => function($query){
                                                $query->where(DB::raw('(py_total_tagihan - py_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'py_kreditur',
                                                            'py_due_date',
                                                             DB::raw('(py_total_tagihan - py_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('py_kreditur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'py_kreditur',
                                                    'sup_supplier.nama_supplier',
                                                    DB::raw('sum(py_total_tagihan - py_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('py_kreditur', 'sup_supplier.nama_supplier')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $not = $first = $second = $third = $fourth = 0;

                            foreach($hutang->detailBySupplier as $idx => $detail){
                                $cek = date_diff(date_create($detail->py_due_date), date_create($d1));
                                $flag = $cek->format("%R");
                                $num = $cek->format("%a");

                                if($flag == '+'){

                                    if($num > 90)
                                        $fourth += $detail->total_tagihan;
                                    else if($num > 60)
                                        $third += $detail->total_tagihan;
                                    else if($num > 30)
                                        $second += $detail->total_tagihan;
                                    else
                                        $first += $detail->total_tagihan;

                                }else{
                                    $not += $detail->total_tagihan; 
                                }

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_supplier,
                                "total_hutang"           => $hutang->total_hutang,
                                "belum_jatuh_tempo"      => $not,
                                "first"                  => $first,
                                "second"                 => $second,
                                "third"                  => $third,
                                "fourth"                 => $fourth
                            ];
                        }

                        // Pastikan Sesuai
               }else{
                    // Laporan Type Detail
                        // Sesuaikan Nama Table Supplier Dari Sini Bosss.

                        $sampler = payable::where('py_chanel', 'Hutang_Supplier')
                                    ->join('sup_supplier', 'dk_payable.py_kreditur', '=', 'sup_supplier.id_supplier')
                                    ->distinct('py_kreditur')
                                    ->with([
                                            'detailBySupplier' => function($query){
                                                $query->where(DB::raw('(py_total_tagihan - py_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'py_kreditur',
                                                            'py_due_date',
                                                            'py_ref_nomor',
                                                            'py_tanggal',
                                                             DB::raw('(py_total_tagihan - py_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('py_kreditur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'py_kreditur',
                                                    'sup_supplier.nama_supplier',
                                                    DB::raw('sum(py_total_tagihan - py_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('py_kreditur', 'sup_supplier.nama_supplier')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $detailNota = [];

                            foreach($hutang->detailBySupplier as $idx => $detail){
                                $cek = date_diff(date_create($detail->py_due_date), date_create($d1));
                                $flag = $cek->format("%R");
                                $num = $cek->format("%a");
                                $not = $first = $second = $third = $fourth = 0; 

                                if($flag == '+'){

                                    if($num > 90)
                                        $fourth = $detail->total_tagihan;
                                    else if($num > 60)
                                        $third = $detail->total_tagihan;
                                    else if($num > 30)
                                        $second = $detail->total_tagihan;
                                    else
                                        $first = $detail->total_tagihan;

                                }else{
                                    $not = $detail->total_tagihan; 
                                }

                                array_push($detailNota, [
                                    "tanggal"                => $detail->py_tanggal,
                                    "jatuh_tempo"            => $detail->py_due_date,
                                    "nomor_referensi"        => $detail->py_ref_nomor,
                                    "belum_jatuh_tempo"      => $not,
                                    "first"                  => $first,
                                    "second"                 => $second,
                                    "third"                  => $third,
                                    "fourth"                 => $fourth
                                ]);

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_supplier,
                                "total_hutang"           => $hutang->total_hutang,
                                "id"                     => $hutang->py_kreditur,
                                "detail"                 => $detailNota,
                            ];
                        }

                        // Pastikan Sesuai
               }
        }else{
            $stage = "Karyawan";
            return "hutang karyawan";
        }

        // return json_encode($data);

        $title = "Laporan_Hutang_".$stage."_".$request->jenis."_".$d1.".xlsx";

        // return view('modul_keuangan.laporan.jurnal.print.excel', compact('data'));

        return Excel::download(new exporter('modul_keuangan.laporan.hutang.print.excel', $data), $title);
    }
}
