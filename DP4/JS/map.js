//---------------------------------Start map initialize-----------------------//
	  
var map;
var polyLine;
var polyOptions;
var geocoder;

function initMap() {
   
  geocoder = new google.maps.Geocoder();
 
   map = new google.maps.Map(document.getElementById('map'), {
	  center: new google.maps.LatLng(7.927079, 80.761244),
	  zoom: 8,
	  //mapTypeId: 'satellite'
	});

   var drawingManager = new google.maps.drawing.DrawingManager({

	  drawingControl: true,
	  drawingControlOptions: {
	    position: google.maps.ControlPosition.TOP_CENTER,
	    drawingModes: ['marker']
	  },
	  markerOptions: {icon: ''},
	  circleOptions: {
	    fillColor: '#FFC857',
	    fillOpacity: 1,
	    strokeWeight: 1,
	    clickable: false,
	    editable: false,
	    zIndex: 1
	  },
	  polylineOptions: {
	  editable: false,
	  draggable: false,
	  geodesic: true
	  }
	  
	});

    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
		
		var rtom = document.getElementById('rtom').value;

		if(rtom == ''){
	
			alert('Plese select a RTOM to continue!');
			return;
		
		}else{

			load_selection_form(marker.position);
			
		}

	});

} 

//--------------------------------start load map data-----------------------------//	

function load_selection_form(position) 
{
	$("#frm_body").html('<div class="form-group"><select class="form-control" id="cmbftype"><option value="">Select One</option><option value="1">PLAN FIBER DP</option></select></div><div style="display:none"><input type="text" class="position" value="'+position+'"/></div><div class="form-group" id="frm_content"></div>');
	
	$("#myModal").modal('show');
	
} 

//--------------------------------start load map data-----------------------------//	

