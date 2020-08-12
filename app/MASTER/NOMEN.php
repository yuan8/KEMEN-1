<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;

class NOMEN extends Model
{
    //
    protected $connection='pgsql';
    protected $table='public.master_nomenklatur_provinsi';
    protected $fillable=['id','nomenklatur','program','kegiatan','sub_kegiatan','jenis','kode',];

    public function _child_kegiatan(){
    	return $this->hasMany($this,'program','program')->where('jenis','kegiatan');
    }

    public function _child_sub_kegiatan(){
    	return $this->hasMany($this,'kegiatan','kegiatan')->where('jenis','sub_kegiatan');
    }

   

}
