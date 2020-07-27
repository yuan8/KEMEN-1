<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbPp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('master_pp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_pn')->unsigned();
            $table->text('nama');
             $table->integer('tahun');
             $table->integer('tahun_selesai');
             $table->softDeletes();

            $table->timestamps();


            $table->foreign('id_pn')
            ->references('id')->on('master_pn')
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
        Schema::dropIfExists('master_pp');
        
    }
}
