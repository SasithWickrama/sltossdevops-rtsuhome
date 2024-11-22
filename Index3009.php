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
		
		<td style="width:200px;"><a href="MSANVEHICLE/msanvehicle.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/msan.jpg" height="80" width="80"><p>MSAN<p></p>Vehicle GPS</p></a></td>

		<td style="width:200px;"><a href="MSANVEHICLE/caevehicle.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/cea.png" height="80" width="80"><p>CEA Node<p></p>Vehicle GPS</p></a></td>
		
		<td style="width:200px;"><a href="MSANVEHICLE/ltevehicle.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/4GLTE.png" height="80" width="80"><p>LTE Basestation  <p></p>Vehicle GPS</p></a></td>
		
		<td style="width:200px;"><a href="ftthnewcon/ftthncon.html" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img  src="Image/ftthnc.png" height="80" width="80" ><p>Quality Inspection for<p></p>FTTH New Connection</p></a></td>
		
		<td><a href="../QualityINS/login.html" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/qa.png" height="80" width="100" ><p>Service Assurance Field  <p></p>Team Quality Check</p></a></td>
	
<td></td>
	</tr>

	<tr style="height:100px">
	
	<td style="width:200px;"><a href="RTSU/RTSU_List.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/nc.png" height="80" width="80"><p>Pending<p></p>New Connection</p></a></td>		
		
	<td style="width:200px;"><a href="faultdb/main.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/fault.png" height="80" width="80"><p>Pending<p></p>Fault Summery</p></a></td>			
		
	<td><a href="feedback/customer.html" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/cucsas.png" height="80" width="80"><p>Service Assurence<p></p>Customer Satisfaction</p></a></td>
	
	<td><a href="NCfeedback/customer.html" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/cucful.png" height="80" width="90"><p>Service Fulfillment<p></p>Customer Satisfaction</p></a></td>	
		
	<td><a href="http://serviceportal.slt.lk" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/contractor.png" height="80" width="80" ><p>New Connection<p></p>ontractor management</p></a></td>	
	</tr>
	
	<tr style="height:100px">
	
	<td><a href="DP/fiberdp.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/fdp.png" height="80" width="80"><p>Fiber DP<p></p>Distribution</p></a></td>	
		
		
	<td><a href="DP/copperdp.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/dp.jpg" height="80" width="80"><p>Copper DP<p></p>Distribution</p></a></td>		
	
	<td><a href="Faults/yfaults.html" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img  src="Image/callus.png" height="80" width="80" ><p>Cleared Faults <p></p>Callback Verification</p></a></td>
	
	<td><a href="../QualityMonitor/login.html" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/construction_worker.png" height="80" width="80"><p>Service Assurance  <p></p>Contractor Team Readiness</p></a></td>	
	</tr>
	</tr>
	
<tr style="height:100px">
	
		<td style="width:200px;"><a href="http://172.25.37.227:8080/WFMADMIN" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img  src="Image/wfm.png" height="80" width="80" ><p>WFM Dashboard<p></p>&nbsp;</p></a></td>
	
		<td><a href="http://172.25.36.252/opmc_dashboard/MaterialUsage_WG.aspx" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/maintanance.PNG" height="80" width="80" ><p>Material Usage</p></p>&nbsp;</p></a></td>
		
		<td><a href="http://172.25.36.252/SSD/Default.aspx" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/monitoring.png" height="80" width="80" ><p>Project Monitoring</p></p>&nbsp;</p></a></td>
		
		<td><a href="http://172.25.37.178/essp/Default.aspx" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/sales.png" height="80" width="80" ><p>Sales portal</p></p>&nbsp;</p></a></td>
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