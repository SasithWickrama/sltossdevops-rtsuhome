<?php

	 ini_set('max_execution_time', 36000);
	 
$q =  $_GET["q"];
$r =  $_GET["r"];

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


if($q == 'RTOM'){
	$sql = "SELECT DISTINCT MAIN_OPMC FROM OSSRPT.SLT_AREA ORDER BY MAIN_OPMC";
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);

}


else if($q == 'CHART'){
	
	$sql = "SELECT FB_VALUE, NVL(COUNT(DISTINCT FAULT_ID),'0')  FROM (
SELECT *  FROM SMS_FEEDBACK
WHERE OPMC = '$r') , FB_VALUES
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
	
	$sql = "SELECT distinct FAULT_ID ,  FEEDBACK , PROM_REPORTED , 
PROM_CLEARED, ROUND(( PROM_CLEARED- PROM_REPORTED)*24,2)  ,CUS_MOBILE ,WORK_GROUP ,CL_NAME ,CL_SERNO
FROM SMS_FEEDBACK , PROBLEMS P
WHERE FEEDBACK IS NOT NULL
AND OPMC = '$r'
AND PROM_NUMBER = FAULT_ID
order by FEEDBACK";
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result = $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))
 .",".oci_result($stid,oci_field_name($stid, 3)).",".oci_result($stid,oci_field_name($stid, 4))
 .",".oci_result($stid,oci_field_name($stid, 5)).",".oci_result($stid,oci_field_name($stid, 6))
 .",".oci_result($stid,oci_field_name($stid, 7)).",".oci_result($stid,oci_field_name($stid, 8))
 .",".oci_result($stid,oci_field_name($stid, 9))."@";	
}
				 
oci_free_statement($stid);
}


echo $result;
?>
