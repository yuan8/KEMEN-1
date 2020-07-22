<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kb5IsuStategis extends Migration
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


         if(!Schema::connection('form')->hasTable($schema.'kb5_isu_stategis')){
             Schema::connection('form')->create($schema.'kb5_isu_stategis',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kode')->nullable();
                 $table->integer('tahun_mulai');
                 $table->integer('tahun_selesai');
                 $table->text('uraian');
                 $table->bigInteger('id_kondisi')->unsigned();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();


                $table->foreign('id_kondisi')
                    ->references('id')->on($schema.'kb5_kondisi_saat_ini')
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

        Schema::connection('form')->dropIfExists($schema.'kb5_isu_stategis');

    }
}
