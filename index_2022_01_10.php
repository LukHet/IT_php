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
	$tempData = $interia->find('div [class="weather-currently-temp-strict"]',0);
	$intCurrTemp = preg_replace('/[^-?0-9]/', '', $tempData->plaintext);
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
	$tempData = $onet->find('div [class="temp"]',0);
	$onCurrTemp = preg_replace('/[^-?0-9]/', '', $tempData->plaintext);
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
	$tempData = $zet->find('div [class="single-weather-item__temperature single-weather-item__item"]',0);
	$zetCurrTemp = preg_replace('/[^-?0-9]/', '', $tempData->plaintext);
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
    <h1>Porównywarka prognoz pogodowych</h1>
  </blockquote>
  <figcaption class="blockquote-footer">
    Ostatnie odświeżenie:
  <?php
  echo date('H:i:s Y-m-d');
	echo "<br>";
	echo "Miasto: Sosnowiec";


//---------------------CREATING DATABASES---------------
//---------------------INTERIA DATABASE-------------------
$intConn = new mysqli("localhost","root","","interia");
//check if connection was succesful
if($intConn->connect_error) {
	die("Connection failed: " . $intConn->connect_error);
}
//Check if Temp Interia table exists and create one if necessary
$intTempTable = date("Y")."_".date("F")."_temp";
$intTableExists = 'SELECT 1 FROM `'.$intTempTable.'` LIMIT 1';

if($intConn->query($intTableExists) === FALSE){
$intCreateTable = "CREATE TABLE `interia`.`".$intTempTable."` ( `id` INT NOT NULL AUTO_INCREMENT, `Time_Tested` VARCHAR(22) NOT NULL , `00` INT NULL DEFAULT NULL , `01` INT NULL DEFAULT NULL , `02` INT NULL DEFAULT NULL , `03` INT NULL DEFAULT NULL , `04` INT NULL DEFAULT NULL , `05` INT NULL DEFAULT NULL , `06` INT NULL DEFAULT NULL , `07` INT NULL DEFAULT NULL , `08` INT NULL DEFAULT NULL , `09` INT NULL DEFAULT NULL , `10` INT NULL DEFAULT NULL , `11` INT NULL DEFAULT NULL , `12` INT NULL DEFAULT NULL , `13` INT NULL DEFAULT NULL , `14` INT NULL DEFAULT NULL , `15` INT NULL DEFAULT NULL , `16` INT NULL DEFAULT NULL , `17` INT NULL DEFAULT NULL , `18` INT NULL DEFAULT NULL , `19` INT NULL DEFAULT NULL , `20` INT NULL DEFAULT NULL , `21` INT NULL DEFAULT NULL , `22` INT NULL DEFAULT NULL , `23` INT NULL DEFAULT NULL , PRIMARY KEY (`id`) ) ENGINE = InnoDB;";
if ($intConn->query($intCreateTable) === TRUE) {
} else {
  echo "Error creating table: " . $intConn->error;
}
}

//Check if Error Temp Interia table exists and create one if necessary
$intErrTempTable = date("Y")."_".date("F")."_error_temp";
$intTableExists = 'SELECT 1 FROM `'.$intErrTempTable.'` LIMIT 1';

if($intConn->query($intTableExists) === FALSE){
$intCreateTable = "CREATE TABLE `interia`.`".$intErrTempTable."` ( `id` INT NOT NULL AUTO_INCREMENT, `Time_Tested` VARCHAR(22) NOT NULL , `00` INT NULL DEFAULT NULL , `01` INT NULL DEFAULT NULL , `02` INT NULL DEFAULT NULL , `03` INT NULL DEFAULT NULL , `04` INT NULL DEFAULT NULL , `05` INT NULL DEFAULT NULL , `06` INT NULL DEFAULT NULL , `07` INT NULL DEFAULT NULL , `08` INT NULL DEFAULT NULL , `09` INT NULL DEFAULT NULL , `10` INT NULL DEFAULT NULL , `11` INT NULL DEFAULT NULL , `12` INT NULL DEFAULT NULL , `13` INT NULL DEFAULT NULL , `14` INT NULL DEFAULT NULL , `15` INT NULL DEFAULT NULL , `16` INT NULL DEFAULT NULL , `17` INT NULL DEFAULT NULL , `18` INT NULL DEFAULT NULL , `19` INT NULL DEFAULT NULL , `20` INT NULL DEFAULT NULL , `21` INT NULL DEFAULT NULL , `22` INT NULL DEFAULT NULL , `23` INT NULL DEFAULT NULL , PRIMARY KEY (`id`) ) ENGINE = InnoDB;";
if ($intConn->query($intCreateTable) === TRUE) {
} else {
  echo "Error creating table: " . $intConn->error;
}
}
//---------------------ONET DATABASE-------------------
$onConn = new mysqli("localhost","root","","onet");
//check if connection was succesful
if($onConn->connect_error) {
	die("Connection failed: " . $onConn->connect_error);
}
//Check if Temp Onet table exists and create one if necessary
$onTempTable = date("Y")."_".date("F")."_temp";
$onTableExists = 'SELECT 1 FROM `'.$onTempTable.'` LIMIT 1';

