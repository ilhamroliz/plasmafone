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

    public function index_outlet()
    {
        if (Plasma::checkAkses(15, 'read') == false) {
            return view('errors/407');
        } else {
            return view('penjualan.set_harga.outlet');
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

    public function cari_code_n_item(Request $request)
    {
        $term = $request->term;

        $select = DB::table('d_item')
            ->leftjoin('d_purchase_dt', 'pd_item', '=', 'i_id')
            ->select('i_id', 'i_nama', 'i_code', 'pd_value')
            ->whereRaw('i_nama like "%' . $term . '%"')
            ->orWhereRaw('concat(coalesce(i_code, ""), " ", coalesce(i_nama, "")) like "%' . $term . '%"')
            ->take(50)->get();

        if ($select == null) {
            $results[] = ['id' => null, 'label' => ' Tidak ditemukan data terkait '];
        } else {
            foreach ($select as $query) {
                if ($query->i_code == null || $query->i_code == '' && $query->pd_value == null) {
                    $results[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_nama,
                        'hpp' => '0'
                    ];
                } else if ($query->i_code == null || $query->i_code == '' && $query->pd_value != null) {
                    $results[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_nama,
                        'hpp' => $query->pd_value
                    ];
                } else if ($query->pd_value == null) {
                    $results[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_code . ' - ' . $query->i_nama,
                        'hpp' => '0'
                    ];
                } else {
                    $results[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_code . ' - ' . $query->i_nama,
                        'hpp' => $query->pd_value
                    ];
                }
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
                        $ng = strtoupper($request->namaGroup);
                        DB::table('m_group')->insert([
                            'g_name' => $ng
                        ]);

                        DB::commit();
                        Plasma::logActivity('Menambahkan Group ' . $ng);
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

    public function add_price_outlet(Request $request)
    {
        if (Plasma::checkAkses(15, 'insert') == false) {
            return view('errors.407');
        } else {
            if ($request->isMethod('post')) {

                DB::beginTransaction();
                try {

                    $shoItemId = $request->shoShowId;
                    $shoCompId = $request->shoCompId;
                    $shoCompPrice = $request->shoCompPrice;

                    $aray = array();

                    for ($i = 0; $i < count($shoCompId); $i++) {
                        if (strpos($shoCompPrice[$i], '.')) {
                            $shoCompPrice[$i] = implode(explode('.', $shoCompPrice[$i]));
                        }
                        $field = array(
                            'op_outlet' => $shoCompId[$i],
                            'op_item' => $shoItemId,
                            'op_price' => $shoCompPrice[$i]
                        );
                        array_push($aray, $field);
                    }

                    DB::table('d_outlet_price')->where('op_item', $shoItemId)->delete();

                    DB::table('d_outlet_price')->insert($aray);

                    $item = DB::table('d_item')->select('i_nama')->where('i_id', $shoItemId)->first();
                    $outlet = DB::table('m_company')->select('c_name')->where('c_id', $shoCompId)->first();
                    $log = 'Meperbarui Harga Barang ' . $item->i_nama . ' pada Outlet ' . $outlet->c_name;
                    DB::commit();
                    Plasma::logActivity($log);
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


            $id = $request->id;
            /// == Cek APAKAH Data Outlet untuk item yang dipilih sudah ada pada tabel d_outlet
            /// jika belum ada, maka dilakukan insert data untuk outlet pada item yang dipilih
            $outlet = '';
            $comp = '';
            if(Auth::user()->m_comp == "PF00000001"){
                $outlet = DB::table('m_company')->select('c_id')->get(); // id outlet 1, 2, ....
            }else{
                $outlet = DB::table('m_company')->where('c_id', Auth::user()->m_comp)->select('c_id')->get(); // id outlet 1, 2, ....
            }

            for ($i = 0; $i < count($outlet); $i++) {
                $cekin = DB::table('d_outlet_price')->where('op_outlet', $outlet[$i]->c_id)->where('op_item', $id)->count();
                if ($cekin == 0) {
                    DB::table('d_outlet_price')->insert([
                        'op_outlet' => $outlet[$i]->c_id,
                        'op_item' => $id,
                        'op_price' => 0
                    ]);
                }
            }
            ////////////////////////////////////////////////////////

            if(Auth::user()->m_comp == "PF00000001"){
                $comp = DB::table('m_company')
                    ->leftjoin('d_outlet_price', 'op_outlet', '=', 'c_id')
                    ->where('op_item', $id)
                    ->select('c_id', 'c_name', 'op_price')->get();
            }else{
                $comp = DB::table('m_company')
                    ->leftjoin('d_outlet_price', 'op_outlet', '=', 'c_id')
                    ->where('op_item', $id)
                    ->where('c_id', Auth::user()->m_comp)
                    ->select('c_id', 'c_name', 'op_price')->get();
            }

            $getHPP = DB::table('d_stock')
                ->join('d_stock_mutation', 'sm_stock', '=', 's_id')
                ->where('s_item', $id)
                ->select('sm_hpp')
                ->orderBy('sm_detailid', 'desc')
                ->first();

            return json_encode([
                'data' => $comp,
                'hpp' => $getHPP
            ]);
        }
    }

    public function edit_group(Request $request)
    {
        if (Plasma::checkAkses(15, 'update') == false) {
            return view('errors / 407');
        } else {
            if ($request->isMethod('post')) {
                // dd($request);
                $id = $request->egId;
                DB::beginTransaction();
                try {

                    $getNama = DB::table('m_group')->select('g_name')->where('g_id', $id)->first();
                    $oldName = $getNama->g_name;
                    $newName = strtoupper($request->egNama);

                    DB::table('m_group')->where('g_id', $id)->update([
                        'g_name' => $newName
                    ]);

                    DB::commit();

                    $log = 'Mengubah Nama Group dari ' . $oldName . ' menjadi ' . $newName;

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

                    // $getGroup = DB::table(' m_group ')->select(' g_name ')->where(' g_id ', $GroupId)->first();
                    // $GroupName = $getGroup->g_name;
                    // $getItem = DB::table(' d_item ')->select(' i_nama ')->where(' i_id ', $ItemId)->first();
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
