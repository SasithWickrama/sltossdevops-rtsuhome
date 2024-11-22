<?php

	 ini_set('max_execution_time', 36000);
	   ini_set('memory_limit', '1024M'); 
	 
$q =  $_GET["q"];
$r =  $_GET["r"];
$s =  $_GET["s"];
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

$msg ="Submited Sucessfuly";


$sql1 = "SELECT FTTH_NC_SEQ.NEXTVAL xx FROM DUAL";

 $stidx = oci_parse($CON, $sql1 );
oci_execute($stidx);

oci_fetch($stidx);
 $sequence =   oci_result($stidx,oci_field_name($stidx, 1));	

$temp = "";
if($_POST["toglast"] == "on")
{$temp = 'YES';}
else{$temp = 'NO';}


$sql = "INSERT INTO OSSPRG.FTTH_NC (
   INSPECTION_DATE, CIRCUIT_NO, OPMC, 
   FTC, FDP, FDP_PORT, 
   INSPECTOR, CONTRACTOR, CON_CONTACTNO, 
   CUS_NAME, CUS_ADDRESS, CUS_CONTACTNO, 
   BB_SPEED_WIRED, BB_SPEED_WIFI, BB_WIFI_CH, 
   BB_OPT_PWR_FDP, BB_OPT_PWR_ROS, BB_LOSS, 
   IPTV_IP, IPTV_OPT_PWR_ONT, ONT_TYPE, 
   FTTH_NC_ID, OH_CONSTRUCTION, WORK_CON_TEAM, 
   AFTER_SALE_SV, INSPEC_SUG, INSPEC_DIF, 
   SUPERVISER,QUAL) 
VALUES ( TO_DATE ('".$_POST['inputField1']."','mm,dd,yyyy')  ,
 '".$_POST['tpno']."',
 '".$_POST['opmc']."',
 '".$_POST['ftc']."',
 '".$_POST['fdp']."',
 '".$_POST['fport']."',
 '".$_POST['name']."',
 '".$_POST['conname']."',
'".$_POST['tpno']."',
'".$_POST['cusname']."',
 '".$_POST['address']."',
'".$_POST['custp']."',
 '".$_POST['tpno']."',
'".$_POST['bbspeed']."',
'".$_POST['chanelno']."',
'".$_POST['pwr']."',
'".$_POST['wifipowr']."',
'".$_POST['loss']."',
'".$_POST['ip']."',
'".$_POST['iptvpwr']."',
'".$_POST['onttype']."',
$sequence,
'".$_POST['options']."',
'".$_POST['options1']."',
'".$_POST['options2']."',
'".$_POST['xx1']."',
'".$_POST['xx2']."',
'".$_POST['xx3']."','".$temp."' )";


 $stid = oci_parse($CON, $sql);
$r = oci_execute($stid);

if (!$r) {    
    $e = oci_error($stid);
    $msg = $sql."FTTH_NC insert error".$e['message'];

}

oci_free_statement($stid);

for($i =1; $i<26; $i++){

$temp = "";
if($_POST["tog$i"] == "on")
{$temp = 'YES';}
else{$temp = 'NO';}

	

$sql2 = "INSERT INTO OSSPRG.FTTH_NC_CHECKLIST (
   NC_ID, CHECK_LIST_ID, COMPLIANCE, 
   DEVIATION, DEVIATION_JUST, OTHER_COMP, 
   EVIDENCE_REF, FEEDBACK) 
VALUES ( $sequence ,
 $i,
'".$temp."',
'".$_POST["a$i"]."',
'".$_POST["b$i"]."',
'".$_POST["c$i"]."',
'".$_POST["d$i"]."',
'".$_POST["e$i"]."')";


 $stid = oci_parse($CON, $sql2);
$r = oci_execute($stid);

if (!$r) {    
    $e = oci_error($stid);
    $msg = "FTTH_NC_CHECKLIST insert error".$e['message'];
}


oci_free_statement($stid);

 
}
oci_free_statement($stidx);
echo '<script type="text/javascript"> var name = "'.$msg.'";alert(name)</script>';
echo $sql;
//echo '<script type="text/javascript"> document.location = "ftthncon.html";</script>';

?>