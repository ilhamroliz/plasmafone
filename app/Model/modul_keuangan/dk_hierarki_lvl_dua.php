<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_hierarki_lvl_dua extends Model
{
    protected $table = "dk_hierarki_lvl_dua";
    public $primaryKey = "hld_id";
    public $incrementing = false;

    public function akun(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_akun', 'ak_kelompok', 'hld_id');
    }

    public function detail(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_hierarki_lvl_dua', 'hld_cashflow', 'hld_cashflow');
    }
}
