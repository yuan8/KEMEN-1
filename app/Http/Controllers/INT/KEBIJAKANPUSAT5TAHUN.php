<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hp;
use App\KB5\KONDISI;
use App\KB5\INDIKATOR;
use Validator;
use Alert;
use Auth;
use Carbon\Carbon;
use App\MASTER\SUBURUSAN;
class KEBIJAKANPUSAT5TAHUN extends Controller
{
    //

	public function index(){
		$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();


		$data=KONDISI::
		where('id_urusan',$meta_urusan['id_urusan'])->
		where('tahun',$tahun)->
		with('_urusan','_children._children._children._children._sub_urusan')->get()->toArray();

        $rpjmn=Hp::get_tahun_rpjmn(Hp::fokus_tahun());
     


    	return view('integrasi.kb5tahun.index')->with([
            'data'=>$data,
            'rpjmn'=>$rpjmn


        ]);

    }



    public function kondisi_store(Request $request){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();

    	if($request->tipe_value){
    		$valid=Validator::make($request->all(),[
    			'nilai'=>'numeric|required',
    			'kode'=>'string|required',
    			'satuan'=>'string|required',
    			'tipe_value'=>'numeric',
    			'uraian'=>'string|required',
    			'tahun_data'=>'numeric|min:'.(Hp::fokus_tahun()-5),
    		]);
    	}else{
    		$valid=Validator::make($request->all(),[
    			'nilai'=>'string|required',
    			'kode'=>'string|required',
    			'tipe_value'=>'numeric',
    			'satuan'=>'string|required',
    			'uraian'=>'string|required',
    			'tahun_data'=>'numeric|min:'.(Hp::fokus_tahun()-5),
    		]);
    	}


    	if($valid->fails()){
    		Alert::error('Error','');
    		dd($valid);
    		return back();

    	}else{
    		$data['satuan']=$request->satuan;
    		$data['tipe_value']=$request->tipe_value;
    		$data['nilai']=$request->nilai;
    		$data['tahun_data']=$request->tahun_data;
    		$data['uraian']=$request->uraian;
    		$data['kode']=$meta_urusan['singkat'].'.KN.'.$request->kode;
    		$data['id_user']=Auth::id();
    		$data['tahun']=$tahun;
    		$data['id_urusan']=$meta_urusan['id_urusan'];
    		$data['created_at']=Carbon::now();
    		$data['updated_at']=Carbon::now();


    		DB::connection('form')->table('kb5_kondisi_saat_ini')->insert($data);
    		Alert::success('Success','Berhasil menambah data kondisi');
    		return back();

    	}



    }


    public function kondisi_create(){
    	$satuan=DB::table('master_satuan')->get()->pluck('kode');
    	return view('integrasi.kb5tahun.kondisi.create')->with('satuan',$satuan);
    }

    public function kondisi_view($id){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();
    	$kondisi=KONDISI::where([['id','=',$id],['id_urusan','=',$meta_urusan['id_urusan']]])->first();
    	$satuan=DB::table('master_satuan')->get()->pluck('kode');

    	return view('integrasi.kb5tahun.kondisi.update')->with(['kondisi'=>$kondisi,'satuan'=>$satuan]);

    }

    public function kondisi_form_delete($id){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();
    	$kondisi=KONDISI::where([['id','=',$id],['id_urusan','=',$meta_urusan['id_urusan']]])->first();

    	return view('integrasi.kb5tahun.kondisi.delete')->with(['kondisi'=>$kondisi]);

    }

    public function kondisi_delete($id){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();
    	$kondisi=KONDISI::where([['id','=',$id],['id_urusan','=',$meta_urusan['id_urusan']]])->first();
    	if($kondisi){
    		$kondisi->delete();
    		Alert::success('Success','Berhasil menghapus data kondisi');

    		return back();	

    	}else{
    		Alert::error('Error','Gagal menghapus data kondisi');

    		return back();	
    	}

    	

    }

