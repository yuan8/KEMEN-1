<?php

namespace App\Http\Controllers\FRONT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ProgramKegiatan extends Controller
{
    //
    public function index(){
        return view('front.index');
    }

    public function per_urusan(){
    	$tahun=2020;
        $id_dom='per_u';

        DB::connection('sink_prokeg')->enableQueryLog();
    	$data=DB::connection('sink_prokeg')
        ->table('public.master_urusan as u')
        ->Leftjoin(DB::raw('prokeg.tb_'.$tahun.'_'.'kegiatan as k'),'u.id','=','k.id_urusan')
        ->whereNotNull('k.id_sub_urusan')
        ->whereNotNull('k.id_urusan')
        ->whereNotNull('k.id_program')


    	->select(
            "u.id as id",
    		DB::raw("u.nama as nama"),
    		DB::raw("count(k.*) as jumlah_kegiatan"),
    		DB::raw("count(DISTINCT(k.id_program)) as jumlah_program"),
    		DB::raw("sum(k.anggaran)::numeric as jumlah_anggaran")
    	)
    	->groupBy('u.id')
        ->orderBy(DB::raw("jumlah_kegiatan "),'DESC')

    	->get();

        // dd(DB::connection('sink_prokeg')->getQueryLog());

        $data_return=[
            'category'=>[],
            'series'=>[
                0=>[
                                    'name'=>'Jumlah Kegiatan',
                                    'data'=>[]
                                    ],
                1=>[
                                    'name'=>'Jumlah Program',
                                    'data'=>[]
                                    ],
                2=>[
                                    'name'=>'anggaran',
                                    'data'=>[]
                                    ],

            ],
            'data'=>[]
        ];

        foreach ($data as $key => $d) {
        $data_return['category'][]=$d->nama;
        $data_return['series'][0]['data'][]=(int)$d->jumlah_kegiatan;
        $data_return['series'][1]['data'][]=(int)$d->jumlah_program;
        $data_return['series'][2]['data'][]=(float)$d->jumlah_anggaran;
        $data_return['data'][]=$d;

        }

        return view('front.map-tem.map1')
        ->with('data',$data_return)
        ->with('id_dom',$id_dom)
        ->with('title','PROGRAM KEGIATAN PER URUSAN')
        ->with('next','program-kegiatan-per-sub-urusan');
    	// dd($data);

    }

