<?php

namespace App\RKP;

use Illuminate\Database\Eloquent\Model;
use App\KB5\INDIKATOR; 

class RKPINDIKATOR extends Model
{
    //
        //
    protected $connection = 'rkp';
    protected $table='rkp.rkp_indikator';

    protected $fillable=['id','id_rkp','id_indikator','jenis','id_user'];


    public function _indikator(){
    	return $this->belongsTo(INDIKATOR::class,'id_indikator');
    }
}
