

//-------------------------------start initialize map---------------------------------------//

function initMap() {
	var marker;
        map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(6.927079, 79.861244),
          zoom: 10,
          mapTypeId: 'satellite'
        });

	map.addListener('click', function() {
	
	var divs = document.getElementsByClassName("gm-style-iw-a"); //geoxml3_infowindow");
	console.log(divs.length);
	
	for(var i=0; i<divs.length;i++ ){
		divs[i].style.display = "none";
		}
	});	
       
}

//-------------------------------End initialize  map--------------------------------------//


	
//--------------------------------start load map data-----------------------------//	

function loaddata(){

$('#over_map3').css("display","none");
$('#getdata').css("display","none");

var maptype = document.getElementById('maptype').options[document.getElementById('maptype').selectedIndex].value;
		
	if((document.getElementById('radios-0').checked || document.getElementById('radios-1').checked || document.getElementById('radios-2').checked) && (document.getElementById('radios-3').checked || document.getElementById('radios-4').checked || document.getElementById('radios-5').checked || document.getElementById('radios-6').checked || document.getElementById('radios-7').checked)){
		
		if(msan != null){
		
			msan.hideDocument();
			
		}
		
		var info =[];
		
		if(document.getElementById('radios-0').checked){
			info[info.length] = 'MSAN';
		}if(document.getElementById('radios-1').checked){
			info[info.length] = 'CPE';
		}if(document.getElementById('radios-2').checked){
			info[info.length] = 'UG';
		}
		
		var serv="";
		
		if(document.getElementById('radios-3').checked ){
						serv = serv+"'PSTN',";
		}if(document.getElementById('radios-4').checked ){
						serv = serv+"'IPTV',";
		}if(document.getElementById('radios-5').checked ){
						serv = serv+"'FTTH',";
		}if(document.getElementById('radios-6').checked ){
						serv = serv+"'ADSL',";
		}if(document.getElementById('radios-7').checked ){
						serv = serv+"'DATA',";
		}
                                
        serv = serv.substring(0, serv.length-1)
		
		if(document.getElementById('radios-0').checked || document.getElementById('radios-1').checked || document.getElementById('radios-2').checked){

		if(maptype == "msan"){
			
			ShowProgressAnimation();
			
			$('#over_map3').css("display","none");
			$.ajax({ type: "POST",url: "./kmlcreate/msancreate.php", data: {info:info,serv:serv},success: function(result){				   
				msan = new geoXML3.parser({map: map,afterParse: useODFData});
				msan.parse('kmlfiles/Msan.kml');
				
				
				    $.ajax({
						type: "POST",
						data: {info:info,serv:serv},
						url: "./function.php?q=2",
						success: function(res){

						var resarr=res.split(',');
						
						
						if(resarr[0]>0){
						$('#lblgreen').html('Fault count less than '+resarr[0]);
						}else{
						$('#lblgreen').html('Fault count '+resarr[0]);	
						}
						/*$('#lblblue').html('Fault count between '+resarr[0]+'-'+ resarr[1]);
						$('#lblred').html('Fault count greater than '+resarr[1]);
						$('#over_map3').css("display","block");*/
						
						$('#getdata').css("display","block");
						HideProgressAnimation();

						}
					});
					
			
			}});
			
		}
		
		
		if(maptype == "dp"){
			
			ShowProgressAnimation();
			
			$('#over_map3').css("display","none");
			$.ajax({ type: "POST",url: "./kmlcreate/dpcreate.php", data: {info:info,serv:serv},success: function(result){				   
				msan = new geoXML3.parser({map: map,afterParse: useODFData});
				msan.parse('kmlfiles/dp.kml');
				
						$.ajax({
							type: "POST",
							data: {info:info,serv:serv},
							url: "./function.php?q=1",
							success: function(res){

							var resarr=res.split(',');
							
							
							if(resarr[0]>0){
							$('#lblgreen').html('Fault count less than '+resarr[0]);
							}else{
							$('#lblgreen').html('Fault count '+resarr[0]);	
							}
							/*$('#lblblue').html('Fault count between '+resarr[0]+'-'+ resarr[1]);
							$('#lblred').html('Fault count greater than '+resarr[1]);
							$('#over_map3').css("display","block");*/
							
							$('#getdata').css("display","block");
							
							HideProgressAnimation();
						
							}
						});
		
			}});
				
		}
		


		}
 		
		
		}else{
		
			alert('please select at least one Fault Type and one Service Type');
			
			$('#getdata').css("display","block");
		
		}	
		
}

function useODFData(doc) {

	var nType = 'odf';
	
	setTimeout(function() { useodfDatax(doc,nType); }, 1000);
	
	
}

function useodfDatax(doc,nType) {
		
	if(doc[0].placemarks.length < 1) {
		alert("No data found for the logged in OPMC");
	}
}

//--------------------------------End load map data----------------------------------//	

	
function closex(){

		document.getElementById("addinfo").style.display = "none";
}
    

function togelDoc(layer,el){

	var box = el.id;
	if (document.getElementById(box).checked == false)
	{
		layer.hideDocument();
	}
	else{
		layer.showDocument();
	}
	
}


function exit(){

		document.getElementById("over_map1").style.visibility = "hidden";
}


$(document).ready(function () {
	$("#loading-div-background").css({ opacity: 0.8 });
   
});

function ShowProgressAnimation() {
   

	$("#loading-div-background").show();

}


function HideProgressAnimation() {
   

	$("#loading-div-background").hide();

}