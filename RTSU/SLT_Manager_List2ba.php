<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION["user"];
	$area = $_SESSION["area"];
	$temp = explode('/',$area);
	$level =$_SESSION["level"];
	$n = sizeof($temp);
	
			if($level <> 9)
			{
				echo '<script type="text/javascript"> document.location = "SLT_User_List.php";</script>';
			 }
	
}
else 
{     
    echo '<script type="text/javascript"> document.location = "../Login.php";</script>'; 
}

$so_id = $_GET["id"];
include "../DBConnection.php";


		
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
	<meta http-equiv="refresh" content="60" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SLTCMS</title>

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

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">SLTCMS SLT PANEL</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Welcome ,<?php echo $user; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="../logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="SLT_Manager_List2.php">DASHBOARD</a>
                        </li>
                        <li>
                            <a href="#"></i> CONTRACTOR<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="../SLT_Contractor_List.php">Contractor List</a></li>
							<li><a href="../SLT_Contractor_Add.php">Add Contractor</a></li>
							<li><a href="../SLT_User_Add.php">Add User</a></li>
							<li><a href="../SLT_Unit_Rate.php">Unit Rates</a></li>
							<li><a href="../SLT_Thr_Rate.php">Add Threshold Value</a></li>
							<li><a href="../SLT_CON_THR.php">Threshold Value Rates</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
                        <li>
                            <a href="#"></i> SERVICE ORDERS<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="../SLT_CON_COM.php">Completed Service Orders</a></li>
								<li><a href="../SLT_CON_RET.php">Returned Service Orders</a></li>
								<li><a href="../SLT_CON_DLY.php">Delayed Service Orders</a></li>
								<li><a href="../SLT_CON_PEN.php">Pending Service Orders</a></li>
								<li><a href="../SLT_CON_WAIT.php">IPTV Confirmation</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
                        <li>
                            <a href="#"></i> INVOICES & MATERIAL<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="../SLT_MET_USG.php">Meterial Usage</a></li>
								<li><a href="../SLT_MET_SUB.php">Meterial Per Subscriber </a></li>
								<li><a href="../SLT_INV_VIEW.php">Invoices</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
                        <li>
                            <a href="#"></i>QUALITY ASSURANCE<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a href="../SLT_QUALITY.php">Sample Select</a></li>
                                <li><a href="../SLT_QUANTITY_CON.php">Quantity Confirm</a></li>
								<li><a href="../SLT_QUALITY_CON.php">Quality Confirm</a></li>
								<li><a href="../SLT_QUALITY_REP.php">Quality Assurence Reports</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
						<li>
							<a href="#"></i>APPOINTMENTS<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a href="../SLT_APPOINTTO.php">TODAY APPOINTMENTS</a></li>
								<li><a href="../SLT_APPOINTSER.php">SEARCH APPOINTMENTS</a></li>
								<li><a href="../SLT_APPOINTREPO.php">APPOINTMENTS REPORT</a></li>
                            </ul>
							
						</li>
                       <li>
							<a href="#"></i>QUERY CIRCUITS<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a href="../sltquerycircuits.php">Query Circuits</a></li>
                            </ul>
							
						</li>
                       
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>


		
	
