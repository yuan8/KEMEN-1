<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hp;
use DB;
use Auth;

use PhpOffice\PhpSpreadsheet\Spreadsheet;	
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DokumentCtrl extends Controller
{
    //

    public function createTemplate(){

    	$urusan=Hp::fokus_urusan();
    	$tahun=Hp::fokus_tahun();
    	$data=DB::table('master_sub_urusan')
    	->where('id_urusan',Hp::fokus_urusan()['id_urusan'])
    	->orderBy('nama','ASC')
    	->get();


		$styleArray = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ],
		    ],
		];

		$styleArray2 = [
		    'fill' => [
		        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
		         'startColor' => ['argb' => '00FF00'],
		    ],
		    'font' => [
		        'bold' => true,
		    ],
		];


		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/template_doc/tem.xlsx'));
		// $spreadsheet->setSheetIndex(0);
		
		$sheet=$spreadsheet->getActiveSheet();
		$sheet->setCellValue('D2',strtoupper(Hp::fokus_urusan()['nama']));
		$sheet->setCellValue('I3',((int)strtoupper($tahun) - 1) );

		$start=8;
		$i=$start;
		foreach ($data as $key => $d) {
			# code...
			$value=('{'.$d->id.'} ').strtoupper($d->nama);
			$spreadsheet->getActiveSheet()->mergeCells('B'.$i.':K'.$i);

			$spreadsheet->getActiveSheet()->setCellValue(('B'.$i),$value);
			$sheet->getStyle('A'.$i.':K'.$i)->applyFromArray($styleArray2);
			$i=$i+10;
		}

		$spreadsheet->getActiveSheet()->getStyle('A'.$start.':K'.$i)->applyFromArray($styleArray);



		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.strtoupper($urusan['nama']).'-'.($tahun-1).'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');

    }
}
