<?php

namespace App\MASALAH;

use Illuminate\Database\Eloquent\Model;
use App\INTEGRASI\PENDUKUNGREKOM;
use App\INTEGRASI\PENDUKUNGREKOMKAB;
use App\INTEGRASI\REKOMENDASI;
use App\MASALAH\AKARMASALAH;




class MASALAH extends Model
{
    //

    protected $connection = 'pgsql';
    protected $table='public.ms';

    public function _reko_program(){
    	return $this->belongsToMany(REKOMENDASI::class,PENDUKUNGREKOM::class,'id_masalah','id_rekomendasi');
    }

     public function _reko_program_kab(){
    	return $this->belongsToMany((new REKOMENDASI), (new PENDUKUNGREKOMKAB),'id_masalah','id_rekomendasi');
    }

    public function _akar(){
    	return $this->hasMany(AKARMASALAH::class,'id_ms');
    }
}
