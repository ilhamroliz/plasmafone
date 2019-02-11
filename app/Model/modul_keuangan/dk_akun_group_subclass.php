<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_akun_group_subclass extends Model
{
    protected $table = 'dk_akun_group_subclass';
    public $primaryKey = 'gs_id';
    public $incrementing = false;

    public function group(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_akun_group', 'ag_subclass', 'gs_id');
    }
}
