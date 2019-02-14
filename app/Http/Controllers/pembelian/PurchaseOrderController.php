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
use Crypt;

class PurchaseOrderController extends Controller
{
    public function index(){
        if(Plasma::checkAkses(4, 'read') == false){
            return view('errors.407');
        }else{
            return view('pembelian.purchase_order.view_purchase_order');
        }
    }

    public function get_proses(){

        $getData = DB::table('d_purchase')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->having(DB::raw('SUM(pd_qtyreceived)'), '<', DB::raw('SUM(pd_qty)'))
            ->select('p_id', 'p_nota', 's_company', DB::raw('SUM(pd_qtyreceived) as qtyR'))
            ->groupBy('p_id')->get();

        // dd($getData);
        return DataTables::of($getData)
            ->addIndexColumn()
            ->addColumn('aksi', function($getData){
                $detil = '<button class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="detail(\'' . Crypt::encrypt($getData->p_id) . '\')"><i class="glyphicon glyphicon-list-alt"></i></button>';
                $edit = '<button class="btn btn-xs btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit(\'' .  Crypt::encrypt($getData->p_id) . '\')"><i class="glyphicon glyphicon-edit"></i></button>';
                $hapus = '<button class="btn btn-xs btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="hapus(\'' .  Crypt::encrypt($getData->p_id) . '\')"><i class="glyphicon glyphicon-trash"></i></button>';
                if($getData->qtyR != "0"){
                    $hapus = '';
                }

                if (Plasma::checkAkses(4, 'update') == false && Plasma::checkAkses(4, 'delete') == false) {
                    return '<div class="text-center">'.$detil.'</div>';
                } else if(Plasma::checkAkses(4, 'update') == true && Plasma::checkAkses(4, 'delete') == false){
                    return '<div class="text-center">'.$detil.'&nbsp;'.$edit.'</div>';
                }else if(Plasma::checkAkses(4, 'update') == false && Plasma::checkAkses(4, 'delete') == true){
                    return '<div class="text-center">'.$detil.'&nbsp;'.$hapus.'</div>';
                }else{
                    return '<div class="text-center">'.$detil.'&nbsp;'.$edit.'&nbsp;'.$hapus.'</div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
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
                    $subT = $request->subTotal;

                    $pecah1 = explode(' ', $request->htgDiskP);
                    $htgDiskP = $pecah1[0];
                    $pecah2 = explode(' ', $request->htgPajak);
                    $htgPajak = $pecah2[0];

                    if(strpos($request->htgDiskV, '.') == true){
                        $htgDiskV = implode(explode('.', $request->htgDiskV));
                    }else{
                        $htgDiskV = $request->htgDiskV;
                        if($htgDiskV == ''){
                            $htgDiskV = 0;
                        }
                    }

                    /// UPDATE ke D_PURCHASE_CONFIRM
                    for($i = 0; $i < count($idNota); $i++){
                        DB::table('d_purchase_confirm')->where('pc_id', $idNota[$i])->update([ 'pc_status' => 'Y' ]);
                    }

                    /// GET Id for PURCHASE ID
                    $getMax = DB::table('d_purchase')->max('p_id');
                    if($getMax == null){
                        $idPO = 1;
                    }else{
                        $idPO = $getMax + 1;
                    }

                    $now = Carbon::now('Asia/Jakarta')->format('d/m/Y');
                    $nowInsert = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

                    $dateT = null;
                    if($request->tempo != ''){
                        $pecah = explode('/', $request->tempo);
                        $dateT = $pecah[2].'-'.$pecah[1].'-'.$pecah[0];
                    }

                    $subTotal = implode(explode('.', $request->htgTotal));

                    $totalDT = 0;
                    for($i = 0; $i < count($subT); $i++){
                        $totalDT += implode(explode('.', $subT[$i]));
                    }

                    $notaPO = $this->getDataId($now);
                    DB::table('d_purchase')->insert([
                        'p_id' => $idPO,
                        'p_nota' => $notaPO,
                        'p_date' => $nowInsert,
                        'p_supplier' => $idSupp,
                        'p_total_gross' => $totalDT,
                        'p_disc_value' => $htgDiskV,
                        'p_disc_persen' => $htgDiskP,
                        'p_pajak' => $htgPajak,
                        'p_total_net' => $subTotal,
                        'p_type' => $request->tipe,
                        'p_due_date' => $dateT,
                        'p_payment' => null
                    ]);

                    $countDTPO = 0;
                    for($i = 0; $i < count($qty); $i++){

                        $harga = 0;
                        if($price[$i] != null){
                            $harga = implode(explode('.', $price[$i]));
                        }

                        $unit = 0;
                        if($qty[$i] != null){
                            $unit = implode(explode('.', $qty[$i]));
                        }

                        $divDiskV = 0;
                        if($diskV[$i] != null){
                            $valDisk = implode(explode('.', $diskV[$i]));
                            $divDiskV = $valDisk / $unit;
                        }


                        if(strpos($diskP[$i], ' ') == true){
                            $pecah4 = explode(' ', $diskP[$i]);
                            $persenDisk = $pecah4[0];
                        }else{
                            $persenDisk = 0;
                        }

                        $subTot = implode(explode('.', $subT[$i]));
                        $divSubT = $subTot / $unit;

                        $cekSC = DB::table('d_item')->where('i_id', $idItem[$i])->select('i_specificcode')->first();
                        if($cekSC->i_specificcode == 'Y'){
                            $arayPODT = array();
                            for($j = 0; $j < $qty[$i]; $j++){
                                $aray = ([
                                    'pd_purchase' => $idPO,
                                    'pd_detailid' => $countDTPO + 1,
                                    'pd_item' => $idItem[$i],
                                    'pd_qty' => 1,
                                    'pd_value' => $harga,
                                    'pd_disc_value' => $divDiskV,
                                    'pd_disc_persen' => $persenDisk,
                                    'pd_total_net' => $divSubT,
                                    'pd_qtyreceived' => 0
                                ]);
                                array_push($arayPODT, $aray);
                                $countDTPO += 1;
                            }
                            DB::table('d_purchase_dt')->insert($arayPODT);
                        }else{
                            // dd($harga);

                            DB::table('d_purchase_dt')->insert([
                                'pd_purchase' => $idPO,
                                'pd_detailid' => $countDTPO + 1,
                                'pd_item' => $idItem[$i],
                                'pd_qty' => $qty[$i],
                                'pd_value' => $harga,
                                'pd_disc_value' => $divDiskV,
                                'pd_disc_persen' => $persenDisk,
                                'pd_total_net' => $divSubT,
                                'pd_qtyreceived' => 0
                            ]);

                            $countDTPO += 1;
                        }
                    }

                    DB::commit();
                    return json_encode([
                        'status' => 'tpoSukses',
                        'id' => Crypt::encrypt($idPO)
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
                    ->select('s_id', 's_company', 's_phone', 's_fax', 's_address', 's_jatuh_tempo', 's_limit')->get();

                $arayDT = array();
                for($i = 0; $i < count($check); $i++){
                    array_push($arayDT, $check[$i]);
                }

                $getDataDT = DB::table('d_purchase_confirm')
                    ->join('d_purchase_confirmdt', 'pcd_purchaseconfirm', '=', 'pc_id')
                    ->join('d_item', 'i_id', '=', 'pcd_item')
                    ->whereIn('pc_id', $arayDT)
                    ->select('pcd_item', 'pcd_purchaseconfirm', 'i_nama', DB::raw('SUM(pcd_qty) as pcd_qty'))
                    ->groupBy('pcd_item')->get();
                $add = '+'.$getDataSupp[0]->s_jatuh_tempo.' days';
                $getTempo = new Carbon($add);
                $getTempo = $getTempo->format('d/m/Y');

                return view('pembelian.purchase_order.addinput')->with(compact('getDataSupp','getDataDT','getTempo','check'));

            }else{
                $getDataSupp = DB::table('d_purchase_confirm')
                    ->join('d_supplier', 's_id', '=', 'pc_supplier')
                    ->select('pc_supplier', 's_company')
                    ->where('pc_status', 'P')
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
            ->where('pc_status', 'P')
            ->select('pc_id', 'pc_nota')
            ->groupBy('pc_nota')->get();

        return json_encode([
            'dataSupp' => $getDataSupp,
            'dataDT' => $getDataDT
        ]);
    }

    public function detail(Request $request){

        $id = $request->id;
        $getData = DB::table('d_purchase_confirm')
            ->join('d_supplier', 's_id', '=', 'pc_supplier')
            ->where('pc_id', $id)
            ->select('pc_nota', 's_company', 's_phone', 's_fax', 's_address')->first();
        $getDataDT = DB::table('d_purchase_confirmdt')
            ->join('d_item', 'i_id', '=', 'pcd_item')
            ->where('pcd_purchaseconfirm', $id)
            ->select('i_nama', 'pcd_qty')->get();

        return json_encode([
            'data' => $getData,
            'dataDT' => $getDataDT
        ]);

    }

    public function print($id){

        $id = Crypt::decrypt($id);
        $datas = DB::table('d_purchase')
            ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->join('d_item', 'i_id', '=', 'pd_item')
            ->where('p_id', $id)
            ->select('p_id', 'p_nota', 's_company', 's_phone', 'p_date', 'p_total_gross', 'p_total_net', DB::raw('IFNULL(p_pajak, 0) as pajak'),
                    'p_disc_persen', 'p_disc_value', 'p_type', 'p_due_date', 'i_nama',
                    DB::raw('SUM(pd_qty) as qty'), 'pd_value', 'pd_disc_persen',
                    DB::raw('ROUND(SUM(pd_disc_value)) as disc_value'),
                    DB::raw('(pd_value * SUM(pd_qty)) * ((100 - IFNULL(pd_disc_persen, 0)) / 100) - IFNULL(SUM(pd_disc_value), 0) as subTotal'))
            ->groupBy('pd_item')->get();

        return view('pembelian.purchase_order.print_purchase')->with(compact('datas'));

    }

    public function get_history(Request $request)
    {
        // dd($request);
        $history = '';

        $tglAw = $request->tglAwal;
        $tglAkh = $request->tglAkhir;
        $nota = $request->nota;
        $idSupp = $request->idSupp;

        if($tglAw != null && $tglAkh != null){
            $taw = explode('/', $tglAw);
            $tglAwal = $taw[2].'-'.$taw[1].'-'.$taw[0];
            $tak = explode('/', $tglAkh);
            $tglAkhir = $tak[2].'-'.$tak[1].'-'.$tak[0];

            if($nota != null && $idSupp == null){
                $history = DB::table('d_purchase')
                    ->join('d_supplier', 's_id', '=', 'p_supplier')
                    ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')

                    ->having(DB::raw('DATE(p_date)'), '<=', $tglAkhir)
                    ->having(DB::raw('DATE(p_date)'), '>=', $tglAwal)
                    ->where('p_nota', $nota)

                    ->select(DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyR'), 'p_id', 'p_nota', 's_company')
                    ->groupBy('p_id')->get();
            }else if($nota == null && $idSupp != null){
                $history = DB::table('d_purchase')
                    ->join('d_supplier', 's_id', '=', 'p_supplier')
                    ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')

                    ->having(DB::raw('DATE(p_date)'), '<=', $tglAkhir)
                    ->having(DB::raw('DATE(p_date)'), '>=', $tglAwal)
                    ->where('p_supplier', $idSupp)

                    ->select(DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyR'), 'p_id', 'p_nota', 's_company')
                    ->groupBy('p_id')->get();
            }else if($nota != null && $idSupp != null){
                $history = DB::table('d_purchase')
                    ->join('d_supplier', 's_id', '=', 'p_supplier')
                    ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')

                    ->having(DB::raw('DATE(p_date)'), '<=', $tglAkhir)
                    ->having(DB::raw('DATE(p_date)'), '>=', $tglAwal)
                    ->where('p_supplier', $idSupp)
                    ->where('p_nota', $nota)

                    ->select(DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyR'), 'p_id', 'p_nota', 's_company')
                    ->groupBy('p_id')->get();
            }else{
                $history = DB::table('d_purchase')
                    ->join('d_supplier', 's_id', '=', 'p_supplier')
                    ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')

                    ->having(DB::raw('DATE(p_date)'), '<=', $tglAkhir)
                    ->having(DB::raw('DATE(p_date)'), '>=', $tglAwal)

                    ->select(DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyR'), 'p_id', 'p_nota', 's_company')
                    ->groupBy('p_id')->get();
            }
        }else{

            if($nota != null && $idSupp == null){
                $history = DB::table('d_purchase')
                    ->join('d_supplier', 's_id', '=', 'p_supplier')
                    ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')

                    ->where('p_nota', $nota)

                    ->select(DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyR'), 'p_id', 'p_nota', 's_company')
                    ->groupBy('p_id')->get();
            }else if($nota == null && $idSupp != null){
                $history = DB::table('d_purchase')
                    ->join('d_supplier', 's_id', '=', 'p_supplier')
                    ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')

                    ->where('p_supplier', $idSupp)

                    ->select(DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyR'), 'p_id', 'p_nota', 's_company')
                    ->groupBy('p_id')->get();
            }else if($nota != null && $idSupp != null){
                $history = DB::table('d_purchase')
                    ->join('d_supplier', 's_id', '=', 'p_supplier')
                    ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')

                    ->where('p_supplier', $idSupp)
                    ->where('p_nota', $nota)

                    ->select(DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyR'), 'p_id', 'p_nota', 's_company')
                    ->groupBy('p_id')->get();
            }else{
                $history = DB::table('d_purchase')
                    ->join('d_supplier', 's_id', '=', 'p_supplier')
                    ->join('d_purchase_dt', 'pd_purchase', '=', 'p_id')

                    ->select(DB::raw('SUM(pd_qty) as qty'), DB::raw('SUM(pd_qtyreceived) as qtyR'), 'p_id', 'p_nota', 's_company')
                    ->groupBy('p_id')->get();
            }

        }

        return json_encode([
            'data' => $history
        ]);
    }

    public function edit(Request $request){

        if(Plasma::checkAkses(4, 'update') == false){
            return view('errors.407');
        }else{

            $id = Crypt::decrypt($request->id);
            $qty = $request->qty;
            $price = $request->price;
            $idItem = $request->idItem;
            $diskP = $request->diskP;
            $diskV = $request->diskV;
            $subTotal = $request->subTotal;

            if($request->isMethod('post')){

                // dd($request);
                DB::beginTransaction();
                try {

                    $totalGross = 0;
                    for($i = 0; $i < count($subTotal); $i++){
                        $totalGross += implode(explode('.', $subTotal[$i]));
                    }

                    $pisah = explode('/', $request->tempo);
                    $tgl = $pisah[2].'-'.$pisah[1].'-'.$pisah[0];
                    DB::table('d_purchase')->where('p_id', $id)->update([
                        'p_type' => $request->tipe,
                        'p_due_date' => $tgl,
                        'p_total_gross' => $totalGross,
                        'p_disc_persen' => str_replace(' %', '', $request->htgDiskP),
                        'p_disc_value' => implode(explode('.', $request->htgDiskV)),
                        'p_pajak' => str_replace(' %', '', $request->htgPajak),
                        'p_total_net' => implode(explode('.', $request->htgTotal))
                    ]);

                    $counterDT = 1;
                    for($i = 0; $i < count($request->qty); $i++){

                        $cekQTYR = DB::table('d_purchase_dt')->where('pd_purchase', $id)->where('pd_item', $idItem[$i])->select(DB::raw('SUM(pd_qtyreceived) as qtyR'))->first();
                        $getNama = DB::table('d_item')->where('i_id', $idItem[$i])->select('i_nama')->first();
                        if($qty[$i] < $cekQTYR->qtyR){
                            return json_encode([
                                'status' => 'kurang',
                                'itemNama' => $getNama->i_nama
                            ]);
                        }

                        $cekSC = DB::table('d_item')->where('i_id', $idItem[$i])->select('i_specificcode')->first();
                        if($cekSC->i_specificcode == 'Y'){

                            $getDTPrev = DB::table('d_purchase_dt')->where('pd_purchase', $id)->where('pd_item', $idItem[$i])->select('pd_specificcode', 'pd_qtyreceived', 'pd_receivedtime')->get();
                            DB::table('d_purchase_dt')->where('pd_purchase', $id)->where('pd_item', $idItem[$i])->delete();

                            $araySCDT = array();
                            for($j = 0; $j < $request->qty[$i]; $j++){

                                if($diskV[$i] == null){
                                    $dv = 0;
                                }else{
                                    $dv = implode(explode('.', $diskV[$i])) / $qty[$i];
                                }
                                $aray = ([
                                    'pd_purchase' => $id,
                                    'pd_detailid' => $counterDT,
                                    'pd_item' => $idItem[$i],
                                    'pd_qty' => 1,
                                    'pd_specificcode' => strtoupper($getDTPrev[$j]->pd_specificcode),
                                    'pd_value' => implode(explode('.', $price[$i])),
                                    'pd_disc_value' => $dv,
                                    'pd_disc_persen' => str_replace(' %', '', $diskP[$i]),
                                    'pd_total_net' => implode(explode('.', $subTotal[$i])) / $qty[$i],
                                    'pd_qtyreceived' => $getDTPrev[$j]->pd_qtyreceived,
                                    'pd_receivedtime' => $getDTPrev[$j]->pd_receivedtime
                                ]);

                                array_push($araySCDT, $aray);
                                $counterDT += 1;

                            }
                            DB::table('d_purchase_dt')->insert($araySCDT);

                        }else{

                            $getDTPrev = DB::table('d_purchase_dt')->where('pd_purchase', $id)->where('pd_item', $idItem[$i])->select('pd_qtyreceived', 'pd_receivedtime')->first();
                            DB::table('d_purchase_dt')->where('pd_purchase', $id)->where('pd_item', $idItem[$i])->delete();

                            DB::table('d_purchase_dt')->insert([
                                'pd_purchase' => $id,
                                'pd_detailid' => $counterDT,
                                'pd_item' => $idItem[$i],
                                'pd_qty' => $qty[$i],
                                'pd_specificcode' => null,
                                'pd_value' => implode(explode('.', $price[$i])),
                                'pd_disc_value' => implode(explode('.', $diskV[$i])),
                                'pd_disc_persen' => str_replace(' %', '', $diskP[$i]),
                                'pd_total_net' => implode(explode('.', $subTotal[$i])) / $qty[$i],
                                'pd_qtyreceived' => $getDTPrev->pd_qtyreceived,
                                'pd_receivedtime' => $getDTPrev->pd_receivedtime
                            ]);
                            $counterDT += 1;

                        }

                    }

                    DB::commit();
                    return json_encode([
                        'status' => 'sukses',
                        'id' => Crypt::encrypt($id)
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return json_encode([
                        'status' => 'gagal',
                        'msg' => $e
                    ]);
                }

            }


            $getPurchase = DB::table('d_purchase')
                ->join('d_supplier', 's_id', '=', 'p_supplier')
                ->where('p_id', $id)->get();

            $getDataDT = DB::table('d_purchase_dt')
                ->join('d_item', 'i_id', '=', 'pd_item')
                ->where('pd_purchase', $id)
                ->select('pd_item', 'i_nama',
                    DB::raw('SUM(pd_qty) as qty'), 'pd_value', 'pd_disc_persen', 'i_specificcode',
                    DB::raw('ROUND(SUM(pd_disc_value)) as disc_value'),
                    DB::raw('ROUND(SUM(pd_total_net)) as subTotal'),
                    DB::raw('ROUND(pd_total_net * pd_qty) as subTotalNonSC'))
                ->groupBy('pd_item')->get();
            // dd($getPurchaseDT);
            $getId = Crypt::encrypt($id);

            return view('pembelian.purchase_order.edit_purchase_order')->with(compact('getPurchase', 'getDataDT', 'getId'));

        }

    }

    public function hapus($id){

        if(Plasma::checkAkses(4, 'delete') == false){
            return view('errors.407');
        }else{

            DB::beginTransaction();
            try {
                $id = Crypt::decrypt($id);
                $getNota = DB::table('d_purchase')->where('p_id', $id)->select('p_nota')->first();
                $nota = $getNota->p_nota;

                DB::table('d_purchase_dt')->where('pd_purchase', $id)->delete();
                DB::table('d_purchase')->where('p_id', $id)->delete();

                $log = 'Menghapus Purchase Order dengan Nota '.$nota;
                Plasma::logActivity($log);

                DB::commit();
                return json_encode([
                    'status' => 'sukses',
                    'nota' => $nota
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
}
