<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_transaksi_detail extends Model
{
    protected $table = 'dk_transaksi_detail';
    public $primarykey = ['trdt_transaksi', 'trdt_nomor'];
    public $incrementing = false;
}
