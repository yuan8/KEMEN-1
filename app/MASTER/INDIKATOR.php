<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;
use App\KB5\ARAHKEBIJAKAN;
use App\KB5\KONDISI;
use App\KB5\SASARAN;
use App\RKP\RKP;
use App\MASTER\SUBURUSAN;
use App\MASTER\URUSAN;

use App\MASTER\KEWENANGAN;

use App\RKP\RKPINDIKATOR;
use Hp;

class INDIKATOR extends Model
{
    //

       //
    protected $connection = 'form';
    protected $table='form.master_indikator';



  protected $fillable=[
    'id',
    'kode_realistic',
    'kode',
    'kewenangan_nas',
    'kewenangan_p',
    'kewenangan_k',
    'tahun',
    'uraian',
    'target',
    'target_1',
    'tipe_value',
    'tipe_cal',
    'satuan',
    'lokus',
    'satuan_lokus',
    'pelaksana_nas',
    'pelaksana_p',
    'pelaksana_k',
    'pelaksana_k',
    'kw_nas',
    'kw_p',
    'kw_k',
    'id_sub_urusan',
    'id_user',
    'data_dukung_nas',
    'data_dukung_p',
    'data_dukung_k',
    'keterangan',
    'id_kebijakan',
    'id_kondisi',
    'id_sasaran',
    'id_kewenangan',
    'tag',
    'id_urusan'
  ];


    public function _sub_urusan(){
    	return $this->belongsTo(SUBURUSAN::class,'id_sub_urusan');
    }

    public function _urusan(){
        return $this->belongsTo(URUSAN::class,'id_urusan');
    }

    public function _kewenangan(){
        return $this->belongsTo(KEWENANGAN::class,'id_kewenangan');
    }

     public function tag_on_rkp_propn(){
        return $this->hasMany(RKPINDIKATOR::class,'id_indikator');
    }

    public function tag_on_kewenangan(){
        return $this->belongsTo(KEWENANGAN::class,'id_kewenangan');
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

    public function _insert_rkp(){
      return $this->hasMany(RKPINDIKATOR::class,'id_indikator');
    }


    public function _sumber(){
        return Hp::tag_ind($this->tag);
    }




}
