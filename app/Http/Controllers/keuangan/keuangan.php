<?php

namespace App\Http\Controllers\keuangan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\pembelian\order as order;
use App\Http\Controllers\PlasmafoneController as Plasma;

use DataTables;
use Carbon\Carbon;
use Auth;
use DB;
use Session;
use PDF;
use Response;

class keuangan extends Controller
{
    // view halaman
    public function index_jenis()
    {
        return view('keuangan/master_coa/index_jenis');
    }

    public function index_kelompok()
    {
        return view('keuangan/master_coa/index_kelompok');
    }

    public function index_buku_besar()
    {
        return view('keuangan/master_coa/index_buku_besar');
    }

    public function index_sub_buku_besar()
    {
        return view('keuangan/master_coa/index_sub_buku_besar');
    }
    // view  data
    public function viewCoa_jenis()
    {
        $jenis = DB::table('dk_akun_jenis')
        ->select('dk_akun_jenis.*')
        ->get();

        $data = array();
        foreach ($jenis as $key) {
            $row = array();
            $row[] = $key->dk_jenis_id;
            $row[] = $key->dk_nama_jenis;
            $data[] = $row;

        }
        echo json_encode(array("data"=>$data));
    }

   
    public function viewCoa_kelompok(Request $request)
    {
        $jenis = $request->input('jenis');
        $kelompok = DB::table('dk_akun_kelompok')
        ->select('dk_akun_kelompok.*','dk_akun_jenis.*')
        ->join('dk_akun_jenis','dk_akun_kelompok.ACCJENIS','=','dk_akun_jenis.dk_jenis_id')
        ->where('dk_akun_kelompok.ACCJENIS','=',$jenis)
        ->get();

        $data = array();
        foreach ($kelompok as $key ) {
           $row = array();
           $row[] = $key->dk_nama_jenis;
           $row[] = $key->ACCKEL;
           $row[] = $key->KELOMPOK;
           $data[] = $row;
        }
        echo json_encode(array("data"=>$data));
    }

    public function viewCoa_buku_besar(Request $request)
    {
        $jenis = $request->input('jenis');
        $kelompok = $request->input('kelompok');

        $bb = DB::table('dk_akun_bb')
        ->select('dk_akun_bb.*','dk_akun_kelompok')
        ->join('dk_akun_kelompok','dk_akun_bb.ACCKEL','=','dk_akun_kelompok.ACCKEL')
        ->where('dk_akun_bb.ACCKEL','=',$kelompok)
        ->get();

        $data = array();
        foreach ($bb as $key ) {
            $row = array();
            $row[] = $key->KELOMPOK;
            $row[] = $key->ACCBB;
            $row[] = $key->BUKUBESAR;
            $data[] = $row;
         }
         echo json_encode(array("data"=>$data));

    }

