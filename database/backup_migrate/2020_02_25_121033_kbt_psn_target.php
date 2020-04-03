<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KbtPsnTarget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //

          Schema::create('kbt_psn_target', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('uraian_indikator');
            $table->text('uraian_target');
            $table->string('tipe_data');
            $table->bigInteger('id_kbt_psn')->unsigned();
            $table->bigInteger('id_urusan')->unsigned();
            $table->integer('tahun');
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();

            $table->foreign('id_user')
              ->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_urusan')
              ->references('id')->on('master_urusan')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_kbt_psn')
              ->references('id')->on('kbt_psn')
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
        Schema::dropIfExists('kbt_psn_target');
        
    }
}
