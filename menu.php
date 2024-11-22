<?php
  session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    $user =$_SESSION['$UID'];
  }else{
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
	<!--CSS============================================= -->
	<!-- <link rel="stylesheet" href="css/linearicons.css"> -->
	<!-- <link rel="stylesheet" href="css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- <link rel="stylesheet" href="css/owl.carousel.css"> -->
	<!-- <link rel="stylesheet" href="css/magnific-popup.css"> -->
	<!-- <link rel="stylesheet" href="css/nice-select.css"> -->
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

  <!-- Start top-category-widget Area -->
  <section class="top-category-widget-area section-gap">
    <div class="d-flex flex-column h-100 min-vh-100 justify-content-center align-items-center" style="margin-top: 5%; margin-bottom: 5%;">
      <a class="btn btn-warning btn-lg" href="faultdb/dashboard.php" role="button">Pending Faults Details considering All WGs</a>
      <p></p>
      <a class="btn btn-warning btn-lg" href="faultdbRegional/dashboard.php" role="button">Pending Faults Details considering OPMC WGs only</a>
    </div>
  </section>
  <!-- End top-category-widget Area -->

  <?php include('footer.html') ?>

	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<!-- <script src="js/jquery.ajaxchimp.min.js"></script> -->
	<!-- <script src="js/parallax.min.js"></script> -->
	<!-- <script src="js/owl.carousel.min.js"></script> -->
	<!-- <script src="js/isotope.pkgd.min.js"></script> -->
	<!-- <script src="js/jquery.nice-select.min.js"></script> -->
	<!-- <script src="js/jquery.magnific-popup.min.js"></script> -->
	<!-- <script src="js/jquery.sticky.js"></script> -->
	<script src="js/main.js"></script>
</body>
</html>


