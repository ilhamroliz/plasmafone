<?php

namespace App\model\pembelian;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'd_request_order_dt';
    protected $primaryKey = 'rdt_no';
}
