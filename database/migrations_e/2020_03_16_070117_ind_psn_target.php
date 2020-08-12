<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndPsnTarget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ind_psn_target', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_ind_psn')->unsigned();
            $table->string('kode_daerah',4)->unsigned()->nullable();
            $table->bigInteger('id_pn')->unsigned()->nullable();
            $table->bigInteger('id_pp')->unsigned()->nullable();
            $table->bigInteger('id_kp')->unsigned()->nullable();
            $table->bigInteger('id_propn')->unsigned()->nullable();
            $table->bigInteger('id_psn')->unsigned()->nullable();
            $table->bigInteger('id_urusan')->unsigned()->nullable();
            $table->bigInteger('id_sub_urusan')->unsigned()->nullable();
            $table->integer('tahun');
            $table->text('target')->nullable();
            $table->bigInteger('id_user')->unsigned();


            $table->foreign('id_user')
              ->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');

          

            $table->foreign('id_urusan')
              ->references('id')->on('master_urusan')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_sub_urusan')
              ->references('id')->on('master_sub_urusan')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('kode_daerah')
              ->references('id')->on('master_daerah')
              ->onDelete('cascade')->onUpdate('cascade');


            $table->foreign('id_pn')
            ->references('id')->on('master_pn')
            ->onDelete('cascade')->onUpdate('cascade');

             $table->foreign('id_pp')
            ->references('id')->on('master_pp')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_kp')
            ->references('id')->on('master_kp')
            ->onDelete('cascade')->onUpdate('cascade');

             $table->foreign('id_propn')
            ->references('id')->on('master_propn')
            ->onDelete('cascade')->onUpdate('cascade');


             $table->foreign('id_psn')
            ->references('id')->on('master_psn')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();

            $table->index(['id_urusan']);
            $table->index(['id_urusan','id_sub_urusan']);
            $table->index(['id_pn']);
            $table->index(['id_pn','id_pp']);
            $table->index(['id_pn','id_pp','id_kp']);
            $table->index(['id_pn','id_pp','id_kp','id_propn']);
            $table->index(['id_pn','id_pp','id_kp','id_propn','id_psn']);
            $table->index(['id_pn','id_pp','id_kp','id_propn','id_psn','id_urusan']);
            $table->index(['id_pn','id_pp','id_kp','id_propn','id_psn','id_urusan','id_sub_urusan']);



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
        Schema::dropIfExists('ind_psn_target');

    }
}
