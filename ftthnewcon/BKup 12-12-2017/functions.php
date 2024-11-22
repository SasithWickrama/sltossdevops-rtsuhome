<?php

	 ini_set('max_execution_time', 36000);
	   ini_set('memory_limit', '1024M'); 
	 
$q =  $_GET["q"];
$r =  $_GET["r"];

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

date_default_timezone_set('Asia/colombo');
$nowmonth = date("m");

if($q == 'SUMMARY'){
	$result = "<table class=\"table\"  ><thead><tr><th> RTOM </th><th> LAST_MONTH </th><th> THIS_MONTH </th></tr></thead>";
	
	$sql = "select a.OPMC , 
(select nvl(count(distinct b.CIRCUIT_NO),0) from FTTH_NC b where b.OPMC = a.OPMC 
        and to_char(INSPECTION_DATE,'MM') = to_char(add_months(sysdate,-1) , 'MM'))LAST_MONTH,
(select nvl(count(distinct b.CIRCUIT_NO),0) from FTTH_NC b where b.OPMC = a.OPMC 
        and to_char(INSPECTION_DATE,'MM') = to_char(sysdate , 'MM'))THIS_MONTH
from FTTH_NC  a
group by OPMC
order by opmc ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result."<tr><td>".oci_result($stid,oci_field_name($stid, 1))."</td><td>".oci_result($stid,oci_field_name($stid, 2))."</td><td>"
 .oci_result($stid,oci_field_name($stid, 3))."</td></tr>";	
}
				 
oci_free_statement($stid);
$result = $result."</table>";
echo  $result;

}


if($q == 'OPMC'){
	$result = null;
	
	$sql = "SELECT DISTINCT  OPMC_NAME FROM OSSRPT.SLT_AREA ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);

echo  $result;

}

if($q == 'CON'){
	$result = null;
	
	$sql = "SELECT DISTINCT  CONTRACTORS FROM SMS_CONTRACTORS ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){
 $result =   $result.oci_result($stid,oci_field_name($stid, 1))."@";	
}
				 
oci_free_statement($stid);

echo  $result;

}


