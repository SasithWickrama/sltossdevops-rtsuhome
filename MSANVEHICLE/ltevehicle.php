<?php
session_start();
$rtom=$_SESSION['rtom'];
$lat= $_SESSION['lati'];
$long =$_SESSION['longi'];
$zoom =$_SESSION['size'];
?>

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
	 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyACf3KGqbKylkAoI4MkjKTdwlbdoCMD-rY"></script> 
<!--   <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyD5qohkApnK68WtXTbSZ7TkItX182htOfA"></script> -->
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
  var lat = <?php echo $lat;?>;
  var lon = <?php echo $long; ?>;
  var ar =  '<?php echo $rtom; ?>';	
  var siz = '<?php echo $zoom; ?>';		
  var nZoom = Number(siz);
  var latlng = new google.maps.LatLng(lat, lon);
  //var latlng = new google.maps.LatLng(7.0494,79.9207);

		  var mapOptions = {
			zoom: nZoom,
			center: latlng
			//mapTypeId:google.maps.MapTypeId.ROADMAP
		  }
		  
		  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		//map.setZoom(size);
	
	
	
  
  
  <?php
 include 'orcon.php';
$DBonn= connecttooracle();

$sql="SELECT  m.LOCATION ,m.LATITUDE,m.LONGITUDE 
FROM OSSRPT.GPS_MSAN m 
where m.TYPE like'MSAN%' and m.LATITUDE is not null
and m.LOCATION  not IN (
SELECT  m.LOCATION  
FROM OSSRPT.GPS_MSAN m ,GPS_MSAN_ALAMS a
where m.D_NAME = A.NODE_NAME
and m.TYPE like'MSAN%' and m.LATITUDE is not null
and A.NETWORK = 'BB')
and m.RTOM = '$rtom'";

$recset = oci_parse($DBonn, $sql);
oci_execute($recset);

$i=0;
$msan= array();

 while ($row = oci_fetch_array($recset)) {
 
	//$msan[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$msan[$i][0] = $row[0];
	$msan[$i][1] = $row[1];
	$msan[$i][2] = $row[2];
	$msan[$i][3] = $i;
			
 $i++;
 }
 
 $sqlalert="SELECT  m.LOCATION,m.LATITUDE,m.LONGITUDE,1 as flag,DESCRIPTION,ALARM ,m.MCATAGORY
FROM OSSRPT.GPS_MSAN m ,GPS_MSAN_ALAMS a
where m.D_NAME = A.NODE_NAME
and m.TYPE like'MSAN%' and m.LATITUDE is not null
and A.NETWORK = 'BB'
and m.RTOM = '$rtom'";

$recalert = oci_parse($DBonn, $sqlalert);
oci_execute($recalert);

$k=0;
$msanalert= array();

 while ($row2 = oci_fetch_array($recalert)) {
 
	//$msan[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$msanalert[$k][0] = $row2[0];
	$msanalert[$k][1] = $row2[1];
	$msanalert[$k][2] = $row2[2];
	$msanalert[$k][3] = $row2[3];
	$msanalert[$k][4] = $row2[4];
	$msanalert[$k][5] = $row2[5];
	$msanalert[$k][6] = $row2[6];
	$msanalert[$k][7] = $k;
			
 $k++;
 }
 
 
 
$DBonn2= connecttooracleprg();
$opmc=$_POST["opmc"];
$_SESSION['opmc'] = $opmc;

$sql="SELECT  V_NUMBER ,V_LAT,V_LOG,V_SPEED,V_TIMEDIFF
FROM OSSPRG.GPS_VEHICLES
where V_LOG is not null
and V_LAT is not null
and V_RTOM = '$rtom'";

$recset = oci_parse($DBonn2, $sql);
oci_execute($recset);

$i=0;
$vehicle= array();

 while ($row = oci_fetch_array($recset)) {
 
	//$vehicle[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$vehicle[$i][0] = $row[0];
	$vehicle[$i][1] = $row[1];
	$vehicle[$i][2] = $row[2];
	$vehicle[$i][3] = $row[3];
	$vehicle[$i][4] = $row[4];
	$vehicle[$i][5] = $i;
			
 $i++;
 }

 //CEA Node
 $DBonn3= connecttooracleprg();
 $sqlcea="select AREA,LAT,LOG,TYPE
from OSSPRG.GPS_CORE_NW
where LOG is not null
and LAT is not null
and RTOM = '$rtom'";

$recea = oci_parse($DBonn3, $sqlcea);
oci_execute($recea);

