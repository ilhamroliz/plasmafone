<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_receivable extends Model
{
    protected $table = 'dk_receivable';
    public $primaryKey = 'rc_id';

    public function detailByDebitur(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_receivable', 'rc_debitur', 'rc_debitur');
    }
}
