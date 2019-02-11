<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_receivable_detail extends Model
{
    protected $table = 'dk_receivable_detail';
    public $primaryKey = 'rcdt_id';
    public $incrementing = false;

    public function receivable(){
    	return $this->belongsTo('App\Model\modul_keuangan\dk_receivable', 'rcdt_receivable', 'rc_id');
    }

    public function jurnal(){
    	return $this->belongsTo('App\Model\modul_keuangan\dk_jurnal', 'rcdt_nomor', 'jr_ref');
    }
}