$n=0;
$cea= array();

 while ($row4 = oci_fetch_array($recea)) {
 
	//$vehicle[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$cea[$n][0] = $row4[0];
	$cea[$n][1] = $row4[1];
	$cea[$n][2] = $row4[2];
	$cea[$n][3] = $row4[3];
	$cea[$n][4] = $n;
			
 $n++;
 }
 
 
  //CEA Node
 $DBonn3= connecttooracleprg();
if($rtom== 'R-WT')
{
 $sqlbase="select LOCATION,LATITUDE,LONGITUDE,TYPE
from OSSRPT.GPS_LOCATION
where  LATITUDE is not null
and LONGITUDE is not null
and TYPE = 'LTE BASESTATION'
and RTOM IN ('R-WT','R-MD')";
}
else
{
$sqlbase="select LOCATION,LATITUDE,LONGITUDE,TYPE
from OSSRPT.GPS_LOCATION
where  LATITUDE is not null
and LONGITUDE is not null
and TYPE = 'LTE BASESTATION'
and RTOM = '$rtom'";
}
$rebase = oci_parse($DBonn, $sqlbase);
oci_execute($rebase);

$m=0;
$base= array();

 while ($row5 = oci_fetch_array($rebase)) {
 
	//$vehicle[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$base[$m][0] = $row5[0];
	$base[$m][1] = $row5[1];
	$base[$m][2] = $row5[2];
	$base[$m][3] = $row5[3];
	$base[$m][4] = $m;
			
 $m++;
 }

 ?>
  
  
 // setMarkers(beaches);
// setMarkers(msan);
 //setMarkers2(msanalert);
 setMarkers3(vehicle);
 //setMarkers4 (cea);
 setMarkers5 (base);
    
    // Bind event listener on button to reload markers
  //document.getElementById('reloadMarkers').addEventListener('click', reloadMarkers);

  setInterval(reloadMarkers, 35000);
 // setInterval(reloadMarkers3, 6000);
 // setInterval(reloadMarkers2, 5000);
  

	
  
//

//  
}
var cea = <?php echo json_encode( $cea ) ?>;
var msan = <?php echo json_encode( $msan ) ?>;
var msanalert = <?php echo json_encode( $msanalert ) ?>;
var vehicle = <?php echo json_encode( $vehicle ) ?>;
var base = <?php echo json_encode( $base ) ?>;



google.maps.event.addDomListener(window, 'load', initialize);



function reloadMarkers() {

for (var i=0; i<markers.length; i++) {
     
        markers[i].setMap(null);
    }

var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function() {
    		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				 
    var repxy = xmlhttp.responseText.split("@");
var data2= [];	
var data3= [];	
var data4= [];
var data5= [];
var data6= [];
				for(i=0; i<repxy.length-1; i++){
				var repx = repxy[i].split("#");
				
					if(repx[3] == '0')
					{
					data2.push( [repx[0], repx[1],repx[2],repx[3],'']);
					}
					if(repx[3] == '1')
					{
					data3.push( [repx[0], repx[1],repx[2],repx[3],repx[4],repx[5],repx[6]]);
					}
					if(repx[3] == '2')
					{
					data4.push( [repx[0], repx[1],repx[2],repx[4],repx[6],repx[3]]);
					}
					if(repx[3] == '3')
					{
					data5.push( [repx[0], repx[1],repx[2],repx[4],repx[3]]);
					}
					if(repx[3] == '4')
					{
					data6.push( [repx[0], repx[1],repx[2],repx[4],repx[3]]);
					}
				}
				
   
    markers = [];
    
    
   // setMarkers(data2);
	//setMarkers2(data3);
	setMarkers3(data4);
	//setMarkers4(data5);
	setMarkers5(data6);
        }
    }
	
    xmlhttp.open("GET","ltevehicle2.php?id=msan",true);
    xmlhttp.send(); 	
}

function reloadMarkers2() {

for (var i=0; i<markers.length; i++) {
     
        markers[i].setMap(null);
    }

var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function() {
    		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				 
    var repxy = xmlhttp.responseText.split("@");
var data2= [];	

				for(i=0; i<repxy.length-1; i++){
				var repx = repxy[i].split("#");
					data2.push( [repx[0], repx[1],repx[2],repx[3]]);
				}
				
   
    markers = [];
    
    
    setMarkers2(data2);
        }
    }
    xmlhttp.open("GET","msanvehicle2.php?id=msanalert",true);
    xmlhttp.send(); 
}

