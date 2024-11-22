
<?php
session_start();
include "DBCon.php";
$uname = $_POST['txtuser']."@intranet.slt.com.lk";
$pwd = $_POST['txtpwd'];

$user_name = $_POST['txtuser'];

$link = ldap_connect( 'intranet.slt.com.lk' );
if( ! $link )
{
	echo"Cant Connect to Server";
}
ldap_set_option( $link, LDAP_OPT_PROTOCOL_VERSION, 3 ); 
if (  ldap_bind( $link, $uname, $pwd ) )
{
    $auth =  oci_fetch_array(validate_user($user_name));
    
    if($auth[0] == $user_name)
    {
   	 $_SESSION['loggedin'] = true;
     $_SESSION["usrid"] = $user_name;
     $_SESSION["opmc"] = $auth[2]; 
     
     echo '<script type="text/javascript"> document.location = "qm.php";</script>';
    }
    else
    {
        echo "<script type='text/javascript'>alert('Not Authorized')</script>";
		echo '<script type="text/javascript"> document.location = "login.html";</script>';
    }
    
     
	  
	  
}else{
		echo "<script type='text/javascript'>alert('Invalid User Name or Password')</script>";
		echo '<script type="text/javascript"> document.location = "login.html";</script>';
}


?>