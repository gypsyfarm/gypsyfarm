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



      echo '<form method=POST action=cust_sales_plus_report.php>';

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
}
else {
    $import_yr=$_REQUEST['year_range'];

}
 
echo '<table width=100%><tr><td align=left>';


  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

 if ($_SESSION['user_type'] == 2) {
 
     $company=$_REQUEST['Company_Name'];
    $company=stripslashes($company);
//$company=stripslashes($company);
//echo'The company name is '.$company;

if (!ISSET($_REQUEST['Company_Name'])) {
	$company = 'Cafe Campesino';
}
 
 	
     mysql_select_db('coop_contact');
      $query = "select contact_id from $tbl_coop_contact where Company = '".$company."'";
        $result = mysql_query($query, $db_conn);

         # echo "<br>$query <br>";

        $num_results = mysql_num_rows($result);

        if ($num_results > 0) {
           $row = mysql_fetch_array($result);
           $customer_key=$row['contact_id'];
         }
	
	  echo '<font size=3 color=blue>Select a Company</font><br>';
	  customerdropdown($company);
}
else {
     $customer_key = $_SESSION['contact_id'];
     $company = $_SESSION['valid_user'];
}

 


echo '<br><font size=3 color=blue>Select a date range</font>';
$date_range =  $year_list;
//  array( '2002','2003','2004','2005','2006');

echo "\n";
echo '<select name=year_range>';
echo "\n";
//for ($i=0; $i < 5;  $i++)
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
echo '<h3>Monthly Sales Report </h3>';
echo "($company)";


echo '</td><td align=right>';
                  echo '¤ ';
            $current_date = date('Y-m-d H:i:s');
            echo date('H:i, jS F');
            
echo '</td></tr></table>';            



 $year_range=$_REQUEST['year_range'];



//**************************Assign ranges to date for searching*********************


$from_date = $year_range.'-01-01';
$to_date = $year_range.'-12-31';


$query = "SELECT oi.item_code, Month(oh.order_date) as order_month, sum(li.quantity) as quantity
              FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li
              WHERE oh.header_id = oi.header_key
              AND oh.customer_key = cc.contact_id
              and oi.item_id = li.item_id
              and oh.order_date Between '$from_date' 
              and '$to_date' 
              and oh.customer_key = $customer_key
              and oh.STATUS <> 'I'
              group by oi.item_code, Month(oh.order_date)
              order by oi.item_code, Month(oh.order_date)";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);

#echo "<br>$query<br>";

 $item_code_array = array();
