<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
     $user = $_SESSION['$UID'];
 	$opmc=$_SESSION['opmc'];
	
if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null   ){	
	echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
 	}
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../dbcon.php';

$info = $_POST['info'];
$ser = $_POST['serv'];

if (!$CON) 
{
  die('Not connected : ' );
}


set_time_limit (1000);

$totcount=0;
$countstring=""; 

$checkCount = sizeof($info);

	for($n=0; $n<$checkCount; $n++){

		if($info[$n] == 'MSAN'){
		if($countstring == ""){
			$countstring  = "nvl(SUM(MSAN_PORT_ISSUES),0)";
		}else{
			$countstring = $countstring ." +nvl(SUM(MSAN_PORT_ISSUES),0)";
		}
		
		}
		
		if($info[$n] == 'CPE'){
		if($countstring == ""){
			$countstring  = " nvl(SUM(CPE_ISSUES),0)";
		}else{
			$countstring = $countstring ." +nvl(SUM(CPE_ISSUES),0)";
		}
		
		}
		
		if($info[$n] == 'UG'){
		if($countstring == ""){
			$countstring  = " nvl(SUM(UG_FAULTS),0)";
		}else{
			$countstring = $countstring ." + nvl(SUM(UG_FAULTS),0)";
		}
		
		}

	}

$sql="SELECT X.*   FROM (
SELECT DISTINCT LOCN_TTNAME ,LOCN_X,LOCN_Y,nvl(SUM(FAULTS_REPORTED),0) 
AS FAULTS_REPORTED,nvl(SUM(FAULTS_REPORTED_WITHOUT_REPEAT),0) AS FAULTS_REPORTED_WITHOUT_REPEAT, nvl(SUM(MSAN_PORT_ISSUES),0)
AS MSAN_PORT_ISSUES,nvl(SUM(CPE_ISSUES),0) AS CPE_ISSUES, nvl(SUM(UG_FAULTS),0) AS  UG_FAULTS,
".$countstring."  TOTAL_FAULT_COUNT 
FROM FRAME_UNITS FU, FRAME_CONTAINERS FC , FRAME_APPEARANCES fa ,RTSU_DP nc , LOCATIONS l
WHERE FU.FRAU_FRAC_ID = FC.FRAC_ID
and fu.FRAU_ID = fa.FRAA_FRAU_ID
AND fc.FRAC_FRAN_NAME IN ( 'DP','FDP')
AND fa.FRAA_SIDE = 'REAR'
AND FC.FRAC_LOCN_TTNAME = L.LOCN_TTNAME
AND FU.FRAU_NAME = DP
AND MOPMC = '".$opmc."'
AND SERVICE_TYPE IN (".$ser.")
    AND LOCN_X IS NOT NULL
GROUP BY LOCN_TTNAME,LOCN_X,LOCN_Y)X
    ORDER BY TOTAL_FAULT_COUNT ";
	  
	// $stid=oci_parse($CON,$sql);
	$stid1=oci_parse($CON,$sql);
	$stid2=oci_parse($CON,$sql);
	// oci_execute($stid);
	oci_execute($stid1);
	oci_execute($stid2);
	
	//oci_fetch_all($stid1, $array);
	//unset($stid1);
	$numberofrows = oci_fetch_all($stid1, $res); //oci_num_rows($stid);
	oci_free_statement($stid1);
	
	$first = $numberofrows *20/100;
	$sec = $numberofrows *80/100;

	
	$firstval=0;
	$secval=0;
	//$tempx = $res[$first];

// creates the document
$dom=new DOMDocument('1.0','UTF-8');

//create the root KML element and appends it to the root document
$node=$dom-> createElementNs('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

// Creates a KML Document element and append it to the KML element.
$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);


$manholeStyleNode = $dom->createElement('Style');
$manholeStyleNode->setAttribute('id', 'greenball');
$manholeIconstyleNode = $dom->createElement('IconStyle');
$manholeIconstyleNode->setAttribute('id', 'manhole');
$manholescale=$dom->createElement('scale', '0.25');
$manholeIconstyleNode->appendChild($manholescale);
$manholeIconNode = $dom->createElement('Icon');
$manholeHref = $dom->createElement('href', 'http://172.25.17.225/RTSUHOME/eqmap/img/green-ball.ico');
$manholeIconNode->appendChild($manholeHref);
$manholeIconstyleNode->appendChild($manholeIconNode);
$manholeStyleNode->appendChild($manholeIconstyleNode);
$docNode->appendChild($manholeStyleNode);



