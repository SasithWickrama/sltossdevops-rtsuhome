<?php

include "DBCon.php";
$t=time();
$i=0;
$teamcount = $_POST['teamcount'];
$teamid = $_POST['teamid'];


while($i < $teamcount)
    {
        
        if(isset($_POST['name1'.$i]))
        {
        $dqteam1 =updateteam($_POST['team'.$i],$_POST['name1'.$i],$_POST['idno1'.$i],$_POST['contact1'.$i]);
        }
        if(isset($_POST['name2'.$i]))
        {
        $dqteam2 =updateteam($_POST['team'.$i],$_POST['name2'.$i],$_POST['idno2'.$i],$_POST['contact2'.$i]);
        }
        
        $i++;
    }

    
    if($dqteam1 && $dqteam2)  
   {
    echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
    echo "<script type='text/javascript'>document.location = \"team.php\";</script>";
    
   } 

?>