    public function per_sub_urusan($id){

        $tahun=2020;
        $id_dom='per_suu';

        $urusan =DB::table('master_urusan')->find($id);
        DB::connection('sink_prokeg')->enableQueryLog();
        $data=DB::connection('sink_prokeg')
        ->table('public.master_sub_urusan as u')
        ->Leftjoin(DB::raw('prokeg.tb_'.$tahun.'_'.'kegiatan as k'),'u.id','=','k.id_sub_urusan')
        ->whereNotNull('k.id_sub_urusan')
        ->whereNotNull('k.id_urusan')
        ->whereNotNull('k.id_program')

        ->where('k.id_urusan',$id)
        ->select(
            "u.id as id",
            DB::raw("u.nama as nama"),
            DB::raw("count(k.*) as jumlah_kegiatan"),
            DB::raw("count(DISTINCT(k.id_program)) as jumlah_program"),
            DB::raw("sum(k.anggaran)::numeric as jumlah_anggaran")
        )
        ->groupBy('u.id')
        ->orderBy(DB::raw("jumlah_kegiatan "),'DESC')

        ->get();

        // dd(DB::connection('sink_prokeg')->getQueryLog());

        $data_return=[
            'category'=>[],
            'series'=>[
                0=>[
                                    'name'=>'Jumlah Kegiatan',
                                    'data'=>[]
                                    ],
                1=>[
                                    'name'=>'Jumlah Program',
                                    'data'=>[]
                                    ],
                2=>[
                                    'name'=>'anggaran',
                                    'data'=>[]
                                    ],

            ],
            'data'=>[]
        ];

        foreach ($data as $key => $d) {
        $data_return['category'][]=$d->nama;
        $data_return['series'][0]['data'][]=(int)$d->jumlah_kegiatan;
        $data_return['series'][1]['data'][]=(int)$d->jumlah_program;
        $data_return['series'][2]['data'][]=(float)$d->jumlah_anggaran;
        $data_return['data'][]=$d;


        }
   return view('front.map-tem.map1')
        ->with('data',$data_return)
        ->with('id_dom',$id_dom)
        ->with('title','PROGRAM KEGIATAN SUBURUSAN '.$urusan->nama)
        ->with('next','program-kegiatan-per-program');

    }


public function per_program($id){

        $tahun=2020;
        $id_dom='per_suu';

        $urusan =DB::table('master_sub_urusan')->find($id);
        DB::connection('sink_prokeg')->enableQueryLog();
        $data=DB::connection('sink_prokeg')
        ->table('prokeg.tb_'.$tahun.'_'.'kegiatan as k')
        ->whereNotNull('k.id_sub_urusan')
        ->whereNotNull('k.id_urusan')
        ->whereNotNull('k.id_program')
        ->where('k.id_sub_urusan',$id)
        ->select(
            "k.id_program as id",
            DB::raw("(select uraian from prokeg.tb_".$tahun."_program as p where p.id=k.id_program) as nama"),
            DB::raw("(select count(*) from prokeg.tb_".$tahun."_ind_program as ip where ip.id_program=k.id_program) as jumlah_ind"),
            DB::raw("count(k.*) as jumlah_kegiatan"),
            DB::raw("sum(k.anggaran)::numeric as jumlah_anggaran")
        )
        ->groupBy('k.id_program')
        ->orderBy(DB::raw("jumlah_kegiatan "),'DESC')
        ->get();



        // dd(DB::connection('sink_prokeg')->getQueryLog());

        $data_return=[
            'category'=>[],
            'series'=>[
                0=>[
                                    'name'=>'Jumlah Kegiatan',
                                    'data'=>[],
                    ],
                1=>[
                                    'name'=>'anggaran',
                                    'data'=>[]
                    ],

            ],
            'data'=>[]
        ];

        foreach ($data as $key => $d) {
        $data_return['category'][]=$d->nama;
        $data_return['series'][0]['data'][]=(int)$d->jumlah_kegiatan;
        // $data_return['series'][1]['data'][]=(int)$d->jumlah_program;
        $data_return['series'][1]['data'][]=(float)$d->jumlah_anggaran;
        $data_return['data'][]=$d;

        }

        return view('front.map-tem.map_pk')
        ->with('data',$data_return)
        ->with('id_dom',$id_dom)
        ->with('title','PROGRAM  '.$urusan->nama)
        ->with('next','');

        


}

public function daerah(){

    return view('front.daerah');
}

public function per_provinsi(){
    $tahun=2020;
        $id_dom='per_provinsi';

        $data=DB::connection('sink_prokeg')
        ->table('public.master_daerah as u')
        ->Leftjoin(DB::raw('prokeg.tb_'.$tahun.'_'.'kegiatan as k'),'k.kode_daerah','ilike',DB::raw("CONCAT(u.id,'%')"))
        ->whereNotNull('k.id_sub_urusan')
        ->whereNotNull('k.id_urusan')
        ->whereNotNull('k.id_program')
        ->whereNull('u.kode_daerah_parent')

        ->select(
            "u.id as id",
            DB::raw("u.nama as nama"),
            DB::raw("count(k.*) as jumlah_kegiatan"),
            DB::raw("count(DISTINCT(k.id_program)) as jumlah_program"),
            DB::raw("sum(k.anggaran)::numeric as jumlah_anggaran")
        )
        ->groupBy('u.id')
        ->orderBy(DB::raw("jumlah_kegiatan "),'DESC')

        ->get();


        // dd(DB::connection('sink_prokeg')->getQueryLog());

        $data_return=[
            'category'=>[],
            'series'=>[
                0=>[
                                    'name'=>'Jumlah Kegiatan',
                                    'data'=>[]
                                    ],
                1=>[
                                    'name'=>'Jumlah Program',
                                    'data'=>[]
                                    ],
                2=>[
                                    'name'=>'anggaran',
                                    'data'=>[]
                                    ],

            ],
            'data'=>[]
        ];

        foreach ($data as $key => $d) {
        $data_return['category'][]=$d->nama;
        $data_return['series'][0]['data'][]=(int)$d->jumlah_kegiatan;
        $data_return['series'][1]['data'][]=(int)$d->jumlah_program;
        $data_return['series'][2]['data'][]=(float)$d->jumlah_anggaran;
        $data_return['data'][]=$d;

        }

        return view('front.map-tem.map1')
        ->with('data',$data_return)
        ->with('id_dom',$id_dom)
        ->with('title','PROGRAM KEGIATAN PER PROVINSI')
        ->with('next','program-kegiatan-per-kota');
        // dd($data);

}

public function per_kota($id){
    $tahun=2020;
        $id_dom='per_kota';

        $data=DB::connection('sink_prokeg')
        ->table('public.master_daerah as u')
        ->Leftjoin(DB::raw('prokeg.tb_'.$tahun.'_'.'kegiatan as k'),'k.kode_daerah','ilike',DB::raw("CONCAT(u.id,'%')"))
        ->whereNotNull('k.id_sub_urusan')
        ->whereNotNull('k.id_urusan')
        ->whereNotNull('k.id_program')
        ->where('u.kode_daerah_parent',$id)

        ->select(
            "u.id as id",
            DB::raw("u.nama as nama"),
            DB::raw("count(k.*) as jumlah_kegiatan"),
            DB::raw("count(DISTINCT(k.id_program)) as jumlah_program"),
            DB::raw("sum(k.anggaran)::numeric as jumlah_anggaran")
        )
        ->groupBy('u.id')
        ->orderBy(DB::raw("jumlah_kegiatan "),'DESC')

        ->get();


        // dd(DB::connection('sink_prokeg')->getQueryLog());

        $data_return=[
            'category'=>[],
            'series'=>[
                0=>[
                                    'name'=>'Jumlah Kegiatan',
                                    'data'=>[]
                                    ],
                1=>[
                                    'name'=>'Jumlah Program',
                                    'data'=>[]
                                    ],
                2=>[
                                    'name'=>'anggaran',
                                    'data'=>[]
                                    ],

            ],
            'data'=>[]
        ];

        foreach ($data as $key => $d) {
        $data_return['category'][]=$d->nama;
        $data_return['series'][0]['data'][]=(int)$d->jumlah_kegiatan;
        $data_return['series'][1]['data'][]=(int)$d->jumlah_program;
        $data_return['series'][2]['data'][]=(float)$d->jumlah_anggaran;
        $data_return['data'][]=$d;

        }

        return view('front.map-tem.map1')
        ->with('data',$data_return)
        ->with('id_dom',$id_dom)
        ->with('title','PROGRAM KEGIATAN PER KOTA/KAB')
        ->with('next','');
        // dd($data);

}


