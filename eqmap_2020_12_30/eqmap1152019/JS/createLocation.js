$(document).ready(function(){

	$(document).on('click','#cmbftype',function(){

	var position = $('.position').val();

	var location = position.replace(/[()]/g, ''); 

	var arrloc = location.split(",");

	var Longitute = arrloc[0];

	var Latitude = arrloc[1];

	var cmbVal = $(this).val();

	var str = '';
	
	var rtom = $('#rtom').val();

	if(cmbVal==1)
	{

	 $(".frmbody").html('<!DOCTYPE html>'+
						'<html>'+
						'<head>'+
						'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">'+
						'</head>'+
						'<body>'+
						'<table class="table" style="width:100%">'+  
						'<tr><td>Pole Code:</td><td><input type="text" id="pcode" class="txtpcode"/></td></tr>'+
					  	'<tr><td>LEA name:</td><td><select id="Pleaname"><option></option></select></td></tr>'+
						'<tr><td>Road name</td><td><input list="locations"  onkeyup="checkKey(event,this);" id="prdname"/><datalist id="locations"><option value=""></option></datalist></td></tr>'+
						'<tr><td>Pole Make:</td><td><select id="pmake" onChange="loadcmbData(this)"><option value=""></option><option value="SLT">SLT</option><option value="CEB">CEB</option><option value="SEC">SEC</option></select></td></tr>'+
						'<tr><td>Pole Height:</td><td><select class="cmbpHeight" id="pheight"><option value=""></option><option value="2.2">2.2</option><option value="5.6(L)">5.6(L)</option><option value="5.6(H)">5.6(H)</option><option value="6.0">6.0</option><option value="6.7">6.7</option><option value="7.5">7.5</option><option value="8.0">8.0</option><option value="9.0">9.0</option><option value="8.3">8.3</option><option value="9.0">9.0</option><option value="10.0">10.0</option><option value="11.0">11.0</option><option value="13.0">13.0</option><option value="8.0">8.0</option></select></td></tr>'+
						'<tr><td>Pole Type:</td><td><select class="cmbpType" id="ptype"><option value=""></option><option value="Concrete">Concrete</option><option value="GI">GI</option><option value="Spun">Spun</option><option value="Concrete">Concrete</option><option value="Wood">Wood</option><option value="Concrete">Concrete</option></select></td></tr>'+
						'<tr><td>Type of Pole1:</td><td><select id="pf1"><option value=""></option><option value="Normal Pole">Normal Pole</option><option value="With power enclosure">With power enclosure</option><option value="with mounted MSAN">with mounted MSAN</option><option value="with riser pipe">with riser pipe</option></select></td></tr>'+
						'<tr><td>Type of Pole2:</td><td><select id="pf2"><option value=""></option><option value="Pole with single Stay">Pole with single Stay</option><option value="Pole with 2 Stays">Pole with 2 Stays</option><option value="Pole with 3 Stays">Pole with 3 Stays</option><option value="Pole with strut">Pole with strut</option><option value="Pole with Overhead guy">Pole with Overhead guy</option><option value="Pole with Barbed wire">Pole with Barbed wire</option></select></td></tr>'+
						'<tr><td>DP Count:</td><td id="pdp"></td><td>  <button type="button" id="pdpedit" class="btn btn-default btn-sm" onclick="adddp()"><span class="glyphicon glyphicon-plus"></span></button></td></tr>'+
						'<tr> <td colspan="3" align="center"><div> <table id="pdptable"><tr><td> DP Location</td><td> DP Discription</td> <td> Index</td></tr><tbody><tr><td><input type="text" id="pdploc"/></td><td><input type="text" id="pdpdis"/></td><td><input type="text" id="pdpind"/></td></tr></tbody></table><button type="button" id="savedp" class="btn btn-default btn-sm" onclick="savedp()">Save DP</button></div></td></tr>'+
						'<tr><td>FDP Count:</td><td id="pfdp"></td><td>  <button type="button"  id="pfdpedit" class="btn btn-default btn-sm" onclick="addfdp()"><span class="glyphicon glyphicon-plus"></span></button></td></tr>'+
						'<tr><td colspan="3" align="center"><div> <table id="pfdptable"><tr><td> FDP Location</td><td> FDP Discription</td> <td> Index</td></tr><tbody></tbody></table>  <button type="button" id="savefdp" class="btn btn-default btn-sm" onclick="savefdp()">Save FDP</button></div></td></tr>'+
						'<tr><td>Number of risers:</td><td><input type="text" id="priser"/></td></tr>'+
						'<tr><td>Number of drop wires:</td><td><select id="pdropwire"><option value=""></option><option value="Copper">Copper</option><option value="Fiber">Fiber</option></select></td></tr>'+
						'<tr><td rowspan=2>GPS location:</td><td>Longitute:'+Longitute+'</td></tr>'+
						'<tr><td>Latitude:'+Latitude+'</td></tr>'+
						'<tr style="display:none"><td><input type="text" id="plng" value="'+Longitute+'"/></td><td><input type="text" id="plat" value="'+Latitude+'"/></td></tr>'+
						'<tr><td></td><td><button type="button" id="savepData"  class="btn btn-primary btn-sm" style="float:right"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Save</button></td></tr>'+
						'</table>'+
						'</body>'+
						'</html>');
						
						$.ajax({
						
							   type: "POST",
							   data: {rtom:rtom},
							   url: "./function.php?q=31",
							   success: function(result){
							  
							   $("#Pleaname").html(result);
							  
							   }
						});

	}else if(cmbVal==2){

	 $(".frmbody").html('<![CDATA[<!DOCTYPE html>'+
						'<html>'+
						'<head>'+
						'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">'+
						'</head>'+
						'<body>'+
						'<table class="table" style="width:100%">'+
						'<tr><th>Items</th><th>Description</th></tr>'+
						'<tr><td>MH code:</td><td><input type="text" id="mhcode"/></td></tr>'+
						'<tr><td>LEA name:</td><td><select id="mhleaname"><option></option></select></td></tr>'+
						'<tr><td>Road name</td><td><input list="locations"  onkeyup="checkKey(event,this);" id="mhrdname"/><datalist id="locations"></datalist></td></tr>'+
						'<tr><td>Location Area Code:</td><td><input type="text" id="mhareacode"/></td></tr>'+
						'<tr><td>Type:</td><td><select id="mhtype" onChange="setsubtype(this)"><option value=""></option><option value="MH">MH</option><option value="HH">HH</option></select></td></tr>'+ 
						'<tr><td>MH Type:</td><td><select id="mhsubtype"><option value=""></option><option value="S-1">S-1</option><option value="S-2">S-2</option><option value="S-3">S-3</option><option value="S-4">S-4</option><option value="L-1">L-1</option><option value="L-2">L-2</option><option value="L-3">L-3</option><option value="SPECIAL">Special</option><option value="HH-1">HH-1</option><option value="HH-2">HH-2</option><option value="HH-3">HH-3</option></select></td></tr>'+
						'<tr><td>Face Number:</td><td><select id="mhfacenumber"><option value=""></option><option value="MH1">MH1</option><option value="MH2">MH2</option></select></td></tr>'+
						'<tr><td>Side:</td><td><select id="mhside"><option value=""></option><option value="RHS">RHS</option><option value="LHS">LHS</option></select></td></tr>'+
						'<tr><td>Start of chain?:</td><td><select id="mhstart"><option value=""></option><option value="Yes">Yes</option><option value="No">No</option></select></td></tr>'+
						'<tr><td>Adjacent previous MH/HH number:</td><td><input type="text" id="mhapnumber" /></td></tr>'+
						'<tr><td>Number of risers:</td><td><input type="text" id="mhriser"/></td></tr>'+
						'<tr><td>Reamrk:</td><td><input type="text" id="mhremark" /></td></tr>'+
						'<tr><td>Frame and cover status :</td><td><select id="mhfcstatus"><option value=""></option><option value="Visible and needs to be adjusted">Visible and needs to be adjusted</option><option value="Not visible and needs to be adjusted">Not visible and needs to be adjusted</option><option value="Needs to be replaced">Needs to be replaced</option></select></td></tr>'+
						'<tr><td rowspan=2>GPS location:</td><td>Longitute:'+Longitute+'</td></tr>'+
						'<tr><td>latitude:'+Latitude+'</td></tr>'+
						'<tr style="display:none"><td><input type="text" id="mhlng" value="'+Longitute+'"/></td><td><input type="text" id="mhlat" value="'+Latitude+'"/></td></tr>'+
						'<tr><td></td><td><button type="button" id="savemhData" class="btn btn-primary btn-sm" style="float:right"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Save</button></td></tr>'+
						'</table>'+
						'</body>'+
						'</html>');
						
						$.ajax({
						
							   type: "POST",
							   data: {rtom:rtom},
							   url: "./function.php?q=31",
							   success: function(result){
							  
							   $("#mhleaname").html(result);
							  
							   }
						});
	

	}else if(cmbVal==3){


 	 $(".frmbody").html('<![CDATA[<!DOCTYPE html>'+                     
                        '<html>'+
                        '<head>'+
                        '</head>'+
                        '<body>'+
                        '<table class="table" style="width:100%">'+
                        '<tr><th>Items</th><th>Description</th></tr>'+
                        '<tr><td>TP Name:</td><td><input type="text" id="tpname"/></td></tr>'+
                        '<tr><td>Customer Name:</td><td><input type="text" id="tpcname"/></td></tr>'+
                        '<tr><td>Number of cores terminated:</td><td><input type="tptext" id="tpnumberofct"/></td></tr>'+
                        '<tr><td>Customer premisess ODF type:</td><td><select id="tpcpodftype"><option value=""></option><option value="Q1">Q1</option><option value="Q2">Q2</option><option value="Q3">Q3</option><option value="Q4">Q4</option><option value="Q5">Q5</option><option value="Q6">Q6</option><option value="Q7">Q7</option></select></td></tr>'+
                        '<tr><td>Customer Type:</td><td><select id="tpctype" onChange="settpsubtype()"><option value=""></option><option value="SME">SME</option><option value="Enterprice">Enterprice</option><option value="Single tenant">Single tenant</option><option value="Multi tnants">Multi tnants</option><option value="Wholesale">Wholesale</option></select></td></tr>'+
                        '<tr><td>Customer sub type:</td><td><select id="tpcsubtype" onChange="setcustomersubtype()"><option value=""></option><option value="Tower">Tower</option><option value="Buildings">Buildings</option></select></td></tr>'+
                        '<tr><td>Operator to which Service provided:</td><td><select id="tpserviceprovided"><option value=""></option><option value="SLT">SLT</option><option value="Mobitel">Mobitel</option><option value="Dialog">Dialog</option><option value="etc">etc</option></select></td></tr>'+
                        '<tr><td>Tower Owner:</td><td><select id="tptowerowner"><option value=""></option><option value="SLT">SLT</option><option value="Mobitel">Mobitel</option><option value="Dialog">Dialog</option><option value="etc">etc</option></select></td></tr>'+
                        '<tr><td rowspan=2>GPS location:</td><td>Longitute: '+Longitute+'</td></tr>'+
                        '<tr><td>latitude: '+Latitude+'</td></tr>'+
						'<tr style="display:none"><td><input type="text" id="tplng" value="'+Longitute+'"/></td><td><input type="text" id="tplat" value="'+Latitude+'"/></td></tr>'+
                        '<tr><td></td><td><button type="button" id="savetpdata" class="btn btn-primary btn-sm" style="float:right"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Save</button></td></tr>'+
                        '</table>'+
                        '</body>'+
                        '</html>');



        }else if(cmbVal==4){


     	 $(".frmbody").html('<![CDATA[<!DOCTYPE html>'+
                            '<html>'+
                            '<head>'+
                            '</head>'+
                            '<body>'+
                            '<table class="table" style="width:100%">'+
                            '<tr><th>Items</th><th>Description</th></tr>'+
                            '<tr><td>DP Number:</td><td><input type="text" id="fdpNo"/></td></tr>'+
                            '<tr><td>LEA name:</td><td><select id="fdpleaname"><option></option></select></td></tr>'+
                            '<tr><td>Road name</td><td><input list="locations"  onkeyup="checkKey(event,this);" id="fdprdname"/><datalist id="locations"></datalist> </td></tr>'+
                            '<tr><td>Number of splitters:</td><td><input type="text" id="fdpsplitter"/></td></tr>'+
                            '<tr><td>Splitter type:</td><td><select id="fdpstype"><option value=""></option><option value="1:4">1:4</option><option value="1:8">1:8</option><option value="LOV:  1:32">1:32</option><option value="1:64">1:64</option><option value="1:128">1:128</option></select></td></tr>'+
                            '<tr><td rowspan=2>GPS location:</td><td>Longitute: '+Longitute+'</td></tr>'+
                            '<tr><td>latitude: '+Latitude+'</td></tr>'+
							'<tr style="display:none"><td><input type="text" id="tplng" value="'+Longitute+'"/></td><td><input type="text" id="tplat" value="'+Latitude+'"/></td></tr>'+
                            '<tr><td></td><td><button type="button" id="savefdpdata" class="btn btn-primary btn-sm" style="float:right"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Save</button></td></tr>'+
                            '</table>'+
                            '</body>'+
                            '</html>');
							
							$.ajax({
						
							   type: "POST",
							   data: {rtom:rtom},
							   url: "./function.php?q=31",
							   success: function(result){
							  
							   $("#fdpleaname").html(result);
							  
							   }
							});


        }else if(cmbVal==5){


     	 $(".frmbody").html('<![CDATA[<!DOCTYPE html>'+
                            '<html>'+
                            '<head>'+
                            '</head>'+
                            '<body>'+
                            '<table class="table" style="width:100%">'+
                            '<tr><th>Items</th><th>Description</th></tr>'+
                            '<tr><td>FTC Number:</td><td><input type="text" id="ftcNo"/></td></tr>'+
                            '<tr><td>LEA name:</td><td><select id="ftleaname"><option></option></select></td></tr>'+
                            '<tr><td>Road name</td><td><input list="locations"  onkeyup="checkKey(event,this);" id="ftcrdname"/><datalist id="locations"></datalist> </td></tr>'+
                            '<tr><td>Side:</td><td><select id="ftcside"><option value=""></option><option value="RHS">RHS</option><option value="LHS">LHS</option></select></td></tr>'+
                            '<tr><td>Type:</td><td><select id="ftctype"><option value=""></option><option value="M1">M1</option><option value="M2">M2</option><option value="M3">M3</option><option value="M4">M4</option><option value="M5">M5</option><option value="M6">M6</option><option value="M7">M7</option><option value="M8">M8</option><option value="M9">M9</option><option value="M10">M10</option><option value="M11">M11</option><option value="M12">M12</option><option value="M13">M13</option><option value="M14">M14</option></select></td></tr>'+
                            '<tr><td>FTC Feature:</td><td><select id="ftcfeature"><option value=""></option><option value="Outdoor pole mounted">Outdoor pole mounted</option><option value="Outdoor ground mounted">Outdoor ground mounted</option><option value="Outdoor wall mounted">Outdoor wall mounted</option><option value="Indoor wall mounted">Indoor wall mounted</option><option value="Indoor rack mounted">Indoor rack mounted</option></select></td></tr>'+
                            '<tr><td>Capacity:</td><td><input type="text" id="ftccapacity"/></td></tr>'+
                            '<tr><td rowspan=2>GPS location:</td><td>Longitute: '+Longitute+'</td></tr>'+
                            '<tr><td>latitude: '+Latitude+'</td></tr>'+
							'<tr style="display:none"><td><input type="text" id="tplng" value="'+Longitute+'"/></td><td><input type="text" id="tplat" value="'+Latitude+'"/></td></tr>'+
                            '<tr><td></td><td><button type="button" id="saveftcdata" class="btn btn-primary btn-sm" style="float:right"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Save</button></td></tr>'+
                            '</table>'+
                            '</body>'+
                            '</html>');
							
							$.ajax({
						
							   type: "POST",
							   data: {rtom:rtom},
							   url: "./function.php?q=31",
							   success: function(result){
							  
							   $("#ftleaname").html(result);
							  
							   }
							});


        }else if(cmbVal==6){


         $(".frmbody").html('<![CDATA[<!DOCTYPE html>'+
                            '<html>'+
                            '<head>'+
                            '</head>'+
                            '<body>'+
                            '<table class="table" style="width:100%">'+
                            '<tr><th>Items</th><th>Description</th> </tr>'+
                            '<tr><td>Joint Number:</td><td><input type="text" id="fjNo"/></td></tr>'+
                            '<tr><td>Connected MH/HH/POLE number:</td><td><input type="text" id="fjconnumber"/></td></tr>'+
                            '<tr><td>Type:</td><td><select id="fjtype"><option value=""></option><option value="Aerial">Aerial</option><option value="Conduit">Conduit</option></select></td></tr>'+
                            '<tr><td>Sheath Number:</td><td><input type="text" id="fjsnumber"/></td></tr>'+
                            '<tr><td rowspan=2>GPS location:</td><td>Longitute: '+Longitute+'</td></tr>'+
                            '<tr><td>latitude:'+Latitude+'</td></tr>'+
							'<tr style="display:none"><td><input type="text" id="tplng" value="'+Longitute+'"/></td><td><input type="text" id="tplat" value="'+Latitude+'"/></td></tr>'+
                            '<tr><td></td><td><button type="button" id="saveFiberJoint" class="btn btn-primary btn-sm" style="float:right"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Save</button></td></tr>'+   
                            '</table>'+
                            '</body>'+
                            '</html>');

	    }else if(cmbVal==7){


         $(".frmbody").html('<![CDATA[<!DOCTYPE html>'+
                            '<html>'+
                            '<head>'+
                            '</head>'+
                            '<body>'+
                            '<table class="table" style="width:100%">'+
                            '<tr><th>Items</th><th>Description</th></tr>'+
                            '<tr><td>ODF Number:</td><td><input type="text" id="odfNo"/></td></tr>'+
                            '<tr><td>LEA name:</td><td><select id="odfleaname"><option></option></select></td></tr>'+
                            '<tr><td>LEA Building loacation:</td><td><input type="text" id="odflblocation"/></td></tr>'+
                            '<tr><td>Location Area Code:</td><td><input type="text" id="odflac"/></td></tr>'+
                            '<tr><td>Rack Number:</td><td><input type="text" id="odfrnumber"/> </td></tr>'+
                            '<tr><td>Sheath Names:</td><td><input type="text" id="odfshname"/></td></tr>'+
                            '<tr><td>Number of cores terminated:</td><td><input type="text" id="odfnumberofct"/></td></tr>'+
                            '<tr><td rowspan=2>GPS location:</td><td>Longitute: '+Longitute+'</td></tr>'+
                            '<tr><td>latitude: '+Latitude+'</td></tr>'+
							'<tr style="display:none"><td><input type="text" id="tplng" value="'+Longitute+'"/></td><td><input type="text" id="tplat" value="'+Latitude+'"/></td></tr>'+
                            '<tr><td></td><td><button type="button" id="saveodfdata" class="btn btn-primary btn-sm" style="float:right"><i class="glyphicon glyphicon-folder-close"></i>&nbsp;&nbsp;Save</button></td></tr>'+  
                            '</table>'+
                            '</body>'+
                            '</html>');
							
							$.ajax({
						
							   type: "POST",
							   data: {rtom:rtom},
							   url: "./function.php?q=31",
							   success: function(result){
							  
							   $("#odfleaname").html(result);
							  
							   }
							});

	    }else{
             
             $(".frmbody").html('');

        }

	});

});


