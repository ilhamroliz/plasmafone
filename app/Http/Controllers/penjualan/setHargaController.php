<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController as Plasma;
use Illuminate\Support\Facades\Crypt;

use DataTables;
use DB;
use Session;
use Auth;
use Carbon\Carbon;
use Response;

class setHargaController extends Controller
{
    public function index()
    {
        if (Plasma::checkAkses(15, 'read') == false) {
            return view('errors/407');
        } else {
            $group = DB::table('m_group')->select('g_id', 'g_name')->get();
            return view('penjualan.set_harga.index')->with(compact('group'));
        }
    }

    public function get_data_harga($id)
    {
        $gp = DB::table('m_group_price')
            ->join('d_item', 'i_id', '=', 'gp_item')
            ->where('gp_group', $id)
            ->select('m_group_price.*', 'i_nama')
            ->orderBy('i_nama', 'asc')->get();

        $gp = collect($gp);

        return DataTables::of($gp)
            ->addIndexColumn()
            ->addColumn('harga', function ($gp) {
                $pisah = [];
                $pisah = explode('.', $gp->gp_price);
                $harga = $pisah[0];
                return '<div>
                            <span style="float: left" >Rp. </span>
                            <span style="float: right" >' . strrev(implode('.', str_split(strrev(strval($harga)), 3))) . '</span>';
            })
            ->addColumn('aksi', function ($gp) {
                if (Plasma::checkAkses(15, 'update') == true) {
                    return '<div class="text-center">
                                <button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Set Harga" onclick="edit_harga(this)"><i class="glyphicon glyphicon-edit"></i></button>
                                <button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Harga" onclick="hapus_harga(this)"><i class="glyphicon glyphicon-trash"></i></button>                                
                            </div>';
                }
            })
            ->rawColumns(['aksi', 'harga'])
            ->make(true);
    }

    public function get_data_group()
    {
        $group = DB::table('m_group')->get();
        $group = collect($group);

        return DataTables::of($group)
            ->addIndexColumn()
            ->addColumn('group_name', function ($group) {
                return '<a onclick="show(\'' . $group->g_id . '\')"><div>' . $group->g_name . '</div></a>';
            })
            ->rawColumns(['group_name'])
            ->make(true);
    }

    public function get_data_group_nonDT($id)
    {
        $unDT = DB::table('m_group')->where('g_id', $id)->first();
        // dd($unDT);
        return json_encode([
            'id' => $unDT->g_id,
            'name' => strtoupper($unDT->g_name)
        ]);
    }

