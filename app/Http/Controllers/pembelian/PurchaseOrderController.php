<?php

namespace App\Http\Controllers\pembelian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\pembelian\order as order;
use App\Http\Controllers\PlasmafoneController as Plasma;

use DataTables;
use Carbon\Carbon;
use Auth;
use DB;
use Session;
use PDF;
use Response;

class PurchaseOrderController extends Controller
{
    public function index(){
        if(Plasma::checkAkses(4, 'read') == false){
            return view('errors.407');
        }else{
            return view('pembelian.purchase_order.view_purchase_order');
        }
    }

    public function getDataId($date)
    {
        $cekNota = $date;

        $cek = DB::table('d_purchase')
            ->whereRaw('p_nota like "%'.$cekNota.'%"')
            ->select(DB::raw('CAST(MID(p_nota, 4, 3) AS UNSIGNED) as p_nota'))
            ->orderBy('p_id', 'desc')->first();

        if ($cek == null) {
            $temp = 1;
        } else {
            $temp = ($cek->p_nota + 1);
        }
        $kode = sprintf("%03s", $temp);

        $tempKode = 'PO-' . $kode . '/' . $cekNota;
        return $tempKode;
    }

    public function tambah(Request $request){
        if(Plasma::checkAkses(4, 'insert') == false){
            return view('errors.407');
        }else{

            if($request->isMethod('post')){
                // dd($request);
                DB::beginTransaction();
                try {

                    $idSupp = $request->id;
                    $idItem = $request->idItem;
                    $qty = $request->qty;
                    $price = $request->price;
                    $diskP = $request->diskP;
                    $diskV = $request->diskV;
                    $idNota = $request->idNota;

                    for($i = 0; $i < count($idNota); $i++){
                        DB::table('d_purchase_confirm')->where('pc_id', $idNota[$i])->update([ 'pc_status' => 'Y' ]);
                    }

                    $getMax = DB::table('d_purchase')->max('p_id');
                    if($getMax == null){
                        $idPO = 1;
                    }else{
                        $idPO = $getMax + 1;
                    }

                    $now = Carbon::now('Asia/Jakarta')->format('d/m/Y');
                    $nowInsert = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

                    $subTotal = 0; $dv = 0;
                    for($i = 0; $i < count($qty); $i++){
                        if(strpos($price[$i], '.') == true){
                            $harga = implode(explode('.', $price[$i]));
                        }else{
                            $harga = $price[$i];
                        }

                        if(strpos($qty[$i], '.') == true){
                            $unit = implode(explode('.', $qty[$i]));
                        }else{
                            $unit = $qty[$i];
                        }

                        if(strpos($diskV[$i], '.') == true){
                            $diskVal = implode(explode('.', $diskV[$i]));
                        }else{
                            $diskVal = $diskV[$i];
                        }


                        if($diskP[$i] != null && $diskV[$i] != null){
                            $total = ($unit * $harga * ((100 - $diskP[$i]) / 100)) - $diskVal;
                        }else if($diskP[$i] != null && $diskV[$i] == null){
                            $total = $unit * $harga * ((100 - $diskP[$i]) / 100);
                        }else if($diskP[$i] == null && $diskV[$i] != null){
                            $total = ($unit * $harga) - $diskVal;
                        }else{
                            $total = $unit * $harga;
                        }

                        $subTotal += $total;
                        $dv += $diskVal;

                    }

                    $dp =0; 
                    for($i = 0; $i < count($qty); $i++){

                        if(strpos($price[$i], '.') == true){
                            $harga = implode(explode('.', $price[$i]));
                        }else{
                            $harga = $price[$i];
                        }
                        $harga = intval($harga);

                        if(strpos($qty[$i], '.') == true){
                            $unit = implode(explode('.', $qty[$i]));
                        }else{
                            $unit = $qty[$i];
                        }
                        $unit = intval($unit);

                        $diskPc = $diskP[$i] * (($unit * $harga) / $subTotal);
                        $dp += $diskPc;

                    }

                    $dateT = null;
                    if($request->tempo != ''){
                        $pecah = explode('/', $request->tempo);
                        $dateT = $pecah[2].'-'.$pecah[1].'-'.$pecah[0];
                    }

                    $notaPO = $this->getDataId($now);
                    DB::table('d_purchase')->insert([
                        'p_id' => $idPO,
                        'p_nota' => $notaPO,
                        'p_date' => $nowInsert,
                        'p_supplier' => $idSupp,
                        'p_total_gross' => $subTotal,
                        'p_disc_value' => $dv,
                        'p_disc_persen' => $dp,
                        'p_total_net' => $subTotal,
                        'p_type' => $request->tipe,
                        'p_due_date' => $dateT,
                        'p_payment' => null
                    ]);

                    for($i = 0; $i < count($qty); $i++){

                        if(strpos($price[$i], '.') == true){
                            $harga = implode(explode('.', $price[$i]));
                        }else{
                            $harga = $price[$i];
                        }

                        if(strpos($qty[$i], '.') == true){
                            $unit = implode(explode('.', $qty[$i]));
                        }else{
                            $unit = $qty[$i];
                        }
                        
                        $cekSC = DB::table('d_item')->where('i_id', $idItem[$i])->select('i_specificcode')->first();
                        if($cekSC->i_specificcode == 'Y'){
                            $arayPODT = array();
                            for($j = 0; $j < $qty[$i]; $j++){
                                $aray = ([
                                    'pd_purchase' => $idPO,
                                    'pd_detailid' => $j + 1,
                                    'pd_item' => $idItem[$i],
                                    'pd_qty' => 1,
                                    'pd_value' => $harga,
                                    'pd_disc_value' => 0,
                                    'pd_disc_persen' => 0,
                                    'pd_total_net' => $harga,
                                    'pd_qtyreceived' => 0
                                ]);
                                array_push($arayPODT, $aray);
                            }
                            // dd($arayPODT);
                            DB::table('d_purchase_dt')->insert($arayPODT);

                        }else{
                            DB::table('d_purchase_dt')->insert([
                                'pd_purchase' => $idPO,
                                'pd_detailid' => 1,
                                'pd_item' => $idItem[$i],
                                'pd_qty' => $qty[i],
                                'pd_value' => $harga,
                                'pd_disc_value' => 0,
                                'pd_disc_persen' => 0,
                                'pd_total_net' => $harga,
                                'pd_qtyreceived' => 0
                            ]);
                        }                       
                    }


                    DB::commit();
                    return json_encode([
                        'status' => 'tpoSukses'
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return json_encode([
                        'status' => 'tpoGagal',
                        'msg' => $e
                    ]);
                }                                            

            }

            if(isset($request->a)){

                $idSupp = $request->id;
                $check = $request->check;
                $getDataSupp = DB::table('d_supplier')
                    ->where('s_id', $idSupp)
                    ->select('s_id', 's_company', 's_phone', 's_fax', 's_address', 's_jatuh_tempo')->get();

                $arayDT = array();
                for($i = 0; $i < count($check); $i++){
                    array_push($arayDT, $check[$i]);
                }

                $getDataDT = DB::table('d_purchase_confirm')
                    ->join('d_purchase_confirmdt', 'pcd_purchaseconfirm', '=', 'pc_id')
                    ->join('d_item', 'i_id', '=', 'pcd_item')
                    ->whereIn('pc_id', $arayDT)
                    ->select('pcd_item', 'i_nama', DB::raw('SUM(pcd_qty) as pcd_qty'))
                    ->groupBy('pcd_item')->get();
                $add = '+'.$getDataSupp[0]->s_jatuh_tempo.' days';
                $getTempo = new Carbon($add);
                $getTempo = $getTempo->format('d/m/Y');

                return view('pembelian.purchase_order.addinput')->with(compact('getDataSupp','getDataDT','getTempo','check'));

            }else{
                $getDataSupp = DB::table('d_purchase_confirm')
                    ->join('d_supplier', 's_id', '=', 'pc_supplier')
                    ->select('pc_supplier', 's_company')
                    ->groupBy('pc_supplier')->get();

                return view('pembelian.purchase_order.add_po')->with(compact('getDataSupp'));
            }
            
        }
    }

    public function getCO(Request $request){
        $idSupp = $request->id;

        $getDataSupp = DB::table('d_supplier')
            ->where('s_id', $idSupp)
            ->select('s_phone', 's_fax', 's_address')->first();

        $getDataDT = DB::table('d_purchase_confirm')
            ->join('d_purchase_confirmdt', 'pcd_purchaseconfirm', '=', 'pc_id')
            ->where('pc_supplier', $idSupp)
            ->select('pc_id', 'pc_nota')
            ->groupBy('pc_nota')->get();

        return json_encode([
            'dataSupp' => $getDataSupp,
            'dataDT' => $getDataDT
        ]);
    }

}
