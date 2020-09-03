<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MasterPrioritasUrusan extends Migration
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

         if(!Schema::connection('form')->hasTable($schema.'master_urusan_prioritas_'.env('TAHUN'))){
              Schema::connection('meta_rkpd')->create($schema.'master_urusan_prioritas_'.env('TAHUN'),function(Blueprint $table) use ($schema){
                    $table->bigIncrements('id');
                    $table->integer('tahun');
                    $table->text('uraian');
                    $table->timestamps();
                   
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
        
        Schema::connection('form')->dropIfExists($schema.'master_urusan_prioritas_'.env('TAHUN'));

    }
}