        public function data($id){
            $tahun=2020;
            $daerah=DB::table('master_daerah')->find($id);

            $data=DB::connection('sink_prokeg')
            ->table(DB::raw('prokeg.tb_'.$tahun.'_'.'kegiatan as k'))
            ->Leftjoin(DB::raw('prokeg.tb_'.$tahun.'_'.'program as p'),'p.id','=','k.id_program')
            ->Leftjoin(DB::raw('prokeg.tb_'.$tahun.'_'.'ind_program as ip'),'ip.id_program','=','k.id_program')
            ->Leftjoin(DB::raw('prokeg.tb_'.$tahun.'_'.'ind_kegiatan as ik'),'ik.id_kegiatan','=','k.id')
            ->select(
                "k.id_urusan as id_urusan",
                DB::raw("(select nama from public.master_urusan where id=k.id_urusan limit 1) as nama_urusan"),
                "k.id_sub_urusan as id_sub_urusan",
                DB::raw("(select nama from public.master_sub_urusan where id=k.id_sub_urusan limit 1) as nama_sub_urusan"),
                "p.id as id_program",
                "p.uraian as nama_program",
                "ip.id as id_ind_p",
                "ip.indikator as nama_ind_p",
                "ip.target_awal as target_ind_p",
                "ip.satuan as satuan_ind_p",

                "k.id as id_kegiatan",
                "k.uraian as nama_kegiatan",
                "ik.id as id_ind_k",
                "ik.indikator as nama_ind_k",
                "ik.target_awal as target_ind_k",
                "ik.satuan as satuan_ind_k",
                "k.anggaran as anggaran"
            )
            ->whereNotNull('k.id_sub_urusan')
            ->whereNotNull('k.id_urusan')
            ->whereNotNull('k.id_program')
            ->where('k.kode_daerah',$id)
            ->orderBy('k.id_urusan','ASC')
            ->orderBy('k.id_sub_urusan','ASC')
            ->orderBy('p.id','ASC')
            ->orderBy('ip.id','ASC')
            ->orderBy('k.id','ASC')
            ->orderBy('ik.id','ASC')
            ->get();



            return view('front.table_daerah')->with('data',$data)->with('daerah',$daerah);


        }
}
