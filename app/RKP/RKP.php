<?php

namespace App\RKP;

use Illuminate\Database\Eloquent\Model;
use App\RKP\RKPINDIKATOR;
use App\KB5\INDIKATOR;


class RKP extends Model
{
    //


    protected $connection = 'rkp';
    protected $table='master_rkp';

    protected $fillable=['tahun','uraian','created_at','updated_at','id_user','id_pn','id_pp','id_kp','id_propn'];
    

    public function _child_pp(){
    	return $this->hasMany($this,'id_pn')->where('jenis',2)->with('_tag_indikator._indikator');
    }

    public function _child_kp(){
    	return $this->hasMany($this,'id_pp')->where('jenis',3)->with('_tag_indikator._indikator');;
    }

    public function _child_propn(){
    	return $this->hasMany($this,'id_kp')->where('jenis',4)->with('_tag_indikator._indikator');;
    }

    public function _child_proyek(){
    	return $this->hasMany($this,'id_propn')->where('jenis',5)->with('_tag_indikator._indikator');;
    }

     public function _parent_pp(){
    	return $this->belongsTo($this,'id_pn')->where('jenis',1);
    }

    public function _parent_kp(){
    	return $this->belongsTo($this,'id_pp')->where('jenis',2);
    }

    public function _parent_propn(){
    	return $this->belongsTo($this,'id_kp')->where('jenis',3);
    }

    public function _parent_proyek(){
    	return $this->belongsTo($this,'id_propn')->where('jenis',4);
    }

     public function _tag_indikator(){
        return $this->hasMany(RKPINDIKATOR::class,'id_rkp');
    }


    public function _indikator(){
        return $this->belongsToMany(INDIKATOR::class,RKPINDIKATOR::class,'id_rkp','id_indikator');
    }


}
