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



$q = $_GET['q'];



if ($q == "1" ){ 

$result="";




$result.="<table class='table table-bordered table-inverse' style='width: 60%;'' align='center'> 
  <thead>
  <tr bgcolor='#2E86C1'>
    <td><h5>Comments</h5></td>
    <td><h5>Week-1</h5></td>
 
  </tr>
</thead>
<tbody >
  
<tr>
    <td>Total cleared fault</td>
    <td>";



              $query="SELECT DISTINCT count(p.PROM_NUMBER) AS CLFAULTCOUNT
                      FROM PROBLEMS p
                      WHERE PROM_TYPE <> 'NWK'
                      AND p.PROM_CLEARED  BETWEEN TO_DATE (concat(TO_CHAR(SYSDATE -8, 'MM/DD/YYYY'),' 11:59:59 PM' ),'mm,dd,yyyy:hh:mi:ss pm')
                      AND TO_DATE (concat(TO_CHAR(SYSDATE , 'MM-DD-YYYY'),' 12:00:00 AM' ),'mm,dd,yyyy:hh:mi:ss pm') ";
              
              $stid=oci_parse($CON, $query);
              oci_execute($stid);
              $row=oci_fetch_array($stid);
              

            $result.=$row['CLFAULTCOUNT'];



    $result.="</td>
  </tr>
  <tr>
    <td>Feedback received</td>
    <td>";


  

              $query1="  SELECT COUNT(DISTINCT FAULT_ID) AS FEEDBACKRECIVED   FROM   (
                        SELECT DISTINCT P.PROM_NUMBER
                        FROM PROBLEMS P
                        WHERE PROM_TYPE <> 'NWK'
                        AND P.PROM_CLEARED  BETWEEN TO_DATE (CONCAT(TO_CHAR(SYSDATE -8, 'MM/DD/YYYY'),' 11:59:59 PM' ),'mm,dd,yyyy:hh:mi:ss pm')
                                                AND TO_DATE (CONCAT(TO_CHAR(SYSDATE -1, 'MM-DD-YYYY'),' 12:00:00 AM' ),'mm,dd,yyyy:hh:mi:ss pm')) A ,
                        SMS_FEEDBACK B
                        WHERE B.FEEDBACK IS NOT NULL 
                        AND FAULT_ID = PROM_NUMBER  ";
              
              $stid1=oci_parse($CON, $query1);
              oci_execute($stid1);
              $row1=oci_fetch_array($stid1);
              

              $result.= $row1['FEEDBACKRECIVED'];

      
    $result.="</td>
  </tr>

  <tr>
    <td>Feedback not received</td>
    <td>";
      
 

              $query2="  SELECT COUNT(DISTINCT FAULT_ID) AS FEEDBACKNOTRECIVED   FROM   (
                         SELECT DISTINCT P.PROM_NUMBER
                         FROM PROBLEMS P
                         WHERE PROM_TYPE <> 'NWK'
                         AND P.PROM_CLEARED  BETWEEN TO_DATE (CONCAT(TO_CHAR(SYSDATE -8, 'MM/DD/YYYY'),' 11:59:59 PM' ),'mm,dd,yyyy:hh:mi:ss pm')
                                                  AND TO_DATE (CONCAT(TO_CHAR(SYSDATE -1, 'MM-DD-YYYY'),' 12:00:00 AM' ),'mm,dd,yyyy:hh:mi:ss pm')) A ,
                         SMS_FEEDBACK B
                         WHERE B.FEEDBACK IS NULL 
                         AND FAULT_ID = PROM_NUMBER ";
              
              $stid2=oci_parse($CON, $query2);
              oci_execute($stid2);
              $row2=oci_fetch_array($stid2);
              

              $result.= $row2['FEEDBACKNOTRECIVED'];

  

   $result.= "</td>
  </tr>

  <tr>
    <td>1~3</td>
    <td>";
      



  

              $query3="SELECT  count(distinct b.FAULT_ID) AS FEEDBACK13    FROM   (
                        SELECT DISTINCT p.PROM_NUMBER
                        FROM PROBLEMS p
                        WHERE  PROM_TYPE <> 'NWK'
                        AND p.PROM_CLEARED  BETWEEN TO_DATE (concat(TO_CHAR(SYSDATE -8, 'MM/DD/YYYY'),' 11:59:59 PM' ),'mm,dd,yyyy:hh:mi:ss pm')
                                                AND TO_DATE (concat(TO_CHAR(SYSDATE -1, 'MM-DD-YYYY'),' 12:00:00 AM' ),'mm,dd,yyyy:hh:mi:ss pm')) a ,
                        SMS_FEEDBACK b
                        WHERE b.FEEDBACK IN ('1','2','3') 
                        AND FAULT_ID = PROM_NUMBER";
              
              $stid3=oci_parse($CON, $query3);
              oci_execute($stid3);
              $row3=oci_fetch_array($stid3);
              

              $result.= $row3['FEEDBACK13'];




   $result.="</td>
  </tr>

  <tr>
    <td>4~5</td>
    <td>";
      
    

              $query4="SELECT  count(distinct b.FAULT_ID) AS FEEDBACK45   FROM   (
                        SELECT DISTINCT p.PROM_NUMBER
                        FROM PROBLEMS p
                        WHERE  PROM_TYPE <> 'NWK'
                        AND p.PROM_CLEARED  BETWEEN TO_DATE (concat(TO_CHAR(SYSDATE -8, 'MM/DD/YYYY'),' 11:59:59 PM' ),'mm,dd,yyyy:hh:mi:ss pm')
                                                AND TO_DATE (concat(TO_CHAR(SYSDATE, 'MM-DD-YYYY'),' 12:00:00 AM' ),'mm,dd,yyyy:hh:mi:ss pm')) a ,
                        SMS_FEEDBACK b
                        WHERE b.FEEDBACK IN ('4','5')  
                        AND FAULT_ID = PROM_NUMBER
                        ";
              
              $stid4=oci_parse($CON, $query4);
              oci_execute($stid4);
              $row4=oci_fetch_array($stid4);
              

              $result.= $row4['FEEDBACK45'];

   



    $result.="</td>
  </tr>

  <tr>
    <td>Contacted Low rating CXs</td>
    <td>";
      

  

              $query5="SELECT COUNT(distinct FAULT_ID) AS DISCRIPTION
                        from (  SELECT  a.PROM_NUMBER   FROM   (
                        SELECT DISTINCT p.PROM_NUMBER
                        FROM PROBLEMS p
                        WHERE  PROM_TYPE <> 'NWK'
                        AND p.PROM_CLEARED  BETWEEN TO_DATE (concat(TO_CHAR(SYSDATE -8, 'MM/DD/YYYY'),' 11:59:59 PM' ),'mm,dd,yyyy:hh:mi:ss pm')
                                                AND TO_DATE (concat(TO_CHAR(SYSDATE, 'MM-DD-YYYY'),' 12:00:00 AM' ),'mm,dd,yyyy:hh:mi:ss pm')) a ,
                        SMS_FEEDBACK b 
                        WHERE FAULT_ID = PROM_NUMBER ) xx ,  SMS_CALLBACK Bb
                        WHERE DISCRIPTION IS NOT NULL
                        AND xx.PROM_NUMBER = Bb.FAULT_ID";
              
              $stid5=oci_parse($CON, $query5);
              oci_execute($stid5);
              $row5=oci_fetch_array($stid5);
              

              $result.= $row5['DISCRIPTION'];

  



    $result.="</td>
  </tr>
  </tbody>
  </table>";

}


