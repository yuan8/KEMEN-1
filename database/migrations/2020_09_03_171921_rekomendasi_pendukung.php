<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RekomendasiPendukung extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         $schema='meta_rkpd.';


         if(!Schema::connection('meta_rkpd')->hasTable($schema.'rekomendasi_dukungan_pro_'.env('TAHUN'))){
              Schema::connection('meta_rkpd')->create($schema.'rekomendasi_dukungan_pro_'.env('TAHUN'),function(Blueprint $table) use ($schema){
                    $table->bigIncrements('id');
                    $table->integer('tahun');
                    $table->bigInteger('id_rekomendasi')->unsigned();
                    $table->bigInteger('id_rkp')->nullable();
                    $table->bigInteger('id_masalah')->nullable();
                    $table->bigInteger('id_nspk')->nullable();
                    $table->bigInteger('id_spm')->nullable();
                    $table->bigInteger('id_urusan')->unsigned();

                    $table->timestamps();


                    $table->foreign('id_urusan')
                        ->references('id')->on('public.master_urusan')
                        ->onDelete('cascade')->onUpdate('cascade');


                    $table->foreign('id_rekomendasi')
                        ->references('id')->on('meta_rkpd.rekomendasi_'.env('TAHUN'))
                        ->onDelete('cascade')->onUpdate('cascade');
                        
                    $table->foreign('id_rkp')
                        ->references('id')->on('rkp.master_rkp')
                        ->onDelete('cascade')->onUpdate('cascade');

                     $table->foreign('id_nspk')
                        ->references('id')->on('public.ikb_mandat')
                        ->onDelete('cascade')->onUpdate('cascade');

                    $table->foreign('id_spm')
                        ->references('id')->on('form.master_spm_'.env('TAHUN'))
                        ->onDelete('cascade')->onUpdate('cascade');

                     $table->foreign('id_masalah')
                        ->references('id')->on('public.ms')
                        ->onDelete('cascade')->onUpdate('cascade');

                     
              });
          }


         if(!Schema::connection('meta_rkpd')->hasTable($schema.'rekomendasi_dukungan_kab_'.env('TAHUN'))){
              Schema::connection('meta_rkpd')->create($schema.'rekomendasi_dukungan_kab_'.env('TAHUN'),function(Blueprint $table) use ($schema){
                    $table->bigIncrements('id');
                    $table->integer('tahun');
                    $table->bigInteger('id_rekomendasi')->unsigned();
                    $table->bigInteger('id_rkp')->nullable();
                    $table->bigInteger('id_masalah')->nullable();
                    $table->bigInteger('id_nspk')->nullable();
                    $table->bigInteger('id_spm')->nullable();
                    $table->bigInteger('id_urusan')->unsigned();

                    $table->timestamps();


                    $table->foreign('id_rekomendasi')
                        ->references('id')->on('meta_rkpd.rekomendasi_kab_'.env('TAHUN'))
                        ->onDelete('cascade')->onUpdate('cascade');

                    $table->foreign('id_urusan')
                        ->references('id')->on('public.master_urusan')
                        ->onDelete('cascade')->onUpdate('cascade');
                        
                    $table->foreign('id_rkp')
                        ->references('id')->on('rkp.master_rkp')
                        ->onDelete('cascade')->onUpdate('cascade');

                     $table->foreign('id_nspk')
                        ->references('id')->on('public.ikb_mandat')
                        ->onDelete('cascade')->onUpdate('cascade');

                     $table->foreign('id_masalah')
                        ->references('id')->on('public.ms')
                        ->onDelete('cascade')->onUpdate('cascade');

                    
                    $table->foreign('id_spm')
                        ->references('id')->on('form.master_spm_'.env('TAHUN'))
                        ->onDelete('cascade')->onUpdate('cascade');

                     
              });
          }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
         $schema='meta_rkpd.';

        Schema::connection('meta_rkpd')->dropIfExists($schema.'rekomendasi_dukungan_kab_'.env('TAHUN'));
         Schema::connection('meta_rkpd')->dropIfExists($schema.'rekomendasi_dukungan_pro_'.env('TAHUN'));

    }
}
