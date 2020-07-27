<?php

namespace App\KB5;

use Illuminate\Database\Eloquent\Model;
use App\KB5\ARAHKEBIJAKAN;
use App\KB5\KONDISI;
use App\KB5\SASARAN;

use App\MASTER\SUBURUSAN;



class INDIKATOR extends Model
{
    //

       //
	protected $connection = 'form';
    protected $table='form.kb5_indikator';



    protected $fillable=['kode','id','uraian','keterangan','data_dukung','kode_realistic','kw_nas','kw_p','kw_k','tipe_value','target','target_1','satuan','id_user','id_kebijakan','id_kondisi','id_sasaran','pelaksana','id_sub_urusan','data_dukung_nas','data_dukung_p','data_dukung_k'];


     public function _sub_urusan(){
    	return $this->belongsTo(SUBURUSAN::class,'id_sub_urusan');
    }

    public function _kondisi(){
    	return $this->belongsTo(KONDISI::class,'id_kondisi');
    }

    public function _kebijakan(){
      return $this->belongsTo(ARAHKEBIJAKAN::class,'id_kebijakan');
    }

    public function _sasaran(){
      return $this->belongsTo(SASARAN::class,'id_sasaran');
    }


}
