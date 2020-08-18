<?php

namespace App\MANDAT;

use Illuminate\Database\Eloquent\Model;

use App\MASTER\PERDA;
use App\MASTER\PERKADA;



class MANDATINTEGRASI extends Model
{
    //

     protected $connection = 'pgsql';
    protected $table='public.ikb_integrasi';

    protected $fillable=[];

    public function _perda(){

    	return $this->hasMany(PERDA::class,'id_integrasi');
    }

     public function _perkada(){

    	return $this->hasMany(PERKADA::class,'id_inegrasi');
    }
}