function loadcmbData(cmb){

		make = cmb.options[cmb.selectedIndex].value;

		var resp= "";
		if(make == 'SLT'){
			 resp =  ["","2.2","5.6(L)","5.6(H)","6.0","6.7","7.5","8.0","9.0" ];
		}else if(make == 'CEB'){
			 resp =  ["","8.3","9.0","10.0","11.0","13.0" ];
		}else if(make == 'SEC'){
			 resp =  ["","8.0" ];
		}
			
		$(".cmbpHeight").html('');

		for (var i = 0; i<resp.length; i++){

		$('.cmbpHeight').append( '<option value="'+resp[i]+'">'+resp[i]+'</option>');

		}
						
		
		var resp= "";
		if(make == 'SLT'){
			 resp =  ["","Concrete","GI","Spun" ];
		}else if(make == 'CEB'){
			 resp =  ["","Concrete","wood" ];
		}else if(make == 'SEC'){
			 resp =  ["","Concrete" ];
		}
		
		$(".cmbpType").html('');

		for (var i = 0; i<resp.length; i++){
			
			$('.cmbpType').append( '<option value="'+resp[i]+'">'+resp[i]+'</option>' );

		}	
		
}


$(document).on('click','#savepData',function(){
		
		if($('#pcode').val() == ''){

			swal("", "POLE code required!", "warning");

			return;

		}else{

		var info =[];
		info[0] = 	$('#pcode').val();
		info[1] = 	document.getElementById('Pleaname').options[document.getElementById('Pleaname').selectedIndex].value;
		info[2] = 	document.getElementById('prdname').value;
		info[3] = 	document.getElementById('pmake').options[document.getElementById('pmake').selectedIndex].value;
		info[4] = 	document.getElementById('pheight').options[document.getElementById('pheight').selectedIndex].value;
		info[5] = 	document.getElementById('ptype').options[document.getElementById('ptype').selectedIndex].value;
		info[6] = 	document.getElementById('pf1').options[document.getElementById('pf1').selectedIndex].value;
		info[7] = 	document.getElementById('pf2').options[document.getElementById('pf2').selectedIndex].value;
		info[8] = 	document.getElementById('priser').value;
		info[9] = 	document.getElementById('pdropwire').options[document.getElementById('pdropwire').selectedIndex].value;
		info[10] = 	document.getElementById('plng').value;
		info[11] = 	document.getElementById('plat').value;
		info[12] = 	document.getElementById('rtom').value;

		

		$.ajax({
		   type: "POST",
		   data: {info:info},
		   url: "./function.php?q=29",
		   success: function(msg){

		   	 $("#myModal").modal('hide');
		   	 swal("Successful", "You created new pole!", "success");
			 polespl.hideDocument();
			 getdata();

		   }
		});

	 }		
});

