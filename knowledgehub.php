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
      <p>RTSU-Knowledge Hub</p>
	  
    </div>
  </div> <div>
  <div align="center"  style="padding-top:5px; padding-left:2%" >
  
	<table style="width: 900px;">
		
<tr style="height: 10px;"></tr>


    <tr >
   
		
        <td style="width:200px;"><a href="http://cc.slt.lk/adslusage/index.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/onlineuser_check.png" height="80" width="100" ><p>LDAP- Online User check and Usage check</p></a></td>
		<td style="width: 300px;"></td>
		<td><a href="http://172.25.16.59/index.php" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img  src="Image/peo.png" height="80" width="80" ><p>PEO TV Customer/Device Management</p></a></td>
	</tr>
    
    
    <tr >
        
        <td><a href="http://acs.slt.com.lk/auth/login?url=%2F" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
        <img src="Image/asc.png" height="80" width="80" ><p>ACS system</p></a></td>	
				
		<td style="width: 300px;"></td>
		<td><a href="http://10.68.74.1/PCRFProvisioningInterface/login.nable" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/pcrf.png" height="80" width="80"><p>PCRF</p></a></td>		
	</tr>
	
	
	<tr >
        
        <td><a href="http://172.25.37.171:8080/bbportal/Login" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
        <img src="Image/userreport.png" height="80" width="80" ><p>user port details with usage</p></a></td>	
				
		<td style="width: 300px;"></td>
		<td><a href="http://10.68.74.4:28080/AdminPortal/admin/home.xhtml?page=usage usage details" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/usage.png" height="80" width="80"><p>SLT VAS admin portal- Usage details</p></a></td>		
	</tr>
	
	
	<tr >
        
        <td><a href="http://gui.sltnet.lk:2001/- password reset" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
        <img src="Image/password.png" height="80" width="80" ><p>BB LDAP Admin GUI- Password reset</p></a></td>	
				
		<td style="width: 300px;"></td>
		<td><a href="http://172.25.17.220/imsportal/login.html" style="text-decoration : none; color : #6D99E5; font-size: 13px;" target="_blank">
		<img src="Image/ims.png" height="80" width="80"><p>IMS portal</p></a></td>		
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
