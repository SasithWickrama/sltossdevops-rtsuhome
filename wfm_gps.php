<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
 $user =$_SESSION['$UID'];
} 
else{
    echo "<script type='text/javascript'>location.href = 'login.html';</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="600" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RTSU Portal</title>

</head>
<style style="text/css">
HTML {
  background: url('Image/rtsu.jpg');
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  width: 100%;
  height: 100%;
  position: relative;
}

body {
  width: 100%;
  min-height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  margin: 0;
  background: rgba(255, 255, 255, .8);
}
</style>

    <style type="text/css">
.style1 {
	width: 300px;
	height: 64px;
}
.style2 {
	width: 124px;
}
.style3 {
	width: 124px;
	height: 23px;
}
.style4 {
	height: 23px;
	width: 207px;
}
.style5 {
	width: 207px;
}
.style6 {
	font-weight: bold;
}
.style7 {
	width: 124px;
	font-weight: bold;
}
.style8 {
	width: 124px;
	font-weight: bold;
	height: 26px;
}
.style9 {
	width: 207px;
	height: 26px;
}
    .style10 {
	color: #FF0000;
	font-weight: bold;
}
    .style11 {color: #000000}
    </style>
 <body> 
<div >
<br />
  <div >
    <div align="center"style="padding-top:10px; font-size:40px; color:#FF8000" >
      <p>GPS BASED APPLCIATIONS</p>
	  
    </div>
  </div>   <div>
  <div align="center"  style="padding-top:5px; padding-left:2%" >
  
	<table style="width: 800px;">

<tr style="height: 10px;"></tr>


    <tr >
    <td style="width:200px;"><a href="MSANVEHICLE/msanvehicle.php" style="text-decoration : none; color : #6D99E5; font-size: 15px;" target="_blank">
		<img src="Image/msan.jpg" height="80" width="80"><p>MSAN Vehicle GPS</p></a></td>
    <td style="width: 300px;"></td>
<td style="width:200px;"><a href="MSANVEHICLE/caevehicle.php" style="text-decoration : none; color : #6D99E5; font-size: 15px;" target="_blank">
		<img src="Image/cea.png" height="80" width="80"><p>CEA Node Vehicle GPS</p></a></td>
    
    
	</tr>

    
     <tr >
    <td style="width:200px;"><a href="MSANVEHICLE/ltevehicle.php" style="text-decoration : none; color : #6D99E5; font-size: 15px;" target="_blank">
		<img src="Image/4GLTE.png" height="80" width="80"><p>LTE Basestation Vehicle GPS</p></a></td>
    <td style="width: 300px;"></td>
	<td><a href="DP/fiberdp.php" style="text-decoration : none; color : #6D99E5; font-size: 15px;" target="_blank">
		<img src="Image/fdp.png" height="80" width="80"><p>Fiber DP Distribution</p></a></td>	
	
	</tr>
    
     <tr >
    <td><a href="DP/copperdp.php" style="text-decoration : none; color : #6D99E5; font-size: 15px;" target="_blank">
		<img src="Image/dp.jpg" height="80" width="80"><p>Copper DP Distribution</p></a></td>	
	<td style="width: 300px;"></td>
	<td><a href="DP/faultdp.php" style="text-decoration : none; color : #6D99E5; font-size: 15px;" target="_blank">
		<img src="Image/faultdp.jpg" height="80" width="80"><p>Fault DP Distribution</p></a></td>
	
	</tr>
	
	 <tr >
    <td><a href="eqmap/MSANMap.php" style="text-decoration : none; color : #6D99E5; font-size: 15px;" target="_blank">
		<img src="Image/msanmap.png" height="80" width="80"><p>MSAN & DP Wise Fault Analyzis</p></a></td>	
	<td style="width: 300px;"></td>
	<td></td>
	
	</tr>

	</table>
	
    
  </div>
  </div>
  <div>
<p align="center"><span class="style10"><span class="style11">&copy;</span> IT Solution & Devops</span></br>  2019. All rights reserved.<br />
</div>
</div>
</body>
</html>