      public function kondisi_update($id,Request $request){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();

    	if($request->tipe_value){
    		$valid=Validator::make($request->all(),[
    			'nilai'=>'numeric|required',
    			'kode'=>'string|required',
    			'satuan'=>'string|required',
    			'tipe_value'=>'numeric',
    			'uraian'=>'string|required',
    			'tahun_data'=>'numeric|min:'.(Hp::fokus_tahun()-5),
    		]);
    	}else{
    		$valid=Validator::make($request->all(),[
    			'nilai'=>'string|required',
    			'kode'=>'string|required',
    			'tipe_value'=>'numeric',
    			'satuan'=>'string|required',
    			'uraian'=>'string|required',
    			'tahun_data'=>'numeric|min:'.(Hp::fokus_tahun()-5),
    		]);
    	}


    	if($valid->fails()){
    		Alert::error('Error','');
    		dd($valid);
    		return back();

    	}else{
    		$data['satuan']=$request->satuan;
    		$data['tipe_value']=$request->tipe_value;
    		$data['nilai']=$request->nilai;
    		$data['tahun_data']=$request->tahun_data;
    		$data['uraian']=$request->uraian;
    		$data['kode']=$meta_urusan['singkat'].'.KN.'.$request->kode;
    		$data['id_user']=Auth::id();
    		$data['updated_at']=Carbon::now();

    		$old=(new KONDISI)::find($id);
    		


    		$dbv=DB::connection('form')->table('kb5_kondisi_saat_ini')->where('id',$id)->update($data);
    		
    		if($dbv){
    			if($dbv){
    			if($data['kode']!=$old['kode']){
					DB::connection('form')->table('kb5_indikator')->where('id_kondisi',$id)
					->update([
						'kode'=>DB::raw("concat('".$data['kode']."','.IND.',kode_realistic)")
					]);
    			}
    		}

    			Alert::success('Success','Berhasil update data kondisi');
    			return back();
    		}else{
    			Alert::error('Error','data kondisi tidak tersedia');
    			return back();
    		}
    		

    	}

    }

    public function isu_create($id){
    	$kondisi=DB::connection('form')->table('kb5_kondisi_saat_ini')->find($id);

    	if($kondisi){
    		return view('integrasi.kb5tahun.isu.create')->with('kondisi',(array)$kondisi);

    	}else{
    		return 'data tidak tersedia';
    	}

    }
     public function isu_store($id,Request $request){
    	$tahun=Hp::fokus_tahun();

    	$kondisi=DB::connection('form')->table('kb5_kondisi_saat_ini')->find($id);

    	if($kondisi){
    		$data=[];
    		$data['uraian']=$request->uraian;
    		$data['tahun']=$tahun;
    		$data['id_kondisi']=$id;
    		$data['id_user']=Auth::id();
    		$data['created_at']=Carbon::now();
    		$data['updated_at']=Carbon::now();

    		DB::connection('form')->table('kb5_isu_strategis')->insert($data);
    		Alert::success('Success','Berhasil menambah data isu strategis');
    		return back();


    	}else{
    		return abort('404');
    	}

    }


     public function isu_view($id){
    	$isu=DB::connection('form')->table('kb5_isu_strategis  as isu')
    	->leftjoin('kb5_kondisi_saat_ini as kondisi','kondisi.id','=','isu.id_kondisi')
    	->select(DB::RAW("isu.*, kondisi.uraian as uraian_kondisi"))
    	->where('isu.id',$id)->first();

    	if($isu){
    		return view('integrasi.kb5tahun.isu.update')->with('isu',(array)$isu);

    	}else{
    		return 'data tidak tersedia';
    	}

    }

    public function isu_update($id,Request $request){
    	$u=DB::connection('form')->table('kb5_isu_strategis')->where('id',$id)->update([
    		'uraian'=>$request->uraian
    	]);

    	if($u){
    		Alert::success('Success','Berhasil merubah data isu strategis');
    		return back();
    	}else{
    		Alert::error('Gagal','Gagal merubah data isu strategis');

    		return back();

    	}
    }

    public function isu_form_delete($id,Request $request){
	    	$isu=DB::connection('form')->table('kb5_isu_strategis  as isu')
	    	->leftjoin('kb5_kondisi_saat_ini as kondisi','kondisi.id','=','isu.id_kondisi')
	    	->select(DB::RAW("isu.*, kondisi.uraian as uraian_kondisi"))
	    	->where('isu.id',$id)->first();

	    	if($isu){
	    		return view('integrasi.kb5tahun.isu.delete')->with('isu',(array)$isu);

	    	}else{
	    		return 'data tidak tersedia';
	    	}
    }

     public function isu_delete($id,Request $request){
	    	$isu=DB::connection('form')->table('kb5_isu_strategis  as isu')
	    	->where('isu.id',$id)->delete();

	    	if($isu){
    			Alert::success('Success','Berhasil menghapus data isu strategis');

	    		return back();

	    	}else{
    			Alert::success('Gagal','Gagal menghapus data isu strategis');

	    		return back();
	    	}
    }


