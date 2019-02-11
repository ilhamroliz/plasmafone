<?php

namespace App\Http\Controllers\modul_keuangan\laporan\piutang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_receivable as receivable;

use DB;
use Excel;
use PDF;


class laporan_piutang_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.laporan.piutang.index');
    }

    public function dataResource(Request $request){
    	// return json_encode($request->all());

    	$d1 = explode('/', $request->d1)[2].'-'.explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
    	$data = [];

        $krediturSupplier = DB::table('sup_customer')->select('id_cust as id', 'nama_cust as text')->get();
        $krediturKaryawan = [];

        // return json_encode($krediturSupplier);

    	if($request->type == "Piutang_Customer"){
               if($request->jenis == "rekap"){
                    // Laporan Type Rekap
                    
                        // Sesuaikan Nama Table Customer Dari Sini Bosss.

                        $sampler = receivable::where('rc_chanel', 'Piutang_Customer')
                                    ->join('sup_customer', 'dk_receivable.rc_debitur', '=', 'sup_customer.id_cust')
                                    ->distinct('rc_debitur')
                                    ->with([
                                            'detailByDebitur' => function($query){
                                                $query->where(DB::raw('(rc_total_tagihan - rc_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'rc_debitur',
                                                            'rc_due_date',
                                                             DB::raw('(rc_total_tagihan - rc_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('rc_debitur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'rc_debitur',
                                                    'sup_customer.nama_cust',
                                                    DB::raw('sum(rc_total_tagihan - rc_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('rc_debitur', 'sup_customer.nama_cust')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $not = $first = $second = $third = $fourth = 0;

                            foreach($hutang->detailByDebitur as $idx => $detail){
                                $cek = date_diff(date_create($detail->rc_due_date), date_create($d1));
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
                                "nama_supplier"          => $hutang->nama_cust,
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
                        // Sesuaikan Nama Table Customer Dari Sini Bosss.

                        $sampler = receivable::where('rc_chanel', 'Piutang_Customer')
                                    ->join('sup_customer', 'dk_receivable.rc_debitur', '=', 'sup_customer.id_cust')
                                    ->distinct('rc_debitur')
                                    ->with([
                                            'detailByDebitur' => function($query){
                                                $query->where(DB::raw('(rc_total_tagihan - rc_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'rc_debitur',
                                                            'rc_due_date',
                                                            'rc_ref_nomor',
                                                            'rc_tanggal',
                                                             DB::raw('(rc_total_tagihan - rc_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('rc_debitur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'rc_debitur',
                                                    'sup_customer.nama_cust',
                                                    DB::raw('sum(rc_total_tagihan - rc_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('rc_debitur', 'sup_customer.nama_cust')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $detailNota = [];

                            foreach($hutang->detailByDebitur as $idx => $detail){
                                $cek = date_diff(date_create($detail->rc_due_date), date_create($d1));
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
                                    "tanggal"                => $detail->rc_tanggal,
                                    "jatuh_tempo"            => $detail->rc_due_date,
                                    "nomor_referensi"        => $detail->rc_ref_nomor,
                                    "belum_jatuh_tempo"      => $not,
                                    "first"                  => $first,
                                    "second"                 => $second,
                                    "third"                  => $third,
                                    "fourth"                 => $fourth
                                ]);

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_cust,
                                "total_hutang"           => $hutang->total_hutang,
                                "id"                     => $hutang->rc_debitur,
                                "detail"                 => $detailNota,
                            ];
                        }

                        // Pastikan Sesuai
               }


    	}else{
    		return "Piutang Lain";
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

        $krediturSupplier = DB::table('sup_customer')->select('id_cust as id', 'nama_cust as text')->get();
        $krediturKaryawan = [];

        // return json_encode($krediturSupplier);

    	if($request->type == "Piutang_Customer"){
               if($request->jenis == "rekap"){
                    // Laporan Type Rekap
                    
                        // Sesuaikan Nama Table Customer Dari Sini Bosss.

                        $sampler = receivable::where('rc_chanel', 'Piutang_Customer')
                                    ->join('sup_customer', 'dk_receivable.rc_debitur', '=', 'sup_customer.id_cust')
                                    ->distinct('rc_debitur')
                                    ->with([
                                            'detailByDebitur' => function($query){
                                                $query->where(DB::raw('(rc_total_tagihan - rc_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'rc_debitur',
                                                            'rc_due_date',
                                                             DB::raw('(rc_total_tagihan - rc_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('rc_debitur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'rc_debitur',
                                                    'sup_customer.nama_cust',
                                                    DB::raw('sum(rc_total_tagihan - rc_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('rc_debitur', 'sup_customer.nama_cust')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $not = $first = $second = $third = $fourth = 0;

                            foreach($hutang->detailByDebitur as $idx => $detail){
                                $cek = date_diff(date_create($detail->rc_due_date), date_create($d1));
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
                                "nama_supplier"          => $hutang->nama_cust,
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
                        // Sesuaikan Nama Table Customer Dari Sini Bosss.

                        $sampler = receivable::where('rc_chanel', 'Piutang_Customer')
                                    ->join('sup_customer', 'dk_receivable.rc_debitur', '=', 'sup_customer.id_cust')
                                    ->distinct('rc_debitur')
                                    ->with([
                                            'detailByDebitur' => function($query){
                                                $query->where(DB::raw('(rc_total_tagihan - rc_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'rc_debitur',
                                                            'rc_due_date',
                                                            'rc_ref_nomor',
                                                            'rc_tanggal',
                                                             DB::raw('(rc_total_tagihan - rc_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('rc_debitur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'rc_debitur',
                                                    'sup_customer.nama_cust',
                                                    DB::raw('sum(rc_total_tagihan - rc_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('rc_debitur', 'sup_customer.nama_cust')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $detailNota = [];

                            foreach($hutang->detailByDebitur as $idx => $detail){
                                $cek = date_diff(date_create($detail->rc_due_date), date_create($d1));
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
                                    "tanggal"                => $detail->rc_tanggal,
                                    "jatuh_tempo"            => $detail->rc_due_date,
                                    "nomor_referensi"        => $detail->rc_ref_nomor,
                                    "belum_jatuh_tempo"      => $not,
                                    "first"                  => $first,
                                    "second"                 => $second,
                                    "third"                  => $third,
                                    "fourth"                 => $fourth
                                ]);

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_cust,
                                "total_hutang"           => $hutang->total_hutang,
                                "id"                     => $hutang->rc_debitur,
                                "detail"                 => $detailNota,
                            ];
                        }

                        // Pastikan Sesuai
               }


    	}else{
    		return "Piutang Lain";
    	}

        // return json_encode($data);

        return view('modul_keuangan.laporan.piutang.print.index', compact('data'));
    }

    public function pdf(Request $request){

        // return json_encode($request->all());

        $d1 = explode('/', $request->d1)[2].'-'.explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
    	$data = [];
    	$stage = '';

        $krediturSupplier = DB::table('sup_customer')->select('id_cust as id', 'nama_cust as text')->get();
        $krediturKaryawan = [];

        // return json_encode($krediturSupplier);

    	if($request->type == "Piutang_Customer"){
    		   $stage = 'Customer';
               if($request->jenis == "rekap"){
                    // Laporan Type Rekap
                    
                        // Sesuaikan Nama Table Customer Dari Sini Bosss.

                        $sampler = receivable::where('rc_chanel', 'Piutang_Customer')
                                    ->join('sup_customer', 'dk_receivable.rc_debitur', '=', 'sup_customer.id_cust')
                                    ->distinct('rc_debitur')
                                    ->with([
                                            'detailByDebitur' => function($query){
                                                $query->where(DB::raw('(rc_total_tagihan - rc_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'rc_debitur',
                                                            'rc_due_date',
                                                             DB::raw('(rc_total_tagihan - rc_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('rc_debitur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'rc_debitur',
                                                    'sup_customer.nama_cust',
                                                    DB::raw('sum(rc_total_tagihan - rc_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('rc_debitur', 'sup_customer.nama_cust')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $not = $first = $second = $third = $fourth = 0;

                            foreach($hutang->detailByDebitur as $idx => $detail){
                                $cek = date_diff(date_create($detail->rc_due_date), date_create($d1));
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
                                "nama_supplier"          => $hutang->nama_cust,
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
                        // Sesuaikan Nama Table Customer Dari Sini Bosss.

                        $sampler = receivable::where('rc_chanel', 'Piutang_Customer')
                                    ->join('sup_customer', 'dk_receivable.rc_debitur', '=', 'sup_customer.id_cust')
                                    ->distinct('rc_debitur')
                                    ->with([
                                            'detailByDebitur' => function($query){
                                                $query->where(DB::raw('(rc_total_tagihan - rc_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'rc_debitur',
                                                            'rc_due_date',
                                                            'rc_ref_nomor',
                                                            'rc_tanggal',
                                                             DB::raw('(rc_total_tagihan - rc_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('rc_debitur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'rc_debitur',
                                                    'sup_customer.nama_cust',
                                                    DB::raw('sum(rc_total_tagihan - rc_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('rc_debitur', 'sup_customer.nama_cust')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $detailNota = [];

                            foreach($hutang->detailByDebitur as $idx => $detail){
                                $cek = date_diff(date_create($detail->rc_due_date), date_create($d1));
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
                                    "tanggal"                => $detail->rc_tanggal,
                                    "jatuh_tempo"            => $detail->rc_due_date,
                                    "nomor_referensi"        => $detail->rc_ref_nomor,
                                    "belum_jatuh_tempo"      => $not,
                                    "first"                  => $first,
                                    "second"                 => $second,
                                    "third"                  => $third,
                                    "fourth"                 => $fourth
                                ]);

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_cust,
                                "total_hutang"           => $hutang->total_hutang,
                                "id"                     => $hutang->rc_debitur,
                                "detail"                 => $detailNota,
                            ];
                        }

                        // Pastikan Sesuai
               }


    	}else{
    		$stage = 'Lain-lain';
    		return "Piutang Lain";
    	}

        // return json_encode($data);

        $title = "Laporan_Piutang_".$stage."_".$request->jenis."_".$d1.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.piutang.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($title);
    }

    public function excel(Request $request){

        // return json_encode($request->all());

        $d1 = explode('/', $request->d1)[2].'-'.explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0];
    	$data = [];
    	$stage = '';

        $krediturSupplier = DB::table('sup_customer')->select('id_cust as id', 'nama_cust as text')->get();
        $krediturKaryawan = [];

        // return json_encode($krediturSupplier);

    	if($request->type == "Piutang_Customer"){
    		   $stage = 'Customer';
               if($request->jenis == "rekap"){
                    // Laporan Type Rekap
                    
                        // Sesuaikan Nama Table Customer Dari Sini Bosss.

                        $sampler = receivable::where('rc_chanel', 'Piutang_Customer')
                                    ->join('sup_customer', 'dk_receivable.rc_debitur', '=', 'sup_customer.id_cust')
                                    ->distinct('rc_debitur')
                                    ->with([
                                            'detailByDebitur' => function($query){
                                                $query->where(DB::raw('(rc_total_tagihan - rc_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'rc_debitur',
                                                            'rc_due_date',
                                                             DB::raw('(rc_total_tagihan - rc_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('rc_debitur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'rc_debitur',
                                                    'sup_customer.nama_cust',
                                                    DB::raw('sum(rc_total_tagihan - rc_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('rc_debitur', 'sup_customer.nama_cust')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $not = $first = $second = $third = $fourth = 0;

                            foreach($hutang->detailByDebitur as $idx => $detail){
                                $cek = date_diff(date_create($detail->rc_due_date), date_create($d1));
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
                                "nama_supplier"          => $hutang->nama_cust,
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
                        // Sesuaikan Nama Table Customer Dari Sini Bosss.

                        $sampler = receivable::where('rc_chanel', 'Piutang_Customer')
                                    ->join('sup_customer', 'dk_receivable.rc_debitur', '=', 'sup_customer.id_cust')
                                    ->distinct('rc_debitur')
                                    ->with([
                                            'detailByDebitur' => function($query){
                                                $query->where(DB::raw('(rc_total_tagihan - rc_sudah_dibayar)'), '!=', 0)
                                                        ->select(
                                                            'rc_debitur',
                                                            'rc_due_date',
                                                            'rc_ref_nomor',
                                                            'rc_tanggal',
                                                             DB::raw('(rc_total_tagihan - rc_sudah_dibayar) as total_tagihan')
                                                        );
                                            }
                                    ]);

                        if(!$request->semua && $request->kreditur != ''){
                            $sampler = $sampler->where('rc_debitur', $request->kreditur);
                        }

                        $sampler = $sampler->select(
                                                    'rc_debitur',
                                                    'sup_customer.nama_cust',
                                                    DB::raw('sum(rc_total_tagihan - rc_sudah_dibayar) as total_hutang')
                                            )
                                            ->groupBy('rc_debitur', 'sup_customer.nama_cust')
                                            ->get();
                                    

                        // return json_encode($sampler);

                        foreach($sampler as $key => $hutang){

                            $detailNota = [];

                            foreach($hutang->detailByDebitur as $idx => $detail){
                                $cek = date_diff(date_create($detail->rc_due_date), date_create($d1));
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
                                    "tanggal"                => $detail->rc_tanggal,
                                    "jatuh_tempo"            => $detail->rc_due_date,
                                    "nomor_referensi"        => $detail->rc_ref_nomor,
                                    "belum_jatuh_tempo"      => $not,
                                    "first"                  => $first,
                                    "second"                 => $second,
                                    "third"                  => $third,
                                    "fourth"                 => $fourth
                                ]);

                            }

                            $data[$key] = [
                                "nama_supplier"          => $hutang->nama_cust,
                                "total_hutang"           => $hutang->total_hutang,
                                "id"                     => $hutang->rc_debitur,
                                "detail"                 => $detailNota,
                            ];
                        }

                        // Pastikan Sesuai
               }


    	}else{
    		$stage = 'Lain-lain';
    		return "Piutang Lain";
    	}

        // return json_encode($data);

        $title = "Laporan_Piutang_".$stage."_".$request->jenis."_".$d1.".xlsx";

        // return view('modul_keuangan.laporan.jurnal.print.excel', compact('data'));

        return Excel::download(new exporter('modul_keuangan.laporan.piutang.print.excel', $data), $title);
    }
}
