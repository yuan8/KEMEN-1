<?php

namespace App\Http\Controllers\INT\DAERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use Auth;
use App\MASTER\NOMEN;
use App\MASTER\NOMENKAB;
use App\INTEGRASI\REKOMENDASI as REKO;
use App\INTEGRASI\REKOMENDASIKAB;
use App\INTEGRASI\REKOMENDASI_IND;
use App\INTEGRASI\REKOMENDASIJAB_IND;
use App\KB5\INDIKATOR;
Use Carbon\Carbon;
use App\RKP\RKP;
use Alert;


class REKOMENDASI extends Controller
{
    //

    public function index(){
    	$meta_urusan=Hp::fokus_urusan();
    	$data=DB::connection('rkpd')->table('public.master_daerah as d')
    	->select(DB::RAW("*"))
    	->orderBy('id','asc')
    	->get();
    
    	return view('integrasi.rekomendasi.index')->with('data',$data);
    }

    public function detail($id){
    	$tahun=Hp::fokus_tahun();
    	if(strlen(($id.""))<3){

    		$model=RKP::where(['jenis'=>4,'tahun'=>($tahun)])->with(['_nomen_pro'=>function($q) use ($tahun,$id){

                return $q->where('tahun',$tahun)->where('jenis',1)->where('kodepemda',$id);

            },'_nomen_pro._nomen','_nomen_pro._tag_indikator._indikator','_nomen_pro._child_kegiatan._child_sub_kegiatan']);

            // $model=RKP::with('_nomen_pro')->get();

    	}else{
    		$model=RKP::where(['jenis'=>4,'tahun'=>($tahun)])->with(['_nomen_kab'=>function($q) use ($tahun,$id){

                return $q->where('tahun',$tahun)->where('jenis',1)->where('kodepemda',$id);

            },'_nomen_kab._nomen','_nomen_kab._tag_indikator._indikator','_nomen_kab._child_kegiatan._child_sub_kegiatan']);
    	}



    	$daerah=(array)DB::table('master_daerah')->find($id);

    	$data=$model->get()->toArray();


    	return view('integrasi.rekomendasi.detail')->with(['daerah'=>$daerah,'data'=>$data]);
    }

    public function add_program($id,$id_rkp=null){
    	$model=null;
    	$meta_urusan=Hp::fokus_urusan();

    	if(strlen(($id.""))<3){
    		$model=NOMEN::class;
    	}else{
    		$model=NOMENKAB::class;
    	}

    	$data=$model::where('jenis','program')->where('urus',$meta_urusan['id_urusan'])->get();

    	return view('integrasi.rekomendasi.nomen')->with(['data'=>$data,'kodepemda'=>$id,'id_rkp'=>$id_rkp]);

    }

    public function store_program($id,$id_rkp=null,Request $request){
    	if(!$request->id_nomen){
    		Alert::error('');
    		return back();
    	}

	    	$uid=Auth::id();
	    	$tahun=Hp::fokus_tahun();


	    	if(strlen(($id.""))<3){
	    		$model='meta_rkpd.rekomendasi';
	    		$parent=REKO::class;
	    	}else{
	    		$model='meta_rkpd.rekomendasi_kab';
	    		$parent=REKOMENDASIKAB::class;

	    	}

	    if(!isset($request->id_parent)){

	    		foreach ($request->id_nomen as $key => $d) {
	    		$data=DB::connection('meta_rkpd')->table($model)->updateOrInsert([
		    		'kodepemda'=>$id,
		    		'id_nomen'=>$d,
		    		'tahun'=>$tahun,
                    'id_rkp'=>$id_rkp

	    		],
	    		[
	    			'kodepemda'=>$id,
		    		'id_nomen'=>$d,
		    		'id_user'=>$uid,
		    		'jenis'=>1,
		    		'tahun'=>$tahun,
                    'id_rkp'=>$id_rkp,
		    		'updated_at'=>Carbon::now()
	    		]);
	    		# code...
	    	}

	    	Alert::success('Success','Berhasil Menambahkan Program');
    	return back();
	    }else{
	    	$parent=$parent::where('id',$request->id_parent)->first()->toArray();
	    	if($parent){
	    		$data=[
	    			'id_p'=>$parent['id_p'],
	    			'id_k'=>$parent['id_k'],
                    'id_rkp'=>$parent['id_rkp'],

	    		];

	    		if($parent['jenis']==1){
	    			$data['id_p']=$parent['id'];
	    			$jenis=2;
	    		}else{
	    			$data['id_k']=$parent['id'];
	    			$jenis=3;
	    		}


	    		foreach ($request->id_nomen as $key => $d) {
		    		$tahun=Hp::fokus_tahun();
		    		$nomen=DB::connection('meta_rkpd')->table($model)->updateOrInsert([
			    		'kodepemda'=>$id,
			    		'id_nomen'=>$d,
			    		'tahun'=>$tahun,

		    		],
		    		[
		    			'kodepemda'=>$id,
			    		'id_nomen'=>$d,
			    		'id_user'=>$uid,
			    		'jenis'=>$jenis,
			    		'id_p'=>$data['id_p'],
			    		'id_k'=>$data['id_k'],
                        'id_rkp'=>$data['id_rkp'],
			    		'tahun'=>$tahun,
			    		'updated_at'=>Carbon::now()
		    		]);
	    		# code...
	    		}

	    		Alert::success('Success','Berhasil Menambahkan '.static::jenis($jenis));
    			return back();

	    	}

	    }

    }

