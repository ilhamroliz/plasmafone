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
            ->join('m_group', 'g_id', '=', 'gp_group')
            ->where('gp_group', $id)
            ->select('m_group_price.*', 'i_nama', 'g_name')
            ->orderBy('i_nama', 'asc')->get();

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
                                <button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Set Harga" onclick="edit_harga(\'' . Crypt::encrypt($gp->gp_item) . '\')"><i class="glyphicon glyphicon-edit"></i></button>
                                <button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Harga" onclick="hapus_harga(\'' . Crypt::encrypt($gp->gp_item) . '\')"><i class="glyphicon glyphicon-trash"></i></button>                                
                            </div>';
                }
            })
            ->rawColumns(['aksi', 'harga'])
            ->make(true);
    }

    public function get_data_group()
    {
        $group = DB::table('m_group')->orderBy('g_name', 'asc')->get();
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
            'name' => $unDT->g_name
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

                $cekAda = DB::table('m_group')->where('g_name', $request->namaGroup)->count();

                if ($cekAda != 0) {
                    return json_encode([
                        'status' => 'tgAda',
                        'name' => $request->namaGroup
                    ]);
                } else {
                    DB::beginTransaction();
                    try {
                        DB::table('m_group')->insert([
                            'g_name' => strtoupper($request->namaGroup)
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
    }

    public function tambah_harga(Request $request)
    {
        // dd($request);
        if (Plasma::checkAkses(15, 'insert') == false) {
            return view('errors/407');
        } else {
            if ($request->isMethod('post')) {

                $cekAda = DB::table('m_group_price')
                    ->where('gp_item', $request->thItemId)
                    ->where('gp_group', $request->thGroupId)->count();

                if ($cekAda != 0) {
                    return json_encode([
                        'status' => 'thAda',
                        'name' => $request->thItemNama
                    ]);
                } else {
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
                            'name' => $request->thItemNama
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
                        'g_name' => strtoupper($request->egNama)
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
                $ItemId = Crypt::decrypt($request->ehItemId);
                $GroupId = $request->ehGroupId;
                DB::beginTransaction();
                try {

                    // $getGroup = DB::table('m_group')->select('g_name')->where('g_id', $GroupId)->first();
                    // $GroupName = $getGroup->g_name;
                    // $getItem = DB::table('d_item')->select('i_nama')->where('i_id', $ItemId)->first();
                    // $ItemName = $getItem->i_nama;

                    DB::table('m_group_price')
                        ->where('gp_group', $GroupId)
                        ->where('gp_item', $ItemId)
                        ->update([
                            'gp_price' => implode(explode('.', $request->ehHarga))
                        ]);

                    DB::commit();

                    $log = 'Mengubah Harga Item ' . $request->ehItemNama . ' pada grup ' . $request->GroupNama;

                    Plasma::logActivity($log);

                    return json_encode([
                        'status' => 'ehBerhasil',
                        'item' => $request->ehItemNama,
                        'id' => $GroupId
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();

                    return json_encode([
                        'status' => 'ehGagal',
                        'msg' => $e
                    ]);
                }

            }

            $dataEdit = DB::table('m_group_price')
                ->join('d_item', 'i_id', '=', 'gp_item')
                ->join('m_group', 'g_id', '=', 'gp_group')
                ->where('gp_item', Crypt::decrypt($request->id))
                ->where('gp_group', $request->g)
                ->select('gp_price', 'i_nama', 'g_name')
                ->first();

            return json_encode([
                'fields' => $dataEdit,
                'price' => round($dataEdit->gp_price, 0)
            ]);
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

    public function hapus_harga(Request $request)
    {
        if (Plasma::checkAkses(15, 'delete') == false) {
            return view('errors/407');
        } else {

            $ItemId = Crypt::decrypt($request->item);
            $GroupId = $request->group;

            DB::beginTransaction();
            try {
                $get1 = DB::table('m_group')->select('g_name')->where('g_id', $GroupId)->first();
                $GroupNama = $get1->g_name;

                $get2 = DB::table('d_item')->select('i_nama')->where('i_id', $ItemId)->first();
                $ItemNama = $get2->i_nama;

                $log = 'Menghapus harga Item ' . $ItemNama . ' pada Group ' . $GroupNama;

                DB::table('m_group_price')
                    ->where('gp_item', $ItemId)
                    ->where('gp_group', $GroupId)->delete();

                DB::commit();

                Plasma::logActivity($log);
                return json_encode([
                    'status' => 'hhBerhasil',
                    'item' => $ItemNama,
                    'group' => $GroupNama
                ]);
            } catch (\Exception $e) {
                DB::rollback();

                return json_encode([
                    'status' => 'hhGagal',
                    'msg' => $e
                ]);
            }
        }
    }
}
