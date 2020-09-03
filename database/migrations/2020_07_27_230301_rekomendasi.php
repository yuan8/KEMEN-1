<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rekomendasi extends Migration
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


         if(!Schema::connection('meta_rkpd')->hasTable($schema.'rekomendasi_'.env('TAHUN'))){
              Schema::connection('meta_rkpd')->create($schema.'rekomendasi_'.env('TAHUN'),function(Blueprint $table) use ($schema){

                 $table->bigIncrements('id');
                 $table->string('kodepemda',4)->unsigned();
                 $table->integer('tahun');
                 $table->integer('jenis')->default(1);
                 $table->bigInteger('id_nomen')->unsigned();
                 $table->bigInteger('id_urusan')->unsigned();

                 $table->bigInteger('id_p')->nullable();
                 $table->bigInteger('id_k')->nullable();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_urusan')
                    ->references('id')->on('public.master_urusan')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_p')
                    ->references('id')->on($schema.'rekomendasi_'.env('TAHUN'))
                    ->onDelete('cascade')->onUpdate('cascade');

                 $table->foreign('id_k')
                    ->references('id')->on($schema.'rekomendasi_'.env('TAHUN'))
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('kodepemda')
                    ->references('id')->on('public.master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_nomen')
                    ->references('id')->on('form.nomenpro_'.env('TAHUN'))
                    ->onDelete('cascade')->onUpdate('cascade');


             });

         }

          if(!Schema::connection('meta_rkpd')->hasTable($schema.'rekomendasi_kab_'.env('TAHUN'))){
              Schema::connection('meta_rkpd')->create($schema.'rekomendasi_kab_'.env('TAHUN'),function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kodepemda',4)->unsigned();
                 $table->integer('tahun');
                 $table->integer('jenis')->default(1);
                 $table->bigInteger('id_nomen')->unsigned();
                 $table->bigInteger('id_p')->nullable();
                 $table->bigInteger('id_k')->nullable();
                 $table->bigInteger('id_user')->unsigned();
                 $table->bigInteger('id_urusan')->unsigned();

                 $table->timestamps();

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_p')
                    ->references('id')->on($schema.'rekomendasi_kab_'.env('TAHUN'))
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('kodepemda')
                    ->references('id')->on('public.master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                 $table->foreign('id_k')
                    ->references('id')->on($schema.'rekomendasi_kab_'.env('TAHUN'))
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_nomen')
                    ->references('id')->on('form.nomenkab_'.env('TAHUN'))
                    ->onDelete('cascade')->onUpdate('cascade');


                $table->foreign('id_urusan')
                    ->references('id')->on('public.master_urusan')
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

        Schema::connection('meta_rkpd')->dropIfExists($schema.'rekomendasi_kab_'.env('TAHUN'));
        Schema::connection('meta_rkpd')->dropIfExists($schema.'rekomendasi_'.env('TAHUN'));


    }
}
