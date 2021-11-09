<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
</head>
<body>

<?php
	include('simple_html_dom.php');

	$interia = file_get_html('https://pogoda.interia.pl/prognoza-szczegolowa-sosnowiec,cId,32574');
	
	$onet = file_get_html('https://pogoda.onet.pl/prognoza-pogody/sosnowiec-346939');
	
	$wp = file_get_html('https://pogoda.wp.pl/pogoda-na-dzis/sosnowiec/3085128');
	
	$zet = file_get_html('https://wiadomosci.radiozet.pl/Pogoda/(region)/slaskie/(miasto)/sosnowiec/(prognoza)/godzinowa');
	
	
	
	header("Refresh:60");
	echo("Ostatnie odświeżenie: ");
	echo "<br>";
	echo date('H:i:s Y-m-d');
	echo "<br>";
	echo "<br>";
	echo "<br>";

	echo $interia->find('title', 0)->plaintext;
	
	echo "<br>";

	//$list = $interia->find('div [class="entry-forecast"]',0);
	
	
	//----------------------------------------------------------------------
	//temperatury interia
	$list = $interia->find('div [class="forecast-top"]',0);
	$list_array=$list->find('span');
	
	$list1 = $interia->find('div [class="forecast-top"]',1);
	$list_array1=$list1->find('span');
	
	$list2 = $interia->find('div [class="forecast-top"]',2);
	$list_array2=$list2->find('span');
	
	$list3 = $interia->find('div [class="forecast-top"]',3);
	$list_array3=$list3->find('span');
	
	$list4 = $interia->find('div [class="forecast-top"]',4);
	$list_array4=$list4->find('span');
	//temperatury interia
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//godziny interia
	$list5 = $interia->find('div [class="entry-hour"]',0);
	$list_array5=$list5->find('span');
	
	$list6 = $interia->find('div [class="entry-hour"]',1);
	$list_array6=$list6->find('span');
	
	$list7 = $interia->find('div [class="entry-hour"]',2);
	$list_array7=$list7->find('span');
	
	$list8 = $interia->find('div [class="entry-hour"]',3);
	$list_array8=$list8->find('span');
	
	$list9 = $interia->find('div [class="entry-hour"]',4);
	$list_array9=$list9->find('span');
	//godziny interia
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//temperatury onet
	$list10 = $onet->find('div [class="temp"]',1);
	//$list_array10=$list->find('span');
	
	$list11 = $onet->find('div [class="temp"]',2);
	//$list_array11=$list11->find('span');
	
	$list12 = $onet->find('div [class="temp"]',3);
	//$list_array12=$list12->find('span');
	
	$list13 = $onet->find('div [class="temp"]',4);
	//$list_array13=$list13->find('span');
	
	$list14 = $onet->find('div [class="temp"]',5);
	//$list_array14=$list14->find('span');
	//temperatury onet
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//godziny onet
	$list15 = $onet->find('div [class="time"]',1);
	//$list_array15=$list15->find('span');
	
	$list16 = $onet->find('div [class="time"]',2);
	//$list_array16=$list16->find('span');
	
	$list17 = $onet->find('div [class="time"]',3);
	//$list_array17=$list17->find('span');
	
	$list18 = $onet->find('div [class="time"]',4);
	//$list_array18=$list18->find('span');
	
	$list19 = $onet->find('div [class="time"]',5);
	//$list_array19=$list19->find('span');
	//godziny onet
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//temperatury zet
	$list20 = $zet->find('div [class="single-weather-item__temperature single-weather-item__item"]',1);
	//$list_array10=$list->find('span');
	
	$list21 = $zet->find('div [class="single-weather-item__temperature single-weather-item__item"]',2);
	//$list_array11=$list11->find('span');
	
	$list22 = $zet->find('div [class="single-weather-item__temperature single-weather-item__item"]',3);
	//$list_array12=$list12->find('span');
	
	$list23 = $zet->find('div [class="single-weather-item__temperature single-weather-item__item"]',4);
	//$list_array13=$list13->find('span');
	
	$list24 = $zet->find('div [class="single-weather-item__temperature single-weather-item__item"]',5);
	//$list_array14=$list14->find('span');
	//temperatury zet
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//godziny zet
	$list25 = $zet->find('div [class="single-weather-item"]',1);
	$list_array25=$list25->find('span');
	
	$list26 = $zet->find('div [class="single-weather-item"]',2);
	$list_array26=$list26->find('span');
	
	$list27 = $zet->find('div [class="single-weather-item"]',3);
	$list_array27=$list27->find('span');
	
	$list28 = $zet->find('div [class="single-weather-item"]',4);
	$list_array28=$list28->find('span');
	
	$list29 = $zet->find('div [class="single-weather-item"]',5);
	$list_array29=$list29->find('span');
	//godziny zet
	//----------------------------------------------------------------------
	
	
	
	//----------------------------------------------------------------------
	//temperatury wp
	/*$list20 = $wp->find('div [class="right" data-v-6afd4e19]',1);
	$list_array20=$list20->find('span');
	
	$list21 = $wp->find('div [class="right" data-v-6afd4e19]',2);
	$list_array21=$list21->find('span');
	
	$list22 = $wp->find('div [class="right" data-v-6afd4e19]',3);
	$list_array22=$list22->find('span');
	
	$list23 = $wp->find('div [class="right" data-v-6afd4e19]',4);
	$list_array23=$list23->find('span');
	
	$list24 = $wp->find('div [class="right" data-v-6afd4e19]',5);
	$list_array24=$list24->find('span');
	//temperatury wp
	//----------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------
	//godziny wp
	$list25 = $wp->find('div [class="data center" data-v-6afd4e19]',1);
	$list_array25=$list25->find('span');
	
	$list26 = $wp->find('div [class="data center" data-v-6afd4e19]',2);
	$list_array16=$list16->find('span');
	
	$list27 = $wp->find('div [class="data center" data-v-6afd4e19]',3);
	$list_array27=$list27->find('span');
	
	$list28 = $wp->find('div [class="data center" data-v-6afd4e19]',4);
	$list_array28=$list28->find('span');
	
	$list29 = $wp->find('div [class="data center" data-v-6afd4e19]',5);
	$list_array29=$list29->find('span');*/
	//godziny wp
	//----------------------------------------------------------------------
	
	
	/*
	for($i=0; $i<sizeof($list_array); $i++){
		echo $list_array[$i];
		echo "<br>";
	}
	
	echo "<br>";
	
	for($i=0; $i<sizeof($list_array1); $i++){
		echo $list_array1[$i];
		echo "<br>";
	}
	
		echo "<br>";
	
	for($i=0; $i<sizeof($list_array2); $i++){
		echo $list_array2[$i];
		echo "<br>";
	}

	echo "<br>";
	
	for($i=0; $i<sizeof($list_array3); $i++){
		echo $list_array3[$i];
		echo "<br>";
	}


	echo "<br>";
	
	for($i=0; $i<sizeof($list_array4); $i++){
		echo $list_array4[$i];
		echo "<br>";
	}*/

