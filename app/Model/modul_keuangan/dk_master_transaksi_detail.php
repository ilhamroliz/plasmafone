<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_master_transaksi_detail extends Model
{
    protected $table = 'dk_master_transaksi_detail';
    public $primaryKey = ['mtdt_transaksi', 'mtdt_nomor'];
    public $incrementing = false;
}
