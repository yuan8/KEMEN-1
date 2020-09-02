<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit','256M');
error_reporting(E_ALL);
ini_set('max_execution_time', 300);
//set_time_limit(5000);
//$tahunnya=$_GET['tahun'];
//$kodewil=$_GET['kodewil'];
// Create connection
$dir = "/var/www/KERNEL/storage/app/bot-sipd/pro-keg-data-daerah/2020/";
function loop_kodepemda($sql){
	$servername = "localhost";
$username = "root";
$password = "S@qpx231azq2";
$dbname = "rkpd_final_2021";
$conn = mysqli_connect($servername, $username, $password,$dbname);	
	if ($result=$conn->query($sql)) {
    return $result;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
function inputan2($sql){
	
}
function inputan($sql){
$servername = "localhost";
$username = "root";
$password = "S@qpx231azq2";
$dbname = "rkpd_final_2021";

$conn = mysqli_connect($servername, $username, $password,$dbname);	
	if ($conn->query($sql) === TRUE) {
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
//$conn->close();

}
function ubah($stringnya){
return	str_replace("'","`",stripslashes($stringnya));
	
}
function array2xml($array, $xml = false){
    if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }
$i=0;
    foreach($array as $key => $value){
       
			
				kodepemda($value, $xml->addChild($key));
			
            
			
		$i++;
	    }
    return $xml->asXML();
}
function kodepemda($array, $xml = false){
	//var_dump($array);die;
	$kodepemda='';$tahun='';$kodebidang='';$uraibidang='';$kodeskpd='';$uraiskpd='';$uraiurusan='';

$i=0;
    foreach($array as $key => $value){
		 if(is_array($value)){
			// echo $key;die;
if($key=='pejabat'){
			pejabat($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd);

}	
if($key=='pilihanbidang'){
			pilihanbidang($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd);

}
if($key=='program'){
			program($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd);

}		
		 }
		 else{
			 if($key=='kodepemda'){
				 $kodepemda=$value;
			 }
			 if($key=='tahun'){
				 $tahun=$value;
			 }
			 if($key=='kodebidang'){
				 $kodebidang=$value;
			 }
			 if($key=='uraibidang'){
				 $uraibidang=ubah($value);
			 }
			 if($key=='kodeskpd'){
				 $kodeskpd=$value;
			 }
			 if($key=='uraiskpd'){
				 $uraiskpd=ubah($value);
			 }
			 if($key=='uraiurusan'){
				 $uraiurusan=ubah($value);
			 }
		 }
	
	$i++;
	}
	$sql="insert ignore into master_pemda(kodepemda,tahun,kodebidang,uraibidang,kodeskpd,uraiskpd,uraiurusan) Values('".$kodepemda."','".$tahun."','".$kodebidang."','".$uraibidang."','".$kodeskpd."','".$uraiskpd."','".$uraiurusan."');";
inputan($sql);
}
function pejabat($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd){
//	var_dump($array);echo "stop";die;

$i=0;
$kepalanip='';$kepalanama='';$kepalajabatan='';$kepalapangkat='';
    foreach($array as $key => $value){
		 if(is_array($value)){
		 //bidang($value, $xml->addChild($key));
		 }
		 else{
			// echo $key;die;
			 if($key=='kepalanip'){
				 $kepalanip=$value;
				 
			 }
			 if($key=='kepalanama'){
				 $kepalanama=$value;
			 }
			 if($key=='kepalajabatan'){
				 $kepalajabatan=$value;
			 }
			 if($key=='kepalapangkat'){
				 $kepalapangkat=$value;
			 }
			 
		 }
	
	$i++;
	}
$sql= "INSERT IGNORE INTO master_pejabat(kodepemda,tahun,kodebidang,uraibidang,kodeskpd,kepalanip,kepalanama,kepalajabatan,kepalapangkat) VALUES('".$kodepemda."','".$tahun."','".$kodebidang."','".$uraibidang."','".$kodeskpd."','".$kepalanip."','".$kepalanama."','".$kepalajabatan."','".$kepalapangkat."');";	
inputan($sql);	

	
}
function pilihanbidang($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd){
	//var_dump($array);die;
	$pilihanbidang='';
	
if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }
$i=0;
    foreach($array as $key => $value){
if(is_array($value)){
	
}
else{
	
		$pilihanbidang = $pilihanbidang.';'.$value;
	
}
		 

	$i++;
	}
	//		echo $pilihanbidang."<br>";	

	
}
function program($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd){
	//var_dump($array);die;
if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }
$i=0;
    foreach($array as $key => $value){
		 if(is_array($value)){
		//	 var_dump($value);die;

	
		program_program($value, $xml->addChild($key),$kodepemda,$tahun,$kodeskpd);


}	

	$i++;
	}

	
}

