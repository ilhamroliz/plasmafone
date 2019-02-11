<?php

namespace App\Http\Controllers\modul_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class dashboard_controller extends Controller
{
    public function home(){
    	return view('modul_keuangan.dash');
    }
}
