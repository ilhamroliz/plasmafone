<?php

namespace App\Http\Controllers\master\pembayaran;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use DB;

class MasterPembayaranController extends Controller
{
    public function index()
    {
        $akun = DB::table('dk_akun')
            ->where('ak_isactive', '=', '1')
            ->where('ak_tahun', '=', Carbon::now('Asia/Jakarta')->format('Y'))
            ->get();

        $outlet = DB::table('m_company')
            ->where('c_isactive', '=', 'Y')
            ->get();

        return view('master.pembayaran.index', compact('akun', 'outlet'));
    }

    public function getDataY()
    {
        $data = DB::table('m_pembayaran')
            ->where('p_isactive', '=', 'Y')
            ->orderBy('p_isactive');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data){
                return '<div class="text-center">
                        <button title="Edit" type="button" data-toggle="modal" data-target="#detail-pembayaran" class="btn btn-warning btn-xs" onclick="detail(\''.encrypt($data->p_id).'\')"><i class="glyphicon glyphicon-edit"></i></button>
                        <button title="Non Aktifkan" type="button" class="nonaktif btn btn-danger btn-xs" onclick="nonaktifkan(\''.encrypt($data->p_id).'\')"><i class="glyphicon glyphicon-remove"></i></button>
                        <button title="Tambahkan" type="button" data-toggle="modal" data-target="#add-pembayaran" class="btn btn-primary btn-xs" onclick="tambahkan(\''.encrypt($data->p_id).'\', \''.$data->p_detail.'\')"><i class="glyphicon glyphicon-circle-arrow-right"></i></button>
                        </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function getDataN()
    {
        $data = DB::table('m_pembayaran')
            ->where('p_isactive', '=', 'N')
            ->orderBy('p_isactive');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data){
                return '<div class="text-center">
                        <button title="Edit" type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#detail-pembayaran" onclick="detail(\''.encrypt($data->p_id).'\')"><i class="glyphicon glyphicon-edit"></i></button>
                        <button title="Aktifkan" type="button" class="btn btn-primary btn-xs" onclick="aktifkan(\''.encrypt($data->p_id).'\')"><i class="glyphicon glyphicon-check"></i></button>
                        </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function save(Request $request)
    {
        $nama = strtoupper($request->nama);
        $nomor = strtoupper($request->nomor);
        $pemilik = strtoupper($request->alias);
        $akun = $request->akun;

        DB::beginTransaction();
        try {
            $id = DB::table('m_pembayaran')->max('p_id');
            ++$id;

            DB::table('m_pembayaran')
                ->insert([
                    'p_id' => $id,
                    'p_detail' => $nama,
                    'p_name' => $pemilik,
                    'p_no' => $nomor,
                    'p_akun' => $akun,
                    'p_isactive' => 'Y'
                ]);
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function getDetail(Request $request)
    {
        $id = decrypt($request->id);
        $data = DB::table('m_pembayaran')
            ->where('p_id', '=', $id)
            ->first();
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $id = decrypt($request->id);
        $nama = strtoupper($request->nama);
        $pemilik = strtoupper($request->alias);
        $nomor = $request->nomor;
        $akun = $request->akun;

        DB::beginTransaction();
        try {
            DB::table('m_pembayaran')
                ->where('p_id', '=', $id)
                ->update([
                    'p_detail' => $nama,
                    'p_name' => $pemilik,
                    'p_no' => $nomor,
                    'p_akun' => $akun,
                ]);
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function setNonaktif(Request $request)
    {
        $id = decrypt($request->id);
        DB::beginTransaction();
        try {
            DB::table('m_pembayaran')
                ->where('p_id', '=', $id)
                ->update([
                    'p_isactive' => 'N'
                ]);
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function setAktif(Request $request)
    {
        $id = decrypt($request->id);
        DB::beginTransaction();
        try {
            DB::table('m_pembayaran')
                ->where('p_id', '=', $id)
                ->update([
                    'p_isactive' => 'Y'
                ]);
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function getOutletPayment(Request $request)
    {
        $outlet = $request->outlet;
        if ($outlet == 'semua'){
            $data = DB::table('d_outlet_payment')
                ->join('m_company', 'c_id', '=', 'op_outlet')
                ->join('m_pembayaran', 'p_id', '=', 'op_pembayaran');
        } else {
            $data = DB::table('d_outlet_payment')
                ->join('m_company', 'c_id', '=', 'op_outlet')
                ->join('m_pembayaran', 'p_id', '=', 'op_pembayaran')
                ->where('op_outlet', '=', $outlet);
        }

        return DataTables::of($data)
            ->addColumn('aksi', function ($data){
                return '<div class="text-center">
                        <button title="Hapus" type="button" class="btn btn-danger btn-xs" onclick="hapusPayment(\''.encrypt($data->op_id).'\')"><i class="glyphicon glyphicon-remove"></i></button>
                        </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function saveOutletPayment(Request $request)
    {
        $payment = decrypt($request->idJenis);
        $outlet = $request->outlet;

        DB::beginTransaction();
        try {
            $cek = DB::table('d_outlet_payment')
                ->where('op_outlet','=', $outlet)
                ->where('op_pembayaran', '=', $payment)
                ->first();

            if ($cek != null){
                DB::rollBack();
                return response()->json([
                    'status' => 'sudah'
                ]);
            } else {
                $id = DB::table('d_outlet_payment')
                    ->max('op_id');
                ++$id;
                DB::table('d_outlet_payment')
                    ->insert([
                        'op_id' => $id,
                        'op_outlet' => $outlet,
                        'op_pembayaran' => $payment
                    ]);
                DB::commit();
                return response()->json([
                    'status' => 'sukses'
                ]);
            }
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function deleteOutletPayment(Request $request)
    {
        $id = decrypt($request->id);
        DB::beginTransaction();
        try {
            DB::table('d_outlet_payment')
                ->where('op_id', '=', $id)
                ->delete();
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

}
