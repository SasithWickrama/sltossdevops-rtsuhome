<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION["user"];
}
else 
{     
    echo '<script type="text/javascript"> document.location = "Login.php";</script>'; 
}

include "../DBConnection.php";
$id=$_GET["id"];
$area=$_GET["area"];
$ortyp=$_GET["ortyp"];
$sertyp=$_GET["sertyp"];

?>


<html>
    <head>
    <meta charset="utf-8">
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
                    <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
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
							<li><a href="../SLT_Thr_Rate.php">Add Threshld Value</a></li>
							<li><a href="../SLT_CON_THR.php">Threshol Value Rates</a></li>
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
					
                    <h1 class=\"page-header\">Pending Service Orders</h1>
					<h6>RTOM: $area </h6>
					<h6>SERVICE TYPE: $sertyp</h6>
					<h6>ORDER TYPE: $ortyp</h6>
					<h5 align=\"right\"><a href=\"SLT_Manager_List2.php\">Back</a></h5>
                </div>
                <!-- /.col-lg-12 -->
            </div>";
			

   $empty_result_set = true;
   $i=1;
   
    if ($id == 'all')
    {

      $con_retd = so_all_pen($area,$sertyp,$ortyp);	

	echo" <div class=\"panel-body\">

		
                        <div class=\"table-responsive\">
                        <table style=\"font-size:11px;\" class=\"table table-striped table-bordered table-hover\">
                            <thead>
                            <tr style=\"font-weight:bold\">
								<th>#</th>
                                <th>Service Order NO</th>
								<th>Circuit NO</th>
								<th>Assigned Date</th>
								<th>Status</th>
								<th>Contractor</th>
                            </tr>
                            </thead>
                            <tbody>		
			";
        while ($row = oci_fetch_array($con_retd))
		{
			$empty_result_set = false;
		
		echo "<tr>
				<th>$i</th>
				<td><a target = '_blank' href=\"../SLT_SO_Details1.php?id=$row[0]\">$row[0]</a></td>
				<td>$row[1]</td>
				<td>$row[2]</td>
				<td>$row[3]</td>
				<td>$row[4]</td>";
	
		
		$i++;
		}
    
		echo "</table> ";
		
		if ($empty_result_set) {
    // No rows in the result set.
		echo "<script type='text/javascript'>alert('No Data Found')</script>";
        echo "<script type='text/javascript'>document.location = \"SLT_Manager_List2.php\";</script>";
		}	
		
		echo "</div>";
    }

    ?>    
        </div>
    </body>
</html>