function updatepolepldata(){	

		var id = event.target.id.replace("save", "");
		
		var info =[];
		info[0] = 	id;
		info[1] = 	document.getElementById(id+'make').options[document.getElementById(id+'make').selectedIndex].value;
		info[2] = 	document.getElementById(id+'height').options[document.getElementById(id+'height').selectedIndex].value;
		info[3] = 	document.getElementById(id+'ptype').options[document.getElementById(id+'ptype').selectedIndex].value;
		info[4] = 	document.getElementById(id+'f1').options[document.getElementById(id+'f1').selectedIndex].value;
		info[5] = 	document.getElementById(id+'f2').options[document.getElementById(id+'f2').selectedIndex].value;
		info[6] = 	document.getElementById(id+'leaname').options[document.getElementById(id+'leaname').selectedIndex].value;
		info[7] = 	document.getElementById(id+'rdname').value;
		info[8] = 	document.getElementById(id+'riser').value;
		info[9] = 	document.getElementById(id+'dropwire').options[document.getElementById(id+'dropwire').selectedIndex].value;
	
		$.ajax({
		   type: "POST",
		   data: {info:info},
		   url: "./function.php?q=32",
		   success: function(msg){
			 swal("Updated Success");
			 polespl.hideDocument();
			 getdata();
		   }
		});
}

