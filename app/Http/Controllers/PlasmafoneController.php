<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class PlasmafoneController
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

    public static function checkAkses($a_id, $aksi)
    {
        $m_id = Auth::user()->m_id;
        $cek = null;
        if ($aksi == 'read'){
            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $m_id)
                ->where('ma_access', '=', $a_id)
                ->where('ma_read', '=', 'Y')
                ->get();
        } elseif ($aksi == 'insert'){
            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $m_id)
                ->where('ma_access', '=', $a_id)
                ->where('ma_insert', '=', 'Y')
                ->get();
        } elseif ($aksi == 'update'){
            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $m_id)
                ->where('ma_access', '=', $a_id)
                ->where('ma_update', '=', 'Y')
                ->get();
        } elseif ($aksi == 'delete'){
            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $m_id)
                ->where('ma_access', '=', $a_id)
                ->where('ma_delete', '=', 'Y')
                ->get();
        }

        if (count($cek) > 0){
            return true;
        } else {
            return false;
        }
    }

    public static function aksesSidebar()
    {
        $m_id = Auth::user()->m_id;
        $cek = DB::select("select ma_access, ma_read, a_name, a_order from d_mem_access inner join d_access on a_id = ma_access where ma_mem = '".$m_id."' order by a_order asc");
        $data = [];
        for ($i = 0; $i < count($cek); $i++){
            $data[$cek[$i]->a_name] = $cek[$i]->ma_read;
        }
        return $data;
    }
}
