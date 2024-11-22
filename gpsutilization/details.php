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


$CON = connecttooracle();

$sql = "SELECT FRAC_LOCN_TTNAME ,FRAU_NAME ,FRAC_INDEX
FROM(
SELECT 
(SELECT COUNT(B.FRAA_POSITION) FROM FRAME_APPEARANCES B WHERE B.FRAA_CIRT_NAME  IS NOT NULL  AND B.FRAA_SIDE = 'REAR'   AND B.FRAA_FRAU_ID = FU.FRAU_ID  ) \"OCCUPIDE\"
, FC.FRAC_LOCN_TTNAME ,FU.FRAU_NAME ,FC.FRAC_INDEX
FROM FRAME_CONTAINERS FC, FRAME_UNITS FU, LOCATIONS H , ( $areacode) D
WHERE  FC.FRAC_FRAN_NAME ='FDP'
AND FU.FRAU_FRAC_ID = FC.FRAC_ID
AND FC.FRAC_LOCN_TTNAME = H.LOCN_TTNAME
AND H.LOCN_AREA_CODE = D.AREA_CODE
) WHERE OCCUPIDE = '$r'";



 $stid = oci_parse($CON, $sql);
oci_execute($stid);

$HEADER = "FDP LOCATION,FDP DESCRIPTION,FDP INDEX\n";
while ($row = oci_fetch_array($stid))
{
$HEADER = $HEADER ."{$row[0]},{$row[1]},{$row[2]}\n";	
		   
}

$File = "Download/{$q}_FDP_FREELOOP_{$r}.csv";
		$FILE_WRITE = fopen($File, 'w') or die("can't open file");
		fwrite($FILE_WRITE, $HEADER);
		fclose($FILE_WRITE);
		
header("location: Download/{$q}_FDP_FREELOOP_{$r}.csv");	
	
?>