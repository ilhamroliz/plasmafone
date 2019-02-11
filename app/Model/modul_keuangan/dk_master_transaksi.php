<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_master_transaksi extends Model
{
    protected $table = 'dk_master_transaksi';
    public $primaryKey = 'mt_id';

    public function detail(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_master_transaksi_detail', 'mtdt_transaksi', 'mt_id');
    }
}
