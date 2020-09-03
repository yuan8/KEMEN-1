<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MaterNomen extends Migration
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


         if(!Schema::connection('form')->hasTable($schema.'nomenpro_'.env('TAHUN'))){
              Schema::connection('meta_rkpd')->create($schema.'nomenpro_'.env('TAHUN'),function(Blueprint $table) use ($schema){
                    $table->bigIncrements('id');
                    $table->integer('tahun');
                    $table->bigInteger('id_urusan_prio')->nullable();
                    $table->bigInteger('id_urusan')->unsigned();
                    $table->bigInteger('id_program')->nullable();
                    $table->bigInteger('id_kegiatan')->nullable();
                    $table->text('uraian');
                    $table->tinyInteger('jenis')->default(1);
                    $table->string('kode_realistic')->nullable();
                    $table->string('kode')->nullable();
                    $table->timestamps();
                    $table->unique(['kode','id_urusan','tahun']);

                      $table->foreign('id_urusan_prio')
                        ->references('id')->on($schema.'master_urusan_prioritas_'.env('TAHUN'))
                        ->onDelete('cascade')->onUpdate('cascade');
    
                    $table->foreign('id_urusan')
                        ->references('id')->on('public.master_urusan')
                        ->onDelete('cascade')->onUpdate('cascade');

                    $table->foreign('id_program')
                        ->references('id')->on($schema.'nomenpro_'.env('TAHUN'))
                        ->onDelete('cascade')->onUpdate('cascade');

                     $table->foreign('id_kegiatan')
                        ->references('id')->on($schema.'nomenpro_'.env('TAHUN'))
                        ->onDelete('cascade')->onUpdate('cascade');

                    

                   
              });
          }

          if(!Schema::connection('form')->hasTable($schema.'nomenkab_'.env('TAHUN'))){
              Schema::connection('meta_rkpd')->create($schema.'nomenkab_'.env('TAHUN'),function(Blueprint $table) use ($schema){
                    $table->bigIncrements('id');
                    $table->integer('tahun');
                    $table->bigInteger('id_urusan_prio')->nullable();
                    $table->bigInteger('id_urusan')->unsigned();
                    $table->bigInteger('id_program')->nullable();
                    $table->bigInteger('id_kegiatan')->nullable();
                    $table->text('uraian');
                    $table->tinyInteger('jenis')->default(1);
                    $table->string('kode_realistic')->nullable();
                    $table->string('kode')->nullable();
                    $table->timestamps();
                    $table->unique(['kode','id_urusan','tahun']);
                        
                    $table->foreign('id_urusan_prio')
                        ->references('id')->on($schema.'master_urusan_prioritas_'.env('TAHUN'))
                        ->onDelete('cascade')->onUpdate('cascade');

                    $table->foreign('id_urusan')
                        ->references('id')->on('public.master_urusan')
                        ->onDelete('cascade')->onUpdate('cascade');

                    $table->foreign('id_program')
                        ->references('id')->on($schema.'nomenkab_'.env('TAHUN'))
                        ->onDelete('cascade')->onUpdate('cascade');

                     $table->foreign('id_kegiatan')
                        ->references('id')->on($schema.'nomenkab_'.env('TAHUN'))
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

        Schema::connection('form')->dropIfExists($schema.'nomenkab_'.env('TAHUN'));
        Schema::connection('form')->dropIfExists($schema.'nomenpro_'.env('TAHUN'));


    }
}
