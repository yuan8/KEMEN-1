<?php

namespace App\Http\Controllers\SISTEM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Storage;
class RPJMN extends Controller
{
    //

    static function trimParse($text){

    	if(strpos(trim($text),trim('PROGRAM  PRIORITAS  (PP)/ KEGIATAN PRIORITAS  (KP)/ PROYEK PRIORITAS (PROP)/ PROYEK'))!==false){

    		return '';
    	}

    	if(strpos($text,'A.')!==false){
    		return '';
    	}

    	if(empty($text)){
    		return '';
    	}

    	$text= preg_replace("/\r|\n/", " ", $text);
    	$text= trim($text);
    	if($text==' '){
    		$text='';
    	}

    	return ucwords($text);

    }

     static function numering($num,$min=2){
    	$num=''.$num;
    	
    	if(strlen($num)<$min){
    		for($i=($min-((int)strlen($num)));$i<$min;$i++){
    			$num='0'.$num;
    		}
    	}

    	return $num;

    }


    static function idproyek($pn,$pp,$kp,$propn){
    	return 'RPJMN'.($pn!=0??'.'.static::numering($pn)).($pp!=0??'.'.static::numering($pp)).($kp!=0??'.'.static::numering($kp)).($propn!=0??'.'.static::numering($propn));
    }


     static function trimNum($text){
    	$text= preg_replace("/\r|\n/", "", $text);
    	$text= preg_replace("/,/", "", $text);
    	return trim($text);
    }


    public function index(){
    	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('rpjmn.xlsx'));
    	$data_return=[];

    	$pn=[];
    	$pp=[];
    	$kp=[];
    	$propn=[];
    	$proyek=[];

    	$pnk=0;
    	$ppk=0;
    	$kpk=0;
    	$propnk=0;
    	$proyekk=0;

    	$pointer='';
    	$pnx=[];

