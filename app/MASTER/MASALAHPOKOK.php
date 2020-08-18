<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\DAERAH;

class MASALAHPOKOK extends Model
{
    //

    protected $connection = 'pgsql';
    protected $table='public.ms_pokok';

    public function _daerah(){
    	return $this->belongsTo(DAERAH::class,'kode_daerah');
    }
}
