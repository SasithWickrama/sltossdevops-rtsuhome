<?php 

function connecttooracle(){
   $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )" ;
  
    if($c = oci_connect("ossprg", "prgoss456", $db))
    {
    return $c;
    }
    else
    {
        $err = OCIError();
        echo "Connection failed." . $err[text];
    }
}


$CON = connecttooracle();



ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
ini_set('max_execution_time', '0'); // for infinite time of execution 

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?> 


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box}

/* Set height of body and the document to 100% */
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial;
}

/* Style tab links */
.tablink {
  background-color: #555;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 50%;
}

.tablink:hover {
  background-color: #777;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  color: white;
  display: none;
  padding: 100px 20px;
  height: 100%;
}

#Home {background-color: white;}
#News {background-color: white;}

#loding_window { position: absolute; margin-top: 5%; right: 40%; z-index: 99; padding:1px;color:#ffffff;background-color:#FFF;}




</style>
<title>SLT Customer Satisfaction</title>
<link rel="stylesheet" href="stylesheet.css">
<link rel="stylesheet" href="bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-responsive.min.css">
<link rel="stylesheet" href="jsDatePick_ltr.min.css">
<script src="amcharts/amcharts.js" type="text/javascript"></script>
<script src="amcharts/serial.js" type="text/javascript"></script>
<script src="amcharts/pie.js" type="text/javascript"></script>
<script src="amcharts/themes/dark.js" type="text/javascript"></script>
<script src="jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="jsDatePick.min.1.3.js"></script>
<script type="text/javascript">

function loadrtom(){
  var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    
        var resp = xmlhttp.responseText.split("@");
         sel = document.getElementById('rt');

for (var i = 0; i<resp.length-1; i++){
    var opt = document.createElement('option');
    opt.value = resp[i];
    opt.innerHTML = resp[i];
    sel.appendChild(opt);
}
 var opt = document.createElement('option');
    opt.value = 'ALL';
    opt.innerHTML = 'ALL';
    sel.appendChild(opt);

        }
    }
    xmlhttp.open("GET","functions.php?q=RTOM",true);
    xmlhttp.send();
}




