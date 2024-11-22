<?php

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true   )
{    
  $user = $_SESSION['$UID'];
  //$opmc = $_SESSION['$rtom'];
  $rtom=$_SESSION['rtom'];

  if(isset($_SESSION['opmc']) && $_SESSION['opmc'] == null   ){	
    echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
  }
}else {     
  echo '<script type="text/javascript"> document.location = "../login.html";</script>'; 
}


?>

<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- Initializations -->
<script type="text/javascript">
// Animations initialization
new WOW().init();
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.material.min.css">

<link href="https://fonts.googleapis.com/css?family=ZCOOL+XiaoWei&display=swap" rel="stylesheet">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

    
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>DevOPS Dashboard</title>
<link rel="shortcut icon" href="img/0028_CMO_IconLB_Reports-Dashboard_RGB.png">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="css/mdb.min.css" rel="stylesheet">
<!-- Your custom styles (optional) -->
<link href="css/style.min.css" rel="stylesheet">

<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<style type="text/css">
  
.nav-tabs { border-bottom: 2px solid #DDD; }
.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover { border-width: 0; }
.nav-tabs > li > a { border: none; color: #000000;background: #ffffff; }
.nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none;  color: #5a4080 !important; background: #5a4080; }
.nav-tabs > li > a::after { content: ""; background: #5a4080; height: 2px; position: absolute; width: 100%; left: 0px; bottom: -1px; transition: all 250ms ease 0s; transform: scale(0); }
.nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }
.tab-nav > li > a::after { background: ##5a4080 none repeat scroll 0% 0%; color: #fff; }
.tab-pane { padding: 15px 0; }
.tab-content{padding:20px}
.nav-tabs > li  {width:25%; text-align:center;}
.card {background: #FFF none repeat scroll 0% 0%; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3); margin-bottom: 30px; }
body{ background: #EDECEC; padding:5px}

@media all and (max-width:724px){
.nav-tabs > li > a > span {display:none;} 
.nav-tabs > li > a {padding: 5px 5px;}
}

</style>
</head>

<body>

<!--Main Navigation-->
<header>
  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container-fluid">
      <!-- Brand -->
      <a class="navbar-brand waves-effect" style="margin-left:45%">
        <strong class="blue-text" >Dashboard | SLT Fault</strong>      
      </a>
	    <a style="font-size:15px;"><?php echo $rtom; ?></a>
    </div>
  </nav>
  <!-- Navbar -->
</header>

<main class="pt-5 mx-lg-12">
  <div class="container-fluid mt-5">
    <div class="row wow fadeIn">
      <!-- Nav tabs -->
      <div class="card">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pending Faults</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Repeated Faults</a>
          </li> -->
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row wow fadeIn justify-content-end">
              <!--Grid column-->
              <!-- <div class="col-md-4 mb-4">
                <h6 id="last_update_date"></h6>
              </div> -->
            </div>
            <div class="row wow fadeIn">
              <!--Grid column-->
              <div class="col-md-4 mb-4">
                <!--Card-->
                <div class="card">
                  <div class="card-header text-center">
                        MEGALINE <br/> (VOICE)
                  </div>
                  <!--Card content-->
                  <div class="card-body">
                    <div id="MEGALINE">
                      <table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
                        
                      </table>
                    </div>
                  </div>
                </div>
                <!--/.Card-->
              </div>
              <!--/.Grid column-->

              <!--Grid column-->
              <div class="col-md-4 mb-4">
                <!--Card-->
                <div class="card">
                  <!-- Card header -->
                  <div class="card-header text-center">
                    BROADBAND <br/> (COPPER BB)
                  </div>
                  <!--Card content-->
                  <div class="card-body">
                    <div id="BROADBAND">
                      <table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
                        
                      </table>
                    </div>
                  </div>
                </div>
                <!--/.Card-->
              </div>
              <!--/.Grid column-->
        
              <!--Grid column-->
              <div class="col-md-4 mb-4">
                <!--Card-->
                <div class="card mb-4">
                  <!-- Card header -->
                  <div class="card-header text-center">
                      PEOTV <br/> (COPPER IPTV) 
                  </div>
                  <!--Card content-->
                  <div class="card-body">
                    <div id="PEOTV">
                      <table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
            
                      </table>
                    </div>
                  </div>
                </div>
                <!--/.Card-->
              </div>
              <!--/.Grid column-->
            </div>
            <!------- end row--->
      
            <!-- start row------>
            <div class="row wow fadeIn">
              <!--Grid column-->
              <div class="col-md-4 mb-4">
                <!--Card-->
                <div class="card mb-4">
                  <!-- Card header -->
                  <div class="card-header text-center">
                    LTE <br/> (VOICE,BB)
                  </div>
                  <!--Card content-->
                  <div class="card-body">
                    <div id="LTE">
                      <table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
              
                      </table>
                    </div>
                  </div>
                </div>
                <!--/.Card-->
              </div>
              <!--/.Grid column-->

              <!--Grid column-->
              <div class="col-md-4 mb-4">
                <!--Card-->
                <div class="card mb-2">
                  <!-- Card header -->
                  <div class="card-header text-center">
                    FTTH <br/> (VOICE,BB,IPTV)
                  </div>
                  <!--Card content-->
                  <div class="card-body">
                    <div id="FTTH">
                      <table  bordercolor="#FFFFFF"; border="2px"; width="100%" >
              
                      </table>
                    </div>
                  </div>
                </div>
                <!--/.Card-->
              </div>
              <!--/.Grid column-->

            </div>
      
            <form name="csvdownload" method="post" action="functioncsv.php">
              <div style="text-align: right; margin-bottom: 20px;"><button type="Submit" name="submitData" id="submitData" class="btn btn-primary btn-sm">Download full report</button></div>
            </form>
      
            <div class="row wow fadeIn">
              <!--Grid column-->
              <div class="col-md-12 mb-4">
                <!--Card-->
                <div class="card"> 
                  <div class="card-header text-center">
                      LEA level - Faults Counts
                  </div>
                  <!--Card content-->
                  <div class="card-body" >
                    <div class="row">
                      <div class="col-md-12 mb-4">
                          <div id="faultnew" style="height:400px;overflow:auto"></div>
                      </div>
                    </div>
                    <div style="text-align: right;"><a href="#" onclick="exportToExcel2()" type="button" class="btn btn-primary btn-sm">Download report</a></div>
                  </div>
                </div>
                <!--/.Card-->
              </div>
              <!--Grid column-->
            </div>
          </div>
          <!-- end first tab ---->
    
          <div class="modal" id="mymodel" style="height:500px; max-width: 700px !important; overflow:auto;">
            <div class="modal-header">
              <h5 class="modal-heading" align="center"></h5>
            </div>
            <div class="modal-body" align="right">
              <div class="modal-content" style="width:630px;">
                <div class="modal-pno" align="center">
                </div>
              </div>
            </div>
            <a href="#" rel="modal:close">Close</a>
            <br/><br/>
            <a href="#" onclick="exportToExcel()">Export</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!--Footer-->
<footer class="page-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn">
  <hr class="my-4">
  <div class="footer-copyright py-3">© 2020 Copyright: OSS DevOPS</div>
</footer>
<!--/.Footer-->


 <!-- Charts -->
<script>

$service_group = ['MEGALINE','BROADBAND','PEOTV','LTE','FTTH','DATA']

window.onload = function(){

  // lastUpdateDDL()
  loadTableStructure()
  loadMainChrtdata();

}

var d = new Date(); 
d.getHours(); 
d.getMinutes(); 
d.getSeconds(); 


// setInterval(function(){ 
//   loadMainChrtdata();
//   if(d.getMinutes() < 11){
//     loadlineChrtData();
//   }
// }, 600000);


function loadTableStructure(){
  $service_group.forEach(function(group){
    $tb =   '<table  bordercolor="#FFFFFF"; border="2px"; width="100%" >'+
              '<tr >'+
                '<td align="center"></td>'+
                '<td align="center"><h6>Total</h6></td>'+
                '<td align="center"><h6>P1</h6></td>'+
              '</tr>'+

              '<tr >'+
                  '<td align="center"><h6>0Hrs&lt; 4Hrs </h6></td>'+
                  '<td bgcolor="#a2d6a2" align="center" width="90px" id="'+ group +'_0"><h6 id="v_'+ group +'_0" >0</h6></td>'+
                  '<td bgcolor="#a2d6a2" align="center" width="90px" id="'+ group +'_p_0"><h6 id="v_'+ group +'_p_0" >0 </h6></td>'+
              '</tr>'+

              '<tr >'+
                  '<td align="center"><h6>4Hrs&lt; 6Hrs </h6></td>'+
                  '<td bgcolor="#7ec77e" align="center" width="90px" id="'+ group +'_1"><h6 id="v_'+ group +'_1" >0</h6></td>'+
                  '<td bgcolor="#7ec77e" align="center" width="90px" id="'+ group +'_p_1"><h6 id="v_'+ group +'_p_1" >0 </h6></td>'+
              '</tr>'+

              '<tr >'+
                  '<td align="center"><h6>6Hrs &lt; 8Hrs</h6></td>'+
                  '<td bgcolor="#29a329" align="center" width="90px" id="'+ group +'_2"><h6 id="v_'+ group +'_2" >0</h6></td>'+
                  '<td bgcolor="#29a329" align="center" width="90px" id="'+ group +'_p_2"><h6 id="v_'+ group +'_p_2" >0 </h6></td>'+
              '</tr>'+

              '<tr>'+
                  '<td align="center"><h6>8Hrs &lt; 24Hrs</h6></td>'+
                  '<td bgcolor="#ffa31a" align="center"; width="90px" id="'+ group +'_3" class="a"><h6 id="v_'+ group +'_3" >0</h6></td>'+
                  '<td bgcolor="#ffa31a" align="center"; width="90px" id="'+ group +'_p_3" class="a"><h6 id="v_'+ group +'_p_3" >0 </h6></td>'+
              '</tr>'+

              '<tr>'+
                  '<td align="center"><h6>&gt; 24Hrs</h6></td>'+
                  '<td bgcolor="#C0392B" align="center" width="90px" id="'+ group +'_4" class="b"><h6  id="v_'+ group +'_4" style="color:#FFF">0</h6></td>'+
                  '<td bgcolor="#C0392B" align="center" width="90px" id="'+ group +'_p_4" class="b"><h6  id="v_'+ group +'_p_4" style="color:#FFF">0 </h6></td>'+
              '</tr>'+
            '</table>'

    $('#'+ group).empty();
    $('#'+ group).append($tb);

    $('#v_'+ group +'_' + 0).attr("onclick","showprobno('"+group+"',null,"+0+")");
    $('#v_'+ group +'_p_' + 0).attr("onclick","showpriprobno('"+group+"',null,"+0+")");

    $('#v_'+ group +'_' + 1).attr("onclick","showprobno('"+group+"',null,"+1+")");
    $('#v_'+ group +'_p_' + 1).attr("onclick","showpriprobno('"+group+"',null,"+1+")");

    $('#v_'+ group +'_' + 2).attr("onclick","showprobno('"+group+"',null,"+2+")");
    $('#v_'+ group +'_p_' + 2).attr("onclick","showpriprobno('"+group+"',null,"+2+")");

    $('#v_'+ group +'_' + 3).attr("onclick","showprobno('"+group+"',null,"+3+")");
    $('#v_'+ group +'_p_' + 3).attr("onclick","showpriprobno('"+group+"',null,"+3+")");

    $('#v_'+ group +'_' + 4).attr("onclick","showprobno('"+group+"',null,"+4+")");
    $('#v_'+ group +'_p_' + 4).attr("onclick","showpriprobno('"+group+"',null,"+4+")");


  });
}

function loadMainChrtdata(){

  $.ajax({
    type: "POST",
    url: "./api.php?apicall=pendingbox",
    success: function(res){
                if(!res['error']){
                  $results = res['reply'];

                  $tb_input_values =  $results.forEach(addTableValue);

                  function addTableValue(item) {
                    $('#v_'+ item.SERVICE_GROUP +'_'+item.TIME_RANGE).text(item.COUNT);
                    $('#v_'+ item.SERVICE_GROUP +'_'+item.TIME_RANGE).attr("onclick","showprobno('"+item.SERVICE_GROUP+"',"+item.COUNT+","+item.TIME_RANGE+")");
                  }

                }else{
                  alert(res['reply'])
                }
              }
  });

  //priority 0

  $.ajax({
    type: "POST",
    url: "./api.php?apicall=pendingboxpri",
    success: function(res){
              if(res != ''){

                $results_pri = res['reply'];
              
                $tb_input_values = $results_pri.forEach(addTableValuePri);

                function addTableValuePri(item) {
                    $('#v_'+ item.SERVICE_GROUP +'_p_'+item.TIME_RANGE).text(item.COUNT);
                    $('#v_'+ item.SERVICE_GROUP +'_p_'+item.TIME_RANGE).attr("onclick","showpriprobno('"+item.SERVICE_GROUP+"',"+item.COUNT+","+item.TIME_RANGE+")");
                }
              }	
            }
  });

  /*LEA fault tbl*/
  $.ajax({
    type: "POST",
    url: "./api.php?apicall=faultnew",
    success: function(res){
                if(res != ''){
                  // console.log(res["reply"])
                  $("#faultnew").css("display", "block");
                  $("#faultnew").html();
                  $("#faultnew").html(res["reply"]);
                  
                  $("#serchD").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#rDatatbl tr").filter(function() {
                      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                  });
                }
              }
  });
}

function showprobno(group,count,range){

	event.preventDefault(); 
	var title = "";
	var type="";
	var time =range;

	if(group == "MEGALINE")	{
		title ="MEGALINE"; type = "MEGALINE";
	}else if(group == "BROADBAND"){
		title ="BROADBAND"; type = "BROADBAND";
	}else if(group == "PEOTV"){
		title ="PEOTV"; type = "PEOTV";
	}else if(group == "LTE"){
		title ="LTE"; type = "LTE";
	}else if(group == "FTTH"){
		title ="FTTH"; type = "FTTH";
	}

	if( range == 0){
		title = title+" < 4Hrs PENDING FAULT NUMBERS"; 
	}
  if( range == 1){
    title = title+" 4Hrs < 6Hrs PENDING FAULT NUMBERS"; 
  }
  if( range == 2){
    title = title+" 6Hrs < 8Hrs PENDING FAULT NUMBERS"; 
  }
	if( range == 3){
		title = title+" 8Hrs < 24Hrs PENDING FAULT NUMBERS";
	}
	if( range == 4){
		title = title+" > 24Hrs PENDING FAULT NUMBERS"; 
	}

	
  $.ajax({
    type: "POST",
    url: "./api.php?apicall=boxfaultsdetails",
    data:{
      type:type,
      time:time
    },
    success:  function(res){
                if(res != ''){
                  // console.log("zozo"+res["reply"]);
                  $('.modal-heading').html(title);	
                  $('.modal-pno').html(res["reply"]); 
                  $('#mymodel').modal();
                }
              }
  });
}
 
 
function showpriprobno(group,count,range){

	event.preventDefault(); 
	var title = "";
	var type="";
	var time = range;

	if(group == "MEGALINE")	{
		title ="MEGALINE"; type = "MEGALINE";
	}else if(group == "BROADBAND"){
		title ="BROADBAND"; type = "BROADBAND";
	}else if(group == "PEOTV"){
		title ="PEOTV"; type = "PEOTV";
	}else if(group == "LTE"){
		title ="LTE"; type = "LTE";
	}else if(group == "FTTH"){
		title ="FTTH"; type = "FTTH";
	}

	if( range == 0){
		title = title+" < 4Hrs PENDING FAULT NUMBERS"; 
	}
  if( range == 1){
    title = title+" 4Hrs < 6Hrs PENDING FAULT NUMBERS"; 
  }
  if( range == 2){
    title = title+" 6Hrs < 8Hrs PENDING FAULT NUMBERS"; 
  }
	if( range == 3){
		title = title+" 8Hrs < 24Hrs PENDING FAULT NUMBERS";
	}
	if( range == 4){
		title = title+" > 24Hrs PENDING FAULT NUMBERS"; 
	}
	
  $.ajax({
    type: "POST",
    url: "./api.php?apicall=boxfaultsdetailspri",
    data:{
      type:type,
      time:time
    },
    success: function(res){
                  if(res != ''){
                    // console.log("zozo"+res["reply"]);
                    $('.modal-heading').html(title);	
                    $('.modal-pno').html(res["reply"])	; 
                    $('#mymodel').modal();
                  }
              }
  });
 
}
 
function closemodel(){
	$('.modal').toggleClass('is-visible');
}


function exportToExcel(x,y){

  var htmls = "";
  var uri = 'data:application/vnd.ms-excel;base64,';
  var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
  var base64 = function(s) {
      return window.btoa(unescape(encodeURIComponent(s)))
  };

  var format = function(s, c) {
    return s.replace(/{(\w+)}/g, function(m, p) {
        return c[p];
    })
  };

  htmls = $('.modal-pno').html();

  var ctx = {
      worksheet : 'Worksheet',
      table : htmls
  }

  var link = document.createElement("a");
  link.download = "Faultexport_"+($('.modal-heading').html().replace('&lt;','<')).replace('&gt;','>')+".xls";
  link.href = uri + base64(format(template, ctx));
  link.click();

}

function exportToExcel2(x,y){

  var htmls = "";
  var uri = 'data:application/vnd.ms-excel;base64,';
  var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
  var base64 = function(s) {
      return window.btoa(unescape(encodeURIComponent(s)))
  };

  var format = function(s, c) {
    return s.replace(/{(\w+)}/g, function(m, p) {
        return c[p];
    })
  };

  htmls = $('#faultnew').html();

  var ctx = {
    worksheet : 'Worksheet',
    table : htmls
  }

  var link = document.createElement("a");
  link.download = "LEA level-Faults Counts-rtsu.xls";
  link.href = uri + base64(format(template, ctx));
  link.click();

}

function viewNo(element) {

  F_id = element;

  $.ajax({
      type: "POST",
      url: "./api.php?apicall=loadReqTelNo",
      data:{F_id:F_id},
      success: function(res){
        if(res != ''){
          var btn = document.getElementById(F_id+"btn");
          btn.value = res['reply'];
          btn.disabled = true;
        }
      }
  }); 

}

function viewNo2(element) {
              
  F_id = element;

  $.ajax({
      type: "POST",
      url: "./api.php?apicall=loadReqTelNo2",
      data:{F_id:F_id},
      success: function(res){
            if(res != ''){
              var btn = document.getElementById(F_id+"btn");
              btn.value = res['reply'];
              btn.disabled = true;
              //alert(res['reply'])
            
            }
      }
  }); 

}

// function lastUpdateDDL() {
              
//   $.ajax({
//       type: "POST",
//       url: "./api.php?apicall=lastupadteddl",
//       success: function(res){
//             if(res != ''){
//               $('#last_update_date').html("Last Update :" + res['reply']);
            
//             }
//       }
//   }); 

// }

</script>
</body>
</html>