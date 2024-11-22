<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
 $user = $_SESSION['$UID'];
 $opmc=$_SESSION['opmc'];
	
if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null   ){	
 	echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
}
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../dbcon.php';

if (!$CON) 
{
  die('Not connected : ' );
}

$info = $_POST['info'];
$ser = $_POST['serv'];

$dom=new DOMDocument('1.0','UTF-8');

$node=$dom-> createElementNs('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);

$manholeStyleNode = $dom->createElement('Style');
$manholeStyleNode->setAttribute('id', 'greenball');
$manholeIconstyleNode = $dom->createElement('IconStyle');
$manholeIconstyleNode->setAttribute('id', 'manhole');
$manholescale=$dom->createElement('scale', '0.25');
$manholeIconstyleNode->appendChild($manholescale);
$manholeIconNode = $dom->createElement('Icon');
$manholeHref = $dom->createElement('href', 'http://172.25.36.241/RTSUHOME/eqmap/img/green-ball.ico');
$manholeIconNode->appendChild($manholeHref);
$manholeIconstyleNode->appendChild($manholeIconNode);
$manholeStyleNode->appendChild($manholeIconstyleNode);
$docNode->appendChild($manholeStyleNode);

$handholeStyleNode = $dom->createElement('Style');
$handholeStyleNode->setAttribute('id', 'blueball');
$handholeIconstyleNode = $dom->createElement('IconStyle');
$handholeIconstyleNode->setAttribute('id', 'manhole');
$handholescale=$dom->createElement('scale', '0.5');
$handholeIconstyleNode->appendChild($handholescale);
$handholeIconNode = $dom->createElement('Icon');
$handholeHref = $dom->createElement('href', 'http://172.25.36.241/RTSUHOME/eqmap/img/orange_boll.png');
$handholeIconNode->appendChild($handholeHref);
$handholeIconstyleNode->appendChild($handholeIconNode);
$handholeStyleNode->appendChild($handholeIconstyleNode);
$docNode->appendChild($handholeStyleNode);

$handholeStyleNode = $dom->createElement('Style');
$handholeStyleNode->setAttribute('id', 'redball');
$handholeIconstyleNode = $dom->createElement('IconStyle');
$handholeIconstyleNode->setAttribute('id', 'manhole');
$handholescale=$dom->createElement('scale', '1');
$handholeIconstyleNode->appendChild($handholescale);
$handholeIconNode = $dom->createElement('Icon');
$handholeHref = $dom->createElement('href', 'http://172.25.36.241/RTSUHOME/eqmap/img/red.png');
$handholeIconNode->appendChild($handholeHref);
$handholeIconstyleNode->appendChild($handholeIconNode);
$handholeStyleNode->appendChild($handholeIconstyleNode);
$docNode->appendChild($handholeStyleNode);

$fltArr=array();

$checkCount = sizeof($info);

for($n=0; $n<$checkCount; $n++){

	if($info[$n] == 'MSAN'){
	
		$fltArr[] = 'MSAN Port Issues';
	
	}
	
	if($info[$n] == 'CPE'){
	
		$fltArr[] = 'CPE Issues_Faulty';
		$fltArr[] = 'CPE Issues_Other';
	
	}
	
	if($info[$n] == 'UG'){
	
		$fltArr[] = 'UG Issues';
	
	}

}

$faultType = implode("','",$fltArr);

$time = strtotime(date('Y-m-d'));
$oneMlater = date("Y-m-d", strtotime("-1 month", $time));

$tbloneMArr = explode('-',$oneMlater);
$tbloneM = $tbloneMArr[1];
$tbloneY = $tbloneMArr[0];
$crnttbl = 'FAULT_INQ_'.$tbloneM.$tbloneY;

$sql="SELECT A.EQUP_ID, COUNT(FAULT_COUNT) AS TOT_FAULT FROM FAULT_INQ_MSANLIST A,".$crnttbl." C
	where A.EQUP_ID = C.EQUP_ID
	AND OPMC_NAME = '".$opmc."'
	AND CATAGORY IN ('".$faultType."')
	AND LOCN_X IS NOT NULL AND LOCN_Y IS NOT NULL
	GROUP BY A.EQUP_ID
	ORDER BY TOT_FAULT DESC";

	$stid1=oci_parse($CON,$sql);
	oci_execute($stid1);
	$a=0;

while($row=oci_fetch_array($stid1)) {
	
	$a++;
	
	$sql2="SELECT EQUP_ID,EQUP_LOCN_TTNAME,LOCN_X,LOCN_Y FROM FAULT_INQ_MSANLIST WHERE EQUP_ID='".$row['EQUP_ID']."' AND OPMC_NAME='".$opmc."'";

	$stid2=oci_parse($CON,$sql2);
	oci_execute($stid2);

	  $row2=oci_fetch_array($stid2);

	  $node = $dom->createElement('Placemark');
	  $placeNode = $docNode->appendChild($node);

	  $placeNode->setAttribute('id', 'placemark' . $row2['EQUP_LOCN_TTNAME']);
	  
	  $discription =makeDiscription($row2,$info,$ser,$CON);

	  $nameNode = $dom->createElement('name',htmlentities($row2['EQUP_LOCN_TTNAME']));
	  $placeNode->appendChild($nameNode);
	  $descNode = $dom->createElement('description', $discription);
	  $placeNode->appendChild($descNode);

	  $styleUrl = $dom->createElement('styleUrl', '#redball');
	  $placeNode->appendChild($styleUrl);

	  $pointNode = $dom->createElement('Point');
	  $placeNode->appendChild($pointNode);

	  $coorStr = $row2['LOCN_Y'] . ','  . $row2['LOCN_X'];
	  $coorNode = $dom->createElement('coordinates', $coorStr);
	  $pointNode->appendChild($coorNode);
	  
	  if ($a == 10) {
		break;
	  }

}

$kmlOutput = $dom->saveXML();
$dom->save("../kmlfiles/Msan.kml");

function makeDiscription($row,$info,$ser,$CON){

$time = strtotime(date('Y-m-d'));
	  
$dis = '<![CDATA[<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

<table class="table" style="width:100%" >

  <tr>
    <td><b>LOCATION:</b></td>
    <td colspan="2">'.$row['EQUP_LOCN_TTNAME'].'</td>
  </tr>
  
  <tr>
    <td><b>SERVICE TYPE:</b></td>
    <td colspan="2">'.$ser.'</td>
  </tr>';
	
	$threeMlater = date("Y-m-d", strtotime("-3 month", $time));
	$tblthreeMArr = explode('-',$threeMlater);
	$tblthreeM = $tblthreeMArr[1];
	$tblthreeY = $tblthreeMArr[0];
	$prevtbl3 = 'FAULT_INQ_'.$tblthreeM.$tblthreeY;
	$prevM3 = $tblthreeM.'-'.$tblthreeY;

	$sql3="SELECT VALUE AS CUSTOMER_BASE FROM FAULT_INQ_ATTLIST 
		   WHERE EQUP_ID = '".$row['EQUP_ID']."'
		   AND ATTRIBUTE = 'CUSTOMER_BASE' AND MONTH='".$prevM3 ."'";

	$stid3=oci_parse($CON,$sql3);
	oci_execute($stid3);

	$row3=oci_fetch_array($stid3);
	
	if($prevM3!=''){
		
	$dis .= '<tr><td><table class="table table-striped">
	<thead class="thead-light">
	<tr>
		<th style="font-size:11px;">MONTH:</td>
		<th style="font-size:11px;">'.$prevM3.'</td>
	</tr>
	</thead>
	
	<tbody>
	<tr>
		<td style="font-size:11px;">CUSTOMER BASE:</td>
		<td style="font-size:11px;">'.$row3['CUSTOMER_BASE'].'</td>
	</tr>';
 
	$dcount = sizeof($info);
		
  	for($i=0; $i<$dcount; $i++){

		if($info[$i] == 'MSAN'){
		
		$sql4="SELECT SUM(FAULT_COUNT) AS MSAN_PORT_ISSUES FROM ".$prevtbl3." WHERE CATAGORY='MSAN Port Issues' AND EQUP_ID='".$row['EQUP_ID']."' AND SVRVICE IN(".$ser.")";

		$stid4=oci_parse($CON,$sql4);
		oci_execute($stid4);

		$row4=oci_fetch_array($stid4);
	
		$dis .= '<tr>
				<td style="font-size:11px;">MSAN PORT ISSUES:</td>
				<td style="font-size:11px;">'.$row4['MSAN_PORT_ISSUES'].'</td>
			  </tr>';

		}
		
		if($info[$i] == 'CPE'){
			
		$sql5="SELECT SUM(FAULT_COUNT) AS CPE_ISSUES FROM ".$prevtbl3." WHERE CATAGORY IN('CPE Issues_Faulty','CPE Issues_Other') AND EQUP_ID='".$row['EQUP_ID']."' AND SVRVICE IN (".$ser.")";

		$stid5=oci_parse($CON,$sql5);
		oci_execute($stid5);

		$row5=oci_fetch_array($stid5);
			
			$dis .= '<tr>
				<td style="font-size:11px;">CPE ISSUES:</td>
				<td style="font-size:11px;">'.$row5['CPE_ISSUES'].'</td>
			  </tr>';
		
		}
		
		if($info[$i] == 'UG'){
			
		$sql6="SELECT SUM(FAULT_COUNT) AS UG_FAULTS FROM ".$prevtbl3." WHERE CATAGORY='UG Issues' AND EQUP_ID='".$row['EQUP_ID']."' AND SVRVICE IN (".$ser.")";

		$stid6=oci_parse($CON,$sql6);
		oci_execute($stid6);

		$row6=oci_fetch_array($stid6);
			
			$dis .= '<tr>
				<td style="font-size:11px;">UG FAULTS:</td>
				<td style="font-size:11px;">'.$row6['UG_FAULTS'].'</td>
			  </tr>';
		
		}

	}
	
	
	}

$dis .= '</tbody></table></td>';

	$twoMlater = date("Y-m-d", strtotime("-2 month", $time));
	$tbltwoMArr = explode('-',$twoMlater);
	$tbltwoM = $tbltwoMArr[1];
	$tbltwoY = $tbltwoMArr[0];
	$prevtbl2 = 'FAULT_INQ_'.$tbltwoM.$tbltwoY;
	$prevM2 = $tbltwoM.'-'.$tbltwoY;

	$sql7="SELECT VALUE AS CUSTOMER_BASE FROM FAULT_INQ_ATTLIST 
		   WHERE EQUP_ID = '".$row['EQUP_ID']."'
		   AND ATTRIBUTE = 'CUSTOMER_BASE' AND MONTH='".$prevM2."'";
		   
		$stid7=oci_parse($CON,$sql7);
		oci_execute($stid7);

		$row7=oci_fetch_array($stid7);
	
	if($prevM2!=''){
		
	$dis .= '<td><table class="table table-striped">
	<thead class="thead-light">
	<tr>
		<th style="font-size:11px;">MONTH:</td>
		<th style="font-size:11px;">'.$prevM2.'</td>
	</tr>
	</thead>
	
	<tbody>
	<tr>
		<td style="font-size:11px;">CUSTOMER BASE:</td>
		<td style="font-size:11px;">'.$row7['CUSTOMER_BASE'].'</td>
	</tr>';
 
	$dcount = sizeof($info);
		
  	for($i=0; $i<$dcount; $i++){

		if($info[$i] == 'MSAN'){
		
		$sql8="SELECT SUM(FAULT_COUNT) AS MSAN_PORT_ISSUES FROM ".$prevtbl2." WHERE CATAGORY='MSAN Port Issues' AND EQUP_ID='".$row['EQUP_ID']."' AND SVRVICE IN(".$ser.")";

		$stid8=oci_parse($CON,$sql8);
		oci_execute($stid8);

		$row8=oci_fetch_array($stid8);
	
		$dis .= '<tr>
				<td style="font-size:11px;">MSAN PORT ISSUES:</td>
				<td style="font-size:11px;">'.$row8['MSAN_PORT_ISSUES'].'</td>
			  </tr>';

		}
		
		if($info[$i] == 'CPE'){
			
		$sql9="SELECT SUM(FAULT_COUNT) AS CPE_ISSUES FROM ".$prevtbl2." WHERE CATAGORY IN('CPE Issues_Faulty','CPE Issues_Other') AND EQUP_ID='".$row['EQUP_ID']."' AND SVRVICE IN (".$ser.")";

		$stid9=oci_parse($CON,$sql9);
		oci_execute($stid9);

		$row9=oci_fetch_array($stid9);
			
			$dis .= '<tr>
				<td style="font-size:11px;">CPE ISSUES:</td>
				<td style="font-size:11px;">'.$row9['CPE_ISSUES'].'</td>
			  </tr>';
		
		}
		
		if($info[$i] == 'UG'){
			
		$sql10="SELECT SUM(FAULT_COUNT) AS UG_FAULTS FROM ".$prevtbl2." WHERE CATAGORY='UG Issues' AND EQUP_ID='".$row['EQUP_ID']."' AND SVRVICE IN (".$ser.")";

		$stid10=oci_parse($CON,$sql10);
		oci_execute($stid10);

		$row10=oci_fetch_array($stid10);
			
			$dis .= '<tr>
				<td style="font-size:11px;">UG FAULTS:</td>
				<td style="font-size:11px;">'.$row10['UG_FAULTS'].'</td>
			  </tr>';
		
		}

	}
	
	
	}

$dis .= '</tbody></table></td>';

	$oneMlater = date("Y-m-d", strtotime("-1 month", $time));
	$tbloneMArr = explode('-',$oneMlater);
	$tbloneM = $tbloneMArr[1];
	$tbloneY = $tbloneMArr[0];
	$crnttbl = 'FAULT_INQ_'.$tbloneM.$tbloneY;
	$crtM = $tbloneM.'-'.$tbloneY;

	$sql11="SELECT VALUE AS CUSTOMER_BASE FROM FAULT_INQ_ATTLIST 
		   WHERE EQUP_ID = '".$row['EQUP_ID']."'
		   AND ATTRIBUTE = 'CUSTOMER_BASE' AND MONTH='".$crtM."'";
		   
		$stid11=oci_parse($CON,$sql11);
		oci_execute($stid11);

		$row11=oci_fetch_array($stid11);
	
	if($crtM!=''){
		
	$dis .= '<td><table class="table table-striped">
	<thead class="thead-light">
	<tr>
		<th style="font-size:11px;">MONTH:</td>
		<th style="font-size:11px;">'.$crtM.'</td>
	</tr>
	</thead>
	
	<tbody>
	<tr>
		<td style="font-size:11px;">CUSTOMER BASE:</td>
		<td style="font-size:11px;">'.$row11['CUSTOMER_BASE'].'</td>
	</tr>';
 
	$dcount = sizeof($info);
		
  	for($i=0; $i<$dcount; $i++){

		if($info[$i] == 'MSAN'){
		
		$sql12="SELECT SUM(FAULT_COUNT) AS MSAN_PORT_ISSUES FROM ".$crnttbl." WHERE CATAGORY='MSAN Port Issues' AND EQUP_ID='".$row['EQUP_ID']."' AND SVRVICE IN(".$ser.")";

		$stid12=oci_parse($CON,$sql12);
		oci_execute($stid12);

		$row12=oci_fetch_array($stid12);
	
		$dis .= '<tr>
				<td style="font-size:11px;">MSAN PORT ISSUES:</td>
				<td style="font-size:11px;">'.$row12['MSAN_PORT_ISSUES'].'</td>
			  </tr>';

		}
		
		if($info[$i] == 'CPE'){
			
		$sql13="SELECT SUM(FAULT_COUNT) AS CPE_ISSUES FROM ".$crnttbl." WHERE CATAGORY IN('CPE Issues_Faulty','CPE Issues_Other') AND EQUP_ID='".$row['EQUP_ID']."' AND SVRVICE IN (".$ser.")";

		$stid13=oci_parse($CON,$sql13);
		oci_execute($stid13);

		$row13=oci_fetch_array($stid13);
			
			$dis .= '<tr>
				<td style="font-size:11px;">CPE ISSUES:</td>
				<td style="font-size:11px;">'.$row13['CPE_ISSUES'].'</td>
			  </tr>';
		
		}
		
		if($info[$i] == 'UG'){
			
		$sql14="SELECT SUM(FAULT_COUNT) AS UG_FAULTS FROM ".$crnttbl." WHERE CATAGORY='UG Issues' AND EQUP_ID='".$row['EQUP_ID']."' AND SVRVICE IN (".$ser.")";

		$stid14=oci_parse($CON,$sql14);
		oci_execute($stid14);

		$row14=oci_fetch_array($stid14);
			
			$dis .= '<tr>
				<td style="font-size:11px;">UG FAULTS:</td>
				<td style="font-size:11px;">'.$row14['UG_FAULTS'].'</td>
			  </tr>';
		
		}

	}
	
	
	}

$dis .= '</tbody></table></td></tr></table>

</body>
</html>';

return $dis;
}
?>