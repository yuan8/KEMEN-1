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


    public function _indikator(){
    	$this->belongsTo(INDIKATOR::class,'id_indikator');
    }
}