function getdata(){

		var rtom = document.getElementById('rtom').value;
		var msg = '';

		if(document.getElementById('chk_1').checked)
		{
			$("#loding_window1").attr("style", "display:block");
			
			 $.ajax({url: "./function.php?q=2", data: {rtom:rtom}, success: function(result){
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">MSAN Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(msan != null){
						msan.hideDocument();
					}
			

					$.ajax({ type: "POST",url: "./kmlcreate/msancreate.php",data:{rtom:rtom},success: function(result){				   
						msan = new geoXML3.parser({
							map: map,
							afterParse: loadw1
							});
						msan.parse('kmlfiles/msan.kml');
					}});


					if(msanalm != null){
						msanalm.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/msancreate_alm.php",data:{rtom:rtom},success: function(result){				   
						msanalm = new geoXML3.parser({
							map: map,
							afterParse: loadw1
							});
						msanalm.parse('kmlfiles/msanalm.kml');
					}});

				}else{

					if(msan != null){
						msan.hideDocument();
					}
			

					$.ajax({ type: "POST",url: "./kmlcreate/msancreate.php",data:{rtom:rtom},success: function(result){				   
						msan = new geoXML3.parser({
							map: map,
							afterParse: loadw1
							});
						msan.parse('kmlfiles/msan.kml');

					}});


					if(msanalm != null){
						msanalm.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/msancreate_alm.php",data:{rtom:rtom},success: function(result){				   
						msanalm = new geoXML3.parser({
							map: map,
							afterParse: loadw1
						});
						msanalm.parse('kmlfiles/msanalm.kml');

					}});
	
				}

			}});


		}


		if(document.getElementById('chk_2').checked)
		{
			$("#loding_window2").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=3", data: {rtom:rtom}, success: function(result){
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">DP Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(dp != null){
						dp.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/dpcreate.php",data:{rtom:rtom},success: function(result){				   
						dp = new geoXML3.parser({
							map: map,
							afterParse: loadw2
							});
						dp.parse('kmlfiles/dp.kml');
						$("#loding_window2").attr("style", "display:none");
					}});

				}else{

					if(dp != null){
						dp.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/dpcreate.php",data:{rtom:rtom},success: function(result){				   
						dp = new geoXML3.parser({
							map: map,
							afterParse: loadw2
							});
						dp.parse('kmlfiles/dp.kml');
						$("#loding_window2").attr("style", "display:none");
					}});
	
				}

			}});


		}
		

		if(document.getElementById('chk_3').checked)
		{

			$("#loding_window3").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=4", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">FDP Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(fdp != null){
						fdp.hideDocument();
					}
			

					$.ajax({ type: "POST",url: "./kmlcreate/fdpcreate.php",data:{rtom:rtom},success: function(result){				   
						fdp = new geoXML3.parser({
							map: map,
							afterParse: loadw3
							});
						fdp.parse('kmlfiles/fdp.kml');

					}});

				}else{

					if(fdp != null){
						fdp.hideDocument();
					}
			

					$.ajax({ type: "POST",url: "./kmlcreate/fdpcreate.php",data:{rtom:rtom},success: function(result){				   
						fdp = new geoXML3.parser({
							map: map,
							afterParse: loadw3
							});
						fdp.parse('kmlfiles/fdp.kml');

					}});
	
				}

			}});

		}

		
		if(document.getElementById('chk_4').checked)
		{
			$("#loding_window4").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=5", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">MH/HH Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(mh != null){
						mh.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/mh_hh_create.php",data:{rtom:rtom},success: function(result){				   
						mh = new geoXML3.parser({
							map: map,
							afterParse: loadw4
							});
						mh.parse('kmlfiles/mh_hh.kml');

					}});

				}else{

					if(mh != null){
						mh.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/mh_hh_create.php",data:{rtom:rtom},success: function(result){				   
						mh = new geoXML3.parser({
							map: map,
							afterParse: loadw4
							});
						mh.parse('kmlfiles/mh_hh.kml');

					}});
	
				}

			}});

		}


		if(document.getElementById('chk_5').checked)
		{
			$("#loding_window5").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=6", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">FIBER HOMES Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(fh != null){
						fh.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/fhcreate.php",data:{rtom:rtom},success: function(result){				   
						fh = new geoXML3.parser({
							map: map,
							afterParse: loadw5
							});
						fh.parse('kmlfiles/fh.kml');

					}});

				}else{

					if(fh != null){
						fh.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/fhcreate.php",data:{rtom:rtom},success: function(result){				   
						fh = new geoXML3.parser({
							map: map,
							afterParse: loadw5
							});
						fh.parse('kmlfiles/fh.kml');

					}});
	
				}

			}});

		}



		
		if(document.getElementById('chk_6').checked)
		{
			$("#loding_window6").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=7", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">LTE BASESTATION Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(lteb != null){
						lteb.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/ltebcreate.php",data:{rtom:rtom},success: function(result){				   
						lteb = new geoXML3.parser({
							map: map,
							afterParse: loadw6
							});
						lteb.parse('kmlfiles/lteb.kml');
					}});

				}else{

					if(lteb != null){
						lteb.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/ltebcreate.php",data:{rtom:rtom},success: function(result){				   
						lteb = new geoXML3.parser({
							map: map,
							afterParse: loadw6
							});
						lteb.parse('kmlfiles/lteb.kml');

					}});
	
				}

			}});

		}


		if(document.getElementById('chk_7').checked)
		{
			$("#loding_window7").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=8", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">LTE SINGAL STRENGTH Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(ltes != null){
					 	ltes.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/ltescreate.php",data:{rtom:rtom},success: function(result){				   
						ltes = new geoXML3.parser({
							map: map,
							afterParse: loadw7
							});
						ltes.parse('kmlfiles/ltes.kml');

					}});

				}else{

					if(ltes != null){
					 	ltes.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/ltescreate.php",data:{rtom:rtom},success: function(result){				   
						ltes = new geoXML3.parser({
							map: map,
							afterParse: loadw7
							});
						ltes.parse('kmlfiles/ltes.kml');

					}});
	
				}

			}});

		}


		if(document.getElementById('chk_8').checked)
		{
			$("#loding_window8").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=9", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">SLBN Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(slbn != null){
					 	slbn.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/slbncreate.php",data:{rtom:rtom},success: function(result){				   
						slbn = new geoXML3.parser({
							map: map,
							afterParse: loadw8
							});
						slbn.parse('kmlfiles/slbn.kml');
		
					}});

				}else{

					if(slbn != null){
					 	slbn.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/slbncreate.php",data:{rtom:rtom},success: function(result){				   
						slbn = new geoXML3.parser({
							map: map,
							afterParse: loadw8
							});
						slbn.parse('kmlfiles/slbn.kml');

					}});
	
				}

			}});

		}


		if(document.getElementById('chk_9').checked)
		{
			$("#loding_window9").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=10", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">MPLS CORE Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(mplsc != null){
					 	mplsc.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/mplsccreate.php",data:{rtom:rtom},success: function(result){				   
						mplsc = new geoXML3.parser({
							map: map,
							afterParse: loadw9
							});
						mplsc.parse('kmlfiles/mplsc.kml');

					}});

				}else{

					if(mplsc != null){
					 	mplsc.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/mplsccreate.php",data:{rtom:rtom},success: function(result){				   
						mplsc = new geoXML3.parser({
							map: map,
							afterParse: loadw9
							});
						mplsc.parse('kmlfiles/mplsc.kml');
	
					}});
	
				}

			}});

		}


		if(document.getElementById('chk_10').checked)
		{
			$("#loding_window10").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=11", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">MPLS EDGE Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(mplse != null){
					 	mplse.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/mplsecreate.php",data:{rtom:rtom},success: function(result){				   
						mplse = new geoXML3.parser({
							map: map,
							afterParse: loadw10
							});
						mplse.parse('kmlfiles/mplse.kml');

					}});

				}else{

					if(mplse != null){
					 	mplse.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/mplsecreate.php",data:{rtom:rtom},success: function(result){				   
						mplse = new geoXML3.parser({
							map: map,
							afterParse: loadw10
							});
						mplse.parse('kmlfiles/mplse.kml');

					}});
	
				}

			}});

		}


		if(document.getElementById('chk_11').checked)
		{
			$("#loding_window11").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=12", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">CEA NODE Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(cea != null){
					 	cea.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/ceacreate.php",data:{rtom:rtom},success: function(result){				   
						cea = new geoXML3.parser({
							map: map,
							afterParse: loadw11
							});
						cea.parse('kmlfiles/cea.kml');

					}});

				}else{

					if(cea != null){
					 	cea.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/ceacreate.php",data:{rtom:rtom},success: function(result){				   
						cea = new geoXML3.parser({
							map: map,
							afterParse: loadw11
							});
						cea.parse('kmlfiles/cea.kml');

					}});
	
				}

			}});

		}


		if(document.getElementById('chk_12').checked)
		{
			$("#loding_window12").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=13", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">LEADS Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(gpsL != null){
					 	gpsL.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/gpslcreate.php",data:{rtom:rtom},success: function(result){				   
						gpsL = new geoXML3.parser({
							map: map,
							afterParse: loadw12
							});
						gpsL.parse('kmlfiles/gpsl.kml');

					}});

				}else{

					if(gpsL != null){
					 	gpsL.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/gpslcreate.php",data:{rtom:rtom},success: function(result){				   
						gpsL = new geoXML3.parser({
							map: map,
							afterParse: loadw12});
						gpsL.parse('kmlfiles/gpsl.kml');

					}});
	
				}

			}});

		}


		if(document.getElementById('chk_13').checked)
		{
			$("#loding_window13").attr("style", "display:block");
			
			$.ajax({url: "./function.php?q=14", data: {rtom:rtom}, success: function(result){
			 
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">PLAN FIBER DP Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(plfdp != null){
					 	plfdp.hideDocument();
					}
					
					
					$.ajax({ type: "POST",url: "./kmlcreate/proposefdpcreate.php",data:{rtom:rtom},success: function(result){				   
						plfdp = new geoXML3.parser({
							map: map,
							afterParse: loadw13
							});
						plfdp.parse('kmlfiles/pfdp.kml');

					}});

				}else{

					if(plfdp != null){
					 	plfdp.hideDocument();
					}
					
					
					$.ajax({ type: "POST",url: "./kmlcreate/proposefdpcreate.php",data:{rtom:rtom},success: function(result){				   
						plfdp = new geoXML3.parser({
							map: map,
							afterParse: loadw13
						});
						plfdp.parse('kmlfiles/pfdp.kml');
						
					}});
	
				}

			}});

		}
		
		
}


