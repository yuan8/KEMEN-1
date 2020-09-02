<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pemetaankebijakan extends Model
{
    //
	 protected $connection = 'form';
    protected $table='form.pemetaan_kebijakan';

    protected $fillable=['id','id_mandat','id_arah_kebijakan','id_user','tahun','created_at','updated_at'];


    
}
