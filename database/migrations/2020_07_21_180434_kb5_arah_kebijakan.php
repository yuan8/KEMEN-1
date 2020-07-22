<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kb5ArahKebijakan extends Migration
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


         if(!Schema::connection('form')->hasTable($schema.'kb5_arah_kebijakan')){
             Schema::connection('form')->create($schema.'kb5_arah_kebijakan',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kode')->nullable();
                 $table->integer('tahun_mulai');
                 $table->integer('tahun_selesai');
                 $table->text('uraian');
                 $table->bigInteger('id_isu')->unsigned();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();


                $table->foreign('id_isu')
                    ->references('id')->on($schema.'kb5_isu_stategis')
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

        Schema::connection('form')->dropIfExists($schema.'kb5_arah_kebijakan');

    }
}
