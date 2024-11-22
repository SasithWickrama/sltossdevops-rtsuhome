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
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include 'dbcon.php';

if (!$CON) 
{
  die('Not connected : ' );
}

set_time_limit(300);

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
<link href="https://fonts.googleapis.com/css?family=DM+Serif+Text|ZCOOL+XiaoWei&display=swap" rel="stylesheet"> 

    
  

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
.nav-tabs > li  {width:20%; text-align:center;}
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
      		<div class="page-title"><h3 style="font-family: 'ZCOOL XiaoWei', serif;">Incentive Application File Upload</h3></div>
      	</div>
      	</div>



        <form role="form" method="post" action="" name="uploadCSV" enctype="multipart/form-data">
          


          <div class="form-group">
            <div class="col-md-12"> 
            <label style="font-family: 'ZCOOL XiaoWei', serif;font-family: 'DM Serif Text', serif; font-size: 16px;">Incentive_Final : &nbsp; (Updated Monthly)</label>&nbsp;&nbsp;&nbsp;
            <input type="file" name="file"  id="file" accept=".csv" style="cursor: pointer;">
            <button type="submit" name="btn1" class="btn btn-warning">Upload</button>
            </div>
          </div>

          <br><br>

          <div class="form-group">
            <div class="col-md-12"> 
            <label style="font-family: 'ZCOOL XiaoWei', serif;font-family: 'DM Serif Text', serif; font-size: 16px;">Technician_FCR : &nbsp; (Update Weekly)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="file" name="file2" id="file2" accept=".csv" style="cursor: pointer;">
            <button type="submit" name="btn2" class="btn btn-warning">Upload</button>
            </div>
          </div>

          <br><br>


          <div class="form-group">
            <div class="col-md-12"> 
            <label style="font-family: 'ZCOOL XiaoWei', serif;font-family: 'DM Serif Text', serif; font-size: 16px;">Technician _FR : &nbsp; (Update Weekly)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="file" name="file3" id="file3" accept=".csv" style="cursor: pointer;">
            <button type="submit" name="btn3" class="btn btn-warning">Upload</button>
            </div>
          </div>

          <br><br>



          <div class="form-group">
            <div class="col-md-12"> 
            <label style="font-family: 'ZCOOL XiaoWei', serif;font-family: 'DM Serif Text', serif; font-size: 16px;">Supervisor_Data : &nbsp; (Update Weekly)</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="file" name="file4" id="file4" accept=".csv" style="cursor: pointer;">
            <button type="submit" name="btn4" class="btn btn-warning">Upload</button>
            </div>
          </div>

          <br><br>


        </form>




        <?php

                if (isset($_POST["btn1"])) {

                     $fileName = $_FILES["file"]["tmp_name"];
    
                    if ($_FILES["file"]["size"] > 0) {
        
                        $file = fopen($fileName, "r");


                          $sql1="TRUNCATE TABLE RTSU_INCENTIVE_FINAL";
                          $stid2=oci_parse($CON,$sql1);
                          oci_execute($stid2);

                          $count=0;

                       while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

                          $count++;
                         if ($count>1) {

                          $sqlInsert = "INSERT into RTSU_INCENTIVE_FINAL (REGION,PROVINCE,OPMC,WG_NAME,TEAM_CATEGORY,USER_SER_NO,INCENTIVE_INDIVIDUAL)values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "')";
                          $stid=oci_parse($CON,$sqlInsert);

                            if (oci_execute($stid)) {
                               $type = "success";
                               $message = "CSV Data Imported into the Database";

                           } else {
                               $type = "error";
                                $message = "Problem in Importing CSV Data";
                           }

                         }
                       
                        }

                        echo '<script>alert("file upload success")</script>';
                        
                       
                    }
                }






                if (isset($_POST["btn2"])) {
                 
                     
                     $fileName = $_FILES["file2"]["tmp_name"];
    
                    if ($_FILES["file2"]["size"] > 0) {
        
                        $file = fopen($fileName, "r");


                          $sql1="TRUNCATE TABLE RTSU_TECH_FCR_DAILY";
                          $stid2=oci_parse($CON,$sql1);
                          oci_execute($stid2);

                          $count=0;
        
                       while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                         $count++;
                         if ($count>1) {
                           
                     

                          $sqlInsert = "INSERT into RTSU_TECH_FCR_DAILY (WFM_WG,FAULTS_REPORTED,FAULTS_CLEARED_SM_DAY,FCRB4PM,FCR_INCENTIVE,FCR_DAY,SERVICE_TYPE)values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "')";
                          $stid=oci_parse($CON,$sqlInsert);

                            if (oci_execute($stid)) {
                               $type = "success";
                               $message = "CSV Data Imported into the Database";

                           } else {
                               $type = "error";
                               $message = "Problem in Importing CSV Data";
                           }
                       
                        }

                         }

                        echo '<script>alert("file upload success")</script>';
                    }


                }




                if (isset($_POST["btn3"])) {
                    
                     $fileName = $_FILES["file3"]["tmp_name"];
    
                    if ($_FILES["file3"]["size"] > 0) {
        
                        $file = fopen($fileName, "r");


                          $sql1="TRUNCATE TABLE RTSU_TECH_FR_DAILY";
                          $stid2=oci_parse($CON,$sql1);
                          oci_execute($stid2);


                        $count=0;
        
                       while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

                           $count++;
                         if ($count>1) {

                           $sqlInsert = "INSERT into RTSU_TECH_FR_DAILY (WFM_WG,FAULTS_REPORTED,FAULT_ALLOWED_PERDAY,FR_INCENTIVE,DAY,SERVICE_TYPE)values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "')";
                          $stid=oci_parse($CON,$sqlInsert);

                            if (oci_execute($stid)) {
                               $type = "success";
                               $message = "CSV Data Imported into the Database";

                           } else {
                               $type = "error";
                               $message = "Problem in Importing CSV Data";
                           }
                         }
                       
                        }

                        echo '<script>alert("file upload success")</script>';
                    }
                }






                if (isset($_POST["btn4"])) {
                    
                     $fileName = $_FILES["file4"]["tmp_name"];
    
                    if ($_FILES["file4"]["size"] > 0) {
        
                        $file = fopen($fileName, "r");


                          $sql1="TRUNCATE TABLE RTSU_SUP_DAILY";
                          $stid2=oci_parse($CON,$sql1);
                          oci_execute($stid2);


                        $count=0;
        
                       while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

                           $count++;
                         if ($count>1) {

                            $sqlInsert = "INSERT into RTSU_SUP_DAILY (PROVINCE,OPMC,POSITION,SERVICE_NO,FAULT_ALLOWED,NO_OF_FAULTS_REPOERTED,FAULTS_REPO_B4PM,FAULTS_CLR_24HRS,FAULTS_CLR_SAMEDAY_REPO_B4PM,FCRB4PM,FCR24HR,KPI,INTENCIVE_SUPERVISOR,DAY)values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "','" . $column[7] . "','" . $column[8] . "','" . $column[9] . "','" . $column[10] . "','" . $column[11] . "','" . $column[12] . "','" . $column[13] . "')";
                          $stid=oci_parse($CON,$sqlInsert);

                            if (oci_execute($stid)) {
                               $type = "success";
                               $message = "CSV Data Imported into the Database";

                           } else {
                               $type = "error";
                               $message = "Problem in Importing CSV Data";
                           }
                         }
                       
                        }

                        echo '<script>alert("file upload success")</script>';
                    }
                }
                ?>



        </div>
       
      </div>
      </div>
    </div>
  </div>
</div>


  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


</body>
</html>