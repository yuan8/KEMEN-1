<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbSpm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //

         Schema::create('master_spm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nama');
            $table->integer('tahun');
            $table->integer('tahun_selesai');
            
            $table->bigInteger('id_urusan')->unsigned()->nullable();
             $table->softDeletes();
            
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
        Schema::dropIfExists('master_spm');
        
    }
}
