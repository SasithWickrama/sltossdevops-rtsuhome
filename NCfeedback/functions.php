<?php

	 ini_set('max_execution_time', 36000);
	   ini_set('memory_limit', '1024M'); 
	 
$q =  $_GET["q"];
$r =  $_GET["r"];
$s =  $_GET["s"];
$t =  $_GET["t"];

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
		$sql = "SELECT DISTINCT PROVINCE  FROM OSSRPT.SLT_AREA  where REGIONS <> 'HQ'";
		$result = "ALL@";
	}else{
		$y = str_replace('*','&',$r);
	$sql = "SELECT DISTINCT PROVINCE  FROM OSSRPT.SLT_AREA  WHERE REGIONS = '$y'  and REGIONS <> 'HQ'";
	$result = "ALL@";
	}
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);


while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);


}


if($q == 'con'){
	$result = null;
	if($r=='ALL'){
		$sql = "SELECT DISTINCT REGIONS  FROM OSSRPT.SLT_AREA where REGIONS <> 'HQ'";
		$result = "ALL@";
	}else{
		$y = str_replace('*','&',$r);
	$sql = "SELECT DISTINCT REGIONS  FROM OSSRPT.SLT_AREA WHERE   RTOM_CODE IN ( 
SELECT  TRIM(COLUMN_VALUE) RTOMS  FROM SMS_CONTRACTORS,     
 XMLTABLE(('\"'    || REPLACE(RTOMS, ',', '\",\"')   || '\"'))
   WHERE CONTRACTORS = '$y') and REGIONS <> 'HQ' ";
	$result = "ALL@";
	}
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);


while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);


}



if($q == 'x'){
	$result = null;
	
		$sql = " SELECT  DISTINCT CONTRACTORS FROM SMS_CONTRACTORS";
		
	
 
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
		$sql = "SELECT DISTINCT RTOM_CODE  FROM OSSRPT.SLT_AREA  WHERE REGIONS = '$s'  and REGIONS <> 'HQ'";
		
	}else{
		$y = str_replace('*','&',$r);
	$sql = "SELECT DISTINCT RTOM_CODE  FROM OSSRPT.SLT_AREA  WHERE PROVINCE= '$y'  and REGIONS <> 'HQ' ";
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
		$sql = "SELECT DISTINCT CL_SERNO , CL_NAME  FROM SMS_FEEDBACK_NEWCON
  WHERE LEA IN (SELECT  LEA_CODE FROM OSSRPT.SLT_AREA $s) AND CL_SERNO IS NOT NULL";
	}else{
	$sql = "SELECT DISTINCT CL_SERNO , CL_NAME  FROM SMS_FEEDBACK_NEWCON
  WHERE LEA  = '$r' AND CL_SERNO IS NOT NULL";
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
	
	$sql = "INSERT INTO OSSPRG.SMS_CALLBACK_NEWCON (
   SO_ID, DTIME, DISCRIPTION) 
VALUES ('$s',SYSDATE,'$r')";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

	$sql = "UPDATE SMS_FEEDBACK_NEWCON
 SET STATUS = '1' WHERE SO_ID = '$s'";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);


oci_free_statement($stid);

}


if($q == 'getcomment'){
	$result = null;
	
	$sql = "SELECT *  FROM OSSPRG.SMS_CALLBACK_NEWCON WHERE SO_ID = '$s' ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 2))."#".oci_result($stid,oci_field_name($stid, 3))."@";	
}
	

oci_free_statement($stid);

}











else if($q == 'CHART'){
		
		$day= " BETWEEN TO_DATE ('$s 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') AND  TO_DATE ('$t 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
		
	

		$y = str_replace('*','&',$r);
	$sql = "SELECT FB_VALUE, NVL(COUNT(DISTINCT SO_ID),'0')  FROM (
SELECT *  FROM SMS_FEEDBACK_NEWCON
WHERE LEA IN (SELECT  LEA_CODE FROM OSSRPT.SLT_AREA $y AND SMS_DATE $day) , FB_VALUES
WHERE FEEDBACK(+) = FB_VALUE
GROUP BY FB_VALUE
ORDER BY FB_VALUE desc ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))."@";	
}
				 
oci_free_statement($stid);
}



else if($q == 'TABLE'){
	
	
		$day= " BETWEEN TO_DATE ('$s 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') AND  TO_DATE ('$t 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
		
			$y = str_replace('*','&',$r);
	$sql = "SELECT distinct OPMC ,SO_ID    ,  FEEDBACK , SO.SERO_DATECREATED , 
SO.SERO_STATUSDATE , ROUND(( SERO_STATUSDATE- SERO_DATECREATED)*24,2)  ,CUS_MOBILE ,WORK_GROUP 
,NC_CIRCUIT ,STATUS,IN_DATE,LEA
FROM SMS_FEEDBACK_NEWCON X
 , SERVICE_ORDERS SO
 WHERE X.SO_ID = SO.SERO_ID
 AND LEA IN (SELECT  LEA_CODE FROM OSSRPT.SLT_AREA $y
AND SO.SERO_STATUSDATE    $day
AND FEEDBACK IS NOT NULL
order by SERO_STATUSDATE DESC ,FEEDBACK ASC ";
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result = $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))
 .",".oci_result($stid,oci_field_name($stid, 3)).",".oci_result($stid,oci_field_name($stid, 4))
 .",".oci_result($stid,oci_field_name($stid, 5)).",".oci_result($stid,oci_field_name($stid, 6))
 .",".oci_result($stid,oci_field_name($stid, 7)).",".oci_result($stid,oci_field_name($stid, 8))
 .",".oci_result($stid,oci_field_name($stid, 9)).",".oci_result($stid,oci_field_name($stid, 10)).",".oci_result($stid,oci_field_name($stid, 12))."@";	
}
				 
oci_free_statement($stid);


}

echo $result;
?>