echo "<br>";
echo $list_array5[1],":",$list_array5[2]," ",$list_array[2];
echo "<br>";
echo "<br>";
echo $list_array6[1],":",$list_array6[2]," ",$list_array1[2];
echo "<br>";
echo "<br>";
echo $list_array7[1],":",$list_array7[2]," ",$list_array2[2];
echo "<br>";
echo "<br>";
echo $list_array8[1],":",$list_array8[2]," ",$list_array3[2];
echo "<br>";
echo "<br>";
echo $list_array9[1],":",$list_array9[2]," ",$list_array4[2];
echo "<br>";


echo "<br>";
echo "<br>";
echo $onet->find('title', 0)->plaintext;
echo "<br>";
echo "<br>";
echo $list15->plaintext,$list10->plaintext,"C";
echo "<br>";
echo "<br>";
echo $list16->plaintext,$list11->plaintext,"C";
echo "<br>";
echo "<br>";
echo $list17->plaintext,$list12->plaintext,"C";
echo "<br>";
echo "<br>";
echo $list18->plaintext,$list13->plaintext,"C";
echo "<br>";
echo "<br>";
echo $list19->plaintext,$list14->plaintext,"C";
echo "<br>";


echo "<br>";
echo "<br>";
echo $zet->find('title', 0)->plaintext;
echo "<br>";
echo "<br>";
echo $list_array25[0]->plaintext,$list20->plaintext;
echo "<br>";
echo "<br>";
echo $list_array26[0]->plaintext,$list21->plaintext;
echo "<br>";
echo "<br>";
echo $list_array27[0]->plaintext,$list22->plaintext;
echo "<br>";
echo "<br>";
echo $list_array28[0]->plaintext,$list23->plaintext;
echo "<br>";
echo "<br>";
echo $list_array29[0]->plaintext,$list24->plaintext;
echo "<br>";


/*echo $wp->find('title', 0)->plaintext;
echo "<br>";
echo "<br>";
echo $list_array25[0]->plaintext,$list_array20[0]->plaintext,"C";
echo "<br>";
echo "<br>";
echo $list_array26[0]->plaintext,$list_array21[0]->plaintext,"C";
echo "<br>";
echo "<br>";
echo $list_array27[0]->plaintext,$list_array22[0]->plaintext,"C";
echo "<br>";
echo "<br>";
echo $list_array28[0]->plaintext,$list_array23[0]->plaintext,"C";
echo "<br>";
echo "<br>";
echo $list_array29[0]->plaintext,$list_array24[0]->plaintext,"C";
echo "<br>";*/

/*echo "<br>";
echo $list_array16[1],":",$list_array16[2]," ",$list_array11[2];
echo "<br>";
echo $list_array17[1],":",$list_array17[2]," ",$list_array12[2];
echo "<br>";
echo $list_array18[1],":",$list_array18[2]," ",$list_array13[2];
echo "<br>";
echo $list_array19[1],":",$list_array19[2]," ",$list_array14[2];
echo "<br>";*/

$intTemp1 = preg_replace('/[^0-9]/', '', $list_array[2]);
$onTemp1 = preg_replace('/[^0-9]/', '', $list10->plaintext);
$zetTemp1 = preg_replace('/[^0-9]/', '', $list20->plaintext);
$intH = $list_array5[1]->plaintext.':'.$list_array5[2]->plaintext;

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
</body>
</html>