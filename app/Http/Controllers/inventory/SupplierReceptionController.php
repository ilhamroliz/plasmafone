<?php

namespace App\Http\Controllers\inventory;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Http\Controllers\PlasmafoneController as Plasma;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Carbon\Carbon;
use Auth;
use PDF;
use Response;

class SupplierReceptionController extends Controller
{
    public function index(){
        if(Plasma::checkAkses(8, 'read') == false){
            return view('errors.407');
        }else{
            return view('inventory.penerimaan-barang.supplier.index');
        }
    }

    public function get_proses(){

        $getProses = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->select('p_id', 'p_nota', 's_company', DB::raw('DATE_FORMAT(p_date, "%d/%m/%Y") as date'))
            ->having(DB::raw('SUM(pd_qtyreceived)'),'<', DB::raw('SUM(pd_qty)'))
            ->groupBy('p_id')
            ->get();

        return DataTables::of($getProses)
            ->addColumn('aksi', function($getProses){

                $detail = '<button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($getProses->p_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                $edit = '<button class="btn btn-xs btn-warning btn-circle view" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' . Crypt::encrypt($getProses->p_id) . '\')"><i class="glyphicon glyphicon-arrow-down"></i></button>';
                if (Plasma::checkAkses(10, 'update') == false) {

                    return '<div class="text-center">'. $detail .'</div>';

                } else {

                    return '<div class="text-center">'. $detail .'&nbsp;'. $edit .'</div>';

                }

            })
            ->rawColumns(['aksi'])
            ->make('true');
    }

