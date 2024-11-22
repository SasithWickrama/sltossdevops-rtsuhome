<?php
include "DBCon.php";
$t=time();
$i=0;

$qdate= date("m/d/Y", strtotime($_POST['qdate']));

    $dq1 =updatedq($t,$_POST['team'],$_POST['user'],$qdate);
    
    $dqlist =updatelist($t,$_POST['team'],$_POST['authletter'],$_POST['dress'],$_POST['vehicle'],$_POST['tools'],$_POST['ladder'],$_POST['safety'],
            $_POST['Material'],$_POST['progress'],$_POST['infcoll'],$_POST['staffcon'],$_POST['Competency'],
            $_POST['wktyp'],$_POST['aloarea'],$_POST['wfm'],$_POST['idcard'],$_POST['vstand']);
            


?>