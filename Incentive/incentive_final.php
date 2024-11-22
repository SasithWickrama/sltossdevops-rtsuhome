<?php

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
    $user = $_SESSION['$UID'];
	$opmc=$_SESSION['opmc'];
	
	if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null   ){	
	echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
	}
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'dbcon.php';

if (!$CON) 
{
  die('Not connected : ' );
}



 ?>



<!DOCTYPE html>
<html>
<head>
  <title></title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.material.min.css">

<link href="https://fonts.googleapis.com/css?family=ZCOOL+XiaoWei&display=swap" rel="stylesheet">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

    
  

<style type="text/css">
  

  .nav-tabs { border-bottom: 2px solid #DDD; }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover { border-width: 0; }
    .nav-tabs > li > a { border: none; color: #ffffff;background: #5a4080; }
        .nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none;  color: #5a4080 !important; background: #fff; }
        .nav-tabs > li > a::after { content: ""; background: #5a4080; height: 2px; position: absolute; width: 100%; left: 0px; bottom: -1px; transition: all 250ms ease 0s; transform: scale(0); }
    .nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }
.tab-nav > li > a::after { background: ##5a4080 none repeat scroll 0% 0%; color: #fff; }
.tab-pane { padding: 15px 0; }
.tab-content{padding:20px}
.nav-tabs > li  {width:25%; text-align:center;}
.card {background: #FFF none repeat scroll 0% 0%; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); margin-bottom: 30px; }
body{ background: #EDECEC; padding:50px}

@media all and (max-width:724px){
.nav-tabs > li > a > span {display:none;} 
.nav-tabs > li > a {padding: 5px 5px;}
}



</style>
</head>
<body>





<div class="container">
  <div class="row">



    <div class="col-md-12"> 
      <!-- Nav tabs -->
      <div class="card">
      	<div class="form-group text-center">
      	<div class="box-body">
      		<div class="page-title"><h4 style="font-family: 'ZCOOL XiaoWei', serif;">Incentive Application</h4>
      		</div>
      		<div class="page-title">
      		<div class="col-md-12" style="text-align: right;">
      		<!-- <button type="button" class="btn btn-primary btn-sm" style="float: right;">Small button</button> -->
      		<lable style="color:#808b96;">Upload File</lable>&nbsp;&nbsp;<a href="loginupload.php"><i class="fa fa-upload" style="font-size:18px;  float: right; cursor: pointer;"></i></a>
      		</div>
      		</div>

      	</div>
      	</div>
       
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Incentive Final</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Supervisor Data</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Technician FCR</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Technician FR </a>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">


        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">

        <table id="example" class="mdl-data-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>REGION</th>
                <th>PROVINCE</th>
                <th>OPMC</th>
                <th>WG_NAME</th>
                <th>TEAM_CATEGORY</th>
                <th>USER_SER_NO</th>
                <th>INCENTIVE_INDIVIDUAL</th>
            </tr>
        </thead>
        <tbody>
            <?php 
             $query="SELECT * FROM RTSU_INCENTIVE_FINAL WHERE OPMC = '".$opmc."'";
             $stid3=oci_parse($CON, $query);
             oci_execute($stid3);
             $cnt=1;
             while($row=oci_fetch_array($stid3))
             {
          ?>  

             <tr>
                <td><?php echo htmlentities($cnt); ?></td>
                <td><?php echo htmlentities($row['REGION']);?></td>
                <td><?php echo htmlentities($row['PROVINCE']);?></td>
                <td><?php echo htmlentities($row['OPMC']);?></td>
                <td><?php echo htmlentities($row['WG_NAME']);?></td> 
                <td><?php echo htmlentities($row['TEAM_CATEGORY']);?></td> 
                <td><?php echo htmlentities($row['USER_SER_NO']);?></td> 
                <td><?php echo htmlentities($row['INCENTIVE_INDIVIDUAL']);?></td> 					
            </tr>
			
            <?php $cnt=$cnt+1; } ?>
			
        </tbody>
    	</table>
    	<form method="POST" action="csvdownload.php">
    	<button type="Submit" name="submitData1" id="submitData1" class="btn btn-primary btn-lg" style="float: right;">Download &nbsp;<i class='fas fa-download'></i></button>
    	</form>

        </div>


        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        	
        <div class="col-md-12" style="overflow: auto; width: 100%; ">
        <table id="example2" class="mdl-data-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>PROVINCE</th>
                <th>OPMC</th>
                <th>POSITION</th>
                <th>SERVICE_NO</th>
                <th>FAULT_ALLOWED</th>
                <th>NO_OF_FAULTS_REPOERTED</th>
                <th>FAULTS_REPO_B4PM</th>
                <th>FAULTS_CLR_24HRS</th>
                <th>FAULTS_CLR_SAMEDAY_REPO_B4PM</th>
                <th>FCRB4PM</th>
                <th>FCR24HR</th>
                <th>DAY</th>
                <th>KPI</th>
                <th>INTENCIVE_SUPERVISOR</th>
            </tr>
        </thead>
        <tbody>
            <?php 
             $query="SELECT * FROM RTSU_SUP_DAILY WHERE OPMC = '".$opmc."'";
             $stid3=oci_parse($CON, $query);
             oci_execute($stid3);
            $cnt=1;
            while($row=oci_fetch_array($stid3))
            {
          ?>  

             <tr>
                <td><?php echo htmlentities($cnt); ?></td>
                <td><?php echo htmlentities($row['PROVINCE']);?></td>
                <td><?php echo htmlentities($row['OPMC']);?></td>
                <td><?php echo htmlentities($row['POSITION']);?></td>
                <td><?php echo htmlentities($row['SERVICE_NO']);?></td> 
                <td><?php echo htmlentities($row['FAULT_ALLOWED']);?></td> 
                <td><?php echo htmlentities($row['NO_OF_FAULTS_REPOERTED']);?></td> 
                <td><?php echo htmlentities($row['FAULTS_REPO_B4PM']);?></td> 
                <td><?php echo htmlentities($row['FAULTS_CLR_24HRS']);?></td>
                <td><?php echo htmlentities($row['FAULTS_CLR_SAMEDAY_REPO_B4PM']);?></td>
                <td><?php echo htmlentities($row['FCRB4PM']);?></td> 
                <td><?php echo htmlentities($row['FCR24HR']);?></td> 
                <td><?php echo htmlentities($row['DAY']);?></td> 
                <td><?php echo htmlentities($row['KPI']);?></td>
                <td><?php echo htmlentities($row['INTENCIVE_SUPERVISOR']);?></td>  
            </tr>
			
            <?php $cnt=$cnt+1; } ?>
			
        </tbody>
    	</table>
  		</div>

  		<br>

  		<form method="POST" action="csvdownload.php">
  		<button type="Submit" name="submitData2" id="submitData2" class="btn btn-primary btn-lg" style="float: right;">Download &nbsp;<i class='fas fa-download'></i></button>
  		</form>

		</div>




        <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
        	
        <table id="example3" class="mdl-data-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>WFM_WG</th>
                <th>FAULTS_REPORTED</th>
                <th>FAULTS_CLEARED_SM_DAY</th>
                <th>FCRB4PM</th>
                <th>FCR_INCENTIVE</th>
                <th>DAY</th>
                <th>SERVICE_TYPE</th>
                 
            </tr>
        </thead>
        <tbody>
            <?php 
             $query="SELECT * FROM RTSU_TECH_FCR_DAILY ";
             $stid3=oci_parse($CON, $query);
             oci_execute($stid3);
            $cnt=1;
            while($row=oci_fetch_array($stid3))
            {
          ?>  

            <tr>
                <td><?php echo htmlentities($cnt); ?></td>
                <td><?php echo htmlentities($row['WFM_WG']);?></td>
                <td><?php echo htmlentities($row['FAULTS_REPORTED']);?></td>
                <td><?php echo htmlentities($row['FAULTS_CLEARED_SM_DAY']);?></td>
                <td><?php echo htmlentities($row['FCRB4PM']);?></td> 
                <td><?php echo htmlentities($row['FCR_INCENTIVE']);?></td> 
                <td><?php echo htmlentities($row['FCR_DAY']);?></td> 
                <td><?php echo htmlentities($row['SERVICE_TYPE']);?></td>     
            </tr>
			
            <?php $cnt=$cnt+1; } ?>
			
        </tbody>
    	</table>

    	<form method="POST" action="csvdownload.php">
    	<button type="Submit" name="submitData3" id="submitData3" class="btn btn-primary btn-lg" style="float: right;">Download &nbsp;<i class='fas fa-download'></i></button>
    	</form>

        </div>


        <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
        	
        <table id="example4" class="mdl-data-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>WFM_WG</th>
                <th>FAULTS_REPORTED</th>
                <th>FAULT_ALLOWED_PERDAY</th>
                <th>FR_INCENTIVE</th>
                <th>DAY</th>
                <th>SERVICE_TYPE</th>
                
            </tr>
        </thead>
        <tbody>
            <?php 
             $query="SELECT * FROM RTSU_TECH_FR_DAILY ";
             $stid3=oci_parse($CON, $query);
             oci_execute($stid3);
            $cnt=1;
            while($row=oci_fetch_array($stid3))
            {
          ?>  


             <tr>
                <td><?php echo htmlentities($cnt); ?></td>
                <td><?php echo htmlentities($row['WFM_WG']);?></td>
                <td><?php echo htmlentities($row['FAULTS_REPORTED']);?></td>
                <td><?php echo htmlentities($row['FAULT_ALLOWED_PERDAY']);?></td>
                <td><?php echo htmlentities($row['FR_INCENTIVE']);?></td> 
                <td><?php echo htmlentities($row['DAY']);?></td> 
                <td><?php echo htmlentities($row['SERVICE_TYPE']);?></td> 
            </tr>
			
            <?php $cnt=$cnt+1; } ?>
			
        </tbody>
    	</table>

    	<form method="POST" action="csvdownload.php">
    	<button type="Submit" name="submitData4" id="submitData4" class="btn btn-primary btn-lg" style="float: right;">Download &nbsp;<i class='fas fa-download'></i></button>
    	</form>

        </div>
      	</div>

      </div>
    </div>
  </div>
</div>





  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


	

<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable();
    $('#example2').DataTable();
    $('#example3').DataTable();
    $('#example4').DataTable();
} );
</script>

</body>
</html>