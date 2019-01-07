<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\CodeGenerator as GenerateCode;
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

        $results = [];
        if (count($data) < 1) {
            $results[] = ['message' => 'Tidak ditemukan'];
        } else {
            // $results[] = $data;
            // foreach ($data as $query) {
            //     $results[] = ['message' => 'Ditemukan', 'data' => $query];
            // }
            $results = ['message' => 'Ditemukan', 'data' => $data];
        }
        return json_encode($results);
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
                $results[] = ['id' => $query->s_id, 'label' => $query->i_code. ' - ' . $query->i_nama . $query->sd_specificcode, 'data' => $query];
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

        $arr_hpp = [];

        $outlet_user = Auth::user()->m_comp;
        $member = Auth::user()->m_id;

        // POS-REG/001/14/12/2018
        $nota = GenerateCode::codePos('d_sales', 's_id', 3, 'POS-REG');
        
        $Htotal_disc_persen = 0;
        $Htotal_disc_value = 0;

        for ($i=0; $i < count($data['idStock']); $i++) { 

            $count_smiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->where('sm_detail', 'PENAMBAHAN');

            $get_smiddetail = $count_smiddetail->get();

            

            $discPercent = implode("", explode("%", $data['discp'][$i]));
            $discValue = implode("", explode(".", $data['discv'][$i]));

            if ($data['kode'][$i] != null) {
                $specificcode = $data['kode'][$i];
                try{
                    DB::table('d_stock_dt')->where(['sd_stock' => $data['idStock'][$i], 'sd_specificcode' => $specificcode])->delete();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return "false";
                }
                
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
                    
                    try{

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

                        // update in table d_stock
                        DB::table('d_stock')->where(['s_comp' => $outlet_user, 's_position' => $outlet_user, 's_item' => $data['idItem'][$i]])->update(['s_qty' => $sm_sisa]);

                        DB::commit();

                    } catch (\Exception $e) {
                        DB::rollback();
                        return "false => ".$e;
                    }

                }

            }
        }

        // Insert to d_sales
        $idsales = DB::table('d_sales')->insertGetId([
            's_comp'                => $outlet_user,
            's_member'              => $data['idMember'],
            's_date'                => date('Y-m-d H:m:s'),
            's_jenis'               => "C",
            's_nota'                => $nota,
            's_total_gross'         => $data['totalHarga'],
            's_total_disc_value'    => 0,
            's_total_disc_persen'   => 0,
            's_total_net'           => $data['totalHarga'],
            's_salesman'            => $member
        ]);

        for ($i=0; $i < count($data['idStock']); $i++) {

            $salesdetailid = DB::table('d_sales_dt')->where('sd_sales', $idsales)->count()+1;

            $discPercent = implode("", explode("%", $data['discp'][$i]));
            $discValue = implode("", explode(".", $data['discv'][$i]));

            $Dtotal_disc_persen = ($data['grossItem'][$i] / $data['totalGross']) * ($discPercent/100);
            $Dtotal_disc_value = ($data['grossItem'][$i] / $data['totalGross']) * $discValue;

            try {
                
                // Insert to table d_sales_dt
                DB::table('d_sales_dt')->insert([
                    'sd_sales'          => $idsales,
                    'sd_detailid'       => $salesdetailid,
                    'sd_comp'           => $outlet_user,
                    'sd_item'           => $data['idItem'][$i],
                    'sd_qty'            => $data['qtyTable'][$i],
                    'sd_value'          => $data['harga'][$i],
                    'sd_hpp'            => $arr_hpp[$i],
                    'sd_total_gross'    => $data['totalItem'][$i],
                    'sd_disc_persen'    => 0,
                    'sd_disc_value'     => 0,
                    'sd_total_net'      => $data['totalItem'][$i]
                ]);

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                return "false => ".$e;
            }

        }

        return "true";

    }

    public function savePenjualanTempo(Request $request)
    {
        $data = $request->all();

        $outlet_user = Auth::user()->m_comp;
        $member = Auth::user()->m_id;

        // POS-REG/001/14/12/2018
        $nota = GenerateCode::codePos('d_sales', 's_id', 3, 'POS-REG');
        
        $Htotal_disc_persen = 0;
        $Htotal_disc_value = 0;

        for ($i=0; $i < count($data['idStock']); $i++) { 

            $count_smiddetail = DB::table('d_stock_mutation')->where('sm_stock', $data['idStock'][$i])->where('sm_detail', 'PENAMBAHAN');

            $get_smiddetail = $count_smiddetail->get();

            $get_countiddetail = $count_smiddetail->count()+1;

            $discPercent = implode("", explode("%", $data['discp'][$i]));
            $discValue = implode("", explode(".", $data['discv'][$i]));

            if ($data['kode'][$i] != null) {
                $specificcode = $data['kode'][$i];
                try{
                    DB::table('d_stock_dt')->where(['sd_stock' => $data['idStock'][$i], 'sd_specificcode' => $specificcode])->delete();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return false;
                }
                
            } else {
                $specificcode = null;
            }

            foreach ($get_smiddetail as $key => $value) {
                
                if ($get_smiddetail[$key]->sm_sisa != 0) {

                    // if ($discPercent == 0 && $discValue == 0) {
                    //     $sm_hpp = 1 * $data['harga'][$i];
                    // } else if ($discPercent != 0) {
                    //     $sm_hpp = ((100 - $discPercent)/100) * ($data['harga'][$i] * 1);
                    // } else if ($discValue != 0) {
                    //     $sm_hpp = 1 * $data['harga'][$i] - $discValue;
                    // }

                    $sm_hpp = $get_smiddetail[$key]->sm_hpp;

                    $sm_sisa = $get_smiddetail[$key]->sm_qty - $data['qtyTable'][$i];

                    // $Htotal_disc_persen += ($data['grossItem'][$i] / $data['totalGross']) * ($discPercent/100);
                    // $Htotal_disc_value += ($data['grossItem'][$i] / $data['totalGross']) * $discValue;
                    
                    try{

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
                            'sm_reff'           => $nota,
                            'sm_mem'            => $member
                        ]);

                        // Update in table d_stock_mutation
                        DB::table('d_stock_mutation')->where(['sm_stock' => $get_smiddetail[$key]->sm_stock, 'sm_detailid' =>  $get_smiddetail[$key]->sm_detailid])->update([
                            'sm_use' => $data['qtyTable'][$i],
                            'sm_sisa' => $sm_sisa
                        ]);

                        // update in table d_stock
                        DB::table('d_stock')->where(['s_comp' => $outlet_user, 's_position' => $outlet_user, 's_item' => $data['idItem'][$i]])->update(['s_qty' => $sm_sisa]);

                        DB::commit();

                    } catch (\Exception $e) {
                        DB::rollback();
                        return false;
                    }

                }

            }
        }

        // Insert to d_sales
        $idsales = DB::table('d_sales')->insertGetId([
            's_comp'                => $outlet_user,
            's_member'              => $data['idMember'],
            's_date'                => date('Y-m-d H:m:s'),
            's_jenis'               => "T",
            's_nota'                => $nota,
            // 's_total_gross'         => $data['totalGross'],
            's_total_gross'         => $data['totalHarga'],
            // 's_total_disc_value'    => $Htotal_disc_value,
            's_total_disc_value'    => 0,
            // 's_total_disc_persen'   => $Htotal_disc_persen,
            's_total_disc_persen'   => 0,
            's_total_net'           => $data['totalHarga'],
            's_salesman'            => $data['idMember']
        ]);

        for ($i=0; $i < count($data['idStock']); $i++) {

            $salesdetailid = DB::table('d_sales_dt')->where('sd_sales', $idsales)->count()+1;

            $discPercent = implode("", explode("%", $data['discp'][$i]));
            $discValue = implode("", explode(".", $data['discv'][$i]));

            $Dtotal_disc_persen = ($data['grossItem'][$i] / $data['totalGross']) * ($discPercent/100);
            $Dtotal_disc_value = ($data['grossItem'][$i] / $data['totalGross']) * $discValue;

            try {
                
                // Insert to table d_sales_dt
                DB::table('d_sales_dt')->insert([
                    'sd_sales'          => $idsales,
                    'sd_detailid'       => $salesdetailid,
                    'sd_comp'           => $outlet_user,
                    'sd_item'           => $data['idItem'][$i],
                    'sd_qty'            => $data['qtyTable'][$i],
                    'sd_value'          => $data['harga'][$i],
                    'sd_hpp'            => $data['totalItem'][$i],
                    // 'sd_total_gross'    => $data['grossItem'][$i],
                    'sd_total_gross'    => $data['totalItem'][$i],
                    'sd_disc_persen'    => 0,
                    'sd_disc_value'     => 0,
                    'sd_total_net'      => $data['totalItem'][$i]
                ]);

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                return false;
            }

        }

        return true;

    }
}
