<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION["user"];
	$area = $_SESSION['rtom'];
	$temp = explode('/',$area);
	$level =$_SESSION["level"];
	$n = sizeof($temp);
	
	
}
else 
{     
    echo '<script type="text/javascript">login.html";</script>'; 
}

$so_id = $_GET["id"];
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

function so_count_pen($or_type,$area)
{ 
    $sql ="select
            (select count(distinct soid) 
            from PENDING_NC2 a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <=3),
            (select count(distinct soid) 
            from PENDING_NC2 b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 3 and 7) ,
            (select count(distinct soid) 
            from PENDING_NC2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE between 7 and 30 ), 
			 (select count(distinct soid) 
            from PENDING_NC2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE >30 ) 
            from PENDING_NC2 x
            where x.AREA = '$area'
            group by x.AREA ";
            
				
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
    return $nc ;
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}
function so_count_pen2($or_type,$area)
{ 
    $sql ="select
            (select count(distinct soid) 
            from PENDING_NCIPTV2 a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <=3),
            (select count(distinct soid) 
            from PENDING_NCIPTV2 b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 3 and 7) ,
            (select count(distinct soid) 
            from PENDING_NCIPTV2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE between 7 and 30 ),
			(select count(distinct soid) 
            from PENDING_NCIPTV2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE > 30 )			
            from PENDING_NCIPTV2 x
            where x.AREA = '$area'
            group by x.AREA ";
            
				
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
    return $nc ;
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}
function so_count_pen3($or_type,$area)
{ 
    $sql ="select
            (select count(distinct soid) 
            from PENDING_NCFTTH2 a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <=7),
            (select count(distinct soid) 
            from PENDING_NCFTTH2 b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 7 and 10) ,
            (select count(distinct soid) 
            from PENDING_NCFTTH2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE between 10 and 30 ) ,
			(select count(distinct soid) 
            from PENDING_NCFTTH2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE > 30 ) 
            from PENDING_NCFTTH2 x
            where x.AREA = '$area'
            group by x.AREA ";
            
				
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
    return $nc ;
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}
//Delete
function so_count_del($or_type,$area)
{ 
    $sql ="select
            (select count(distinct soid) 
            from PENDING_DC2 a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <=3),
            (select count(distinct soid) 
            from PENDING_DC2 b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 3 and 7) ,
            (select count(distinct soid) 
            from PENDING_DC2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE between 7 and 30 ), 
			 (select count(distinct soid) 
            from PENDING_DC2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE >30 ) 
            from PENDING_DC2 x
            where x.AREA = '$area'
            group by x.AREA ";
            
				
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
    return $nc ;
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}

function so_count_del2($or_type,$area)
{ 
    $sql ="select
            (select count(distinct soid) 
            from PENDING_DCIPTV2 a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <=3),
            (select count(distinct soid) 
            from PENDING_DCIPTV2 b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 3 and 7) ,
            (select count(distinct soid) 
            from PENDING_DCIPTV2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE between 7 and 30 ),
			(select count(distinct soid) 
            from PENDING_DCIPTV2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE > 30 )			
            from PENDING_DCIPTV2 x
            where x.AREA = '$area'
            group by x.AREA ";
            
		
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
    return $nc ;
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}
function so_count_del3($or_type,$area)
{ 
    $sql ="select
            (select count(distinct soid) 
            from PENDING_DCFTTH2 a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <=7),
            (select count(distinct soid) 
            from PENDING_DCFTTH2 b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 7 and 10) ,
            (select count(distinct soid) 
            from PENDING_DCFTTH2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE between 10 and 30 ) ,
			(select count(distinct soid) 
            from PENDING_DCFTTH2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE > 30 ) 
            from PENDING_DCFTTH2 x
            where x.AREA = '$area'
            group by x.AREA ";
            
				
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
    return $nc ;
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}
	
