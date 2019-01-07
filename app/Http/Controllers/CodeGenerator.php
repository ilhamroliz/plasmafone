<?php

namespace App\Http\Controllers;

use DB;

class CodeGenerator
{
	public static function code($table, $field, $lebar=0, $awalan)
	{
		$code = DB::table($table)->select($field)->orderBy($field, 'desc')->limit(1);
        $countData = $code->count();
        if ($countData == 0) {
            $nomor = 1;
        }else{
            $getData = $code->get();
            $row = array();
            foreach ($getData as $value) {
                $row = array($value->$field);
            }
            $nomor = intval(substr($row[0], strlen($awalan)))+1;
        }

        if ($lebar > 0) {
            $angka = $awalan.str_pad($nomor, $lebar,"0", STR_PAD_LEFT);
        }else{
            $angka = $awalan.$nomor;
        }

        return $angka;
    }
    
    public static function codePos($table, $field, $lebar=0, $awalan)
    {
        // POS-REG/001/14/12/2018

        $code = DB::table($table)->select($field);
        $countData = $code->count();

        // if ($countData == 0) {
        //     $nomor = 1;
        // }else{
        //     $getData = $code->get();
        //     $row = array();
        //     foreach ($getData as $value) {
        //         $row = array($value->$field);
        //     }
        //     $nomor = intval(substr($row[0], strlen($awalan)))+1;
            
        // }

        $nomor = $countData+1;


        if ($lebar > 0) {
            $angka = $awalan.'/'.str_pad($nomor, $lebar,"0", STR_PAD_LEFT).'/'.date('d/m/Y');
        }else{
            $angka = $awalan.'/'.$nomor.'/'.date('d/m/Y');
        }

        return $angka;
    }
}

?>