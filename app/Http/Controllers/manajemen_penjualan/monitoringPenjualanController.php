<?php

namespace App\Http\Controllers\manajemen_penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController;

class monitoringPenjualanController extends Controller
{
    public function index()
    {
        if (PlasmafoneController::checkAkses(27, 'read') == false) {
            return view('errors.407');
        } else {
            return view('manajemen_penjualan.monitoring_penjualan.index');
        }
    }
}
