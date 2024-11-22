<?php

session_start();
$rtom = $_SESSION['rtom'];

include 'orcon.php';
$DBonn= connecttooracle();

$q =  $_GET["id"];


if($q == 'dp')
{

$sql ="select  distinct LATITUDE,LONGITUDE,LOCATION,0 as flsg,10,15
from gps_location
where LOCATION IN (select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'FDP')
and TYPE = 'FDP'
and RTOM ='$rtom'
and LATITUDE is not null
union
select  distinct LATITUDE,LONGITUDE,LOCATION,1 as flsg,10,15
from gps_location
where LOCATION IN (select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'DP')
and TYPE = 'DP'
and RTOM ='$rtom'
and LATITUDE is not null
union
SELECT  V_NUMBER ,V_LAT,V_LOG,2 as flsg,TO_NUMBER(V_SPEED),TO_NUMBER(V_TIMEDIFF)
FROM OSSPRG.GPS_VEHICLES
where V_LOG <> 'null'
and V_LAT <> 'null'
and V_RTOM = '$rtom'";

$recset = oci_parse($DBonn, $sql);
oci_execute($recset);

$i=0;
$data2= array();
 $reply ='';
 while ($row = oci_fetch_array($recset)) {

	//$data[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$reply  = $reply.$row[0].'#'.$row[1].'#'.$row[2].'#'.$row[3].'#'.$row[4].'#'.$row[5].'#'.$i.'@';
			
 $i++;
 }
 
 echo $reply ;
}



?>