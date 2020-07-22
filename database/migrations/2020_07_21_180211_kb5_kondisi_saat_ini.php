<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kb5KondisiSaatIni extends Migration
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

         if(!Schema::connection('form')->hasTable($schema.'kb5_kondisi_saat_ini')){
             Schema::connection('form')->create($schema.'kb5_kondisi_saat_ini',function(Blueprint $table){
                 $table->bigIncrements('id');
                 $table->string('kode')->nullable();
                 $table->integer('tahun_mulai');
                 $table->integer('tahun_selesai');
                 $table->text('uraian');
                 $table->bigInteger('id_urusan')->unsigned();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();


                $table->foreign('id_urusan')
                    ->references('id')->on('public.master_urusan')
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
        
        Schema::dropIfExists($schema.'kb5_kondisi_saat_ini');

    }
}
