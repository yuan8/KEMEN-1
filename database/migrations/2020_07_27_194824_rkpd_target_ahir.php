<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class RkpdTargetAhir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        //
        $tahun=date('Y');
        $schema='meta_rkpd.';
         if(!Schema::connection('meta_rkpd')->hasTable($schema.'indikator_program_'.$tahun)){

              Schema::connection('meta_rkpd')->create($schema.'indikator_program_'.$tahun,function(Blueprint $table) use ($schema,$tahun){
                 $table->bigIncrements('id');
                 $table->bigInteger('id_indikator')->unique();
                 $table->text('target')->unsigned();
                 $table->bigInteger('satuan')->unsigned();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();

                $table->foreign('id_user')
                    ->references('id')->on('public.users')
                    ->onDelete('cascade')->onUpdate('cascade');

               
             });

         }

       
         if(!Schema::connection('meta_rkpd')->hasTable($schema.'indikator_kegiatan_'.$tahun)){

              Schema::connection('meta_rkpd')->create($schema.'indikator_kegiatan_'.$tahun,function(Blueprint $table) use ($schema,$tahun){
                 $table->bigIncrements('id');
                 $table->bigInteger('id_indikator')->unique();
                 $table->text('target')->unsigned();
                 $table->bigInteger('satuan')->unsigned();
                 $table->bigInteger('id_user')->unsigned();
                 $table->timestamps();

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
        $schema='meta_rkpd.';
        $tahun=date('Y');

        Schema::connection('meta_rkpd')->dropIfExists($schema.'indikator_kegiatan_'.$tahun);
        Schema::connection('meta_rkpd')->dropIfExists($schema.'indikator_program_'.$tahun);

     }
}
