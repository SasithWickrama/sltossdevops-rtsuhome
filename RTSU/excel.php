<?php
//require_once 'PHPExcel.php';
//require_once 'PHPExcel/IOFactory.php';

function OracleConnection(){
     $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )
";

    if($c = oci_connect("OSSRPT", "ossrpt123", $db))        
    {
            return $c;
    }
    else
    {
        echo "<script type='text/javascript'>alert('Connection failed')</script>";
    }
}

if(isset($_POST["q"]) && $_POST["q"] == 'penNc') {
    
    $area = $_POST["val"];
	
	$HEADER = "RTOM,SOD NO,Service,Order Type,Time Range,Task Name, Work Group, Assign Date \n";  
	
	$sql ="select distinct a.AREA,a.SOID,a.ORTYP,
case when  a.TIMEDUE < 3 then 'T<=3D'
when  a.TIMEDUE between 3 and 7 then '3D<T<=7D'
when  a.TIMEDUE between 7 and 30  then '7D<T<=1M'
when  a.TIMEDUE >30 then 'T>1M'
else '' end as TIMEDUE,'AB-CAB' , b.SEIT_TASKNAME, b.SEIT_WORG_NAME,b.SEIT_ASSIGNED
	from PENDING_NC2 a  ,service_implementation_tasks b
	where a.SOID = b.SEIT_SERO_ID
	and b.SEIT_STAS_ABBREVIATION= 'INPROGRESS'
	and a.AREA= '$area' 
	union all select distinct a.AREA,a.SOID,a.ORTYP,
case when  a.TIMEDUE < 7 then 'T<=7D'
when  a.TIMEDUE between 7 and 10 then '7D<T<=10D'
when  a.TIMEDUE between 10 and 30  then '10D<T<=1M'
when  a.TIMEDUE >30 then 'T>1M'
else '' end as TIMEDUE,'AB-FTTH' , b.SEIT_TASKNAME, b.SEIT_WORG_NAME,b.SEIT_ASSIGNED
	from PENDING_NCFTTH2 a ,service_implementation_tasks b
	where a.SOID = b.SEIT_SERO_ID
	and b.SEIT_STAS_ABBREVIATION= 'INPROGRESS'
	and a.AREA= '$area' 
	union all select distinct a.AREA,a.SOID,a.ORTYP,
case when  a.TIMEDUE < 3 then 'T<=3D'
when  a.TIMEDUE between 3 and 7 then '3D<T<=7D'
when  a.TIMEDUE between 7 and 30  then '7D<T<=1M'
when  a.TIMEDUE >30 then 'T>1M'
else '' end as TIMEDUE,'IPTV' , b.SEIT_TASKNAME, b.SEIT_WORG_NAME,b.SEIT_ASSIGNED
	from PENDING_NCIPTV2 a ,service_implementation_tasks b
	where a.SOID = b.SEIT_SERO_ID
	and b.SEIT_STAS_ABBREVIATION= 'INPROGRESS'
	and a.AREA= '$area' ";
            
				
    $oraconn = OracleConnection();
    $penNc = oci_parse($oraconn, $sql);

    if(oci_execute($penNc ))
    {    
    
		while($row = oci_fetch_array($penNc)){
	
		$HEADER = $HEADER . "{$row[0]},{$row[1]},{$row[4]},{$row[2]},{$row[3]},{$row[5]},{$row[6]},{$row[7]}\n";	
		} 
		
		
		$File = "files/{$area}_pen.csv";
		$FILE_WRITE = fopen($File, 'w') or die("can't open file");
		fwrite($FILE_WRITE, $HEADER);
		fclose($FILE_WRITE);

		echo "success";  
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo $e;  
    }
    
    
    
}

