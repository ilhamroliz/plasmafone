<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class d_mem extends Authenticatable
{
	protected $table       = 'd_mem';
	protected $primaryKey  = 'm_id';
	public $incrementing   = false;
	public $remember_token = false;
	const CREATED_AT       = 'created_at';
	const UPDATED_AT       = 'updated_at';

    protected $fillable = ['m_comp','m_id', 'm_username', 'm_password', 'm_name', 'm_address', 'm_birth', 'm_level', 'm_img', 'm_state', 'm_lastlogin', 'm_lastlogout', 'created_at', 'updated_at'];

}