function drawchart(){
    document.getElementById('chart1').setAttribute("style","height:300px;  width:600px; padding-left:10px");    
    document.getElementById('chart2').setAttribute("style","height:500px;  width:600px; padding-left:10px");
    document.getElementById('chart3').setAttribute("style","height:500px;  width:1200px; padding-left:10px");
    document.getElementById('chart4').setAttribute("style","height:500px;  width:1200px; padding-left:10px");
    
    
      
  
  var fdate = document.getElementById('inputField1').value;
  var todate = document.getElementById('inputField2').value;
  
  if(fdate=='' || todate ==''){
    alert("Plese Select From Date and To Date");
    return;
  }
    
    var rtm = getleaval().replace('&','*');
    console.log(rtm);
    var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    var chartData = []; 
    var chartData1 = [];
    var cval = ["","4 or 5","","","1 to 3"] 
    var tarcum=0; 
    var achcum=0; 
    var tempx   =0;
    var fcount = 0;
    var pec =0;
    document.getElementById('table1').style.display = 'none'; 
      document.getElementById('chart1').style.display ='' ;
      document.getElementById('chart2').style.display = '';
      document.getElementById('chart3').style.display ='' ;
      document.getElementById('chart4').style.display = '';
      
      //console.log (xmlhttp.responseText);
    
      var respx = xmlhttp.responseText.split("@#");
      
      var resp = respx[0].split("@");
      
    //  alert(xmlhttp.responseText);
    
    //console.log (resp.length);
        
      var t1 =0; var t2=0;
        for(var t =0; t<resp.length; t++){
          var temp = resp[t].split(",");
          
          chartData.push({
            dat: temp[0],
            ach: temp[1]
          });
          
          t1 += parseInt(temp[0]);
          t2 += parseInt(temp[1]);
          
          if(t== 4 ){
          
          
          chartData1.push({
            title: "1 to 3",
            value: t2           
          }
          );
          
          t1 = 0;  t2=0;
          }
          if(t==1 ){
          
          
          chartData1.push({
            title: "4 & 5",
            value: t2           
          });
          
          t1 = 0;  t2=0;
          }
        }
        
        var testd= [];
          var respy = respx[1].split("@");
          
          for(var t =0; t<respy.length; t++){
          var tempx = respy[t].split(",,");
                    if(tempx[1] != 0){
          testd.push({
            title: tempx[0],
            value: tempx[1]
          });
                    }         
          }
    /***********bar chart**********/    
        
      
               chart = new AmCharts.AmSerialChart();
               chart.dataProvider = chartData;
               chart.categoryField = "dat";  
         chart.rotate= true;            
               var categoryAxis = chart.categoryAxis;
               categoryAxis.axisColor = "#DADADA";
              

               var graph1 = new AmCharts.AmGraph();
               graph1.valueField = "ach";
         graph1.lineColor = '#106882';
         graph1.fillAlphas = 0.8;
           graph1.lineAlpha = 0.2;
         graph1.type ="column";        
               chart.addGraph(graph1);
        
        
         
       

               var chartCursor = new AmCharts.ChartCursor();
               chartCursor.cursorAlpha = 0.1;
               chartCursor.fullWidth = true;
               chart.addChartCursor(chartCursor);

               var legend = new AmCharts.AmLegend();
               legend.marginLeft = 110;
               legend.useGraphSettings = true;
               chart.addLegend(legend);

               chart.write("chart1"); 
    /***********************************************/    

         chart1 = new AmCharts.AmPieChart();
               chart1.dataProvider = chartData1; 
         chart1.type ="pie";             
               chart1.valueField = "value";
          chart1.titleField =  "title";
        chart1.pullOutOnlyOne = true;
        chart1.allLabels = [];
        chart1.titles = [{"text": "Feedback"}];
        chart1.labelText = "[[title]]: [[value]]";
                chart1.colors = ["#28B463","#CB4335"];
                
                chart1.write("chart2");
//***********************************************************
        
    chart2 = new AmCharts.AmPieChart();
    chart2.dataProvider = testd; 
  chart2.type ="pie";            
    chart2.valueField = "value";
    chart2.titleField =  "title";
  chart2.pullOutOnlyOne = true;
  chart2.allLabels = [];
  chart2.titles = [{"text": "Feedback Reasons"}];
  chart2.labelText = "[[title]]: [[value]]"; 
chart2.startAngle = -90;  
                
  chart2.colors = ["#28B463","#CB4335","#4357AD","#48A9A6","#FFC857","#40576F","#4EC1D0"];
    chart2.write("chart3");
    
    
    
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = testd;
    chart.categoryField = "title";  
  chart.rotate= true;            
    var categoryAxis = chart.categoryAxis;
    categoryAxis.axisColor = "#DADADA";
    categoryAxis.autoWrap = "true";

    var graph1 = new AmCharts.AmGraph();
    graph1.valueField = "value";
  graph1.lineColor = '#106882';
  graph1.fillAlphas = 0.8;
    graph1.lineAlpha = 0.2;
  graph1.type ="column";         
    chart.addGraph(graph1);
    
    var chartCursor = new AmCharts.ChartCursor();
               chartCursor.cursorAlpha = 0.1;
               chartCursor.fullWidth = true;
               chart.addChartCursor(chartCursor);

               var legend = new AmCharts.AmLegend();
               legend.marginLeft = 110;
               legend.useGraphSettings = true;
               chart.addLegend(legend);

               chart.write("chart4"); 
               



//****************************************
            
      
      
            
        }
    }
    xmlhttp.open("GET","functions.php?q=CHART&r="+rtm+"&s="+fdate+"&t="+todate,true);
    xmlhttp.send();
}



