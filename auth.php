<?php

include 'env_data.php';

session_start();
// function OracleConnection(){
//       $db = 	 $db = "  (DESCRIPTION =
//     (ADDRESS_LIST =
//       (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
//     )
//     (CONNECT_DATA = (SID=clty))
//   )
// " ;

//     if($c = oci_connect("OSSRPT", "ossrpt123", $db))
//     {
//             return $c;

//     }
//     else
//     {
//         echo "<script type='text/javascript'>alert('Connection failed')</script>";
//     }
// }

function OracleConnection($db_host,$username,$password){
      $db = 	 $db = $db_host;

    if($c = oci_connect($username, $password, $db))
    {
            return $c;

    }
    else
    {
        echo "<script type='text/javascript'>alert('Connection failed')</script>";
    }
}


// function validate_user($usr,$pwd)
function validate_user($usr,$pwd,$db_host,$username,$password)
{
    $sql = "select a.USER_NAME,a.OPMC_NAME,b.RTOM,b.LATI,b.LONGI,b.MAP_SIZE
			from RTOM_LOGIN a, RTOM_GPS b
			where a.RTOM_CODE = b.RTOM
			and  a.USER_NAME = '$usr'
			and a.PASSWD = '$pwd'";
			
    // $oraconn = OracleConnection();
    $oraconn = OracleConnection($db_host,$username,$password);
    $user = oci_parse($oraconn, $sql);
    if ( oci_execute($user))
    {
    return $user;
    }
    else
    {
        $err = oci_error($user);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

};


$uname = $_POST['txtUsername']."@intranet.slt.com.lk";
$pwd = $_POST['txtPassword'];

$_SESSION['$UID']= $_POST['txtUsername'];
// $auth = validate_user($_POST['txtUsername'],$pwd);
$auth = validate_user($_POST['txtUsername'],$pwd,$db_host1, $username1, $password1);
$row=oci_fetch_array($auth);
$_SESSION['opmc'] = $row[1];
$_SESSION['rtom'] = $row[2];
$_SESSION['lati'] = $row[3];
$_SESSION['longi'] = $row[4];
$_SESSION['size']= $row[5];
if($row[0]==$_POST['txtUsername'])
{
		 $_SESSION['loggedin'] = true;
		 echo '<script type="text/javascript"> document.location = "Indexnew.php";</script>';
		 
}
else
{
				echo "<script type='text/javascript'>alert('Sorry, your not authorized for this site')</script>";
                echo '<script type="text/javascript"> document.location = "login.html";</script>';
}

?>