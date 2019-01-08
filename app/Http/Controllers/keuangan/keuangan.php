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

    }

   
    public function viewCoa_kelompok()
    {

    }

    public function viewCoa_buku_besar()
    {

    }

    public function viewCoa_sub_buku_besar()
    {

    }

    // get data dropdown

    public function get_coaJenis()
    {

    }

    public function get_coaKelompok()
    {

    }

    // tambah data

    public function add_kelompok()
    {

    }

    public function add_buku_besar()
    {

    }

    public function add_sub_buku_besar()
    {

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