    public function viewCoa_sub_buku_besar(Request $request)
    {
        $jenis = $request->input('jenis');
        $kelompok = $request->input('kelompok');
        $buku_besar = $request->input('buku_besar');

        if($jenis =='00' and $kelompok=='00' and $buku_besar=='00'){
            $sbb = DB::table('dk_akun_sbb')
            ->select('dk_akun_sbb.*','dk_akun_bb.*','dk_akun_kel.*','dk_akun_jenis.*')
            ->join('dk_akun_bb','dk_akun_sbb.ACCBB','=','dk_akun_bb.ACCBB')
            ->join('dk_akun_kel','dk_akun_bb.ACCKEL','=','dk_akun_kel.ACCKEL')
            ->join('dk_akun_jenis','dk_akun_kel.ACCJENIS','=','dk_akun_jenis.ACCJENIS')
            ->get();
        }else if($jenis !='00' and $kelompok=='00' and $buku_besar=='00'){
            $sbb = DB::table('dk_akun_sbb')
            ->select('dk_akun_sbb.*','dk_akun_bb.*','dk_akun_kel.*','dk_akun_jenis.*')
            ->join('dk_akun_bb','dk_akun_sbb.ACCBB','=','dk_akun_bb.ACCBB')
            ->join('dk_akun_kel','dk_akun_bb.ACCKEL','=','dk_akun_kel.ACCKEL')
            ->join('dk_akun_jenis','dk_akun_kel.ACCJENIS','=','dk_akun_jenis.ACCJENIS')
            ->where('dk_akun_kel.ACCJENIS','=',$jenis)
            ->get();
        }else if($jenis =='00' and $kelompok !='00' and $buku_besar=='00'){
            $sbb = DB::table('dk_akun_sbb')
            ->select('dk_akun_sbb.*','dk_akun_bb.*','dk_akun_kel.*','dk_akun_jenis.*')
            ->join('dk_akun_bb','dk_akun_sbb.ACCBB','=','dk_akun_bb.ACCBB')
            ->join('dk_akun_kel','dk_akun_bb.ACCKEL','=','dk_akun_kel.ACCKEL')
            ->join('dk_akun_jenis','dk_akun_kel.ACCJENIS','=','dk_akun_jenis.ACCJENIS')
            ->where('dk_akun_bb.ACCKEL','=',$kelompok)
            ->get();
        }else if($jenis =='00' and $kelompok =='00' and $buku_besar !='00'){
            $sbb = DB::table('dk_akun_sbb')
            ->select('dk_akun_sbb.*','dk_akun_bb.*','dk_akun_kel.*','dk_akun_jenis.*')
            ->join('dk_akun_bb','dk_akun_sbb.ACCBB','=','dk_akun_bb.ACCBB')
            ->join('dk_akun_kel','dk_akun_bb.ACCKEL','=','dk_akun_kel.ACCKEL')
            ->join('dk_akun_jenis','dk_akun_kel.ACCJENIS','=','dk_akun_jenis.ACCJENIS')
            ->where('dk_akun_sbb.ACCBB','=',$buku_besar)
            ->get();
        }else if($jenis =='00' and $kelompok !='00' and $buku_besar !='00'){
            $sbb = DB::table('dk_akun_sbb')
            ->select('dk_akun_sbb.*','dk_akun_bb.*','dk_akun_kel.*','dk_akun_jenis.*')
            ->join('dk_akun_bb','dk_akun_sbb.ACCBB','=','dk_akun_bb.ACCBB')
            ->join('dk_akun_kel','dk_akun_bb.ACCKEL','=','dk_akun_kel.ACCKEL')
            ->join('dk_akun_jenis','dk_akun_kel.ACCJENIS','=','dk_akun_jenis.ACCJENIS')
            ->where('dk_akun_bb.ACCKEL','=',$kelompok)
            ->where('dk_akun_sbb.ACCBB','=',$buku_besar)
            ->get();
        }else if($jenis !='00' and $kelompok !='00' and $buku_besar =='00'){
            $sbb = DB::table('dk_akun_sbb')
            ->select('dk_akun_sbb.*','dk_akun_bb.*','dk_akun_kel.*','dk_akun_jenis.*')
            ->join('dk_akun_bb','dk_akun_sbb.ACCBB','=','dk_akun_bb.ACCBB')
            ->join('dk_akun_kel','dk_akun_bb.ACCKEL','=','dk_akun_kel.ACCKEL')
            ->join('dk_akun_jenis','dk_akun_kel.ACCJENIS','=','dk_akun_jenis.ACCJENIS')
            ->where('dk_akun_kel.ACCJENIS','=',$jenis)
            ->where('dk_akun_bb.ACCKEL','=',$kelompok)
            ->get();
        }else if($jenis !='00' and $kelompok !='00' and $buku_besar !='00'){
            $sbb = DB::table('dk_akun_sbb')
            ->select('dk_akun_sbb.*','dk_akun_bb.*','dk_akun_kel.*','dk_akun_jenis.*')
            ->join('dk_akun_bb','dk_akun_sbb.ACCBB','=','dk_akun_bb.ACCBB')
            ->join('dk_akun_kel','dk_akun_bb.ACCKEL','=','dk_akun_kel.ACCKEL')
            ->join('dk_akun_jenis','dk_akun_kel.ACCJENIS','=','dk_akun_jenis.ACCJENIS')
            ->where('dk_akun_kel.ACCJENIS','=',$jenis)
            ->where('dk_akun_bb.ACCKEL','=',$kelompok)
            ->where('dk_akun_sbb.ACCBB','=',$buku_besar)
            ->get();
        }

        $data = array();
        $i = 1;
        foreach ($sbb as $key) {
            $row = array();
            $row[] = $i++;
            $row[] = $key->dk_nama_jenis;
            $row[] = $key->KELOMPOK;
            $row[] = $key->BUKUBESAR;
            $row[] = $key->ACC;
            $row[] = $key->KETERANGAN;
            $data[] = $row;
        }

        echo json_encode(array("data"=>$data));

    }

