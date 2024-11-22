<?php

include "DBCon.php";

$opmc = $_POST['opmc'];
$team = $_POST['team'];
$datto = $_POST['dateto'];
$datfrom= $_POST['datefrom'];

$countay ='0';
$countan ='0';
$countby ='0';
$countbn ='0';
$countcy ='0';
$countcn ='0';
$countdy ='0';
$countdn ='0';
$countey ='0';
$counten ='0';


$totan ='0';
$totbn ='0';
$totcn ='0';
$totdn ='0';
$toten ='0';

$getdetail = getdetail($opmc,$team,$datto,$datfrom);
   // $HEADER = "Team Name, ," .$team;
	//$HEADER = $HEADER . "\n";
    $HEADER = $HEADER . "DATE,DRESS CODE,,COMPANY ID CARD,,FOUR WHEEL VEHICLE AVAILABILITY, ,USAGE OF PROPER TOOLS,,VIOLATION OF STANDARDS,\n";
    $HEADER = $HEADER . ",COMPLIED/NOT COMPLIED,PENALTY,YES/NO,PENALTY,COMPLIED/NOT COMPLIED,PENALTY ,COMPLIED/NOT COMPLIED,PENALTY,YES/NO,PENALTY\n";
    
    while($row = oci_fetch_array($getdetail)){
    	
        if($row[1] == 'NOT COMPLIED')
        {
            $a = '10000';   
            $countan++;
            $totan = $totan +$a;
        }
        else if($row[1] == 'COMPLIED')
        {
            $a='';   
            $countay++;
        }
        else
        {
            $a='';   
        }
        
        if($row[2] == 'NO')
        {
            $b = '10000';  
            $countbn++;
            $totbn = $totbn +$b;
        }
        else if($row[2] == 'YES')
        {
            $b='';
            $countby++;
        }
        else
        {
            $b='';
        }
        
        if($row[3] == 'NOT COMPLIED')
        {
            $c = '50000'; 
            $countcn++; 
            $totcn = $totcn +$c;
        }
        else if($row[3] == 'COMPLIED')
        {
            $c='';
            $countcy++;
        }
        else
        {
            $c='';
        }
        
        if($row[4] == 'NOT COMPLIED')
        {
            $d = '10000'; 
            $countdn++; 
            $totdn = $totdn +$d;
        }
        else if($row[4] == 'COMPLIED')
        {
            $d='';
            $countdy++;  
        }
        else
        {
            $d=''; 
        }
        
        if($row[5] == 'YES')
        {
            $e = '10000';   
            $counten++;
            $toten = $toten +$e;
        }
        else if($row[5] == 'NO')
        {
            $e='';
            $countey++;
            
        }
        else
        {
            $e='';
        }
        
    $HEADER = $HEADER . "$row[0],$row[1],$a,{$row[2]},$b,{$row[3]},$c,{$row[4]},$d,{$row[5]},$e\n";	
    
    
    } 
    $tot = $totan + $totbn + $totcn + $totdn + $toten;
    
    $HEADER = $HEADER . "\n";
    $HEADER = $HEADER . "Overall Summary\n";
    $HEADER = $HEADER . "\n";
    $HEADER = $HEADER . ",DRESS CODE,,COMPANY ID CARD,,FOUR WHEEL VEHICLE AVAILABILITY, ,USAGE OF PROPER TOOLS,,VIOLATION OF STANDARDS,\n";
    $HEADER = $HEADER . ",COMPLIED,NOT COMPLIED,YES,NO,COMPLIED,NOT COMPLIED,COMPLIED,NOT COMPLIED,YES,NO\n";	
    $HEADER = $HEADER . "NO OF DAYS,$countay,$countan,$countby,$countbn,$countcy,$countcn,$countdy,$countdn,$countey,$counten\n";	
    $HEADER = $HEADER . "SUB TOTAL PENALTY,$totan,,$totbn,,$totcn,,$totdn,,$toten,\n";	
    $HEADER = $HEADER . "TOTAL PENALTY,$tot,,,,,,,,,\n";	
    
    $File = "files/{$opmc}.csv";
    $FILE_WRITE = fopen($File, 'w') or die("can't open file");
    fwrite($FILE_WRITE, $HEADER);
    fclose($FILE_WRITE);
    
    header("location: files/{$opmc}.csv");
    
/*    if($dqteam1 && $dqteam2)  
   {
    echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
    echo "<script type='text/javascript'>document.location = \"team.php\";</script>";
    
   } */


?>