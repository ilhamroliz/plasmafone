<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Http\Controllers\PlasmafoneController as Plasma;
use DataTables;
use Carbon\Carbon;
use Auth;
use PDF;
use Response;

class ReceptionController extends Controller
{
	// Penerimaan barang dari supplier
    public function index_supplier()
    {
    	// $data = DB::table('d_inventory')
    	// 		->select('d_inventory.*', 'd_supplier.s_company')
    	// 		->where('d_inventory.i_from', '=', 'Supplier')
    	// 		->join('d_supplier', 'd_inventory.i_id_supplier', '=', 'd_supplier.s_id')
    	// 		->get();
    	return view('inventory.receipt_goods.supplier.index');
    }

    public function view_bbm_dt()
    {
    	return view('inventory.receipt_goods.supplier.view_bbm_dt');
    }

    public function load_bbm()
    {
        // menampilkan data master penerimaan barang
        $query = DB::table('d_bbm')
                ->select('d_bbm.*','d_supplier.*','d_purchase.*',DB::raw('(sum(d_bbm_dt.bm_qty)-sum(d_bbm_dt.bm_receiveQty)) as selisih'))
                ->join('d_bbm_dt','d_bbm.bm_id','=','d_bbm_dt.bm_id')
                ->join('d_supplier','d_bbm.bm_supplier','=','d_supplier.s_id')
                ->join('d_purchase','d_bbm.bm_po','=','d_purchase.p_id')
                ->groupBy('d_bbm_dt.bm_id')
                ->get();

        $data = array();
        $i = 1;
        foreach ($query as $key) {
           $row     = array();
           $row[]   = $i++;
           $row[]   = $key->bm_no;
           $row[]   = $key->p_nota;
           $row[]   = $key->s_company;
           $row[]   = $key->selisih;
           $row[]   = '<div class="text-center"><button type="button" class="btn btn-xs btn-primary btn-circle view" data-toggle="tooltip" data-placement="top" title="Lihat Data" onclick="page('. $key->bm_id .')"><i class="glyphicon glyphicon-list-alt"></i></button></div>';
           $data[]  = $row;
        }

        echo json_encode(array("data"=>$data));
    }

    public function detailPo(Request $request)
    {
        // menampilkan table detail item purchase order
        $id = $request->input('po');
        $query = DB::table('d_purchase_dt')
                ->select('d_purchase_dt.*','d_item.*')
                ->join('d_item','d_purchase_dt.pd_item','=','d_item.i_id')
                ->where('d_purchase_dt.pd_purchase',$id)
                ->get();
        
                $data = array();
                $i = 1;
                foreach ($query as $key) {
                    $row        = array();
                    $row[]      = $i++;
                    $row[]      = $key->i_nama;
                    $row[]      = $key->pd_value;
                    $row[]      = $key->pd_qty;
                    $row[]      = '<div class="text-center edit"><input type="text" class="form-control txtedit" id="qty' . $key->pd_detailid . '"  style="text-transform: uppercase" onkeyup="updateQty(' . $key->pd_detailid . ')" /></div>';
                    $row[]      = '<input type="hidden" id="gudangHidden'.$key->pd_detailid.'" name="tpMemberId"><input type="text" class="form-control" id="gudangShow'.$key->pd_detailid.'" name="tpMemberNama" style="width: 100%" placeholder="Masukkan Nama Item" onkeyup="updateGudang(' . $key->pd_detailid . ')">';
                    $data[]     = $row;

                }

                echo json_encode(array("data"=>$data));
    }

