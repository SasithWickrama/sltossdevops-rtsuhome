<?php
session_start();
$q =  $_GET["rtom"];
$r =  $_GET["no"];


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




  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }


  $filename = "Fiber_utilization" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  
  
  $CON = connecttooracle();

$sql = "SELECT DISTINCT AREA_AREA_CODE  RTOM_CODE,
 FU.FRAU_NAME, FC.FRAC_LOCN_TTNAME,  FC.FRAC_STATUS,(SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_STATUS  = 'SPARE' AND B.FRAA_SIDE = 'REAR'  AND B.FRAA_FRAU_ID = FU.FRAU_ID ) \"SPARE\",
(SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_STATUS  = 'LOCK' AND B.FRAA_SIDE = 'REAR'   AND B.FRAA_FRAU_ID = FU.FRAU_ID ) \"LOCK\",
  (SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_STATUS  = 'INSERVICE'  AND B.FRAA_SIDE = 'REAR'  AND B.FRAA_FRAU_ID = FU.FRAU_ID ) \"INSERVICE\",
   (SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_STATUS  = 'OUTOFSERVICE'   AND B.FRAA_SIDE = 'REAR' AND B.FRAA_FRAU_ID = FU.FRAU_ID ) \"OUTOFSERVICE\",
    (SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_STATUS  = 'BADPORT'  AND B.FRAA_SIDE = 'REAR'  AND B.FRAA_FRAU_ID = FU.FRAU_ID ) \"BADPORT\",
    (SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_CIRT_NAME  IS NOT NULL  AND B.FRAA_SIDE = 'REAR'   AND B.FRAA_FRAU_ID = FU.FRAU_ID  ) \"OCCUPIDE\",
(SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_CIRT_NAME  IS  NULL AND B.FRAA_STATUS  = 'INSERVICE' AND B.FRAA_SIDE = 'REAR'   AND B.FRAA_FRAU_ID = FU.FRAU_ID  ) \"FREE\"
FROM FRAME_CONTAINERS FC, FRAME_UNITS FU, LOCATIONS H , ( $areacode) D
WHERE  FC.FRAC_FRAN_NAME IN ('FDP')
AND FU.FRAU_FRAC_ID = FC.FRAC_ID
 AND FC.FRAC_LOCN_TTNAME = H.LOCN_TTNAME
AND H.LOCN_AREA_CODE = D.AREA_CODE(+)";


 $stid = oci_parse($CON, $sql);
oci_execute($stid);

 echo "RTOM_CODE \t DP_NAME\tDP_LOCATION\tDP_STATUS\tSPARE\tLOCK\tINSERVICE\tOUTOFSERVICE\tBADPORT\tOCCUPIDE\tFREE\r\n";

 
  while(oci_fetch($stid)){
	$temp = oci_result($stid,oci_field_name($stid, 1))." \t ".oci_result($stid,oci_field_name($stid, 2))."\t".oci_result($stid,oci_field_name($stid, 3))."\t".oci_result($stid,oci_field_name($stid, 4))."\t".oci_result($stid,oci_field_name($stid, 5))."\t".oci_result($stid,oci_field_name($stid, 6))."\t".oci_result($stid,oci_field_name($stid, 7))."\t".oci_result($stid,oci_field_name($stid, 8))."\t".oci_result($stid,oci_field_name($stid, 9))."\t".oci_result($stid,oci_field_name($stid, 10))."\t".oci_result($stid,oci_field_name($stid, 11))."\r\n";
	echo $temp;
	  
  }
  exit;
?>