<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;

class INDIKATOR extends Model
{
    //
    protected $connection = 'form';
    protected $table='form.master_indikator';


     public function _sub_urusan(){
    	return $this->belongsTo(SUBURUSAN::class,'id_sub_urusan');
    }
}