//FOR CANCELLETION
function so_count_can($or_type,$area)
{ 
    $sql ="select
            (select count(distinct soid) 
            from PENDING_CAN2 a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <=3),
            (select count(distinct soid) 
            from PENDING_CAN2 b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 3 and 7) ,
            (select count(distinct soid) 
            from PENDING_CAN2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE between 7 and 30 ), 
			 (select count(distinct soid) 
            from PENDING_CAN2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE >30 ) 
            from PENDING_CAN2 x
            where x.AREA = '$area'
            group by x.AREA ";
            
				
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
    return $nc ;
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}
function so_count_can2($or_type,$area)
{ 
    $sql ="select
            (select count(distinct soid) 
            from PENDING_CANIPTV2 a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <=3),
            (select count(distinct soid) 
            from PENDING_CANIPTV2 b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 3 and 7) ,
            (select count(distinct soid) 
            from PENDING_CANIPTV2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE between 7 and 30 ),
			(select count(distinct soid) 
            from PENDING_CANIPTV2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE > 30 )			
            from PENDING_CANIPTV2 x
            where x.AREA = '$area'
            group by x.AREA ";
            
				
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
    return $nc ;
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}
function so_count_can3($or_type,$area)
{ 
    $sql ="select
            (select count(distinct soid) 
            from PENDING_CANFTTH2 a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <=7),
            (select count(distinct soid) 
            from PENDING_CANFTTH2 b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 7 and 10) ,
            (select count(distinct soid) 
            from PENDING_CANFTTH2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE between 10 and 30 ) ,
			(select count(distinct soid) 
            from PENDING_CANFTTH2 c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE > 30 ) 
            from PENDING_CANFTTH2 x
            where x.AREA = '$area'
            group by x.AREA ";
            
				
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
    return $nc ;
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}

function updateTime()
{ 
    $sql ="select TO_CHAR(UPDATE_TIME, 'mm/dd/yyyy hh:mi:ss AM') from PENDING_NC_TIME";
            
				
    $oraconn = OracleConnection();
    $nc = oci_parse($oraconn, $sql);

    if(oci_execute($nc ))
    {    
		$row=oci_fetch_array($nc);
		return $row[0];
    }
    else
    {
        $err = oci_error($nc );
        $e =  $err['message'];
        echo "<script type='text/javascript'>alert('$e')</script>";
    }
}	
?>

<!DOCTYPE html>
<html>
<title>NC</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/w3.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="css/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu.min.js"></script>
    <!-- Morris Charts JavaScript -->
    <script src="js/raphael.min.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/morris-data.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
<style>
  #img1:hover {
    cursor: pointer;
}

#img2:hover {
    cursor: pointer;
}

#img3:hover {
    cursor: pointer;
}

#loading-overlay {
    position: absolute;
    width: 100%;
    height:100%;
    left: 0;
    top: 0;
    display: none;
    align-items: center;
    background-color: #000;
    z-index: 999;
    opacity: 0.5;
}
.loading-icon{ position:absolute;border-top:4px solid #fff;border-right:4px solid #fff;border-bottom:4px solid #fff;border-left:4px solid #767676;border-radius:60px;width:60px;height:60px;margin:0 auto;position:absolute;left:50%;margin-left:-20px;top:50%;margin-top:-20px;z-index:4;-webkit-animation:spin 1s linear infinite;-moz-animation:spin 1s linear infinite;animation:spin 1s linear infinite;}
@-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
@-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
@keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
</style> 

<script>
function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("con");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-light-blue", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " w3-light-blue";
}


function dwnloadpen(val){
	
	var q = 'penNc';
          $.ajax({

            type:"post",
             url:"excel.php",
             data:"q="+q+"&val="+val,
			 beforeSend: function(){
            $("#loading-overlay").show();
            },
             success:function(data){

                    if(data == "success"){
                        $("#loading-overlay").hide();
						 $("#img1").hide(100);
						 $("#img1dw").show(100);
                        
                    }else{
                        alert(data);
                        location.reload();
                    }
                
                }
          });
}

function dwnloaddel(val){
	
	var q = 'penDel';
          $.ajax({

            type:"post",
             url:"excel.php",
             data:"q="+q+"&val="+val,
			 beforeSend: function(){
            $("#loading-overlay").show();
            },
             success:function(data){

                    if(data == "success"){
                        $("#loading-overlay").hide();
						 $("#img2").hide(100);
						 $("#img2dw").show(100);
                        
                    }else{
                        alert(data);
                        location.reload();
                    }
                
                }
          });
}

function dwnloadcan(val){
	
	var q = 'penCan';
          $.ajax({

            type:"post",
             url:"excel.php",
             data:"q="+q+"&val="+val,
			 beforeSend: function(){
            $("#loading-overlay").show();
            },
             success:function(data){

                    if(data == "success"){
                        $("#loading-overlay").hide();
						 $("#img3").hide(100);
						 $("#img3dw").show(100);
                        
                    }else{
                        alert(data);
                        location.reload();
                    }
                
                }
          });
}
</script>


<body>

<div class="w3-container">
  <h2  style="text-align:center"><?php echo $area ; ?> Pending Connection Summary</h2>

