<?php

namespace App\MASTER;

use Illuminate\Database\Eloquent\Model;
use Hp;
class NOMENURUSANPRIO extends Model
{
    //

     protected $connection='pgsql';


    protected $fillable=['id','uraian','tahun'];


    public function __construct(array $attributes = array())
    {

        $this->setTable('form.master_urusan_prioritas_'.Hp::fokus_tahun());
        parent::__construct($attributes);
        
    }
      

         
       


}
