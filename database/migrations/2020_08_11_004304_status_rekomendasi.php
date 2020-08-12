<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StatusRekomendasi extends Migration
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


         if(!Schema::connection('meta_rkpd')->hasTable($schema.'rekomendasi_status_final')){
              Schema::connection('meta_rkpd')->create($schema.'rekomendasi_status_final',function(Blueprint $table) use ($schema){
                        $table->bigIncrements('id');
                     $table->string('kodepemda',4)->unsigned();
                     $table->integer('tahun');

                    $table->bigInteger('id_urusan')->unsigned();
                    $table->bigInteger('id_user')->unsigned();
                     

                     $table->timestamps();

                     $table->unique(['kodepemda','id_urusan','tahun']);

                    $table->foreign('kodepemda')
                        ->references('id')->on('public.master_daerah')
                        ->onDelete('cascade')->onUpdate('cascade');
                        
                    $table->foreign('id_urusan')
                        ->references('id')->on('public.master_urusan')
                        ->onDelete('cascade')->onUpdate('cascade');

                     $table->foreign('id_user')
                    ->references('id')->on('public.users')
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

        Schema::connection('meta_rkpd')->dropIfExists($schema.'rekomendasi_status_final');

    }
}
