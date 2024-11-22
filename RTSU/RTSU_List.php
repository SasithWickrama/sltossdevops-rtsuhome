<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION["user"];
	$area = $_SESSION['rtom'];
	$temp = explode('/',$area);
	$level =$_SESSION["level"];
	$n = sizeof($temp);
	
	echo $_SESSION["area"];
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
            from PENDING_NC a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <3),
            (select count(distinct soid) 
            from PENDING_NC b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 3 and 5) ,
            (select count(distinct soid) 
            from PENDING_NC c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE > 5 ) 
            from PENDING_NC x
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
            from PENDING_NCIPTV a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <3),
            (select count(distinct soid) 
            from PENDING_NCIPTV b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 3 and 5) ,
            (select count(distinct soid) 
            from PENDING_NCIPTV c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE > 5 ) 
            from PENDING_NCIPTV x
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
            from PENDING_NCFTTH a
            where  ORTYP = '$or_type'  and  a.AREA = x.AREA and TIMEDUE <3),
            (select count(distinct soid) 
            from PENDING_NCFTTH b
            where  ORTYP = '$or_type'  and  b.AREA = x.AREA and TIMEDUE between 3 and 5) ,
            (select count(distinct soid) 
            from PENDING_NCFTTH c
            where  ORTYP = '$or_type'  and   c.AREA = x.AREA and TIMEDUE > 5 ) 
            from PENDING_NCFTTH x
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

		
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
	<meta http-equiv="refresh" content="3000" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RTSU</title>

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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>


    <div id="wrapper">

	
<?php	
	echo"	 <div id=\"page-wrapper\">
	
	<div class=\"row\">
                <div class=\"col-lg-12\">
                    <h1 style=\"text-align:center\" class=\"page-header\">Pending New Connection Summary RTOM : $area</h1>
					<img src=\"img/MegaLine.jpg\" >
                </div>
                <!-- /.col-lg-12 -->
            </div>";
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
		$tot =	$row[0]+$row[1]+$row[2];
		
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
		$tot2 =	$row2[0]+$row2[1]+$row2[2];
		
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
		$tot3 =	$row3[0]+$row3[1]+$row3[2];
		
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
		$tot4 =	$row4[0]+$row4[1]+$row4[2];			
			
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
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						";
						if($row[1] =='0')
						{
                         echo"   <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
						else
						{
						 echo"   <div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
                       echo" </a>
						";
						if($row[2] =='0')
						{
                        echo"    <div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
						else
						{
						echo"    <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						
						}
                        echo"</a>
						

                        </a>

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
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						";
						if($row2[1] =='0')
						{
                            echo"<div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
						else
						{
						echo"<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
                        echo"</a>
						";
						if($row2[2] == '0')
						{
                         echo"   <div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}	
						else
						{
						echo"   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
                        echo"</a>
                        

                        </a>
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
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
					";
						if($row3[1] =='0')
						{
                         echo"   <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							echo"   <div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                        echo"</a>
						";
						if($row3[2] == '0')
						{
                            echo"<div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							echo"<div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                       echo" </a>
                        

                        </a>
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
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
					";
						if($row4[1]=='0')
						{
                            echo"<div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							 echo"<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                       echo" </a>
						";
						if($row4[2]=='0')
						{
                         echo"   <div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							echo"   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                        echo"</a>
                        
     
                        </a>
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
		$tot =	$row[0]+$row[1]+$row[2];
		
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
		$tot2 =	$row2[0]+$row2[1]+$row2[2];
		
		//MODIFY-SERVICE
		$or_type = 'MODIFY-SERVICE';
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
		$tot3 =	$row3[0]+$row3[1]+$row3[2];
		
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
		$tot4 =	$row4[0]+$row4[1]+$row4[2];			
			
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
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						";
						if($row[1] =='0')
						{
                         echo"   <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
						else
						{
						 echo"   <div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
                       echo" </a>
						";
						if($row[2] =='0')
						{
                        echo"    <div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
						else
						{
						echo"    <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						
						}
                        echo"</a>
						

                        </a>

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
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						";
						if($row2[1] =='0')
						{
                            echo"<div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
						else
						{
						echo"<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
                        echo"</a>
						";
						if($row2[2] == '0')
						{
                         echo"   <div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}	
						else
						{
						echo"   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
                        echo"</a>
                       

                        </a>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY-SERVICE</span></div>
                                </div>
                            </div>
                        </div>
					
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						";
						if($row3[1] =='0')
						{
                         echo"   <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							echo"   <div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                        echo"</a>
						";
						if($row3[2] == '0')
						{
                            echo"<div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							echo"<div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                       echo" </a>

                        </a>
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
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						";
						if($row4[1]=='0')
						{
                            echo"<div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							 echo"<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                       echo" </a>
						";
						if($row4[2]=='0')
						{
                         echo"   <div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							echo"   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                        echo"</a>
                        

                        </a>
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
	
	//IPTV
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
		$tot =	$row[0]+$row[1]+$row[2];
		
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
		$tot2 =	$row2[0]+$row2[1]+$row2[2];
		
		//MODIFY-SERVICE
		$or_type = 'CREATE-UPGRD SAME NO';
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
		$tot3 =	$row3[0]+$row3[1]+$row3[2];
		
		//MODIFY LOCATION 
		$or_type = 'CREATE-UPGRD DIF NO';
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
		$tot4 =	$row4[0]+$row4[1]+$row4[2];			
			
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
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						";
						if($row[1] =='0')
						{
                         echo"   <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
						else
						{
						 echo"   <div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
                       echo" </a>
						";
						if($row[2] =='0')
						{
                        echo"    <div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
						else
						{
						echo"    <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						
						}
                        echo"</a>
						

                        </a>

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
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						";
						if($row2[1] =='0')
						{
                            echo"<div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
						else
						{
						echo"<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
                        echo"</a>
						";
						if($row2[2] == '0')
						{
                         echo"   <div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}	
						else
						{
						echo"   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
						}
                        echo"</a>

                        </a>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE-UPGRD SAME NO</span></div>
                                </div>
                            </div>
                        </div>
					
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						";
						if($row3[1] =='0')
						{
                         echo"   <div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							echo"   <div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                        echo"</a>
						";
						if($row3[2] == '0')
						{
                            echo"<div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							echo"<div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                       echo" </a>

                        </a>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"Large\"><span style=\"font-weight: bold;\">$tot4</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE-UPGRD DIF NO</span></div>
                                </div>
                            </div>
                        </div>
					
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
					";
						if($row4[1]=='0')
						{
                            echo"<div class=\"panel-footerGM\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							 echo"<div class=\"panel-footerY\">
                                <span style=\"color:white;font-weight: bold;\">3D < T < 5D  :</span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[1]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                       echo" </a>
					";
						if($row4[2]=='0')
						{
                         echo"   <div class=\"panel-footerGD\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
							else
							{
							echo"   <div class=\"panel-footerR\">
                                <span style=\"color:white;font-weight: bold;\">T > 5D : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[2]</span>
                                <div class=\"clearfix\"></div>
                            </div>";
							}
                        echo"</a>

                        </a>
                    </div>
                </div>
				
            </div>
            <!-- /.row -->";
			$m++;
	}
    	?>		
            <!-- /.row -->
        </div>	
        <!-- /#page-wrapper -->
		

		
	
</div>
	

    <!-- /#wrapper -->

</body>

</html>