$handholeStyleNode = $dom->createElement('Style');
$handholeStyleNode->setAttribute('id', 'blueball');
$handholeIconstyleNode = $dom->createElement('IconStyle');
$handholeIconstyleNode->setAttribute('id', 'manhole');
$handholescale=$dom->createElement('scale', '0.5');
$handholeIconstyleNode->appendChild($handholescale);
$handholeIconNode = $dom->createElement('Icon');
$handholeHref = $dom->createElement('href', 'http://172.25.17.225/RTSUHOME/eqmap/img/orange_boll.png');
$handholeIconNode->appendChild($handholeHref);
$handholeIconstyleNode->appendChild($handholeIconNode);
$handholeStyleNode->appendChild($handholeIconstyleNode);
$docNode->appendChild($handholeStyleNode);


$handholeStyleNode = $dom->createElement('Style');
$handholeStyleNode->setAttribute('id', 'redball');
$handholeIconstyleNode = $dom->createElement('IconStyle');
$handholeIconstyleNode->setAttribute('id', 'manhole');
$handholescale=$dom->createElement('scale', '1');
$handholeIconstyleNode->appendChild($handholescale);
$handholeIconNode = $dom->createElement('Icon');
$handholeHref = $dom->createElement('href', 'http://172.25.17.225/RTSUHOME/eqmap/img/red.png');
$handholeIconNode->appendChild($handholeHref);
$handholeIconstyleNode->appendChild($handholeIconNode);
$handholeStyleNode->appendChild($handholeIconstyleNode);
$docNode->appendChild($handholeStyleNode);
 
$ccount =0;
$greenballArr=array();
$orangeballArr=array();
$redballArr=array();


while ($row2=oci_fetch_array($stid2)) {
$ccount++;
 
  
  	$checkCount = sizeof($info);

	for($n=0; $n<$checkCount; $n++){

		if($info[$n] == 'MSAN'){
		
			$totcount += $row2['MSAN_PORT_ISSUES'];
		
		}
		
		if($info[$n] == 'CPE'){
		
			$totcount += $row2['CPE_ISSUES'];
		
		}
		
		if($info[$n] == 'UG'){
		
			$totcount += $row2['UG_FAULTS'];
		
		}

	}

 

  if($ccount < $first)  
  { 	


		$greenballArr[] = "'".$row2['LOCN_TTNAME']."'";

  }else{

	  if($ccount == $first){ $firstval = $totcount; }
	  

	  if($totcount == $firstval ){

	  	  $greenballArr[] = "'".$row2['LOCN_TTNAME']."'";

	  }else{
		  if($ccount < $sec) 
		  { 	
		 
		  $orangeballArr[] = "'".$row2['LOCN_TTNAME']."'";


		  }
		   else {
				if($ccount == $sec){ $secval = $totcount; }
				
				if($totcount == $secval ){

					$orangeballArr[] = "'".$row2['LOCN_TTNAME']."'";
						  

				}else{

					$redballArr[] = "'".$row2['LOCN_TTNAME']."'";
				}
		  }
	  }
  }
  

 
}


$greenballArrlength= sizeof($greenballArr);
$orangeballArrlength = sizeof($orangeballArr);
$redballArrlength = sizeof($redballArr);



$greenballLimit = $greenballArrlength* 85/100;
$orangeballLimit = $orangeballArrlength* 85/100;
$redballLimit = $redballArrlength* 85/100;

for ($i=$greenballArrlength; $i> $greenballLimit ; $i--) { 


// if ($greenballLimit>$i) {
	

$sql2="SELECT X.*   FROM (
SELECT DISTINCT LOCN_TTNAME ,LOCN_X,LOCN_Y,nvl(SUM(FAULTS_REPORTED),0) 
AS FAULTS_REPORTED,nvl(SUM(FAULTS_REPORTED_WITHOUT_REPEAT),0) AS FAULTS_REPORTED_WITHOUT_REPEAT, nvl(SUM(MSAN_PORT_ISSUES),0)
AS MSAN_PORT_ISSUES,nvl(SUM(CPE_ISSUES),0) AS CPE_ISSUES, nvl(SUM(UG_FAULTS),0) AS  UG_FAULTS,
".$countstring."  TOTAL_FAULT_COUNT 
FROM FRAME_UNITS FU, FRAME_CONTAINERS FC , FRAME_APPEARANCES fa ,RTSU_DP nc , LOCATIONS l
WHERE FU.FRAU_FRAC_ID = FC.FRAC_ID
and fu.FRAU_ID = fa.FRAA_FRAU_ID
AND fc.FRAC_FRAN_NAME IN ( 'DP','FDP')
AND fa.FRAA_SIDE = 'REAR'
AND FC.FRAC_LOCN_TTNAME = L.LOCN_TTNAME
AND FU.FRAU_NAME = DP
AND MOPMC = '".$opmc."'
AND LOCN_TTNAME = ".$greenballArr[$i]."
AND SERVICE_TYPE IN (".$ser.")
    AND LOCN_X IS NOT NULL
GROUP BY LOCN_TTNAME,LOCN_X,LOCN_Y)X
    ORDER BY TOTAL_FAULT_COUNT ";


