<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pemetaanperencanaan extends Model
{
    //
	// protected $connection = 'rpjmd';
    protected $table='rpjmd.pemetaan_perencanaan';

    protected $fillable=['id_program_rpjmd','id_program_rkpd','created_at','updated_at'];


    
}
