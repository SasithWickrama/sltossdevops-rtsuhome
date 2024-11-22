
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
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
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
 /* var lat = <?php echo $lat;?>;
  var lon = <?php echo $long; ?>;
  var ar =  '<?php echo $rtom; ?>';	
  
  var latlng = new google.maps.LatLng(lat, lon);*/
  
  var latlng = new google.maps.LatLng(7.0494,79.9207);
	  var mapOptions = {
			zoom: 10,
			center: latlng
			//mapTypeId:google.maps.MapTypeId.ROADMAP
		  }
		  
		  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	 
		
	
  
  
  <?php
  session_start();
 include 'orcon.php';
$DBonn= OracleConnection();
$opmc=$_POST["opmc"];
$_SESSION['opmc'] = $opmc;

$sql="SELECT  V_NUMBER ,V_LAT,V_LOG,V_SPEED
FROM OSSPRG.GPS_VEHICLES
where V_LOG is not null
and V_LAT is not null
and V_OPMC = '$opmc'";

$recset = oci_parse($DBonn, $sql);
oci_execute($recset);

$i=0;
$vehicle= array();

 while ($row = oci_fetch_array($recset)) {
 
	//$vehicle[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$vehicle[$i][0] = $row[0];
	$vehicle[$i][1] = $row[1];
	$vehicle[$i][2] = $row[2];
	$vehicle[$i][3] = $row[3];
	$vehicle[$i][4] = $i;
			
 $i++;
 }
 
 
 ?>
  
  
 // setMarkers(beaches);
 setMarkers(msan);

    // Bind event listener on button to reload markers
  //document.getElementById('reloadMarkers').addEventListener('click', reloadMarkers);

  setInterval(reloadMarkers, 10000);
 // setInterval(reloadMarkers2, 5000);
  

	
  
//

//  
}
var msan = <?php echo json_encode( $vehicle ) ?>;

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

				for(i=0; i<repxy.length-1; i++){
				var repx = repxy[i].split("#");
			
					data2.push( [repx[0], repx[1],repx[2],repx[3]]);
					
				}
				
   
    markers = [];
    
    
    setMarkers(data2);
        }
    }
	
    xmlhttp.open("GET","vehiclemap2.php?id=vehicle",true);
    xmlhttp.send(); 	
}




function setMarkers(locations) {

	

	var prev_infowindow =false;
    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
		var tit = 'Vehicle No: '+beach[0]+'  Speed: '+beach[3];
        var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
		var pinImage = new google.maps.MarkerImage("vehicle.png");
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
  </head>
  <body>
    <div id="map-canvas">
	</div>
  </body>
</html>