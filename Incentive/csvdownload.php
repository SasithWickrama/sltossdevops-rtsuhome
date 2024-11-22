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

$date=date('Y-m-d');






     if(isset($_POST["submitData1"])){

     	$fname=$opmc.'_'.$date.'_incentive_final.csv';
     	//$fname=$date.'-incentive_final.csv';
         
         
          header('Content-Type: text/csv; charset=utf-8');  
          header('Content-Disposition: attachment; filename='.$fname);  
          $output = fopen("php://output", "w"); 
          
          fputcsv($output, array('REGION','PROVINCE','OPMC', 'WG_NAME', 'TEAM_CATEGORY', 'USER_SER_NO','INCENTIVE_INDIVIDUAL')); 

          $query = "SELECT REGION,PROVINCE,OPMC,WG_NAME,TEAM_CATEGORY,USER_SER_NO,INCENTIVE_INDIVIDUAL from RTSU_INCENTIVE_FINAL WHERE OPMC = '".$opmc."'"; 

          // $query = "SELECT REGION,PROVINCE,OPMC,WG_NAME,TEAM_CATEGORY,USER_SER_NO,INCENTIVE_INDIVIDUAL from RTSU_INCENTIVE_FINAL WHERE OPMC ='$opmc'"; 
          
          $stid=oci_parse($CON,$query);
          oci_execute($stid);

                  while($row = oci_fetch_array($stid))  
                  {  
                   
                    fputcsv($output, array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6]));

                  }
                  fclose($output); 
          }





        if(isset($_POST["submitData2"])){

		$fname=$opmc.'_'.$date.'_Supervisor_Data.csv';
     	//$fname=$date.'-Supervisor_Data.csv';
         
         
          header('Content-Type: text/csv; charset=utf-8');  
          header('Content-Disposition: attachment; filename='.$fname);  
          $output = fopen("php://output", "w"); 
          
          fputcsv($output, array('PROVINCE','OPMC','POSITION', 'SERVICE_NO', 'FAULT_ALLOWED','NO_OF_FAULTS_REPOERTED','FAULTS_REPO_B4PM','FAULTS_CLR_24HRS','FAULTS_CLR_SAMEDAY_REPO_B4PM','FCRB4PM','FCR24HR','KPI','INTENCIVE_SUPERVISOR','DAY')); 

          $query = "SELECT PROVINCE,OPMC,POSITION,SERVICE_NO,FAULT_ALLOWED,NO_OF_FAULTS_REPOERTED,FAULTS_REPO_B4PM,FAULTS_CLR_24HRS,FAULTS_CLR_SAMEDAY_REPO_B4PM,FCRB4PM,FCR24HR,KPI,INTENCIVE_SUPERVISOR,DAY from RTSU_SUP_DAILY WHERE OPMC = '".$opmc."'"; 

           // $query = "SELECT PROVINCE,OPMC,POSITION,SERVICE_NO,FAULT_ALLOWED,NO_OF_FAULTS_REPOERTED,FAULTS_REPO_B4PM,FAULTS_CLR_24HRS,FAULTS_CLR_SAMEDAY_REPO_B4PM,FCRB4PM,FCR24HR,KPI,INTENCIVE_SUPERVISOR from RTSU_SUP_DAILY WHERE OPMC ='$opmc'"; 

          
          $stid=oci_parse($CON,$query);
          oci_execute($stid);

                  while($row = oci_fetch_array($stid))  
                  {  
                  
                    fputcsv($output, array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13]));

                  }
                  fclose($output); 
          }




        if(isset($_POST["submitData3"])){

     	$fname=$opmc.'_'.$date.'_Technician_FCR.csv';
     	//$fname=$date.'-Technician_FCR.csv';
         
         
          header('Content-Type: text/csv; charset=utf-8');  
          header('Content-Disposition: attachment; filename='.$fname);  
          $output = fopen("php://output", "w"); 
          
          fputcsv($output, array('WFM_WG','FAULTS_REPORTED','FAULTS_CLEARED_SM_DAY', 'FCRB4PM', 'FCR_INCENTIVE','FCR_DAY','SERVICE_TYPE')); 

          $query = "SELECT WFM_WG,FAULTS_REPORTED,FAULTS_CLEARED_SM_DAY,FCRB4PM,FCR_INCENTIVE,FCR_DAY,SERVICE_TYPE from RTSU_TECH_FCR_DAILY"; 

           // $query = "SELECT WFM_WG,FAULTS_REPORTED,FAULTS_CLEARED_SM_DAY,FCRB4PM,FCR_INCENTIVE,FCR_DAY,SERVICE_TYPE from RTSU_TECH_FCR_DAILY WHERE OPMC='$opmc'"; 

          
          $stid=oci_parse($CON,$query);
          oci_execute($stid);

                  while($row = oci_fetch_array($stid))  
                  {  
                   
                    fputcsv($output, array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6]));

                  }
                  fclose($output); 
          }






        if(isset($_POST["submitData4"])){

     	$fname=$opmc.'_'.$date.'_Technician_FR.csv';
     	//$fname=$date.'-Technician_FR.csv';
         
         
          header('Content-Type: text/csv; charset=utf-8');  
          header('Content-Disposition: attachment; filename='.$fname);  
          $output = fopen("php://output", "w"); 
          
          fputcsv($output, array('WFM_WG','FAULTS_REPORTED','FAULT_ALLOWED_PERDAY', 'FR_INCENTIVE', 'DAY','SERVICE_TYPE')); 

          $query = "SELECT WFM_WG,FAULTS_REPORTED,FAULT_ALLOWED_PERDAY,FR_INCENTIVE,DAY,SERVICE_TYPE from RTSU_TECH_FR_DAILY"; 

        // $query = "SELECT WFM_WG,FAULTS_REPORTED,FAULT_ALLOWED_PERDAY,FR_INCENTIVE,DAY,SERVICE_TYPE from RTSU_TECH_FR_DAILY WHERE OPMC='$opmc'"; 

          
          $stid=oci_parse($CON,$query);
          oci_execute($stid);

                  while($row = oci_fetch_array($stid))  
                  {  
                  
                    fputcsv($output, array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]));

                  }
                  fclose($output); 
          }

?>