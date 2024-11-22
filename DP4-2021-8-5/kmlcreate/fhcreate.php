<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../dbcon.php';

$CON= connecttooracle();

if (!$CON) 
{
  die('Not connected : ' );
}

$rtom = $_POST['rtom'];

// creates the document
$dom=new DOMDocument('1.0','UTF-8');

//create the root KML element and appends it to the root document
$node=$dom-> createElementNs('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

// Creates a KML Document element and append it to the KML element.
$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);

$NetStyleNode = $dom->createElement('Style');
$NetStyleNode->setAttribute('id', 'fh1');
$NetIconstyleNode = $dom->createElement('IconStyle');
$NetIconstyleNode->setAttribute('id', 'msan');
$Netscale=$dom->createElement('scale', '0.95');
$NetIconstyleNode->appendChild($Netscale);
$NetIconNode = $dom->createElement('Icon');
$NetHref = $dom->createElement('href', 'http://ossportal/out_dated/SLTIlastrator/images/Home16.png');
$NetIconNode->appendChild($NetHref);
$NetIconstyleNode->appendChild($NetIconNode);
$NetStyleNode->appendChild($NetIconstyleNode);
$docNode->appendChild($NetStyleNode);


$cableStyleNode = $dom->createElement('Style');
$cableStyleNode->setAttribute('id', 'line-style');
$cablestyleNode = $dom->createElement('BalloonStyle');
$cablelinestyleNode = $dom->createElement('LineStyle');
$cablecolour = $dom->createElement('color', 'FF0000');
$cablelinestyleNode->appendChild($cablecolour);
$cablewidth = $dom->createElement('width', '4.294');
$cablelinestyleNode->appendChild($cablewidth);
$cablestyleNode->appendChild($cablelinestyleNode);
$cableStyleNode->appendChild($cablestyleNode);
$docNode->appendChild($cableStyleNode);


$sql="SELECT  LAT,LOG,TP_NO, CUS_NAME,CUS_ADDRESS,FDP  FROM OSSRPT.GPS_CUST  where LAT is not null";

  $res = oci_parse($CON, $sql);
  oci_execute($res);

$i=0;

while ($row = oci_fetch_array($res)) {

  $i ++; 

  $discription =makeDiscription($row,$CON);

  // Creates a Placemark and append it to the Document.
  $node = $dom->createElement('Placemark');
  $placeNode = $docNode->appendChild($node);

  // Creates an id attribute and assign it the value of id column.
  $placeNode->setAttribute('id', 'placemark' . $i);

  $descNode = $dom->createElement('description', $discription);
  $placeNode->appendChild($descNode);


  $styleUrl = $dom->createElement('styleUrl', '#fh1');
  $placeNode->appendChild($styleUrl);
    
  // Creates a Point element.
  $pointNode = $dom->createElement('Point');
  $placeNode->appendChild($pointNode);

  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
  
  $lon = preg_replace('/\s+/', '', $row['LOG']);
  
  $lat = preg_replace('/\s+/', '', $row['LAT']);
 
  $coorStr = $lon. ','  .$lat;
  $coorNode = $dom->createElement('coordinates', $coorStr);
  $pointNode->appendChild($coorNode);
  
}

$kmlOutput = $dom->saveXML();
$dom->save("../kmlfiles/fh.kml");
//echo $kmlOutput;


function makeDiscription($row,$CON){

$dis = '<![CDATA[<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

<table class="table table-borderless" style="width:100%" >
  
  <tr>
    <td colspan="2"><b>'.$row['CUS_NAME'].'</b></td>
  </tr>

  <tr>
    <td colspan="2">'.$row['TP_NO'].'</td>
  </tr>

</table>

</body>
</html>';

return $dis;

}

?>