<?php

namespace App\Http\Controllers\master\pembayaran;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use DB;

class MasterPembayaranController extends Controller
{
    public function index()
    {
        return view('master.pembayaran.index');
    }

    public function getDataY()
    {
        $data = DB::table('m_pembayaran')
            ->where('p_isactive', '=', 'Y')
            ->orderBy('p_isactive');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data){
                return '<div class="text-center">
                        <button title="Edit" type="button" class="btn btn-info btn-xs" onclick="detail('.$data->p_id.')"><i class="glyphicon glyphicon-edit"></i></button>
                        <button title="Tambahkan" type="button" class="btn btn-danger btn-xs" onclick="detail('.$data->p_id.')"><i class="glyphicon glyphicon-circle-arrow-right"></i></button>
                        </div>';
            })
            ->editColumn('p_isactive', function ($data){
                if ($data->p_isactive == 'Y'){
                    return '<div class="text-center">
                        <span class="label label-primary">Aktif</span>
                        </div>';
                } else {
                    return '<div class="text-center">
                        <span class="label label-danger">Tidak Aktif</span>
                        </div>';
                }
            })
            ->rawColumns(['aksi', 'p_isactive'])
            ->make(true);
    }
}
