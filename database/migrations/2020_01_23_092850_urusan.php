<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Urusan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('master_urusan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('nomenklatur')->nullable();
            $table->string('singkat')->nullable();
            $table->string('kode')->nullable();

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
        Schema::dropIfExists('master_urusan');

    }
}
