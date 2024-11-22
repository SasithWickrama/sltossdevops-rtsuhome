<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
 $user =$_SESSION['$UID'];
} 
else{
    echo "<script type='text/javascript'>location.href = 'login.html';</script>";
}
$rtom=$_SESSION['rtom'];
?>



<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="colorlib">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>RTSU Portal</title>

	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700|Roboto:400,500" rel="stylesheet">
	<!--
			CSS
			============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/nice-select.css"> 
	<link rel="stylesheet" href="css/main.css">


	<style type="text/css">

        /* unvisited link */
		a:link {
		  color:white;
		}

		/* visited link */
		a:visited {
		  color: white ;
		}
		/* selected link */
		a:active {
		  color: white ;
		} 

				a:hover {
		  color: #eb984e;
		}
	</style>

</head>
<body>

	<ul class="nav justify-content-end" style="background-color:#243050;">
		  <li class="nav-item">
			<a class="nav-link" href=""><b><?php echo $rtom ?></b></a>
		  </li>
		  <li class="nav-item">
		   <a  class="nav-link" href="Indexnew.php">Home</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="logout.php">Sign out</a>
		  </li>
		 
	</ul>

	<!-- <section class="banner-area relative"> -->
	<section class="relative">
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<!-- <div class="row justify-content-between align-items-center text-center banner-content">
				<div class="col-lg-12">
					<h1 class="text-white">RTSU</h1>
					<p>Home</p>
				</div>
			</div> -->
		</div>
	</section>




	<!-- Start top-category-widget Area -->
	<section class="top-category-widget-area section-gap">
		
		<div class="container">
			<div class="row justify-content-between align-items-center text-center banner-content">
				<div class="col-lg-12">
					<h1 class="text-black" style="color: #bb8fce;">SYSTEM HUB</h1>
					<p>RTSU</p>
				</div>
			</div>
		</div>
		<br>

		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="single-cat-widget">
						<div class="content relative" style="width: 300px;">
							<div class="overlay overlay-bg" style="opacity: 0.5;"></div>
							<a href="http://cc.slt.lk/adslusage/index.php" target="_blank">
								<div class="thumb">
									<img class="content-image img-fluid d-block mx-auto" src="img/usagecheck.jpg" alt="" style="height: 150px;">
								</div>
								<div class="content-details">
									<h4 class="content-title mx-auto text-uppercase">LDAP</h4>
									<!-- <span></span> -->
									<!-- <p>Enjoy your social life together</p> -->
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-cat-widget">
						<div class="content relative" style="width: 300px;">
							<div class="overlay overlay-bg" style="opacity: 0.5;"></div>
							<a href="http://172.25.16.59/index.php" target="_blank">
								<div class="thumb">
									<img class="content-image img-fluid d-block mx-auto" src="img/PeoOTT.jpg" alt="" style="height: 150px;">
								</div>
								<div class="content-details">
									<h4 class="content-title mx-auto text-uppercase">PEO TV Customer/<br>Device Management</h4>
									<!-- <span></span> -->
									<!-- <p>Let the food be finished</p> -->
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-cat-widget">
						<div class="content relative" style="width: 300px;">
							<div class="overlay overlay-bg" style="opacity: 0.6;"></div>
							<a href="http://172.25.17.220/imsportal/login.html" target="_blank">
								<div class="thumb">
									<img class="content-image img-fluid d-block mx-auto" src="img/ims.jpg" alt="" style="height: 150px;">
								</div>
								<div class="content-details">
									<h4 class="content-title mx-auto text-uppercase">IMS portal</h4>
									<!-- <span></span> -->
									<!-- <p>Be a part of politics</p> -->
								</div>
							</a>
						</div>
					</div>
				</div>	
			</div>
		</div>
		<br>


		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="single-cat-widget">
						<div class="content relative" style="width: 300px;">
							<div class="overlay overlay-bg" style="opacity: 0.6;"></div>
							<a href="http://acs.slt.com.lk/auth/login?url=%2F" target="_blank">
								<div class="thumb">
									<img class="content-image img-fluid d-block mx-auto" src="img/customer-care77.jpg" alt="" style="height: 150px;">
								</div>
								<div class="content-details">
									<h4 class="content-title mx-auto text-uppercase">ACS system</h4>
									<!-- <span></span> -->
									<!-- <p>Enjoy your social life together</p> -->
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-cat-widget">
						<div class="content relative" style="width: 300px;">
							<div class="overlay overlay-bg" style="opacity: 0.6;"></div>
							<a href="http://10.68.74.1/PCRFProvisioningInterface/login.nable" target="_blank">
								<div class="thumb">
									<img class="content-image img-fluid d-block mx-auto" src="img/pcrf.jpg" alt="" style="height: 150px;">
								</div>
								<div class="content-details">
									<h4 class="content-title mx-auto text-uppercase">PCRF</h4>
									<!-- <span></span> -->
									<!-- <p>Be a part of politics</p> -->
								</div>
							</a>
						</div>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="single-cat-widget">
						<div class="content relative" style="width: 300px;">
							<div class="overlay overlay-bg" style="opacity: 0.6;"></div>
							<a href="http://10.68.74.4:28080/AdminPortal/admin/home.xhtml?page=usage usage details" target="_blank">
								<div class="thumb">
									<img class="content-image img-fluid d-block mx-auto" src="img/analytics-data.jpg" alt="" style="height: 150px;">
								</div>
								<div class="content-details">
									<h4 class="content-title mx-auto text-uppercase">SLT VAS ADMIN PORTAL</h4>
									<!-- <span></span> -->
									<!-- <p>Be a part of politics</p> -->
								</div>
							</a>
						</div>
					</div>
				</div>	
			</div>
		</div>	
		<br>


		<!--<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="single-cat-widget">
						<div class="content relative" style="width: 300px;">
							<div class="overlay overlay-bg" style="opacity: 0.6;"></div>
							<a href="http://gui.slt.com.lk:9191/" target="_blank">
								<div class="thumb">
									<img class="content-image img-fluid d-block mx-auto" src="img/the-Password.jpg" alt="" style="height: 150px;">
								</div>
								<div class="content-details">
									<h4 class="content-title mx-auto text-uppercase">BROADBAND LDAP <br/> ADMIN GUI</h4>
									<!-- <span></span> -->
									<!-- <p>Enjoy your social life together</p> -->
								<!--</div>
							</a>
						</div>
					</div>
				</div>
		
			</div>
		</div>-->	


	</section>
	<!-- End top-category-widget Area -->


	<!-- start footer Area -->
	<?php include('footer.html') ?>
	<!--<footer class="footer-area section-gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>SERVICE FULFILLMENT</h4>
					<ul>
						<li><a href="RTSU/RTSU_List.php">Pending New Connection</a></li>
						<li><a href="NCfeedback/customer.html">Service Fulfillment Customer Satisfaction</a></li>
						<li><a href="http://172.25.36.252/SSD/Default.aspx">Project Monitoring</a></li>
						<li><a href="https://serviceportal.slt.lk">New Connection Contractor Management</a></li>
						<li><a href="ftthnewcon/ftthncon.html">Quality Inspection for FTTH New Connection</a></li>
					</ul>
				</div>
				<div class="col-lg-1 col-md-6 single-footer-widget">
					<h4>SERVICE ASSURANCE</h4>
					<ul>
						<li><a href="faultdb/main.php">Pending Fault Summary</a></li>
						<li><a href="feedback/customer.html">Service Assurence Customer Satisfaction</a></li>
					</ul>
				</div>
				
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>GPS BASED APPLICATIONS</h4>
					<ul>
						<li><a href="MSANVEHICLE/msanvehicle.php">MSAN Vehicle GPS</a></li>
						<li><a href="MSANVEHICLE/caevehicle.php">CEA Node Vehicle GPS</a></li>
						<li><a href="MSANVEHICLE/ltevehicle.php">LTE Basestation Vehicle GPS</a></li>
						<li><a href="DP/fiberdp.php">Fiber DP Distribution</a></li>
						<li><a href="DP/copperdp.php">Copper DP Distribution</a></li>
						<li><a href="DP/faultdp.php">Fault DP Distribution</a></li>
						<li><a href="eqmap/MSANMap.php">MSAN & DP Wise Fault Analysis</a></li>
					</ul>
				</div>
				<div class="col-lg-1 col-md-6 single-footer-widget">
					<h4>WFM & MATERIAL UPDATE</h4>
					<ul>
						<li><a href="http://172.25.37.227:8080/WFMADMIN">WFM Dashboard</a></li>
						<li><a href="http://hq-jupiter/CPETracker/Login.aspx?type=form">CPE Tracking</a></li>
						<li><a href="http://insite.slt.com.lk/sites/CBIO/isqm/MQFB/SitePages/MQFB%20Home.aspx">Meterial Quality Check</a></li>
						
					</ul>
				</div>

				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>SUPPORT</h4>
					<ul>
						
						<li><a href="http://hq-dev-athena.intranet.slt.com.lk/#/workbooks/49/views">SLT Meter Board</a></li>
						<li><a href="http://insite.slt.com.lk/sites/CC_Knowledge_Hub/EN/_layouts/15/start.aspx#/SitePages/Home.aspx">CC-Knowledge Hub</a></li>
						<li><a href="http://saturn/IntegratedBillingSystemInterface/login.aspx">Sales portal</a></li>
						<li><a href="http://hq-jupiter/IntegratedBillingSystemInterface/login.aspx">IBSI</a></li>
						<li><a href="http://172.25.37.251:8080/PlannedOutage/">Planned Power Outage</a></li>
						<li><a href="http://insite.slt.com.lk/sites/CRO/Data%20Cleansing/Forms/AllItems.aspx?RootFolder=%2Fsites%2FCRO%2FData%20Cleansing%2FData%20upload&FolderCTID=0x012000145821F9AF517444BAF0769A0A0AA8A8&View=%7B1D20E390%2DA121%2D40D8%2DA1C7%2D0FD3E2632FC9%7D">Incomplete CCT and GIS update</a></li>

					</ul>
				</div>

				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>OTHER</h4>
					<ul>
						<li><a href="Incentive/incentive_final.php">Incentive scheme</a></li>
						<li><a href="../QualityINS/login.html">Service Assurance Field <br>Team Quality Check</a></li>
						<li><a href="Faults/yfaults.html">Cleared Faults Callback<br>Verification</a></li>
						<li><a href="http://172.25.17.220/msanportcheck/listalluser.php">MSAN Ring Tester</a></li>
						<li><a href="http://172.25.36.245/CQMS/login.aspx">CQMS</a></li>
					</ul>
				</div>


				<div class="col-lg-2 col-md-6 single-footer-widget">
				<h4>RTSU-SYSTEM hub</h4>
					<ul>
						<li><a href="http://cc.slt.lk/adslusage/index.php">LDAP</a></li>
						<li><a href="http://172.25.16.59/index.php">PEO TV Customer/<br>Device Management</a></li>
						<li><a href="http://acs.slt.com.lk/auth/login?url=%2F">ACS system</a></li>
						<li><a href="http://10.68.74.1/PCRFProvisioningInterface/login.nable">PCRF</a></li>
						<li><a href="http://10.68.74.4:28080/AdminPortal/admin/home.xhtml?page=usage usage details">SLT VAS admin portal</a></li>
						<li><a href="http://gui.slt.com.lk:9191/">Broadband LDAP Admin GUI</a></li>
						<li><a href="http://172.25.17.220/imsportal/login.html">IMS portal</a></li>
					</ul>
				</div>

			</div>
			<div class="row footer-bottom d-flex justify-content-between">
				<p class="col-lg-8 col-sm-12 footer-text m-0 text-white">
					
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | IT Solution & DevOps &nbsp; by &nbsp;<a href="#">Sri Lanka Telecom (PLC)</a>

				</p>
		
			</div>
		</div>
	</footer>-->
	<!-- End footer Area -->

	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/parallax.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/isotope.pkgd.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/main.js"></script>
</body>

</html>


