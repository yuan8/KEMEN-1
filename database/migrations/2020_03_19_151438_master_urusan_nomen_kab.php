<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MasterUrusanNomenKab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('master_urusan_nomen_kab', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_urusan')->unsigned();
                $table->string('nomenklatur');
                $table->integer('tahun');
                $table->integer('tahun_selesai');
                $table->timestamps();

                $table->foreign('id_urusan')
                  ->references('id')->on('master_urusan')
                  ->onUpdate('cascade');
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
        Schema::dropIfExists('master_urusan_nomen_kab');

    }
}
