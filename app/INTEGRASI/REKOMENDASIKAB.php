<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\NOMENKAB;
use App\INTEGRASI\REKOMENDASIKAB_IND;
use Hp;
use App\INTEGRASI\PENDUKUNGREKOMKAB;
use App\MANDAT\MANDAT;
use App\RKP\RKP;
use App\MASALAH\MASALAH;

class REKOMENDASIKAB extends Model
{
    //

    public function __construct(array $attributes = array())
    {

        $this->setTable('meta_rkpd.rekomendasi_kab_'.Hp::fokus_tahun());
        parent::__construct($attributes);
    }

    protected $connection='pgsql';
    protected $table='meta_rkpd.rekomendasi_kab';
    protected $fillable=['id','kodepemda','id_nomen','id_urusan','id_p','id_k','jenis','tahun','id_user'];


    public function _nomen(){
    	return $this->belongsTo(NOMENKAB::class,'id_nomen');
    }

    public function _child_kegiatan(){
    	return $this->hasMany($this,'id_p')->where('jenis',2)->with('_nomen','_tag_indikator._indikator');
    }
     
    public function _child_sub_kegiatan(){
    	return $this->hasMany($this,'id_k')->where('jenis',3)->with('_nomen','_tag_indikator._indikator');
    }

    public function _tag_indikator(){
        return $this->hasMany(REKOMENDASIKAB_IND::class,'id_rekom')->whereHas('_indikator');;
    }


     public function _pendukung_masalah(){
        return $this->belongsToMany(MASALAH::class,PENDUKUNGREKOMKAB::class,'id_rekomendasi','id_masalah');

    }

    public function _dukungan(){
        return $this->hasMany(PENDUKUNGREKOMKAB::class,'id_rekomendasi');

    }

    public function _pendukung_nspk(){
        return $this->belongsToMany(MANDAT::class,PENDUKUNGREKOMKAB::class,'id_rekomendasi','id_nspk');

    }

    public function _pendukung_rkp(){
        return $this->belongsToMany(RKP::class,PENDUKUNGREKOMKAB::class,'id_rekomendasi','id_rkp');

    }
}
