<?php

namespace App\Http\Controllers\manajemen_penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController;

class pembuatanRencanaPenjualanController extends Controller
{
    function index()
    {
        if (PlasmafoneController::checkAkses(26, 'read') == false) {
            return view('errors.407');
        } else {
            return view('manajemen_penjualan.rencana_penjualan.index');
        }
    }
}
