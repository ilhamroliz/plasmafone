<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Input;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\PlasmafoneController as Plasmafone;
//use App\Model\pengaturan\order as order;
use DB;
use Session;
use PDF;
use Auth;
use Response;
use Yajra\DataTables\DataTables;

class PengaturanController extends Controller
{
    public function akses_pengguna()
    {
        // $state = DB::table('d_mem')
        //                 ->select('m_state')
        //                 ->get();
        if (Plasmafone::checkAkses(42, 'read') == true) {
            $dis = '';
            if (Plasmafone::checkAkses(42, 'insert') == true) {
                return view('pengaturan.akses_pengguna.index')->with(compact('dis'));
            } else {
                $dis = 'denied';
                return view('pengaturan.akses_pengguna.index')->with(compact('dis'));
            }
        } else {
            return view('errors.access_denied');
        }
        // return view('pengaturan.akses_pengguna.index');
    }

    public function log_kegiatan()
    {
        if (Plasmafone::checkAkses(43, 'read') == true) {
            return view('pengaturan.log_activity.index');
        } else {
            return view('errors.access_denied');
        }
    }

    public function cari_userLog(Request $request)
    {
        $cari = $request->term;
        $nama = DB::select("select m_id, m_name from d_mem where m_name like '%" . $cari . "%' and m_status = 'AKTIF'");

        if ($nama == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->m_id, 'label' => $query->m_name];
            }
        }

        return Response::json($results);
    }

    public function find_log(Request $request)
    {
        // dd($request);
        if ($request->nama == "" && $request->tgl_awal != "" && $request->tgl_akhir != "") {
            $request->tgl_awal = str_replace('/', '-', $request->tgl_awal);
            $request->tgl_akhir = str_replace('/', '-', $request->tgl_akhir);

            $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
            $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000

            $data = DB::table('d_log_activity')
                ->join('d_mem', 'm_id', '=', 'la_mem')
                ->join('m_company', 'c_id', '=', 'la_comp')
                ->select('d_log_activity.*', 'm_name', 'c_name')
                ->where('la_date', '>=', $start)
                ->where('la_date', '<=', $end)
                ->get();
        } elseif ($request->nama != "" && $request->tgl_awal == "" && $request->tgl_akhir == "") {
            $data = DB::table('d_log_activity')
                ->join('d_mem', 'm_id', '=', 'la_mem')
                ->join('m_company', 'c_id', '=', 'la_comp')
                ->select('d_log_activity.*', 'm_name', 'c_name')
                ->where('la_mem', $request->nama)
                ->get();
        } elseif ($request->nama != "" && $request->tgl_awal != "" && $request->tgl_akhir != "") {
            $request->tgl_awal = str_replace('/', '-', $request->tgl_awal);
            $request->tgl_akhir = str_replace('/', '-', $request->tgl_akhir);

            $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
            $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000

            $data = DB::table('d_log_activity')
                ->join('d_mem', 'm_id', '=', 'la_mem')
                ->join('m_company', 'c_id', '=', 'la_comp')
                ->select('d_log_activity.*', 'm_name', 'c_name')
                ->where('la_date', '>=', $start)
                ->where('la_date', '<=', $end)
                ->where('la_mem', $request->nama)
                ->get();
        }

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->la_date = Carbon::parse($data[$i]->la_date)->format('d-m-Y G:i:s');
        }

        return Response::json($data);
    }

    public function dataUser()
    {
        $user = DB::table('d_mem')
            ->join('m_level', 'l_id', '=', 'm_level')
            ->select('d_mem.*', 'l_name')
            ->orderBy('m_id')
            ->get();
        $user = collect($user);
        $cekUpdate = Plasmafone::checkAkses(42, 'update');
        $cekDelete = Plasmafone::checkAkses(42, 'delete');
        return DataTables::of($user)
            ->addColumn('aksi', function ($user) use ($cekDelete, $cekUpdate) {
                if ($user->m_state == "ACTIVE") {
                    if ($cekUpdate == true && $cekDelete == true) {
                        return '<div class="text-center">
                        <button style="margin-left:5px;" title="Akses" type="button" class="btn btn-warning btn-circle btn-xs edit" onclick="akses(\'' . Crypt::encrypt($user->m_id) . '\')"><i class="glyphicon glyphicon-wrench"></i></button>
                        <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-success btn-circle btn-xs edit" onclick="edit(\'' . Crypt::encrypt($user->m_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>
                        <a href="#modalPass" id="passM" data-toggle="modal" style="margin-left:5px;" title="Ganti Password" type="button" class="btn btn-primary btn-circle btn-xs edit" data-id="' . Crypt::encrypt($user->m_id) . '"><i class="fa fa-exchange"></i></a>
                        <button style="margin-left:5px;" title="Set Nonactive" type="button" class="btn btn-danger btn-circle btn-xs" onclick="trigger(\'' . Crypt::encrypt($user->m_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>
                        </div>';
                    } else if ($cekUpdate == false && $cekDelete == true) {
                        return '<div class="text-center">
                        <button style="margin-left:5px;" title="Akses" type="button" class="btn btn-warning btn-circle btn-xs edit" disabled><i class="glyphicon glyphicon-wrench"></i></button>
                        <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-success btn-circle btn-xs edit" disabled><i class="glyphicon glyphicon-edit"></i></button>
                        <button style="margin-left:5px;" title="Ganti Password" type="button" class="btn btn-primary btn-circle btn-xs edit" disabled><i class="fa fa-exchange"></i></button>
                        <button style="margin-left:5px;" title="Set Nonactive" type="button" class="btn btn-danger btn-circle btn-xs" onclick="trigger(\'' . Crypt::encrypt($user->m_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>
                        </div>';
                    } else if ($cekDelete == false && $cekUpdate == true) {
                        return '<div class="text-center">
                        <button style="margin-left:5px;" title="Akses" type="button" class="btn btn-warning btn-circle btn-xs edit" onclick="akses(\'' . Crypt::encrypt($user->m_id) . '\')"><i class="glyphicon glyphicon-wrench"></i></button>
                        <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-success btn-circle btn-xs edit" onclick="edit(\'' . Crypt::encrypt($user->m_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>
                        <a href="#modalPass" id="passM" data-toggle="modal" style="margin-left:5px;" title="Ganti Password" type="button" class="btn btn-primary btn-circle btn-xs edit" data-id="' . Crypt::encrypt($user->m_id) . '"><i class="fa fa-exchange"></i></a>
                        <button style="margin-left:5px;" title="Set Nonactive" type="button" class="btn btn-danger btn-circle btn-xs" disabled><i class="glyphicon glyphicon-trash"></i></button>
                        </div>';
                    } else {
                        return '<div class="text-center">
                        <button style="margin-left:5px;" title="Akses" type="button" class="btn btn-warning btn-circle btn-xs edit" disabled><i class="glyphicon glyphicon-wrench"></i></button>
                        <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-success btn-circle btn-xs edit" disabled><i class="glyphicon glyphicon-edit"></i></button>
                        <button style="margin-left:5px;" title="Ganti Password" type="button" class="btn btn-primary btn-circle btn-xs edit" disabled><i class="fa fa-exchange"></i></button>
                        <button style="margin-left:5px;" title="Set Nonactive" type="button" class="btn btn-danger btn-circle btn-xs" disabled><i class="glyphicon glyphicon-trash"></i></button>
                        </div>';
                    }
                } else {
                    if (Plasmafone::checkAkses(42, 'delete') == false) {
                        return '<div class="text-center">
                        <button style="margin-left:5px;" title="Akses" type="button" class="btn btn-warning btn-circle btn-xs edit" onclick="akses(\'' . Crypt::encrypt($user->m_id) . '\')" disabled><i class="glyphicon glyphicon-wrench"></i></button>
                        <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-success btn-circle btn-xs edit" onclick="edit(\'' . Crypt::encrypt($user->m_id) . '\')" disabled><i class="glyphicon glyphicon-edit"></i></button>
                        <button style="margin-left:5px;" title="Ganti Password" type="button" class="btn btn-primary btn-circle btn-xs edit" onclick="pass(\'' . Crypt::encrypt($user->m_id) . '\')" disabled><i class="fa fa-exchange"></i></button>
                        <button style="margin-left:5px;" title="Set Active" type="button" class="btn btn-primary btn-circle btn-xs" onclick="trigger(\'' . Crypt::encrypt($user->m_id) . '\')" disabled><i class="glyphicon glyphicon-check"></i></button>
                        </div>';
                    } else {
                        return '<div class="text-center">
                        <button style="margin-left:5px;" title="Akses" type="button" class="btn btn-warning btn-circle btn-xs edit" onclick="akses(\'' . Crypt::encrypt($user->m_id) . '\')" disabled><i class="glyphicon glyphicon-wrench"></i></button>
                        <button style="margin-left:5px;" title="Edit" type="button" class="btn btn-success btn-circle btn-xs edit" onclick="edit(\'' . Crypt::encrypt($user->m_id) . '\')" disabled><i class="glyphicon glyphicon-edit"></i></button>
                        <button style="margin-left:5px;" title="Ganti Password" type="button" class="btn btn-primary btn-circle btn-xs edit" onclick="pass(\'' . Crypt::encrypt($user->m_id) . '\')" disabled><i class="fa fa-exchange"></i></button>
                        <button style="margin-left:5px;" title="Set Active" type="button" class="btn btn-primary btn-circle btn-xs" onclick="trigger(\'' . Crypt::encrypt($user->m_id) . '\')"><i class="glyphicon glyphicon-check"></i></button>
                        </div>';
                    }
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function edit_akses($id)
    {
        $idm = Crypt::decrypt($id);
        $user = DB::table('d_mem')
            ->join('m_level', 'l_id', '=', 'm_level')
            ->join('m_company', 'c_id', '=', 'm_comp')
            ->select('d_mem.*', 'l_name', 'm_company.c_name', DB::raw('DATE_FORMAT(m_lastlogin, "%d/%m/%Y %h:%i") as m_lastlogin'), DB::raw('DATE_FORMAT(m_lastlogout, "%d/%m/%Y %h:%i") as m_lastlogout'))
            ->where('m_id', $idm)->get();

        if (count($user) == 0) {
            return view('errors.data_not_found');
        }

        $id = Crypt::encrypt($idm);

        $akses = DB::select("select * from d_access left join d_mem_access on a_id = ma_access and ma_mem = '" . $idm . "' order by a_order");

        if (Plasmafone::checkAkses(42, 'update') == true) {
            return view('pengaturan.akses_pengguna.edit')->with(compact('user', 'akses', 'id'));
        } else {
            return view('errors.access_denied');
        }
        // return view('pengaturan.akses_pengguna.edit')->with(compact('user', 'akses', 'id'));
    }

    public function simpan(Request $request)
    {
        // dd($request);
        $id = Crypt::decrypt($request->id);
        DB::beginTransaction();
        $nama = DB::table('d_mem')->select('m_name')->where('m_id', $id)->first();

        try {
            $read = [];
            if ($request->read != null) {
                $read = $request->read;
            }
            $insert = [];
            if ($request->insert != null) {
                $insert = $request->insert;
            }
            $update = [];
            if ($request->update != null) {
                $update = $request->update;
            }
            $delete = [];
            if ($request->delete != null) {
                $delete = $request->delete;
            }

            $akses = DB::table('d_access')
                ->select('a_id')
                ->get();

            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $id)
                ->get();

            if (count($cek) > 0) {
                //== update data
                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->update([
                        'ma_read' => 'N',
                        'ma_insert' => 'N',
                        'ma_update' => 'N',
                        'ma_delete' => 'N'
                    ]);

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
            } else {
                //== create data
                $addAkses = [];
                for ($i = 0; $i < count($akses); $i++) {
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
            // $response = [
            //     'status' => 'sukses'
            // ];
            // return json_encode($response);
            $log = 'Mengganti Hak Akses User ' . $nama->m_name;
            Plasmafone::logActivity($log);
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // $response = [
            //     'status' => 'gagal'
            // ];
            // return json_encode($response);
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }

    }
}
