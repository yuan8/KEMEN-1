<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\INDIKATOR;
use App\MASTER\SUBURUSAN;

class KEWENANGAN extends Model
{
    //

    protected $connection = 'form';
    protected $table='form.master_kewenangan';
    protected $fillable=['id','kewenangan_nas','tahun','kewenangan_p','kewenangan_k','id_sub_urusan','id_user'];

    public function _sub_urusan(){
    	return $this->belongsTo(SUBURUSAN::class,'id_sub_urusan');
    }


    public function _indikator(){
    	return $this->hasMany(INDIKATOR::class,'id_kewenangan');
    }
}
