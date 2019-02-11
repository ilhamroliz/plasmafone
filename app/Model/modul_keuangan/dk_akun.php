<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_akun extends Model
{
    protected $table = 'dk_akun';
    public $primaryKey = 'ak_id';
    public $incrementing = false;

    public function fromKelompok(){
        return $this->hasMany('App\Model\modul_keuangan\dk_akun', 'ak_kelompok', 'ak_kelompok');
    }

    public function jurnal_detail(){
        return $this->hasMany('App\Model\modul_keuangan\dk_jurnal_detail', 'jrdt_akun', 'ak_id');
    }

    public function mutasikasMasuk(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_jurnal_detail', 'jrdt_akun', 'ak_id');
    }

    public function mutasikasKeluar(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_jurnal_detail', 'jrdt_akun', 'ak_id');
    }

    public function mutasiBankMasuk(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_jurnal_detail', 'jrdt_akun', 'ak_id');
    }

    public function mutasiBankKeluar(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_jurnal_detail', 'jrdt_akun', 'ak_id');
    }

    public function mutasiMemorialDebet(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_jurnal_detail', 'jrdt_akun', 'ak_id');
    }

    public function mutasiMemorialKredit(){
    	return $this->hasMany('App\Model\modul_keuangan\dk_jurnal_detail', 'jrdt_akun', 'ak_id');
    }
}
