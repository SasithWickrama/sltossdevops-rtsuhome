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
      <p>RTSU HOME</p>
	  
    </div>
  </div>
  <div>
  <div align="center"  style="padding-top:5px; padding-left:2%" >
  
	<table>
	<tr style="height:300px">
		
		<td style="width:300px;"><a href="service_ful.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		&nbsp;&nbsp;&nbsp;&nbsp;<img src="Image/Fulfilment.jpg" height="150" width="150"><p style="font-size: 20px;"><u>SERVICE FULFILMENT </u></p></a></td>

		<td style="width:300px;"><a href="service_assu.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="Image/Assurance.jpg" height="150" width="150"><p style="font-size: 20px;"><u>SERVICE ASSURANCE</u></p></a></td>
		
		<td style="width:300px;"><a href="wfm_gps.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="Image/GPS.jpg" height="150" width="150"><p style="font-size: 20px;"><u>GPS BASED APPLCIATIONS</u></p></a></td>
		
		<td style="width:200px;"><a href="wfm.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="Image/WFM.jpg" height="150" width="150"><p style="font-size: 20px;"><u>WFM & MATERIAL UPDATE</u></p></a></td>
	</tr>

	
    <tr style="height:300px">
		
		
		<td style="width:200px;"><a href="support.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		&nbsp;&nbsp;&nbsp;&nbsp;<img src="Image/Support.jpg" height="150" width="150"><p style="font-size: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>SUPPORT</u></p></a></td>
		
		<td style="width:200px;"><a href="other.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		&nbsp;&nbsp;&nbsp;&nbsp;<img src="Image/Other.jpg" height="150" width="150"><p style="font-size: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>OTHER</u></p></a></td>
		
		<td style="width:200px;"><a href="knowledgehub.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		&nbsp;&nbsp;&nbsp;&nbsp;<img src="Image/knowledge.png" height="150" width="150"><p style="font-size: 20px;">&nbsp;<u>RTSU_Knowledge Hub</u></p></a></td>
		
		<td style="width:200px;"></td>
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
