<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbPsn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //

         Schema::create('master_psn', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_pn')->unsigned();
            $table->bigInteger('id_pp')->unsigned();
            $table->bigInteger('id_kp')->unsigned();
            $table->bigInteger('id_propn')->unsigned();

            // $table->bigInteger('id_urusan')->unsigned()->nullable();
            // $table->bigInteger('id_sub_urusan')->unsigned()->nullable();
            // $table->string('kode_daerah',4)->unsigned()->nullable();



            $table->text('nama');
            $table->integer('tahun');
            $table->integer('tahun_selesai');
            $table->softDeletes();
            $table->timestamps();

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

            // $table->foreign('id_urusan')
            // ->references('id')->on('master_urusan')
            // ->onDelete('cascade')->onUpdate('cascade');

            // $table->foreign('id_sub_urusan')
            // ->references('id')->on('master_sub_urusan')
            // ->onDelete('cascade')->onUpdate('cascade');

            // $table->foreign('kode_daerah')
            //   ->references('id')->on('master_daerah')
            //   ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('master_psn');
        
    }
}
