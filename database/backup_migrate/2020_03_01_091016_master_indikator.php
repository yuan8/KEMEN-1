<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MasterIndikator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('master_indikator', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('uraian');
            $table->bigInteger('id_pn')->unsigned()->nullable();
            $table->bigInteger('id_pp')->unsigned()->nullable();
            $table->bigInteger('id_kp')->unsigned()->nullable();
            $table->bigInteger('id_propn')->unsigned()->nullable();
            $table->bigInteger('id_psn')->unsigned()->nullable();
            $table->integer('tahun');
            $table->integer('tahun_selesai');
            $table->text('target_1')->nullable();
            $table->text('target_2')->nullable();
            $table->text('target_3')->nullable();
            $table->text('target_4')->nullable();
            $table->text('target_5')->nullable();
            $table->text('cal_type')->nullable();
            $table->integer('id_satuan')->unsigned()->index();
            $table->bigInteger('id_user')->unsigned();


            $table->foreign('id_user')
              ->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');

             $table->foreign('id_satuan')
              ->references('id')->on('master_satuan')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->index(['id_pn']);
            $table->index(['id_pn','id_pp']);
            $table->index(['id_pn','id_pp','id_kp']);
            $table->index(['id_pn','id_pp','id_kp','id_propn']);
            $table->index(['id_pn','id_pp','id_kp','id_propn','id_psn']);


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
        Schema::dropIfExists('master_indikator');

    }
}
