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
$NetStyleNode->setAttribute('id', 'ltesst1');
$NetIconstyleNode = $dom->createElement('IconStyle');
$NetIconstyleNode->setAttribute('id', 'msan');
$Netscale=$dom->createElement('scale', '0.95');
$NetIconstyleNode->appendChild($Netscale);
$NetIconNode = $dom->createElement('Icon');
$NetHref = $dom->createElement('href', 'http://ossportal/out_dated/SLTIlastrator/images/flgR32.png');
$NetIconNode->appendChild($NetHref);
$NetIconstyleNode->appendChild($NetIconNode);
$NetStyleNode->appendChild($NetIconstyleNode);
$docNode->appendChild($NetStyleNode);


$NetStyleNode = $dom->createElement('Style');
$NetStyleNode->setAttribute('id', 'ltesst2');
$NetIconstyleNode = $dom->createElement('IconStyle');
$NetIconstyleNode->setAttribute('id', 'msan');
$Netscale=$dom->createElement('scale', '0.95');
$NetIconstyleNode->appendChild($Netscale);
$NetIconNode = $dom->createElement('Icon');
$NetHref = $dom->createElement('href', 'http://ossportal/out_dated/SLTIlastrator/images/flgB32.png');
$NetIconNode->appendChild($NetHref);
$NetIconstyleNode->appendChild($NetIconNode);
$NetStyleNode->appendChild($NetIconstyleNode);
$docNode->appendChild($NetStyleNode);


$NetStyleNode = $dom->createElement('Style');
$NetStyleNode->setAttribute('id', 'ltesst3');
$NetIconstyleNode = $dom->createElement('IconStyle');
$NetIconstyleNode->setAttribute('id', 'msan');
$Netscale=$dom->createElement('scale', '0.95');
$NetIconstyleNode->appendChild($Netscale);
$NetIconNode = $dom->createElement('Icon');
$NetHref = $dom->createElement('href', 'http://ossportal/out_dated/SLTIlastrator/images/flg32.png');
$NetIconNode->appendChild($NetHref);
$NetIconstyleNode->appendChild($NetIconNode);
$NetStyleNode->appendChild($NetIconstyleNode);
$docNode->appendChild($NetStyleNode);


$NetStyleNode = $dom->createElement('Style');
$NetStyleNode->setAttribute('id', 'ltesst4');
$NetIconstyleNode = $dom->createElement('IconStyle');
$NetIconstyleNode->setAttribute('id', 'msan');
$Netscale=$dom->createElement('scale', '0.95');
$NetIconstyleNode->appendChild($Netscale);
$NetIconNode = $dom->createElement('Icon');
$NetHref = $dom->createElement('href', 'http://ossportal/out_dated/SLTIlastrator/images/flgN32.png');
$NetIconNode->appendChild($NetHref);
$NetIconstyleNode->appendChild($NetIconNode);
$NetStyleNode->appendChild($NetIconstyleNode);
$docNode->appendChild($NetStyleNode);


$sql="SELECT  LATITUDE,LONGITUDE,DP  FROM OSSRPT.GPS_LOCATION  where TYPE='LTE SIGNAL'";

  $res = oci_parse($CON, $sql);
  oci_execute($res);

$i=0;

while ($row = oci_fetch_array($res)) {

  echo $linksp =$row['DP'];

  if (is_numeric($linksp)){

  $i ++; 

  $discription =makeDiscription($row,$CON);

  // Creates a Placemark and append it to the Document.
  $node = $dom->createElement('Placemark');
  $placeNode = $docNode->appendChild($node);

  // Creates an id attribute and assign it the value of id column.
  $placeNode->setAttribute('id', 'placemark' . $i);

  $descNode = $dom->createElement('description', $discription);
  $placeNode->appendChild($descNode);


   if ($linksp<-110 || $linksp==-110) 
   {

    $styleUrl = $dom->createElement('styleUrl', '#ltesst1');
    $placeNode->appendChild($styleUrl);

  }
  if ($linksp>-110 && $linksp<-100)
  {

    $styleUrl = $dom->createElement('styleUrl', '#ltesst2');
    $placeNode->appendChild($styleUrl);

  }
  if ($linksp>-100 || $linksp==-100)
  {

    $styleUrl = $dom->createElement('styleUrl', '#ltesst3');
    $placeNode->appendChild($styleUrl);

  }else{

    $styleUrl = $dom->createElement('styleUrl', '#ltesst4');
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
}

//header('Content-type: application/vnd.google-earth.kml+xml');
$kmlOutput = $dom->saveXML();
$dom->save("../kmlfiles/ltes.kml");
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
    <td colspan="2"><b>'.$row['DP'].'</b></td>
  </tr>

</table>

</body>
</html>';

return $dis;

}

?>