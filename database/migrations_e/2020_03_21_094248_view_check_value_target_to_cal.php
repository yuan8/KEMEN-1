<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewCheckValueTargetToCal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
            //

        DB::statement("CREATE VIEW view_check_ind_to_cal AS 
        select psn.id,
        (select CASE WHEN SUM(CASE WHEN (textregexeq(case when left(target,1)='-' then (replace(target,'-','')) else target end,'^[[:digit:]]+(\.[[:digit:]]+)?$'))=false  THEN 1 ELSE 0 END) > 0
        THEN FALSE ELSE TRUE end from ind_psn_target ipt  where ipt.id_ind_psn =psn.id
        )AS all_is_number,
        case when (psn.cal_type in ('min_accept','max_accept','aggregate')) then true else false end as parse_cal 
        from master_ind_psn as psn  
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          DB::statement( 'DROP VIEW view_check_ind_to_cal' );
        
    }
}
