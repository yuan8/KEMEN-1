<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use Hp;
use App\MASALAH\MASALAH;
class PENDUKUNGREKOMKAB extends Model
{
    //

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setTable('meta_rkpd.rekomendasi_dukungan_kab_'.Hp::fokus_tahun());
    }

    protected $table='meta_rkpd.rekomendasi_dukungan_kab_';

    protected $connection='pgsql';

    protected $fillable=['id_rekomendasi','id_rkp','tahun','id_nspk','id_masalah','id_urusan'];

    public function _masalah(){
    	return $this->belongsto(MASALAH::class,'id_masalah');
    }
}
