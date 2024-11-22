<?php  session_start(); ?>

<!DOCTYPE html>
<html>
  <head>
    
    <meta charset="utf-8">
    <title>Geocoding service</title>
    <style>
      html, body, #map-canvas {
        height: 900px;
        margin: 0;
        padding: 0;
      }

      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }

      /*
      Provide the following styles for both ID and class,
      where ID represents an actual existing "panel" with
      JS bound to its name, and the class is just non-map
      content that may already have a different ID with
      JS bound to its name.
      */

      #panel, .panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #panel select, #panel input, .panel select, .panel input {
        font-size: 15px;
      }

      #panel select, .panel select {
        width: 100%;
      }

      #panel i, .panel i {
        font-size: 12px;
      }

    </style>
    <!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>-->
	<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxb5RdPkgh2796wOx22ECeokZquR2A06g&..."
        async defer></script> -->
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyD5qohkApnK68WtXTbSZ7TkItX182htOfA"></script>
    <script>
var geocoder;
var map;
var loc = [];
var markers = []; // Create a marker array to hold your markers
var beaches = [
    ['SIG-KPR-NODE', 7.3202338, 80.64328, 3],
    ['SIG-KDM-NODE', 7.27285666, 80.60375492, 2],
    ['UK-LAB-NODE', 7.3223176, 80.6308517, 1],
    ['UK-UDT-NODE', 7.3368292, 80.561882, 0]
];

function initialize() {
  geocoder = new google.maps.Geocoder();

 // var latlng = new google.maps.LatLng(lat, lon);
  var latlng = new google.maps.LatLng(7.0494,79.9207);

		  var mapOptions = {
			zoom: 8,
			center: latlng
			//mapTypeId:google.maps.MapTypeId.ROADMAP
		  }
		  
		  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		//map.setZoom(size);
	
	
	
  
  
  <?php
function connecttooracle(){
	 $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )" ;
  
    if($c = oci_connect("ossprg", "prgoss456", $db))
    {
		return $c;
    }
    else
    {
        $err = OCIError();
        echo "Connection failed." . $err[text];
    }
}


$DBonn = connecttooracle();

$s =  $_GET["s"];
$r =  $_GET["r"];
$area = $_SESSION['area'];



if ($area == 'ALL') {	
   $areacode = " SELECT * FROM AREAS WHERE AREA_ARET_CODE = 'LEA'  ";
}else if (strpos($area, 'X-') !== false) {	
	$temp = str_replace("X-","",$area);
	$tempx = str_replace(",","','",$temp);
   $areacode = " SELECT * FROM AREAS WHERE AREA_ARET_CODE = 'LEA' AND AREA_AREA_CODE IN (SELECT DISTINCT RTOM_CODE FROM OSSRPT.SLT_AREA WHERE REGIONS in ('$tempx') ) ";
}else if (strpos($area, 'P-') !== false) {	
	$temp = str_replace("P-","",$area);
	$tempx = str_replace(",","','",$temp);
   $areacode = " SELECT * FROM AREAS WHERE AREA_ARET_CODE = 'LEA' AND AREA_AREA_CODE IN (SELECT DISTINCT RTOM_CODE FROM OSSRPT.SLT_AREA WHERE PROVINCE in ('$tempx') ) ";
}else{
$tempx = str_replace(",","','",$area);
	$areacode =  "SELECT * FROM areas WHERE AREA_ARET_CODE = 'LEA' AND AREA_AREA_CODE in ( '$tempx')";
}


$sql = "SELECT FRAC_LOCN_TTNAME ,LOCN_X , LOCN_Y,FRAU_NAME 
FROM(
SELECT 
(SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_CIRT_NAME  IS NOT NULL  AND B.FRAA_SIDE = 'REAR'   AND B.FRAA_FRAU_ID = FU.FRAU_ID  ) \"OCCUPIDE\"
, FC.FRAC_LOCN_TTNAME ,FU.FRAU_NAME ,FC.FRAC_INDEX ,H.LOCN_X , H.LOCN_Y
FROM FRAME_CONTAINERS FC, FRAME_UNITS FU, LOCATIONS H , ( $areacode) D
WHERE  FC.FRAC_FRAN_NAME ='FDP'
AND FU.FRAU_FRAC_ID = FC.FRAC_ID
AND FC.FRAC_LOCN_TTNAME = H.LOCN_TTNAME
AND H.LOCN_AREA_CODE = D.AREA_CODE
) WHERE OCCUPIDE = '$s'";



$recset = oci_parse($DBonn, $sql);
oci_execute($recset);

$i=0;
$dp= array();

 while ($row = oci_fetch_array($recset)) {
 
	//$msan[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$dp[$i][0] = $row[0];
	$dp[$i][1] = $row[1];
	$dp[$i][2] = $row[2];
	$dp[$i][3] = $row[3];
	$dp[$i][4] = $i;
			
 $i++;
 }
 
 
 
 ?>
  
 setMarkers(dp);

}
var dp = <?php echo json_encode( $dp ) ?>;





google.maps.event.addDomListener(window, 'load', initialize);

function setMarkers(locations) {


	var prev_infowindow =false;
    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
		var tit = beach[3];
        var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
		var pinImage = new google.maps.MarkerImage("red.png");

		
        var marker = new google.maps.Marker({
            position: myLatLng,
			icon: pinImage,
            map: map,
            title:tit
            
        });
        
        // Push marker to markers array
        markers.push(marker);

		
    }
}


    </script>
  </head>
  <body>
    <div id="map-canvas">
	</div>
  </body>
</html>