<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
    $user = $_SESSION['$UID'];
  $opmc=$_SESSION['opmc'];
  
  if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null   ){ 
  echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
  }
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
//set_time_limit(300);
ini_set('max_execution_time',300);

include 'dbcon.php';

if (!$CON) 
{
  die('Not connected : ' );
}


$q = $_GET['q'];




if ($q == "1" ){

$info = $_POST['info'];
$ser = $_POST['serv'];

$totcount=0;
$countstring="";
$result="";

$checkCount = sizeof($info);

  for($n=0; $n<$checkCount; $n++){

    if($info[$n] == 'MSAN'){
    if($countstring == ""){
      $countstring  = "nvl(SUM(MSAN_PORT_ISSUES),0)";
    }else{
      $countstring = $countstring ." +nvl(SUM(MSAN_PORT_ISSUES),0)";
    }
    
    }
    
    if($info[$n] == 'CPE'){
    if($countstring == ""){
      $countstring  = " nvl(SUM(CPE_ISSUES),0)";
    }else{
      $countstring = $countstring ." +nvl(SUM(CPE_ISSUES),0)";
    }
    
    }
    
    if($info[$n] == 'UG'){
    if($countstring == ""){
      $countstring  = " nvl(SUM(UG_FAULTS),0)";
    }else{
      $countstring = $countstring ." + nvl(SUM(UG_FAULTS),0)";
    }
    
    }

  }

$sql="SELECT X.*   FROM (
SELECT DISTINCT LOCN_TTNAME ,LOCN_X,LOCN_Y,nvl(SUM(FAULTS_REPORTED),0) 
AS FAULTS_REPORTED,nvl(SUM(FAULTS_REPORTED_WITHOUT_REPEAT),0) AS FAULTS_REPORTED_WITHOUT_REPEAT, nvl(SUM(MSAN_PORT_ISSUES),0)
AS MSAN_PORT_ISSUES,nvl(SUM(CPE_ISSUES),0) AS CPE_ISSUES, nvl(SUM(UG_FAULTS),0) AS  UG_FAULTS,
".$countstring."  TOTAL_FAULT_COUNT 
FROM FRAME_UNITS FU, FRAME_CONTAINERS FC , FRAME_APPEARANCES fa ,RTSU_DP nc , LOCATIONS l
WHERE FU.FRAU_FRAC_ID = FC.FRAC_ID
and fu.FRAU_ID = fa.FRAA_FRAU_ID
AND fc.FRAC_FRAN_NAME IN ( 'DP','FDP')
AND fa.FRAA_SIDE = 'REAR'
AND FC.FRAC_LOCN_TTNAME = L.LOCN_TTNAME
AND FU.FRAU_NAME = DP
AND MOPMC = '".$opmc."'
AND SERVICE_TYPE IN (".$ser.")
    AND LOCN_X IS NOT NULL
GROUP BY LOCN_TTNAME,LOCN_X,LOCN_Y)X
    ORDER BY TOTAL_FAULT_COUNT";
 

  $stid=oci_parse($CON,$sql);
  $stid1=oci_parse($CON,$sql);
 
  oci_execute($stid);
  oci_execute($stid1);
  
  $numberofrows = oci_fetch_all($stid1, $res); 
  oci_free_statement($stid1);
  
  $first = $numberofrows *20/100;
  $sec = $numberofrows *80/100;
  $firstval ="";
  $secval="";

  
  $ccount =0;

  while ($row=oci_fetch_array($stid)) {
	  
	$totcount=0;
	$ccount++;
  
  
  $checkCount = sizeof($info);

	for($n=0; $n<$checkCount; $n++){
			
		if($info[$n] == 'MSAN'){

			$totcount += $row['MSAN_PORT_ISSUES'];
		
		}
		
		if($info[$n] == 'CPE'){
		
			$totcount += $row['CPE_ISSUES'];
		
		}
		
		if($info[$n] == 'UG'){
		
			$totcount += $row['UG_FAULTS'];
		
		}

	}

  if($ccount < $first)  
  { 	
		$firstval = $totcount; 
  }  
  else {
	  if($ccount == $first){ 

			$firstval = $totcount; 

			
	  }
	  
	  if($ccount == $firstval ){

		 $firstval = $totcount; 
		 
	  }else{
		  
		  if($ccount < $sec) 
		  { 
 
			$secval = $totcount; 
			
		  }else {
			  
			if($ccount == $sec){ 
			
			$secval = $totcount; 
			
			}
				
		  }
	  }
  }
  
} 
  
  $result.=$firstval.','.$secval;

	
}


