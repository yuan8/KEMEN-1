<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Indikator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
          //
        $schema='form.';


         if(!Schema::connection('meta_rkpd')->hasTable($schema.'master_indikator')){
              Schema::connection('meta_rkpd')->create($schema.'master_indikator',function(Blueprint $table) use ($schema){
                $table->bigIncrements('id');
                 $table->string('kode_realistic')->nullable();
                 $table->string('kode')->nullable();
                 $table->string('kewenangan_nas')->nullable();
                 $table->string('kewenangan_p')->nullable();
                 $table->string('kewenangan_k')->nullable();
                 $table->integer('tahun');
                 $table->text('uraian');
                 $table->text('target');
                 $table->text('target_1')->nullable();
                 $table->integer('tipe_value')->default(0);
                 $table->integer('tipe_cal')->nullable();
                 $table->string('satuan');
                 $table->text('lokus')->nullable();
                 $table->string('satuan_lokus')->nullable();
                 $table->text('pelaksana_nas')->nullable();
                 $table->text('pelaksana_p')->nullable();
                 $table->text('pelaksana_k')->nullable();
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

        Schema::connection('meta_rkpd')->dropIfExists($schema.'master_indikator');
        Schema::connection('meta_rkpd')->dropIfExists($schema.'master_indikator');
        
    }
}
