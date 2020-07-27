<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use Alert;
use Auth;
use App\RKP\RKP;
use Validator;
use App\KB5\INDIKATOR;
use App\RKP\RKPINDIKATOR;
use Carbon\Carbon;
class KEBIJAKANPUSAT1TAHUN extends Controller
{
    //

    static function indikator_form_delete($id){

        $data=RKPINDIKATOR::with('_indikator')->find($id);

        if($data){
            return view('integrasi.kb1tahun.pn.form_delete_indikator')->with('data',$data);
        }else{
            return 'data not found';
        }

    }

    public function indikator_delete($id){
        $data=RKPINDIKATOR::where('id',$id)->delete();
        if($data){
            Alert::success('Success','Berhasil Menghapus Indikator');
            return back();
        }
    }


    static function namaRKP($kode){
        $jenis='';
        switch ((int)$kode) {
            case 1:
                # code...
             $jenis='PN';
                break;
             case 2:
                # code...
             $jenis='PP';
                break;
             case 3:
                # code...
             $jenis='KP';
                break;
             case 4:
                # code...
             $jenis='PROPN';
                break;
              case 5:
                # code...
             $jenis='PROYEK';
                break;
            default:
                # code...
                break;
        }
        return $jenis;
    }



    public function index(){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['jenis'=>1,'tahun'=>$tahun])->with(['_tag_indikator._indikator','_child_pp._child_kp._child_propn._child_proyek'])->get();
    	return view('integrasi.kb1tahun.index')->with('data',$data);
    }


     public function pn_create(){
    	return view('integrasi.kb1tahun.pn.create');
    }

    public function pn_store(Request $request){
    	$tahun=Hp::fokus_tahun();

    	$valid=Validator::make($request->all(),[
    		'uraian'=>'required|string'
    	]);


    	if($valid->fails()){
    		Alert::error('Error');
    		return back();
    	}

    	$data=RKP::create([
    		'uraian'=>$request->uraian,
    		'jenis'=>1,
    		'tahun'=>$tahun,
    		'id_user'=>Auth::User()->id
    	]);

    	if($data){
    		Alert::success('Success','Berhasil Menambahkan PN');
    		return back();
    	}

    }


    public function pn_view($id){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();
        $jenis=static::namaRKP($data['jenis']);
    	
        if($data){
    		return view('integrasi.kb1tahun.pn.update')->with(['data'=>$data,'jenis'=>$jenis]);
    	}

    }

    public function pn_update($id,Request $request){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();
         $jenis=static::namaRKP($data['jenis']);
    	if($data){
    		$pn=RKP::find($id)->update([
    			'uraian'=>$request->uraian
    		]);

    		if($pn){
    			
    			Alert::success('Success','Berhasil Mengubah '.$jenis);
    			return back();
    		}

    	}

    }

     public function pn_form_delete($id,Request $request){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();
        $jenis=static::namaRKP($data['jenis']);
    	if($data){
	    	return view('integrasi.kb1tahun.pn.form_delete')->with(['data'=>$data,'jenis'=>$jenis]);	


    	}

    }

    public function pn_delete($id){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();
        $jenis=static::namaRKP($data['jenis']);
        $data=RKP::where(['tahun'=>$tahun,'id'=>$id])->delete();
    	if($data){
    		Alert::success('Success','Berhasil menghapus data '.$jenis);
    		return back();
	   }else{
	   		Alert::error('Gagal','Gagal menghapus data '.$jenis);
    		return back();
	   }
    }

     public function pn_indikator($id){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();

    	$id_sub=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();
        $jenis=static::namaRKP($data['jenis']);

    	if($data){
    		$indikator=INDIKATOR::where('tahun',$tahun)->whereIn('id_sub_urusan',$id_sub)->get();
    		return view('integrasi.kb1tahun.pn.indikator')->with(['data'=>$indikator,'rkp'=>$data,'jenis'=>$jenis])->render();
	   }else{
	   		return 'data tidak tersedia';
	   }
    }

    public function store_indikator($id,Request $request){
    	$tahun=Hp::fokus_tahun();
    	$uid=Auth::id();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();
    	if($data){
    		if($request->id_indikator){
    			foreach ($request->id_indikator as $key => $i) {
	    			if(!(RKPINDIKATOR::where(['id_rkp'=>$data->id,'id_indikator'=>$i])->first())){
	    				RKPINDIKATOR::create(['id_rkp'=>$data->id,'id_indikator'=>$i,'jenis'=>$data->jenis,'id_user'=>$uid]);
	    			}
	    			# code...
	    		}

	    		Alert::success('Success','Berhasil Menambahkan Indikator');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menambahkan Indikator');
	    		return back();

    		}
    	}

    }


    public function nested_create($id){

        $data=RKP::where(['id'=>$id])->first();
        $jenis_kode=$data->jenis;
        $jenis=static::namaRKP($jenis_kode+1);

        return view('integrasi.kb1tahun.pn.form_nested')->with(['data'=>$data,'id'=>$id,'jenis'=>$jenis,'jenis_kode'=>$jenis_kode]);
    }

    public function nested_store($id,$jenis,Request $request){
        $tahun=Hp::fokus_tahun();

        $data=RKP::where(['id'=>$id])->first()->toArray();
        $jenis_kode=(int)$data['jenis'];
        $data_create=[
            'uraian'=>$request->uraian,
            'jenis'=>(int)$jenis,
            'id_pn'=>$data['id_pn'],
            'id_pp'=>$data['id_pp'],
            'id_kp'=>$data['id_kp'],
            'tahun'=>(int)$tahun,
            'id_propn'=>$data['id_propn'],
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'id_user'=>Auth::User()->id
        ];
        $data_create['id_'.strtolower(static::namaRKP($jenis_kode))]=$data['id'];

        DB::connection('rkp')->table('rkp.master_rkp')->insert([$data_create]);
        $nama=static::namaRKP($jenis);
        Alert::success('Success','Success Menambahkan '.$nama);
        return back();


    }
}
