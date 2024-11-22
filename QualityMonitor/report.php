<?php
session_start();
include "DBCon.php";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $user = $_SESSION['usrid'];
    $opmc =  $_SESSION["opmc"];

} else {
    echo '<script type="text/javascript"> document.location = "login.html";</script>';
}


?> 

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>QualityMonitor</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	
	
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
	
	

    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <script src="dist/js/pages/dashboard.js" type="text/javascript"></script>
    <script src="dist/js/demo.js" type="text/javascript"></script>

<link rel="stylesheet" href="jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%m/%d/%Y"
		});
                new JsDatePick({
			useMode:2,
			target:"inputField1",
			dateFormat:"%m/%d/%Y"
		});
	};
 </script>  
<script>
function getArea(val) {
	$.ajax({
	type: "POST",
	url: "dynamic_load.php",
	data:'area='+val,
	success: function(data){
		$("#area").html(data);
	}
	});
}

function getOpmc(val) {
	$.ajax({
	type: "POST",
	url: "dynamic_load.php",
	data:'opmc='+val,
	success: function(data){
		$("#opmc").html(data);
	}
	});
}

function getContractor(val) {
	$.ajax({
	type: "POST",
	url: "dynamic_load.php",
	data:'contractor='+val,
	success: function(data){
		$("#contractor").html(data);
	}
	});
}

function getTeam(val){
    var opmc =  document.getElementById('opmc').value;
    
    
                var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
   
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        
        
                                
    var resp = xmlhttp.responseText.split("@");
    sel = document.getElementById('team');

for (var i = 0; i<resp.length-1; i++){
        var dd = resp[i].split(",");
            var opt = document.createElement('option');
            opt.value = dd [0];
            opt.innerHTML = dd [0];
            sel.appendChild(opt);
        console.log(dd[0]);
        }
    }
    }
    
    
    xmlhttp.open("GET","dynamic_load.php?y="+val+"&r="+opmc,true);
    xmlhttp.send();
}

function getexcel(){
var opmc =  document.getElementById('opmc').value;
var dat =  document.getElementById('inputField').value;
 
   if(opmc != '')
    {
                var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                                
// sel = document.getElementById('team');
// var repxy = xmlhttp.responseText;
// var repx = repxy.split("#");
// sel.value = repx[0];
//document.getElementById('teamcount').value = repx[0];
// document.getElementById('teamid').value = repx[1];

var repxy = xmlhttp.responseText.split("@");
console.log(repxy[0]);
 
    alert('Report Generated');  

        }
    }
    xmlhttp.open("GET","dynamic_load.php?op="+opmc+"&dt="+dat,true);
    xmlhttp.send();
    }
    else
    {
        alert('Select the OPMC');  
    }
}

