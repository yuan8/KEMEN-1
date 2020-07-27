<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RkpIndikator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        $schema='rkp.';
         if(!Schema::connection('rkp')->hasTable($schema.'rkp_indikator')){

              Schema::connection('rkp')->create($schema.'rkp_indikator',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->bigInteger('id_rkp')->unsigned();
                 $table->bigInteger('id_indikator')->unsigned();
                 $table->integer('jenis')->default(1);
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_rkp')
                    ->references('id')->on($schema.'master_rkp')
                    ->onDelete('cascade')->onUpdate('cascade');

                 $table->foreign('id_indikator')
                    ->references('id')->on('form.kb5_indikator')
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
        $schema='rkp.';
        
        Schema::connection('rkp')->dropIfExists($schema.'rkp_indikator');
     }

}
