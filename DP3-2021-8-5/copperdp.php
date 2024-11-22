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
	
	<script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
	 <script src="js/map.js" type="text/javascript"></script>
	 <script src="JS/geoxml3.js"></script>
	 <script src="JS/walk.js"></script>
	 <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
	 <link href="css/bootstrap.min.css" rel="stylesheet">
	 
	 
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	
	<!-- alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	  </head>
  <body>
	
	<script>

		var sLoc;
   
	</script>
	
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyACf3KGqbKylkAoI4MkjKTdwlbdoCMD-rY"></script>
	
		<div id="panel">
  
    <div class="form-inline">
	<label>Search Type</label>
	<select class="form-control" onchange="vwsercht();" id="shrtype" style="font-size:11.5px;">
		<option value=""></option>
		<!--<option value="cty">City Search</option>-->
		<option value="dp">DP Location Search</option>
	</select>
	</div>
	
	<div id="divcty" style="display:none;">
	<label>City Search</label>
	<div  class="form-inline">
	<input id="address" class="form-control" type="textbox" value=""> &nbsp;&nbsp;
	<input type="button" class="btn btn-warning btn-lg" value="search" onclick="codeAddress()">
	</div>
	</div>
	
	<div id="divdp" style="display:none;">
	<label>DP Location Search</label>
	<div  class="form-inline">
	<input id="dploc"  class="form-control" type="textbox" value="">&nbsp;&nbsp;
	<input type="button" class="btn btn-warning btn-lg" value="search" onclick="dplocserach()">
	</div>
	</div>
	
  </div>
  
 

  
    <div id="map-canvas">
	</div>
	
	<!-- popup box -->
    <div id="myModal" class="modal fade">
    <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <div id="frm_body" class="card-body"></div>
            </div>
        </div>
    </div>
</div>
<!-- end popup box -->
	
	
	
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



function vwsercht(){

  var shrtype = $('#shrtype').val();
  
  //initMap();
  initialize();
  
  if(shrtype == 'cty'){
	  
	document.getElementById("divcty").style.display = "block";
	document.getElementById("divdp").style.display = "none";
  
  }else if(shrtype == 'dp'){
	  
	document.getElementById("divcty").style.display = "none";
	document.getElementById("divdp").style.display = "block";
	  
  }else{
	  
	getdata();
	document.getElementById("divcty").style.display = "none";
	document.getElementById("divdp").style.display = "none";
	
  }
  
  
}


function codeAddress() {
  
  var address = document.getElementById('address').value+', Sri Lanka';
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker2 = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
		  zoom: 18
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}





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
			scaleControl: true,
			center: latlng
			//mapTypeId:google.maps.MapTypeId.ROADMAP
		  }
		  
		  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		//map.setZoom(size);
	
	
	
  
 
}

function getdata(){
	
	
	  <?php
 include 'orcon.php';
$DBonn= connecttooracle();

/*$sql="select distinct a.LATITUDE,a.LONGITUDE,a.LOCATION,b.FREE,b.OCCUPIDE
from OSSRPT.GPS_LOCATION a,OSSRPT.GPS_DPFREE  b
where a.LOCATION = B.FRAC_DESCRIPTION
and a.TYPE = 'DP'
and a.RTOM ='$rtom'
and a.LATITUDE is not null
and a.LOCATION is not null
and a.LOCATION NOT IN (select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'DP'
and RTOM = '$rtom')";*/
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
minus
select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'DP'
and RTOM IN ('R-WT','R-MD'))";
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
minus
select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'DP'
and RTOM = '$rtom')";	
}

/*
$sql="select distinct a.LATITUDE,a.LONGITUDE,a.LOCATION,b.FREE,b.OCCUPIDE
from OSSRPT.GPS_LOCATION a,OSSRPT.GPS_DPFREE  b
where a.LOCATION = B.FRAC_DESCRIPTION
and a.TYPE = 'DP'
and a.RTOM ='$rtom'
and a.LATITUDE is not null
and a.LOCATION  IN (
select distinct a.LOCATION
from OSSRPT.GPS_LOCATION a
where a.TYPE = 'DP'
and a.RTOM ='$rtom'
and a.LATITUDE is not null
minus
select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'DP'
and RTOM = '$rtom')";
*/

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
	$dp[$i][4] = $row[4];
	$dp[$i][5] = $i;
			
 $i++;
 }
 
 $sqlalert="select  distinct LATITUDE,LONGITUDE,LOCATION,TYPE
