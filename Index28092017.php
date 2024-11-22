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
  <div >
    <div align="center"style="padding-top:10px; font-size:40px; color:#FF8000" >
      <p>Regional Tech Support Unit</p>
	  
    </div>
  </div>
  <div>
  <div align="center"  style="padding-top:5px; padding-left:2%" >
  
	<table>
	<tr style="height:100px">
	<td style="width:300px;"><a href="MSANVEHICLE/msanvehicle.php" target="_blank">
		<img src="Image/msanvehicle.jpg"></a></td>
	<td style="width:300px;"><a href="MSANVEHICLE/caevehicle.php" target="_blank">
		<img src="Image/ceavehicle.jpg"></a></td>
		<td style="width:300px;"><a href="MSANVEHICLE/ltevehicle.php" target="_blank">
		<img src="Image/ltevehicle.jpg"></a></td>
	<td><a href="ftthnewcon/ftthncon.html" style="text-decoration : none; color : #6D99E5; font-size: 12px;" target="_blank">
		<img  src="Image/ftthnc.png" height="70" width="70" ><p>Quality Inspection for<p></p>FTTH New Connection</p></a></td>
	
<td></td>
	</tr>

	<tr style="height:100px">
	<td style="width:300px;"><a href="RTSU/RTSU_List.php" target="_blank">
		<img src="Image/pennewcon.jpg"></a></td>
	<td style="width:300px;"><a href="faultdb/main.php" target="_blank">
		<img src="Image/fault.jpg"></a></td>
	<td style="width:300px;"><a href="feedback/customer.html" target="_blank">
		<img src="Image/sacs.png"></a></td>
		<td></td>
	</tr>
	
	<tr style="height:100px">
	<td><a href="DP/fiberdp.php" target="_blank">
		<img src="Image/fiberdp.jpg"></a></td>
	<td><a href="DP/copperdp.php" target="_blank">
		<img src="Image/copperdp.jpg"></a></td>
		<td><a href="NCfeedback/customer.html" target="_blank">
		<img src="Image/sfcs.png"></a></td>
		<td></td>
	</tr>
	
<tr style="height:100px">
	
	<td><a href="Faults/yfaults.html" style="text-decoration : none; color : #6D99E5; font-size: 12px;" target="_blank">
		<img  src="Image/callus.png" height="80" width="80" ><p>Cleared Faults <p></p>Callback Verification</p></a></td>
	
<td><a href="../QualityMonitor/login.html" style="text-decoration : none; color : #6D99E5; font-size: 12px;" target="_blank">
		<img src="Image/construction_worker.png" height="100" width="100"><p>Service Assurance  <p></p>Contractor Team Readiness</p></a></td>
	<td><a href="../QualityINS/login.html" style="text-decoration : none; color : #6D99E5; font-size: 12px;" target="_blank">
		<img src="Image/Qins.PNG"><p>Service Assurance Field  <p></p>team quality check</p></a></td>
	<td><a href="http://172.25.36.252/OPMC_DashBoard/MaterialUsage_WG.aspx" style="text-decoration : none; color : #6D99E5; font-size: 12px;" target="_blank">
		<img src="Image/maintanance.PNG" height="80" width="80" ><p>Material Usage</p></a></td>
	</tr>
	
	
	
	
	</table>
	
    
  </div>
  </div>
  <div>
<p align="center"><span class="style10"><span class="style11">&copy;</span> IT Solution & Implementation</span></br>  2017. All rights reserved.<br />
</div>
</div>
</body>
</html>