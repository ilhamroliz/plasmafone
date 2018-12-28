<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController as Plasma;
use App\Model\penjualan\pemesanan_barang as pemesanan;
use Illuminate\Support\Facades\Crypt;

use DataTables;
use DB;
use Session;
use Auth;
use Carbon\Carbon;
use Response;

class pemesananBarangController extends Controller
{
    public function index()
    {
        if (Plasma::checkAkses(18, 'read') == false) {
            return view('errors/407');
        } else {
            $datapemesanan = DB::table('d_indent')
                ->select('i_comp', 'i_member', 'i_nota', 'i_total_tagihan', 'i_total_pembayaran')
                ->first();
            return view('penjualan.pemesanan_barang.index')->with(compact('datapemesanan'));
        }
    }

    public function get_data_proses()
    {
        $proses = pemesanan::where('i_status', 'PROSES')
            ->join('m_member', 'm_id', '=', 'i_member')
            ->select('d_indent.*', 'm_name')
            ->orderBy('i_id', 'desc')->get();
        $proses = collect($proses);

        return DataTables::of($proses)
            ->addColumn('aksi', function ($proses) {
                if (Plasma::checkAkses(18, 'delete') == false) {
                    return '<div class="text-center">
                            <button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($proses->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center">
                            <button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($proses->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;
                            <button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($proses->i_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_data_done()
    {
        $done = pemesanan::where('i_status', 'DONE')
            ->join('m_member', 'm_id', '=', 'i_member')
            ->select('d_indent.*', 'm_name')
            ->orderBy('i_id', 'desc')->get();
        $done = collect($done);

        return DataTables::of($done)
            ->addColumn('aksi', function ($done) {
                if (Plasma::checkAkses(18, 'delete') == false) {
                    return '<div class="text-center">
                            <button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($done->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center">
                            <button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($done->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;
                            <button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($done->i_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_data_cancel()
    {
        $cancel = pemesanan::where('i_status', 'CANCEL')
            ->join('m_member', 'm_id', '=', 'i_member')
            ->select('d_indent.*', 'm_name')
            ->orderBy('i_id', 'desc')->get();
        $cancel = collect($cancel);

        return DataTables::of($cancel)
            ->addColumn('aksi', function ($cancel) {
                if (Plasma::checkAkses(18, 'delete') == false) {
                    return '<div class="text-center">
                            <button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($cancel->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center">
                            <button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Detail" onclick="detail(\'' . Crypt::encrypt($cancel->i_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;
                            <button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($cancel->i_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_detail($id)
    {
        if (Plasma::checkAkses(47, 'read') == false) {

            return view('errors/407');

        } else {

            $id = Crypt::decrypt($id);
            $pemesanan = pemesanan::where('i_id', $id)->first();

            $dataMember = DB::table('m_member')->select('m_name')->where('m_id', $pemesanan->i_member)->first();
            $dataCompany = DB::table('m_company')->select('c_name')->where('c_id', $pemesanan->i_comp)->first();
            // dd($member);
            return response()->json([
                'data' => $pemesanan,
                'dm' => $dataMember->m_name,
                'dc' => $dataCompany->c_name
            ]);
        }
    }

    public function cari_member(Request $request)
    {
        $cari = $request->term;
        $member = DB::select("select m_id, m_name from m_member where m_name like '%" . $cari . "%'");

        if ($member == null) {
            $hasilmember[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($member as $query) {
                $hasilmember[] = [
                    'id' => $query->m_id,
                    'label' => $query->m_name
                ];
            }
        }

        return Response::json($hasilmember);
    }

    public function cari_item(Request $request)
    {
        $cari = $request->term;
        $idItem = [];
        if (isset($request->idItem)) {
            $idItem = $request->idItem;
        } else {
            $idItem[0] = 'a';
        }

        $hasilitem = array();
        $item = DB::table('d_item')
            ->select('i_id', 'i_nama', 'i_price')
            ->whereRaw('i_nama like "%' . $cari . '%"')
            ->whereNotIn('i_id', $idItem)
            ->get();

        if ($item == null) {
            $hasilitem[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($item as $query) {
                $hasilitem[] = [
                    'id' => $query->i_id,
                    'label' => $query->i_nama,
                    'harga' => $query->i_price
                ];
            }
        }

        return Response::json($hasilitem);
    }

    public function tambah_member(Request $request)
    {
        if (Plasma::checkAkses(18, 'insert') == false) {
            return view('errors/407');
        } else {
            if ($request->isMethod('post')) {
                DB::beginTransaction();
                try {
                    DB::table('m_member')->insert([
                        'm_name' => strtoupper($request->namaMember),
                        'm_telp' => $request->noTelp,
                        'm_nik' => $request->noNIK
                    ]);

                    DB::commit();
                    return response()->json([
                        'status' => 'tmSukses'
                    ]);

                } catch (\Exception $e) {

                    DB::rollback();
                    return response()->json([
                        'status' => 'tmGagal',
                        'msg' => $e
                    ]);
                }
            }
        }
        return view('penjualan.pemesanan_barang.tambah');
    }

    public function getDataId()
    {
        $cek = DB::table('d_indent')
            ->select(DB::raw('max(right(i_id, 3)) as id'))
            ->get();

        foreach ($cek as $x) {
            $temp = ((int)$x->id + 1);
            $kode = sprintf("%03s", $temp);
        }

        $date = [];
        $date = explode(' ', Carbon::now('Asia/Jakarta'));
        $tgl = explode('-', $date[0]);

        $tempKode = 'IND-' . $kode . '/' . $tgl[2] . '/' . $tgl[1] . '/' . $tgl[0];
        return $tempKode;
    }

    public function tambah_pemesanan(Request $request)
    {
        if (Plasma::checkAkses(18, 'insert') == false) {
            return view('errors/407');
        } else {

            if ($request->isMethod('post')) {

                DB::beginTransaction();
                try {

                    $idItem = $request->idItem;
                    $qtyItem = $request->qtyItem;
                    $hargaItem = $request->hargaItem;
                    $total = 0;
                    for ($i = 0; $i < count($idItem); $i++) {
                        $total = $total + ($qtyItem[$i] * $hargaItem[$i]);
                    }

                    $hitung = DB::table('d_indent')->count();

                    //== untuk d_indent
                    $i_id = $hitung + 1;
                    $i_comp = Auth::user()->m_comp;
                    $i_member = $request->tpMemberId;
                    $i_nota = $this->getDataId();
                    $i_total_tagihan = $total;
                    $i_total_pembayaran = 0;
                    $i_status = "PROSES";

                    DB::table('d_indent')->insert([
                        'i_id' => $i_id,
                        'i_comp' => $i_comp,
                        'i_member' => $i_member,
                        'i_nota' => $i_nota,
                        'i_total_tagihan' => $i_total_tagihan,
                        'i_total_pembayaran' => $i_total_pembayaran,
                        'i_status' => $i_status
                    ]);

                    //== untuk d_indent_dt
                    for ($i = 0; $i < count($idItem); $i++) {

                        DB::table('d_indent_dt')->insert([
                            'id_indent' => $i_id,
                            'id_detailid' => $i + 1,
                            'id_item' => $idItem[$i],
                            'id_qty' => $qtyItem[$i],
                        ]);
                    }

                    DB::commit();
                    return response()->json([
                        'status' => 'tpSukses'
                    ]);

                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json([
                        'status' => 'tpGagal',
                        'msg' => $e
                    ]);
                }


            }

            return view('penjualan.pemesanan_barang.tambah');
        }
    }

    public function hapus()
    {

    }

}
