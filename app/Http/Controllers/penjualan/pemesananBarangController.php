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
                ->select('i_comp', 'i_member', 'i_nota')
                ->get();
            return view('penjualan.pemesanan_barang.index')->with(compact('datapemesanan'));
        }
    }

    public function get_data_proses()
    {
        $company = Auth::user()->m_comp;
        $proses = '';
        if ($company != "PF00000001") {
            $proses = pemesanan::where('d_indent.i_status', 'PROSES')
                ->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                ->join('d_item', 'd_item.i_id', '=', 'id_item')
                ->select('d_indent.i_id', 'd_indent.i_nota', 'c_name', 'd_item.i_nama', 'm_member.m_name', DB::raw('d_mem.m_name as sales'), DB::raw('SUM(id_qty) as qty'))
                ->where('d_indent.i_comp', $company)
                ->where('id_status', 'P')
                ->groupBy('id_item')
                ->orderBy('i_nama', 'asc');

        } else {
            $proses = pemesanan::where('d_indent.i_status', 'PROSES')
                ->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                ->join('d_item', 'd_item.i_id', '=', 'id_item')
                ->select('d_indent.i_id', 'd_indent.i_nota', 'c_name', 'd_item.i_nama', 'm_member.m_name', DB::raw('d_mem.m_name as sales'), DB::raw('SUM(id_qty) as qty'))
                ->where('id_status', 'P')
                ->groupBy('id_item')
                ->orderBy('i_nama', 'asc');
        }

        return DataTables::of($proses)
            ->addColumn('aksi', function ($proses) {
                if (Plasma::checkAkses(18, 'delete') == false) {
                    return '<div class="text-center"></div>';
                } else {
                    return '<div class="text-center">
                            <button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' . Crypt::encrypt($proses->i_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function get_history(Request $request)
    {
        // dd($request);
        $company = Auth::user()->m_comp;
        $history = '';

        $tglAw = $request->tglAwal;
        $tglAkh = $request->tglAkhir;
        $nota = $request->nota;
        $idMember = $request->idMember;

        if($tglAw != null && $tglAkh != null){
            $taw = explode('/', $tglAw);
            $tglAwal = $taw[2].'-'.$taw[1].'-'.$taw[0];
            $tak = explode('/', $tglAkh);
            $tglAkhir = $tak[2].'-'.$tak[1].'-'.$tak[0];

            // dd($tglAwal);

            if($company != "PF00000001"){
                if($nota != null && $idMember == null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_comp', $company)
                        ->where('d_indent.i_date', '<=', $tglAkhir)
                        ->where('d_indent.i_date', '>=', $tglAwal)
                        ->where('d_indent.i_nota', $nota)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else if($nota == null && $idMember != null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_comp', $company)
                        ->where('d_indent.i_date', '<=', $tglAkhir)
                        ->where('d_indent.i_date', '>=', $tglAwal)
                        ->where('d_indent.i_member', $idMember)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else if($nota != null && $idMember != null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_comp', $company)
                        ->where('d_indent.i_date', '<=', $tglAkhir)
                        ->where('d_indent.i_date', '>=', $tglAwal)
                        ->where('d_indent.i_member', $idMember)
                        ->where('d_indent.i_nota', $nota)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else{
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_comp', $company)
                        ->where('d_indent.i_date', '<=', $tglAkhir)
                        ->where('d_indent.i_date', '>=', $tglAwal)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }
            }else{
                if($nota != null && $idMember == null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_date', '<=', $tglAkhir)
                        ->where('d_indent.i_date', '>=', $tglAwal)
                        ->where('d_indent.i_nota', $nota)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else if($nota == null && $idMember != null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_date', '<=', $tglAkhir)
                        ->where('d_indent.i_date', '>=', $tglAwal)
                        ->where('d_indent.i_member', $idMember)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else if($nota != null && $idMember != null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_date', '<=', $tglAkhir)
                        ->where('d_indent.i_date', '>=', $tglAwal)
                        ->where('d_indent.i_member', $idMember)
                        ->where('d_indent.i_nota', $nota)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else{
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_date', '<=', $tglAkhir)
                        ->where('d_indent.i_date', '>=', $tglAwal)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }
            }
        
        }else{

            if($company != "PF00000001"){
                if($nota != null && $idMember == null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_comp', $company)
                        ->where('d_indent.i_nota', $nota)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else if($nota == null && $idMember != null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_comp', $company)
                        ->where('d_indent.i_member', $idMember)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else if($nota != null && $idMember != null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_comp', $company)
                        ->where('d_indent.i_member', $idMember)
                        ->where('d_indent.i_nota', $nota)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else{
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_comp', $company)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }
            }else{
                if($nota != null && $idMember == null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_nota', $nota)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else if($nota == null && $idMember != null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_member', $idMember)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else if($nota != null && $idMember != null){
                    $history = DB::table('d_indent')->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')
                        
                        ->where('d_indent.i_member', $idMember)
                        ->where('d_indent.i_nota', $nota)

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }else{
                    $history = DB::table('d_indent')
                        ->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
                        ->join('m_member', 'm_member.m_id', '=', 'd_indent.i_member')
                        ->join('m_company', 'c_id', '=', 'd_indent.i_comp')
                        ->join('d_mem', 'd_mem.m_id', '=', 'd_indent.i_sales')

                        ->select('d_indent.i_status', 'd_indent.i_id', 'd_indent.i_nota', 'd_indent.i_status', 'c_name', 'm_member.m_name', DB::raw('d_mem.m_name as sales'))
                        ->groupBy('d_indent.i_nota')
                        ->orderBy('d_indent.i_id', 'desc')->get();
                }
            }
            
        }

        // dd($history);
        return json_encode([
            'data' => $history
        ]);
    }

    public function detail_dt($id)
    {
        $proses = DB::table('d_indent_dt')->where('id_indent', $id)
            ->join('d_item', 'd_item.i_id', '=', 'id_item')
            ->select('i_nama', 'id_qty')->get();

        return DataTables::of($proses)
            ->addIndexColumn()
            ->addColumn('qty', function ($proses) {
                return '<span style="float: right">' . $proses->id_qty . ' Unit</span>';
            })
            ->rawColumns(['qty'])
            ->make(true);
    }

    public function detail($id)
    {
        $data = pemesanan::where('i_id', $id)
            ->join('m_member', 'm_member.m_id', '=', 'i_member')
            ->join('d_mem', 'd_mem.m_id', '=', 'i_sales')
            ->join('m_company', 'c_id', '=', 'i_comp')
            ->select('i_id','i_nota', 'c_name', 'm_member.m_name', 'm_member.m_idmember', 'm_member.m_telp', DB::raw('d_mem.m_name as sales'))
            ->first();

        return json_encode([
            'data' => $data
        ]);
    }

    public function auto_member(Request $request)
    {
        $cari = $request->term;
        $member = DB::table('m_member')
            ->whereRaw('m_name like "%'.$cari.'%"')
            ->select('m_id', 'm_name', 'm_telp')->get();

        if ($member == null) {
            $hasilmember[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($member as $query) {
                $hasilmember[] = [
                    'id' => $query->m_id,
                    'label' => $query->m_name.' ('.$query->m_telp.')',
                ];
            }
        }

        return Response::json($hasilmember);
    }

    public function auto_nota(Request $request)
    {
        $cari = $request->term;
        $nota = DB::table('d_indent')
            ->whereRaw('i_nota like "%'.$cari.'%"')
            ->select('i_id', 'i_nota')->get();

        if ($nota == null) {
            $hasilnota[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nota as $query) {
                $hasilnota[] = [
                    'id' => $query->i_id,
                    'label' => $query->i_nota
                ];
            }
        }

        return Response::json($hasilnota);
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
            ->select('i_id', 'i_nama', 'i_code', 'i_price')
            ->whereNotIn('i_id', $idItem)
            ->where(function ($query) use ($cari) {
                $query->whereRaw('i_nama like "%' . $cari . '%"')
                    ->orWhereRaw('concat(coalesce(i_code, ""), " ", coalesce(i_nama, "")) like "%' . $cari . '%"');
            })
            ->take(50)->get();

        if ($item == null) {
            $hasilitem[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($item as $query) {

                if ($query->i_code == null || $query->i_code == '' && $query->i_price == null) {
                    $hasilitem[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_nama,
                        'harga' => '0'
                    ];
                } else if ($query->i_code == null || $query->i_code == '' && $query->i_price != null) {
                    $hasilitem[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_nama,
                        'harga' => $query->i_price
                    ];
                } else if ($query->i_price == null) {
                    $hasilitem[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_code . ' - ' . $query->i_nama,
                        'harga' => $query->i_price
                    ];
                } else {
                    $hasilitem[] = [
                        'id' => $query->i_id,
                        'label' => $query->i_code . ' - ' . $query->i_nama,
                        'harga' => $query->i_price
                    ];
                }
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

                $nama = strtoupper($request->namaMember);
                $telp = $request->noTelp;
                $nik = $request->noNIK;

                $ceknik = DB::table('m_member')->where('m_nik', $nik)->count();
                if ($ceknik > 0) {
                    return response()->json([
                        'status' => 'nikAda',
                        'member' => $nik
                    ]);
                } else {
                    $cektelp = DB::table('m_member')->where('m_telp', $telp)->count();
                    if ($cektelp > 0) {
                        return response()->json([
                            'status' => 'telpAda',
                            'member' => $telp
                        ]);
                    } else {
                        DB::beginTransaction();
                        try {
                            DB::table('m_member')->insert([
                                'm_name' => $nama,
                                'm_telp' => $telp,
                                'm_nik' => $nik,
                                'm_status' => 'AKTIF'
                            ]);

                            DB::commit();

                            Plasma::logActivity('Menambahkan Member ' . strtoupper($request->namaMember) . ' (' . $request->noTelp . ')');

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
            }
        }
        return view('penjualan.pemesanan_barang.tambah');
    }

    public function getDataId()
    {
        $date = explode(' ', Carbon::now('Asia/Jakarta'));
        $tgl = explode('-', $date[0]);

        $cekNota = '/' . $tgl[2] . '/' . $tgl[1] . '/' . $tgl[0];

        $cek = DB::table('d_indent')
            ->select(DB::raw('select CAST(MID(i_nota, 5, 3) AS UNSIGNED)'))
            ->whereRaw('i_nota like "%' . $cekNota . '%"')
            ->max('i_id');

        if ($cek == null) {
            $temp = 1;
        } else {
            $temp = ($cek + 1);
        }

        $kode = sprintf("%03s", $temp);

        $tempKode = 'IND-' . $kode . $cekNota;
        return $tempKode;
    }

    public function tambah_pemesanan(Request $request)
    {
        if (Plasma::checkAkses(18, 'insert') == false) {
            return view('errors/407');
        } else {

            if ($request->isMethod('post')) {

                $i_member = $request->tpMemberId;
                $idItem = $request->idItem;
                $qtyItem = $request->qtyItem;

                DB::beginTransaction();
                try {

                    $hitung = DB::table('d_indent')->select('i_id')->max('i_id');

                    //== untuk d_indent
                    $i_id = $hitung + 1;
                    $i_comp = Auth::user()->m_comp;
                    $i_nota = $this->getDataId();
                    $i_status = "PROSES";
                    $i_sales = Auth::user()->m_id;

                    DB::table('d_indent')->insert([
                        'i_id' => $i_id,
                        'i_comp' => $i_comp,
                        'i_sales' => $i_sales,
                        'i_member' => $i_member,
                        'i_nota' => $i_nota,
                        'i_status' => $i_status,
                        'i_date' => Carbon::now()->format('Y-m-d')
                    ]);

                    $arayIndent = array();

                    //== untuk d_indent_dt
                    for ($i = 0; $i < count($idItem); $i++) {

                        $arayI = array(
                            'id_indent' => $i_id,
                            'id_detailid' => $i + 1,
                            'id_item' => $idItem[$i],
                            'id_qty' => $qtyItem[$i],
                            'id_status' => 'P'
                        );

                        array_push($arayIndent, $arayI);
                    }

                    DB::table('d_indent_dt')->insert($arayIndent);

                    DB::commit();

                    Plasma::logActivity('Menambahkan Pemesanan Barang dengan No. Nota : ' . $i_nota);

                    return response()->json([
                        'status' => 'tpSukses',
                        'nota' => $i_nota
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

    public function hapus($id)
    {
        if (Plasma::checkAkses(18, 'delete') == false) {
            return view('errors.407');
        } else {
            DB::beginTransaction();
            try {

                // $id = Crypt::decrypt($id);
                $nota = DB::table('d_indent')->select('i_nota')->where('i_id', $id)->first();
                $log = 'Menghapus Pemesanan Barang dengan nota '.$nota->i_nota;
                DB::table('d_indent')->where('i_id', $id)->delete();

                DB::table('d_indent_dt')->where('id_indent', $id)->delete();

                DB::commit();
                Plasma::logActivity($log);
                return json_encode([
                    'status' => 'hpSukses',
                    'name' => $nota->i_nota
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return json_encode([
                    'status' => 'hpGagal',
                    'msg' => $e
                ]);
            }
        }
    }

    public function simpan_status(Request $request){
        $id = $request->id;
        $status = $request->status;
        if($status == "2"){
            $status = "DONE";
        }else if($status == "3"){
            $status = "CANCEL";
        }

        DB::beginTransaction();
        try {
            DB::table('d_indent')->where('i_id', $id)->update([
                'i_status' => $status
            ]);

            $getNota = DB::table('d_indent')->where('i_id', $id)->select('i_nota')->first();
            $log = 'Mengganti Status Pemesanan Barang dengan Nota '.$getNota->i_nota.' menjadi '.$status;

            DB::commit();
            Plasma::logActivity($log);
            return json_encode([
                'status' => 'ssSukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return json_encode([
                'status' => 'ssGagal',
                'msg' => $e
            ]);
        }        
    }

    public function print(Request $request)
    {
        $id = $request->id;
        $data = DB::table('d_indent')
            ->join('m_company', 'c_id', '=', 'i_comp')
            ->join('m_member', 'm_id', '=', 'i_member')
            ->select('i_nota', 'c_name', 'c_address', 'c_tlp', 'm_name', 'm_telp', 'm_idmember')
            ->where('i_nota', $id)->get();

        $getId = DB::table('d_indent')->select('i_id')->where('i_nota', $id)->first();

        $dtData = DB::table('d_indent_dt')
            ->join('d_item', 'i_id', '=', 'id_item')
            ->select('i_nama', 'id_qty')
            ->where('id_indent', $getId->i_id)->get();

        // dd($data);
        return view('penjualan.pemesanan_barang.print')->with(compact('data', 'dtData'));
    }
}
