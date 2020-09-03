<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MASTER\NOMEN;
use App\MASTER\NOMENKAB;
use Hp;
use Alert;
use DB;
use App\MASTER\NOMENURUSANPRIO;

class MASTER90 extends Controller
{
    //
    public function list_api_urusan_prio(Request $request){
        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
        $model= new NOMENURUSANPRIO();
        $data=$model->select(DB::raw("id,uraian as text"));
        if($request->q){
           $data= $data->where('uraian','ilike','%'.$request->q.'%');
        }
        $data=$data->paginate();

        return $data; 
    }


    public function index($pro=null,Request $request){
    	$tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();

    	if(strtoupper($pro)=='PROVINSI'){
            $pro='PROVINSI';
            $data =new NOMEN();
        		$data=$data->where([
        			['id_urusan','=',$meta_urusan['id_urusan']],
        			['jenis','=',1]
        		]
        	);


    	}else{
            $pro='KOTA';

        	$data =new NOMENKAB();
            $data=$data->where([
                    ['id_urusan','=',$meta_urusan['id_urusan']],
                    ['jenis','=',1]
                ]
            );
        
        }


        $data=$data->with(['_urusan_prio','_child_kegiatan._child_sub_kegiatan'])->orderBy('id_urusan_prio','ASC')->get()->toArray();



    	return view('integrasi.nomen.index')->with([
    		'data'=>$data,
    		'pro'=>$pro
    	]);

    }

    public function store_program($pro=null,Request $request){
        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
        if(!is_numeric($request->urusan)){

            $model=new NOMENURUSANPRIO;

            $urusan=$model->where('uraian','ilike',('%'.$request->urusan.'%'))->first();
            if(!$urusan){
                 $urusan=$model->create([
                    'uraian'=>strtoupper($request->urusan),
                    'tahun'=>$tahun
                ]);
            }
        }else{
            $urusan=['id'=>$request->urusan];
        }


        $data=[
            'kode'=>$request->kodeprogram,
            'id_urusan_prio'=>$urusan['id'],
            'id_urusan'=>$meta_urusan['id_urusan'],
            'tahun'=>$tahun,
            'uraian'=>strtoupper($request->uraiprogram),
            'kode_realistic'=>$request->kodeprogram,
            'jenis'=>1
        ];

        if(strtoupper($pro)=='PROVINSI'){
            $model =new NOMEN();
                
        }else{
            $model =new NOMENKAB();
        }

        $p=$model->insert($data);

        if($p){
            Alert::success('BERHASIL','PROGRAM DITAMBAHKAN');
        }

        return back();



    }

    public  function store_kegiatan($pro=null,$id_program,Request $request){

        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();

        $data=[
            'kode'=>$request->kode_parent.$request->kodekegiatan,
            'id_urusan'=>$meta_urusan['id_urusan'],
            'tahun'=>$tahun,
            'kode_realistic'=>$request->kodekegiatan,
            'uraian'=>strtoupper($request->uraikegiatan),
            'id_program'=>$request->id_program,
            'jenis'=>2

        ];
        if(strtoupper($pro)=='PROVINSI'){
            $model =new NOMEN();
                
        }else{

            $model =new NOMENKAB();
        }

        
        $p=$model->insert($data);

        if($p){
            Alert::success('BERHASIL','KEGIATAN DITAMBAHKAN');
        }

        return back();
    }

    public  function store_subkegiatan($pro=null,$id_program,$id_kegiatan,Request $request){

         $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();

        $data=[
            'kode'=>$request->kode_parent.$request->kodesubkegiatan,
            'id_urusan'=>$meta_urusan['id_urusan'],
            'tahun'=>$tahun,
            'kode_realistic'=>$request->kodesubkegiatan,
            'uraian'=>strtoupper($request->uraisubkegiatan),
            'id_program'=>$id_program,
            'id_kegiatan'=>$id_kegiatan,
            'jenis'=>3

        ];

        if(strtoupper($pro)=='PROVINSI'){
            $model =new NOMEN();
                
        }else{
            $model =new NOMENKAB();
        }

        $p=$model->insert($data);

        if($p){
            Alert::success('BERHASIL','SUBKEGIATAN DITAMBAHKAN');
        }

        return back();
    }

    public function api_get_nomen($pro,Request $request){
        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();

        $data=null;
        if($request->id_nomen){


            if(strtoupper($pro)=='PROVINSI'){
                $model =new NOMEN;
                    
            }else{
                $model =new NOMENKAB;
            }

            $data=$model->where('id',$request->id_nomen)->where('id_urusan',$meta_urusan['id_urusan'])->first();
        }

        if($data){
            return $data;
        }else{
            return [];
        }


    }


    public function update($pro,$id){

        if(strtoupper($pro)=='PROVINSI'){
            $model =new NOMEN($tahun);
                
        }else{
            $model =new NOMENKAB($tahun);
        }

        $data=$model->where('id',$id)->first();
        if($data){

            if($data->jenis==1){
                $data=$model->where('id',$id)->with('_child_kegiatan._child_sub_kegiatan')->get();

                $model->where('jenis',2)->where('id_program',$id)->update(
                    [
                        'kode'=>DB::raw("concate('".$data->kode."','.','kode_realistic')")
                    ]
                );

            }else if($data->jenis==2){
                $data=$model->where('id',$id)->with('_child_sub_kegiatan')->get();

            }

            $up=$model->where('id',$id)->update([
                'kode'=>$request->kode_parent.$request->kode_realistic,
                'kode_realistic'=>$request->kode_realistic,
            ]);

        }


    }

    public function delete($pro,$id){
         
            $tahun=Hp::fokus_tahun();
             $meta_urusan=Hp::fokus_urusan();

            if(strtoupper($pro)=='PROVINSI'){
                $model =new NOMEN;
                    
            }else{
                $model =new NOMENKAB;
            }

            $data=$model->where('id',$id)->delete();


            if($data){
                Alert::success('BEHASIL','MENGHAPUS MASTER NOMENKLATUR');
            }

            return back();


    }
}
