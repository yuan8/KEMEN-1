<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndDataPsn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('ind_data_psn', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('uraian');
            $table->bigInteger('id_ind_psn')->unsigned();

            $table->integer('tahun');
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();

         
            $table->foreign('id_user')
              ->references('id')->on('users')
              ->onDelete('cascade')->onUpdate('cascade');

            // $table->foreign('id_urusan')
            //   ->references('id')->on('master_urusan')
            //   ->onDelete('cascade')->onUpdate('cascade');

            // $table->foreign('id_sub_urusan')
            //   ->references('id')->on('master_sub_urusan')
            //   ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_ind_psn')
              ->references('id')->on('master_ind_psn')
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
        Schema::dropIfExists('ind_data_psn');
        
    }
}
