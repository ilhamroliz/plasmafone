<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_jurnal_detail extends Model
{
    protected $table = 'dk_jurnal_detail';
    public $primaryKey = ['jrdt_jurnal', 'jrdt_nomor'];
    public $incrementing = false;

    public function jurnal(){
    	return $this->belongsTo('App\Model\modul_keuangan\dk_jurnal', 'jrdt_jurnal', 'jr_id');
    }
}
