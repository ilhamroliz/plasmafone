<?php

namespace App\Http\Controllers\master\pembayaran;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MasterPembayaranController extends Controller
{
    public function index()
    {
        return view('master.pembayaran.index');
    }
}
