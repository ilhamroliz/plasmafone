<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use DB;

class onlineshop_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_hp = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->orderBy('i_merk')
            ->get();

        $menu_acces = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->orderBy('i_merk')
            ->get();

        $i_merk = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->whereIn('i_merk', ['ACER','ASUS','APPLE','BLACKBERRY','OPPO','LENOVO','LG','XIAOMI','SAMSUNG','HUAWEI','NOKIA'])
            ->orderBy('i_merk')
            ->get();

        $products = DB::table('d_stock')
            ->select('s_id', 's_item','i_id', 'i_nama', 'i_merk','i_img', 'i_price')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->where('s_qty', '!=', 0)
            ->inRandomOrder()
            ->paginate(8);

        return view('onlineshop', compact('menu_hp', 'menu_acces','i_merk', 'products'));
    }

    public function product_detail($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return view('errors/404');
        }

        $menu_hp = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->orderBy('i_merk')
            ->get();

        $menu_acces = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->orderBy('i_merk')
            ->get();

        $products = DB::table('d_stock')
            ->select('s_id', 's_item', 's_qty', 'i_id', 'i_nama', 'i_merk', 'i_price', 'i_img')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->where('i_id', '=', $id)
            ->first();

        return view('onlineshop.halaman.detail_produk', compact('menu_hp', 'menu_acces', 'products'));

    }

    public function product_all()
    {
        $menu_hp = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->orderBy('i_merk')
            ->get();

        $menu_acces = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->orderBy('i_merk')
            ->get();

        $i_merk_hp = DB::table('d_stock')
            ->selectRaw('distinct i_merk')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->orderBy('i_merk')
            ->get();

        $i_merk_acces = DB::table('d_stock')
            ->selectRaw('distinct i_merk')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->orderBy('i_merk')
            ->get();

        $products = DB::table('d_stock')
            ->select('s_id', 'i_id', 's_item', 'i_nama', 'i_merk','i_img', 'i_price', 'i_kelompok')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->where('s_qty', '!=', 0)
            ->inRandomOrder()
            ->paginate(8);

        return view('onlineshop.halaman.semua_produk', compact('menu_hp', 'menu_acces', 'i_merk_hp', 'i_merk_acces', 'products'));
    }

    public function product_hp()
    {
        $menu_hp = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->orderBy('i_merk')
            ->get();

        $menu_acces = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->orderBy('i_merk')
            ->get();

        $i_merk_hp = DB::table('d_stock')
            ->selectRaw('distinct i_merk')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->orderBy('i_merk')
            ->get();

        $i_merk_acces = DB::table('d_stock')
            ->selectRaw('distinct i_merk')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->orderBy('i_merk')
            ->get();

        $products = DB::table('d_stock')
            ->select('s_id', 'i_id', 's_item', 'i_nama', 'i_merk','i_img', 'i_price', 'i_kelompok')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->inRandomOrder()
            ->paginate(8);

        return view('onlineshop.handphone.index', compact('menu_hp', 'menu_acces', 'i_merk_hp', 'i_merk_acces', 'products'));
    }

    public function product_acces()
    {
        $menu_hp = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->orderBy('i_merk')
            ->get();

        $menu_acces = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->orderBy('i_merk')
            ->get();

        $i_merk = DB::table('d_stock')
            ->selectRaw('distinct i_merk')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->orderBy('i_merk')
            ->get();

        $products = DB::table('d_stock')
            ->select('s_id', 'i_id', 's_item', 'i_nama', 'i_merk','i_img', 'i_price', 'i_kelompok')
            ->join('d_item', 'd_stock.s_item', '=', 'd_item.i_id')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->inRandomOrder()
            ->paginate(8);

        return view('onlineshop.aksesoris.index', compact('menu_hp', 'menu_acces', 'i_merk', 'products'));
    }

    public function shoping_cart()
    {

        $menu_hp = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'HANDPHONE')
            ->orderBy('i_merk')
            ->get();

        $menu_acces = DB::table('d_item')
            ->select('i_merk')
            ->distinct('i_merk')
            ->where('i_kelompok', '=', 'ACCESORIES')
            ->orderBy('i_merk')
            ->get();

        return view('onlineshop.halaman.shoping_cart', compact('menu_hp', 'menu_acces', 'products'));

    }
}
