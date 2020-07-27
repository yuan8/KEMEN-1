<?php

namespace App\KB5;

use Illuminate\Database\Eloquent\Model;

use App\KB5\SASARAN;
use App\KB5\ISU;


class ARAHKEBIJAKAN extends Model
{
    //
    protected $connection = 'form';
    protected $table='kb5_arah_kebijakan';


    public function _children(){
    	return $this->hasMany(SASARAN::class,'id_kebijakan');

    }

     public function _isu(){
    	return $this->belongsTo(ISU::class,'id_isu');
    }

}
