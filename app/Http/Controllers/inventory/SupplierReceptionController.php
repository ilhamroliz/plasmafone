<?php

namespace App\Http\Controllers\inventory;

use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Http\Controllers\PlasmafoneController as Plasma;
use App\Http\Controllers\PlasmafoneController as Access;
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
}
