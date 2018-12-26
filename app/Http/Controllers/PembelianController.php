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

    public function rencana_pembelian()
    {
        
    	return view('pembelian/rencana_pembelian/index');
    }

    public function rencanaMenunggu(){
       
        $menunggu  = DB::table('d_purchase_plan')
                    ->select(
                        'd_purchase_plan.pr_idPlan',
                        'd_purchase_plan.pr_idReq',
                        'd_purchase_plan.pr_itemPlan',
                        'd_purchase_plan.pr_supplier',
                        'd_purchase_plan.pr_qtyReq',
                        'd_purchase_plan.pr_qtyApp',
                        'd_purchase_plan.pr_stsPlan',
                        'd_purchase_plan.pr_dateRequest',
                        'd_purchase_plan.pr_dateApp',
                        'd_purchase_plan.pr_comp',
                        'd_item.i_nama',
                        'm_company.c_name'
                    )
                    ->join('d_item','d_purchase_plan.pr_itemPlan','=','d_item.i_id')
                    ->join('d_mem','d_purchase_plan.pr_comp','=','d_mem.m_id')
                    ->join('m_company','d_mem.m_comp','=','m_company.c_id')
                    ->where('d_purchase_plan.pr_stsPlan','WAITING')
                    ->get();
        $menunggu = collect($menunggu);

        return DataTables::of($menunggu)
            
            ->addColumn('aksi', function ($menunggu) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$menunggu->pr_idPlan. '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$menunggu->pr_idPlan. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $menunggu->pr_idPlan . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $menunggu->pr_idPlan. '\', \'' .$menunggu->pr_idPlan. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input','aksi'])
            ->make(true);
    }

    public function rencanaDisetujui(){
        $setujui  = DB::table('d_purchase_plan')
        ->select(
            'd_purchase_plan.pr_idPlan',
            'd_purchase_plan.pr_idReq',
            'd_purchase_plan.pr_itemPlan',
            'd_purchase_plan.pr_supplier',
            'd_purchase_plan.pr_qtyReq',
            'd_purchase_plan.pr_qtyApp',
            'd_purchase_plan.pr_stsPlan',
            'd_purchase_plan.pr_dateRequest',
            'd_purchase_plan.pr_dateApp',
            'd_purchase_plan.pr_comp',
            'd_item.i_nama',
            'm_company.c_name'
        )
        ->join('d_item','d_purchase_plan.pr_itemPlan','=','d_item.i_id')
        ->join('d_mem','d_purchase_plan.pr_comp','=','d_mem.m_id')
        ->join('m_company','d_mem.m_comp','=','m_company.c_id')
        ->where('d_purchase_plan.pr_stsPlan','DISETUJUI')
        ->get();
        $setujui = collect($setujui);

        return DataTables::of($setujui)
            ->addColumn('input', function ($setujui) {
                
                    return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTy"  style="text-transform: uppercase" /></div>';
                
            })
            ->addColumn('aksi', function ($setujui) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$setujui->pr_idPlan. '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$setujui->pr_idPlan. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $setujui->pr_idPlan . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $setujui->pr_idPlan. '\', \'' .$setujui->pr_idPlan. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input','aksi'])
            ->make(true);
    }

    public function rencanaDitolak(){
        $ditolak  = DB::table('d_purchase_plan')
        ->select(
            'd_purchase_plan.pr_idPlan',
            'd_purchase_plan.pr_idReq',
            'd_purchase_plan.pr_itemPlan',
            'd_purchase_plan.pr_supplier',
            'd_purchase_plan.pr_qtyReq',
            'd_purchase_plan.pr_qtyApp',
            'd_purchase_plan.pr_stsPlan',
            'd_purchase_plan.pr_dateRequest',
            'd_purchase_plan.pr_dateApp',
            'd_purchase_plan.pr_comp',
            'd_item.i_nama',
            'm_company.c_name'
        )
        ->join('d_item','d_purchase_plan.pr_itemPlan','=','d_item.i_id')
        ->join('d_mem','d_purchase_plan.pr_comp','=','d_mem.m_id')
        ->join('m_company','d_mem.m_comp','=','m_company.c_id')
        ->where('d_purchase_plan.pr_stsPlan','DITOLAK')
        ->get();
        $ditolak = collect($ditolak);

        return DataTables::of($ditolak)
            ->addColumn('input', function ($ditolak) {
                
                    return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTy"  style="text-transform: uppercase" /></div>';
                
            })
            ->addColumn('aksi', function ($ditolak) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$ditolak->pr_idPlan. '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$ditolak->pr_idPlan. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $ditolak->pr_idPlan . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $ditolak->pr_idPlan. '\', \'' .$ditolak->pr_idPlan. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input','aksi'])
            ->make(true);
    }

    public function rencanaSemua()
    {
        $semua  = DB::table('d_purchase_plan')
        ->select(
            'd_purchase_plan.pr_idPlan',
            'd_purchase_plan.pr_idReq',
            'd_purchase_plan.pr_itemPlan',
            'd_purchase_plan.pr_supplier',
            'd_purchase_plan.pr_qtyReq',
            'd_purchase_plan.pr_qtyApp',
            'd_purchase_plan.pr_stsPlan',
            'd_purchase_plan.pr_dateRequest',
            'd_purchase_plan.pr_dateApp',
            'd_purchase_plan.pr_comp',
            'd_item.i_nama',
            'm_company.c_name'
        )
        ->join('d_item','d_purchase_plan.pr_itemPlan','=','d_item.i_id')
        ->join('d_mem','d_purchase_plan.pr_comp','=','d_mem.m_id')
        ->join('m_company','d_mem.m_comp','=','m_company.c_id')
        ->get();
        $semua = collect($semua);

        return DataTables::of($semua)
        ->addColumn('input', function ($semua) {
                
            return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTy"  style="text-transform: uppercase" /></div>';
        
    })
    ->addColumn('aksi', function ($semua) {
        if (Plasma::checkAkses(47, 'update') == false) {
            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$semua->pr_idPlan. '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
        } else {
            return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$semua->pr_idPlan. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $semua->pr_idPlan . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $semua->pr_idPlan. '\', \'' .$semua->pr_idPlan. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
        }
    })
    ->rawColumns(['input','aksi'])
    ->make(true);
            
    }

    public function view_tambahRencana()
    {
        $tambahRencana  = DB::table('d_purchase_req')
        ->select(
            'd_purchase_req.pr_id',
            'd_purchase_req.pr_codeReq',
            'm_company.c_name',
            'd_item.i_nama',
            'd_purchase_req.pr_qtyReq',
            'd_purchase_req.pr_dateReq',
            'd_purchase_req.pr_stsReq'
        )
        ->join('d_mem','d_purchase_req.pr_compReq','=','d_mem.m_id')
        ->join('m_company','d_mem.m_comp','=','m_company.c_id')
        ->join('d_item','d_purchase_req.pr_itemReq','=','d_item.i_id')
        ->where('d_purchase_req.pr_stsReq','WAITING')
        ->get();
        $tambahRencana = collect($tambahRencana);

        return DataTables::of($tambahRencana)
            ->addColumn('input', function ($tambahRencana) {
                
                    return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTY"  style="text-transform: uppercase" /></div>';
                
            })
            ->addColumn('aksi', function ($tambahRencana) {
                if (Plasma::checkAkses(47, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="tambahRencana('.$tambahRencana->pr_id.')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit('. $tambahRencana->pr_id .')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Di Tolak" onclick="getTolak('. $tambahRencana->pr_id .')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['input','aksi'])
            ->make(true); 
    }

    public function itemSuplier()
    {
        $query = DB::table('d_supplier')
                ->select('d_supplier.s_id','d_supplier.s_company')
                ->get();
        echo json_encode($query);
    }

    public function tambahRencana(Request $request)
    {
        $comp = $request->input('comp');
        $pr_idReq = $request->input('pr_idReq');
        $pr_itemPlan = $request->input('pr_idReq');
        $pr_qtyReq = $request->input('pr_idReq');
        $pr_dateRequest = $request->input('pr_idReq');
        $pr_supplier = $request->input('supplier');
        $pr_qtyApp = $request->input('qty');
        
        $pr_dateApp = Carbon::now('Asia/Jakarta');
        $pr_stsPlan = "WAITING";

        $list = array(
            'pr_idReq'=>$pr_idReq,
            'pr_itemPlan'=>$pr_itemPlan,
            'pr_qtyReq'=>$pr_qtyReq,
            'pr_dateRequest'=>$pr_dateRequest,
            'pr_supplier'=>$pr_supplier, 
            'pr_qtyApp'=>$pr_qtyApp,
            'pr_stsPlan'=>$pr_stsPlan,
            'pr_dateApp'=>$pr_dateApp,
            'pr_comp'=>$comp
        );

        $insert = DB::table('d_purchase_plan')->insert($list);
        if(!$insert){
            
            $data = "GAGAL";
            echo json_encode(array("status"=>$data));
        }else{
            $reqOrder = DB::table('d_purchase_req')
                ->where('d_purchase_req.pr_id',$pr_idReq)
                ->update([
                    'pr_stsReq'=>'DIPROSES'
                ]);
                if(!$reqOrder){
                    $data = "GAGAL";
                    echo json_encode(array("status"=>$data));
                }else{
                    $data = "SUKSES";
                    echo json_encode(array("status"=>$data));
                }
            
        }
        
    }

    public function tolakRequest(Request $request)
    {
        $pr_idReq = $request->input('pr_idReq');
        $reqOrder = DB::table('d_purchase_req')
        ->where('d_purchase_req.pr_id',$pr_idReq)
        ->update([
            'pr_stsReq'=>'DITOLAK'
        ]);
        if($reqOrder){
            $data = "SUKSES";
            echo json_encode(array("status"=>$data));
        }else{
            $data = "GAGAL";
            echo json_encode(array("status"=>$data));
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
                    'm_company.c_tlp',
                )

                ->join('d_mem','d_purchase_req.pr_compReq','=','d_mem.m_id')
                ->join('d_item','d_purchase_req.pr_itemReq','=', 'd_item.i_id')
                ->join('m_company','d_mem.m_comp','=','m_company.c_id')
                ->where('d_purchase_req.pr_id',$id)
                ->get();


                foreach($query as $value)
                {
                    $pr_id2     = $value->pr_id;
                    $pr_codeReq = $value->pr_codeReq;
                    $pr_compReq = $value->pr_compReq;
                    $pr_itemReq = $value->pr_itemReq;
                    $pr_qtyReq  = $value->pr_qtyReq;
                    $pr_dateReq = $value->pr_dateReq;
                    $pr_stsReq  = $value->pr_stsReq;
                    $i_id       = $value->i_id;
                    $i_kelompok = $value->i_kelompok;
                    $i_group    = $value->i_group;
                    $i_sub_group= $value->i_sub_group;
                    $i_merk     = $value->i_merk;
                    $i_nama     = $value->i_nama;
                    $i_specificcode = $value->i_specificcode;
                    $i_code     = $value->i_code;
                    $i_isactive = $value->i_isactive;
                    $i_price    = $value->i_price;
                    $i_minstock = $value->i_minstock;
                    $i_berat    = $value->i_berat;
                    $i_img      = $value->i_img;
                    $c_name     = $value->c_name;
                    $c_address  = $value->c_address;
                    $c_tlp      = $value->c_tlp;
                }

                $item = array(
                    'pr_id' =>$pr_id2,
                    "pr_codeReq"=>$pr_codeReq,
                    "pr_compReq"=>$pr_compReq,
                    "pr_itemReq"=>$pr_itemReq,
                    "pr_qtyReq"=>$pr_qtyReq,
                    "pr_dateReq"=>$pr_dateReq,
                    "pr_stsReq"=>$pr_stsReq,
                    "i_id"=>$i_id,
                    "i_kelompok"=>$i_kelompok,
                    "i_group"=>$i_group,
                    "i_sub_group"=>$i_sub_group,
                    "i_merk"=>$i_merk,
                    "i_nama"=>$i_nama,
                    "i_specificcode"=>$i_specificcode,
                    "i_code"=>$i_code,
                    "i_isactive"=>$i_isactive,
                    "i_price"=>$i_price,
                    "i_minstock"=>$i_minstock,
                    "i_berat"=>$i_berat,
                    "i_img"=>$i_img,
                    "c_name"=>$c_name,
                    "c_address"=>$c_address,
                    "c_tlp"=>$c_tlp,
                );

        echo json_encode(array("data"=>$item));
    } 

    public function getBarang_input(Request $request){
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('d_item')
            // ->select('d_item.i_nama')
            ->where('d_item.i_nama','LIKE',"%{$query}%")
            ->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative" >';
            foreach($data as $row)
            {
                $output .= '<li><a href="#" >'.$row->i_nama.'</a></li>';
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

    public function konfirmasi_pembelian()
    { 
        // $data = "Null";
        // $data_supplier = DB::table('d_supplier')
        //                 ->join('d_request_order_dt', 'd_supplier.s_id', '=', 'd_request_order_dt.rdt_supplier')
        //                 ->where('d_request_order_dt.rdt_status', '=', 'Rencana Pembelian')
        //                 ->groupBy('d_supplier.s_name')
        //                 ->get();
        // print_r($data_supplier);
    	// return view('pembelian/konfirmasi_pembelian/index', compact('data', 'data_supplier'));

        return view('pembelian/konfirmasi_pembelian/view_konfirmasi_pembelian');
    }

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

        // print_r($data_order); die;

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
        $data_return = DB::table('d_purchase_return')
                        ->select('d_purchase_return.*', 'd_purchase_return_dt.*')
                        ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
                        ->get();
                        // print_r($data_return); die;
    	return view('pembelian/return_barang/index')->with(compact('data_return'));
    }

    public function return_barang_add(Request $request)
    {
        if ($request->isMethod('post'))
        {
            // $data               = $request->all();
            // print_r($data); die;

            $count              = DB::table('d_purchase_return')->count();
            $urutan             = $count + 1;
            $pr_code            = 'PR'.date('YmdHms').$urutan;

            $harga_satuan       = $this->formatPrice($request->harga_satuan);
            $total_bayar        = $this->formatPrice($request->total_bayar);
            $total_harga_return = $this->formatPrice($request->total_harga_return);
            // print_r($total_harga_return); die;

            $result_price       = '';

            if ($request->methode_return == 'GB')
            {
                $result_price = $total_bayar;
            }
            elseif ($request->methode_return == 'PT')
            {
                $result_price = $total_bayar - $total_harga_return;
            }
            elseif ($request->methode_return == 'GU')
            {
                $result_price = $total_bayar - $total_harga_return;
            }
            elseif ($request->methode_return == 'PN')
            {
                $result_price = $total_bayar - $total_harga_return;
            }

            $return_brg = DB::table('d_purchase_return')->insertGetId([
                        'pr_po_id'          =>$request->purchase_order,
                        'pr_code'           =>$pr_code,
                        'pr_methode_return' =>$request->methode_return,
                        'pr_total_price'    =>$total_harga_return,
                        'pr_result_price'   =>$result_price,
                        'pr_status_return'  => 'WT'
                    ]);

            DB::table('d_purchase_return_dt')->insert([
                'pr_id'             =>$return_brg,
                'prd_kode_barang'   =>$request->kode_barang,
                'prd_qty'           =>$request->kuantitas_return,
                'prd_unit_price'    =>$harga_satuan,
                'prd_total_price'   =>$total_harga_return
            ]);

            

            return redirect('/pembelian/purchase-return')->with('flash_message_success','Data return barang berhasil ditambahkan!');


        }
        $purchase = DB::table('d_purchase_order_dt')->get();
        return view('pembelian.return_barang.add')->with(compact('purchase'));
    }

    public function get_current_return($id = null)
    {
        $data = DB::table('d_purchase_return')
                ->select('d_purchase_return.*', 'd_purchase_return_dt.*')
                ->join('d_purchase_return_dt', 'd_purchase_return.pr_id', '=', 'd_purchase_return_dt.pr_id')
                ->where(['d_purchase_return.pr_id'=>$id])
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

        if(count($data) == 0){
            return view('errors.data_not_found');
        }
        // print_r($data); die;
        return view('pembelian.return_barang.edit', compact('data'));
    }

    public function update_purchase_return(Request $request)
    {
        $harga_satuan       = $this->formatPrice($request->harga_satuan);
        $total_bayar        = $this->formatPrice($request->total_bayar);
        $total_harga_return = $this->formatPrice($request->total_harga_return);

        $result_price       = '';

        if ($request->methode_return == 'GB')
        {
            $result_price = $total_bayar;
        }
        elseif ($request->methode_return == 'PT')
        {
            $result_price = $total_bayar - $total_harga_return;
        }
        elseif ($request->methode_return == 'GU')
        {
            $result_price = $total_bayar - $total_harga_return;
        }
        elseif ($request->methode_return == 'PN')
        {
            $result_price = $total_bayar - $total_harga_return;
        }

        $data = DB::table('d_purchase_return')->where('pr_id', $request->return_id);

        if(!$data->first()){

            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];
            return json_encode($response);

        }else{

            if ($request->confirm_return == 'CF')
            {
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
                    'prd_qty'           =>$request->kuantitas_return,
                    'prd_total_price'   =>$total_harga_return,
                    'prd_isconfirm'     =>1
                ]);

                Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
                $response = [
                    'status'    => 'berhasil',
                    'content'   => null
                ];

                return json_encode($response);
            } 
            else
            {
                $data->update([
                    'pr_methode_return' => $request->methode_return,
                    'pr_total_price'    => $total_harga_return,
                    'pr_result_price'   => $result_price,
                    'pr_status_return'  => $request->confirm_return
                ]);

                DB::table('d_purchase_return_dt')
                ->where('pr_id', $request->return_id)
                ->update([
                    'prd_qty'           =>$request->kuantitas_return,
                    'prd_total_price'   =>$total_harga_return
                ]);

                Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
                $response = [
                    'status'    => 'berhasil',
                    'content'   => null
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

        if(count($data) == 0){
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

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

    public function show_purchase($id = null)
    {
        $data = DB::table('d_purchase_order_dt')
                ->select('d_purchase_order_dt.*', 'd_purchase_order.*', 'd_supplier.*')
                ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', '=', 'd_purchase_order.po_no')
                ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
                ->where(['podt_purchase'=>$id, 'po_status'=>'Diterima'])
                ->first();
        echo json_encode($data);
    }

    public function purchase_order()
    {
        // $data = DB::table('d_purchase_order_dt')
        //         ->select('d_purchase_order_dt.*', 'd_purchase_order.*', 'd_supplier.*')
        //         ->join('d_purchase_order', 'd_purchase_order_dt.podt_purchase', 'd_purchase_order.po_no')
        //         ->join('d_supplier', 'd_purchase_order_dt.podt_kode_suplier', '=', 'd_supplier.s_id')
        //         ->orderBy('d_purchase_order.po_status', 'desc')
        //         ->get();
    	// return view('pembelian/purchase_order/index', compact('data'));
        return view('pembelian/purchase_order/view_purchase_order');
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
        $explode_rp =  implode("", explode("Rp", $data));
        return implode("", explode(".", $explode_rp));
    }

    function generate_code($table, $field, $lebar=0, $awalan)
    {
        $order = DB::table($table)->select($field)->orderBy($field, 'desc')->limit(1);
        $countData = $order->count();
        if ($countData == 0) {
            $nomor = 1;
        }else{
            $getData = $order->get();
            $row = array();
            foreach ($getData as $value) {
                $row = array($value->$field);
            }
            // print_r($row); die;
            $nomor = intval(substr($row[0], strlen($awalan)))+1;
        }

        if ($lebar > 0) {
            $angka = $awalan.str_pad($nomor, $lebar,"0", STR_PAD_LEFT);
        }else{
            $angka = $awalan.$nomor;
        }

        return $angka;
    }

    public function add_purchase(Request $request)
    {
        // print_r($request->all()); die;
        $total_harga = $this->formatPrice($request->total_harga);
        $total_bayar = $this->formatPrice($request->total_bayar);
        $harga_satuan = $this->formatPrice($request->harga_satuan);
        // echo $harga_satuan; die;
        $po_no = $this->generate_code('d_purchase_order', 'po_no', 4, 'PO'.date('ymd'));
        
        $podt_no = $this->generate_code('d_purchase_order_dt', 'podt_no', 4, 'PODT'.date('dmy'));
        // print_r($po_no); die;
        if ($request->diskon == "") {
            # code...
            $diskon = "0";
        }else{
            $diskon = $request->diskon;
        }

        $insert_purchase_order = DB::table('d_purchase_order')->insert([
                                    'po_no'=>$po_no,
                                    'po_request_order_no'=>$request->request_dt_no,
                                    'po_status'=>$request->status,
                                    'po_type_pembayaran'=>$request->tipe_pembayaran,
                                    'po_total_harga'=>$total_harga,
                                    'po_diskon'=>$diskon,
                                    'po_ppn'=>$request->ppn,
                                    'po_total_bayar'=>$total_bayar
                                ]);

        $inser_purchase_order_dt = DB::table('d_purchase_order_dt')->insert([
                                        'podt_purchase'=>$po_no,
                                        'podt_no'=>$podt_no,
                                        'podt_kode_barang'=>$request->kode_barang,
                                        'podt_kode_suplier'=>$request->id_supplier,
                                        'podt_kuantitas'=>$request->kuantitas,
                                        'podt_harga_satuan'=>$harga_satuan
                                    ]);

        $update_request_order_dt = DB::table('d_request_order_dt')
                                    ->where('rdt_no', $request->request_dt_no)
                                    ->update(['rdt_status'=>$request->status]);

        return redirect('/pembelian/purchase-order')->with('flash_message_success','Data berhasil ditambahkan!');
    }

    public function get_purchase_order($id)
    {
        $data = DB::table('d_purchase_order_dt')
                ->select('d_purchase_order_dt.*', 'd_purchase_order.*', 'd_supplier.*', 'd_request_order.ro_cabang','d_cabang.c_nama')
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

        if(count($data) == 0){
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

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'podt_harga_satuan'=>$harga_satuan
            ]);
            DB::table('d_purchase_order')
            ->where('po_no', $request->po_no)
            ->update([
                'po_status'=>$request->status,
                'po_type_pembayaran'=>$request->tipe_pembayaran,
                'po_total_harga'=>$total_harga,
                'po_diskon'=>$request->diskon,
                'po_ppn'=>$request->ppn,
                'po_total_bayar'=>$total_bayar
            ]);

            DB::table('d_request_order_dt')
            ->where('rdt_no', $request->request_order)
            ->update([
                'rdt_status'=>$request->status
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
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

        if(count($data) == 0){
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

        return  json_encode([
                    'status'    => 'berhasil'
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
            $sub_total_bayar = $value->po_total_bayar;

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
            $sub_total_bayar = $value->po_total_bayar;

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
            $sub_total_bayar = $value->po_total_bayar;

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

    public function request_order_tambah(){
        return view('pembelian/request_order/tambah_request_order');
        // $comp = Auth::user()->m_id;
        // $del = DB::table('d_purchase_req_dumy')->where('pr_mem_id',$comp)->delete();

        // if($del){
        //     return view('pembelian/request_order/tambah_request_order');
        // }else{
        //     return view('pembelian/request_order/tambah_request_order');
        // }
        
    }

    

    public function addData(Request $request){

        $comp = Auth::user()->m_id;
        $item = $request->input('item');
        $qty = $request->input('qty');

        $insert =DB::table('d_purchase_req_dumy')->insert([
                'pr_item'                    => $item,
                'pr_qty'                     => $qty,
                'pr_mem_id'                => $$comp
                
            ]);
            
        if($insert){
            $status ="SUKSES";
        }else{
            $status ="GAGAL";
        }

        echo json_encode($status);
        
    }

    public function ddRequest_dumy(Request $request){
        $dateReq = Carbon::now('Asia/Jakarta');
        $status = 'DUMY';
        $comp = Auth::user()->m_id;
        $list  = DB::table('d_purchase_req')
                ->select('d_purchase_req.pr_id','d_purchase_req.pr_codeReq','d_item.i_nama','d_purchase_req.pr_compReq','d_purchase_req.pr_itemReq','d_purchase_req.pr_qtyReq','d_purchase_req.pr_dateReq','d_purchase_req.pr_stsReq')
                ->join('d_item','d_purchase_req.pr_itemReq','=','d_item.i_id')
                ->where('d_purchase_req.pr_compReq',$comp)
                ->where('d_purchase_req.pr_stsReq','DUMY')
                ->get();
       
                $data = array();
                foreach ($list as $hasil) {
                    $row = array();
                    $row[] = $hasil->i_nama;
                    // $row[] = $hasil->pr_qty;
                    $row[] = '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama'.$hasil->pr_id.'" value="'.$hasil->pr_qtyReq.'"  style="text-transform: uppercase" /></div>';
                    $row[] = '<div class="text-center"><button class="btn btn-xs btn-warning btn-circle"   title="Edit Data" onclick="editDumy(' .$hasil->pr_id. ')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle"   title="Hapus Data" onclick="hapusData(' .$hasil->pr_id. ')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                   $data[] = $row;
               }
                echo json_encode(array("data"=>$data));
    }

    public function addDumyReq(Request $request){
        $comp = Auth::user()->m_id;
        $item = $request->input('item');
        $qty = $request->input('qty');
        $dateReq = Carbon::now('Asia/Jakarta');
        $status = 'DUMY';

        


        $query = DB::table('d_item')
              ->select('d_item.i_id')
              ->where('d_item.i_nama',$item)->first();

        $itm = implode(" ", explode("+", $query->i_id));
        

        $insert = DB::table('d_purchase_req')
        ->insert([
            
            'pr_codeReq'     =>'',
            'pr_compReq'     =>$comp,
            'pr_itemReq'     =>$itm,
            'pr_qtyReq'      =>$qty,
            'pr_dateReq'     =>$dateReq,
            'pr_stsReq'      =>$status,
            
        ]);

        if($insert){
            $status ="SUKSES";
        }else{
            $status = "GAGAL";
        }

        echo json_encode(array("data"=>$status));
    }

    public function getDumyReq(){
        $comp = Auth::user()->mem_id;
        $item = $request->input('item_id');
        $qty = $request->input('qty');
        $id = $request->input('id');

        $query = DB::table('d_purchase_req_dumy')
        ->select('d_purchase_req_dumy.pr_id','d_item.i_nama','d_purchase_req_dumy.pr_qty')
        ->join('d_item','d_purchase_req_dumy.pr_item','=','d_item.i_id')
        ->where('d_purchase_req_dumy.pr_mem_id',$comp)
        ->get();

        $data = array(
            'pr_id'=>$query->pr_id,
            'i_nama'=>$query->i_nama,
            'pr_qty'=>$query->pr_qty,

        );

        echo json_encode($data);
    }



    public function editDumyReq(Request $request){
        $comp = Auth::user()->m_id;
        $id = $request->input('id');
        $qty = $request->input('qty');

        $update = DB::table('d_purchase_req')
        ->where('d_purchase_req.pr_compReq',$comp)
        ->where('d_purchase_req.pr_id',$id)
        ->update([
            'pr_qtyReq'=>$qty,
        ]);

        if($update){
            $data = "ok";
        }else{
            $data = "gagal";
        }
                
        echo json_encode(array("dataSet"=>$data));

    }

    public function hapusDumy(Request $request){
        $comp = Auth::user()->m_id;
        $id = $request->input('id');
        
        $delete = DB::table('d_purchase_req')
        ->where('d_purchase_req.pr_compReq',$comp)
        ->where('d_purchase_req.pr_id',$id)
        ->delete();

        if($delete){
            $data = "ok";
        }else{
            $data = "gagal";
        }
                
        echo json_encode(array("dataSet"=>$data));

    }


    public function menunggu(){
        $waiting  = DB::table('d_purchase_req')
                ->select('d_purchase_req.pr_id','m_company.c_name','d_item.i_nama','d_mem.m_name','d_purchase_req.pr_itemReq','d_purchase_req.pr_qtyReq','d_purchase_req.pr_stsReq')
                ->join('d_item','d_purchase_req.pr_itemReq','=','d_item.i_id')
                ->join('d_mem','d_purchase_req.pr_compReq','=','d_mem.m_id')
                ->join('m_company','d_mem.m_comp','=','m_company.c_id')
                ->where('d_purchase_req.pr_stsReq','WAITING')
                ->get();
        $waiting = collect($waiting);

        return DataTables::of($waiting)
            ->addColumn('pr_stsReq', function ($waiting) {

                return "<span class='label label-danger'>MENUNGGU...</span>";

            })

            ->addColumn('aksi', function ($waiting) {
                // return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$waiting->pr_id. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $waiting->pr_id . '\', \'' .$waiting->pr_id. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                if (Plasma::checkAkses(49, 'update') == false) {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$waiting->pr_id. '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                } else {
                    return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$waiting->pr_id. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $waiting->pr_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $waiting->pr_id . '\', \'' .$waiting->pr_id. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }
            })
            ->rawColumns(['pr_stsReq','aksi'])
            ->make(true);
    }

    public function all(){
        $all  = DB::table('d_purchase_req')
        ->select('d_purchase_req.pr_id','m_company.c_name','d_item.i_nama','d_mem.m_name','d_purchase_req.pr_itemReq','d_purchase_req.pr_qtyReq','d_purchase_req.pr_stsReq')
        ->join('d_item','d_purchase_req.pr_itemReq','=','d_item.i_id')
        ->join('d_mem','d_purchase_req.pr_compReq','=','d_mem.m_id')
        ->join('m_company','d_mem.m_comp','=','m_company.c_id')
        ->where('d_purchase_req.pr_stsReq','DIPROSES')
        ->get();
        $all = collect($all);

        return DataTables::of($all)
        ->addColumn('pr_stsReq', function ($waiting) {

            return "<span class='label label-danger'>PROSES PURCASHING...</span>";

        })
            // ->addColumn('input', function ($all) {
                
            //         return '<div class="text-center"><input type="text" class="form-control" name="i_nama" id="i_nama" placeholder="QTy"  style="text-transform: uppercase" /></div>';
                
            // })
            // ->addColumn('aksi', function ($all) {
            //     if (Plasma::checkAkses(47, 'update') == false) {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$all->pr_id. '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
            //     } else {
            //         return '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$all->pr_id. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $all->pr_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' . $all->pr_id . '\', \'' .$all->pr_id. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
            //     }
            // })
            ->rawColumns(['pr_stsReq'])
            ->make(true);
    }


    
    public function form_add_request()
    {
        return view('pembelian/request_order/tambah_request_order');
    }

    public function getOutlet(){

        $comp = Auth::user()->m_id;

        $query = DB::table('m_company')
                ->select('m_company.c_name')
                ->join('d_mem', 'm_company.c_id', '=', 'd_mem.m_comp')
                ->where('d_mem.m_id', $comp)->get();

            foreach ($query as $row) {
                $outlet = $row->c_name;
            }

            $data = array(
                "C_NAME"=>$outlet,
            );

        echo json_encode($data);



    }

    public function getKelompok_item(){
        $data  = DB::table('d_item')
        ->select('d_item.i_kelompok')
        ->groupBy('d_item.i_kelompok')
        ->get();
        echo json_encode($data);
    }

    public function getMerk(Request $request){
        $kelompok = $request->input('kelompok');

        $data  = DB::table('d_item')
        ->select('d_item.i_id','d_item.i_merk')
        ->where('d_item.i_kelompok',$kelompok)
        ->groupBy('d_item.i_merk')
        ->get();

        echo json_encode($data);
    }



    public function getBarang(){
        // $kelompok = $req->input('merk');

        $data  = DB::table('d_item')
        ->select('d_item.i_id','d_item.i_nama')
        // ->where('d_item.i_id',$kelompok)
        ->get();

        echo json_encode($data);
    }

    public function showItem(Request $request){
        $i_id = $request->input('item_id');

        $data =  DB::table('d_item')
        ->select('d_item.i_merk','d_item.i_nama')
        ->where('d_item.i_id',$i_id)
        ->get();

        echo json_encode($data);
    }

    public function simpanRequest(Request $request)
    {
        
        $comp = Auth::user()->m_id;
        $dateReq = Carbon::now('Asia/Jakarta');
        $status = 'WAITING';

        $dumy = DB::table('d_purchase_req_dumy')
                    ->select('d_purcahse_req_dumy.*')
                    ->where('d_purchase_req_dumy.pr_mem_id')
                    ->get();
        
        $data = array(
            'pr_compReq'    =>$comp,
            'pr_itemReq'    =>$dumy->pr_item,
            'pr_qtyReq'     =>$dumy->pr_qty,
            'pr_dateReq'    =>$dateReq,
            'pr_stsReq'     =>$status,
        );

        $insert =DB::table('purchase_req')->insert($data);

        if($insert){
            $status ="SUKSES";
        }else{
            $status ="GAGAL";
        }

        echo json_encode($status);
        
    }

    public function verifikasi_simpanRequest()
    {
        $dateReq = Carbon::now('Asia/Jakarta');
        $status = 'WAITING';
        $mem_id = Auth::user()->m_id;
        $code = Carbon::now()->timestamp;

        $update = DB::table('d_purchase_req')
        ->where('d_purchase_req.pr_compReq',$mem_id)
        ->where('d_purchase_req.pr_stsReq','DUMY')
        ->update([
            'pr_codeReq'=>$code,
            'pr_stsReq'=>$status,
            'pr_dateReq'=>$dateReq,
        ]);
        
        
        if(!$update){
            $response = "gagal";
            echo json_encode(array("status"=>$response));
        }else{
            $response = "sukses";
            echo json_encode(array("status"=>$response));
        }

        // echo json_encode($res);
    }

    public function request_order_add(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->all();

            // print_r($data); die;

            $ro_no = $this->generate_code('d_request_order', 'ro_no', 4, 'RO'.date('ymd'));
            // $rdt_no = date('HmsYmd').'1';

            $sql = DB::table('d_request_order')->insert([
                        'ro_no'=>$ro_no,
                        'ro_cabang'=>$data['ro_cabang']
                    ]);
            
            $no = 1;
            foreach ($data['kode_barang'] as $key => $value) {
                $rdt_no = $this->generate_code('d_request_order_dt', 'rdt_no', 4, 'RODT'.date('dmy'));
                if (!empty($value)) {

                    // $check_rdtno = DB::table('d_request_order_dt')->where('rdt_no', $rdt_no)->count();

                    // if ($check_rdtno > 0) {
                    //     $rdt_no = date('HmsYmd').$no;
                    // }
                    
                    $sql2 = DB::table('d_request_order_dt')->insert([
                        'rdt_request'=>$ro_no,
                        'rdt_no'=>$rdt_no,
                        'rdt_kode_barang'=>$data['kode_barang'][$key],
                        'rdt_kuantitas'=>$data['kuantitas'][$key],
                        'rdt_kuantitas_approv'=>'0',
                        'rdt_status'=>'Pending',
                        'rdt_supplier'=>"0"
                    ]);
                }
                $no++;
            }

            return redirect('/pembelian/request-order')->with('flash_message_success','Data berhasil ditambahkan!');
        }
        $data_outlet = DB::table('d_cabang')->get();
        return view('pembelian/request_order/tambah_request_order', compact('data_outlet'));
    }

    public function edit_order(Request $request)
    {
        // $data = order::where('rdt_no', $request->id)->get();
        $data = DB::table('d_request_order_dt')
                ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_request_order_dt.rdt_no', $request->id)->get();

        if(count($data) == 0){
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
        // $data = order::find($id);
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
        // return json_encode($request->all());

        $data = DB::table('d_request_order_dt')->where('rdt_no', $request->rdt_request_no);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'rdt_kode_barang'   => $request->kode_barang,
                'rdt_kuantitas'     => $request->kuantitas
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_delete_order(Request $request)
    {

        // print_r($request); die;

        for ($i = 0; $i < count($request->rdt_request); $i++) {
            # code...
            // print_r($key);echo ": ";print_r($value); echo "<pre>";
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

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }

    public function request_order_status(Request $request)
    {
        $data = $request->all();

        // echo json_encode($data); die;

        if ($data['status'] == "Pending") {
            $check_data = DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->get();
            if (count($check_data) > 0) {
                $getData = DB::table('d_rencana_pembelian')
                            ->where('no_rdt',$data['rdt_no'])
                            ->first();
                DB::table('d_rencana_pembelian_dt')
                    ->where('rpdt_rencana',$getData->rp_no)
                    ->delete();
                DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->delete();
            }
            $sql = DB::table('d_request_order_dt')
                    ->where('rdt_request',$data['rdt_request'])
                    ->where('rdt_no',$data['rdt_no'])
                    ->update([
                'rdt_status'=>""
            ]);
            if ($sql) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "'.$data['rdt_no'].'" berhasil diubah ke "Pending".');
                $response = [
                    'status'    => 'pending',
                    'content'   => null
                ];
                return json_encode($response);
            }else{
                return redirect()->back()->with('flash_message_error','Gagal merubah status order barang!!!');
            }
        } else if ($data['status'] == "Dibatalkan") {
            
            $check_data = DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->get();
            if (count($check_data) > 0) {
                $getData = DB::table('d_rencana_pembelian')
                            ->where('no_rdt',$data['rdt_no'])
                            ->first();
                DB::table('d_rencana_pembelian_dt')
                    ->where('rpdt_rencana',$getData->rp_no)
                    ->delete();
                DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->delete();
            }
            $sql = DB::table('d_request_order_dt')
                    ->where('rdt_request',$data['rdt_request'])
                    ->where('rdt_no',$data['rdt_no'])
                    ->update([
                'rdt_status'=>$data['status']
            ]);
            if ($sql) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "'.$data['rdt_no'].'" berhasil diubah ke "Dibatalkan".');
                $response = [
                    'status'    => 'dibatalkan',
                    'content'   => null
                ];
                return json_encode($response);
            }else{
                return redirect()->back()->with('flash_message_error','Gagal merubah status order barang!!!');
            }
        } else if ($data['status'] == "Ditunda") {
            $check_data = DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->get();
            if (count($check_data) > 0) {
                $getData = DB::table('d_rencana_pembelian')
                            ->where('no_rdt',$data['rdt_no'])
                            ->first();
                DB::table('d_rencana_pembelian_dt')
                    ->where('rpdt_rencana',$getData->rp_no)
                    ->delete();
                DB::table('d_rencana_pembelian')
                    ->where('no_rdt',$data['rdt_no'])
                    ->delete();
            }
            $sql = DB::table('d_request_order_dt')
                    ->where('rdt_request',$data['rdt_request'])
                    ->where('rdt_no',$data['rdt_no'])
                    ->update([
                'rdt_status'=>$data['status']
            ]);
            if ($sql) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "'.$data['rdt_no'].'" berhasil diubah ke "Ditunda".');
                $response = [
                    'status'    => 'ditunda',
                    'content'   => null
                ];
                return json_encode($response);
            }else{
                return redirect()->back()->with('flash_message_error','Gagal merubah status order barang!!!');
            }
        } else {
            $check = DB::table('d_rencana_pembelian')->get();
            $no_rp = date('Ymd').count($check)+1;

            $check_dt = DB::table('d_rencana_pembelian_dt')->get();
            $no_rpdt = date('dmY').count($check_dt)+1;

            $sql1 = DB::table('d_request_order_dt')
                    ->where('rdt_request',$data['rdt_request'])
                    ->where('rdt_no',$data['rdt_no'])
                    ->update([
                'rdt_status'=>$data['status']
            ]);

            // $sql2 = DB::table('d_rencana_pembelian')->insert([
            //     'rp_no'=>$no_rp,
            //     'no_rdt'=>$data['rdt_no']
            // ]);

            // $sql3 = DB::table('d_rencana_pembelian_dt')->insert([
            //     'rpdt_rencana'=>$no_rp,
            //     'rpdt_no'=>$no_rpdt,
            //     'rpdt_kode_barang'=>$data['kode_barang'],
            //     'rpdt_qty'=>$data['kuantitas'],
            //     'rpdt_kuantitas_approv'=>$data['kuantitas_approv']
            // ]);

            if ($sql1) {
                Session::flash('flash_message_success', 'Status untuk Request Detail "'.$data['rdt_no'].'" berhasil diubah ke "Rencana Pembelian".');
                $response = [
                    'status'    => 'rencana pembelian',
                    'content'   => null
                ];
                return json_encode($response);
            }else{
                return redirect()->back()->with('flash_message_error','Status order barang gagal diubah!!');
            }
        }

    }

    

    public function dtSemua(){
        $list  = DB::table('d_purchase_req')
        ->select('d_purchase_req.pr_id','m_company.c_name','d_mem.m_name','d_item.i_nama','d_purchase_req.pr_qtyReq','d_purchase_req.pr_stsReq')
        ->join('d_item','d_purchase_req.pr_itemReq','=','d_item.i_id')
        ->join('d_mem','d_purchase_req.pr_compReq','=','d_mem.m_id')
        ->join('m_company','d_mem.m_comp','=','m_company.c_id')
        ->where('d_purchase_req.pr_stsReq','WAITING')
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
                }
                else if ($hasil->pr_stsReq == 'PROSES') {
                    $row[] = "<span class='label label-warning'>SEDANG DI PROSES.</span>";
                }

                if (Plasma::checkAkses(47, 'update') == true) {
                    $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$hasil->pr_id. '\')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
                    // $row[] = "<span class='label label-warning'>SEDANG DI PROSES.</span>";
                } else {
                    // $row[] =  "<span class='label label-warning'>SEDANG DI PROSES.</span>";
                    $row[] = '<div class="text-center"><button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' .$hasil->pr_id. '\')"><i class="glyphicon glyphicon-list-alt"></i></button>&nbsp;<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . $hasil->pr_id . '\')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Non Aktifkan" onclick="statusnonactive(\'' .$hasil->pr_id. '\', \'' .$hasil->pr_id. '\')"><i class="glyphicon glyphicon-remove"></i></button></div>';
                }

               $data[] = $row;
           }
            echo json_encode(array("data"=>$data));
    }

    public function addRencana()
    {
        return view('pembelian/rencana_pembelian/add');
    }

    public function getItem(Request $request)
    {
        $key = $request->term;
        $nama = DB::table('d_item')
            ->select('i_id', 'i_nama')
            ->where(function ($q) use ($key){
                $q->orWhere('i_nama', 'like', '%'.$key.'%');
                $q->orWhere('i_code', 'like', '%'.$key.'%');
                $q->orWhere('i_kelompok', 'like', '%'.$key.'%');
                $q->orWhere('i_group', 'like', '%'.$key.'%');
                $q->orWhere('i_sub_group', 'like', '%'.$key.'%');
                $q->orWhere('i_merk', 'like', '%'.$key.'%');
            })
            ->groupBy('i_id')
            ->get();

        if ($nama == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->i_id, 'label' => $query->i_nama ];
            }
        }
        return Response::json($results);
    }

    public function multiple_edit_rencana_pembelian(Request $request)
    {
        // print_r($request->all()); die;
        $data = DB::table('d_request_order_dt')
                ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->whereIn('d_request_order_dt.rdt_no', $request->data_check)->get();
        $data_supplier = DB::table('d_supplier')->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('pembelian.rencana_pembelian.edit_rencana_pembelian', compact('data','data_supplier'));
    }

    public function rencana_pembelian_edit(Request $request)
    {
        $data = DB::table('d_request_order_dt')
                ->select('d_request_order.*', 'd_request_order_dt.*', 'd_cabang.*')
                ->join('d_request_order', 'd_request_order_dt.rdt_request', '=', 'd_request_order.ro_no')
                ->join('d_cabang', 'd_request_order.ro_cabang', '=', 'd_cabang.c_id')
                ->where('d_request_order_dt.rdt_no', $request->id)->get();
        $data_supplier = DB::table('d_supplier')->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('pembelian.rencana_pembelian.edit_rencana_pembelian', compact('data','data_supplier'));
    }

    public function update_rencana_pembelian(Request $request)
    {
        // return json_encode($request->all());
        // print_r($request->all()); die;

        $data = DB::table('d_request_order_dt')->where('rdt_no', $request->rdt_request_no);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'rdt_kuantitas_approv'     => $request->kuantitas_approv,
                'rdt_supplier' => $request->supplier
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function coba_print()
    {
        $pdf = PDF::loadView('pembelian.coba_cetak');
        return $pdf->stream();
        // return $pdf->download('footballerdetail.pdf');
    }

    public function new_print()
    {
        return view('pembelian.konfirmasi_pembelian.newprint');
    }
    
}
