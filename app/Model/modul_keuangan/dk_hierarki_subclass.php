<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_hierarki_subclass extends Model
{
    protected $table = "dk_hierarki_subclass";
    public $primaryKey = "hs_id";

    public function level_2(){
    	return $this->hasmany('App\Model\modul_keuangan\dk_hierarki_lvl_dua', 'hld_subclass', 'hs_id');
    }
}
