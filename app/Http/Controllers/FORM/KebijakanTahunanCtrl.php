<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Alert;
use Validator;
use Hp;
use Carbon\Carbon;
class KebijakanTahunanCtrl extends Controller
{
    //

    public function api_get_pn_list(Request $request){
        $id=$request->id;
        $tahun=Hp::fokus_tahun();

         if($id){
            return DB::table('master_psn as psn')

            ->join('master_pn as pn','psn.id_pn','=','psn.id')
            ->join('pic_psn_urusan as pic','pic.id_psn','=','psn.id')
            ->where('pic.id_sub_urusan',$id)
            ->where('psn.tahun','<=',$tahun)
            ->where('psn.tahun_selesai','>=',$tahun)
            ->select('pn.id','pn.nama')
            ->groupBy('pn.id')
            ->get();

        }else{
            return [];
        }

    }

    public function api_get_kp_list(Request $request){
        $id=$request->id;

        $tahun=Hp::fokus_tahun();

        if($id){
            return DB::table('master_kp as kp')->where('kp.id_pp',$id)
              ->where('kp.tahun','<=',$tahun)
            ->where('kp.tahun_selesai','>=',$tahun)
            ->get();

        }else{
            return [];
        }


    }

     public function api_get_propn_list(Request $request){
        $id=$request->id;

        $tahun=Hp::fokus_tahun();

        if($id){
            return DB::table('master_propn as pro')->where('pro.id_kp',$id)
            ->where('pro.tahun','<=',$tahun)
            ->where('pro.tahun_selesai','>=',$tahun)
            ->get();

        }else{
            return [];
        }


    }

    public function api_get_pp_list(Request $request){
        $id=$request->id;

        $tahun=Hp::fokus_tahun();

        if($id){
            return DB::table('master_pp as pp')->where('id_pn',$id)
              ->where('tahun','<=',$tahun)
            ->where('tahun_selesai','>=',$tahun)
            ->get();

        }else{
            return [];
        }

    }

    public function api_get_psn_list(Request $request){
        $tahun=Hp::fokus_tahun();

        $data=DB::table('view_pic_psn as psn')
        ->select('*',DB::raw("CONCAT('<button class=%22btn btn-warning btn-xs%22 onclick=%22add_card(this)%22 >Tambah</button>') as btn_add "),DB::raw("CONCAT('<button type=%22button%22 class=%22btn btn-info btn-xs%22 onclick=%22 viewDetailPSN(',psn.id,',','event',') %22 >Detail</button>') as btn_detail"))
        ->where('tahun','<=',$tahun)
        ->where('tahun_selesai','>=',$tahun)
        ->where('id_urusan',null)->get();

        return $data;
       // return view('form.kebijakan-tahunan.api.table-list-psn')->with('data',$data);

    }

    public function index(){

        $master_pn=DB::table('master_pn')->orderBy('nama','ASC')->get();
        $master_sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',Hp::fokus_urusan()['id_urusan'])->get();
        $data=[];

        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];
        $data=DB::table('view_pic_psn as psn')
        ->select(
            DB::raw("(select nama from master_pn as pn where pn.id = psn.id_pn limit 1) as nama_pn"),
            DB::raw("(select nama from master_pp as pp where pp.id = psn.id_pp limit 1) as nama_pp"),
            DB::raw("(select nama from master_kp as kp where kp.id = psn.id_kp limit 1) as nama_kp"),
            DB::raw("(select nama from master_propn as propn where propn.id = psn.id_propn limit 1) as nama_propn"),
            'psn.*',
            DB::raw("(select nama from master_sub_urusan as sub where sub.id = psn.id_sub_urusan limit 1) as nama_sub_urusan"),
            'ipsns.jumlah_ind_targeted',
            DB::raw("(select count(*) from master_ind_psn as ip where ip.id_psn = psn.id limit 1) as jumlah_ind")            
        )
        ->leftJoin(DB::raw('view_ind_psn_status as ipsns'),function($join)use ($tahun){
                return $join->on('ipsns.id_psn', '=', 'psn.id')->on('ipsns.tahun','=',DB::raw($tahun));
        
        })
        ->where('psn.id_urusan',$id_urusan)
        ->where('psn.tahun','<=',$tahun)
        ->where('psn.tahun_selesai','>=',$tahun)
        // ->orderBy('psn.updated_at','DESC')
        ->paginate(20);