function program_program($array, $xml = false,$kodepemda,$tahun,$kodeskpd){
	//var_dump($array);die;
if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }
$i=0;
    foreach($array as $key => $value){
		 if(is_array($value)){
			// var_dump($value);die;
if($key=='prioritas'){
						program_prioritas($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$array['kodeprogram']);


}
if($key=='kegiatan'){
						kegiatan($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$array['kodeprogram']);


}		
if($key=='capaian'){
						program_capaian($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$array['kodeprogram']);


}	
 }
		 else{
			// echo $key;die;
			 if($key=='kodebidang'){
				 $kodebidang=$value;
				 
			 }
			 if($key=='uraibidang'){
				 $uraibidang=$value;
			 }
			 if($key=='kodeprogram'){
				 $kodeprogram=$value;
			 }
			 if($key=='uraiprogram'){
				 $uraiprogram=ubah($value);
			 }
			 
		 }
	$i++;
	}
	$sql="INSERT ignore into master_program(kodepemda,tahun,kodebidang,uraibidang,kodeprogram,kodeskpd,uraiprogram) values ('".$kodepemda."','".$tahun."','".$kodebidang."','".$uraibidang."','".$kodeprogram."','".$kodeskpd."','".$uraiprogram."');";	
//echo $sql ."<br>";
//var_dump($array);
//die();
inputan($sql);

}
function program_prioritas($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram){
	//var_dump($array);die;
if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }
$i=1;
$prioritasnasional='';
$prioritas='';
$r_prioritas='';

    foreach($array as $key => $value){
		if(is_array($value)){
	program_prioritas_prioritas($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$i);
		}
else{

 $sql= "insert ignore into master_program_prioritas(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodeprioritas,jenis,uraiprioritas) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$i."','".$key."','".$value."');";
//echo $sql;
inputan($sql);

//echo	"nilai=".$value."----kodeprogram=".$kodeprogram."<br>";
}
		
	$i++;
	}


	}

function program_prioritas_prioritas($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodeprioritas){
//	var_dump($array);
//echo $kodeprogram ."<br>";
    foreach($array as $key => $value){
		
	if($key=='prioritasnasional')
	{
		$jenis="prioritasnasional";
		$uraiprioritas=ubah($value);
if(!empty($array)){
 $sql= "insert ignore into master_program_prioritas(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodeprioritas,jenis,uraiprioritas) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodeprioritas."','".$jenis."','".$uraiprioritas."');";
//echo $sql;
inputan($sql);
}
		
	}
	if($key=='prioritasdaerah')
	{
		$jenis="prioritasdaerah";
		$uraiprioritas=ubah($value);
if(!empty($array)){
 $sql= "insert ignore into master_program_prioritas(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodeprioritas,jenis,uraiprioritas) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodeprioritas."','".$jenis."','".$uraiprioritas."');";
//echo $sql;
inputan($sql);
}

	}
	if($key=='prionas')
	{
		$jenis="prioritasnasional";
		$uraiprioritas=ubah($value);
if(!empty($array)){
 $sql= "insert ignore into master_program_prioritas(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodeprioritas,jenis,uraiprioritas) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodeprioritas."','".$jenis."','".$uraiprioritas."');";
//echo $sql;
inputan($sql);
}
		
	}
	if($key=='prioprov')
	{
		$jenis="prioritasprovinsi";
		$uraiprioritas=ubah($value);
if(!empty($array)){
 $sql= "insert ignore into master_program_prioritas(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodeprioritas,jenis,uraiprioritas) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodeprioritas."','".$jenis."','".$uraiprioritas."');";
//echo $sql;
inputan($sql);
}
		
	}
	if($key=='priodaerah')
	{
		$jenis="prioritasdaerah";
		$uraiprioritas=ubah($value);
if(!empty($array)){
 $sql= "insert ignore into master_program_prioritas(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodeprioritas,jenis,uraiprioritas) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodeprioritas."','".$jenis."','".$uraiprioritas."');";
//echo $sql;
inputan($sql);
}
		
	}
	}
}
function kegiatan($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram){
	//var_dump($array);die;
if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }
$i=0;

    foreach($array as $key => $value){
kegiatan_kegiatan($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram);

		
	$i++;
	}
	
	//echo $prioritas; die;
}

