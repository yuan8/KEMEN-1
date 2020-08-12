<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RekomendasiIndikator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          //
        $schema='meta_rkpd.';


         if(!Schema::connection('meta_rkpd')->hasTable($schema.'rekomendasi_indikator')){
              Schema::connection('meta_rkpd')->create($schema.'rekomendasi_indikator',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kodepemda',4)->nullable();
                 $table->integer('tahun');
                 $table->integer('jenis')->default(1);
                 $table->bigInteger('id_indikator')->unsigned();
                 $table->bigInteger('id_rekom')->unsigned();
                 $table->text('target')->nullable();
                 $table->text('target_1')->nullable();


                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_rekom')
                    ->references('id')->on($schema.'rekomendasi')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_indikator')
                    ->references('id')->on('form.'.'master_indikator')
                    ->onDelete('cascade')->onUpdate('cascade');


             });

         }

          if(!Schema::connection('meta_rkpd')->hasTable($schema.'rekomendasi_indikator_kab')){
              Schema::connection('meta_rkpd')->create($schema.'rekomendasi_indikator_kab',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kodepemda',4)->nullable();
                 $table->integer('tahun');
                 $table->integer('jenis')->default(1);
                 $table->bigInteger('id_indikator')->unsigned();
                 $table->bigInteger('id_rekom')->unsigned();
                 $table->text('target')->nullable();
                 $table->text('target_1')->nullable();
                 $table->bigInteger('id_user')->unsigned();
                 

                 $table->timestamps();

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_rekom')
                    ->references('id')->on($schema.'rekomendasi_kab')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_indikator')
                    ->references('id')->on('form.'.'master_indikator')
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

        Schema::connection('meta_rkpd')->dropIfExists($schema.'rekomendasi_indikator');
        Schema::connection('meta_rkpd')->dropIfExists($schema.'rekomendasi_indikator_kab');
        
    }
}
