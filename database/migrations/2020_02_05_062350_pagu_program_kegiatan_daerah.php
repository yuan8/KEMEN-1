<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaguProgramKegiatanDaerah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('anggaran_kegiatan_perdaerah', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_daerah',4)->unsigned()->index();
            $table->float('anggaran')->default(0);
            $table->integer('tahun')->index();
            $table->timestamps();


            $table->foreign('kode_daerah')
            ->references('id')->on('master_daerah')
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
        Schema::dropIfExists('anggaran_kegiatan_perdaerah');
        
    }
}