    public function nestedCreate($id,$id_parent,$jenis){
    	$meta_urusan=Hp::fokus_urusan();

    	if(strlen(($id.""))<3){
    		$model=REKO::class;
    		$nom=NOMEN::class;

    	}else{
    		$model=REKOMENDASIKAB::class;
    		$nom=NOMENKAB::class;

    	}

    	$model=$model::where('id',$id_parent)->with('_nomen')->first();

    	if($model){
    		$model=$model['_nomen']->toArray();

    		$jenisNomen=static::jenisNomen($jenis);
    		$dt=[
    			'jenis'=>static::jenisNomen($jenis+1),
    			'urus'=>$meta_urusan['id_urusan']
    		];
    		$dt[$jenisNomen]=$model[$jenisNomen];
    		$data=$nom::where($dt)->get();

    		return view('integrasi.rekomendasi.nomen')->with(['data'=>$data,'kodepemda'=>$id,'id_parent'=>$id_parent]);


    	}


    	return  'data tidak tersedia';


    }




    public function delete_nested ($id,$id_parent){
    	$meta_urusan=Hp::fokus_urusan();

    	if(strlen(($id.""))<3){
    		$model=REKO::class;
    		$nom=NOMEN::class;

    	}else{
    		$model=REKOMENDASIKAB::class;
    		$nom=NOMENKAB::class;

    	}

    	$model=$model::where('id',$id_parent)->with('_nomen')->first();

    	if($model){
    		$jenis=static::jenis($model['jenis']);
    		$model=$model::where('id',$id_parent)->with('_nomen')->delete();
    		Alert::success('Success','Berhasil Menghapus '.$jenis);
    		return back();

    	}


    	return  'data tidak tersedia';


    }

    public function add_indikator($id,$id_parent,$jenis){
		$uid=Auth::id();
    	$tahun=Hp::fokus_tahun();
    	$where=[];

    	if(strlen(($id.""))<3){
    		$model=REKO::class;
    		$nom=NOMEN::class;
    		$where['kw_p']=true;

    		$kewenangan='PROVINSI';

    	}else{
    		$model=REKOMENDASIKAB::class;
    		$nom=NOMENKAB::class;
    		$where['kw_k']=true;
    		$kewenangan='KOTA / KAB';



    	}

        $parent=$model::with('_nomen')->find($id_parent)->toArray();


    	$data=INDIKATOR::where('tahun',$tahun)->where($where)->whereHas('_insert_rkp',function($q) use ($tahun,$parent){
            return $q->where(['tahun'=>$tahun,'id_rkp'=>$parent['id_rkp']]);
        })->get();



    	
    	if($parent){
    		$jenis=static::jenis($parent['jenis']);

	    	return view('integrasi.rekomendasi.indikator')->with([
	    		'data'=>$data,
	    		'jenis'=>$jenis,
	    		'reko'=>$parent,
    			'parent'=>$parent['_nomen'],
    			'kodepemda'=>$id,
    			'kewenangan'=>$kewenangan
	    	]);
    	}

    }

