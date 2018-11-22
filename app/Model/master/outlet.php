<?php

namespace App\Model\master;

use Illuminate\Database\Eloquent\Model;

class outlet extends Model
{
    protected $table = 'd_cabang';
    protected $primaryKey = 'c_id';
    public $incrementing = false;
}