function deletepolespldata(){  

  var poleNo = document.getElementById("poleNo").value;

  swal({
    title: "Are you sure?",
    text: "Once deleted,POLE informations will not be able to recover!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("POLE informations have been deleted", {
        icon: "success",
      });

      $.ajax({
       type: "POST",
       data: {poleNo:poleNo},
       url: "./function.php?q=33",
       success: function(msg){
       polespl.hideDocument();
       getdata();
       }
    });
	
    } else {
      swal("Your informations are safe!");
    }
  });

}


function setsubtype(cmb){
 
    var type = cmb.options[cmb.selectedIndex].value;

    var resp= "";
    if(type == 'MH'){
       resp =  ["S-1","S-2","S-3","S-4","L-1","L-2","L-3","special" ];
    }else if(type == 'HH'){
       resp =  ["HH-1","HH-2","HH-3"];
    }

    $(".mhsubtype").html('');

	for (var i = 0; i<resp.length; i++){

		$('.mhsubtype').append( '<option value="'+resp[i]+'">'+resp[i]+'</option>');

	}

}

 $(document).on('click','#savemhData',function(){

 	if($('#mhcode').val() == ''){

		swal("", "MANHOLE-HANDHOLE code required!", "warning");

		return;

	}else if($('#mhtype').val() == ''){

		swal("", "MANHOLE-HANDHOLE Type required!", "warning");

		return;

	}else{
    
    var info =[];
    info[0] =   document.getElementById('mhcode').value;
    info[1] =   document.getElementById('mhleaname').options[document.getElementById('mhleaname').selectedIndex].value;
    info[2] =   document.getElementById('mhrdname').value;
    info[3] =   document.getElementById('mhareacode').value;
    info[4] =   document.getElementById('mhtype').options[document.getElementById('mhtype').selectedIndex].value;
    info[5] =   document.getElementById('mhsubtype').options[document.getElementById('mhsubtype').selectedIndex].value;
    info[6] =   document.getElementById('mhfacenumber').options[document.getElementById('mhfacenumber').selectedIndex].value;
    info[7] =   document.getElementById('mhside').options[document.getElementById('mhside').selectedIndex].value;
    info[8] =   document.getElementById('mhstart').options[document.getElementById('mhstart').selectedIndex].value;
    info[9] =   document.getElementById('mhapnumber').value;
    info[10] =  document.getElementById('mhriser').value;
    info[11] =  document.getElementById('mhremark').value;
    info[12] =  document.getElementById('mhfcstatus').options[document.getElementById('mhfcstatus').selectedIndex].value;
    info[13] =  document.getElementById('mhlng').value;
    info[14] =  document.getElementById('mhlat').value;
    info[15] = 	document.getElementById('rtom').value;


    $.ajax({
       type: "POST",
       data: {info:info},
       url: "./function.php?q=30",
       success: function(msg){
       $("#myModal").modal('hide');
	   swal("Successful", "You created new  MANHOLE-HANDHOLE!", "success");
       manholepl.hideDocument();
       getdata();
       }
    });


	}

});


