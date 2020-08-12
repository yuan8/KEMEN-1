<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\URUSAN;
class REKOMENDASIFINAL extends Model
{
   
	protected $connection='pgsql';
    protected $table='meta_rkpd.rekomendasi_status_final';
    protected $fillable=['id','kodepemda','id_urusan','tahun','id_user'];

    public function _urusan(){
    	return $this->belongsTo(URUSAN::class,'id_urusan');
    } 
}
