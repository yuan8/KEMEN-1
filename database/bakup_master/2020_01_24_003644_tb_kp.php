<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbKp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //

         Schema::create('master_kp', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->bigInteger('id_pn')->unsigned();
             $table->bigInteger('id_pp')->unsigned();
             $table->text('nama');
             $table->integer('tahun');
             $table->integer('tahun_selesai');
             $table->timestamps();
             $table->softDeletes();


             $table->foreign('id_pn')
            ->references('id')->on('master_pn')
            ->onDelete('cascade')->onUpdate('cascade');

             $table->foreign('id_pp')
            ->references('id')->on('master_pp')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('master_kp');
        
    }
}
