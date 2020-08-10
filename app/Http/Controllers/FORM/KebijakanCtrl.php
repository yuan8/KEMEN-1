<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
use Alert;
use Hp;
class KebijakanCtrl extends Controller
{
    //

    public function index(Request $request){
        $urusan=\Hp::fokus_urusan();

        $kebijakan=DB::table(DB::raw('master_sub_urusan as su'))
        ->select('su.id as id','su.nama as nama','man.id as id_mandat','man.uraian as mandat','man.tipe',
            DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_uu as ux where ux.id_mandat=man.id ) as uu"),
            DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_pp as ux where ux.id_mandat=man.id ) as pp"),
            DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_perpres as ux where ux.id_mandat=man.id ) as perpres"),
            DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_permen as ux where ux.id_mandat=man.id ) as permen")
        )
        ->leftJoin('ikb_mandat as man','man.id_sub_urusan','=','su.id')
        ->where('su.id_urusan',$urusan['id_urusan'])
        ->orderBy('su.id','ASC')
        ->orderBy('man.id','DESC')


        ->paginate(10);


    	return view('form.kebijakan.pusat.index')->with('kebijakan',$kebijakan);
    }

    public  function store_mandat($id_sub,Request $request)
    {
            $re=$request->all();
            $urusan=session('fokus_urusan');
            $re['id_sub_urusan']=$id_sub;
            $re['id_urusan']=$urusan['id_urusan'];
            $re['id_user']=Auth::User()->id;
            $re['created_at']=date('Y-m-d h:i');
            $re['updated_at']=date('Y-m-d h:i');
            $re['tahun']=session('fokus_tahun');
            $re['tipe']=isset($request->tipe)?true:false;
            unset($re['_token']);

            $valid=Validator::make($re,[
                'id_sub_urusan'=>'required|numeric|exists:master_sub_urusan,id',
                'uraian'=>'required|string',
                'tipe'=>'nullable',
                'id_urusan'=>'required|numeric|exists:master_urusan,id',
                'tahun'=>'required|numeric|min:'.date('Y')
            ]);

            if($valid->fails()){
                Alert::error('Gagal',$valid->errors()[0]);
                return back();
            }

            $id=DB::table('ikb_mandat')->insertGetId($re);
            if($id){
                Alert::success('','Mandat Ditambahkan');

                return back();

            }else{

            }
    }

    public function delete_mandat($id){
        $d=DB::table('ikb_mandat')->find($id);
        if($d){
            $a=DB::table('ikb_mandat')->where('id',$id)->delete();
            if($a){
                Alert::success($d->uraian,'Mandat Telah di Hapus');
                return back();
            }
        }else{

        }

        Alert::error('','Mandat Tidak terhapus Hapus');
        return back();

    }

    public function store_uu($id_sub_urusan,$id_mandat,Request $request){
        $valid=Validator::make($request->all(),[
            'uu'=>'required|array'
        ]);

        if($valid->fails()){
            Alert::error('Gagal','UU kosong');
            return back();
        }

       
        $data=[];
      
        $uu=$request->uu;

        foreach ($uu as $key => $value) {
            # code...
            $data[]=array(
                'id_urusan'=>(int)Hp::fokus_urusan()['id_urusan'],
                'id_sub_urusan'=>(int)$id_sub_urusan,
                'id_mandat'=>(int)$id_mandat,
                'uraian'=>$value,
                'tahun'=>(int)session('fokus_tahun'),
                'id_user'=>(int)Auth::id(),
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            );
        }

        if(count($uu)>0){
             $a=DB::table('ikb_uu')
                ->where('id_sub_urusan',$id_sub_urusan)
                ->where('id_mandat',$id_mandat)
                ->whereNotIn('uraian',$uu)
                ->where('tahun',session('fokus_tahun'))
                ->delete();
            $a=DB::table('ikb_uu')->insertOrIgnore($data);
        }

        Alert::success('','UU Berhasil di Tambahkan');
        return back();
        

    	// return view('form.kebijakan.pusat.tambah');
    }

    public function store_pp($id_sub_urusan,$id_mandat,Request $request){
        $valid=Validator::make($request->all(),[
            'pp'=>'required|array'
        ]);



        if($valid->fails()){
            Alert::error('Gagal','UU kosong');
            return back();
        }


        
        $data=[];
   
        $uu=(array)$request->pp;

        foreach ($uu as $key => $value) {
            # code...
            $data[]=array(
                'id_urusan'=>(int)Hp::fokus_urusan()['id_urusan'],
                'id_sub_urusan'=>(int)$id_sub_urusan,
                'id_mandat'=>(int)$id_mandat,
                'uraian'=>$value,
                'tahun'=>(int)session('fokus_tahun'),
                'id_user'=>(int)Auth::id(),
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            );
        }



        if(count($data)>0){
            $a=DB::table('ikb_pp')
            ->where('id_sub_urusan',$id_sub_urusan)
            ->where('id_mandat',$id_mandat)
            ->whereNotIn('uraian',$uu)
            ->where('tahun',session('fokus_tahun'))
            ->delete();
            $a=DB::table('ikb_pp')->insertOrIgnore($data);
        }

        Alert::success('','PP Berhasil di Tambahkan');
        return back();
        

        // return view('form.kebijakan.pusat.tambah');
    }

    public function store_perpres($id_sub_urusan,$id_mandat,Request $request){
        $valid=Validator::make($request->all(),[
            'perpres'=>'required|array'
        ]);

        if($valid->fails()){
            Alert::error('Gagal','Perpres kosong');
            return back();
        }

       
        $data=[];
     
        $uu=$request->perpres;

        foreach ($uu as $key => $value) {
            # code...
            $data[]=array(
                'id_urusan'=>(int)Hp::fokus_urusan()['id_urusan'],
                'id_sub_urusan'=>(int)$id_sub_urusan,
                'id_mandat'=>(int)$id_mandat,
                'uraian'=>$value,
                'tahun'=>(int)session('fokus_tahun'),
                'id_user'=>(int)Auth::id(),
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            );
        }

         if(count($uu)>0){
             $a=DB::table('ikb_perpres')
                ->where('id_sub_urusan',$id_sub_urusan)
                ->where('id_mandat',$id_mandat)
                ->whereNotIn('uraian',$uu)
                ->where('tahun',session('fokus_tahun'))
                ->delete();
            $a=DB::table('ikb_perpres')->insertOrIgnore($data);
        }


        Alert::success('','Perpres Berhasil di Tambahkan');
        return back();
        

        // return view('form.kebijakan.pusat.tambah');
    }

    public function store_permen($id_sub_urusan,$id_mandat,Request $request){
        $valid=Validator::make($request->all(),[
            'permen'=>'required|array'
        ]);

        if($valid->fails()){
            Alert::error('Gagal','Permen kosong');
            return back();
        }

      
        $data=[];
       
        $uu=$request->permen;

        foreach ($uu as $key => $value) {
            # code...
            $data[]=array(
                'id_urusan'=>(int)Hp::fokus_urusan()['id_urusan'],
                'id_sub_urusan'=>(int)$id_sub_urusan,
                'id_mandat'=>(int)$id_mandat,
                'uraian'=>$value,
                'tahun'=>(int)session('fokus_tahun'),
                'id_user'=>(int)Auth::id(),
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            );
        }

       if(count($uu)>0){
             $a=DB::table('ikb_permen')
                ->where('id_sub_urusan',$id_sub_urusan)
                ->where('id_mandat',$id_mandat)
                ->whereNotIn('uraian',$uu)
                ->where('tahun',session('fokus_tahun'))
                ->delete();
            $a=DB::table('ikb_permen')->insertOrIgnore($data);
        }

        Alert::success('','Permen Berhasil di Tambahkan');
        return back();
        

        // return view('form.kebijakan.pusat.tambah');
    }



    public function api_get_uu(Request $request){
        if($request->term){
            $r=DB::table('ikb_uu')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('ikb_uu')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }

    public function api_get_pp(Request $request){
        if($request->term){
            $r=DB::table('ikb_pp')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('ikb_pp')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }

    public function api_get_perpres(Request $request){
        if($request->term){
            $r=DB::table('ikb_perpres')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('ikb_perpres')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }

    public function api_get_permen(Request $request){
        if($request->term){
            $r=DB::table('ikb_permen')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('ikb_permen')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }

    public function api_store_uu($id,Request $request){
        $uid=Auth::id();
        $m=DB::table('ikb_mandat')->find($id);
        if($m){

            $check=DB::table('ikb_uu')->where([
                'id_urusan'=>$m->id_urusan,
                'id_sub_urusan'=>$m->id_sub_urusan,
                'uraian'=>$request->uraian,
                'id_mandat'=>$id,
                'tahun'=>session('fokus_tahun')
            ])->first();
            if($check){
                return array('code'=>500,'mesaage'=>'');
            }else{
                $uu=true;
               // $uu= DB::table('ikb_uu')->insertGetId(
               //  [
               //      'id_urusan'=>$m->id_urusan,
               //      'id_sub_urusan'=>$m->id_sub_urusan,
               //      'uraian'=>$request->uraian,
               //      'id_mandat'=>$id,
               //      'tahun'=>session('fokus_tahun'),
               //      'id_user'=>$uid,
               //      'created_at'=>date('Y-m-d h:i'),
               //      'updated_at'=>date('Y-m-d h:i')
               //  ]
               // );

               if($uu){
                    return array('code'=>200,'data'=>array('text'=>$request->uraian,'id'=>$request->uraian));
               }else{
                    return array('code'=>500,'mesaage'=>'');
               }
            }

        }else{
             return array('code'=>500,'mesaage'=>'mandat g ada');


        }
    }

    public function api_store_pp($id,Request $request){
        $uid=Auth::id();
        $m=DB::table('ikb_mandat')->find($id);
        if($m){

            $check=DB::table('ikb_pp')->where([
                'id_urusan'=>$m->id_urusan,
                'id_sub_urusan'=>$m->id_sub_urusan,
                'uraian'=>$request->uraian,
                'id_mandat'=>$id,
                'tahun'=>session('fokus_tahun')
            ])->first();
            if($check){
                return array('code'=>500,'mesaage'=>'');
            }else{
                $uu=true;
               // $uu= DB::table('ikb_uu')->insertGetId(
               //  [
               //      'id_urusan'=>$m->id_urusan,
               //      'id_sub_urusan'=>$m->id_sub_urusan,
               //      'uraian'=>$request->uraian,
               //      'id_mandat'=>$id,
               //      'tahun'=>session('fokus_tahun'),
               //      'id_user'=>$uid,
               //      'created_at'=>date('Y-m-d h:i'),
               //      'updated_at'=>date('Y-m-d h:i')
               //  ]
               // );
                if($uu){
                    return array('code'=>200,'data'=>array('text'=>$request->uraian,'id'=>$request->uraian));
               }else{
                    return array('code'=>500,'mesaage'=>'');
               }
            }

        }else{
             return array('code'=>500,'mesaage'=>'mandat g ada');


        }
    }

    public function api_store_perpres($id,Request $request){
        $uid=Auth::id();
        $m=DB::table('ikb_mandat')->find($id);
        if($m){

            $check=DB::table('ikb_perpres')->where([
                'id_urusan'=>$m->id_urusan,
                'id_sub_urusan'=>$m->id_sub_urusan,
                'uraian'=>$request->uraian,
                'id_mandat'=>$id,
                'tahun'=>session('fokus_tahun')
            ])->first();
            if($check){
                return array('code'=>500,'mesaage'=>'');
            }else{
                  $uu=true;
               // $uu= DB::table('ikb_uu')->insertGetId(
               //  [
               //      'id_urusan'=>$m->id_urusan,
               //      'id_sub_urusan'=>$m->id_sub_urusan,
               //      'uraian'=>$request->uraian,
               //      'id_mandat'=>$id,
               //      'tahun'=>session('fokus_tahun'),
               //      'id_user'=>$uid,
               //      'created_at'=>date('Y-m-d h:i'),
               //      'updated_at'=>date('Y-m-d h:i')
               //  ]
               // );
                if($uu){
                    return array('code'=>200,'data'=>array('text'=>$request->uraian,'id'=>$request->uraian));
               }else{
                    return array('code'=>500,'mesaage'=>'');
               }
            }

        }else{
             return array('code'=>500,'mesaage'=>'mandat g ada');


        }
    }


    public function api_store_permen($id,Request $request){
        $uid=Auth::id();
        $m=DB::table('ikb_mandat')->find($id);
        if($m){

            $check=DB::table('ikb_permen')->where([
                'id_urusan'=>$m->id_urusan,
                'id_sub_urusan'=>$m->id_sub_urusan,
                'uraian'=>$request->uraian,
                'id_mandat'=>$id,
                'tahun'=>session('fokus_tahun')
            ])->first();
            if($check){
                return array('code'=>500,'mesaage'=>'');
            }else{
                $uu=true;
               // $uu= DB::table('ikb_uu')->insertGetId(
               //  [
               //      'id_urusan'=>$m->id_urusan,
               //      'id_sub_urusan'=>$m->id_sub_urusan,
               //      'uraian'=>$request->uraian,
               //      'id_mandat'=>$id,
               //      'tahun'=>session('fokus_tahun'),
               //      'id_user'=>$uid,
               //      'created_at'=>date('Y-m-d h:i'),
               //      'updated_at'=>date('Y-m-d h:i')
               //  ]
               // );
                if($uu){
                    return array('code'=>200,'data'=>array('text'=>$request->uraian,'id'=>$request->uraian));
               }else{
                    return array('code'=>500,'mesaage'=>'');
               }
            }

        }else{
             return array('code'=>500,'mesaage'=>'mandat g ada');


        }
    }




    // ------------------------------------------------------------------------------------------------------------------

    public function index_daerah(Request $request){

    	$provinsi=DB::table('master_daerah')->where(DB::raw('length(id)'),2)
    	->orderBy('nama','ASC')->get();

    	return view('form.kebijakan.daerah.index',['provinsis'=>$provinsi]);

    }

    public function view_daerah($id,Request $request){
    	$daerah=DB::table('master_daerah')->find($id);

        $data=DB::table('ikb_mandat as man')
        ->select('man.id_sub_urusan as id','su.nama as nama','man.uraian as mandat','man.tipe','man.id as id_mandat','int.note',
            'int.id as id_integrasi','int.kesesuaian',
            DB::raw('(select nama from master_daerah where id=int.kode_daerah) as nama_daerah'),
             DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_perda as ux where ux.id_integrasi=int.id ) as perda"),
            DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_perkada as ux where ux.id_integrasi=int.id ) as perkada")

        )
        ->leftJoin('master_sub_urusan as su','man.id_sub_urusan','=','su.id')
        ->leftJoin('ikb_integrasi as int',[['man.id','=','int.id_mandat'],['int.kode_daerah','=',DB::raw("'".$id."'") ]])

        ->orderBy('man.id_sub_urusan','DESC')
        ->orderBy('man.id','DESC')
        ->orderBy('int.id','DESC')
        ->where('su.id_urusan',Hp::fokus_urusan()['id_urusan'])
        ->paginate(10);



    	return view('form.kebijakan.daerah.view')->with('daerah',$daerah)->with('datas',$data)->with('kode_daerah',$id)->with('back_link',route('kebijakan.daerah.index'));
    }

     public function store_perda($id_sub_urusan,$id_mandat,Request $request){
        $valid=Validator::make($request->all(),[
            'perda'=>'required|array'
        ]);

        $uid=Auth::id();

        if($valid->fails()){
            Alert::error('Gagal','Perda kosong');
            return back();
        }

        $m=DB::table('ikb_mandat')->find($id_mandat);

        $integrasi=DB::table('ikb_integrasi')
        ->where('id_sub_urusan',$id_sub_urusan)
        ->where('id_mandat',$id_mandat)
        ->where('kode_daerah',$request->kode_daerah)
        ->where('tahun',session('fokus_tahun'))->first();

        if(!$integrasi){
            $integrasi=DB::table('ikb_integrasi')->insertGetId(
                [
                    'id_sub_urusan'=>$id_sub_urusan,
                    'id_mandat'=>$id_mandat,
                    'tahun'=>session('fokus_tahun'),
                    'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
                    'kode_daerah'=>$request->kode_daerah,
                    'id_user'=>$uid,
                    'created_at'=>date('Y-m-d h:i'),
                    'updated_at'=>date('Y-m-d h:i')
                ]

            );

            
        }else{
            $integrasi=$integrasi->id;
        }

        $data=[];
       
        $uu=$request->perda;

        foreach ($uu as $key => $value) {
            # code...
            $data[]=array(
                'id_integrasi'=>$integrasi,
                'kode_daerah'=>$request->kode_daerah,
                'id_urusan'=>(int)Hp::fokus_urusan()['id_urusan'],
                'id_sub_urusan'=>(int)$id_sub_urusan,
                'id_mandat'=>(int)$id_mandat,
                'uraian'=>$value,
                'tahun'=>(int)session('fokus_tahun'),
                'id_user'=>(int)Auth::id(),
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            );
        }

       if(count($uu)>0){
             $a=DB::table('ikb_perda')
                ->where('id_sub_urusan',$id_sub_urusan)
                ->where('id_mandat',$id_mandat)
                ->where('kode_daerah',$request->kode_daerah)
                ->where('id_integrasi',$integrasi)
                ->whereNotIn('uraian',$uu)
                ->where('tahun',session('fokus_tahun'))
                ->delete();
            $a=DB::table('ikb_perda')->insertOrIgnore($data);
        }

        Alert::success('','Perda Berhasil di Tambahkan');
        return back();
        

        // return view('form.kebijakan.pusat.tambah');
    }



    public function api_get_table_kota(Request $request){
    	$return =[];
    	if($request->id){
			$return =DB::table('master_daerah')->where('id','ilike',DB::raw("'".$request->id."' "."||'%'"))
			->orderBy('id','ASC')->orderBy('nama','ASC')
			->get();    		
    	}

    	return view('form.kebijakan.daerah.api.table_kota')->with('daerahs',$return)->render();

    }


    public function api_get_perda(Request $request){

        if($request->term){
            $r=DB::table('ikb_perda')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('ikb_perda')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);

    }



    public function api_store_perda($id,Request $request){

        $uid=Auth::id();
        $m=DB::table('ikb_mandat')->find($id);



        if($m){

            $integrasi=DB::table('ikb_integrasi')->where([
                'id_urusan'=>$m->id_urusan,
                'id_sub_urusan'=>$m->id_sub_urusan,
                'id_mandat'=>$id,
                'kode_daerah'=>$request->kode_daerah,
                'tahun'=>session('fokus_tahun')
            ])->select('id')->first();

            if(!$integrasi){
                $integrasi=DB::table('ikb_integrasi')->insertGetId([
                    'id_urusan'=>$m->id_urusan,
                    'id_sub_urusan'=>$m->id_sub_urusan,
                    'id_mandat'=>$id,
                    'kode_daerah'=>$request->kode_daerah,
                    'tahun'=>session('fokus_tahun'),
                    'id_user'=>$uid,
                    'created_at'=>date('Y-m-d h:i'),
                    'updated_at'=>date('Y-m-d h:i')
                ]);
            }else{
                $integrasi=$integrasi->id;
            }


            $check=DB::table('ikb_perda')->where([
                'id_integrasi'=>$integrasi,
                'kode_daerah'=>$request->kode_daerah,
                'id_urusan'=>$m->id_urusan,
                'id_sub_urusan'=>$m->id_sub_urusan,
                'uraian'=>$request->uraian,
                'id_mandat'=>$id,
                'tahun'=>session('fokus_tahun')
            ])->first();

            if($check){
                return array('code'=>500,'mesaage'=>'');
            }else{
                $uu=true;
               // $uu= DB::table('ikb_uu')->insertGetId(
               //  [
               //      'id_urusan'=>$m->id_urusan,
               //      'id_sub_urusan'=>$m->id_sub_urusan,
               //      'uraian'=>$request->uraian,
               //      'id_mandat'=>$id,
               //      'tahun'=>session('fokus_tahun'),
               //      'id_user'=>$uid,
               //      'created_at'=>date('Y-m-d h:i'),
               //      'updated_at'=>date('Y-m-d h:i')
               //  ]
               // );
                if($uu){
                    return array('code'=>200,'data'=>array('text'=>$request->uraian,'id'=>$request->uraian));
               }else{
                    return array('code'=>500,'mesaage'=>'');
               }
            }

        }else{
             return array('code'=>500,'mesaage'=>'Perda Tidak Tersedia');


        }



    }






    public function api_get_perkada(Request $request){

         if($request->term){
            $r=DB::table('ikb_perkada')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('ikb_perkada')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);

    }


    public function api_store_perkada($id,Request $request){

        $uid=Auth::id();
        $m=DB::table('ikb_mandat')->find($id);



        if($m){
            $integrasi=DB::table('ikb_integrasi')->where([
                'id_urusan'=>$m->id_urusan,
                'id_sub_urusan'=>$m->id_sub_urusan,
                'id_mandat'=>$id,
                'kode_daerah'=>$request->kode_daerah,
                'tahun'=>session('fokus_tahun')
            ])->select('id')->first();

            if(!$integrasi){
                $integrasi=DB::table('ikb_integrasi')->insertGetId([
                    'id_urusan'=>$m->id_urusan,
                    'id_sub_urusan'=>$m->id_sub_urusan,
                    'id_mandat'=>$id,
                    'kode_daerah'=>$request->kode_daerah,
                    'tahun'=>session('fokus_tahun'),
                    'id_user'=>$uid,
                    'created_at'=>date('Y-m-d h:i'),
                    'updated_at'=>date('Y-m-d h:i')
                ]);
            }else{
                $integrasi=$integrasi->id;
            }


            $check=DB::table('ikb_perkada')->where([
                'id_integrasi'=>$integrasi,
                'kode_daerah'=>$request->kode_daerah,
                'id_urusan'=>$m->id_urusan,
                'id_sub_urusan'=>$m->id_sub_urusan,
                'uraian'=>$request->uraian,
                'id_mandat'=>$id,
                'tahun'=>session('fokus_tahun')
            ])->first();

            if($check){
                return array('code'=>500,'mesaage'=>'');
            }else{
                $uu=true;
               // $uu= DB::table('ikb_uu')->insertGetId(
               //  [
               //      'id_urusan'=>$m->id_urusan,
               //      'id_sub_urusan'=>$m->id_sub_urusan,
               //      'uraian'=>$request->uraian,
               //      'id_mandat'=>$id,
               //      'tahun'=>session('fokus_tahun'),
               //      'id_user'=>$uid,
               //      'created_at'=>date('Y-m-d h:i'),
               //      'updated_at'=>date('Y-m-d h:i')
               //  ]
               // );
                if($uu){
                    return array('code'=>200,'data'=>array('text'=>$request->uraian,'id'=>$request->uraian));
               }else{
                    return array('code'=>500,'mesaage'=>'');
               }
            }

        }else{
             return array('code'=>500,'mesaage'=>'Perkada Tidak Tersedia');

        }



    }

    public function store_perkada($id_sub_urusan,$id_mandat,Request $request){
        $valid=Validator::make($request->all(),[
            'perkada'=>'required|array'
        ]);

        $uid=Auth::id();

        if($valid->fails()){
            Alert::error('Gagal','Perkada kosong');
            return back();
        }

        $m=DB::table('ikb_mandat')->find($id_mandat);

        $integrasi=DB::table('ikb_integrasi')
        ->where('id_sub_urusan',$id_sub_urusan)
        ->where('id_mandat',$id_mandat)
        ->where('kode_daerah',$request->kode_daerah)
        ->where('tahun',session('fokus_tahun'))->first();

        if(!$integrasi){
            $integrasi=DB::table('ikb_integrasi')->insertGetId(
                [
                    'id_sub_urusan'=>$id_sub_urusan,
                    'id_mandat'=>$id_mandat,
                    'tahun'=>session('fokus_tahun'),
                    'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
                    'kode_daerah'=>$request->kode_daerah,
                    'id_user'=>$uid,
                    'created_at'=>date('Y-m-d h:i'),
                    'updated_at'=>date('Y-m-d h:i')
                ]

            );

            
        }else{
            $integrasi=$integrasi->id;
        }

        $data=[];
       
        $uu=$request->perkada;

        foreach ($uu as $key => $value) {
            # code...
            $data[]=array(
                'id_integrasi'=>$integrasi,
                'kode_daerah'=>$request->kode_daerah,
                'id_urusan'=>(int)Hp::fokus_urusan()['id_urusan'],
                'id_sub_urusan'=>(int)$id_sub_urusan,
                'id_mandat'=>(int)$id_mandat,
                'uraian'=>$value,
                'tahun'=>(int)session('fokus_tahun'),
                'id_user'=>(int)Auth::id(),
                'created_at'=>date('Y-m-d h:i'),
                'updated_at'=>date('Y-m-d h:i')
            );
        }

       if(count($uu)>0){
             $a=DB::table('ikb_perkada')
                ->where('id_sub_urusan',$id_sub_urusan)
                ->where('id_mandat',$id_mandat)
                ->where('kode_daerah',$request->kode_daerah)
                ->where('id_integrasi',$integrasi)
                ->whereNotIn('uraian',$uu)
                ->where('tahun',session('fokus_tahun'))
                ->delete();
            $a=DB::table('ikb_perkada')->insertOrIgnore($data);
        }

        Alert::success('','Perkada Berhasil di Tambahkan');
        return back();
        

        // return view('form.kebijakan.pusat.tambah');
    }



    public function update_kesesuaian($id,Request $request){

        $data=DB::table('ikb_integrasi')->find($id);
        if($data){
            $data=DB::table('ikb_integrasi')
            ->where('id',$id)
            ->update(
                [
                    'kesesuaian'=>$request->penilaian,
                    'note'=>$request->note,
                ]);
            if($data){
                Alert::success('','Penilaian Berhasil');
                return back();
            }

        }else{
            Alert::error('Gagal','Gagal Melakukan Penilaian');
            return back();
        }

    }


}
