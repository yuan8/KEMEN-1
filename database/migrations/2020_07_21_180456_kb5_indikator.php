<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kb5Indikator extends Migration
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

        if(!Schema::connection('form')->hasTable($schema.'kb5_indikator')){
             Schema::connection('form')->create($schema.'kb5_indikator',function(Blueprint $table) use ($schema){
                 $table->bigIncrements('id');
                 $table->string('kode_realistic')->nullable();
                 $table->string('kode')->nullable();
                 $table->string('kode_turunan_rkp')->nullable();
                 $table->integer('tahun');
                 $table->text('uraian');
                 $table->text('target');
                 $table->text('target_1')->nullable();
                 $table->integer('tipe_value')->default(0);
                 $table->integer('tipe_cal')->nullable();
                 $table->string('satuan');
                 $table->text('lokus')->nullable();
                 $table->string('satuan_lokus')->nullable();
                 $table->text('pelaksana')->nullable();
                 $table->boolean('kw_nas')->default(0);
                 $table->boolean('kw_p')->default(0);
                 $table->boolean('kw_k')->default(0);
                 $table->bigInteger('id_sub_urusan')->unsigned();
                 $table->bigInteger('id_user')->unsigned();
                 $table->text('data_dukung_nas')->nullable();
                 $table->text('data_dukung_p')->nullable();
                 $table->text('data_dukung_k')->nullable();
                 $table->text('keterangan')->nullable();
                 $table->timestamps();


                $table->foreign('id_sub_urusan')
                    ->references('id')->on('public.master_sub_urusan')
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

        Schema::connection('form')->dropIfExists($schema.'kb5_indikator');

    }
}