if($onConn->query($onTableExists) === FALSE){
$onCreateTable = "CREATE TABLE `onet`.`".$onTempTable."` ( `id` INT NOT NULL AUTO_INCREMENT, `Time_Tested` VARCHAR(22) NOT NULL , `00` INT NULL DEFAULT NULL , `01` INT NULL DEFAULT NULL , `02` INT NULL DEFAULT NULL , `03` INT NULL DEFAULT NULL , `04` INT NULL DEFAULT NULL , `05` INT NULL DEFAULT NULL , `06` INT NULL DEFAULT NULL , `07` INT NULL DEFAULT NULL , `08` INT NULL DEFAULT NULL , `09` INT NULL DEFAULT NULL , `10` INT NULL DEFAULT NULL , `11` INT NULL DEFAULT NULL , `12` INT NULL DEFAULT NULL , `13` INT NULL DEFAULT NULL , `14` INT NULL DEFAULT NULL , `15` INT NULL DEFAULT NULL , `16` INT NULL DEFAULT NULL , `17` INT NULL DEFAULT NULL , `18` INT NULL DEFAULT NULL , `19` INT NULL DEFAULT NULL , `20` INT NULL DEFAULT NULL , `21` INT NULL DEFAULT NULL , `22` INT NULL DEFAULT NULL , `23` INT NULL DEFAULT NULL , PRIMARY KEY (`id`) ) ENGINE = InnoDB;";
if ($onConn->query($onCreateTable) === TRUE) {
} else {
  echo "Error creating table: " . $onConn->error;
}
}

//Check if Error Temp Onet table exists and create one if necessary
$onErrTempTable = date("Y")."_".date("F")."_error_temp";
$onTableExists = 'SELECT 1 FROM `'.$onErrTempTable.'` LIMIT 1';

if($onConn->query($onTableExists) === FALSE){
$onCreateTable = "CREATE TABLE `onet`.`".$onErrTempTable."` ( `id` INT NOT NULL AUTO_INCREMENT, `Time_Tested` VARCHAR(22) NOT NULL , `00` INT NULL DEFAULT NULL , `01` INT NULL DEFAULT NULL , `02` INT NULL DEFAULT NULL , `03` INT NULL DEFAULT NULL , `04` INT NULL DEFAULT NULL , `05` INT NULL DEFAULT NULL , `06` INT NULL DEFAULT NULL , `07` INT NULL DEFAULT NULL , `08` INT NULL DEFAULT NULL , `09` INT NULL DEFAULT NULL , `10` INT NULL DEFAULT NULL , `11` INT NULL DEFAULT NULL , `12` INT NULL DEFAULT NULL , `13` INT NULL DEFAULT NULL , `14` INT NULL DEFAULT NULL , `15` INT NULL DEFAULT NULL , `16` INT NULL DEFAULT NULL , `17` INT NULL DEFAULT NULL , `18` INT NULL DEFAULT NULL , `19` INT NULL DEFAULT NULL , `20` INT NULL DEFAULT NULL , `21` INT NULL DEFAULT NULL , `22` INT NULL DEFAULT NULL , `23` INT NULL DEFAULT NULL , PRIMARY KEY (`id`) ) ENGINE = InnoDB;";
if ($onConn->query($onCreateTable) === TRUE) {
} else {
  echo "Error creating table: " . $onConn->error;
}
}
//---------------------ZET DATABASE-------------------
$zetConn = new mysqli("localhost","root","","zet");
//check if connection was succesful
if($zetConn->connect_error) {
	die("Connection failed: " . $zetConn->connect_error);
}
//Check if Temp Zet table exists and create one if necessary
$zetTempTable = date("Y")."_".date("F")."_temp";
$zetTableExists = 'SELECT 1 FROM `'.$zetTempTable.'` LIMIT 1';

