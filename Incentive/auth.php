<?php

session_start();
include 'dbcon.php';



if (!$CON) 
{
  die('Not connected : ' );
}


$uname = $_POST['serviceId']."@intranet.slt.com.lk";
$pwd = $_POST['password'];


$_SESSION['$usrid']= $_POST['serviceId'];

$link = ldap_connect('intranet.slt.com.lk' );

if(! $link )
{
	echo"Cant Connect to Server";
}

ldap_set_option($link, LDAP_OPT_PROTOCOL_VERSION, 3); 

if (ldap_bind( $link, $uname, $pwd ) )
{
	$CON = connecttooracle();
	$sql = "select USER_NAME from RTSU_INCENTIVE_LOGIN  where USER_NAME ='".$_POST['serviceId']."'";
	//echo $sql;
	$userid = oci_parse($CON, $sql);
	oci_execute($userid);
	$row= oci_fetch_array($userid);

   	 if($row[0] == $_POST['serviceId'] )
	 {

	 $_SESSION['$usrname']= $row['USER_NAME'];
	 // $_SESSION['$p_level']= $row['USER_TYPE'];
	 $_SESSION['loggedin'] = true;

		 	echo '<script type="text/javascript"> document.location = "upload.php";</script>';

	  }
	  else
	  {
		echo "<script type='text/javascript'>alert('Not Authorize for this Site')</script>";
		echo '<script type="text/javascript"> document.location = "loginupload.php";</script>';
	  }

}else{
		echo "<script type='text/javascript'>alert('Invalid User Name or Password')</script>";
		echo '<script type="text/javascript"> document.location = "loginupload.php";</script>';
}



?>