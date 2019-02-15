<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use DB;
use Carbon\Carbon;

class OnlineshopController extends Controller
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

    public function shoping_cart($id)
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
        $carts = DB::table('d_cart')
            ->join('d_cartdt', 'c_id', '=', 'cd_cart')
            ->join('d_item', 'cd_item', 'i_id')
            ->select('cd_item', 'cd_qty','i_nama', 'i_img','i_merk', 'i_price', 'd_cart.*')
            ->where('c_token', '=', $id)
            ->get();

        return view('onlineshop.halaman.shoping_cart', compact('menu_hp', 'menu_acces', 'carts'));

    }

    public function addToCart(Request $request)
    {
        $token = $request->input('_token');
        $i_id  = $request->input('i_id');
        $qty   = $request->input('qty');
        $date  = Carbon::now('Asia/Jakarta');


        DB::beginTransaction();
        try {

                $checkId = DB::table('d_cart')->select('d_cart.*')->get();
                if (count($checkId) == 0) {
                    $c_id = 1;
                }else {
                    $c_id  = DB::table('d_cart')->max('c_id');
                    ++$c_id;
                }

            $checkRow = DB::table('d_cart')->select('d_cart.*')
            ->where('c_token', '=', $token)->first();

            if ($checkRow != null) {
                $detail = DB::table('d_cart')->select('d_cart.*')
                    ->join('d_cartdt', 'c_id', '=', 'cd_cart')
                    ->select('d_cart.*', DB::raw('max(cd_detailid) as cd_detailid'))
                    ->where('c_token', '=', $token)->first();

                DB::table('d_cartdt')->insert([
                    'cd_cart' => $checkRow->c_id,
                    'cd_detailid' => $detail->cd_detailid + 1,
                    'cd_item' => $i_id,
                    'cd_qty' => $qty
                ]);
            } else {

                $cd_dtId = 0;
                DB::table('d_cart')->insert([
                    'c_id' => $c_id,
                    'c_date' => $date,
                    'c_token' => $token
                ]);

                DB::table('d_cartdt')->insert([
                    'cd_cart' => $c_id,
                    'cd_detailid' => $cd_dtId+1,
                    'cd_item' => $i_id,
                    'cd_qty' => $qty
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }

    }
}
