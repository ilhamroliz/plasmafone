<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_transaksi extends Model
{
    protected $table = 'dk_transaksi';
    public $primaryKey = 'tr_id';

    public function detail(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_transaksi_detail', 'trdt_transaksi', 'tr_id');
    }
}
