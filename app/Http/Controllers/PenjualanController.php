<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Response;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.penjualan-regular.index');
    }

    public function cariMember(Request $request)
    {
        $cari = $request->term;
        $nama = DB::table('m_member')
            ->where(function ($q) use ($cari){
                $q->orWhere('m_name', 'like', '%'.$cari.'%');
                $q->orWhere('m_telp', 'like', '%'.$cari.'%');
            })->get();

        if ($nama == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->m_id, 'label' => $query->m_name . ' ('.$query->m_telp.')'];
            }
        }
        return Response::json($results);
    }

    public function saveMember(Request $request)
    {
        DB::beginTransaction();
        try {
            $nama = strtoupper($request->nama);
            $nomor = $request->nomor;

            $cek = DB::table('m_member')
                ->where('m_telp', '=', $nomor)
                ->get();

            if (count($cek) > 0){
                DB::rollback();
                return response()->json([
                    'status' => 'nomor'
                ]);
            } else {
                $getId = DB::table('m_member')
                    ->max('m_id');
                DB::table('m_member')
                    ->insert([
                        'm_id' => $getId + 1,
                        'm_name' => $nama,
                        'm_telp' => $nomor
                    ]);
                DB::commit();
                return response()->json([
                    'status' => 'sukses'
                ]);
            }
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal'
            ]);
        }
    }
}
