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
use App\MASTER\KEWENANGAN;
use App\MASTER\INDIKATOR;
class PELAKSANAANURUSAN extends Controller
{
    //


    public function form_update($id){
        $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();
        $data=KEWENANGAN::with('_sub_urusan')->where('id',$id)->first();

        if($data){

            $sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get();
        
            return view('integrasi.pelaksanaan.update')->with(
                [
                    'data'=>$data,
                    'sub_urusan'=>$sub_urusan
                ]
            );

        }



    }

     public function form_delete_indikator($id){
        $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();
        $data=INDIKATOR::where('id',$id)->first();
        if($data){
            return view('integrasi.pelaksanaan.delete_indikator')->with(
                [
                    'data'=>$data,
                ]
            );

        }

    }


     public function delete_indikator($id){
        $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();
        $data=INDIKATOR::where('id',$id)->first();
        if($data){
            $data->id_kewenangan=null;
            $data->update();

            Alert::success('Success','Berhasil Mengapus Indikator dari Kewenangan');
            return back();

        }

    }


    public function form_delete($id){
        $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();
        $data=KEWENANGAN::with('_sub_urusan')->where('id',$id)->first();

        if($data){
            $data['uraian']='';
            return view('integrasi.pelaksanaan.delete')->with(
                [
                    'data'=>$data,
                ]
            );

        }



    }

    public function create_kewenangan(){
        $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();
        $sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get();
    
        return view('integrasi.pelaksanaan.create')->with([
            'sub_urusan'=>$sub_urusan
        ]);
    }


    public function store_kewenangan(Request $request){
         $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();
        $data=[];

        $data['id_sub_urusan']=$request->id_sub_urusan;
        $data['kewenangan_nas']=$request->kw_nas;
        $data['kewenangan_p']=$request->kw_p;
        $data['kewenangan_k']=$request->kw_k;
        $data['tahun']=$tahun;
        $data['id_user']=Auth::id();
        $data['created_at']=Carbon::now();
        $data['updated_at']=Carbon::now();

        $data=KEWENANGAN::create($data);

        if($data){
            Alert::success('Success','Berhasil Menambahkan kewenangan');
            return back();
        }
    }

    public function index(){
    	$meta_urusan=Hp::fokus_urusan();
    	$tahun=Hp::fokus_tahun();
        $sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

        $data=KEWENANGAN::whereIn('id_sub_urusan',$sub_urusan)->with('_sub_urusan','_indikator')->orderBy('id_sub_urusan','ASC')->get();
    	return view('integrasi.pelaksanaan.index')->with('data',$data);
    }


    public function create($id){
        $meta_urusan=Hp::fokus_urusan();
        $tahun=Hp::fokus_tahun();
        $satuan=DB::table('master_satuan')->get()->pluck('kode');
        $sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get();

        $data=KEWENANGAN::find($id);
        if($data){
            return view('integrasi.kb1tahun.pn.indikator')
            ->with([
                'sub_urusan'=>($sub_urusan),
                'meta_urusan'=>$meta_urusan,
                'satuan'=>$satuan,
                'tag'=>3,
                'jenis'=>'KEWENANGAN',
                'rkp'=>['uraian'=>'PADA SUB URUSAN <span class="text-success">'.$data->_sub_urusan->nama.'</span>'],
                'route_add'=>route('int.pelurusan.store_indikator',['id'=>$data->id]),
                'data'=>[],
                'only_sub_urusan'=>$data->id_sub_urusan,
                'for_kewenangan'=>true
            ])->render();
        }
        
    }

    public function store_indikator($id,Request $request){
            $meta_urusan=Hp::fokus_urusan();
            $tahun=Hp::fokus_tahun();
            $data=[];
            $k=KEWENANGAN::find($id);

            if($k){
                $indikator=$request->id_indikator?$request->id_indikator:[];
                foreach ($indikator as $key => $i) {
                    $ind=INDIKATOR::where('id',$i)->first();
                    if($ind){
                        if($ind->id_kewenangan==null){
                            $ind->id_kewenangan=$k->id;
                            $ind->update();
                        }else{

                        }
                    }

                }

                Alert::success('Success','Berhasil Menambahkan indikator');
                return back();

            }


           


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
            $k=KEWENANGAN::find($id);

            if($k){
                $k->kewenangan_nas=$request->kewenangan_nas;
                $k->kewenangan_p=$request->kewenangan_p;
                $k->kewenangan_k=$request->kewenangan_k;
                $k->update();
                Alert::success('Success','Berhasil Mengupdate kewenangan');
                return back();
            }




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
            $data=KEWENANGAN::where('id',$id)->delete();
            if($data){
                Alert::success('Success','Berhasil Menghapus Kewenangan');
                return back();
            }


         

    }

}
