<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Builder extends Controller
{
    //


    static function  trimALL($string){
        $string= trim(preg_replace('/\s\s+/', ' ', $string));
        $string=explode(':', $string);
        if(count($string)>1){
            $string=$string[1];

        }else{
            $string=$string[0];
        }


        $string=trim($string);
        $string=utf8_encode($string);

        return strtoupper($string);
    }
    public function pn(){
    	DB::table('master_pn')->truncate();

    	DB::connection('dev')
    	->table('');

    } 
    public function pp(){
    	DB::table('master_pn')->truncate();

    	DB::connection('dev')
    	->table('');

    } 

    public function kp(){
    	DB::table('master_pn')->truncate();

    	DB::connection('dev')
    	->table('');

    } 

    public function propn(){
    	DB::table('master_pn')->truncate();
    	DB::connection('dev')
    	->table('');
    } 

     public function psn(){
        DB::table('master_pn')->truncate();
       
        $data=DB::connection('dev')
        ->table('master_pn_2020_pn')->get();

        foreach ($data as $key => $d) {
            DB::table('master_pn')->insert([
                'nama'=>$d->id.':'.static::trimALL($d->pn),
                'tahun'=>2020,
                'tahun_selesai'=>2024
                ]
            );
        }

         DB::table('master_pp')->truncate();
       
        $data=DB::connection('dev')
        ->table('master_pn_2020_pp')->get();

        foreach ($data as $key => $d) {
            
            $t=DB::table('master_pn')->where('nama','like',($d->id_pn.':%'))->first();
            DB::table('master_pp')->insert([
                'nama'=>$d->id_pn.'.'.$d->id_pp.':'.static::trimALL($d->pp),
                'id_pn'=>$t->id,
                'tahun'=>2020,
                'tahun_selesai'=>2024
            ]

            );

        
        }

        $t=0;

        DB::table('master_kp')->truncate();
       
        $data=DB::connection('dev')
        ->table('master_pn_2020_kp')->get();

        foreach ($data as $key => $d) {
            
            $t=DB::table('master_pp')->where('nama','like',($d->id_pn.'.'.$d->id_pp.':%'))->first();

            DB::table('master_kp')->insert([
                'nama'=>$d->id_pn.'.'.$d->id_pp.'.'.$d->id_kp.':'.static::trimALL($d->kp),
                'id_pn'=>$t->id_pn,
                'id_pp'=>$t->id,
                'tahun'=>2020,
                'tahun_selesai'=>2024

            ]);

        
        }


        $t=0;
        DB::table('master_propn')->truncate();
       
        $data=DB::connection('dev')->table('master_pn_2020_propn')->get();
        foreach ($data as $key => $d) {
            $t=DB::table('master_kp')->where('nama','like',($d->id_pn.'.'.$d->id_pp.'.'.$d->id_kp.':%'))->first();
            DB::table('master_propn')->insert([
                'nama'=>$d->id_pn.'.'.$d->id_pp.'.'.$d->id_kp.'.'.$d->id_propn.':'.static::trimALL($d->propn),
                'id_pn'=>$t->id_pn,
                'id_pp'=>$t->id_pp,
                'id_kp'=>$t->id,
                'tahun'=>2020,
                'tahun_selesai'=>2024

            ]);


        
        }


        DB::table('master_psn')->truncate();
       
        $data=DB::connection('dev')->table('master_pn_2020_pronas')->get();

        foreach ($data as $key => $d) {
            
            $t=DB::table('master_propn')->where('nama','like',($d->id_pn.'.'.$d->id_pp.'.'.$d->id_kp.'.'.$d->id_propn.':%'))->first();

            if($t){


            }else{

                dd(($d->id_pn.'.'.$d->id_pp.'.'.$d->id_kp.'.'.$d->id_propn.':%'));
            }

            DB::table('master_psn')->insert([
                'nama'=>$d->id_pn.'.'.$d->id_pp.'.'.$d->id_kp.'.'.$d->id_propn.'.'.$d->id_pronas.':'.static::trimALL($d->pronas),
                'id_pn'=>$t->id_pn,
                'id_pp'=>$t->id_pp,
                'id_kp'=>$t->id_kp,
                'id_propn'=>$t->id,
                'tahun'=>2020,
                'tahun_selesai'=>2024

            ]);


        
        }








        // DB::table('master_psn')->truncate();
        // $data=DB::connection('dev')
        // ->table('master_pn_2020_pronas')->get();

        // foreach ($data as $key => $d) {
        //     $pro=DB::connection('dev')
        //     ->table('master_pn_2020_propn')->where(
        //         [
        //             'id_pn'=>$d->id_pn,
        //             'id_pp'=>$d->id_pp,
        //             'id_kp'=>$d->id_kp,
        //             'id_propn'=>$d->id_propn,

        //         ]
        //     )->first();

        //     if($pro){
        //        $real=DB::table('master_propn')->where('nama','ilike',static::trimALL($pro->propn))->first();
        //        dd($real);
               
        //     }

        // }


    } 
}
