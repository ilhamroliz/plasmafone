<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController as Access;
use App\Http\Controllers\CodeGenerator as GenerateCode;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use DB;
use Response;
use DataTables;
Use Auth;

class ServicesController extends Controller
{
    public function index()
    {
        if (Access::checkAkses(21, 'read') == true) {
            return view('penjualan.service-barang.index');
        } else {
            return view('errors.404');
        }
    }

    public function cariDataService(Request $request)
    {
        if (Auth::user()->m_comp == "PF00000001") {
            $data = DB::table('d_service_item')
                ->select('d_service_item.si_id as id',
                    DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                    'd_service_item.si_nota as nota',
                    'd_service_item.si_shipping_status',
                    'm_member.m_name as pelanggan',
                    'm_company.c_name as position',
                    'd_service_item.si_status')
                ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
                ->join('m_company', 'd_service_item.si_position', '=', 'm_company.c_id');
            if ($request->nota != ""){
                $data->where('d_service_item.si_nota', $request->nota);
            } else if ($request->tgl_awal != ""  && $request->tgl_akhir == "") {
                $data->orWhere('d_service_item.si_date', Carbon::parse($request->tglAwal)->format('Y-m-d'));
            } else if ($request->tgl_awal == "" && $request->tgl_akhir != "") {
                $data->orWhere('d_service_item.si_date', Carbon::parse($request->tgl_akhir)->format('Y-m-d'));
            } else if ($request->tgl_awal != "" && $request->tgl_akhir != "") {
                $data->whereBetween('d_service_item.si_date', [Carbon::parse($request->tgl_awal)->format('Y-m-d'), Carbon::parse($request->tgl_akhir)->format('Y-m-d')]);
            }
        } else {
            $data = DB::table('d_service_item')
                ->select('d_service_item.si_id as id',
                    DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                    'd_service_item.si_nota as nota',
                    'd_service_item.si_shipping_status',
                    'm_member.m_name as pelanggan',
                    'm_company.c_name as position',
                    'd_service_item.si_status')
                ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
                ->join('m_company', 'd_service_item.si_position', '=', 'm_company.c_id');
            if ($request->nota != ""){
                $data->where('d_service_item.si_nota', $request->nota);
            } else if ($request->tgl_awal != ""  && $request->tgl_akhir == "") {
                $data->orWhere('d_service_item.si_date', Carbon::parse($request->tglAwal)->format('Y-m-d'));
            } else if ($request->tgl_awal == "" && $request->tgl_akhir != "") {
                $data->orWhere('d_service_item.si_date', Carbon::parse($request->tgl_akhir)->format('Y-m-d'));
            } else if ($request->tgl_awal != "" && $request->tgl_akhir != "") {
                $data->whereBetween('d_service_item.si_date', [Carbon::parse($request->tgl_awal)->format('Y-m-d'), Carbon::parse($request->tgl_akhir)->format('Y-m-d')]);
            }
        }

        return DataTables::of($data)

            ->addColumn('posisi', function ($data){
                if ($data->si_shipping_status == "On Outlet"){
                    return $data->position;
                } else if ($data->si_shipping_status == "Delivery to Center") {
                    return '<center><span class="label label-info">Sedang Dikirim ke Pusat</span></center>';
                } else if ($data->si_shipping_status == "Delivery to Outlet") {
                    return '<center><span class="label label-info">Sedang Dikirim ke Outlet</span></center>';
                } else if ($data->si_shipping_status == "On Center") {
                    return $data->position;
                }
            })

            ->addColumn('status', function ($data){
                if ($data->si_status == "PENDING") {
                    return '<center><span class="label label-warning">PENDING</span></center>';
                } else if ($data->si_status == "DITERIMA") {
                    return '<center><span class="label label-primary">DITERIMA</span></center>';
                } else if ($data->si_status == "PROSES") {
                    return '<center><span class="label label-warning">PROSES</span></center>';
                } else if ($data->si_status == "TOLAK") {
                    return '<center><span class="label label-danger">TOLAK</span></center>';
                } else if ($data->si_status == "DONE") {
                    return '<center><span class="label label-success">SELESAI</span></center>';
                }
            })

            ->addColumn('aksi', function ($data) {

                if (Auth::user()->m_comp == "PF00000001") {
                    if ($data->si_status == "PENDING") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="serviceHapus(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle view" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="serviceTolak(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Terima" onclick="serviceTerima(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-arrow-down"></i></button></div>';
                    } else if ($data->si_status == "DITERIMA") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle view" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="serviceTolak(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Proses" onclick="serviceProses(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-refresh"></i></button></div>';
                    } else if ($data->si_status == "PROSES") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle view" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="serviceTolak(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Selesai" onclick="serviceSelesai(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-check"></i></button></div>';
                    } else if ($data->si_status == "DONE") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    }
                } else {
                    if ($data->si_shipping_status == "Delivery to Center" || $data->si_shipping_status == "On Center") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    } else if($data->si_shipping_status == "On Outlet") {
                        if ($data->si_status == "TOLAK" || $data->si_status == "PROSES" || $data->si_status == "DONE") {
                            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                        } else {
                            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="serviceHapus(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Kirim ke Pusat" onclick="servicePenjualan(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-send"></i></button></div>';
                        }
                    } else if($data->si_shipping_status == "Delivery to Outlet") {
                        if($data->si_status == "DONE" || $data->si_status == "TOLAK"){
                            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Kirim ke Pusat" onclick="serviceTerimaOutlet(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-arrow-down"></i></button></div>';
                        }
                    }
                }

            })

            ->rawColumns(['aksi', 'status', 'posisi'])

            ->make(true);
    }

