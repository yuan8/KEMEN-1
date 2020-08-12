<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndNomenProgkegKab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        //

         Schema::create('ind_nomen_prokeg_kab', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_ind_psn')->unsigned();
                $table->bigInteger('id_nomen')->unsigned();
                $table->string('nomenklatur');
                $table->timestamps();

                $table->foreign('id_ind_psn')
                ->references('id')->on('master_ind_psn')
                ->onUpdate('cascade');

                $table->foreign('id_nomen')
                ->references('id')->on('master_nomenklatur_kabkota')
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
        Schema::dropIfExists('ind_nomen_prokeg_kab');

    }
}
