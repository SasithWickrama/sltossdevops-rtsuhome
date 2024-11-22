<?php
session_start();
	 ini_set('max_execution_time', 36000);
	   ini_set('memory_limit', '1024M'); 
	 
$q =  $_GET["q"];

function connecttooracle(){
	 $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )" ;
  
    if($c = oci_connect("ossrpt", "ossrpt123", $db))
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


$area = $_SESSION['area'];


if ($area == 'ALL') {	
   $areacode = " SELECT * FROM AREAS WHERE AREA_ARET_CODE = 'LEA'  ";
}else if (strpos($area, 'X-') !== false) {	
	$temp = str_replace("X-","",$area);
	$tempx = str_replace(",","','",$temp);
   $areacode = " SELECT * FROM AREAS WHERE AREA_ARET_CODE = 'LEA' AND AREA_AREA_CODE IN (SELECT DISTINCT RTOM_CODE FROM OSSRPT.SLT_AREA WHERE REGIONS in ('$tempx') ) ";
}else if (strpos($area, 'P-') !== false) {	
	$temp = str_replace("P-","",$area);
	$tempx = str_replace(",","','",$temp);
   $areacode = " SELECT * FROM AREAS WHERE AREA_ARET_CODE = 'LEA' AND AREA_AREA_CODE IN (SELECT DISTINCT RTOM_CODE FROM OSSRPT.SLT_AREA WHERE PROVINCE in ('$tempx') ) ";
}else{
$tempx = str_replace(",","','",$area);
	$areacode =  "SELECT * FROM areas WHERE AREA_ARET_CODE = 'LEA' AND AREA_AREA_CODE in ( '$tempx')";
}



if($q == 'RTOM'){
	$result = null;
		$sql = "SELECT DISTINCT RTOM_CODE  FROM OSSRPT.SLT_AREA  order by RTOM_CODE";		
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);

}


if($q == 'MAP'){
$s =  $_GET["s"];
$sql = "SELECT FRAC_LOCN_TTNAME ,LOCN_X , LOCN_Y,FRAU_NAME 
FROM(
SELECT 
(SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_CIRT_NAME  IS NOT NULL  AND B.FRAA_SIDE = 'REAR'   AND B.FRAA_FRAU_ID = FU.FRAU_ID  ) \"OCCUPIDE\"
, FC.FRAC_LOCN_TTNAME ,FU.FRAU_NAME ,FC.FRAC_INDEX ,H.LOCN_X , H.LOCN_Y
FROM FRAME_CONTAINERS FC, FRAME_UNITS FU, LOCATIONS H , ( $areacode) D
WHERE  FC.FRAC_FRAN_NAME ='FDP'
AND FU.FRAU_FRAC_ID = FC.FRAC_ID
AND FC.FRAC_LOCN_TTNAME = H.LOCN_TTNAME
AND H.LOCN_AREA_CODE = D.AREA_CODE
) WHERE OCCUPIDE = '$s'";


$stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch_array($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2)).",".
 oci_result($stid,oci_field_name($stid, 3)).",".oci_result($stid,oci_field_name($stid, 4))."@";
}
				 
oci_free_statement($stid);
}




 if($q == 'DPCHART'){
		
		$sql = "SELECT DISTINCT (case when H.LOCN_X is null then 'nogps' else 'withgps' end) gps , count( FC.FRAC_LOCN_TTNAME) LOCATION 
FROM FRAME_CONTAINERS FC, LOCATIONS H , OSSRPT.SLT_AREA D , FRAME_UNITS FU 
WHERE  FC.FRAC_FRAN_NAME = 'FDP'
AND FC.FRAC_LOCN_TTNAME = H.LOCN_TTNAME
AND H.LOCN_AREA_CODE = D.LEA_CODE
AND FC.FRAC_STATUS = 'INSERVICE'
AND FU.FRAU_FRAC_ID =FRAC_ID
and D.RTOM_CODE = 'R-WT'
group by (case when H.LOCN_X is null then 'nogps' else 'withgps' end) ";

 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))."@";	
}
				 
oci_free_statement($stid);

}

 if($q == 'CHARTTWO'){
		
		$sql = "select *  from FDP_SUMMRY ORDER BY DISORDER";

 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))
 .",".oci_result($stid,oci_field_name($stid, 3)).",".oci_result($stid,oci_field_name($stid, 4)).",".oci_result($stid,oci_field_name($stid, 5))
 .",".oci_result($stid,oci_field_name($stid, 6)).",".oci_result($stid,oci_field_name($stid, 7)).",".oci_result($stid,oci_field_name($stid, 8))
 .",".oci_result($stid,oci_field_name($stid, 9)).",".oci_result($stid,oci_field_name($stid, 10))."@";	
}
				 
oci_free_statement($stid);

}


 if($q == 'TABLE'){
		
		/*$sql = "SELECT  AREA_AREA_CODE  RTOM_CODE , OCCUPIDE , COUNT(DISTINCT FRAU_NAME)  FROM(
SELECT DISTINCT 
(SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_CIRT_NAME  IS NOT NULL  AND B.FRAA_SIDE = 'REAR'   AND B.FRAA_FRAU_ID = FU.FRAU_ID  ) \"OCCUPIDE\"
,FU.FRAU_NAME , AREA_AREA_CODE  
FROM FRAME_CONTAINERS FC, FRAME_UNITS FU, LOCATIONS H ,  ( $areacode) D
WHERE  FC.FRAC_FRAN_NAME ='FDP'
AND FU.FRAU_FRAC_ID = FC.FRAC_ID
 AND FC.FRAC_LOCN_TTNAME = H.LOCN_TTNAME
AND H.LOCN_AREA_CODE = D.AREA_CODE)
GROUP BY OCCUPIDE , AREA_AREA_CODE   
ORDER BY AREA_AREA_CODE   ,OCCUPIDE ";*/

$sql = "SELECT  AREA_AREA_CODE  RTOM_CODE , OCCUPIDE , COUNT(DISTINCT FRAU_NAME)  ,
(SELECT COUNT(FDP)  FROM FDP_ZERO_SALE WHERE AREA_AREA_CODE = RTOM) ZERO_DP
FROM(
SELECT DISTINCT 
(SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_CIRT_NAME  IS NOT NULL  AND B.FRAA_SIDE = 'REAR'   AND B.FRAA_FRAU_ID = FU.FRAU_ID  ) \"OCCUPIDE\"
,FU.FRAU_NAME , AREA_AREA_CODE  
FROM FRAME_CONTAINERS FC, FRAME_UNITS FU, LOCATIONS H ,  ( $areacode  ) D
WHERE  FC.FRAC_FRAN_NAME ='FDP'
AND FU.FRAU_FRAC_ID = FC.FRAC_ID
 AND FC.FRAC_LOCN_TTNAME = H.LOCN_TTNAME
AND H.LOCN_AREA_CODE = D.AREA_CODE)
GROUP BY OCCUPIDE , AREA_AREA_CODE   
ORDER BY AREA_AREA_CODE   ,OCCUPIDE ";

 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);
$result = null;

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1)).",".oci_result($stid,oci_field_name($stid, 2))
 .",".oci_result($stid,oci_field_name($stid, 3)).",".oci_result($stid,oci_field_name($stid, 4))."@";	
}
				 
oci_free_statement($stid);


}

echo $result;
?>