$stid4=oci_parse($CON,$sql2);
oci_execute($stid4);

while ($row=oci_fetch_array($stid4)) {


$node = $dom->createElement('Placemark');
		  $placeNode = $docNode->appendChild($node);

		  // Creates an id attribute and assign it the value of id column.
		  $placeNode->setAttribute('id', 'placemark' . $row['LOCN_TTNAME']);

		  // Create name, and description elements and assigns them the values of the name and address columns from the results.
		  $nameNode = $dom->createElement('name',htmlentities($row['LOCN_TTNAME']));
		  $placeNode->appendChild($nameNode);
		  $descNode = $dom->createElement('description', $discription);
		  $placeNode->appendChild($descNode);


		  $styleUrl = $dom->createElement('styleUrl', '#greenball');
		  $placeNode->appendChild($styleUrl);

		  $discription =makeDiscription($row,$info,$ser);



		  // Creates a Point element.
		  $pointNode = $dom->createElement('Point');
		  $placeNode->appendChild($pointNode);

		  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
		  $coorStr = $row['LOCN_Y'] . ','  . $row['LOCN_X'];
		  $coorNode = $dom->createElement('coordinates', $coorStr);
		  $pointNode->appendChild($coorNode);

}
// }

}

for ($j=$orangeballArrlength; $j> $orangeballLimit ; $j--) { 


// if ($greenballLimit>$i) {
	

$sql3="SELECT X.*   FROM (
SELECT DISTINCT LOCN_TTNAME ,LOCN_X,LOCN_Y,nvl(SUM(FAULTS_REPORTED),0) 
AS FAULTS_REPORTED,nvl(SUM(FAULTS_REPORTED_WITHOUT_REPEAT),0) AS FAULTS_REPORTED_WITHOUT_REPEAT, nvl(SUM(MSAN_PORT_ISSUES),0)
AS MSAN_PORT_ISSUES,nvl(SUM(CPE_ISSUES),0) AS CPE_ISSUES, nvl(SUM(UG_FAULTS),0) AS  UG_FAULTS,
".$countstring."  TOTAL_FAULT_COUNT 
FROM FRAME_UNITS FU, FRAME_CONTAINERS FC , FRAME_APPEARANCES fa ,RTSU_DP nc , LOCATIONS l
WHERE FU.FRAU_FRAC_ID = FC.FRAC_ID
and fu.FRAU_ID = fa.FRAA_FRAU_ID
AND fc.FRAC_FRAN_NAME IN ( 'DP','FDP')
AND fa.FRAA_SIDE = 'REAR'
AND FC.FRAC_LOCN_TTNAME = L.LOCN_TTNAME
AND FU.FRAU_NAME = DP
AND MOPMC = '".$opmc."'
AND LOCN_TTNAME = ".$orangeballArr[$j]."
AND SERVICE_TYPE IN (".$ser.")
    AND LOCN_X IS NOT NULL
GROUP BY LOCN_TTNAME,LOCN_X,LOCN_Y)X
    ORDER BY TOTAL_FAULT_COUNT ";


$stid5=oci_parse($CON,$sql3);
oci_execute($stid5);

while ($row5=oci_fetch_array($stid5)) {


$node = $dom->createElement('Placemark');
		  $placeNode = $docNode->appendChild($node);

		  // Creates an id attribute and assign it the value of id column.
		  $placeNode->setAttribute('id', 'placemark' . $row5['LOCN_TTNAME']);

		  // Create name, and description elements and assigns them the values of the name and address columns from the results.
		  $nameNode = $dom->createElement('name',htmlentities($row5['LOCN_TTNAME']));
		  $placeNode->appendChild($nameNode);
		  $descNode = $dom->createElement('description', $discription);
		  $placeNode->appendChild($descNode);


		  $styleUrl = $dom->createElement('styleUrl', '#blueball');
		  $placeNode->appendChild($styleUrl);

		  $discription =makeDiscription($row5,$info,$ser);



		  // Creates a Point element.
		  $pointNode = $dom->createElement('Point');
		  $placeNode->appendChild($pointNode);

		  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
		  $coorStr = $row5['LOCN_Y'] . ','  . $row5['LOCN_X'];
		  $coorNode = $dom->createElement('coordinates', $coorStr);
		  $pointNode->appendChild($coorNode);

}
// }

}


