<?php
session_start();


if($_SESSION['loggedin'] != true){
	echo '<script type="text/javascript"> document.location = "login.html";</script>';
}


$heding = $_SESSION['area'];

?>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FDP Utilization</title>

<link rel="stylesheet" href="bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-responsive.min.css">
<script src="amcharts/amcharts.js" type="text/javascript"></script>
<script src="amcharts/serial.js" type="text/javascript"></script>
<script src="amcharts/pie.js" type="text/javascript"></script>
<script src="amcharts/themes/dark.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">

function drawchart(){
document.getElementById('table1').innerHTML = "<br/><br/><div class=\"loader\"></div>";
document.getElementById('chart1').innerHTML = "";
		
		var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var chartData = [];	
		var chartData1 = [];
		var occupied =0;
		var totalloop =0;
		
		var resp = xmlhttp.responseText.split("@");
		
					
			var t1 =0; var t2=0;
				for(var t =0; t<resp.length-1; t++){
					var temp = resp[t].split(",");					
					chartData.push({
						dat: temp[0],
						ach: temp[1]
					});		

				
				}		   
			   
			   chart1 = new AmCharts.AmPieChart();
               chart1.dataProvider = chartData; 
			   chart1.type ="pie";	           
               chart1.valueField = "ach";
  			 	chart1.titleField =  "dat";
              
            chart1.write("chart1");
			
        }
    }
    xmlhttp.open("GET","functions.php?q=DPCHART",true);
    xmlhttp.send();
}

function gettable(){
	
	var xmlhttpx=new XMLHttpRequest();
xmlhttpx.onreadystatechange=function() {
    if (xmlhttpx.readyState==4 && xmlhttpx.status==200) {
		var occupied =0;
		var totalloop =0;
		
		var t1 = 0;
		var t2= 0;
		
			var rtom = '';
				var resp = xmlhttpx.responseText.split("@");
				
					var tbl = "<table class=\"table table-bordered table-inverse\" width=\"60%\"> <tr bgcolor=\"#2E86C1\"><th>RTOM</th><th>Utilized</th><th>Total loops</th><th>Pecentage</th><th>Unable to Utilized FDPs</th></tr>";
				 for(var t =0; t<resp.length-1; t++){
					var temp = resp[t].split(",");
					if(t==0){
						rtom = temp[0];
						//console.log(rtom);
					}
					
					if(rtom == temp[0]){
					occupied += parseInt(temp[1])*parseInt(temp[2]) ;
					totalloop += parseInt(temp[2])*8;
					var zloop =temp[3];
					t1 += parseInt(temp[1])*parseInt(temp[2]) ;
					t2 += parseInt(temp[2])*8;
					}else{
					
					tbl  =tbl+"<tr><td >"+rtom+"</td><td>"+occupied+"</td><td>"+totalloop+"</td><td>"+Math.round((occupied/totalloop)*100)+"%</td><td>"+zloop+"</td></td>";
					rtom= temp[0];	
					occupied = parseInt(temp[1])*parseInt(temp[2]) ;
					totalloop = parseInt(temp[2])*8 - (8*temp[3]);
					t1 += parseInt(temp[1])*parseInt(temp[2]) ;
					t2 += parseInt(temp[2])*8;
					}
									
				}	
				tbl = tbl+"<tr><td >"+rtom+"</td><td>"+occupied+"</td><td>"+totalloop+"</td><td>"+Math.round((occupied/totalloop)*100)+"%</td><td>"+zloop+"</td></tr>"+
				"<tr><td >TOTAL</td><td>"+t1+"</td><td>"+t2+"</td><td>"+Math.round((t1/t2)*100)+"%</td><td></td></tr>"+
				"</table>";
				 document.getElementById('table2').innerHTML = tbl;				
        }
    }
    xmlhttpx.open("GET","functions.php?q=TABLE",true);
    xmlhttpx.send();
	
}


