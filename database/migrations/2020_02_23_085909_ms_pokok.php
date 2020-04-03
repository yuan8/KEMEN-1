<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MsPokok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('ms_pokok', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('uraian');
            $table->string('kode_daerah',4)->unsigned();
            $table->bigInteger('id_urusan')->unsigned();
            $table->integer('tahun');
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();

            $table->foreign('kode_daerah')
              ->references('id')->on('master_daerah')
              ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_user')
              ->references('id')->on('users')
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
        Schema::dropIfExists('ms_pokok');
        
    }
}
