<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\NOMEN;
use App\INTEGRASI\REKOMENDASI_IND;
use Hp;
use App\INTEGRASI\PENDUKUNGREKOM;
use App\MANDAT\MANDAT;
use App\RKP\RKP;
use App\MASALAH\MASALAH;



class REKOMENDASI extends Model
{
    //
      public function __construct(array $attributes = array())
    {

        $this->setTable('meta_rkpd.rekomendasi_'.Hp::fokus_tahun());
        parent::__construct($attributes);
    }
    protected $connection='pgsql';
    protected $table='meta_rkpd.rekomendasi';
     protected $fillable=['id','kodepemda','id_nomen','id_urusan','id_p','id_k','jenis','tahun','id_user'];

    public function _nomen(){
    	return $this->belongsTo(NOMEN::class,'id_nomen');
    }

    public function _child_kegiatan(){
    	return $this->hasMany($this,'id_p')->where('jenis',2)->with('_nomen','_tag_indikator._indikator');
    }


     
    public function _child_sub_kegiatan(){
    	return $this->hasMany($this,'id_k')->where('jenis',3)->with('_nomen','_tag_indikator._indikator');
    }

    public function _tag_indikator(){
        return $this->hasMany(REKOMENDASI_IND::class,'id_rekom')->whereHas('_indikator');
    }

       public function _pendukung_masalah(){
        return $this->belongsToMany(MASALAH::class,PENDUKUNGREKOM::class,'id_rekomendasi','id_masalah');

    }

    public function _dukungan(){
        return $this->hasMany(PENDUKUNGREKOM::class,'id_rekomendasi');

    }

    public function _pendukung_nspk(){
        return $this->belongsToMany(MANDAT::class,PENDUKUNGREKOM::class,'id_rekomendasi','id_nspk');

    }

    public function _pendukung_rkp(){
        return $this->belongsToMany(RKP::class,PENDUKUNGREKOM::class,'id_rekomendasi','id_rkp');

    }

}