function loadw1(){
	
	$("#loding_window1").attr("style", "display:none");
}

function loadw2(){
	
	$("#loding_window2").attr("style", "display:none");
}

function loadw3(){
	
	$("#loding_window3").attr("style", "display:none");
}

function loadw4(){
	
	$("#loding_window4").attr("style", "display:none");
}

function loadw5(){
	
	$("#loding_window5").attr("style", "display:none");
}

function loadw6(){
	
	$("#loding_window6").attr("style", "display:none");
}

function loadw7(){
	
	$("#loding_window7").attr("style", "display:none");
}

function loadw8(){
	
	$("#loding_window8").attr("style", "display:none");
}

function loadw9(){
	
	$("#loding_window9").attr("style", "display:none");
}

function loadw10(){
	
	$("#loding_window10").attr("style", "display:none");
}

function loadw11(){
	
	$("#loding_window11").attr("style", "display:none");
}

function loadw12(){
	
	$("#loding_window12").attr("style", "display:none");
}

function loadw13(){
	
	$("#loding_window13").attr("style", "display:none");
}


//--------------------------------End load map data----------------------------------//	

//--------------------------move icon -------------------------//
function editpfdpdata(){
		
	var rtom = document.getElementById('rtom').value;	
		
	if(rtom == ''){
		
		alert('plese select a RTOM to continue!');
		return;
			
	}else{
		
		$("#rtom").prop('disabled', 'disabled');
		
		if(plfdp != null){
			plfdp.hideDocument();
		}
		
		if(document.getElementById('chk_13').checked ){

			$.ajax({ type: "POST",url: "./kmlcreate/proposefdpcreate.php", data: {rtom:rtom},success: function(result){				   
				plfdp = new geoXML3.parser({map: map,markerOptions: {draggable:true },afterParse: useMHplData});
				plfdp.parse('kmlfiles/pfdp.kml');
			}});
			
		}

	}
						
}
//------------------------------end move icon -------------------//

