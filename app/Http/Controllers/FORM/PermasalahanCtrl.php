<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Hp;
use Validator;
use Alert;
class PermasalahanCtrl extends Controller
{
    //

    public function index(Request $request){
        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();

    	$provinsi=DB::table('public.master_daerah as d')
       
        ->selectRaw("
            (case when (length(d.id)<3) then d.nama else concat(d.nama,' - ',(select p.nama from public.master_daerah as p where p.id=d.kode_daerah_parent limit 1)) end) as nama,
            d.id,
            (select count(msp.id) from public.ms_pokok as msp where msp.kode_daerah=d.id and msp.tahun=".$tahun." and msp.id_urusan=".$meta_urusan['id_urusan']." ) as ms_exists
            
        ")
    	->orderBy('d.id','ASC')->get();


    	return view('form.permasalahan.index',['daerah'=>$provinsi]);
    }


    // ------------------------------------------------------------------------


    public function api_get_table_kota(Request $request){

    	$return =[];
    	if($request->id){
			$return =DB::table('master_daerah')->where('id','ilike',DB::raw("'".$request->id."' "."||'%'"))
			->orderBy('id','ASC')->orderBy('nama','ASC')
			->get();    		
    	}

    	return view('form.permasalahan.daerah.api.table_kota')->with('daerahs',$return)->render();

    }


    public function view_daerah($id){
        $daerah=DB::table('master_daerah')->find($id);

        $data=DB::table('ms_pokok as pk')
        ->leftJoin('ms','ms.id_ms_pokok','=','pk.id')
        ->leftJoin('ms_akar as ak','ak.id_ms','=','ms.id')
        ->leftJoin('ms_data_dukung as dt','dt.id_ms_akar','=','ak.id')
        ->select(
            'pk.id as id_pokok',
            'pk.uraian as pokok_uraian',
            'ms.id as id_ms',
            'ms.uraian as ms_uraian',
            'ak.id as id_akar',
            'ak.uraian as akar_uraian',
            'dt.id as id_data',
            'dt.uraian as data_uraian'
        )
        ->where('pk.kode_daerah',$id)
        ->where('pk.tahun',Hp::fokus_tahun())
        ->where('pk.id_urusan',Hp::fokus_urusan()['id_urusan'])


        ->orderBy('pk.id','desc')
        ->orderBy('ms.id','desc')
        ->orderBy('ak.id','desc')
        ->orderBy('dt.id','desc')
        ->paginate(15);




        return view('form.permasalahan.daerah.view')->with([
            'daerah'=>$daerah,
            'data'=>$data,
            'back_link'=>route('permasalahan.index')
        ]);
    }


    public function store_masalah_pokok($id,Request $request){
        $uid=Auth::id();
        $daerah=DB::table('master_daerah')->find($id);
        $valid=Validator::make($request->all(),[
            'uraian'=>'string|required'
        ]);

        if($valid->fails()){
              Alert::error('','Masalah  Pokok Tidak Dapat ditambahkan');

            return back();
        }

        if($daerah){
            $data=DB::table('ms_pokok')->insertGetId([
                'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
                'tahun'=>Hp::fokus_tahun(),
                'kode_daerah'=>$id,
                'uraian'=>strtoupper($request->uraian),
                'id_user'=>$uid,
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            ]);

            if($data){
                Alert::success('','Masalah Pokok ditambahkan');
                return back();
            }else{
                  Alert::error('','Masalah  Pokok Tidak Dapat ditambahkan');
                return back();
            }

        }else{
              Alert::error('','Masalah  Pokok Tidak Dapat ditambahkan');
            return back();
        }

    }

    public function update_masalah_pokok($kodepemda,$id,Request $request){
        $data=DB::table('ms_pokok')->where('id',$id)->update([
            'uraian'=>strtoupper($request->uraian)
        ]);
        if($data){
                Alert::success('Success','Berhasl Update Masalah Pokok');

        }

        return back();
    }

     public function update_masalah($kodepemda,$id,Request $request){
        $data=DB::table('ms')->where('id',$id)->update([
            'uraian'=>strtoupper($request->uraian)
        ]);
        if($data){
                Alert::success('Success','Berhasl Update Masalah');

        }

        return back();
    }

      public function update_akar_masalah($kodepemda,$id,Request $request){
        $data=DB::table('ms_akar')->where('id',$id)->update([
            'uraian'=>strtoupper($request->uraian)
        ]);
        if($data){
                Alert::success('Success','Berhasl Update Akar Masalah');

        }

        return back();
    }

     public function update_data_dukung($kodepemda,$id,Request $request){
        $data=DB::table('ms_data_dukung')->where('id',$id)->update([
            'uraian'=>strtoupper($request->uraian)
        ]);
        if($data){
                Alert::success('Success','Berhasl Update Data Dukung');

        }

        return back();
    }

    public function delete_masalah_pokok($kodepemda,$id,Request $request){
        $data=DB::table('ms_pokok')->where('id',$id)->delete();
        if($data){
                Alert::success('Success','Berhasl Hapus Masalah Pokok');

        }

        return back();
    }

    public function delete_masalah($kodepemda,$id,Request $request){
        $data=DB::table('ms')->where('id',$id)->delete();
        if($data){
                Alert::success('Success','Berhasl Hapus Masalah');

        }

        return back();
    }

      public function delete_akar_masalah($kodepemda,$id,Request $request){
        $data=DB::table('ms_akar')->where('id',$id)->delete();
        if($data){
                Alert::success('Success','Berhasl Hapus Akar Masalah');

        }

        return back();
    }

     public function delete_data_dukung($kodepemda,$id,Request $request){
        $data=DB::table('ms_data_dukung')->where('id',$id)->delete();
        if($data){
                Alert::success('Success','Berhasl Hapus Data Dukung');

        }

        return back();
    }


     public function store_masalah($id,$id_pokok,Request $request){
        $uid=Auth::id();
        $daerah=DB::table('master_daerah')->find($id);
        $pokok=DB::table('ms_pokok')->find($id_pokok);

        $valid=Validator::make($request->all(),[
            'uraian'=>'string|required'
        ]);

        if($valid->fails()){
              Alert::error('','Masalah  Tidak Dapat Ditambahkan');

            return back();
        }

        if((!empty($daerah))&&(!empty($pokok))){
            $data=DB::table('ms')->insertGetId([
                'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
                'tahun'=>Hp::fokus_tahun(),
                'id_ms_pokok'=>$pokok->id,
                'kode_daerah'=>$id,
                'uraian'=>strtoupper($request->uraian),
                'id_user'=>$uid,
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            ]);

            if($data){
                Alert::success('','Masalah  Ditambahkan');
                return back();
            }else{
                  Alert::error('','Masalah   Tidak Dapat Ditambahkan');
                return back();
            }

        }else{
              Alert::error('','Masalah  Tidak Dapat Ditambahkan');
            return back();
        }

    }


     public function store_akar_masalah($id,$id_pokok,$id_msalah,Request $request){
        $uid=Auth::id();
        $daerah=DB::table('master_daerah')->find($id);
        $pokok=DB::table('ms_pokok')->find($id_pokok);
        $masalah=DB::table('ms')->find($id_msalah);


        $valid=Validator::make($request->all(),[
            'uraian'=>'string|required'
        ]);

        if($valid->fails()){
              Alert::error('','Akar Masalah   Tidak Dapat Ditambahkan');

            return back();
        }

        if(((!empty($daerah))&&(!empty($pokok)))&&(!empty($masalah))){
            $data=DB::table('ms_akar')->insertGetId([
                'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
                'tahun'=>Hp::fokus_tahun(),
                'id_ms_pokok'=>$pokok->id,
                'id_ms'=>$masalah->id,
                'kode_daerah'=>$id,
                'uraian'=>strtoupper($request->uraian),
                'id_user'=>$uid,
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            ]);

            if($data){
                Alert::success('','Akar Masalah  Ditambahkan');
                return back();
            }else{
                  Alert::error('','Akar Masalah    Tidak Dapat Ditambahkan');
                return back();
            }

        }else{
              Alert::error('','Akar Masalah   Tidak Dapat Ditambahkan');
            return back();
        }

    }


    public function store_data_sukung($id,$id_pokok,$id_msalah,$id_akar,Request $request){
        $uid=Auth::id();
        $daerah=DB::table('master_daerah')->find($id);
        $akar=DB::table('ms_akar')->find($id_akar);



        $valid=Validator::make($request->all(),[
            'uraian'=>'string|required'
        ]);

        if($valid->fails()){
              Alert::error('','Data Dukung Masalah   Tidak Dapat Ditambahkan');

            return back();
        }

        if(((!empty($daerah))&&(!empty($akar)))&&(!empty($akar))){
            $data=DB::table('ms_data_dukung')->insertGetId([
                'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
                'tahun'=>Hp::fokus_tahun(),
                'id_ms_pokok'=>$akar->id_ms_pokok,
                'id_ms'=>$akar->id_ms,
                'id_ms_akar'=>$akar->id,
                'kode_daerah'=>$id,
                'uraian'=>strtoupper($request->uraian),
                'id_user'=>$uid,
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            ]);

            if($data){
                Alert::success('','Data Dukung Masalah  Ditambahkan');
                return back();
            }else{
                  Alert::error('','Data Dukung Masalah    Tidak Dapat Ditambahkan');
                return back();
            }

        }else{
              Alert::error('','Data Dukung Masalah   Tidak Dapat Ditambahkan');
            return back();
        }

    }


    public function api_get_masalah_pokok(Request $request){

        if($request->term){
            $r=DB::table('ms_pokok')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('ms_pokok')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }
}