if ($q == "2" ){ 

$result="";



      $query6="SELECT LISTAGG( RTOM, ',') WITHIN GROUP (ORDER BY NULL) FROM (SELECT DISTINCT ''''||RTOM||'''' AS RTOM FROM  SMS_FEEDBACK B ,SMS_CALLBACK BB
              WHERE   SMS_DATE  BETWEEN TO_DATE (CONCAT(TO_CHAR(SYSDATE -8, 'MM/DD/YYYY'),' 11:59:59 PM' ),'mm,dd,yyyy:hh:mi:ss pm')
              AND TO_DATE (CONCAT(TO_CHAR(SYSDATE, 'MM-DD-YYYY'),' 12:00:00 AM' ),'mm,dd,yyyy:hh:mi:ss pm')             
              AND   B.FAULT_ID = BB.FAULT_ID)";

              $stid6=oci_parse($CON, $query6);
              oci_execute($stid6);

              // $rtomarr=array();
              $i=0; $rtom="";
              while ($row6=oci_fetch_array($stid6)) {
               
                // $rtomarr[$i]=$row6['RTOM'];
                $rtom=$row6[0];

              }
              // print_r($rtomarr);
        
        
          $query7="SELECT * FROM(SELECT nvl(RTOM,-1) RTOM , DISCRIPTION , COUNT( B.FAULT_ID)FAULT_ID          
                      FROM  SMS_FEEDBACK b ,SMS_CALLBACK Bb
                      WHERE   SMS_DATE  BETWEEN TO_DATE (concat(TO_CHAR(SYSDATE -8, 'MM/DD/YYYY'),' 11:59:59 PM' ),'mm,dd,yyyy:hh:mi:ss pm')
                      AND TO_DATE (concat(TO_CHAR(SYSDATE, 'MM-DD-YYYY'),' 12:00:00 AM' ),'mm,dd,yyyy:hh:mi:ss pm')   
                      AND b.FAULT_ID = Bb.FAULT_ID
                      group by cube(RTOM, DISCRIPTION)  
                      )
                      PIVOT
                      (
                        SUM(FAULT_ID)
                        FOR RTOM IN ($rtom, -1 as TOTAL)
                      )
                      ORDER BY DISCRIPTION";




  $result.="<table class='table table-bordered table-inverse' > 
  <tr bgcolor='#2E86C1'>
  <td><h6>Feedback received from Low rated customers</h6></td>";
    

      $result.="<td>".str_replace( ",","</td><td>" ,str_replace("'", "", $rtom))."</td> <td><h6>Grand Total</h6></td> </tr>";
    // $length=sizeof($rtomarr);
    
      $stid7=oci_parse($CON, $query7);
             oci_execute($stid7);

            $stid8=oci_parse($CON, $query7);
             oci_execute($stid8);
             $i=0; 

  
             $nrows = oci_fetch_all($stid8,$res);
             $cnt=0;

             while ($row6=oci_fetch_array($stid7)) {
                  
                  $cnt++;
                  $result.="<tr>";
                  if ($nrows>$cnt) {
                    
          
                  $result.="<td>".$row6['DISCRIPTION']."</td>";
                  }else{
                   $result.="<td><b>Grand Total</b></td>";
                  }
                  $ncols = oci_num_fields($stid7);
                  
                  for ($i = 1; $i < $ncols; $i++) {


                  $result.="<td>".$row6[$i]."</td>" ;


               

                  }

                 $result.="</tr>";
                
                        }

  }
echo $result;



  ?>