function gettable(){
  var fdate = document.getElementById('inputField1').value;
  var todate = document.getElementById('inputField2').value;
  
  if(fdate=='' || todate ==''){
    alert("Plese Select From Date and To Date");
    return;
  }
    
    document.getElementById('chart1').style.display = 'none';
    document.getElementById('chart2').style.display = 'none';
    document.getElementById('chart3').style.display = 'none';
    document.getElementById('chart4').style.display = 'none';
    
  document.getElementById('table1').style.display = '';
  document.getElementById('table1').innerHTML = "<br/><br/><div class=\"loader\"></div>";
  var rtm = getleaval().replace('&','*');
  
  console.log(rtm);
  
  if(rtm ==''){document.getElementById('table1').innerHTML = "";}
  

  
  
  var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    
    
    document.getElementById('table1').style.display = '';
    
        var resp = xmlhttp.responseText.split("@");
        
          var tbl = "<table class=\"table table-bordered table-inverse\"> <tr bgcolor=\"#2E86C1\"><td>LEA</td><td>OPMC</td><td>FAULT ID</td><td>CIRCUIT ID</td><td>FEEDBACK</td><td>REPORTED TIME</td><td>CLOSED TIME</td><td>OUTAGE</td><td>CUSTOMER MOBILE</td><td>WORK GROUP</td><td>EMP NAME</td><td>EMP NUMBER</td><td></td></tr>";
         
         for(var t =0; t<resp.length-1; t++){
          var temp = resp[t].split(",");
          
          tbl = tbl+"<tr><td>"+temp[12]+"</td><td>"+temp[0]+"</td><td>"+temp[1]+"</td><td>"+temp[10]+"</td><td>"+temp[2]+"</td><td>"+temp[3]+"</td><td>"+temp[4]+"</td><td>"+temp[5]+"</td><td>"+temp[6]+"</td><td>"+temp[7]+"</td><td>"+temp[8]+"</td><td>"+temp[9]+"</td>";
          
          if(temp[2] < 4){
            if(temp[11] == '1' || temp[11] == '0' ){
            tbl = tbl+"<td><button id=\""+temp[1]+"\" name=\""+temp[10]+"\" type=\"button\" class=\"btn btn-info\" onClick=\"enableselect()\" data-toggle=\"modal\" data-target=\"#myModal\">Call</button></td></tr>";

            }else if(temp[11] == '2'){
              tbl = tbl+"<td><button id=\""+temp[1]+"\" name=\""+temp[10]+"\" type=\"button\" class=\"btn btn-warning\" onClick=\"getcomment(this)\" data-toggle=\"modal\" data-target=\"#myModal\">Info</button></td></tr>";
              
            }
          }else{
            tbl = tbl+"<td></td></tr>";
          }
         }
        
         tbl = tbl+"</table>";
         document.getElementById('table1').innerHTML = tbl;
         
        }
    }
    xmlhttp.open("GET","functions.php?q=TABLE&r="+rtm+"&s="+fdate+"&t="+todate,true);
    xmlhttp.send();
}


