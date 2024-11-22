<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="icon" type="image/png" href="images/icons/favicon.ico"/> -->
	<link rel="stylesheet" type="text/css" href="style/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="style/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="style/css/util.css">
	<link rel="stylesheet" type="text/css" href="style/css/main.css">

	<script type='text/javascript'>

	function checkForm(frm) {

	if (frm.serviceId.value == "" ) {
	         alert("Service ID Required");
	         return false;     
	     }
		 if (frm.password.value == "" ) {
	         alert("Password Required");
	         return false;     
	     }

	}

	</script>	

</head>
<body>

	<div class="limiter">

	<!-- <div style="background-color:  #f2f4f4;"> -->
	<!-- <a href="../index.html" class="btn btn-primary" role="button" aria-pressed="true" style="float: right; margin-top: 10px; margin-right: 20px; "><i class="fa fa-home"></i>&nbsp;Home</a> -->
	<!-- </div>
 -->

		<div class="container-login100">
			<div class="wrap-login100">

				<form class="login100-form validate-form" method="post" action="auth.php" id="form1" onsubmit="return checkForm(this)">
					<span class="login100-form-title p-b-26">
						Login
					</span>
					

					<div class="wrap-input100 validate-input" data-validate="Enter Service ID">
						<input class="input100" type="text" id="serviceId" name="serviceId">
						<span class="focus-input100" data-placeholder="Service ID"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" id="password" name="password">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Login
							</button>
						</div>

						<div>
							<br><a href="incentive_final.php"><i class="fa fa-home"></i></style>&nbsp;Back to main</a>
						</div>

					</div>

					<div class="text-center p-t-115">
						
					</div>
				</form>

			</div>

		</div>

			<div class="container-heading" style="font-size:12px; margin-top: -60px; color:#000;text-align: center; ">

		<span >
				Copyright © 2019 IT Solutions & DevOps.
		</span>

	 </div>
	</div>

	<script src="style/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="style/vendor/animsition/js/animsition.min.js"></script>
	<script src="style/vendor/bootstrap/js/popper.js"></script>
	<script src="style/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="style/js/main.js"></script>

</body>
</html>