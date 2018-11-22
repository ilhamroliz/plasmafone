<?php

namespace App\model\master;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $table = 'd_jenis';
    protected $primaryKey = 'j_id';
    CONST CREATED_AT = 'created_at';
    CONST UPDATED_AT = 'updated_at';

    public function types() {
		return $this->hasMany('App\model\master\JenisBarang', 'j_parent');
	}

}
