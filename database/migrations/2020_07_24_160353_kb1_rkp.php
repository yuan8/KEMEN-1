<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kb1Rkp extends Migration
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
        $schema='rkp.';


         if(!Schema::connection('rkp')->hasTable($schema.'master_rkp')){
              Schema::connection('rkp')->create($schema.'master_rkp',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kode')->nullable();
                 $table->integer('tahun');
                 $table->text('uraian');
                 $table->integer('jenis')->default(1);
                 $table->bigInteger('id_pn')->nullable();
                 $table->bigInteger('id_pp')->nullable();
                 $table->bigInteger('id_kp')->nullable();
                 $table->bigInteger('id_propn')->nullable();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_pn')
                    ->references('id')->on($schema.'master_rkp')
                    ->onDelete('cascade')->onUpdate('cascade');

                 $table->foreign('id_pp')
                    ->references('id')->on($schema.'master_rkp')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_kp')
                    ->references('id')->on($schema.'master_rkp')
                    ->onDelete('cascade')->onUpdate('cascade');

                 $table->foreign('id_propn')
                    ->references('id')->on($schema.'master_rkp')
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

        Schema::connection('rkp')->dropIfExists($schema.'pn');
    }
}
