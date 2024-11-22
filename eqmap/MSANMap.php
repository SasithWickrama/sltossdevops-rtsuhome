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
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>SLTMSAN|Map</title>
	<link rel="icon" type="image/png" href="Login/images/icons/favicon.ico"/>
	<script src="JS/geoxml3.js"></script>
	<script src="JS/walk.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="js/map.js" type="text/javascript"></script>
	<script src="js/createLocation.js" type="text/javascript"></script>
	
	<!-- pop box resource files -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	
	<!-- alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
   html, body {
        height: 100%;
        padding: 0;
        margin: 0;
        }
      #map {
       height: 100%;
       width: 100%;
       overflow: hidden;
       float: left;
       border: thin solid #333;
       }
	   

   #wrapper { position: relative; }
   #over_map { position: absolute; top: 4px; right: 60px; z-index: 99; background-color:rgba(0,0,0,0.6); color:#ffffff;padding:5px; border-radius:5px;font-family: Times New Roman, Times, serif; font-size:11.25px; width:20%;}
   #over_map1 { position: absolute; top: 30%; right: 40%; z-index: 99; background-color:#FFF;padding:5px;width: 20%; height: 40%; overflow: auto; overflow-x: hidden;}
    #over_map3 { position: absolute; top: 10px; right: 25%; z-index: 99; background-color:#FFF;padding:5px; border-radius:5px;font-family: Times New Roman, Times, serif; font-size:11px; width:60%}

   #btn_logout { position: absolute; top: 5%; right: 4%; z-index: 99; padding:12px; color:#ffffff;}
	
  .btn:focus, .btn:active, button:focus, button:active {

    outline: none !important;
    box-shadow: none !important;

  }

  #image-gallery .modal-footer{

    display: block;

  }

  .thumb{

    margin-top: 15px;
    margin-bottom: 15px;

  }
  
/*----- waiting window styles------- */

	#loading-div-background 
	{
		display:none;
		position:fixed;
		top:0;
		left:0;
		background:black;
		width:100%;
		height:100%;
	 }
	 
	 #loading-div
	{
		 width: 300px;
		 height: 200px;
		 background-color: #0c0b0b;
		 text-align:center;
		 position:absolute;
		 left: 50%;
		 top: 50%;
		 margin-left:-150px;
		 margin-top: -100px;
	 }
      
    </style>
  </head>
  <body>
<span class="metadata-marker" style="display: none;" data-region_tag="html-body"></span>    

<div id="map"></div>
   
<script>

	var msan;
 
</script>
	
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACf3KGqbKylkAoI4MkjKTdwlbdoCMD-rY&libraries=drawing&callback=initMap">
    </script>
	
	<div id="wrapper">
   <div id="google_map">

   </div>

  

<div id="over_map3" class="box-body" style="display:none">

	<div class="form-group">
		<div class="inline col-md-12">
		 <div class="col-md-4 text-left">
			<label style="font-size: 12px;" id="lblgreen"></label>&nbsp;
			<img src="img/green-ball.ico" width="15"  height="15">	
		</div>

		<div class="col-md-4 text-left">
			<label style="font-size: 12px;" id="lblblue"></label>&nbsp;
			<img src="img/orange_boll.png" width="15"  height="15">		
		</div>

		<div class="col-md-4 text-left">
			<label style="font-size: 12px;" id="lblred"></label>&nbsp;
			<img src="img/red.png" width="15"  height="15">		
		</div>


	</div>
	</div>



</div>



<div id="over_map" class="box-body">

	<div class="form-group">
		<!--<h4 style="text-align:center">MSAN MAP</h4>
		<hr style="border: 1px solid #ffffff;"/>-->
	</div>
	 
	<div class="form-group">
		<label>MAP TYPE</label>
		<select class="form-control" id="maptype" name="maptype">
			<option value="msan">MSAN WISE</option>
			<option value="dp">DP WISE</option>
		</select>
	</div>
	 
	
	 <div class="form-group">
		<label>FAULT TYPES</label>	
	 </div>
	 
	 <div class="form-group-sm">
		<input type="checkbox"  id="radios-0" value="poles">
		<label>MSAN PORT</label>	
	 </div>
	 
	 
	 
	 <div class="form-group-sm">
		<input type="checkbox"  id="radios-1" value="duct">
		<label>CPE ISSUE</label>
	 </div>
	 
	 <div class="form-group-sm">
	  <input type="checkbox"  id="radios-2" value="manholes">
	  <label>UG FACT</label>	
	 </div>
	 
	 <hr/>
	 
	 <div class="form-group-sm">
		<label>SERVICE TYPES</label>	
	 </div>
	 
	  <div class="form-group-sm">
	  <input type="checkbox"  id="radios-3" value="manholes">
	  <label>PSTN</label>	
	 </div>
	 
	  <div class="form-group-sm">
	  <input type="checkbox"  id="radios-4" value="manholes">
	  <label>IPTV</label>	
	 </div>
	 
	  <div class="form-group-sm">
	  <input type="checkbox"  id="radios-5" value="manholes">
	  <label>FTTH</label>	
	 </div>
	 
	 <div class="form-group-sm">
	  <input type="checkbox"  id="radios-6" value="manholes">
	  <label>ADSL</label>	
	 </div>
	 
	 <div class="form-group-sm">
	  <input type="checkbox"  id="radios-7" value="manholes">
	  <label>DATA</label>	
	 </div>
	 

	<button type="button" id="getdata" onclick="loaddata()" class="btn btn-warning btn-md">Get Data</button>

   </div>
   
</div>

<!-- img popup box -->
    <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                        <input type="text" id="imgNo" style="display: none;" />
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary full-left" id="delete-image"><i class="glyphicon glyphicon-trash"></i>
                        </button>

                        <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                        </button>

                        <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>

<!-- end img popup box -->


<div id="over_map1" style="visibility: hidden;  border: 0.5px solid red;  border-radius: 25px;" >

 <div class="modal-header">
          <button type="button" class="close" id="btnclose" onclick="exit();">&times;</button>
          <h6 class="modal-title" style="color: red; text-align: center; font-weight: bold;"><span class="glyphicon glyphicon-exclamation-sign"></span><br>Following Informations Are Not Available This<p id="rtomname"></p> </h6>
        </div>
  <div class="row">
    <ul type="circle" id="errbox">
      
    </ul>
  </div>

</div>


<!-- popup box -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" id="frm_body">

            </div>
        </div>
    </div>
</div>

<!-- end popup box -->

<!-- waiting dialog popup --->
 <div id="loading-div-background">
    <div id="loading-div" class="ui-corner-all" >
      <img style="height:80px;margin:30px;" src="img/loading.gif" alt="Loading.."/>
      <h2 style="color:gray;font-weight:normal;">Please wait....</h2>
     </div>
</div>

<!-- end popup box -->

  </body>
</html>