//
</script>


  </head>
  <body class="skin-blue">
    <div class="wrapper">
    
    <header class="main-header">
    <!-- Logo -->
    <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        
        <!-- Notifications: style can be found in dropdown.less -->
        
        <!-- Tasks: style can be found in dropdown.less -->
        
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="dist/img/avatar5.png" class="user-image" alt="User Image"/>
        <span class="hidden-xs"><?php echo $user; ?></span>
        </a>
        <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
        <img src="dist/img/avatar5.png" class="img-circle" alt="User Image" />
        <p>
        </p>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
        
        <div class="pull-right">
        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
        </div>
        </li>
        </ul>
        </li>
        </ul>
        </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- search form -->
        <form action="qmupdate.php" method="post" class="sidebar-form">
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
        <li class="active treeview">
        <a href="team.php">
        <span>TEAM</span></i>
        </a>
        </li>
        
        <li class="active treeview">
        <a href="teamed.php">
        <span>User Update</span> </i>
        </a>
        </li>
        
        <li class="active treeview">
        <a href="qm.php">
        <span>Quality</span> </i>
        </a>
        </li>
        
        <li class="active treeview">
        <a href="report.php">
        <span>Report</span> </i>
        </a>
        </li>
        
  
        

        
        </section>
    <!-- /.sidebar -->
    </aside>
    
    <!-- content-wrapper -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="container">
       
    <form class="well form-horizontal" action="reportgen.php" method="post" id="contact_form">
    <fieldset>
        <input type="hidden" name="newinsert" id="newinsert" value="newscl"/>
    <!-- Form Name -->
    
        <table>
         <tr><td style="width: 150px;">
        <span style="font-size: medium; font-family: TimesNewRomen;">Region</span>
        </td>
        <td style="width: 250px;">
            <select name="region" id="region" class="form-control " onchange="getArea(this.value)"required >
            <option value=" " >Select Region</option>
            <option value="CEN_UVA" >CEN & UVA</option>
            <option value="NEP" >NEP</option>
            <option value="WPC" >WPC</option>
            <option value="WPS" >WPS</option>
			<option value="WPN" >WPN</option>
			<option value="SAB_SP" >SAB & SP</option>
			<option value="NC_NWP" >NC & NWP</option>
            </select>
        </td>

        <td style="width: 150px;">
        <span style="font-size: medium; font-family: TimesNewRomen;">&nbsp;&nbsp;&nbsp;Area</span>
        </td>
        <td style="width: 250px;">
        <select name="area" id="area" class="form-control " onchange="getOpmc(this.value)" >
            <option value=" " >Select Area</option>
            </select>
        </td>
        </tr>
        <tr style="height: 5px;"></tr>
        <tr>
        <td>
        <span style="font-size: medium; font-family: TimesNewRomen;">OPMC</span>
        </td>
        <td>
        <select name="opmc" id="opmc" class="form-control " onchange="getContractor(this.value)" >
            <option value="">Select OPMC</option>
            </select>
        </td>

        <td>
        <span style="font-size: medium; font-family: TimesNewRomen;">&nbsp;&nbsp;&nbsp;Contractor</span>
        </td>
        <td>
        <select name="contractor" id="contractor" class="form-control " onchange="getTeam(this.value)" >
            <option value="">Select Contractor</option>
            </select>
        </td>
        </tr>
        <tr style="height: 5px;"></tr>

        <tr>
        <td>
        <span style="font-size: medium; font-family: TimesNewRomen;">Team</span>
        </td>
        <td>
        <select name="team" id="team" class="form-control ">
            <option value="null">Select Team</option>
            </select>
        </td>

        <td>
        <span style="font-size: medium; font-family: TimesNewRomen;">&nbsp;&nbsp;&nbsp;Date From</span>
        </td>
        <td>
        <input type="text"  name="datefrom" id="inputField" style="width:250px; height:30px;" class="form-control" required></td>
		
        </tr>
        <tr style="height: 5px;"></tr>
        <tr>
        <td>
  
        </td>
        <td></td>
        <td>
        <span style="font-size: medium; font-family: TimesNewRomen;">&nbsp;&nbsp;&nbsp;Date To</span>
        </td>
        <td>
        <input type="text"  name="dateto" id="inputField1" style="width:250px; height:30px;" class="form-control" required></td>
		
        </tr>
        <tr style="height: 5px;"></tr>
        
        
        <tr><td colspan="4"  > <div id="teamtbl"></div></td></tr>



        <tr style="height: 15px;"></tr>
        
        <tr>
        <td>
        <button type="submit" class="btn btn-warning"  >Submit <span class="glyphicon glyphicon-send"></span></button>
        </td>
        <td>
        
        </td>
        </tr>
        </table>

        <input  name="teamcount" id="teamcount" class="form-control"  type="hidden"/>
        <input  name="teamid" id="teamid" class="form-control"  type="hidden"/>
    </fieldset>
    </form>
    </section>
    
    <!-- Main content -->
    </div>
    </div>
    <!-- content-wrapper -->
    
    <!-- footer -->  
    <footer class="main-footer" align="center">
    <strong >Copyright &copy; 2017 <font color="red">IT SOLUTION & IMPLEMENTATION.</font> All rights reserved.</strong>
    </footer>

    <!-- footer -->    
</div><!-- ./wrapper -->


  </body>
</html>