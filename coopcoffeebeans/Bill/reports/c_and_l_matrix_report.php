<?php

require("../../tables.php");
require("../../functions.php");
// check security
 session_start();
// check session variable

  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
  }

	echo'<html>';
	echo'<head>';
  	echo'<title>Admin Customer Sales Report</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';



      echo '<form method=POST action=c_and_l_matrix_report.php>';

# was here
#  far right cell 


      echo '<table width=100%><tr><td>';
      echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
      echo '</td><td align=center>';
      echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';
  

 


//*************Build Date Drop Down******************************************
//**Adding dates to dropdown here must add dates to if statements below******
#$import_yr = $current_year;


if (!isset($_REQUEST['year_range'])) {
    $import_yr = $current_year;
    $year_range = $current_year;
}
else {
    $import_yr=$_REQUEST['year_range'];
    $year_range=$_REQUEST['year_range'];

}

if (!isset($_REQUEST['year_range'])) {
    $import_yr = $current_year;
}
else {
    $import_yr=$_REQUEST['year_range'];

}
 
echo '<table width=100%><tr><td align=left>';


  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

 

echo '<br><font size=3 color=blue>Select a date range</font>';
$date_range =  $year_list;

echo "\n";
echo '<select name=year_range>';
echo "\n";
 
for ($i=0; $i < count($date_range);  $i++)
  {
    echo "<option value=$date_range[$i] ";
    if ($import_yr == $date_range[$i]) {
       echo ' selected ';
    }

    echo "> $date_range[$i]";

    echo "\n";
  }

 echo '</select><br>';

echo '<input type="SUBMIT" name="ACTION" class=button value="View">';



echo '</td><td align=center>';
echo '<h3>Contracted and Landed Containers Report </h3>';
 


echo '</td><td align=right>';
                  echo '¤ ';
            $current_date = date('Y-m-d H:i:s');
            echo date('H:i, jS F');
            
echo '</td></tr></table>';            


//**************************Assign ranges to date for searching*********************


$from_date = $year_range.'-01-01';
$to_date = $year_range.'-12-31';

            
   $query = "SELECT id.item_code,  Month(ci.ship_date) as ship_month, sum(ci.quantity) as quantity,
             AVG(ci.cost) as cost
          FROM $tbl_item_description id,  $tbl_coop_item ci
          WHERE id.item_code = ci.item_code     
           AND ci.ship_date Between '$from_date' and '$to_date'
           and ci.STATUS in ('Signed','Landed')
              group by id.item_code, Month(ci.ship_date)
              order by id.item_code, Month(ci.ship_date)";           
        
#echo "<br> $query <br>";

$second_half = "";              
              

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);


 $item_code_array = array();
