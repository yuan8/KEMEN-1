<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use Hp;
class PENDUKUNGREKOM extends Model
{
    //

    public function __construct(array $attributes = array())
    {

        $this->setTable('meta_rkpd.rekomendasi_dukungan_pro_'.Hp::fokus_tahun());
        parent::__construct($attributes);
    }

    protected $fillable=['id_rekomendasi','id_rkp','tahun','id_nspk','id_masalah','id_urusan'];


    protected $connection='pgsql';
}