if(isset($_POST["q"]) && $_POST["q"] == 'penDel') {
    
    $area = $_POST["val"];
	
	$HEADER = "RTOM,SOD NO,Service,Order Type,Time Range,Task Name, Work Group, Assign Date \n";  
	
	$sql ="select distinct a.AREA,a.SOID,a.ORTYP,
case when  a.TIMEDUE < 3 then 'T<=3D'
when  a.TIMEDUE between 3 and 7 then '3D<T<=7D'
when  a.TIMEDUE between 7 and 30  then '7D<T<=1M'
when  a.TIMEDUE >30 then 'T>1M'
else '' end as TIMEDUE,'AB-CAB' , b.SEIT_TASKNAME, b.SEIT_WORG_NAME,b.SEIT_ASSIGNED
	from PENDING_DC2 a ,service_implementation_tasks b
	where a.SOID = b.SEIT_SERO_ID
	and b.SEIT_STAS_ABBREVIATION= 'INPROGRESS'
	and a.AREA= '$area' 
	union all select distinct a.AREA,a.SOID,a.ORTYP,
case when  a.TIMEDUE < 7 then 'T<=7D'
when  a.TIMEDUE between 7 and 10 then '7D<T<=10D'
when  a.TIMEDUE between 10 and 30  then '10D<T<=1M'
when  a.TIMEDUE >30 then 'T>1M'
else '' end as TIMEDUE,'AB-FTTH' , b.SEIT_TASKNAME, b.SEIT_WORG_NAME,b.SEIT_ASSIGNED
	from PENDING_DCFTTH2 a ,service_implementation_tasks b
	where a.SOID = b.SEIT_SERO_ID
	and b.SEIT_STAS_ABBREVIATION= 'INPROGRESS'
	and a.AREA= '$area' 
	union all select distinct a.AREA,a.SOID,a.ORTYP,
case when  a.TIMEDUE < 3 then 'T<=3D'
when  a.TIMEDUE between 3 and 7 then '3D<T<=7D'
when  a.TIMEDUE between 7 and 30  then '7D<T<=1M'
when  a.TIMEDUE >30 then 'T>1M'
else '' end as TIMEDUE,'IPTV' , b.SEIT_TASKNAME, b.SEIT_WORG_NAME,b.SEIT_ASSIGNED
	from PENDING_DCIPTV2 a ,service_implementation_tasks b
	where a.SOID = b.SEIT_SERO_ID
	and b.SEIT_STAS_ABBREVIATION= 'INPROGRESS'
	and a.AREA= '$area' ";
            
				
    $oraconn = OracleConnection();
    $penNc = oci_parse($oraconn, $sql);

    if(oci_execute($penNc ))
    {    
    
		while($row = oci_fetch_array($penNc)){
	
		$HEADER = $HEADER . "{$row[0]},{$row[1]},{$row[4]},{$row[2]},{$row[3]},{$row[5]},{$row[6]},{$row[7]}\n";	
		} 
		
		
		$File = "files/{$area}_del.csv";
		$FILE_WRITE = fopen($File, 'w') or die("can't open file");
		fwrite($FILE_WRITE, $HEADER);
		fclose($FILE_WRITE);

		echo "success";  
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo $e;  
    }
    
    
    
}


if(isset($_POST["q"]) && $_POST["q"] == 'penCan') {
    
    $area = $_POST["val"];
	
	$HEADER = "RTOM,SOD NO,Service,Order Type,Time Range,Task Name, Work Group, Assign Date \n";  
	
	$sql ="select distinct a.AREA,a.SOID,a.ORTYP,
case when  a.TIMEDUE < 3 then 'T<=3D'
when  a.TIMEDUE between 3 and 7 then '3D<T<=7D'
when  a.TIMEDUE between 7 and 30  then '7D<T<=1M'
when  a.TIMEDUE >30 then 'T>1M'
else '' end as TIMEDUE,'AB-CAB' , b.SEIT_TASKNAME, b.SEIT_WORG_NAME,b.SEIT_ASSIGNED
	from PENDING_CAN2 a ,service_implementation_tasks b
	where a.SOID = b.SEIT_SERO_ID
	and b.SEIT_STAS_ABBREVIATION= 'INPROGRESS'
	and a.AREA= '$area'  
	union all select distinct a.AREA,a.SOID,a.ORTYP,
case when  a.TIMEDUE < 7 then 'T<=7D'
when  a.TIMEDUE between 7 and 10 then '7D<T<=10D'
when  a.TIMEDUE between 10 and 30  then '10D<T<=1M'
when  a.TIMEDUE >30 then 'T>1M'
else '' end as TIMEDUE,'AB-FTTH' , b.SEIT_TASKNAME, b.SEIT_WORG_NAME,b.SEIT_ASSIGNED
	from PENDING_CANFTTH2 a ,service_implementation_tasks b
	where a.SOID = b.SEIT_SERO_ID
	and b.SEIT_STAS_ABBREVIATION= 'INPROGRESS'
	and a.AREA= '$area' 
	union all select distinct a.AREA,a.SOID,a.ORTYP,
case when  a.TIMEDUE < 3 then 'T<=3D'
when  a.TIMEDUE between 3 and 7 then '3D<T<=7D'
when  a.TIMEDUE between 7 and 30  then '7D<T<=1M'
when  a.TIMEDUE >30 then 'T>1M'
else '' end as TIMEDUE,'IPTV' , b.SEIT_TASKNAME, b.SEIT_WORG_NAME,b.SEIT_ASSIGNED
	from PENDING_CANIPTV2 a ,service_implementation_tasks b
	where a.SOID = b.SEIT_SERO_ID
	and b.SEIT_STAS_ABBREVIATION= 'INPROGRESS'
	and a.AREA= '$area' ";
            
				
    $oraconn = OracleConnection();
    $penNc = oci_parse($oraconn, $sql);

    if(oci_execute($penNc ))
    {    
    
		while($row = oci_fetch_array($penNc)){
	
		$HEADER = $HEADER . "{$row[0]},{$row[1]},{$row[4]},{$row[2]},{$row[3]},{$row[5]},{$row[6]},{$row[7]}\n";	
		} 
		
		
		$File = "files/{$area}_can.csv";
		$FILE_WRITE = fopen($File, 'w') or die("can't open file");
		fwrite($FILE_WRITE, $HEADER);
		fclose($FILE_WRITE);

		echo "success";  
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo $e;  
    }
    
    
    
}

?>