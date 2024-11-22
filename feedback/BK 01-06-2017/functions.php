<?php

	 ini_set('max_execution_time', 36000);
	   ini_set('memory_limit', '1024M'); 
	 
$q =  $_GET["q"];
$r =  $_GET["r"];
$s =  $_GET["s"];

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


if($q == 'users'){
	$result = null;
	if($r=='ALL'){
		$sql = "SELECT DISTINCT CL_SERNO , CL_NAME  FROM SMS_FEEDBACK  WHERE LEA IN (SELECT  LEA_CODE FROM OSSRPT.SLT_AREA $s) AND CL_SERNO IS NOT NULL";
	}else{
	$sql = "SELECT DISTINCT CL_SERNO , CL_NAME  FROM SMS_FEEDBACK  WHERE LEA  = '$r' AND CL_SERNO IS NOT NULL";
	}
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."#".oci_result($stid,oci_field_name($stid, 2))."@";	
}
				 
oci_free_statement($stid);

}


if($q == 'comment'){
	$result = null;
	
	$sql = "INSERT INTO OSSPRG.SMS_CALLBACK (
   FAULT_ID, DTIME, DISCRIPTION) 
VALUES ('$s',SYSDATE,'$r')";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

	$sql = "UPDATE SMS_FEEDBACK SET STATUS = '2' WHERE FAULT_ID = '$s'";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);


oci_free_statement($stid);

}


if($q == 'getcomment'){
	$result = null;
	
	$sql = "SELECT *  FROM OSSPRG.SMS_CALLBACK WHERE FAULT_ID = '$s' ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 2))."#".oci_result($stid,oci_field_name($stid, 3))."@";	
}
	

oci_free_statement($stid);

}











else if($q == 'CHART'){
	
	if($s == '1'){
		$day= "TRUNC(SYSDATE) - 30";
	}
	else{
		$day= " TO_DATE ('12/10/2016 11:03:48 AM','mm,dd,yyyy:hh:mi:ss pm')";
	}
	
	if($r == 'ALL'){
		$sql = "SELECT FB_VALUE, NVL(COUNT(DISTINCT FAULT_ID),'0')  FROM  SMS_FEEDBACK , FB_VALUES
WHERE FEEDBACK(+) = FB_VALUE AND SMS_DATE >  $day
GROUP BY FB_VALUE
ORDER BY FB_VALUE desc ";
	}
	else{
		$y = str_replace('*','&',$r);
	$sql = "SELECT FB_VALUE, NVL(COUNT(DISTINCT FAULT_ID),'0')  FROM (
SELECT *  FROM SMS_FEEDBACK
WHERE LEA IN (SELECT  LEA_CODE FROM OSSRPT.SLT_AREA $y AND SMS_DATE >  $day) , FB_VALUES
WHERE FEEDBACK(+) = FB_VALUE
GROUP BY FB_VALUE
ORDER BY FB_VALUE desc ";
	}
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))."@";	
}
				 
oci_free_statement($stid);
}



else if($q == 'TABLE'){
	
	if($s == '1'){
		$day= "TRUNC(SYSDATE) - 30";
	}
	else{
		$day= " TO_DATE ('12/10/2016 11:03:48 AM','mm,dd,yyyy:hh:mi:ss pm')";
	}
	
		if($r == 'ALL'){
				$sql = "SELECT distinct OPMC ,FAULT_ID ,  FEEDBACK , PROM_REPORTED , 
PROM_CLEARED, ROUND(( PROM_CLEARED- PROM_REPORTED)*24,2)  ,CUS_MOBILE ,WORK_GROUP ,CL_NAME ,CL_SERNO,
C.CIRT_DISPLAYNAME,STATUS,IN_DATE
FROM SMS_FEEDBACK , PROBLEMS P, PROBLEM_LINKS pl , CIRCUITS C
WHERE FEEDBACK IS NOT NULL
and PL.PROL_PROM_NUMBER = FAULT_ID
AND PL.PROL_FOREIGNID = C.CIRT_NAME
AND PROM_NUMBER = FAULT_ID
and PROM_CLEARED >  $day
order by PROM_CLEARED DESC ,FEEDBACK ASC ";
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result = $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))
 .",".oci_result($stid,oci_field_name($stid, 3)).",".oci_result($stid,oci_field_name($stid, 4))
 .",".oci_result($stid,oci_field_name($stid, 5)).",".oci_result($stid,oci_field_name($stid, 6))
 .",".oci_result($stid,oci_field_name($stid, 7)).",".oci_result($stid,oci_field_name($stid, 8))
 .",".oci_result($stid,oci_field_name($stid, 9)).",".oci_result($stid,oci_field_name($stid, 10))
 .",".oci_result($stid,oci_field_name($stid, 11)).",".oci_result($stid,oci_field_name($stid, 12))."@";	
}
				 
oci_free_statement($stid);

			
		}
		
		else{
			$y = str_replace('*','&',$r);
	$sql = "SELECT distinct OPMC ,FAULT_ID ,  FEEDBACK , PROM_REPORTED , 
PROM_CLEARED, ROUND(( PROM_CLEARED- PROM_REPORTED)*24,2)  ,CUS_MOBILE ,WORK_GROUP ,CL_NAME ,CL_SERNO
,C.CIRT_DISPLAYNAME,STATUS,IN_DATE
FROM SMS_FEEDBACK , PROBLEMS P, PROBLEM_LINKS pl , CIRCUITS C
WHERE FEEDBACK IS NOT NULL
AND LEA IN (SELECT  LEA_CODE FROM OSSRPT.SLT_AREA $y
and PL.PROL_PROM_NUMBER = FAULT_ID
AND PL.PROL_FOREIGNID = C.CIRT_NAME
AND PROM_NUMBER = FAULT_ID
and PROM_CLEARED >  $day
order by PROM_CLEARED DESC ,FEEDBACK ASC ";
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result = $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))
 .",".oci_result($stid,oci_field_name($stid, 3)).",".oci_result($stid,oci_field_name($stid, 4))
 .",".oci_result($stid,oci_field_name($stid, 5)).",".oci_result($stid,oci_field_name($stid, 6))
 .",".oci_result($stid,oci_field_name($stid, 7)).",".oci_result($stid,oci_field_name($stid, 8))
 .",".oci_result($stid,oci_field_name($stid, 9)).",".oci_result($stid,oci_field_name($stid, 10))
 .",".oci_result($stid,oci_field_name($stid, 11)).",".oci_result($stid,oci_field_name($stid, 12))."@";	
}
				 
oci_free_statement($stid);

}
}

echo $result;
?>