<?php	
	echo"	 <div id=\"page-wrapper\">
	
	<div class=\"row\">
                <div class=\"col-lg-12\">
                    <h3 class=\"page-header\">Pending PSTN WO Summery</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>";
	$i=0;	
	while ($i < $n)
	{
		//CREATE
		$ser_type = 'PSTN';
		$or_type = 'CREATE';
		$so_count = so_count_pen($temp[$i],$ser_type,$or_type);
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
		$so_count = so_count_pen($temp[$i],$ser_type,$or_type);
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
		$so_count = so_count_pen($temp[$i],$ser_type,$or_type);
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
		$so_count = so_count_pen($temp[$i],$ser_type,$or_type);
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
			<h5><span style=\"font-weight: bold;\">RTOM AREA : $temp[$i]</span></h5>
			</div>
            <!-- /.row -->
			<div class=\"row\">
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"huge\"><span style=\"font-weight: bold;\">$tot</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE</span></div>
                                </div>
                            </div>
                        </div>
						
                        <a target = '_blank'  href=\"SLT_MGT_PEN.php?id=twodays&area=$temp[$i]&ortyp=CREATE&sertyp=PSTN\">
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=sixdays&area=$temp[$i]&ortyp=CREATE&sertyp=PSTN\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=moreseven&area=$temp[$i]&ortyp=CREATE&sertyp=PSTN\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=all&area=$temp[$i]&ortyp=CREATE&sertyp=PSTN\">
                            <div class=\"panel-footer\">
                                <span class=\"pull-left\">View All</span>
                                <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>

                    </div>
					
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"huge\"><span style=\"font-weight: bold;\">$tot2</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE OR</span></div>
                                </div>
                            </div>
                        </div>
					<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=twodays&area=$temp[$i]&ortyp=CREATE-OR&sertyp=PSTN\">
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=sixdays&area=$temp[$i]&ortyp=CREATE-OR&sertyp=PSTN\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=moreseven&area=$temp[$i]&ortyp=CREATE-OR&sertyp=PSTN\">";
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
                        <a target = '_blank'  href=\"SLT_MGT_PEN.php?id=all&area=$temp[$i]&ortyp=CREATE-OR&sertyp=PSTN\">
                            <div class=\"panel-footer\">
                                <span class=\"pull-left\">View All</span>
                                <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"huge\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE RECON</span></div>
                                </div>
                            </div>
                        </div>
					<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=twodays&area=$temp[$i]&ortyp=CREATE-RECON&sertyp=PSTN\">
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=sixdays&area=$temp[$i]&ortyp=CREATE-RECON&sertyp=PSTN\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=moreseven&area=$temp[$i]&ortyp=CREATE-RECON&sertyp=PSTN\">";
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
                        <a target = '_blank'  href=\"SLT_MGT_PEN.php?id=all&area=$temp[$i]&ortyp=CREATE-RECON&sertyp=PSTN\">
                            <div class=\"panel-footer\">
                                <span class=\"pull-left\">View All</span>
                                <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"huge\"><span style=\"font-weight: bold;\">$tot4</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY LOCATION</span></div>
                                </div>
                            </div>
                        </div>
					<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=twodays&area=$temp[$i]&ortyp=MODIFY-LOCATION&sertyp=PSTN\">
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=sixdays&area=$temp[$i]&ortyp=MODIFY-LOCATION&sertyp=PSTN\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=moreseven&area=$temp[$i]&ortyp=MODIFY-LOCATION&sertyp=PSTN\">";
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
                        <a target = '_blank'  href=\"SLT_MGT_PEN.php?id=all&area=$temp[$i]&ortyp=MODIFY-LOCATION&sertyp=PSTN\">
                            <div class=\"panel-footer\">
                                <span class=\"pull-left\">View All</span>
                                <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
            </div>
            <!-- /.row -->";
			$i++;
	}	
	echo"	<div class=\"row\">
                <div class=\"col-lg-12\">
                    <h3 class=\"page-header\">Pending IPTV WO Summery</h3>
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
		$so_count = so_count_pen($temp[$k],$ser_type,$or_type);
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
		$so_count = so_count_pen($temp[$k],$ser_type,$or_type);
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
		$so_count = so_count_pen($temp[$k],$ser_type,$or_type);
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
		$so_count = so_count_pen($temp[$k],$ser_type,$or_type);
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
                                    <div class=\"huge\"><span style=\"font-weight: bold;\">$tot</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE</span></div>
                                </div>
                            </div>
                        </div>
						
                        <a target = '_blank'  href=\"SLT_MGT_PEN.php?id=twodays&area=$temp[$k]&ortyp=CREATE&sertyp=IPTV\">
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=sixdays&area=$temp[$k]&ortyp=CREATE&sertyp=IPTV\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=moreseven&area=$temp[$k]&ortyp=CREATE&sertyp=IPTV\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=all&area=$temp[$k]&ortyp=CREATE&sertyp=IPTV\">
                            <div class=\"panel-footer\">
                                <span class=\"pull-left\">View All</span>
                                <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>

                    </div>
					
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"huge\"><span style=\"font-weight: bold;\">$tot2</span></div>
                                    <div><span style=\"font-weight: bold;\">CREATE OR</span></div>
                                </div>
                            </div>
                        </div>
					<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=twodays&area=$temp[$k]&ortyp=CREATE-OR&sertyp=IPTV\">
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row2[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=sixdays&area=$temp[$k]&ortyp=CREATE-OR&sertyp=IPTV\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=moreseven&area=$temp[$k]&ortyp=CREATE-OR&sertyp=IPTV\">";
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
                        <a target = '_blank'  href=\"SLT_MGT_PEN.php?id=all&area=$temp[$k]&ortyp=CREATE-OR&sertyp=IPTV\">
                            <div class=\"panel-footer\">
                                <span class=\"pull-left\">View All</span>
                                <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"huge\"><span style=\"font-weight: bold;\">$tot3</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY-SERVICE</span></div>
                                </div>
                            </div>
                        </div>
					<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=twodays&area=$temp[$k]&ortyp=MODIFY-SERVICE&sertyp=IPTV\">
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row3[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=sixdays&area=$temp[$k]&ortyp=MODIFY-SERVICE&sertyp=IPTV\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=moreseven&area=$temp[$k]&ortyp=MODIFY-SERVICE&sertyp=IPTV\">";
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
                        <a target = '_blank'  href=\"SLT_MGT_PEN.php?id=all&area=$temp[$k]&ortyp=MODIFY-SERVICE&sertyp=IPTV\">
                            <div class=\"panel-footer\">
                                <span class=\"pull-left\">View All</span>
                                <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class=\"col-lg-3 col-md-6\">
                    <div class=\"panel panel-primary\">
                        <div class=\"panel-heading\">
                            <div class=\"row\">
                                <div class=\"col-xs-9 text-right\">
                                    <div class=\"huge\"><span style=\"font-weight: bold;\">$tot4</span></div>
                                    <div><span style=\"font-weight: bold;\">MODIFY LOCATION</span></div>
                                </div>
                            </div>
                        </div>
					<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=twodays&area=$temp[$k]&ortyp=MODIFY-LOCATION&sertyp=IPTV\">
                            <div class=\"panel-footerGL\">
                                <span style=\"color:white;font-weight: bold;\">T < 3D   : </span>
								<span style=\"color:white;font-weight: bold; float: right\">$row4[0]</span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=sixdays&area=$temp[$k]&ortyp=MODIFY-LOCATION&sertyp=IPTV\">";
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
						<a target = '_blank'  href=\"SLT_MGT_PEN.php?id=moreseven&area=$temp[$k]&ortyp=MODIFY-LOCATION&sertyp=IPTV\">";
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
                        <a target = '_blank'  href=\"SLT_MGT_PEN.php?id=all&area=$temp[$k]&ortyp=MODIFY-LOCATION&sertyp=IPTV\">
                            <div class=\"panel-footer\">
                                <span class=\"pull-left\">View All</span>
                                <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                <div class=\"clearfix\"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
            </div>
            <!-- /.row -->";
			$k++;
	}
	?>		
            <!-- /.row -->
        </div>	
        <!-- /#page-wrapper -->
		

		
	
</div>
	

    <!-- /#wrapper -->

</body>

</html>
