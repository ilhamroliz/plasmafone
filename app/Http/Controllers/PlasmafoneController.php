<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class PlasmafoneController extends Controller
{
    public static function getActivity()
    {
        Carbon::setLocale('id');
        $sekarang = Carbon::now('Asia/Jakarta');
        $lastLogin = DB::table('d_mem')
            ->where('m_id', '=', Auth::user()->m_id)
            ->select('m_lastlogin')
            ->first();
        $lastLogin = $lastLogin->m_lastlogin;
        if ($lastLogin == null){
            $lastLogin = Carbon::now('Asia/Jakarta');
        } else {
            $lastLogin = Carbon::parse($lastLogin);
        }
        $time = $lastLogin->diffForHumans();
        return $time;
    }
}
