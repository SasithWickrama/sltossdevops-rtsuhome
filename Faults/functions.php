<?php

	 ini_set('max_execution_time', 36000);
	   ini_set('memory_limit', '1024M'); 
	 
$q =  $_GET["q"];
$r =  $_GET["r"];
$s =  $_GET["s"];
$u =  $_GET["u"];

function connecttooracle(){
	 $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )" ;
  
    if($c = oci_connect("ossprg", "prgoss456", $db))
    {
		return $c;
    }
    else
    {
        $err = OCIError();
        echo "Connection failed." . $err[text];
    }
}


$CON = connecttooracle();

date_default_timezone_set('Asia/colombo');
$nowmonth = date("m");


if($q == 'region'){
	$result = null;
	if($r=='ALL'){
		$sql = "SELECT DISTINCT PROVINCE  FROM OSSRPT.SLT_AREA";
	}else{
		$y = str_replace('*','&',$r);
	$sql = "SELECT DISTINCT PROVINCE  FROM OSSRPT.SLT_AREA  WHERE REGIONS = '$y'";
	$result = "ALL@";
	}
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);


while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);


}

if($q == 'province'){
	$result = null;
	if($r=='ALL'){
		$sql = "SELECT DISTINCT RTOM_CODE  FROM OSSRPT.SLT_AREA  WHERE REGIONS = '$s'";
		
	}else{
		$y = str_replace('*','&',$r);
	$sql = "SELECT DISTINCT RTOM_CODE  FROM OSSRPT.SLT_AREA  WHERE PROVINCE= '$y'";
	$result = "ALL@";
	}
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);

}


if($q == 'province2'){
	$result = null;
	if($r=='ALL'){
		$sql = "SELECT DISTINCT OPMC_NAME  FROM OSSRPT.SLT_AREA  WHERE REGIONS = '$s'";
		
	}else{
		$y = str_replace('*','&',$r);
	$sql = "SELECT DISTINCT OPMC_NAME  FROM OSSRPT.SLT_AREA  WHERE PROVINCE= '$y'";
	$result = "ALL@";
	}
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);

}


if($q == 'rtom'){
	$result = null;
	if($r=='ALL'){
		$sql = "SELECT DISTINCT LEA_CODE  FROM OSSRPT.SLT_AREA WHERE PROVINCE= '$s'";
	}else{
	$sql = "SELECT DISTINCT LEA_CODE  FROM OSSRPT.SLT_AREA  WHERE RTOM_CODE = '$r'";
	$result = "ALL@";
	}
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);

}



if($q == 'opmc'){
	$result = null;
	if($r=='ALL'){
		$sql = "SELECT DISTINCT LEA_CODE  FROM OSSRPT.SLT_AREA WHERE PROVINCE= '$s'";
	}else{
	$sql = "SELECT DISTINCT LEA_CODE  FROM OSSRPT.SLT_AREA  WHERE OPMC_NAME  = '$r'";
	$result = "ALL@";
	}
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);

}



if($q == 'comment'){
	$result = null;
	
	$sql = "INSERT INTO OSSPRG.YDAY_CLER_FLTS_CALLBACK (
   FAULT_ID, DTIME, DISCRIPTION) 
VALUES ('$s',SYSDATE,'$r')";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

	$sql = "UPDATE ossprg.YDAY_CLER_FLTS SET STATUS = '1' WHERE PROM_NUMBER = '$s'";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);


oci_free_statement($stid);

}


if($q == 'getcomment'){
	$result = null;
	
	$sql = "SELECT *  FROM OSSPRG.YDAY_CLER_FLTS_CALLBACK WHERE FAULT_ID = '$s' ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 2))."#".oci_result($stid,oci_field_name($stid, 3))."@";	
}
	

oci_free_statement($stid);

}








else if($q == 'TABLE'){
	
	
		$day= " BETWEEN TO_DATE ('$s 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') AND  TO_DATE ('$s 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
		
			$y = str_replace('*','&',$r);
	$sql = "SELECT DISTINCT OPMC_NAME,LEA_CODE,PROM_NUMBER, CIRCUIT,REPORTED_TIME,CLEARED_TIME,ROUND((CLEARED_TIME- REPORTED_TIME)*24,2),PROBLEM_REPORTED_CONTACT,PROM_REPORTEDBY,
 STATUS FROM YDAY_CLER_FLTS 
WHERE CLEARED_TIME  $day
AND SERVICE = '$u'
AND LEA_CODE IN (SELECT  LEA_CODE FROM OSSRPT.SLT_AREA $y
order by CLEARED_TIME ASC ";


 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result = $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))
 .",".oci_result($stid,oci_field_name($stid, 3)).",".oci_result($stid,oci_field_name($stid, 4))
 .",".oci_result($stid,oci_field_name($stid, 5)).",".oci_result($stid,oci_field_name($stid, 6))
 .",".oci_result($stid,oci_field_name($stid, 7)).",".oci_result($stid,oci_field_name($stid, 8))
 .",".oci_result($stid,oci_field_name($stid, 9)).",".oci_result($stid,oci_field_name($stid, 10))."@";	
}
				 
oci_free_statement($stid);


}

echo $result;
?>