function loadvalues(varid ){
  var fillitem = document.getElementById(varid);
  var selectval = fillitem.options[fillitem.selectedIndex].value.replace('&','*');
  document.getElementById('chart1').innerHTML = '';
    document.getElementById('chart2').innerHTML = '';
    document.getElementById('table1').innerHTML = '';
    document.getElementById('chart3').innerHTML = '';
    document.getElementById('chart4').innerHTML = '';
  
  var nextid;
  var preval;
  show(varid);
  
  if(varid == 'region'){ 
    show('province');
    hide('rtom');
    hide('lea');
    hide('user');
    hide('opmc');
    nextid = 'province';  
  }
  
  if(varid == 'province'){ 
    show('rtom');
    hide('lea');
    hide('user');
    show('opmc');
    nextid = 'rtom';  
    preval = document.getElementById('region').options[document.getElementById('region').selectedIndex].value;    
  }
  
  if(varid == 'rtom'){ 
    show('lea');
    hide('user');
    hide('opmc'); 
    nextid = 'lea'; 
    preval = document.getElementById('province').options[document.getElementById('province').selectedIndex].value.replace('&','*'); 
  }
  
  if(varid == "opmc"){ 
    hide("rtom");
    show("lea");
    hide("user"); 
    nextid = "lea"; 
    preval = document.getElementById('province').options[document.getElementById('province').selectedIndex].value.replace('&','*');
  }
  
  if(varid == "lea"){ 
    show("user"); 
    nextid = "user";
    var opmcx = document.getElementById('opmc').options[document.getElementById('opmc').selectedIndex].value.replace('&','*');  
    
    var rtomx = document.getElementById('rtom').options[document.getElementById('rtom').selectedIndex].value.replace('&','*');
    
    getusers(selectval,opmcx,rtomx);
    return;
    
  }
  
  if(selectval == ''){
    return;
  }
  
  sel = document.getElementById(nextid);
           var length = sel.options.length;
for (var i = 0; i < length; i++) {
  sel.options[i] = null;
}

sel.options.length = 0;
  
  
  //console.log("functions.php?q="+varid+"&r="+selectval+"&s="+preval);
  
  var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) { 
//  console.log(xmlhttp.responseText);
        var resp = xmlhttp.responseText.split("@");
         sel = document.getElementById(nextid);
         
          var opt = document.createElement('option');
    opt.value = '';
    opt.innerHTML = '';
    sel.appendChild(opt);

for (var i = 0; i<resp.length-1; i++){
    var opt = document.createElement('option');
    opt.value = resp[i].replace('&','*');
    opt.innerHTML = resp[i];
    sel.appendChild(opt);
}


        }
    }
    xmlhttp.open("GET","functions.php?q="+varid+"&r="+selectval+"&s="+preval,true);
    xmlhttp.send();
  
  
  if(varid == 'province'){
    nextidx = 'opmc';
    varid = 'province2';
    selx = document.getElementById(nextidx);
           var length = selx.options.length;
for (var i = 0; i < length; i++) {
  selx.options[i] = null;
}

selx.options.length = 0;
  
  var xmlhttpx=new XMLHttpRequest();
xmlhttpx.onreadystatechange=function() {
    if (xmlhttpx.readyState==4 && xmlhttpx.status==200) { 
        var respx = xmlhttpx.responseText.split("@");
         selx = document.getElementById(nextidx);
         
          var optx = document.createElement('option');
    optx.value = '';
    optx.innerHTML = '';
    selx.appendChild(optx);

for (var i = 0; i<respx.length-1; i++){
    var optx = document.createElement('option');
    optx.value = respx[i];
    optx.innerHTML = respx[i];
    selx.appendChild(optx);
}


        }
    }
    xmlhttpx.open("GET","functions.php?q="+varid+"&r="+selectval+"&s="+preval,true);
    xmlhttpx.send();
  }
}


function getusers(lea,opmc,rtom){
  
  if(opmc!= ''){
    var preval = "WHERE OPMC_NAME = '"+opmc+"'";
  }else{
    var preval = "WHERE RTOM_CODE = '"+rtom+"'";
  }
  
  sel = document.getElementById('user');
           var length = sel.options.length;
for (var i = 0; i < length; i++) {
  sel.options[i] = null;
}

sel.options.length = 0;
  
  var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) { 
  
        var resp = xmlhttp.responseText.split("@");
         sel = document.getElementById('user');
         
          var opt = document.createElement('option');
    opt.value = 'ALL';
    opt.innerHTML = 'ALL';
    sel.appendChild(opt);

for (var i = 0; i<resp.length-1; i++){
    var opt = document.createElement('option');
  var respx = resp[i].split("#");
    opt.value = respx[0];
    opt.innerHTML = respx[0]+"_"+respx[1];
    sel.appendChild(opt);
}


        }
    }
    xmlhttp.open("GET","functions.php?q=users&r="+lea+"&s="+preval,true);
    xmlhttp.send();
  
}

function hide(varid){
  document.getElementById(varid).style.visibility = 'hidden';
  document.getElementById(varid+"x").style.visibility = 'hidden';
}


