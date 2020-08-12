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
use App\INTEGRASI\REKOMENDASIFINAL;

use App\INTEGRASI\REKOMENDASIJAB_IND;
use App\MASTER\INDIKATOR;
use App\MASTER\DAERAH;
Use Carbon\Carbon;
use App\RKP\RKP;
use Alert;


class REKOMENDASI extends Controller
{
    //

    public function setTargetDarah($id,$id_indikator,Request $request){
            if(!$request->target){
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

            $data=DB::connection('meta_rkpd')->table($indikator_model)->where('id',$id_indikator)->first();

            if($data){
                $data=DB::connection('meta_rkpd')->table($indikator_model)->where('id',$id_indikator)->update([
                    'target'=>$request->target,
                    'target_1'=>$request->target_1,
                    'updated_at'=>Carbon::now()
                ]);

                return array('code'=>200);
            }else{
                return array('code'=>200);

            }

    }


    public function index(){
    	$tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
        $id_urusan=$meta_urusan['id_urusan'];
        $data=DAERAH::with(['_rekomendasi_final'=>function($q) use ($tahun,$id_urusan){
            return $q->where('tahun',$tahun)->where('id_urusan',$id_urusan);
        }])->orderBy('id','asc')->get();
    	return view('integrasi.rekomendasi.index')->with('data',$data);
    }

    public function detail($id){
    	$tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
        $id_urusan=$meta_urusan['id_urusan'];

        $daerah=DAERAH::where('id',$id)->with(['_rekomendasi_final'=>function($q) use ($tahun,$id_urusan){
            return $q->where('tahun',$tahun)->where('id_urusan',$id_urusan);
        }])->first();
        if($daerah['_rekomendasi_final']){
            return redirect()->route('int.rekomendasi.export',['id'=>$id]);

        }


    	if(strlen(($id.""))<3){

    		$model=RKP::where(['jenis'=>4,'tahun'=>($tahun),'id_urusan'=>$meta_urusan['id_urusan']])->with(['_nomen_pro'=>function($q) use ($tahun,$id){
                return $q->where('tahun',$tahun)->where('jenis',1)->where('kodepemda',$id);
            },'_nomen_pro._nomen','_nomen_pro._tag_indikator._indikator','_nomen_pro._child_kegiatan._child_sub_kegiatan']);


    	}else{
    		$model=RKP::where(['jenis'=>4,'tahun'=>($tahun)])->with(['_nomen_kab'=>function($q) use ($tahun,$id){

                return $q->where('tahun',$tahun)->where('jenis',1)->where('kodepemda',$id);

            },'_nomen_kab._nomen','_nomen_kab._tag_indikator._indikator','_nomen_kab._child_kegiatan._child_sub_kegiatan']);
    	}



    	

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
        
// Your Eloquent query executed by using get()


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


    	$data=INDIKATOR::where('tahun',$tahun)->where($where)->get();

        $data=[

            'jenis'=>$jenis,
            'reko'=>$parent,
            'parent'=>$parent['_nomen'],
            'kodepemda'=>$id,
            'kewenangan'=>$kewenangan,

        ];


        if($jenis==1){
            $data['for_integrasi_program']=true;
            $data['indikator_from_rkp_id']=$parent['id_rkp'];
        }
        else{
            $data['for_integrasi_program_child']=true;
            $data['indikator_from_rkp_id']=$parent['id_rkp'];
        }

       

      

    	if($parent){
            $jenis=static::jenis($parent['jenis']);

            $data['jenis']=$jenis;
	    	return view('integrasi.rekomendasi.indikator')->with(
	    		$data
	    	);
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


    public function form_final($id){
        $data=DAERAH::find($id);

        if($data){
            return view('integrasi.rekomendasi.form_final')->with('data',$data);
        }
    }


    public function finalisasi($id){
        $data=DAERAH::find($id);
        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();


        if($data){
            $ok=REKOMENDASIFINAL::updateOrCreate(
                [
                'kodepemda'=>$id,
                'tahun'=>$tahun,
                'id_urusan'=>$meta_urusan['id_urusan'],

                ]
                ,
                [
                    'kodepemda'=>$id,
                    'tahun'=>$tahun,
                    'id_user'=>Auth::id(),
                     'id_urusan'=>$meta_urusan['id_urusan'],

                ]
            );

            if($ok){
            Alert::success('REKOMENDASI FINAL','Berhasil Mengubah Rekomendasi Pada Satatus Final');

            }

            return back();


        }
    }


    public function view_format_export($id,Request $request){

        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
        $id_urusan=$meta_urusan['id_urusan'];
        $daerah=DAERAH::with(['_rekomendasi_final'=>function($q) use ($tahun,$id_urusan){
            return $q->where('tahun',$tahun)->where('id_urusan',$id_urusan);
        },'_rekomendasi_final._urusan'])->where('id',$id)->first();
        
            if($daerah['_rekomendasi_final']){

                if(strlen(($id.""))<3){

                $model=RKP::where(['jenis'=>4,'tahun'=>($tahun),'id_urusan'=>$meta_urusan['id_urusan']])->with(['_nomen_pro'=>function($q) use ($tahun,$id){
                    return $q->where('tahun',$tahun)->where('jenis',1)->where('kodepemda',$id);
                },'_nomen_pro._nomen','_nomen_pro._tag_indikator._indikator','_nomen_pro._child_kegiatan._child_sub_kegiatan']);


            }else{
                $model=RKP::where(['jenis'=>4,'tahun'=>($tahun)])->with(['_nomen_kab'=>function($q) use ($tahun,$id){

                    return $q->where('tahun',$tahun)->where('jenis',1)->where('kodepemda',$id);

                },'_nomen_kab._nomen','_nomen_kab._tag_indikator._indikator','_nomen_kab._child_kegiatan._child_sub_kegiatan']);
            }

            $data=$model->get()->toArray();

            if($request->pdf){
                $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape')->setOptions(['dpi' => 200, 'defaultFont' => 'sans-serif','isRemoteEnabled' => true]);
                $pdf->loadHTML(view('integrasi.rekomendasi.final')->with(['meta'=>$daerah['_rekomendasi_final'],'data'=>$data,'daerah'=>$daerah])->render());
                return $pdf->stream();

            }else if($request->excel){

            }else{
                return view('integrasi.rekomendasi.final')->with(['meta'=>$daerah['_rekomendasi_final'],'data'=>$data,'daerah'=>$daerah]);
            }
            



        }

    }


}
