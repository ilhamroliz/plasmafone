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

class ReturnPembelianController extends Controller
{
    public function index(){
        if(Plasma::checkAkses(5, 'read') == false){
            return view('errors.407');
        }else{
            $supplier = DB::table('d_supplier')->where('s_isactive', 'Y')->select('s_id', 's_name')->get();
            return view('pembelian.return_barang.index')->with(compact('supplier'));
        }
    }

    public function auto_nota(Request $request)
    {
        $cari = $request->term;
        $supp = DB::table('d_purchase')
            ->where('p_nota', 'like', '%'.$cari.'%')
            ->select('p_id', 'p_nota')->get();

        if ($supp == null) {
            $hasilsupp[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($supp as $query) {
                $hasilsupp[] = [
                    'id' => $query->p_id,
                    'label' => $query->p_nota
                ];
            }
        }

        return Response::json($hasilsupp);
    }

    public function getDataPembelian(Request $request){

        // dd($request);
        $getPurchase = DB::table('d_purchase')
            ->join('d_supplier', 's_id', '=', 'p_supplier')
            ->select(DB::raw('date_format(p_date, "%d-%m-%Y") as date'), 'p_nota', 's_company', 'p_id');

        if($request->awal != '' && $request->awal != null){
            $getPurchase->where(DB::raw('date_format(p_date, "%d/%m/%Y")'), '>=', $request->awal);
        }

        if($request->akhir != '' && $request->akhir != null){
            $getPurchase->where(DB::raw('date_format(p_date, "%d/%m/%Y")'), '<=', $request->akhir);
        }

        if($request->nota != '' && $request->nota != null){
            $getPurchase->where('p_nota', $request->nota);
        }

        if($request->supplier != '' && $request->supplier != null && $request->supplier != 'null'){
            $getPurchase->where('p_supplier', $request->supplier);
        }

        $purchase = $getPurchase->get();

        return json_encode([
            'data' => $purchase
        ]);
    }

    public function getDataId()
    {
        $cekNota = Carbon::now('Asia/Jakarta')->format('d/m/Y');

        $cek = DB::table('d_purchase_return')
            ->whereRaw('pr_nota like "%'.$cekNota.'%"')
            ->select(DB::raw('CAST(MID(pr_nota, 4, 3) AS UNSIGNED) as pr_nota'))
            ->orderBy('pr_id', 'desc')->first();

        if ($cek == null) {
            $temp = 1;
        } else {
            $temp = ($cek->pr_nota + 1);
        }
        $kode = sprintf("%03s", $temp);

        $tempKode = 'PR-' . $kode . '/' . $cekNota;
        return $tempKode;
    }

    public function tambah(Request $request){
        if(Plasma::checkAkses(5, 'insert') == false){
            return view('errors.407');
        }else{

            if($request->isMethod('post')){
                // dd($request);

                DB::beginTransaction();
                try {

                    // Insert untuk PURCHASE_RETURN
                    $hitung = DB::table('d_purchase_return')->count();
                    $idMaxPR = 1;

                    if($hitung > 0){
                        $getMax = DB::table('d_purchase_return')->max('pr_id');
                        $idMaxPR = $getMax + 1;
                    }

                    DB::table('d_purchase_return')->insert([
                        'pr_id' => $idMaxPR,
                        'pr_nota' => $this->getDataId(),
                        'pr_date' => Carbon::now('Asia/Jakarta')->format('Y-m-d'),
                        'pr_supplier' => $request->idSupp,
                        'pr_status' => 'P',
                        'pr_action' => null,
                        'pr_insert' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                        'pr_update' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
                    ]);

                    // Insert untuk PURCHASE_RETURN_DT
                    $arayPRD = array();
                    $count = 1;
                    for($i = 0; $i < count($request->kodeqty); $i++){

                        $pecahKQ = explode('==', $request->kodeqty[$i]);
                        if($pecahKQ[0] == 'Y'){
                            $qty = 1;
                            $sc = $pecahKQ[1];
                        }else{
                            $qty = $pecahKQ[1];
                            $sc = null;
                        }

                        $aray = ([
                            'prd_purchasereturn' => $idMaxPR,
                            'prd_detailid' => $count,
                            'prd_item' => $request->idItem[$i],
                            'prd_qty' => $qty,
                            'prd_specificcode' => $sc,
                            'prd_action' => $request->statusReturn[$i]
                        ]);
                        array_push($arayPRD, $aray);
                        $count +=1;
                    }
                    DB::table('d_purchase_returndt')->insert($arayPRD);
                    // dd($arayTry);

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

            if(isset($request->detail)){

                $id = $request->id;

                $getPurchase = DB::table('d_purchase')
                ->join('d_supplier', 's_id', '=', 'p_supplier')
                ->where('p_id', $id)->get();

                $getDataDT = DB::table('d_purchase_dt')
                    ->join('d_item', 'i_id', '=', 'pd_item')
                    ->where('pd_purchase', $id)
                    ->get();

                $getId = Crypt::encrypt($id);
                
                return view('pembelian.return_barang.add_pembelian_pilih')->with(compact('getPurchase', 'getDataDT', 'getId'));

            }

            if(isset($request->lanjut)){

                // dd($request);
                $arayPRList = array();
                $count = 1;
                for($i = 0; $i < count($request->qty); $i++){

                    $pecahItem = explode('==', $request->item[$i]);
                    $index = $pecahItem[0];

                    if(array_key_exists($index, $request->check)){
                        $pecahCek = explode('==', $request->check[$index]);
                        $nama = DB::table('d_item')->where('i_id', $pecahItem[1])->select('i_nama')->first();

                        $aray = ([
                            'i_specificcode' => $pecahCek[2],
                            'idItem' => $pecahItem[1],
                            'namaItem' => $nama->i_nama,
                            'qty' => $request->qty[$index],
                            'specificcode' => $request->kode[$index],
                            'detailid' => $pecahCek[1]
                        ]);
                        array_push($arayPRList, $aray);
                        $count +=1;
                    }
                }

                // dd($request->idP);
                $idP = Crypt::decrypt($request->idP);
                $id = $idP;
                $idSupp = $request->idSupp;
                $p_nota = $request->pNota;
                $s_company = $request->namaSupp;
                $s_phone = $request->telpSupp;

                return view('pembelian.return_barang.tambah_submit_pembelian')->with(compact('arayPRList', 'id', 'p_nota', 's_company', 's_phone', 'idSupp'));
            }

            $supplier = DB::table('d_supplier')->where('s_isactive', 'Y')->select('s_id', 's_name')->get();
            return view('pembelian.return_barang.add')->with(compact('supplier'));
        }
    }

    public function tambahFP(Request $request){
        if(Plasma::checkAkses(5, 'insert') == false){
            return view('errors.407');
        }else{

            if($request->isMethod('post')){

                DB::beginTransaction();
                try {

                    DB::commit();
                    return json_encode([
                        'status' => 'sukses'
                    ]);

                } catch (\Exception $e) {

                    DB::rollback();
                    return json_encode([
                        'status' => 'gagal'
                    ]);

                }

            }

            $supplier = DB::table('d_supplier')->where('s_isactive', 'Y')->select('s_id', 's_name')->get();
            return view('pembelian.return_barang.add_dari_penjualan')->with(compact('supplier'));
        }
    }

    public function edit(Request $request){
        if(Plasma::checkAkses(5, 'update') == false){
            return view('errors.407');
        }else{

            if($request->isMethod('post')){

                DB::beginTransaction();
                try {

                    DB::commit();
                    return json_encode([
                        'status' => 'sukses'
                    ]);

                } catch (\Exception $e) {

                    DB::rollback();
                    return json_encode([
                        'status' => 'gagal'
                    ]);

                }

            }

            return view('pembelian.return_barang.edit');

        }
    }

    public function hapus($id){
        if(Plasma::checkAkses(5, 'delete') == false){
            return view('errors.407');
        }else{

            DB::beginTransaction();
                try {

                    DB::commit();
                    return json_encode([
                        'status' => 'sukses'
                    ]);

                } catch (\Exception $e) {

                    DB::rollback();
                    return json_encode([
                        'status' => 'gagal'
                    ]);

                }

        }
    }
}
