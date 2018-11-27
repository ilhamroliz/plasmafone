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

    public static function getHari(){
        $hari = Carbon::now('Asia/Jakarta')->format('l');

        if ($hari == 'Sunday') {
            $hari = 'Ahad';
        } elseif ($hari == 'Monday'){
            $hari = 'Senin';
        } elseif ($hari == 'Tuesday'){
            $hari = 'Selasa';
        } elseif ($hari == 'Wednesday'){
            $hari = 'Rabu';
        }
        elseif ($hari == 'Thursday'){
            $hari = 'Kamis';
        }
        elseif ($hari == 'Friday'){
            $hari = 'Jumat';
        }
        elseif ($hari == 'Saturday'){
            $hari = 'Sabtu';
        }
        return $hari;
    }

    public static function getTanggal(){
        $date = Carbon::now('Asia/Jakarta')->format('d M Y');
        return $date;
    }
}
