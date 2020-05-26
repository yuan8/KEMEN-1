<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewPemenuhanTargetPusatPro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("CREATE VIEW view_pemenuhan_target_pusat_pro AS 
            select psnt.id_ind_psn ,
            (psn.uraian ) as uraian,
            psnt.tahun ,
            psnt.target as target_pusat,
            (
            case when (psn.cal_type)='min_accept' 
            then
            (
            select  count(tgd.*) from ind_psn_target_pro as tgd  where tgd.target >= psnt.target and tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
            )
            when 
            (psn.cal_type)='max_accept' 
            then 
            (
            select  count(tgd.*) from ind_psn_target_pro as tgd  where tgd.target <= psnt.target and tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
            )
            when 
            (psn.cal_type)='aggregate'
            then
            (
            select  sum(tgd.target::numeric) from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
            )
            when 
            (psn.cal_type)='aggregate_min'
            then 
            (
            select  sum(-1*(tgd.target::numeric)) from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
            )
            else
            (
            select  count(tgd.*) from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn and tgd.target!='' group by tgd.id_ind_psn limit 1
            
            )
            end 
            ) as terpenuhi,
            case when (psn.cal_type in ('min_accept','max_accept')) then 'acceptable'
            when (psn.cal_type in ('aggregate','aggregate_min'))
            then 'cal'
            else 
            'none'
            end as type,
             psn.cal_type as cal_type,
            (
            case when (psn.cal_type)='min_accept' 
            then
            (
            select  CONCAT(STRING_AGG(tgd.kode_daerah,',')) from ind_psn_target_pro as tgd  where tgd.target >= psnt.target and tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
            )
            when 
            (psn.cal_type)='max_accept' 
            then 
            (
            select CONCAT(STRING_AGG(tgd.kode_daerah,',')) from ind_psn_target_pro as tgd  where tgd.target <= psnt.target and tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
            )
            when 
            (psn.cal_type)='aggregate'
            then
            (
            select  CONCAT(STRING_AGG(tgd.kode_daerah,',')) from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
            )
            when 
            (psn.cal_type)='aggregate_min'
            then 
            (
            select  CONCAT(STRING_AGG(tgd.kode_daerah,',')) from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn group by tgd.id_ind_psn limit 1
            )
            when (psn.cal_type)='none'
            then
            (

              select  CONCAT(STRING_AGG(tgd.kode_daerah,',')) from ind_psn_target_pro as tgd  where  tgd.tahun=psnt.tahun and tgd.id_ind_psn=psnt.id_ind_psn and tgd.target!='' group by tgd.id_ind_psn limit 1
            )
            else
            '()'
            end 
            ) as daerah
            from ind_psn_target as psnt
            join master_ind_psn as psn on psn.id=psnt.id_ind_psn 

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
          DB::statement( 'DROP VIEW view_pemenuhan_target_pusat_pro' );

    }
}
