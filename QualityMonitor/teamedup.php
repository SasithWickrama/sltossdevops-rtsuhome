<?php

include "DBCon.php";
$i=0;
$teamname = $_POST['team'];
$dqteam=delteam($teamname);
while($i < 2)
    {
        
        if(isset($_POST['name'.$i]))
        {
         $dqteam1 =updateteam($teamname,$_POST['name'.$i],$_POST['idno'.$i],$_POST['contact'.$i]);
        }
        $i++;
    }


   if($dqteam1)  
   {
    echo "<script type='text/javascript'>alert('updated successfully!')</script>";
    echo "<script type='text/javascript'>document.location = \"teamed.php\";</script>";
    
   }