    public function ak_create($id){
    	$isu=DB::connection('form')->table('kb5_isu_strategis')->find($id);
    	if($isu){
    		return view('integrasi.kb5tahun.arah_kebijakan.create')->with('isu',(array)$isu);

    	}else{
    		return 'data tidak tersedia';
    	}

    }

    public function ak_view($id){
    	$ak=DB::connection('form')->table('kb5_arah_kebijakan  as ak')
    	->leftjoin('kb5_isu_strategis as isu','isu.id','=','ak.id_isu')
    	->select(DB::RAW("ak.*, isu.uraian as uraian_isu"))
    	->where('ak.id',$id)->first();

    	if($ak){
    		return view('integrasi.kb5tahun.arah_kebijakan.update')->with('ak',(array)$ak);

    	}else{
    		return 'data tidak tersedia';
    	}

    }
    
    public function ak_update($id,Request $request){
    	$u=DB::connection('form')->table('kb5_arah_kebijakan')->where('id',$id)->update([
    		'uraian'=>$request->uraian
    	]);

    	if($u){
    		Alert::success('Success','Berhasil merubah data arah kebijakan');
    		return back();
    	}else{
    		Alert::error('Gagal','Gagal merubah data arah kebijakan');

    		return back();

    	}
    }

    public function ak_form_delete($id,Request $request){
	    	$isu=DB::connection('form')->table('kb5_arah_kebijakan  as ak')
		    	->leftjoin('kb5_isu_strategis as isu','isu.id','=','ak.id_isu')
		    	->select(DB::RAW("ak.*, isu.uraian as uraian_isu"))
		    	->where('isu.id',$id)->first();
			    	if($isu){
	    		return view('integrasi.kb5tahun.arah_kebijakan.delete')->with('ak',(array)$isu);

	    	}else{
	    		return 'data tidak tersedia';
	    	}
    }

     public function ak_delete($id,Request $request){
	    	$isu=DB::connection('form')->table('kb5_arah_kebijakan  as ak')
	    	->where('ak.id',$id)->delete();

	    	if($isu){
    			Alert::success('Success','Berhasil menghapus data  arah kebijakan');

	    		return back();

	    	}else{
    			Alert::success('Gagal','Gagal menghapus data  arah kebijakan');

	    		return back();
	    	}
    }

    



     public function ak_store($id,Request $request){
    	$tahun=Hp::fokus_tahun();

    	$kondisi=DB::connection('form')->table('kb5_isu_strategis')->find($id);

    	if($kondisi){
    		$data=[];
    		$data['uraian']=$request->uraian;
    		$data['tahun']=$tahun;
    		$data['id_isu']=$id;
    		$data['id_user']=Auth::id();
    		$data['created_at']=Carbon::now();
    		$data['updated_at']=Carbon::now();

    		DB::connection('form')->table('kb5_arah_kebijakan')->insert($data);
    		Alert::success('Success','Berhasil menambah data arah kebijakan');
    		return back();


    	}else{
    		return abort('404');
    	}

    }

     public function indikator_create($id){

    	$ak_kondisi=DB::connection('form')->table('kb5_arah_kebijakan as ak')
    	->leftjoin('kb5_isu_strategis as isu','isu.id','=','ak.id_isu')
    	->leftjoin('kb5_sasaran as s','s.id_kebijakan','=','ak.id')
    	->leftjoin('kb5_kondisi_saat_ini as kondisi','kondisi.id','=','isu.id_kondisi')
    	->select(DB::RAW("s.*,kondisi.kode,kondisi.uraian as uraian_kondisi,kondisi.id as id_kondisi"))
    	->where('s.id',$id)->first();
    	$satuan=DB::table('master_satuan')->get()->pluck('kode');
    	$meta_urusan=Hp::fokus_urusan();


    	$sub_urusan=SUBURUSAN::where('id_urusan',$meta_urusan['id_urusan'])->get()->toArray();

    	if($ak_kondisi){
    		return view('integrasi.kb5tahun.indikator.create')->with(['ak_kondisi'=>(array)$ak_kondisi,'satuan'=>$satuan,'sub_urusan'=>$sub_urusan]);

    	}else{
    		return 'data tidak tersedia';
    	}
    	
    }

