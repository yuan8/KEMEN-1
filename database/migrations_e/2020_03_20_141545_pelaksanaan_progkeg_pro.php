<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PelaksanaanProgkegPro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pel_prokeg_pro', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('kode')->unsigned();
                $table->bigInteger('id_nomen')->unsigned();
                $table->string('kode_daerah',4)->unsigned();
                $table->integer('tahun');
                $table->boolean('approve')->default(0);
                $table->timestamps();

                $table->unique(['kode','id_nomen','kode_daerah','tahun']);

                // $table->foreign('kode')
                // ->references('kode')->on('master_nomenklatur_provinsi')
                // ->onUpdate('cascade');

                 $table->foreign('id_nomen')
                ->references('id')->on('master_nomenklatur_provinsi')
                ->onUpdate('cascade');

                $table->foreign('kode_daerah')
                ->references('id')->on('master_daerah')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('pel_prokeg_pro');

    }
}