function show(varid){
  document.getElementById(varid).style.visibility = 'visible';
  document.getElementById(varid+"x").style.visibility = 'visible';
}



function getleaval(){
  var statment= null;
   var reg =document.getElementById('region').options[document.getElementById('region').selectedIndex].value;
   if(reg ==''){
     alert("Atlese Select Region to get Data")
   }if(reg =='ALL'){
     statement = ")";
     return statement;
   }else{
     statement = "WHERE REGIONS like '"+reg+"')";
   }
   
   
    var prov =document.getElementById('province').options[document.getElementById('province').selectedIndex].value;
   if(prov ==''){
    return statement;
   }if(prov =='ALL'){
    // return statement;
   }else{
     statement = "WHERE PROVINCE = '"+prov+"')";
   }
   
   
   var rtom =document.getElementById('rtom').options[document.getElementById('rtom').selectedIndex].value;
    var opmc =document.getElementById('opmc').options[document.getElementById('opmc').selectedIndex].value;
  
   if(rtom =='' && opmc ==''){
    return statement;   
   }
   if(rtom !=''){
   if(rtom =='ALL'){
    // return statement;
   }else{
     statement = "WHERE RTOM_CODE = '"+rtom+"')";
   }
   }
   
   
   if(rtom =='' && opmc ==''){
    return statement;   
   }
   if(opmc !=''){
     if(opmc =='ALL'){
    // return statement;
   }else{
     statement = "WHERE OPMC_NAME = '"+opmc+"')";
   }
   }
   
   
    var lea =document.getElementById('lea').options[document.getElementById('lea').selectedIndex].value;
   if(lea ==''){
    return statement;
   }if(lea =='ALL'){
    // return statement;
   }else{
     statement = "WHERE LEA_CODE = '"+lea+"')";
   }
   
   
   var user =document.getElementById('user').options[document.getElementById('user').selectedIndex].value;
   if(user ==''){
    return statement;
   }if(user =='ALL'){
     return statement;
   }else{
     statement = statement+"  AND  CL_SERNO = '"+user+"'";
   }
   
   return statement;
   
}


function closemodel(){
  var tex = document.getElementById('modelselect').options[document.getElementById('modelselect').selectedIndex].value;
  var fid = document.getElementById('mtitle').innerHTML;
  
  console.log(tex+"  "+fid);
  
  if(tex== ''){ return;}
  else{
    var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) { 
  console.log(xmlhttp.responseText);
        var resp = xmlhttp.responseText.split("@"); 
        gettable()      
        
        }
    }
    xmlhttp.open("GET","functions.php?q=comment&r="+tex+"&s="+fid,true);
    xmlhttp.send();
    
  }
}


function enableselect(){
  document.getElementById('modelselect').style.display='block';
  document.getElementById('modelsave').style.display='block';
  document.getElementById('modeltext').style.display='none';
  document.getElementById('modeltext').disabled = true;
  document.getElementById('modelselect').disabled = false;
}

function getcomment(x){
  document.getElementById('modelselect').style.display='none';
  document.getElementById('modeltext').style.display='block';
  document.getElementById('modelsave').style.display='none';
  document.getElementById('modelselect').disabled = true;
  document.getElementById('modeltext').disabled = true;
  var tex = document.getElementById('modeltext');
  console.log(x);
  var fid = x.id;
  
    var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) { 
  console.log(xmlhttp.responseText);
        var resp = xmlhttp.responseText.split("@");
        var fill= '';
        for (var i = 0; i<resp.length-1; i++){
          var respx = resp[i].split("#");
          fill= fill+respx[0]+"   "+respx[1]+"\n";
        }
        tex.value = fill;
        
        }
    }
    xmlhttp.open("GET","functions.php?q=getcomment&s="+fid,true);
    xmlhttp.send();
    
  
}





