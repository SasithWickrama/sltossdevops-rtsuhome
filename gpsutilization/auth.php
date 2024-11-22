<?php

session_start();
function connecttooracle(){
	 $db = $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )
";
  
    if($c = oci_connect("ossrpt", "ossrpt123", $db))
    {
		return $c;
    }
    else
    {
        $err = OCIError();
        echo "Connection failed." . $err[text];
    }
}

$uname = $_POST['txtUsername']."@intranet.slt.com.lk";
$pwd = $_POST['txtPassword'];



$_SESSION['$usrid']= $_POST['txtUsername'];

$link = ldap_connect( 'intranet.slt.com.lk' );
if( ! $link )
{
	echo"Cant Connect to Server";
}
ldap_set_option( $link, LDAP_OPT_PROTOCOL_VERSION, 3 ); 
if (  ldap_bind( $link, $uname, $pwd ) )
{

	$CON = connecttooracle();
	$sql = "select USER_ID,AREA from FDP_USERS
  where USER_ID  ='".$_POST['txtUsername']."' ";
	//echo $sql;
	$userid = oci_parse($CON, $sql);
	oci_execute($userid);
	$row= oci_fetch_array($userid);
   	 if($row[0] == $_POST['txtUsername'] )
	 {
		
			$_SESSION['$usrid']= $row[0];
			$_SESSION['loggedin'] = true; 
			$_SESSION['area'] = $row[1];
	  		echo '<script type="text/javascript"> document.location = "customer.php";</script>';
		
	  
	  }
	  else
	  {
		echo "<script type='text/javascript'>alert('Not Authorize for this Site')</script>";
		echo '<script type="text/javascript"> document.location = "login.html";</script>';
	  }
}else{
		echo "<script type='text/javascript'>alert('Invalid User Name or Password')</script>";
		echo '<script type="text/javascript"> document.location = "login.html";</script>';
}


?>