<?php

namespace App\INTEGRASI;

use Illuminate\Database\Eloquent\Model;
use App\MASTER\URUSAN;
use Hp;
class REKOMENDASIFINAL extends Model
{
	protected $connection='pgsql';

   
     public function __construct(array $attributes = array())
    {

        $this->setTable('meta_rkpd.form_status_'.Hp::fokus_tahun());
        parent::__construct($attributes);
    }

    protected $fillable=['id','kodepemda','id_urusan','tahun','id_user'];

    public function _urusan(){
    	return $this->belongsTo(URUSAN::class,'id_urusan');
    } 
}
