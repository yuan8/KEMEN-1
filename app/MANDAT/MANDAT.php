<?php

namespace App\MANDAT;

use Illuminate\Database\Eloquent\Model;
use App\MANDAT\MANDATINTEGRASI;
use App\MASTER\UU;
use App\MASTER\PP;
use App\MASTER\PERPRES;
use App\MASTER\PERMEN;
use App\MASTER\SUBURUSAN;

use App\MASTER\PERDA;
use App\MASTER\PERKADA;

class MANDAT extends Model
{
    //

    protected $connection = 'pgsql';
    protected $table='public.ikb_mandat';

    protected $fillable=[];

    public function _integrasi(){
    	return $this->hasMany(MANDATINTEGRASI::class,'id_mandat');
    }

    public function _sub_urusan(){
    	return $this->belongsTo(SUBURUSAN::class,'id_sub_urusan');
    }

    public function _uu(){
    	return $this->hasMany(UU::class,'id_mandat');
    }

    public function _pp(){
    	return $this->hasMany(PP::class,'id_mandat');
    }

    public function _perpres(){
    	return $this->hasMany(PERPRES::class,'id_mandat');
    }

    public function _permen(){
    	return $this->hasMany(PERMEN::class,'id_mandat');
    }

    public function _list_perkada(){
    	return $this->belongsToMany(MANDATINTEGRASI::class,PERKADA::class,'id_mandat','id_integrasi');
    }

    public function _integrasi_sesuai(){
    	return $this->hasMany(MANDATINTEGRASI::class,'id_mandat')->where('kesesuaian',1);
    }
      public function _integrasi_belum_dinilai(){
    	return $this->hasMany(MANDATINTEGRASI::class,'id_mandat')->where('kesesuaian',0);
    }
    
    public function _integrasi_tidak_sesuai(){
    	return $this->hasMany(MANDATINTEGRASI::class,'id_mandat')->where('kesesuaian',2);
    }

    public function _list_perda(){
    	return $this->belongsToMany(MANDATINTEGRASI::class,PERDA::class,'id_mandat','id_integrasi');
    }
}