function drawcharttwo(){
document.getElementById('chart2').innerHTML = "<br/><br/><div class=\"loader\"></div>";
document.getElementById('chart3').innerHTML = "<br/><br/><div class=\"loader\"></div>";


		
		var xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		var chartData = [];	
		var chartDatatwo = [];
		var occupied =0;
		var totalloop =0;
		
		var resp = xmlhttp.responseText.split("@");
		console.log(xmlhttp.responseText);
		for(var tx =0; tx<resp.length-1; tx++){		
			var temp = resp[tx].split(",");					
				
				console.log(temp[0],);
				chartData.push({
				a:temp[0],
				b:temp[1],
				c:temp[2],
				d:temp[3],
				e:temp[4],
				f:temp[5],
				g:temp[6],
				h:temp[7],
				i:temp[8],
				j:temp[9]
				
				});
				occupied = parseInt(temp[2])*1 +  parseInt(temp[3])*2 + parseInt(temp[4])*3 + parseInt(temp[5])*4 +
							parseInt(temp[6])*5 + parseInt(temp[7])*6 + parseInt(temp[8])*7 + parseInt(temp[9])*8 ;
				totalloop = (parseInt(temp[1])+parseInt(temp[2])+parseInt(temp[3])+parseInt(temp[4])+parseInt(temp[5])
							+parseInt(temp[6])+parseInt(temp[7])+parseInt(temp[8])+parseInt(temp[9]))*8;
						
							
				chartDatatwo.push({ ax:temp[0], bx:occupied , cx:totalloop });
			
		}

chart = new AmCharts.AmSerialChart();
               chart.dataProvider = chartData;
               chart.categoryField = "a";              
               var categoryAxis = chart.categoryAxis;
               categoryAxis.axisColor = "#DADADA";
               categoryAxis.dateFormats = [{                 
                    period: 'YYYY',
                    format: 'YYYY'
                }];

               var graph1 = new AmCharts.AmGraph();
               graph1.title = "0 Loop Utilize";
               graph1.valueField = "b";
			 //  graph1.balloonText = ("[[b]]"/totalloop)*100;
               graph1.bullet = "round";
               graph1.hideBulletsCount = 30;
               graph1.bulletBorderThickness = 1;
			   graph1.lineColor = '#FF0E00';
			   graph1.lineThickness = 3;
               chart.addGraph(graph1);
				
                var graph2 = new AmCharts.AmGraph();
               graph2.title = "1 Loop Utilize";
               graph2.valueField = "c";
               graph2.bullet = "round";
               graph2.hideBulletsCount = 30;
               graph2.bulletBorderThickness = 1;
			   graph2.lineColor = '#FF6501';
			   graph2.lineThickness = 3;
               chart.addGraph(graph2);

               var graph3 = new AmCharts.AmGraph();
               graph3.valueField = "d";
               graph3.title = "2 Loop Utilize";
               graph3.bullet = "circle";
               graph3.hideBulletsCount = 30;
               graph3.bulletBorderThickness = 1;
			   graph3.lineColor = '#FF9E02';
			   graph3.lineThickness = 3;
               chart.addGraph(graph3);
			   
			   var graph4 = new AmCharts.AmGraph();
               graph4.valueField = "e";
               graph4.title = "3 Loop Utilize";
               graph4.bullet = "circle";
               graph4.hideBulletsCount = 30;
               graph4.bulletBorderThickness = 1;
			   graph4.lineColor = '#FCD202';
			   graph4.lineThickness = 3;
               chart.addGraph(graph4);
			   
			   
			   var graph5 = new AmCharts.AmGraph();
               graph5.valueField = "f";
               graph5.title = "4 Loop Utilize";
               graph5.bullet = "circle";
               graph5.hideBulletsCount = 30;
               graph5.bulletBorderThickness = 1;
			   graph5.lineColor = '#F8FF01';
			   graph5.lineThickness = 3;
               chart.addGraph(graph5);
			   
			   
			   var graph6 = new AmCharts.AmGraph();
               graph6.valueField = "g";
               graph6.title = "5 Loop Utilize";
               graph6.bullet = "circle";
               graph6.hideBulletsCount = 30;
               graph6.bulletBorderThickness = 1;
			   graph6.lineColor = '#B0DD0E';
			   graph6.lineThickness = 3;
               chart.addGraph(graph6);
			   
			   var graph7 = new AmCharts.AmGraph();
               graph7.valueField = "h";
               graph7.title = "6 Loop Utilize";
               graph7.bullet = "circle";
               graph7.hideBulletsCount = 30;
               graph7.bulletBorderThickness = 1;
			   graph7.lineColor = '#00D819';
			   graph7.lineThickness = 3;
               chart.addGraph(graph7);
			   
			   
			   var graph7 = new AmCharts.AmGraph();
               graph7.valueField = "i";
               graph7.title = "7 Loop Utilize";
               graph7.bullet = "circle";
               graph7.hideBulletsCount = 30;
               graph7.bulletBorderThickness = 1;
			   graph7.lineColor = '#0F8ECF';
			   graph7.lineThickness = 3;
               chart.addGraph(graph7);
			   
			   
			   var graph8 = new AmCharts.AmGraph();
               graph8.valueField = "j";
               graph8.title = "8 Loop Utilize";
               graph8.bullet = "circle";
               graph8.hideBulletsCount = 30;
               graph8.bulletBorderThickness = 1;
			   graph8.lineColor = '#0D50D8';
			   graph8.lineThickness = 3;
               chart.addGraph(graph8);
			   
			 

               var chartCursor = new AmCharts.ChartCursor();
               chartCursor.cursorAlpha = 0.1;
               chartCursor.fullWidth = true;
               chart.addChartCursor(chartCursor);

               var legend = new AmCharts.AmLegend();
               legend.marginLeft = 110;
               legend.useGraphSettings = true;
               chart.addLegend(legend);

               chart.write("chart2");	



charttwo = new AmCharts.AmSerialChart();
               charttwo.dataProvider = chartDatatwo;
               charttwo.categoryField = "ax";              
               var categoryAxis = charttwo.categoryAxis;
               categoryAxis.axisColor = "#DADADA";
               categoryAxis.dateFormats = [{                 
                    period: 'YYYY',
                    format: 'YYYY'
                }];

               var graph1x = new AmCharts.AmGraph();
               graph1x.title = "Occupied";
               graph1x.valueField = "bx";
               graph1x.bullet = "round";
               graph1x.hideBulletsCount = 30;
               graph1x.bulletBorderThickness = 1;
			   graph1x.lineColor = '#FF0E00';
			   graph1x.lineThickness = 3;
               charttwo.addGraph(graph1x);
				
                var graph2x = new AmCharts.AmGraph();
               graph2x.title = "Totalloop";
               graph2x.valueField = "cx";
               graph2x.bullet = "round";
               graph2x.hideBulletsCount = 30;
               graph2x.bulletBorderThickness = 1;
			   graph2x.lineColor = '#0D50D8';
			   graph2x.lineThickness = 3;
               charttwo.addGraph(graph2x);	
			   
			     var chartCursor = new AmCharts.ChartCursor();
               chartCursor.cursorAlpha = 0.1;
               chartCursor.fullWidth = true;
               charttwo.addChartCursor(chartCursor);

               var legend = new AmCharts.AmLegend();
               legend.marginLeft = 110;
               legend.useGraphSettings = true;
               charttwo.addLegend(legend);

charttwo.write("chart3");			   
			  
			
        }
    }
    xmlhttp.open("GET","functions.php?q=CHARTTWO",true);
    xmlhttp.send();
}




 window.onload = function(){
                            drawchart();
							gettable();
							<?php 
							
							if (substr($heding, 0, 1) != 'R'){
							echo"drawcharttwo();";
							}
							?>
						
                };


</script>

</head>

<body >
<div align="center"; style="background-color:#2E86C1">
  <h2 style="color:#F0F3F4  ; font-weight:bolder"><?php echo str_replace("X-","",str_replace("P-","",$heding));?> GPS STATUS</h2>
</div>
<div align="center" >

		
		
 <br/>
 
  <table>
  <tr><td colspan="2" align="center"><div id="table" style=" width:50%;" ></div></td></tr>
    <tr>
	<td> <div id="table1" style=" width:100%;" ></div></td>
      <td><div id="chart1"  style="height:600px;  width:800px; padding-left:10px"></div></td>
    </tr>
	<tr>
	<td colspan="2" align="center"  > <div id="table2" style=" width:60%;" ></div></td>
      </td>
    </tr>
	<tr>
	<td colspan="2"> <div id="chart2"  style="height:400px;  width:800px; padding-left:10px"></div></td>
    </tr>
	<tr>
	<td colspan="2"> <div id="chart3"  style="height:400px;  width:800px; padding-left:10px"></div></td>
    </tr>
  </table>
  

</div>
</body>
</html>