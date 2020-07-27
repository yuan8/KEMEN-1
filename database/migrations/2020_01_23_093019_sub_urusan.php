<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubUrusan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('master_sub_urusan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_urusan')->unsigned();
            $table->string('nama');
            $table->string('nomeklatur')->nullable();
            
            $table->timestamps();

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
        Schema::dropIfExists('master_sub_urusan');

    }
}
