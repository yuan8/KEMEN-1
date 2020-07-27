<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndikatorPendukungPusat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          if(!Schema::hasTable('kebijakan.tb_2020_ind_keg_pen_pusat')){
             Schema::create('kebijakan.tb_2020_ind_keg_pen_pusat',function(Blueprint $table){
                 $table->bigIncrements('id');
                 $table->bigInteger('id_ind')->unsined();
                 $table->bigInteger('id_ind_pusat')->unsined();
                 $table->unique(['id_ind','id_ind_pusat']);
                 $table->index(['id_ind','id_ind_pusat']);


                    $table->foreign('id_ind_pusat')
                    ->references('id')->on('kebijakan.tb_2020_2024_rpjmn_indikator')
                    ->onDelete('cascade')->onUpdate('cascade');

                    $table->foreign('id_ind')
                    ->references('id')->on('prokeg.tb_2020_ind_kegiatan')
                    ->onDelete('cascade')->onUpdate('cascade');

             });

          }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kebijakan.tb_2020_ind_keg_pen_pusat');
        //
    }
}
