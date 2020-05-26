<?php

namespace App\Http\Controllers\FRONT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BOT extends Controller
{
    //


    public function getJson($tahun,$kodepemda){
    	Hp::checkDBProKeg($tahun);
    	Artisan::call('sipd:status-rkpd '.$tahun);

    	set_time_limit(-1);

    	$kode_bidang=[];
    	$opts = [
		    "http" => [
		        "method" => "GET",
		          "header" => "Authorization: bearer ".static::$token

		    ]
		];

		if(strlen($kodepemda)<4){
			$kode_daerah=$kodepemda.'00';
		}else{
			$kode_daerah=$kodepemda;
		}

		$context = stream_context_create($opts);


		
    }
}
