<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_payable extends Model
{
    protected $table = 'dk_payable';
    public $primaryKey = 'py_id';


    public function detailBySupplier(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_payable', 'py_kreditur', 'py_kreditur');
    }
}