for ($i=0; $i <$num_results;  $i++)  {
    $row = mysql_fetch_array($result);
 
    if ( !$item_code_array[$row["item_code"]]);
        $item_code_array[$row["item_code"]] = $row["item_code"];
        
        
    if (${$row["item_code"]}) {
    	 ${$row["item_code"]}["sales"]  += $row["quantity"];

    	switch ($row["order_month"]) 
    	        {
    		case 1: ${$row["item_code"]}["jan"]  += $row["quantity"];
    		        break;
    	        case 2: ${$row["item_code"]}["feb"]  += $row["quantity"];
    		        break;
    		case 3: ${$row["item_code"]}["mar"]  += $row["quantity"];
    		        break;
    		case 4: ${$row["item_code"]}["apr"]  += $row["quantity"];
    		        break;
    		case 5: ${$row["item_code"]}["may"]  += $row["quantity"];
    		        break;
    		case 6: ${$row["item_code"]}["jun"]  += $row["quantity"];
    		        break;
    		case 7: ${$row["item_code"]}["jul"]  += $row["quantity"];
    		        break;
    		case 8: ${$row["item_code"]}["aug"]  += $row["quantity"];
    		        break;
    		case 9: ${$row["item_code"]}["sep"]  += $row["quantity"];
    		        break;
    		case 10: ${$row["item_code"]}["oct"]  += $row["quantity"];
    		        break;
    		case 11: ${$row["item_code"]}["nov"]  += $row["quantity"];
    		        break;
    		case 12: ${$row["item_code"]}["dec"]  += $row["quantity"];
    		        break;   
    		}  
    	 
 
 	
}
    else {
    	 ${$row["item_code"]} = array("code" => $row["item_code"],
    	                                        "jan" =>"0", 
    	                                        "feb" =>"0", 
    	                                        "mar" =>"0", 
    	                                        "apr" =>"0", 
    	                                        "may" =>"0", 
    	                                        "jun" =>"0", 
    	                                        "jul" =>"0", 
    	                                        "aug" =>"0", 
    	                                        "sep" =>"0", 
    	                                        "oct" =>"0", 
    	                                        "nov" =>"0", 
    	                                        "dec" =>"0",
    	                                        "remain" => "0",
    	                                        "sales" => "0",
    	                                        "committed" => "0");
    	                                        
    	 ${$row["item_code"]}["sales"]  = $row["quantity"];

    	
    	switch ($row["order_month"]) 
    	        {
    		case 1: ${$row["item_code"]}["jan"]  = $row["quantity"];
    		        break;
    	        case 2: ${$row["item_code"]}["feb"]  = $row["quantity"];
    		        break;
    		case 3: ${$row["item_code"]}["mar"]  = $row["quantity"];
    		        break;
    		case 4: ${$row["item_code"]}["apr"]  = $row["quantity"];
    		        break;
    		case 5: ${$row["item_code"]}["may"]  = $row["quantity"];
    		        break;
    		case 6: ${$row["item_code"]}["jun"]  = $row["quantity"];
    		        break;
    		case 7: ${$row["item_code"]}["jul"]  = $row["quantity"];
    		        break;
    		case 8: ${$row["item_code"]}["aug"]  = $row["quantity"];
    		        break;
    		case 9: ${$row["item_code"]}["sep"]  = $row["quantity"];
    		        break;
    		case 10: ${$row["item_code"]}["oct"]  = $row["quantity"];
    		        break;
    		case 11: ${$row["item_code"]}["nov"]  = $row["quantity"];
    		        break;
    		case 12: ${$row["item_code"]}["dec"]  = $row["quantity"];
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
  
  
  echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
//echo '<tr><th align=center><font size=2 color=blue>Description</font></th>';
echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Item</font></th>';
echo '<th align=center><font size=2 color=blue>Remain</font></th>';
echo '<th align=center><font size=2 color=blue>Sales</font></th>';
echo '<th align=center><font size=2 color=blue>Jan</font></th>';
echo '<th align=center><font size=2 color=blue>Feb</font></th>';
echo '<th align=center><font size=2 color=blue>Mar</font></th>';
echo '<th align=center><font size=2 color=blue>Apr</font></th>';
echo '<th align=center><font size=2 color=blue>May</font></th>';
echo '<th align=center><font size=2 color=blue>Jun</font></th>';
echo '<th align=center><font size=2 color=blue>Jul</font></th>';
echo '<th align=center><font size=2 color=blue>Aug</font></th>';
echo '<th align=center><font size=2 color=blue>Sep</font></th>';
echo '<th align=center><font size=2 color=blue>Oct</font></th>';
echo '<th align=center><font size=2 color=blue>Nov</font></th>';
echo '<th align=center><font size=2 color=blue>Dec</font></th>';
echo '</tr>';

    sort($item_code_array);
    foreach($item_code_array as $key => $value) {
  
        $subquery = "select item_code,
                 sum(month01) as month01,
                 sum(month02) as month02,
                 sum(month03) as month03,
                 sum(month04) as month04,
                 sum(month05) as month05,
                 sum(month06) as month06,
                 sum(month07) as month07,
                 sum(month08) as month08,
                 sum(month09) as month09,
                 sum(month10) as month10,
                 sum(month11) as month11,
                 sum(month12) as month12,
                 sum(py) as py        
          from $tbl_coop_commited 
          where  item_code = '$value' 
            and import_yr ='$import_yr' 
            and customer_key = '$customer_key' 
            group by item_code";
 
       $subresult = mysql_query($subquery, $db_conn);
      $subnum_results = mysql_num_rows($subresult);

      $item_quantity=0;
      $total = 0;
      if ($subnum_results > 0) {
         $subrow = mysql_fetch_array($subresult);

         $total = $subrow['month01'] + 
                  $subrow['month02'] + 
                  $subrow['month03'] + 
                  $subrow['month04'] + 
                  $subrow['month05'] + 
                  $subrow['month06'] + 
                  $subrow['month07'] +
                  $subrow['month08'] + 
                  $subrow['month09'] + 
                  $subrow['month10'] + 
                  $subrow['month11'] + 
                  $subrow['month12'] + $subrow['py'];

        }
 
 
 
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
                       
       $remaining=  $total - $item_quantity;
      $remaining_total=$remaining_total+$remaining;
      
      
  
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

      
   
      
            # now print the row !

      echo '<tr><td align=center>'.$value.'</td>';
      echo '<td align=right>'.$remaining.'</td>';
      echo "<td align=right>&nbsp; $item_quantity</td>";
      echo "<td align=right>".${$value}[jan]."</td>";
      echo "<td align=right>".${$value}[feb]."</td>";
      echo "<td align=right>".${$value}[mar]."</td>";
      echo "<td align=right>".${$value}[apr]."</td>";
      echo "<td align=right>".${$value}[may]."</td>";
      echo "<td align=right>".${$value}[jun]."</td>";
      echo "<td align=right>".${$value}[jul]."</td>";
      echo "<td align=right>".${$value}[aug]."</td>";
      echo "<td align=right>".${$value}[sep]."</td>";
      echo "<td align=right>".${$value}[oct]."</td>";
      echo "<td align=right>".${$value}[nov]."</td>";
      echo "<td align=right>".${$value}[dec]."</td>";
      $remaining = 0;
      echo "</tr>";

    	
#   print " $key: $value ";
#   echo " had sales of ".${$value}["sales"]."<br>";
   
   
   
}
    
 
  # now lets see if there are any commitments but no sales
 
 $query = "SELECT item_code
              FROM $tbl_coop_commited cc 
              WHERE cc.customer_key = '$customer_key'
              AND cc.import_yr = '$import_yr'
              group by item_code
              order by item_code";
              
          
 $result = mysql_query($query, $db_conn);             
 $num_results = mysql_num_rows($result);
 $heading = 0;
 for ($i=0; $i <$num_results;  $i++)  {
  
  
      $row = mysql_fetch_array($result);
           
   if (!in_array($row["item_code"],$item_code_array)) {
  	if ($heading == 0) {
          $heading = 1;
          echo '<tr bgcolor=palegreen><td align=left colspan=15><font color=blue>Commitments with No Sales:</font></td></tr>';  	
  	} 
  	 $item_code = $row["item_code"]; 
         $subquery = "select item_code,
                 sum(month01) as month01,
                 sum(month02) as month02,
                 sum(month03) as month03,
                 sum(month04) as month04,
                 sum(month05) as month05,
                 sum(month06) as month06,
                 sum(month07) as month07,
                 sum(month08) as month08,
                 sum(month09) as month09,
                 sum(month10) as month10,
                 sum(month11) as month11,
                 sum(month12) as month12,
                 sum(py) as py        
          from $tbl_coop_commited 
          where  item_code = '$item_code' 
            and import_yr ='$import_yr' 
            and customer_key = '$customer_key' 
            group by item_code";
 
      $subresult = mysql_query($subquery, $db_conn);
      
      $subnum_results = mysql_num_rows($subresult);

      $item_quantity=0;
      $remaining = 0;
      if ($subnum_results > 0) {
         $subrow = mysql_fetch_array($subresult);

         $remaining = $subrow['month01'] + 
                  $subrow['month02'] + 
                  $subrow['month03'] + 
                  $subrow['month04'] + 
                  $subrow['month05'] + 
                  $subrow['month06'] + 
                  $subrow['month07'] +
                  $subrow['month08'] + 
                  $subrow['month09'] + 
                  $subrow['month10'] + 
                  $subrow['month11'] + 
                  $subrow['month12'] + $subrow['py'];

      } 
      
      
      echo '<tr><td align=center>'.$item_code.'</td>';
      echo "<td align=right>$remaining</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "<td align=right>0</td>";
      echo "</tr>";	
  	
  	
  	$remaining_total += $remaining;
  	
   }	


}
 
 
  echo '<tr bgcolor=palegreen><td align=center><font color=blue>Totals:</font></td>';
  echo '<td align=right><font color=blue>'.$remaining_total.'</font></td>';
  echo '<td align=right><font color=blue>'.$total_total.'</font></td>';
  echo "<td align=right><font color=blue>$month01_total</font></td>";
  echo "<td align=right><font color=blue>$month02_total</font></td>";
  echo "<td align=right><font color=blue>$month03_total</font></td>";
  echo "<td align=right><font color=blue>$month04_total</font></td>";
  echo "<td align=right><font color=blue>$month05_total</font></td>";
  echo "<td align=right><font color=blue>$month06_total</font></td>";
  echo "<td align=right><font color=blue>$month07_total</font></td>";
  echo "<td align=right><font color=blue>$month08_total</font></td>";
  echo "<td align=right><font color=blue>$month09_total</font></td>";
  echo "<td align=right><font color=blue>$month10_total</font></td>";
  echo "<td align=right><font color=blue>$month11_total</font></td>";
  echo "<td align=right><font color=blue>$month12_total</font></td></tr>";


  echo '</table>';

 

 
echo '</form>';

?>