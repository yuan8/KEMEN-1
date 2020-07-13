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

                if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_rkpd_sinkron')){
                        Schema::connection($n)->create($schema.'master_'.$tahun.'_rkpd_sinkron',function(Blueprint $table)use($tahun,$schema){

                            $table->string('kodepemda',4)->primary();
                            $table->dateTime('date_updated');
                            $table->string('flag',50);
                            $table->unique(['kodepemda','flag']);


                        });
                       
                }


            }else{

                if(!Schema::connection($n)->hasTable($schema.'master_urusan')){
                    Schema::connection($n)->create($schema.'master_urusan',function(Blueprint $table)use($tahun,$schema){

                        $table->bigIncrements('id');
                        $table->string('nama')->unique();
                        $table->timestamps();

                    });

                    $dt=DB::table('master_urusan')->select('id','nama')->get();
                    $dt=json_encode($dt);
                    $dt=json_decode($dt,true);

                    DB::connection($n)->table($schema.'master_urusan')->insertOrIgnore($dt);


                 }


                  if(!Schema::connection($n)->hasTable($schema.'master_urusan_prioritas')){
                    Schema::connection($n)->create($schema.'master_urusan_prioritas',function(Blueprint $table)use($tahun,$schema){

                        $table->bigIncrements('id');
                        $table->string('nama')->unique();
                        $table->timestamps();

                    });

                    // $dt=DB::table('master_urusan')->select('id','nama')->get();
                    // $dt=json_encode($dt);
                    // $dt=json_decode($dt,true);

                    // DB::connection($n)->table($schema.'master_urusan')->insertOrIgnore($dt);


                 }

                  if(!Schema::connection($n)->hasTable($schema.'master_sub_urusan')){
                    Schema::connection($n)->create($schema.'master_sub_urusan',function(Blueprint $table)use($tahun,$schema){

                        $table->bigIncrements('id');
                        $table->string('nama');
                        $table->bigInteger('id_urusan');
                        $table->timestamps();


                    });

                    $dt=DB::table('master_sub_urusan')->select('id','nama','id_urusan')->get();
                    $dt=json_encode($dt);
                    $dt=json_decode($dt,true);

                    DB::connection($n)->table($schema.'master_sub_urusan')->insertOrIgnore($dt);


                 }



            }


             if(!Schema::connection($n)->hasTable($schema.'master_daerah')){
                Schema::connection($n)->create($schema.'master_daerah',function(Blueprint $table)use($tahun,$schema){

                    $table->string('id',4)->primary()->unique();
                    $table->string('nama')->unique();
                    $table->string('kode_daerah_parent')->nullable();

                });

                $dt=DB::table('master_daerah')->select('id','nama','kode_daerah_parent')->get();
                $dt=json_encode($dt);
                $dt=json_decode($dt,true);

                DB::connection($n)->table($schema.'master_daerah')->insertOrIgnore($dt);


             }




            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_status_data')){
                Schema::connection($n)->create($schema.'master_'.$tahun.'_status_data',function(Blueprint $table)use($tahun,$schema){
                    $table->increments('id');
                    $table->string('kodepemda',4)->unique();
                    $table->integer('status_data')->default(0);
                    $table->date('push_date')->nullable();
                    $table->timestamps();

                });

             
             }


            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_status')){

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_status',function(Blueprint $table)use($tahun,$schema){
                    $table->bigIncrements('id');
                    $table->string('kodepemda',4)->unique();
                    $table->integer('tahun')->default($tahun);
                    $table->integer('status')->default(0);
                    $table->double('anggaran',25,3)->default(0);
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
                    $table->string('kodebidang',50);
                    $table->string('uraibidang')->nullable();
                    $table->bigInteger('kode_urusan_prioritas')->nullable();
                    $table->bigInteger('id_urusan')->nullable();
                    $table->bigInteger('id_sub_urusan')->nullable();
                    $table->string('kodeprogram',100);
                    $table->text('uraiprogram');
                    $table->string('kodeskpd',50);
                    $table->string('uraiskpd');
                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram'],'program_un'.$tahun);
                    $table->timestamps();

                     $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                });


             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_program_capaian')){

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_program_capaian',function(Blueprint $table)use($tahun,$schema){
                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();
                    $table->bigInteger('id_program')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodeskpd',50);
                    $table->string('kodeindikator')->nullable();
                    $table->string('tolokukur',500);
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
                    $table->integer('jenis')->nullable();
                    $table->timestamps();

                    $table->foreign('id_program')
                    ->references('id')->on($schema.'master_'.$tahun.'_program')
                    ->onDelete('cascade')->onUpdate('cascade');

                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodeindikator','id_program'],'program_capaian_un'.$tahun);

                });


             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_program_prioritas' ) ){

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_program_prioritas',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();
                    $table->bigInteger('id_program')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang',50);
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodeprioritas',50)->nullable();
                    $table->string('jenis')->nullable();
                    $table->text('uraiprioritas')->nullable();
                    $table->timestamps();


                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                    // $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodeprioritas']);


                     $table->foreign('id_program')
                    ->references('id')->on($schema.'master_'.$tahun.'_program')
                    ->onDelete('cascade')->onUpdate('cascade');

                     $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodeprioritas','id_program'],'program_prioritas_un'.$tahun);

                });


             }

            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan')){

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');

                    $table->bigInteger('id_program')->unsigned();
                    $table->integer('status')->nullable();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang',50);
                    $table->bigInteger('id_urusan')->nullable();
                    $table->bigInteger('id_sub_urusan')->nullable();
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodekegiatan',100);
                    $table->text('uraikegiatan');
                    $table->double('pagu',20,3)->nullable()->default(0);
                    $table->double('pagu_p',20,3)->nullable()->default(0);
                    $table->integer('jenis')->nullable();
                    $table->integer('kode_lintas_urusan')->nullable();

                    $table->timestamps();


                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                    

                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodekegiatan','id_program'],'kegiatan_un'.$tahun);


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
                    $table->string('kodebidang',50);
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodekegiatan',100);
                    $table->string('kodeindikator')->nullable();
                    $table->string('tolokukur',500);
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
                    $table->integer('jenis')->nullable();
                    $table->timestamps();



                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');


                    $table->unique(['kodepemda','kodebidang','kodeskpd','tolokukur','kodeprogram','kodekegiatan','kodeindikator','id_kegiatan'],'kegiatan_indikator_un'.$tahun);

                   

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
                    $table->string('kodebidang',50);
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodekegiatan',100);
                    $table->string('kodesumberdana',100)->nullable();
                    $table->string('sumberdana')->nullable();
                    $table->double('pagu',20,2)->default(0);
                    $table->timestamps();


                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');


                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesumberdana','id_kegiatan'],'kegiatan_sumberdana_index_un'.$tahun);

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
                    $table->string('kodebidang',50);
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodekegiatan',100);
                    $table->string('kodelokasi',50)->nullable();
                    $table->text('lokasi')->nullable();
                    $table->text('detaillokasi')->nullable();
                    $table->timestamps();


                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');


                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodelokasi','id_kegiatan'],'kegiatan_lokasi_index_un'.$tahun);

                     $table->foreign('id_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');
                });

             }

            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_prioritas')){

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_prioritas',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();

                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang',50);
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                      $table->string('kodekegiatan',100);
                    $table->string('kodeprioritas',50)->nullable();
                    $table->string('jenis')->nullable();
                    $table->text('uraiprioritas')->nullable();
                    $table->timestamps();


                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                   

                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodeprioritas','id_kegiatan'],'kegiatan_prioritas_index_un'.$tahun);

                     $table->foreign('id_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');

                });


             }

              if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_subkegiatan')){

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_subkegiatan',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();
                    $table->bigInteger('id_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang',50);
                    $table->bigInteger('id_urusan')->nullable();
                    $table->bigInteger('id_sub_urusan')->nullable();
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodekegiatan',100);
                    $table->string('kodesubkegiatan')->nullable();
                    $table->text('uraisubkegiatan')->nullable();
                    $table->double('pagu',20,3)->default(0);
                    $table->double('pagu_p',20,3)->default(0);
                    $table->timestamps();


                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                    
                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesubkegiatan','id_kegiatan'],'sub_index_un'.$tahun);

                     $table->foreign('id_kegiatan')
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');

                });


             }

            if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_subkegiatan_indikator')){

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_subkegiatan_indikator',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();
                    $table->bigInteger('id_sub_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang',50);
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodekegiatan',100);
                    $table->string('kodesubkegiatan',100)->nullable();
                    $table->string('kodeindikator',100)->nullable();
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
                    $table->timestamps();


                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');


                   
                     $table->foreign('id_sub_kegiatan','ski_'.$tahun)
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan_subkegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');

                     $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesubkegiatan','kodeindikator','id_sub_kegiatan'],'sub_indikator_un'.$tahun);


                });


             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_subkegiatan_lokasi')){

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_subkegiatan_lokasi',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();
                    $table->bigInteger('id_sub_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang',50);
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodekegiatan',100);
                    $table->string('kodesubkegiatan',100);
                    $table->string('kodelokasi',50)->nullable();
                    $table->text('lokasi')->nullable();
                    $table->text('detaillokasi')->nullable();
                    $table->timestamps();


                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesubkegiatan','kodelokasi','id_sub_kegiatan'],'sub_lokasi_un_'.$tahun);
                    

                     $table->foreign('id_sub_kegiatan','skl_'.$tahun)
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan_subkegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');
                });

             }

             if(!Schema::connection($n)->hasTable($schema.'master_'.$tahun.'_kegiatan_subkegiatan_prioritas')){

                 Schema::connection($n)->create($schema.'master_'.$tahun.'_kegiatan_subkegiatan_prioritas',function(Blueprint $table)use($tahun,$schema){

                    $table->bigIncrements('id');
                    $table->integer('status')->nullable();
                    $table->bigInteger('id_sub_kegiatan')->unsigned();
                    $table->string('kodepemda',4);
                    $table->integer('tahun')->default($tahun);
                    $table->string('kodebidang',50);
                    $table->string('kodeskpd',50);
                    $table->string('kodeprogram',100);
                    $table->string('kodekegiatan',100);
                    $table->string('kodesubkegiatan',100);
                    $table->string('kodeprioritas',50)->nullable();
                    $table->string('jenis',100)->nullable();
                    $table->text('uraiprioritas')->nullable();
                    $table->timestamps();

                    $table->foreign('kodepemda')
                    ->references('id')->on($schema.'master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                    $table->unique(['kodepemda','kodebidang','kodeskpd','kodeprogram','kodekegiatan','kodesubkegiatan','kodeprioritas'],'subprioun'.$tahun);

                     $table->foreign('id_sub_kegiatan','skp_'.$tahun)
                    ->references('id')->on($schema.'master_'.$tahun.'_kegiatan_subkegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');

                });


             }





            # code...
        }

        return 'done';



        // posgres

    }
}