function kegiatan_kegiatan($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram)
{
	//var_dump($array);die;
$kodekegiatan='';
$uraikegiatan='';
$pagu='';
$pagu_p='';
if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }
$i=0;
$kodekegiatan='';
    foreach($array as $key => $value){
if(is_array($value)){
	if($key=='sumberdana'){
		sumberdana($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$array['kodekegiatan']);
		
	}
	if($key=='prioritas'){
		kegiatan_prioritas($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$array['kodekegiatan']);
		
	}
	if($key=='indikator'){
		//echo $array['kodekegiatan'];die;
		indikator($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$array['kodekegiatan']);
		
	}
	if($key=='subkegiatan'){
		//echo $array['kodekegiatan'];die;
		subkegiatan($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$array['kodekegiatan']);
		
	}
	if($key=='lokasi'){
						lokasi($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$array['kodekegiatan']);


}	

}
else{
	if($key=='sumberdana'){
	
$sumberdana=$value;
sumberdana($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$array['kodekegiatan'],$array['pagu']);
		
	}
	if($key=='kodekegiatan'){
	
$kodekegiatan=$value;		
	}
	if($key=='uraikegiatan'){
$uraikegiatan=ubah($value);		
	}
	if($key=='pagu'){
$pagu=$value;		
	}
	if($key=='pagu_p'){
$pagu_p=$value;		
	}
}
		
	$i++;
	}
	$sql="insert ignore into master_kegiatan(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,uraikegiatan,pagu,pagu_p) VALUES('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$uraikegiatan."','".$pagu."','".$pagu_p."');";
inputan($sql);	
}
function sumberdana($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan){
//var_dump($array);die;
if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }
$i=1;

    foreach($array as $key => $value){
		if(is_array($value))
		{
		sumberdana_sumberdana($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,'',$i);	
		}
		else{
			
		}
		$i++;
	}	
}
function sumberdana_sumberdana($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$pagu,$nom)
{
//var_dump($array);die;
$kodesumberdana='';
if(is_array($array)){
foreach($array as $key => $value){
	if($key=='pagu'){
		$pagu =$value;
	}
	if($key=='sumberdana'){
		$sumberdana =$value;
	}
	if($key=='kodesumberdana'){
		$kodesumberdana =$value;
	}
	
}	
//if($kodesumberdana==''){$kodesumberdana=$nom;}
$kodesumberdana=$nom;
$sql= "insert ignore into master_kegiatan_sumberdana(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,pagu,sumberdana,kodesumberdana) VALUES('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$pagu."','".$sumberdana."','".$kodesumberdana."');";
inputan($sql);
//echo $sql .'<br>';
}
else{
$sumberdana =$array;
$kodesumberdana='';
$sql="insert ignore into master_kegiatan_sumberdana(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,pagu,sumberdana,kodesumberdana) VALUES('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$pagu."','".$sumberdana."','".$kodesumberdana."');";
inputan($sql);
}
}
function kegiatan_prioritas($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan){
	//var_dump($array);die;
if($xml === false){
        $xml = new SimpleXMLElement('<result/>');
    }
$i=1;
$prioritasnasional='';
$prioritas='';
$r_prioritas='';
    foreach($array as $key => $value){
	kegiatan_prioritas_prioritas($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$i);


		
	$i++;
	}
	
	}