for ($n=$redballArrlength; $n> $redballLimit ; $n--) { 


// if ($greenballLimit>$i) {
	

$sql4="SELECT X.*   FROM (
SELECT DISTINCT LOCN_TTNAME ,LOCN_X,LOCN_Y,nvl(SUM(FAULTS_REPORTED),0) 
AS FAULTS_REPORTED,nvl(SUM(FAULTS_REPORTED_WITHOUT_REPEAT),0) AS FAULTS_REPORTED_WITHOUT_REPEAT, nvl(SUM(MSAN_PORT_ISSUES),0)
AS MSAN_PORT_ISSUES,nvl(SUM(CPE_ISSUES),0) AS CPE_ISSUES, nvl(SUM(UG_FAULTS),0) AS  UG_FAULTS,
".$countstring."  TOTAL_FAULT_COUNT 
FROM FRAME_UNITS FU, FRAME_CONTAINERS FC , FRAME_APPEARANCES fa ,RTSU_DP nc , LOCATIONS l
WHERE FU.FRAU_FRAC_ID = FC.FRAC_ID
and fu.FRAU_ID = fa.FRAA_FRAU_ID
AND fc.FRAC_FRAN_NAME IN ( 'DP','FDP')
AND fa.FRAA_SIDE = 'REAR'
AND FC.FRAC_LOCN_TTNAME = L.LOCN_TTNAME
AND FU.FRAU_NAME = DP
AND MOPMC = '".$opmc."'
AND LOCN_TTNAME = ".$redballArr[$n]."
AND SERVICE_TYPE IN (".$ser.")
    AND LOCN_X IS NOT NULL
GROUP BY LOCN_TTNAME,LOCN_X,LOCN_Y)X
    ORDER BY TOTAL_FAULT_COUNT ";


$stid6=oci_parse($CON,$sql4);
oci_execute($stid6);

while ($row6=oci_fetch_array($stid6)) {


$node = $dom->createElement('Placemark');
		  $placeNode = $docNode->appendChild($node);

		  // Creates an id attribute and assign it the value of id column.
		  $placeNode->setAttribute('id', 'placemark' . $row6['LOCN_TTNAME']);

		  // Create name, and description elements and assigns them the values of the name and address columns from the results.
		  $nameNode = $dom->createElement('name',htmlentities($row6['LOCN_TTNAME']));
		  $placeNode->appendChild($nameNode);
		  $descNode = $dom->createElement('description', $discription);
		  $placeNode->appendChild($descNode);


		  $styleUrl = $dom->createElement('styleUrl', '#redball');
		  $placeNode->appendChild($styleUrl);

		  $discription =makeDiscription($row6,$info,$ser);



		  // Creates a Point element.
		  $pointNode = $dom->createElement('Point');
		  $placeNode->appendChild($pointNode);

		  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
		  $coorStr = $row6['LOCN_Y'] . ','  . $row6['LOCN_X'];
		  $coorNode = $dom->createElement('coordinates', $coorStr);
		  $pointNode->appendChild($coorNode);

}


}


//header('Content-type: application/vnd.google-earth.kml+xml');
$kmlOutput = $dom->saveXML();
$dom->save("../kmlfiles/dp.kml");
//echo $kmlOutput;


function makeDiscription($row,$info,$ser){

	$dis = '<![CDATA[<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

</head>
<body>

<table class="table" style="width:100%" >

  <tr>
    <td>LOCATION:</td>
    <td>'.$row['LOCN_TTNAME'].'</td>
  </tr>
  
  <tr>
    <td>SERVICE TYPE:</td>
    <td>'.$ser.'</td>
  </tr>
  
  <tr>
    <td>FAULTS REPORTED:</td>
    <td>'.$row['FAULTS_REPORTED'].'</td>
  </tr>
  
  <tr>
    <td>FAULTS REPORTED WITHOUT_REPEAT:</td>
    <td>'.$row['FAULTS_REPORTED_WITHOUT_REPEAT'].'</td>
  </tr>';
 
	$dcount = sizeof($info);
		
  	for($i=0; $i<$dcount; $i++){

		if($info[$i] == 'MSAN'){
		
		$dis .= '<tr>
				<td>MSAN PORT ISSUES:</td>
				<td>'.$row['MSAN_PORT_ISSUES'].'</td>
			  </tr>';

		}
		
		if($info[$i] == 'CPE'){
			
			$dis .= '<tr>
				<td>CPE ISSUES:</td>
				<td>'.$row['CPE_ISSUES'].'</td>
			  </tr>';
		
		}
		
		if($info[$i] == 'UG'){
			
			$dis .= '<tr>
				<td>UG FAULTS:</td>
				<td>'.$row['UG_FAULTS'].'</td>
			  </tr>';
		
		}

	}

$dis .= '</table>

</body>
</html>';

return $dis;
}
?>