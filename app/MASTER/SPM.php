<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;
use Hp;
use App\MASTER\SUBURUSAN;
class SPM extends Model
{
    //

    protected $connection = 'pgsql';
    protected $table='form.master_spm_2020';
    protected $fillable=['id','id_urusan','id_sub_urusan','uraian','tahun','id_user'];
      public function __construct(array $attributes = array())
    {

        $this->setTable('form.master_spm_'.Hp::fokus_tahun());
        parent::__construct($attributes);
        
    }

    public function _sub_urusan(){
    	return $this->belongsTo(SUBURUSAN::class,'id_sub_urusan');
    }

    public function _indikator(){
    	return $this->hasMany(INDIKATOR::class,'id_spm');
    }
}
