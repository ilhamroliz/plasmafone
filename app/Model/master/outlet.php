<?php

namespace App\Model\master;

use Illuminate\Database\Eloquent\Model;

class outlet extends Model
{
    protected $table = 'm_company';
    protected $primaryKey = 'c_id';
    public $incrementing = false;
}
