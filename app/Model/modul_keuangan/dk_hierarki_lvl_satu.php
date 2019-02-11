<?php

namespace App\Model\modul_keuangan;

use Illuminate\Database\Eloquent\Model;

class dk_hierarki_lvl_satu extends Model
{
    protected $table = "dk_hierarki_lvl_satu";
    public $primaryKey = "hls_id";

    public function subclass(){
    	return $this->hasmany('App\Model\modul_keuangan\dk_hierarki_subclass', 'hs_level_1', 'hls_id');
    }
}
