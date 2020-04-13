<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Hp;
use Validator;
use Alert;

class IntegrasiKabKotaCtrl extends Controller
{
    //

	public function index(){
	
		$data=DB::table('master_nomenklatur_kabkota as p')
		->orderBy('kode','ASC')
		->whereIn('jenis',['bidang_urusan','program','kegiatan','sub_kegiatan'])
		->get();

		

		dd($data);

	
	}

    public function kota(){

    	$d=DB::table("master_daerah as d")
    	->whereNotNull('kode_daerah_parent')
    	->select(
    		DB::raw("(select nama from master_daerah where id=d.kode_daerah_parent limit 1) as nama_provinsi"),
    		"d.*"
    	)
    	->get();



    }
}
