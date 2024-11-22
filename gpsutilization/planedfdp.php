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


  $filename = "FDP INSTALATION TARGETS" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  
  
  $CON = connecttooracle();

$sql = "select a.* from FDP_PLANNED a , ( $areacode) D
where RTOM  = d.AREA_AREA_CODE";


 $stid = oci_parse($CON, $sql);
oci_execute($stid);

 echo "RTOM_CODE \t AREA\tLOCATION\tFDP_COUNT\tTARGET_DATE\r\n";

 
  while(oci_fetch($stid)){
	$temp = oci_result($stid,oci_field_name($stid, 1))." \t ".oci_result($stid,oci_field_name($stid, 2))."\t".oci_result($stid,oci_field_name($stid, 3))."\t".oci_result($stid,oci_field_name($stid, 4))."\t".oci_result($stid,oci_field_name($stid, 5))."r\n";
	echo $temp;
	  
  }
  exit;
?>