<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MasterIndPsn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('master_ind_psn', function (Blueprint $table) {
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
            $table->text('lokus_text')->nullable();
            $table->text('pelaksana')->nullable();
            $table->boolean('k_pusat')->default(0)->nullable();
            $table->boolean('k_pro')->default(0)->nullable();
            $table->boolean('k_kota')->default(0)->nullable();
            // $table->boolean('major')->default(0)->nullable();
            $table->string('type')->nullable();
            $table->string('cal_type')->nullable();
            $table->integer('id_satuan')->unsigned()->index()->nullable();
            $table->bigInteger('id_user')->unsigned();

            $table->foreign('id_user')
              ->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_satuan')
              ->references('id')->on('master_satuan')
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
        Schema::dropIfExists('master_ind_psn');

    }
}
