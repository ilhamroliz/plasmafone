<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReturnPenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.return-penjualan.index');
    }
}
