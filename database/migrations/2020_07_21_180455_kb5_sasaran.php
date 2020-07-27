<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kb5Sasaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
                $schema='form.';

        if(!Schema::connection('form')->hasTable($schema.'kb5_sasaran')){
             Schema::connection('form')->create($schema.'kb5_sasaran',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kode')->nullable();
                 $table->integer('tahun');
                 $table->text('uraian');
                 $table->bigInteger('id_kebijakan')->unsigned();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();


                $table->foreign('id_kebijakan')
                    ->references('id')->on($schema.'kb5_arah_kebijakan')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
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
        //
        
                $schema='form.';

        Schema::connection('form')->dropIfExists($schema.'kb5_sasaran');
        
    }
}
