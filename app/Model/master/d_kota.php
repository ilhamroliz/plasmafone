<?php

namespace App\Model\master;

use Illuminate\Database\Eloquent\Model;

class d_kota extends Model
{
    protected $table = 'd_kota';
    public $incrementin = false;

    public $timestamps = false;

    public function provinsi(){
    	return $this->belongsTo('App\Model\master\d_provinsi', 'id_provinsi', 'id');
    }
}