$(function(){ 
    $('#myModal').on('show.bs.modal', function (e) {
        var button = $(event.target) 
    var $buttonx = $(event.target); 
  var recipient = $buttonx.attr('id')
  var tp = $buttonx.attr('name')
  var modal = $(this)
  modal.find('.modal-title').text( recipient)
  modal.find('.modal-title1').text( tp)
 $("#modelselect").val("");
    });
});


</script>
<script type="text/javascript">
                window.onload = function(){
                                new JsDatePick({
                                                useMode:2,
                                                target:"inputField1",
                                                dateFormat:"%m/%d/%Y"
                                });
                new JsDatePick({
                                                useMode:2,
                                                target:"inputField2",
                                                dateFormat:"%m/%d/%Y"
                                });

				tbl1();

                };
</script>

<script type="text/javascript">
  

            function tbl1(){

            $("#loding_window").css( "display","block" );  
            $.ajax({
            type: "POST",
            // data: {info:info,serv:serv},
            url: "./cust.php?q=1",
            success: function(res){

            $('#tbl1').html(res);
            tbl2();
            }
          });
          }

  function tbl2(){
            $.ajax({
            type: "POST",
            // data: {info:info,serv:serv},
            url: "./cust.php?q=2",
            success: function(res){

            $('#tbl2').html(res);
            
            
            $("#loding_window").css( "display","none" );  

            }
          });
          }

</script>



</head>
<body>

<button class="tablink" onclick="openPage('Home', this, '#a569bd')" id="defaultOpen"><h4>Service Assurance Customer Satisfaction</h4></button>
<!-- <button class="tablink" onclick="openPage('News', this, 'green')" id="defaultOpen">News</button> -->
<button class="tablink" onclick="openPage('News', this, ' #a569bd ')"><h4>weekly progress</h4></button>
<!-- <button class="tablink" onclick="openPage('About', this, 'orange')">About</button> -->

<div id="Home" class="tabcontent">
 

<!-- <div align="center"; style="background-color:#2E86C1">
  <h2 style="color:#F0F3F4  ; font-weight:bolder">Service Assurance Customer Satisfaction</h2>
</div> -->

