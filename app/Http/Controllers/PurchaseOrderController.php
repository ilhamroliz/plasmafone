<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
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
        if (!PlasmafoneController::checkAkses('4', 'read')){
            return redirect()->route('login');
        }
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
}
