<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PsnUrusan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('pic_psn_urusan', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_psn')->unsigned();
                $table->bigInteger('id_urusan')->unsigned();
                $table->bigInteger('id_sub_urusan')->unsigned();
                $table->bigInteger('id_user')->unsigned();
                $table->timestamps();
                $table->softDeletes();

                $table->unique(['id_psn','id_urusan','id_sub_urusan']);
                $table->index(['id_psn','id_urusan','id_sub_urusan']);
                $table->index(['id_psn','id_urusan']);
                $table->index(['id_urusan']);
                $table->index(['id_psn']);





                // $table->foreign('kode')
                // ->references('kode')->on('master_nomenklatur_provinsi')
                // ->onUpdate('cascade');

                 $table->foreign('id_psn')
                ->references('id')->on('master_psn')
                ->onUpdate('cascade');

                  $table->foreign('id_urusan')
                ->references('id')->on('master_urusan')
                ->onUpdate('cascade');

                  $table->foreign('id_sub_urusan')
                ->references('id')->on('master_sub_urusan')
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
        Schema::dropIfExists('pic_psn_urusan');

    }
}
