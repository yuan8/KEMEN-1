<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;

class PERKADA extends Model
{
    //
    protected $connection = 'pgsql';
    protected $table='public.ikb_perkada';
}