function updatemhpldata(){  

    var id = event.target.id.replace("save", "");
    
    var info =[];
    info[0] =   id;
    info[1] =   document.getElementById(id+'type').options[document.getElementById(id+'type').selectedIndex].value;
    info[2] =   document.getElementById(id+'mhsubtype').options[document.getElementById(id+'mhsubtype').selectedIndex].value;
    info[3] =   document.getElementById(id+'side').options[document.getElementById(id+'side').selectedIndex].value;
    info[4] =   document.getElementById(id+'facenumber').options[document.getElementById(id+'facenumber').selectedIndex].value;
    info[5] =   document.getElementById(id+'leaname').options[document.getElementById(id+'leaname').selectedIndex].value;
    info[6] =   document.getElementById(id+'rdname').value;
    info[7] =   document.getElementById(id+'areacode').value;
    info[8] =   document.getElementById(id+'start').options[document.getElementById(id+'start').selectedIndex].value;
    info[9] =   document.getElementById(id+'apnumber').value;
    info[10] =   document.getElementById(id+'riser').value;
    info[11] =   document.getElementById(id+'remark').value;
    info[12] =   document.getElementById(id+'fcstatus').options[document.getElementById(id+'fcstatus').selectedIndex].value;



    $.ajax({
       type: "POST",
       data: {info:info},
       url: "./function.php?q=34",
       success: function(msg){
       
	   swal("Updated Success");
       manholepl.hideDocument();
       getdata();
	   
       }
    });
  }
  
  
  function deletemhpldata(){  

  var mhNo = document.getElementById("mhNo").value;
  
   swal({
    title: "Are you sure?",
    text: "Once deleted,all Manhole-Handhole informations will not be able to recover!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("All images and other Manhole-Handhole informations have been deleted", {
        icon: "success",
      });

       $.ajax({
       type: "POST",
       data: {mhNo:mhNo},
       url: "./function.php?q=35",
       success: function(msg){
       manholepl.hideDocument();
       getdata();
       }
    });

    } else {
      swal("Your informations are safe!");
    }
  });

}

