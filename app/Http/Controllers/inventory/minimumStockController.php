<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PlasmafoneController;

class minimumStockController extends Controller
{
    public function index()
    {
        if (PlasmafoneController::checkAkses(13, 'read') == false) {
            return view('errors.407');
        } else {
            return view('inventory.minimum_stock.index');
        }
    }

    public function tambah(Request $request)
    {

    }

    public function edit(Request $request)
    {

    }
}
