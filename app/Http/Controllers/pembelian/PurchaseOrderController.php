<?php

namespace App\Http\Controllers\pembelian;

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

class PurchaseOrderController extends Controller
{
    public function index(){
        if(Plasma::checkAkses(4, 'read') == false){
            return view('errors.407');
        }else{
            return view('pembelian.purchase_order.index');
        }
    }

    public function view_tambah(){
        if(Plasma::checkAkses(4, 'insert') == false){
            return view('errors.407');
        }else{
            return view('pembelian.purchase_order.add_po');
        }
    }

    public function simpan_tambah(){

    }

    

}
