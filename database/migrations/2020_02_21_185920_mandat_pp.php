<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MandatPp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //

          Schema::create('ikb_pp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('uraian');
            $table->bigInteger('id_urusan')->unsigned();
            $table->bigInteger('id_sub_urusan')->unsigned();
            $table->bigInteger('id_mandat')->unsigned();
            $table->integer('tahun');
            $table->bigInteger('id_user')->unsigned();
            $table->unique(['id_urusan','id_sub_urusan','uraian']);
            

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

            $table->foreign('id_mandat')
              ->references('id')->on('ikb_mandat')
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
        Schema::dropIfExists('ikb_pp');
        
    }
}
