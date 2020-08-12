<?php

namespace App\KB5;

use Illuminate\Database\Eloquent\Model;
use App\KB5\ISU;
use App\MASTER\URUSAN;
use App\KB5\INDIKATOR;

class KONDISI extends Model
{
    //

    protected $connection = 'form';
    protected $table='kb5_kondisi_saat_ini';

    protected $fillable=['id','satuan','tahun_data','uraian','id_urusan','tahun','nilai','id_user'];


    public function _children(){
    	return $this->hasMany(ISU::class,'id_kondisi');
    }

    public function _urusan(){
    	return $this->belongsTo(URUSAN::class,'id_urusan');
    }

    public function _indikator(){
    	return $this->hasMany(INDIKATOR::class,'id_kondisi');
    }

}
