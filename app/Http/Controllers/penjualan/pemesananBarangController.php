<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController as Plasma;
use Illuminate\Support\Facades\Crypt;

use DataTables;
use DB;
use Session;
use Auth;
use Carbon\Carbon;
use Response;

class pemesananBarangController extends Controller
{
    public function index()
    {
        if (Plasma::checkAkses(18, 'read') == false) {
            return view('errors/407');
        } else {
            $datapemesanan = DB::table('d_indent')
                ->select('i_comp', 'i_member', 'i_nota', 'i_total_tagihan', 'i_total_pembayaran')
                ->first();
            return view('penjualan.pemesanan_barang.index')->with(compact('datapemesanan'));
        }
    }

    public function get_data_proses()
    {

    }

    public function get_data_done()
    {

    }

    public function get_data_cancel()
    {

    }

    public function get_detail()
    {

    }

    public function tambah_member()
    {

    }

    public function tambah_pemesanan()
    {

    }

    public function hapus()
    {

    }
}
