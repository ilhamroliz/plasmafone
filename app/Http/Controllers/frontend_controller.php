<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class frontend_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $i_merk = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->whereIn('i_merk', ['ACER','ASUS','APPLE','BLACKBERRY','OPPO','LENOVO','LG','XIAOMI','SAMSUNG','HUAWEI','NOKIA'])
            ->orderBy('i_merk')
            ->get();
        $products = DB::table('d_stock')
            ->select('s_id', 's_item', 'i_nama', 'i_merk', 'i_price')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            // ->whereIn('i_merk', ['ACER','ASUS','APPLE','BLACKBERRY','OPPO','LENOVO','LG','XIAOMI','SAMSUNG','HUAWEI','NOKIA'])
            ->inRandomOrder()
            ->paginate(8);
        return view('frontend', compact('i_merk', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function product_detail()
    {
        return view('frontend.halaman.detail_produk');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
