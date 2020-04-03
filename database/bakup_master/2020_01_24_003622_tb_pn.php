<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbPn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('master_pn', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->text('nama');
             $table->integer('tahun');
             $table->integer('tahun_selesai');
             $table->softDeletes();
            $table->timestamps();
            
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
        Schema::dropIfExists('master_pn');
        
    }
}