from gps_location
where LOCATION IN (select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'DP')
and TYPE = 'DP'
and RTOM ='$rtom'
and LATITUDE is not null";

$recalert = oci_parse($DBonn, $sqlalert);
oci_execute($recalert);

$k=0;
$dpalert= array();

 while ($row2 = oci_fetch_array($recalert)) {
 
	//$msan[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$dpalert[$k][0] = $row2[0];
	$dpalert[$k][1] = $row2[1];
	$dpalert[$k][2] = $row2[2];
	$dpalert[$k][3] = $row2[3];
	$dpalert[$k][4] = $k;
			
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

$n=0;
$vehicle= array();

 while ($row = oci_fetch_array($recset)) {
 
	//$vehicle[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$vehicle[$n][0] = $row[0];
	$vehicle[$n][1] = $row[1];
	$vehicle[$n][2] = $row[2];
	$vehicle[$n][3] = $row[3];
	$vehicle[$n][4] = $row[4];
	$vehicle[$n][5] = $n;
			
 $n++;
 } 

 
 ?>
  
  
 // setMarkers(beaches);
 setMarkers(dp);
// setMarkers2(dpalert);
 setMarkers3(vehicle);
    
    // Bind event listener on button to reload markers
  //document.getElementById('reloadMarkers').addEventListener('click', reloadMarkers);
	
	//setInterval(reloadMarkers, 10000);
  setInterval(reloadMarkers, 300000);
 // setInterval(reloadMarkers3, 6000);
 // setInterval(reloadMarkers2, 5000);
  

	
  
//

// 
	
	
	
}


var dp = <?php echo json_encode( $dp ) ?>;
var dpalert = <?php echo json_encode( $dpalert ) ?>;
var vehicle = <?php echo json_encode( $vehicle ) ?>;




google.maps.event.addDomListener(window, 'load', vwsercht);


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

				for(i=0; i<repxy.length-1; i++){
				var repx = repxy[i].split("#");
				
					if(repx[3] == '0')
					{
					data2.push( [repx[0], repx[1],repx[2],repx[4],repx[5]]);
					}
					if(repx[3] == '1')
					{
					data3.push( [repx[0], repx[1],repx[2],repx[4],repx[5]]);
					}
					if(repx[3] == '2')
					{
					data4.push( [repx[0], repx[1],repx[2],repx[4],repx[5]]);
					}
			
				}
				
   
    markers = [];
    
    
    setMarkers(data2);
	setMarkers2(data3);
	setMarkers3(data4);
        }
    }
	
    xmlhttp.open("GET","copperdp2.php?id=dp",true);
    xmlhttp.send();
    getdata(); 	
}



function setMarkers(locations) {


	var prev_infowindow =false;
    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
		var freeloop = beach[3];
		var usedloop = beach[4];
		var tit = beach[2];
        var myLatLng = new google.maps.LatLng(beach[0], beach[1]);
		
		
		if ( freeloop > 5)
		{
		var pinImage = new google.maps.MarkerImage("blue.png");
		}
		if (  freeloop  < 6 && freeloop  > 0)
		{
		var pinImage = new google.maps.MarkerImage("yellow.png");
		}
		if ( freeloop == 0)
		{
		var pinImage = new google.maps.MarkerImage("red.png");
		}
		
        var marker = new google.maps.Marker({
            position: myLatLng,
			icon: pinImage,
            map: map,
            title:tit+ "\n"+"Free Loops : "+freeloop+ "\n"+"Used Loops : "+usedloop ,
            zIndex: beach[3]
        });
       
 
        // Push marker to markers array
        markers.push(marker);

		
    }
}

function setMarkers2(locations) {

    var prev_infowindow =false;
    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
		var tit = beach[2];
        var myLatLng = new google.maps.LatLng(beach[0], beach[1]);
		var pinImage = new google.maps.MarkerImage("amber.png");

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




    </script>

   
  </body>
</html>