function reloadMarkers3() {

for (var i=0; i<markers.length; i++) {
     
        markers[i].setMap(null);
    }

var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function() {
    		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				 
    var repxy = xmlhttp.responseText.split("@");
var data2= [];		

				for(i=0; i<repxy.length-1; i++){
				var repx = repxy[i].split("#");
			
					data2.push( [repx[0], repx[1],repx[2],repx[3]]);
					
				}
				
   
    markers = [];
    
    
    setMarkers3(data2);

        }
    }
	
    xmlhttp.open("GET","vehiclemap2.php?id=vehicle",true);
    xmlhttp.send(); 	
}




function setMarkers(locations) {

	

	var prev_infowindow =false;
    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
		var tit = beach[0]+' '+beach[4];
        var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
		var pinImage = new google.maps.MarkerImage("msan24.png");
        var marker = new google.maps.Marker({
            position: myLatLng,
			icon: pinImage,
            map: map,
            title:tit ,
            zIndex: beach[3]
        });
        
        // Push marker to markers array
        markers.push(marker);

		
    }
}

function setMarkers2(locations) {

    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
		var tit = beach[0]+' '+beach[4];
        var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
		if (beach[5] == '1' && beach[6] == 'H')
		{
		var pinImage = new google.maps.MarkerImage("alarmamber_1.png");
		}
		if (beach[5] == '1' && beach[6] == 'M')
		{
		var pinImage = new google.maps.MarkerImage("alarmamber_2.png");
		}
		if (beach[5] == '1' && beach[6] == 'L')
		{
		var pinImage = new google.maps.MarkerImage("alarmamber_3.png");
		}
		if ((beach[5] == '2' || beach[5] == '3') && beach[6] == 'H')
		{
		var pinImage = new google.maps.MarkerImage("Red_1.png");
		}
		if ((beach[5] == '2' || beach[5] == '3') && beach[6] == 'M')
		{
		var pinImage = new google.maps.MarkerImage("Red_2.png");
		}
		if ((beach[5] == '2' || beach[5] == '3') && beach[6] == 'L')
		{
		var pinImage = new google.maps.MarkerImage("Red_3.png");
		}
        var marker = new google.maps.Marker({
            position: myLatLng,
			icon: pinImage,
            map: map,
            title:tit,
            zIndex: beach[3]
        });
        
        // Push marker to markers array
		
		/*var infowindow = new google.maps.InfoWindow({
  content:beach[0]+"<br/>"+beach[4]
  });

 infowindow.open(map,marker);*/
		
       markers.push(marker);
	   
	                   google.maps.event.addListener(marker, 'click', function () {

                    var infowindow = new google.maps.InfoWindow({
  content:beach[0]+"<br/>"+beach[4]
  });                    
                    infowindow.open(map,marker);
                   
                });
		
		
    }
}

function setMarkers3(locations) {

	

	var prev_infowindow =false;
    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
		var tit = 'Vehicle No: '+beach[0]+'  Speed: '+beach[3];
        var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
		if(beach[4] > 40)
		{
		var pinImage = new google.maps.MarkerImage("vehicleyellow.png");
		}
		else
		{
			if (beach[3] != 0)
			{
			var pinImage = new google.maps.MarkerImage("vehiclemv.png");
			}
			else
			{
			var pinImage = new google.maps.MarkerImage("vehicle.png");
			}
		}
        var marker = new google.maps.Marker({
            position: myLatLng,
			icon: pinImage,
            map: map,
            title:tit ,
            zIndex: beach[0]
        });
        
        // Push marker to markers array		
        markers.push(marker);

		
    }
}

function setMarkers4(locations) {

	

	var prev_infowindow =false;
    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
		var tit = beach[0]+' '+beach[3];
        var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
		var pinImage = new google.maps.MarkerImage("ceanode.png");
        var marker = new google.maps.Marker({
            position: myLatLng,
			icon: pinImage,
            map: map,
            title:tit ,
            zIndex: beach[3]
        });
        
        // Push marker to markers array
        markers.push(marker);

		
    }
}


function setMarkers5(locations) {

	

	var prev_infowindow =false;
    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
		var tit = beach[0]+' '+beach[3];
        var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
		var pinImage = new google.maps.MarkerImage("ltebase.png");
        var marker = new google.maps.Marker({
            position: myLatLng,
			icon: pinImage,
            map: map,
            title:tit ,
            zIndex: beach[3]
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
