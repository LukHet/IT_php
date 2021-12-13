﻿<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

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
	$intTemp[$i] = preg_replace('/[^-?0-9]/', '', $tempData_array[2]->plaintext);
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
	$onTemp[$i] = preg_replace('/[^-?0-9]/', '', $tempData->plaintext);
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
	$zetTemp[$i] = preg_replace('/[^-?0-9]/', '', $tempData->plaintext);
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
?>
<figure class="text-center">
  <blockquote class="blockquote">
    <h1>Pogodeo: porównywarka prognoz pogodowych</h1>
  </blockquote>
  <figcaption class="blockquote-footer">
    Ostatnie odświeżenie:
  <?php
  echo date('H:i:s Y-m-d');
  echo "<br>";
	echo ("Aktualna temperatura: ");
	$aktualna_temperatura = $interia->find('div [class="weather-currently-temp-strict"]',0);
	echo $aktualna_temperatura->plaintext;
	echo "<br>";
	echo "Miasto: Sosnowiec";
  ?>
  </figcaption>
</figure>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">godzina</th>
      <th scope="col">Onet</th>
      <th scope="col">Interia</th>
      <th scope="col">Zet</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><?php echo $zetHour[0]?></th>
      <td><?php echo $onTemp[0], "°C"?></td>
      <td><?php echo $intTemp[0], "°C"?></td>
      <td><?php echo $zetTemp[0], "°C"?></td>
    </tr>
    <tr>
      <th scope="row"><?php echo $zetHour[1]?></th>
      <td><?php echo $onTemp[1], "°C"?></td>
      <td><?php echo $intTemp[1], "°C"?></td>
      <td><?php echo $zetTemp[1], "°C"?></td>
    </tr>
    <tr>
      <th scope="row"><?php echo $zetHour[2]?></th>
      <td><?php echo $onTemp[2], "°C"?></td>
      <td><?php echo $intTemp[2], "°C"?></td>
      <td><?php echo $zetTemp[2], "°C"?></td>
    </tr>
	<tr>
      <th scope="row"><?php echo $zetHour[3]?></th>
      <td><?php echo $onTemp[3], "°C"?></td>
      <td><?php echo $intTemp[3], "°C"?></td>
      <td><?php echo $zetTemp[3], "°C"?></td>
    </tr>
	<tr>
      <th scope="row"><?php echo $zetHour[4]?></th>
      <td><?php echo $onTemp[4], "°C"?></td>
      <td><?php echo $intTemp[4], "°C"?></td>
      <td><?php echo $zetTemp[4], "°C"?></td>
    </tr>
  </tbody>
</table>


<?php
/*
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
}*/
//----------------------------------------------------------------------

/*
//-----------------------PRZYPISYWANIE (TE LISTY TRZEBA DO SQL WPISAĆ)
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


//-----------------------POROWNANIE (TO TEŻ TRZEBA TEŻ DO SQL WPISAĆ)
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
*/
/*if ($minuty == "25"){
	$lista_aktualnych_czasow[$godziny]=$godziny;
	$lista_aktualnych_temperatur[$godziny]=$aktualna_temperatura;
	preg_replace('/\t+/', '',$lista_aktualnych_temperatur[$godziny]);
	echo "<br>";
	echo $lista_aktualnych_czasow[$godziny];
	echo $lista_aktualnych_temperatur[$godziny];
	//}*/
	
//$tekst = $list_array29[0]->plaintext;
//$tekst1 = substr($tekst, 0, 2);
//echo $tekst1;

//connect to the db
$conn = new mysqli("localhost","root","","sunny");
//check if connection was succesful
if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
for($i = 0; $i < 5; $i++){											//Database operations for the Interia website
$sqlInt = "UPDATE interia_temp1 SET `".substr($zetHour[$i],0,2)."`= ".$intTemp[$i]." WHERE Hour_tested = '".date('H')."'";

if($conn->query($sqlInt) === FALSE) {
	echo "Error: " .$sqlInt."<br>".$conn->error;
}
}
$sqlQInt = "SELECT `".date('H')."` FROM interia_temp1 WHERE Hour_tested = '".(date('H')-1)."'";				//taking data from mysql database
$result = $conn->query($sqlQInt);
$prevTempInt = $result->fetch_array(MYSQLI_NUM);

$currTempInt = preg_replace('/[^-?0-9]/', '', $aktualna_temperatura->plaintext);	//changing current temperature to be usable in an equation
if($prevTempInt != NULL){
	
$errTempInt = $prevTempInt[0] - $currTempInt;					//calculating error
$sqlInt = "UPDATE interia_errtemp1 SET `".date('H')."`= ".$errTempInt." WHERE Hour_tested = '".(date('H')-1)."'";//sending error to database

if($conn->query($sqlInt) === FALSE) {
	echo "Error: " .$sqlInt."<br>".$conn->error;
}
}


for($i = 0; $i < 5; $i++){											//Database operations for the Onet website
$sqlOnet = "UPDATE onet_temp1 SET `".substr($zetHour[$i],0,2)."`= ".$onTemp[$i]." WHERE Hour_tested = '".date('H')."'";

if($conn->query($sqlOnet) === FALSE) {
	echo "Error: " .$sqlOnet."<br>".$conn->error;
}
}
$sqlQOnet = "SELECT `".date('H')."` FROM onet_temp1 WHERE Hour_tested = '".(date('H')-1)."'";				//taking data from mysql database
$result = $conn->query($sqlQOnet);
$prevTempOnet = $result->fetch_array(MYSQLI_NUM);

$currTempOnet = preg_replace('/[^-?0-9]/', '', $aktualna_temperatura->plaintext);	//changing current temperature to be usable in an equation
if($prevTempOnet != NULL){
	
$errTempOnet = $prevTempOnet[0] - $currTempOnet;					//calculating error
$sqlOnet = "UPDATE onet_errtemp1 SET `".date('H')."`= ".$errTempOnet." WHERE Hour_tested = '".(date('H')-1)."'";//sending error to database

if($conn->query($sqlOnet) === FALSE) {
	echo "Error: " .$sqlOnet."<br>".$conn->error;
}
}



for($i = 0; $i < 5; $i++){											//Database operations for the Zet website
$sqlZet = "UPDATE zet_temp1 SET `".substr($zetHour[$i],0,2)."`= ".$zetTemp[$i]." WHERE Hour_tested = '".date('H')."'";

if($conn->query($sqlZet) === FALSE) {
	echo "Error: " .$sqlZet."<br>".$conn->error;
}
}
$sqlQZet = "SELECT `".date('H')."` FROM zet_temp1 WHERE Hour_tested = '".(date('H')-1)."'";				//taking data from mysql database
$result = $conn->query($sqlQZet);
$prevTempZet = $result->fetch_array(MYSQLI_NUM);

$currTempZet = preg_replace('/[^-?0-9]/', '', $aktualna_temperatura->plaintext);	//changing current temperature to be usable in an equation
if($prevTempZet != NULL){
	
$errTempZet = $prevTempZet[0] - $currTempZet;					//calculating error
$sqlZet = "UPDATE zet_errtemp1 SET `".date('H')."`= ".$errTempZet." WHERE Hour_tested = '".(date('H')-1)."'";//sending error to database

if($conn->query($sqlZet) === FALSE) {
	echo "Error: " .$sqlZet."<br>".$conn->error;
}
}
$conn->close();


	
?>

  </tbody>
</body>
</html>