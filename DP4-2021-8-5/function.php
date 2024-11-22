<?php

session_start();

$q = $_GET['q'];

include 'orcon.php';

$rtom=$_SESSION['rtom'];

$CON= connecttooracle();
		
if (!$CON) 
{
  die('Not connected : ' );
}


if ($q=="1") {

$dploc = $_GET['dploc'];


if($rtom == 'R-WT')
{
$sql="select count(*) as REC_COUNT
from OSSRPT.GPS_LOCATION a,OSSRPT.GPS_DPFREE  b
where (a.dp = B.FRAC_DESCRIPTION
and a.TYPE = 'FDP'
and a.RTOM IN ('R-WT','R-MD')
and a.LATITUDE is not null
and a.dp  IN (
select distinct a.dp
from OSSRPT.GPS_LOCATION a,OSSRPT.GPS_DPFREE  b
where a.dp = B.FRAC_DESCRIPTION
and a.TYPE = 'FDP'
and a.RTOM IN ('R-WT','R-MD')
and a.LATITUDE is not null
and a.dp ='$dploc'
minus
select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'FDP
and RTOM IN ('R-WT','R-MD')
and a.dp ='$dploc'))";
}

else
{
$sql="select count(*) as REC_COUNT
from OSSRPT.GPS_LOCATION a,OSSRPT.GPS_DPFREE  b
where (a.dp = B.FRAC_DESCRIPTION
and a.TYPE = 'FDP'
and a.RTOM ='$rtom'
and a.LATITUDE is not null
and a.dp  IN (
select distinct a.dp
from OSSRPT.GPS_LOCATION a,OSSRPT.GPS_DPFREE  b
where a.dp = B.FRAC_DESCRIPTION
and a.TYPE = 'FDP'
and a.RTOM ='$rtom'
and a.LATITUDE is not null
and a.dp ='$dploc'
minus
select distinct DP
from GPS_FAULT_DP
where STATUS = '0'
and TYPE = 'FDP'
and RTOM = '$rtom')
and a.dp ='$dploc')";
	
}



//$sql="select count(a.LOCATION) as REC_COUNT
//from OSSRPT.GPS_LOCATION a,OSSRPT.GPS_DPFREE  b
//where a.dp = B.FRAC_DESCRIPTION
//and a.TYPE = 'DP'
//and a.dp ='$dploc'
//and a.LATITUDE is not null";

  $stid=oci_parse($CON,$sql);
  oci_execute($stid);

   $row = oci_fetch_array($stid);
   $result = $row['REC_COUNT'];
   
}

echo $result;

?>