<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\INDIKATOR;
use Hp;
class REKOMENDASIKAB_IND extends Model
{
    //

    protected $connection='pgsql';
    protected $table='meta_rkpd.rekomendasi_indikator_kab';
    protected $fillable=['id','kodepemda','id_rekom','id_indikator','jenis','tahun','id_user','target_1','target'];

    public function _indikator(){
        $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();

    	return $this->belongsTo(INDIKATOR::class,'id_indikator')->where('id_urusan',$meta_urusan['id_urusan'])
    	->where('tahun',$tahun)->has('tag_on_kewenangan')
        // ->has('tag_on_rkp_propn');
        ;
    }



    public function __construct(array $attributes = array())
    {

        $this->setTable('meta_rkpd.rekomendasi_indikator_kab_'.Hp::fokus_tahun());
        parent::__construct($attributes);
    }

}
