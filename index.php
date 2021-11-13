﻿<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="sunnyStyle.css">
</head>
<body>
<div class="hero-image">
<?php
	include('simple_html_dom.php');

	$interia = file_get_html('https://pogoda.interia.pl/prognoza-szczegolowa-sosnowiec,cId,32574');
	
	$onet = file_get_html('https://pogoda.onet.pl/prognoza-pogody/sosnowiec-346939');
	
	$wp = file_get_html('https://pogoda.wp.pl/pogoda-na-dzis/sosnowiec/3085128');
	
	$zet = file_get_html('https://wiadomosci.radiozet.pl/Pogoda/(region)/slaskie/(miasto)/sosnowiec/(prognoza)/godzinowa');
	
	
	$minuty = date('i');
	$godziny = date('H');
	$czas_zakonczenia = date('H:i');
	header("Refresh:60");
	echo("Ostatnie odświeżenie: ");
	echo "<br>";
	date_default_timezone_set('Europe/Warsaw');
	echo date('H:i:s Y-m-d');
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo ("Aktualna temperatura: ");
	$aktualna_temperatura = $interia->find('div [class="weather-currently-temp-strict"]',0);
	echo $aktualna_temperatura->plaintext;
	echo "<br>";
	echo "<br>";
	echo "<br>";
	$lista_temperatur_interia[23]=0;
	$lista_temperatur_onet[23]=0;
	$lista_temperatur_zet[23]=0;
	$lista_godzin_interia[23]=0;
	$lista_godzin_onet[23]=0;
	$lista_godzin_zet[23]=0;
	for($i = 0; $i < 23; $i++){
		$lista_aktualnych_czasow[$i]=$i;
		$lista_temperatur_interia[$i]=0;
		$lista_temperatur_onet[$i]=0;
		$lista_temperatur_zet[$i]=0;
		$lista_godzin_interia[$i]=0;
		$lista_godzin_onet[$i]=0;
		$lista_godzin_zet[$i]=0;
		$lista_aktualnych_temperatur[$i]=0;}
	
	echo "<br>";

	
//----------------------------------------------------------------------
	//temperatury interia
	for($i = 0; $i < 5; $i++){
	$tempData = $interia->find('div [class="forecast-top"]',$i);
	$tempData_array = $tempData->find('span');
	$intTemp[$i] = preg_replace('/[^0-9]/', '', $tempData_array[2]);
	}
	//temperatury interia
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//godziny interia
	for($i = 0; $i < 5; $i++){
	$hourData = $interia->find('div [class="entry-hour"]',$i);
	$hourData_array = $hourData->find('span');
	$intHour[$i] = $hourData_array[1]->plaintext.':'.$hourData_array[2]->plaintext;
	}
	//godziny interia
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//temperatury onet
	for($i = 0; $i < 5; $i++){
	$tempData = $onet->find('div [class="temp"]',$i+1);
	$onTemp[$i] = preg_replace('/[^0-9]/', '', $tempData->plaintext);
	}
	//temperatury onet
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//godziny onet
	for($i = 0; $i < 5; $i++){
	$hourData = $onet->find('div [class="time"]',$i+1);
	$onHour[$i] = $hourData->plaintext;
	}
	//godziny onet
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//temperatury zet
	for($i = 0; $i < 5; $i++){
	$tempData = $zet->find('div [class="single-weather-item__temperature single-weather-item__item"]',$i+1);
	$zetTemp[$i] = preg_replace('/[^0-9]/', '', $tempData->plaintext);
	}
	//temperatury zet
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//godziny zet
	for($i = 0; $i < 5; $i++){
	$hourData = $zet->find('div [class="single-weather-item"]',$i+1);
	$hourData_array=$hourData->find('span');
	$zetHour[$i] = $hourData_array[0]->plaintext;
	}
	//godziny zet
	//----------------------------------------------------------------------
	
