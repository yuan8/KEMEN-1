<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use DB;
use Carbon\Carbon;
class SIPD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sipd:status-rkpd {tahun} {kodepemda?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $tahun=$this->argument('tahun');
        $kode_daerah=$this->argument('kodepemda')?$this->argument('kodepemda').'':null;
        if($kode_daerah){
             if(strpos(($kode_daerah.''),'00')!==false){
                $kode_daerah=str_replace('00', '', ($kode_daerah.''));
            }

        }


        $process = new Process('node '.app_path('NodeJS/SIPD/index.js').' '.$tahun); 

        $process->setTimeout(10000);
        $process->setPty(true);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        $schema='prokeg';

        $data=file_get_contents(app_path('NodeJS/SIPD/storage/file-status-rkpd-'.$tahun.'.json'));
        $data=json_decode($data,true);

            $data_return=[];

             foreach ($data['data'] as $key => $d) {
                $status=0;

                switch (1) {
                    case (int)$d['final']:
                        $status=5;
                        break;
                    case (int)$d['rankhir']:
                        $status=4;
                        break;
                    case (int)$d['ranrkpd']:
                        $status=3;
                        break;
                    case (int)$d['ranwal']:
                        $status=2;
                        break;
                    default:
                        # code...
                        $status=0;
                        break;
                }

                $kodar=str_replace('00', '', $d['kodepemda']);
                $pagu=str_replace(',', '.', (str_replace('.', '',$d['pagu'])));
                $data_return[$kodar]=array(
                    'kode_daerah'=>$kodar,
                    'status'=>$status,
                    'anggaran'=>$d['pagu'],
                    'updated_at'=>Carbon::now(),
                    'last_date'=>$d['lastpost'],
                    'anggaran'=>(float)$pagu
                );

             }

             foreach ($data_return as $key => $d) {


                if(substr($d['kode_daerah'],0,2)!='99'){

                    $ds=DB::connection('sink_prokeg')->table($schema."."."tb_".$tahun."_status_file_daerah")
                    ->where(
                        [
                            ['kode_daerah','=',$d['kode_daerah']],
                            // ['status','!=',$d['status']]
                        ]
                    )->first();

                    if(($ds)AND($ds->status!=$d['status'])){

                        $ds=DB::connection('sink_prokeg')->table($schema."."."tb_".$tahun."_status_file_daerah")
                        ->where('id',$ds->id)
                        ->update($d);

                    }else if($ds){

                        $ds=DB::connection('sink_prokeg')->table($schema."."."tb_".$tahun."_status_file_daerah")
                        ->where('id',$ds->id)
                        ->update(
                            $d
                        );
                    }
                    else{

                        $di=DB::connection('sink_prokeg')->table($schema."."."tb_".$tahun."_status_file_daerah")
                        ->where('kode_daerah',$d['kode_daerah'])->insertOrIgnore([
                            'kode_daerah'=>$d['kode_daerah'],
                            'status'=>$d['status'],
                            'anggaran'=>$d['anggaran'],
                            'last_date'=>$d['last_date'],
                            'created_at'=>Carbon::now(),
                            'updated_at'=>Carbon::now()
                        ]);
                    }
                }else{


                }
             }


             if($kode_daerah){
                return $data_return[$kode_daerah];
             }

             return 1;



        
        
    }
}