    // get data dropdown

    public function get_coaJenis()
    {
        $jenis = DB::table('dk_akun_jenis')
        ->select('dk_akun_jenis.*')
        ->orderBy('ACCJENIS','ASC')
        ->get();

        echo json_encode($jenis);

    }

    public function get_coaKelompok(Request $request)
    {
        $jenis = $request->input('jenis');

        if($jenis=='00'){
            $kelompok = DB::table('dk_akun_kel')
            ->select('dk_akun_kel.*')
            ->orderBy('ACCKEL','ASC')
            ->get();
        }else{
            $kelompok = DB::table('dk_akun_kel')
            ->select('dk_akun_kel.*')
            ->where('dk_akun_kel.ACCJENIS','=',$jenis)
            ->orderBy('ACCKEL','ASC')
            ->get();
        }
        

        echo json_encode($kelompok);

    }

    public function get_coaBb(Request $request)
    {
        $jenis = $request->input('jenis');
        $kelompok = $request->input('kelompok');

        if($kelompok =='00'){
            $buku_besar = DB::table('dk_akun_bb')
            ->select('dk_akun_bb.*')
            ->orderBy('ACCBB','ASC')
            ->get();
        }else{
            $buku_besar = DB::table('dk_akun_bb')
            ->select('dk_akun_bb.*')
            ->where('dk_akun_bb.ACCKEL','=',$kelompok)
            ->orderBy('ACCBB','ASC')
            ->get();
        }
        

        echo json_encode($buku_besar);

    }

    public function get_detail_bb(Request $request)
    {
        $bb = $request->input('bb');
        $query = DB::table('dk_akun_bb')
        ->select('dk_akun_bb.*')
        ->where('dk_akun_bb.ACCBB','=',$bb)
        ->get();

        foreach ($query as $key) {
            $ACCBB = $key->ACCBB;
            $KATEGORI = $key->KATEGORI;
        }
        $data = array(
            "accbb"=>$ACCBB,
            "kategori"=>$KATEGORI
        );

        echo json_encode($data);
    }

    // tambah data

    public function add_kelompok()
    {

    }

    public function add_buku_besar()
    {

    }

    public function add_sub_buku_besar(Request $request)
    {
        $accbb = $request->input('accbb');
        $accsbb = $request->input('accsbb');
        $keterangan = $request->input('keterangan');
        $ket = strtoupper($keterangan);
        $cashflow = $request->input('cashflow');
        $unit = Auth::user()->m_comp;
        $id_sbb = $accbb.''.$accsbb;

        $list = array([
            'ACCBB'     =>$accbb,
            'ACC'       =>$id_sbb,
            'KETERANGAN'=>$ket,
            'CASHFLOW'  =>$cashflow,
            'UNIT'      =>$unit
            ]);

        $insert = DB::table('dk_akun_sbb')->insert($list);
        if(!$insert){
            $data = "GAGAL";
            echo json_encode(array("status"=>$data));
        }else{
            $data = "SUKSES";
            echo json_encode(array("status"=>$data));
        }



    }

    // edit data coa

    public function edit_kelompok()
    {

    }

    public function edit_buku_besar()
    {

    }

    public function edit_sub_buku_besar()
    {

    }


}
