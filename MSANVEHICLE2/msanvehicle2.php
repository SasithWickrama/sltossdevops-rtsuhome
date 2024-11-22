<?php

session_start();
$rtom = $_SESSION['rtom'];

include 'orcon.php';
$DBonn= connecttooracle();

$q =  $_GET["id"];


if($q == 'msan')
{
/*$sql="SELECT  m.LOCATION ,m.LATITUDE,m.LONGITUDE 
FROM OSSRPT.GPS_MSAN m 
where m.TYPE like'MSAN%' and m.LATITUDE is not null
and m.LOCATION  not IN (
SELECT  m.LOCATION  
FROM OSSRPT.GPS_MSAN m ,GPS_MSAN_ALAMS a
where m.D_NAME = A.NODE_NAME
and m.TYPE like'MSAN%' and m.LATITUDE is not null
and A.NETWORK = 'BB')
and m.RTOM = 'R-CW'";*/

$sql ="SELECT  m.LOCATION ,m.LATITUDE,m.LONGITUDE , 0 as flsg,'DESCRIPTION',10,'CATAGORY'
FROM OSSRPT.GPS_MSAN m 
where m.TYPE like'MSAN%' and m.LATITUDE is not null
and m.LOCATION  not IN (
SELECT  m.LOCATION  
FROM OSSRPT.GPS_MSAN m ,GPS_MSAN_ALAMS a
where m.D_NAME = A.NODE_NAME
and m.TYPE like'MSAN%' and m.LATITUDE is not null
and A.NETWORK = 'MSAN')
and m.RTOM = '$rtom'
union
SELECT  m.LOCATION,m.LATITUDE,m.LONGITUDE,1 as flsg,DESCRIPTION,a.ALARM ,m.MCATAGORY
FROM OSSRPT.GPS_MSAN m ,GPS_MSAN_ALAMS a
where m.D_NAME = A.NODE_NAME
and m.TYPE like'MSAN%' and m.LATITUDE is not null
and A.NETWORK = 'MSAN'
and m.RTOM = '$rtom'
union
SELECT  V_NUMBER ,V_LAT,V_LOG,2 as flsg,V_SPEED,10,V_TIMEDIFF
FROM OSSPRG.GPS_VEHICLES
where V_LOG is not null
and V_LAT is not null
and V_RTOM = '$rtom'
";

$recset = oci_parse($DBonn, $sql);
oci_execute($recset);

$i=0;
$data2= array();
 $reply ='';
 while ($row = oci_fetch_array($recset)) {

	//$data[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$reply  = $reply.$row[0].'#'.$row[1].'#'.$row[2].'#'.$row[3].'#'.$row[4].'#'.$row[5].'#'.$row[6].'#'.$i.'@';
			
 $i++;
 }
 
 echo $reply ;
}

if($q == 'msanalert')
{
$sql="SELECT  m.LOCATION,m.LATITUDE,m.LONGITUDE,DESCRIPTION  
FROM OSSRPT.GPS_MSAN m ,GPS_MSAN_ALAMS a
where m.D_NAME = A.NODE_NAME
and m.TYPE like'MSAN%' and m.LATITUDE is not null
and A.NETWORK = 'BB'
and m.RTOM = 'R-WT'";

$recset = oci_parse($DBonn, $sql);
oci_execute($recset);

$i=0;
$data2= array();
 $reply ='';
 while ($row = oci_fetch_array($recset)) {

	//$data[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$reply  = $reply.$row[0].'#'.$row[1].'#'.$row[2].'#'.$i.'@';
			
 $i++;
 }
 
 echo $reply ;
}

?>