for ($i=0; $i <$num_results;  $i++)  {
    $row = mysql_fetch_array($result);
 
    if ( !$item_code_array[$row["item_code"]]);
        $item_code_array[$row["item_code"]] = $row["item_code"];
        
        
    if (${$row["item_code"]}) {
    	 ${$row["item_code"]}["sales"]  += $row["quantity"];
    	 
      if ($row["cost"] == 0) {
      	$cost = 260;
      }
      else {
      	$cost = $row["cost"];
      }
      
    	switch ($row["ship_month"]) 
    	        {
    		case 1: ${$row["item_code"]}["jan"]  += $row["quantity"];
    		        ${$row["item_code"]}["janc"]  += $row["quantity"] * $cost;
    		        break;
    	        case 2: ${$row["item_code"]}["feb"]  += $row["quantity"];
    	                ${$row["item_code"]}["febc"]  += $row["quantity"] * $cost;
    		              break;
    		case 3: ${$row["item_code"]}["mar"]  += $row["quantity"];
    		        ${$row["item_code"]}["marc"]  += $row["quantity"] * $cost;
    		        break;
    		case 4: ${$row["item_code"]}["apr"]  += $row["quantity"];
    		        ${$row["item_code"]}["aprc"]  += $row["quantity"] * $cost;
    		        break;
    		case 5: ${$row["item_code"]}["may"]  += $row["quantity"];
    		        ${$row["item_code"]}["mayc"]  += $row["quantity"] * $cost; 
    		        break;
    		case 6: ${$row["item_code"]}["jun"]  += $row["quantity"];
    		        ${$row["item_code"]}["junc"]  += $row["quantity"] * $cost;
    		        break;
    		case 7: ${$row["item_code"]}["jul"]  += $row["quantity"];
    	         	${$row["item_code"]}["jucc"]  += $row["quantity"] * $cost;
    		        break;
    		case 8: ${$row["item_code"]}["aug"]  += $row["quantity"];
    		        ${$row["item_code"]}["augc"]  += $row["quantity"] * $cost;
    		        break;
    		case 9: ${$row["item_code"]}["sep"]  += $row["quantity"];
    		        ${$row["item_code"]}["sepc"]  += $row["quantity"] * $cost;
    		        break;
    		case 10: ${$row["item_code"]}["oct"]  += $row["quantity"];
    		         ${$row["item_code"]}["octc"]  += $row["quantity"] * $cost;
    		        break;
    		case 11: ${$row["item_code"]}["nov"]  += $row["quantity"];
    		         ${$row["item_code"]}["novc"]  += $row["quantity"] * $cost;
    		        break;
    		case 12: ${$row["item_code"]}["dec"]  += $row["quantity"];
    		         ${$row["item_code"]}["decc"]  += $row["quantity"] * $cost;
    		        break;   
    		}  
    	 
 
 	
}
    else {
    	 ${$row["item_code"]} = array("code" => $row["item_code"],
    	                                        "cost" => $cost,
    	                                        "jan" =>"0", 
    	                                        "janc" =>"0",
    	                                        "feb" =>"0", 
    	                                        "febc" =>"0", 
    	                                        "mar" =>"0", 
    	                                        "marc" =>"0", 
    	                                        "apr" =>"0", 
    	                                        "aprc" =>"0", 
    	                                        "may" =>"0",
    	                                        "mayc" =>"0", 
    	                                        "jun" =>"0", 
    	                                        "junc" =>"0", 
    	                                        "jul" =>"0", 
    	                                        "julc" =>"0",
    	                                        "aug" =>"0", 
    	                                        "augc" =>"0", 
    	                                        "sep" =>"0", 
    	                                        "sepc" =>"0", 
    	                                        "oct" =>"0", 
    	                                        "octc" =>"0", 
    	                                        "nov" =>"0",
    	                                        "novc" =>"0",  
    	                                        "dec" =>"0",
    	                                        "decc" =>"0",
    	                                        "remain" => "0",
    	                                        "sales" => "0",
    	                                        "committed" => "0");
    	                                        
    	 ${$row["item_code"]}["sales"]  = $row["quantity"];
    	
    	switch ($row["ship_month"]) 
    	        {
    		case 1: ${$row["item_code"]}["jan"]  = $row["quantity"];
    	        	${$row["item_code"]}["janc"]  = $row["quantity"] * $cost;
    		        break;
    	        case 2: ${$row["item_code"]}["feb"]  = $row["quantity"];
    	                ${$row["item_code"]}["febc"]  = $row["quantity"] * $cost;    	        
    		        break;
    		case 3: ${$row["item_code"]}["mar"]  = $row["quantity"];
    		        ${$row["item_code"]}["febc"]  = $row["quantity"] * $cost;
    		        break;
    		case 4: ${$row["item_code"]}["apr"]  = $row["quantity"];
    		        ${$row["item_code"]}["aprc"]  = $row["quantity"] * $cost;
    		        break;
    		case 5: ${$row["item_code"]}["may"]  = $row["quantity"];
    		        ${$row["item_code"]}["mayc"]  = $row["quantity"] * $cost;
    		        break;
    		case 6: ${$row["item_code"]}["jun"]  = $row["quantity"];
    		        ${$row["item_code"]}["junc"]  = $row["quantity"] * $cost;
    		        break;
    		case 7: ${$row["item_code"]}["jul"]  = $row["quantity"];
    		        ${$row["item_code"]}["julc"]  = $row["quantity"] * $cost;
    		        break;
    		case 8: ${$row["item_code"]}["aug"]  = $row["quantity"];
    		        ${$row["item_code"]}["augc"]  = $row["quantity"] * $cost;
    		        break;
    		case 9: ${$row["item_code"]}["sep"]  = $row["quantity"];
    		        ${$row["item_code"]}["sepc"]  = $row["quantity"] * $cost;
    		        break;
    		case 10: ${$row["item_code"]}["oct"]  = $row["quantity"];
    		${$row["item_code"]}["octc"]  = $row["quantity"] * $cost;
    		        break;
    		case 11: ${$row["item_code"]}["nov"]  = $row["quantity"];
    		         ${$row["item_code"]}["novc"]  = $row["quantity"] * $cost;
    		        break;
    		case 12: ${$row["item_code"]}["dec"]  = $row["quantity"];
    	         	${$row["item_code"]}["decc"]  = $row["quantity"] * $cost;
    		        break;   
    		}                                                     
    		        
    		      
    	  	
 
   } 	
   
   
}  # end of loop
 

