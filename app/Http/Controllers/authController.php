<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PlasmafoneController as Plasmafone;
use App\d_mem;
use Auth;
use DB;
use Session;

class authController extends Controller
{
    public function authenticate(Request $request){

		$member = d_mem::where(DB::raw('BINARY m_username'), $request->username)->first();

		// if($member && Hash::check('secret_'.$request->password, $member->m_password)){
        if($member && sha1(md5('لا إله إلاّ الله') . $request->password) == $member->m_password){
			Auth::login($member);
            DB::table('d_mem')
                ->where('m_id', '=', Auth::user()->m_id)
                ->update([
                    'm_lastlogin' => Carbon::now('Asia/Jakarta')
                ]);
            Plasmafone::logActivity('login');
			return redirect()->route('home');
		}else{
			Session::flash('gagal', 'Kombinasi Username dan Password Tidak Bisa Kami Temukan Di Dalam Database. Silahkan Coba Lagi !');
			return redirect()->route('login')->withInput();
		}
    }

    public function logout(){
        DB::table('d_mem')
            ->where('m_id', '=', Auth::user()->m_id)
            ->update([
                'm_lastlogout' => Carbon::now('Asia/Jakarta')
            ]);
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
