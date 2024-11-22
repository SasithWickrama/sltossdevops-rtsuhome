<?php
session_start();
include "DBCon.php";
$opmcarea =  $_SESSION["opmc"];

if(isset($_GET["q"]) && isset($_GET["r"])) {
    
    $chkteam = oci_fetch_array(chk_team($_GET["q"],$_GET["r"]));
  
    if($chkteam[0] != '0')
    {
        echo 'yes@';
    }
    else
    {
        $team_count = get_team($_GET["q"],$_GET["r"]);
        
        while($row = oci_fetch_array($team_count)){
    	
           echo $row[0].'#'.$row[1].'#'.'@';
         } 
    }
}

if(isset($_GET["user"])) {
    
    $getuser = getuser($_GET["user"]);
 
        while($row = oci_fetch_array($getuser)){
    	
           echo $row[0].'#'.$row[1].'#'.$row[2].'#'.'@';
         } 

}




if(isset($_GET["op"]) && isset($_GET["dt"])) {
    $opmc = $_GET["op"];
    $getdetail = getdetail($_GET["op"],$_GET["dt"]);
    
    $HEADER = $HEADER . "AREA,OPMC,CONTRACTOR,TEAM,NAME,ID,CONTACT,NAME,ID,CONTACT,Type Of Work,Allocated Area,Authorization Letter,Dress Code,Vehicle Four Wheel,Tool Box,Ladder,Safety Items,Material Reconilations Report,Daily report for Invoicing,Information Collected,Same Staff Continue,If New Staff Check the Competency \n";
    while($row = oci_fetch_array($getdetail)){
    	
    $HEADER = $HEADER . "$row[0],$row[1],{$row[2]},{$row[3]},{$row[4]},{$row[5]},{$row[6]},$row[7],{$row[8]},{$row[9]},{$row[10]},{$row[11]},{$row[12]},$row[13],{$row[14]},{$row[15]},{$row[16]},{$row[17]},{$row[18]},$row[19],{$row[20]},{$row[21]},{$row[22]},{$row[23]}\n";	
    } 
    $File = "files/{$opmc}.csv";
    $FILE_WRITE = fopen($File, 'w') or die("can't open file");
    fwrite($FILE_WRITE, $HEADER);
    fclose($FILE_WRITE);
    
   echo 'yes@';
}


if(isset($_GET["y"])) {
    $rep="";
    $team_count = get_teamlist($_GET["y"],$_GET["r"]);
    
    while($row = oci_fetch_array($team_count)){
	
       $rep= $rep.$row[0].'@';
     } 
 echo $rep;
}


if(isset($_POST["area"])) {
    
    $area = get_area($_POST["area"]);
    
    echo"<option value=\"\">Select Area</option>";
    
    while($row = oci_fetch_array($area)){
	
       echo"<option  value=\"$row[0]\">$row[0]</option>";
     } 
    
}

if(isset($_POST["opmc"])) {
    
   echo"<option value=\"\">Select OPMC</option>";
   $opmc = get_opmc($_POST["opmc"]);
    while($row = oci_fetch_array($opmc)){
       echo"<option  value=\"$row[0]\">$row[0]</option>";
     } 
    
   // echo"<option  value=\"$opmcarea\">$opmcarea</option>";
    
}    
 
 if(isset($_POST["contractor"])) {
    
    $contractor = get_contractor($_POST["contractor"]);
    
    echo"<option value=\"\">Select Contractor</option>";
    
    while($row = oci_fetch_array($contractor)){
	
       echo"<option  value=\"$row[0]\">$row[0]</option>";
     } 
    
}

 if(isset($_POST["team"])&&isset($_POST["topmc"])) {
    
    $team = get_team($_POST["team"],$_POST["topmc"]);
    
    echo"<option value=\"\">Select Team3</option>";
    
    while($row = oci_fetch_array($team)){
	
       echo"<option  value=\"$row[0]\">$row[0]</option>";
     } 
    
}
?>