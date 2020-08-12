<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;
use App\INTEGRASI\REKOMENDASI;
use App\INTEGRASI\REKOMENDASIKAB;
use App\INTEGRASI\REKOMENDASIFINAL;

use Hp;

class DAERAH extends Model
{
    //
	     //
    protected $connection = 'pgsql';
    protected $table='public.master_daerah';
    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    public function _rekomendasi_final(){

        return $this->hasOne(REKOMENDASIFINAL::class,'kodepemda');
    }

    public function _has_rekomendasi(){
        $tahun=Hp::fokus_tahun();
    	if($this->id){
            if(strlen(($this->id.''))<3){
                return $this->hasOne(REKOMENDASI::class,'kodepemda','id')->where('tahun',$tahun);
            }else{
                return $this->hasOne(REKOMENDASIKAB::class,'kodepemda','id')->where('tahun',$tahun);
            }
        }
    }

    public function _provinsi(){
        if($this->id){
            if(strlen(($this->id.''))<3){
        
                return $this->belongsTo($this,'id','id');
            }else{
                return $this->belongsTo($this,'kode_daerah_parent','id');

            }
        }
    	
    }


}