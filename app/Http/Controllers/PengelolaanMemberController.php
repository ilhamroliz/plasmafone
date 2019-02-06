<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengelolaanMemberController extends Controller
{
    public function index()
    {
        return view('pengelolaan_member.index');
    }
}