function kegiatan_prioritas_prioritas($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodeprioritas){
	//var_dump($array);
$jenis='';$uraiprioritas='';
if(is_array($array)){
    foreach($array as $key => $value){
	if($key=='prioritasnasional')
	{
		$jenis="prioritasnasional";
		$uraiprioritas=ubah($value);
		
	}
	if($key=='prioritasdaerah')
	{
		$jenis="prioritasdaerah";
		$uraiprioritas=ubah($value);
	}
	}
}
else
{
	
}
 $sql= "insert ignore into master_kegiatan_prioritas(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,kodeprioritas,jenis,uraiprioritas) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$kodeprioritas."','".$jenis."','".$uraiprioritas."');";
//echo $sql;
inputan($sql);
}

function indikator($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan)
{
	//var_dump($array);die;
	foreach($array as $key =>$value){
		indikator_indikator($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan);
	}
}
function indikator_indikator($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan)
{
	//var_dump($array);die;
	
		$kodeindikator=$array['kodeindikator'];
$jenis=$array['jenis'];
$tolokukur=ubah($array['tolokukur']);
$satuan=ubah($array['satuan']);
$real_p3=ubah($array['real_p3']);
$pagu_p3=ubah($array['pagu_p3']);
$real_p2=ubah($array['real_p2']);
$pagu_p2=ubah($array['pagu_p2']);
$real_p1=ubah($array['real_p1']);
$pagu_p1=ubah($array['pagu_p1']);
$target=ubah($array['target']);
$pagu=ubah($array['pagu']);
$pagu_p=ubah($array['pagu_p']);
$target_n1=ubah($array['target_n1']);
$pagu_n1=ubah($array['pagu_n1']);

		$sql= "INSERT IGNORE INTO master_kegiatan_indikator(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,kodeindikator,jenis,tolokukur,satuan,real_p3,pagu_p3,real_p2,pagu_p2,real_p1,pagu_p1,target,pagu,pagu_p,target_n1,pagu_n1) VALUES('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$kodeindikator."','".$jenis."','".$tolokukur."','".$satuan."','".$real_p3."','".$pagu_p3."','".$real_p2."','".$pagu_p2."','".$real_p1."','".$pagu_p1."','".$target."','".$pagu."','".$pagu_p."','".$target_n1."','".$pagu_n1."'); ";
	inputan($sql);
}
function subkegiatan($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan)
{
	//var_dump($array);die;
	foreach($array as $key =>$value){
		subkegiatan_subkegiatan($value, $xml->addChild($key),$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan);
	}
}

function subkegiatan_subkegiatan($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan)
{
	//var_dump($array);die;
		
		foreach($array as $key=>$value){
//var_dump($array);die;		
		if(is_array($value)){
				if($key=='sumberdana'){
					subkegiatan_subkegiatan_sumberdana($value, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$array['kodesubkegiatan']);
				}
				if($key=='prioritas'){
					subkegiatan_subkegiatan_prioritas($value, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$array['kodesubkegiatan']);

				}
				if($key=='indikator'){
					
					subkegiatan_subkegiatan_indikator($value, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$array['kodesubkegiatan']);

				}
				if($key=='lokasi'){
		subkegiatan_lokasi($value, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$array['kodesubkegiatan']);

				}
			}
			else{
	if($key=='kodesubkegiatan'){
		$kodesubkegiatan =ubah($value);
	}
if($key=='uraisubkegiatan'){
		$uraisubkegiatan =ubah($value);
	}
if($key=='pagu'){
		$pagu =ubah($value);
	}
if($key=='pagu_p'){
		$pagu_p =ubah($value);
	}
if($key=='sumberdana'){
		$sumberdana =ubah($value);
	}
if($key=='prioritas'){
		$prioritas =ubah($value);
	}
if($key=='lokasi'){
		$lokasi =ubah($value);
	}	
				
			}
		}
$sql= "insert ignore into master_kegiatan_subkegiatan(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,kodesubkegiatan,uraisubkegiatan,pagu,pagu_p) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$kodesubkegiatan."','".$uraisubkegiatan."','".$pagu."','".$pagu_p."');";
inputan($sql);	
}
function subkegiatan_subkegiatan_indikator($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan)
{
	//var_dump($array);
	foreach($array as $key =>$value){
		subkegiatan_indikator_indikator($value, $xml=false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan);
	}
}
function subkegiatan_indikator_indikator($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan)
{
	//var_dump($array);die;
	
		$kodeindikator=$array['kodeindikator'];
$jenis=$array['jenis'];
$tolokukur=ubah($array['tolokukur']);
$satuan=ubah($array['satuan']);
$real_p3=ubah($array['real_p3']);
$pagu_p3=ubah($array['pagu_p3']);
$real_p2=ubah($array['real_p2']);
$pagu_p2=ubah($array['pagu_p2']);
$real_p1=ubah($array['real_p1']);
$pagu_p1=ubah($array['pagu_p1']);
$target=ubah($array['target']);
$pagu=ubah($array['pagu']);
$pagu_p=ubah($array['pagu_p']);
$target_n1=ubah($array['target_n1']);
$pagu_n1=ubah($array['pagu_n1']);

		$sql= "INSERT IGNORE INTO master_subkegiatan_indikator(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,kodesubkegiatan,kodeindikator,jenis,tolokukur,satuan,real_p3,pagu_p3,real_p2,pagu_p2,real_p1,pagu_p1,target,pagu,pagu_p,target_n1,pagu_n1) VALUES('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$kodesubkegiatan."','".$kodeindikator."','".$jenis."','".$tolokukur."','".$satuan."','".$real_p3."','".$pagu_p3."','".$real_p2."','".$pagu_p2."','".$real_p1."','".$pagu_p1."','".$target."','".$pagu."','".$pagu_p."','".$target_n1."','".$pagu_n1."'); ";
	inputan($sql);
}

