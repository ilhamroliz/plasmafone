<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class manajemenPenggunaController extends Controller
{
    public function getId()
    {
        $cek = DB::table('d_mem')
            ->select(DB::raw('max(right(m_id, 7)) as id'))
            ->get();

        foreach ($cek as $x) {
            $temp = ((int)$x->id + 1);
            $kode = sprintf("%07s",$temp);
        }

        $tempKode = 'MEM' . $kode;
        return $tempKode;
    }

    public function addUser(Request $request){
        
        DB::beginTransaction();
        try {
            
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    public function editUser(){

    }

    public function getUser(){

    }
}