    public function get_item(Request $request){

        $id = Crypt::decrypt($request->id);
        $getProses = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->select('p_id','pd_item', 'i_nama', DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyr'))
            ->where('p_id', $id)
            ->groupBy('pd_item')
            ->get();

        return DataTables::of($getProses)
            ->addColumn('aksi', function($getProses){

                if($getProses->qty == $getProses->qtyr){
                    $terima = '<button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" disabled><i class="glyphicon glyphicon-check"></i>&nbsp;Diterima</button>';
                }else{
                    $terima = '<button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Terima Barang" onclick="terima(\'' . Crypt::encrypt($getProses->p_id) . '\', \'' . Crypt::encrypt($getProses->pd_item) . '\')"><i class="glyphicon glyphicon-arrow-down"></i>&nbsp;Terima</button>';
                }

                $detail = '<button class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Detail Barang Dtiterima" onclick="detail(\'' . Crypt::encrypt($getProses->p_id) . '\', \'' . Crypt::encrypt($getProses->pd_item) . '\')"><i class="glyphicon glyphicon-list"></i>&nbsp;Detail</button>';

                return '<div class="text-center">'. $terima . '&nbsp;' . $detail .'</div>';

            })
            ->rawColumns(['aksi'])
            ->make('true');
    }

    public function get_history(){

    }

    public function getMaks($id = null, $item = null){

        $id = Crypt::decrypt($id);
        $item = Crypt::decrypt($item);
        $getMaks = DB::table('d_purchase_dt')->where('pd_purchase', $id)->where('pd_item', $item)->select(DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyR'))->get();

        $getMaksHitung = $getMaks[0]->qty - $getMaks[0]->qtyR;

        return json_encode([
            'maks' => $getMaksHitung
        ]);
    }

    public function detail(Request $request){

        $id = Crypt::decrypt($request->id);
        $getData = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->where('p_id', $id)
            ->select('p_nota', 'p_date', 's_company', 's_phone', 'i_nama', 'pd_qty', 'pd_qtyreceived')->get();

        return json_encode([
            'data' => $getData,
            'status' => 'Sukses'
        ]);

    }

    public function edit(Request $request){
        if(Plasma::checkAkses(8, 'update') == false){
            return view('errors.407');
        }else{

            $id = Crypt::decrypt($request->id);
            if($request->isMethod('post')){

            }


            $getData = DB::table('d_purchase')
                ->join('d_supplier', 's_id', '=', 'p_supplier')
                ->where('p_id', $id)
                ->select('p_nota', 's_company')->get();

            $id = Crypt::encrypt($id);

            return view('inventory.penerimaan-barang.supplier.edit')->with(compact('getData', 'id'));

        }
    }

    public function itemReceive($id = null, $item = null)
    {
        if (Plasma::checkAkses(8, 'read') == false) {

            return json_encode([
                'status' => 'Access denied'
            ]);

        } else {
            $data = DB::table('d_purchase')
                    ->select(
                        'd_purchase.p_id as id', 
                        'd_purchase.p_supplier as supplier', 
                        'd_purchase_dt.pd_item as itemId', 
                        'd_purchase_dt.pd_detailid as iddetail', 
                        'd_purchase_dt.pd_qtyreceived as qtyReceived', 
                        DB::raw('sum(pd_qtyreceived) as sum_qtyReceived'),
                        DB::raw('sum(pd_qty) as sum_qty'),  
                        'd_purchase_dt.pd_qty as qty', 
                        'd_item.i_specificcode as specificcode', 
                        'd_item.i_nama as nama_item',
                        'i_specificcode', 'i_expired')

                    ->join('d_purchase_dt', function($x) use ($item){
                        $x->on('d_purchase_dt.pd_purchase', '=', 'd_purchase.p_id');
                        $x->where('d_purchase_dt.pd_item', Crypt::decrypt($item));
                    })
                    ->join('d_item', 'd_item.i_id', '=', 'd_purchase_dt.pd_item')
                    ->where('d_purchase.p_id', Crypt::decrypt($id))
                    ->groupBy('d_purchase_dt.pd_item')
                    ->first();
            // dd($data);
            return json_encode([
                'data' => $data
            ]);
        }
        
    }

    public function getItemReceived($id = null)
    {
        $data = DB::table('d_purchase_dt')
            ->select('pd_specificcode')
            ->where('pd_purchase', Crypt::decrypt($id))
            ->where('pd_specificcode', '!=', null);

        return DataTables::of($data)
            ->addColumn('status', function ($data) {
                return '<div class="text-center"><span class="label label-success">Diterima</span></div>';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function itemReceiveDT(Request $request){

        $id = Crypt::decrypt($request->id);
        $getNota = DB::table('d_purchase')->where('p_id', $id)->select('p_nota')->first();
        $nota = $getNota->p_nota;
        $item =  Crypt::decrypt($request->item);

        $getDT = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->where('p_nota', $nota)
            ->where('pd_item', $item)
            ->where('pd_qtyreceived', '!=', 0)
            ->select('pd_specificcode', 'pd_purchase', 'pd_detailid', 'pd_qty')
            ->groupBy('pd_detailid')
            ->get();

        $getReff = DB::table('d_stock_mutation')
            ->where('sm_nota', $nota)
            ->select('sm_reff', 'sm_expired')
            ->get();

        $getSCEX = DB::table('d_item')->where('i_id', $item)->select('i_specificcode', 'i_expired')->first();
        // dd($getDT);
        return json_encode([
            'item' => $getSCEX,
            'dataDT' => $getDT,
            'dataSM' => $getReff
        ]);
    }

    public function itemReceiveAdd(Request $request){

        if(Plasma::checkAkses(8, 'update') == false){
            return view('errors.407');
        }else{
            // dd($request);
            DB::beginTransaction();
            try {
                $idpo = Crypt::decrypt($request->idpo);
                $iditem = Crypt::decrypt($request->iditem);
                $getSCEXP = DB::table('d_item')->where('i_id', $iditem)->select('i_specificcode', 'i_expired')->first();
                $sc = $getSCEXP->i_specificcode;
                $exp = $getSCEXP->i_expired;

                if($sc == "Y"){
                    $kode = $request->kode;
                }

                /// Cek apakah Kode Spesifik sudah ada, jika barang memiliki kode spesifik
                // if($sc == 'Y'){
                //     $cekSCSM = DB::table('d_stock_mutation')->where('sm_specificcode', $kode)->count();
                //     if($cekSCSM > 0){
                //         return json_encode([
                //             'status' => 'ada'
                //         ]);
                //     }
                // }

                /// Memasukkan Data SPECIFICCODE ke D_PURCHASE_DT dan update PD_QTYRECEIVED
                if($sc == "Y"){
                    for($i = 0; $i < count($request->notaDO); $i++){
                        $getIdDT = DB::table('d_purchase_dt')
                        ->where('pd_purchase', $idpo)
                        ->where('pd_item', $iditem)
                        ->where('pd_qtyreceived', '!=', 1)->min('pd_detailid');

                        DB::table('d_purchase_dt')
                        ->where('pd_purchase', $idpo)
                        ->where('pd_item', $iditem)
                        ->where('pd_qtyreceived', '!=', 1)
                        ->where('pd_detailid', $getIdDT)
                        ->update([
                            'pd_specificcode' => $kode[$i],
                            'pd_qtyreceived' => 1
                        ]);
                    }
                }else{
                    DB::table('d_purchase_dt')
                    ->where('pd_purchase', $idpo)
                    ->where('pd_item', $iditem)
                    ->update([
                        'pd_qtyreceived' => $request->qty + $request->qtyR
                    ]);
                }


                /// Update QTY di D_STOCK
                $countQTY = DB::table('d_stock')->where('s_item', $iditem)->where('s_position', 'PF00000001')->count();
                if($countQTY != 0){

                    $getQTY = DB::table('d_stock')->where('s_item', $iditem)->where('s_position', 'PF00000001')
                        ->select('s_qty', 's_id')->first();
                    $idS = $getQTY->s_id;

                    if($sc == "Y"){
                        DB::table('d_stock')
                            ->where('s_id', $getQTY->s_id)
                            ->update([
                                's_qty' => $getQTY->s_qty + count($request->notaDO)
                            ]);
                    }else{
                        DB::table('d_stock')
                            ->where('s_id', $getQTY->s_id)
                            ->update([
                                's_qty' => $getQTY->s_qty + $request->qty
                            ]);
                    }

                    $getDTMax = DB::table('d_stock_dt')->where('sd_stock', $idS)->max('sd_detailid');
                    $getIdDTMax = $getDTMax + 1;
                    $getSMMax = DB::table('d_stock_mutation')->where('sm_stock', $idS)->max('sm_detailid');
                    $getIdSMMax = $getSMMax + 1;

                }else{

                    $getIdSMax = DB::table('d_stock')->max('s_id');
                    $idS = $getIdSMax + 1;
                    if($sc == "Y"){
                        DB::table('d_stock')->insert([
                            's_id' => $idS,
                            's_comp' => 'PF00000001',
                            's_position' => 'PF00000001',
                            's_item' => $iditem,
                            's_qty' => count($request->notaDO),
                            's_status' => 'On Destination',
                            's_min' => 0,
                            's_insert' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                            's_update' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
                        ]);
                    }else{

                        DB::table('d_stock')->insert([
                            's_id' => $idS,
                            's_comp' => 'PF00000001',
                            's_position' => 'PF00000001',
                            's_item' => $iditem,
                            's_qty' => $request->qty,
                            's_status' => 'On Destination',
                            's_min' => 0,
                            's_insert' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                            's_update' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
                        ]);
                    }

                    $getIdDTMax = 1;
                    $getIdSMMax = 1;
                }                
                

                /// Insert ke D_STOCK_DT
                if($sc == "Y"){
                    for($i = 0; $i < count($request->notaDO); $i++){
                        DB::table('d_stock_dt')->insert([
                            'sd_stock' => $idS,
                            'sd_detailid' => $getIdDTMax + $i,
                            'sd_specificcode' => $kode[$i]
                        ]);
                    }
                }


                /// Memasukkan Data ke D_STOCK_MUTATION untuk PENAMBAHAN
                $getHPP = DB::table('d_purchase')->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
                    ->where('p_id', $idpo)->where('pd_item', $iditem)->select(
                        'pd_total_net', 'p_total_gross', 'p_total_net', DB::raw('COUNT(pd_detailid) as banyak')
                    )->get();                
                $smhpp = ($getHPP[0]->pd_total_net / $getHPP[0]->p_total_gross ) * $getHPP[0]->p_total_net ;

                $getSell = DB::table('d_item')->where('i_id', $iditem)->select('i_price')->first();
                $smsell = $getSell->i_price;

                $getNota = DB::table('d_purchase')->where('p_id', $idpo)->select('p_nota')->first();
                $smnota = $getNota->p_nota;

                if($sc == 'Y'){

                    $araySM = array();
                    for($i = 0; $i < count($request->notaDO); $i++){

                        $expDate = $request->expDate[$i];
                        $speccode = $kode[$i];
                        $smqty = 1;

                        $aray = ([
                            'sm_stock' => $idS,
                            'sm_detailid' => $getIdSMMax + $i,
                            'sm_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                            'sm_detail' => 'PENAMBAHAN',
                            'sm_specificcode' => $speccode,
                            'sm_expired' => $expDate,
                            'sm_qty' => $smqty,
                            'sm_use' => 0,
                            'sm_sisa' => $smqty,
                            'sm_hpp' => $smhpp,
                            'sm_sell' => $smsell,
                            'sm_nota' => $smnota,
                            'sm_reff' => $request->notaDO[$i]
                        ]);
                        array_push($araySM, $aray);
                    }
                    DB::table('d_stock_mutation')->insert($araySM);

                }else{
                    $expDate = null;
                    $smqty = $request->qty;

                    DB::table('d_stock_mutation')->insert([
                        'sm_stock' => $idS,
                        'sm_detailid' => $getIdSMMax,
                        'sm_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_specificcode' => null,
                        'sm_expired' => $expDate,
                        'sm_qty' => $smqty,
                        'sm_use' => 0,
                        'sm_sisa' => $smqty,
                        'sm_hpp' => $smhpp,
                        'sm_sell' => $smsell,
                        'sm_nota' => $smnota,
                        'sm_reff' => $request->notaDO
                    ]);
                }
                


                DB::commit();
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


    public function editReceived()
    }

    public function hapus(){

    }

}