    	$sheet_count=($spreadsheet->getSheetCount());
    	for($i=0;$i<$sheet_count;$i++){
    		$sheet = $spreadsheet->setActiveSheetIndex($i);

    		foreach ($sheet->toArray() as $key => $d) {


    			if(strpos(static::trimParse($d[2]),'INDIKASI  TARGET')===false){

    					if((static::trimParse($d[0])!='') OR (static::trimParse($d[1])!='')){

    				// print_r($d);
    				// print('<br>');
    				// print('<br>');

    				if(strpos(static::trimParse($d[0]), 'PN :')!==false){
    					// print('<br>');
    					// print('-----PN--');
    					// print('<br>');
			    		$pnk+=1;
			    	

	    				$pn[$pnk]=[
				    		'id'=>'RPJMN.'.static::numering($pnk),
				    		// 'kode'=>,
				    		'nama'=>static::trimParse($d[0]),
		    				'jenis'=>'PN',
				    		'indikator'=>[],
				    		'child'=>[]
			    		];

				    	$ppk=0;
				    	$kpk=0;
				    	$propnk=0;
				    	$proyekk=0;

	    			}else if(static::trimParse($d[2])=='INDIKASI TARGET'){
	    				// if($pn!=[]){
		    			// 	$data_return[$pnk]=$pn;
	    				// 	$pn=[];
	    				// }

    					// $pn=$pnx;

	    				$pointer='PN';
	    				$pointer_ind='PN';


	    				
	    			}else{


	    				if(strpos(static::trimParse($d[0]),'PP :')!==false){
					    	$ppk+=1;
					    	$kpk=0;
					    	$propnk=0;
					    	$proyekk=0;
					    	$indikator=0;

	    					$pp=[
					    		'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk),
					    		'nama'=>trim(static::trimParse($d[0])),
		    					'jenis'=>'PP',
					    		'indikator'=>[],
					    		'child'=>[]
				    		];

			    			$pn[$pnk]['child'][$ppk]=$pp;
	    					


	    					$pointer='PP';
	    					$pointer_ind='PP';


	    				}else if(strpos(static::trimParse($d[0]),'KP :')!==false){
	    					$pointer='KP';
	    					$pointer_ind='KP';

	    					$kpk+=1;
	    					$propnk=0;
					    	$proyekk=0;
					    	$indikator=0;

					    	
	    					

	    					$kp=[
					    		'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.'.static::numering($kpk),
					    		'nama'=>static::trimParse($d[0]),
		    					'jenis'=>'KP',

					    		'indikator'=>[],

					    		'child'=>[]
				    		];	

				    		$pn[$pnk]['child'][$ppk]['child'][$kpk]=$kp;

		    				
	    					

	    				}else if(strpos(static::trimParse($d[0]),'ProP :')!==false){
	    					$pointer='PROPN';
	    					$pointer_ind='PROPN';

	    					$propnk+=1;
					    	$proyekk=0;
					    	$indikator=0;


	    					$propn=[
					    		'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.'.static::numering($kpk).'.'.static::numering($propnk),
					    		'nama'=>static::trimParse($d[0]),
		    					'jenis'=>'PROPN',
					    		'indikator'=>[],
					    		'child'=>[]
				    		];	

				    		$pn[$pnk]['child'][$ppk]['child'][$kpk]['child'][$propnk]=$propn;


	    				}else if((static::trimParse($d[0]))!=''){
	    					switch ($pointer) {
	    						case 'PP':
		    						$proyekk+=1;
					    			$indikator=0;


			    					$proyek=[
			    						'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.PRY.'.static::numering($proyekk),
			    						'nama'=>static::trimParse($d[0]),
			    						'jenis'=>'PRONAS',
			    						'indikator'=>[],
			    						'child'=>[]
			    					];

			    					$pointer_ind='PROYEK';
				    				$pn[$pnk]['child'][$ppk]['proyek'][$proyekk]=$proyek;



	    							# code...
	    							break;
	    						case 'KP':
		    						$proyekk+=1;
					    			$indikator=0;


		    						
			    					$proyek=[
			    						'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.'.static::numering($kpk).'.PRY.'.static::numering($proyekk),
			    						'nama'=>static::trimParse($d[0]),
			    						'jenis'=>'PRONAS',
			    						'indikator'=>[],
			    						'child'=>[]
			    					];
				    				$pn[$pnk]['child'][$ppk]['child'][$kpk]['proyek'][$proyekk]=$proyek;

			    					$$pointer_ind='PROYEK';


	    							# code...
	    							break;
  
	    						case 'PROPN':
		    						$proyekk+=1;
					    			$indikator=0;
		    						
			    					$proyek=[
			    						'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.'.static::numering($kpk).'.'.static::numering($propnk).'.PRY.'.static::numering($proyekk),
			    						'nama'=>static::trimParse($d[0]),
			    						'jenis'=>'PRONAS',
			    						'indikator'=>[],
			    						'child'=>[]
			    					];
				    				$pn[$pnk]['child'][$ppk]['child'][$kpk]['child'][$propnk]['proyek'][$proyekk]=$proyek;


			    					$pointer_ind='PROYEK';


	    							# code...
	    							break;
	    						
	    						default:
	    							# code...
	    							break;
	    					}

	    				}

	    				if(static::trimParse($d[1])!=''){
	    					if(!isset($pointer_ind)){
	    						dd($d);
	    					}
	    					switch ($pointer_ind) {
	    						case 'PP':
	    							$indikator+=1;
	    							$pn[$pnk]['child'][$ppk]['indikator'][$indikator]=[
	    								'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.IND.'.static::numering($indikator,3),
	    								'nama'=>static::trimParse($d[1]),
	    								'jenis'=>'PP',
	    								'target_1_1'=>static::trimNum($d[2]),
	    								'target_2_1'=>static::trimNum($d[3]),
	    								'target_3_1'=>static::trimNum($d[4]),
	    								'target_4_1'=>static::trimNum($d[5]),
	    								'target_5_1'=>static::trimNum($d[6]),
	    								'anggaran'=>static::trimNum($d[7]),
	    								'lokasi'=>static::trimParse($d[8]),
	    								'major'=>static::trimParse($d[9]),
	    								'instansi'=>static::trimParse($d[10]),

	    							];
	    							
	    							# code...
	    							break;
	    						case 'KP':
	    							$indikator+=1;

	    							$pn[$pnk]['child'][$ppk]['child'][$kpk]['indikator'][$indikator]=[
	    								'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.'.static::numering($kpk).'.IND.'.static::numering($indikator,3),
	    								'nama'=>static::trimParse($d[1]),
	    								'jenis'=>'KP',
	    								'target_1_1'=>static::trimNum($d[2]),
	    								'target_2_1'=>static::trimNum($d[3]),
	    								'target_3_1'=>static::trimNum($d[4]),
	    								'target_4_1'=>static::trimNum($d[5]),
	    								'target_5_1'=>static::trimNum($d[6]),
	    								'anggaran'=>static::trimNum($d[7]),
	    								'lokasi'=>static::trimParse($d[8]),
	    								'major'=>static::trimParse($d[9]),
	    								'instansi'=>static::trimParse($d[10]),

	    							];
	    							# code...
	    							# code...
	    							break;
	    						
	    						case 'PROPN':
	    							$indikator+=1;

	    							$pn[$pnk]['child'][$ppk]['child'][$kpk]['child'][$propnk]['indikator'][$indikator]=[
	    								'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.'.static::numering($kpk).'.'.static::numering($propnk).'.IND.'.static::numering($indikator,3),
	    								'nama'=>static::trimParse($d[1]),
	    								'jenis'=>'PROPN',
	    								'target_1_1'=>static::trimNum($d[2]),
	    								'target_2_1'=>static::trimNum($d[3]),
	    								'target_3_1'=>static::trimNum($d[4]),
	    								'target_4_1'=>static::trimNum($d[5]),
	    								'target_5_1'=>static::trimNum($d[6]),
	    								'anggaran'=>static::trimNum($d[7]),
	    								'lokasi'=>static::trimParse($d[8]),
	    								'major'=>static::trimParse($d[9]),
	    								'instansi'=>static::trimParse($d[10]),

	    							];
	    							# code...
	    							break;

	    						case 'PROYEK':
	    							$indikator+=1;
	    						
	    							switch ($pointer) {
	    								case 'PP':
	    									$pn[$pnk]['child'][$ppk]['proyek'][$proyekk]['indikator'][$indikator]=[
		    								'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.PRY.'.static::numering($proyekk).'.IND.'.static::numering($indikator,3),
		    								'nama'=>static::trimParse($d[1]),
		    								'jenis'=>'PRONAS',
		    								'target_1_1'=>static::trimNum($d[2]),
		    								'target_2_1'=>static::trimNum($d[3]),
		    								'target_3_1'=>static::trimNum($d[4]),
		    								'target_4_1'=>static::trimNum($d[5]),
		    								'target_5_1'=>static::trimNum($d[6]),
		    								'anggaran'=>static::trimNum($d[7]),
		    								'lokasi'=>static::trimParse($d[8]),
		    								'major'=>static::trimParse($d[9]),
		    								'instansi'=>static::trimParse($d[10]),
		    							];
	    									# code...
	    									break;
	    								case 'KP':
	    									$pn[$pnk]['child'][$ppk]['child'][$kpk]['proyek'][$proyekk]['indikator'][$indikator]=[
    										'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.'.static::numering($kpk).'.PRY.'.static::numering($proyekk).'.IND.'.static::numering($indikator,3),
		    								'nama'=>static::trimParse($d[1]),
		    								'jenis'=>'PRONAS',
		    								'target_1_1'=>static::trimNum($d[2]),
		    								'target_2_1'=>static::trimNum($d[3]),
		    								'target_3_1'=>static::trimNum($d[4]),
		    								'target_4_1'=>static::trimNum($d[5]),
		    								'target_5_1'=>static::trimNum($d[6]),
		    								'anggaran'=>static::trimNum($d[7]),
		    								'lokasi'=>static::trimParse($d[8]),
		    								'major'=>static::trimParse($d[9]),
		    								'instansi'=>static::trimParse($d[10]),
		    							];
	    									# code...
	    									break;

	    								case 'PROPN':
	    									$pn[$pnk]['child'][$ppk]['child'][$kpk]['child'][$propnk]['proyek'][$proyekk]['indikator'][$indikator]=[
    										'id'=>'RPJMN.'.static::numering($pnk).'.'.static::numering($ppk).'.'.static::numering($kpk).'.'.static::numering($propnk).'.PRY.'.static::numering($proyekk).'.IND.'.static::numering($indikator,3),
		    								'nama'=>static::trimParse($d[1]),
		    								'jenis'=>'PRONAS',
		    								'target_1_1'=>static::trimNum($d[2]),
		    								'target_2_1'=>static::trimNum($d[3]),
		    								'target_3_1'=>static::trimNum($d[4]),
		    								'target_4_1'=>static::trimNum($d[5]),
		    								'target_5_1'=>static::trimNum($d[6]),
		    								'anggaran'=>static::trimNum($d[7]),
		    								'lokasi'=>static::trimParse($d[8]),
		    								'major'=>static::trimParse($d[9]),
		    								'instansi'=>static::trimParse($d[10]),
		    							];
	    									# code...
	    									break;
	    								
	    								default:
	    									# code...
	    									break;
	    							}
	    							
	    							break;
	    						
	    						default:
	    							# code...
	    							break;
	    					}

	    				}

	    			}
    			}else{
    				
    			}
    			}	
    		

    		}
    	}

