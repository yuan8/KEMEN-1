<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Alert;
use Hp;
use Validator;
class PelaksanaanUrusanCtrl extends Controller
{
    //

    public function index(){

    	$data=DB::table('master_sub_urusan as su')
        ->select('su.*',DB::raw("(select count(*) from plu_indikator as plui where plui.id_sub_urusan = su.id and plui.tahun = ".Hp::fokus_tahun()." ) as count_indikator"))
        ->where('su.id_urusan',Hp::fokus_urusan()['id_urusan'])

        ->get();
    	return view('form.pelaksanaan_urusan.index')->with('data',$data);
    	
    }

    public function view($id){

    	$data=DB::table('master_sub_urusan')
    	->where('id_urusan',Hp::fokus_urusan()['id_urusan'])
    	->where('id',$id)->first();


    	if($data){

    		$indi=DB::table('plu_indikator as plu')
    		->leftJoin('plu_data as plud','plud.id_plu_indikator','=','plu.id')
    		->select(
    			'plu.id as plu_id',
    			'plu.uraian as plu_uraian',
    			'plud.id as plud_id',
    			'plud.uraian as plud_uraian'
    		)
    		->where('plu.id_urusan',Hp::fokus_urusan()['id_urusan'])
    		->where('plu.id_sub_urusan',$data->id)
    		->where('plu.tahun',Hp::fokus_tahun())
    		->orderBy('plu.id','DESC')
    		->orderBy('plud.id','DESC')

    		->paginate(20);

    		return view('form.pelaksanaan_urusan.view')->with('sub',$data)->with('data',$indi);
    	}

    }

    public function store_indikator($id,Request $request){
    	$uid=Auth::id();

    	$data=DB::table('master_sub_urusan')
    	->where('id_urusan',Hp::fokus_urusan()['id_urusan'])
    	->where('id',$id)->first();

    	 	$valid=Validator::make($request->all(),[
                'uraian'=>'required|string',
            ]);

            if($valid->fails()){
                Alert::error('Gagal',$valid->errors()[0]);
                return back();
            }

    	if($data){
            $data=DB::table('plu_indikator')->insertGetId([
                'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
                'id_sub_urusan'=>$data->id,
                'tahun'=>Hp::fokus_tahun(),
                'uraian'=>$request->uraian,
                'id_user'=>$uid,
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            ]);

            if($data){
                Alert::success('','Indikator Ditambahkan');
                return back();
            }else{
                  Alert::error('','Indikator Tidak Dapat ditambahkan');
                return back();
            }

        }else{
              Alert::error('','Indikator Dapat ditambahkan');
            return back();
        }
    }


    public function store_data($id_sub,$id_indikator,Request $request){
    	$uid=Auth::id();
    	$data=DB::table('plu_indikator')
    	->where('id_sub_urusan',$id_sub)
    	->where('id',$id_indikator)
    	->first();

    		$valid=Validator::make($request->all(),[
                'uraian'=>'required|string',
            ]);

            if($valid->fails()){
                Alert::error('Gagal',$valid->errors()[0]);
                return back();
            }

    	if($data){

    		 $data=DB::table('plu_data')->insertGetId([
                'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
                'id_sub_urusan'=>$data->id_sub_urusan,
                'id_plu_indikator'=>$data->id,
                'tahun'=>Hp::fokus_tahun(),
                'uraian'=>$request->uraian,
                'id_user'=>$uid,
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            ]);

            if($data){
                Alert::success('','Data Indikator Ditambahkan');
                return back();
            }else{
                  Alert::error('','Data Indikator Tidak Dapat ditambahkan');
                return back();
            }

    	}

    }

}