function program_capaian($array, $xml=false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram){
	//var_dump($array);die;
	foreach($array as $key=>$value){
		program_capaian_capaian($value, $xml=false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram);
	}
}
function program_capaian_capaian($array, $xml=false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram){
	//var_dump($array);die;
	$kodeindikator=ubah($array['kodeindikator']);
$tolokukur=ubah($array['tolokukur']);
$satuan=ubah($array['satuan']);
$real_p3=ubah($array['real_p3']);
$pagu_p3=ubah($array['pagu_p3']);
$real_p2=ubah($array['real_p2']);
$pagu_p2=ubah($array['pagu_p2']);
$real_p1=ubah($array['real_p1']);
$pagu_p1=ubah($array['pagu_p1']);
$target=ubah($array['target']);
$pagu=ubah($array['pagu']);
$pagu_p=ubah($array['pagu_p']);
$target_n1=ubah($array['target_n1']);
$pagu_n1=ubah($array['pagu_n1']);

$sql= "insert ignore into master_program_capaian(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodeindikator,tolokukur,satuan,real_p3,pagu_p3,real_p2,pagu_p2,real_p1,pagu_p1,target,pagu,pagu_p,target_n1,pagu_n1) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodeindikator."','".$tolokukur."','".$satuan."','".$real_p3."','".$pagu_p3."','".$real_p2."','".$pagu_p2."','".$real_p1."','".$pagu_p1."','".$target."','".$pagu."','".$pagu_p."','".$target_n1."','".$pagu_n1."');";	
inputan($sql);
}
function lokasi($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan){
//	var_dump($array);die;
$i=1;
	foreach($array as $key=>$value){
		lokasi_lokasi($value, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$i);
	$i++;
	}
}
function lokasi_lokasi($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodelokasi){
//var_dump($array);die;
$lokasi='';$detaillokasi='';
if(is_array($array)){
if(array_key_exists('lokasi',$array)){
$lokasi=ubah($array['lokasi']);
}
if(array_key_exists('detaillokasi',$array)){
$detaillokasi=ubah($array['detaillokasi']);
}
}
else
{
$lokasi=$array;
}
$sql= "insert ignore into master_kegiatan_lokasi(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,lokasi,kodelokasi,detaillokasi) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$lokasi."','".$kodelokasi."','".$detaillokasi."');";
inputan($sql);
//echo $sql."<br>";
}
function subkegiatan_lokasi($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan){
//	var_dump($array);die;
$i=1;
$lokasi='';
$kodelokasi='';
$detaillokasi='';
	foreach($array as $key=>$value){
		if(is_array($value)){
		subkegiatan_lokasi_lokasi($value, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan,$i);
		}
		else{
			if($key=='lokasi'){
				$lokasi=$value;
			}
			if($key=='kodelokasi'){
				$kodelokasi=$value;
			}
			if($key=='detaillokasi'){
				$detaillokasi=$value;
			}
		}
	$i++;
	}
if(isset($value) && is_string($value) && $lokasi<>''){
$sql= "insert ignore into master_subkegiatan_lokasi(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,kodesubkegiatan,lokasi,kodelokasi,detaillokasi) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$kodesubkegiatan."','".$lokasi."','".$kodelokasi."','".$detaillokasi."');";
inputan($sql);
//echo $sql."<br>"; 	
	
};
}
function subkegiatan_lokasi_lokasi($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan,$kodelokasi){
//var_dump($array);
$lokasi='';$detaillokasi='';
if(array_key_exists('lokasi',$array)){
$lokasi=ubah($array['lokasi']);
}
if(array_key_exists('detaillokasi',$array)){
$detaillokasi=ubah($array['detaillokasi']);
}
$sql= "insert ignore into master_subkegiatan_lokasi(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,kodesubkegiatan,lokasi,kodelokasi,detaillokasi) values('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$kodesubkegiatan."','".$lokasi."','".$kodelokasi."','".$detaillokasi."');";
inputan($sql);
//echo $sql."<br>";
}

