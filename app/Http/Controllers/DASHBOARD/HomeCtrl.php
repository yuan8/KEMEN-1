<?php

namespace App\Http\Controllers\DASHBOARD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
<<<<<<< HEAD
=======
use App\KB5\KONDISI;
>>>>>>> 39f9bdbea541cf329922f279acaade62204930b4
class HomeCtrl extends Controller
{
    //

    public function index(){
      dd(md5(12345678));
      dd(DB::table('users')->where('id',1)->get());
    	return view('dashboard.home.index');
    }

    public function detail(){
    	return view('dashboard.rkpd.perbidang');
    }

      public function pemda($kodepemda){
      	$pemda=DB::table('public.master_daerah as d')->where('id',$kodepemda)->first();
    	return view('dashboard.rkpd.perkota')->with(['provinsi'=>$pemda]);
    }

    public function api_pemda($kodepemda,Request $request){

    	$tahun=$request->tahun??2020;
    	$colors=['green','red'];
    	$data=DB::table('public.master_daerah as d')
    	->selectRaw('id as kodepemda,nama as nama_pemda')
    	->where('d.kode_daerah_parent',$kodepemda)->get();

    	$return=['map'=>[],'chart'=>[]];
    	foreach ($data as $key => $d) {
    		$d=(array)$d;
    		$return['map'][]=array(
    			'id'=>$d['kodepemda'],
    			'name'=>$d['nama_pemda'],
    			'value'=>1,
    			'color'=>$colors[rand(0,1)],
    			'jumlah_program'=>rand(1,9),
    			'jumlah_kegiatan'=>rand(0,11),
    			'jumlah_pagu'=>rand(10000,1100000000),

    			'link_detail'=>route('v.rkpd.detail',['tahun'=>$tahun,'kodepemda'=>$d['kodepemda']])
    		);
    		$return['chart'][]=array(
    			'id'=>$d['kodepemda'],
    			'category'=>$d['nama_pemda'],
    			'data'=>[
    				rand(0,10000000000),rand(1,10)
    			],
    			
    		);
    	
    	}

    	return $return;

    }

    public function program(){
        $data=KONDISI::with(['_children._children'])->get()->toArray();


        return view('dashboard.rkpd.program')->with('data',$data);
    }
}
