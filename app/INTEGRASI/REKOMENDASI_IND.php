<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\INDIKATOR;
use Hp;
class REKOMENDASI_IND extends Model
{
    //

       public function __construct(array $attributes = array())
    {

        $this->setTable('meta_rkpd.rekomendasi_indikator_'.Hp::fokus_tahun());
        parent::__construct($attributes);
    }

    protected $connection='pgsql';
    protected $table='meta_rkpd.rekomendasi_indikator';
    protected $fillable=['id','kodepmda','id_rekom','id_indikator','jenis','tahun','id_user','target_1','target'];

    public function _indikator(){
    	return $this->belongsTo(INDIKATOR::class,'id_indikator')->has('tag_on_kewenangan');
    }
}
