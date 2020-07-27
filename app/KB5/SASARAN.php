<?php

namespace App\KB5;

use Illuminate\Database\Eloquent\Model;
use App\KB5\INDIKATOR;

class SASARAN extends Model
{
    //
    protected $connection = 'form';
    protected $table='kb5_sasaran';


    public function _children(){
    	return $this->hasMany(INDIKATOR::class,'id_sasaran');

    }
}