//-----------------------WYŚWIETLANIE
//Interia
echo $interia->find('title', 0)->plaintext,"<br>";
for($i = 0; $i < 5; $i++){
	echo "<br>";
	echo $intHour[$i]," ",$intTemp[$i], "°C<br>";
}
//Onet
echo "<br>";
echo $onet->find('title', 0)->plaintext,"<br>";
for($i = 0; $i < 5; $i++){
	echo "<br>";
	echo $onHour[$i]," ",$onTemp[$i], "°C<br>";
}
//Radio Zet
echo "<br>";
echo $zet->find('title', 0)->plaintext,"<br>";
for($i = 0; $i < 5; $i++){
	echo "<br>";
	echo $zetHour[$i]," ",$zetTemp[$i], "°C<br>";
}
//----------------------------------------------------------------------


//-----------------------PRZYPISYWANIE (TE LISTY TRZEBA DO SQL DODAĆ)
//Interia
for($i = 0; $i < 5; $i++){
	for($j = 0; $j < 23; $j++){
		if(substr($intHour[$i], 0, 2)==$lista_aktualnych_czasow[$j]){
			$lista_temperatur_interia[$j]==$intTemp[$i];	
			}
	}
}
//Onet
for($i = 0; $i < 5; $i++){
	for($j = 0; $j < 23; $j++){
		if(substr($onHour[$i], 0, 2)==$lista_aktualnych_czasow[$j]){
			$lista_temperatur_onet[$j]==$onTemp[$i];	
			}
	}
}
//Radio Zet
for($i = 0; $i < 5; $i++){
	for($j = 0; $j < 23; $j++){
		if(substr($zetHour[$i], 0, 2)==$lista_aktualnych_czasow[$j]){
			$lista_temperatur_zet[$j]==$zetTemp[$i];	
			}
	}
}
//Wpisanie w liste temperatur aktualnych
if ($minuty == "00")
		$lista_aktualnych_temperatur[$godziny]==$aktualna_temperatura;	
	
//----------------------------------------------------------------------


//-----------------------POROWNANIE (TO TEŻ TRZEBA TEŻ DO SQL DODAĆ)
//Interia
for($i = 0; $i < 5; $i++){
	for($j = 0; $j < 23; $j++){
		if($intHour[$i]==$lista_aktualnych_czasow[$j]){
			$lista_temperatur_interia[$j]==$intTemp[$i];	
		}
	}
}
//Onet
for($i = 0; $i < 5; $i++){
	for($j = 0; $j < 23; $j++){
	if($onHour[$i]==$lista_aktualnych_czasow[$j]){
		$lista_temperatur_onet[$j]==$onTemp[$i];	
		}
	}
}
//Radio Zet
for($i = 0; $i < 5; $i++){
	for($j = 0; $j < 23; $j++){
		if($zetHour[$i]==$lista_aktualnych_czasow[$j]){
			$lista_temperatur_zet[$j]==$zetTemp[$i];	
		}
	}
}
//----------------------------------------------------------------------

//if ($minuty == "25"){
	$lista_aktualnych_czasow[$godziny]=$godziny;
	$lista_aktualnych_temperatur[$godziny]=$aktualna_temperatura;
	preg_replace('/\t+/', '',$lista_aktualnych_temperatur[$godziny]);
	echo "<br>";
	echo $lista_aktualnych_czasow[$godziny];
	echo $lista_aktualnych_temperatur[$godziny];
	//}
	
//$tekst = $list_array29[0]->plaintext;
//$tekst1 = substr($tekst, 0, 2);
//echo $tekst1;

//connect to the db
$conn = new mysqli("localhost","root","","sunny");
//check if connection was succesful
if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO today (Hour,Interia_temperature,Onet_temperature,Zet_temperature)
VALUES ('".$intH."', ".$intTemp1.",".$onTemp1.", ".$zetTemp1.")";

if($conn->query($sql) === TRUE) {
	echo "New record created succesfully";
}else{
	echo "Error: " .$sql."<br>".$conn->error;
}

$conn->close();


	
?>
</div>
</body>
</html>