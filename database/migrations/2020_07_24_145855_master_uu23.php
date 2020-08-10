<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MasterUu23 extends Migration
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


         if(!Schema::connection('meta_rkpd')->hasTable($schema.'master_kewenangan')){
              Schema::connection('meta_rkpd')->create($schema.'master_kewenangan',function(Blueprint $table) use ($schema){
                $table->bigIncrements('id');
                 $table->string('kode_realistic')->nullable();
                 $table->string('kode')->nullable();
                 $table->string('kewenangan_nas')->nullable();
                 $table->string('kewenangan_p')->nullable();
                 $table->string('kewenangan_k')->nullable();
                 $table->integer('tahun');
                 $table->bigInteger('id_sub_urusan')->unsigned();
                 $table->bigInteger('id_user')->unsigned();

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

        Schema::connection('meta_rkpd')->dropIfExists($schema.'master_kewenangan');
        
    }
}
