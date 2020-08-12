<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Fingerprint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
           Schema::create('fingerprint', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('id_finger')->unique();
                $table->boolean('approve_login')->default(0);
                $table->bigInteger('id_user')->unsigned()->nullable();

                $table->timestamps();

                $table->foreign('id_user')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('fingerprint');

    }
}
