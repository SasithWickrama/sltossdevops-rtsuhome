<?php

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
    $user = $_SESSION['$UID'];
	//$opmc = $_SESSION['$rtom'];
	$rtom=$_SESSION['rtom'];
	
	if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null   ){	
	echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
	}
}
else 
{     
    echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
}


?>

<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- Initializations -->
<script type="text/javascript">
// Animations initialization
new WOW().init();

</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.material.min.css">

<link href="https://fonts.googleapis.com/css?family=ZCOOL+XiaoWei&display=swap" rel="stylesheet">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

    
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>DevOPS Dashboard</title>
<link rel="shortcut icon" href="img/0028_CMO_IconLB_Reports-Dashboard_RGB.png">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="css/mdb.min.css" rel="stylesheet">
<!-- Your custom styles (optional) -->
<link href="css/style.min.css" rel="stylesheet">

  <!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<style type="text/css">
  
.nav-tabs { border-bottom: 2px solid #DDD; }
.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover { border-width: 0; }
.nav-tabs > li > a { border: none; color: #000000;background: #ffffff; }
.nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none;  color: #5a4080 !important; background: #5a4080; }
.nav-tabs > li > a::after { content: ""; background: #5a4080; height: 2px; position: absolute; width: 100%; left: 0px; bottom: -1px; transition: all 250ms ease 0s; transform: scale(0); }
.nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }
.tab-nav > li > a::after { background: ##5a4080 none repeat scroll 0% 0%; color: #fff; }
.tab-pane { padding: 15px 0; }
.tab-content{padding:20px}
.nav-tabs > li  {width:25%; text-align:center;}
.card {background: #FFF none repeat scroll 0% 0%; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); margin-bottom: 30px; }
body{ background: #EDECEC; padding:5px}

@media all and (max-width:724px){
.nav-tabs > li > a > span {display:none;} 
.nav-tabs > li > a {padding: 5px 5px;}
}

</style>

</head>

<body>

<!--Main Navigation-->
<header>

  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container-fluid">

      <!-- Brand -->
      <a class="navbar-brand waves-effect" style="margin-left:45%">
        <strong class="blue-text" >Dashboard | SLT Fault</strong>      
      </a>
	  
	  <a style="font-size:15px;"><?php echo $rtom; ?></a>

    </div>
  </nav>
  <!-- Navbar -->

</header>

<main class="pt-5 mx-lg-12">

  <div class="container-fluid mt-5">

    <div class="row wow fadeIn">

      <!-- Nav tabs -->
      <div class="card">
       
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pending Faults</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Repeated Faults</a>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">

        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">

        <div class="row wow fadeIn">

        <!--Grid column-->
       <div class="col-md-4 mb-4">

        <!--Card-->
        <div class="card">

        <div class="card-header text-center">
              MEGALINE <br/> (VOICE)
        </div>

        <!--Card content-->
        <div class="card-body">

        <div id="megaline">

        <table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
		  <tr >
            <td align="center"></td>
           <td align="center"><h6>Total</h6></td>
		   <td align="center"><h6>P1</h6></td>
          </tr>

        <tr >
            <td align="center"><h6>0Hrs &lt; 4Hrs  </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="val0v"><h6 id="val0" >0 </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="p0v"><h6 id="p0" >0 </h6></td>
        </tr>
		  
        <tr >
            <td align="center"><h6>4Hrs &lt; 20Hrs  </h6></td>
            <td bgcolor="#7ec77e" align="center" width="90px" id="val1v"><h6 id="val1" >0 </h6></td>
			      <td bgcolor="#7ec77e" align="center" width="90px" id="p1v"><h6 id="p1" >0 </h6></td>
        </tr>
		  
		    <tr >
            <td align="center"><h6>20Hrs &lt; 24Hrs</h6></td>
            <td bgcolor="#29a329" align="center" width="90px" id="val2v"><h6 id="val2" >0 </h6></td>
			      <td bgcolor="#29a329" align="center" width="90px" id="p2v"><h6 id="p2" >0 </h6></td>
        </tr>
          
        <tr>
            <td align="center"><h6> 1Day &lt; 3Day</h6></td>
            <td bgcolor="#ffa31a" align="center"; width="90px" id="val3v" class="a"><h6 id="val3" >0 </h6></td>
			      <td bgcolor="#ffa31a" align="center"; width="90px" id="p3v" class="a"><h6 id="p3" >0 </h6></td>
        </tr>
          
        <tr>
            <td align="center"><h6>&gt; 3Day</h6></td>
            <td bgcolor="#C0392B" align="center" width="90px" id="val4v" class="b"><h6  id="val4" style="color:#FFF">0 </h6></td>
			      <td bgcolor="#C0392B" align="center" width="90px" id="p4v" class="b"><h6  id="p4" style="color:#FFF">0 </h6></td>
        </tr>

        </table>
        
        </div>

        </div>

        </div>
        <!--/.Card-->

       </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-4 mb-4">
          <!--Card-->
          <div class="card">
            <!-- Card header -->
            <div class="card-header text-center">
              BROADBAND <br/> (COPPER BB)
            </div>
            <!--Card content-->
            <div class="card-body">
              <div id="BB">
          
          <table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
		  <tr >
            <td align="center"></td>
           <td align="center"><h6>Total</h6></td>
		   <td align="center"><h6>P1</h6></td>
          </tr>
        
        <tr >
            <td align="center"><h6>0Hrs&lt; 4Hrs </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="val5v"><h6 id="val5" >0 </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="p5v"><h6 id="p5" >0 </h6></td>
        </tr>

        <tr >
            <td align="center"><h6>4Hrs&lt; 20Hrs </h6></td>
            <td bgcolor="#7ec77e" align="center" width="90px" id="val6v"><h6 id="val6" >0 </h6></td>
			      <td bgcolor="#7ec77e" align="center" width="90px" id="p6v"><h6 id="p6" >0 </h6></td>
        </tr>
		  
		    <tr >
            <td align="center"><h6>20Hrs &lt; 24Hrs</h6></td>
            <td bgcolor="#29a329" align="center" width="90px" id="val7v"><h6 id="val7" >0 </h6></td>
			      <td bgcolor="#29a329" align="center" width="90px" id="p7v"><h6 id="p7" >0 </h6></td>
        </tr>
          
        <tr>
            <td align="center"><h6> 1Day &lt; 3Day</h6></td>
            <td bgcolor="#ffa31a" align="center"; width="90px" id="val8v" class="a"><h6 id="val8" >0 </h6></td>
			      <td bgcolor="#ffa31a" align="center"; width="90px" id="p8v" class="a"><h6 id="p8" >0 </h6></td>
        </tr>
          
        <tr>
            <td align="center"><h6>&gt; 3Day</h6></td>
            <td bgcolor="#C0392B" align="center" width="90px" id="val9v" class="b"><h6  id="val9" style="color:#FFF">0 </h6></td>
			      <td bgcolor="#C0392B" align="center" width="90px" id="p9v" class="b"><h6  id="p9" style="color:#FFF">0 </h6></td>
        </tr>
        </table></div>
            </div>
          </div>
          <!--/.Card-->
		</div>
        <!--Grid column-->
    
        <!--Grid column-->
      <div class="col-md-4 mb-4">
          <!--Card-->
          <div class="card mb-4">
            <!-- Card header -->
            <div class="card-header text-center">
              PEOTV <br/> (COPPER IPTV) 
            </div>
            <!--Card content-->
            <div class="card-body">
              <div id="IPTV">
			  
			  <table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
			  
			  <tr >
           <td align="center"></td>
           <td align="center"><h6>Total</h6></td>
		       <td align="center"><h6>P1</h6></td>
          </tr>
		  
        <tr >
            <td align="center"><h6>0Hrs&lt; 4Hrs </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="val10v"><h6 id="val10" >0 </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="p10v"><h6 id="p10" >0 </h6></td>
        </tr>

        <tr >
            <td align="center"><h6>4Hrs&lt; 20Hrs </h6></td>
            <td bgcolor="#7ec77e" align="center" width="90px" id="val11v"><h6 id="val11" >0 </h6></td>
			      <td bgcolor="#7ec77e" align="center" width="90px" id="p11v"><h6 id="p11" >0 </h6></td>
        </tr>
		  
		    <tr >
            <td align="center"><h6>20Hrs &lt; 24Hrs</h6></td>
            <td bgcolor="#29a329" align="center" width="90px" id="val12v"><h6 id="val12" >0 </h6></td>
			      <td bgcolor="#29a329" align="center" width="90px" id="p12v"><h6 id="p12" >0 </h6></td>
        </tr>
          
        <tr>
            <td align="center"><h6> 1Day &lt; 3Day</h6></td>
            <td bgcolor="#ffa31a" align="center"; width="90px" id="val13v" class="a"><h6 id="val13" >0 </h6></td>
			      <td bgcolor="#ffa31a" align="center"; width="90px" id="p13v" class="a"><h6 id="p13" >0 </h6></td>
        </tr>
          
        <tr>
            <td align="center"><h6>&gt; 3Day</h6></td>
            <td bgcolor="#C0392B" align="center" width="90px" id="val14v" class="b"><h6  id="val14" style="color:#FFF">0 </h6></td>
			      <td bgcolor="#C0392B" align="center" width="90px" id="p14v" class="b"><h6  id="p14" style="color:#FFF">0 </h6></td>
        </tr>

        </table></div>
            </div>
          </div>
          <!--/.Card-->
        </div>
        <!--Grid column-->
		
		</div>
		<!------- end row--->
		
		<!-- start row------>
	   <div class="row wow fadeIn">
    
        <!--Grid column-->
        <div class="col-md-4 mb-4">
          <!--Card-->
          <div class="card mb-4">
            <!-- Card header -->
            <div class="card-header text-center">
              LTE <br/> (VOICE,BB)
            </div>
            <!--Card content-->
            <div class="card-body">
              <div id="LTE"><table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
			  
			  <tr >
            <td align="center"></td>
           <td align="center"><h6>Total</h6></td>
		   <td align="center"><h6>P1</h6></td>
          </tr>


        <tr >
            <td align="center"><h6>0Hrs&lt;4Hrs </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="val15v"><h6 id="val15" >0 </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="p15v"><h6 id="p15" >0 </h6></td>
        </tr>
		  
        <tr >
            <td align="center"><h6>4Hrs&lt; 20Hrs </h6></td>
            <td bgcolor="#7ec77e" align="center" width="90px" id="val16v"><h6 id="val16" >0 </h6></td>
			      <td bgcolor="#7ec77e" align="center" width="90px" id="p16v"><h6 id="p16" >0 </h6></td>
        </tr>
		  
		    <tr >
            <td align="center"><h6>20Hrs &lt; 24Hrs</h6></td>
            <td bgcolor="#29a329" align="center" width="90px" id="val17v"><h6 id="val17" >0 </h6></td>
			      <td bgcolor="#29a329" align="center" width="90px" id="p17v"><h6 id="p17" >0 </h6></td>
        </tr>
          
        <tr>
            <td align="center"><h6> 1Day &lt; 3Day</h6></td>
            <td bgcolor="#ffa31a" align="center"; width="90px" id="val18v" class="a"><h6 id="val18" >0 </h6></td>
			      <td bgcolor="#ffa31a" align="center"; width="90px" id="p18v" class="a"><h6 id="p18" >0 </h6></td>
        </tr>
          
        <tr>
            <td align="center"><h6>&gt; 3Day</h6></td>
            <td bgcolor="#C0392B" align="center" width="90px" id="val19v" class="b"><h6  id="val19" style="color:#FFF">0 </h6></td>
			      <td bgcolor="#C0392B" align="center" width="90px" id="p19v" class="b"><h6  id="p19" style="color:#FFF">0 </h6></td>
        </tr>
        </table></div>
            </div>
          </div>
          <!--/.Card-->
        </div>
        <!--Grid column-->
    
        <div class="col-md-4 mb-4">
          <!--Card-->
          <div class="card mb-2">
            <!-- Card header -->
            <div class="card-header text-center">
              FTTH <br/> (VOICE,BB,IPTV)
            </div>
            <!--Card content-->
            <div class="card-body">
              <div id="FTTH"><table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
			  
			    <tr >
           <td align="center"></td>
           <td align="center"><h6>Total</h6></td>
		       <td align="center"><h6>P1</h6></td>
          </tr>
		  
          <tr >
            <td align="center"><h6>0Hrs&lt; 4Hrs </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="val20v"><h6 id="val20" >0 </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="p20v"><h6 id="p20" >0 </h6></td>
          </tr>

          <tr >
            <td align="center"><h6>4Hrs&lt; 20Hrs </h6></td>
            <td bgcolor="#7ec77e" align="center" width="90px" id="val21v"><h6 id="val21" >0 </h6></td>
			      <td bgcolor="#7ec77e" align="center" width="90px" id="p21v"><h6 id="p21" >0 </h6></td>
          </tr>
		  
		      <tr >
            <td align="center"><h6>20Hrs &lt; 24Hrs</h6></td>
            <td bgcolor="#29a329" align="center" width="90px" id="val22v"><h6 id="val22" >0 </h6></td>
			      <td bgcolor="#29a329" align="center" width="90px" id="p22v"><h6 id="p22" >0 </h6></td>
          </tr>
          
          <tr>
            <td align="center"><h6> 1Day &lt; 3Day</h6></td>
            <td bgcolor="#ffa31a" align="center"; width="90px" id="val23v" class="a"><h6 id="val23" >0 </h6></td>
			      <td bgcolor="#ffa31a" align="center"; width="90px" id="p23v" class="a"><h6 id="p23" >0 </h6></td>
          </tr>
          
          <tr>
            <td align="center"><h6>&gt; 3Day</h6></td>
            <td bgcolor="#C0392B" align="center" width="90px" id="val24v" class="b"><h6  id="val24" style="color:#FFF">0 </h6></td>
			      <td bgcolor="#C0392B" align="center" width="90px" id="p24v" class="b"><h6  id="p24" style="color:#FFF">0 </h6></td>
          </tr>
        </table></div>
            </div>
          </div>
          <!--/.Card-->
        </div>
        <!--Grid column-->
    
        <div class="col-md-4 mb-4">
          <!--Card-->
          <div class="card mb-2">
            <!-- Card header -->
            <div class="card-header text-center">
              DATA <br/><br/>
            </div>
            <!--Card content-->
            <div class="card-body">
              <div id="DATA"><table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
			  
			  <tr >
           <td align="center"></td>
           <td align="center"><h6>Total</h6></td>
		       <td align="center"><h6>P1</h6></td>
          </tr>
		  
		      <tr >
            <td align="center"><h6>0Hrs&lt; 4Hrs </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="val25v"><h6 id="val25" >0 </h6></td>
            <td bgcolor="#a2d6a2" align="center" width="90px" id="p25v"><h6 id="p25" >0 </h6></td>
          </tr>

          <tr >
            <td align="center"><h6>4Hrs&lt; 20Hrs </h6></td>
            <td bgcolor="#7ec77e" align="center" width="90px" id="val26v"><h6 id="val26" >0 </h6></td>
			      <td bgcolor="#7ec77e" align="center" width="90px" id="p26v"><h6 id="p26" >0 </h6></td>
          </tr>
		  
		      <tr >
            <td align="center"><h6>20Hrs &lt; 24Hrs</h6></td>
            <td bgcolor="#29a329" align="center" width="90px" id="val27v"><h6 id="val27" >0 </h6></td>
			      <td bgcolor="#29a329" align="center" width="90px" id="p27v"><h6 id="p27" >0 </h6></td>
          </tr>
          
          <tr>
            <td align="center"><h6> 1Day &lt; 3Day</h6></td>
            <td bgcolor="#ffa31a" align="center"; width="90px" id="val28v" class="a"><h6 id="val28" >0 </h6></td>
			      <td bgcolor="#ffa31a" align="center"; width="90px" id="p28v" class="a"><h6 id="p28" >0 </h6></td>
          </tr>
          
          <tr>
            <td align="center"><h6>&gt; 3Day</h6></td>
            <td bgcolor="#C0392B" align="center" width="90px" id="val29v" class="b"><h6  id="val29" style="color:#FFF">0 </h6></td>
			      <td bgcolor="#C0392B" align="center" width="90px" id="p29v" class="b"><h6  id="p29" style="color:#FFF">0 </h6></td>
          </tr>
          </table></div>
            </div>
          </div>

        <!--/.Card-->
        </div>

        <!--Grid column-->
        </div>
		
		<form name="csvdownload" method="post" action="functioncsv.php">

		<div style="text-align: right; margin-bottom: 20px;"><button type="Submit" name="submitData" id="submitData" class="btn btn-primary btn-sm">Download full report</button></div>
		
		</form>
		
		       <!--Grid row-->
          <div class="row wow fadeIn">

            <!--Grid column-->
            <div class="col-md-12 mb-4">
              <!--Card-->
              <div class="card" >
              <div class="card-header text-center">
                  Time wise Pending Faults
                </div>
                <!--Card content-->
                <div class="card-body"style="height: 400px">
                  <canvas id="pendingflts" ></canvas>
                </div>
              </div>
              <!--/.Card-->

            </div>
            <!--Grid column-->

        </div>


           <!--Grid row-->
      <div class="row wow fadeIn">

        <!--Grid column-->
        <div class="col-md-6 mb-4">
          <!--Card-->
          <div class="card">
      <div class="card-header text-center">
              Reported Faults
            </div>
            <!--Card content-->
            <div class="card-body">
              <canvas id="repfaults"></canvas>
            </div>
          </div>
          <!--/.Card-->

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-6 mb-4">
          <!--Card-->
          <div class="card mb-4">
            <!-- Card header -->
            <div class="card-header text-center">
              Cleared Faults
            </div>
            <!--Card content-->
            <div class="card-body">
              <canvas id="clerdfaults"></canvas>
            </div>
          </div>
          <!--/.Card-->
        </div>
        <!--Grid column-->

      </div>
	  
	  
	<div class="row wow fadeIn">

      <!--Grid column-->
      <div class="col-md-12 mb-4">
          <!--Card-->
      <div class="card">
          
      <div class="card-header text-center">
          LEA level - Faults Counts
      </div>

      <!--Card content-->
      
      <div class="card-body" >
        <div class="row">
        <div class="col-md-12 mb-4">
            <div id="faultnew" style="height:400px;overflow:auto"></div>
        </div>
    <!--       
        <div class="col-md-4 mb-4">
        <h3 id="numberx"></h3>
              <canvas id="fltdetails"></canvas>
        </div> -->
        </div>
		<div style="text-align: right;"><a href="#" onclick="exportToExcel2()" type="button" class="btn btn-primary btn-sm">Download report</a></div>
      </div>

      </div>
      <!--/.Card-->

      </div>
      <!--Grid column-->

      </div>
	  
	  
	  

        </div>

        <!-- end first tab ---->


     <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          

      <!--Grid row-->
      <div class="row wow fadeIn">

        <!--Grid column-->
        <div class="col-md-4 mb-4">

          <!--Card-->
          <div class="card">

            <div class="card-header text-center">
              Repeated Fault Summary Megaline
            </div>

            <!--Card content-->
            <div class="card-body">

              <canvas id="cuflt"></canvas>

            </div>

          </div>
          <!--/.Card-->

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-4 mb-4">

          <!--Card-->
          <div class="card mb-4">

            <!-- Card header -->
            <div class="card-header text-center">
             Repeated Fault Summary FTTH
            </div>

            <!--Card content-->
            <div class="card-body">

              <canvas id="ftthflt"></canvas>

            </div>

          </div>
          <!--/.Card-->
        </div>
        <!--Grid column-->
    
        <!--Grid column-->
        <div class="col-md-4 mb-4">

          <!--Card-->
          <div class="card mb-4">

            <!-- Card header -->
            <div class="card-header text-center">
              Repeated Fault Summary LTE
            </div>

            <!--Card content-->
            <div class="card-body">

              <canvas id="lteflt"></canvas>

            </div>

          </div>
          <!--/.Card-->
        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->


       <!--Grid row-->
      <div class="row wow fadeIn">

      <!--Grid column-->
      <div class="col-md-12 mb-4">
          <!--Card-->
      <div class="card">
          
      <div class="card-header text-center">
          Repeated Fault Details for Pending Faults
      </div>

      <!--Card content-->
      
      <div class="card-body" >
        <div class="row">
        <div class="col-md-8 mb-4">
            <div id="repetedfaults" style="height:400px;overflow:auto"></div>
        </div>
          
        <div class="col-md-4 mb-4">
        <h3 id="numberx"></h3>
              <canvas id="fltdetails"></canvas>
        </div>
        </div>
      </div>

      </div>
      <!--/.Card-->

      </div>
      <!--Grid column-->

      </div>




       <!--Grid row-->
      <div class="row wow fadeIn">

      <!--Grid column-->
      <div class="col-md-12 mb-4">
          <!--Card-->
      <div class="card">
          
      <div class="card-header text-center">
          Repeated Fault Details for Closed Fault within past 24 hours
      </div>

      <!--Card content-->
      
      <div class="card-body" >
        <div class="row">
        <div class="col-md-8 mb-4">
            <div id="repetedfaults2" style="height:400px;overflow:auto"></div>
        </div>
          
        <div class="col-md-4 mb-4">
        <h3 id="numberx2"></h3>
              <canvas id="fltdetails2"></canvas>
        </div>
        </div>
      </div>

      </div>
      <!--/.Card-->

      </div>
      <!--Grid column-->

      </div>

      </div>


      </div>

      </div>

    </div>
	
	
	<div class="modal" id="mymodel" style="height:500px; max-width: 700px !important; overflow:auto;">
      <div class="modal-header">
        <h5 class="modal-heading" align="center"></h5>
      </div>
      
      <div class="modal-body" align="right">
        <div class="modal-content" style="width:630px;">
		<div class="modal-pno" align="center">
		</div>
		
        </div>
      </div>
	  <a href="#" rel="modal:close">Close</a><br/><br/>
	   <a href="#" onclick="exportToExcel()">Export</a>
  </div>
  
  

  </div>

</main>

<!--Footer-->
<footer class="page-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn">

  <hr class="my-4">

  <div class="footer-copyright py-3">© 2020 Copyright: OSS DevOPS</div>

</footer>
<!--/.Footer-->


 <!-- Charts -->
<script>

window.onload = function(){

    loadMainChrtdata();

    loadlineChrtData();

}

window.myPieChart1;
window.myPieChart2;
window.myPieChart3;
window.myPieChart4;
window.myPieChart5;
window.myLineChart;

window.chartColors = {
red: 'rgb(255, 99, 132)',
orange: 'rgb(255, 159, 64)',
yellow: 'rgb(255, 205, 86)',
green: 'rgb(75, 192, 192)',
blue: 'rgb(54, 162, 235)',
purple: 'rgb(153, 102, 255)',
grey: 'rgb(201, 203, 207)'
};


var d = new Date(); 
d.getHours(); 
d.getMinutes(); 
d.getSeconds(); 


setInterval(function(){ 

  loadMainChrtdata();

  if(d.getMinutes() < 11){

     loadlineChrtData();

  }
 

}, 600000);


function loadMainChrtdata(){


$.ajax({
   type: "POST",
   url: "./api.php?apicall=pendingbox1",
   success: function(res){
	if(res != ''){
		console.log(res);
		var elements = document.getElementsByClassName('a');
		for (var i = 0; i < elements.length; i++) {
			
			elements[i].bgColor="#ffa31a";
		}
		
		 var elements = document.getElementsByClassName('b');
		for (var i = 0; i < elements.length; i++) {
			
			elements[i].bgColor="#C0392B";
			<!--elements[i].bgColor="#e74c3c";-->
	
		}
		
		
				for(var i =0; i<30;i++){
					
				   document.getElementById("val"+i).innerHTML = res["reply"][0][i];
				   if(res["reply"][0][i] == '0'){
					   document.getElementById("val"+i+"v").bgColor = '#29a329';
				   }
					
          //if(res["reply"][0][i] > 0){

						document.getElementById("val"+i+"v").setAttribute("onclick","showprobno("+i+")");
						
						//"event.preventDefault();  $('.modal').toggleClass('is-visible');");
					 
				   //}
			   }
		
	}	
   }
});


//priority 0

$.ajax({
   type: "POST",
   url: "./api.php?apicall=pendingboxpri",
   success: function(res){
	if(res != ''){
		console.log(res);
		var elements = document.getElementsByClassName('a');
		for (var i = 0; i < elements.length; i++) {
			
			elements[i].bgColor="#ffa31a";
		}
		
		 var elements = document.getElementsByClassName('b');
		for (var i = 0; i < elements.length; i++) {
			
			elements[i].bgColor="#C0392B";
			<!--elements[i].bgColor="#e74c3c";-->
	
		}
		
		
				for(var i =0; i<30;i++){
					
				   document.getElementById("p"+i).innerHTML = res["reply"][0][i];
				   if(res["reply"][0][i] == '0'){
					   document.getElementById("p"+i+"v").bgColor = '#29a329';
				   }
				   
				   document.getElementById("p"+i+"v").setAttribute("onclick","showpriprobno("+i+")");
					
			   }
		
	}	
   }
});


   
    //pie rgWiseReported
	$.ajax({
   type: "POST",
   url: "./api.php?apicall=repfsummary",
   success: function(res){

    
      if(window.myPieChart1!= null){
            myPieChart1.destroy();  
      } 

     var copper = document.getElementById("cuflt").getContext('2d');

     window.myPieChart1 = new Chart(copper, {
      type: 'pie',
      data: {
        labels: res["reply"][0],
        datasets: [{
          data: res["reply"][1],
		  backgroundColor:[window.chartColors.red,window.chartColors.orange,window.chartColors.yellow,window.chartColors.purple,window.chartColors.green]
        }]
      },
      options: {
        responsive: true,
		legend: {
                display: true,
                position: 'right'
				}
      }
    });

     if(window.myPieChart2!= null){
            myPieChart2.destroy();  
      } 

     var ftth = document.getElementById("ftthflt").getContext('2d');

	   window.myPieChart2 = new Chart(ftth, {
      type: 'pie',
      data: {
        labels: res["reply"][0],
        datasets: [{
          data: res["reply"][2],
		  backgroundColor:[window.chartColors.red,window.chartColors.orange,window.chartColors.yellow,window.chartColors.purple,window.chartColors.green]
        }]
      },
      options: {
        responsive: true,
		legend: {
                display: true,
                position: 'right'
				}
      }
    });
	
    if(window.myPieChart3!= null){
            myPieChart3.destroy();  
    } 

     var lte = document.getElementById("lteflt").getContext('2d');

	    window.myPieChart3  = new Chart(lte, {
      type: 'pie',
      data: {
        labels: res["reply"][0],
        datasets: [{
          data: res["reply"][3],
		  backgroundColor:[window.chartColors.red,window.chartColors.orange,window.chartColors.yellow,window.chartColors.purple,window.chartColors.green]
        }]
      },
      options: {
        responsive: true,
		legend: {
                display: true,
                position: 'right'
				}
      }
    });
}
}); 

/*min chart*/

/*repeated fault tbl*/
$.ajax({
   type: "POST",
   url: "./api.php?apicall=repetedfaults",
   success: function(res){
  if(res != ''){
    
  $("#repetedfaults").css("display", "block");
  $("#repetedfaults").html();
  $("#repetedfaults").html(res["reply"]);
    
    $("#serchD").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#rDatatbl tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    });
  
  }
  
   }
});




/*LEA fault tbl*/
$.ajax({
   type: "POST",
   url: "./api.php?apicall=faultnew",
   success: function(res){
  if(res != ''){
    
  $("#faultnew").css("display", "block");
  $("#faultnew").html();
  $("#faultnew").html(res["reply"]);
    
    $("#serchD").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#rDatatbl tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    });
  
  }
  
   }
});






$.ajax({
   type: "POST",
   url: "./api.php?apicall=repetedfaults2",
   success: function(res){
  if(res != ''){
    
  $("#repetedfaults2").css("display", "block");
  $("#repetedfaults2").html();
  $("#repetedfaults2").html(res["reply"]);
    
    $("#serchD").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#rDatatbl tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    });
  
  }
  
   }
});


}


function loadlineChrtData(){

$.ajax({
   type: "POST",
   url: "./api.php?apicall=repfaults",
   success: function(res){

    if(window.myLineChart!= null){
            myLineChart.destroy();  
    } 

		var ctxL = document.getElementById("repfaults").getContext('2d');
    window.myLineChart  = new Chart(ctxL, {
      type: 'line',
      data: {
        labels: res["reply"][0],
        datasets: [{
            label: "Total Reported Faults",
			fill: false,
            backgroundColor: window.chartColors.red,
            borderColor:window.chartColors.red,
            borderWidth: 5,
            data: res["reply"][1]
          },
          {
            label:"Megaline",
			fill: false,
            backgroundColor: window.chartColors.blue,
            borderColor: window.chartColors.blue,
            data: res["reply"][2]
          },
		  {
            label: "FTTH",
			fill: false,
            backgroundColor: window.chartColors.yellow,
            borderColor: window.chartColors.yellow,
            data: res["reply"][3]
			//,borderDash: [20,10]
          },
		  {
            label: "LTE",
			fill: false,
            backgroundColor: window.chartColors.purple,
            borderColor: window.chartColors.purple,
            data: res["reply"][4]
          }
        ]
      },
      options: {
				responsive: true,
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Day'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Fault Count'
						}
					}]
				},
				
				legend: {
					labels: {
						fontSize:10
						}
				}
			}
    });

}
}); 


$.ajax({
   type: "POST",
   url: "./api.php?apicall=clerdfaults",
   success: function(res){


		var ctxL = document.getElementById("clerdfaults").getContext('2d');
    var myLineChart = new Chart(ctxL, {
      type: 'line',
      data: {
        labels: res["reply"][0],
        datasets: [{
            label: "Total Cleared Faults",
			fill: false,
            backgroundColor: window.chartColors.green,
            borderColor:window.chartColors.green,
            borderWidth: 5,
            data: res["reply"][1]
          },
          {
            label:"Megaline",
			fill: false,
            backgroundColor: window.chartColors.blue,
            borderColor: window.chartColors.blue,
            data: res["reply"][2]
          },
		  {
            label: "FTTH",
			fill: false,
            backgroundColor: window.chartColors.yellow,
            borderColor: window.chartColors.yellow,
            data: res["reply"][3]
			//,borderDash: [20,10]
          },
		  {
            label: "LTE",
			fill: false,
            backgroundColor: window.chartColors.purple,
            borderColor: window.chartColors.purple,
            data: res["reply"][4]
          }
        ]
      },
      options: {
				responsive: true,
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Day'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Fault Count'
						}
					}]
				},
				
				legend: {
					labels: {
						fontSize:10
						}
				}
			}
    });

}
}); 


