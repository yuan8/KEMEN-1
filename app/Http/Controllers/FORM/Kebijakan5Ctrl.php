<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Alert;
use Validator;
use Hp;
class Kebijakan5Ctrl extends Controller
{
    //


    public function index(){

    	$data=DB::table('master_sub_urusan as  su')
    	->leftJoin('kb5_kondisi_saat_ini as si','si.id_sub_urusan','=','su.id')
    	->leftJoin('kb5_isu_strategis as is','is.id_kb5_kondisi_saat_ini','=','si.id')
    	->leftJoin('kb5_arah_kebijakan as ak','ak.id_kb5_isu_strategis','=','is.id')
    	->leftJoin('kb5_sasaran_at_indikator as sai','sai.id_kb5_arah_kebijakan','=','ak.id')
    	->leftJoin('kb5_target as tg','tg.id_kb5_sasaran_at_indikator','=','sai.id')
    	->select(
    		'su.id as su_id',
    		'su.nama as nama',
    		'si.id as si_id',
    		'si.uraian as si_uraian',
    		'is.id as is_id',
    		'is.uraian as is_uraian',
    		'ak.id as ak_id',
    		'ak.uraian as ak_uraian',
    		'sai.id as sai_id',
    		'sai.uraian as sai_uraian',
    		'sai.pusat',
    		'sai.provinsi',
    		'sai.kota',
    		'tg.id as tg_id',
    		'tg.uraian as tg_uraian'
    	)
    	->where('si.tahun',Hp::fokus_tahun())
    	->where('si.id_urusan',Hp::fokus_urusan()['id_urusan'])
		->orderBy('su.id','DESC')
		->orderBy('si.id','DESC')
		->orderBy('is.id','DESC')
		->orderBy('ak.id','DESC')  
		->orderBy('sai.id','DESC') 
		->orderBy('tg.id','DESC')    
		->paginate(50);	


    	return view('form.kebijakan-5-tahun.index')->with('data',$data);

    }
}