    public function store_indikator($id,$id_parent,Request $request){
    	if(!$request->id_indikator){
    		Alert::error('');
    		return back();
    	}

    		$uid=Auth::id();
    		$tahun=Hp::fokus_tahun();
	    	if(strlen(($id.""))<3){
	    		$model='meta_rkpd.rekomendasi';
	    		$parent=REKO::class;
	    		$indikator_model='meta_rkpd.rekomendasi_indikator';

	    	}else{
	    		$model='meta_rkpd.rekomendasi_kab';
	    		$parent=REKOMENDASIKAB::class;
	    		$indikator_model='meta_rkpd.rekomendasi_indikator_kab';

	    	}

    		$parent=$parent::where('id',$id_parent)->first();


	    	if($parent){
	    		$parent=$parent->toArray();
	    		$jenis=$parent['jenis'];

	    		foreach ($request->id_indikator as $key => $d) {
		    		$tahun=Hp::fokus_tahun();
		    		$nomen=DB::connection('meta_rkpd')->table($indikator_model)->updateOrInsert([
			    		'kodepemda'=>$id,
			    		'id_indikator'=>$d,
			    		'id_rekom'=>$id_parent,
			    		'tahun'=>$tahun,

		    		],
		    		[
		    			'kodepemda'=>$id,
			    		'id_rekom'=>$id_parent,
			    		'id_indikator'=>$d,
			    		'id_user'=>$uid,
			    		'jenis'=>$jenis,
			    		'tahun'=>$tahun,
			    		'updated_at'=>Carbon::now()
		    		]);
	    		# code...
	    		}

	    		Alert::success('Success','Berhasil Menambahkan indikator '.static::jenis($jenis).'');
    			return back();

	    	}


    }




    static function jenis($jenis){
    	switch ($jenis) {
    		case 1:
    		$jenis='PROGRAM';
    			# code...
    			break;
    		case 2:
    		$jenis='KEGIATAN';
    			# code...
    			break;
    			case 3:
    		$jenis='SUB KEGIATAN';
    			# code...
    			break;
    		
    		default:
    			# code...
    			break;
    	}
    	return $jenis;
    }

     static function jenisNomen($jenis){
    	switch ($jenis) {
    		case 1:
    		$jenis='program';
    			# code...
    			break;
    		case 2:
    		$jenis='kegiatan';
    			# code...
    			break;
    			case 3:
    		$jenis='sub_kegiatan';
    			# code...
    			break;
    		
    		default:
    			# code...
    			break;
    	}
    	return $jenis;
    }


   public function delete_form_nested($id,$id_parent,$jenis){
    	
    	$meta_urusan=Hp::fokus_urusan();

    	if(strlen(($id.""))<3){
    		$model=REKO::class;
    		$nom=NOMEN::class;

    	}else{
    		$model=REKOMENDASIKAB::class;
    		$nom=NOMENKAB::class;

    	}

    	$model=$model::where('id',$id_parent)->with('_nomen')->first();
    	$jenis=static::jenis($model['jenis']);
    	
    	if($model){
    		return view('integrasi.rekomendasi.delete')->with(['jenis'=>$jenis,'id_parent'=>$id_parent,'parent'=>$model['_nomen'],'kodepemda'=>$id]);

    	}


    	return  'data tidak tersedia';


    }

       public function delete_form_indikator($id,$id_indikator){
    	
    	$meta_urusan=Hp::fokus_urusan();
		$uid=Auth::id();
		$tahun=Hp::fokus_tahun();
    	if(strlen(($id.""))<3){
    		$model='meta_rkpd.rekomendasi';
    		$parent=REKO::class;
    		$indikator_model=REKOMENDASI_IND::class;

    	}else{
    		$model='meta_rkpd.rekomendasi_kab';
    		$parent=REKOMENDASIKAB::class;
    		$indikator_model=REKOMENDASIKAB_IND::class;

    	}


    	$model=$indikator_model::where('id',$id_indikator)->with('_indikator')->first();
    	$jenis=static::jenis($model['jenis']);
    	
    	if($model){
    		return view('integrasi.rekomendasi.delete_indikator')->with(['jenis'=>$jenis,'id_parent'=>$id_indikator,'parent'=>$model['_indikator'],'kodepemda'=>$id]);

    	}


    	return  'data tidak tersedia';


    }


      public function delete_indikator($id,$id_indikator){
    	
    	$meta_urusan=Hp::fokus_urusan();
		$uid=Auth::id();
		$tahun=Hp::fokus_tahun();
    	if(strlen(($id.""))<3){
    		$model='meta_rkpd.rekomendasi';
    		$parent=REKO::class;
    		$indikator_model=REKOMENDASI_IND::class;

    	}else{
    		$model='meta_rkpd.rekomendasi_kab';
    		$parent=REKOMENDASIKAB::class;
    		$indikator_model=REKOMENDASIKAB_IND::class;

    	}


    	$model=$indikator_model::where('id',$id_indikator)->delete();

    	if($model){
    		Alert::success('Success','Berhasil Menghapus indikator');
    		return back();
    	}
    	
    }


}
