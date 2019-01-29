<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\pembelian\order as order;
use App\Http\Controllers\PlasmafoneController as Plasma;

use DataTables;
use Carbon\Carbon;
use Auth;
use DB;
use Session;
use PDF;
use Response;

class PembelianController extends Controller
{
    // ----Bagian rencana Pembelian -----
    public function cariItem(Request $request)
    {
        $cari = $request->term;
        $nama = DB::table('d_item')
            ->where(function ($q) use ($cari){
                $q->orWhere('i_code', 'like', '%'.$cari.'%');
                $q->orWhere('i_nama', 'like', '%'.$cari.'%');
            })->get();

        if ($nama == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                if ($query->i_code != null || $query->i_code != '') {
                    $results[] = ['id' => $query->i_id, 'label' => $query->i_code.' - '.$query->i_nama ];
                } else {
                    $results[] = ['id' => $query->i_id, 'label' => $query->i_nama ];
                }
            }
        }
        return Response::json($results);
    }

    public function rencana_pembelian()
    {

        return view('pembelian/rencana_pembelian/index');
    }

    public function rencanaMenunggu()
    {
        // $prive = Auth::user()->m_comp;
        $user = Auth::user()->m_id;

        // if($prive == "PF00000001"){
        //     $menunggu = DB::table('d_purchase_plan')
        //     ->select(
        //         'd_purchase_plan.pp_id',
        //         'd_purchase_plan.pp_item',
        //         'd_purchase_plan.pp_qtyreq',
        //         'd_purchase_plan.pp_status',
        //         DB::raw('date_format(pp_date, "%d/%m/%Y") as pp_date'),
        //         'd_item.i_nama'
        //     )
        //     ->join('d_item', 'd_purchase_plan.pp_item', '=', 'd_item.i_id')
        //     ->join('d_mem', 'd_purchase_plan.pr_userId', '=', 'd_mem.m_id')
        //     ->where('d_purchase_plan.pp_status', 'P')
        //     ->get();

        // }else{
            $menunggu = DB::table('d_purchase_plan')
            ->select(
                'd_purchase_plan.pp_id',
                'd_purchase_plan.pp_item',
                'd_purchase_plan.pp_qtyreq',
                'd_purchase_plan.pp_status',
                DB::raw('date_format(pp_date, "%d/%m/%Y") as pp_date'),
                'd_item.i_nama'
            )
            ->join('d_item', 'd_purchase_plan.pp_item', '=', 'd_item.i_id')
            // ->join('d_mem', 'd_purchase_plan.pr_userId', '=', 'd_mem.m_id')
            ->where('d_purchase_plan.pp_status', 'P')
            ->get();
        // }

        return DataTables::of($menunggu)

            ->addColumn('aksi', function ($menunggu) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $menunggu->pp_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $menunggu->pp_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $menunggu->pp_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $menunggu->pp_id . '\', \'' . $menunggu->pp_id . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input', 'aksi'])
            ->make(true);
    }

    public function rencanaDisetujui()
    {
        $prive = Auth::user()->m_comp;
        if($prive == "PF00000001"){
            $setujui = DB::table('d_purchase_plan')
            ->select(
                'd_purchase_plan.pp_id',
                'd_purchase_plan.pp_item',
                'd_purchase_plan.pp_qtyreq',
                'd_purchase_plan.pp_qtyappr',
                'd_purchase_plan.pp_status',
                'd_purchase_plan.pp_date',
                'd_purchase_plan.pp_insert',
                'd_item.i_nama'
                // 'm_company.c_name'
            )
            ->join('d_item', 'd_purchase_plan.pp_item', '=', 'd_item.i_id')
            ->where('d_purchase_plan.pp_status', 'Y')
            ->get();
        }else{
            $setujui = DB::table('d_purchase_plan')
            ->select(
                'd_purchase_plan.pp_id',
                'd_purchase_plan.pp_item',
                'd_purchase_plan.pp_qtyreq',
                'd_purchase_plan.pp_qtyappr',
                'd_purchase_plan.pp_status',
                'd_purchase_plan.pp_date',
                'd_purchase_plan.pp_insert',
                'd_item.i_nama'
                // 'm_company.c_name'
            )
            ->join('d_item', 'd_purchase_plan.pp_item', '=', 'd_item.i_id')
            ->where('d_purchase_plan.pp_status', 'Y')
            ->get();
        }


        return DataTables::of($setujui)
            ->addColumn('input', function ($setujui) {

                return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTy"  style="text-transform: uppercase" /></div>';

            })
            // ->addColumn('aksi', function ($setujui) {
            //     if (Plasma::checkAkses(47, 'update') == false) {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $setujui->pr_idPlan . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
            //     } else {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $setujui->pr_idPlan . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $setujui->pr_idPlan . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $setujui->pr_idPlan . '\', \'' . $setujui->pr_idPlan . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
            //     }
            // })
            ->rawColumns(['input', 'aksi'])
            ->make(true);
    }

    public function rencanaDitolak()
    {
        $prive = Auth::user()->m_comp;

        if($prive == "PF00000001"){
        $ditolak = DB::table('d_purchase_plan')
            ->select(
                'd_purchase_plan.pr_idPlan',
                'd_purchase_plan.pr_idReq',
                'd_purchase_plan.pr_itemPlan',
                'd_purchase_plan.pr_qtyReq',
                'd_purchase_plan.pr_qtyApp',
                'd_purchase_plan.pr_stsPlan',
                'd_purchase_plan.pr_dateRequest',
                'd_purchase_plan.pr_dateApp',
                'd_purchase_plan.pr_comp',
                'd_item.i_nama',
                'm_company.c_name'
            )
            ->join('d_item', 'd_purchase_plan.pr_itemPlan', '=', 'd_item.i_id')
            ->join('d_mem', 'd_purchase_plan.pr_userId', '=', 'd_mem.m_id')
            ->join('m_company', 'd_mem.m_comp', '=', 'm_company.c_id')
            ->where('d_purchase_plan.pr_stsPlan', 'DITOLAK')
            ->get();
        }else{
            $ditolak = DB::table('d_purchase_plan')
            ->select(
                'd_purchase_plan.pr_idPlan',
                'd_purchase_plan.pr_idReq',
                'd_purchase_plan.pr_itemPlan',
                'd_purchase_plan.pr_qtyReq',
                'd_purchase_plan.pr_qtyApp',
                'd_purchase_plan.pr_stsPlan',
                'd_purchase_plan.pr_dateRequest',
                'd_purchase_plan.pr_dateApp',
                'd_purchase_plan.pr_comp',
                'd_item.i_nama',
                'm_company.c_name'
            )
            ->join('d_item', 'd_purchase_plan.pr_itemPlan', '=', 'd_item.i_id')
            ->join('d_mem', 'd_purchase_plan.pr_userId', '=', 'd_mem.m_id')
            ->join('m_company', 'd_mem.m_comp', '=', 'm_company.c_id')
            ->where('d_purchase_plan.pr_stsPlan', 'DITOLAK')
            ->where('d_purchase_plan.pr_comp', $prive)
            ->get();
        }

        return DataTables::of($ditolak)
            ->addColumn('input', function ($ditolak) {

                return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTy"  style="text-transform: uppercase" /></div>';

            })
            // ->addColumn('aksi', function ($ditolak) {
            //     if (Plasma::checkAkses(47, 'update') == false) {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $ditolak->pr_idPlan . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
            //     } else {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $ditolak->pr_idPlan . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $ditolak->pr_idPlan . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $ditolak->pr_idPlan . '\', \'' . $ditolak->pr_idPlan . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
            //     }
            // })
            ->rawColumns(['input', 'aksi'])
            ->make(true);
    }

    public function rencanaSemua()
    {
        $prive = Auth::user()->m_comp;

        if($prive == "PF00000001"){
        $semua = DB::table('d_purchase_plan')
            ->select(
                'd_purchase_plan.pp_id',
                'd_purchase_plan.pp_date',
                'd_purchase_plan.pp_item',
                'd_purchase_plan.pp_qtyreq',
                'd_purchase_plan.pp_qtyappr',
                'd_purchase_plan.pp_status',
                'd_purchase_plan.pp_insert',
                'd_item.i_nama'
            )
            ->join('d_item', 'd_purchase_plan.pp_item', '=', 'd_item.i_id')
            ->get();
        }else{
            $semua = DB::table('d_purchase_plan')
            ->select(
                'd_purchase_plan.pp_id',
                'd_purchase_plan.pp_date',
                'd_purchase_plan.pp_item',
                'd_purchase_plan.pp_qtyreq',
                'd_purchase_plan.pp_qtyappr',
                'd_purchase_plan.pp_status',
                'd_purchase_plan.pp_insert',
                'd_item.i_nama'
            )
            ->join('d_item', 'd_purchase_plan.pp_item', '=', 'd_item.i_id')
            ->where('d_purchase_plan.pr_comp',$prive)
            ->get();
        }

        return DataTables::of($semua)
            ->addColumn('input', function ($semua) {

                return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTy"  style="text-transform: uppercase" /></div>';

            })
            // ->addColumn('aksi', function ($semua) {
            //     if (Plasma::checkAkses(47, 'update') == false) {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $semua->pr_idPlan . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
            //     } else {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $semua->pr_idPlan . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $semua->pr_idPlan . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $semua->pr_idPlan . '\', \'' . $semua->pr_idPlan . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
            //     }
            // })
            ->rawColumns(['input', 'aksi'])
            ->make(true);

    }

    public function simpanConfirm(Request $request)
    {
        $pr_supplier = $request->input('supplier');

        $dateReq    = Carbon::now('Asia/Jakarta');
        $status     = 'WAITING';
        $code       = Carbon::now()->timestamp;
        $numberPlan = "CONF-".$code;
        $user       = Auth::user()->m_id;

        $query = DB::table('d_purchase_plan_dd')
            ->select('d_purchase_plan_dd.*')
            ->where('d_purchase_plan_dd.pr_stsPlan', $status)
            ->where('d_purchase_plan_dd.pr_userId',$user)
            ->get();


        $baris = count($query);

        if($baris =="0"){
            $data = "notFound";
            echo json_encode(array("status" => $data));
        }else{
            $pr_dateApp = Carbon::now('Asia/Jakarta');
            $pr_stsPlan = "WAITING";

                 $addAkses = [];
                    for ($i=0; $i < count($query); $i++) {
                        $temp = [

                            // 'pr_idPlan' =>$query[$i]->pr_idPlan,
                            'pr_supplier'      => $pr_supplier,
                            'pr_item'          => $query[$i]->pr_itemPlan,
                            'pr_price'         => $query[$i]->pr_harga_satuan,
                            'pr_qtyApp'        => $query[$i]->pr_qtyApp,
                            'pr_stsConf'       => $pr_stsPlan,
                            'pr_dateApp'       => $dateReq,
                            'pr_comp'          => Auth::user()->m_comp,
                            'pr_confirmNumber' => $numberPlan,
                            'total'            => $query[$i]->pr_harga_satuan * $query[$i]->pr_qtyApp
                        ];
                        array_push($addAkses, $temp);
                    }

            $insert = DB::table('d_purchase_confirm')->insert($addAkses);
            if (!$insert) {

                $data = "GAGAL";
                echo json_encode(array("status" => $data));
            } else {
                $reqOrder = DB::table('d_purchase_plan')
                        ->where('d_purchase_plan.pr_stsPlan','WAITING')
                        ->where('d_purchase_plan.pr_userId',$user)
                        ->update([
                            'pr_stsPlan' => 'CONFIRM',
                            'pr_codeConf'=> $numberPlan
                        ]);
                        if (!$reqOrder) {
                            $data = "GAGAL";
                            echo json_encode(array("status" => $data));
                        } else {
                            $data = "SUKSES";
                            echo json_encode(array("status" => $data));
                        }

            }
        }


    }

    public function getRequest_dumy(Request $request)
    {


        $pr_compReq = $request->input('comp');

        $dateReq    = Carbon::now('Asia/Jakarta');
        $status     = 'WAITING';
        $code       = Carbon::now()->timestamp;
        $numberPlan = "PL-".$code;
        $user       = Auth::user()->m_id;

        if($pr_compReq =="semua"){
            $query = DB::table('d_purchase_req')
            ->select('d_purchase_req.*','d_purchase_req.pr_id', 'd_purchase_req.pr_codeReq', 'd_item.i_nama', 'd_purchase_req.pr_compReq', 'd_purchase_req.pr_itemReq', 'd_purchase_req.pr_qtyReq', 'd_purchase_req.pr_dateReq', 'd_purchase_req.pr_stsReq','d_purchase_req_dumy.pr_qtyApp_dumy')
            ->join('d_item', 'd_purchase_req.pr_itemReq', '=', 'd_item.i_id')
            ->join('d_purchase_req_dumy','d_purchase_req.pr_id','=','d_purchase_req_dumy.pr_id')
            ->where('d_purchase_req.pr_stsReq', $status)
            ->get();
        }else{
            $query = DB::table('d_purchase_req')
            ->select('d_purchase_req.*','d_purchase_req.pr_id', 'd_purchase_req.pr_codeReq', 'd_item.i_nama', 'd_purchase_req.pr_compReq', 'd_purchase_req.pr_itemReq', 'd_purchase_req.pr_qtyReq', 'd_purchase_req.pr_dateReq', 'd_purchase_req.pr_stsReq','d_purchase_req_dumy.pr_qtyApp_dumy')
            ->join('d_item', 'd_purchase_req.pr_itemReq', '=', 'd_item.i_id')
            ->join('d_purchase_req_dumy','d_purchase_req.pr_id','=','d_purchase_req_dumy.pr_id')
            ->where('d_purchase_req.pr_compReq', $pr_compReq)
            ->where('d_purchase_req.pr_stsReq', $status)
            ->get();
        }




        $baris = count($query);

        if($baris =="0"){
            $data = "notFound";
            echo json_encode(array("status" => $data));
        }else{
            $pr_dateApp = Carbon::now('Asia/Jakarta');
            $pr_stsPlan = "WAITING";

                 $addAkses = [];
                    for ($i=0; $i < count($query); $i++) {
                        $temp = [

                            'pr_itemPlan'    => $query[$i]->pr_itemReq,
                            'pr_comp'        => $query[$i]->pr_compReq,
                            'pr_planNumber'  => $numberPlan,
                            'pr_idReq'       => $query[$i]->pr_id,
                            'pr_qtyReq'      => $query[$i]->pr_qtyReq,
                            'pr_qtyApp'      => $query[$i]->pr_qtyApp_dumy,
                            'pr_stsPlan'     => $pr_stsPlan,
                            'pr_dateRequest' => $query[$i]->pr_dateReq,
                            'pr_dateApp'     => $pr_dateApp,
                            'pr_userId'      => $user
                        ];
                        array_push($addAkses, $temp);
                    }

            $insert = DB::table('d_purchase_plan')->insert($addAkses);
            if (!$insert) {

                $data = "GAGAL";
                echo json_encode(array("status" => $data));
            } else {

                $def = DB::table('d_purchase_req_dumy')
                    ->select('d_purchase_req_dumy.*')
                    ->where('d_purchase_req_dumy.pr_userId',$user)
                    ->get();

                    foreach ($def as $key => $value) {
                        $dat['coloum'] = $value;
                    }

                    $dat = array();
                    foreach ($def as $key) {
                       $row = array();
                       $row[] = $key->pr_id;
                       $dat[] = $row;
                    }

                   $update = DB::table('d_purchase_req')
                   ->whereIn('d_purchase_req.pr_id',$dat)
                   ->update([
                       'pr_stsReq'=>'DIPROSES'
                   ]);

                   DB::table('d_purchase_req_dumy')
                   ->where('d_purchase_req_dumy.pr_userId','=',$user)
                   ->delete();

                   $data = "SUKSES";
                    echo json_encode(array("status" => $data));

            }
        }




    }


    public function view_tambahRencana_dumy(Request $request)
    {
        $comp = $request->input('comp');
        $user = Auth::user()->m_id;
        if($comp == "semua"){
            $tambahRencana = DB::table('d_purchase_req_dumy')
            ->select(
                'd_requestorder.ro_id',
                'm_company.c_name',
                'd_item.i_nama',
                'd_purchase_req_dumy.pr_qtyReq_dumy',
                'd_purchase_req_dumy.pr_qtyApp_dumy',
                'd_requestorder.ro_date',
                'd_requestorder.ro_state'
            )
            ->join('m_company', 'd_mem.m_comp', '=', 'm_company.c_id')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            // ->where('d_requestorder.ro_comp',$comp)
            ->get();
        }else{
            $tambahRencana = DB::table('d_purchase_req_dumy')
            ->select(
                'd_requestorder.ro_id',
                'm_company.c_name',
                'd_item.i_nama',
                'd_purchase_req_dumy.pr_qtyReq_dumy',
                'd_purchase_req_dumy.pr_qtyApp_dumy',
                'd_requestorder.ro_date',
                'd_requestorder.ro_state'
            )
            ->join('d_mem', 'd_requestorder.pr_userId', '=', 'd_mem.m_id')
            ->join('m_company', 'd_mem.m_comp', '=', 'm_company.c_id')
            ->join('d_item', 'd_requestorder.pr_itemReq', '=', 'd_item.i_id')
            ->where('d_requestorder.pr_userId',$user)
            ->where('d_purchase_req_dumy.pr_compReq', $comp)
            ->get();
        }


            $data = array();
            $i = 0;
        foreach ($tambahRencana as $hasil) {

            $row = array();
            $row[] = $i++;
            $row[] = $hasil->c_name;
            $row[] = $hasil->i_nama;
            $row[] = $hasil->pr_qtyReq;
            $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $hasil->pr_id . '" value="'.$hasil->pr_qtyApp .'"  style="text-transform: uppercase" onkeyup="apply(' . $hasil->pr_id . ')"/></div>';
            $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="App qty" onclick="apply(' . $hasil->pr_id . ')"><i class="glyphicon glyphicon-list"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $hasil->pr_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $hasil->pr_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
            $data[] = $row;
        }

        echo json_encode(array("data"=>$data));
    }

    public function view_tambahRencana(Request $request)
    {
        $comp = $request->input('comp');
        $userCreate = Auth::user()->m_id;

        if($comp =="semua"){

            $cek = DB::table('d_purchase_req_dumy')
                ->where('d_purchase_req_dumy.pr_userId',$userCreate)
                ->delete();

            $query2 = DB::table('d_requestorder')
                ->select('d_requestorder.*')
                ->get();

            $query = DB::table('d_requestorder')
                ->select('d_requestorder.*')
                ->where('d_requestorder.ro_state', 'P')
                ->get();

            $data = array();
            foreach ($query as $key) {
                $row    = array();
                $row[]  = $key->ro_id;
                $data[] = $row;
            }

            $cek_id = DB::table('d_purchase_req_dumy')
                ->select('d_purchase_req_dumy.*')
                ->whereIn('pr_id',$data)
                ->get();

            $baris_id = count($cek_id);

            if($baris_id == '0'){

                $baris = count($query2);

                if($baris=="0"){
                    $no = "1";
                }else{
                    $no = $baris+1;
                }

                    $addAkses = [];
                            for ($i=0; $i < count($query); $i++) {
                                $temp = [
                                    'pr_id'          => $query[$i]->ro_id,
                                    'pr_compReq'     => $query[$i]->ro_comp,
                                    'pr_item'        => $query[$i]->ro_item,
                                    'pr_qtyReq_dumy' => $query[$i]->ro_qty,
                                    'pr_qtyApp_dumy' => $query[$i]->ro_qty,
                                    'pr_userId'      => $userCreate
                                ];
                                array_push($addAkses, $temp);
                            }

                    $insert = DB::table('d_purchase_req_dumy')->insert($addAkses);

                    if(!$insert){
                        if($comp=="semua"){
                            $tambahRencana = DB::table('d_requestorder')
                            ->select(
                                'd_requestorder.*',
                                'd_purchase_req_dumy.*',
                                'd_item.i_nama',
                                'm_company.c_name'
                            )
                            ->join('d_purchase_req_dumy','d_requestorder.ro_id','=','d_purchase_req_dumy.pr_id')
                            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
                            ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
                            ->where('d_requestorder.ro_state', 'P')
                            ->get();

                            $data = array();
                            $i = 1;
                            foreach ($tambahRencana as $key) {
                            $row = array();
                            $row[] = $i++;
                            $row[] = $key->c_name;
                            $row[] = $key->i_nama;
                            $row[] = $key->pr_qtyReq_dumy;
                            $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_id . '" value="'.$key->pr_qtyApp_dumy .'"  style="text-transform: uppercase" onkeyup="editTable(' .$key->pr_id . ')"/></div>';
                            $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="App qty" onclick="apply(' . $key->pr_id . ')"><i class="glyphicon glyphicon-list"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $key->pr_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $key->pr_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                            $data[] = $row;
                            }

                            echo json_encode(array("data"=>$data));
                        }else{
                            $tambahRencana = DB::table('d_requestorder')
                            ->select(
                                'd_requestorder.*',
                                'd_purchase_req_dumy.*',
                                'd_item.i_nama',
                                'm_company.c_name'
                            )
                            ->join('d_purchase_req_dumy','d_requestorder.ro_id','=','d_purchase_req_dumy.pr_id')
                            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
                            ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
                            ->where('d_requestorder.ro_state', 'P')
                            ->where('d_requestorder.ro_comp',$comp)
                            ->get();
                            $data = array();
                            $i = 1;
                            foreach ($tambahRencana as $key) {
                            $row = array();
                            $row[] = $i++;
                            $row[] = $key->c_name;
                            $row[] = $key->i_nama;
                            $row[] = $key->pr_qtyReq_dumy;
                            $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_id . '" value="'.$key->pr_qtyApp_dumy .'"  style="text-transform: uppercase" onkeyup="editTable(' .$key->pr_id . ')"/></div>';
                            $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="App qty" onclick="apply(' . $key->pr_id . ')"><i class="glyphicon glyphicon-list"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $key->pr_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $key->pr_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                            $data[] = $row;
                            }

                            echo json_encode(array("data"=>$data));
                        }


                    }else{
                        $tambahRencana = DB::table('d_requestorder')
                        ->select(
                            'd_requestorder.*',
                            'd_purchase_req_dumy.*',
                            'd_item.i_nama',
                            'm_company.c_name'
                        )
                        ->join('d_purchase_req_dumy','d_requestorder.ro_id','=','d_purchase_req_dumy.pr_id')
                        ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
                        ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
                        ->where('d_requestorder.ro_state', 'P')
                        ->where('d_purchase_req_dumy.pr_userId', $userCreate)
                        ->get();
                        $data = array();
                        $i = 1;
                        foreach ($tambahRencana as $key) {
                        $row = array();
                        $row[] = $i++;
                        $row[] = $key->c_name;
                        $row[] = $key->i_nama;
                        $row[] = $key->pr_qtyReq_dumy;
                        $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_id . '" value="'.$key->pr_qtyApp_dumy .'"  style="text-transform: uppercase" onkeyup="editTable(' .$key->pr_id . ')"/></div>';
                        $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="App qty" onclick="apply(' . $key->pr_id . ')"><i class="glyphicon glyphicon-list"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $key->pr_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $key->pr_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                        $data[] = $row;
                        }

                        echo json_encode(array("data"=>$data));
                    }

            }else{
                $tambahRencana = DB::table('d_requestorder')
                            ->select(
                                'd_requestorder.*',
                                'd_purchase_req_dumy.*',
                                'd_item.i_nama',
                                'm_company.c_name'
                            )
                            ->join('d_purchase_req_dumy','d_requestorder.ro_id','=','d_purchase_req_dumy.pr_id')
                            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
                            ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
                            ->where('d_requestorder.ro_state', 'P')
                            ->where('d_purchase_req_dumy.pr_userId', $userCreate)
                            ->get();
                            $data = array();
                            $i = 1;
                            foreach ($tambahRencana as $key) {
                            $row = array();
                            $row[] = $i++;
                            $row[] = $key->c_name;
                            $row[] = $key->i_nama;
                            $row[] = $key->pr_qtyReq_dumy;
                            $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_id . '" value="'.$key->pr_qtyApp_dumy .'"  style="text-transform: uppercase" onkeyup="editTable(' .$key->pr_id . ')"/></div>';
                            $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="App qty" onclick="apply(' . $key->pr_id . ')"><i class="glyphicon glyphicon-list"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $key->pr_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $key->pr_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                            $data[] = $row;
                            }

                            echo json_encode(array("data"=>$data));
            }


        }else{
            $cek = DB::table('d_purchase_req_dumy')
            ->where('d_purchase_req_dumy.pr_userId',$userCreate)
            ->delete();

            $query2 = DB::table('d_requestorder')
            ->select('d_requestorder.*')
            ->get();

            $query = DB::table('d_requestorder')
            ->select(
                'd_requestorder.*'
            )
            ->where('d_requestorder.ro_state', 'P')
            ->where('d_requestorder.ro_comp',$comp)
            ->get();

            $data = array();
            foreach ($query as $key) {
                $row = array();
                $row[]  = $key->pr_id;
                $data[] = $row;
            }

            $cek_id = DB::table('d_purchase_req_dumy')
            ->select('d_purchase_req_dumy.*')
            ->whereIn('pr_id',$data)
            ->get();

            $baris_id = count($cek_id);

            if($baris_id == '0'){
                $baris = count($query2);

                if($baris=="0"){
                    $no = "1";
                }else{
                    $no = $baris+1;
                }

                    $addAkses = [];
                            for ($i=0; $i < count($query); $i++) {
                                $temp = [
                                    'pr_id'          => $query[$i]->ro_id,
                                    'pr_compReq'     => $query[$i]->ro_comp,
                                    'pr_item'        => $query[$i]->ro_item,
                                    'pr_qtyReq_dumy' => $query[$i]->ro_qty,
                                    'pr_qtyApp_dumy' => $query[$i]->ro_qty,
                                    'pr_userId'      => $userCreate
                                ];
                                array_push($addAkses, $temp);
                            }

                    $insert = DB::table('d_purchase_req_dumy')->insert($addAkses);

                    if(!$insert){
                        if($comp=="semua"){
                            $tambahRencana = DB::table('d_requestorder')
                            ->select(
                                'd_requestorder.*',
                                'd_purchase_req_dumy.*',
                                'd_item.i_nama',
                                'm_company.c_name'
                            )
                            ->join('d_purchase_req_dumy','d_requestorder.ro_id','=','d_purchase_req_dumy.pr_id')
                            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
                            ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
                            ->where('d_requestorder.ro_state', 'P')
                            ->get();
                            $data = array();
                            $i = 1;
                            foreach ($tambahRencana as $key) {
                            $row = array();
                            $row[] = $i++;
                            $row[] = $key->c_name;
                            $row[] = $key->i_nama;
                            $row[] = $key->pr_qtyReq_dumy;
                            $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_id . '" value="'.$key->pr_qtyApp_dumy .'"  style="text-transform: uppercase" onkeyup="editTable(' .$key->pr_id . ')"/></div>';
                            $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="App qty" onclick="apply(' . $key->pr_id . ')"><i class="glyphicon glyphicon-list"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $key->pr_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $key->pr_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                            $data[] = $row;
                            }

                            echo json_encode(array("data"=>$data));
                        }else{
                            $tambahRencana = DB::table('d_requestorder')
                            ->select(
                                'd_requestorder.*',
                                'd_purchase_req_dumy.*',
                                'd_item.i_nama',
                                'm_company.c_name'
                            )
                            ->join('d_purchase_req_dumy','d_requestorder.ro_id','=','d_purchase_req_dumy.pr_id')
                            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
                            ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
                            ->where('d_requestorder.ro_state', 'P')
                            ->where('d_requestorder.ro_comp',$comp)
                            ->where('d_purchase_req_dumy.pr_userId', $userCreate)
                            ->get();
                            $data = array();
                            $i = 1;
                            foreach ($tambahRencana as $key) {
                            $row = array();
                            $row[] = $i++;
                            $row[] = $key->c_name;
                            $row[] = $key->i_nama;
                            $row[] = $key->pr_qtyReq_dumy;
                            $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_id . '" value="'.$key->pr_qtyApp_dumy .'"  style="text-transform: uppercase" onkeyup="editTable(' .$key->pr_id . ')"/></div>';
                            $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="App qty" onclick="apply(' . $key->pr_id . ')"><i class="glyphicon glyphicon-list"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $key->pr_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $key->pr_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                            $data[] = $row;
                            }

                            echo json_encode(array("data"=>$data));
                        }


                    }else{
                        $tambahRencana = DB::table('d_requestorder')
                        ->select(
                            'd_requestorder.*',
                            'd_purchase_req_dumy.*',
                            'd_item.i_nama',
                            'm_company.c_name'
                        )
                        ->join('d_purchase_req_dumy','d_requestorder.ro_id','=','d_purchase_req_dumy.pr_id')
                        ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
                        ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
                        ->where('d_requestorder.ro_state', 'P')
                        ->where('d_purchase_req_dumy.pr_userId',$userCreate)
                        ->where('d_purchase_req_dumy.pr_userId', $userCreate)
                        ->get();
                        $data = array();
                        $i = 1;
                        foreach ($tambahRencana as $key) {
                        $row = array();
                        $row[] = $i++;
                        $row[] = $key->c_name;
                        $row[] = $key->i_nama;
                        $row[] = $key->pr_qtyReq_dumy;
                        $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_id . '" value="'.$key->pr_qtyApp_dumy .'"  style="text-transform: uppercase" onkeyup="editTable(' .$key->pr_id . ')"/></div>';
                        $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="App qty" onclick="apply(' . $key->pr_id . ')"><i class="glyphicon glyphicon-list"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $key->pr_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $key->pr_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                        $data[] = $row;
                        }

                        echo json_encode(array("data"=>$data));
                    }

            }else{
                $tambahRencana = DB::table('d_requestorder')
                            ->select(
                                'd_requestorder.*',
                                'd_purchase_req_dumy.*',
                                'd_item.i_nama',
                                'm_company.c_name'
                            )
                            ->join('d_purchase_req_dumy','d_requestorder.ro_id','=','d_purchase_req_dumy.pr_id')
                            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
                            ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
                            ->where('d_requestorder.ro_state', 'P')
                            ->where('d_purchase_req_dumy.pr_userId', $userCreate)
                            ->get();
                            $data = array();
                            $i = 1;
                            foreach ($tambahRencana as $key) {
                            $row = array();
                            $row[] = $i++;
                            $row[] = $key->c_name;
                            $row[] = $key->i_nama;
                            $row[] = $key->pr_qtyReq_dumy;
                            $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_id . '" value="'.$key->pr_qtyApp_dumy .'"  style="text-transform: uppercase" onkeyup="editTable(' .$key->pr_id . ')"/></div>';
                            $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="App qty" onclick="apply(' . $key->pr_id . ')"><i class="glyphicon glyphicon-list"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $key->pr_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $key->pr_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
                            $data[] = $row;
                            }

                            echo json_encode(array("data"=>$data));
            }
        }

    }




    public function itemSuplier()
    {
        $query = DB::table('d_supplier')
            ->select('d_supplier.s_id', 'd_supplier.s_company')
            ->get();
        echo json_encode($query);
    }

    public function tambahRencana(Request $request)
    {
        $comp     = Auth::user()->m_id;
        $req_id   = $request->input('req_id');
        $item_id  = $request->input('item_id');
        $qtyApp   = $request->input('qtyApp');
        $req_date = Carbon::now('Asia/Jakarta');

        DB::beginTransaction();
        try {
            DB::table('d_requestorder')
            ->whereIn('ro_id', $req_id)
            ->update([
                'ro_state' => 'Y'
            ]);

            for($i = 0; $i < count($item_id);$i++){

                $chek = DB::table('d_purchase_plan')
                    ->where('pp_item', '=', $item_id[$i])
                    ->where('pp_status', '=', 'P')
                    ->get();

                if (count($chek) > 0){
                    $qtyAkhir = $qtyApp[$i] + $chek[0]->pp_qtyreq;
                    DB::table('d_purchase_plan')
                    ->where('pp_item', '=', $item_id[$i])
                    ->update([
                        'pp_qtyreq' => $qtyAkhir
                    ]);

                } else {
                    DB::table('d_purchase_plan')->insert([
                        'pp_date'   => $req_date,
                        'pp_item'   => $item_id[$i],
                        'pp_qtyreq' => $qtyApp[$i],
                        'pp_status' => 'P'
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data'   => $e
            ]);
        }

    }

    public function tolakRequest(Request $request)
    {
        dd($request);
        $req_id = $request->input('id');
        DB::beginTransaction();
        try {
            DB::table('d_requestorder')
            ->where('ro_id', $req_id)
            ->update([
                'ro_state' => 'N'
            ]);

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);

        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data'   => $e
            ]);
        }
    }

    public function getRequest_id(Request $request)
    {
        $id = $request->input('id');
        $query = DB::table('d_purchase_req')
            ->SELECT(
                'd_purchase_req.pr_id',
                'd_purchase_req.pr_codeReq',
                'd_purchase_req.pr_compReq',
                'd_purchase_req.pr_itemReq',
                'd_purchase_req.pr_qtyReq',
                'd_purchase_req.pr_dateReq',
                'd_purchase_req.pr_stsReq',
                'd_item.i_id',
                'd_item.i_kelompok',
                'd_item.i_group',
                'd_item.i_sub_group',
                'd_item.i_merk',
                'd_item.i_nama',
                'd_item.i_specificcode',
                'd_item.i_code',
                'd_item.i_isactive',
                'd_item.i_price',
                'd_item.i_minstock',
                'd_item.i_berat',
                'd_item.i_img',
                'm_company.c_id',
                'm_company.c_name',
                'm_company.c_address',
                'm_company.c_tlp'
            )

            ->join('d_mem', 'd_purchase_req.pr_userId', '=', 'd_mem.m_id')
            ->join('d_item', 'd_purchase_req.pr_itemReq', '=', 'd_item.i_id')
            ->join('m_company', 'd_mem.m_comp', '=', 'm_company.c_id')
            ->where('d_purchase_req.pr_id', $id)
            ->get();


        foreach ($query as $value) {
            $pr_id2         = $value->pr_id;
            $pr_codeReq     = $value->pr_codeReq;
            $pr_compReq     = $value->pr_compReq;
            $pr_itemReq     = $value->pr_itemReq;
            $pr_qty         = $value->pr_qtyReq;
            $pr_dateReq     = $value->pr_dateReq;
            $pr_stsReq      = $value->pr_stsReq;
            $i_id           = $value->i_id;
            $i_kelompok     = $value->i_kelompok;
            $i_group        = $value->i_group;
            $i_sub_group    = $value->i_sub_group;
            $i_merk         = $value->i_merk;
            $i_nama         = $value->i_nama;
            $i_specificcode = $value->i_specificcode;
            $i_code         = $value->i_code;
            $i_isactive     = $value->i_isactive;
            $i_price        = $value->i_price;
            $i_minstock     = $value->i_minstock;
            $i_berat        = $value->i_berat;
            $i_img          = $value->i_img;
            $c_name         = $value->c_name;
            $c_address      = $value->c_address;
            $c_tlp          = $value->c_tlp;
        }

        $item = array(
            'pr_id'          => $pr_id2,
            "pr_codeReq"     => $pr_codeReq,
            "pr_compReq"     => $pr_compReq,
            "pr_itemReq"     => $pr_itemReq,
            "pr_qtyReq"      => $pr_qty,
            "pr_dateReq"     => $pr_dateReq,
            "pr_stsReq"      => $pr_stsReq,
            "i_id"           => $i_id,
            "i_kelompok"     => $i_kelompok,
            "i_group"        => $i_group,
            "i_sub_group"    => $i_sub_group,
            "i_merk"         => $i_merk,
            "i_nama"         => $i_nama,
            "i_specificcode" => $i_specificcode,
            "i_code"         => $i_code,
            "i_isactive"     => $i_isactive,
            "i_price"        => $i_price,
            "i_minstock"     => $i_minstock,
            "i_berat"        => $i_berat,
            "i_img"          => $i_img,
            "c_name"         => $c_name,
            "c_address"      => $c_address,
            "c_tlp"          => $c_tlp
        );

        echo json_encode(array("data" => $item));
    }

    public function getBarang_input(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('d_item')
            // ->select('d_item.i_nama')
                ->where('d_item.i_nama', 'LIKE', "%{$query}%")
                ->get();

            $output = '<ul class="dropdown-menu table-responsive" style="display:block; position:relative" >';
            foreach ($data as $row) {
                $output .= '<li><a href="#" >' . $row->i_nama . '</a></li>';
            }
            $output .= '</ul';
            echo $output;
        }

        // $term = $request->input('term');

        // $results = array();

        // $queries = DB::table('d_item')
        //     ->where('i_id', 'LIKE', '%'.$term.'%')
        //     ->orWhere('i_nama', 'LIKE', '%'.$term.'%')
        //     ->take(5)->get();

        // foreach ($queries as $query)
        // {
        //     $results[] = [ 'i_id' => $query->i_id, 'value' => $query->i_id.' '.$query->i_nama ];
        // }
        // return Response::json($results);

        // $input = $request->input('data');
        // $list  = DB::table('d_item')
        // ->select('d_item.*')
        // ->where('d_item.i_id','LIKE',"%{$input}%")
        // ->orWhere('d_item.i_nama','LIKE',"%{$input}%")
        // ->take(5)
        // ->get();


        // if ($list == null)
        // {
        //     $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        // } else {
        //     foreach ($list as $query) {
        //         $results[] = ['id' => $query->i_id, 'label' => $query->i_nama];
        //     }
        // }

        // echo json_encode($results);
    }

    // start konfirm order-----------------------------------------------------------------------------------------------------------

    public function konfirmasi_pembelian()
    {

        return view('pembelian/konfirmasi_pembelian/view_konfirmasi_pembelian');
    }

    public function view_addKonfirmasi()
    {

        return view('pembelian/konfirmasi_pembelian/add_konfirmasi_pembelian');
    }

    public function view_confirmApp()
    {
        $confirmOrder = DB::table('d_purchase_confirm')
            ->select(
                'd_purchase_confirm.pc_id',
                'd_purchase_confirm.pc_date',
                'd_purchase_confirm.pc_nota',
                'd_purchase_confirm.pc_supplier',
                'd_purchase_confirm.pc_insert',
                'd_purchase_confirm.pc_status',
                'd_item.i_nama')
                // 'd_supplier.s_company')
            // ->join('m_company', 'd_purchase_confirm.pr_comp', '=', 'm_company.c_id')
            ->join('d_purchase_confirmdt','pcd_purchaseconfirm', '=', 'pc_id')
            ->join('d_item', 'd_purchase_confirmdt.pcd_item', '=', 'd_item.i_id')
            // ->join('d_supplier', 'd_purchase_confirm.pc_supplier', '=', 'd_supplier.s_id')
            ->where('d_purchase_confirm.pc_status', 'P')
            ->get();
        return DataTables::of($confirmOrder)
            ->addColumn('input', function ($confirmOrder) {

                return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTY"  style="text-transform: uppercase" /></div>';

            })
            ->addColumn('aksi', function ($confirmOrder) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="tambahRencana(' . $confirmOrder->pc_id . ')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $confirmOrder->pc_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $confirmOrder->pc_id . ')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input', 'aksi'])
            ->make(true);
    }

    public function view_confirmPurchase()
    {
        $confirmOrder = DB::table('d_purchase_confirm')
            ->select(
                'd_purchase_confirm.pc_id',
                'd_purchase_confirm.pc_date',
                'd_purchase_confirm.pc_nota',
                'd_purchase_confirm.pc_supplier',
                'd_purchase_confirm.pc_insert',
                'd_purchase_confirm.pc_status',
                'd_item.i_nama',
                'pcd_qty')
                // 'd_supplier.s_company')
            // ->join('m_company', 'd_purchase_confirm.pr_comp', '=', 'm_company.c_id')
            ->join('d_purchase_confirmdt','pcd_purchaseconfirm', '=', 'pc_id')
            ->join('d_item', 'd_purchase_confirmdt.pcd_item', '=', 'd_item.i_id')
            // ->join('d_supplier', 'd_purchase_confirm.pc_supplier', '=', 'd_supplier.s_id')
            ->where('d_purchase_confirm.pc_status', 'Y')
            ->get();

        return DataTables::of($confirmOrder)
            // ->addColumn('input', function ($confirmOrder) {

            //     return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTY"  style="text-transform: uppercase" /></div>';

            // })

            // ->addColumn('pr_price', function ($confirmOrder) {

            //     return ''.number_format($confirmOrder->pr_price, 0).'';


            // })
            // ->addColumn('aksi', function ($confirmOrder) {
            //     if (Plasma::checkAkses(47, 'update') == false) {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="tambahRencana(' . $confirmOrder->pc_id . ')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
            //     } else {
            //         return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $confirmOrder->pc_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $confirmOrder->pc_id . ')"><i class="glyphicon glyphicon-remove"></i></button></div>';
            //     }
            // })
            ->rawColumns(['input', 'aksi'])
            ->make(true);
    }

    public function tampilSupplier(Request $request)
    {
        $supplier = $request->input('supplier');
        $query = DB::table('d_supplier')
        ->select('d_supplier.*')
        ->where('d_supplier.s_id','=',$supplier)
        ->get();

        foreach ($query as $key){
            $s_name    = $key->s_name;
            $s_phone   = $key->s_phone;
            $s_fax     = $key->s_fax;
            $s_address = $key->s_address;
          }

          $data = array(
              's_name'    => $s_name,
              's_phone'   => $s_phone,
              's_fax'     => $s_fax,
              's_address' => $s_address
          );

          echo json_encode($data);
    }

    public function view_confirmAll()
    {
        $confirmOrder = DB::table('d_purchase_confirm')
            ->select(
                'd_purchase_confirm.pc_id',
                'd_purchase_confirm.pc_date',
                'd_purchase_confirm.pc_nota',
                'd_purchase_confirm.pc_supplier',
                'd_purchase_confirm.pc_insert',
                'd_purchase_confirm.pc_status',
                // 'd_item.i_nama',
                'd_supplier.s_company'
            )
            // ->join('m_company', 'd_purchase_confirm.pr_comp', '=', 'm_company.c_id')
            // ->join('d_item', 'd_purchase_confirm.pr_item', '=', 'd_item.i_id')
            ->join('d_supplier', 'd_purchase_confirm.pc_supplier', '=', 'd_supplier.s_id')

            ->get();

        return DataTables::of($confirmOrder)
            ->addColumn('input', function ($confirmOrder) {

                return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTY"  style="text-transform: uppercase" /></div>';

            })
            ->addColumn('aksi', function ($confirmOrder) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="tambahRencana(' . $confirmOrder->pc_id . ')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(' . $confirmOrder->pc_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $confirmOrder->pc_id . ')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input', 'aksi'])
            ->make(true);
    }

    public function view_confirmAdd_trans()
    {
        $menunggu = DB::table('d_purchase_plan_dd')
                ->select(
                    'd_purchase_plan_dd.*',
                    'd_item.i_nama',
                    'm_company.c_name'
                )
                // ->join('d_item', 'd_purchase_plan_dd.pr_itemPlan', '=', 'd_item.i_id')
                // ->join('m_company', 'd_purchase_plan_dd.pr_comp', '=', 'm_company.c_id')
                ->where('d_purchase_plan_dd.pr_stsPlan', 'WAITING')
                ->get();
                $data = array();
                $i = 1;
                foreach ($menunggu as $key) {
                $row = array();
                $row[] = $key->i_nama;
                $row[] = $key->pr_qtyApp;
                $row[] = '<div class="text-center"><span id="span'.$key->pr_idPlan.'" class="caption" onclick="editFor(' . $key->pr_idPlan . ')" >' . number_format($key->pr_harga_satuan) . ' </span><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_idPlan . '" value="' .  number_format($key->pr_harga_satuan,0,',','') . '" data-id="' . $key->pr_idPlan . '"  style="text-transform: uppercase;display:none;"  /></div>';
                // $row[] = '<div class="text-center"><span id="span'.$key->pr_idPlan.'" class="caption" onclick="editFor(' . $key->pr_idPlan . ')" >' . $key->pr_harga_satuan . ' </span><input type="text" class="form-control editor" name="i_nama" id="i_nama' . $key->pr_idPlan . '" value="' . $key->pr_harga_satuan . '" data-id="' . $key->pr_idPlan . '"  style="text-transform: uppercase;display:none;"  /></div>';
                // $row[] = '<div class="text-center"><input type="text" class="form-control editor" name="i_nama" id="i_nama' .$key->pr_idPlan . '" value="'.number_format($key->pr_harga_satuan) .'"  style="text-transform: uppercase" onkeyup="editTable(' .$key->pr_idPlan. ')"/></div>';
                // $row[] = '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="getPlan_id(' . $key->pr_idPlan . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $key->pr_idPlan . ')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                $data[] = $row;
                }

                echo json_encode(array("data"=>$data));
    }

    public function view_confirmAdd()
    {
        $userCreate = Auth::user()->m_id;

        $cek = DB::table('d_purchase_plan_dd')
        ->where('d_purchase_plan_dd.pr_userId',$userCreate)
        ->delete();

        $query2 = DB::table('d_purchase_confirm')
        ->select('d_purchase_confirm.*')
        ->get();

        $baris = count($query2);

        if($baris=="0"){
            $no = "1";
        }else{
            $no = $baris+1;
        }

        $query = DB::table('d_purchase_plan')
            ->select(
                'd_purchase_plan.*',
                'd_item.*',
                'm_company.*',
                DB::raw('sum(d_purchase_plan.pp_qtyreq) as TotalQty_req'),
                DB::raw('sum(d_purchase_plan.pp_qtyappr) as TotalQty_appr')
            )
            ->join('d_item', 'd_purchase_plan.item', '=', 'd_item.i_id')
            // ->join('m_company', 'd_purchase_plan.pp_comp', '=', 'm_company.c_id')
            ->where('d_purchase_plan.pp_status', 'P')
            // ->where('d_purchase_plan.pp_userId',$userCreate)
            ->groupBy('d_purchase_plan.pp_item')
            ->get();

            $addAkses = [];
                    for ($i=0; $i < count($query); $i++) {
                        $temp = [
                            'pr_idPlan'       => $query[$i]->pr_idPlan,
                            'pr_idReq'        => $query[$i]->pr_idReq,
                            'pr_itemPlan'     => $query[$i]->pr_itemPlan,
                            'pr_qtyReq'       => $query[$i]->TotalQty_req,
                            'pr_qtyApp'       => $query[$i]->TotalQty_app,
                            'pr_harga_satuan' => "0",
                            'pr_discount'     => "0",
                            'pr_subtotal'     => "0",
                            'pr_hpp'          => "0",
                            'pr_stsPlan'      => $query[$i]->pr_stsPlan,
                            'pr_dateRequest'  => $query[$i]->pr_dateRequest,
                            'pr_dateApp'      => $query[$i]->pr_dateApp,
                            'pr_comp'         => $query[$i]->pr_comp,
                            'pr_planNumber'   => $query[$i]->pr_planNumber,
                            'pr_userId'       => $userCreate
                        ];
                        array_push($addAkses, $temp);
                    }

            $insert = DB::table('d_purchase_plan_dd')->insert($addAkses);

            if($insert){
                $status = "SUKSES";
                echo json_encode(array("data" => $status));
            }else{
                $status = "GAGAL";
                echo json_encode(array("data" => $status));
            }

    }

    public function getPlan_id(Request $request)
    {
        $id = $request->input('id');
        $query = DB::table('d_purchase_plan_dd')
            ->SELECT(
                'd_purchase_plan_dd.*',
                'd_item.i_id',
                'd_item.i_kelompok',
                'd_item.i_group',
                'd_item.i_sub_group',
                'd_item.i_merk',
                'd_item.i_nama',
                'd_item.i_specificcode',
                'd_item.i_code',
                'd_item.i_isactive',
                'd_item.i_price',
                'd_item.i_minstock',
                'd_item.i_berat',
                'd_item.i_img',
                'm_company.c_id',
                'm_company.c_name',
                'm_company.c_address',
                'm_company.c_tlp'
                // 'd_supplier.s_id',
                // 'd_supplier.s_company',
                // 'd_supplier.s_phone'

            )

            ->join('m_company', 'd_purchase_plan_dd.pr_comp', '=', 'm_company.c_id')
            ->join('d_item', 'd_purchase_plan_dd.pr_itemPlan', '=', 'd_item.i_id')
            ->where('d_purchase_plan_dd.pr_idPlan', $id)
            ->get();


        foreach ($query as $value) {
            $pr_idPlan      = $value->pr_idPlan;
            $pr_idReq       = $value->pr_idReq;
            $pr_itemPlan    = $value->pr_itemPlan;
            $pr_supplier    = $value->pr_supplier;
            $pr_qtyApp      = $value->pr_qtyApp;
            $pr_dateApp     = $value->pr_dateApp;
            $pr_dateRequest = $value->pr_dateRequest;
            $pr_stsPlan     = $value->pr_stsPlan;
            $pr_comp        = $value->pr_comp;
            $i_id           = $value->i_id;
            $i_kelompok     = $value->i_kelompok;
            $i_sub_group    = $value->i_sub_group;
            $i_group        = $value->i_group;
            $i_merk         = $value->i_merk;
            $i_nama         = $value->i_nama;
            $i_specificcode = $value->i_specificcode;
            $i_code         = $value->i_code;
            $i_isactive     = $value->i_isactive;
            $i_price        = $value->i_price;
            $i_minstock     = $value->i_minstock;
            $i_berat        = $value->i_berat;
            $i_img          = $value->i_img;
            $c_name         = $value->c_name;
            $c_address      = $value->c_address;
            $c_tlp          = $value->c_tlp;
            // $s_id = $value->s_id;
            // $s_company = $value->s_company;
            // $s_phone = $value->s_phone;
        }

        $data = array(
            'pr_idPlan'      => $pr_idPlan,
            "pr_comp"        => $pr_comp,
            "pr_supplier"    => $pr_supplier,
            "pr_itemPlan"    => $pr_itemPlan,
            "pr_qtyApp"      => $pr_qtyApp,
            "i_id"           => $i_id,
            "i_kelompok"     => $i_kelompok,
            "i_group"        => $i_group,
            "i_sub_group"    => $i_sub_group,
            "i_merk"         => $i_merk,
            "i_nama"         => $i_nama,
            "i_specificcode" => $i_specificcode,
            "i_code"         => $i_code,
            "i_isactive"     => $i_isactive,
            "i_price"        => $i_price,
            "i_minstock"     => $i_minstock,
            "i_berat"        => $i_berat,
            "i_img"          => $i_img,
            "c_name"         => $c_name,
            "c_address"      => $c_address,
            "c_tlp"          => $c_tlp
            // "s_id" => $s_id,
            // "s_company" => $s_company,
            // "s_phone" => $s_phone
        );

        echo json_encode(array("data" => $data));

    }

    public function getSupplier()
    {
        $data = DB::table('d_supplier')
                ->select('d_supplier.*')
                ->get();
        echo json_encode($data);
    }

    public function getTelp(Request $request)
    {
        $id = $request->input('s_id');
        $data = DB::table('d_supplier')
            ->select('d_supplier.s_phone')
            ->where('d_supplier.s_id',$id)
            ->get();

        echo json_encode($data);
    }

    public function confirmSetuju(Request $request)
    {
        $pr_idPlan		= $request->input('pr_idPlan');
        $pr_supplier	= $request->input('pr_supplier');
        $pr_item		= $request->input('pr_item');
        $pr_price		= $request->input('pr_price');
        $pr_qtyApp		= $request->input('pr_qtyApp');
        $pr_stsConf		= $request->input('pr_stsConf');
        $pr_comp		= $request->input('pr_comp');
        $pr_dateApp     = Carbon::now('Asia/Jakarta');

        $list = array([
            'pr_idPlan'     => $pr_idPlan,
            'pr_supplier'   => $pr_supplier,
            'pr_item'       => $pr_item,
            'pr_price'      => $pr_price,
            'pr_qtyApp'     => $pr_qtyApp,
            'pr_stsConf'    => $pr_stsConf,
            'pr_dateApp'    => $pr_dateApp,
            'pr_comp'       => $pr_comp
            ]);

            $insert = DB::table('d_purchase_confirm')->insert($list);
            if (!$insert) {

                $data = "GAGAL";
                echo json_encode(array("status" => $data));
            } else {

                $confOrder = DB::table('d_purchase_plan')
                    ->where('d_purchase_plan.pr_idPlan', $pr_idPlan)
                    ->update([
                        'pr_stsPlan' => 'DISETUJUI',
                        'pr_qtyApp' => $pr_qtyApp
                    ]);
                if (!$confOrder) {
                    $data = "GAGAL";
                    echo json_encode(array("status" => $data));
                } else {
                    $data = "SUKSES";
                    echo json_encode(array("status" => $data));
                }

            }
    }

    public function confirmTolak(Request $request)
    {
        $pr_idPlan		= $request->input('pr_idPlan');
        $pr_supplier	= $request->input('pr_supplier');
        $pr_item		= $request->input('pr_item');
        $pr_price		= $request->input('pr_price');
        $pr_qtyApp		= $request->input('pr_qtyApp');
        $pr_stsConf		= $request->input('pr_stsConf');
        $pr_comp		= $request->input('pr_comp');
        $pr_dateApp     = Carbon::now('Asia/Jakarta');

        $confOrder = DB::table('d_purchase_plan')
                    ->where('d_purchase_plan.pr_idPlan', $pr_idPlan)
                    ->update([
                        'pr_stsPlan' => 'DITOLAK',
                    ]);

                if(!$confOrder) {

                    $data = "GAGAL";
                    echo json_encode(array("status" => $data));
                } else {
                    $data = "SUKSES";
                    echo json_encode(array("status" => $data));
                }
    }

    // end konfirm order

    // start purchase order
    public function getSupplier_po()
    {
        $data = DB::table('d_purchase_confirm')
                ->select('d_purchase_confirm.pr_supplier','d_supplier.s_company')
                ->join('d_supplier','d_purchase_confirm.pr_supplier','=','d_supplier.s_id')
                ->where('d_purchase_confirm.pr_stsConf','WAITING')
                ->groupBy('d_purchase_confirm.pr_supplier')
                ->get();
        echo json_encode($data);
    }

    public function getComp_plan()
    {
        $data = DB::table('d_purchase_req')
                ->select('d_purchase_req.pr_compReq','m_company.c_name')
                ->join('m_company','d_purchase_req.pr_compReq','=','m_company.c_id')
                ->where('d_purchase_req.pr_stsReq','WAITING')
                ->groupBy('d_purchase_req.pr_compReq')
                ->get();
        echo json_encode($data);
    }

    public function getOutlet_po(Request $request)
    {
        $id = $request->input('id');
        $data = DB::table('d_purchase_confirm')
                ->select('d_purchase_confirm.pr_comp','m_company.c_name')
                ->join('d_mem','d_purchase_confirm.pr_comp','=','d_mem.m_id')
                ->join('m_company','d_mem.m_comp','=','m_company.c_id')
                ->groupBy('d_purchase_confirm.pr_comp')
                ->get();
        echo json_encode($data);
    }
    public function multiple_insert()
    {
       $query = DB::table('d_purchase_confirm')
                ->select('d_purchase_confirm.*')
                ->get();

        $query2 = DB::table('d_purchase_confirm_copy')
        ->select('d_purchase_confirm_copy.*')
        ->get();

        $n = count($query2);


                $addAkses = [];
                for ($i=0; $i < count($query); $i++) {
                    $temp = [
                        // 'pr_idConf' =>$query[$i]->pr_idConf,
                        'pr_idPlan'   => $query[$i]->pr_idPlan,
                        'pr_supplier' => $query[$i]->pr_supplier,
                        'pr_item'     => $query[$i]->pr_item,
                        'pr_price'    => $query[$i]->pr_price,
                        'pr_qtyApp'   => $query[$i]->pr_qtyApp,
                        'pr_stsConf'  => $n++,
                        'pr_dateApp'  => $query[$i]->pr_dateApp,
                        'pr_comp'     => $query[$i]->pr_comp
                    ];
                    array_push($addAkses, $temp);
                }
        $insert = DB::table('d_purchase_confirm_copy')->insert($addAkses);

        if(!$insert){
            echo "GAGAL";
        }else{
            echo json_encode($n);
        }

    }

    public function purchase_order()
    {
        return view('pembelian/purchase_order/view_purchase_order');
    }


    public function view_purchaseAll()
    {
        $purchaseAll = DB::table('d_purchase')
                ->select('d_purchase.*')
                ->get();

        return DataTables::of($purchaseAll)
            ->addColumn('input', function ($purchaseAll) {

                return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTY"  style="text-transform: uppercase" /></div>';

            })
            ->addColumn('aksi', function ($purchaseAll) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="tambahRencana(' . $purchaseAll->p_id . ')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="getPlan_id(' . $purchaseAll->p_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $purchaseAll->p_id . ')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input', 'aksi'])
            ->make(true);


    }

    public function purchasing()
    {
        $purchasing = DB::table('d_purchase')
                ->select('d_purchase.*')
                ->where('d_purchase.po_status','PURCHASING')
                ->get();


        return DataTables::of($purchasing)
            ->addColumn('input', function ($purchasing) {

                return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTY"  style="text-transform: uppercase" /></div>';

            })
            ->addColumn('aksi', function ($purchasing) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="tambahRencana(' . $purchasing->p_id . ')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="getPlan_id(' . $purchasing->p_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $purchasing->p_id . ')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input', 'aksi'])
            ->make(true);
    }

    public function purchaseComplete()
    {
        $purchaseComplete = DB::table('d_purchase')
                ->select('d_purchase.*')
                ->where('d_purchase.po_status','COMPLETE')
                ->get();

        return DataTables::of($purchaseComplete)
            ->addColumn('input', function ($purchaseComplete) {

                return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTY"  style="text-transform: uppercase" /></div>';

            })
            ->addColumn('aksi', function ($purchaseComplete) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="tambahRencana(' . $purchaseComplete->p_id . ')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="getPlan_id(' . $purchaseComplete->p_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $purchaseComplete->p_id . ')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input', 'aksi'])
            ->make(true);
    }

    public function getDetail_purchase(Request $request)
    {
        $id = $request->input('id');
        $detailPurchase = DB::table('d_purchase_dt')
                ->select('d_purchase_dt.*', 'd_purchase.*', 'd_supplier.*')
                ->join('d_purchase', 'd_purchase_dt.pd_purchase', '=', 'd_purchase.p_id')
                ->join('d_supplier', 'd_purchase.p_suplier', '=', 'd_supplier.s_id')
                ->get();

        return DataTables::of($detailPurchase)
            ->addColumn('input', function ($detailPurchase) {

                return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTY"  style="text-transform: uppercase" /></div>';

            })
            ->addColumn('aksi', function ($detailPurchase) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="tambahRencana(' . $detailPurchase->p_id . ')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="getPlan_id(' . $detailPurchase->p_id . ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak(' . $purchaseComplete->p_id . ')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input', 'aksi'])
            ->make(true);
    }

    public function get_idDetail(Request $request)
    {
        $idDetail = $request->input('idDetail');
        $query    = DB::table('d_purchase_dt')
                    ->select('d_purchase_dt.*')
                    ->where('d_purchase_dt.ide',$idDetail)
                    ->get();
        echo json_encode(array("data"=>$query));
    }

    public function update_detailPurchase(Request $request)
    {
        $ide            = $request->input('ide');
        $pd_qty         = $request->input('pd_qty');
        $pd_value       = $request->input('pd_value');
        $pd_disc_value  = $request->input('pd_disc_value');
        $pd_disc_persen = $request->input('pd_disc_persen');
        $pd_total_net   = $request->input('pd_total_net');

        $update = DB::table('p_purchase_dt')
                    ->update([
                        'pd_qty'         => $request->methode_return,
                        'pd_value'       => date('Y-m-d'),
                        'pd_disc_value'  => $total_harga_return,
                        'pd_disc_persen' => $result_price,
                        'pd_total_net'   => $request->confirm_return
                    ]);
        if(!$update){
            $data = array("data" => "GAGAL");
            echo json_encode($data);
        }else{
            $data = array("data" => "SUKSES");
            echo json_encode($data);
        }


    }

    public function view_tambahPo()
    {
        return view('pembelian/purchase_order/add_po');
    }

    public function add_purchaseOrder(Request $request)
        {
            $id = $request->input('id');

            $masterPo = DB::table('d_purchase')
                    ->select('d_purchase.p_id')
                    ->get();
            $detailPo =DB::table('d_purchase_dt')
                    ->select('d_purchase_dt.*')
                    ->get();

            $barisPo = count($masterPo);
                if($barisPo==0) {
                    $cif ="00001";
                }
                else
                {
                    foreach ($masterPo as $row) {
                        //$a = substr($row->ID,5);
                        $counter=intval($barisPo); //hasil yang didaptkan dirubah jadi integer. Ex: 0001 mjd 1.
                        $new=intval($counter)+1;         //digit terahit ditambah 1
                    }
                    if (strlen($new)==1){ //jika counter yg didapat panjangnya 1 ex: 1
                        $vcounter="0000". '' .$new;
                    }
                    if (strlen($new)==2){  //jika counter yg didapat panjangnya 2 ex: 11
                        $vcounter="000". '' .$new;
                    }
                    if (strlen($new)==3){  //jika counter yg didapat panjangnya 2 ex: 11
                        $vcounter="00". '' .$new;
                    }
                    if (strlen($new)==4){  //jika counter yg didapat panjangnya 2 ex: 11
                        $vcounter="0". '' .$new;
                    }
                    if (strlen($new)==5){  //jika counter yg didapat panjangnya 2 ex: 11
                        $vcounter=$new;
                    }
                    $cif = $vcounter;
                }

                $barisDetail = count($detailPo);
                if($barisDetail==0) {
                    $cif1 ="00001";
                }
                else
                {
                    foreach ($detailPo as $row1) {
                        //$a = substr($row->ID,5);
                        $counter1=intval($barisDetail); //hasil yang didaptkan dirubah jadi integer. Ex: 0001 mjd 1.
                        $new1=intval($counter1)+1;         //digit terahit ditambah 1
                    }
                    if (strlen($new1)==1){ //jika counter yg didapat panjangnya 1 ex: 1
                        $vcounter1="0000". '' .$new1;
                    }
                    if (strlen($new1)==2){  //jika counter yg didapat panjangnya 2 ex: 11
                    $vcounter1="000". '' .$new1;
                    }
                    if (strlen($new1)==3){  //jika counter yg didapat panjangnya 2 ex: 11
                    $vcounter1="00". '' .$new1;
                    }
                    if (strlen($new1)==4){  //jika counter yg didapat panjangnya 2 ex: 11
                    $vcounter1="0". '' .$new1;
                    }
                    if (strlen($new1)==5){  //jika counter yg didapat panjangnya 2 ex: 11
                    $vcounter1=$new1;
                    }
                    $cif1 = $vcounter1;
                }

            $tgl = date('d');
            $bln = date('m');
            $thn = date('Y');

            $code = "PO-".$cif."/".$tgl."/".$bln."/".$thn;

            $detailPurchase = DB::table('d_purchase_confirm')
                            ->select('d_purchase_confirm.*')
                            ->where('d_purchase_confrim.pr_supplier',$pr_supplier)
                            ->where('d_purchase_confrim.pr_stsConf','CONFIRM')
                            ->get();

            $ide = count($detailPo);
            $pd_purchase =count($masterPo);



            $insertPo = [];
            for ($i=0; $i < count($detailPurchase); $i++) {
                $temp = [
                    // 'pr_idConf' =>$query[$i]->pr_idConf,
                    'ide'             => $ide++,
                    'pd_purchase'     => $query[$i]->pr_idPlan,
                    'pd_detailid'     => $query[$i]->pr_idPlan,
                    'pd_item'         => $query[$i]->pr_idPlan,
                    'pd_qty'          => $query[$i]->pr_idPlan,
                    'pd_value'        => $query[$i]->pr_idPlan,
                    'pd_disc_value'   => $query[$i]->pr_idPlan,
                    'pd_disc_persen'  => $query[$i]->pr_idPlan,
                    'pd_total_net'    => $query[$i]->pr_idPlan,
                    'pd_receivedtime' => $query[$i]->pr_idPlan,
                    'pr_idPlan'       => $query[$i]->pr_idPlan,
                    'pr_supplier'     => $query[$i]->pr_supplier,
                    'pr_item'         => $query[$i]->pr_item,
                    'pr_price'        => $query[$i]->pr_price,
                    'pr_qtyApp'       => $query[$i]->pr_qtyApp,
                    'pr_stsConf'      => $n++,
                    'pr_dateApp'      => $query[$i]->pr_dateApp,
                    'pr_comp'         => $query[$i]->pr_comp
                ];
                array_push($insertPo, $temp);
            }

            $insert = DB::table('d_purchase_dt')->insert($insertPo);





            // $query = DB::table('d_purchase_confirm')
            // ->select('d_purchase_confirm.*')
            // ->get();

            // $query2 = DB::table('d_purchase_confirm_copy')
            // ->select('d_purchase_confirm_copy.*')
            // ->get();

            // $n = count($query2);

            // $addAkses = [];
            // for ($i=0; $i < count($query); $i++) {
            //     $temp = [
            //         // 'pr_idConf' =>$query[$i]->pr_idConf,
            //         'pr_idPlan' =>$query[$i]->pr_idPlan,
            //         'pr_supplier'=>$query[$i]->pr_supplier,
            //         'pr_item' =>$query[$i]->pr_item,
            //         'pr_price' =>$query[$i]->pr_price,
            //         'pr_qtyApp' =>$query[$i]->pr_qtyApp,
            //         'pr_stsConf' =>$n++,
            //         'pr_dateApp' =>$query[$i]->pr_dateApp,
            //         'pr_comp' =>$query[$i]->pr_comp
            //     ];
            //     array_push($addAkses, $temp);
            // }

            // $insert = DB::table('d_purchase_confirm_copy')->insert($addAkses);

            // if(!$insert){
            //     echo "GAGAL";
            // }else{
            //     echo json_encode($n);
            // }
        }

        public function testDesc()
    {
        $query  = DB::table('d_item')
        ->select('d_item.*')
        ->orderBy('d_item.i_id','DESC')
        ->take('1')
        ->get();

        echo json_encode($query);
    }

    public function list_draftPo(Request $request)
    {
        $supplier = $request->input('supplier');
        $outlet = $request->input('outlet');

        $list = DB::table('d_purchase_confirm')
                ->select('d_purchase_confirm.*','d_supplier.*','d_item.*')
                ->join('d_item','d_purchase_confirm.pr_item','=','d_item.i_id')
                ->join('d_supplier','d_purchase_confirm.pr_supplier','=','d_supplier.s_id')
                ->where('d_purchase_confirm.pr_stsConf','WAITING')
                ->where('d_purchase_confirm.pr_supplier',$supplier)
                ->get();

                $data = array();
                $i = 1;
                foreach ($list as $hasil) {

                   $row = array();
                    $row[]  = $i++;
                    $row[]  = $hasil->i_nama;
                    $row[]  = '<div class="text-center">'.$hasil->pr_qtyApp.'</div>';
                    $row[]  = '<div class="text-right">'.number_format($hasil->pr_price).'</div>';
                    $row[]  = '<div class="text-right">'.number_format($hasil->total).'</div>';
                    $data[] = $row;

                }
                echo json_encode(array("data"=>$data));
    }

    public function simpanPo(Request $request)
    {
        // $request->tgl_awal = str_replace('/', '-', $request->tgl_awal);
        // $request->tgl_akhir = str_replace('/', '-', $request->tgl_akhir);

        // $start = Carbon::parse($request->tgl_awal)->startOfDay();  //2016-09-29 00:00:00.000000
        // $end = Carbon::parse($request->tgl_akhir)->endOfDay(); //2016-09-29 23:59:59.000000
        // $id = '1';
        $id = $request->input('id');
        $due_date = $request->input('due_date');
        $date = str_replace('/','-',$due_date);
        $tanggal = Carbon::parse($date);
            $queryBaris = DB::table('d_purchase')
            ->select('d_purchase.*')
            ->get();

            $query3 = DB::table('d_purchase_dt')
            ->select('d_purchase_dt.*')
            ->get();

        $noD = count($query3);
        if($noD==''){
            $noDetail = '1';
        }else{
            $noDetail = $noD+1;
        }


        $total =  DB::table('d_purchase_confirm')
        ->select(DB::raw('sum(d_purchase_confirm.total) as Total'))
        ->get();

        foreach ($total as $key) {
            $harga = $key->Total;
        }

            $barisPo = count($queryBaris);
                if($barisPo==0) {
                    $cif ="00001";
                }
                else
                {
                    foreach ($queryBaris as $row) {
                        //$a = substr($row->ID,5);
                        $counter=intval($barisPo); //hasil yang didaptkan dirubah jadi integer. Ex: 0001 mjd 1.
                        $new=intval($counter)+1;         //digit terahit ditambah 1
                    }
                    if (strlen($new)==1){ //jika counter yg didapat panjangnya 1 ex: 1
                    $vcounter="0000". '' .$new;
                    }
                    if (strlen($new)==2){  //jika counter yg didapat panjangnya 2 ex: 11
                    $vcounter="000". '' .$new;
                    }
                    if (strlen($new)==3){  //jika counter yg didapat panjangnya 2 ex: 11
                    $vcounter="00". '' .$new;
                    }
                    if (strlen($new)==4){  //jika counter yg didapat panjangnya 2 ex: 11
                    $vcounter="0". '' .$new;
                    }
                    if (strlen($new)==5){  //jika counter yg didapat panjangnya 2 ex: 11
                    $vcounter=$new;
                    }
                    $cif = $vcounter;
                }

                $date = Carbon::Now('Asia/jakarta');

                $tgl = date('d');
                $bln = date('m');
                $thn = date('Y');

                $m=count($queryBaris);
                if($m == ""){
                    $n = '1';
                }else{
                    $n = $m+1;
                }

                $code = "PO-".$cif."/".$tgl."/".$bln."/".$thn;

                $list = array([
                    'p_id'             => $n,
                    'p_nota'           => $code,
                    'p_date'           => $date,
                    'p_supplier'       => $id,
                    'p_total_gross'    => '0',
                    'p_disc_value'     => '0',
                    'p_disc_persen'    => '0',
                    'p_total_net'      => $harga,
                    'po_status'        => 'PURCHASING',
                    'p_purchaseNumber' => $code,
                    'p_tgl'            => $tgl,
                    'p_bln'            => $bln,
                    'p_thn'            => $thn,
                    'p_dueDate'        => $tanggal
                ]);

        $insertOne = DB::table('d_purchase')->insert($list);

        if(!$insertOne){
           echo "GAGAL";
        }else{

            $query = DB::table('d_purchase_confirm')
            ->select('d_purchase_confirm.*')
            ->where('d_purchase_confirm.pr_stsConf','WAITING')
            ->where('d_purchase_confirm.pr_supplier',$id)
            ->get();

                $queryx = DB::table('d_purchase_dt')
                ->select('d_purchase_dt.*')
                ->get();


                $number = count($queryx);

                if($number ==''){
                    $nUrut = '1';
                }else{
                    $nUrut = $number+1;
                }

                if($number ==''){
                    $nUrut1 = '1';
                }else{
                    $nUrut1 = $number+1;
                }


                        $addAkses = [];
                        for ($i=0; $i < count($query); $i++) {
                            $temp = [
                                // 'pr_idConf' =>$query[$i]->pr_idConf,
                                'ide'             => $nUrut1++,
                                'pd_purchase'     => $n,
                                'pd_detailid'     => $nUrut++,
                                'pd_item'         => $query[$i]->pr_item,
                                'pd_qty'          => $query[$i]->pr_qtyApp,
                                'pd_value'        => $query[$i]->pr_price,
                                'pd_disc_value'   => $query[$i]->pr_dateApp,
                                'pd_disc_persen'  => $query[$i]->pr_comp,
                                'pd_total_net'    => $query[$i]->pr_comp,
                                'pd_receivedtime' => Carbon::Now('Asia/Jakarta')
                            ];
                            array_push($addAkses, $temp);
                        }
                $insert = DB::table('d_purchase_dt')->insert($addAkses);

                if(!$insert){
                    echo "GAGAL";
                }else{
                    $def = DB::table('d_purchase_confirm')
                    ->select('pr_idConf')
                    ->where('pr_stsConf','=','WAITING')
                    ->get();

                    foreach ($def as $key => $value) {
                        $dat['coloum'] = $value;
                    }

                    $data = array();
                    foreach ($def as $key) {
                       $row    = array();
                       $row[]  = $key->pr_idConf;
                       $data[] = $row;
                    }

                   $update = DB::table('d_purchase_confirm')
                   ->whereIn('pr_idConf',$data)
                   ->update([
                       'pr_stsConf'=>'PURCHASING'
                   ]);
                    PlasmafoneController::logActivity('aksi yang dilalukan PURCHASING');
                    echo "SUKSES";
                }
        }


    }
    // end purchase order

    public function get_data_order($id)
    {
        $data_order = DB::table('d_request_order_dt')
            ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_request_order_dt.rdt_supplier', $id)
            ->where('d_request_order_dt.rdt_status', '=', 'Rencana Pembelian')
            ->get();
        $data = $id;
        $data_supplier = DB::table('d_supplier')
            ->join('d_request_order_dt', 'd_supplier.s_id', '=', 'd_request_order_dt.rdt_supplier')
            ->where('d_request_order_dt.rdt_status', '=', 'Rencana Pembelian')
            ->groupBy('d_supplier.s_name')
            ->get();


        return view('pembelian/konfirmasi_pembelian/index', compact('data', 'data_supplier', 'data_order'));
    }

    public function generatePDF($id)
    {
        $data_order = DB::table('d_request_order_dt')
            ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_request_order_dt.rdt_supplier', $id)->get();
        // return view('pembelian/konfirmasi_pembelian/print', compact('data_order'));

        $pdf = PDF::loadView('pembelian/konfirmasi_pembelian/newpdf', compact('data_order'));
        return $pdf->stream();
    }

    public function print($id)
    {
        $data_order = DB::table('d_request_order_dt')
            ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_request_order_dt.rdt_supplier', $id)->get();
        return view('pembelian/konfirmasi_pembelian/newprint', compact('data_order'));
    }

    public function downloadpdf($id)
    {
        $data_order = DB::table('d_request_order_dt')
            ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_request_order_dt.rdt_supplier', $id)->get();
        return view('pembelian/konfirmasi_pembelian/pdf', compact('data_order', 'id'));
    }

    public function return_barang()
    {

        return view('pembelian/return_barang/index');
    }

    public function return_barang_add(Request $request)
    {
        if ($request->isMethod('post')) {
            // $data               = $request->all();
            // print_r($data); die;

            $count   = DB::table('d_purchase_return')->count();
            $urutan  = $count + 1;
            $pr_code = 'PR' . date('YmdHms') . $urutan;

            $harga_satuan       = $this->formatPrice($request->harga_satuan);
            $total_bayar        = $this->formatPrice($request->total_bayar);
            $total_harga_return = $this->formatPrice($request->total_harga_return);
            // print_r($total_harga_return); die;

            $result_price = '';

            if ($request->methode_return == 'GB') {
                $result_price = $total_bayar;
            } elseif ($request->methode_return == 'PT') {
                $result_price = $total_bayar - $total_harga_return;
            } elseif ($request->methode_return == 'GU') {
                $result_price = $total_bayar - $total_harga_return;
            } elseif ($request->methode_return == 'PN') {
                $result_price = $total_bayar - $total_harga_return;
            }

            $return_brg = DB::table('d_purchase_return')->insertGetId([
                'pr_po_id'          => $request->purchase_order,
                'pr_code'           => $pr_code,
                'pr_methode_return' => $request->methode_return,
                'pr_total_price'    => $total_harga_return,
                'pr_result_price'   => $result_price,
                'pr_status_return'  => 'WT'
            ]);

            DB::table('d_purchase_return_dt')->insert([
                'pr_id'           => $return_brg,
                'prd_kode_barang' => $request->kode_barang,
                'prd_qty'         => $request->kuantitas_return,
                'prd_unit_price'  => $harga_satuan,
                'prd_total_price' => $total_harga_return
            ]);



            return redirect('/pembelian/purchase-return')->with('flash_message_success', 'Data return barang berhasil ditambahkan!');


        }
        $purchase = DB::table('d_purchase_order_dt')->get();
        return view('pembelian.return_barang.add')->with(compact('purchase'));
    }

    public function get_current_return($id = null)
    {
        $data = DB::table('d_purchase_return')
            ->select('d_purchase_return.*', 'd_purchase_return_dt.*')
            ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
            ->where(['d_purchase_return.pr_id' => $id])
            ->first();
        echo json_encode($data);
    }

    public function get_edit_return($id = null)
    {
        $data = DB::table('d_purchase_return')
            ->select('d_purchase_return.*', 'd_purchase_return_dt.*', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_supplier.*')
            ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
            ->join('d_purchase_order', 'd_purchase_return.pr_po_id', '=', 'd_purchase_order.po_no')
            ->join('d_purchase_order_dt', 'd_purchase_order.po_no', 'd_purchase_order_dt.podt_purchase')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->where('d_purchase_return.pr_id', $id)->first();
        echo json_encode($data);
    }

    public function edit_purchase_return(Request $request)
    {
        $data = DB::table('d_purchase_return')
            ->select('d_purchase_return.*', 'd_purchase_return_dt.*', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_supplier.*')
            ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
            ->join('d_purchase_order', 'd_purchase_return.pr_po_id', '=', 'd_purchase_order.po_no')
            ->join('d_purchase_order_dt', 'd_purchase_order.po_no', 'd_purchase_order_dt.podt_purchase')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->where('d_purchase_return.pr_id', $request->id)->get();

        if (count($data) == 0) {
            return view('errors.data_not_found');
        }
        // print_r($data); die;
        return view('pembelian.return_barang.edit', compact('data'));
    }

    public function update_purchase_return(Request $request)
    {
        $harga_satuan = $this->formatPrice($request->harga_satuan);
        $total_bayar = $this->formatPrice($request->total_bayar);
        $total_harga_return = $this->formatPrice($request->total_harga_return);

        $result_price = '';

        if ($request->methode_return == 'GB') {
            $result_price = $total_bayar;
        } elseif ($request->methode_return == 'PT') {
            $result_price = $total_bayar - $total_harga_return;
        } elseif ($request->methode_return == 'GU') {
            $result_price = $total_bayar - $total_harga_return;
        } elseif ($request->methode_return == 'PN') {
            $result_price = $total_bayar - $total_harga_return;
        }

        $data = DB::table('d_purchase_return')->where('pr_id', $request->return_id);

        if (!$data->first()) {

            $response = [
                'status' => 'tidak ada',
                'content' => 'null'
            ];
            return json_encode($response);

        } else {

            if ($request->confirm_return == 'CF') {
                $data->update([
                    'pr_methode_return' => $request->methode_return,
                    'pr_confirm_date'   => date('Y-m-d'),
                    'pr_total_price'    => $total_harga_return,
                    'pr_result_price'   => $result_price,
                    'pr_status_return'  => $request->confirm_return
                ]);

                DB::table('d_purchase_return_dt')
                    ->where('pr_id', $request->return_id)
                    ->update([
                        'prd_qty'         => $request->kuantitas_return,
                        'prd_total_price' => $total_harga_return,
                        'prd_isconfirm'   => 1
                    ]);

                Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
                $response = [
                    'status' => 'berhasil',
                    'content' => null
                ];

                return json_encode($response);
            } else {
                $data->update([
                    'pr_methode_return' => $request->methode_return,
                    'pr_total_price'    => $total_harga_return,
                    'pr_result_price'   => $result_price,
                    'pr_status_return'  => $request->confirm_return
                ]);

                DB::table('d_purchase_return_dt')
                    ->where('pr_id', $request->return_id)
                    ->update([
                        'prd_qty' => $request->kuantitas_return,
                        'prd_total_price' => $total_harga_return
                    ]);

                Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
                $response = [
                    'status' => 'berhasil',
                    'content' => null
                ];

                return json_encode($response);
            }

        }
    }

    public function multiple_edit_purchase_return(Request $request)
    {
        $data = DB::table('d_purchase_return')
            ->select('d_purchase_return.*', 'd_purchase_return_dt.*', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_supplier.*')
            ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
            ->join('d_purchase_order', 'd_purchase_return.pr_po_id', '=', 'd_purchase_order.po_no')
            ->join('d_purchase_order_dt', 'd_purchase_order.po_no', 'd_purchase_order_dt.podt_purchase')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->whereIn('d_purchase_return.pr_id', $request->data_check)->get();

        if (count($data) == 0) {
            return view('errors.data_not_found');
        }
        // print_r($data); die;
        return view('pembelian.return_barang.edit', compact('data'));
    }

    public function multiple_delete_purchase_return(Request $request)
    {
        for ($i = 0; $i < count($request->pr_id); $i++) {
            # code...
            // print_r($key);echo ": ";print_r($value); echo "<pre>";
            DB::table('d_purchase_return_dt')->where('pr_id', $request->pr_id[$i])->delete();
            $check_prid_on_d_return = DB::table('d_purchase_order_dt')
                ->where('podt_no', $request->podt_no[$i])
                ->get();
            if (count($check_prid_on_d_return) == 0) {
                $check_prid_on_d_return_dt = DB::table('d_purchase_return')
                    ->where('pr_id', $request->pr_id[$i])
                    ->get();
                if (count($check_prid_on_d_return_dt) != 0) {
                    DB::table('d_purchase_return')->where('pr_id', $request->pr_id[$i])->delete();
                }

            }

        }

        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return json_encode([
            'status' => 'berhasil'
        ]);
    }

    public function show_purchase($id = null)
    {
        $data = DB::table('d_purchase_order_dt')
            ->select('d_purchase_order_dt.*', 'd_purchase_order.*', 'd_supplier.*')
            ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->where(['podt_purchase' => $id, 'po_status' => 'Diterima'])
            ->first();
        echo json_encode($data);
    }


    public function purchase_order_add()
    {
        $data_request = DB::table('d_request_order_dt')
            ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_purchase_order', 'd_request_order_dt.rdt_no', '=', 'd_purchase_order.po_request_order_no', 'left')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_request_order_dt.rdt_status', '=', 'Rencana Pembelian')
            ->get();
        return view('pembelian.purchase_order.tambah_purchase_order')->with(compact('data_request'));
    }

    public function get_request_purchase($id)
    {
        $data = DB::table('d_request_order_dt')
            ->select('d_request_order.*', 'd_request_order_dt.*', 'd_request_order.ro_cabang', 'd_supplier.s_name')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id')
            ->where('d_request_order_dt.rdt_no', $id)
            ->first();
        return json_encode($data);
    }

    public function get_purchase($id)
    {
        // return json_encode($id); die;
        $data = DB::table('d_purchase_order_dt')
            ->select('d_purchase_order.*', 'd_purchase_order_dt.*', 'd_request_order.ro_cabang', 'd_supplier.s_name')
            ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
            ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->where('d_purchase_order_dt.podt_no', $id)
            ->first();
        return json_encode($data);
    }

    function formatPrice($data)
    {
        $explode_rp = implode("", explode("Rp", $data));
        return implode("", explode(".", $explode_rp));
    }

    function generate_code($table, $field, $lebar = 0, $awalan)
    {
        $order = DB::table($table)->select($field)->orderBy($field, 'desc')->limit(1);
        $countData = $order->count();
        if ($countData == 0) {
            $nomor = 1;
        } else {
            $getData = $order->get();
            $row = array();
            foreach ($getData as $value) {
                $row = array($value->$field);
            }
            // print_r($row); die;
            $nomor = intval(substr($row[0], strlen($awalan))) + 1;
        }

        if ($lebar > 0) {
            $angka = $awalan . str_pad($nomor, $lebar, "0", STR_PAD_LEFT);
        } else {
            $angka = $awalan . $nomor;
        }

        return $angka;
    }

    public function add_purchase(Request $request)
    {
        // print_r($request->all()); die;
        $total_harga  = $this->formatPrice($request->total_harga);
        $total_bayar  = $this->formatPrice($request->total_bayar);
        $harga_satuan = $this->formatPrice($request->harga_satuan);
        // echo $harga_satuan; die;
        $po_no = $this->generate_code('d_purchase_order', 'po_no', 4, 'PO' . date('ymd'));

        $podt_no = $this->generate_code('d_purchase_order_dt', 'podt_no', 4, 'PODT' . date('dmy'));
        // print_r($po_no); die;
        if ($request->diskon == "") {
            # code...
            $diskon = "0";
        } else {
            $diskon = $request->diskon;
        }

        $insert_purchase_order = DB::table('d_purchase_order')->insert([
            'po_no'               => $po_no,
            'po_request_order_no' => $request->request_dt_no,
            'po_status'           => $request->status,
            'po_type_pembayaran'  => $request->tipe_pembayaran,
            'po_total_harga'      => $total_harga,
            'po_diskon'           => $diskon,
            'po_ppn'              => $request->ppn,
            'po_total_bayar'      => $total_bayar
        ]);

        $inser_purchase_order_dt = DB::table('d_purchase_order_dt')->insert([
            'podt_purchase'     => $po_no,
            'podt_no'           => $podt_no,
            'podt_kode_barang'  => $request->kode_barang,
            'podt_kode_suplier' => $request->id_supplier,
            'podt_kuantitas'    => $request->kuantitas,
            'podt_harga_satuan' => $harga_satuan
        ]);

        $update_request_order_dt = DB::table('d_request_order_dt')
            ->where('rdt_no', $request->request_dt_no)
            ->update(['rdt_status' => $request->status]);

        return redirect('/pembelian/purchase-order')->with('flash_message_success', 'Data berhasil ditambahkan!');
    }

    public function get_purchase_order($id)
    {
        $data = DB::table('d_purchase_order_dt')
            ->select('d_purchase_order_dt.*', 'd_purchase_order.*', 'd_supplier.*', 'd_request_order.ro_cabang', 'd_cabang.c_nama')
            ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_purchase_order_dt.podt_no', $id)->first();

        return json_encode($data);
    }

    public function edit_purchase_order(Request $request)
    {
        $data = DB::table('d_purchase_order_dt')
            ->select('d_purchase_order.*', 'd_purchase_order_dt.*', 'd_request_order.ro_cabang', 'd_supplier.s_name', 'd_cabang.c_nama')
            ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
            ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_purchase_order_dt.podt_no', $request->id)->get();

        if (count($data) == 0) {
            return view('errors.data_not_found');
        }
        // print_r($data); die;
        return view('pembelian.purchase_order.edit_purchase_order', compact('data'));
    }

    public function update_purchase_order(Request $request)
    {
        // print_r($request->all()); die;
        $total_harga = $this->formatPrice($request->total_harga);
        $total_bayar = $this->formatPrice($request->total_bayar);
        $harga_satuan = $this->formatPrice($request->harga_satuan);
        $data = DB::table('d_purchase_order_dt')->where('podt_no', $request->podt_no);

        if (!$data->first()) {
            $response = [
                'status'  => 'tidak ada',
                'content' => 'null'
            ];

            return json_encode($response);
        } else {
            $data->update([
                'podt_harga_satuan' => $harga_satuan
            ]);
            DB::table('d_purchase_order')
                ->where('po_no', $request->po_no)
                ->update([
                    'po_status'          => $request->status,
                    'po_type_pembayaran' => $request->tipe_pembayaran,
                    'po_total_harga'     => $total_harga,
                    'po_diskon'          => $request->diskon,
                    'po_ppn'             => $request->ppn,
                    'po_total_bayar'     => $total_bayar
                ]);

            DB::table('d_request_order_dt')
                ->where('rdt_no', $request->request_order)
                ->update([
                    'rdt_status' => $request->status
                ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status' => 'berhasil',
                'content' => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_edit_purchase_order(Request $request)
    {
        $data = DB::table('d_purchase_order_dt')
            ->select('d_purchase_order.*', 'd_purchase_order_dt.*', 'd_request_order.ro_cabang', 'd_supplier.s_name', 'd_cabang.c_nama')
            ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
            ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->whereIn('d_purchase_order_dt.podt_no', $request->data_check)->get();

        if (count($data) == 0) {
            return view('errors.data_not_found');
        }

        return view('pembelian.purchase_order.edit_purchase_order', compact('data'));
    }

    public function multiple_delete_purchase_order(Request $request)
    {
        for ($i = 0; $i < count($request->podt_no); $i++) {
            # code...
            // print_r($key);echo ": ";print_r($value); echo "<pre>";
            DB::table('d_purchase_order_dt')->where('podt_no', $request->podt_no[$i])->delete();
            $check_podt_no = DB::table('d_purchase_order_dt')
                ->where('podt_no', $request->podt_no[$i])
                ->get();
            if (count($check_podt_no) == 0) {
                $check_po = DB::table('d_purchase_order')
                    ->where('po_no', $request->podt_purchase[$i])
                    ->get();
                if (count($check_po) != 0) {
                    DB::table('d_purchase_order')->where('po_no', $request->podt_purchase[$i])->delete();
                }

            }

        }

        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return json_encode([
            'status' => 'berhasil'
        ]);
    }

    public function cetak_purchase()
    {
        $data = "Null";
        $data_supplier = DB::table('d_supplier')
            ->join('d_request_order_dt', 'd_supplier.s_id', '=', 'd_request_order_dt.rdt_supplier')
            ->where('d_request_order_dt.rdt_status', '=', 'Menunggu')
            ->groupBy('d_supplier.s_name')
            ->get();
        // print_r($data_supplier);
        return view('pembelian/purchase_order/print_purchase', compact('data', 'data_supplier'));
    }

    public function get_purchase_data($id)
    {
        $data_order = DB::table('d_request_order_dt')
            ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_request_order_dt.rdt_supplier', $id)
            ->where('d_request_order_dt.rdt_status', 'Menunggu')
            ->get();
        $data = $id;
        $data_supplier = DB::table('d_supplier')
            ->join('d_request_order_dt', 'd_supplier.s_id', '=', 'd_request_order_dt.rdt_supplier')
            ->where('d_request_order_dt.rdt_status', '=', 'Menunggu')
            ->groupBy('d_supplier.s_name')
            ->get();

        // print_r($data_order); die;

        return view('pembelian/purchase_order/print_purchase', compact('data', 'data_supplier', 'data_order'));
    }

    public function print_purchase($id)
    {
        $data_purchase = DB::table('d_purchase_order_dt')
            ->select('d_supplier.s_company', 'd_supplier.s_phone', 'd_supplier.s_address', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_cabang.c_nama')
            ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
            ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', 'd_supplier.s_id')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_purchase_order_dt.podt_kode_suplier', $id)
            ->where('d_purchase_order.po_status', 'Menunggu')
            ->get();
        foreach ($data_purchase as $value) {
            # code...
            $sub_total_bayar   = $value->po_total_bayar;

            $total_bayar_sub[] = $sub_total_bayar;
        }

        $jumlah = array_sum($total_bayar_sub);
        return view('pembelian/purchase_order/print_out', compact('data_purchase', 'jumlah', 'id'));
    }

    public function viewpdf_purchase($id)
    {
        $data_purchase = DB::table('d_purchase_order_dt')
            ->select('d_supplier.s_company', 'd_supplier.s_phone', 'd_supplier.s_address', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_cabang.c_nama')
            ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
            ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', 'd_supplier.s_id')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_purchase_order_dt.podt_kode_suplier', $id)
            ->where('d_purchase_order.po_status', 'Menunggu')
            ->get();

        foreach ($data_purchase as $value) {
            # code...
            $sub_total_bayar   = $value->po_total_bayar;

            $total_bayar_sub[] = $sub_total_bayar;
        }

        $jumlah = array_sum($total_bayar_sub);
        // print_r(array_sum($total_bayar_sub)); die;

        return view('pembelian/purchase_order/pdf', compact('data_purchase', 'jumlah', 'id'));
        // $pdf = PDF::loadView('pembelian/purchase_order/pdf', compact('data_purchase', 'jumlah'));
        // return $pdf->stream();
    }

    public function pdf_purchase($id)
    {
        $data_purchase = DB::table('d_purchase_order_dt')
            ->select('d_supplier.s_company', 'd_supplier.s_phone', 'd_supplier.s_address', 'd_purchase_order.*', 'd_purchase_order_dt.*', 'd_cabang.c_nama')
            ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
            ->join('d_request_order_dt', 'd_purchase_order.po_request_order_no', '=', 'd_request_order_dt.rdt_no')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', 'd_supplier.s_id')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_purchase_order_dt.podt_kode_suplier', $id)
            ->where('d_purchase_order.po_status', 'Menunggu')
            ->get();

        foreach ($data_purchase as $value) {
            # code...
            $sub_total_bayar   = $value->po_total_bayar;

            $total_bayar_sub[] = $sub_total_bayar;
        }

        $jumlah = array_sum($total_bayar_sub);
        // print_r(array_sum($total_bayar_sub)); die;

        // return view('pembelian/purchase_order/pdf', compact('data_purchase'));
        $pdf = PDF::loadView('pembelian/purchase_order/newpdf', compact('data_purchase', 'jumlah'));
        return $pdf->stream();
    }

    public function refund()
    {
        return view('pembelian/refund/refund');
    }

    // -------------request order-------------------

    public function request_order()
    {
        return view('pembelian/request_order/view_request_order');
    }

    public function request_order_tambah()
    {
        return view('pembelian/request_order/tambah_request_order');

    }



    public function addData(Request $request)
    {

        $comp = Auth::user()->m_id;
        $item = $request->input('item');
        $qty = $request->input('qty');

        $insert = DB::table('d_purchase_req_dumy')->insert([
            'pr_item'   => $item,
            'pr_qty'    => $qty,
            'pr_mem_id' => $$comp

        ]);

        if ($insert) {
            $status = "SUKSES";
        } else {
            $status = "GAGAL";
        }

        echo json_encode($status);

    }

    public function ddRequest_dumy(Request $request)
    {
        $comp    = Auth::user()->m_comp;
        $dateReq = Carbon::now('Asia/Jakarta');
        $status  = 'D';
        $user    = Auth::user()->m_id;

        $user = Auth::user()->m_id;
        $list = DB::table('d_requestorder')
            ->select('d_requestorder.ro_id', 'd_item.i_nama', 'd_requestorder.ro_comp', 'd_requestorder.ro_item', 'd_requestorder.ro_qty', 'd_requestorder.ro_date', 'd_requestorder.ro_state')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            ->where('d_requestorder.ro_comp', $comp)
            ->where('d_requestorder.ro_state', 'D')
            ->get();


        $data = array();
        foreach ($list as $hasil) {
            $row = array();
            $row[] = $hasil->i_nama;
            $row[] = '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama' . $hasil->ro_id . '" value="' . $hasil->ro_qty . '"  style="text-transform: uppercase" onkeyup="editDumy(' . $hasil->ro_id . ')" /></div>';
            $row[] = '<div class="text-center"><button class="btn btn-xs btn-danger btn-circle" title="Hapus Data" onclick="hapusData(' . $hasil->ro_id . ')"><i class="glyphicon glyphicon-trash"></i></button></div>';
            $data[] = $row;
        }
        echo json_encode(array("data" => $data));
    }

    public function addDumyReq(Request $request)
    {

        $comp    = Auth::user()->m_comp;
        $user    = Auth::user()->m_id;
        $item    = $request->input('item');
        $qty     = $request->input('qty');
        $dateReq = Carbon::now('Asia/Jakarta');
        $status  = 'D';

        $cek_item = DB::table('d_requestorder')
        ->select('d_requestorder.ro_item')
        ->where('d_requestorder.ro_item','=',$item)
        ->where('d_requestorder.ro_comp','=',$comp)
        ->where('d_requestorder.ro_state','=','D')
        ->get();

        $kuantiti = DB::table('d_requestorder')
        ->select('d_requestorder.ro_qty')
        ->where('d_requestorder.ro_item','=',$item)
        ->where('d_requestorder.ro_state','=','D')
        ->get();

        $baris = count($cek_item);
        $getId = DB::table('d_requestorder')->max('ro_id');
        ++$getId;

        if($baris =='0' and $qty !=''){
            $insert = DB::table('d_requestorder')
                ->insert([

                    'ro_id'        => $getId,
                    'ro_comp'      => $comp,
                    'ro_item'      => $item,
                    'ro_qty'       => $qty,
                    'ro_date'      => $dateReq,
                    'ro_state'     => $status

                ]);

                if ($insert) {
                    $sts = "SUKSES";
                    echo json_encode(array("data" => $sts));
                } else {
                    $sts = "GAGAL";
                    echo json_encode(array("data" => $sts));
                }
        }else if($baris =='0' and $qty ==''){
            $insert = DB::table('d_requestorder')
            ->insert([

                'ro_id'         => $getId,
                'ro_comp'       => $comp,
                'ro_item'       => $item,
                'ro_qty'        => '1',
                'ro_date'       => $dateReq,
                'ro_state'      => $status

            ]);

            if ($insert) {
                $sts = "SUKSES";
                echo json_encode(array("data" => $sts));
            } else {
                $sts = "GAGAL";
                echo json_encode(array("data" => $sts));
            }
        }else if($baris !='0' and $qty ==''){
            $kuantiti = DB::table('d_requestorder')
            ->select('d_requestorder.ro_qty')
            ->where('d_requestorder.ro_item','=',$item)
            ->where('d_requestorder.ro_state','=','D')
            ->get();

            foreach ($kuantiti as $key) {
                $k = $key->ro_qty;
            }

            $update_qty = DB::table('d_requestorder')
            ->where('d_requestorder.ro_item','=',$item)
            ->update([
                'ro_qty' => $k+1
            ]);

            if ($update_qty) {
                $sts = "SUKSES";
                echo json_encode(array("data" => $sts));
            } else {
                $sts = "GAGA1";
                echo json_encode(array("data" => $sts));
            }
        }else if($baris !='0' and $qty !=''){

            $kuantiti = DB::table('d_requestorder')
            ->select('d_requestorder.ro_qty')
            ->where('d_requestorder.ro_item','=',$item)
            ->where('d_requestorder.ro_state','=','D')
            ->get();

            foreach ($kuantiti as $key) {
                $k = $key->ro_qty;
            }

            $update_qty = DB::table('d_requestorder')
            ->where('d_requestorder.ro_item','=',$item)
            ->update([
                'ro_qty' => $k+$qty
            ]);

            if ($update_qty) {
                $sts = "SUKSES";
                echo json_encode(array("data" => $sts));
            } else {
                $sts = "GAGA1";
                echo json_encode(array("data" => $sts));
            }
        }

    }

    public function getDumyReq()
    {
        $comp = Auth::user()->mem_id;
        $item = $request->input('item_id');
        $qty  = $request->input('qty');
        $id   = $request->input('id');

        $query = DB::table('d_purchase_req_dumy')
            ->select('d_purchase_req_dumy.pr_id', 'd_item.i_nama', 'd_purchase_req_dumy.pr_qty')
            ->join('d_item', 'd_purchase_req_dumy.pr_item', '=', 'd_item.i_id')
            ->where('d_purchase_req_dumy.pr_mem_id', $comp)
            ->get();

        $data = array(
            'pr_id'  => $query->pr_id,
            'i_nama' => $query->i_nama,
            'pr_qty' => $query->pr_qty,

        );

        echo json_encode($data);
    }

    public function editConfirm_dummy(Request $request)
    {
        $comp = Auth::user()->m_id;
        $id = $request->input('id');
        $harga = $request->input('harga');

        $update = DB::table('d_purchase_plan_dd')
            ->where('d_purchase_plan_dd.pr_userId', $comp)
            ->where('d_purchase_plan_dd.pr_idPlan', $id)
            ->update([
                'pr_harga_satuan' => $harga,
            ]);

        if ($update) {
            $data = "ok";
        } else {
            $data = "gagal";
        }

        echo json_encode(array("dataSet" => $data));
    }



    public function editDumyReq(Request $request)
    {
        $comp = Auth::user()->m_id;
        $id = $request->input('id');
        $qty = $request->input('qty');

        $update = DB::table('d_purchase_req')
            ->where('d_purchase_req.pr_userId', $comp)
            ->where('d_purchase_req.pr_id', $id)
            ->update([
                'pr_qtyReq' => $qty,
            ]);

        if ($update) {
            $data = "ok";
        } else {
            $data = "gagal";
        }

        echo json_encode(array("dataSet" => $data));

    }

    public function editDumy(Request $request)
    {
        $comp = Auth::user()->m_id;
        $id = $request->input('id');
        $qty = $request->input('qty');

        $update = DB::table('d_purchase_req_dumy')
            ->where('d_purchase_req_dumy.pr_id', $id)
            ->update([
                'pr_qtyApp_dumy' => $qty,
            ]);

        if ($update) {
            $data = "ok";
        } else {
            $data = "gagal";
        }

        echo json_encode(array("dataSet" => $data));

    }

    public function hapusDumy(Request $request)
    {
        $comp = Auth::user()->m_id;
        $id = $request->input('id');

        $delete = DB::table('d_requestorder')
            ->where('d_requestorder.ro_id', $id)
            ->delete();

        if (!$delete) {

            $response = "gagal";
            echo json_encode(array("status" => $response));

        } else {
            $response = "sukses";
            echo json_encode(array("status" => $response));

        }

    }




    public function menunggu()
    {
        $comp = Auth::user()->m_comp;

        if($comp == "PF00000001"){
            $waiting = DB::table('d_requestorder')
            ->select('d_requestorder.ro_id', DB::raw('date_format(ro_date, "%d/%m/%Y") as ro_date'), 'm_company.c_name', 'd_item.i_nama', 'd_requestorder.ro_item', 'd_requestorder.ro_qty', 'd_requestorder.ro_state')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            ->join('m_company', 'ro_comp', '=', 'm_company.c_id')
            ->where('d_requestorder.ro_state', 'P')
            ->where('d_requestorder.ro_comp', $comp)
            ->get();
        }else{
            $id = Auth::user()->m_id;
            $waiting = DB::table('d_requestorder')
            ->select('d_requestorder.ro_id', DB::raw('date_format(ro_date, "%d/%m/%Y") as ro_date'), 'm_company.c_name', 'd_item.i_nama', 'd_requestorder.ro_item', 'd_requestorder.ro_qty', 'd_requestorder.ro_state')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            ->join('m_company', 'ro_comp', '=', 'm_company.c_id')
            ->where('d_requestorder.ro_state', 'P')
            ->where('d_requestorder.ro_comp',$comp)
            ->get();
        }

        return DataTables::of($waiting)
            ->addColumn('ro_state', function ($waiting) {

                return "<div class='text-center'><span class='label label-warning'>MENUNGGU</span></div>";

            })

            ->addColumn('aksi', function ($waiting){
                return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $waiting->ro_id . '\', \''.$waiting->i_nama.'\', \''.$waiting->ro_qty.'\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="hapusReq(\'' . $waiting->ro_id . '\')"><i class="glyphicon glyphicon-trash"></i></button></div>';
            })

            // ->addColumn('aksi', function ($waiting) {
            //     if (Plasma::checkAkses(49, 'update') == false) {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
            //     } else {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $waiting->pr_id . '\', \'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
            //     }
            // })
            ->rawColumns(['ro_state', 'aksi'])
            ->make(true);
    }

    public function requestTolak(Request $request)
    {
        $tgl_awal_tolak  = $request->input('tgl_awal_tolak');
        $tgl_akhir_tolak = $request->input('tgl_akhir_tolak');
        $req_awal_tolak  = str_replace('/', '-', $tgl_awal_tolak);
        $req_akhir_tolak = str_replace('/', '-', $tgl_akhir_tolak);

        $awal_tolak  = Carbon::parse($req_awal_tolak)->startOfDay();
        $akhir_tolak = Carbon::parse($req_akhir_tolak)->endOfDay();

        $comp = Auth::user()->m_comp;

        if($comp == "PF00000001"){
            $tolak = DB::table('d_requestorder')
            ->select('d_requestorder.ro_id', DB::raw('date_format(ro_date, "%d/%m/%Y") as ro_date'), 'm_company.c_name', 'd_item.i_nama', 'd_requestorder.ro_item', 'd_requestorder.ro_qty', 'd_requestorder.ro_state')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            ->join('m_company', 'ro_comp', '=', 'm_company.c_id')
            ->where('d_requestorder.ro_state', 'N')
            ->where('d_requestorder.ro_date','>=',$awal_tolak)
            ->where('d_requestorder.ro_date','<=',$akhir_tolak)
            ->get();
        }else{
            $id = Auth::user()->m_id;
            $tolak = DB::table('d_requestorder')
            ->select('d_requestorder.ro_id', DB::raw('date_format(ro_date, "%d/%m/%Y") as ro_date'), 'm_company.c_name', 'd_item.i_nama', 'd_requestorder.ro_item', 'd_requestorder.ro_qty', 'd_requestorder.ro_state')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            ->join('m_company', 'ro_comp', '=', 'm_company.c_id')
            ->where('d_requestorder.ro_state', 'N')
            ->where('d_requestorder.ro_date','>=',$awal_tolak)
            ->where('d_requestorder.ro_date','<=',$akhir_tolak)
            ->where('d_requestorder.ro_comp',$comp)
            ->get();
        }

        $data = array();
        // $i = 1;
        foreach ($tolak as $key ) {
            $row    = array();
            $row[]  = $key->ro_date;
            $row[]  = $key->c_name;
            $row[]  = $key->i_nama;
            $row[]  = $key->ro_qty;
            $row[]  = "<div class='text-center'><span class='label label-danger'>DI TOLAK...</span></div>";
            $row[]  = "<div class='text-center'><button class='btn btn-sm btn-warning btn-circle' title='Edit' onclick='editQtyTolak(\"".$key->i_nama."\",".$key->ro_id.",".$key->ro_qty.")'><i class='fa fa-edit'></i></button>&nbsp <button class='btn btn-sm btn-danger btn-circle' title='Hapus'><i class='fa fa-trash'></i></button></div>";
            $data[] = $row;
        }

        echo json_encode(array("data"=>$data));

        // return DataTables::of($tolak)
        //     ->addColumn('status', function ($tolak) {

        //         return "<div class='text-center'><span class='label label-danger' style='padding:5%'>DITOLAK...</span></div>";

        //     })

            // ->addColumn('aksi', function ($waiting) {
            //     if (Plasma::checkAkses(49, 'update') == false) {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
            //     } else {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $waiting->pr_id . '\', \'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
            //     }
            // })
            // ->rawColumns(['status', 'aksi'])
            // ->make(true);
    }

    public function requestProses(Request $request)
    {
        $tgl_awal  = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');
        $req_awal  = str_replace('/', '-', $tgl_awal);
        $req_akhir = str_replace('/', '-', $tgl_akhir);

        $awal  = Carbon::parse($req_awal)->startOfDay();
        $akhir = Carbon::parse($req_akhir)->endOfDay();

        $comp = Auth::user()->m_comp;

        if($comp == "PF00000001"){
            $proses = DB::table('d_requestorder')
            ->select('d_requestorder.ro_id', DB::raw('date_format(ro_date, "%d/%m/%Y") as ro_date'), 'm_company.c_name', 'd_item.i_nama', 'd_requestorder.ro_item', 'd_requestorder.ro_qty', 'd_requestorder.ro_state')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            ->join('m_company', 'ro_comp', '=', 'm_company.c_id')
            ->where('d_requestorder.ro_state', 'Y')
            ->where('d_requestorder.ro_date','>=',$awal)
            ->where('d_requestorder.ro_date','<=',$akhir)
            ->get();
        }else{
            $id = Auth::user()->m_comp;
            $proses = DB::table('d_requestorder')
            ->select('d_requestorder.ro_id', DB::raw('date_format(ro_date, "%d/%m/%Y") as ro_date'), 'm_company.c_name', 'd_item.i_nama', 'd_requestorder.ro_item', 'd_requestorder.ro_qty', 'd_requestorder.ro_state')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            ->join('m_company', 'ro_comp', '=', 'm_company.c_id')
            ->where('d_requestorder.ro_state', 'Y')
            ->where('d_requestorder.ro_comp',$comp)
            ->where('d_requestorder.ro_date','>=',$awal)
            ->where('d_requestorder.ro_date','<=',$akhir)
            ->get();
        }

        $data = array();
        // $i = 1;
        foreach ($proses as $key ) {
            $row    = array();
            $row[]  = $key->ro_date;
            $row[]  = $key->c_name;
            $row[]  = $key->i_nama;
            $row[]  = $key->ro_qty;
            $row[]  = "<div class='text-center'><span class='label label-success'>PROSES PURCASHING...</span></div>";
            $data[] = $row;
        }

        echo json_encode(array("data"=>$data));


    }



    public function form_add_request()
    {
        return view('pembelian/request_order/tambah_request_order');
    }

    public function getOutlet()
    {

        $comp = Auth::user()->m_id;

        $query = DB::table('m_company')
            ->select('m_company.c_name')
            ->join('d_mem', 'm_company.c_id', '=', 'd_mem.m_comp')
            ->where('d_mem.m_id', $comp)->get();

        foreach ($query as $row) {
            $outlet = $row->c_name;
        }

        $data = array(
            "C_NAME" => $outlet,
        );

        echo json_encode($data);
    }

    public function getKelompok_item()
    {
        $data = DB::table('d_item')
            ->select('d_item.i_kelompok')
            ->groupBy('d_item.i_kelompok')
            ->get();
        echo json_encode($data);
    }

    public function getMerk(Request $request)
    {
        $kelompok = $request->input('kelompok');

        $data = DB::table('d_item')
            ->select('d_item.i_id', 'd_item.i_merk')
            ->where('d_item.i_kelompok', $kelompok)
            ->groupBy('d_item.i_merk')
            ->get();

        echo json_encode($data);
    }



    public function getBarang()
    {
        $data = DB::table('d_item')
            ->select('d_item.i_id', 'd_item.i_nama')
            ->get();

        echo json_encode($data);
    }

    public function showItem(Request $request)
    {
        $i_id = $request->input('item_id');
        $data = DB::table('d_item')
            ->select('d_item.i_merk', 'd_item.i_nama')
            ->where('d_item.i_id', $i_id)
            ->get();

        echo json_encode($data);
    }

    public function simpanRequest(Request $request)
    {
        $comp    = Auth::user()->m_comp;
        $user    = Auth::user()->m_id;
        $dateReq = Carbon::now('Asia/Jakarta');
        $status  = 'WAITING';
        $dumy    = DB::table('d_purchase_req_dumy')
            ->select('d_purcahse_req_dumy.*')
            ->where('d_purchase_req_dumy.pr_mem_id')
            ->get();

        $data = array(
            'pr_compReq' => $comp,
            'pr_itemReq' => $dumy->pr_item,
            'pr_qtyReq'  => $dumy->pr_qty,
            'pr_qtyReq'  => $dumy->pr_qtyApp,
            'pr_dateReq' => $dateReq,
            'pr_stsReq'  => $status,
        );

        $insert = DB::table('purchase_req')->insert($data);

        if ($insert) {
            $status = "SUKSES";
        } else {
            $status = "GAGAL";
        }

        echo json_encode($status);
    }

    public function verifikasi_simpanRequest()
    {
        $comp    = Auth::user()->m_comp;
        $dateReq = Carbon::now('Asia/Jakarta');
        $status  = 'P';
        $user    = Auth::user()->m_id;
        $code    = Carbon::now()->timestamp;

        $query = DB::table('d_requestorder')
            ->select('d_requestorder.*')
            ->where('d_requestorder.ro_comp',$comp)
            ->where('d_requestorder.ro_state', 'D')
            ->get();

        $baris = count($query);
        if($baris == "0"){
            $response = "notFound";
            echo json_encode(array("status" => $response));
        } else {

                $update = DB::table('d_requestorder')
                    ->where('d_requestorder.ro_comp', $comp)
                    ->where('d_requestorder.ro_state', 'D')
                    ->update([
                        'ro_state'   => $status,
                        'ro_date'    => $dateReq
                ]);

            if (!$update) {
                $response = "gagal";
                echo json_encode(array("status" => $response));
            } else {
                $response = "sukses";
                echo json_encode(array("status" => $response));
            }

        }

    }

    public function request_order_add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $ro_no = $this->generate_code('d_request_order', 'ro_no', 4, 'RO' . date('ymd'));
            $sql = DB::table('d_request_order')->insert([
                'ro_no'     => $ro_no,
                'ro_cabang' => $data['ro_cabang']
            ]);

            $no = 1;
            foreach ($data['kode_barang'] as $key => $value) {
                $rdt_no = $this->generate_code('d_request_order_dt', 'rdt_no', 4, 'RODT' . date('dmy'));
                if (!empty($value)) {

                    $sql2 = DB::table('d_request_order_dt')->insert([
                        'rdt_request'          => $ro_no,
                        'rdt_no'               => $rdt_no,
                        'rdt_kode_barang'      => $data['kode_barang'][$key],
                        'rdt_kuantitas'        => $data['kuantitas'][$key],
                        'rdt_kuantitas_approv' => '0',
                        'rdt_status'           => 'Pending',
                        'rdt_supplier'         => "0"
                    ]);
                }
                $no++;
            }

            return redirect('/pembelian/request-order')->with('flash_message_success', 'Data berhasil ditambahkan!');
        }
        $data_outlet = DB::table('d_cabang')->get();
        return view('pembelian/request_order/tambah_request_order', compact('data_outlet'));
    }

    public function edit_order(Request $request)
    {
        $data = DB::table('d_request_order_dt')
            ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_request_order_dt.rdt_no', $request->id)->get();

        if (count($data) == 0) {
            return view('errors.data_not_found');
        }

        return view('pembelian.request_order.edit_request_order', compact('data'));
    }

    public function edit_multiple(Request $request)
    {
        $data = DB::table('d_request_order_dt')
            ->select('d_request_order.ro_no', 'd_request_order.ro_cabang', 'd_request_order_dt.rdt_request', 'd_request_order_dt.rdt_no', 'd_request_order_dt.rdt_kode_barang', 'd_request_order_dt.rdt_kuantitas', 'd_request_order_dt.rdt_kuantitas_approv', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->whereIn('d_request_order_dt.rdt_no', $request->data_check)->get();
        return view('pembelian.request_order.edit_request_order', compact('data'));
    }

    public function get_order($id)
    {
        $data = DB::table('d_request_order_dt')
            ->select('d_request_order_dt.*', 'd_request_order.*', 'd_supplier.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_supplier', 'd_request_order_dt.rdt_supplier', '=', 'd_supplier.s_id', 'left')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_request_order_dt.rdt_no', $id)->first();

        return json_encode($data);
    }

    public function update_order(Request $request)
    {
        $data = DB::table('d_request_order_dt')->where('rdt_no', $request->rdt_request_no);

        if (!$data->first()) {
            $response = [
                'status'  => 'tidak ada',
                'content' => 'null'
            ];

            return json_encode($response);
        } else {
            $data->update([
                'rdt_kode_barang' => $request->kode_barang,
                'rdt_kuantitas'   => $request->kuantitas
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'  => 'berhasil',
                'content' => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_delete_order(Request $request)
    {

        for ($i = 0; $i < count($request->rdt_request); $i++) {
            DB::table('d_request_order_dt')->where('rdt_no', $request->rdt_no[$i])->delete();
            $check_rdt_req = DB::table('d_request_order_dt')
                ->where('rdt_request', $request->rdt_request[$i])
                ->get();
            if (count($check_rdt_req) == 0) {
                $check_ro = DB::table('d_request_order')
                    ->where('ro_no', $request->rdt_request[$i])
                    ->get();
                if (count($check_ro) != 0) {
                    DB::table('d_request_order')->where('ro_no', $request->rdt_request[$i])->delete();
                }

            }

        }

        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return json_encode([
            'status' => 'berhasil'
        ]);
    }

    public function request_order_status(Request $request)
    {
        $data = $request->all();
        if ($data['status'] == "Pending") {
            $check_data = DB::table('d_rencana_pembelian')
                ->where('no_rdt', $data['rdt_no'])
                ->get();
            if (count($check_data) > 0) {
                $getData = DB::table('d_rencana_pembelian')
                    ->where('no_rdt', $data['rdt_no'])
                    ->first();
                DB::table('d_rencana_pembelian_dt')
                    ->where('rpdt_rencana', $getData->rp_no)
                    ->delete();
                DB::table('d_rencana_pembelian')
                    ->where('no_rdt', $data['rdt_no'])
                    ->delete();
            }
            $sql = DB::table('d_request_order_dt')
                ->where('rdt_request', $data['rdt_request'])
                ->where('rdt_no', $data['rdt_no'])
                ->update([
                    'rdt_status' => ""
                ]);
            if ($sql) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "' . $data['rdt_no'] . '" berhasil diubah ke "Pending".');
                $response = [
                    'status'  => 'pending',
                    'content' => null
                ];
                return json_encode($response);
            } else {
                return redirect()->back()->with('flash_message_error', 'Gagal merubah status order barang!!!');
            }
        } else if ($data['status'] == "Dibatalkan") {

            $check_data = DB::table('d_rencana_pembelian')
                ->where('no_rdt', $data['rdt_no'])
                ->get();
            if (count($check_data) > 0) {
                $getData = DB::table('d_rencana_pembelian')
                    ->where('no_rdt', $data['rdt_no'])
                    ->first();
                DB::table('d_rencana_pembelian_dt')
                    ->where('rpdt_rencana', $getData->rp_no)
                    ->delete();
                DB::table('d_rencana_pembelian')
                    ->where('no_rdt', $data['rdt_no'])
                    ->delete();
            }
            $sql = DB::table('d_request_order_dt')
                ->where('rdt_request', $data['rdt_request'])
                ->where('rdt_no', $data['rdt_no'])
                ->update([
                    'rdt_status' => $data['status']
                ]);
            if ($sql) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "' . $data['rdt_no'] . '" berhasil diubah ke "Dibatalkan".');
                $response = [
                    'status'  => 'dibatalkan',
                    'content' => null
                ];
                return json_encode($response);
            } else {
                return redirect()->back()->with('flash_message_error', 'Gagal merubah status order barang!!!');
            }
        } else if ($data['status'] == "Ditunda") {
            $check_data = DB::table('d_rencana_pembelian')
                ->where('no_rdt', $data['rdt_no'])
                ->get();
            if (count($check_data) > 0) {
                $getData = DB::table('d_rencana_pembelian')
                    ->where('no_rdt', $data['rdt_no'])
                    ->first();
                DB::table('d_rencana_pembelian_dt')
                    ->where('rpdt_rencana', $getData->rp_no)
                    ->delete();
                DB::table('d_rencana_pembelian')
                    ->where('no_rdt', $data['rdt_no'])
                    ->delete();
            }

            $sql = DB::table('d_request_order_dt')
                ->where('rdt_request', $data['rdt_request'])
                ->where('rdt_no', $data['rdt_no'])
                ->update([
                    'rdt_status' => $data['status']
                ]);
            if ($sql) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "' . $data['rdt_no'] . '" berhasil diubah ke "Ditunda".');
                $response = [
                    'status'  => 'ditunda',
                    'content' => null
                ];
                return json_encode($response);
            } else {
                return redirect()->back()->with('flash_message_error', 'Gagal merubah status order barang!!!');
            }
        } else {
            $check = DB::table('d_rencana_pembelian')->get();
            $no_rp = date('Ymd') . count($check) + 1;

            $check_dt = DB::table('d_rencana_pembelian_dt')->get();
            $no_rpdt = date('dmY') . count($check_dt) + 1;

            $sql1 = DB::table('d_request_order_dt')
                ->where('rdt_request', $data['rdt_request'])
                ->where('rdt_no', $data['rdt_no'])
                ->update([
                    'rdt_status' => $data['status']
                ]);

            if ($sql1) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "' . $data['rdt_no'] . '" berhasil diubah ke "Rencana Pembelian".');
                $response = [
                    'status'  => 'rencana pembelian',
                    'content' => null
                ];
                return json_encode($response);
            } else {
                return redirect()->back()->with('flash_message_error', 'Status order barang gagal diubah!!');
            }
        }

    }



    public function dtSemua()
    {
        $list = DB::table('d_purchase_req')
            ->select('d_purchase_req.pr_id', 'm_company.c_name', 'd_mem.m_name', 'd_item.i_nama', 'd_purchase_req.pr_qtyReq', 'd_purchase_req.pr_stsReq')
            ->join('d_item', 'd_purchase_req.pr_itemReq', '=', 'd_item.i_id')
            ->join('d_mem', 'd_purchase_req.pr_compReq', '=', 'd_mem.m_id')
            ->join('m_company', 'd_mem.m_comp', '=', 'm_company.c_id')
            ->where('d_purchase_req.pr_stsReq', 'WAITING')
            ->get();

        $data = array();
        foreach ($list as $hasil) {
            $row = array();
            $row[] = $hasil->pr_id;
            $row[] = $hasil->c_name;
            $row[] = $hasil->i_nama;
            $row[] = $hasil->pr_qtyReq;
            if ($hasil->pr_stsReq == 'WAITING') {
                $row[] = "<span class='label label-danger'>BELUM DI PROSES</span>";
            } else if ($hasil->pr_stsReq == 'PROSES') {
                $row[] = "<span class='label label-warning'>SEDANG DI PROSES.</span>";
            }

            if (Plasma::checkAkses(47, 'update') == true) {
                $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $hasil->pr_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    // $row[] = "<span class='label label-warning'>SEDANG DI PROSES.</span>";
            } else {
                    // $row[] =  "<span class='label label-warning'>SEDANG DI PROSES.</span>";
                $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . $hasil->pr_id . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $hasil->pr_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $hasil->pr_id . '\', \'' . $hasil->pr_id . '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
            }

            $data[] = $row;
        }
        echo json_encode(array("data" => $data));
    }

    public function addRencana()
    {
        $request1 = DB::table('d_requestorder')
            ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            ->where('d_requestorder.ro_state', 'P')
            ->select(
                DB::raw('CONCAT("ro-", d_requestorder.ro_id) as id'),
                DB::raw('d_requestorder.ro_comp as comp'),
                DB::raw('d_requestorder.ro_item as item'),
                DB::raw('d_requestorder.ro_qty as qty'),
                DB::raw('date_format(ro_date, "%d/%m/%Y") as date'),
                'c_name','i_nama');

        $request2 = DB::table('d_indent')
            ->join('m_company', 'd_indent.i_comp', '=', 'm_company.c_id')
            ->join('d_indent_dt', 'id_indent', '=', 'd_indent.i_id')
            ->join('d_item', 'd_indent_dt.id_item', '=', 'd_item.i_id')
            ->where('d_indent.i_status', 'P')
            ->select(
                DB::raw('CONCAT("pb-", d_indent.i_id) as id'),
                DB::raw('d_indent.i_comp as comp'),
                DB::raw('id_item as item'),
                DB::raw('id_qty as qty'),
                DB::raw('d_indent.i_nota as date'),
                'c_name','i_nama');

        $request = $request1->union($request2)->get();

        return view('pembelian/rencana_pembelian/add', compact('request'));
    }

    public function getItem(Request $request)
    {
        $key = $request->term;
        $nama = DB::table('d_item')
            ->select('i_id', 'i_nama')
            ->where(function ($q) use ($key) {
                $q->orWhere('i_nama', 'like', '%' . $key . '%');
                $q->orWhere('i_code', 'like', '%' . $key . '%');
                $q->orWhere('i_kelompok', 'like', '%' . $key . '%');
                $q->orWhere('i_group', 'like', '%' . $key . '%');
                $q->orWhere('i_sub_group', 'like', '%' . $key . '%');
                $q->orWhere('i_merk', 'like', '%' . $key . '%');
            })
            ->groupBy('i_id')
            ->get();

        if ($nama == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->i_id, 'label' => $query->i_nama];
            }
        }
        return Response::json($results);
    }

    public function multiple_edit_rencana_pembelian(Request $request)
    {
        $data = DB::table('d_request_order_dt')
            ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->whereIn('d_request_order_dt.rdt_no', $request->data_check)->get();
        $data_supplier = DB::table('d_supplier')->get();

        if (count($data) == 0) {
            return view('errors.data_not_found');
        }

        return view('pembelian.rencana_pembelian.edit_rencana_pembelian', compact('data', 'data_supplier'));
    }

    public function rencana_pembelian_edit(Request $request)
    {
        $data = DB::table('d_request_order_dt')
            ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
            ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
            ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
            ->where('d_request_order_dt.rdt_no', $request->id)->get();
        $data_supplier = DB::table('d_supplier')->get();

        if (count($data) == 0) {
            return view('errors.data_not_found');
        }

        return view('pembelian.rencana_pembelian.edit_rencana_pembelian', compact('data', 'data_supplier'));
    }

    public function update_rencana_pembelian(Request $request)
    {
        $data = DB::table('d_request_order_dt')->where('rdt_no', $request->rdt_request_no);

        if (!$data->first()) {
            $response = [
                'status'  => 'tidak ada',
                'content' => 'null'
            ];

            return json_encode($response);
        } else {
            $data->update([
                'rdt_kuantitas_approv' => $request->kuantitas_approv,
                'rdt_supplier' => $request->supplier
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'  => 'berhasil',
                'content' => null
            ];

            return json_encode($response);
        }
    }

    public function coba_print()
    {
        $pdf = PDF::loadView('pembelian.coba_cetak');
        return $pdf->stream();

    }

    public function new_print()
    {
        return view('pembelian.konfirmasi_pembelian.newprint');
    }

    public function updateReq(Request $request)
    {
        DB::beginTransaction();
        try {
            DB::table('d_requestorder')->where('ro_id', '=', $request->id)
            ->update([
                'ro_qty'   => $request->qty,
                'ro_state' => 'P'
            ]);
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data'   => $e
            ]);
        }
    }

    public function updateReqTolak(Request $request)
    {
        $date_now = Carbon::now('Asia/Jakarta');
        DB::beginTransaction();
        try {
            DB::table('d_requestorder')->where('ro_id', '=', $request->id)
            ->update([
                'ro_qty'   => $request->qty,
                'ro_state' => 'P',
                'ro_date'  => $date_now
            ]);
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data'   => $e
            ]);
        }
    }

    public function hapusReq(Request $request)
    {
        DB::beginTransaction();
        try {
            DB::table('d_requestorder')->where('ro_id', '=', $request->id)
            ->delete();

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);

        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data'   => $e
            ]);
        }
        // $comp = Auth::user()->m_id;
        // $id = $request->input('ro_id');

        // $delete = DB::table('d_requestorder')
        //     ->where('d_requestorder.ro_id', $id)
        //     ->delete();

        // if (!$delete) {

        //     $response = "gagal";
        //     echo json_encode(array("status" => $response));

        // } else {
        //     $response = "sukses";
        //     echo json_encode(array("status" => $response));

        // }

    }

    public function tambahrencana_view()
    {
        $confirmOrder = DB::table('d_requestorder')
            ->select(
                'd_requestorder.ro_id',
                'd_requestorder.ro_comp',
                'd_requestorder.ro_item',
                'd_requestorder.ro_qty',
                'd_requestorder.ro_state',
                'm_company.c_name',
                'd_item.i_nama'
            )
            ->join('m_company', 'd_requestorder.ro_comp', '=', 'm_company.c_id')
            ->join('d_item', 'd_requestorder.ro_item', '=', 'd_item.i_id')
            ->where('d_requestorder.ro_state', 'P')
            ->get();

        return DataTables::of($confirmOrder)
            ->addColumn('input', function ($confirmOrder) {

                return '<div class="text-center"><input type="number" min="0" class="form-control" name="qtyApp" id="qty-'.$confirmOrder->ro_id.'" placeholder="QTY"  style="text-transform: uppercase" onkeyup="setQty(\'qty-'.$confirmOrder->ro_id.'\')" value="0"/></div>';

            })
            ->addColumn('aksi', function ($confirmOrder) {
                return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" ><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-hapus btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button></div>';
            })
            ->rawColumns(['input', 'aksi'])
            ->make(true);


    }



}
