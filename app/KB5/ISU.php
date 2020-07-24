<?php

namespace App\KB5;

use Illuminate\Database\Eloquent\Model;
use App\KB5\ARAHKEBIJAKAN;

class ISU extends Model
{
    //
	protected $connection = 'form';
    protected $table='kb5_isu_strategis';


    public function _children(){
    	
    	return $this->hasMany(ARAHKEBIJAKAN::class,'id_isu');
    }




}
