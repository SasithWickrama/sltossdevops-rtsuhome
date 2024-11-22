<?php 
$s =  $_GET["s"];
$r =  $_GET["r"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
</head>
<body>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxb5RdPkgh2796wOx22ECeokZquR2A06g&..."
        async defer></script> 
<script type="text/javascript">
	 
      var map;
window.onload = function () {

var r = <?php echo json_encode( $r ) ?>;
var s = <?php echo json_encode( $s ) ?>;

	var mapOptions = {
                center: new google.maps.LatLng(6.9411080, 81.037344),
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
     map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
	 var markersx = [];		
     var lat_lngx = new Array();
	 
console.log("functions.php?q=MAP&r="+r+"&s="+s);
		
var xmlhttp07 =new XMLHttpRequest();
xmlhttp07.onreadystatechange=function() {
	
    if (xmlhttp07.readyState==4 && xmlhttp07.status==200) {
	//	console.log(xmlhttp07.responseText);
		var resp = xmlhttp07.responseText.split("##@");	
		for(var i=0; i<resp.length-1; i++)
		{
			markersx = [];
			lat_lngx = new Array();
			
      		var servicex = new google.maps.DirectionsService();
			
			
			var temp1 = resp[i].split("@");
			for(var x=0; x<temp1.length; x++)
			{
				var temp2 = temp1[x].split(",");
				markersx.push({
						title: temp2[0],
						lat: temp2[1],
						lng: temp2[2],
						description : temp2[4]
					});
					
					var myLatlng = new google.maps.LatLng(temp2[1], temp2[2]);
					lat_lngx.push(myLatlng);
			}
			//console.log(markersx.length);
			//console.log(lat_lngx.length);
		setpoints(markersx,lat_lngx);
		drawroute(lat_lngx,servicex,temp2[3]);
		}
		
		
    }}
xmlhttp07.open("GET","functions.php?q=MAP&r="+r+"&s="+s,true);
xmlhttp07.send();

}

function setpoints(markers,lat_lng) {
            
            var infoWindow = new google.maps.InfoWindow();
            var latlngbounds = new google.maps.LatLngBounds();
            for (i = 0; i < markers.length; i++) {
                var data = markers[i]
               
                var marker = new google.maps.Marker({
                    position: lat_lng[i],
                    map: map,
                    title: data.title
                });
                latlngbounds.extend(marker.position);
                (function (marker, data) {
				var tep =data.description.replace(/@/g , "<br/>");
				console.log(tep);
                    google.maps.event.addListener(marker, "click", function (e) {
                        infoWindow.setContent(tep);
                        infoWindow.open(map, marker);
                    });
                })(marker, data);
            }
            map.setCenter(latlngbounds.getCenter());
            map.fitBounds(latlngbounds);

            			
        }
		
function drawroute(lat_lng,service,cable){
	var col = getRandomColor();
	 var infowindow = new google.maps.InfoWindow();
		            for (var i = 0; i < lat_lng.length; i++) {;
                if ((i + 1) < lat_lng.length) {
                    var src = lat_lng[i];
                    var des = lat_lng[i + 1];
                  
				  // console.log(i+" "+src+" *   "+des);
                  singleroute(src,des,service,(i-10),cable,col)
                }
            }
}

		
function singleroute(src,des,service,delayFactor,cable,colour){
           service.route({
                        origin: src,
                        destination: des,
                        travelMode: google.maps.DirectionsTravelMode.DRIVING
                    }, function (result, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
							  	var path = new google.maps.MVCArray();
          						var poly = new google.maps.Polyline({
									map: map,
									strokeColor: colour
							  });
							  for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
								path.push(result.routes[0].overview_path[i]);
							  }
							  poly.setPath(path);
							 
				   
				   			google.maps.event.addListener(poly, 'click', function(evt) {
								infowindow.setContent(cable);
								infowindow.setPosition(evt.latLng);
								infowindow.open(map);
							  })
          
                        } else if (status === google.maps.DirectionsStatus.OVER_QUERY_LIMIT) {
            delayFactor++;
			//console.log(src+" *   "+des+"  *    "+delayFactor);
            setTimeout(singleroute, delayFactor * 1000,src,des,service,delayFactor,cable,colour);
        } else {
            console.log("Route: " + status);
        }
                    });
}



function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}
    </script>
<div id="dvMap" style="width: 100%; height: 98vh">
</body>
</html>
