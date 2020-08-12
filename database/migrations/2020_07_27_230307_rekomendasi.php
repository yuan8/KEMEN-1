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


         if(!Schema::connection('meta_rkpd')->hasTable($schema.'rekomendasi')){
              Schema::connection('meta_rkpd')->create($schema.'rekomendasi',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kodepemda',4)->unsigned();
                 $table->integer('tahun');
                 $table->integer('jenis')->default(1);
                 $table->bigInteger('id_nomen')->unsigned();
                 $table->bigInteger('id_rkp')->nullable();
                 $table->bigInteger('id_p')->nullable();
                 $table->bigInteger('id_k')->nullable();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_p')
                    ->references('id')->on($schema.'rekomendasi')
                    ->onDelete('cascade')->onUpdate('cascade');

                 $table->foreign('id_k')
                    ->references('id')->on($schema.'rekomendasi')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('kodepemda')
                    ->references('id')->on('public.master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                 $table->foreign('id_rkp')
                    ->references('id')->on('rkp.master_rkp')
                    ->onDelete('cascade')->onUpdate('cascade');

             });

         }

          if(!Schema::connection('meta_rkpd')->hasTable($schema.'rekomendasi_kab')){
              Schema::connection('meta_rkpd')->create($schema.'rekomendasi_kab',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kodepemda',4)->unsigned();
                 $table->integer('tahun');
                 $table->integer('jenis')->default(1);
                 $table->bigInteger('id_nomen')->unsigned();
                 $table->bigInteger('id_rkp')->nullable();
                 $table->bigInteger('id_p')->nullable();
                 $table->bigInteger('id_k')->nullable();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_p')
                    ->references('id')->on($schema.'rekomendasi_kab')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('kodepemda')
                    ->references('id')->on('public.master_daerah')
                    ->onDelete('cascade')->onUpdate('cascade');

                 $table->foreign('id_k')
                    ->references('id')->on($schema.'rekomendasi_kab')
                    ->onDelete('cascade')->onUpdate('cascade');

                  $table->foreign('id_rkp')
                    ->references('id')->on('rkp.master_rkp')
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

        Schema::connection('meta_rkpd')->dropIfExists($schema.'rekomendasi_kab');
        Schema::connection('meta_rkpd')->dropIfExists($schema.'rekomendasi');

        
    }
}
