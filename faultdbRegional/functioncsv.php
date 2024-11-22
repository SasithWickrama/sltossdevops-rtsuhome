<?php 

include 'env_data.php';

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
  $user = $_SESSION['$UID'];
	$rtom=$_SESSION['rtom'];
	
	if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null   ){	
	  echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
	}
}else{     
  echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
}

date_default_timezone_set("Asia/Colombo");


function OracleConnection($host,$user,$pass){

  $DB_HOST=$host;
	$DB_USERNAME=$user;
	$DB_PASSWORD=$pass;

  try {

    $conn = new PDO("oci:dbname=" . $DB_HOST, $DB_USERNAME, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;

  } catch (PDOException $e) {

    echo "<script type='text/javascript'>alert('Connection failed')</script>";
    // print "Error: " . $e->getMessage();

  }
	
}


if(isset($_POST["submitData"])){
         
  header('Content-Type: text/csv; charset=utf-8');  
  header('Content-Disposition: attachment; filename=pending_fault_all.csv');  
  $output = fopen("php://output", "w"); 
          
  fputcsv($output, array('PROM_NUMBER','PROM_WORG_NAME','CIRT_DISPLAYNAME','SERVICE_TYPE', 'PROM_PRIORITY')); 

  $con = OracleConnection($db_host1,$username1,$password1);
  $sql = "  SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,CIRT_SERT_ABBREVIATION,PROM_PRIORITY 
            FROM RTSU_NOT_CLEARED_FAULTS_UPDATE  
            WHERE ( CIRT_SERT_ABBREVIATION in ('AB-CAB' ,'V-VOICE COPPER','BB-INTERNET COPPER','ADSL','E-IPTV COPPER','V-VOICE','BB-INTERNET') 
            OR CIRT_SERT_ABBREVIATION LIKE 'D-%' OR CIRT_SERT_ABBREVIATION LIKE '%FTTH')
            AND  RTOM_CODE = ?"; 

  $con_query =  $con->prepare($sql);

  try{

    if($con_query->execute([$rtom]))
    {

      $printoutputs = $con_query->fetchAll(PDO::FETCH_ASSOC);
      foreach ($printoutputs as $printoutput) {
        fputcsv($output, array($printoutput['PROM_NUMBER'],$printoutput['PROM_WORG_NAME'],$printoutput['CIRT_DISPLAYNAME'],$printoutput['CIRT_SERT_ABBREVIATION'],$printoutput['PROM_PRIORITY']));
      }
     
      fclose($output); 
        
    }else{

      echo "<script type='text/javascript'>alert('Error Occured')</script>";

    }

  }catch(PDOException $e){
    echo  $e;

  }
              
  

  
}



?>