$(document).on('click','#saveductData',function(){
		
		if($('#ductcode').val() == ''){

			swal("", "DUCT code required!", "warning");

			return;

		}else{
		
		var cmbNumwaysval = document.getElementById('ductwayscmb').value;
		
		if(cmbNumwaysval == 'etc'){
		
			var ductways = document.getElementById('ductwaystxt').value;
		
		}else{
		
			var ductways = document.getElementById('ductways').options[document.getElementById('ductways').selectedIndex].value;
		
		}

		var info =[];
		info[0] = 	$('#ductcode').val();
		info[1] = 	document.getElementById('ductend1').value;
		info[2] = 	document.getElementById('ductend2').value;
		info[3] = 	document.getElementById('ductlength').value;
		info[4] = 	document.getElementById('ductprotection').options[document.getElementById('ductprotection').selectedIndex].value;
		info[5] = 	document.getElementById('ductdamage').value;
		info[6] = 	document.getElementById('ductremarks').options[document.getElementById('ductremarks').selectedIndex].value;
		info[7] = 	ductways;
		info[8] = 	document.getElementById('ductnumber').value;
		info[9] = 	document.getElementById('subduct').options[document.getElementById('subduct').selectedIndex].value;
		info[10] = 	document.getElementById('ducttype').options[document.getElementById('ducttype').selectedIndex].value;
		info[11] = 	document.getElementById('ductsize').options[document.getElementById('ductsize').selectedIndex].value;
		info[12] = 	document.getElementById('ductPosition').value;
		info[13] = 	document.getElementById('rtom').value;


		$.ajax({
		   type: "POST",
		   data: {info:info},
		   url: "./function.php?q=36",
		   success: function(msg){

		   	 $("#myModal").modal('hide');
		   	 swal("Successful", "You created new Duct!", "success");
			 ductpl.hideDocument();
			 getdata();

		   }
		});

	 }		
});


function updateductpldata(){  

    var id = event.target.id.replace("save", "");
    
    	info[0] = 	id;
		info[1] = 	document.getElementById(id+'length').value;
		info[2] = 	document.getElementById(id+'protection').options[document.getElementById(id+'protection').selectedIndex].value;
		info[3] = 	document.getElementById(id+'damage').value;
		info[4] = 	document.getElementById(id+'remarks').value;
		info[5] = 	document.getElementById(id+'type').options[document.getElementById(id+'type').selectedIndex].value;
		info[6] = 	document.getElementById(id+'ways').options[document.getElementById(id+'ways').selectedIndex].value;
		info[7] = 	document.getElementById(id+'dnumber').value;
		info[8] = 	document.getElementById(id+'subduct').options[document.getElementById(id+'subduct').selectedIndex].value;
		info[9] = 	document.getElementById(id+'size').options[document.getElementById(id+'size').selectedIndex].value;
		info[10] = 	document.getElementById(id+'mhend1').value;
		info[11] = 	document.getElementById(id+'mhend2').value;


    $.ajax({
       type: "POST",
       data: {info:info},
       url: "./function.php?q=48",
       success: function(msg){
       
	   swal("Updated Success");
       ductpl.hideDocument();
       getdata();
	   
       }
    });
  }
  

function deleteductpldata(){  

  var ductName = document.getElementById("ductName").value;

  swal({
    title: "Are you sure?",
    text: "Once deleted,POLE informations will not be able to recover!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("POLE informations have been deleted", {
        icon: "success",
      });

      $.ajax({
       type: "POST",
       data: {ductName:ductName},
       url: "./function.php?q=37",
       success: function(msg){
       polespl.hideDocument();
       getdata();
       }
    });
	
    } else {
      swal("Your informations are safe!");
    }
  });

}


