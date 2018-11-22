<?php

namespace App\Model\master;

use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    protected $table = 'd_karyawan';
    protected $primaryKey = 'id_karyawan';
    public $incrementing = false;

    public function jabatan(){
    	return $this->belongsTo('App\Model\master\d_jabatan', 'id_jabatan', 'id');
    }

    public function posisi(){
    	return $this->belongsTo('App\Model\master\d_posisi', 'id_posisi', 'id_posisi');
    }

    public function kota(){
    	return $this->belongsTo('App\Model\master\d_kota', 'id_kota', 'id');
    }
}