    public function cari_itemth(Request $request)
    {

        $cari = $request->term;
        $nama = DB::select("select i_id, i_nama from d_item where i_nama like '%" . $cari . "%'");

        if ($nama == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->i_id, 'label' => $query->i_nama];
            }
        }

        return Response::json($results);
    }

    public function tambah_group(Request $request)
    {
        if (Plasma::checkAkses(15, 'insert') == false) {
            return view('errors/407');
        } else {
            if ($request->isMethod('post')) {
                DB::beginTransaction();
                try {
                    DB::table('m_group')->insert([
                        'g_name' => $request->namaGroup
                    ]);

                    DB::commit();
                    Plasma::logActivity('Menambahkan Group ' . $request->namaGroup);
                    return json_encode([
                        'status' => 'sukses'
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return json_encode([
                        'status' => 'gagal',
                        'msg' => $e
                    ]);
                }
            }
        }
    }

    public function tambah_harga(Request $request)
    {
        // dd($request);
        if (Plasma::checkAkses(15, 'insert') == false) {
            return view('errors/407');
        } else {
            if ($request->isMethod('post')) {

                DB::beginTransaction();
                try {

                    $harga = implode(explode('.', $request->thHarga));
                    DB::table('m_group_price')->insert([
                        'gp_group' => $request->thGroupId,
                        'gp_item' => $request->thItemId,
                        'gp_price' => $harga
                    ]);

                    $item = DB::table('d_item')->select('i_nama')->where('i_id', $request->thItemId)->first();
                    $group = DB::table('m_group')->select('g_name')->where('g_id', $request->thGroupId)->first();
                    $log = 'Menambahkan Harga Barang ' . $item->i_nama . ' pada group harga ' . $group->g_name;

                    DB::commit();
                    Plasma::logActivity($log);
                    return json_encode([
                        'status' => 'thBerhasil',
                        'id' => $request->thGroupId,
                        'name' => $request->thItemName
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return json_encode([
                        'status' => 'thGagal',
                        'msg' => $e
                    ]);
                }
            }
        }
    }

    public function edit_group(Request $request)
    {
        if (Plasma::checkAkses(15, 'update') == false) {
            return view('errors/407');
        } else {
            if ($request->isMethod('post')) {
                // dd($request);
                $id = $request->egId;
                DB::beginTransaction();
                try {

                    $getNama = DB::table('m_group')->select('g_name')->where('g_id', $id)->first();
                    $oldName = $getNama->g_name;

                    DB::table('m_group')->where('g_id', $id)->update([
                        'g_name' => $request->egNama
                    ]);

                    DB::commit();

                    $log = 'Mengubah Nama Group dari ' . $oldName . ' menjadi ' . $request->egNama;

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

            }

        }
    }

    public function edit_harga(Request $request)
    {
        if (Plasma::checkAkses(15, 'update') == false) {
            return view('errors/407');
        } else {
            if ($request->isMethod('post')) {
                // dd($request);
                $id = $request->egId;
                DB::beginTransaction();
                try {

                    $getNama = DB::table('m_group')->select('g_name')->where('g_id', $id)->first();
                    $oldName = $getNama->g_name;

                    DB::table('m_group')->where('g_id', $id)->update([
                        'g_name' => $request->egNama
                    ]);

                    DB::commit();

                    $log = 'Mengubah Nama Group dari ' . $oldName . ' menjadi ' . $request->egNama;

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

            }

        }
    }

    public function hapus_group($id)
    {
        if (Plasma::checkAkses(15, 'delete') == false) {
            return view('errors/407');
        } else {

            $cek = DB::table('m_member')->where('m_jenis', $id)->count();

            if ($cek != 0) {
                return json_encode([
                    'status' => 'hgDigunakan'
                ]);
            } else {

                DB::beginTransaction();
                try {
                    $get = DB::table('m_group')->select('g_name')->where('g_id', $id)->first();
                    $egNama = $get->g_name;
                    $log = 'Menghapus Group ' . $get->g_name;

                    DB::table('m_group')->where('g_id', $id)->delete();
                    DB::commit();

                    Plasma::logActivity($log);
                    return json_encode([
                        'status' => 'hgBerhasil',
                        'name' => $egNama
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();

                    return json_encode([
                        'status' => 'hgGagal',
                        'msg' => $e
                    ]);
                }
            }
        }
    }

    public function hapus_harga(Request $request, $id)
    {

    }

    public function edit(Request $request, $id = null)
    {
        // dd($id);
        if (Plasma::checkAkses(15, 'update') == false) {

            return json_encode([
                'status' => 'ditolak'
            ]);

        } else {

            // $id = Crypt::decrypt($id);
            if ($request->isMethod('post')) {

                if (Plasma::checkAkses(15, 'update') == false) {

                    return json_encode([
                        'status' => 'ditolak'
                    ]);

                } else {

                    $data = $request->all();
                    DB::beginTransaction();

                    try {

                        $now = Carbon::now('Asia/Jakarta');
                        $harga = implode("", explode(".", $data['harga']));
                        // $dd($harga);
                        if ($data['tipe'] == '1') {
                            Item::where('i_id', $id)->update([
                                'i_price_1' => $harga,
                                'updated_at' => $now
                            ]);
                        } else if ($data['tipe'] == '2') {
                            Item::where('i_id', $id)->update([
                                'i_price_2' => $harga,
                                'updated_at' => $now
                            ]);
                        } else if ($data['tipe'] == '3') {
                            Item::where('i_id', $id)->update([
                                'i_price_3' => $harga,
                                'updated_at' => $now
                            ]);
                        } else if ($data['tipe'] == '4') {
                            Item::where('i_id', $id)->update([
                                'i_price_4' => $harga,
                                'updated_at' => $now
                            ]);
                        }

                        DB::commit();

                        return json_encode([
                            'status' => 'setberhasil'
                        ]);

                    } catch (\Exception $e) {

                        DB::rollback();
                        return json_encode([
                            'status' => 'gagal',
                            'msg' => $e
                        ]);
                    }

                }
            }

            $item = Item::where(['i_id' => $id])->first();
            return response()->json([
                'status' => 'OK',
                'data' => $item
            ]);
        }
    }
}
