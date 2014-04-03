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
  	echo'<title>Sales Report</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';


//The command below tells if magic quotes is on or off a returned value of 1 means on a 0 means off
//if magic quotes is on, all characters that need escaping post variables automatically get escaped.
//The trick is to strip slashes after the post variable is assigned to a regular variable
//ideally this would be done dynamically but for now

//echo get_magic_quotes_gpc();

$company=$_REQUEST['Company_Name'];
$company=stripslashes($company);
//echo'The company name is '.$company;


$current_id=$_REQUEST['current_id'];


# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }



      echo '<form method=POST action=sales_report.php>';

# was here
#  far right cell 



      echo '<table width=100%><tr bgcolor=palegreen><td>';
      echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
      echo '</td><td align=center>';
      echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';
  
  
 

echo '<table width=100%><tr><td align=left>';
 # put in replacement date range.
 //************************************************************************************
//                               Start Building the Report
//************************************************************************************
 if ($_REQUEST['To_Year'] == '') {
    $_REQUEST['To_Year']=$current_year;  
  }
  
  if ($_REQUEST['From_Year'] == '') {
    $_REQUEST['From_Year']=$current_year;  
  }
  if ($_REQUEST['To_Day'] == '') {
    $_REQUEST['To_Day']=31;  
  }
  if ($_REQUEST['From_Day'] == '') {
    $_REQUEST['From_Day']=01;  
  }
    if ($_REQUEST['To_Month'] == '') {
    $_REQUEST['To_Month']=12;  
  }
  if ($_REQUEST['From_Month'] == '') {
    $_REQUEST['From_Month']=01;  
  }

 
 //***************************Create the Date Drop Downs from Functions****************

	  echo '<font size=3 color=blue><Bold>Choose a Date Range</bold></font><br>';
	  echo 'Starting Month';

      $from_month=$_REQUEST['From_Month'];
	  from_monthdropdown($from_month);
	  
	  	  echo 'Day: ';

      $from_day=$_REQUEST['From_Day'];
	  from_daydropdown($from_day);

      echo 'Year: ';

	  $from_year=$_REQUEST['From_Year'];
	  from_yeardropdown($from_year);


	  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	  echo 'Ending Month: ';

	  $to_month=$_REQUEST['To_Month'];
	  to_monthdropdown($to_month);
	  
	  echo 'Day: ';

	  $to_day=$_REQUEST['To_Day'];
	  to_daydropdown($to_day);

	  echo 'Year: ';

	  $to_year=$_REQUEST['To_Year'];
	  to_yeardropdown($to_year);

#	  echo '<br>';

          $ft_option_sql = "";
          $ft_option = $_REQUEST['ft_option'];
          echo ' FT Option: ';
          echo '<select name="ft_option">';
          
          if ($ft_option == "All") {
             echo '<option value="All" selected>All';
        }
          else {
             echo '<option value="All">All'; }
             
           if ($ft_option == "Yes") {
                echo '<option value="Yes"  selected>Yes';
                $ft_option_sql = " and cc.FTTrack = 'Y' ";
        }
           else  {
               echo '<option value="Yes">Yes'; }
               
           if ($ft_option == "No") {
           	echo '<option value="No" selected>No';
           	$ft_option_sql = " and cc.FTTrack <> 'Y' ";
        }
           else    {
               echo '<option value="No">No'; }
               
           echo "</select>";
 

echo '<input type="SUBMIT" name="ACTION" class=button value="View">';



echo '</td><td align=center>';
echo '<h3>Monthly Sales Report </h3>';


echo '</td><td align=right>';
                  echo '¤ ';
            $current_date = date('Y-m-d H:i:s');
            echo date('H:i, jS F');
            
echo '</td></tr></table>';            


 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
 $year_range=$_REQUEST['year_range'];



//**************************Assign ranges to date for searching*********************

#$from_date = $year_range.'-01-01';
#$to_date = $year_range.'-12-31';

#          AND oh.order_date Between \"$from_date\" and \"$to_date\"

//*********************Set the Dates up for the Query Statement***********
$from_date=$from_year.'-'.$from_month.'-'.$from_day;
$to_date=$to_year.'-'.$to_month.'-'.$to_day;


mysql_select_db($tbl_coop_commited);

$query = "SELECT oi.item_code, Month(oh.order_date) as order_month, sum(li.quantity) as quantity
              FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li
              WHERE oh.header_id = oi.header_key
              AND oh.customer_key = cc.contact_id
              $ft_option_sql
              and oi.item_id = li.item_id
              and oh.order_date Between '$from_date' 
              and '$to_date' group by oi.item_code, Month(oh.order_date)
              order by oi.item_code, Month(oh.order_date)";





$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);


# echo "<br>query  = $query <br>";


 
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
$month01_total=0;
$month02_total=0;
$month03_total=0;
$month04_total=0;
$month05_total=0;
$month06_total=0;
$month07_total=0;
$month08_total=0;
$month09_total=0;
$month10_total=0;
$month11_total=0;
$month12_total=0;

