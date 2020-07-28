<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;

class NOMENKAB extends Model
{
    //
    protected $connection='pgsql';
    protected $table='public.master_nomenklatur_kabkota';

    public function _child_kegiatan(){
    	return $this->hasMany($this,'program','program')->where('jenis','kegiatan');
    }

     public function _child_sub_kegiatan(){
    	return $this->hasMany($this,'kegiatan','kegiatan')->where('jenis','sub_kegiatan');
    }
}
