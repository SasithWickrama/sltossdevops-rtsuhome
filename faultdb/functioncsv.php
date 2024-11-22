<?php 
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
    $user = $_SESSION['$UID'];
	$rtom=$_SESSION['rtom'];
	
	if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null   ){	
	echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
	}
}
else 
{     
    echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
}
date_default_timezone_set("Asia/Colombo");


function OracleConnection(){

	$db = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = prxd1-scan)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = HADWH)
    ) )" ;


	if($c = oci_connect("JASREP", "slt#jasrep", $db))
	{
		return $c;
	}
	else
	{
	   $err = OCIError();
	   echo "<script type='text/javascript'>alert('Connection failed')</script>";
	}
	
}


 if(isset($_POST["submitData"])){
         
          header('Content-Type: text/csv; charset=utf-8');  
          header('Content-Disposition: attachment; filename=pending_fault_all.csv');  
          $output = fopen("php://output", "w"); 
          
          fputcsv($output, array('PROM_NUMBER','PROM_WORG_NAME','CIRT_DISPLAYNAME','SERVICE_TYPE', 'PROM_PRIORITY')); 

          $con = OracleConnection();
          $query = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,CIRT_SERT_ABBREVIATION,PROM_PRIORITY FROM OSS_FAULTS.REALTIME_FAULTS  
						WHERE PROM_CLEARED IS NULL AND  ( CIRT_SERT_ABBREVIATION in ('AB-CAB' ,'V-VOICE COPPER','BB-INTERNET COPPER','ADSL','E-IPTV COPPER','V-VOICE','BB-INTERNET') 
						OR CIRT_SERT_ABBREVIATION LIKE 'D-%' OR CIRT_SERT_ABBREVIATION LIKE '%FTTH')
						AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA 
						WHERE RTOM_CODE = '$rtom')"; 
          $stid=oci_parse($con,$query);
          oci_execute($stid);

                  while($row = oci_fetch_array($stid))  
                  {  
                   // fputcsv($output, $row);
                    fputcsv($output, array($row[0],$row[1],$row[2],$row[3],$row[4]));

                  }
                  fclose($output); 
          }



?>