if($q == 'search'){
	$result = null;
	
	$sql = "SELECT INSPECTION_DATE,CIRCUIT_NO,OPMC,FTC,FDP,FDP_PORT,INSPECTOR,CONTRACTOR,
CON_CONTACTNO CONTRACTOR_CONTACTNO,CUS_NAME CUSTOMER_NAME,CUS_ADDRESS CUSTOMER_ADDRESS,CUS_CONTACTNO CUSTOMER__CONTACTNO,
BB_SPEED_WIRED,BB_SPEED_WIFI,
BB_WIFI_CH SELECTED_WIFI_CHANAL_NO ,BB_OPT_PWR_FDP OUTPUT_POWER_LEVEL_FDP,BB_OPT_PWR_ROS OUTPUT_POWER_LEVEL_ROSSETE,
BB_LOSS LOSS_BETWEEN_FDP_AND_ROSSETE,IPTV_IP,IPTV_OPT_PWR_ONT OUTPUT_POWER_ONT,
ONT_TYPE,OH_CONSTRUCTION,WORK_CON_TEAM WORKMANSHIP_OF_CONTEAM,AFTER_SALE_SV AFTER_SALES_SERVICE,INSPEC_SUG INSPECTOR_SUGGESTIONS,
INSPEC_DIF INSPECTOR_FACED_DIFICULTIES,
SUPERVISER ,SEGMENT,CHECK_LIST,COMPLIANCE,DEVIATION,DEVIATION_JUST,OTHER_COMP,EVIDENCE_REF,FEEDBACK
FROM (select *  from FTTH_NC
where CIRCUIT_NO = '$r'  ) A , (SELECT *  FROM  FTTH_NC_POINTS Y ,FTTH_NC_CHECKLIST X 
WHERE X.CHECK_LIST_ID = Y.ID) B
WHERE FTTH_NC_ID = NC_ID(+) ";
	
 
 $stid = oci_parse($CON, $sql);
oci_execute($stid);

while(oci_fetch($stid)){

	$result =" <table style=\"color:#40576F; \">\n" +
"    <tr style=\"padding:0\" >\n" +
"      <td>Date of inspection</td>\n" +
"      <td style=\"padding-right:55px;\"><input type=\"text\" name=\"inputField1\" class=\"inputx\"  id=\"inputField1\"   value=\"oci_result($stid,oci_field_name($stid, 1))\"  /></td>\n" +
"      <td>Name of inspectors visited</td>\n" +
"      <td><input type=\"text\" name=\"name\" class=\"inputx\"  id=\"name\"   value=\"oci_result($stid,oci_field_name($stid, 7))\"  /></td>\n" +
"    </tr>\n" +
"    <tr >\n" +
"      <td>Telephone/Circuit No:</td>\n" +
"      <td><input type=\"text\" name=\"tpno\"  id=\"tpno\" class=\"inputx\"  id=\"tpno\"     /> \n" +
"      <button type=\"button\" onclick=\"getdata()\">search</button></td>\n" +
"      <td>Contractor Name:</td>\n" +
"      <td><input type=\"text\" name=\"conname\"  id=\"conname\" class=\"inputx\" value=\"oci_result($stid,oci_field_name($stid, 8))\">\n" +
"          </td>\n" +
"    </tr>\n" +
"    <tr >\n" +
"      <td >OPMC Area:</td>\n" +
"      <td><input type=\"text\" name=\"opmc\"  id=\"opmc\" class=\"inputx\" value=\"oci_result($stid,oci_field_name($stid, 3))\"></td>\n" +
"      <td>Contractor Contact No:</td>\n" +
"      <td><input type=\"text\" name=\"contp\" class=\"inputx\"  id=\"contp\"  value=\"oci_result($stid,oci_field_name($stid, 9))\"/></td>\n" +
"    </tr>\n" +
"    <tr >\n" +
"      <td>FTC (Code):</td>\n" +
"      <td><input type=\"text\" name=\"ftc\" class=\"inputx\"  id=\"ftc\"  value=\"oci_result($stid,oci_field_name($stid, 4))\" /></td>\n" +
"      <td>Customer Name:</td>\n" +
"      <td><input type=\"text\" name=\"cusname\" class=\"inputx\"  id=\"cusname\"  /></td>\n" +
"    </tr>\n" +
"    <tr>\n" +
"      <td >FDP (Code):</td>\n" +
"      <td><input type=\"text\" name=\"fdp\" class=\"inputx\"  id=\"fdp\"  /></td>\n" +
"      <td>Customer Address:</td>\n" +
"      <td><input type=\"text\" name=\"address\" class=\"inputx\"  id=\"address\"  /></td>\n" +
"    </tr>\n" +
"    <tr>\n" +
"      <td>FDP Port:</td>\n" +
"      <td><input type=\"text\" name=\"fport\" class=\"inputx\"  id=\"fport\"  /></td>\n" +
"      <td>Customer Contact No:</td>\n" +
"      <td><input type=\"text\" name=\"custp\" class=\"inputx\"  id=\"custp\"  /></td>\n" +
"      </tr>\n" +
"  </table>\n" +
"  <br/>\n" +
"  <table border=\"1\" bordercolor=\"#40576F\" style=\"color:#40576F; font-size:13px \">\n" +
"    <tr style=\"padding:0\" align=\"center\"  >\n" +
"      <td >Segment</td>\n" +
"      <td >S/N</td>\n" +
"      <td >Check Item</td>\n" +
"      <td >Compliance (yes/No)</td>\n" +
"      <td >If no, what is the deviation with the standard</td>\n" +
"      <td >Any justification for the deviation (as observed)</td>\n" +
"      <td >Other complaint/queries/concerns&nbsp; of the customer</td>\n" +
"      <td width=\"152px\">Reference for Evidence provided (photo no, other documents etc)</td>\n" +
"      <td >Your feedback/answers given to the customer</td>\n" +
"    </tr>\n" +
"    <tr align=\"center\">\n" +
"      <td rowspan=4 width=\"150px\" >Appearance and behavior of contractor team</td>\n" +
"      <td >1</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"  width=\"152px\">Visiting customer premises in given appointment time</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog1\" name=\"tog1\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a1\" name=\"a1\"></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b1\" name=\"b2\"></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c1\" name=\"c1\"></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d1\" name=\"d1\"></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e1\"></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >2</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Wearing company uniform</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog2\" name=\"tog2\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a2\" name=\"a2\"></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b2\" name=\"b2\"></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c2\" name=\"c2\"></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d2\" name=\"d2\"></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e2\" name=\"e2\"></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\" >\n" +
"      <td >3</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Wearing Company Identity Card</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog3\"  name=\"tog3\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a3\" name=\"a3\"></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b3\" name=\"b3\"></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c3\" name=\"c3\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d3\"\n" +
"      name=\"d3\"></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e3\" name=\"e3\"></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >4</td>\n" +
"      <td align=\"left\"  style=\"padding:5px\" width=\"152px\">Friendly service to the customer</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog4\" name=\"tog4\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a4\" name=\"a4\"></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b4\" name=\"b4\"></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c4\" name=\"c4\"></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d4\" name=\"d4\"></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e4\" name=\"e4\"></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td rowspan=3  width=\"150px\">Neatness of the work</td>\n" +
"      <td >5</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Cleaning the FDP and relevant adaptor before terminate the fiber drop wire</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog5\" name=\"tog5\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a5\" name=\"a5\"></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b5\" name=\"b5\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c5\" name=\"c5\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d5\" name=\"d5\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e5\" name=\"e5\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\" >\n" +
"      <td >6</td>\n" +
"      <td  align=\"left\" style=\"padding:5px\" width=\"152px\">Neatness of the wiring inside the house according to the\n" +
"        customer awareness/agreement and compliance to the SLT provided guideline</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog6\" name=\"tog6\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a6\" name=\"a6\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b6\" name=\"b6\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c6\" name=\"c6\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d6\" name=\"d6\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e6\" name=\"e6\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >7</td>\n" +
"      <td  align=\"left\" style=\"padding:5px\" width=\"152px\">Cleaning site properly after completion of installations</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog7\"  name=\"tog7\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a7\" name=\"a7\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b7\" name=\"b7\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c7\" name=\"c7\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d7\" name=\"d7\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e7\" name=\"e7\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\" >\n" +
"      <td rowspan=4  width=\"150px\">FAC installation</td>\n" +
"      <td >8</td>\n" +
"      <td  align=\"left\" style=\"padding:5px\" width=\"152px\">Using SLT standardized FAC<span\n" +
"  style='mso-spacerun:yes'> </span></td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog8\" name=\"tog8\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a8\" name=\"a8\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b8\" name=\"b8\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c8\" name=\"c8\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d8\" name=\"d8\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e8\" name=\"e8\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >9</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Using proper tools for each tasks</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog9\" name=\"tog9\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a9\" name=\"a9\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b9\" name=\"b9\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c9\" name=\"c9\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d9\" name=\"d9\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e9\" name=\"e9\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >10</td>\n" +
"      <td  align=\"left\" style=\"padding:5px\" width=\"152px\">Using Acetone fluid or surgical sprit and gauze or baby tissues\n" +
"        for cleaning</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog10\" name=\"tog10\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a10\" name=\"a10\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b10\" name=\"b10\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c10\" name=\"c10\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d10\" name=\"d10\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e10\" name=\"e10\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td  align=\"left\" >11</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Ability to install the FAC perfectly at the first attempt</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog11\" name=\"tog11\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a11\" name=\"a11\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b11\" name=\"b11\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c11\" name=\"c11\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d11\" name=\"d11\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e11\" name=\"e11\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td rowspan=2  width=\"150px\">Confirming the completion of work</td>\n" +
"      <td  align=\"left\" >12</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Using proper equipment to test the connection (VFL, Power Meter)</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog12\" name=\"tog12\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a12\" name=\"a12\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b12\" name=\"b12\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c12\" name=\"c12\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d12\" name=\"d12\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e12\" name=\"e12\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >13</td>\n" +
"      <td  align=\"left\" style=\"padding:5px\" width=\"152px\">Checking the all services are working properly and confirming to customer (Internet on both Ethernet and Wi-Fi and their speeds, PEO TV, and\n" +
"        Voice)</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog13\" name=\"tog13\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a13\" name=\"a13\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b13\" name=\"b13\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c13\" name=\"c13\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d13\" name=\"d13\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e13\" name=\"e13\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td rowspan=11  width=\"150px\">Contractor team adherence to the SLT provided\n" +
"        guidelines for FTTH new connection installation</td>\n" +
"      <td >14</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Keeping FTTH guidelines booklet with the team</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog14\" name=\"tog14\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a14\" name=\"a14\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b14\" name=\"b14\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c14\" name=\"c14\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d14\" name=\"d14\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e14\" name=\"e14\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\" >\n" +
"      <td >15</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Terminating Into FDP</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog15\" name=\"tog15\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a15\" name=\"a15\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b15\" name=\"b15\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c15\" name=\"c15\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d15\" name=\"d15\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e15\" name=\"e15\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\" >\n" +
"      <td >16</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Drop Wire\n" +
"        Drawing</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog16\" name=\"tog16\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a16\" name=\"a16\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b16\" name=\"b16\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c16\" name=\"c16\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d16\" name=\"d16\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e16\" name=\"e16\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\" >\n" +
"      <td height=17 >17</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Erecting Poles</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog17\" name=\"tog17\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a17\" name=\"a17\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b17\" name=\"b17\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c17\" name=\"c17\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d17\" name=\"d17\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e17\" name=\"e17\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td>18</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Demarcation Box\n" +
"        Placing</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog18\" name=\"tog18\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a18\" name=\"a18\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b18\" name=\"b18\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c18\" name=\"c18\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d18\" name=\"d18\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e18\" name=\"e18\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >19</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Internal Wire</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog19\" name=\"tog19\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a19\" name=\"a19\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b19\" name=\"b19\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c19\" name=\"c19\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d19\" name=\"d19\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e19\" name=\"e19\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >20</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Rosette Box\n" +
"        Placing</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog20\" name=\"tog20\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a20\" name=\"a20\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b20\" name=\"b20\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c20\" name=\"c20\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d20\" name=\"d20\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e20\" name=\"e20\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\" >\n" +
"      <td >21</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">FAC Assembling</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog21\" name=\"tog21\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a21\" name=\"a21\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b21\" name=\"b21\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c21\" name=\"c21\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d21\" name=\"d21\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e21\" name=\"e21\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >22</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">ONT Placing</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog22\" name=\"tog22\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a22\" name=\"a22\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b22\" name=\"b22\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c22\" name=\"c22\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d22\" name=\"d22\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e22\" name=\"e22\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td>23</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Power Testing</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog23\" name=\"tog23\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a23\" name=\"a23\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b23\" name=\"b23\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c23\" name=\"c23\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d23\" name=\"d23\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e23\" name=\"e23\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td>24</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">ONT Configuration</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog24\" name=\"tog24\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a24\" name=\"a24\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b24\" name=\"b24\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c24\" name=\"c24\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d24\" name=\"d24\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e24\" name=\"e24\" ></textarea></td>\n" +
"    </tr>\n" +
"    <tr style=\"padding:0\" align=\"center\">\n" +
"      <td >Safty</td>\n" +
"      <td>25</td>\n" +
"      <td align=\"left\" style=\"padding:5px\" width=\"152px\">Adhering safe work practices</td>\n" +
"      <td align=\"left\" style=\"padding:5px\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"Yes\" data-off=\"No\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"tog25\" name=\"tog25\"></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"a25\" name=\"a25\" ></textarea></td>\n" +
"      <td align=\"left\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"b25\" name=\"b25\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"c25\" name=\"c25\" ></textarea></td>\n" +
"      <td align=\"left\" width=\"152px\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"d25\" name=\"d25\" ></textarea></td>\n" +
"      <td align=\"left\" ><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"e25\" name=\"e25\" ></textarea></td>\n" +
"    </tr>\n" +
"  </table>\n" +
"  <br/>\n" +
"  <table style=\"color:#40576F; \">\n" +
"    <tr >\n" +
"      <td rowspan=3 >BB</td>\n" +
"      <td >Internet speed (wired):</td>\n" +
"      <td style=\"padding-right:55px;\"><input type=\"text\" name=\"bbspeed\" class=\"inputx\"  id=\"bbspeed\"     /></td>\n" +
"      <td >Opt.Pwr Level at FDP(dBm):</td>\n" +
"       <td style=\"padding-right:55px;\"><input type=\"text\" name=\"pwr\" class=\"inputx\"  id=\"pwr\"     /></td>\n" +
"    </tr>\n" +
"    <tr >\n" +
"      <td >Internet speed (Wi-Fi):</td>\n" +
"       <td style=\"padding-right:55px;\"><input type=\"text\" name=\"to\" class=\"inputx\"  id=\"wifispeed\"     /></td>\n" +
"      <td  >Opt.Pwr Level at Rossete(dBm):</td>\n" +
"       <td style=\"padding-right:55px;\"><input type=\"text\" name=\"wifipowr\" class=\"inputx\"  id=\"wifipowr\"     /></td>\n" +
"    </tr>\n" +
"    <tr >\n" +
"      <td >Selected Wi-Fi Channel No:</td>\n" +
"       <td style=\"padding-right:55px;\"><input type=\"text\" name=\"chanelno\" class=\"inputx\"  id=\"chanelno\"     /></td>\n" +
"      <td  >Loss btwn FDP &amp; Rossete(dBm):</td>\n" +
"      <td style=\"padding-right:55px;\"><input type=\"text\" name=\"loss\" class=\"inputx\"  id=\"loss\"     /></td>\n" +
"    </tr>\n" +
"    <tr >\n" +
"      <td  >Peo TV</td>\n" +
"      <td >IP Address:</td>\n" +
"       <td style=\"padding-right:55px;\"><input type=\"text\" name=\"ip\" class=\"inputx\"  id=\"ip\"     /></td>\n" +
"      <td  >Opt.Pwr Level at ONT(dBm):</td>\n" +
"       <td style=\"padding-right:55px;\"><input type=\"text\" name=\"iptvpwr\" class=\"inputx\"  id=\"iptvpwr\"     /></td>\n" +
"    </tr>\n" +
"    <tr >\n" +
"      <td >Other Services</td>\n" +
"      <td >&nbsp;</td>\n" +
"      <td >&nbsp;</td>\n" +
"      <td >ONT Type/Model:</td>\n" +
"       <td style=\"padding-right:55px;\"><input type=\"text\" name=\"onttype\" class=\"inputx\"  id=\"onttype\"     /></td>\n" +
"    </tr>\n" +
"    </table>\n" +
"    <br/>\n" +
"    <table style=\"color:#40576F; \">\n" +
"    <tr >\n" +
"      <td colspan=\"5\" align=\"center\">Overall Customer Satisfaction (Excellent / Good/ Average/Bad)</td>\n" +
"    </tr>\n" +
"    <tr >\n" +
"      <td >OH Construction</td>\n" +
"      <td colspan=\"4\" style=\"padding:5px\"><div class=\"btn-group\" data-toggle=\"buttons\" id=\"tog1\">\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options\" id=\"Excellent\" value=\"Excellent\" autocomplete=\"off\"  > Excellent\n" +
"  </label>\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options\" id=\"Good\" value=\"Good\" autocomplete=\"off\"> Good\n" +
"  </label>\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options\" id=\"Average\" value=\"Average\" autocomplete=\"off\"> Average\n" +
"  </label>\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options\" id=\"Bad\" value=\"Bad\" autocomplete=\"off\"> Bad\n" +
"  </label>\n" +
"</div></td>\n" +
"       </tr>\n" +
"    <tr >\n" +
"      <td >Workmanship of Construction Teams</td>\n" +
"       <td colspan=\"4\" style=\"padding:5px\"><div class=\"btn-group\" data-toggle=\"buttons\" id=\"tog2\">\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options1\" id=\"options1\" value=\"Excellent\" autocomplete=\"off\" > Excellent\n" +
"  </label>\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options1\" id=\"options1\" value=\"Good\" autocomplete=\"off\"> Good\n" +
"  </label>\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options1\" id=\"options1\" value=\"Average\" autocomplete=\"off\"> Average\n" +
"  </label>\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options1\" id=\"options1\" value=\"Bad\" autocomplete=\"off\"> Bad\n" +
"  </label>\n" +
"</div></td>\n" +
"       </tr>\n" +
"    <tr  >\n" +
"      <td >SLT After Sale Service</td>\n" +
"       <td colspan=\"4\" style=\"padding:5px\"><div class=\"btn-group\" data-toggle=\"buttons\" id=\"tog3\">\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options2\" value=\"Excellent\" autocomplete=\"off\" > Excellent\n" +
"  </label>\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options2\" value=\"Good\" autocomplete=\"off\"> Good\n" +
"  </label>\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options2\" value=\"Average\" autocomplete=\"off\"> Average\n" +
"  </label>\n" +
"  <label class=\"btn btn-secondary btn-lg\">\n" +
"    <input type=\"radio\" name=\"options2\" value=\"Bad\" autocomplete=\"off\"> Bad\n" +
"  </label>\n" +
"</div></td>\n" +
"    </tr>\n" +
"	<tr>\n" +
"      <td colspan=\"2\">Overall Quality</td>\n" +
"      <td colspan=\"3\"><input type=\"checkbox\" checked data-toggle=\"toggle\" data-on=\"PASS\" data-off=\"FAIL\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"toglast\" name=\"toglast\"></td>\n" +
"    </tr>\n" +
"    <tr>\n" +
"      <td colspan=\"2\">Any suggestions by the inspectors</td>\n" +
"      <td colspan=\"3\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"xx1\" name=\"xx1\"></textarea></td>\n" +
"    </tr>\n" +
"    <tr >\n" +
"      <td colspan=\"2\">Any difficulties faced by the inspectors</td>\n" +
"      <td colspan=\"3\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"xx2\" name=\"xx2\"></textarea></td>\n" +
"    </tr>\n" +
"\n" +
"    <tr >\n" +
"      <td colspan=\"2\">Signature of the supervisor</td>\n" +
"      <td colspan=\"3\"><textarea class=\"form-control\" rows=\"2\" style=\"width:100%; height:100%\" id=\"xx2\" name=\"xx3\"></textarea></td>\n" +
"    </tr>\n" +
"    \n" +
"  </table>";

}
				 
oci_free_statement($stid);

echo  $result;

}