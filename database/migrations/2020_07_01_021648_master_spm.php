<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MasterSpm extends Migration
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


         if(!Schema::connection('pgsql')->hasTable($schema.'master_spm_'.env('TAHUN'))){
              Schema::connection('pgsql')->create($schema.'master_spm_'.env('TAHUN'),function(Blueprint $table) use ($schema){
                    $table->bigIncrements('id');
                    $table->integer('tahun');
                    $table->bigInteger('id_urusan')->unsigned();
                    $table->bigInteger('id_sub_urusan')->nullable();
                    $table->text('uraian');
                    $table->bigInteger('id_user')->unsigned();
                    $table->timestamps();



                    $table->foreign('id_sub_urusan')
                        ->references('id')->on('public.master_sub_urusan')
                        ->onDelete('cascade')->onUpdate('cascade');
                        
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

        Schema::connection('pgsql')->dropIfExists($schema.'master_spm_'.env('TAHUN'));
    }
}
