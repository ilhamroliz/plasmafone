<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class SatuanBarang extends Model
{
    protected $table = 'd_satuan';
    protected $primaryKey = 'st_id';
    CONST CREATED_AT = 'created_at';
    CONST UPDATED_AT = 'updated_at';
}
