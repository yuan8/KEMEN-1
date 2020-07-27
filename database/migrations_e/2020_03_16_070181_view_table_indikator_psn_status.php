<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewTableIndikatorPsnStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("CREATE VIEW view_ind_psn_status AS 
            select 
            tg.tahun, 
            tg.id_psn ,
            (select count(*) from master_ind_psn as ind where ind.id_psn = tg.id_psn ) as jumlah_ind,
            count(tg.*) as jumlah_ind_targeted
            from ind_psn_target as tg
            join view_pic_psn as psn on psn.id = tg.id_psn
            where tg.target is not null and psn.tahun_selesai >= tg.tahun and psn.tahun <= tg.tahun
            and psn.deleted_at >= to_timestamp(concat(tg.tahun,'/12/31 23:58:58'),'YYYY/MM/DD HH24:MI:SS')
            group by tg.tahun,tg.id_psn 

                -- select 
                -- tg.tahun, 
                -- psn.id ,
                -- count(ipsn.*) as jumlah_ind,
                -- count(tg.*) as jumlah_ind_targeted
                -- from master_psn as psn
                -- join master_ind_psn as ipsn on psn.id=ipsn.id_psn  
                -- join ind_psn_target as tg on tg.id_ind_psn =ipsn.id and tg.target is not null
                -- where tg.target is not null
                -- group by psn.id,tg.tahun
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
          DB::statement( 'DROP VIEW IF EXISTS view_ind_psn_status' );
    }
}
