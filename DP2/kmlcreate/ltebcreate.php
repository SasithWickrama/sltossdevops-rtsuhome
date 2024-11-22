<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../dbcon.php';

$CON= connecttooracle();

if (!$CON) 
{
  die('Not connected : ' );
}

// creates the document
$dom=new DOMDocument('1.0','UTF-8');

//create the root KML element and appends it to the root document
$node=$dom-> createElementNs('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

// Creates a KML Document element and append it to the KML element.
$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);


$manholeStyleNode = $dom->createElement('Style');
$manholeStyleNode->setAttribute('id', 'locationStyle');
$manholeIconstyleNode = $dom->createElement('IconStyle');
$manholeIconstyleNode->setAttribute('id', 'msan');
$manholescale=$dom->createElement('scale', '0.75');
$manholeIconstyleNode->appendChild($manholescale);
$manholeIconNode = $dom->createElement('Icon');
$manholeHref = $dom->createElement('href', 'http://ossportal/out_dated/SLTIlastrator/images/tower48.png');
$manholeIconNode->appendChild($manholeHref);
$manholeIconstyleNode->appendChild($manholeIconNode);
$manholeStyleNode->appendChild($manholeIconstyleNode);
$docNode->appendChild($manholeStyleNode);


$sql_t_lotlag="SELECT  LATITUDE,LONGITUDE,LOCATION  FROM OSSRPT.GPS_LOCATION  where TYPE='LTE BASESTATION'";

$recset_t_lotlag = oci_parse($CON, $sql_t_lotlag);
oci_execute($recset_t_lotlag);

$i=0;

while ($row = oci_fetch_array($recset_t_lotlag)) {

  $i ++; 

  $discription =makeDiscription($row,$CON);

  // Creates a Placemark and append it to the Document.
  $node = $dom->createElement('Placemark');
  $placeNode = $docNode->appendChild($node);

  // Creates an id attribute and assign it the value of id column.
  $placeNode->setAttribute('id', 'placemark' . $i);

  $descNode = $dom->createElement('description', $discription);
  $placeNode->appendChild($descNode);
  
  $styleUrl = $dom->createElement('styleUrl', '#locationStyle');
  $placeNode->appendChild($styleUrl);
  
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
$dom->save("../kmlfiles/lteb.kml");
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
    <td><b>'.$row['LOCATION'].'</b></td>
  </tr>

</table>

</body>
</html>';

return $dis;

}

?>