<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewPsnUrusan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("CREATE VIEW view_pic_psn AS 
            SELECT 
            psn.id as id ,
            max(psn.nama) as nama,
            (pic.id_urusan) as id_urusan
            ,(pic.id_sub_urusan) as id_sub_urusan ,
            max(psn.id_pn) as id_pn,
            max(psn.id_pp) as id_pp,
            max(psn.id_kp) as id_kp,
            max(psn.id_propn) as id_propn,
            max(psn.tahun) as tahun,
            max(psn.tahun_selesai) as tahun_selesai,
            min(pic.id_user) as id_user,max(pic.created_at) as created_at,
            max((case when pic.updated_at is not null  then pic.updated_at   else TO_TIMESTAMP('0001/01/01 01:01:01', 'YYYY/MM/DD HH12:MI:SS')  end)) as updated_at,
            max(CASE WHEN psn.deleted_at IS NULL THEN TO_TIMESTAMP(concat((psn.tahun+4),'/12/31 23:59:59'), 'YYYY/MM/DD HH24:MI:SS') ELSE psn.deleted_at END  ) as deleted_at
            FROM pic_psn_urusan as pic 
            right join master_psn as psn on psn.id=pic.id_psn
            -- where psn.deleted_at is null or pic.deleted_at < NOW() 
            group by pic.id_urusan,pic.id_sub_urusan,psn.id
            order by updated_at DESC   
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
          DB::statement( 'DROP  VIEW IF EXISTS view_pic_psn cascade' );

    }
}