$.ajax({
   type: "POST",
   url: "./api.php?apicall=pendingflts",
   success: function(res){

		var ctxL = document.getElementById("pendingflts").getContext('2d');
    var myLineChart = new Chart(ctxL, {
      type: 'line',
      data: {
        labels: res["reply"][0],
        datasets: [{
            label: "Total Pending Faults",
			fill: false,
            backgroundColor: window.chartColors.orange,
            borderColor:window.chartColors.orange,
            borderWidth: 5,
            data: res["reply"][1]
          },
          {
            label:"Megaline",
			fill: false,
            backgroundColor: window.chartColors.blue,
            borderColor: window.chartColors.blue,
            data: res["reply"][2]
          },
		  {
            label: "FTTH",
			fill: false,
            backgroundColor: window.chartColors.yellow,
            borderColor: window.chartColors.yellow,
            data: res["reply"][3]
			//,borderDash: [20,10]
          },
		  {
            label: "LTE",
			fill: false,
            backgroundColor: window.chartColors.purple,
            borderColor: window.chartColors.purple,
            data: res["reply"][4]
          }
        ]
      },
      options: {
				responsive: true,
				maintainAspectRatio: false,
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Day'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Fault Count'
						}
					}]
				},
				
				legend: {
					labels: {
						fontSize:10
						}
				}
			}
    });

}
}); 



}