$item_quantity=0;

$total_total=0;
$remaining=0;
$reamining_total=0;
$py_total=0;

$sales_by_month = array(0,0,0,0,0,0,0,0,0,0,0,0,0);

if ($num_results > 0 ) {
   $row = mysql_fetch_array($result);
   $previous_item_code = $row["item_code"];
}
 
$alt_sw = 0;
for ($i=0; $i <$num_results;  $i++)  {

   $item_code=$row['item_code'];

   If ($previous_item_code <> $row['item_code'] || $i == ($num_results - 1)) {
   	
      if ($i == ($num_results - 1)) {
      	 $sales_by_month[$row["order_month"]] = $sales_by_month[$row['order_month']] + $row['quantity']; 
      } 	      

      #$from_year  ->  and import_yr ='$import_yr'
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
          where  item_code = '$previous_item_code' 
            and import_yr ='$from_year' 
          group by item_code";
 
      $subresult = mysql_query($subquery, $db_conn);
      $subnum_results = mysql_num_rows($subresult);

      $item_quantity=0;

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




      $item_quantity = $sales_by_month[1] +  
                       $sales_by_month[2] + 
                       $sales_by_month[3] +
                       $sales_by_month[4] +
                       $sales_by_month[5] +
                       $sales_by_month[6] +
                       $sales_by_month[7] +
                       $sales_by_month[8] +
                       $sales_by_month[9] +
                       $sales_by_month[10] +
                       $sales_by_month[11] +
                       $sales_by_month[12]; 
                       
                
                       
                       
      $remaining=  $total - $item_quantity;
      $remaining_total=$remaining_total+$remaining;                       
 
      $month01_total=$month01_total + $sales_by_month[1];
      $month02_total=$month02_total + $sales_by_month[2];
      $month03_total=$month03_total + $sales_by_month[3];
      $month04_total=$month04_total + $sales_by_month[4];
      $month05_total=$month05_total + $sales_by_month[5];
      $month06_total=$month06_total + $sales_by_month[6];
      $month07_total=$month07_total + $sales_by_month[7];
      $month08_total=$month08_total + $sales_by_month[8];
      $month09_total=$month09_total + $sales_by_month[9];
      $month10_total=$month10_total + $sales_by_month[10];
      $month11_total=$month11_total + $sales_by_month[11];
      $month12_total=$month12_total + $sales_by_month[12];
      
      $total_total += $sales_by_month[1];
      $total_total += $sales_by_month[2];
      $total_total += $sales_by_month[3];
      $total_total += $sales_by_month[4];
      $total_total += $sales_by_month[5];
      $total_total += $sales_by_month[6];
      $total_total += $sales_by_month[7];
      $total_total += $sales_by_month[8];
      $total_total += $sales_by_month[9];
      $total_total += $sales_by_month[10];
      $total_total += $sales_by_month[11];
      $total_total += $sales_by_month[12];
 
  
                
      # now print the row !
      if ($alt_sw == 1) {
         echo  "<tr bgcolor=lightgrey>";
         $alt_sw = 0;
         }
      else {
         echo "<tr>";
         $alt_sw = 1;
      }
      echo "<td align=center>".$previous_item_code."</td>";
      echo "<td align=right>".$remaining."</td>";
      echo "<td align=right>&nbsp; $item_quantity</td>";
      echo "<td align=right>".$sales_by_month[1]."</td>";
      echo "<td align=right>".$sales_by_month[2]."</td>";
      echo "<td align=right>".$sales_by_month[3]."</td>";
      echo "<td align=right>".$sales_by_month[4]."</td>";
      echo "<td align=right>".$sales_by_month[5]."</td>";
      echo "<td align=right>".$sales_by_month[6]."</td>";
      echo "<td align=right>".$sales_by_month[7]."</td>";
      echo "<td align=right>".$sales_by_month[8]."</td>";
      echo "<td align=right>".$sales_by_month[9]."</td>";
      echo "<td align=right>".$sales_by_month[10]."</td>";
      echo "<td align=right>".$sales_by_month[11]."</td>";
      echo "<td align=right>".$sales_by_month[12]."</td>";
      echo "</tr>";
      $sales_by_month = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
      $sales_by_month[$row["order_month"]] = $sales_by_month[$row['order_month']] + $row['quantity']; 
      $previous_item_code = $row["item_code"];
      $row = mysql_fetch_array($result);
   } 
 #  elseif ($i != ($num_results - 1)) {
   else  {
      $sales_by_month[$row["order_month"]] = $sales_by_month[$row['order_month']] + $row['quantity']; 
      $previous_item_code = $row["item_code"];  	
      $row = mysql_fetch_array($result);
   }   

    # end if item code changed.
}
# end for loop.  

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