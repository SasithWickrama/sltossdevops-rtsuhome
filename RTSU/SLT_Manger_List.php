<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{    
    $user = $_SESSION["user"];
	$area = $_SESSION["area"];
	$temp = explode('/',$area);
	$n = sizeof($temp);
	
}
else 
{     
    echo '<script type="text/javascript"> document.location = "Login.php";</script>'; 
}

$so_id = $_GET["id"];
include "../DBConnection.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
        <link rel="shortcut icon" href="img/contractor.png">
	<link rel="stylesheet" href="../css/style.css">
            <link href="../css/tabmenu.css" rel="stylesheet" type="text/css" />
    <script src="../css/tabmenu.js" type="text/javascript"></script>
    
</head>
<body>
    <div id="cssmenu">
        
        
    <ul>
   <li class='active'><a href="../SLT_User_List.php"><span>Home</span></a></li>
   <li><a href='#'><span>Logged as : <?php echo $user ?></span></a></li>
   <li class='last'><a href="../logout.php"><span>Logout</span></a></li>
</ul>
        </div>	
		<div style="padding-left: 450px; padding-top: 40px">
<font size="5">Pending PSTN New Connection Summary</font>
</div>
<div style="padding-left: 350px; padding-top: 50px" id="table1">

	
<table  border="2">
<tr style="border-color:#333; border-radius:50px; font-weight: bold; font-size:18px; ">
<td>RTOM AREA</td>
<td>ORDER TYPE</td>
<td>ALL NC COUNT</td>
<td>T < 3D</td>
<td>3D < T > 7D</td>
<td>T > 7D</td>
</tr>
<?php
$tot= 0;
$v1 = 0;
$v2=0;
$v3=0;
$i=0;

	while ($i < $n)
	{
		//CREATE
		$so_count = so_count_pen($temp[$i]);
		$row=oci_fetch_array($so_count);
		if ($row[0] == null)
		{
		$row[0] = 0;
		}
		if ($row[1] == null)
		{
		$row[1] = 0;
		}
		if ($row[2] == null)
		{
		$row[2] = 0;
		}
		$tot =	$row[0]+$row[1]+$row[2];
	echo"	<tr style=\"font-size:15px;\" align=\"center\">
			<td>$temp[$i]</td>
			<td>CREATE</td>
			<td>$tot</td>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			</tr> ";
			
		//CREATE OR 
		$so_count2 = so_count_pen2($temp[$i]);
		$row2=oci_fetch_array($so_count2);
		if ($row2[0] == null)
		{
		$row2[0] = 0;
		}
		if ($row2[1] == null)
		{
		$row2[1] = 0;
		}
		if ($row2[2] == null)
		{
		$row2[2] = 0;
		}
		$tot2 =	$row2[0]+$row2[1]+$row2[2];
	echo"	<tr style=\"font-size:15px;\" align=\"center\">
			<td>$temp[$i]</td>
			<td>CREATE OR</td>
			<td>$tot2</td>
			<td>$row2[0]</td>
			<td>$row2[1]</td>
			<td>$row2[2]</td>
			</tr> ";
			
		//CREATE RECON 
		$so_count3 = so_count_pen3($temp[$i]);
		$row3=oci_fetch_array($so_count3);
		if ($row3[0] == null)
		{
		$row3[0] = 0;
		}
		if ($row3[1] == null)
		{
		$row3[1] = 0;
		}
		if ($row3[2] == null)
		{
		$row3[2] = 0;
		}
		$tot3 =	$row3[0]+$row3[1]+$row3[2];
	echo"	<tr style=\"font-size:15px;\" align=\"center\">
			<td>$temp[$i]</td>
			<td>CREATE RECON</td>
			<td>$tot3</td>
			<td>$row3[0]</td>
			<td>$row3[1]</td>
			<td>$row3[2]</td>
			</tr> ";	
			
		//MODIFY LOCATION 
		$so_count4 = so_count_pen4($temp[$i]);
		$row4=oci_fetch_array($so_count4);
		if ($row4[0] == null)
		{
		$row4[0] = 0;
		}
		if ($row4[1] == null)
		{
		$row4[1] = 0;
		}
		if ($row4[2] == null)
		{
		$row4[2] = 0;
		}
		$tot4 =	$row4[0]+$row4[1]+$row4[2];
	echo"	<tr style=\"font-size:15px;\" align=\"center\">
			<td>$temp[$i]</td>
			<td>MODIFY LOCATION</td>
			<td>$tot4</td>
			<td>$row4[0]</td>
			<td>$row4[1]</td>
			<td>$row4[2]</td>
			</tr> ";
			
		$i++;
	}
?>
</table>
</div>   
    
</body>
</html>