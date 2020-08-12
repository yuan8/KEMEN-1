<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndUrusan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('map_ind_urusan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_psn')->unsigned();
            $table->bigInteger('id_urusan')->unsigned();
            $table->integer('tahun');
            $table->integer('tahun_selesai');
            $table->bigInteger('id_user')->unsigned();
            $table->softDeletes();

            $table->timestamps();

            $table->foreign('id_psn')
              ->references('id')->on('master_psn')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_urusan')
              ->references('id')->on('master_urusan')
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
        Schema::dropIfExists('map_ind_urusan');

    }
}