function subkegiatan_subkegiatan_sumberdana($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan){
//var_dump($array);die;
foreach($array as $key => $value){
		if(is_array($value))
		{
		subkegiatan_subkegiatan_sumberdana_sumberdana($value, $xml=false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan);	
		}
		else{
			
		}
	}	
}
function subkegiatan_subkegiatan_sumberdana_sumberdana($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan){
//var_dump($array);die;
$kodesumberdana='';
$sumberdana='';
$pagu='';
if(is_array($array)){
foreach($array as $key => $value){
	if($key=='pagu'){
		$pagu =$value;
	}
	if($key=='sumberdana'){
		$sumberdana =$value;
	}
	if($key=='kodesumberdana'){
		$kodesumberdana =$value;
	}
}	
$sql= "insert ignore into master_subkegiatan_sumberdana(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,kodesubkegiatan,pagu,sumberdana,kodesumberdana) VALUES('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$kodesubkegiatan."','".$pagu."','".$sumberdana."','".$kodesumberdana."');";
inputan($sql);
}
else{
$sumberdana =$array;
$kodesumberdana='';
$sql= "insert ignore into master_subkegiatan_sumberdana(kodepemda,tahun,kodebidang,kodeskpd,kodeprogram,kodekegiatan,kodesubkegiatan,pagu,sumberdana,kodesumberdana) VALUES('".$kodepemda."','".$tahun."','".$kodebidang."','".$kodeskpd."','".$kodeprogram."','".$kodekegiatan."','".$kodesubkegiatankegiatan."','".$pagu."','".$sumberdana."','".$kodesumberdana."');";
inputan($sql);
}

}
function subkegiatan_subkegiatan_prioritas($array, $xml = false,$kodepemda,$tahun,$kodebidang,$uraibidang,$kodeskpd,$kodeprogram,$kodekegiatan,$kodesubkegiatan)
{
	//var_dump($array);
	
}

//print_r($xml);
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Authorization: bearer d1d1ab9140c249e34ce356c91e9166a6" 
    ]
];

$context = stream_context_create($opts);
$sql="SELECT kodepemda FROM status_rkpd_final_2021 WHERE kodepemda NOT IN (SELECT kodepemda FROM master_program GROUP BY kodepemda) ";
$hasil=loop_kodepemda($sql);
while($row = mysqli_fetch_array($hasil)) {    
//if(substr($row[0],2,2)=='00')
//{
//	$kodepemda=substr($row[0],0,2);
//}	
//else {
	$kodepemda=$row[0];
//}
//  $raw_data = file_get_contents($dir.$kodepemda.'.json', false);
$raw_data = file_get_contents('https://sipd.go.id/run/serv/api.php?tahun=2021&kodepemda='.$kodepemda.'', false, $context);
$jSON = json_decode($raw_data, true);
//var_dump($jSON );die;
$xml = array2xml($jSON);
echo $kodepemda."   selesai" .'<br>';
}   
//var_dump($hasil);
//die;
// Open the file using the HTTP headers set above

?>