if($zetConn->query($zetTableExists) === FALSE){
$zetCreateTable = "CREATE TABLE `zet`.`".$zetTempTable."` ( `id` INT NOT NULL AUTO_INCREMENT, `Time_Tested` VARCHAR(22) NOT NULL , `00` INT NULL DEFAULT NULL , `01` INT NULL DEFAULT NULL , `02` INT NULL DEFAULT NULL , `03` INT NULL DEFAULT NULL , `04` INT NULL DEFAULT NULL , `05` INT NULL DEFAULT NULL , `06` INT NULL DEFAULT NULL , `07` INT NULL DEFAULT NULL , `08` INT NULL DEFAULT NULL , `09` INT NULL DEFAULT NULL , `10` INT NULL DEFAULT NULL , `11` INT NULL DEFAULT NULL , `12` INT NULL DEFAULT NULL , `13` INT NULL DEFAULT NULL , `14` INT NULL DEFAULT NULL , `15` INT NULL DEFAULT NULL , `16` INT NULL DEFAULT NULL , `17` INT NULL DEFAULT NULL , `18` INT NULL DEFAULT NULL , `19` INT NULL DEFAULT NULL , `20` INT NULL DEFAULT NULL , `21` INT NULL DEFAULT NULL , `22` INT NULL DEFAULT NULL , `23` INT NULL DEFAULT NULL , PRIMARY KEY (`id`) ) ENGINE = InnoDB;";
if ($zetConn->query($zetCreateTable) === TRUE) {
} else {
  echo "Error creating table: " . $zetConn->error;
}
}

//Check if Error Temp Zet table exists and create one if necessary
$zetErrTempTable = date("Y")."_".date("F")."_error_temp";
$zetTableExists = 'SELECT 1 FROM `'.$zetErrTempTable.'` LIMIT 1';

if($zetConn->query($zetTableExists) === FALSE){
$zetCreateTable = "CREATE TABLE `zet`.`".$zetErrTempTable."` ( `id` INT NOT NULL AUTO_INCREMENT, `Time_Tested` VARCHAR(22) NOT NULL , `00` INT NULL DEFAULT NULL , `01` INT NULL DEFAULT NULL , `02` INT NULL DEFAULT NULL , `03` INT NULL DEFAULT NULL , `04` INT NULL DEFAULT NULL , `05` INT NULL DEFAULT NULL , `06` INT NULL DEFAULT NULL , `07` INT NULL DEFAULT NULL , `08` INT NULL DEFAULT NULL , `09` INT NULL DEFAULT NULL , `10` INT NULL DEFAULT NULL , `11` INT NULL DEFAULT NULL , `12` INT NULL DEFAULT NULL , `13` INT NULL DEFAULT NULL , `14` INT NULL DEFAULT NULL , `15` INT NULL DEFAULT NULL , `16` INT NULL DEFAULT NULL , `17` INT NULL DEFAULT NULL , `18` INT NULL DEFAULT NULL , `19` INT NULL DEFAULT NULL , `20` INT NULL DEFAULT NULL , `21` INT NULL DEFAULT NULL , `22` INT NULL DEFAULT NULL , `23` INT NULL DEFAULT NULL , PRIMARY KEY (`id`) ) ENGINE = InnoDB;";
if ($zetConn->query($zetCreateTable) === TRUE) {
} else {
  echo "Error creating table: " . $zetConn->error;
}
}



