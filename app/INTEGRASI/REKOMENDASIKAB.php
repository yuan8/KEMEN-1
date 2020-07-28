<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;

class REKOMENDASIKAB extends Model
{
    //
    protected $connection='pgsql';
    protected $table='meta_rkpd.rekomendasi';
    protected $fillable=['id','kodepmda','id_nomen','id_p','id_k','jenis','tahun','id_user'];
}
