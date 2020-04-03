<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserUrusan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        //

         Schema::create('user_urusan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned()->index();
            $table->bigInteger('id_urusan')->unsigned()->index();

            $table->timestamps();


            $table->foreign('id_urusan')
            ->references('id')->on('master_urusan')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_user')
            ->references('id')->on('users')->onUpdate('cascade');

          
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
        Schema::dropIfExists('user_urusan');

    }
}