    public function indikator_view($id){
    	$ak_kondisi=DB::connection('form')->table('kb5_arah_kebijakan as ak')
    	->leftjoin('kb5_isu_strategis as isu','isu.id','=','ak.id_isu')
    	->leftjoin('kb5_kondisi_saat_ini as kondisi','kondisi.id','=','isu.id_kondisi')
    	->leftjoin('kb5_indikator as i','i.id_kebijakan','=','ak.id')
    	->select(DB::RAW("ak.*,kondisi.kode,kondisi.uraian as uraian_kondisi,kondisi.id as id_kondisi"))
    	->where('i.id',$id)->first();

    	$satuan=DB::table('master_satuan')->get()->pluck('kode');
    	$meta_urusan=Hp::fokus_urusan();
    	$indikator=INDIKATOR::where('id',$id)->with('_sub_urusan')->first();
    	$sub_urusan=SUBURUSAN::where('id_urusan',$meta_urusan['id_urusan'])->get()->toArray();
    	
    	if($ak_kondisi){
    		return view('integrasi.kb5tahun.indikator.update')->with(['ak_kondisi'=>(array)$ak_kondisi,'satuan'=>$satuan,'sub_urusan'=>$sub_urusan,'indikator'=>$indikator]);
    	}else{
    		return 'data tidak tersedia';
    	}

    }



     public function indikator_store($id,$id_kondisi=null,Request $request){
    	$tahun=Hp::fokus_tahun();
    	$ak_kondisi=(array)DB::connection('form')->table('kb5_arah_kebijakan as ak')
    	->leftjoin('kb5_isu_strategis as isu','isu.id','=','ak.id_isu')
    	->leftjoin('kb5_kondisi_saat_ini as kondisi','kondisi.id','=','isu.id_kondisi')
    	->leftjoin('kb5_sasaran as s','s.id_kebijakan','=','ak.id')
    	->select(DB::RAW("ak.*,kondisi.kode,kondisi.uraian as uraian_kondisi,kondisi.id as id_kondisi"))
    	->where('s.id',$id)
    	->where('kondisi.id',$id_kondisi)
    	->first();

    	if($ak_kondisi){
    		$data=[];
    		$data['uraian']=$request->uraian;
    		$data['kode_realistic']=$request->kode;
    		$data['kode']=$ak_kondisi['kode'].'.IND.'.$request->kode;
    		$data['tahun']=$tahun;
    		$data['id_kebijakan']=$ak_kondisi['id'];
    		$data['id_sasaran']=$id;
    		$data['id_kondisi']=$id_kondisi;
    		$data['tipe_value']=$request->tipe_value;
    		$data['target']=$request->target;
    		$data['target_1']=$request->tipe_value==2?($request->target_1?(float)$request->target_1:null):null;
    		$data['satuan']=$request->satuan;
    		$data['lokus']=$request->lokus;
    		$data['kw_nas']=$request->kw_nas=='on'?true:false;
    		$data['kw_p']=$request->kw_p=='on'?true:false;
    		$data['kw_k']=$request->kw_k=='on'?true:false;
    		$data['id_sub_urusan']=$request->id_sub_urusan;
    		$data['data_dukung_nas']=$data['kw_nas']?($request->data_dukung_nas):null;
    		$data['data_dukung_p']=$data['kw_p']?($request->data_dukung_p):null;
    		$data['data_dukung_k']=$data['kw_k']?($request->data_dukung_k):null;
    		$data['keterangan']=$request->keterangan;
    		$data['pelaksana']=strtoupper($request->pelaksana);

    		$data['id_user']=Auth::id();
    		$data['created_at']=Carbon::now();
    		$data['updated_at']=Carbon::now();


    		DB::connection('form')->table('kb5_indikator')->insert($data);
    		Alert::success('Success','Berhasil menambah data indikator');
    		return back();


    	}else{
    		return abort('404');
    	}

    }

    public function indikator_update($id,Request $request){
    		$indikator=INDIKATOR::where('id',$id)->with('_kondisi')->first();
    		if($indikator){

	    		$data['uraian']=$request->uraian;
	    		$data['kode_realistic']=$request->kode;
	    		$data['kode']=$indikator['_kondisi']['kode'].'.IND.'.$request->kode;
	    		$data['tipe_value']=$request->tipe_value;
	    		$data['target']=$request->target;
	    		$data['target_1']=$request->tipe_value==2?($request->target_1?(float)$request->target_1:null):null;
	    		$data['satuan']=$request->satuan;
	    		$data['kw_nas']=$request->kw_nas=='on'?true:false;
	    		$data['kw_p']=$request->kw_p=='on'?true:false;
	    		$data['kw_k']=$request->kw_k=='on'?true:false;
	    		$data['id_sub_urusan']=$request->id_sub_urusan;
    			$data['lokus']=$request->lokus;
	    		$data['data_dukung_nas']=$data['kw_nas']?($request->data_dukung_nas):null;
	    		$data['data_dukung_p']=$data['kw_p']?($request->data_dukung_p):null;
	    		$data['data_dukung_k']=$data['kw_k']?($request->data_dukung_k):null;
	    		$data['keterangan']=$request->keterangan;
	    		$data['pelaksana']=strtoupper($request->pelaksana);
	    		$data['updated_at']=Carbon::now();

    			$indikator->update($data);
    			Alert::success('Success','Berhasil merubah data indikator');

    			return back();

    		}else{

    			Alert::error('Gagal','Gagal merubah data indikator');

    			return back();


    		}

    }

