<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;
use Hp;

class NOMENKAB extends Model
{
    //
    protected $connection='pgsql';

  protected $fillable=['id','id_urusan_prio','uraian','jenis','id_urusan','id_program','id_kegiatan'];

    public function _urusan_prio(){
        return $this->belongsTo(NOMENURUSANPRIO::class,'id_urusan_prio');
    }

    public function _child_kegiatan(){
        return $this->hasMany($this,'id_program')->where('jenis',2)->orderBy('kode','ASC');
    }

    public function _child_sub_kegiatan(){
        return $this->hasMany($this,'id_kegiatan')->where('jenis',3)->orderBy('kode','ASC');
    }

    public function __construct(array $attributes = array())
    {

        $this->setTable('form.nomenkab_'.Hp::fokus_tahun());
        parent::__construct($attributes);
        
    }

  
}
