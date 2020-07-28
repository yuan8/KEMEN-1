<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\NOMEN;
use App\INTEGRASI\REKOMENDASI_IND;
class REKOMENDASI extends Model
{
    //
    protected $connection='pgsql';
    protected $table='meta_rkpd.rekomendasi';
    protected $fillable=['id','kodepmda','id_nomen','id_p','id_k','jenis','tahun','id_user'];


    public function _nomen(){
    	return $this->belongsTo(NOMEN::class,'id_nomen');
    }

    public function _child_kegiatan(){
    	return $this->hasMany($this,'id_p')->with('_nomen','_tag_indikator._indikator');
    }
     
    public function _child_sub_kegiatan(){
    	return $this->hasMany($this,'id_k')->with('_nomen','_tag_indikator._indikator');
    }

    public function _tag_indikator(){
        return $this->hasMany(REKOMENDASI_IND::class,'id_rekom');
    }

}