//---------------------DATABASE OPERATIONS---------------
$intColor = "black"; $intWidth = "normal";
$onColor = "black"; $onWidth = "normal";
$zetColor = "black"; $zetWidth = "normal";
$intErrTemp = NULL; $onErrTemp = NULL; $zetErrTemp = NULL;
//---------------------INTERIA DATABASE-------------------
//Add a record only at a full hour
if(date("i") == "01")
{
$currTime = date("d.m.y  H:i:s");
$currDate = date("d.m.y");
$currHour = date('H');
$intInsert = "INSERT INTO `".$intTempTable."` (`Time_Tested`, `".substr($zetHour[0],0,2)."`, `".substr($zetHour[1],0,2)."`, `".substr($zetHour[2],0,2)."`, `".substr($zetHour[3],0,2)."`, `".substr($zetHour[4],0,2)."`) VALUES ('".$currTime."', ".$intTemp[0].", ".$intTemp[1].", ".$intTemp[2].", ".$intTemp[3].", ".$intTemp[4].")";
if($intConn->query($intInsert) === FALSE) {
	echo "Error: " .$intInsert."<br>".$intConn->error;
}
if($currHour != "00")
{
//taking data from mysql database
$intSelect = "SELECT `".$currHour."` FROM `".$intTempTable."` WHERE Time_Tested LIKE '".$currDate."  ".($currHour-1)."%'";
$result = $intConn->query($intSelect);
$intPrevTemp = $result->fetch_array(MYSQLI_NUM);

//changing current temperature to be usable in an equation
//$intCurrTemp = preg_replace('/[^-?0-9]/', '', $aktualna_temperatura->plaintext);	
if($intPrevTemp != NULL){
	
$intErrTemp = $intPrevTemp[0] - $intCurrTemp;					//calculating error
//sending error to database
$intInsert = "INSERT INTO `".$intErrTempTable."` (`Time_Tested`, `".($currHour-1)."`) VALUES ('".$currTime."',".$intErrTemp.")";

if($intConn->query($intInsert) === FALSE) {
	echo "Error: " .$intInsert."<br>".$intConn->error;
}
}
}else
{
//taking data from mysql database
$intSelect = "SELECT `".$currHour."` FROM `".$intTempTable."` WHERE Time_Tested LIKE '".(date("d")-1).date(".m.y")."  ".(23)."%'";
$result = $intConn->query($intSelect);
$intPrevTemp = $result->fetch_array(MYSQLI_NUM);

//changing current temperature to be usable in an equation
//$intCurrTemp = preg_replace('/[^-?0-9]/', '', $aktualna_temperatura->plaintext);	
if($intPrevTemp != NULL){
	
$intErrTemp = $intPrevTemp[0] - $intCurrTemp;					//calculating error
//sending error to database
$intInsert = "INSERT INTO `".$intErrTempTable."` (`Time_Tested`, `23`) VALUES ('".$currTime."',".$intErrTemp.")";

if($intConn->query($intInsert) === FALSE) {
	echo "Error: " .$intInsert."<br>".$intConn->error;
}
}
}

//---------------------ONET DATABASE-------------------
$onInsert = "INSERT INTO `".$onTempTable."` (`Time_Tested`, `".substr($zetHour[0],0,2)."`, `".substr($zetHour[1],0,2)."`, `".substr($zetHour[2],0,2)."`, `".substr($zetHour[3],0,2)."`, `".substr($zetHour[4],0,2)."`) VALUES ('".$currTime."', ".$onTemp[0].", ".$onTemp[1].", ".$onTemp[2].", ".$onTemp[3].", ".$onTemp[4].")";
if($onConn->query($onInsert) === FALSE) {
	echo "Error: " .$onInsert."<br>".$onConn->error;
}

if($currHour != "00")
{
//taking data from mysql database
$onSelect = "SELECT `".$currHour."` FROM `".$onTempTable."` WHERE Time_Tested LIKE '".$currDate."  ".($currHour-1)."%'";
$result = $onConn->query($onSelect);
$onPrevTemp = $result->fetch_array(MYSQLI_NUM);

//changing current temperature to be usable in an equation
//$onCurrTemp = preg_replace('/[^-?0-9]/', '', $aktualna_temperatura->plaintext);	
if($onPrevTemp != NULL){
	
$onErrTemp = $onPrevTemp[0] - $onCurrTemp;					//calculating error
//sending error to database
$onInsert = "INSERT INTO `".$onErrTempTable."` (`Time_Tested`, `".($currHour-1)."`) VALUES ('".$currTime."',".$onErrTemp.")";

if($onConn->query($onInsert) === FALSE) {
	echo "Error: " .$onInsert."<br>".$onConn->error;
}
}
}else
{
//taking data from mysql database
$onSelect = "SELECT `".$currHour."` FROM `".$onTempTable."` WHERE Time_Tested LIKE '".(date("d")-1).date(".m.y")."  ".(23)."%'";
$result = $onConn->query($onSelect);
$onPrevTemp = $result->fetch_array(MYSQLI_NUM);

//changing current temperature to be usable in an equation
//$onCurrTemp = preg_replace('/[^-?0-9]/', '', $aktualna_temperatura->plaintext);	
if($onPrevTemp != NULL){
	
$onErrTemp = $onPrevTemp[0] - $onCurrTemp;					//calculating error
//sending error to database
$onInsert = "INSERT INTO `".$onErrTempTable."` (`Time_Tested`, `23`) VALUES ('".$currTime."',".$onErrTemp.")";

if($onConn->query($onInsert) === FALSE) {
	echo "Error: " .$onInsert."<br>".$onConn->error;
}
}
}


//---------------------ZET DATABASE-------------------
$zetInsert = "INSERT INTO `".$zetTempTable."` (`Time_Tested`, `".substr($zetHour[0],0,2)."`, `".substr($zetHour[1],0,2)."`, `".substr($zetHour[2],0,2)."`, `".substr($zetHour[3],0,2)."`, `".substr($zetHour[4],0,2)."`) VALUES ('".$currTime."', ".$zetTemp[0].", ".$zetTemp[1].", ".$zetTemp[2].", ".$zetTemp[3].", ".$zetTemp[4].")";
if($zetConn->query($zetInsert) === FALSE) {
	echo "Error: " .$zetInsert."<br>".$zetConn->error;
}

if($currHour != "00")
{
//taking data from mysql database
$zetSelect = "SELECT `".$currHour."` FROM `".$zetTempTable."` WHERE Time_Tested LIKE '".$currDate."  ".($currHour-1)."%'";
$result = $zetConn->query($zetSelect);
$zetPrevTemp = $result->fetch_array(MYSQLI_NUM);

//changing current temperature to be usable in an equation
//$zetCurrTemp = preg_replace('/[^-?0-9]/', '', $aktualna_temperatura->plaintext);	
if($zetPrevTemp != NULL){
	
$zetErrTemp = $zetPrevTemp[0] - $zetCurrTemp;					//calculating error
//sending error to database
$zetInsert = "INSERT INTO `".$zetErrTempTable."` (`Time_Tested`, `".($currHour-1)."`) VALUES ('".$currTime."',".$zetErrTemp.")";

if($zetConn->query($zetInsert) === FALSE) {
	echo "Error: " .$zetInsert."<br>".$zetConn->error;
}
}
}else
{
//taking data from mysql database
$zetSelect = "SELECT `".$currHour."` FROM `".$zetTempTable."` WHERE Time_Tested LIKE '".(date("d")-1).date(".m.y")."  ".(23)."%'";
$result = $zetConn->query($zetSelect);
$zetPrevTemp = $result->fetch_array(MYSQLI_NUM);

//changing current temperature to be usable in an equation
//$zetCurrTemp = preg_replace('/[^-?0-9]/', '', $aktualna_temperatura->plaintext);	
if($zetPrevTemp != NULL){
	
$zetErrTemp = $zetPrevTemp[0] - $zetCurrTemp;					//calculating error
//sending error to database
$zetInsert = "INSERT INTO `".$zetErrTempTable."` (`Time_Tested`, `23`) VALUES ('".$currTime."',".$zetErrTemp.")";

if($zetConn->query($zetInsert) === FALSE) {
	echo "Error: " .$zetInsert."<br>".$zetConn->error;
}
}
}
}
//------------------------------------------------------------------
$intGetErrorTemp = "SELECT `00`, `01`, `02`, `03`, `04`, `05`, `06`, `07`, `08`, `09`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23` FROM ".$intErrTempTable." WHERE id=(SELECT max(id) FROM ".$intErrTempTable.");";
$resultGet = $intConn->query($intGetErrorTemp);
$intErrArray = $resultGet->fetch_array(MYSQLI_NUM);
if(!empty($intErrArray))
{
for($i = 0; $i < 24; $i++)
{
	if(!empty($intErrArray[$i]))
	{
		$intErrTemp = $intErrArray[$i];
	}
}
}

