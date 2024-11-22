<?php
session_start();
function OracleConnectionLogin(){
       $db = $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )
";
        
    if($c = oci_connect("OSSRPT", "ossrpt123", $db))       
    {
            return $c;
    }
    else
    {
        echo "<script type='text/javascript'>alert('Connection failed')</script>";
    }
}

function validate_user($uname,$passwd)
{
    $sql ="select USER_NAME,RTOM_CODE from RTOM_LOGIN where USER_NAME = '{$uname}' and PASSWD = '{$passwd}'";
    $oraconn = OracleConnectionLogin();
    $auth = oci_parse($oraconn, $sql);
    if(oci_execute($auth))
    {
    return $auth;
    }
    else
    {
        $err = oci_error($auth);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}

$user_name = $_POST["txtUsername"];
$password = $_POST["txtPassword"];


//SLT Domain Login

    $auth = validate_user($user_name,$password);
    $row=oci_fetch_array($auth);
    
    if($row[0]==$user_name)
    {    
                $_SESSION['loggedin'] = true; 
                $_SESSION["user"] = $user_name;
				$_SESSION["area"] = $row[1];
                echo '<script type="text/javascript"> document.location = "RTSU_List.php";</script>';
      
    }
    else
    {
        echo "<script type='text/javascript'>alert('Sorry, your not authorized for this site')</script>";
                echo '<script type="text/javascript"> document.location = "login.html";</script>';
    }


?>
