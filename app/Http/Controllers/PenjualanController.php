<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\CodeGenerator as GenerateCode;
use App\Http\Controllers\PlasmafoneController as Access;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Response;
Use Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.penjualan-regular.index');
    }

    public function tempo()
    {
        return view('penjualan.penjualan-tempo.index');
    }

    public function cariSales(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('d_mem')
            ->where(function ($q) use ($cari){
                $q->orWhere('m_id', 'like', '%'.$cari.'%');
                $q->orWhere('m_name', 'like', '%'.$cari.'%');
            })->get();

        

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->m_id, 'label' => $query->m_name];
            }
        }
        return Response::json($results);
    }

    public function cariMember(Request $request)
    {
        $cari = $request->term;
        $results = [];
        $nama = DB::table('m_member')
            ->where(function ($q) use ($cari){
                $q->orWhere('m_name', 'like', '%'.$cari.'%');
                $q->orWhere('m_telp', 'like', '%'.$cari.'%');
                $q->orWhere('m_id', 'like', '%'.$cari.'%');
            })->get();

        

        if (count($nama) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($nama as $query) {
                $results[] = ['id' => $query->m_id, 'label' => $query->m_name . ' ('.$query->m_telp.')'];
            }
        }
        return Response::json($results);
    }

    public function saveMember(Request $request)
    {
        DB::beginTransaction();
        try {
            $nama = strtoupper($request->nama);
            $nomor = $request->nomor;

            $cek = DB::table('m_member')
                ->where('m_telp', '=', $nomor)
                ->get();

            if (count($cek) > 0){
                DB::rollback();
                return response()->json([
                    'status' => 'nomor'
                ]);
            } else {
                $getId = DB::table('m_member')
                    ->max('m_id');
                DB::table('m_member')
                    ->insert([
                        'm_id' => $getId + 1,
                        'm_name' => $nama,
                        'm_telp' => $nomor
                    ]);
                DB::commit();
                return response()->json([
                    'status' => 'sukses'
                ]);
            }
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal'
            ]);
        }
    }

    public function searchStock(Request $request)
    {
        $cari = $request->term;
        $kode = [];
        if (isset($request->kode)){
            $kode = $request->kode;
            if (($key = array_search(null, $kode)) !== false) {
                unset($kode[$key]);
            }
            $temp = [];
            foreach ($kode as $code){
                array_push($temp, $code);
            }
            $kode = $temp;
        }
        if (count($kode) > 0){

            $dataN = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('sd_stock', '=', 's_id');
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'N')
                ->groupBy('sm_specificcode');

            $dataY = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                    $q->whereNotIn('sm_specificcode', $kode);
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('sd_stock', '=', 's_id');
                    $a->on('sm_specificcode', '=', 'sd_specificcode');
                    $a->whereNotIn('sd_specificcode', $kode);
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'Y')
                ->groupBy('sm_specificcode');

            $data = $dataN->union($dataY)->get();
        } else {
            $data = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                })
                ->leftJoin('d_stock_dt', function ($a) {
                    $a->on('sd_stock', '=', 's_id');
                    $a->on('sd_specificcode', '=', 'sm_specificcode');
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->groupBy('sm_specificcode')
                ->get();
        }

        /*$results = [];
        if (count($data) < 1) {
            $results[] = ['message' => 'Tidak ditemukan'];
        } else {
            // $results[] = $data;
            // foreach ($data as $query) {
            //     $results[] = ['message' => 'Ditemukan', 'data' => $query];
            // }
            $results = ['message' => 'Ditemukan', 'data' => $data];
        }
        return json_encode($results);*/
        $results = [];
        if (count($data) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($data as $query) {
                $results[] = ['id' => $query->s_id, 'label' => $query->i_code. ' - ' . $query->i_nama . $query->sd_specificcode, 'data' => $query];
            }
        }
        return Response::json($results);
    }

    public function cariStock(Request $request)
    {
        
        $cari = $request->term;
        $kode = [];
        if (isset($request->kode)){
            $kode = $request->kode;
            if (($key = array_search(null, $kode)) !== false) {
                unset($kode[$key]);
            }
            $temp = [];
            foreach ($kode as $code){
                array_push($temp, $code);
            }
            $kode = $temp;
        }
        if (count($kode) > 0){

            $dataN = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('sd_stock', '=', 's_id');
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'N')
                ->groupBy('sm_specificcode');

            $dataY = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q) use ($kode){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                    $q->whereNotIn('sm_specificcode', $kode);
                })
                ->leftJoin('d_stock_dt', function ($a) use ($kode){
                    $a->on('sd_stock', '=', 's_id');
                    $a->on('sm_specificcode', '=', 'sd_specificcode');
                    $a->whereNotIn('sd_specificcode', $kode);
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->where('i_specificcode', '=', 'Y')
                ->groupBy('sm_specificcode');

            $data = $dataN->union($dataY)->get();
        } else {
            $data = DB::table('d_stock')
                ->select('sd_detailid', 'i_id', 'sm_specificcode','i_specificcode', 'i_code', 'i_nama', 's_qty', 'gp_price', 'op_price', 'i_price', 's_id', DB::raw('coalesce(concat(" (", sd_specificcode, ")"), "") as sd_specificcode'))
                ->join('d_stock_mutation', function ($q){
                    $q->on('sm_stock', '=', 's_id');
                    $q->where('sm_detail', '=', 'PENAMBAHAN');
                    $q->where('sm_sisa', '>', '0');
                    $q->where('sm_reff', '!=', 'Rusak');
                })
                ->leftJoin('d_stock_dt', function ($a) {
                    $a->on('sd_stock', '=', 's_id');
                    $a->on('sd_specificcode', '=', 'sm_specificcode');
                })
                ->join('d_item', 'i_id', '=', 's_item')
                ->leftjoin('m_group_price', 'gp_item', '=', 's_item')
                ->leftjoin('d_outlet_price', 'op_item', '=', 's_item')
                ->where(function ($w) use ($cari){
                    $w->orWhere('i_nama', 'like', '%'.$cari.'%');
                    $w->orWhere('i_code', 'like', '%'.$cari.'%');
                    $w->orWhere('sd_specificcode', 'like', '%'.$cari.'%');
                })
                ->groupBy('sm_specificcode')
                ->get();
        }

        $results = [];
        if (count($data) < 1) {
            $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
        } else {
            foreach ($data as $query) {
                if($query->i_code == "") {
                    $results[] = ['id' => $query->s_id, 'label' => $query->i_nama . $query->sd_specificcode, 'data' => $query];
                } else {
                    $results[] = ['id' => $query->s_id, 'label' => $query->i_code. ' - ' . $query->i_nama . $query->sd_specificcode, 'data' => $query];
                }
                
            }
        }
        return Response::json($results);
    }

    public function getDetailMember($id = null)
    {
        $query = DB::table('m_member')
                    ->select('m_member.m_address', 'm_group.g_name')
                    ->join('m_group', 'm_member.m_jenis', '=', 'm_group.g_id')
                    ->where('m_member.m_id', $id)
                    ->first();

        return Response::json(['jenis' => $query->g_name, 'alamat' => $query->m_address]);
    }

    public function savePenjualan(Request $request)
    {
        $data = $request->all();

        if (!isset($data['idStock']) || $data['idMember'] == null || $data['salesman'] == null) 
        { 
            return "lengkapi data";
        } else {
            DB::beginTransaction();
            try{

                $sales = DB::table('d_mem')
                        ->select('m_id', 'm_name')
                        ->where('m_id', $data['salesman'])
                        ->first();

                $arr_hpp = [];

                $outlet_user = Auth::user()->m_comp;
                $member = Auth::user()->m_id;

                if ($data['jenis_pembayaran'] == "T") {
                    // POS-TEM/001/14/12/2018
                    $nota = GenerateCode::codePenjualan('d_sales', 's_nota', 13, 10, 3, 'POS-TEM');
                } else {
                    // POS-REG/001/14/12/2018
                    $nota = GenerateCode::codePenjualan('d_sales', 's_nota', 13, 10, 3, 'POS-REG');
                }
                
                $Htotal_disc_persen = 0;
                $Htotal_disc_value = 0;

                for ($i=0; $i < count($data['idStock']); $i++) { 

                    $count_smiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->where('sm_detail', 'PENAMBAHAN');

                    $get_smiddetail = $count_smiddetail->get();

                    $discPercent = implode("", explode("%", $data['discp'][$i]));
                    $discValue = implode("", explode(".", $data['discv'][$i]));

                    if ($data['kode'][$i] != null) {
                        $specificcode = $data['kode'][$i];
                        
                        DB::table('d_stock_dt')->where(['sd_stock' => $data['idStock'][$i], 'sd_specificcode' => $specificcode])->delete();
                        
                    } else {
                        $specificcode = null;
                    }

                    foreach ($get_smiddetail as $key => $value) {

                        $get_countiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->count()+1;
                        
                        if ($get_smiddetail[$key]->sm_sisa != 0) {

                            // if ($discPercent == 0 && $discValue == 0) {
                            //     $sm_hpp = 1 * $data['harga'][$i];
                            // } else if ($discPercent != 0) {
                            //     $sm_hpp = ((100 - $discPercent)/100) * ($data['harga'][$i] * 1);
                            // } else if ($discValue != 0) {
                            //     $sm_hpp = 1 * $data['harga'][$i] - $discValue;
                            // }

                            $sm_hpp = $get_smiddetail[$key]->sm_hpp;
                            array_push($arr_hpp, $sm_hpp);

                            $sm_reff = $get_smiddetail[$key]->sm_nota;
                            
                            if ($get_smiddetail[$key]->sm_use != 0) {
                                $sm_use = $data['qtyTable'][$i] + $get_smiddetail[$key]->sm_use;
                                $sm_sisa = $get_smiddetail[$key]->sm_qty - $get_smiddetail[$key]->sm_use - $data['qtyTable'][$i];
                            } else {
                                $sm_use = $data['qtyTable'][$i] + $get_smiddetail[$key]->sm_use;
                                $sm_sisa = $get_smiddetail[$key]->sm_qty - $data['qtyTable'][$i];
                            }
                            

                            // $Htotal_disc_persen += ($data['grossItem'][$i] / $data['totalGross']) * ($discPercent/100);
                            // $Htotal_disc_value += ($data['grossItem'][$i] / $data['totalGross']) * $discValue;
                            

                            // Insert to table d_stock_mutation
                            DB::table('d_stock_mutation')->insert([
                                'sm_stock'          => $data['idStock'][$i],
                                'sm_detailid'       => $get_countiddetail,
                                'sm_date'           => date('Y-m-d H:m:s'),
                                'sm_detail'         => 'PENGURANGAN',
                                'sm_specificcode'   => $specificcode,
                                'sm_qty'            => $data['qtyTable'][$i],
                                'sm_use'            => 0,
                                'sm_sisa'           => 0,
                                'sm_hpp'            => $sm_hpp,
                                'sm_sell'           => $data['harga'][$i],
                                'sm_nota'           => $nota,
                                'sm_reff'           => $sm_reff,
                                'sm_mem'            => $member
                            ]);

                            // Update in table d_stock_mutation
                            DB::table('d_stock_mutation')->where(['sm_stock' => $get_smiddetail[$key]->sm_stock, 'sm_detailid' =>  $get_smiddetail[$key]->sm_detailid])->update([
                                'sm_use' => $sm_use,
                                'sm_sisa' => $sm_sisa
                            ]);

                            // Update d_stock
                            DB::table('d_stock')
                            ->where('s_id', $data['idStock'][$i])
                            ->update([
                                's_qty' => $sm_sisa,
                                's_status' => 'On Going'
                            ]);

                        }

                    }
                }

                // Insert to d_sales
                $idsales = DB::table('d_sales')->insertGetId([
                    's_comp'                => $outlet_user,
                    's_member'              => $data['idMember'],
                    's_date'                => date('Y-m-d H:m:s'),
                    's_jenis'               => $data['jenis_pembayaran'],
                    's_nota'                => $nota,
                    's_total_gross'         => $data['totalHarga'],
                    's_total_disc_value'    => 0,
                    's_total_disc_persen'   => 0,
                    's_total_net'           => $data['totalHarga'],
                    's_salesman'            => $sales->m_id
                ]);

                for ($i=0; $i < count($data['idStock']); $i++) {

                    $salesdetailid = DB::table('d_sales_dt')->where('sd_sales', $idsales)->count()+1;

                    $discPercent = implode("", explode("%", $data['discp'][$i]));
                    $discValue = implode("", explode(".", $data['discv'][$i]));

                    $Dtotal_disc_persen = ($data['grossItem'][$i] / $data['totalGross']) * ($discPercent/100);
                    $Dtotal_disc_value = ($data['grossItem'][$i] / $data['totalGross']) * $discValue;

                    $idItem = DB::table('d_stock')->select('s_item')->where('s_id', $data['idStock'][$i])->first();
                    // Insert to table d_sales_dt
                    DB::table('d_sales_dt')->insert([
                        'sd_sales'          => $idsales,
                        'sd_detailid'       => $salesdetailid,
                        'sd_comp'           => $outlet_user,
                        'sd_item'           => $idItem->s_item,
                        'sd_qty'            => $data['qtyTable'][$i],
                        'sd_value'          => $data['harga'][$i],
                        'sd_hpp'            => $arr_hpp[$i],
                        'sd_total_gross'    => $data['totalItem'][$i],
                        'sd_disc_persen'    => $Dtotal_disc_persen,
                        'sd_disc_value'     => $Dtotal_disc_value,
                        'sd_total_net'      => $data['totalItem'][$i]
                    ]);

                }
                
                if ($data['jenis_pembayaran'] == "T") {
                    Access::logActivity('Membuat penjualan tempo ' . $nota);
                } else {
                    Access::logActivity('Membuat penjualan regular ' . $nota);
                }

                DB::commit();
                // $url = url('/').'/penjualan-reguler/struk/'.$sales.'/'.$idsales;
                // return $url;
                return response()->json([
                    'status' => 'sukses',
                    'bayar' => $data['bayar'],
                    'salesman' => $sales->m_name,
                    'idSales' => Crypt::encrypt($idsales),
                    'bri' => $data['bri'],
                    'bni' => $data['bni'],
                    'totPemb' => $data['total_pembayaran'],
                    'kembali' => $data['kembali']
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => 'gagal',
                    'data' => 'server gagal menyimpan',
                    'eror' => $e
                ]);
            }
        }

    }

    public function detailpembayaran($total = null)
    {
        return view('penjualan.penjualan-regular.detailPembayaran', compact('total'));
    }

    public function struck($salesman = null, $id = null, $totPemb = null, $kembali = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $datas = DB::table('d_sales')
                ->select('m_company.c_name as nama_outlet', 'm_company.c_address as alamat_outlet', 'd_sales.s_nota as nota', 'm_member.m_name as nama_member', 'm_member.m_telp as telp_member', 'd_sales.s_date as tanggal', 'd_sales_dt.sd_qty as qty', 'd_item.i_nama as nama_item', 'd_sales_dt.sd_total_net as total_item', 'd_sales.s_total_net as total')
                ->where('d_sales.s_id', $id)
                ->join('d_sales_dt', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id')
                ->join('m_company', 'm_company.c_id', '=', 'd_sales.s_comp')
                ->join('m_member', 'm_member.m_id', '=', 'd_sales.s_member')
                ->join('d_item', 'd_item.i_id', '=', 'd_sales_dt.sd_item')
                ->get();

        if ($datas == null) {
            return view('errors/404');
        }

        return view('penjualan.penjualan-regular.struk')->with(compact('datas', 'salesman', 'totPemb', 'kembali'));
    }

    public function detailpembayaranTempo($total = null)
    {
        return view('penjualan.penjualan-tempo.detailPembayaran', compact('total'));
    }

    public function struckTempo($salesman = null, $id = null, $totPemb = null, $kembali = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $datas = DB::table('d_sales')
                ->select('m_company.c_name as nama_outlet', 'm_company.c_address as alamat_outlet', 'd_sales.s_nota as nota', 'm_member.m_name as nama_member', 'm_member.m_telp as telp_member', 'd_sales.s_date as tanggal', 'd_sales_dt.sd_qty as qty', 'd_item.i_nama as nama_item', 'd_sales_dt.sd_total_net as total_item', 'd_sales.s_total_net as total')
                ->where('d_sales.s_id', $id)
                ->join('d_sales_dt', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id')
                ->join('m_company', 'm_company.c_id', '=', 'd_sales.s_comp')
                ->join('m_member', 'm_member.m_id', '=', 'd_sales.s_member')
                ->join('d_item', 'd_item.i_id', '=', 'd_sales_dt.sd_item')
                ->get();

        if ($datas == null) {
            return view('errors/404');
        }

        return view('penjualan.penjualan-tempo.struk')->with(compact('datas', 'salesman', 'bayar', 'bri', 'bni', 'totPemb', 'kembali'));
    }

    
}
