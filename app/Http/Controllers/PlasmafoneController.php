<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PlasmafoneController extends Controller
{
    public static function getActivity()
    {
        $sekarang = Carbon::now('Asia/Jakarta');
    }
}
