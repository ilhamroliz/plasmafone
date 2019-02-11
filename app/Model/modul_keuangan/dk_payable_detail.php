<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_payable_detail extends Model
{
    protected $table = 'dk_payable_detail';
    public $primaryKey = 'pydt_id';
    public $incrementing = false;

    public function payable(){
    	return $this->belongsTo('App\Model\modul_keuangan\dk_payable', 'pydt_payable', 'py_id');
    }

    public function jurnal(){
    	return $this->belongsTo('App\Model\modul_keuangan\dk_jurnal', 'pydt_nomor', 'jr_ref');
    }
}