function useMHplData(doc) {

	var nType = 'mh';
	
	setTimeout(function() { usemhPlDatax(doc,nType); }, 5000);
	
}

function usemhPlDatax(doc,nType) {
		
	for (var i = 0; i < doc[0].placemarks.length; i++) {
		
    google.maps.event.addListener(doc[0].placemarks[i].marker,"dragend", function (event) {
	 
	 var pfdpmarkid = this.id;
	 var pfdpmarkArr = pfdpmarkid.split('placemark');
	 var pfdpno = pfdpmarkArr[1];
	 
	 var latitude = event.latLng.lat();
	 var longitude = event.latLng.lng();
	 
	 var info =[];
     info[0] =   pfdpno;
     info[1] =   latitude;
     info[2] =   longitude;

	 if (confirm("Are you sure! you want to change the location")) {
    	
    	$.ajax({
	       type: "POST",
	       data: {info:info},
	       url: "./function.php?q=16",
	       success: function(msg){
	       
		    alert('location change successfully');
			
				if (confirm("Are you sure! You completed all changes")) {
					
					getdata();

				}else{

					return false;
				}

			}
		   
		   
	    });

	 } else {
	    alert('location not change');
	 }
  
  });//end event

  }//end for loop
  
}

//-----------------------------delete fdp ----------------------//
function del_fdp(a){

var fdp_id = a;

if (confirm("Are you sure! you want to delete FDP")) {

    $.ajax({
       type: "POST",
       data: {fdp_id:fdp_id},
       url: "./function.php?q=1",
       success: function(msg){
          
         alert('FDP Deleted successful');

         getdata();
          
       }
    });
  
} else {

  alert('Delete Canceled!');
  
}

}
//-----------------------------delete fdp --------------------//


function dplocserach(){
	
	var dploc = document.getElementById('dploc').value;
	var msg = '';	
	
	$.ajax({url: "./function.php?q=1", data: {dploc:dploc}, success: function(result){
			 var res = result;
			
				if(res == 0){

					msg +='<li style="color:red">DP Data Not Found</li>';
					$("#frm_body").html(msg);
					$("#myModal").modal('show');

					if(sLoc != null){
						sLoc.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/dploccreate.php",data:{dploc:dploc},success: function(result){				   
						sLoc = new geoXML3.parser({map: map});
						sLoc.parse('kmlfiles/dploc.kml');
					}});

				}else{

					if(sLoc != null){
						sLoc.hideDocument();
					}
					

					$.ajax({ type: "POST",url: "./kmlcreate/dploccreate.php",data:{dploc:dploc},success: function(result){				   
						sLoc = new geoXML3.parser({map: map});
						sLoc.parse('kmlfiles/dploc.kml');
					}});
	
				}
				
			}
				
	});
	
}

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
