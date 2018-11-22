<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class m_member extends Authenticatable
{
    protected $table = 'd_mem';
    protected $primaryKey = "m_id";

    public $remember_token = false;

}
