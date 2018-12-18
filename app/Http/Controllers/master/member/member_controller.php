<?php

namespace App\Http\Controllers\master\member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Model\master\member as member;
use App\Http\Controllers\PlasmafoneController as Plasma;

use DB;
use Session;
use DataTables;
use Carbon\Carbon;

class member_controller extends Controller
{
    public function index()
    {
        if (Plasma::checkAkses(47, 'read' == true)) {
            return view('master/member/index');
        } else {
            return view('errors/407');
        }
    }

    public function get_data_all()
    {
        $all = member::orderBy('m_insert', 'desc')->get();
        $all = collect($all);

        return DataTables::of($all)
            ->addColumn('active', function ($all) {

                if ($all->m_status == "AKTIF") {
                    return '<span class="label label-success">AKTIF</span>';
                } else {
                    return '<span class="label label-danger">NON AKTIF</span>';
                }

            })
            ->addColumn('aksi', function ($all) {

                if ($all->m_status == "AKTIF") {
                    if (Access::checkAkses(47, 'update') == true) {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . Crypt::encrypt($supplier_all->s_id) . '\', \'' . $supplier_all->s_name . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                    } else {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    }
                } else {
                    if (Access::checkAkses(47, 'update') == true) {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Aktifkan" onclick="statusactive(\'' . Crypt::encrypt($supplier_all->s_id) . '\', \'' . $supplier_all->s_name . '\')"><i class="glyphicon glyphicon-check"></i></button></div>';
                    } else {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_all->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    }
                }
            })
            ->rawColumns(['aksi', 'active'])
            ->make(true);
    }

    public function get_data_active()
    {
        $active = member::where('m_status', 'AKTIF')->orderBy('m_insert')->get();
        $active = collect($active);

        return DataTables::of($active)
            ->addColumn('aksi', function ($supplier_active) {
                if (Access::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_active->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_active->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($supplier_active->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . Crypt::encrypt($supplier_active->s_id) . '\', \'' . $supplier_active->s_name . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_data_nonactive()
    {
        $nonactive = member::where('m_status', 'NONAKTIF')->orderBy('m_insert', 'desc')->get();
        $nonactive = collect($nonactive);

        return DataTables::of($nonactive)

            ->addColumn('aksi', function ($nonactive) {

                if (Access::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_nonactive->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($supplier_nonactive->s_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Aktifkan" onclick="statusactive(\'' . Crypt::encrypt($supplier_nonactive->s_id) . '\', \'' . $supplier_nonactive->s_name . '\')"><i class="glyphicon glyphicon-check"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($supplier_nonactive->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function detail($id)
    {

    }

    public function tambah(Request $request)
    {
        if (Plasma::checkAkses(47, 'insert') == true) {

            if ($request->isMethod('post')) {
                // dd($request);
                $data = $request->all();
                DB::beginTransaction();
                try {

                    $check = member::where('m_nik', '=', $data['nik'])->count();

                    if ($check == 0) {

                        if ($data['tanggal'] != 'Tanggal' || $data['tanggal'] != '') {
                            $tanggal = $data['tanggal'];
                        } else {
                            $tanggal = "00";
                        }

                        if ($data['bulan'] != 'Bulan' || $data['bulan'] != '') {
                            $bulan = $data['bulan'];
                        } else {
                            $bulan = "00";
                        }

                        if ($data['tahun'] != 'Tahun' || $data['tahun'] != '') {
                            $tahun = $data['tahun'];
                        } else {
                            $tahun = "0000";
                        }

                        $tglnow = Carbon::now('Asia/Jakarta');

                        DB::table('m_mem')->insert([
                            'm_name' => strtoupper($data['nama']),
                            'm_nik' => $data['nik'],
                            'm_birth' => $tahun . '-' . $bulan . '-' . $tanggal,
                            'm_telp' => $data['telp'],
                            'm_address' => $data['alamat'],
                            'm_email' => $data['email'],
                            'm_insert' => $tglnow
                        ]);

                    } else {
                        return json_encode([
                            'status' => 'ada',
                            'member' => $data['nik'] . ' (' . $data['telp'] . ')'
                        ]);
                    }
                    DB::commit();

                    Plasma::logActivity('Menambahkan Member ' . $data['nama']);

                    return json_encode([
                        'status' => 'berhasil'
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();

                    return json_encode([
                        'status' => 'gagal',
                        'pesan' => $e
                    ]);
                }
            }

            return view('master/member/add');
        } else {
            return view('errors/407');
        }
    }

    public function edit(Request $request)
    {
        if (Plasma::checkAkses(47, 'update') == true) {
            if ($request->isMethod('post')) {
                if (Plasma::checkAkses(47, 'update') == true) {

                    $data = $request->all();
                    DB::beginTransaction();
                    try {

                        $cek = member::where('m_id', Crypt::decrypt($id))->count();

                        if ($check != 0) {

                            if ($data['tanggal'] != 'Tanggal' || $data['tanggal'] != '') {
                                $tanggal = $data['tanggal'];
                            } else {
                                $tanggal = "00";
                            }

                            if ($data['bulan'] != 'Bulan' || $data['bulan'] != '') {
                                $bulan = $data['bulan'];
                            } else {
                                $bulan = "00";
                            }

                            if ($data['tahun'] != 'Tahun' || $data['tahun'] != '') {
                                $tahun = $data['tahun'];
                            } else {
                                $tahun = "0000";
                            }

                            $tglnow = Carbon::now('Asia/Jakarta');

                            member::where('m_id', Crypt::decrypt($id))->update([
                                'm_name' => strtoupper($data['nama']),
                                'm_nik' => $data['nik'],
                                'm_telp' => $data['telp'],
                                'm_email' => $data['email'],
                                'm_birth' => $tahun . '-' . $bulan . '-' . $tanggal,
                                'm_alamat' => $data['address'],
                                'm_update' => $tglnow
                            ]);

                            DB::commit();

                            Plasma::logActivity('Edit Data Member ' . $data['nama']);

                            return json_encode([
                                'status' => 'berhasil'
                            ]);

                        } else {
                            return json_encode([
                                'status' => 'tidak ada',
                                'msg' => $data['nama']
                            ]);
                        }
                    } catch (\Exception $e) {
                        DB::rollback();
                        return json_encode([
                            'status' => 'gagal',
                            'msg' => $e
                        ]);
                    }

                } else {
                    return json_encode([
                        'status' => 'ditolak'
                    ]);
                }
            }
        } else {
            return view('errors/407');
        }
    }

    public function active($id)
    {
        if (Plasma::checkAkses(47, 'update') == true) {
            DB::beginTransaction();
            try {
                $cek = member::where('m_id', Crypt::decrypt($id))->count();

                if ($cek != 0) {

                    member::where('m_id', Crypt::decrypt($id))->update(['m_status' => 'AKTIF']);

                    DB::commit();

                    $data = member::where('m_id', Crypt::decrypt($id))->select('m_name', 'm_telp')->get();
                    $log = 'Mengubah Status Member ' . $data->m_name . ' (' . $data->m_telp . ') = AKTIF';
                    Plasma::logActivity($log);

                    return json_encode([
                        'status' => 'berhasil'
                    ]);
                } else {
                    return json_encode([
                        'status' => 'tidak ada'
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return json_encode([
                    'status' => 'gagal',
                    'msg' => $e
                ]);
            }
        } else {
            return json_encode([
                'status' => 'ditolak'
            ]);
        }
    }

    public function nonactive($id)
    {
        if (Plasma::checkAkses(47, 'update') == true) {
            DB::beginTransaction();
            try {
                $cek = member::where('m_id', Crypt::decrypt($id))->count();

                if ($cek != 0) {

                    member::where('m_id', Crypt::decrypt($id))->update(['m_status' => 'NONAKTIF']);

                    DB::commit();

                    $data = member::where('m_id', Crypt::decrypt($id))->select('m_name', 'm_telp')->get();
                    $log = 'Mengubah Status Member ' . $data->m_name . ' (' . $data->m_telp . ') = AKTIF';
                    Plasma::logActivity($log);

                    return json_encode([
                        'status' => 'berhasil'
                    ]);
                } else {
                    return json_encode([
                        'status' => 'tidak ada'
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return json_encode([
                    'status' => 'gagal',
                    'msg' => $e
                ]);
            }
        } else {
            return json_encode([
                'status' => 'ditolak'
            ]);
        }
    }

    public function delete($id)
    {
        if (Plasma::checkAkses(47, 'delete')) {
            DB::beginTransaction();
            try {

                member::where('m_id', Crypt::decrypt($id))->delete();

                DB::commit();

                $data = member::where('m_id', Crypt::decrypt($id))->select('m_name', 'm_telp')->get();
                $log = 'Hapus Member ' . $data->m_name . ' (' . $data->m_telp . ')';
                Plasma::logActivity($log);

                return json_encode([
                    'status' => 'berhasil'
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return json_encode([
                    'status' => 'gagal',
                    'msg' => $e
                ]);
            }
        } else {

        }
    }
}