$(document).on('click','#savetpdata',function(){
		
		if($('#pcode').val() == ''){

			swal("", "Termination code required!", "warning");

			return;

		}else{

			var info =[];
			info[0] =   document.getElementById('tpname').value;
			info[1] =   document.getElementById('tpcname').value;
			info[2] =   document.getElementById('tpnumberofct').value;
			info[3] =   document.getElementById('tpcpodftype').options[document.getElementById('tpcpodftype').selectedIndex].value;
			info[4] =   document.getElementById('tpctype').options[document.getElementById('tpctype').selectedIndex].value;
			info[5] =   document.getElementById('tpcsubtype').options[document.getElementById('tpcsubtype').selectedIndex].value;
			info[6] =   document.getElementById('tpserviceprovided').options[document.getElementById('tpserviceprovided').selectedIndex].value;
			info[7] =   document.getElementById('tptowerowner').options[document.getElementById('tptowerowner').selectedIndex].value;
			info[8] =  	document.getElementById('tplat').value;
			info[9] =   document.getElementById('tplng').value;
			info[10] = 	document.getElementById('rtom').value;

			$.ajax({
			   type: "POST",
			   data: {info:info},
			   url: "./function.php?q=38",
			   success: function(msg){

				 $("#myModal").modal('hide');
				 swal("Successful", "You created new Termination Point!", "success");
				 tppl.hideDocument();
				 getdata();

			   }
			});

	 }		
});

function updateTPpldata(){  

    var id = event.target.id.replace("save", "");
    
    var info =[];
    info[0] =   id;
    info[1] =   document.getElementById(id+'cname').value;
    info[2] =   document.getElementById(id+'numberofct').value;
    info[3] =   document.getElementById(id+'cpodftype').options[document.getElementById(id+'cpodftype').selectedIndex].value;
    info[4] =   document.getElementById(id+'ctype').options[document.getElementById(id+'ctype').selectedIndex].value;
    info[5] =   document.getElementById(id+'csubtype').options[document.getElementById(id+'csubtype').selectedIndex].value;
    info[6] =   document.getElementById(id+'serviceprovided').options[document.getElementById(id+'serviceprovided').selectedIndex].value;
    info[7] =   document.getElementById(id+'towerowner').options[document.getElementById(id+'towerowner').selectedIndex].value;


    $.ajax({
       type: "POST",
       data: {info:info},
       url: "./function.php?q=49",
       success: function(msg){
       
	   swal("Updated Success");
       ductpl.hideDocument();
       getdata();
	   
       }
    });
  }

function deletetpPLdata(){  

  var tpName = document.getElementById("tpName").value;

  swal({
    title: "Are you sure?",
    text: "Once deleted,Termination Point informations will not be able to recover!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("Termination Point informations have been deleted", {
        icon: "success",
      });

      $.ajax({
       type: "POST",
       data: {tpName:tpName},
       url: "./function.php?q=39",
       success: function(msg){
       polespl.hideDocument();
       getdata();
       }
    });
	
    } else {
      swal("Your informations are safe!");
    }
  });

}

$(document).on('click','#savefdpdata',function(){
		
		if($('#pcode').val() == ''){

			swal("", "Fiber Distribution Name required!", "warning");

			return;

		}else{

			var info =[];
			info[0] =   document.getElementById('fdpNo').value;
			info[1] =   document.getElementById('fdpleaname').options[document.getElementById('fdpleaname').selectedIndex].value;
			info[2] =   document.getElementById('fdprdname').value;
			info[3] =  	document.getElementById('fdpsplitter').value;
			info[4] =   document.getElementById('fdpstype').options[document.getElementById('fdpstype').selectedIndex].value;
			info[5] =   document.getElementById('tplat').value;
			info[6] =   document.getElementById('tplng').value;
			info[7] = 	document.getElementById('rtom').value;

			$.ajax({
			   type: "POST",
			   data: {info:info},
			   url: "./function.php?q=40",
			   success: function(msg){

				 $("#myModal").modal('hide');
				 swal("Successful", "You created new Fiber Distribution!", "success");
				 fdppl.hideDocument();
				 getdata();

			   }
			});

	 }		
});


function updateFDPpldata(){  

    var id = event.target.id.replace("save", "");
    
    var info =[];
    info[0] =   id;
    info[1] =   document.getElementById(id+'splitter').value;
    info[2] =   document.getElementById(id+'stype').options[document.getElementById(id+'stype').selectedIndex].value;
    info[3] =   document.getElementById(id+'leaname').options[document.getElementById(id+'leaname').selectedIndex].value;
    info[4] =   document.getElementById(id+'rdname').value;

    $.ajax({
       type: "POST",
       data: {info:info},
       url: "./function.php?q=50",
       success: function(msg){
       
	   swal("Updated Success");
       ductpl.hideDocument();
       getdata();
	   
       }
    });
  }
  
  
function deleteFDPPLdata(){  

  var fdpNo = document.getElementById("fdpNo").value;

  swal({
    title: "Are you sure?",
    text: "Once deleted,Fiber Distribution informations will not be able to recover!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("Fiber Distribution informations have been deleted", {
        icon: "success",
      });

      $.ajax({
       type: "POST",
       data: {fdpNo:fdpNo},
       url: "./function.php?q=41",
       success: function(msg){
       fdppl.hideDocument();
       getdata();
       }
    });
	
    } else {
      swal("Your informations are safe!");
    }
  });

}