    public function getDataService()
    {
        if (Auth::user()->m_comp == "PF00000001") {
            $data = DB::table('d_service_item')
                ->select('d_service_item.si_id as id',
                    DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                    'd_service_item.si_nota as nota',
                    'd_service_item.si_shipping_status',
                    'm_member.m_name as pelanggan',
                    'm_company.c_name as position',
                    'd_service_item.si_status')
                ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
                ->join('m_company', 'd_service_item.si_position', '=', 'm_company.c_id')
                ->where('si_shipping_status', 'Delivery to Center')
                ->orWhere('si_shipping_status', 'On Center');
        } else {
            $data = DB::table('d_service_item')
                ->select('d_service_item.si_id as id',
                    DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                    'd_service_item.si_nota as nota',
                    'd_service_item.si_shipping_status',
                    'm_member.m_name as pelanggan',
                    'm_company.c_name as position',
                    'd_service_item.si_status')
                ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
                ->join('m_company', 'd_service_item.si_position', '=', 'm_company.c_id');
        }

        return DataTables::of($data)

            ->addColumn('posisi', function ($data){
                if ($data->si_shipping_status == "On Outlet"){
                    return $data->position;
                } else if ($data->si_shipping_status == "Delivery to Center") {
                    return '<center><span class="label label-info">Sedang Dikirim ke Pusat</span></center>';
                } else if ($data->si_shipping_status == "Delivery to Outlet") {
                    return '<center><span class="label label-info">Sedang Dikirim ke Outlet</span></center>';
                } else if ($data->si_shipping_status == "On Center") {
                    return $data->position;
                }
            })

            ->addColumn('status', function ($data){
                if ($data->si_status == "PENDING") {
                    return '<center><span class="label label-warning">PENDING</span></center>';
                } else if ($data->si_status == "DITERIMA") {
                    return '<center><span class="label label-primary">DITERIMA</span></center>';
                } else if ($data->si_status == "PROSES") {
                    return '<center><span class="label label-warning">PROSES</span></center>';
                } else if ($data->si_status == "TOLAK") {
                    return '<center><span class="label label-danger">TOLAK</span></center>';
                } else if ($data->si_status == "DONE") {
                    return '<center><span class="label label-success">SELESAI</span></center>';
                }
            })

            ->addColumn('aksi', function ($data) {

                if (Auth::user()->m_comp == "PF00000001") {
                    if ($data->si_status == "PENDING") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="serviceHapus(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle view" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="serviceTolak(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Terima" onclick="serviceTerima(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-arrow-down"></i></button></div>';
                    } else if ($data->si_status == "DITERIMA") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle view" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="serviceTolak(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Proses" onclick="serviceProses(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-refresh"></i></button></div>';
                    } else if ($data->si_status == "PROSES") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle view" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="serviceTolak(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Selesai" onclick="serviceSelesai(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-check"></i></button></div>';
                    } else if ($data->si_status == "DONE") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    }
                } else {
                    if ($data->si_shipping_status == "Delivery to Center" || $data->si_shipping_status == "On Center") {
                        return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    } else if($data->si_shipping_status == "On Outlet") {
                        if ($data->si_status == "TOLAK" || $data->si_status == "PROSES" || $data->si_status == "DONE") {
                            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                        } else {
                            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="serviceHapus(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Kirim ke Pusat" onclick="servicePenjualan(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-send"></i></button></div>';
                        }
                    } else if($data->si_shipping_status == "Delivery to Outlet") {
                        if($data->si_status == "DONE" || $data->si_status == "TOLAK"){
                            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Kirim ke Pusat" onclick="serviceTerimaOutlet(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-arrow-down"></i></button></div>';
                        }
                    }
                }

            })

            ->rawColumns(['aksi', 'status', 'posisi'])

            ->make(true);
    }

    public function getPending()
    {
        $data = DB::table('d_service_item')
            ->select('d_service_item.si_id as id', DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                'd_service_item.si_nota as nota', 'm_member.m_name as pelanggan')
            ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
            ->where('d_service_item.si_status', 'PENDING');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(21, 'delete') == false && Access::checkAkses(21, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;<button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Proses" onclick="proses(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-refresh"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getTolak()
    {
        $data = DB::table('d_service_item')
            ->select('d_service_item.si_id as id', DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                'd_service_item.si_nota as nota', 'm_member.m_name as pelanggan')
            ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
            ->where('d_service_item.si_status', 'TOLAK');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(21, 'delete') == false && Access::checkAkses(21, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Batalkan" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getProses()
    {
        $data = DB::table('d_service_item')
            ->select('d_service_item.si_id as id', DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                'd_service_item.si_nota as nota', 'm_member.m_name as pelanggan')
            ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
            ->where('d_service_item.si_status', 'PROSES');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(21, 'delete') == false && Access::checkAkses(21, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Tolak" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getDone()
    {
        $data = DB::table('d_service_item')
            ->select('d_service_item.si_id as id', DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as tanggal'),
                'd_service_item.si_nota as nota', 'm_member.m_name as pelanggan')
            ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
            ->where('d_service_item.si_status', 'DONE');

        return DataTables::of($data)

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(21, 'delete') == false && Access::checkAkses(21, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Batalkan" onclick="remove(\'' . Crypt::encrypt($data->id) . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function getDetailService($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return json_encode('Not Found');
        }

        $datas = DB::table('d_service_item')
            ->select(
                'm_company.c_name as position',
                DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as date'),
                'd_service_item.si_nota as nota_service',
                'd_service_item.si_notasales as nota_sales',
                'd_service_item.si_status as status',
                'd_service_item.si_shipping_status as shipping_status',
                'm_member.m_name as buyer',
                'd_item.i_nama as item',
                'd_item.i_code as code',
                'd_service_itemdt.sid_qty as qty',
                'd_service_itemdt.sid_specificcode as specificcode',
                'd_service_itemdt.sid_note as note',
                'd_mem.m_name as officer'
            )
            ->where('d_service_item.si_id', $id)
            ->join('d_service_itemdt', 'd_service_item.si_id', '=', 'd_service_itemdt.sid_serviceitem')
            ->join('d_sales', 'd_sales.s_nota', '=', 'd_service_item.si_notasales')
            ->join('m_member', 'm_member.m_id', '=', 'd_service_item.si_mem')
            ->join('d_item', 'd_item.i_id', '=', 'd_service_itemdt.sid_item')
            ->join('m_company', 'd_service_item.si_position', '=', 'm_company.c_id')
            ->join('d_mem', 'd_service_itemdt.sid_mem', '=', 'd_mem.m_id')
            ->get();

        if ($datas == null) {
            return json_encode('Not Found');
        }

        return json_encode($datas);
    }

    public function add()
    {
        if (Access::checkAkses(21, 'insert') == true) {
            return view('penjualan.service-barang.add');
        } else {
            return view('errors.404');
        }
    }

    public function cariMember(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('d_sales')
            ->join('m_member', function ($x) use ($cari){
                $x->on('d_sales.s_member', '=', 'm_member.m_id');
                $x->where('m_member.m_name', 'like', '%'.$cari.'%');
            })
            ->get();

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->m_id, 'label' => strtoupper($query->m_name)];
            }
        }
        return Response::json($results);
    }

    public function cariKode(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('d_sales')
            ->join('d_sales_dt', function ($x) use ($cari){
                $x->on('d_sales.s_id', '=', 'd_sales_dt.sd_sales');
                $x->where('d_sales_dt.sd_specificcode', 'like', '%'.$cari.'%');
            })
            ->get();

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->s_id, 'label' => strtoupper($query->sd_specificcode)];
            }
        }
        return Response::json($results);
    }

    public function cariNota(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('d_sales')
            ->where(function ($x) use ($cari){
                $x->where('s_nota', 'like', '%'.$cari.'%');
            })
            ->get();

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->s_id, 'label' => strtoupper($query->s_nota)];
            }
        }
        return Response::json($results);
    }

    public function cariNotaPenjualan(Request $request)
    {
        $data = DB::table('d_sales')
            ->join('d_sales_dt', 'd_sales.s_id', 'd_sales_dt.sd_sales')
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id');

        if ($request->member != "") {
            $data->where('m_member.m_name', 'like', '%'.$request->member.'%');
        } else if ($request->idmember != "") {
            $data->orWhere('d_sales.s_member', $request->idmember);
        } else if ($request->kode != "") {
            $data->orWhere('d_sales_dt.sd_specificcode', $request->kode);
        } else if ($request->nota != "") {
            $data->orWhere('d_sales.s_nota', $request->nota);
        } else if ($request->tgl_awal != ""  && $request->tgl_akhir == "") {
            $data->orWhere('d_sales.s_date', Carbon::parse($request->tglAwal)->format('Y-m-d'));
        } else if ($request->tgl_awal == "" && $request->tgl_akhir != "") {
            $data->orWhere('d_sales.s_date', Carbon::parse($request->tgl_akhir)->format('Y-m-d'));
        } else if ($request->tgl_awal != "" && $request->tgl_akhir != "") {
            $data->whereBetween('d_sales.s_date', [Carbon::parse($request->tgl_awal)->format('Y-m-d'), Carbon::parse($request->tgl_akhir)->format('Y-m-d')]);
        }

        $data->groupBy('d_sales.s_nota');

        return DataTables::of($data)

            ->addColumn('tanggal', function ($data){
                return Carbon::parse($data->s_date)->format('d-m-Y');
            })

            ->addColumn('aksi', function ($data) {

                if (Access::checkAkses(20, 'update') == false) {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';

                } else {

                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Service Barang" onclick="servicePenjualan(\'' . Crypt::encrypt($data->s_id) . '\')"><i class="glyphicon glyphicon-wrench"></i></button></div>';

                }

            })

            ->rawColumns(['aksi'])

            ->make(true);
    }

    public function cariNotaDetail($id = null)
    {
        if (Access::checkAkses(20, 'read') == false) {
            return json_encode(array('status' => 'Access denied'));
        }

        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return json_encode(array('status' => 'Not Found'));
        }

        $regular = DB::table('d_sales')
            ->select('d_sales.*', 'd_sales_dt.*', DB::raw('FORMAT(d_sales_dt.sd_total_net, 0, "de_DE") as total_net'),
                DB::raw('DATE_FORMAT(d_sales.s_date, "%d-%m-%Y") as tanggal'), 'd_mem.m_name as salesman', 'd_item.i_nama as nama_item',
                'm_member.m_name', 'm_member.m_telp', 'm_member.m_address', 'd_item.i_code')
            ->join('d_sales_dt', 'd_sales.s_id', '=', 'd_sales_dt.sd_sales')
            ->join('d_mem', 'd_sales.s_salesman', '=', 'd_mem.m_id')
            ->join('d_item', 'd_sales_dt.sd_item', '=', 'd_item.i_id')
            ->join('m_member', 'd_sales.s_member', '=', 'm_member.m_id')
            ->where('d_sales.s_id', $id)->get();

        $row = [];
        foreach ($regular as $key => $penjualan) {
            $row[] = array(
                'tanggal' => $penjualan->tanggal,
                'nota' => $penjualan->s_nota,
                's_total_net' => $penjualan->s_total_net,
                'salesman' => $penjualan->salesman,
                'm_name' => $penjualan->m_name,
                'm_telp' => $penjualan->m_telp,
                'm_address' => $penjualan->m_address,
                'idsales' => Crypt::encrypt($penjualan->sd_sales),
                'iditem' => Crypt::encrypt($penjualan->sd_item),
                'code' => $penjualan->i_code,
                'specificcode' => $penjualan->sd_specificcode,
                'nama_item' => $penjualan->nama_item,
                'qty' => $penjualan->sd_qty,
                'total_net' => $penjualan->total_net
            );
        }
        return json_encode($row);
    }

    public function serviceBarang($idsales = null, $iditem = null, $spcode = null)
    {
        try {
            $idsales = Crypt::decrypt($idsales);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        try {
            $iditem = Crypt::decrypt($iditem);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        if ($spcode == "null"){
            $spcode = null;
        }

        $data = DB::table('d_sales')
            ->join('d_sales_dt', 'd_sales.s_id', '=', 'd_sales_dt.sd_sales')
            ->join('d_item', 'd_sales_dt.sd_item', '=', 'd_item.i_id')
            ->where('d_sales_dt.sd_sales', $idsales)
            ->where('d_sales_dt.sd_item', $iditem)
            ->where('d_sales_dt.sd_specificcode', $spcode)
            ->first();

        return view('penjualan.service-barang.service')->with(compact('data'));
    }

    public function addService(Request $request)
    {
        try {
            $idsales = Crypt::decrypt($request->idsales);
        } catch (DecryptException $e) {
            return json_encode(['status' => 'not found']);
        }

        try {
            $iditem = Crypt::decrypt($request->iditem);
        } catch (DecryptException $e) {
            return json_encode(['status' => 'not found']);
        }

        $nota = GenerateCode::codeReturn('d_service_item', 'si_nota', 8, 10, 3, 'PB');

        $notasales = $request->nota;

        $qty = $request->qty;

        $kode = $request->kode;

        $note = strtoupper($request->ket);

        $comp = Auth::user()->m_comp;

        $petugas = Auth::user()->m_id;

        $date = Carbon::now('Asia/Jakarta');

        $idpelanggan = DB::table('d_sales')->where('s_id', $idsales)->first()->s_member;

        $sid = (DB::table('d_service_item')->max('si_id')) ? (DB::table('d_service_item')->max('si_id') + 1) : 1;

        $detailid = (DB::table('d_service_itemdt')->where('sid_serviceitem', $sid)->max('sid_detailid')) ? (DB::table('d_service_itemdt')->where('sid_serviceitem', $sid)->max('sid_detailid') + 1) : 1;

        $compsales = DB::table('d_sales')->where('s_id', $idsales)->first()->s_comp;

        DB::beginTransaction();
        try{
            $service[] = [
                'si_id' => $sid,
                'si_comp' => $comp,
                'si_position' => $comp,
                'si_date' => $date,
                'si_nota' => $nota,
                'si_notasales' => $notasales,
                'si_mem' => $idpelanggan,
                'si_status' => 'PENDING'
            ];

            $item[] = [
                'sid_serviceitem' => $sid,
                'sid_detailid' => $detailid,
                'sid_item' => $iditem,
                'sid_qty' => $qty,
                'sid_specificcode' => $kode,
                'sid_note' => $note,
                'sid_mem' => $petugas
            ];

            DB::table('d_service_item')->insert($service);

            DB::table('d_service_itemdt')->insert($item);

            //insert stock mutasi rusak
            //check item rusak
            $stockRusak = DB::table('d_stock')
                ->where('s_comp', $comp)
                ->where('s_position', $comp)
                ->where('s_item', $iditem)
                ->where('s_status', 'On Destination')
                ->where('s_condition', 'BROKEN');

            if ($stockRusak->count() == 0) {
                $idStockRusak = (DB::table('d_stock')->max('s_id')) ? (DB::table('d_stock')->max('s_id') + 1) : 1;
                DB::table('d_stock')
                    ->insert([
                        's_id'          => $idStockRusak,
                        's_comp'        => $comp,
                        's_position'    => $comp,
                        's_item'        => $iditem,
                        's_qty'         => $qty,
                        's_status'      => 'On Destination',
                        's_condition'   => 'BROKEN'
                    ]);
            } else {
                $idStockRusak = $stockRusak->first()->s_id;
                DB::table('d_stock')
                    ->where('s_id', $idStockRusak)
                    ->update([
                        's_qty'         => $stockRusak->first()->s_qty + $qty,
                    ]);
            }

            if ($kode != null) {
                $sd_iddetail = (DB::table('d_stock_dt')->where('sd_stock', $idStockRusak)->max('sd_detailid')) ? (DB::table('d_stock_dt')->where('sd_stock', $idStockRusak)->max('sd_detailid')) + 1 : 1;

                DB::table('d_stock_dt')->insert([
                    'sd_stock' => $idStockRusak,
                    'sd_detailid' => $sd_iddetail,
                    'sd_specificcode' => $kode
                ]);
            }

            //insert stock mutation
            $detalidsm = (DB::table('d_stock_mutation')->where('sm_stock', $idStockRusak)->max('sm_detailid')) ? (DB::table('d_stock_mutation')->where('sm_stock', $idStockRusak)->max('sm_detailid')) + 1 : 1;

            $stock_check = DB::table('d_stock')
                ->where('s_comp', $compsales)
                ->where('s_position', $compsales)
                ->where('s_item', $iditem)
                ->where('s_status', 'On Destination')
                ->where('s_condition', 'FINE');

            if ($stock_check->count() == 0) {
                DB::rollback();
                return json_encode(['status' => 'not found']);
            } else {
                $sm = DB::table('d_stock_mutation')
                    ->where('sm_stock', $stock_check->first()->s_id)
                    ->where('sm_detail', 'PENAMBAHAN')
                    ->where('sm_specificcode', $kode)
                    ->where('sm_reff', '!=', 'RUSAK')
                    ->first();

                DB::table('d_stock_mutation')
                    ->insert([
                        'sm_stock' => $idStockRusak,
                        'sm_detailid' => $detalidsm,
                        'sm_date' => Carbon::now('Asia/Jakarta'),
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_specificcode' => $kode,
                        'sm_qty' => $qty,
                        'sm_use' => 0,
                        'sm_sisa' => $qty,
                        'sm_hpp' => $sm->sm_hpp,
                        'sm_sell' => $sm->sm_sell,
                        'sm_nota' => $nota,
                        'sm_reff' => 'RUSAK',
                        'sm_mem' => $petugas
                    ]);

                DB::commit();
                return json_encode(['status' => 'true', 'id' => Crypt::encrypt($sid)]);
            }
        }catch (\Exception $e){
            DB::rollback();
            return $e;
            return json_encode(['status' => 'false']);
        }
    }

    public function sendService($id = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'Not Found']);
        }

        DB::beginTransaction();
        try{
            $itemService = DB::table('d_service_item')
                ->join('d_service_itemdt', 'd_service_item.si_id', '=', 'd_service_itemdt.sid_serviceitem')
                ->where('si_id', $id);

            if ($itemService->count() == 0) {
                return response()->json(['status' => 'Not Found']);
            } else {
                DB::table('d_service_item')
                    ->where('si_id', $id)
                    ->update([
                        'si_position' => 'PF00000001',
                        'si_shipping_status' => 'Delivery to Center'
                    ]);

                // insert d_stock
                $sid = (DB::table('d_stock')->max('s_id')) ? (DB::table('d_stock')->max('s_id')) + 1 : 1;

                $stock = DB::table('d_stock')
                    ->where('s_comp', $itemService->first()->si_comp)
                    ->where('s_position', $itemService->first()->si_position)
                    ->where('s_item', $itemService->first()->sid_item)
                    ->where('s_status', 'On Going')
                    ->where('s_condition', 'BROKEN');

                if ($stock->count() == 0) {

                    // insert d_stock
                    DB::table('d_stock')->insert([
                        's_id' => $sid,
                        's_comp' => $itemService->first()->si_comp,
                        's_position' => $itemService->first()->si_position,
                        's_item' => $itemService->first()->sid_item,
                        's_qty' => $itemService->first()->sid_qty,
                        's_status' => 'On Going',
                        's_condition' => 'BROKEN'
                    ]);

                    if ($itemService->first()->sid_specificcode != null) {
                        // insert kode d_stockdt
                        $sidDetail = (DB::table('d_stock_dt')->where('sd_stock', $sid)->max('sd_detailid')) ? (DB::table('d_stock_dt')->where('sd_stock', $sid)->max('sd_detailid')) + 1 : 1;
                        DB::table('d_stock_dt')
                            ->insert([
                                'sd_stock' => $sid,
                                'sd_detailid' => $sidDetail,
                                'sd_specificcode' => $itemService->first()->sid_specificcode
                            ]);
                    }

                } else {

                    //update qtynya
                    DB::table('d_stock')
                        ->where('s_comp', $itemService->first()->si_comp)
                        ->where('s_position', $itemService->first()->si_position)
                        ->where('s_item', $itemService->first()->sid_item)
                        ->where('s_status', 'On Going')
                        ->where('s_condition', 'BROKEN')
                        ->update([
                            's_qty' => $stock->s_qty + $itemService->first()->sid_qty
                        ]);

                    if ($itemService->first()->sid_specificcode != null) {
                        // insert kode d_stockdt
                        $sidDetail = (DB::table('d_stock_dt')->where('sd_stock', $stock->first()->s_id)->max('sd_detailid')) ? (DB::table('d_stock_dt')->where('sd_stock', $sid)->max('sd_detailid')) + 1 : 1;
                        DB::table('d_stock_dt')
                            ->insert([
                                'sd_stock' => $stock->first()->s_id,
                                'sd_detailid' => $sidDetail,
                                'sd_specificcode' => $itemService->first()->sid_specificcode
                            ]);
                    }

                }

                //pengurangan stock mutasi
                $idsm = DB::table('d_stock_mutation')
                    ->where('sm_detail', 'PENAMBAHAN')
                    ->where('sm_specificcode', $itemService->first()->sid_specificcode)
                    ->where('sm_nota', $itemService->first()->si_nota)
                    ->where('sm_reff', 'RUSAK');

                if ($idsm->count() == 0) {
                    DB::rollback();
                    return response()->json(['status' => 'Not Found']);
                } else {
                    //insert mutasi stock pengurangan
                    $iddetailsm = (DB::table('d_stock_mutation')->where('sm_stock', $idsm->first()->sm_stock)->max('sm_detailid')) ? (DB::table('d_stock_mutation')->where('sm_stock', $idsm->first()->sm_stock)->max('sm_detailid')) + 1 : 1;

                    DB::table('d_stock_mutation')
                        ->insert([
                            'sm_stock'          => $idsm->first()->sm_stock,
                            'sm_detailid'       => $iddetailsm,
                            'sm_date'           => Carbon::now('Asia/Jakarta'),
                            'sm_detail'         => 'PENGURANGAN',
                            'sm_specificcode'   => $itemService->first()->sid_specificcode,
                            'sm_qty'            => $itemService->first()->sid_qty,
                            'sm_use'            => 0,
                            'sm_sisa'           => 0,
                            'sm_hpp'            => $idsm->first()->sm_hpp,
                            'sm_sell'           => $idsm->first()->sm_sell,
                            'sm_nota'           => $idsm->first()->sm_nota,
                            'sm_reff'           => $idsm->first()->sm_nota,
                            'sm_mem'            => Auth::user()->m_id
                        ]);

                    //pengurangan qty
                    $smupdate = [
                        'sm_use' => $idsm->first()->sm_use + $itemService->first()->sid_qty,
                        'sm_sisa' => $idsm->first()->sm_sisa - $itemService->first()->sid_qty
                    ];
                    $idsm->update($smupdate);

                    if ($itemService->first()->sid_specificcode != null) {
                        DB::table('d_stock_dt')
                            ->where('sd_stock', $idsm->first()->sm_stock)
                            ->where('sd_specificcode', $itemService->first()->sid_specificcode)
                            ->delete();
                    }

                    //pengurangan qty d_stock
                    $stk = DB::table('d_stock')
                        ->where('s_comp', $itemService->first()->si_comp)
                        ->where('s_position', $itemService->first()->si_comp)
                        ->where('s_item', $itemService->first()->sid_item)
                        ->where('s_status', 'On Destination')
                        ->where('s_condition', 'BROKEN');

                    if ($stk->count() == 0) {
                        DB::rollback();
                        return response()->json(['status' => 'Not Found']);
                    } else {
                        $stockupdate = [
                            's_qty' => $stk->first()->s_qty - $itemService->first()->sid_qty
                        ];

                        DB::table('d_stock')
                            ->where('s_id', $idsm->first()->sm_stock)
                            ->update($stockupdate);

                        DB::commit();
                        return response()->json(['status' => 'True']);
                    }
                }
            }
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['status' => 'False']);
        }
    }

    public function edit()
    {
        return view('penjualan.service-barang.edit');
    }

    public function struk($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $datas = DB::table('d_service_item')
            ->select(
                DB::raw('DATE_FORMAT(d_service_item.si_date, "%d-%m-%Y") as date'),
                'm_company.c_name as outlet',
                'm_company.c_address as outlet_address',
                'd_service_item.si_nota as nota_service',
                'd_service_item.si_notasales as nota_sales',
                'm_member.m_name as buyer',
                'm_member.m_telp as telp',
                'd_mem.m_name as officer',
                'd_item.i_code as code',
                'd_item.i_nama as item',
                'd_service_itemdt.sid_specificcode as specificcode',
                'd_service_itemdt.sid_qty as qty',
                'd_service_itemdt.sid_note as note'
            )
            ->join('d_service_itemdt', 'd_service_item.si_id', '=', 'd_service_itemdt.sid_serviceitem')
            ->join('d_item', 'd_service_itemdt.sid_item', '=', 'd_item.i_id')
            ->join('m_company', 'd_service_item.si_comp', 'm_company.c_id')
            ->join('m_member', 'd_service_item.si_mem', '=', 'm_member.m_id')
            ->join('d_mem', 'd_service_itemdt.sid_mem', '=', 'd_mem.m_id')
            ->get();

        if ($datas == null) {
            return view('errors/404');
        }

        return view('penjualan.service-barang.struk')->with(compact('datas'));
    }

    public function serviceTolak($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'Not Found']);
        }

        try{
            DB::table('d_service_item')
                ->where('si_id', $id)
                ->update([
                    'si_status' => 'TOLAK',
                    'si_shipping_status' => 'Delivery to Outlet'
                ]);
            DB::commit();
            return response()->json(['status' => 'True']);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['status' => 'False']);
        }
    }

    public function serviceTerima($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'Not Found']);
        }

        try{
            DB::table('d_service_item')
                ->where('si_id', $id)
                ->update([
                    'si_status' => 'DITERIMA',
                    'si_shipping_status' => 'On Center'
                ]);
            DB::commit();
            return response()->json(['status' => 'True']);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['status' => 'False']);
        }
    }

    public function serviceProses($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'Not Found']);
        }

        try{
            DB::table('d_service_item')
                ->where('si_id', $id)
                ->update([
                    'si_status' => 'PROSES'
                ]);
            DB::commit();
            return response()->json(['status' => 'True']);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['status' => 'False']);
        }
    }

    public function serviceSelesai($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'Not Found']);
        }

        try{
            DB::table('d_service_item')
                ->where('si_id', $id)
                ->update([
                    'si_status' => 'DONE',
                    'si_shipping_status' => 'Delivery to Outlet'
                ]);
            DB::commit();
            return response()->json(['status' => 'True']);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['status' => 'False']);
        }
    }

    public function serviceTerimaPusat($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'Not Found']);
        }

        try{
            DB::table('d_service_item')
                ->where('si_id', $id)
                ->update([
                    'si_position' => Auth::user()->m_comp,
                    'si_shipping_status' => 'On Outlet'
                ]);
            DB::commit();
            return response()->json(['status' => 'True']);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['status' => 'False']);
        }
    }

    public function serviceDelete($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'Not Found']);
        }

        try{
            DB::table('d_service_item')
                ->where('si_id', $id)
                ->delete();
            DB::table('d_service_itemdt')
                ->where('sid_serviceitem', $id)
                ->delete();
            DB::commit();
            return response()->json(['status' => 'True']);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['status' => 'False']);
        }
    }
}
