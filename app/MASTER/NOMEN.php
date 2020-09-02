<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;

class NOMEN extends Model
{
    //
    protected $connection='pgsql';
    
    protected $fillable=['id','uraian','jenis','id_urusan','id_program','id_kegiatan'];

    public function _child_kegiatan(){
    	return $this->hasMany($this,'program','program')->where('jenis','kegiatan');
    }

    public function _child_sub_kegiatan(){
    	return $this->hasMany($this,'kegiatan','kegiatan')->where('jenis','sub_kegiatan');
    }

    public function __construct($tahun=null)
    {

        if($tahun){
             $this->setTable('form.nomenpro_'.$tahun);
        }else{
            $this->setTable('form.nomenpro_'.(2020));
        }
    }






   

}
