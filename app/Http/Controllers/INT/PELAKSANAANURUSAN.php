<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\KB5\KONDISI;
use Hp;
use DB;
use Carbon\Carbon;
use Alert;
class PELAKSANAANURUSAN extends Controller
{
    //

    public function index(){
    	$meta_urusan=Hp::fokus_urusan();
    	$tahun=Hp::fokus_tahun();
    	$id_sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

    	$data=DB::connection('form')->table('form.master_indikator as i')
    	->leftJoin('public.master_sub_urusan as su','su.id','=','i.id_sub_urusan')
    	->whereIn('i.id_sub_urusan',$id_sub_urusan)
    	->where('tahun',$tahun)
    	->select(DB::raw("i.*,su.nama as nama_sub_urusan"))
    	->orderBy('i.id_sub_urusan','asc')
    	->get()->toArray();


    	return view('integrasi.pelaksanaan.index')->with('data',$data);
    }


    public function create(){
        $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();
        $satuan=DB::table('master_satuan')->get()->pluck('kode');
        $sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get();

        return view('integrasi.indikator.create')->with(['sub_urusan'=>($sub_urusan),'meta_urusan'=>$meta_urusan,'satuan'=>$satuan])->render();
    }

    public function store_indikator(Request $request){
            $meta_urusan=Hp::fokus_urusan();
            $tahun=Hp::fokus_tahun();
            $data=[];
            $data['uraian']=$request->uraian;
            $data['kode_realistic']=$request->kode;
            $data['kode']=$meta_urusan['singkat'].'.IND.'.$request->kode;
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


            $data=DB::connection('form')->table('form.master_indikator')->insert($data);
            if($data){
                Alert::success('Success','Berhasil Menambahkan indikator');
            }
            return back();


    }

    public function view($id){
        $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();

        $id_sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

        $data=(array)DB::connection('form')->table('form.master_indikator as i')
        ->leftJoin('public.master_sub_urusan as su','su.id','=','i.id_sub_urusan')
        ->whereIn('i.id_sub_urusan',$id_sub_urusan)
        ->where('tahun',$tahun)
        ->select(DB::raw("i.*,su.nama as nama_sub_urusan"))
        ->orderBy('i.id_sub_urusan','asc')
        ->where('i.id',$id)
        ->whereIn('id_sub_urusan',$id_sub_urusan)
        ->first();
        
       

        if($data){
             $satuan=DB::table('master_satuan')->get()->pluck('kode');
            $sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get();
             return view('integrasi.indikator.show')->with(['sub_urusan'=>($sub_urusan),'meta_urusan'=>$meta_urusan,'satuan'=>$satuan,'data'=>$data])->render();
         }else{
            return 'data tidak tersedia';
         }




    }

    public function update($id,Request $request){

            $meta_urusan=Hp::fokus_urusan();
            $tahun=Hp::fokus_tahun();



            $id_sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

            $in=(array)DB::connection('form')->table('form.master_indikator as i')
            ->leftJoin('public.master_sub_urusan as su','su.id','=','i.id_sub_urusan')
            ->whereIn('i.id_sub_urusan',$id_sub_urusan)
            ->where('tahun',$tahun)
            ->select(DB::raw("i.*,su.nama as nama_sub_urusan"))
            ->orderBy('i.id_sub_urusan','asc')
            ->where('i.id',$id)
            ->whereIn('id_sub_urusan',$id_sub_urusan)
            ->first();
            
           

            if($in){

            $data=[];
            $data['uraian']=$request->uraian;
            $data['kode_realistic']=$request->kode;
            $data['kode']=$meta_urusan['singkat'].'.IND.'.$request->kode;
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
                $data=DB::connection('form')->table('form.master_indikator')
                ->where('id',$id)->update($data);

                Alert::success('Success','Berhasil Mengupdate indikator');

            }

            return back();



    }


    public function show_form_delete($id){

            $meta_urusan=Hp::fokus_urusan();
            $tahun=Hp::fokus_tahun();



            $id_sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

            $in=(array)DB::connection('form')->table('form.master_indikator as i')
            ->leftJoin('public.master_sub_urusan as su','su.id','=','i.id_sub_urusan')
            ->whereIn('i.id_sub_urusan',$id_sub_urusan)
            ->where('tahun',$tahun)
            ->select(DB::raw("i.*,su.nama as nama_sub_urusan"))
            ->orderBy('i.id_sub_urusan','asc')
            ->where('i.id',$id)
            ->whereIn('id_sub_urusan',$id_sub_urusan)
            ->first();

            if($in){
                return view('integrasi.indikator.delete')->with('data',$in);
            }
            
    }


    public function delete($id){

         $meta_urusan=Hp::fokus_urusan();
            $tahun=Hp::fokus_tahun();



            $id_sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

            $in=(array)DB::connection('form')->table('form.master_indikator as i')
            ->leftJoin('public.master_sub_urusan as su','su.id','=','i.id_sub_urusan')
            ->whereIn('i.id_sub_urusan',$id_sub_urusan)
            ->where('tahun',$tahun)
            ->select(DB::raw("i.*,su.nama as nama_sub_urusan"))
            ->orderBy('i.id_sub_urusan','asc')
            ->where('i.id',$id)
            ->whereIn('id_sub_urusan',$id_sub_urusan)
            ->first();


            if($in){
                $in=DB::connection('form')->table('form.master_indikator as i')->where('id',$id)->delete();

                if($in){
                    Alert::success('Success','Berhasil Melakukan Pengahapusan Indikator');
                }
            }


            return back();

    }

}