    	return view('form.kebijakan-tahunan.index2')->with(['data'=>$data,'master_pn'=>$master_pn,'master_sub_urusan'=>$master_sub_urusan]);

    }


    public function store_pn(Request $request){
    	$uid=Auth::id();
    	$valid=Validator::make($request->all(),[
    		'uraian'=>'required|string',
    		'anggaran'=>'required|numeric|min:0',

    	]);

    	if($valid->fails()){

    		Alert::error('Gagal',Hp::error($valid));
    		return back();
    	}

    	$data=DB::table('kbt_pn')
    	->where('id_urusan',Hp::fokus_urusan()['id_urusan'])
    	->where('tahun',Hp::fokus_tahun())
    	->where('uraian','ilike',$request->uraian)
    	->first();

    	if(!$data){
    		$data=DB::table('kbt_pn')
    		->insertGetId(
    			[
    				'id_user'=>$uid,
    				'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
    				'uraian'=>$request->uraian,
    				'anggaran'=>$request->anggaran,
    				'tahun'=>(int)session('fokus_tahun'),
    				 'created_at'=>date('Y-m-d h:i'),
                	'updated_at'=>date('Y-m-d h:i')

    			]
    		);

    		if($data){
    			Alert::success('','Data Ditambahkan');
    			return back();
    		}else{
    			Alert::error('Gagal','Tidak dapat diproses');
    			return back();

    		}


    	}else{
    		Alert::error('Gagal','Data Telah Terdefinisi Sebelumnya');
    		return back();
    	}




    }

    public function store_pp($id,Request $request){
    	$uid=Auth::id();
    	$valid=Validator::make($request->all(),[
    		'uraian'=>'required|string',
    		'anggaran'=>'required|numeric|min:0',

    	]);

    	$pn=DB::table('kbt_pn')
    	->find($id);

    	if($valid->fails()){

    		Alert::error('Gagal',Hp::error($valid));
    		return back();
    	}

    	$data=DB::table('kbt_pp')
    	->where('id_urusan',Hp::fokus_urusan()['id_urusan'])
    	->where('tahun',Hp::fokus_tahun())
    	->where('id_kbt_pn',$id)
    	->where('uraian','ilike',$request->uraian)
    	->first();

    	if((empty($data))&&(!empty($pn)) ){
    		$data=DB::table('kbt_pp')
    		->insertGetId(
    			[
    				'id_user'=>$uid,
    				'id_kbt_pn'=>$pn->id,
    				'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
    				'uraian'=>$request->uraian,
    				'anggaran'=>$request->anggaran,
    				'tahun'=>(int)session('fokus_tahun'),
    				 'created_at'=>date('Y-m-d h:i'),
                	'updated_at'=>date('Y-m-d h:i')

    			]
    		);

    		if($data){
    			Alert::success('','Data Ditambahkan');
    			return back();
    		}else{
    			Alert::error('Gagal','Tidak dapat diproses');
    			return back();

    		}


    	}else{
    		Alert::error('Gagal','Data Telah Terdefinisi Sebelumnya');
    		return back();
    	}

    }

    public function store_kp($id_pn,$id_pp,Request $request){
    	$uid=Auth::id();
    	$valid=Validator::make($request->all(),[
    		'uraian'=>'required|string',
    		'anggaran'=>'required|numeric|min:0',

    	]);

    	$pp=DB::table('kbt_pp')
    	->find($id_pp);

    	if($valid->fails()){

    		Alert::error('Gagal',Hp::error($valid));
    		return back();
    	}

    	$data=DB::table('kbt_kp')
    	->where('id_urusan',Hp::fokus_urusan()['id_urusan'])
    	->where('tahun',Hp::fokus_tahun())
    	->where('id_kbt_pp',$id_pp)
    	->where('uraian','ilike',$request->uraian)
    	->first();

    	if((empty($data))&&(!empty($pp)) ){
    		$data=DB::table('kbt_kp')
    		->insertGetId(
    			[
    				'id_user'=>$uid,
    				'id_kbt_pp'=>$pp->id,
    				'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
    				'uraian'=>$request->uraian,
    				'anggaran'=>$request->anggaran,
    				'tahun'=>(int)session('fokus_tahun'),
    				 'created_at'=>date('Y-m-d h:i'),
                	'updated_at'=>date('Y-m-d h:i')

    			]
    		);

    		if($data){
    			Alert::success('','Data Ditambahkan');
    			return back();
    		}else{
    			Alert::error('Gagal','Tidak dapat diproses');
    			return back();

    		}


    	}else{
    		Alert::error('Gagal','Data Telah Terdefinisi Sebelumnya');
    		return back();
    	}


    }

     public function store_target_psn($id_psn,Request $request){
    	$uid=Auth::id();
    	$valid=Validator::make($request->all(),[
    		'uraian'=>'required|string',

    	]);

    	$psn=DB::table('kbt_psn')
    	->find($id_psn);

    	if($valid->fails()){

    		Alert::error('Gagal',Hp::error($valid));
    		return back();
    	}

    	$data=null;

    	if((empty($data))&&(!empty($psn)) ){
    		$data=DB::table('kbt_psn_target')
    		->insertGetId(
    			[
    				'id_user'=>$uid,
    				'id_kbt_psn'=>$psn->id,
    				'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
    				'uraian'=>$request->uraian,
    				'tahun'=>(int)session('fokus_tahun'),
    				'created_at'=>date('Y-m-d h:i'),
                	'updated_at'=>date('Y-m-d h:i')

    			]
    		);

    		if($data){
    			Alert::success('','Data Ditambahkan');
    			return back();
    		}else{
    			Alert::error('Gagal','Tidak dapat diproses');
    			return back();

    		}


    	}else{
    		Alert::error('Gagal','Data Telah Terdefinisi Sebelumnya');
    		return back();
    	}


    }

    public function api_get_pn(Request $request){
    	if($request->term){
            $r=DB::table('kbt_pn')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('kbt_pn')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }
     public function api_get_pp(Request $request){
    	if($request->term){
            $r=DB::table('kbt_pp')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('kbt_pp')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }

     public function api_get_kp(Request $request){
    	if($request->term){
            $r=DB::table('kbt_kp')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('kbt_kp')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }

    public function api_get_propn(Request $request){
    	if($request->term){
            $r=DB::table('kbt_propn')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('kbt_propn')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }

     public function api_get_psn(Request $request){
    	if($request->term){
            $r=DB::table('kbt_psn')->select('uraian as text', 'uraian as id')->where('uraian','ilike',('%'.$request->term.'%'))->groupBy('uraian')->limit(4)->get();
        }else{
             $r=DB::table('kbt_psn')->select('uraian as text','uraian as id')->groupBy('uraian')->limit(4)->get();
        }

        return array('results'=>$r);
    }



    public function proyek(){
    	// $data=DB::table('kbt_kp as kp')
    	// ->leftJoin('kbt_propn as pro','pro.id_kbt_kp','=','kp.id')
    	// ->leftJoin('kbt_psn as psn','psn.id_kbt_propn','=','pro.id')
    	// ->leftJoin('kbt_psn_target as target','target.id_kbt_psn','=','psn.id')
    	// ->select(
    	// 	'kp.id as kp_id',
    	// 	'kp.uraian as kp_uraian',
    	// 	'kp.anggaran as kp_anggaran',

    	// 	'pro.id as pro_id',
    	// 	'pro.uraian as pro_uraian',
    	// 	'pro.anggaran as pro_anggaran',

    	// 	'psn.id as psn_id',
    	// 	'psn.uraian as psn_uraian',
    	// 	'psn.anggaran as psn_anggaran',

    	// 	'target.id as target_id',
    	// 	'target.uraian as target_uraian'
    		
    	// )
    	// ->orderBy('kp.id','DESC')
    	// ->orderBy('pro.id','DESC')
    	// ->orderBy('psn.id','DESC')
    	// ->orderBy('target.id','DESC')

    	// ->where('kp.tahun',Hp::fokus_tahun())
    	// ->where('kp.id_urusan',Hp::fokus_urusan()['id_urusan'])
    	// ->paginate(50);



    	return view('form.kebijakan-tahunan.proyek')->with('data',$data);




    }


    public function proyek_indikator($id){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];
        $data=DB::table('view_pic_psn as psn')

        ->select('psn.id','psn.id_pp','psn.id_kp','psn.id_propn','pic.id_urusan','pic.id_sub_urusan','psn.tahun','psn.tahun_selesai','psn.nama',
            DB::raw("(select nama from master_pn as pn where pn.id = psn.id_pn limit 1) as nama_pn"),
            DB::raw("(select nama from master_pp as pp where pp.id = psn.id_pp limit 1) as nama_pp"),
            DB::raw("(select nama from master_kp as kp where kp.id = psn.id_kp limit 1) as nama_kp"),
            DB::raw("(select nama from master_propn as propn where propn.id = psn.id_propn limit 1) as nama_propn"),
            DB::raw("(select nama from master_sub_urusan where id=psn.id_sub_urusan limit 1) as nama_sub_urusan")
        )
        ->join('pic_psn_urusan as pic',[['pic.id_psn','=','psn.id']])
        ->where([
            ['psn.id',$id],
            ['psn.tahun','<=',$tahun],
            ['psn.tahun_selesai','>=',$tahun],
            ['psn.deleted_at','>',DB::raw("to_timestamp(concat(".$tahun.",'/01/01 10:00:00'),'YYYY/MM/DD HH24:MI:SS')")],
            ['pic.id_urusan',$id_urusan]
        ])
        ->orWhere([
            ['psn.id',$id],
            ['psn.tahun','<=',$tahun],
            ['psn.tahun_selesai','>=',$tahun],
            ['psn.deleted_at',null]
        ])
       ->first();

        if($data){
            $tahun_mulai=$data->tahun;
            $tahun_selesai=$data->tahun_selesai;

            $indikator=DB::table('master_ind_psn as ipsn')
            ->select('ipsn.*',
            DB::raw("(select kode from master_satuan as satuan where satuan.id =ipsn.id_satuan ) as view_satuan"),
            DB::raw("(select  target from ind_psn_target as tg where tg.id_ind_psn=ipsn.id and ipsn.tahun =tg.tahun ) as rkp_1"),
            DB::raw("(select  target from ind_psn_target as tg where tg.id_ind_psn=ipsn.id and (ipsn.tahun+1) =tg.tahun ) as rkp_2"),
            DB::raw("(select  target from ind_psn_target as tg where tg.id_ind_psn=ipsn.id and (ipsn.tahun+2) =tg.tahun ) as rkp_3"),

            DB::raw("(select  target from ind_psn_target as tg where tg.id_ind_psn=ipsn.id and (ipsn.tahun+3) =tg.tahun ) as rkp_4"),
            DB::raw("(select  target from ind_psn_target as tg where tg.id_ind_psn=ipsn.id and (ipsn.tahun+4) =tg.tahun ) as rkp_5")
            )
            ->where('ipsn.tahun','<=',(int)$tahun)
            ->where('ipsn.tahun_selesai','>=',(int)$tahun)
            ->where('ipsn.id_psn',$data->id)->get();


            return view('form.kebijakan-tahunan.indikator')->with([
                'data'=>$indikator,
                'proyek'=>$data,
                 'back_link'=>route('kebijakan.pusat.tahunan.index')
            ]);


        }else{
            Alert::info('Info','Data Tidak di Temukan');
            return redirect()->route('kebijakan.pusat.tahunan.index');
        }

    }


    public function store_proyek(Request $request){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];
        $id_sub_urusan=$request->sub_urusan;
        $data_error=[];
        $uid=Auth::id();
        if($request->proyek_id){
            foreach ($request->proyek_id as $key => $d) {

                $exist=DB::table('pic_psn_urusan')->where('id_psn',$d)->where('id_urusan',$d)
                ->first();


                if($exist){

                
                        $data=DB::table('pic_psn_urusan')->where('id_psn',$d)->update(
                             [
                                'id_urusan'=>$id_urusan,
                                'id_sub_urusan'=>$id_sub_urusan,
                                'updated_at'=>Carbon::now(),
                            ]
                        );

                        // DB::table('pic_psn_urusan')->where('id_psn',$d)->update([
                        //     'id_urusan'=>$id_urusan,
                        //     'id_sub_urusan'=>$id_sub_urusan,
                        //     'updated_at'=>Carbon::now(),
                        //     'id_user'=>$uid
                        // ]);

                        // DB::table('ind_psn_target')->where('id_psn',$d)->update([
                        //     'id_urusan'=>$id_urusan,
                        //     'id_sub_urusan'=>$id_sub_urusan,
                        //     'updated_at'=>Carbon::now(),
                        //     'id_user'=>$uid
                        // ]);





                }else{

                  $exist=DB::table('pic_psn_urusan')->where('id_psn',$d)->first();

                  if(!$exist){
                      DB::table('pic_psn_urusan')->insert([
                            'id_urusan'=>$id_urusan,
                            'id_sub_urusan'=>$id_sub_urusan,
                            'updated_at'=>Carbon::now(),
                            'id_psn'=>$d,
                            'id_user'=>$uid,
                            'created_at'=>Carbon::now()

                    ]);
                  }else{
                $data_error[]=$d;

                  }

                  


                }


            }

             Alert::success('Berhasil','Data Error '.count($data_error));
        }else{
            Alert::error('Gagal','Tidak Terdapat Data Untuk di Tagging');
        }


        return back();

    }


     public function store_propn($id,Request $request){
    	$uid=Auth::id();
    	$valid=Validator::make($request->all(),[
    		'uraian'=>'required|string',
    		'anggaran'=>'required|numeric|min:0',

    	]);

    	$kp=DB::table('kbt_kp')
    	->find($id);

    	if($valid->fails()){

    		Alert::error('Gagal',Hp::error($valid));
    		return back();
    	}

    	$data=DB::table('kbt_propn')
    	->where('id_urusan',Hp::fokus_urusan()['id_urusan'])
    	->where('tahun',Hp::fokus_tahun())
    	->where('id_kbt_kp',$id)
    	->where('uraian','ilike',$request->uraian)
    	->first();

    	if((empty($data))&&(!empty($kp)) ){
    		$data=DB::table('kbt_propn')
    		->insertGetId(
    			[
    				'id_user'=>$uid,
    				'id_kbt_kp'=>$kp->id,
    				'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
    				'uraian'=>$request->uraian,
    				'anggaran'=>$request->anggaran,
    				'tahun'=>(int)session('fokus_tahun'),
    				 'created_at'=>date('Y-m-d h:i'),
                	'updated_at'=>date('Y-m-d h:i')

    			]
    		);

    		if($data){
    			Alert::success('','Data Ditambahkan');
    			return back();
    		}else{
    			Alert::error('Gagal','Tidak dapat diproses');
    			return back();

    		}


    	}else{
    		Alert::error('Gagal','Data Telah Terdefinisi Sebelumnya');
    		return back();
    	}

    }

    public function store_psn($id,Request $request){
    	$uid=Auth::id();
    	$valid=Validator::make($request->all(),[
    		'uraian'=>'required|string',
    		'anggaran'=>'required|numeric|min:0',

    	]);

    	$propn=DB::table('kbt_propn')
    	->find($id);

    	if($valid->fails()){

    		Alert::error('Gagal',Hp::error($valid));
    		return back();
    	}

    	$data=DB::table('kbt_psn')
    	->where('id_urusan',Hp::fokus_urusan()['id_urusan'])
    	->where('tahun',Hp::fokus_tahun())
    	->where('id_kbt_propn',$id)
    	->where('uraian','ilike',$request->uraian)
    	->first();

    	if((empty($data))&&(!empty($propn)) ){
    		$data=DB::table('kbt_psn')
    		->insertGetId(
    			[
    				'id_user'=>$uid,
    				'id_kbt_propn'=>$propn->id,
    				'id_urusan'=>Hp::fokus_urusan()['id_urusan'],
    				'uraian'=>$request->uraian,
    				'anggaran'=>$request->anggaran,
    				'tahun'=>(int)session('fokus_tahun'),
    				 'created_at'=>date('Y-m-d h:i'),
                	'updated_at'=>date('Y-m-d h:i')

    			]
    		);

    		if($data){
    			Alert::success('','Data Ditambahkan');
    			return back();
    		}else{
    			Alert::error('Gagal','Tidak dapat diproses');
    			return back();

    		}


    	}else{
    		Alert::error('Gagal','Data Telah Terdefinisi Sebelumnya');
    		return back();
    	}

    }

    public function view_ind_psn($id){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];
        $data=DB::table('master_ind_psn as ipsn')
        ->select('ipsn.*',
            DB::raw("(select kode from master_satuan where master_satuan.id = ipsn.id_satuan) as satuan"),
              DB::raw("(select nama from master_pn as pn where pn.id = ipsn.id_pn limit 1) as nama_pn"),
            DB::raw("(select nama from master_pp as pp where pp.id = ipsn.id_pp limit 1) as nama_pp"),
            DB::raw("(select nama from master_kp as kp where kp.id = ipsn.id_kp limit 1) as nama_kp"),
            DB::raw("(select nama from master_propn as propn where propn.id = ipsn.id_propn limit 1) as nama_propn"),
            DB::raw("(select nama from master_psn as psn where psn.id = ipsn.id_psn limit 1) as nama_psn"),

            'ipsn.*',
            DB::raw("(select nama from master_sub_urusan as sub where sub.id = pic.id_sub_urusan limit 1) as nama_sub_urusan")
        )
        ->join('pic_psn_urusan as pic','pic.id_psn','=','ipsn.id_psn')
        ->where('pic.id_urusan',$id_urusan)
        ->where('ipsn.tahun','<=',$tahun)
        ->where('ipsn.tahun_selesai','>=',$tahun)
        ->where('ipsn.id',$id)
        ->first();

        if($data){
                  
            $data=(array)$data;      
            for($i=$data['tahun'];$i<=$data['tahun_selesai'];$i++){
                $d=DB::table('ind_psn_target')
                ->where('id_ind_psn',$data['id'])->where('tahun',$i)->first();

                $data['target_tahunan'][$i]=$d?(array)$d:null;

                $data=(array)$data;


            }


           return view('form.kebijakan-tahunan.detail-indikator')
           ->with('data',$data)
           ->with('tahun_start',$data['tahun'])
           ->with('fokus_tahun',$tahun)
           ->with('back_link',route('kebijakan.pusat.tahunan.proyek.indikator.index',['id'=>$data['id_psn']]));
            
        }

        Alert::error('data tidak ditemukan');
        return back();


    }

    public function update_ind_psn($id,Request $request){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];
        $data=DB::table('master_ind_psn as ind')
        ->select('ind.*','pic.id_urusan','pic.id_sub_urusan')
        ->join('pic_psn_urusan as pic','pic.id_psn','=','ind.id_psn')
        ->where('pic.id_urusan',$id_urusan)
        ->where('ind.id',$id)->first();
        $uid=Auth::id();

        if($data){

            if((empty($data->id_satuan)OR(empty($data->id_urusan)) and empty($data->cal_type))){
                Alert::info('','Mohon mengisi meta data indikator terlebih dahulu (satuan,kalkulasi)');
                return back();
            }

            if($data->id_urusan!=$id_urusan){
                Alert::info('Data tidak tersedia');
                return back();
            }



            foreach ($request->target_tahunan as $key => $d) {
                    
                $ind_tg=DB::table('ind_psn_target')->where('tahun',$key)->where('id_ind_psn',$data->id)->first();

                if($ind_tg){

                    if(in_array($data->cal_type, ['min_accept','max_accept','aggregate','aggregate_min'])){
                        $valid=Validator::make(['target'=>$d],[
                            'target'=>'required|numeric',
                        ]);

                        if($valid->fails()){
                            Alert::error('Error','Tipe Data tidak valid');
                            return back();
                        }
                    }                        
                    
                  

                    $ind_tg=DB::table('ind_psn_target')->where('tahun',$key)->where('id_ind_psn',$data->id)
                    ->update([
                        'target'=>$d,
                        'updated_at'=>Carbon::now(),
                        'id_user'=>$uid
                    ]);

                }else{


                    $ind_tg=DB::table('ind_psn_target')
                    ->insert([
                        'id_pn'=>$data->id_pn,
                        'id_pp'=>$data->id_pp,
                        'id_kp'=>$data->id_kp,
                        'id_propn'=>$data->id_propn,
                        'id_psn'=>$data->id_psn,
                        'id_ind_psn'=>$data->id,
                        'tahun'=>$key,
                        'id_urusan'=>$data->id_urusan,
                        'target'=>$d,
                        'id_sub_urusan'=>$data->id_sub_urusan,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now(),
                        'id_user'=>$uid
                    ]);
                }
            }



            if($ind_tg){
                Alert::success('Berhasil');
            }

        }else{
            Alert::error('Gagal');
        }

        return back();





    } 


    public function update_ind_psn_meta($id,Request $request){

        $valid=Validator::make($request->all(),[
            'cal_type'=>'required|string|in:min_accept,max_accept,aggregate,none,aggregate_min',
            'satuan'=>'required|string|exists:master_satuan,id',
            'lokus_text'=>'string|nullable',
            'pelaksana'=>'string|nullable',

        ]);


        if($valid->fails()){
            return back();
        }else{

             if(in_array($request->cal_type, ['min_accept','max_accept','aggregate','aggregate_min'])){
                     
                   $d=DB::table('view_check_ind_to_cal')->where('id',$id)->where('all_is_number',true)->first();
                   if(!$d){
                       Alert::error('Error','Terdapat data target dengan Tipe data text, mohon rubah terlebih dahulu!') ;

                       return back();
                   } 
             }    


            $tahun=Hp::fokus_tahun();
            $id_urusan=Hp::fokus_urusan()['id_urusan'];
            $data=DB::table('master_ind_psn as ind')->
            select('ind.*')
            ->join('pic_psn_urusan as pic','pic.id_psn','=','ind.id_psn')
            ->where('ind.id',$id)
            ->where('pic.id_urusan',$id_urusan)
            ->first();
           if($data){
            $k_pusat=isset($request->k_pusat)?true:false;
            $k_pro=isset($request->k_pro)?true:false;
            $k_kota=isset($request->k_kota)?true:false;

             $data=DB::table('master_ind_psn as ind')->where('id',$id)->update([
                'id_satuan'=>$request->satuan,
                'cal_type'=>$request->cal_type,
                'updated_at'=>Carbon::now(),
                'k_kota'=>$k_kota,
                'k_pusat'=>$k_pusat,
                'k_pro'=>$k_pro,
                'lokus_text'=>$request->lokus_text,
                'pelaksana'=>$request->pelaksana

            ]);

            if($data){
                Alert::success('Update Data Berhasil');
            }else{
                Alert::error('Gagal');
            }


           }else{
                Alert::error('Gagal');

           }

        }


        return back();
    }

}
