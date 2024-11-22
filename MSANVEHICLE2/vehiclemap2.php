<?php
  session_start();
include 'orcon.php';
$DBonn= connecttooracleprg();
$rtom=$_SESSION['rtom'];

$q =  $_GET["id"];


if($q == 'vehicle')
{


$sql ="SELECT  V_NUMBER ,V_LAT,V_LOG,V_SPEED
FROM OSSPRG.GPS_VEHICLES
where V_LOG is not null
and V_LAT is not null
and V_RTOM = '$rtom'";

$recset = oci_parse($DBonn, $sql);
oci_execute($recset);

$i=0;
$data2= array();
 $reply ='';
 while ($row = oci_fetch_array($recset)) {

	//$data[$i] = array(array($row[0], $row[1],$row[2], $i));
	
	$reply  = $reply.$row[0].'#'.$row[1].'#'.$row[2].'#'.$row[3].'#'.$i.'@';
			
 $i++;
 }
 
 echo $reply ;
}
?>