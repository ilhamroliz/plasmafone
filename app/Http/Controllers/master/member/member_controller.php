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
        $all = member::orderBy('m_insert', 'desc');

        return DataTables::of($all)
            ->addColumn('active', function ($all) {

                if ($all->m_status == "AKTIF") {
                    return '<span class="label label-success">AKTIF</span>';
                } else {
                    return '<span class="label label-danger">NON AKTIF</span>';
                }

            })
            ->addColumn('aksi', function ($all) {

                $checkindent = DB::table('d_indent')
                    ->where('i_member', $all->m_id)
                    ->count();

                $checksales = DB::table('d_sales')
                    ->where('s_member', $all->m_id)
                    ->count();

                $nonactive = '';
                if ($checkindent == 0 && $checksales == 0) {
                    $nonactive = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . Crypt::encrypt($all->m_nik) . '\', \'' . $all->m_name . '\')"><i class="glyphicon glyphicon-remove"></i></button>';
                }

                if ($all->m_status == "AKTIF") {
                    if (Plasma::checkAkses(47, 'update') == true) {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($all->m_nik) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($all->m_nik) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' . $nonactive . '</div>';
                    } else {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($all->m_nik) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    }
                } else {
                    if (Plasma::checkAkses(47, 'update') == true) {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($all->m_nik) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($all->m_nik) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Aktifkan" onclick="statusactive(\'' . Crypt::encrypt($all->m_nik) . '\', \'' . $all->m_name . '\')"><i class="glyphicon glyphicon-check"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="hapus(\'' . Crypt::encrypt($all->m_nik) . '\', \'' . $all->m_name . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                    } else {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($all->m_nik) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    }
                }
            })
            ->rawColumns(['aksi', 'active'])
            ->make(true);
    }

    public function get_data_active()
    {
        $active = member::where('m_status', 'AKTIF')->orderBy('m_insert', 'desc');

        return DataTables::of($active)
            ->addColumn('aksi', function ($active) {
                $checkindent = DB::table('d_indent')
                    ->where('i_member', $active->m_id)
                    ->count();

                $checksales = DB::table('d_sales')
                    ->where('s_member', $active->m_id)
                    ->count();

                $nonactive = '';
                if ($checkindent == 0 && $checksales == 0) {
                    $nonactive = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . Crypt::encrypt($active->m_nik) . '\', \'' . $active->m_name . '\')"><i class="glyphicon glyphicon-remove"></i></button>';
                }
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($active->m_nik) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($active->m_nik) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($active->m_nik) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' . $nonactive . '</div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_data_nonactive()
    {
        $nonactive = member::where('m_status', 'NONAKTIF')->orderBy('m_insert', 'desc');

        return DataTables::of($nonactive)
            ->addColumn('aksi', function ($nonactive) {

                if (Plasma::checkAkses(47, 'update') == true) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($nonactive->m_nik) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" onClick="edit(\'' . Crypt::encrypt($nonactive->m_nik) . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Aktifkan" onclick="statusactive(\'' . Crypt::encrypt($nonactive->m_nik) . '\', \'' . $nonactive->m_name . '\')"><i class="glyphicon glyphicon-check"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="hapus(\'' . Crypt::encrypt($nonactive->m_nik) . '\', \'' . $nonactive->m_name . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle edit" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($nonactive->m_nik) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function detail($id)
    {
        if (Plasma::checkAkses(47, 'read') == false) {

            return json_encode([
                'status' => 'ditolak'
            ]);

        } else {

            $id = Crypt::decrypt($id);
            $member = member::where('m_nik', $id)->first();

            $groupMember = '';
            if ($member->m_jenis != null) {
                $dataGroup = DB::table('m_group')->select('g_name')->where('g_id', $member->m_jenis)->first();
                $groupMember = $dataGroup->g_name;
            } else {
                $groupMember = 'DEFAULT';
            }
            return response()->json([
                'status' => 'ok',
                'data' => $member,
                'jm' => $groupMember
            ]);
        }
    }

    public function getDataId()
    {
        $cek = DB::table('m_member')
            ->select(DB::raw('MID(m_idmember, 4, 7) as id'))
            ->orderBy('id')->first();

        $temp = intval($cek->id) + 1;
        $kode = sprintf("%07s", $temp);

        $tempKode = 'MPF' . $kode;
        // dd($tempKode);
        return $tempKode;
    }

    public function simpan_tambah(Request $request)
    {

        $provinsi = DB::table('m_wil_provinsi')
            ->orderBy('wp_name')
            ->get();

        if (Plasma::checkAkses(47, 'insert') == false) {
            return view('errors/407');
        } else {

            if ($request->isMethod('post')) {

                if (Plasma::checkAkses(47, 'insert') == false) {

                    return view('errors.407');

                } else {
                    $data = $request->all();
                    DB::beginTransaction();

                    try {

                        $checknik = member::where('m_nik', '=', $data['nik'])->where('m_status', 'AKTIF')->count();

                        if ($checknik > 0) {

                            return json_encode([
                                'status' => 'nikada',
                                'name' => $data['nik']
                            ]);

                        } else {

                            $checktelp = member::where('m_telp', '=', $data['telp'])->where('m_status', 'AKTIF')->count();

                            if ($checktelp > 0) {

                                return json_encode([
                                    'status' => 'telpada',
                                    'name' => $data['telp']
                                ]);

                            } else {

                                $finalkode = $this->getDataId();

                                if ($data['checklist'] != "") {
                                    $member = $finalkode;
                                } else {
                                    $member = $data['idmember'];
                                }

                                if ($data['email'] == "") {
                                    $email = "";
                                } else {
                                    $email = $data['email'];
                                }

                                if ($data['tanggal'] == null) {
                                    $tanggal = "00";
                                } else {
                                    $tanggal = $data['tanggal'];
                                }

                                if ($data['bulan'] == null) {
                                    $bulan = "00";
                                } else {
                                    $bulan = $data['bulan'];
                                }

                                if ($data['tahun'] == null) {
                                    $tahun = "0000";
                                } else {
                                    $tahun = $data['tahun'];
                                }

                                if ($data['tipe'] == "") {
                                    $tipe = "DEFAULT";
                                } else {
                                    $tipe = $data['tipe'];
                                }

                                if ($data['hassaldo'] == "") {
                                    $hassaldo = "N";
                                } else {
                                    $hassaldo = $data['hassaldo'];
                                }
                                // dd("oke");

                                member::insert([
                                    'm_name' => strtoupper($data['name']),
                                    'm_nik' => $data['nik'],
                                    'm_idmember' => $member,
                                    'm_telp' => $data['telp'],
                                    'm_email' => $email,
                                    'm_jenis' => $tipe,
                                    'm_hassaldo' => $hassaldo,
                                    'm_address' => $data['address'],
                                    'm_birth' => $tahun . '-' . $bulan . '-' . $tanggal,
                                    'm_provinsi' => $data['provinsi'],
                                    'm_kota' => $data['kota'],
                                    'm_kecamatan' => $data['kecamatan'],
                                    'm_desa' => $data['desa'],
                                    'm_status' => 'AKTIF',
                                    'm_insert' => Carbon::now('Asia/Jakarta'),
                                    'm_update' => Carbon::now('Asia/Jakarta')
                                ]);

                                DB::commit();
                                Plasma::logActivity('Menambahkan Member ' . strtoupper($data['name'] . ' (' . $data['telp'] . ')'));

                                return json_encode([
                                    'status' => 'berhasil',
                                    'name' => strtoupper($data['name'])
                                ]);

                            }
                        }
                    } catch (\Exception $e) {

                        DB::rollback();

                        // something went wrong
                        return json_encode([
                            'status' => 'gagal',
                            'msg' => $e
                        ]);

                    }
                }
            }
            $getJM = DB::table('m_group')->select('g_id', 'g_name')->get();
            return view('master.member.add')->with(compact('provinsi', 'getJM'));
        }
    }

    public function simpan_edit(Request $request, $id = null)
    {

        if (Plasma::checkAkses(47, 'update') == false) {

            return view('errors/407');

        } else {

            if ($request->isMethod('post')) {
                if (Plasma::checkAkses(47, 'update') == false) {

                    return json_encode([
                        'status' => 'ditolak'
                    ]);

                } else {
                    // dd($request);

                    $data = $request->all();
                    DB::beginTransaction();

                    try {

                        $check = member::where('m_nik', $data['nik'])->count();

                        if ($check == 0) {

                            return json_encode([
                                'status' => 'tidak ada',
                                'name' => $data['name'] . ' (' . $data['telp'] . ')'
                            ]);

                        } else {

                            if ($data['email'] == "") {
                                $email = "";
                            } else {
                                $email = $data['email'];
                            }

                            if ($data['tanggal'] == null) {
                                $tanggal = "00";
                            } else {
                                $tanggal = $data['tanggal'];
                            }

                            if ($data['bulan'] == null) {
                                $bulan = "00";
                            } else {
                                $bulan = $data['bulan'];
                            }

                            if ($data['tahun'] == null) {
                                $tahun = "0000";
                            } else {
                                $tahun = $data['tahun'];
                            }

                            if ($data['tipe'] == "") {
                                $tipe = "DEFAULT";
                            } else {
                                $tipe = $data['tipe'];
                            }

                            member::where('m_nik', $data['nik'])->update([
                                'm_name' => strtoupper($data['name']),
                                'm_telp' => $data['telp'],
                                'm_email' => $email,
                                'm_address' => $data['address'],
                                'm_provinsi' => $data['provinsi'],
                                'm_kota' => $data['kota'],
                                'm_kecamatan' => $data['kecamatan'],
                                'm_desa' => $data['desa'],
                                'm_birth' => $tahun . '-' . $bulan . '-' . $tanggal,
                                'm_jenis' => $request->tipe,
                                'm_update' => Carbon::now('Asia/Jakarta')
                            ]);

                            DB::commit();
                            Plasma::logActivity('Edit Data Member ' . strtoupper($data['name']) . ' (' . $data['telp'] . ')');

                            return json_encode([
                                'status' => 'berhasil',
                                'name' => $data['name'] . ' (' . $data['telp'] . ')'
                            ]);
                        }

                    } catch (\Exception $e) {

                        DB::rollback();
                        return json_encode([
                            'status' => 'gagal',
                            'msg' => $e
                        ]);

                    }
                }
            }

            // ======================Method Get================================
            DB::beginTransaction();

            try {
                $id = Crypt::decrypt($id);
                // dd($id);
                $check = member::where('m_nik', $id)->count();

                if ($check > 0) {

                    $member = member::where('m_nik', $id)->get();
                    $provinsi = DB::table('m_wil_provinsi')
                        ->orderBy('wp_name')
                        ->get();

                    $desa = DB::table('m_wil_desa')
                        ->where('wd_kecamatan', $member[0]->m_kecamatan)
                        ->orderBy('wd_name')
                        ->get();

                    $kecamatan = DB::table('m_wil_kecamatan')
                        ->where('wk_kota', $member[0]->m_kota)
                        ->orderBy('wk_name')
                        ->get();

                    $kota = DB::table('m_wil_kota')
                        ->where('wc_provinsi', $member[0]->m_provinsi)
                        ->orderBy('wc_name')
                        ->get();

                    $date = member::where('m_nik', $id)->select('m_birth')->first();
                    $tgl = [];
                    $tgl = explode('-', $date->m_birth);
                    $day = $tgl[2];
                    $month = $tgl[1];
                    $year = $tgl[0];

                    $getJM = DB::table('m_group')->select('g_id', 'g_name')->get();

                    // dd($year);
                    DB::commit();

                    return view('master.member.edit')->with(compact('provinsi', 'desa', 'kota', 'kecamatan', 'member', 'day', 'month', 'year', 'getJM'));

                } else {

                    return redirect()->back()->with('flash_message_error', 'Data yang anda edit tidak ada didalam basis data...! Mulai ulang halaman');

                }

            } catch (\Exception $e) {

                DB::rollback();
                return redirect()->back()->with('flash_message_error', 'Ada yang tidak beres...! Mohon coba lagi');

            }
        }
    }

    public function active($id)
    {
        if (Plasma::checkAkses(47, 'update') == true) {
            DB::beginTransaction();
            try {
                $cek = member::where('m_nik', Crypt::decrypt($id))->count();

                if ($cek != 0) {

                    member::where('m_nik', Crypt::decrypt($id))->update(['m_status' => 'AKTIF']);

                    DB::commit();

                    $data = member::where('m_nik', Crypt::decrypt($id))->select('m_name', 'm_telp')->first();
                    $log = 'Mengubah Status Member ' . $data->m_name . ' (' . $data->m_telp . ') = AKTIF';
                    Plasma::logActivity($log);

                    return json_encode([
                        'status' => 'aktifberhasil',
                        'name' => $data->m_name
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
                $cek = member::where('m_nik', Crypt::decrypt($id))->count();

                if ($cek != 0) {

                    member::where('m_nik', Crypt::decrypt($id))->update(['m_status' => 'NONAKTIF']);

                    DB::commit();

                    $data = member::where('m_nik', Crypt::decrypt($id))->select('m_name', 'm_telp')->first();
                    $log = 'Mengubah Status Member ' . $data->m_name . ' (' . $data->m_telp . ') = NONAKTIF';
                    Plasma::logActivity($log);

                    return json_encode([
                        'status' => 'nonaktifberhasil',
                        'name' => $data->m_name
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
        if (Plasma::checkAkses(47, 'delete') == false) {

            return json_encode([
                'status' => 'ditolak'
            ]);

        } else {

            DB::beginTransaction();

            try {
                $id = Crypt::decrypt($id);
                $check = member::where('m_nik', $id)->count();

                if ($check == 0) {

                    return json_encode([
                        'status' => 'tidak ada'
                    ]);

                } else {

                    $mNama = member::select('m_name', 'm_telp')->where('m_nik', $id)->first();
                    $nama = $mNama->m_name;
                    $log = 'Menghapus Data Member ' . $mNama->m_name . ' (' . $mNama->m_name . ')';

                    member::where('m_nik', $id)->delete();

                    DB::commit();

                    Plasma::logActivity($log);

                    return json_encode([
                        'status' => 'hapusberhasil',
                        'name' => $nama
                    ]);
                }
            } catch (\Exception $e) {

                DB::rollback();

                // something went wrong
                return json_encode([
                    'status' => 'gagal',
                    'msg' => $e
                ]);
            }
        }
    }

    public function getkota(Request $request)
    {
        $kota = DB::table('m_wil_kota')
            ->where('wc_provinsi', $request->provinsi)
            ->orderBy('wc_name')
            ->get();

        return response()->json($kota);
    }

    public function getkecamatan(Request $request)
    {
        $kecamatan = DB::table('m_wil_kecamatan')
            ->where('wk_kota', $request->kota)
            ->orderBy('wk_name')
            ->get();

        return response()->json($kecamatan);
    }

    public function getdesa(Request $request)
    {
        $desa = DB::table('m_wil_desa')
            ->where('wd_kecamatan', $request->kecamatan)
            ->orderBy('wd_name')
            ->get();

        return response()->json($desa);
    }
}
