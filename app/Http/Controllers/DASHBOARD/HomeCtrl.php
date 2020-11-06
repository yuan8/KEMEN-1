<?php

namespace App\Http\Controllers\DASHBOARD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use App\KB5\KONDISI;

class HomeCtrl extends Controller
{
    //

    public static function percertase_color($value){
        $color='black';
        if($value==0){
        $color='black';

        }else if( $value<=20){
                $color='red';
                # code...
                }
        else if( $value<=40){
            $color='orange';
            # code...
         }
         else if( $value<=60){
            $color='yellow';
            # code...
            }
         else if( $value<=80){
            $color='green';
            # code...
            }
         else if( $value<=100){
            $color='#45ff23';
            # code...
            }
        return $color;
    }

    public function index($tahun=null){
        if(is_numeric($tahun){
            $data=DB::connection('bot')->table('public.master_daerah as d')
            ->leftjoin('rkpd.master_'.$tahun.'_status_data as st',[['d.id','=','st.kodepemda'],['st.status','>',DB::raw(0)]])
            ->selectRaw("min(d.id) as id,REPLACE((select p.nama from master_daerah as p where p.id=min(d.id)),'PROVINSI ','') as nama_pemda,count(distinct(d.id)) as jumlah_pemda,count(distinct(st.kodepemda)) as jumlah_pemda_melapor,(count(distinct(d.id))-count(distinct(st.kodepemda))) as jumlah_pemda_tidak_melapor,
                sum(case when left(d.id,2) = st.kodepemda then 1 else 0 end) as provinsi_melapor
                ")
            ->groupBy(DB::RAW('left(d.id,2)'))
            ->get();

            $data_chart=[
                'melapor'=>[],
                'tidak_melapor'=>[],

            ];

            $data_map=[
               
            ];
            foreach ($data as $key => $d) {
                $data_chart['melapor'][]=[
                    'category'=>$d->nama_pemda,
                    'y'=>(int)$d->jumlah_pemda_melapor
                ];
                  $data_chart['tidak_melapor'][]=[
                    'category'=>$d->nama_pemda,
                    'y'=>(int)$d->jumlah_pemda_tidak_melapor
                ];
                $data_map[]=[
                    'id'=>$d->id,
                    'name'=>$d->nama_pemda,
                    'value'=>number_format(($d->jumlah_pemda_melapor/$d->jumlah_pemda),2,',','.'),
                    'color'=>static::percertase_color($d->jumlah_pemda_melapor/$d->jumlah_pemda),
                    'tooltip'=>'<b>'.$d->nama_pemda.'</b> <br>MELAPORKAN RKPD :'.$d->jumlah_pemda_melapor.'/'.$d->jumlah_pemda.'<br>'.($d->provinsi_melapor?'<b>PROVINSI MELAPORKAN RKPD</b>':'<b>PROVINSI TIDAK MELAPORKAN RKPD</b>')
                ];


            }



            $data_chart['category']=$data->pluck('nama_pemda');

        }else{
            return redirect()->route('v.rkpd.prov',['tahun'=>date('Y')]);
        }
    	return view('dashboard.home.index')->with(['tahun'=>$tahun,'data_chart'=>$data_chart,'data_map'=>$data_map]);
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
