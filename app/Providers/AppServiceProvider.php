<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        //

        Schema::defaultStringLength(151);

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('PUSAT');
        
            $event->menu->add([
                'text' => 'KEBIJAKAN PUSAT',
                'url'=>route('kebijakan.pusat.index')
            ]);

            $event->menu->add([
                'text' => 'KEBIJAKAN PUSAT 5 TAHUNAN',
                'url'=>route('int.kb5tahun.index')
            ]);

            $event->menu->add([
                'text' => 'KEBIJAKAN PUSAT TAHUNAN',
                'url'=>route('int.kb1tahun.index')
            ]);

            $event->menu->add([
                'text' => 'DATA PELAKSANAAN URUSAN',

                'url'=>route('int.pelurusan.index')
            ]);




            $event->menu->add('DAERAH');
             $event->menu->add([
                'text' => 'INDENTIFIKASI KEBIJAKAN',
                'icon'=>'fa-number-1',
                'url'=>route('kebijakan.daerah.index')
                

            ]);

            $event->menu->add([
                'text' => 'PERMASALAHAN',
                'url'=>route('permasalahan.index')
            ]);

            $event->menu->add([
                'text' => 'PROGRAM KEGIATAN',
                'url'=>route('int.prokeg.index')
            ]);


            $event->menu->add('INTEGRASI');

        

            $event->menu->add([
                'text' => 'INTEGRASI PROGRAM KEGIATAN',
                'url'=>route('int.rekomendasi.index')
            ]);


            // $event->menu->add('PENILAIAN INTEGRASI');
            
           

            


         

       

            // $event->menu->add([
            //     'text' => 'INTEGRASI',
            //     'icon'=>'fa-number-7',

            //     'submenu'=>[
            //         [
            //             'text'=>'PROVINSI',
            //             'icon'=>'fa-sub',
            //             'submenu'=>[
            //                 [
            //                     'text'=>'MAP NOMENLATUR ',
            //                     'url'=>route('integrasi.index'),
            //                 ],
            //                 [
            //                     'text'=>'INTEGRASI NOMENKLATUR',
            //                     'url'=>route('nomen.pro.index'),

            //                 ],
            //                  [
            //                     'text'=>'INTEGRASI INDIKATOR',
            //                     'url'=>route('integrasi.provinsi'),

            //                 ],
            //                 [
            //                     'text'=>'REPORT REKAP INDIKATOR ',
            //                     'url'=>route('res.pro'),
            //                     // 'icon'=>'fa-sub'
            //                 ]

            //             ]


            //         ],
            //         [
            //             'text'=>'KOTA / KABUPATEN',
            //             'icon'=>'fa-sub',
            //             'submenu'=>[
            //                 [
            //                     'text'=>'MAP NOMENLATUR',
            //                     // 'url'=>route('integrasi.index'),

            //                 ],
            //                  [
            //                     'text'=>'INTEGRASI NOMENLATUR ',
            //                     'url'=>route('integrasi.kota'),

            //                 ],
            //                  [
            //                     'text'=>'INTEGRASI INDIKATOR ',
            //                     // 'url'=>route('integrasi.provinsi'),

            //                 ],
            //                 [
            //                     'text'=>'REPORT REKAP INDIKATOR ',
            //                     // 'url'=>route('res.pro'),
            //                     // 'icon'=>'fa-sub'
            //                 ]

            //             ]

            //         ],
                    
            //     ]

            // ]);
            //  $event->menu->add([
            //     'text' => 'MONITORING DAN EVALUASI PELAKSANAAN RENCANA PEMBANGUNAN DAERAH LINGKUP SUPD 2',
            //     'icon'=>'fa-number-8',

            //     'url'=>null
            // ]);
            // $event->menu->add([
            //     'text' => 'EVALUASI CAPAIAN PELAKSANAAN URUSAN PEMERINTAHAN DI INTERNAL DAERAH',
            //     'icon'=>'fa-number-9',

            //     'url'=>null
            // ]);
            // $event->menu->add([
            //     'text' => 'EVALUASI CAPAIAN PELAKSANAAN URUSAN PEMERINTAHAN ',
            //     'icon'=>'fa-number-10',

            //     'url'=>null
            // ]);

            // $event->menu->add('MATER PROGRAM KEGIATAN DAERAH');

            // $event->menu->add([
            //     'text' => 'INTEGRASI APLIKASI DAERAH',

            //     'url'=>null
            // ]);
        });
    }
}
