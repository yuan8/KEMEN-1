<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\NOMENKAB;
use App\INTEGRASI\REKOMENDASIKAB_IND;
class REKOMENDASIKAB extends Model
{
    //
    protected $connection='pgsql';
    protected $table='meta_rkpd.rekomendasi_kab';
    protected $fillable=['id','kodepmda','id_nomen','id_p','id_k','jenis','tahun','id_user'];


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
        return $this->hasMany(REKOMENDASIKAB_IND::class,'id_rekom');
    }
}