    public function cariGudang(Request $request)
    {
        $cari = $request->term;
        $nama = DB::table('d_gudang')
            ->where(function ($q) use ($cari){
                $q->orWhere('g_id', 'like', '%'.$cari.'%');
                $q->orWhere('g_nama', 'like', '%'.$cari.'%');
            })->get();

        if ($nama == null) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
           
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->g_id, 'label' => $query->g_nama .'('.$query->g_kode.')'];
               
            }
        }
        return Response::json($results);
    }

    public function updateGudang(Request $request)
    {
        $id = $request->input('id');
        $gudang = $request->input('gudang');
        $update = DB::table('d_purchase_dt')
        ->where('pd_detailid',$id)
        ->update([
            'pd_gudangTerima' =>$gudang
        ]);
        if(!$update){
            echo "gagal";
        }else{
            echo "sukses";
        }
    }

    public function updateQty(Request $request){
        $id = $request->input('id');
        $qty = $request->input('qty');
        $update = DB::table('d_purchase_dt')
        ->where('pd_detailid',$id)
        ->update([
            'pd_qtyTerima' =>$qty
        ]);
        if(!$update){
            echo "gagal";
        }else{
            echo "sukses";
        }
    }

    public function updateTgl(Request $request){
        $id = $request->input('id');
        $tgl = $request->input('tgl');
        $update = DB::table('d_purchase_dt')
        ->where('pd_detailid',$id)
        ->update([
            'pd_tglTerima' =>$tgl
        ]);
        if(!$update){
            echo "gagal";
        }else{
            echo "sukses";
        }
    }

    public function add_bbm(Request $request)
    {
        // menambahkan data penerimaan barang
        $poNumber = '1';
        // $poNumber = $request->input('poNumber');

        $query3 = DB::table('d_purchase')
        ->select('d_purchase.*')
        ->where('d_purchase.p_id')
        ->get();

        $query2 = DB::table('d_purchase_dt')
        ->select('d_purchase_dt.*')
        ->where('d_purchase_dt.pd_purchase',$poNumber)
        ->get();

        $query = DB::table('d_bbm')
                ->select('d_bbm.*')
                ->get();
        

        $barisBbm = count($query);
        if($barisBbm==0) {
            $cif ="00001";
        }
        else
        {
            foreach ($query as $row) {
                //$a = substr($row->ID,5); 
                $counter=intval($barisBbm); //hasil yang didaptkan dirubah jadi integer. Ex: 0001 mjd 1.
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

        $m=count($query);
                if($m == ""){
                    $n = '1';
                }else{
                    $n = $m+1;
                }
        $user = Auth::user()->m_id;
        $tgl = date('d');
        $bln = date('m');
        $thn = date('Y');
        $code = "BBM-".$cif."/".$tgl."/".$bln."/".$thn;
        $faktur = Carbon::now()->timestamp;

        $list = array([
            'bm_id'             =>$n,
            'bm_faktur'         =>$faktur,
            'bm_no'             =>$code,
            'bm_po'             =>$poNumber,
            'bm_supplier'       =>$query3->p_supplier,
            'bm_mem'            =>'',
            'bm_receiveDate'    =>$query2->pd_receivedttime,
            'bm_orderDate'      =>$query2->pd_receivedttime,
            'bm_needDate'       =>$query2->pd_receivedttime,
            'bm_total'          =>$query2->pd_total_net,
            'bm_createdDate'    =>$query2->pd_receivedttime,
            'bm_createdUserID'  =>$user,
            'bm_modifiedDate'   =>'',
            'bm_modifiedUserID' =>'',
            ]);

        $insertOne = DB::table('d_bbm')->insert($list);


       

        
    }

    public function terimaBarang(Request $request)
    {
        // $id = '1';
        $id = $request->input('po');
        $due_date = $request->input('due_date');

        $purchase = DB::table('d_purchase')
        ->select('d_purchase.*')
        ->where('d_purchase.p_id',$id)
        ->get();

        foreach ($purchase as $key => $p) {
           $sup = $p->p_supplier;
        }
        

        $masterBbm = DB::table('d_bbm')
        ->select('d_bbm.*')
        ->get();

        $query3 = DB::table('d_bbm_dt')
        ->select('d_bbm_dt.*')
        ->get();
            $noD = count($query3);
            if($noD==''){
                $noDetail = '1';
            }else{
                $noDetail = $noD+1;
            }


        $total =  DB::table('d_purchase_dt')
        ->select(DB::raw('sum(d_purchase_dt.pd_qtyTerima) as Total'))
        ->where('d_purchase_dt.pd_purchase',$id)
        ->get();

        foreach ($total as $key) {
            $harga = $key->Total;
        }

            $barisPo = count($masterBbm);
                if($barisPo==0) {
                    $cif ="00001";
                }
                else
                {
                    foreach ($masterBbm as $row) {
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

                $m=count($masterBbm);
                if($m == ""){
                    $n = '1';
                }else{
                    $n = $m+1;
                }
                    
                $code = "BBM-".$cif."/".$tgl."/".$bln."/".$thn;

                $list = array([
                    'bm_id'                 =>$n,
                    'bm_faktur'             =>"",
                    'bm_no'                 =>$code,
                    'bm_po'                 =>$id,
                    'bm_supplier'           =>$sup,
                    'bm_mem'                =>"",
                    'bm_receiveDate'        =>"",
                    'bm_orderDate'          =>$date,
                    'bm_needDate'           =>$date,
                    'bm_total'              =>"",
                    'bm_note'               =>"",
                    'bm_createdDate'        =>$date,
                    'bm_createdUserID'      =>"",
                    'bm_modifiedDate'       =>$date,
                    'bm_modifiedUserID'     =>""
                    ]);

        $insertOne = DB::table('d_bbm')->insert($list);

        if(!$insertOne){
           echo "GAGAL";
        }else{

            // $statusPo = DB::table('d_purchase_dt')
            // ->select(DB::raw('sum(d_purchase_dt.pd_qtyTerima) as terima'),DB::raw('sum(d_purchase_dt.pd_qty) as order'))
            // ->where('d_purchase_dt.pd_purchase',$id)
            // ->groupBy('pd_purchase')
            // ->get();

            // if($statusPo->terima == $statusPo->order){
            //     $st = "COMPLETE";
            // }else if($statusPo->terima < $statusPo->order){
            //     $st = "QTY KURANG";
            // }else{
            //     $st = "KELEBIHAN QTY";
            // }

            
            $query = DB::table('d_purchase_dt')
            ->select('d_purchase_dt.*')
            ->where('d_purchase_dt.pd_purchase',$id)
            ->get();

                $queryx = DB::table('d_bbm_dt')
                ->select('d_bbm_dt.*')
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
                                'bm_dt' =>$nUrut1++,
                                'bm_id' =>$n,
                                'bm_item'=>$query[$i]->pd_item,
                                'bm_price'=>$query[$i]->pd_value,
                                'bm_qty'=>$query[$i]->pd_qtyTerima,
                                'bm_receiveQty' =>$query[$i]->pd_qtyTerima,
                                'bm_receiveStatus'=>"-",
                                'bm_factoryID' =>$query[$i]->pd_gudangTerima,
                                'bm_note' =>"-",
                                'bm_createdDate' =>$date,
                                'bm_createdUserID' =>$date,
                                'bm_modifiedDate' =>$date,
                                'bm_modifiedUserID' =>$date
                            ];  
                            array_push($addAkses, $temp);
                        }
                $insert = DB::table('d_bbm_dt')->insert($addAkses);

                if(!$insert){
                    echo json_encode(array("status" =>"gagal"));
                }else{
                    $def = DB::table('d_purchase')
                    ->select('p_id')
                    ->where('po_status','=','PURCHASING')
                    ->where('p_id',$id)
                    ->get();

                    foreach ($def as $key => $value) {
                        $dat['coloum'] = $value;
                    }
                       
                    $data = array();
                    foreach ($def as $key) {
                       $row = array();
                       $row[] = $key->p_id;
                       $data[] = $row;
                    }
                  
                   $update = DB::table('d_purchase')
                   ->whereIn('p_id',$data)
                   ->update([
                       'po_status'=>'ACCEPT'
                   ]);
                    // PlasmafoneController::logActivity('aksi yang dilalukan PURCHASING');
                    echo json_encode(array("status" =>"sukses"));
                }
        }

       
    }

    public function index_addSupplier()
    {
        return view('inventory.receipt_goods.supplier.add');
    }

    public function getPo()
    {
        $data = DB::table('d_purchase')
                ->select('d_purchase.*')
                ->where('d_purchase.po_status','PURCHASING')
                ->get();
        echo json_encode($data);

    }

    public function getEntitas_po(Request $request)
    {
        $po = $request->input('po');
        $query = DB::table('d_purchase')
        ->select('d_purchase.*','d_supplier.*')
        ->join('d_supplier','d_purchase.p_supplier','=','d_supplier.s_id')
        ->where('d_purchase.p_id',$po)
        ->get();


        foreach ($query as $key) {
            $nama = $key->s_company;
            $tgl = $key->p_date;
        }

        $data = array(
            "s_company"=>$nama,
            "p_date" =>$tgl
        );

        echo json_encode($data);
    }
// -------------------------------------------- other script----------------------------------------
    public function add_items_from_supplier(Request $request)
    {
    	if ($request->isMethod('post')) {
    		
    		$data = $request->all();
    		// print_r($data); die;
    		$sql = DB::table('d_inventory')->insert([
                'i_po'         => $data['purchase_order'],
                'i_kategori' 	=> $data['kategori'],
                'i_imei'		=> $data['imei'],
                'i_kode_barang'=> $data['kode_barang'],
                'i_nama_barang'=> $data['nama_barang'],
                'i_qty'		=> $data['qty'],
                'i_tgl_masuk'	=> $data['tgl_masuk'],
                'i_id_supplier'=> $data['supplier'],
                'i_from'		=> 'Supplier'
            ]);

            DB::table('d_purchase_order_dt')->where('podt_purchase', $data['purchase_order'])->update([
                'podt_status_inventory' => '1'
            ]);

            if ($sql) {
                return redirect('/inventory/penerimaan/supplier')->with('flash_message_success','Semua Data Yang Terakhir Anda Input Berhasil Tersimpan Di Database!');
            }else{
                return redirect('/inventory/penerimaan/supplier')->with('flash_message_error','Semua Data Yang Terakhir Anda Input Gagal Tersimpan Di Database!');
            }

    	}

    	$data_supplier = DB::table('d_supplier')->get();
        $purchase = DB::table('d_purchase_order_dt')
                    ->where('d_purchase_order_dt.podt_status_inventory', '=', '0')
                    ->get();
        if (count($purchase) == 0) {
            $purchase = 'null';
        }
    	return view('inventory.receipt_goods.supplier.add')->with(compact('data_supplier', 'purchase'));
    }

    public function get_current_receipt($id = null)
    {
    	$data = DB::table('d_inventory')
    			->select('d_inventory.*', 'd_supplier.s_company')
    			->where('d_inventory.i_id', '=', $id)
    			->join('d_supplier', 'd_inventory.i_id_supplier', '=', 'd_supplier.s_id')
    			->first();

        return json_encode($data);
    }

    public function multiple_edit_penerimaan_barang(Request $request)
    {
    	$data = DB::table('d_inventory')
    			->select('d_inventory.*', 'd_supplier.s_company')
    			->whereIn('d_inventory.i_id', $request->data_check)
    			->join('d_supplier', 'd_inventory.i_id_supplier', '=', 'd_supplier.s_id')
    			->get();

    	if(count($data) == 0){
            return view('errors.data_not_found');
        }

    	$data_supplier = DB::table('d_supplier')->get();
        return view('inventory.receipt_goods.supplier.edit', compact('data', 'data_supplier'));
    }

    public function edit(Request $request)
    {
        $data = DB::table('d_inventory')
    			->select('d_inventory.*', 'd_supplier.s_company')
    			->where('d_inventory.i_id', '=', $request->id)
    			->join('d_supplier', 'd_inventory.i_id_supplier', '=', 'd_supplier.s_id')
    			->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        // print_r($data); die;

        $data_supplier = DB::table('d_supplier')->get();
        return view('inventory.receipt_goods.supplier.edit', compact('data', 'data_supplier'));
    }

    public function update_penerimaan_barang(Request $request)
    {
    	$data = DB::table('d_inventory')->where('i_id', $request->i_id);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'i_kategori' 	=> $request->kategori,
                'i_imei'		=> $request->imei,
                'i_kode_barang'=> $request->kode_barang,
                'i_nama_barang'=> $request->nama_barang,
                'i_qty'		=> $request->qty,
                'i_tgl_masuk'	=> $request->tgl_masuk,
                'i_id_supplier'=> $request->supplier,
                'i_from'		=> 'Supplier'
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_delete_penerimaan(Request $request){
        // return json_encode($request->data);

        DB::table('d_inventory')->whereIn('i_id', $request->data)->delete();
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }
    // End penerimaan barang dari supplier

    // Penerimaan barang dari pusat
    public function index_pusat()
    {
    	$data = DB::table('d_inventory')
    			->where('i_from', '=', 'Pusat')
    			->get();
    	return view('inventory.receipt_goods.pusat.index')->with(compact('data'));
    }

    public function add_items_from_pusat(Request $request)
    {
    	if ($request->isMethod('post')) {
    		
    		$data = $request->all();
    		// print_r($data); die;
    		$sql = DB::table('d_inventory')->insert([
                'i_kategori' 	=> $data['kategori'],
                'i_imei'		=> $data['imei'],
                'i_kode_barang'=> $data['kode_barang'],
                'i_nama_barang'=> $data['nama_barang'],
                'i_qty'		=> $data['qty'],
                'i_tgl_masuk'	=> $data['tgl_masuk'],
                'i_id_supplier'=> '0',
                'i_from'		=> 'Pusat'
            ]);
            if ($sql) {
                return redirect('/inventory/penerimaan/pusat')->with('flash_message_success','Semua Data Yang Terakhir Anda Input Berhasil Tersimpan Di Database!');
            }else{
                return redirect('/inventory/penerimaan/pusat')->with('flash_message_error','Semua Data Yang Terakhir Anda Input Gagal Tersimpan Di Database!');
            }

    	}

    	return view('inventory.receipt_goods.pusat.add');
    }

    public function get_current_receipt_pusat($id = null)
    {
    	$data = DB::table('d_inventory')
    			->where('i_id', '=', $id)
    			->first();

        return json_encode($data);
    }

    public function multiple_edit_penerimaan_barang_pusat(Request $request)
    {
    	$data = DB::table('d_inventory')
    			->whereIn('i_id', $request->data_check)
    			->get();

    	if(count($data) == 0){
            return view('errors.data_not_found');
        }

        return view('inventory.receipt_goods.pusat.edit', compact('data'));
    }

    public function edit_barang_pusat(Request $request)
    {
        $data = DB::table('d_inventory')
    			->where('i_id', '=', $request->id)
    			->get();

        if(count($data) == 0){
            return view('errors.data_not_found');
        }

        // print_r($data); die;

        return view('inventory.receipt_goods.pusat.edit', compact('data'));
    }

    public function update_penerimaan_barang_pusat(Request $request)
    {
    	$data = DB::table('d_inventory')->where('i_id', $request->i_id);

        if(!$data->first()){
            $response = [
                'status'    => 'tidak ada',
                'content'   => 'null'
            ];

            return json_encode($response);
        }else{
            $data->update([
                'i_kategori' 	=> $request->kategori,
                'i_imei'		=> $request->imei,
                'i_kode_barang'=> $request->kode_barang,
                'i_nama_barang'=> $request->nama_barang,
                'i_qty'		=> $request->qty,
                'i_tgl_masuk'	=> $request->tgl_masuk,
                'i_from'		=> 'Pusat'
            ]);

            Session::flash('flash_message_success', 'Semua Data Yang Telah Anda Ubah Berhasil Tersimpan.');
            $response = [
                'status'    => 'berhasil',
                'content'   => null
            ];

            return json_encode($response);
        }
    }

    public function multiple_delete_penerimaan_pusat(Request $request){
        // return json_encode($request->data);

        DB::table('d_inventory')->whereIn('i_id', $request->data)->delete();
        Session::flash('flash_message_success', 'Semua Data Yang Anda Pilih Berhasil Dihapus.');

        return  json_encode([
                    'status'    => 'berhasil'
                ]);
    }
    // End penerimaan barang dari pusat

    // Distribusi barang
    // public function index_distribusi()
    // {
    //     $purchase = DB::table('d_inventory')->get();
    //     return view('inventory.distribusi.index')->with(compact('purchase'));
    // }

    // public function show_purchase($id = null)
    // {
    //     $data = DB::table('d_inventory')
    //             ->where('i_po', $id)
    //             ->get();
    //     if (count($data) == 0) {
    //         # code...
    //         $data = null;
    //     }
    //     echo json_encode($data);
    // }
    // End distribusi barang
}