<br/>
<div class="row">
<div class="col-lg-12 col-md-6">
  <div class="w3-bar w3-gray" style="font-size:18px;">
  <div class="col-lg-9 col-md-6">
    <button class="w3-bar-item w3-button tablink w3-light-blue" onclick="openCity(event,'new')">New Connection</button>
    <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'del')">Delete</button>
    <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'can')">For Cancellation</button>
 </div>	
	<b>Last Updated : <?php echo updateTime(); ?>

	</div>
  </div>
</div> 
</div> 

<br/>
  <div id="new" class="w3-container w3-border con">
    <br/>
	<?php
	$i=0;	
	while ($i < $n)
	{
		//CREATE
		$or_type = 'CREATE';
		$so_count = so_count_pen($or_type,$temp[$i]);
		$row=oci_fetch_array($so_count);
		if ($row[0] == null)
		{
		$row[0] = 0;
		}
		if ($row[1] == null)
		{
		$row[1] = 0;
		}
		if ($row[2] == null)
		{
		$row[2] = 0;
		}
		if ($row[3] == null)
		{
		$row[3] = 0;
		}
		$tot =	$row[0]+$row[1]+$row[2]+$row[3];
		
		//CREATE OR 
		$or_type = 'CREATE-OR';
		$so_count = so_count_pen($or_type,$temp[$i]);
		$row2=oci_fetch_array($so_count);
		if ($row2[0] == null)
		{
		$row2[0] = 0;
		}
		if ($row2[1] == null)
		{
		$row2[1] = 0;
		}
		if ($row2[2] == null)
		{
		$row2[2] = 0;
		}
		if ($row2[3] == null)
		{
		$row2[3] = 0;
		}
		$tot2 =	$row2[0]+$row2[1]+$row2[2]+$row2[3];
		
		//CREATE RECON 
		$or_type = 'CREATE-RECON';
		$so_count = so_count_pen($or_type,$temp[$i]);
		$row3=oci_fetch_array($so_count);
		if ($row3[0] == null)
		{
		$row3[0] = 0;
		}
		if ($row3[1] == null)
		{
		$row3[1] = 0;
		}
		if ($row3[2] == null)
		{
		$row3[2] = 0;
		}
		if ($row3[3] == null)
		{
		$row3[3] = 0;
		}
		$tot3 =	$row3[0]+$row3[1]+$row3[2]+$row3[3];
		
		//MODIFY LOCATION 
		$or_type = 'MODIFY-LOCATION';
		$so_count = so_count_pen($or_type,$temp[$i]);
		$row4=oci_fetch_array($so_count);
		if ($row4[0] == null)
		{
		$row4[0] = 0;
		}
		if ($row4[1] == null)
		{
		$row4[1] = 0;
		}
		if ($row4[2] == null)
		{
		$row4[2] = 0;
		}
		if ($row4[3] == null)
		{
		$row4[3] = 0;
		}
		$tot4 =	$row4[0]+$row4[1]+$row4[2]+$row4[3];	

			
		echo "	
		<div class=\"row\">
                <div class=\"col-lg-11\">
					<img src=\"img/MegaLine.jpg\" >
                </div>
				<div class=\"col-lg-1\">
					<img src=\"img/Excel.ico \" width=\"50\" height=\"50\" id=\"img1\" onclick=\"dwnloadpen('$area')\">
					<p id=\"img1dw\" style=\"display:none\"><a href=\"files/{$area}_pen.csv\" download>Download</a></p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			
            <!-- /.row -->
			<div class=\"row\">
				
	
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE</span></div>
                                </div>
                            </div>
                        </div>
						
                       
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

                    </div>
					
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot2</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE OR</span></div>
                                </div>
                            </div>
                        </div>
					
                           <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE RECON</span></div>
                                </div>
                            </div>
                        </div>
					
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot4</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY LOCATION</span></div>
                                </div>
                            </div>
                        </div>
				
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
				

				
            </div>
            <!-- /.row -->";
			$i++;
	}
    echo"	<div class=\"row\">
			</br>
                <div class=\"col-lg-12\">
                    <img src=\"img/peologo_new.jpg\" >
                </div>
                <!-- /.col-lg-12 -->
            </div>";
	
	//IPTV
	$k=0;	
	while ($k < $n)
	{
		//CREATE
		$ser_type = 'IPTV';
		$or_type = 'CREATE';
		$so_count = so_count_pen2($or_type,$temp[$k]);
		$row=oci_fetch_array($so_count);
		if ($row[0] == null)
		{
		$row[0] = 0;
		}
		if ($row[1] == null)
		{
		$row[1] = 0;
		}
		if ($row[2] == null)
		{
		$row[2] = 0;
		}
		if ($row[3] == null)
		{
		$row[3] = 0;
		}
		$tot =	$row[0]+$row[1]+$row[2]+$row[3];
		
		//CREATE OR 
		$or_type = 'CREATE-OR';
		$so_count = so_count_pen2($or_type,$temp[$k]);
		$row2=oci_fetch_array($so_count);
		if ($row2[0] == null)
		{
		$row2[0] = 0;
		}
		if ($row2[1] == null)
		{
		$row2[1] = 0;
		}
		if ($row2[2] == null)
		{
		$row2[2] = 0;
		}
		if ($row2[3] == null)
		{
		$row2[3] = 0;
		}
		$tot2 =	$row2[0]+$row2[1]+$row2[2]+$row2[3];
		
		//CREATE-RECON
		$or_type = 'CREATE-RECON';
		$so_count = so_count_pen2($or_type,$temp[$k]);
		$row3=oci_fetch_array($so_count);
		if ($row3[0] == null)
		{
		$row3[0] = 0;
		}
		if ($row3[1] == null)
		{
		$row3[1] = 0;
		}
		if ($row3[2] == null)
		{
		$row3[2] = 0;
		}
		if ($row3[3] == null)
		{
		$row3[3] = 0;
		}
		$tot3 =	$row3[0]+$row3[1]+$row3[2]+$row3[3];
		
		//MODIFY LOCATION 
		$or_type = 'MODIFY-LOCATION';
		$so_count = so_count_pen2($or_type,$temp[$k]);
		$row4=oci_fetch_array($so_count);
		if ($row4[0] == null)
		{
		$row4[0] = 0;
		}
		if ($row4[1] == null)
		{
		$row4[1] = 0;
		}
		if ($row4[2] == null)
		{
		$row4[2] = 0;
		}
		if ($row4[3] == null)
		{
		$row4[3] = 0;
		}
		$tot4 =	$row4[0]+$row4[1]+$row4[2]+$row4[3];	


	
			
		echo "	<div>
			</div>
            <!-- /.row -->
			<div class=\"row\">
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE</span></div>
                                </div>
                            </div>
                        </div>
						
                                <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
					
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot2</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE OR</span></div>
                                </div>
                            </div>
                        </div>
					
                           <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE RECON</span></div>
                                </div>
                            </div>
                        </div>
					
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot4</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY LOCATION</span></div>
                                </div>
                            </div>
                        </div>
				
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
				


                
				
            </div>
            <!-- /.row -->";
			$k++;
	}
    echo"	<div class=\"row\">
		</br>
                <div class=\"col-lg-12\">
                    <img src=\"img/smartline.jpg\" >
                </div>
                <!-- /.col-lg-12 -->
            </div>";
	
	//FTTH
	$m=0;	
	while ($m < $n)
	{
		//CREATE
		$ser_type = 'FTTH';
		$or_type = 'CREATE';
		$so_count3 = so_count_pen3($or_type,$temp[$m]);
		$row=oci_fetch_array($so_count3);
		if ($row[0] == null)
		{
		$row[0] = 0;
		}
		if ($row[1] == null)
		{
		$row[1] = 0;
		}
		if ($row[2] == null)
		{
		$row[2] = 0;
		}
		if ($row[3] == null)
		{
		$row[3] = 0;
		}
		$tot =	$row[0]+$row[1]+$row[2]+$row[3];
		
		//CREATE OR 
		$or_type = 'CREATE-OR';
		$so_count3 = so_count_pen3($or_type,$temp[$m]);
		$row2=oci_fetch_array($so_count3);
		if ($row2[0] == null)
		{
		$row2[0] = 0;
		}
		if ($row2[1] == null)
		{
		$row2[1] = 0;
		}
		if ($row2[2] == null)
		{
		$row2[2] = 0;
		}
		if ($row2[3] == null)
		{
		$row2[3] = 0;
		}
		$tot2 =	$row2[0]+$row2[1]+$row2[2]+$row2[3];
		
		//MODIFY LOCATION
		$or_type = 'MODIFY-LOCATION';
		$so_count3 = so_count_pen3($or_type,$temp[$m]);
		$row3=oci_fetch_array($so_count3);
		if ($row3[0] == null)
		{
		$row3[0] = 0;
		}
		if ($row3[1] == null)
		{
		$row3[1] = 0;
		}
		if ($row3[2] == null)
		{
		$row3[2] = 0;
		}
		if ($row3[3] == null)
		{
		$row3[3] = 0;
		}
		$tot3 =	$row3[0]+$row3[1]+$row3[2]+$row3[3];
		
		//CREATE-UPGRD SAME NO
		$or_type = 'CREATE-UPGRD SAME NO';
		$so_count = so_count_pen3($or_type,$temp[$m]);
		$row4=oci_fetch_array($so_count);
		if ($row4[0] == null)
		{
		$row4[0] = 0;
		}
		if ($row4[1] == null)
		{
		$row4[1] = 0;
		}
		if ($row4[2] == null)
		{
		$row4[2] = 0;
		}
		if ($row4[3] == null)
		{
		$row4[3] = 0;
		}
		$tot4 =	$row4[0]+$row4[1]+$row4[2]+$row4[3];	

			
		echo "	<div>
			</div>
            <!-- /.row -->
			<div class=\"row\">
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE</span></div>
                                </div>
                            </div>
                        </div>
						
						
						<div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						
                        
                                                                               
                    </div>
					
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot2</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE OR</span></div>
                                </div>
                            </div>
                        </div>
					
                           <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY LOCATION</span></div>
                                </div>
                            </div>
                        </div>
					
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot4</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE-UPGRD SAME NO</span></div>
                                </div>
                            </div>
                        </div>
				
                           <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
				


            </div>
            <!-- /.row -->";
			$m++;
	}
	
	
	
	?>
  </div>

  <div id="del" class="w3-container w3-border con" style="display:none">
    <br/>
	<?php
	$i=0;	
	while ($i < $n)
	{


		//DELETE 
		$or_type = 'DELETE';
		$so_count = so_count_del($or_type,$temp[$i]);
		$row5=oci_fetch_array($so_count);
		if ($row5[0] == null)
		{
		$row5[0] = 0;
		}
		if ($row5[1] == null)
		{
		$row5[1] = 0;
		}
		if ($row5[2] == null)
		{
		$row5[2] = 0;
		}
		if ($row5[3] == null)
		{
		$row5[3] = 0;
		}
		$tot5 =	$row5[0]+$row5[1]+$row5[2]+$row5[3];	
		
		//DELETE OR 
		$or_type = 'DELETE-OR';
		$so_count = so_count_del($or_type,$temp[$i]);
		$row6=oci_fetch_array($so_count);
		if ($row6[0] == null)
		{
		$row6[0] = 0;
		}
		if ($row6[1] == null)
		{
		$row6[1] = 0;
		}
		if ($row6[2] == null)
		{
		$row6[2] = 0;
		}
		if ($row6[3] == null)
		{
		$row6[3] = 0;
		}
		$tot6 =	$row6[0]+$row6[1]+$row6[2]+$row6[3];
			
		echo "	<div class=\"row\">
                <div class=\"col-lg-11\">
					<img src=\"img/MegaLine.jpg\" >
                </div>
				<div class=\"col-lg-1\">
					<img src=\"img/Excel.ico \" width=\"50\" height=\"50\" id=\"img2\" onclick=\"dwnloaddel('$area')\">
					<p id=\"img2dw\" style=\"display:none\"><a href=\"files/{$area}_del.csv\" download>Download</a></p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class=\"row\">

                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot5</span></div>
                                    <div><span style=\"font-weight: bold;\">DELETE</span></div>
                                </div>
                            </div>
                        </div>
						
                       
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>

                    </div>
					
                 </div>

                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot6</span></div>
                                    <div><span style=\"font-weight: bold;\">DELETE-OR</span></div>
                                </div>
                            </div>
                        </div>
						
                       
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>

                    </div>
					 </div>

				
                
                
				
            </div>
            <!-- /.row -->";
			$i++;
	}
    echo"	<div class=\"row\">
			</br>
                <div class=\"col-lg-12\">
                    <img src=\"img/peologo_new.jpg\" >
                </div>
                <!-- /.col-lg-12 -->
            </div>";
	
	//IPTV
	$k=0;	
	while ($k < $n)
	{
	
		//DELETE 
		$or_type = 'DELETE';
		$so_count = so_count_del2($or_type,$temp[$k]);
		$row5=oci_fetch_array($so_count);
		if ($row5[0] == null)
		{
		$row5[0] = 0;
		}
		if ($row5[1] == null)
		{
		$row5[1] = 0;
		}
		if ($row5[2] == null)
		{
		$row5[2] = 0;
		}
		if ($row5[3] == null)
		{
		$row5[3] = 0;
		}
		$tot5 =	$row5[0]+$row5[1]+$row5[2]+$row5[3];	
		
		//DELETE OR 
		$or_type = 'DELETE-OR';
		$so_count = so_count_del2($or_type,$temp[$k]);
		$row6=oci_fetch_array($so_count);
		if ($row6[0] == null)
		{
		$row6[0] = 0;
		}
		if ($row6[1] == null)
		{
		$row6[1] = 0;
		}
		if ($row6[2] == null)
		{
		$row6[2] = 0;
		}
		if ($row6[3] == null)
		{
		$row6[3] = 0;
		}
		$tot6 =	$row6[0]+$row6[1]+$row6[2]+$row6[3];	
			
		echo "	<div>
			</div>
            <!-- /.row -->
			<div class=\"row\">

				
				                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot5</span></div>
                                    <div><span style=\"font-weight: bold;\">DELETE</span></div>
                                </div>
                            </div>
                        </div>
						
                       
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>

                    </div>
					
                 </div>

                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot6</span></div>
                                    <div><span style=\"font-weight: bold;\">DELETE-OR</span></div>
                                </div>
                            </div>
                        </div>
						
                       
                          <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>

                    </div>
					 </div>
				
            </div>
            <!-- /.row -->";
			$k++;
	}
    echo"	<div class=\"row\">
		</br>
                <div class=\"col-lg-12\">
                    <img src=\"img/smartline.jpg\" >
                </div>
                <!-- /.col-lg-12 -->
            </div>";
	
	//FTTH
	$m=0;	
	while ($m < $n)
	{
	
		//DELETE 
		$or_type = 'DELETE';
		$so_count = so_count_del3($or_type,$temp[$m]);
		$row5=oci_fetch_array($so_count);
		if ($row5[0] == null)
		{
		$row5[0] = 0;
		}
		if ($row5[1] == null)
		{
		$row5[1] = 0;
		}
		if ($row5[2] == null)
		{
		$row5[2] = 0;
		}
		if ($row5[3] == null)
		{
		$row5[3] = 0;
		}
		$tot5 =	$row5[0]+$row5[1]+$row5[2]+$row5[3];	
		
		//DELETE OR 
		$or_type = 'DELETE-OR';
		$so_count = so_count_del3($or_type,$temp[$m]);
		$row6=oci_fetch_array($so_count);
		if ($row6[0] == null)
		{
		$row6[0] = 0;
		}
		if ($row6[1] == null)
		{
		$row6[1] = 0;
		}
		if ($row6[2] == null)
		{
		$row6[2] = 0;
		}
		if ($row6[3] == null)
		{
		$row6[3] = 0;
		}
		$tot6 =	$row6[0]+$row6[1]+$row6[2]+$row6[3];		
			
		echo "	<div>
			</div>
            <!-- /.row -->
			<div class=\"row\">

				                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot5</span></div>
                                    <div><span style=\"font-weight: bold;\">DELETE</span></div>
                                </div>
                            </div>
                        </div>
						
                       
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row5[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>

                    </div>
					
                 </div>

                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot6</span></div>
                                    <div><span style=\"font-weight: bold;\">DELETE-OR</span></div>
                                </div>
                            </div>
                        </div>
						
                       
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row6[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>

                    </div>
					 </div>
				
            </div>
            <!-- /.row -->";
			$m++;
	}
	?>
  </div>

  <div id="can" class="w3-container w3-border con" style="display:none">
    <br/>
	<?php
	$i=0;	
	while ($i < $n)
	{
		//CREATE
		$or_type = 'CREATE';
		$so_count = so_count_can($or_type,$temp[$i]);
		$row=oci_fetch_array($so_count);
		if ($row[0] == null)
		{
		$row[0] = 0;
		}
		if ($row[1] == null)
		{
		$row[1] = 0;
		}
		if ($row[2] == null)
		{
		$row[2] = 0;
		}
		if ($row[3] == null)
		{
		$row[3] = 0;
		}
		$tot =	$row[0]+$row[1]+$row[2]+$row[3];
		
		//CREATE OR 
		$or_type = 'CREATE-OR';
		$so_count = so_count_can($or_type,$temp[$i]);
		$row2=oci_fetch_array($so_count);
		if ($row2[0] == null)
		{
		$row2[0] = 0;
		}
		if ($row2[1] == null)
		{
		$row2[1] = 0;
		}
		if ($row2[2] == null)
		{
		$row2[2] = 0;
		}
		if ($row2[3] == null)
		{
		$row2[3] = 0;
		}
		$tot2 =	$row2[0]+$row2[1]+$row2[2]+$row2[3];
		
		//CREATE RECON 
		$or_type = 'CREATE-RECON';
		$so_count = so_count_can($or_type,$temp[$i]);
		$row3=oci_fetch_array($so_count);
		if ($row3[0] == null)
		{
		$row3[0] = 0;
		}
		if ($row3[1] == null)
		{
		$row3[1] = 0;
		}
		if ($row3[2] == null)
		{
		$row3[2] = 0;
		}
		if ($row3[3] == null)
		{
		$row3[3] = 0;
		}
		$tot3 =	$row3[0]+$row3[1]+$row3[2]+$row3[3];
		
		//MODIFY LOCATION 
		$or_type = 'MODIFY-LOCATION';
		$so_count = so_count_can($or_type,$temp[$i]);
		$row4=oci_fetch_array($so_count);
		if ($row4[0] == null)
		{
		$row4[0] = 0;
		}
		if ($row4[1] == null)
		{
		$row4[1] = 0;
		}
		if ($row4[2] == null)
		{
		$row4[2] = 0;
		}
		if ($row4[3] == null)
		{
		$row4[3] = 0;
		}
		$tot4 =	$row4[0]+$row4[1]+$row4[2]+$row4[3];	

			
		echo "	
		<div class=\"row\">
                <div class=\"col-lg-11\">
					<img src=\"img/MegaLine.jpg\" >
                </div>
				<div class=\"col-lg-1\">
					<img src=\"img/Excel.ico \" width=\"50\" height=\"50\" id=\"img3\" onclick=\"dwnloadcan('$area')\">
					<p id=\"img3dw\" style=\"display:none\"><a href=\"files/{$area}_can.csv\" download>Download</a></p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			
            <!-- /.row -->
			<div class=\"row\">
				
	
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE</span></div>
                                </div>
                            </div>
                        </div>
						
                       
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

                    </div>
					
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot2</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE OR</span></div>
                                </div>
                            </div>
                        </div>
					
                           <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE RECON</span></div>
                                </div>
                            </div>
                        </div>
					
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot4</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY LOCATION</span></div>
                                </div>
                            </div>
                        </div>
				
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
				

				
            </div>
            <!-- /.row -->";
			$i++;
	}
    echo"	<div class=\"row\">
			</br>
                <div class=\"col-lg-12\">
                    <img src=\"img/peologo_new.jpg\" >
                </div>
                <!-- /.col-lg-12 -->
            </div>";
	
	//IPTV
	$k=0;	
	while ($k < $n)
	{
		//CREATE
		$ser_type = 'IPTV';
		$or_type = 'CREATE';
		$so_count = so_count_can2($or_type,$temp[$k]);
		$row=oci_fetch_array($so_count);
		if ($row[0] == null)
		{
		$row[0] = 0;
		}
		if ($row[1] == null)
		{
		$row[1] = 0;
		}
		if ($row[2] == null)
		{
		$row[2] = 0;
		}
		if ($row[3] == null)
		{
		$row[3] = 0;
		}
		$tot =	$row[0]+$row[1]+$row[2]+$row[3];
		
		//CREATE OR 
		$or_type = 'CREATE-OR';
		$so_count = so_count_can2($or_type,$temp[$k]);
		$row2=oci_fetch_array($so_count);
		if ($row2[0] == null)
		{
		$row2[0] = 0;
		}
		if ($row2[1] == null)
		{
		$row2[1] = 0;
		}
		if ($row2[2] == null)
		{
		$row2[2] = 0;
		}
		if ($row2[3] == null)
		{
		$row2[3] = 0;
		}
		$tot2 =	$row2[0]+$row2[1]+$row2[2]+$row2[3];
		
		//CREATE-RECON
		$or_type = 'CREATE-RECON';
		$so_count = so_count_can2($or_type,$temp[$k]);
		$row3=oci_fetch_array($so_count);
		if ($row3[0] == null)
		{
		$row3[0] = 0;
		}
		if ($row3[1] == null)
		{
		$row3[1] = 0;
		}
		if ($row3[2] == null)
		{
		$row3[2] = 0;
		}
		if ($row3[3] == null)
		{
		$row3[3] = 0;
		}
		$tot3 =	$row3[0]+$row3[1]+$row3[2]+$row3[3];
		
		//MODIFY LOCATION 
		$or_type = 'MODIFY-LOCATION';
		$so_count = so_count_can2($or_type,$temp[$k]);
		$row4=oci_fetch_array($so_count);
		if ($row4[0] == null)
		{
		$row4[0] = 0;
		}
		if ($row4[1] == null)
		{
		$row4[1] = 0;
		}
		if ($row4[2] == null)
		{
		$row4[2] = 0;
		}
		if ($row4[3] == null)
		{
		$row4[3] = 0;
		}
		$tot4 =	$row4[0]+$row4[1]+$row4[2]+$row4[3];	


	
			
		echo "	<div>
			</div>
            <!-- /.row -->
			<div class=\"row\">
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE</span></div>
                                </div>
                            </div>
                        </div>
						
                                <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
					
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot2</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE OR</span></div>
                                </div>
                            </div>
                        </div>
					
                           <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE RECON</span></div>
                                </div>
                            </div>
                        </div>
					
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot4</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY LOCATION</span></div>
                                </div>
                            </div>
                        </div>
				
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T <= 7D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 1M : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
				


                
				
            </div>
            <!-- /.row -->";
			$k++;
	}
    echo"	<div class=\"row\">
		</br>
                <div class=\"col-lg-12\">
                    <img src=\"img/smartline.jpg\" >
                </div>
                <!-- /.col-lg-12 -->
            </div>";
	
	//FTTH
	$m=0;	
	while ($m < $n)
	{
		//CREATE
		$ser_type = 'FTTH';
		$or_type = 'CREATE';
		$so_count3 = so_count_can3($or_type,$temp[$m]);
		$row=oci_fetch_array($so_count3);
		if ($row[0] == null)
		{
		$row[0] = 0;
		}
		if ($row[1] == null)
		{
		$row[1] = 0;
		}
		if ($row[2] == null)
		{
		$row[2] = 0;
		}
		if ($row[3] == null)
		{
		$row[3] = 0;
		}
		$tot =	$row[0]+$row[1]+$row[2]+$row[3];
		
		//CREATE OR 
		$or_type = 'CREATE-OR';
		$so_count3 = so_count_can3($or_type,$temp[$m]);
		$row2=oci_fetch_array($so_count3);
		if ($row2[0] == null)
		{
		$row2[0] = 0;
		}
		if ($row2[1] == null)
		{
		$row2[1] = 0;
		}
		if ($row2[2] == null)
		{
		$row2[2] = 0;
		}
		if ($row2[3] == null)
		{
		$row2[3] = 0;
		}
		$tot2 =	$row2[0]+$row2[1]+$row2[2]+$row2[3];
		
		//MODIFY LOCATION
		$or_type = 'MODIFY-LOCATION';
		$so_count3 = so_count_can3($or_type,$temp[$m]);
		$row3=oci_fetch_array($so_count3);
		if ($row3[0] == null)
		{
		$row3[0] = 0;
		}
		if ($row3[1] == null)
		{
		$row3[1] = 0;
		}
		if ($row3[2] == null)
		{
		$row3[2] = 0;
		}
		if ($row3[3] == null)
		{
		$row3[3] = 0;
		}
		$tot3 =	$row3[0]+$row3[1]+$row3[2]+$row3[3];
		
		//CREATE-UPGRD SAME NO
		$or_type = 'CREATE-UPGRD SAME NO';
		$so_count = so_count_can3($or_type,$temp[$m]);
		$row4=oci_fetch_array($so_count);
		if ($row4[0] == null)
		{
		$row4[0] = 0;
		}
		if ($row4[1] == null)
		{
		$row4[1] = 0;
		}
		if ($row4[2] == null)
		{
		$row4[2] = 0;
		}
		if ($row4[3] == null)
		{
		$row4[3] = 0;
		}
		$tot4 =	$row4[0]+$row4[1]+$row4[2]+$row4[3];	

			
		echo "	<div>
			</div>
            <!-- /.row -->
			<div class=\"row\">
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE</span></div>
                                </div>
                            </div>
                        </div>
						
						
						<div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						
                        
                                                                               
                    </div>
					
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot2</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE OR</span></div>
                                </div>
                            </div>
                        </div>
					
                           <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY LOCATION</span></div>
                                </div>
                            </div>
                        </div>
					
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot4</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE-UPGRD SAME NO</span></div>
                                </div>
                            </div>
                        </div>
				
                           <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T <= 7D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
						  <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">7D < T <= 10D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>

							
							<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">10D < T <= 1M  : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>
							

						   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 1M  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[3]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                    </div>
                </div>
				


            </div>
            <!-- /.row -->";
			$m++;
	}
	
	
	
	?>
  </div>
</div>


<div id="loading-overlay">
    <div class="loading-icon"></div>
</div>

</body>
</html>