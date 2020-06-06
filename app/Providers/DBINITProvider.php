<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class DBINITProvider extends ServiceProvider
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


    static public function rkpd_db($tahun=2020){

        if(!Schema::hasTable('prokeg.tb_'.$tahun.'_status_file_daerah')){ 
            Schema::create('prokeg.tb_'.$tahun.'_status_file_daerah',function(Blueprint $table)use($tahun){
                $table->bigIncrements('id');
                $table->integer('status')->nullable();
                $table->string('kode_daerah',4)->unsigned();
              
                $table->text('last_date')->nullable();
                $table->timestamps();
                $table->index('kode_daerah');
                $table->foreign('kode_daerah')
                ->references('id')->on('public.master_daerah')
                ->onDelete('cascade')->onUpdate('cascade');
                
            });
        }

        if(!Schema::hasTable('prokeg.tb_'.$tahun.'_program')){ 
            Schema::create('prokeg.tb_'.$tahun.'_program',function(Blueprint $table)use($tahun){
                $table->bigIncrements('id');
                $table->integer('status')->nullable();
                $table->string('kode_daerah',4)->unsigned();
                $table->string('kode_program',200);
                $table->string('kode_skpd')->nullable();
                $table->string('uraian_skpd')->nullable();
                $table->string('kode_bidang')->nullable();
                $table->text('uraian');
                $table->bigInteger('id_urusan')->unsigned()->nullable();
                $table->bigInteger('id_sub_urusan')->unsigned()->nullable();
                // $table->text('pelaksana')->nullable();
                $table->text('keterangan')->nullable();
                $table->timestamps();
                $table->unique(['kode_program','kode_daerah','kode_skpd','kode_bidang','status']);
                $table->index('kode_daerah');

                $table->foreign('id_urusan')
                ->references('id')->on('public.master_urusan')
                ->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('id_sub_urusan')
                ->references('id')->on('public.master_sub_urusan')
                ->onDelete('cascade')->onUpdate('cascade');
                 $table->foreign('kode_daerah')
                ->references('id')->on('public.master_daerah')
                ->onDelete('cascade')->onUpdate('cascade');
                
            });
        }

         if(!Schema::hasTable('prokeg.tb_'.$tahun.'_ind_program')){ 
            Schema::create('prokeg.tb_'.$tahun.'_ind_program',function(Blueprint $table)use($tahun){
                $table->bigIncrements('id');
                $table->integer('status')->nullable();
                $table->string('kode_daerah',4)->unsigned();
                $table->bigInteger('id_program')->unsigned();
                $table->string('kode_ind')->nullable();
                $table->text('indikator');
                $table->double('anggaran',12,3)->nullable()->default(0);
                $table->text('target_awal')->nullable();
                $table->text('target_ahir')->nullable();
                $table->text('satuan')->nullable();
                $table->string('kode_skpd')->nullable();
                $table->text('uraian_skpd')->nullable();
                $table->string('kode_bidang')->nullable();
                // $table->text('pelaksana')->nullable();
                $table->text('keterangan')->nullable();
                $table->timestamps();

                $table->unique(['kode_ind','kode_daerah','kode_skpd','kode_bidang','status','id_program']);
                $table->index(['id_program','kode_daerah']);

                $table->foreign('id_program')
                ->references('id')->on('prokeg.tb_'.$tahun.'_program')
                ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('kode_daerah')
                ->references('id')->on('public.master_daerah')
                ->onDelete('cascade')->onUpdate('cascade');
                
            });
        }

         if(!Schema::hasTable('prokeg.tb_'.$tahun.'_kegiatan')){ 
            Schema::create('prokeg.tb_'.$tahun.'_kegiatan',function(Blueprint $table)use($tahun){
                $table->bigIncrements('id');
                $table->integer('status')->nullable();
                $table->string('kode_daerah',4)->unsigned();
                $table->bigInteger('id_program')->unsigned();
                $table->string('kode_kegiatan',200);
                $table->string('kode_skpd')->nullable();
                $table->string('uraian_skpd')->nullable();
                $table->string('kode_bidang')->nullable();
                $table->text('uraian');
                $table->double('anggaran',12,3)->nullable()->default(0);

                $table->bigInteger('id_urusan')->unsigned()->nullable();
                $table->bigInteger('id_sub_urusan')->unsigned()->nullable();
                // $table->text('pelaksana')->nullable();
                $table->text('keterangan')->nullable();
                $table->timestamps();
                $table->unique(['kode_kegiatan','kode_daerah','kode_skpd','kode_bidang','status','id_program']);
                $table->index('kode_daerah');

                $table->foreign('id_urusan')
                ->references('id')->on('public.master_urusan')
                ->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('id_sub_urusan')
                ->references('id')->on('public.master_sub_urusan')
                ->onDelete('cascade')->onUpdate('cascade');
                 $table->foreign('kode_daerah')
                ->references('id')->on('public.master_daerah')
                ->onDelete('cascade')->onUpdate('cascade');
                 $table->foreign('id_program')
                ->references('id')->on('prokeg.tb_'.$tahun.'_program')
                ->onDelete('cascade')->onUpdate('cascade');
                
            });
        }

         if(!Schema::hasTable('prokeg.tb_'.$tahun.'_ind_kegiatan')){ 
            Schema::create('prokeg.tb_'.$tahun.'_ind_kegiatan',function(Blueprint $table)use($tahun){
                $table->bigIncrements('id');
                $table->integer('status')->nullable();
                $table->string('kode_daerah',4)->unsigned();
                $table->bigInteger('id_kegiatan')->unsigned();
                $table->string('kode_ind')->nullable();
                $table->text('indikator');
                $table->double('anggaran',12,3)->nullable()->default(0);
                $table->text('target_awal')->nullable();
                $table->text('target_ahir')->nullable();
                $table->text('satuan')->nullable();
         
                $table->string('kode_skpd')->nullable();
                $table->string('uraian_skpd')->nullable();
                $table->string('kode_bidang')->nullable();
                // $table->text('pelaksana')->nullable();
                $table->text('keterangan')->nullable();
                $table->timestamps();

                $table->unique(['kode_ind','kode_daerah','kode_skpd','kode_bidang','status','id_kegiatan']);
                $table->index(['id_kegiatan','kode_daerah']);

                $table->foreign('id_kegiatan')
                ->references('id')->on('prokeg.tb_'.$tahun.'_kegiatan')
                ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('kode_daerah')
                ->references('id')->on('public.master_daerah')
                ->onDelete('cascade')->onUpdate('cascade');
                
            });
        }


          if(!Schema::hasTable('prokeg.tb_'.$tahun.'_s_dana')){ 
            Schema::create('prokeg.tb_'.$tahun.'_s_dana',function(Blueprint $table)use($tahun){
                $table->bigIncrements('id');
                $table->text('kode_dana');
                $table->integer('status')->nullable();
                $table->string('kode_daerah',4)->unsigned();
                $table->string('kode_skpd')->nullable();
                $table->string('uraian_skpd')->nullable();
                $table->string('kode_bidang')->nullable();
                $table->bigInteger('id_kegiatan')->unsigned();
                $table->string('kode_sumber_dana')->nullable();
                $table->integer('kode_sumber_dana_supd')->nullable();
                $table->text('sumber_dana')->nullable();
                $table->double('pagu',12,3)->nullable()->default(0);
                $table->timestamps();


                $table->index(['id_kegiatan','kode_daerah']);
                $table->unique(['kode_dana','id_kegiatan']);

                $table->foreign('id_kegiatan')
                ->references('id')->on('prokeg.tb_'.$tahun.'_kegiatan')
                ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('kode_daerah')
                ->references('id')->on('public.master_daerah')
                ->onDelete('cascade')->onUpdate('cascade');
                
            });
        }



    }
}