/*
      foreach($COP as $key => $value) {
      
        print " $key: $value ";
        echo " had sales of ".${$value}["sales"]."<br>";	
      	
}

*/
  
  echo '<h4>By Quantity </h4>';
  
  echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
  $second_half .= " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
//echo '<tr><th align=center><font size=2 color=blue>Description</font></th>';
echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Item</font></th>';
 $second_half .=  '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Item</font></th>';

echo '<th align=center><font size=2 color=blue>Total</font></th>';
 $second_half .=  '<th align=center><font size=2 color=blue>Total</font></th>';
echo '<th align=center><font size=2 color=blue>Jan</font></th>';
 $second_half .=  '<th align=center><font size=2 color=blue>Jan</font></th>';
echo '<th align=center><font size=2 color=blue>Feb</font></th>';
 $second_half .=   '<th align=center><font size=2 color=blue>Feb</font></th>';
echo '<th align=center><font size=2 color=blue>Mar</font></th>';
 $second_half .=  '<th align=center><font size=2 color=blue>Mar</font></th>';
echo '<th align=center><font size=2 color=blue>Apr</font></th>';
 $second_half .= '<th align=center><font size=2 color=blue>Apr</font></th>';
echo '<th align=center><font size=2 color=blue>May</font></th>';
 $second_half .=  '<th align=center><font size=2 color=blue>May</font></th>';
echo '<th align=center><font size=2 color=blue>Jun</font></th>';
 $second_half .= '<th align=center><font size=2 color=blue>Jun</font></th>';
echo '<th align=center><font size=2 color=blue>Jul</font></th>';
 $second_half .=  '<th align=center><font size=2 color=blue>Jul</font></th>';
echo '<th align=center><font size=2 color=blue>Aug</font></th>';
 $second_half .=   '<th align=center><font size=2 color=blue>Aug</font></th>';
echo '<th align=center><font size=2 color=blue>Sep</font></th>';
 $second_half .=   '<th align=center><font size=2 color=blue>Sep</font></th>';
echo '<th align=center><font size=2 color=blue>Oct</font></th>';
 $second_half .=  '<th align=center><font size=2 color=blue>Oct</font></th>';
echo '<th align=center><font size=2 color=blue>Nov</font></th>';
 $second_half .=   '<th align=center><font size=2 color=blue>Nov</font></th>';
echo '<th align=center><font size=2 color=blue>Dec</font></th>';
 $second_half .=   '<th align=center><font size=2 color=blue>Dec</font></th>';