    public function indikator_form_delete($id){
    		$indikator=INDIKATOR::where('id',$id)->with('_kondisi')->first();
    		if($indikator){
    			return view('integrasi.kb5tahun.indikator.delete')->with('indikator',$indikator);
    		}else{
    			return 'data tidak tersedia';
    		}

    }

       public function indikator_delete($id){

    		$indikator=INDIKATOR::where('id',$id)->first();
    		if($indikator){
    			$indikator->delete();
    			Alert::success('Success','Berhasil menghapus data indikator');


    			return back();

    		}else{

    			Alert::error('Gagal','Gagal menghapus data indikator');

    			return back();
    		}

    }

    public function indikator_detail($id){
		$indikator=INDIKATOR::where('id',$id)->orWhere('kode_realistic',$id)->orWhere('kode')
		->with(
			'_sub_urusan',
			'_sasaran',
			'_kebijakan._isu',
			'_kondisi._urusan'
		)->first();


		if($indikator){
			return view('integrasi.kb5tahun.indikator.detail')->with('i',$indikator);
		}else{
			return 'data tidak tersedia';
		}
    }

    public function sasaran_create($id){
    	$kebijakan=DB::connection('form')->table('kb5_arah_kebijakan')->find($id);
    	if($kebijakan){
    		return view('integrasi.kb5tahun.sasaran.create')->with('kebijakan',(array)$kebijakan);

    	}else{
    		return 'data tidak tersedia';
    	}

    }

    public function sasaran_view($id){
    	$sasaran=DB::connection('form')->table('kb5_arah_kebijakan  as ak')
    	->leftjoin('kb5_sasaran as s','s.id_kebijakan','=','ak.id')
    	->select(DB::RAW("s.*, s.uraian as uraian_s"))
    	->where('s.id',$id)->first();

    	if($sasaran){
    		return view('integrasi.kb5tahun.sasaran.update')->with('sasaran',(array)$sasaran);

    	}else{
    		return 'data tidak tersedia';
    	}

    }
    
    public function sasaran_update($id,Request $request){
    	$u=DB::connection('form')->table('kb5_sasaran')->where('id',$id)->update([
    		'uraian'=>$request->uraian
    	]);

    	if($u){
    		Alert::success('Success','Berhasil merubah data asasaran');
    		return back();
    	}else{
    		Alert::error('Gagal','Gagal merubah data sasaran');

    		return back();

    	}
    }

    public function sasaran_form_delete($id,Request $request){
	    	$sasaran=DB::connection('form')->table('kb5_arah_kebijakan  as ak')
    	->leftjoin('kb5_sasaran as s','s.id_kebijakan','=','ak.id')
    	->select(DB::RAW("s.*, s.uraian as uraian_s"))
    	->where('s.id',$id)->first();


			if($sasaran){
	    		return view('integrasi.kb5tahun.sasaran.delete')->with('sasaran',(array)$sasaran);

	    	}else{
	    		return 'data tidak tersedia';
	    	}
    }

     public function sasaran_delete($id,Request $request){
	    	$isu=DB::connection('form')->table('kb5_sasaran  as s')
	    	->where('s.id',$id)->delete();

	    	if($isu){
    			Alert::success('Success','Berhasil menghapus data  sasaran');

	    		return back();

	    	}else{
    			Alert::success('Gagal','Gagal menghapus data sasaran');

	    		return back();
	    	}
    }

     public function sasaran_store($id,Request $request){
    	$tahun=Hp::fokus_tahun();

    	$kondisi=DB::connection('form')->table('kb5_arah_kebijakan')->find($id);

    	if($kondisi){
    		$data=[];
    		$data['uraian']=$request->uraian;
    		$data['tahun']=$tahun;
    		$data['id_kebijakan']=$id;
    		$data['id_user']=Auth::id();
    		$data['created_at']=Carbon::now();
    		$data['updated_at']=Carbon::now();

    		DB::connection('form')->table('kb5_sasaran')->insert($data);
    		Alert::success('Success','Berhasil menambah data sasaran');
    		return back();


    	}else{
    		return abort('404');
    	}

    }


}
