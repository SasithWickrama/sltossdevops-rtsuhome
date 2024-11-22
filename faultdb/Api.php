<?php 
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
    $user = $_SESSION['$UID'];
	$rtom=$_SESSION['rtom'];
	
	if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null   ){	
	echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
	}
}
else 
{     
    echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
}
date_default_timezone_set("Asia/Colombo");




function OracleConnection(){

	$db = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = prxd1-scan)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = HADWH)
    ) )" ;


	if($c = oci_connect("JASREP", "slt#jasrep", $db))
	{
		return $c;
	}
	else
	{
	   $err = OCIError();
	   echo "<script type='text/javascript'>alert('Connection failed')</script>";
	}
	
}

$response = array();
$q= '$rtom';

if(isset($_GET['apicall'])){

	switch($_GET['apicall']){


		case 'repfsummary':	
			
			$con = OracleConnection();
			$sql = "SELECT * FROM
					(select  CASE 
					WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
					WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
					WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
					END AS SVTYPE , OUTAGE  from (
					select xx.PROM_NUMBER,xx.CIRT_DISPLAYNAME, xx.CIRT_SERT_ABBREVIATION,xx.PROM_REGN_CODE ,yy.PROM_REPORTED, CASE
						WHEN (sysdate - yy.PROM_REPORTED ) = 0  THEN '0' 
						WHEN  (SYSDATE - yy.PROM_REPORTED ) < 1 THEN 'T<1' 
						WHEN (SYSDATE - yy.PROM_REPORTED ) < 7 THEN '1<T<7' 
						WHEN (SYSDATE - yy.PROM_REPORTED ) <90 THEN '7<T<3M'
						WHEN (SYSDATE - yy.PROM_REPORTED ) > 90  THEN '3M<T'
						END AS OUTAGE
					from (select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE 
					from OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is null ) xx,
					(select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE
					from OSS_FAULTS.REALTIME_FAULTS_DELETE where PROM_CLEARED is not null
					union all
					select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE
					from OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is not null
					union all
					select PROM_NUMBER, sysdate as PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE 
					from OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is null 
					and PROM_REGN_CODE IN (SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom'))
					and CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER',
					'V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH','V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET')
					and CIRT_DISPLAYNAME NOT IN (select distinct xx.CIRT_DISPLAYNAME
					from (select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE 
					from OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is null ) xx,
					(select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE
					from OSS_FAULTS.REALTIME_FAULTS_DELETE where PROM_CLEARED is not null
					union all
					select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE
					from OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is not null)yy
					where xx.CIRT_DISPLAYNAME = yy.CIRT_DISPLAYNAME
					and xx.PROM_REGN_CODE IN (SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom')) 
					and xx.CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER',
					'V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH','V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET'))
					)yy
					where xx.CIRT_DISPLAYNAME = yy.CIRT_DISPLAYNAME
					and xx.PROM_REGN_CODE IN (SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom')) 
					and yy.PROM_REPORTED > add_months(sysdate, - 6) --sysdate - interval '6' month 
					and xx.CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER',
					'V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH','V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET'))
					)
					PIVOT
					(
					  COUNT(OUTAGE)
					  FOR OUTAGE IN ('T<1', '1<T<7' , '7<T<3M', '3M<T','0')
					)";
					
					
					/* SELECT * FROM
					(
					SELECT SVTYPE , CASE WHEN PROM_CLEARED IS NOT NULL THEN CASE
					WHEN   (TO_DATE (PROM_REPORTED, 'dd,mm,yyyy:hh:mi:ss pm') - TO_DATE (PROM_CLEARED , 'dd,mm,yyyy:hh:mi:ss pm')) < 1 THEN 'T<1' 
					WHEN  (TO_DATE (PROM_REPORTED, 'dd,mm,yyyy:hh:mi:ss pm') - TO_DATE (PROM_CLEARED , 'dd,mm,yyyy:hh:mi:ss pm')) < 7 THEN '1<T<7' 
					WHEN  (TO_DATE (PROM_REPORTED, 'dd,mm,yyyy:hh:mi:ss pm') - TO_DATE (PROM_CLEARED , 'dd,mm,yyyy:hh:mi:ss pm')) <90 THEN '7<T<3M'
					WHEN  (TO_DATE (PROM_REPORTED, 'dd,mm,yyyy:hh:mi:ss pm') - TO_DATE (PROM_CLEARED , 'dd,mm,yyyy:hh:mi:ss pm')) > 90  THEN '3M<T'
					END 
					WHEN PROM_CLEARED IS NULL THEN '0'
					END AS OUTAGE ,PROM_NUMBER
					FROM
					(SELECT DISTINCT Y.PROM_NUMBER ,Y.CIRT_DISPLAYNAME, Y.PROM_REPORTED ,
					CASE 
					WHEN Y.CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
					WHEN Y.CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
					WHEN Y.CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
					END AS SVTYPE,
					MIN (X.PROM_CLEARED)  PROM_CLEARED
					FROM  ( SELECT A.CIRT_DISPLAYNAME, TO_CHAR(A.PROM_NUMBER )PROM_NUMBER,TO_DATE (A.PROM_CLEARED, 'mm,dd,yyyy:hh:mi:ss pm')PROM_CLEARED FROM CUMULATIVE_REP_FAULTS A 
					WHERE A.PROM_PCAT_NAME IS NOT NULL 
					UNION  ALL
					SELECT B.CIRT_DISPLAYNAME, TO_CHAR(B.PROM_NUMBER )  ,PROM_CLEARED  FROM OSS_FAULTS.REALTIME_FAULTS_DELETE B
					WHERE  B.CAUSE_OF_FAULT IS NOT NULL  ) X ,OSS_FAULTS.REALTIME_FAULTS Y
					WHERE X.CIRT_DISPLAYNAME(+)  = Y.CIRT_DISPLAYNAME 
					AND Y.PROM_REGN_CODE IN (SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom')) 
					AND  Y.PROM_CLEARED IS NULL
					GROUP BY Y.PROM_NUMBER,Y.CIRT_DISPLAYNAME,Y.PROM_REPORTED,CASE 
					WHEN Y.CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
					WHEN Y.CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
					WHEN Y.CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
					END)
					)
					PIVOT
					(
					  COUNT(DISTINCT  PROM_NUMBER)
					  FOR OUTAGE IN ('T<1', '1<T<7' , '7<T<3M', '3M<T','0')
					)
					ORDER BY SVTYPE*/
			
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$result = array();
				$result[$i] = array(); $result[$i]=array('Last Fault< 1Day', 'Last Fault between 1day and 7days' , 'Last Fault between 7days and 3month', 'Last Fault befor 3months ','No Previous Faults');
				$i++;
				while ($row = oci_fetch_array($userid))
						{							
							$result[$i] = array();
							$result[$i] = array($row[1],$row[2],$row[3],$row[4],$row[5]);
							$i++;
						}
				$response['error'] = false;
				$response['reply'] = $result;
			
		break;
		
		case 'repfaults':		
		
			$con = OracleConnection();
				
			$sql = "  SELECT * FROM
					( 
					SELECT ALLD,SVTYPE,TOTAL,PROM_NUMBER FROM (
						SELECT REP_HOUR,CASE 
					WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
					WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
					WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
					END AS SVTYPE ,PROM_NUMBER,COUNT( PROM_NUMBER ) OVER ( PARTITION BY REP_HOUR ) AS TOTAL
					FROM (SELECT PROM_REGN_CODE, PROM_NUMBER,CIRT_SERT_ABBREVIATION , TO_CHAR(PROM_REPORTED, 'MM/DD/YYYY hh24')REP_HOUR 
					FROM (SELECT PROM_NUMBER , PROM_REPORTED , PROM_REGN_CODE , PROM_CLEARED ,CIRT_SERT_ABBREVIATION FROM OSS_FAULTS.REALTIME_FAULTS 
					UNION SELECT PROM_NUMBER , PROM_REPORTED , PROM_REGN_CODE , PROM_CLEARED ,CIRT_SERT_ABBREVIATION  FROM OSS_FAULTS.REALTIME_FAULTS_DELETE)
						WHERE PROM_REPORTED > TO_DATE (TO_CHAR(SYSDATE - (12 / 24), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') 
						AND PROM_REGN_CODE IN(SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom'))) 
						),( SELECT TO_CHAR(SYSDATE-(0/24), 'MM/DD/YYYY hh24') ALLD FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(1/24), 'MM/DD/YYYY hh24') ALLD FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(2/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(3/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(4/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(5/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(6/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(7/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(8/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(9/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(10/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(11/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(12/24), 'MM/DD/YYYY hh24') FROM DUAL) WHERE ALLD = REP_HOUR(+)
					)
					PIVOT
					(
					  COUNT(DISTINCT  PROM_NUMBER)
					  FOR SVTYPE IN ('COPPER', 'FTTH' , 'LTE')
					)
					ORDER BY ALLD";
  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$lables = array();
				$total = array();
				$cu = array();
				$ftth = array();
				$lte = array();
				$result = array();
				while ($row = oci_fetch_array($userid))
						{							
							$lables[$i] = $row['ALLD'];
							 if($row[1]== null){$total[$i] = '0';} else {$total[$i] =$row[1];};
							$cu[$i] = $row[2];
							$ftth[$i] = $row[3];
							$lte[$i] = $row[4];
							$i++;
						}
				$result[0] = $lables;
				$result[1] = $total;
				$result[2] = $cu;
				$result[3] = $ftth;
				$result[4] = $lte;				
				
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break; 	
		
		case 'clerdfaults':		
		
			$con = OracleConnection();
				
			$sql = "  SELECT * FROM
					( 
					SELECT ALLD,SVTYPE,TOTAL,PROM_NUMBER FROM (
						SELECT REP_HOUR,CASE 
					WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
					WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
					WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
					END AS SVTYPE ,PROM_NUMBER,COUNT( PROM_NUMBER ) OVER ( PARTITION BY REP_HOUR ) AS TOTAL
					FROM (SELECT PROM_REGN_CODE, PROM_NUMBER,CIRT_SERT_ABBREVIATION , TO_CHAR(PROM_CLEARED, 'MM/DD/YYYY hh24')REP_HOUR 
					FROM (SELECT PROM_NUMBER , PROM_REPORTED , PROM_REGN_CODE , PROM_CLEARED ,CIRT_SERT_ABBREVIATION FROM OSS_FAULTS.REALTIME_FAULTS 
					UNION SELECT PROM_NUMBER , PROM_REPORTED , PROM_REGN_CODE , PROM_CLEARED ,CIRT_SERT_ABBREVIATION  FROM OSS_FAULTS.REALTIME_FAULTS_DELETE)
						WHERE PROM_CLEARED > TO_DATE (TO_CHAR(SYSDATE - (12 / 24), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') 
						AND PROM_REGN_CODE IN(SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom'))) 
						),( SELECT TO_CHAR(SYSDATE-(0/24), 'MM/DD/YYYY hh24') ALLD FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(1/24), 'MM/DD/YYYY hh24') ALLD FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(2/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(3/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(4/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(5/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(6/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(7/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(8/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(9/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(10/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(11/24), 'MM/DD/YYYY hh24') FROM DUAL 
						UNION SELECT TO_CHAR(SYSDATE-(12/24), 'MM/DD/YYYY hh24') FROM DUAL) WHERE ALLD = REP_HOUR(+)
					)
					PIVOT
					(
					  COUNT(DISTINCT  PROM_NUMBER)
					  FOR SVTYPE IN ('COPPER', 'FTTH' , 'LTE')
					)
					ORDER BY ALLD";
  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$lables = array();
				$total = array();
				$cu = array();
				$ftth = array();
				$lte = array();
				$result = array();
				while ($row = oci_fetch_array($userid))
						{							
							$lables[$i] = $row['ALLD'];
							 if($row[1]== null){$total[$i] = '0';} else {$total[$i] =$row[1];};
							$cu[$i] = $row[2];
							$ftth[$i] = $row[3];
							$lte[$i] = $row[4];
							$i++;
						}
				$result[0] = $lables;
				$result[1] = $total;
				$result[2] = $cu;
				$result[3] = $ftth;
				$result[4] = $lte;				
				
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;

		case 'pendingflts':		
		
			$con = OracleConnection();
				
			$sql = "SELECT * FROM
				( 
				SELECT TO_CHAR(Y.MYDATE, 'mm/dd/yyyy hh24') AS D_HOUR,TOTAL,SVTYPE ,nvl(X.PROM_NUMBER,'0') as PROM_NUMBER  FROM 
				(SELECT MYDATE , PROM_NUMBER  ,CASE 
				WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
				WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
				WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
				END AS SVTYPE ,nvl(COUNT( PROM_NUMBER )OVER ( PARTITION BY MYDATE ),0)  AS TOTAL
				FROM (select PROM_NUMBER , PROM_REPORTED , PROM_REGN_CODE , PROM_CLEARED ,CIRT_SERT_ABBREVIATION from OSS_FAULTS.REALTIME_FAULTS 
				union select PROM_NUMBER , PROM_REPORTED , PROM_REGN_CODE , PROM_CLEARED ,CIRT_SERT_ABBREVIATION  from OSS_FAULTS.REALTIME_FAULTS_DELETE) 
				 A, (SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(0/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') MYDATE FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(1/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(2/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(3/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(4/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(5/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(6/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(7/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(8/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(9/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(10/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(11/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(12/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL) B
				WHERE PROM_REPORTED <= MYDATE
				AND (PROM_CLEARED > MYDATE  OR PROM_CLEARED IS NULL) 
				AND PROM_REGN_CODE IN(SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom'))
				ORDER BY MYDATE) X, (SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(0/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') MYDATE FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(1/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(2/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(3/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(4/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(5/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(6/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(7/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(8/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(9/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(10/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(11/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL
				UNION
				SELECT TO_DATE (TO_CHAR(TRUNC(SYSDATE -(12/24),'HH'), 'mm,dd,yyyy:hh:mi:ss pm'),'mm,dd,yyyy:hh:mi:ss pm') FROM DUAL) Y
				WHERE X.MYDATE(+) = Y.MYDATE 
				ORDER BY Y.MYDATE
				)
				PIVOT
				(
				  COUNT(DISTINCT  PROM_NUMBER)
				  FOR SVTYPE IN ('COPPER', 'FTTH' , 'LTE')
				)
				ORDER BY D_HOUR";
  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$lables = array();
				$total = array();
				$cu = array();
				$ftth = array();
				$lte = array();
				$result = array();
				while ($row = oci_fetch_array($userid))
						{							
							$lables[$i] = $row['D_HOUR'];
							 if($row[1]== null){$total[$i] = '0';} else {$total[$i] =$row[1];};
							$cu[$i] = $row[2];
							$ftth[$i] = $row[3];
							$lte[$i] = $row[4];
							$i++;
						}
				$result[0] = $lables;
				$result[1] = $total;
				$result[2] = $cu;
				$result[3] = $ftth;
				$result[4] = $lte;				
				
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;
		
		
		
		case 'repetedfaults':		
		
			$con = OracleConnection();
				
			$sql = "SELECT * FROM
				(select CASE 
				WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
				WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
				WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
				END AS SVTYPE ,
				PROM_REGN_CODE,CIRT_DISPLAYNAME ,OUTAGE ,CIRT_SERT_ABBREVIATION,SUM( count(distinct PROM_NUMBER) ) OVER ( PARTITION BY CIRT_DISPLAYNAME, PROM_REGN_CODE ) AS Total,count(PROM_NUMBER)PROM_NUMBER from (
				select yy.PROM_NUMBER,xx.CIRT_DISPLAYNAME, xx.CIRT_SERT_ABBREVIATION,xx.PROM_REGN_CODE ,yy.PROM_REPORTED, CASE 
					WHEN  (SYSDATE - yy.PROM_REPORTED ) < 1 THEN 'T<1' 
					WHEN (SYSDATE - yy.PROM_REPORTED ) < 7 THEN '1<T<7' 
					WHEN (SYSDATE - yy.PROM_REPORTED ) <90 THEN '7<T<3M'
					WHEN (SYSDATE - yy.PROM_REPORTED ) > 90  THEN '3M<T' END AS OUTAGE
				from (select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE 
				from OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is null ) xx,
				(select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE
				from OSS_FAULTS.REALTIME_FAULTS_DELETE where PROM_CLEARED is not null
				union all
				select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE
				from OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is not null)yy
				where xx.CIRT_DISPLAYNAME = yy.CIRT_DISPLAYNAME 
				and xx.PROM_REGN_CODE IN (SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom')) 
				and yy.PROM_REPORTED > add_months(sysdate, - 6) --sysdate - interval '6' month
				and xx.CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER',
				'V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH','V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET'))
				group by CASE 
				WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
				WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
				WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
				END  ,CIRT_DISPLAYNAME ,CIRT_SERT_ABBREVIATION,PROM_REGN_CODE,OUTAGE
				)
				PIVOT
				(
				  sum(PROM_NUMBER)
				  FOR OUTAGE IN ('T<1', '1<T<7' , '7<T<3M', '3M<T')
				)
				order by SVTYPE,PROM_REGN_CODE,CIRT_SERT_ABBREVIATION";
				  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$result ='<table class="table table-sm" style="text-align: center;" >
					<thead>				
					<tr bgcolor="#0A3981" style="color:#ffffff">
						<th>Circut Number</th>
						<th>LEA</th>
						<th>T<1</th>
						<th>1-7 days<T<7D</th>
						<th>7 day To 3 Month<T<7D</th>
						<th>Above 3 Month<T<7D</th>
						<th>Total Faults</th>
						<th><input type="text" id="serchD" style="color:#000000" placeholder="search"></th>
					</tr>
					</thead>
					<tbody id="rDatatbl" style="color:#0A3981; font-weight: 900;">';
				
				$heading="";
	
				while ($row = oci_fetch_array($userid)) {
					if($heading== ""){
						$result .='<tr style="background-color:#0D47A1;color:#ffffff"><td colspan="8">MEGALINE</td></tr>';
						$heading="COPPER";
					}
					if($heading== "COPPER" && $row["SVTYPE"]=="FTTH"){
						$result .='<tr style="background-color:#0D47A1;color:#ffffff"><td colspan="8">FTTH</td></tr>';
						$heading="FTTH";
					}
					if($heading== "FTTH" && $row["SVTYPE"]=="LTE"){
						$result .='<tr style="background-color:#0D47A1;color:#ffffff"><td colspan="8">LTE</td></tr>';
						$heading="LTE";
					}
					
					$tot=0;
					
					if($row["'T<1'"] > 0)
				    { 
						$tot += $row["'T<1'"]; 
				    }
					
					if($row["'1<T<7'"] > 0)
				    { 
						$tot += $row["'1<T<7'"];
				    }
					
					if($row["'7<T<3M'"] > 0)
				    { 
						$tot += $row["'7<T<3M'"]; 
				    }
					
					if($row["'3M<T'"] > 0)
				    { 
						$tot += $row["'3M<T'"]; 
				    }

					$result .='<tr>
					<td bgcolor="#fef9e7">'.$row['CIRT_DISPLAYNAME'].'</td>
					<td bgcolor="#fef9e7">'.$row['PROM_REGN_CODE'].'</td>';
					
					if($row["'T<1'"] > 0){
					$result .='<td style="background-color:#7A191B; color:#ffffff">'.$row["'T<1'"].'</td>';
					}else{
					$result .='<td>0</td>';
					}
					
					if($row["'1<T<7'"] > 0){
					$result .='<td style="background-color:#D04349; color:#ffffff">'.$row["'1<T<7'"].'</td>';
					}else{
					$result .='<td>0</td>';	
					}
					
					if($row["'7<T<3M'"] > 0){
					$result .='<td style="background-color:#F56C71; color:#ffffff">'.$row["'7<T<3M'"].'</td>';
					}else{
					$result .='<td>0</td>';	
					}
					
					if($row["'3M<T'"] > 0){
					$result .='<td style="background-color:rgb(251, 169, 125); color:#ffffff">'.$row["'3M<T'"].'</td>';
					}else{
					$result .='<td>0</td>';
					}
					
					$result .='<td bgcolor="#fef9e7">'.$tot.'</td>
					<td bgcolor="#fef9e7"><button style="margin:0px" class="btn btn-warning btn-sm" onclick="viewData();" id="D'.$row['CIRT_DISPLAYNAME'].'">VIEW DATA</button></td>
				</tr>';
				
				} 
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;



		case 'repetedfaults2':		
		
			$con = OracleConnection();
				
$sql = "SELECT * FROM
                (select CASE 
                WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
                WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
                WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
                END AS SVTYPE ,
                PROM_REGN_CODE,CIRT_DISPLAYNAME ,OUTAGE ,CIRT_SERT_ABBREVIATION,SUM( count(distinct PROM_NUMBER) ) OVER ( PARTITION BY CIRT_DISPLAYNAME, PROM_REGN_CODE ) AS Total,count(PROM_NUMBER)PROM_NUMBER from (
                select yy.PROM_NUMBER,xx.CIRT_DISPLAYNAME, xx.CIRT_SERT_ABBREVIATION,xx.PROM_REGN_CODE ,yy.PROM_REPORTED, CASE 
                                WHEN  (SYSDATE - yy.PROM_REPORTED ) < 1 THEN 'T<1' 
                                WHEN (SYSDATE - yy.PROM_REPORTED ) < 7 THEN '1<T<7' 
                                WHEN (SYSDATE - yy.PROM_REPORTED ) <90 THEN '7<T<3M'
                                WHEN (SYSDATE - yy.PROM_REPORTED ) > 90  THEN '3M<T' END AS OUTAGE
                from (select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE 
                from OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED   > sysdate - 1
                union
                select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE 
                from OSS_FAULTS.REALTIME_FAULTS_DELETE where PROM_CLEARED > sysdate - 1
                 ) xx,
                (select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE
                from OSS_FAULTS.REALTIME_FAULTS_DELETE where PROM_CLEARED is not null
                union all
                select PROM_NUMBER, PROM_REPORTED,CIRT_DISPLAYNAME, CIRT_SERT_ABBREVIATION,PROM_REGN_CODE
                from OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is not null)yy
                where xx.CIRT_DISPLAYNAME = yy.CIRT_DISPLAYNAME 
                and xx.PROM_REGN_CODE IN (SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom')) 
                and yy.PROM_REPORTED > add_months(sysdate, - 6) --sysdate - interval '6' month
                and xx.CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER',
                'V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH','V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET'))
                group by CASE 
                WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB','E-IPTV COPPER','BB-INTERNET COPPER') THEN 'COPPER'
                WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
                WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
                END  ,CIRT_DISPLAYNAME ,CIRT_SERT_ABBREVIATION,PROM_REGN_CODE,OUTAGE
                )
                PIVOT
                (
                  sum(PROM_NUMBER)
                  FOR OUTAGE IN ('T<1', '1<T<7' , '7<T<3M', '3M<T')
                )
                order by SVTYPE,PROM_REGN_CODE,CIRT_SERT_ABBREVIATION";
				  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$result ='<table class="table table-sm" style="text-align: center;" >
					<thead>				
					<tr bgcolor="#0A3981" style="color:#ffffff">
						<th>Circut Number</th>
						<th>LEA</th>
						<th>T<1</th>
						<th>1-7 days<T<7D</th>
						<th>7 day To 3 Month<T<7D</th>
						<th>Above 3 Month<T<7D</th>
						<th>Total Faults</th>
						<th><input type="text" id="serchD" style="color:#000000" placeholder="search"></th>
					</tr>
					</thead>
					<tbody id="rDatatbl" style="color:#0A3981; font-weight: 900;">';
				
				$heading="";
	
				while ($row = oci_fetch_array($userid)) {
					if($heading== ""){
						$result .='<tr style="background-color:#0D47A1;color:#ffffff"><td colspan="8">MEGALINE</td></tr>';
						$heading="COPPER";
					}
					if($heading== "COPPER" && $row["SVTYPE"]=="FTTH"){
						$result .='<tr style="background-color:#0D47A1;color:#ffffff"><td colspan="8">FTTH</td></tr>';
						$heading="FTTH";
					}
					if($heading== "FTTH" && $row["SVTYPE"]=="LTE"){
						$result .='<tr style="background-color:#0D47A1;color:#ffffff"><td colspan="8">LTE</td></tr>';
						$heading="LTE";
					}
					
					$tot=0;
					
					if($row["'T<1'"] > 0)
				    { 
						$tot += $row["'T<1'"]; 
				    }
					
					if($row["'1<T<7'"] > 0)
				    { 
						$tot += $row["'1<T<7'"];
				    }
					
					if($row["'7<T<3M'"] > 0)
				    { 
						$tot += $row["'7<T<3M'"]; 
				    }
					
					if($row["'3M<T'"] > 0)
				    { 
						$tot += $row["'3M<T'"]; 
				    }

					$result .='<tr>
					<td bgcolor="#fef9e7">'.$row['CIRT_DISPLAYNAME'].'</td>
					<td bgcolor="#fef9e7">'.$row['PROM_REGN_CODE'].'</td>';
					
					if($row["'T<1'"] > 0){
					$result .='<td style="background-color:#7A191B; color:#ffffff">'.$row["'T<1'"].'</td>';
					}else{
					$result .='<td>0</td>';
					}
					
					if($row["'1<T<7'"] > 0){
					$result .='<td style="background-color:#D04349; color:#ffffff">'.$row["'1<T<7'"].'</td>';
					}else{
					$result .='<td>0</td>';	
					}
					
					if($row["'7<T<3M'"] > 0){
					$result .='<td style="background-color:#F56C71; color:#ffffff">'.$row["'7<T<3M'"].'</td>';
					}else{
					$result .='<td>0</td>';	
					}
					
					if($row["'3M<T'"] > 0){
					$result .='<td style="background-color:rgb(251, 169, 125); color:#ffffff">'.$row["'3M<T'"].'</td>';
					}else{
					$result .='<td>0</td>';
					}
					
					$result .='<td bgcolor="#fef9e7">'.$tot.'</td>
					<td bgcolor="#fef9e7"><button style="margin:0px" class="btn btn-warning btn-sm" onclick="viewData1();" id="D'.$row['CIRT_DISPLAYNAME'].'">VIEW DATA</button></td>
				</tr>';
				
				} 
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;
		
		
		case 'repetedfaultsdetails':		
		
			$con = OracleConnection();
			$c_no = $_POST['id'];
			$sql = "SELECT DISTINCT PROM_PCAT_NAME , COUNT(PROM_NUMBER) PROM_NUMBER
					FROM (SELECT CIRT_DISPLAYNAME,CAUSE_OF_FAULT PROM_PCAT_NAME,TO_CHAR(PROM_NUMBER)PROM_NUMBER ,PROM_REPORTED FROM OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is null 
					union
					SELECT CIRT_DISPLAYNAME,CAUSE_OF_FAULT ,TO_CHAR(PROM_NUMBER)PROM_NUMBER ,PROM_REPORTED FROM OSS_FAULTS.REALTIME_FAULTS_DELETE )X 
					WHERE CIRT_DISPLAYNAME IN (SELECT CIRT_DISPLAYNAME FROM OSS_FAULTS.REALTIME_FAULTS WHERE PROM_REGN_CODE IN (SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom'))) 
					AND PROM_PCAT_NAME IS NOT NULL AND X.CIRT_DISPLAYNAME = '".$c_no."' 
					AND X.PROM_REPORTED > add_months(sysdate, - 6) -- sysdate - interval '6' month
					GROUP BY PROM_PCAT_NAME";
  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$lables = array();
				$total = array();
				$result = array();
				while ($row = oci_fetch_array($userid))
				{							
					$lables[$i] = $row['PROM_PCAT_NAME'];
					$total[$i] =$row['PROM_NUMBER'];
					$i++;
				}
				$result[0] = $lables;
				$result[1] = $total;		
				
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;


		case 'repetedfaultsdetails2':		
		
			$con = OracleConnection();
			$c_no = $_POST['id'];
						$sql = "SELECT DISTINCT PROM_PCAT_NAME , COUNT(PROM_NUMBER) PROM_NUMBER
						FROM (SELECT CIRT_DISPLAYNAME,CAUSE_OF_FAULT PROM_PCAT_NAME,TO_CHAR(PROM_NUMBER)PROM_NUMBER ,PROM_REPORTED ,PROM_REGN_CODE FROM 
						OSS_FAULTS.REALTIME_FAULTS where PROM_CLEARED is NOT null 
						Union
						SELECT CIRT_DISPLAYNAME,CAUSE_OF_FAULT ,TO_CHAR(PROM_NUMBER)PROM_NUMBER ,PROM_REPORTED ,PROM_REGN_CODE FROM OSS_FAULTS.REALTIME_FAULTS_DELETE )X 
						WHERE X.PROM_REGN_CODE IN (SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom'))
						AND PROM_PCAT_NAME IS NOT NULL AND X.CIRT_DISPLAYNAME = '".$c_no."' 
						AND X.PROM_REPORTED > add_months(sysdate, - 6) -- sysdate - interval '6' month
						GROUP BY PROM_PCAT_NAME
";
  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$lables = array();
				$total = array();
				$result = array();
				while ($row = oci_fetch_array($userid))
				{							
					$lables[$i] = $row['PROM_PCAT_NAME'];
					$total[$i] =$row['PROM_NUMBER'];
					$i++;
				}
				$result[0] = $lables;
				$result[1] = $total;		
				
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;
		
		case 'pendingbox':		
		
			$con = OracleConnection();
			//$c_no = $_POST['id'];
			$sql = "SELECT 1 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED) <= 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 2 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					UNION
					SELECT 3 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 4 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED) <= 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 5 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					UNION
					SELECT 6 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 7 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED) <= 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 8 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE  PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					UNION
					SELECT 9 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 10 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED) <= 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 11 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					UNION
					SELECT 12 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 13 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED) <= 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 14 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					UNION
					SELECT 15 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 19 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'CDMA' AND (SYSDATE - PROM_REPORTED) <= 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 20 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'CDMA' AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					UNION
					SELECT 20 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'CDMA' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 16 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED) <= 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					union
					SELECT 17 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
					UNION
					SELECT 18 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) order by IDS";
					  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$total = array();
				$result = array();
				while ($row = oci_fetch_array($userid))
						{							
							$total[$i] =$row['PROB_COUNT'];
							$i++;
						}
				$result[0] = $total;		
				
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;
		
		
		case 'boxfaultsdetails':		
		
			$con = OracleConnection();
			$type = $_POST['type'];
			$s = $_POST['time'];
			if($type == "PSTN"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB' ,'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "ADSL"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY  FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "IPTV"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "LTE"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "CDMA"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'CDMA' AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "DATA"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "FTTH"){
				
				//$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH'  AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			
			//$sql="SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY ,
				//(SELECT OLT_ROP||'#'||PW_LEVEL  FROM  ossprg.LINE_QUALITY@DBLINK_CLARITY
				//WHERE  SUBSTR(CIRT_DISPLAYNAME,-7)=  SUBSTR(CIRCUIT_NAME,-7) 
				//AND OPMC = '$rtom') SIGLEVEL
				//FROM OSS_FAULTS.REALTIME_FAULTS 
				//WHERE PROM_CLEARED IS NULL 
				//AND CIRT_SERT_ABBREVIATION in ('AB-FTTH' ,'V-VOICE FTTH')
				//AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))";
			
			/*$sql="SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY ,
				(SELECT OLT_ROP||'#'||OPERATIONAL_ST  FROM  ossprg.LINE_QUALITY@DBLINK_CLARITY
				WHERE  SUBSTR(CIRT_DISPLAYNAME,-7)=  SUBSTR(CIRCUIT_NAME,-7) 
				AND OPMC = '$rtom') SIGLEVEL
				FROM OSS_FAULTS.REALTIME_FAULTS 
				WHERE PROM_CLEARED IS NULL 
				AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' 
				AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))";*/
				
			$sql="SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY
				FROM OSS_FAULTS.REALTIME_FAULTS WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' 
				AND (SYSDATE - PROM_REPORTED) ".$s." AND PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA WHERE RTOM_CODE IN ('$rtom'))";
				
			}
			
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$sel = '<table style="width:630px;" border = "1" id="tbl_data"><tr><td>FAULT NUMBER</td><td>WG</td><td>CCT</td><td>PRI.</td>';
				
				if($type == "FTTH"){
					
					$sel .= '<td>OP. STATUS</td><td>RX. Power</td><td>Cause for the recent down</td>';
				}
				
				$sel .= '<td>PHONE NO</td></tr>';
				
				while ($row = oci_fetch_array($userid))
				{
						
				if($type == "FTTH"){	
					
				//$sql2="SELECT OLT_ROP||'#'||OPERATIONAL_ST SIGLEVEL FROM ossprg.LINE_QUALITY@DBLINK_CLARITY WHERE SUBSTR(CIRCUIT_NAME,-7) = SUBSTR('".$row["CIRT_DISPLAYNAME"]."',-7) AND OPMC = '".$rtom."'";
				
				//$sql2="SELECT RX_POWER||'#'||STATUS SIGLEVEL FROM LINE_QUALITY WHERE SUBSTR(CIRCUIT_NAME,-7) = SUBSTR('".$row["CIRT_DISPLAYNAME"]."',-7) AND  OPMC = '".$rtom."'";
					   
				$sql2="SELECT RX_POWER,STATUS,CAUSE FROM LINE_QUALITY
						WHERE SUBSTR(CCT,-7) = SUBSTR('".$row["CIRT_DISPLAYNAME"]."',-7)";
					  
					$stid2 = oci_parse($con, $sql2);
					oci_execute($stid2);
					$row2 = oci_fetch_array($stid2);
				
					//$pwArr = explode('#',$row2['SIGLEVEL']);
					//$oltRop = $pwArr[0];
					//$pwLevel = $pwArr[1];
							
				}

				$sel .= '<tr><td>'.$row["PROM_NUMBER"].'</td><td>'.$row["PROM_WORG_NAME"].'</td><td>'.$row["CIRT_DISPLAYNAME"].'</td><td>'.$row["PROM_PRIORITY"].'</td>';
				
				if($type == "FTTH"){
					
					$sel .= "<td>".$row2["STATUS"]."</td><td>".$row2["RX_POWER"]."</td><td>".$row2["CAUSE"]."</td>";
				}
					
					$sel .= '<td><input type="button" value="VIEW" id="'.$row["PROM_NUMBER"].'btn" class="btn btn-warning btn-md" onclick="viewNo(this);"/></td></tr>';
				}	
				
				
				$response['error'] = false;
				$response['reply'] = $sel; 
			
		
		break;
		
		
		
		case 'boxfaultsdetailspri':		
		
			$con = OracleConnection();
			$type = $_POST['type'];
			$s = $_POST['time'];
			if($type == "PSTN"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL and PROM_PRIORITY = 1 AND CIRT_SERT_ABBREVIATION in ('AB-CAB' ,'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "ADSL"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY  FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL and PROM_PRIORITY = 1 AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "IPTV"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL and PROM_PRIORITY = 1 AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "LTE"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL and PROM_PRIORITY = 1 AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "CDMA"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL and PROM_PRIORITY = 1 AND CIRT_SERT_ABBREVIATION = 'CDMA' AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "DATA"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL and PROM_PRIORITY = 1 AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}if($type == "FTTH"){
				$sql = "SELECT PROM_NUMBER ,PROM_WORG_NAME , CIRT_DISPLAYNAME ,PROM_PRIORITY   FROM OSS_FAULTS.REALTIME_FAULTS   WHERE PROM_CLEARED IS NULL and PROM_PRIORITY = 1 AND CIRT_SERT_ABBREVIATION LIKE '%FTTH'  AND (SYSDATE - PROM_REPORTED) ".$s."  AND  PROM_REGN_CODE  in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) ";
			}
			
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$sel = '<table border = "1" id="tbl_data2"><tr><td>FAULT NUMBER</td><td>WG</td><td>CCT</td><td>PRI</td>';
				
				if($type == "FTTH"){
					
					$sel .= '<td>OP. STATUS</td><td>RX. Power</td><td>Cause for the recent down</td>';
				}
				
				
				$sel .= '<td>PHONE NO</td></tr>';
				
				while ($row = oci_fetch_array($userid))
						{

				if($type == "FTTH"){	
					
				//$sql2="SELECT OLT_ROP||'#'||OPERATIONAL_ST SIGLEVEL FROM ossprg.LINE_QUALITY@DBLINK_CLARITY WHERE SUBSTR(CIRCUIT_NAME,-7) = SUBSTR('".$row["CIRT_DISPLAYNAME"]."',-7) AND OPMC = '".$rtom."'";
				
				//$sql2="SELECT RX_POWER||'#'||STATUS SIGLEVEL FROM LINE_QUALITY WHERE SUBSTR(CIRCUIT_NAME,-7) = SUBSTR('".$row["CIRT_DISPLAYNAME"]."',-7) AND  OPMC = '".$rtom."'";
					   
				$sql2="SELECT RX_POWER,STATUS,CAUSE FROM LINE_QUALITY
						WHERE SUBSTR(CCT,-7) = SUBSTR('".$row["CIRT_DISPLAYNAME"]."',-7)";
					  
					$stid2 = oci_parse($con, $sql2);
					oci_execute($stid2);
					$row2 = oci_fetch_array($stid2);
				
					//$pwArr = explode('#',$row2['SIGLEVEL']);
					//$oltRop = $pwArr[0];
					//$pwLevel = $pwArr[1];
							
				}

					
							$sel = $sel."<tr><td>".$row["PROM_NUMBER"]."</td>
							<td>".$row["PROM_WORG_NAME"]."</td>
							<td>".$row["CIRT_DISPLAYNAME"]."</td>
							<td>".$row["PROM_PRIORITY"]."</td>";
							
							if($type == "FTTH"){
					
							$sel .= "<td>".$row2["STATUS"]."</td><td>".$row2["RX_POWER"]."</td><td>".$row2["CAUSE"]."</td>";
							}
							
							
							$sel .="<td><input type='button' value='VIEW' id='".$row["PROM_NUMBER"]."btn' class='btn btn-warning btn-sm' onclick='viewNo2(this);'/></td></tr>";
						}	
				
				
				$response['error'] = false;
				$response['reply'] = $sel; 
			
		
		break;
		
		
		case 'loadReqTelNo':

			function connecttooracle2() {
				$db = "(DESCRIPTION =
				(ADDRESS_LIST =
				  (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
				)
				(CONNECT_DATA = (SID=clty))
			  )
			";

				if ($c = oci_connect("ossprg", "prgoss456", $db)) {
					return $c;
				} else {
					$err = OCIError();
					echo "Connection failed." . $err[text];
				}
			}
		
			$con2 = connecttooracle2();
			
			$F_id = $_POST['F_id'];
			
			$sql="SELECT PROM_REPORTEDCONTACT from CLARITY.problems where PROM_NUMBER = '".$F_id."'";
			
				$stid = oci_parse($con2, $sql);
				oci_execute($stid);
				$row = oci_fetch_array($stid);
						
				$sel = $row['PROM_REPORTEDCONTACT'];
				
				$response['error'] = false;
				$response['reply'] = $sel; 
			
		
		break;


			case 'loadReqTelNo2':

			function connecttooracle2() {
				$db = "(DESCRIPTION =
				(ADDRESS_LIST =
				  (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
				)
				(CONNECT_DATA = (SID=clty))
			  )
			";

				if ($c = oci_connect("ossprg", "prgoss456", $db)) {
					return $c;
				} else {
					$err = OCIError();
					echo "Connection failed." . $err[text];
				}
			}
		
			$con2 = connecttooracle2();
			
			$F_id = $_POST['F_id'];
			
			$sql="SELECT PROM_REPORTEDCONTACT from CLARITY.problems where PROM_NUMBER = '".$F_id."'";
			
				$stid = oci_parse($con2, $sql);
				oci_execute($stid);
				$row = oci_fetch_array($stid);
						
				$sel = $row['PROM_REPORTEDCONTACT'];
				
				$response['error'] = false;
				$response['reply'] = $sel; 
			
		
		break;

		case 'pendingbox1':		
		
			$con = OracleConnection();
			//$c_no = $_POST['id'];
$sql = "SELECT 1 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 2 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 >= 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 3 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 4 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 5 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 6 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 7 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 8 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 9 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 10 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 11 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 12 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 13 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 14 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE  PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 15 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 16 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 17 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 18 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET')  AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 19 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 20 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 21 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 22 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 23 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 24 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 25 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 26 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 27 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 28 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 29 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 30 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) order by IDS";
					  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$total = array();
				$result = array();
				while ($row = oci_fetch_array($userid))
						{							
							$total[$i] =$row['PROB_COUNT'];
							$i++;
						}
				$result[0] = $total;		
				
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;
		
		
case 'pendingboxpri':		
		
			$con = OracleConnection();
			//$c_no = $_POST['id'];
			$sql = "SELECT 1 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_PRIORITY = 1 and  PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 2 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_PRIORITY = 1 and  PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 3 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 4 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 5 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION in ('AB-CAB', 'V-VOICE COPPER') AND (SYSDATE - PROM_REPORTED) > 3 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 6 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED)*24 <= 4  and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 7 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 8 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 9 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 10 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ( 'BB-INTERNET COPPER','ADSL') AND (SYSDATE - PROM_REPORTED) > 3  and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 11 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 12 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 13 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 14 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE  PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 15 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION = 'E-IPTV COPPER' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 16 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 17 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 18 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 19 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 20 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION IN ('V-VOICE','BB-INTERNET') AND (SYSDATE - PROM_REPORTED) > 3 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 21 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 22 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 23 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 24 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 25 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE '%FTTH' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 26 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED)*24 <= 4 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 27 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED)*24 <= 20 and PROM_PRIORITY = 1 AND (SYSDATE - PROM_REPORTED)*24 > 4 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 28 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED)*24 <= 24 and PROM_PRIORITY = 1 AND (SYSDATE - PROM_REPORTED)*24 > 20 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
union
SELECT 29 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED) <=3 and PROM_PRIORITY = 1 AND (SYSDATE - PROM_REPORTED) > 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom'))
UNION
SELECT 30 AS IDS, NVL(COUNT(PROM_NUMBER),0)   PROB_COUNT  FROM OSS_FAULTS.REALTIME_FAULTS  WHERE PROM_CLEARED IS NULL AND CIRT_SERT_ABBREVIATION LIKE 'D-%' AND (SYSDATE - PROM_REPORTED) > 3 and PROM_PRIORITY = 1 and PROM_REGN_CODE in (SELECT LEA_CODE FROM SLT_AREA  WHERE RTOM_CODE IN ('$rtom')) order by IDS";

					  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$total = array();
				$result = array();
				while ($row = oci_fetch_array($userid))
						{							
							$total[$i] =$row['PROB_COUNT'];
							$i++;
						}
				$result[0] = $total;		
				
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;
		
		
		
		case 'faultnew2':		
		
			//$username = $_SESSION['$rtom'];
		
			$con = OracleConnection();
				
			$sql = "SELECT * FROM (
        SELECT PROM_REGN_CODE ,  CASE 
        WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB') THEN 'MEGALINE'
        WHEN CIRT_SERT_ABBREVIATION = 'BB-INTERNET COPPER' THEN 'BROADBAND'
        WHEN CIRT_SERT_ABBREVIATION ='E-IPTV COPPER' THEN 'PEOTV'
        WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
        WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
        WHEN CIRT_SERT_ABBREVIATION LIKE 'D-%' THEN 'DATA'
        END AS SVTYPE , 
        CASE
        WHEN (SYSDATE - YY.PROM_REPORTED ) = 0  THEN '0' 
        WHEN (SYSDATE - YY.PROM_REPORTED ) < 1 THEN 'T<1' 
        WHEN (SYSDATE - YY.PROM_REPORTED ) < 7 THEN '1<T<7' 
        WHEN (SYSDATE - YY.PROM_REPORTED ) <90 THEN '7<T<3M'
        WHEN (SYSDATE - YY.PROM_REPORTED ) > 90  THEN '3M<T'
        END AS OUTAGE,PROM_NUMBER
        FROM OSS_FAULTS.REALTIME_FAULTS YY , SLT_AREA
        WHERE PROM_CLEARED IS NULL AND PROM_REGN_CODE = LEA_CODE AND RTOM_CODE = '$rtom')
        PIVOT
        (
         COUNT(PROM_NUMBER)
         FOR (SVTYPE,OUTAGE)
         IN (('MEGALINE', 'T<1') AS MEGALINE_T1 , ('MEGALINE', '1<T<7')AS MEGALINE_T2, ('MEGALINE', '7<T<3M')AS MEGALINE_T3, ('MEGALINE', '3M<T')AS MEGALINE_T4 ,
            ('BROADBAND', 'T<1')AS BROADBAND_T1 , ('BROADBAND', '1<T<7')AS BROADBAND_T2, ('BROADBAND', '7<T<3M')AS BROADBAND_T3, ('BROADBAND', '3M<T') ASBROADBAND_T4 ,
            ('PEOTV', 'T<1') AS PEOTV_T1 , ('PEOTV', '1<T<7') AS PEOTV_T2, ('PEOTV', '7<T<3M')AS PEOTV_T3, ('PEOTV', '3M<T') AS PEOTV_T4 ,
            ('FTTH', 'T<1') FTTH_T1 , ('FTTH', '1<T<7')AS  FTTH_T2, ('FTTH', '7<T<3M') FTTH_T3, ('FTTH', '3M<T') AS FTTH_T4 ,
            ('LTE', 'T<1') AS LTE_T1 , ('LTE', '1<T<7') AS LTE_T2, ('LTE', '7<T<3M') LTE_T3, ('LTE', '3M<T') AS LTE_T4 ,
            ('DATA', 'T<1') AS DATA_T1 , ('DATA', '1<T<7')AS  DATA_T2, ('DATA', '7<T<3M')AS  DATA_T3, ('DATA', '3M<T')AS  DATA_T4 )
            )
            ORDER BY PROM_REGN_CODE";
				  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$result ='<table class="table table-sm" style="text-align: center;" >
					<thead style="position: sticky; top: 0;">
					<tr bgcolor="#0A3981" style="color:#ffffff">
					<th></th>
					<th colspan="4" bgcolor="#f1948a" style="color:#ffffff">MEGALINE</th>
					<th colspan="4" bgcolor="#d2b4de" style="color:#ffffff">BROADBAND</th>
					<th colspan="4" bgcolor="#7dcea0" style="color:#ffffff">PEOTV</th>
					<th colspan="4" bgcolor="#fad7a0" style="color:#ffffff">FTTH</th>
					<th colspan="4" bgcolor="#5dade2" style="color:#ffffff">LTE</th>
					<th colspan="4" bgcolor="#f2d7d5" style="color:#ffffff">DATA</th>
					</tr>				
					<tr bgcolor="#0A3981" style="color:#ffffff">
						<th>&nbsp;LEA &nbsp;</th>
						<th>T&#60;1</th>
						<th>1&#60;T&#60;7</th>
						<th>7&#60;T&#60;3M</th>
						<th>3M&#60;T</th>
						<th>T&#60;1</th>
						<th>1&#60;T&#60;7</th>
						<th>7&#60;T&#60;3M</th>
						<th>3M&#60;T</th>
						<th>T&#60;1</th>
						<th>1&#60;T&#60;7</th>
						<th>7&#60;T&#60;3M</th>
						<th>3M&#60;T</th>
						<th>T&#60;1</th>
						<th>1&#60;T&#60;7</th>
						<th>7&#60;T&#60;3M</th>
						<th>3M&#60;T</th>
						<th>T&#60;1</th>
						<th>1&#60;T&#60;7</th>
						<th>7&#60;T&#60;3M</th>
						<th>3M&#60;T</th>
						<th>T&#60;1</th>
						<th>1&#60;T&#60;7</th>
						<th>7&#60;T&#60;3M</th>
						<th>3M&#60;T</th>
					</tr>
					</thead>
					<tbody id="rDatatbl" style="color:#0A3981; font-weight: 900;">';
				
			
	
				while ($row = oci_fetch_array($userid)) {

					$result .='<tr>
					<td bgcolor="#fef9e7">'.$row['PROM_REGN_CODE'].'</td>
					
					<td bgcolor="#f1948a">'.$row['MEGALINE_T1'].'</td>
					<td bgcolor="#f1948a">'.$row['MEGALINE_T2'].'</td>
					<td bgcolor="#f1948a">'.$row['MEGALINE_T3'].'</td>
					<td bgcolor="#f1948a">'.$row['MEGALINE_T4'].'</td>
					<td bgcolor="#d2b4de">'.$row['BROADBAND_T1'].'</td>
					<td bgcolor="#d2b4de">'.$row['BROADBAND_T2'].'</td>
					<td bgcolor="#d2b4de">'.$row['BROADBAND_T3'].'</td>
					<td bgcolor="#d2b4de">'.$row['ASBROADBAND_T4'].'</td>
					<td bgcolor="#7dcea0">'.$row['PEOTV_T1'].'</td>
					<td bgcolor="#7dcea0">'.$row['PEOTV_T2'].'</td>
					<td bgcolor="#7dcea0">'.$row['PEOTV_T3'].'</td>
					<td bgcolor="#7dcea0">'.$row['PEOTV_T4'].'</td>
					<td bgcolor="#fad7a0">'.$row['FTTH_T1'].'</td>
					<td bgcolor="#fad7a0">'.$row['FTTH_T2'].'</td>
					<td bgcolor="#fad7a0">'.$row['FTTH_T3'].'</td>
					<td bgcolor="#fad7a0">'.$row['FTTH_T4'].'</td>
					<td bgcolor="#5dade2">'.$row['LTE_T1'].'</td>
					<td bgcolor="#5dade2">'.$row['LTE_T2'].'</td>
					<td bgcolor="#5dade2">'.$row['LTE_T3'].'</td>
					<td bgcolor="#5dade2">'.$row['LTE_T4'].'</td>
					<td bgcolor="#f2d7d5">'.$row['DATA_T1'].'</td>
					<td bgcolor="#f2d7d5">'.$row['DATA_T2'].'</td>
					<td bgcolor="#f2d7d5">'.$row['DATA_T3'].'</td>
					<td bgcolor="#f2d7d5">'.$row['DATA_T4'].'</td>
					</tr>';
					
				} 
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;
		
		
		
		
		case 'faultnew':		
		
			//$username = $_SESSION['$rtom'];
		
			$con = OracleConnection();
				
			$sql ="SELECT * FROM (
        SELECT PROM_REGN_CODE ,  CASE 
        WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE COPPER','AB-CAB') THEN 'MEGALINE'
        WHEN CIRT_SERT_ABBREVIATION = 'BB-INTERNET COPPER' THEN 'BROADBAND'
        WHEN CIRT_SERT_ABBREVIATION ='E-IPTV COPPER' THEN 'PEOTV'
        WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE FTTH','AB-FTTH','E-IPTV FTTH','BB-INTERNET FTTH') THEN 'FTTH'
        WHEN CIRT_SERT_ABBREVIATION IN('V-VOICE','AB-WIRLESS ACCESS','BB-INTERNET') THEN 'LTE'
        WHEN CIRT_SERT_ABBREVIATION LIKE 'D-%' THEN 'DATA'
        END AS SVTYPE , 
        CASE
        WHEN (SYSDATE - PROM_REPORTED)*24 <= 4 THEN '0<H<4'
        WHEN (SYSDATE - PROM_REPORTED)*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 THEN '4<H<20'
        WHEN (SYSDATE - PROM_REPORTED)*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 THEN '20<H<24'
        WHEN (SYSDATE - PROM_REPORTED) <=3 AND (SYSDATE - PROM_REPORTED) > 1 THEN '1<D<3'
        WHEN (SYSDATE - PROM_REPORTED) > 3 THEN 'D>3'
        END AS OUTAGE,PROM_NUMBER
        FROM OSS_FAULTS.REALTIME_FAULTS YY , SLT_AREA
        WHERE PROM_CLEARED IS NULL AND PROM_REGN_CODE = LEA_CODE AND  RTOM_CODE = '$rtom')
        PIVOT
        (
         COUNT(PROM_NUMBER)
         FOR (SVTYPE,OUTAGE)
         IN (('MEGALINE', '0<H<4') AS MEGALINE_T1 , ('MEGALINE', '4<H<20')AS MEGALINE_T2, ('MEGALINE', '20<H<24')AS MEGALINE_T3, ('MEGALINE', '1<D<3')AS MEGALINE_T4 ,('MEGALINE', 'D>3')AS MEGALINE_T5 ,
            ('BROADBAND', '0<H<4')AS BROADBAND_T1 , ('BROADBAND', '4<H<20')AS BROADBAND_T2, ('BROADBAND', '20<H<24')AS BROADBAND_T3, ('BROADBAND', '1<D<3') AS BROADBAND_T4 ,('BROADBAND', 'D>3') AS BROADBAND_T5 ,
            ('PEOTV', '0<H<4') AS PEOTV_T1 , ('PEOTV', '4<H<20') AS PEOTV_T2, ('PEOTV', '20<H<24')AS PEOTV_T3, ('PEOTV', '1<D<3') AS PEOTV_T4 , ('PEOTV', 'D>3') AS PEOTV_T5 ,
            ('FTTH', '0<H<4') FTTH_T1 , ('FTTH', '4<H<20')AS  FTTH_T2, ('FTTH', '20<H<24') FTTH_T3, ('FTTH', '1<D<3') AS FTTH_T4 ,('FTTH', 'D>3') AS FTTH_T5 ,
            ('LTE', '0<H<4') AS LTE_T1 , ('LTE', '4<H<20') AS LTE_T2, ('LTE', '20<H<24') LTE_T3, ('LTE', '1<D<3') AS LTE_T4 ,('LTE', 'D>3') AS LTE_T5 ,
            ('DATA', '0<H<4') AS DATA_T1 , ('DATA', '4<H<20')AS  DATA_T2, ('DATA', '20<H<24')AS  DATA_T3, ('DATA', '1<D<3')AS  DATA_T4,('DATA', 'D>3')AS  DATA_T5  )
            )
            ORDER BY PROM_REGN_CODE";
				  
				$userid = oci_parse($con, $sql);
				oci_execute($userid);
				$i =0;
				$result ='<table class="table table-sm" style="text-align: center;" >
					<thead style="position: sticky; top: 0;">
					<tr bgcolor="#0A3981" style="color:#ffffff">
					<th></th>
					<th colspan="5" bgcolor="#f1948a" style="color:#ffffff">MEGALINE</th>
					<th colspan="5" bgcolor="#d2b4de" style="color:#ffffff">BROADBAND</th>
					<th colspan="5" bgcolor="#7dcea0" style="color:#ffffff">PEOTV</th>
					<th colspan="5" bgcolor="#fad7a0" style="color:#ffffff">FTTH</th>
					<th colspan="5" bgcolor="#5dade2" style="color:#ffffff">LTE</th>
					<th colspan="5" bgcolor="#f2d7d5" style="color:#ffffff">DATA</th>
					</tr>				
					<tr bgcolor="#0A3981" style="color:#ffffff">
						<th>&nbsp;LEA&nbsp;</th>
						<th>0&#60;hrs&#60;4</th>
						<th>4&#60;hrs&#60;20</th>
						<th>20&#60;hrs&#60;24</th>
						<th>1&#60;D&#60;3</th>
						<th>3&#60;D</th>
						<th>0&#60;hrs&#60;4</th>
						<th>4&#60;hrs&#60;20</th>
						<th>20&#60;hrs&#60;24</th>
						<th>1&#60;D&#60;3</th>
						<th>3&#60;D</th>
						<th>0&#60;hrs&#60;4</th>
						<th>4&#60;hrs&#60;20</th>
						<th>20&#60;hrs&#60;24</th>
						<th>1&#60;D&#60;3</th>
						<th>3&#60;D</th>
					    <th>0&#60;hrs&#60;4</th>
						<th>4&#60;hrs&#60;20</th>
						<th>20&#60;hrs&#60;24</th>
						<th>1&#60;D&#60;3</th>
						<th>3&#60;D</th>
						<th>0&#60;hrs&#60;4</th>
						<th>4&#60;hrs&#60;20</th>
						<th>20&#60;hrs&#60;24</th>
						<th>1&#60;D&#60;3</th>
						<th>3&#60;D</th>
						<th>0&#60;hrs&#60;4</th>
						<th>4&#60;hrs&#60;20</th>
						<th>20&#60;hrs&#60;24</th>
						<th>1&#60;D&#60;3</th>
						<th>3&#60;D</th>
					</tr>
					</thead>
					<tbody id="rDatatbl" style="color:#0A3981; font-weight: 900;">';
				
			
	
				while ($row = oci_fetch_array($userid)) {

					$result .='<tr>
					<td bgcolor="#fef9e7">'.$row['PROM_REGN_CODE'].'</td>
					<td bgcolor="#f1948a">'.$row['MEGALINE_T1'].'</td>
					<td bgcolor="#f1948a">'.$row['MEGALINE_T2'].'</td>
					<td bgcolor="#f1948a">'.$row['MEGALINE_T3'].'</td>
					<td bgcolor="#f1948a">'.$row['MEGALINE_T4'].'</td>
					<td bgcolor="#f1948a">'.$row['MEGALINE_T5'].'</td>
					<td bgcolor="#d2b4de">'.$row['BROADBAND_T1'].'</td>
					<td bgcolor="#d2b4de">'.$row['BROADBAND_T2'].'</td>
					<td bgcolor="#d2b4de">'.$row['BROADBAND_T3'].'</td>
					<td bgcolor="#d2b4de">'.$row['BROADBAND_T4'].'</td>
					<td bgcolor="#d2b4de">'.$row['BROADBAND_T5'].'</td>
					<td bgcolor="#7dcea0">'.$row['PEOTV_T1'].'</td>
					<td bgcolor="#7dcea0">'.$row['PEOTV_T2'].'</td>
					<td bgcolor="#7dcea0">'.$row['PEOTV_T3'].'</td>
					<td bgcolor="#7dcea0">'.$row['PEOTV_T4'].'</td>
					<td bgcolor="#7dcea0">'.$row['PEOTV_T5'].'</td>
					<td bgcolor="#fad7a0">'.$row['FTTH_T1'].'</td>
					<td bgcolor="#fad7a0">'.$row['FTTH_T2'].'</td>
					<td bgcolor="#fad7a0">'.$row['FTTH_T3'].'</td>
					<td bgcolor="#fad7a0">'.$row['FTTH_T4'].'</td>
					<td bgcolor="#fad7a0">'.$row['FTTH_T5'].'</td>
					<td bgcolor="#5dade2">'.$row['LTE_T1'].'</td>
					<td bgcolor="#5dade2">'.$row['LTE_T2'].'</td>
					<td bgcolor="#5dade2">'.$row['LTE_T3'].'</td>
					<td bgcolor="#5dade2">'.$row['LTE_T4'].'</td>
					<td bgcolor="#5dade2">'.$row['LTE_T5'].'</td>
					<td bgcolor="#f2d7d5">'.$row['DATA_T1'].'</td>
					<td bgcolor="#f2d7d5">'.$row['DATA_T2'].'</td>
					<td bgcolor="#f2d7d5">'.$row['DATA_T3'].'</td>
					<td bgcolor="#f2d7d5">'.$row['DATA_T4'].'</td>
					<td bgcolor="#f2d7d5">'.$row['DATA_T5'].'</td>
					</tr>';
					
				} 
				
				$response['error'] = false;
				$response['reply'] = $result; 
			
		
		break;
		
		
		
		
		
		
		

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