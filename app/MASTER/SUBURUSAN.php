<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\URUSAN;
class SUBURUSAN extends Model
{
    //

    protected $connection='pgsql';
    protected $table='public.master_sub_urusan';

    public function _urusan(){
    	return $this->belongsTo(URUSAN::class,'id_urusan');
    }
}
