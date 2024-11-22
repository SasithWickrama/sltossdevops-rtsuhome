<?php

	 ini_set('max_execution_time', 36000);
	   ini_set('memory_limit', '1024M'); 
	 
$q =  $_GET["q"];
$r =  $_GET["r"];
$s =  $_GET["s"];
$t =  $_GET["t"];
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

if($q == 'SUMMARY'){
	$result = "<table class=\"table\"  ><thead><tr><th> RTOM </th><th> LAST_MONTH </th><th> THIS_MONTH </th></tr></thead>";
	
	$sql = "select a.OPMC , 
(select nvl(count(distinct b.CIRCUIT_NO),0) from FTTH_NC b where b.OPMC = a.OPMC 
        and to_char(INSPECTION_DATE,'MM') = to_char(add_months(sysdate,-1) , 'MM'))LAST_MONTH,
(select nvl(count(distinct b.CIRCUIT_NO),0) from FTTH_NC b where b.OPMC = a.OPMC 
        and to_char(INSPECTION_DATE,'MM') = to_char(sysdate , 'MM'))THIS_MONTH
from FTTH_NC  a
group by OPMC
order by opmc ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result."<tr><td>".oci_result($stid,oci_field_name($stid, 1))."</td><td>".oci_result($stid,oci_field_name($stid, 2))."</td><td>"
 .oci_result($stid,oci_field_name($stid, 3))."</td></tr>";	
}
				 
oci_free_statement($stid);
$result = $result."</table>";


}


if($q == 'OPMCx'){
	$result = null;
	
	$sql = "SELECT DISTINCT  OPMC_NAME FROM OSSRPT.SLT_AREA ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);



}

if($q == 'CON'){
	$result = null;
	
	$sql = "SELECT DISTINCT  CONTRACTORS FROM SMS_CONTRACTORS ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);



}





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

else if($q == 'TABLE'){
	
	
		$day= " BETWEEN TO_DATE ('$s 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') AND  TO_DATE ('$t 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
		
		
		$sql= "select a.OPMC , 
(select nvl(count(distinct b.CIRCUIT_NO),0) from FTTH_NC b where b.OPMC = a.OPMC 
        and INSPECTION_DATE $day )LAST_MONTH
from FTTH_NC  a 
where a.OPMC in (SELECT  OPMC_NAME FROM OSSRPT.SLT_AREA $r
group by OPMC
order by opmc";

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result = $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))."@";	
}
				 
oci_free_statement($stid);


}

else if($q == 'alldata'){
	
	
		$day= " BETWEEN TO_DATE ('$s 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') AND  TO_DATE ('$t 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
		
		
		$sql= "SELECT INSPECTION_DATE,CIRCUIT_NO,OPMC,FTC,FDP,FDP_PORT,INSPECTOR,CONTRACTOR,
CON_CONTACTNO CONTRACTOR_CONTACTNO,CUS_NAME CUSTOMER_NAME,CUS_ADDRESS CUSTOMER_ADDRESS,CUS_CONTACTNO CUSTOMER__CONTACTNO,
BB_SPEED_WIRED,BB_SPEED_WIFI,
BB_WIFI_CH SELECTED_WIFI_CHANAL_NO ,BB_OPT_PWR_FDP OUTPUT_POWER_LEVEL_FDP,BB_OPT_PWR_ROS OUTPUT_POWER_LEVEL_ROSSETE,
BB_LOSS LOSS_BETWEEN_FDP_AND_ROSSETE,IPTV_IP,IPTV_OPT_PWR_ONT OUTPUT_POWER_ONT,
ONT_TYPE,OH_CONSTRUCTION,WORK_CON_TEAM WORKMANSHIP_OF_CONTEAM,AFTER_SALE_SV AFTER_SALES_SERVICE,INSPEC_SUG INSPECTOR_SUGGESTIONS,
INSPEC_DIF INSPECTOR_FACED_DIFICULTIES,
SUPERVISER ,SEGMENT,CHECK_LIST,COMPLIANCE,DEVIATION,DEVIATION_JUST,OTHER_COMP,EVIDENCE_REF,FEEDBACK
FROM (select * from FTTH_NC where INSPECTION_DATE $day) A , (SELECT *  FROM  FTTH_NC_POINTS Y ,FTTH_NC_CHECKLIST X 
WHERE X.CHECK_LIST_ID = Y.ID) B
WHERE FTTH_NC_ID = NC_ID(+)";

 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result = $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2)).",".
			oci_result($stid,oci_field_name($stid, 3)).",".oci_result($stid,oci_field_name($stid, 4)).",".
			oci_result($stid,oci_field_name($stid, 5)).",".oci_result($stid,oci_field_name($stid, 6)).",".
			oci_result($stid,oci_field_name($stid, 7)).",".oci_result($stid,oci_field_name($stid, 8)).",".
			oci_result($stid,oci_field_name($stid, 9)).",".oci_result($stid,oci_field_name($stid, 10)).",".
			oci_result($stid,oci_field_name($stid, 11)).",".oci_result($stid,oci_field_name($stid, 12)).",".
			oci_result($stid,oci_field_name($stid, 13)).",".oci_result($stid,oci_field_name($stid, 14)).",".
			oci_result($stid,oci_field_name($stid, 15)).",".oci_result($stid,oci_field_name($stid, 16)).",".
			oci_result($stid,oci_field_name($stid, 17)).",".oci_result($stid,oci_field_name($stid, 18)).",".
			oci_result($stid,oci_field_name($stid, 19)).",".oci_result($stid,oci_field_name($stid, 20)).",".
			oci_result($stid,oci_field_name($stid, 21)).",".oci_result($stid,oci_field_name($stid, 22)).",".
			oci_result($stid,oci_field_name($stid, 23)).",".oci_result($stid,oci_field_name($stid, 24)).",".		
			oci_result($stid,oci_field_name($stid, 25)).",".oci_result($stid,oci_field_name($stid, 26)).",".
			oci_result($stid,oci_field_name($stid, 27)).",".oci_result($stid,oci_field_name($stid, 28)).",".
			oci_result($stid,oci_field_name($stid, 29)).",".oci_result($stid,oci_field_name($stid, 30)).",".
			oci_result($stid,oci_field_name($stid, 31)).",".oci_result($stid,oci_field_name($stid, 32)).",".
			oci_result($stid,oci_field_name($stid, 33)).",".oci_result($stid,oci_field_name($stid, 34)).",".
			oci_result($stid,oci_field_name($stid, 35))."@";
}
				 
oci_free_statement($stid);


}


echo  $result;



?>