<?php 

include 'env_data.php';

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
    $user = $_SESSION['$UID'];
	$rtom=$_SESSION['rtom'];
	
	if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null){	
		echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
	}
}
else 
{     
    echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
}
date_default_timezone_set("Asia/Colombo");




function OracleConnection($host,$user,$pass){

	$DB_HOST=$host;
	$DB_USERNAME=$user;
	$DB_PASSWORD=$pass;
  
	try {
  
	  $conn = new PDO("oci:dbname=" . $DB_HOST, $DB_USERNAME, $DB_PASSWORD);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  return $conn;
  
	} catch (PDOException $e) {
  
	  echo "<script type='text/javascript'>alert('Connection failed')</script>";
	  // print "Error: " . $e->getMessage();
  
	}
	  
}

function OracleConnection2($host,$user,$pass){

	$DB_HOST=$host;
	$DB_USERNAME=$user;
	$DB_PASSWORD=$pass;
  
	try {
  
	  $conn = new PDO("oci:dbname=" . $DB_HOST, $DB_USERNAME, $DB_PASSWORD);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  return $conn;
  
	} catch (PDOException $e) {
  
	  echo "<script type='text/javascript'>alert('Connection failed')</script>";
	  // print "Error: " . $e->getMessage();
  
	}
	  
}

function OracleConnection3($host,$user,$pass){

	$DB_HOST=$host;
	$DB_USERNAME=$user;
	$DB_PASSWORD=$pass;
  
	try {
  
	  $conn = new PDO("oci:dbname=" . $DB_HOST, $DB_USERNAME, $DB_PASSWORD);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  return $conn;
  
	} catch (PDOException $e) {
  
	  echo "<script type='text/javascript'>alert('Connection failed')</script>";
	  // print "Error: " . $e->getMessage();
  
	}
	  
}

$response = array();
$q= '$rtom';

$con = OracleConnection($db_host1,$username1,$password1);
$con2 = OracleConnection2($db_host2,$username2,$password2);
$con3 = OracleConnection3($db_host3,$username3,$password3);

