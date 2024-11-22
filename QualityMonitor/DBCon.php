<?php
function OracleConnection(){
      $db = 	 $db = "  (DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )
";

 /*      $db = "  (DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=172.25.16.192)
      (PORT=1599)
    )
    (CONNECT_DATA=
      (SERVICE_NAME=clty_uat)
    )
  )" ;*/
  
    if($c = oci_connect("OSSPRG", "prgoss456", $db))
    {
            return $c;
    }
    else
    {
        echo "<script type='text/javascript'>alert('Connection failed')</script>";
    }
}

function validate_user($usr)
{
    $sql = "select * from DQ_MONITOR_LOGIN where SER_ID = '$usr'";
    $oraconn = OracleConnection();
    $user = oci_parse($oraconn, $sql);
    if ( oci_execute($user))
    {
    return $user;
    }
    else
    {
        $err = oci_error($user);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}


function get_area($ar)
{
    $sql = "select distinct AREA from DQ_MONITOR_AREA where REGION = '$ar'";
		
    $oraconn = OracleConnection();
    $area = oci_parse($oraconn, $sql);
    if ( oci_execute($area))
    {
    return $area;
    }
    else
    {
        $err = oci_error($area);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}

function get_opmc($ar)
{
    $sql = "select distinct OPMC from DQ_MONITOR_AREA where AREA = '$ar'";
		
    $oraconn = OracleConnection();
    $area = oci_parse($oraconn, $sql);
    if ( oci_execute($area))
    {
    return $area;
    }
    else
    {
        $err = oci_error($area);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}

function get_contractor($ar)
{
    $sql = "select distinct UR_CONTRACTORS from DQ_TEAM where OPMC_AREA = '$ar'";
		
    $oraconn = OracleConnection();
    $area = oci_parse($oraconn, $sql);
    if ( oci_execute($area))
    {
    return $area;
    }
    else
    {
        $err = oci_error($area);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}

function get_team($ar,$op)
{
    $sql = "select count( *) over (),a.WFM_WG_ID
                from DQ_TEAM a
                where UR_CONTRACTORS = '$ar' and OPMC_AREA = '$op'";
    $oraconn = OracleConnection();
    $area = oci_parse($oraconn, $sql);
    if ( oci_execute($area))
    {
    return $area;
    }
    else
    {
        $err = oci_error($area);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}


function getdetail($op,$tm,$dt,$dtfr)
{
    $sql = "select B.DQ_DATE,C.DRESS,C.IDCARD,C.VEHICLE,C.TOOL,C.STANDERD
        from DQ_TEAM a,DQ_MONITOR b,DQ_MONITOR_LIST c
        where B.DQ_ID = C.DQ_ID
        and A.WFM_WG_ID = B.TEAM
        and A.WFM_WG_ID = C.TEAMNAME
        and A.OPMC_AREA = '$op'
        and A.WFM_WG_ID = '$tm'
        AND B.DQ_DATE BETWEEN '$dtfr' AND '$dt'
		order by B.DQ_DATE";
    $oraconn = OracleConnection();
    $area = oci_parse($oraconn, $sql);
    if ( oci_execute($area))
    {
    return $area;
    }
    else
    {
        $err = oci_error($area);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}

function chk_team($ar,$op)
{
    $sqlteam = "select count(*) 
            from DQ_MONITOR_TEAM a,DQ_TEAM b
            where a.TEAM_NAME = b.WFM_WG_ID
            and b.UR_CONTRACTORS = '$ar'
            and b.OPMC_AREA = '$op'";
     $oraconn = OracleConnection();
     $team = oci_parse($oraconn, $sqlteam);      
    if ( oci_execute($team))
    {
    return $team;
    }
    else
    {
        $err = oci_error($team);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
    

}

function get_teamlist($ar,$op)
{
    $sql = "select distinct b.TEAM_NAME
 from DQ_TEAM a, DQ_MONITOR_TEAM b
where a.WFM_WG_ID = b.TEAM_NAME
and  a.UR_CONTRACTORS = '$ar' and a.OPMC_AREA = '$op'";
		
    $oraconn = OracleConnection();
    $area = oci_parse($oraconn, $sql);
    if ( oci_execute($area))
    {
    return $area;
    }
    else
    {
        $err = oci_error($area);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}

function updatedq($a,$b,$c,$d)
{
    $sql = "INSERT INTO DQ_MONITOR (DQ_ID, TEAM, EN_USER, EN_DATE,DQ_DATE) 
VALUES ('$a','$b','$c',sysdate,'$d')";
		
    $oraconn = OracleConnection();
    $insert = oci_parse($oraconn, $sql);
    if ( oci_execute($insert))
    {    
        $sql2= "select * from DQ_MONITOR_TEAM where TEAM_NAME = '$b'";
        $oraconn = OracleConnection();
        $select = oci_parse($oraconn, $sql2);
        oci_execute($select);
        $i=1;
        while($row = oci_fetch_array($select))
        {
           if($i==1)
           {
            $sql3="update DQ_MONITOR 
                    set NAME1= '$row[1]' , ID1='$row[2]' , CONTACT1='$row[3]' 
                    where DQ_ID = '$a'";
           }
           if($i==2)
           {
            $sql3="update DQ_MONITOR 
                    set NAME2= '$row[1]' , ID2='$row[2]' , CONTACT2='$row[3]' 
                    where DQ_ID = '$a'";
            }         
            $oraconn = OracleConnection();
            $update = oci_parse($oraconn, $sql3);
            oci_execute($update);
            
            $i++;
        }
    }
    else
    {
        $err = oci_error($insert);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}

function updateteam($a,$b,$c,$d)
{
    $sql = "INSERT INTO DQ_MONITOR_TEAM (TEAM_NAME, USER_NAME, IDNO, CONTACT_NO) 
            VALUES ('$a','$b','$c','$d') ";
		
    $oraconn = OracleConnection();
    $insert = oci_parse($oraconn, $sql);
    if ( oci_execute($insert))
    {
    return $insert;
    }
    else
    {
        $err = oci_error($insert);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}

function updatelist($a,$b,$c,$d,$e,$f,$g,$h,$j,$k,$l,$m,$n,$p,$r,$x,$y,$z)
{
    $sql = "INSERT INTO DQ_MONITOR_LIST (DQ_ID,TEAMNAME ,AUTH_LETT, DRESS,VEHICLE, TOOL, LADDER,SAFETY, METERIAL, PROGRESS,INFOCOL, SAME_STAFF,CHECK_COMPETENCY,TYPEWORK,ALLAREA,WFM,IDCARD,STANDERD) 
VALUES ('$a','$b','$c','$d','$e','$f','$g','$h','$j','$k','$l','$m','$n','$p','$r','$x','$y','$z')";
		
    $oraconn = OracleConnection();
    $insert = oci_parse($oraconn, $sql);
    if ( oci_execute($insert))
    {
    return $insert;
    }
    else
    {
        $err = oci_error($insert);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }

}

function getuser($a)
{
    $sql = "select a.USER_NAME,a.IDNO,a.CONTACT_NO
    from DQ_MONITOR_TEAM a,DQ_TEAM b
    where a.TEAM_NAME = B.WFM_WG_ID
    and b.WFM_WG_ID = '$a'";
		
    $oraconn = OracleConnection();
    $user = oci_parse($oraconn, $sql);
    if ( oci_execute($user))
    {
    return $user;
    }
    else
    {
        $err = oci_error($user);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}


function delteam($a)
{
    $sql = "delete from DQ_MONITOR_TEAM where TEAM_NAME= '$a'";
		
    $oraconn = OracleConnection();
    $del = oci_parse($oraconn, $sql);
    if ( oci_execute($del))
    {
    return 0;
    }
    else
    {
        $err = oci_error($del);
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}
?>