<div align="center"; >

  <table>
    <tr style="padding:0" >
      <td rowspan="2"><h2 style="color:#2E86C1; font-weight:bolder"><small style="color:#3498DB;" id="regionx">REGION </small></h2></td>
      <td  rowspan="2" style="padding:1em"><select id="region" onChange="loadvalues('region')">
          <option value=""></option>
          <option value="ALL">ALL</option>
          <option value="CEN%UVA">CEN & UVA</option>
      <option value="NEP">NEP</option>
      <option value="WPS">WPS</option>
      <option value="SAB%SP">SAB & SP</option>
      <option value="NC%NWP">NC & NWP</option>
      <option value="WPN">WPN</option>
      <option value="WPC">WPC</option>
        </select></td>
      <td rowspan="2"><h2 style="color:#2E86C1; font-weight:bolder; visibility:hidden"><small style="color:#3498DB;" id="provincex" >PROVINCE </small></h2></td>
      <td rowspan="2" style="padding:1em" ><select id="province" style="visibility:hidden" onChange="loadvalues('province')">
          <option value=""></option>
        </select></td>
      <td><h2 style="color:#2E86C1; font-weight:bolder; visibility:hidden"><small style="color:#3498DB; " id="rtomx" >RTOM </small></h2></td>
      <td style="padding:1em"><select id="rtom" style="visibility:hidden" onChange="loadvalues('rtom')">
          <option value=""></option>
        </select></td>
      <td rowspan="2"><h2 style="color:#2E86C1; font-weight:bolder; visibility:hidden"><small style="color:#3498DB; "id="leax" >LEA </small></h2></td>
      <td rowspan="2" style="padding:1em"><select id="lea" style="visibility:hidden" onChange="loadvalues('lea')">
          <option value=""></option>
        </select></td>
      <td rowspan="2"><h2 style="color:#2E86C1; font-weight:bolder; visibility:hidden"><small style="color:#3498DB; " id="userx" >USERS </small></h2></td>
      <td rowspan="2" style="padding:1em"><select id="user" style="visibility:hidden;width:50px;" >
          <option value=""></option>
        </select></td>
    </tr>
    <tr>
      <td><h2 style="color:#2E86C1; font-weight:bolder; visibility:hidden"><small style="color:#3498DB; " id="opmcx" >OPMC </small></h2></td>
      <td style="padding:1em"><select id="opmc" style="visibility:hidden" onChange="loadvalues('opmc')">
          <option value=""></option>
        </select></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td><h2 style="color:#2E86C1; font-weight:bolder"><small style="color:#3498DB; " id="opmcx" >FROM </small></h2></td><td><input type="text" name="to" class="form-control"  id="inputField1"     />
      </td>
      <td><h2 style="color:#2E86C1; font-weight:bolder"><small style="color:#3498DB; " id="opmcx" >TO </small></h2></td><td><input type="text" name="to" class="form-control" id="inputField2"     /></td>
      <td colspan="2" ><button type="button" class="btn btn-success" onClick="drawchart()">Get Summary Chart</button></td>
      <td  colspan="2"><button type="button" class="btn btn-success" onClick="gettable()">Get Details</button></td>
    </tr>
  </table>
  <div id="table1"  ></div>
 
  <table>
  
    <tr>
      <td><div id="chart1"  style="height:300px;  width:600px; padding-left:10px"></div></td>
      <td><div id="chart2"  style="height:500px;  width:600px; padding-left:10px"></div></td>
    </tr>
     <tr>
      <td colspan="2"><div id="chart3"  style="height:500px;  width:1200px; padding-left:10px"></div></td>
    </tr>
     <tr>
      <td colspan="2"><div id="chart4"  style="height:500px;  width:1200px; padding-left:10px"></div></td>
    </tr>
  </table>
  
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog"> 
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="mtitle"></h4>
      <h4 class="modal-title1" id="mtitle1"></h4>
        </div>
        <div class="modal-body">
          <select id="modelselect"  style="width:35em;">
            <option value=""></option>
            <option value="T_Solved after many visits">T_Solved after many visits</option>
            <option value="T_Solved only one issue and remain other issues">T_Solved only one issue and remain other issues</option>
            <option value="T_Unable to explain the problem or identify within a short time">T_Unable to explain the problem or identify within a short time</option>
            <option value="D_Took long time to solve">D_Took long time to solve</option>
            <option value="D_Fault is not cleared, but SMS is received">D_Fault is not cleared, but SMS is received</option>
            <option value="S_Unacceptable behavior">S_Unacceptable behavior</option>
            <option value="S_Untidy appearance of the Technician">S_Untidy appearance of the Technician</option>
            <option value="S_Did not clean after attending the fault">S_Did not clean after attending the fault</option>
            <option value="C_Irrelevant response">C_Irrelevant response</option>
            <option value="C_CPE issue">C_CPE issue</option>
            <option value="C_SW issue related to customer">C_SW issue related to customer</option>
            <option value="C_Customer related issues">C_Customer related issues</option>
      <option value="S_Fault cleared for the moment,but appears time to time">S_Fault cleared for the moment,but appears time to time</option>
      <option value="S_Genaral idea about SLT, not about particular fault">S_Genaral idea about SLT, not about particular fault</option>
      <option value="S_Fault was cleared, but having some other issue">S_Fault was cleared, but having some other issue</option>
          </select>
          <textarea id="modeltext" style="width:80%; height:50px"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" id="modelsave" class="btn btn-default" onClick="closemodel()" data-dismiss="modal">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>

</div>



<div id="News" class="tabcontent">


<div id="loding_window" style="display: none;">
<img src="img/loading1.gif" width="400" height="200">
</div>

<div id="tbl1">
</div>


<br>

<div id="tbl2">
</div>
</div>







<script>



// $(document).ready(function () {
//   $("#loding_window").css( "display","block" );
   
// });






function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();





</script>
   
</body>
</html> 