function viewData(){
 
	var id = event.target.id.replace("D", "");	
   $.ajax({
	   type: "POST",
	   url: "./api.php?apicall=repetedfaultsdetails",
	   data:{id:id},
	   success: function(res){
		
		if(res != ''){	
		if(window.myPieChart4!= null){
				myPieChart4.destroy();	}	
				var fltdetails = document.getElementById("fltdetails").getContext('2d');
				document.getElementById("numberx").innerHTML = id;
				window.myPieChart4 = new Chart(fltdetails, {
				  type: 'pie',
				  data: {
					labels: res["reply"][0],
					datasets: [{
					  data: res["reply"][1],
					  backgroundColor:[window.chartColors.red,window.chartColors.orange,window.chartColors.yellow,window.chartColors.purple,window.chartColors.green,,window.chartColors.blue,,window.chartColors.gray]
					}]
				  },
				  options: {
					responsive: true,
					legend: {
							display: true,
							position: 'right'
							}
				  }
				});
				
			}
			
		}
	});

	
 }


 function viewData1(){
 
  var id = event.target.id.replace("D", "");  
   $.ajax({
     type: "POST",
     url: "./api.php?apicall=repetedfaultsdetails2",
     data:{id:id},
     success: function(res){

    
    if(res != ''){  
    if(window.myPieChart5!= null){
        myPieChart5.destroy();  } 
        var fltdetails2 = document.getElementById("fltdetails2").getContext('2d');
        document.getElementById("numberx2").innerHTML = id;
        window.myPieChart5 = new Chart(fltdetails2, {
          type: 'pie',
          data: {
          labels: res["reply"][0],
          datasets: [{
            data: res["reply"][1],
            backgroundColor:[window.chartColors.red,window.chartColors.orange,window.chartColors.yellow,window.chartColors.purple,window.chartColors.green,,window.chartColors.blue,,window.chartColors.gray]
          }]
          },
          options: {
          responsive: true,
          legend: {
              display: true,
              position: 'right'
              }
          }
        });
        
      }
      
    }
  });

  
 }
 
 function showprobno(x){

	event.preventDefault(); 
	var title = "";
	var type="";
	var time ="";

	if(x < 5)	{
		title ="MEGALINE"; type = "PSTN";
	}else if(x < 10){
		title ="BROADBAND"; type = "ADSL";
	}else if(x < 15){
		title ="PEOTV"; type = "IPTV";
	}else if(x < 20){
		title ="LTE"; type = "LTE";
	}else if(x < 25){
		title ="FTTH"; type = "FTTH";
	}else if(x < 30){
		title ="DATA"; type = "DATA";
	}
 //  else if(x < 35){
	// 	title ="CDMA"; type = "CDMA";
	// }

	if( x%5 == 0){
		title = title+" < 4Hrs PENDING FAULT NUMBERS"; time ="*24 <= 4";
	}
  if( x%5 == 1){
    title = title+" 4Hrs < 20Hrs PENDING FAULT NUMBERS"; time ="*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 ";
  }
	if( x%5 == 2){
		title = title+" 20Hrs < 24Hrs PENDING FAULT NUMBERS"; time ="*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 ";
	}
	if( x%5 == 3){
		title = title+" 1Day < 3Day  PENDING FAULT NUMBERS"; time ="<=3 AND (SYSDATE - PROM_REPORTED)  >=1 ";
	}
	if( x%5 == 4){
		title = title+" > 3Day  PENDING FAULT NUMBERS"; time =">3";
	}
	
 $.ajax({
   type: "POST",
   url: "./api.php?apicall=boxfaultsdetails",
   data:{type:type,time:time},
   success: function(res){
	if(res != ''){
	//console.log("zozo"+res["reply"]);
	$('.modal-heading').html(title);	
	$('.modal-pno').html(res["reply"])	; 
	$('#mymodel').modal();
	}
	
   }
});
 }
 
 
  function showpriprobno(x){

	event.preventDefault(); 
	var title = "";
	var type="";
	var time ="";

	if(x < 5)	{
		title ="MEGALINE"; type = "PSTN";
	}else if(x < 10){
		title ="BROADBAND"; type = "ADSL";
	}else if(x < 15){
		title ="PEOTV"; type = "IPTV";
	}else if(x < 20){
		title ="LTE"; type = "LTE";
	}else if(x < 25){
		title ="FTTH"; type = "FTTH";
	}else if(x < 30){
		title ="DATA"; type = "DATA";
	}
 //  else if(x < 35){
	// 	title ="CDMA"; type = "CDMA";
	// }

	if( x%5 == 0){
		title = title+" < 4Hrs PRIORITY 1 PENDING FAULT NUMBERS"; time ="*24 <= 4";
	}
  if( x%5 == 1){
    title = title+" 4Hrs < 20Hrs PRIORITY 1 PENDING FAULT NUMBERS"; time ="*24 <= 20 AND (SYSDATE - PROM_REPORTED)*24 > 4 ";
  }
	if( x%5 == 2){
		title = title+" 20Hrs < 24Hrs PRIORITY 1 PENDING FAULT NUMBERS"; time ="*24 <= 24 AND (SYSDATE - PROM_REPORTED)*24 > 20 ";
	}
	if( x%5 == 3){
		title = title+" 1Day < 3Day  PRIORITY 1 PENDING FAULT NUMBERS"; time ="<=3 AND (SYSDATE - PROM_REPORTED)  >=1 ";
	}
	if( x%5 == 4){
		title = title+" > 3Day  PRIORITY 1 PENDING FAULT NUMBERS"; time =">3";
	}
	
 $.ajax({
   type: "POST",
   url: "./api.php?apicall=boxfaultsdetailspri",
   data:{type:type,time:time},
   success: function(res){
	if(res != ''){
	//console.log("zozo"+res["reply"]);
	$('.modal-heading').html(title);	
	$('.modal-pno').html(res["reply"])	; 
	$('#mymodel').modal();
	}
	
   }
});
 }
 
