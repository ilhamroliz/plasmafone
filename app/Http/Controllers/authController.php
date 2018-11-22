<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\m_member;

use Auth;
use DB;
use Session;

class authController extends Controller
{
    public function authenticate(Request $request){

    	$ret = [
			"status" => "gagal",
			"message" => "Kombinasi Username Dan Password Tidak Sesuai"
		];

		$member = m_member::where("m_username", $request->username)->first();
        dd($member);
		if($member && Hash::check('secret_'.$request->password, $member->m_password)){
			Auth::login($member);
			return redirect()->route('home');
		}else{
			Session::flash('gagal', 'Kombinasi Username dan Password Tidak Bisa Kami Temukan Di Dalam Database. Silahkan Coba Lagi !');
			return redirect()->route('login')->withInput();
		}
    }

    public function logout(){
    	Auth::logout();
    	return redirect()->route('login');
    }

    public function makeUser(){
    	$data = [
    		"m_username"	=> "developer",
    		"m_password"	=> Hash::make("secret_123456")
    	];

    	DB::table('d_mem')->insert($data);
    }
}
