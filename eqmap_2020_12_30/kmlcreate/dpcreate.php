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
set_time_limit(300);
$totcount=0;

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
SELECT DISTINCT DP AS LOCN_TTNAME ,LOCN_X,LOCN_Y,nvl(SUM(FAULTS_REPORTED),0) 
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
	AND DP <> 'TEMP-DP'
GROUP BY DP,LOCN_X,LOCN_Y)X
    ORDER BY TOTAL_FAULT_COUNT";


	$stid=oci_parse($CON,$sql);
	$stid1=oci_parse($CON,$sql);
	oci_execute($stid);
	oci_execute($stid1);

	$numberofrows = oci_fetch_all($stid1, $res); //oci_num_rows($stid);
	oci_free_statement($stid1);
	
	$first = $numberofrows *85/100;
	

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
// Iterates through the MySQL results, creating one Placemark for each row.
while ($row=oci_fetch_array($stid)) {
$ccount++;
  $discription =makeDiscription($row,$info,$ser);

  // Creates a Placemark and append it to the Document.

  $node = $dom->createElement('Placemark');
  $placeNode = $docNode->appendChild($node);

  // Creates an id attribute and assign it the value of id column.
  $placeNode->setAttribute('id', 'placemark' . $row['LOCN_TTNAME']);

  // Create name, and description elements and assigns them the values of the name and address columns from the results.
  $nameNode = $dom->createElement('name',htmlentities($row['LOCN_TTNAME']));
  $placeNode->appendChild($nameNode);
  $descNode = $dom->createElement('description', $discription);
  $placeNode->appendChild($descNode);
  
  	$checkCount = sizeof($info);

	for($n=0; $n<$checkCount; $n++){

		if($info[$n] == 'MSAN'){
		
			$totcount += $row['MSAN_PORT_ISSUES'];
		
		}
		
		if($info[$n] == 'CPE'){
		
			$totcount += $row['CPE_ISSUES'];
		
		}
		
		if($info[$n] == 'UG'){
		
			$totcount += $row['UG_FAULTS'];
		
		}

	}


    if($ccount >= $first)  
	{ 	

	  $styleUrl = $dom->createElement('styleUrl', '#redball');
	  $placeNode->appendChild($styleUrl);
			
	  // Creates a Point element.
	  $pointNode = $dom->createElement('Point');
	  $placeNode->appendChild($pointNode);

	  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
	  $coorStr = $row['LOCN_Y'] . ','  . $row['LOCN_X'];
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