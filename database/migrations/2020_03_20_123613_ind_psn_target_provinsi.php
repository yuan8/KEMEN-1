<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndPsnTargetProvinsi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('ind_psn_target_pro', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_ind_psn')->unsigned();
                $table->string('kode_daerah',4)->unsigned();
                $table->text('target');
                $table->integer('tahun');
                $table->boolean('approve')->default(0);
                $table->timestamps();

                $table->foreign('id_ind_psn')
                ->references('id')->on('master_ind_psn')
                ->onUpdate('cascade');

                $table->foreign('kode_daerah')
                ->references('id')->on('master_daerah')
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
        Schema::dropIfExists('ind_psn_target_pro');
        
    }
}
