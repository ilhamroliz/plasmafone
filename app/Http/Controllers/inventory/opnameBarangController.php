<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController;

class opnameBarangController extends Controller
{
    public function pusat()
    {
        if (PlasmafoneController::checkAkses(11, 'read') == false) {
            return view('errors.407');
        } else {
            return view('inventory.opname_barang.pusat');
        }
    }

    public function outlet()
    {
        if (PlasmafoneController::checkAkses(12, 'read') == false) {
            return view('errors.407');
        } else {
            return view('inventory.opname_barang.outlet');
        }
    }

    public function get_approved()
    {

    }

    public function get_pending()
    {

    }

    public function cari_opname(Request $request)
    {

    }

    public function cari_item_form()
    {

    }

    public function detil_opname($id)
    {

    }

    public function form_tambah()
    {

    }

    public function simpan_opname()
    {

    }

    public function approve_opname($id)
    {

    }

    public function delete_opname($id)
    {

    }

}