$(document).on('click','#saveftcdata',function(){
		
		if($('#pcode').val() == ''){

			swal("", "Fiber Cabinet Number required!", "warning");

			return;

		}else{

			var info =[];
			info[0] =   document.getElementById('ftcNo').value;
			info[1] =   document.getElementById('ftleaname').options[document.getElementById('ftleaname').selectedIndex].value;
			info[2] =   document.getElementById('ftcrdname').value;
			info[3] =   document.getElementById('ftcside').options[document.getElementById('ftcside').selectedIndex].value;
			info[4] =   document.getElementById('ftctype').options[document.getElementById('ftctype').selectedIndex].value;
			info[5] =   document.getElementById('ftccapacity').value;
			info[6] =   document.getElementById('tplat').value;
			info[7] =   document.getElementById('tplng').value;
			info[8] = 	document.getElementById('rtom').value;

			$.ajax({
			   type: "POST",
			   data: {info:info},
			   url: "./function.php?q=42",
			   success: function(msg){

				 $("#myModal").modal('hide');
				 swal("Successful", "You created new Fiber Cabinet!", "success");
				 ftcpl.hideDocument();
				 getdata();

			   }
			});

	 }		
});

function deleteftcPLdata(){  

  var ftcNo = document.getElementById("ftcNo").value;

  swal({
    title: "Are you sure?",
    text: "Once deleted,Fiber Cabinet informations will not be able to recover!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("Fiber Cabinet informations have been deleted", {
        icon: "success",
      });

      $.ajax({
       type: "POST",
       data: {ftcNo:ftcNo},
       url: "./function.php?q=43",
       success: function(msg){
       ftcpl.hideDocument();
       getdata();
       }
    });
	
    } else {
      swal("Your informations are safe!");
    }
  });

}

$(document).on('click','#saveFiberJoint',function(){
		
		if($('#pcode').val() == ''){

			swal("", "Fiber Joint Number required!", "warning");

			return;

		}else{

			var info =[];
			info[0] =   document.getElementById('fjNo').value;
			info[1] =   document.getElementById('fjconnumber').value;
			info[2] =   document.getElementById('fjtype').options[document.getElementById('fjtype').selectedIndex].value;
			info[3] =   document.getElementById('tplat').value;
			info[4] =   document.getElementById('tplng').value;
			info[5] = 	document.getElementById('rtom').value;
			info[6] = 	document.getElementById('fjsnumber').value;
			

			$.ajax({
			   type: "POST",
			   data: {info:info},
			   url: "./function.php?q=44",
			   success: function(msg){

				 $("#myModal").modal('hide');
				 swal("Successful", "You created new Fiber Joint!", "success");
				 fjpl.hideDocument();
				 getdata();

			   }
			});

	 }		
});

function deletefjpldata(){  

  var fjNo = document.getElementById("fjNo").value;

  swal({
    title: "Are you sure?",
    text: "Once deleted,Fiber Joint informations will not be able to recover!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("Fiber Joint informations have been deleted", {
        icon: "success",
      });

      $.ajax({
       type: "POST",
       data: {fjNo:fjNo},
       url: "./function.php?q=45",
       success: function(msg){
       fjpl.hideDocument();
       getdata();
       }
    });
	
    } else {
      swal("Your informations are safe!");
    }
  });

}

$(document).on('click','#saveodfdata',function(){
		
		if($('#odfNo').val() == ''){

			swal("", "ODF Number required!", "warning");

			return;

		}else{

			var info =[];
			info[0] =   document.getElementById('odfNo').value;
			info[1] =   document.getElementById('odfleaname').options[document.getElementById('odfleaname').selectedIndex].value;
			info[2] =   document.getElementById('odflblocation').value;
			info[3] =   document.getElementById('odflac').value;
			info[4] =   document.getElementById('odfrnumber').value;
			info[5] = 	document.getElementById('odfshname').value;
			info[6] = 	document.getElementById('odfnumberofct').value;
			info[7] =   document.getElementById('tplat').value;
			info[8] =   document.getElementById('tplng').value;
			info[9] = 	document.getElementById('rtom').value;

			$.ajax({
			   type: "POST",
			   data: {info:info},
			   url: "./function.php?q=46",
			   success: function(msg){

				 $("#myModal").modal('hide');
				 swal("Successful", "You created new Optical Distribution Point!", "success");
				 odfpl.hideDocument();
				 getdata();

			   }
			});

	 }		
});

function deleteodfpldata(){  

  var odfNo = document.getElementById("odfNo").value;

  swal({
    title: "Are you sure?",
    text: "Once deleted,Optical Distribution Point informations will not be able to recover!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("Optical Distribution Point informations have been deleted", {
        icon: "success",
      });

      $.ajax({
       type: "POST",
       data: {odfNo:odfNo},
       url: "./function.php?q=47",
       success: function(msg){
       fjpl.hideDocument();
       getdata();
       }
    });
	
    } else {
      swal("Your informations are safe!");
    }
  });

}

function checkKey(e,location) {

    e = e || window.event;
    
    //arrow key event
    if (e.keyCode == '38' || e.keyCode == '40' || e.keyCode == '37' || e.keyCode == '39' || e.keyCode == '13') {
        //event
    }else{
      getroadname(location);
    }

}

  
function getroadname(location){
  
  var location = location.value;

  $.ajax({

       type: "POST",
       data: {location:location},
       url: "function.php?q=20",
       success: function(result){

        $('#locations').html('');

        $('#locations').html(result);

       }
    });

}