echo '</tr>';
 $second_half .=   '</tr>';

 
    sort($item_code_array);
    
    
    foreach($item_code_array as $key => $value) {
  
       $cost = ${$value}[cost];
    
       $item_quantity = ${$value}[jan] +  
                       ${$value}[feb] + 
                       ${$value}[mar] +
                       ${$value}[apr] +
                       ${$value}[may] +
                       ${$value}[jun] +
                       ${$value}[jul] +
                       ${$value}[aug] +
                       ${$value}[sep] +
                       ${$value}[oct] +
                       ${$value}[nov] +
                       ${$value}[dec];    
                       
              $item_quantity_c = ${$value}[janc] +  
                       ${$value}[febc] + 
                       ${$value}[marc] +
                       ${$value}[aprc] +
                       ${$value}[mayc] +
                       ${$value}[junc] +
                       ${$value}[julc] +
                       ${$value}[augc] +
                       ${$value}[sepc] +
                       ${$value}[octc] +
                       ${$value}[novc] +
                       ${$value}[decc];                  
                       
                       
  #     $remaining=  $total - $item_quantity;
  #    $remaining_total=$remaining_total+$remaining;
      
      
  
      $month01_total +=   ${$value}[jan];
      $month02_total +=   ${$value}[feb];
      $month03_total +=   ${$value}[mar];
      $month04_total +=  ${$value}[apr];
      $month05_total +=  ${$value}[may];
      $month06_total +=  ${$value}[jun];
      $month07_total +=  ${$value}[jul];
      $month08_total +=  ${$value}[aug];
      $month09_total +=  ${$value}[sep];
      $month10_total +=  ${$value}[oct];
      $month11_total +=  ${$value}[nov];
      $month12_total +=  ${$value}[dec];
      
      
      $month01_total_c +=   ${$value}[janc];
      $month02_total_c +=   ${$value}[febc];
      $month03_total_c +=   ${$value}[marc];
      $month04_total_c +=  ${$value}[aprc];
      $month05_total_c +=  ${$value}[mayc];
      $month06_total_c +=  ${$value}[junc];
      $month07_total_c +=  ${$value}[julc];
      $month08_total_c +=  ${$value}[augc];
      $month09_total_c +=  ${$value}[sepc];
      $month10_total_c +=  ${$value}[octc];
      $month11_total_c +=  ${$value}[novc];
      $month12_total_c +=  ${$value}[decc];
      
      
      $total_total += ${$value}[jan] +
                      ${$value}[feb] +
                      ${$value}[mar] +
                      ${$value}[apr] +
                      ${$value}[may] +
                      ${$value}[jun] +
                      ${$value}[jul] +
                      ${$value}[aug] +
                      ${$value}[sep] +
                      ${$value}[oct] +
                      ${$value}[nov] +
                      ${$value}[dec];
                      
     $total_total_c += ${$value}[janc] +
                      ${$value}[febc] +
                      ${$value}[marc] +
                      ${$value}[aprc] +
                      ${$value}[mayc] +
                      ${$value}[junc] +
                      ${$value}[julc] +
                      ${$value}[augc] +
                      ${$value}[sepc] +
                      ${$value}[octc] +
                      ${$value}[novc] +
                      ${$value}[decc];

      
   
      
            # now print the row !
      #      number_format($value);

      echo '<tr><td align=center>'.$value.'</td>';
      $second_half .=  '<tr><td align=center>'.$value.'</td>';
      echo "<td align=right>&nbsp; $item_quantity </td>";
      $second_half .=  "<td align=right>&nbsp; $item_quantity_c </td>";
      echo "<td align=right>".number_format(${$value}[jan])."</td>";
      $second_half .=  "<td align=right>".number_format(${$value}[janc])."</td>";
      echo "<td align=right>".number_format(${$value}[feb])."</td>";
      $second_half .=   "<td align=right>".number_format(${$value}[febc])."</td>";
      echo "<td align=right>".number_format(${$value}[mar])."</td>";
      $second_half .=  "<td align=right>".number_format(${$value}[marc])."</td>";
      echo "<td align=right>".number_format(${$value}[apr])."</td>";
      $second_half .=   "<td align=right>".number_format(${$value}[aprc])."</td>";
      echo "<td align=right>".number_format(${$value}[may])."</td>";
      $second_half .=  "<td align=right>".number_format(${$value}[mayc])."</td>";
      echo "<td align=right>".number_format(${$value}[jun])."</td>";
      $second_half .=  "<td align=right>".number_format(${$value}[junc])."</td>";
      echo "<td align=right>".number_format(${$value}[jul])."</td>";
      $second_half .=  "<td align=right>".number_format(${$value}[julc])."</td>";
      echo "<td align=right>".number_format(${$value}[aug])."</td>";
      $second_half .=   "<td align=right>".number_format(${$value}[augc])."</td>";
      echo "<td align=right>".number_format(${$value}[sep])."</td>";
      $second_half .=   "<td align=right>".number_format(${$value}[sepc])."</td>";
      echo "<td align=right>".number_format(${$value}[oct])."</td>";
      $second_half .=  "<td align=right>".number_format(${$value}[octc])."</td>";
      echo "<td align=right>".number_format(${$value}[nov])."</td>";
      $second_half .=   "<td align=right>".number_format(${$value}[novc])."</td>";
      echo "<td align=right>".number_format(${$value}[dec])."</td>";
      $second_half .=  "<td align=right>".number_format(${$value}[decc])."</td>";
   #   $remaining = 0;
      echo "</tr>";
      $second_half .=  "</tr>";

    	
#   print " $key: $value ";
#   echo " had sales of ".${$value}["sales"]."<br>";
   
   
}
    
 
  echo '<tr bgcolor=palegreen><td align=center><font color=blue>Totals:</font></td>';
  $second_half .= '<tr bgcolor=palegreen><td align=center><font color=blue>Totals:</font></td>';
  echo '<td align=right><font color=blue>'.number_format($total_total).'</font></td>';
  $second_half .= '<td align=right><font color=blue>'.number_format($total_total_c).'</font></td>';
  echo "<td align=right><font color=blue>$month01_total</font></td>";
  $second_half .=  "<td align=right><font color=blue>".number_format($month01_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month02_total)."</font></td>";
  $second_half .= "<td align=right><font color=blue>".number_format($month02_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month03_total)."</font></td>";
  $second_half .=  "<td align=right><font color=blue>".number_format($month03_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month04_total)."</font></td>";
  $second_half .= "<td align=right><font color=blue>".number_format($month04_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month05_total)."</font></td>";
  $second_half .=  "<td align=right><font color=blue>".number_format($month05_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month06_total)."</font></td>";
  $second_half .=  "<td align=right><font color=blue>".number_format($month06_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month07_total)."</font></td>";
  $second_half .= "<td align=right><font color=blue>".number_format($month07_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month08_total)."</font></td>";
  $second_half .=  "<td align=right><font color=blue>".number_format($month08_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month09_total)."</font></td>";
  $second_half .=  "<td align=right><font color=blue>".number_format($month09_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month10_total)."</font></td>";
  $second_half .= "<td align=right><font color=blue>".number_format($month10_total_c)."</font></td>";
  echo "<td align=right><font color=blue>".number_format($month11_total)."</font></td>";
  $second_half .=  "<td align=right><font color=blue>".number_format($month11_total_c)."</font></td>";
  echo  "<td align=right><font color=blue>".number_format($month12_total)."</font></td>";
  $second_half .=  "<td align=right><font color=blue>".number_format($month12_total_c)."</font></td>";
 

  echo '</table>';
  $second_half .=  '</table>';

 
echo "<p>";
echo '<h4>By Cost </h4>';
echo $second_half;
 
echo '</form>';

?>