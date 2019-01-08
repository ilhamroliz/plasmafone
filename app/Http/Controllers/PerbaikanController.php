<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Access;

class PerbaikanController extends Controller
{
    public function index()
    {
        $check = PlasmafoneController::checkAkses(24, 'read');
        if (!$check){
            return view('errors.407');
        }
        return view('perbaikan.index');
    }
}
