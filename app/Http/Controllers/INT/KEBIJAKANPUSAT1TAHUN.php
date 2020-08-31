<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use Alert;
use Auth;
use Validator;
use App\KB5\INDIKATOR;
use App\RKP\RKPINDIKATOR;
use Carbon\Carbon;
use App\MASTER\SUBURUSAN;
use App\RKP\RKP;
class KEBIJAKANPUSAT1TAHUN extends Controller
{
    //

    public function download(Request $request){
        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
        $rpjmn=HP::get_tahun_rpjmn();
        $title='KEBIJAKAN PUSAT '.$meta_urusan['nama'].' TAHUN '.$tahun;

        $sub_title='KEBIJAKAN PUSAT TAHUNAN';

        $data=RKP::where(['jenis'=>1,'tahun'=>$tahun,'id_urusan'=>$meta_urusan['id_urusan']])->with(['_tag_indikator._indikator','_child_pp._child_kp._child_propn._child_proyek'])->get();


        if($request->pdf){
             $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape')->setOptions(['dpi' => 200, 'defaultFont' => 'sans-serif','isRemoteEnabled' => true]);
                $pdf->loadHTML(view('integrasi.kb1tahun.download')->with(['data'=>$data,
                    'title'=>$title,'sub_title'=>$sub_title])->render());
                return $pdf->stream();
        }
    }

    public function store_indikator_rkp(Request $request){
        $rkp=RKP::find($request->id_rkp);
        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();

        if($rkp){
            $data=[];
            $data['tag']=2;
            $data['uraian']=$request->uraian;
            $data['kode_realistic']=$request->kode;
            $data['kode']=$request->pre_ind.$request->kode;
            $data['tahun']=$tahun;
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
            $data['pelaksana_nas']=$data['kw_nas']?json_encode($request->pelaksana_nas?$request->pelaksana_nas:[]):'[]';
            $data['pelaksana_p']=$data['kw_p']?json_encode($request->pelaksana_p?$request->pelaksana_p:[]):'[]';
            $data['pelaksana_k']=$data['kw_k']?json_encode($request->pelaksana_k?$request->pelaksana_p:[]):'[]';
            $data['kewenangan_nas']=$data['kw_nas']?($request->kewenangan_nas):null;
            $data['kewenangan_p']=$data['kw_p']?($request->kewenangan_p):null;
            $data['kewenangan_k']=$data['kw_k']?($request->kewenangan_k):null;
            $data['id_user']=Auth::id();
            $data['created_at']=Carbon::now();
            $data['updated_at']=Carbon::now();

            $ind=INDIKATOR::create($data);
            $ind->kode_realistic=$ind->id;
            $ind->kode=Hp::pre_ind($ind->tag).$ind->id;
            $ind->update();


            if($ind){

                $ind=INDIKATOR::where('id',$ind->id)->with('_sub_urusan')->first();
                $ind['_sumber']=$ind->_sumber();
                 Hp::satuanCreateOrignore($data['satuan']);

                return array(
                    'kode'=>200,
                    'data'=>$ind,
                    'message'=>'Indikator Berhasil di Tambahkan'
                );
            }

        }else{
            return array(
                'kode'=>500,
                'message'=>'data tidak ditemukan'
            );
        }

    }

 

    static function indikator_form_delete($id){

        $data=RKPINDIKATOR::with('_indikator')->find($id);

        if($data){
            return view('integrasi.kb1tahun.pn.form_delete_indikator')->with('data',$data);
        }else{
            return 'data not found';
        }

    }

    public function indikator_delete($id){
        $data=RKPINDIKATOR::where('id',$id)->first()->toArray();
        $id_indikator=$data['id_indikator'];
        $data=RKPINDIKATOR::where('id',$id)->delete();
        if($data){
            // \App\INTEGRASI\REKOMENDASI_IND::where('id_indikator',$id_indikator)->delete();
            // \App\INTEGRASI\REKOMENDASIKAB_IND::where('id_indikator',$id_indikator)->delete();

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
        $meta_urusan=Hp::fokus_urusan();
    	$data=RKP::where(['jenis'=>1,'tahun'=>$tahun,'id_urusan'=>$meta_urusan['id_urusan']])->with(['_tag_indikator._indikator','_child_pp._child_kp._child_propn._child_proyek'])->get();
        
    	return view('integrasi.kb1tahun.index')->with('data',$data);
    }


     public function pn_create(){
    	return view('integrasi.kb1tahun.pn.create');
    }

    public function pn_store(Request $request){
    	$tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();

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
            'id_urusan'=>$meta_urusan['id_urusan'],
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
            $for_pp=false;
            $for_pp_child=false;


            if($jenis=='PP'){
                $for_pp=true;
            }else{
                $for_pp_child=true;
            }
            $satuan=DB::table('master_satuan')->get()->pluck('kode');
            $sub_urusan=SUBURUSAN::where('id_urusan',$meta_urusan['id_urusan'])->get()->toArray();
            $ret=[
                'data'=>[],
                'rkp'=>$data,
                'jenis'=>$jenis,
                'satuan'=>$satuan,
                'sub_urusan'=>$sub_urusan,
                'meta_urusan'=>$meta_urusan,
                'tag'=>2];

            if($for_pp){
                $ret['for_pp']=true;
            }

            if($for_pp_child){
                $ret['for_pp_child']=true;
            }

    		return view('integrasi.kb1tahun.pn.indikator')
            ->with($ret)->render();

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
            'id_urusan'=>$data['id_urusan'],
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
