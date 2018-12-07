<?php

namespace App\Http\Controllers\master\outlet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\master\outlet as Outlet;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\CodeGenerator as GenerateCode;
use DataTables;
use DB;
use Session;
use Auth;

class outlet_controller extends Controller
{
    public function index()
    {
    	return view('master.outlet.index');
    }

    public function getdata()
    {
        $dataOutlet = Outlet::orderBy('c_id', 'desc')->get();

        $dataOutlet = collect($dataOutlet);

        return DataTables::of($dataOutlet)

        ->addColumn('aksi', function ($dataOutlet){ 

            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $dataOutlet->c_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $dataOutlet->c_id . '\')"><i class="glyphicon glyphicon-edit"></i></button></div>';

        })

        ->rawColumns(['aksi'])

        ->make(true);
    }

    public function getcode()
    {
        $kode = GenerateCode::code('m_company', 'c_id', 8, 'PF');

        return response()->json($kode);
    }

    public function add()
    {
    	return view('master.outlet.add');
    }
}
