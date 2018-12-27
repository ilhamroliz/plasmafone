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
        $proses = pemesanan::where('i_status', 'PROSES')->orderBy('i_id', 'desc')->get();
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
        $done = pemesanan::where('i_status', 'DONE')->orderBy('i_id', 'desc')->get();
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
        $cancel = pemesanan::where('i_status', 'CANCEL')->orderBy('i_id', 'desc')->get();
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
                $hasilmember[] = ['id' => $query->m_id, 'label' => $query->m_name];
            }
        }

        return Response::json($hasilmember);
    }

    public function cari_item(Request $request)
    {
        $cari = $request->term;
        $item = DB::select("select i_id, i_nama from d_item where i_nama like '%" . $cari . "%'");

        if ($item == null) {
            $hasilitem[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($item as $query) {
                $hasilitem[] = ['id' => $query->i_id, 'label' => $query->i_nama];
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
                DB::beginTransavtion();
                try {

                } catch (\Exception $e) {

                }
            }
        }
        return view('penjualan.pemesanan_barang.tambah');
    }

    public function ft_pemesanan(Request $request)
    {
        if (Plasma::checkAkses(18, 'insert') == false) {
            return view('errors/407');
        } else {
            if ($request->isMethod('post')) {

            }
        }
    }

    public function tambah_pemesanan(Request $request)
    {
        if (Plasma::checkAkses(18, 'insert') == false) {
            return view('errors/407');
        } else {
            if ($request->isMethod('post')) {

            }
        }
    }

    public function hapus()
    {

    }

    public function temp_tambah_data(Request $request)
    {
        $comp = Auth::user()->m_id;
        $item = $request->input('itemId');
        $qty = $request->input('jumlah');
        $status = 'DUMY';

        $count = DB::table('d_indent')->count();
        $idIndent = $count + 1;

        $countDetil = DB::table('d_indent_dt')->where('id_indent', $idIndent)->count();
        $idDetilId = $countDetail + 1;

        $insert = DB::table('d_indent_dt')
            ->insert([
                'id_indent' => $idIndent,
                'id_detailid' => $idIndentId,
                'id_item' => $item,
                'id_qty' => $qty,
                'id_note' => $request->note
            ]);

        if ($insert) {
            $status = "SUKSES";
        } else {
            $status = "GAGAL";
        }

        echo json_encode(array("data" => $status));
    }
}
