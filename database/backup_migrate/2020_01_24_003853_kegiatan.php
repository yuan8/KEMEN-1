<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        //

        Schema::create('kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_kp')->unsigned()->nullable()->index();
            $table->bigInteger('id_propn')->unsigned()->nullable()->index();
            $table->bigInteger('id_psn')->unsigned()->nullable()->index();
            $table->bigInteger('id_spm')->unsigned()->nullable()->index();
            $table->bigInteger('id_sdgs')->unsigned()->nullable()->index();
            $table->bigInteger('id_nspk')->unsigned()->nullable()->index();
            $table->string('kode_daerah',4)->unsigned();
            $table->bigInteger('id_urusan')->unsigned()->nullable();
            $table->bigInteger('id_sub_urusan')->unsigned()->nullable();
            $table->bigInteger('id_program')->unsigned()->index();
            $table->string('kode_kegiatan')->index();
            $table->float('anggaran')->index();



            $table->text('uraian');
             $table->integer('tahun');
             $table->integer('tahun_selesai');
            $table->string('tag')->nullable();
            $table->string('kode_program')->nullable()->index();


            $table->timestamps();

               
            $table->foreign('kode_daerah')
            ->references('id')->on('master_daerah')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_program')
            ->references('id')->on('program')
            ->onDelete('cascade')->onUpdate('cascade');


            $table->foreign('id_kp')
            ->references('id')->on('master_kp')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_propn')
            ->references('id')->on('master_propn')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_psn')
            ->references('id')->on('master_psn')
            ->onDelete('cascade')->onUpdate('cascade');

             $table->foreign('id_spm')
            ->references('id')->on('master_spm')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_sdgs')
            ->references('id')->on('master_sdgs')
            ->onDelete('cascade')->onUpdate('cascade');

           
            $table->foreign('id_urusan')
            ->references('id')->on('master_urusan')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_sub_urusan')
            ->references('id')->on('master_sub_urusan')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('kegiatan');

    }
}