$onGetErrorTemp = "SELECT `00`, `01`, `02`, `03`, `04`, `05`, `06`, `07`, `08`, `09`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23` FROM ".$onErrTempTable." WHERE id=(SELECT max(id) FROM ".$onErrTempTable.");";
$resultGet = $onConn->query($onGetErrorTemp);
$onErrArray = $resultGet->fetch_array(MYSQLI_NUM);
if(!empty($onErrArray))
{
for($i = 0; $i < 24; $i++)
{
	if(!empty($onErrArray[$i]))
	{
		$onErrTemp = $onErrArray[$i];
	}
}
}

$zetGetErrorTemp = "SELECT `00`, `01`, `02`, `03`, `04`, `05`, `06`, `07`, `08`, `09`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23` FROM ".$zetErrTempTable." WHERE id=(SELECT max(id) FROM ".$zetErrTempTable.");";
$resultGet = $zetConn->query($zetGetErrorTemp);
$zetErrArray = $resultGet->fetch_array(MYSQLI_NUM);
if(!empty($zetErrArray))
{
for($i = 0; $i < 24; $i++)
{
	if(!empty($zetErrArray[$i]))
	{
		$zetErrTemp = $zetErrArray[$i];
	}
}
}

if(abs($intErrTemp) <= abs($onErrTemp))
{
	if(abs($intErrTemp) <= abs($zetErrTemp))
	{
		$intColor = "seagreen";
		$intWidth = "bold";
	}else
	{
		$zetColor = "seagreen";
		$zetWidth = "bold";
	}
}else
{
	if(abs($onErrTemp) <= abs($zetErrTemp))
	{
		$onColor = "seagreen";
		$onWidth = "bold";
	}else
	{
		$zetColor = "seagreen";
		$zetWidth = "bold";
	}		
}
$intConn->close();
$onConn->close();
$zetConn->close();	
?>
</figcaption>
</figure>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Godzina</th>
      <th scope="col">Onet</th>
      <th scope="col">Interia</th>
      <th scope="col">Zet</th>
    </tr>
  </thead>
  <tbody>
  <tr>
      <th scope="row"><?php echo date('H:i');?></th>
      <td><?php echo '<div style="Color:'.$onColor.';font-weight: '.$onWidth.';">'.$onCurrTemp.'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$intColor.';font-weight: '.$intWidth.';">'.$intCurrTemp.'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$zetColor.';font-weight: '.$zetWidth.';">'.$zetCurrTemp.'°C</div>';?></td>
    </tr>
    <tr>
      <th scope="row"><?php echo $zetHour[0]?></th>
      <td><?php echo '<div style="Color:'.$onColor.';font-weight: '.$onWidth.';">'.$onTemp[0].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$intColor.';font-weight: '.$intWidth.';">'.$intTemp[0].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$zetColor.';font-weight: '.$zetWidth.';">'.$zetTemp[0].'°C</div>';?></td>
    </tr>
    <tr>
      <th scope="row"><?php echo $zetHour[1]?></th>
      <td><?php echo '<div style="Color:'.$onColor.';font-weight: '.$onWidth.';">'.$onTemp[1].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$intColor.';font-weight: '.$intWidth.';">'.$intTemp[1].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$zetColor.';font-weight: '.$zetWidth.';">'.$zetTemp[1].'°C</div>';?></td>
    </tr>
    <tr>
      <th scope="row"><?php echo $zetHour[2]?></th>
      <td><?php echo '<div style="Color:'.$onColor.';font-weight: '.$onWidth.';">'.$onTemp[2].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$intColor.';font-weight: '.$intWidth.';">'.$intTemp[2].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$zetColor.';font-weight: '.$zetWidth.';">'.$zetTemp[2].'°C</div>';?></td>
    </tr>
	<tr>
      <th scope="row"><?php echo $zetHour[3]?></th>
      <td><?php echo '<div style="Color:'.$onColor.';font-weight: '.$onWidth.';">'.$onTemp[3].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$intColor.';font-weight: '.$intWidth.';">'.$intTemp[3].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$zetColor.';font-weight: '.$zetWidth.';">'.$zetTemp[3].'°C</div>';?></td>
    </tr>
	<tr>
      <th scope="row"><?php echo $zetHour[4]?></th>
      <td><?php echo '<div style="Color:'.$onColor.';font-weight: '.$onWidth.';">'.$onTemp[4].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$intColor.';font-weight: '.$intWidth.';">'.$intTemp[4].'°C</div>';?></td>
      <td><?php echo '<div style="Color:'.$zetColor.';font-weight: '.$zetWidth.';">'.$zetTemp[4].'°C</div>';?></td>
    </tr>
  </tbody>
</table>



  </tbody>
</body>
</html>