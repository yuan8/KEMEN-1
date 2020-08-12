<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;

class SATUAN extends Model
{
    //
	protected $connection='pgsql';
	protected $table='public.master_satuan';

	protected $fillable=['kode','sistem_cal'];

}