    	Storage::put('RPJMN_FINAL_2.json',json_encode(static::convert_from_latin1_to_utf8_recursively($pn),JSON_PRETTY_PRINT));
    	// dd($pn[1]['child'][1]);



    }

      public static function convert_from_latin1_to_utf8_recursively($dat)
   {
      if (is_string($dat)) {
         return utf8_encode($dat);
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }


   public static function susun($index,$data,$spreadsheet){
   	$kol='B';
   	$start=3;
   	$sheet = $spreadsheet->getActiveSheet();
   	if(!isset($data['jenis'])){
   		dd($data);
   	}

   	switch ($data['jenis']) {
   		case 'PN':
   			$kol='B';
   			# code...
   			break;
   		case 'PP':
   			$kol='C';
   			# code...
   			break;
   		case 'KP':
   			$kol='D';
   			# code...
   			break;
   		case 'PROPN':
   			$kol='E';
   			# code...
   			break;
   		case 'PROYEK':
   			$kol='F';
   			# code...
   			break;
   		
   		default:
   			# code...
   			break;
   	}

   	if(!(in_array($kol,['B','C']))){
   		// dd($kol);
   	}

   		$pn=$data;
		$sheet->setCellValue('A'.($start+$index), $pn['id']);
		$sheet->setCellValue($kol.($start+$index), $pn['nama']);
		$index+=1;

		foreach ($pn['indikator'] as $key => $ind) {
			$sheet->setCellValue('A'.($start+$index), $ind['id']);
			$sheet->setCellValue('G'.($start+$index), $ind['nama']);
			$sheet->setCellValue('H'.($start+$index), $ind['major']);
			$sheet->setCellValue('I'.($start+$index), $ind['lokasi']);
			$sheet->setCellValue('J'.($start+$index), $ind['anggaran']);
			$sheet->setCellValue('K'.($start+$index), $ind['target_1_1']);
			$sheet->setCellValue('L'.($start+$index), $ind['target_2_1']);
			$sheet->setCellValue('M'.($start+$index), $ind['target_3_1']);
			$sheet->setCellValue('N'.($start+$index), $ind['target_4_1']);
			$sheet->setCellValue('O'.($start+$index), $ind['target_5_1']);
			$sheet->setCellValue('P'.($start+$index), $ind['instansi']);
			$index+=1;

		}

		if(isset($pn['proyek'])){
			foreach ($pn['proyek'] as $key => $proyek) {
				$sheet->setCellValue('A'.($start+$index), $proyek['id']);
				$sheet->setCellValue('F'.($start+$index), $proyek['nama']);
				$index+=1;

				foreach ($proyek['indikator'] as $key => $ind) {
					$sheet->setCellValue('A'.($start+$index), $ind['id']);
					$sheet->setCellValue('G'.($start+$index), $ind['nama']);
					$sheet->setCellValue('H'.($start+$index), $ind['major']);
					$sheet->setCellValue('I'.($start+$index), $ind['lokasi']);
					$sheet->setCellValue('J'.($start+$index), $ind['anggaran']);
					$sheet->setCellValue('K'.($start+$index), $ind['target_1_1']);
					$sheet->setCellValue('L'.($start+$index), $ind['target_2_1']);
					$sheet->setCellValue('M'.($start+$index), $ind['target_3_1']);
					$sheet->setCellValue('N'.($start+$index), $ind['target_4_1']);
					$sheet->setCellValue('O'.($start+$index), $ind['target_5_1']);
					$sheet->setCellValue('P'.($start+$index), $ind['instansi']);
					$index+=1;
				}
			}
		};

		

	return  array('spreadsheet' =>$spreadsheet ,'index'=>$index);

   }

   public function build(){


   		$data=file_get_contents(storage_path('app/RPJMN_FINAL_2.json'));
   		$data=json_decode($data,true);

   		$spreadsheet = new Spreadsheet();
		
		$start=3;
		$index=0;
		
		foreach ($data as $key => $pn) {
				$r=static::susun($index,$pn,$spreadsheet);
				$spreadsheet=$r['spreadsheet'];
				$index=$r['index'];
			foreach ($pn['child'] as $key => $pp) {
				$r=static::susun($index,$pp,$spreadsheet);
				$spreadsheet=$r['spreadsheet'];
				$index=$r['index'];
				foreach ($pp['child'] as $key => $kp) {
				$r=static::susun($index,$kp,$spreadsheet);
				$spreadsheet=$r['spreadsheet'];
				$index=$r['index'];
					foreach ($kp['child'] as $key => $propn) {
							$r=static::susun($index,$propn,$spreadsheet);
							$spreadsheet=$r['spreadsheet'];
							$index=$r['index'];

					}
				# code...
				}
				# code...
			}
			# code...
		}
		
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="myfile.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');

		// $writer = new Xlsx($spreadsheet);
		// $writer->save('hello world.xlsx');


   }
}
