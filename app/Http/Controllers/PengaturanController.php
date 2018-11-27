<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Illuminate\Support\Facades\Crypt;
//use App\Model\pengaturan\order as order;
use DB;
use Session;
use PDF;
use Auth;

class PengaturanController extends Controller
{
    public function akses_pengguna()
    {
        $data_users = DB::table('d_mem')
                        ->join('d_jabatan','id', '=', 'm_level')
                        ->select('d_mem.*', 'd_jabatan.nama')
                        ->orderBy('m_id')
                        ->get();
        return view('pengaturan.akses_pengguna.index')->with(compact('data_users'));
    }

    public function edit_akses(Request $request)
    {
        $user = DB::table('d_mem')
                        ->join('d_jabatan', 'id', '=', 'm_level')
                        ->join('m_company', 'c_id', '=', 'm_comp')
                        ->select('d_mem.*', 'd_jabatan.nama', 'm_company.c_name', DB::raw('DATE_FORMAT(m_lastlogin, "%d/%m/%Y %h:%i") as m_lastlogin'), DB::raw('DATE_FORMAT(m_lastlogout, "%d/%m/%Y %h:%i") as m_lastlogout'))
                        ->where('m_id', $request->id)->get();

        if(count($user) == 0){
            return view('errors.data_not_found');
        }

        $id = Crypt::encrypt($request->id);

        $akses = DB::select("select * from d_access left join d_mem_access on a_id = ma_access and ma_mem = '".$request->id."' order by a_order");

        return view('pengaturan.akses_pengguna.edit')->with(compact('user', 'akses', 'id'));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();
        try {
            $read = $request->read;
            $insert = $request->insert;
            $update = $request->update;
            $delete = $request->delete;
            $id = Crypt::decrypt($request->id);

            $akses = DB::table('d_access')
                ->select('a_id')
                ->get();

            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $id)
                ->get();

            if (count($cek) > 0){
                //== update data
                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->update([
                        'ma_read' => 'N',
                        'ma_insert' => 'N',
                        'ma_update' => 'N',
                        'ma_delete' => 'N'
                    ]);

                if(count($read) > 0){
                    DB::table('d_mem_access')
                        ->where('ma_mem', '=', $id)
                        ->whereIn('ma_access', $read)
                        ->update([
                            'ma_read' => 'Y'
                        ]);
                }
                if (count($insert) > 0) {
                    DB::table('d_mem_access')
                        ->where('ma_mem', '=', $id)
                        ->whereIn('ma_access', $insert)
                        ->update([
                            'ma_insert' => 'Y'
                        ]);
                }
                if (count($update) > 0) {
                    DB::table('d_mem_access')
                        ->where('ma_mem', '=', $id)
                        ->whereIn('ma_access', $update)
                        ->update([
                            'ma_update' => 'Y'
                        ]);                
                }
                if (count($delete) > 0) {
                    DB::table('d_mem_access')
                        ->where('ma_mem', '=', $id)
                        ->whereIn('ma_access', $delete)
                        ->update([
                            'ma_delete' => 'Y'
                        ]);
                }
            } else {
                //== create data
                $addAkses = [];
                for ($i = 0; $i < count($akses); $i++){
                    $temp = [
                        'ma_mem' => $id,
                        'ma_access' => $akses[$i]->a_id
                    ];
                    array_push($addAkses, $temp);
                }
                DB::table('d_mem_access')->insert($addAkses);

                if (count($read) > 0) {
                    DB::table('d_mem_access')
                        ->where('ma_mem', '=', $id)
                        ->whereIn('ma_access', $read)
                        ->update([
                            'ma_read' => 'Y'
                        ]);
                }
                if (count($insert) > 0) {
                    DB::table('d_mem_access')
                        ->where('ma_mem', '=', $id)
                        ->whereIn('ma_access', $insert)
                        ->update([
                            'ma_insert' => 'Y'
                        ]);            
                }
                if (count($update) > 0) {
                    DB::table('d_mem_access')
                        ->where('ma_mem', '=', $id)
                        ->whereIn('ma_access', $update)
                        ->update([
                            'ma_update' => 'Y'
                        ]);
                }
                if (count($delete) > 0) {
                    DB::table('d_mem_access')
                        ->where('ma_mem', '=', $id)
                        ->whereIn('ma_access', $delete)
                        ->update([
                            'ma_delete' => 'Y'
                        ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::commit();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
        
    }
}
