<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class suplier extends Model
{
    protected $table = 'd_supplier';
    protected $primaryKey = 's_id';
    CONST CREATED_AT = 's_insert';
    CONST UPDATED_AT = 's_update';
}