if ($q == "2" ){
	
	
$info = $_POST['info'];
$ser = $_POST['serv'];
	
$totcount=0;
$countstring ="";
$result="";


$checkCount = sizeof($info);

	for($n=0; $n<$checkCount; $n++){

		if($info[$n] == 'MSAN'){
		
			$countstring = " nvl(SUM(MSAN_PORT_ISSUES),0)";
		
		}
		
		if($info[$n] == 'CPE'){
		
			$countstring = $countstring ." +nvl(SUM(CPE_ISSUES),0)";
		
		}
		
		if($info[$n] == 'UG'){
		
			$countstring = $countstring ." + nvl(SUM(UG_FAULTS),0)";
		
		}

	}
	

$sql="SELECT X.*   FROM (
SELECT DISTINCT LOCATION ,LOCN_X,LOCN_Y,nvl(SUM(CUSTOMER_BASE),0) AS CUSTOMER_BASE,nvl(SUM(FAULTS_REPORTED),0) 
AS FAULTS_REPORTED,nvl(SUM(FAULTS_REPORTED_WITHOUT_REPEAT),0) AS FAULTS_REPORTED_WITHOUT_REPEAT, nvl(SUM(MSAN_PORT_ISSUES),0)
 AS MSAN_PORT_ISSUES,nvl(SUM(CPE_ISSUES),0) AS CPE_ISSUES, nvl(SUM(UG_FAULTS),0) AS  UG_FAULTS,
 ".$countstring." TOTAL_FAULT_COUNT 
    FROM RTSU_MSAN , LOCATIONS
    WHERE MOPMC = '".$opmc."'
    AND SERVICE_TYPE IN (".$ser.")
    AND LOCATION = LOCN_TTNAME
    AND LOCN_X IS NOT NULL
    GROUP BY LOCATION,LOCN_X,LOCN_Y) X
    ORDER BY TOTAL_FAULT_COUNT ";
	
	
	  
	$stid=oci_parse($CON,$sql);
	$stid1=oci_parse($CON,$sql);
	oci_execute($stid);
	oci_execute($stid1);
	
	//oci_fetch_all($stid1, $array);
	//unset($stid1);
	$numberofrows = oci_fetch_all($stid1, $res); //oci_num_rows($stid);
	oci_free_statement($stid1);
	
	$first = $numberofrows *20/100;
	$sec = $numberofrows *80/100;

	$firstval="";
	$secval="";
	
	
	
  $ccount =0;

  while ($row=oci_fetch_array($stid)) {
	  
	  
  $totcount=0;
  $ccount++;
  
  $checkCount = sizeof($info);

	for($n=0; $n<$checkCount; $n++){

		if($info[$n] == 'MSAN'){
		
			$totcount += $row['MSAN_PORT_ISSUES'];
		
		}
		
		if($info[$n] == 'CPE'){
		
			$totcount += $row['CPE_ISSUES'];
		
		}
		
		if($info[$n] == 'UG'){
		
			$totcount += $row['UG_FAULTS'];
		
		}

	}
	
	
	
	  if($ccount < $first)  
  { 	
		$firstval = $totcount; 
  }  
  else {
	  if($ccount == $first){ 

			$firstval = $totcount; 

			
	  }
	  
	  if($ccount == $firstval ){

		 $firstval = $totcount; 
		 
	  }else{
		  
		  if($ccount < $sec) 
		  { 
 
			$secval = $totcount; 
			
		  }else {
			  
			if($ccount == $sec){ 
			
			$secval = $totcount; 
			
			}
				
		  }
	  }
  }
  
  
  
  }
  
   $result.=$firstval.','.$secval;
	
}

echo $result;
?>