<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DBINITRKPD extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    static public function getData($tahun=2020,$kodepemda){
        if(file_exists(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA/'.$kodepemda.'.json'))){
            $json=file_get_contents(storage_path('app/BOT/SIPD/JSON/  '.$tahun.'/DATA/'.$kodepemda.'.json'));
            $json=json_decode($json,true);
            foreach ($json['data'] as   $u) {
                foreach ($u['program'] as $p) {
                    dd($p);
                }

            
            }
        }

    }


    static public function init($tahun=2020){

        // mysql
        $name_db=['myfinal','myranwal','pgsql'];
        $schema='';
        foreach ($name_db as $n) {
            if($n=='pgsql'){
                $schema='rkpd.';
                // dd(Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_status'));

            }
             if(!Schema::connection($n)->hasTable($schema.'master_daerah')){
                Schema::connection($n)->create($schema.'master_daerah',function(Blueprint $table)use($tahun,$schema){

                    $table->string('id')->primary()->unique();
                    $table->string('nama')->unique();
                    $table->string('kode_daerah_parent')->nullable();

                });

                $dt=DB::table('master_daerah')->select('id','nama','kode_daerah_parent')->get();
                $dt=json_encode($dt);
                $dt=json_decode($dt,true);

                DB::connection($n)->table($schema.'master_daerah')->insertOrIgnore($dt);


             }

            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_status')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_status',function(Blueprint $table)use($tahun,$schema){
                    $table->bigIncrements('id');
                    $table->string('kodepemda',4)->unique();
                    $table->integer('tahun')->default($tahun);
                    $table->integer('status')->default(0);
                    $table->double('anggaran',20,3)->default(0);
                    $table->string('last_date')->nullable();
                    $table->timestamps();
                    $table->unique(['kodepemda','tahun']);
                
                });
             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_program')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_program',function(Blueprint $table)use($tahun,$schema){
                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('uraibidang');
                    $table->integer('id_urusan')->nullable();
                    $table->string('kodeprogram');
                    $table->text('uraiprogram');
                    $table->string('kodeskpd');
                    $table->string('uraiskpd');
                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','id_urusan'],'program_un');
                    // $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram']);

                
                });


             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_program_capaian')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_program_capaian',function(Blueprint $table)use($tahun,$schema){
                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();
                    $table->bigInteger('id_program')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('kodeprogram');
                    $table->string('kodeskpd');
                    $table->string('kodeindikator')->nullable();
                    $table->text('tolokukur');
                    $table->text('satuan')->nullable();
                    $table->text('real_p3')->nullable();
                    $table->double('pagu_p3',20,3)->nullable();
                    $table->text('real_p2')->nullable();
                    $table->double('pagu_p2',20,3)->nullable();
                    $table->text('real_p1')->nullable();
                    $table->double('pagu_p1',20,3)->nullable();
                    $table->text('target')->nullable();
                    $table->double('pagu',20,3)->nullable();
                    $table->double('pagu_p',20,3)->nullable();
                    $table->text('target_n1')->nullable();
                    $table->double('pagu_n1',20,3)->nullable();

                    if($schema!=''){
                        $table->integer('jenis')->nullable();
                        $table->timestamps();
                    }

                    $table->foreign('id_program')
                    ->references('id')->on($schema.'master_'.$tahun.'_program')
                    ->onDelete('cascade')->onUpdate('cascade');

                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodeindikator','id_program'],'program_capaian_un');
                
                });


             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_program_prio' ) ){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_program_prio',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();
                    $table->bigInteger('id_program')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('kodeskpd');
                    $table->string('kodeprogram');
                    $table->string('kodeprioritas')->nullable();
                    $table->string('jenis')->nullable();
                    $table->text('uraiprioritas')->nullable();

                    // $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodeprioritas']);
                   

                     $table->foreign('id_program')
                    ->references('id')->on($schema.'master_'.$tahun.'_program')
                    ->onDelete('cascade')->onUpdate('cascade');

                     $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodeprioritas','jenis','id_program'],'program_prio_un');
                
                });


             }

            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');

                    $table->bigInteger('id_program')->unsigned();
                    $table->integer('status')->nullable();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->integer('id_urusan')->nullable();
                    $table->string('kodeskpd');
                    $table->string('kodeprogram');
                    $table->string('kodekegiatan');
                    $table->text('uraikegiatan');
                    $table->double('pagu',20,3)->nullable()->default(0);
                    $table->double('pagu_p',20,3)->nullable()->default(0);

                    if($schema!=''){
                        $table->integer('jenis')->nullable();
                        $table->integer('kode_lintas_urusan')->nullable();

                        $table->timestamps();
                    }


                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','id_urusan','id_program'],'kegiatan_un');
                   

                     $table->foreign('id_program')
                    ->references('id')->on($schema.'master_'.$tahun.'_program')
                    ->onDelete('cascade')->onUpdate('cascade');
                
                });


             }

            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_indikator')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_indikator',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();

                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('kodeskpd');
                    $table->string('kodeprogram');
                    $table->string('kodekegiatan');
                    $table->string('kodeindikator')->nullable();
                    $table->text('tolokukur');
                    $table->text('satuan')->nullable();
                    $table->text('real_p3')->nullable();
                    $table->double('pagu_p3',20,3)->nullable();
                    $table->text('real_p2')->nullable();
                    $table->double('pagu_p2',20,3)->nullable();
                    $table->text('real_p1')->nullable();
                    $table->double('pagu_p1',20,3)->nullable();
                    $table->text('target')->nullable();
                    $table->double('pagu',20,3)->nullable();
                    $table->double('pagu_p',20,3)->nullable();
                    $table->text('target_n1')->nullable();
                    $table->double('pagu_n1',20,3)->nullable();


                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodeindikator','id_kegiatan'],'kegiatan_indikator_un');

                    // $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodeindikator'],'kegiatan_indikator_index_un');

                     $table->foreign('id_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');
                
                });


             }

            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_sumberdana')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_sumberdana',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();

                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('kodeskpd');
                    $table->string('kodeprogram');
                    $table->string('kodekegiatan');
                    $table->string('kodesumberdana')->nullable();
                    $table->string('sumberdana')->nullable();
                    $table->double('pagu',20,2)->default(0);

               
                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesumberdana','id_kegiatan','sumberdana'],'kegiatan_sumberdana_index_un');

                     $table->foreign('id_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');
                
                });


             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_lokasi')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_lokasi',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();

                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('kodeskpd');
                    $table->string('kodeprogram');
                    $table->string('kodekegiatan');
                    $table->string('kodelokasi')->nullable();
                    $table->text('lokasi')->nullable();
                    $table->text('detaillokasi')->nullable();

                 
                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodelokasi','id_kegiatan','detaillokasi'],'kegiatan_lokasi_index_un');

                     $table->foreign('id_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');
                });

             }

            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_prio')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_prio',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();

                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('kodeskpd');
                    $table->string('kodeprogram');
                    $table->string('kodekegiatan');
                    $table->string('kodeprioritas')->nullable();
                    $table->string('jenis')->nullable();
                    $table->text('uraiprioritas')->nullable();

                    // $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodeprioritas'],'kegiatan_prio_un');

                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodeprioritas','id_kegiatan','jenis'],'kegiatan_prio_index_un');

                     $table->foreign('id_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');
                
                });


             }

              if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_sub')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_sub',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();

                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->integer('id_urusan')->nullable();
                    $table->string('kodeskpd');
                    $table->string('kodeprogram');
                    $table->string('kodekegiatan');
                    $table->string('kodesubkegiatan')->nullable();
                    $table->text('uraisubkegiatan')->nullable();
                    $table->double('pagu',20,3)->default(0);
                    $table->double('pagu_p',20,3)->default(0);

                    // $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesubkegiatan'],'sub_un');
                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesubkegiatan','id_kegiatan'],'sub_index_un');

                     $table->foreign('id_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');
                
                });


             }

            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_sub_indikator')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_sub_indikator',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();

                    $table->bigInteger('id_sub_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('kodeskpd');

                    $table->string('kodeprogram');
                    $table->string('kodekegiatan');
                    $table->string('kodesubkegiatan')->nullable();
                    $table->string('kodeindikator')->nullable();
                    $table->text('tolokukur');
                    $table->text('satuan')->nullable();
                    $table->text('real_p3')->nullable();
                    $table->double('pagu_p3',20,3)->nullable();
                    $table->text('real_p2')->nullable();
                    $table->double('pagu_p2',20,3)->nullable();
                    $table->text('real_p1')->nullable();
                    $table->double('pagu_p1',20,3)->nullable();
                    $table->text('target')->nullable();
                    $table->double('pagu',20,3)->nullable();
                    $table->double('pagu_p',20,3)->nullable();
                    $table->text('target_n1')->nullable();
                    $table->double('pagu_n1',20,3)->nullable();


                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesubkegiatan','kodeindikator'],'sub_indikator_un');
                 
                     $table->foreign('id_sub_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan_sub')
                    ->onDelete('cascade')->onUpdate('cascade');
                
                });


             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_sub_lokasi')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_sub_lokasi',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();

                    $table->bigInteger('id_sub_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('kodeskpd');
                    $table->string('kodeprogram');
                    $table->string('kodekegiatan');
                    $table->string('kodesubkegiatan');
                    $table->string('kodelokasi')->nullable();
                    $table->text('lokasi')->nullable();
                    $table->text('detaillokasi')->nullable();

                    $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesubkegiatan','kodelokasi','detaillokasi','id_sub_kegiatan'],'sub_lokasi_un');
                    // $table->unique(['kodepemda','tahun','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodelokasi','kodesubkegiatan','id_sub_kegiatan'],'sub_lokasi_index_un');

                     $table->foreign('id_sub_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan_sub')
                    ->onDelete('cascade')->onUpdate('cascade');
                });

             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_sub_prio')){ 

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_sub_prio',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();

                    $table->bigInteger('id_sub_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang');
                    $table->string('kodeskpd');
                    $table->string('kodeprogram');
                    $table->string('kodekegiatan');
                    $table->string('kodesubkegiatan');
                    $table->string('kodeprioritas')->nullable();
                    $table->string('jenis',50)->nullable();
                    $table->text('uraiprioritas')->nullable();

                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesubkegiatan','kodeprioritas','jenis',],'subprioun');
                   
                     $table->foreign('id_sub_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan_sub')
                    ->onDelete('cascade')->onUpdate('cascade');
                
                });


             }





            # code...
        }

        return 'done';
       


        // posgres

    }
}
