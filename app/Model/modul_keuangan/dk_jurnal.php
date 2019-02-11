<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_jurnal extends Model
{
    protected $table = 'dk_jurnal';
    public $primaryKey = 'jr_id';

    public function detail(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_jurnal_detail', 'jrdt_jurnal', 'jr_id');
    }
}
