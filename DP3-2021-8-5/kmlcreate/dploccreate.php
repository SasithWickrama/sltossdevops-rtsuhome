<?php

session_start();
$rtom=$_SESSION['rtom'];

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../orcon.php';

$CON= connecttooracle();

if (!$CON) 
{
  die('Not connected : ' );
}

$dploc = $_POST['dploc'];

// creates the document
$dom=new DOMDocument('1.0','UTF-8');

//create the root KML element and appends it to the root document
$node=$dom-> createElementNs('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

// Creates a KML Document element and append it to the KML element.
$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);

$NetStyleNode = $dom->createElement('Style');
$NetStyleNode->setAttribute('id', 'dpst1');
$NetIconstyleNode = $dom->createElement('IconStyle');
$NetIconstyleNode->setAttribute('id', 'msan');
$Netscale=$dom->createElement('scale', '0.85');
$NetIconstyleNode->appendChild($Netscale);
$NetIconNode = $dom->createElement('Icon');
$NetHref = $dom->createElement('href', '../blue.png');
$NetIconNode->appendChild($NetHref);
$NetIconstyleNode->appendChild($NetIconNode);
$NetStyleNode->appendChild($NetIconstyleNode);
$docNode->appendChild($NetStyleNode);


$NetStyleNode = $dom->createElement('Style');
$NetStyleNode->setAttribute('id', 'dpst2');
$NetIconstyleNode = $dom->createElement('IconStyle');
$NetIconstyleNode->setAttribute('id', 'msan');
$Netscale=$dom->createElement('scale', '0.85');
$NetIconstyleNode->appendChild($Netscale);
$NetIconNode = $dom->createElement('Icon');
$NetHref = $dom->createElement('href', '../yellow.png');
$NetIconNode->appendChild($NetHref);
$NetIconstyleNode->appendChild($NetIconNode);
$NetStyleNode->appendChild($NetIconstyleNode);
$docNode->appendChild($NetStyleNode);


$NetStyleNode = $dom->createElement('Style');
$NetStyleNode->setAttribute('id', 'dpst3');
$NetIconstyleNode = $dom->createElement('IconStyle');
$NetIconstyleNode->setAttribute('id', 'msan');
$Netscale=$dom->createElement('scale', '0.85');
$NetIconstyleNode->appendChild($Netscale);
$NetIconNode = $dom->createElement('Icon');
$NetHref = $dom->createElement('href', '../red.png');
$NetIconNode->appendChild($NetHref);
$NetIconstyleNode->appendChild($NetIconNode);
$NetStyleNode->appendChild($NetIconstyleNode);
$docNode->appendChild($NetStyleNode);


if($rtom == 'R-WT')
{
$sql="select distinct a.LATITUDE,a.LONGITUDE,a.dp LOCATION,b.FREE,b.OCCUPIDE
from OSSRPT.GPS_LOCATION a,OSSRPT.GPS_DPFREE  b
where a.dp = B.FRAC_DESCRIPTION
and a.TYPE = 'DP'
and a.RTOM IN ('R-WT','R-MD')
and a.LATITUDE is not null
and a.dp  IN (
select distinct a.dp
from OSSRPT.GPS_LOCATION a
where a.TYPE = 'DP'
and a.RTOM IN ('R-WT','R-MD')
and a.LATITUDE is not null
and a.dp ='$dploc'
minus
select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'DP'
and RTOM IN ('R-WT','R-MD')
and a.dp ='$dploc')";
}
else
{	
$sql="select distinct a.LATITUDE,a.LONGITUDE,a.dp LOCATION,b.FREE,b.OCCUPIDE
from OSSRPT.GPS_LOCATION a,OSSRPT.GPS_DPFREE  b
where a.dp = B.FRAC_DESCRIPTION
and a.TYPE = 'DP'
and a.RTOM ='$rtom'
and a.LATITUDE is not null
and a.dp  IN (
select distinct a.dp
from OSSRPT.GPS_LOCATION a
where a.TYPE = 'DP'
and a.RTOM ='$rtom'
and a.LATITUDE is not null
and a.dp ='$dploc'
minus
select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'DP'
and RTOM = '$rtom'
and a.dp ='$dploc')";

}

  $res = oci_parse($CON, $sql);
  oci_execute($res);

$i=0;

while ($row = oci_fetch_array($res)) {

  $i ++; 

  $freeloop =$row['FREE'];

  $discription =makeDiscription($row,$CON);

  // Creates a Placemark and append it to the Document.
  $node = $dom->createElement('Placemark');
  $placeNode = $docNode->appendChild($node);

  // Creates an id attribute and assign it the value of id column.
  $placeNode->setAttribute('id', 'placemark' . $i);

  $descNode = $dom->createElement('description', $discription);
  $placeNode->appendChild($descNode);


  if ($freeloop > 5)
  {

    $styleUrl = $dom->createElement('styleUrl', '#dpst1');
    $placeNode->appendChild($styleUrl);

  }
  if ($freeloop  < 6 && $freeloop  > 0)
  {

    $styleUrl = $dom->createElement('styleUrl', '#dpst2');
    $placeNode->appendChild($styleUrl);

  }
  if ($freeloop == 0)
  {

    $styleUrl = $dom->createElement('styleUrl', '#dpst3');
    $placeNode->appendChild($styleUrl);

  }
    
  // Creates a Point element.
  $pointNode = $dom->createElement('Point');
  $placeNode->appendChild($pointNode);

  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
  
  $lon = preg_replace('/\s+/', '', $row['LONGITUDE']);
  
  $lat = preg_replace('/\s+/', '', $row['LATITUDE']);
 
  $coorStr = $lon. ','  .$lat;
  $coorNode = $dom->createElement('coordinates', $coorStr);
  $pointNode->appendChild($coorNode);
  
}

//header('Content-type: application/vnd.google-earth.kml+xml');
$kmlOutput = $dom->saveXML();
$dom->save("../kmlfiles/dploc.kml");
//echo $kmlOutput;


function makeDiscription($row,$CON){

$dis = '<![CDATA[<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

<table class="table" style="width:100%" >
  
  <tr>
    <td colspan="2"><b>'.$row['LOCATION'].'</b></td>
  </tr>

  <tr>
    <td>Used Loops :</td>
    <td>'.$row['OCCUPIDE'].'</td>
  </tr>

  <tr>
    <td>Free Loops :</td>
    <td>'.$row['FREE'].'</td>
  </tr>

</table>

</body>
</html>';

return $dis;

}

?>