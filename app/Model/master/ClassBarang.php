<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class ClassBarang extends Model
{
    protected $table = 'd_class';
    protected $primaryKey = 'cl_id';
    CONST CREATED_AT = 'created_at';
    CONST UPDATED_AT = 'updated_at';
}
