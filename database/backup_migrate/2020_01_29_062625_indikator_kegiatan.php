<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndikatorKegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        //
        Schema::create('indikator_kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_kegiatan')->unsigned();
            $table->text('indikator');
            $table->string('target_awal')->nullable();
            $table->string('target_ahir')->nullable();
            $table->float('anggaran')->nullable();

            $table->string('satuan')->nullable();
             $table->integer('tahun');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_kegiatan')
            ->references('id')->on('kegiatan')
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
        Schema::dropIfExists('indikator_kegiatan');

    }
}
