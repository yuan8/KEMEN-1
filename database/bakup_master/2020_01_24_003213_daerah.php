<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Daerah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('master_daerah', function (Blueprint $table) {
            $table->string('id',4)->index()->unique();
            $table->string('kode_daerah_parent',2)->nullable()->index();
            $table->string('nama')->index();
            $table->string('param_1')->nullable();
            $table->string('param_2')->nullable();
            $table->integer('status')->nullable()->index();
            $table->primary('id');
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
        Schema::dropIfExists('master_daerah');

    }
}