function closemodel(){
	$('.modal').toggleClass('is-visible');
}


function exportToExcel(x,y){
var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            };

            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            };

            htmls = $('.modal-pno').html();

            var ctx = {
                worksheet : 'Worksheet',
                table : htmls
            }


            var link = document.createElement("a");
            link.download = "Faultexport_"+($('.modal-heading').html().replace('&lt;','<')).replace('&gt;','>')+".xls";
            link.href = uri + base64(format(template, ctx));
            link.click();
}

function exportToExcel2(x,y){
var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            };

            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            };

            htmls = $('#faultnew').html();

            var ctx = {
                worksheet : 'Worksheet',
                table : htmls
            }


            var link = document.createElement("a");
            link.download = "LEA level-Faults Counts-rtsu.xls";
            link.href = uri + base64(format(template, ctx));
            link.click();
}

function viewNo(element) {
                
  var table = document.getElementById('tbl_data');
  var x = element.parentNode.parentNode.rowIndex;  
  var F_id = table.rows[x].cells[0].innerHTML;

	$.ajax({
	   type: "POST",
	   url: "./api.php?apicall=loadReqTelNo",
	   data:{F_id:F_id},
	   success: function(res){
		if(res != ''){
			var btn = document.getElementById(F_id+"btn");
			btn.value = res['reply'];
			btn.disabled = true;
			//alert(res['reply'])
		
		}
		
	   }
	}); 
  
}


function viewNo2(element) {
                
  var table = document.getElementById('tbl_data2');
  var x = element.parentNode.parentNode.rowIndex;  
  var F_id = table.rows[x].cells[0].innerHTML;

	$.ajax({
	   type: "POST",
	   url: "./api.php?apicall=loadReqTelNo2",
	   data:{F_id:F_id},
	   success: function(res){
		if(res != ''){
			var btn = document.getElementById(F_id+"btn");
			btn.value = res['reply'];
			btn.disabled = true;
			//alert(res['reply'])
		
		}
		
	   }
	}); 
  
}


</script>

</body>

</html>