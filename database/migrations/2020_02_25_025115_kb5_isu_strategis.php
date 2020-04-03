<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kb5IsuStrategis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('kb5_isu_strategis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('uraian');
            $table->bigInteger('id_urusan')->unsigned();
            $table->bigInteger('id_kb5_kondisi_saat_ini')->unsigned();
            $table->bigInteger('id_sub_urusan')->unsigned();
            $table->integer('tahun');
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();

            $table->foreign('id_user')
              ->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_urusan')
              ->references('id')->on('master_urusan')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_sub_urusan')
              ->references('id')->on('master_sub_urusan')
              ->onDelete('cascade')->onUpdate('cascade');

             $table->foreign('id_kb5_kondisi_saat_ini')
              ->references('id')->on('kb5_kondisi_saat_ini')
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
        Schema::dropIfExists('kb5_isu_strategis');

    }
}