if(isset($_GET['apicall'])){

	switch($_GET['apicall']){

		
		case 'boxfaultsdetails':
			
			$type = $_POST['type'];
			$time = $_POST['time'];

			$sql = "SELECT * FROM
					(
						SELECT 
							c.*, 
							CASE  
								WHEN ACTUAL_OUTAGE_HOURS <= 4 THEN '0'
								WHEN ACTUAL_OUTAGE_HOURS <= 6 THEN '1'
								WHEN ACTUAL_OUTAGE_HOURS <= 8 THEN '2'
								WHEN ACTUAL_OUTAGE_HOURS <= 24 THEN '3'
								ELSE '4' 
							END AS TIME_RANGE,
							CASE  
								WHEN CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER') THEN 'MEGALINE'
								WHEN CIRT_SERT_ABBREVIATION IN ('BB-INTERNET COPPER','ADSL') THEN 'BROADBAND'
								WHEN CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' THEN 'PEOTV'
								WHEN CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') THEN 'LTE'
								WHEN CIRT_SERT_ABBREVIATION LIKE '%FTTH' THEN 'FTTH'
								WHEN CIRT_SERT_ABBREVIATION LIKE 'D-%' THEN 'DATA'
								ELSE 'OTHER' 
							END AS SERVICE_GROUP
						FROM 
						(
							SELECT  b.*,
									(SYSDATE-PROM_ACTUAL_GEN_TIME)*24  OUTAGE_HOURS,
									(SYSDATE-PROM_ACTUAL_GEN_TIME)*24 -(TRUNC(SYSDATE)-TRUNC(PROM_ACTUAL_GEN_TIME) )* 10 ACTUAL_OUTAGE_HOURS
							FROM (
								SELECT
									a.*,
									CASE 
										WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') < 8 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
										WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') > 22 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME+1,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
										ELSE PROM_ACTUAL_TIME 
									END AS PROM_ACTUAL_GEN_TIME
								FROM (
									SELECT  
										PROM_NUMBER,PROM_DESCRIPTION, PROM_WORG_NAME, CIRT_DISPLAYNAME,PROM_CLEARED,PROM_REPORTED,PROM_REASSIGNED,
										CASE WHEN PROM_REASSIGNED IS NOT NULL THEN PROM_REASSIGNED ELSE PROM_REPORTED END AS PROM_ACTUAL_TIME, CIRT_SERT_ABBREVIATION, PROM_PRIORITY, PROM_REGN_CODE,PROM_RTOM
									FROM OSS_FAULTS.REALTIME_FAULTS_WGGROUP
									WHERE (
										CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER','BB-INTERNET COPPER','ADSL','E-IPTV COPPER','V-VOICE','BB-INTERNET')
										OR CIRT_SERT_ABBREVIATION LIKE 'D-%' 
										OR CIRT_SERT_ABBREVIATION LIKE '%FTTH'
									)
									AND PROM_WGGROUP = 'OPMC'
									AND PROM_CLEARED IS NULL
									AND PROM_RTOM = ?
								) a
							) b
						) c
					)
					WHERE TIME_RANGE = ?
					AND SERVICE_GROUP = ?"; 

			$con_query =  $con2->prepare($sql);

			try{
				if($con_query->execute([$rtom,$time, $type]))
				{
					$sel = '<table style="width:630px;" border = "1" id="tbl_data"><tr><td>FAULT NUMBER</td><td>WG</td><td>CCT</td><td>PRI.</td>';
				
					if($type == "FTTH"){
						$sel .= '<td>OP. STATUS</td><td>RX. Power</td><td>Cause for the recent down</td>';
					}
				
					$sel .= '<td>PHONE NO</td></tr>';

					$outputs = $con_query->fetchAll(PDO::FETCH_ASSOC);

					foreach ($outputs as $output) {
						if($type == "FTTH"){	
													   
							$sql2=" SELECT RX_POWER,STATUS,CAUSE 
							        FROM LINE_QUALITY
									WHERE SUBSTR(CCT,-7) = SUBSTR(?,-7)";
								  
							$con_query2 =  $con2->prepare($sql2);

							try{
								if($con_query2->execute([$output["CIRT_DISPLAYNAME"]]))
								{
									$output2 = $con_query2->fetch(PDO::FETCH_ASSOC);
								}else{
									$response['error'] = true;
									$response['reply'] = 'Error Occured'; 
								}
							}catch(PDOException $e){
								$response['error'] = true;
								$response['reply'] = $e; 
							}				
						}
			
						$sel .= '<tr><td>'.$output["PROM_NUMBER"].'</td><td>'.$output["PROM_WORG_NAME"].'</td><td>'.$output["CIRT_DISPLAYNAME"].'</td><td>'.$output["PROM_PRIORITY"].'</td>';
							
						if($type == "FTTH"){
							if($output2){
								$sel .= "<td>".$output2["STATUS"]."</td><td>".$output2["RX_POWER"]."</td><td>".$output2["CAUSE"]."</td>";
							}else{
								$sel .= "<td></td><td></td><td></td>";
							}
						}
								
						$sel .= '<td><input type="button" value="VIEW" id="'.$output["PROM_NUMBER"].'btn" class="btn btn-warning btn-md" onclick="viewNo('.$output["PROM_NUMBER"].');"/></td></tr>';

					}

					$response['error'] = false;
					$response['reply'] = $sel; 
					
				}else{

					$response['error'] = true;
					$response['reply'] = 'Error Occured'; 

				}
			}catch(PDOException $e){
				$response['error'] = true;
				$response['reply'] = $e; 
		  	}
		
		break;
		
		case 'boxfaultsdetailspri':

			$type = $_POST['type'];
			$time = $_POST['time'];

			$sql = "SELECT * FROM
					(
						SELECT 
							c.*, 
							CASE  
								WHEN ACTUAL_OUTAGE_HOURS <= 4 THEN '0'
								WHEN ACTUAL_OUTAGE_HOURS <= 6 THEN '1'
								WHEN ACTUAL_OUTAGE_HOURS <= 8 THEN '2'
								WHEN ACTUAL_OUTAGE_HOURS <= 24 THEN '3'
								ELSE '4' 
							END AS TIME_RANGE,
							CASE  
								WHEN CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER') THEN 'MEGALINE'
								WHEN CIRT_SERT_ABBREVIATION IN ('BB-INTERNET COPPER','ADSL') THEN 'BROADBAND'
								WHEN CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' THEN 'PEOTV'
								WHEN CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') THEN 'LTE'
								WHEN CIRT_SERT_ABBREVIATION LIKE '%FTTH' THEN 'FTTH'
								WHEN CIRT_SERT_ABBREVIATION LIKE 'D-%' THEN 'DATA'
								ELSE 'OTHER' 
							END AS SERVICE_GROUP
						FROM 
						(
							SELECT  b.*,
									(SYSDATE-PROM_ACTUAL_GEN_TIME)*24  OUTAGE_HOURS,
									(SYSDATE-PROM_ACTUAL_GEN_TIME)*24 -(TRUNC(SYSDATE)-TRUNC(PROM_ACTUAL_GEN_TIME) )* 10 ACTUAL_OUTAGE_HOURS
							FROM (
								SELECT
									a.*,
									CASE 
										WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') < 8 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
										WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') > 22 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME+1,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
										ELSE PROM_ACTUAL_TIME 
									END AS PROM_ACTUAL_GEN_TIME
								FROM (
									SELECT  
										PROM_NUMBER,PROM_DESCRIPTION, PROM_WORG_NAME, CIRT_DISPLAYNAME,PROM_CLEARED,PROM_REPORTED,PROM_REASSIGNED,
										CASE WHEN PROM_REASSIGNED IS NOT NULL THEN PROM_REASSIGNED ELSE PROM_REPORTED END AS PROM_ACTUAL_TIME, CIRT_SERT_ABBREVIATION, PROM_PRIORITY, PROM_REGN_CODE,PROM_RTOM
									FROM OSS_FAULTS.REALTIME_FAULTS_WGGROUP
									WHERE (
										CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER','BB-INTERNET COPPER','ADSL','E-IPTV COPPER','V-VOICE','BB-INTERNET')
										OR CIRT_SERT_ABBREVIATION LIKE 'D-%' 
										OR CIRT_SERT_ABBREVIATION LIKE '%FTTH'
									)
									AND PROM_WGGROUP = 'OPMC'
									AND PROM_CLEARED IS NULL
									AND PROM_PRIORITY = 1
									AND PROM_RTOM = ?
								) a
							) b
						) c
					)
					WHERE TIME_RANGE = ?
					AND SERVICE_GROUP = ?"; 

			$con_query =  $con2->prepare($sql);

			try{
				if($con_query->execute([$rtom,$time, $type]))
				{
					$sel = '<table border = "1" id="tbl_data2"><tr><td>FAULT NUMBER</td><td>WG</td><td>CCT</td><td>PRI</td>';
				
					if($type == "FTTH"){
						$sel .= '<td>OP. STATUS</td><td>RX. Power</td><td>Cause for the recent down</td>';
					}
				
					$sel .= '<td>PHONE NO</td></tr>';

					$outputs = $con_query->fetchAll(PDO::FETCH_ASSOC);

					foreach ($outputs as $output) {
						if($type == "FTTH"){	
							
							$sql2 = "	SELECT RX_POWER,STATUS,CAUSE 
										FROM LINE_QUALITY
										WHERE SUBSTR(CCT,-7) = SUBSTR(?,-7)"; 

							$con_query2 =  $con2->prepare($sql2);

							if($con_query2->execute($output["CIRT_DISPLAYNAME"]))
							{
								$output2 = $con_query->fetch(PDO::FETCH_ASSOC);
							}else{
								$response['error'] = true;
								$response['reply'] = 'Error Occured'; 
							}
							
						}
		
						$sel = $sel."<tr><td>".$output["PROM_NUMBER"]."</td><td>".$output["PROM_WORG_NAME"]."</td><td>".$output["CIRT_DISPLAYNAME"]."</td><td>".$output["PROM_PRIORITY"]."</td>";
							
						if($type == "FTTH"){
							if($output2){
								$sel .= "<td>".$output2["STATUS"]."</td><td>".$output2["RX_POWER"]."</td><td>".$output2["CAUSE"]."</td>";
							}else{
								$sel .= "<td></td><td></td><td></td>";
							}
						}
							
						$sel .="<td><input type='button' value='VIEW' id='".$output["PROM_NUMBER"]."btn' class='btn btn-warning btn-sm' onclick='viewNo2(".$output["PROM_NUMBER"].");'/></td></tr>";
					}
				
					$response['error'] = false;
					$response['reply'] = $sel; 
					
				}else{

					$response['error'] = true;
					$response['reply'] = 'Error Occured'; 

				}
			}catch(PDOException $e){
				$response['error'] = true;
				$response['reply'] = $e; 
		  	}
		
		break;
			
		case 'pendingbox':	
			
			$sql = "SELECT TIME_RANGE, count(*) AS COUNT,SERVICE_GROUP FROM
					(
						SELECT 
							c.*, 
							CASE  
								WHEN ACTUAL_OUTAGE_HOURS <= 4 THEN '0'
								WHEN ACTUAL_OUTAGE_HOURS <= 6 THEN '1'
								WHEN ACTUAL_OUTAGE_HOURS <= 8 THEN '2'
								WHEN ACTUAL_OUTAGE_HOURS <= 24 THEN '3'
								ELSE '4' 
							END AS TIME_RANGE,
							CASE  
								WHEN CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER') THEN 'MEGALINE'
								WHEN CIRT_SERT_ABBREVIATION IN ('BB-INTERNET COPPER','ADSL') THEN 'BROADBAND'
								WHEN CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' THEN 'PEOTV'
								WHEN CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') THEN 'LTE'
								WHEN CIRT_SERT_ABBREVIATION LIKE '%FTTH' THEN 'FTTH'
								WHEN CIRT_SERT_ABBREVIATION LIKE 'D-%' THEN 'DATA'
								ELSE 'OTHER' 
							END AS SERVICE_GROUP
						FROM 
						(
							SELECT  b.*,
									(SYSDATE-PROM_ACTUAL_GEN_TIME)*24  OUTAGE_HOURS,
									(SYSDATE-PROM_ACTUAL_GEN_TIME)*24 -(TRUNC(SYSDATE)-TRUNC(PROM_ACTUAL_GEN_TIME) )* 10 ACTUAL_OUTAGE_HOURS
							FROM (
								SELECT
									a.*,
									CASE 
										WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') < 8 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
										WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') > 22 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME+1,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
										ELSE PROM_ACTUAL_TIME 
									END AS PROM_ACTUAL_GEN_TIME
								FROM (
									SELECT  
										PROM_NUMBER,PROM_DESCRIPTION, PROM_WORG_NAME, CIRT_DISPLAYNAME,PROM_CLEARED,PROM_REPORTED,PROM_REASSIGNED,
										CASE WHEN PROM_REASSIGNED IS NOT NULL THEN PROM_REASSIGNED ELSE PROM_REPORTED END AS PROM_ACTUAL_TIME, CIRT_SERT_ABBREVIATION, PROM_PRIORITY, PROM_REGN_CODE,PROM_RTOM
									FROM OSS_FAULTS.REALTIME_FAULTS_WGGROUP
									WHERE (
										CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER','BB-INTERNET COPPER','ADSL','E-IPTV COPPER','V-VOICE','BB-INTERNET')
										OR CIRT_SERT_ABBREVIATION LIKE 'D-%' 
										OR CIRT_SERT_ABBREVIATION LIKE '%FTTH'
									)
									AND PROM_WGGROUP = 'OPMC'
									AND PROM_CLEARED IS NULL
									AND PROM_RTOM = ?
								) a
							) b
						) c
					)
					GROUP BY TIME_RANGE, SERVICE_GROUP
					ORDER BY TIME_RANGE,SERVICE_GROUP"; 

			$con_query =  $con2->prepare($sql);

			try{
				if($con_query->execute([$rtom]))
				{

					$outputs = $con_query->fetchAll(PDO::FETCH_ASSOC);

					$response['error'] = false;
					$response['reply'] = $outputs; 
					
				}else{

					$response['error'] = true;
					$response['reply'] = 'Error Occured'; 

				}
			}catch(PDOException $e){
				$response['error'] = true;
				$response['reply'] = $e; 
		  	}
		
		break;
		
		case 'pendingboxpri':

			$sql = "SELECT TIME_RANGE, count(*) AS COUNT,SERVICE_GROUP FROM
					(
						SELECT 
							c.*, 
							CASE  
								WHEN ACTUAL_OUTAGE_HOURS <= 4 THEN '0'
								WHEN ACTUAL_OUTAGE_HOURS <= 6 THEN '1'
								WHEN ACTUAL_OUTAGE_HOURS <= 8 THEN '2'
								WHEN ACTUAL_OUTAGE_HOURS <= 24 THEN '3'
								ELSE '4' 
							END AS TIME_RANGE,
							CASE  
								WHEN CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER') THEN 'MEGALINE'
								WHEN CIRT_SERT_ABBREVIATION IN ('BB-INTERNET COPPER','ADSL') THEN 'BROADBAND'
								WHEN CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' THEN 'PEOTV'
								WHEN CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') THEN 'LTE'
								WHEN CIRT_SERT_ABBREVIATION LIKE '%FTTH' THEN 'FTTH'
								WHEN CIRT_SERT_ABBREVIATION LIKE 'D-%' THEN 'DATA'
								ELSE 'OTHER' 
							END AS SERVICE_GROUP
						FROM 
						(
							SELECT  b.*,
									(SYSDATE-PROM_ACTUAL_GEN_TIME)*24  OUTAGE_HOURS,
									(SYSDATE-PROM_ACTUAL_GEN_TIME)*24 -(TRUNC(SYSDATE)-TRUNC(PROM_ACTUAL_GEN_TIME) )* 10 ACTUAL_OUTAGE_HOURS
							FROM (
								SELECT
									a.*,
									CASE 
										WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') < 8 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
										WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') > 22 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME+1,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
										ELSE PROM_ACTUAL_TIME 
									END AS PROM_ACTUAL_GEN_TIME
								FROM (
									SELECT  
										PROM_NUMBER,PROM_DESCRIPTION, PROM_WORG_NAME, CIRT_DISPLAYNAME,PROM_CLEARED,PROM_REPORTED,PROM_REASSIGNED,
										CASE WHEN PROM_REASSIGNED IS NOT NULL THEN PROM_REASSIGNED ELSE PROM_REPORTED END AS PROM_ACTUAL_TIME, CIRT_SERT_ABBREVIATION, PROM_PRIORITY, PROM_REGN_CODE,PROM_RTOM
									FROM OSS_FAULTS.REALTIME_FAULTS_WGGROUP
									WHERE (
										CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER','BB-INTERNET COPPER','ADSL','E-IPTV COPPER','V-VOICE','BB-INTERNET')
										OR CIRT_SERT_ABBREVIATION LIKE 'D-%' 
										OR CIRT_SERT_ABBREVIATION LIKE '%FTTH'
									)
									AND PROM_WGGROUP = 'OPMC'
									AND PROM_CLEARED IS NULL
									AND PROM_PRIORITY = 1
									AND PROM_RTOM = ?
								) a
							) b
						) c
					)
					GROUP BY TIME_RANGE, SERVICE_GROUP
					ORDER BY TIME_RANGE,SERVICE_GROUP"; 

			$con_query =  $con2->prepare($sql);

			try{
				if($con_query->execute([$rtom]))
				{

					$outputs = $con_query->fetchAll(PDO::FETCH_ASSOC);
				
					$response['error'] = false;
					$response['reply'] = $outputs; 
					
				}else{

					$response['error'] = true;
					$response['reply'] = 'Error Occured'; 

				}
			}catch(PDOException $e){
				$response['error'] = true;
				$response['reply'] = $e; 
		  	}		
		
		break;
		
		case 'loadReqTelNo':

			$F_id = $_POST['F_id'];
			
			$sql3="SELECT PROM_REPORTEDCONTACT from CLARITY.problems where PROM_NUMBER = ?";
			
			$con_query3 =  $con3->prepare($sql3);

			try{
				if($con_query3->execute([$F_id]))
				{
					
					$outputs = $con_query3->fetch(PDO::FETCH_ASSOC);
					$sel = $outputs['PROM_REPORTEDCONTACT'];

					$response['error'] = false;
					$response['reply'] = $sel; 
					
				}else{

					$response['error'] = true;
					$response['reply'] = 'Error Occured'; 

				}
			}catch(PDOException $e){
				$response['error'] = true;
				$response['reply'] = $e; 
		  	}
		
		break;
		
		case 'loadReqTelNo2':
			
			$F_id = $_POST['F_id'];
			
			$sql3="SELECT PROM_REPORTEDCONTACT from CLARITY.problems where PROM_NUMBER = ?";

			$con_query3 =  $con3->prepare($sql3);

			try{
				if($con_query3->execute([$F_id]))
				{
					
					$outputs = $con_query3->fetch(PDO::FETCH_ASSOC);
					$sel = $outputs['PROM_REPORTEDCONTACT'];

					$response['error'] = false;
					$response['reply'] = $sel; 
					
				}else{

					$response['error'] = true;
					$response['reply'] = 'Error Occured'; 

				}
			}catch(PDOException $e){
				$response['error'] = true;
				$response['reply'] = $e; 
		  	}
		
		break;
		
		case 'faultnew':		
		
			$sql =  "	SELECT * FROM 
							(
								SELECT 
									PROM_REGN_CODE, 
									CASE  
										WHEN ACTUAL_OUTAGE_HOURS <= 4 THEN '0'
										WHEN ACTUAL_OUTAGE_HOURS <= 6 THEN '1'
										WHEN ACTUAL_OUTAGE_HOURS <= 8 THEN '2'
										WHEN ACTUAL_OUTAGE_HOURS <= 24 THEN '3'
										ELSE '4' 
									END AS TIME_RANGE,
									CASE  
										WHEN CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER') THEN 'MEGALINE'
										WHEN CIRT_SERT_ABBREVIATION IN ('BB-INTERNET COPPER','ADSL') THEN 'BROADBAND'
										WHEN CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' THEN 'PEOTV'
										WHEN CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') THEN 'LTE'
										WHEN CIRT_SERT_ABBREVIATION LIKE '%FTTH' THEN 'FTTH'
										-- WHEN CIRT_SERT_ABBREVIATION LIKE 'D-%' THEN 'DATA'
										ELSE 'OTHER' 
									END AS SERVICE_GROUP,
									PROM_NUMBER
								FROM 
								(
									SELECT  b.*,
											(SYSDATE-PROM_ACTUAL_GEN_TIME)*24  OUTAGE_HOURS,
											(SYSDATE-PROM_ACTUAL_GEN_TIME)*24 -(TRUNC(SYSDATE)-TRUNC(PROM_ACTUAL_GEN_TIME) )* 10 ACTUAL_OUTAGE_HOURS
									FROM (
										SELECT
											a.*,
											CASE 
												WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') < 8 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
												WHEN TO_CHAR(PROM_ACTUAL_TIME,'hh24') > 22 THEN TO_DATE(TO_CHAR(PROM_ACTUAL_TIME+1,'mm,dd,yyyy')||' 08:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
												ELSE PROM_ACTUAL_TIME 
											END AS PROM_ACTUAL_GEN_TIME
										FROM (
											SELECT  
												PROM_NUMBER,PROM_DESCRIPTION, PROM_WORG_NAME, CIRT_DISPLAYNAME,PROM_CLEARED,PROM_REPORTED,PROM_REASSIGNED,
												CASE WHEN PROM_REASSIGNED IS NOT NULL THEN PROM_REASSIGNED ELSE PROM_REPORTED END AS PROM_ACTUAL_TIME, CIRT_SERT_ABBREVIATION, PROM_PRIORITY, PROM_REGN_CODE,PROM_RTOM
											FROM OSS_FAULTS.REALTIME_FAULTS_WGGROUP
											WHERE (
												CIRT_SERT_ABBREVIATION IN ('AB-CAB', 'V-VOICE COPPER','BB-INTERNET COPPER','ADSL','E-IPTV COPPER','V-VOICE','BB-INTERNET')
												OR CIRT_SERT_ABBREVIATION LIKE 'D-%' 
												OR CIRT_SERT_ABBREVIATION LIKE '%FTTH'
											)
											AND PROM_WGGROUP = 'OPMC'
											AND PROM_CLEARED IS NULL
											AND PROM_RTOM = ?
										) a
									) b
								) c
							)
							PIVOT
							(
								COUNT(PROM_NUMBER)
								FOR (SERVICE_GROUP, TIME_RANGE)
								IN (
									('MEGALINE', '0') AS MEGALINE_T1 , ('MEGALINE', '1')AS MEGALINE_T2, ('MEGALINE', '2')AS MEGALINE_T3, ('MEGALINE', '3')AS MEGALINE_T4 ,('MEGALINE', '4')AS MEGALINE_T5 ,
									('BROADBAND', '0')AS BROADBAND_T1 , ('BROADBAND', '1')AS BROADBAND_T2, ('BROADBAND', '2')AS BROADBAND_T3, ('BROADBAND', '3') AS BROADBAND_T4 ,('BROADBAND', '4') AS BROADBAND_T5 ,
									('PEOTV', '0') AS PEOTV_T1 , ('PEOTV', '1') AS PEOTV_T2, ('PEOTV', '2')AS PEOTV_T3, ('PEOTV', '3') AS PEOTV_T4 , ('PEOTV', '4') AS PEOTV_T5 , 
									('FTTH', '0') FTTH_T1 , ('FTTH', '1')AS  FTTH_T2, ('FTTH', '2') FTTH_T3, ('FTTH', '3') AS FTTH_T4 ,('FTTH', '4') AS FTTH_T5 , 
									('LTE', '0') AS LTE_T1 , ('LTE', '1') AS LTE_T2, ('LTE', '2') LTE_T3, ('LTE', '3') AS LTE_T4 ,('LTE', '4') AS LTE_T5 
								)
							)
						ORDER BY PROM_REGN_CODE";

						$con_query =  $con2->prepare($sql);

						try{
							if($con_query->execute([$rtom]))
							{
								$result =	'<table class="table table-sm" style="text-align: center;" >
												<thead style="position: sticky; top: 0;">
													<tr bgcolor="#0A3981" style="color:#ffffff">
														<th></th>
														<th colspan="6" bgcolor="#f1948a" style="color:#ffffff">MEGALINE</th>
														<th colspan="6" bgcolor="#d2b4de" style="color:#ffffff">BROADBAND</th>
														<th colspan="6" bgcolor="#7dcea0" style="color:#ffffff">PEOTV</th>
														<th colspan="6" bgcolor="#fad7a0" style="color:#ffffff">FTTH</th>
														<th colspan="6" bgcolor="#5dade2" style="color:#ffffff">LTE</th>
													</tr>				
													<tr bgcolor="#0A3981" style="color:#ffffff">
														<th>&nbsp;LEA&nbsp;</th>
														<th>0&#60;hrs&#60;4</th>
														<th>4&#60;hrs&#60;6</th>
														<th>6&#60;hrs&#60;8</th>
														<th>8&#60;hrs&#60;24</th>
														<th>24&#60;hrs</th>
														<th>0&#60;hrs&#60;4</th>
														<th>4&#60;hrs&#60;6</th>
														<th>6&#60;hrs&#60;8</th>
														<th>8&#60;hrs&#60;24</th>
														<th>24&#60;hrs</th>
														<th>0&#60;hrs&#60;4</th>
														<th>4&#60;hrs&#60;6</th>
														<th>6&#60;hrs&#60;8</th>
														<th>8&#60;hrs&#60;24</th>
														<th>24&#60;hrs</th>
														<th>0&#60;hrs&#60;4</th>
														<th>4&#60;hrs&#60;6</th>
														<th>6&#60;hrs&#60;8</th>
														<th>8&#60;hrs&#60;24</th>
														<th>24&#60;hrs</th>
														<th>0&#60;hrs&#60;4</th>
														<th>4&#60;hrs&#60;6</th>
														<th>6&#60;hrs&#60;8</th>
														<th>8&#60;hrs&#60;24</th>
														<th>24&#60;hrs</th>
													</tr>
												</thead>
												<tbody id="rDatatbl" style="color:#0A3981; font-weight: 900;">';

								$outputs = $con_query->fetchAll(PDO::FETCH_ASSOC);

								foreach ($outputs as $output) {
									$result .=	'<tr>
													<td bgcolor="#fef9e7">'.$output['PROM_REGN_CODE'].'</td>
													<td bgcolor="#f1948a">'.$output['MEGALINE_T1'].'</td>
													<td bgcolor="#f1948a">'.$output['MEGALINE_T2'].'</td>
													<td bgcolor="#f1948a">'.$output['MEGALINE_T3'].'</td>
													<td bgcolor="#f1948a">'.$output['MEGALINE_T4'].'</td>
													<td bgcolor="#f1948a">'.$output['MEGALINE_T5'].'</td>
													<td bgcolor="#d2b4de">'.$output['BROADBAND_T1'].'</td>
													<td bgcolor="#d2b4de">'.$output['BROADBAND_T2'].'</td>
													<td bgcolor="#d2b4de">'.$output['BROADBAND_T3'].'</td>
													<td bgcolor="#d2b4de">'.$output['BROADBAND_T4'].'</td>
													<td bgcolor="#d2b4de">'.$output['BROADBAND_T5'].'</td>
													<td bgcolor="#7dcea0">'.$output['PEOTV_T1'].'</td>
													<td bgcolor="#7dcea0">'.$output['PEOTV_T2'].'</td>
													<td bgcolor="#7dcea0">'.$output['PEOTV_T3'].'</td>
													<td bgcolor="#7dcea0">'.$output['PEOTV_T4'].'</td>
													<td bgcolor="#7dcea0">'.$output['PEOTV_T5'].'</td>
													<td bgcolor="#fad7a0">'.$output['FTTH_T1'].'</td>
													<td bgcolor="#fad7a0">'.$output['FTTH_T2'].'</td>
													<td bgcolor="#fad7a0">'.$output['FTTH_T3'].'</td>
													<td bgcolor="#fad7a0">'.$output['FTTH_T4'].'</td>
													<td bgcolor="#fad7a0">'.$output['FTTH_T5'].'</td>
													<td bgcolor="#5dade2">'.$output['LTE_T1'].'</td>
													<td bgcolor="#5dade2">'.$output['LTE_T2'].'</td>
													<td bgcolor="#5dade2">'.$output['LTE_T3'].'</td>
													<td bgcolor="#5dade2">'.$output['LTE_T4'].'</td>
													<td bgcolor="#5dade2">'.$output['LTE_T5'].'</td>
												</tr>';
								}
								$response['error'] = false;
								$response['reply'] = $result; 	
							}else{
								$response['error'] = true;
								$response['reply'] = 'Error Occured'; 
							}
						}catch(PDOException $e){
							$response['error'] = true;
							$response['reply'] = $e; 
						}
						
						// $response['error'] = false;
						// $response['reply'] = $result; 
			
		
		break;

		// case 'lastupadteddl':
			
		// 	$sql="SELECT TO_CHAR(LAST_DDL_TIME,'YYYY-MM-DD HH:MI:SS AM') AS LAST_DDL_TIME FROM USER_OBJECTS WHERE OBJECT_NAME='RTSU_NOT_CLEARED_FAULTS_UPDATE'";

		// 	$con_query =  $con->prepare($sql);

		// 	try{
		// 		if($con_query->execute())
		// 		{
					
		// 			$outputs = $con_query->fetch(PDO::FETCH_ASSOC);
		// 			$lastDate = $outputs['LAST_DDL_TIME'];

		// 			$response['error'] = false;
		// 			$response['reply'] = $lastDate; 
					
		// 		}else{

		// 			$response['error'] = true;
		// 			$response['reply'] = 'Error Occured'; 

		// 		}
		// 	}catch(PDOException $e){
		// 		$response['error'] = true;
		// 		$response['reply'] = $e; 
		//   	}

		// break;

		default: 
				$response['error'] = true;
				$response['message'] = 'Invalid api call';
	}
		
}else{
	header("HTTP/1.0 404 Not Found");
	echo "<h1>404 Not Found</h1>";
	echo "The page that you have requested could not be found.";
	exit();
}
	

	header('Content-Type: application/json');
	echo json_encode($response);
	
?>