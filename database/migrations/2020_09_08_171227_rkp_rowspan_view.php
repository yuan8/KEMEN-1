<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RkpRowspanView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        DB::connection('rkp')->statement("create view rkp.rowspan_rkp_".env('TAHUN')." as  (select mr.id, mr.jenis, 
        ((select count(*) as cc from rkp.master_rkp c where (c.id_pn=mr.id) or (c.id_pp=mr.id) or (c.id_kp=mr.id) or (c.id_propn=mr.id))::numeric 
        + 
        (select count(*) as cc from rkp.rkp_indikator ri where ri.id_rkp in (select id as cc from rkp.master_rkp c where (c.id_pn=mr.id) or (c.id_pp=mr.id) or (c.id_kp=mr.id) or (c.id_propn=mr.id) or ri.id_rkp=mr.id ))::numeric
        )::numeric as rowspan
        from rkp.master_rkp  mr) ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::connection('rkp')->statement('DROP VIEW IF EXISTS rkp.rowspan_rkp_'.env('TAHUN'));

    }
}
