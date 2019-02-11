<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_akun_group extends Model
{
    protected $table = 'dk_akun_group';
    public $primaryKey = 'ag_id';
    public $incrementing = false;

    public function akun(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_akun', 'ak_group_neraca', 'ag_id');
    }

    public function lr(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_akun', 'ak_group_lr', 'ag_id');
    }
}
