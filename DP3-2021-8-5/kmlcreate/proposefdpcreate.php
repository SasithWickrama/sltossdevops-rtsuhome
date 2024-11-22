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
$NetStyleNode->setAttribute('id', 'locationStyle');
$NetIconstyleNode = $dom->createElement('IconStyle');
$NetIconstyleNode->setAttribute('id', 'msan');
$Netscale=$dom->createElement('scale', '1.25');
$NetIconstyleNode->appendChild($Netscale);
$NetIconNode = $dom->createElement('Icon');
$NetHref = $dom->createElement('href', 'http://ossportal/out_dated/SLTIlastrator/images/fdp.png');
$NetIconNode->appendChild($NetHref);
$NetIconstyleNode->appendChild($NetIconNode);
$NetStyleNode->appendChild($NetIconstyleNode);
$docNode->appendChild($NetStyleNode);


$sql="select FDP_LON,FDP_LAT,FDP_NAME,FDP_ID
from OSSRPT.GPS_FDP
where 
RTOM ='$rtom'
and FDP_LON is not null and FDP_LAT is not null";

  $res = oci_parse($CON, $sql);
  oci_execute($res);

while ($row = oci_fetch_array($res)) {

  $discription =makeDiscription($row,$CON);

  // Creates a Placemark and append it to the Document.
  $node = $dom->createElement('Placemark');
  $placeNode = $docNode->appendChild($node);

  // Creates an id attribute and assign it the value of id column.
  $placeNode->setAttribute('id', 'placemark' . $row['FDP_ID']);

  $descNode = $dom->createElement('description', $discription);
  $placeNode->appendChild($descNode);
  
  $styleUrl = $dom->createElement('styleUrl', '#locationStyle');
  $placeNode->appendChild($styleUrl);
  
  // Creates a Point element.
  $pointNode = $dom->createElement('Point');
  $placeNode->appendChild($pointNode);

  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
  
  $lon = preg_replace('/\s+/', '', $row['FDP_LON']);
  
  $lat = preg_replace('/\s+/', '', $row['FDP_LAT']);
 
  $coorStr = $lon. ','  .$lat;
  $coorNode = $dom->createElement('coordinates', $coorStr);
  $pointNode->appendChild($coorNode);
  
}

//header('Content-type: application/vnd.google-earth.kml+xml');
$kmlOutput = $dom->saveXML();
$dom->save("../kmlfiles/pfdp.kml");
//echo $kmlOutput;


function makeDiscription($row,$CON){

echo $FDP_ID = $row['FDP_ID'];

$dis = '<![CDATA[<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

<table class="table table-borderless" style="width:100%">
  
  <tr>
    <td><b>Proposed FDP</b></td>
  </tr>

  <tr>
    <td>'.$row['FDP_NAME'].'</td>
  </tr>

  <tr>
  <td><button type="button" onclick="editpfdpdata()" class="btn btn btn-warning btn-md"><i class="fa fa-edit"></i>'." ";
$dis = $dis.'Edit Location</button></td>
 </tr>

   <tr>
    <td><button id="btndel" onclick="del_fdp('.$FDP_ID.');" class="btn btn-danger btn-md"><i class="fa fa-trash"></i> Delete</button></td>
  </tr>

</table>

</body>
</html>';

return $dis;

}

?>