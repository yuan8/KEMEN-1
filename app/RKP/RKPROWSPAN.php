<?php

namespace App\RKP;

use Illuminate\Database\Eloquent\Model;
use Hp;
class RKPROWSPAN extends Model
{
    //

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setTable('rkp.rowspan_rkp_'.Hp::fokus_tahun());
    }
}
