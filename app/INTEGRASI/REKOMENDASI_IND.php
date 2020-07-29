<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use App\KB5\INDIKATOR;
class REKOMENDASI_IND extends Model
{
    //
    protected $connection='pgsql';
    protected $table='meta_rkpd.rekomendasi_indikator';
    protected $fillable=['id','kodepmda','id_rekom','id_indikator','jenis','tahun','id_user','target_1','target'];

    public function _indikator(){
    	return $this->belongsTo(INDIKATOR::class,'id_indikator');
    }
}