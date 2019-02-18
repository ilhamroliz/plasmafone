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
            return view('pembelian.return_barang.index');
        }
    }

    public function tambah(Request $request){
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

            return view('pembelian.return_barang.tambah');

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
