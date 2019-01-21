<?php

namespace App\Model\master;

use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    protected $table = 'm_member';
    protected $primaryKey = 'm_id';
    public $incrementing = false;
    public $timestamps = false;
}
