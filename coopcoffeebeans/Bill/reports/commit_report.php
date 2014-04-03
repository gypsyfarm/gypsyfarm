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
  	echo'<title>Commitments Report</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';


//The command below tells if magic quotes is on or off a returned value of 1 means on a 0 means off
//if magic quotes is on, all characters that need escaping post variables automatically get escaped.
//The trick is to strip slashes after the post variable is assigned to a regular variable
//ideally this would be done dynamically but for now

//echo get_magic_quotes_gpc();


$current_id=$_REQUEST['current_id'];


# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }



      echo '<form method=POST action=commit_report.php>';

# was here
#  far right cell 


      echo '<table width=100%><tr bgcolor=palegree><td>';
      echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
      echo '</td><td align=center>';
      echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';
  
  
 
 


//*************Build Date Drop Down******************************************
//**Adding dates to dropdown here must add dates to if statements below******



   
 

if (!isset($_REQUEST['year_range'])) {
$_REQUEST['year_range']= $current_year;

}
$import_yr=$_REQUEST['year_range'];

echo '<table width=100%><tr><td align=left>';

echo '<br><font size=3 color=blue>Select a date range</font>';
# $date_range = array( '2002','2003','2004','2005','2006','2007','2008');
$date_range = $year_list_extended;

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

 echo '</select>';
 echo "\n";
 
  //*******************Display the Warehouse dropdown box************************
#	 $warehouse=$_REQUEST['warehouse'];
	 
        if ($_REQUEST['warehouse']) {
           $warehouse=$_REQUEST['warehouse'];
        }
        else {
           $warehouse = '%';
        }
         	

	echo '<font size=3 color=blue>Select a Warehouse</font>';
	
report_warehousedropdown($warehouse);
 
echo "\n";
 

echo "&nbsp;&nbsp;";
echo '<input type="SUBMIT" name="ACTION" class=button value="View">';



echo '</td><td align=center>';
echo '<h3>All Customer Commitment Report </h3>';


echo '</td><td align=right>';
                  echo '¤ ';
            $current_date = date('Y-m-d H:i:s');
            echo date('H:i, jS F');
            
echo '</td></tr></table>';            


 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
 
 

 
  
if (isset($_REQUEST['year_range'])) {
   $year_range=$_REQUEST['year_range'];    
}
else {
   $year_range = "2008"; 
}



//**************************Assign ranges to date for searching*********************

/*


if ($year_range=='2002') {
     $from_date='2002-01-01';
     $to_date='2002-12-31';
}

if ($year_range=='2003') {
    $from_date='2003-01-01';
    $to_date='2003-03-31';
}

if ($year_range=='2004') {
    $from_date='2004-01-01';
    $to_date='2004-12-31';
}

if ($year_range=='2005') {
    $from_date='2005-01-01';
    $to_date='2005-12-31';
}


if ($year_range=='2006') {
    $from_date='2006-01-01';
    $to_date='2006-12-31';
}


if ($year_range=='2007') {
    $from_date='2007-01-01';
    $to_date='2007-12-31';
}

if ($year_range=='2008') {
    $from_date='2008-01-01';
    $to_date='2008-12-31';
}

if ($year_range=='2009') {
    $from_date='2009-01-01';
    $to_date='2009-12-31';
}


*/
$from_date = $year_range.'-01-01';
$to_date = $year_range.'-12-31';
 $sales_ytd_total = 0;
 $remaining_total = 0;

mysql_select_db($tbl_coop_commited);

#$query = "select * 
#             from $tbl_coop_commited 
#            where  import_yr = '$year_range' order by item_code";

 ;
if ($warehouse == "%"){
 $warehouse_sql = " ";
}
else { 
   $warehouse_sql = " and cc.fob_code = '$warehouse' ";
}
   

$query = "select item_code,
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
          from $tbl_coop_commited c, $tbl_coop_contact cc 
          where  import_yr ='$year_range'
            and c.customer_key = cc.contact_id 
           $warehouse_sql 
           group by item_code 
          order by item_code";
          



#echo "<br>query  = $query <br>";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);




echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
//echo '<tr><th align=center><font size=2 color=blue>Description</font></th>';
echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Item</font></th>';
echo '<th align=center><font size=2 color=blue>Sales YTD</font></th>';
echo '<th align=center><font size=2 color=blue>Remain</font></th>';
echo '<th align=center><font size=2 color=blue>Commitment</font></th>';
echo '<th align=center><font size=2 color=blue>PY</font></th>';
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


for ($i=0; $i <$num_results;  $i++)
  {
  $row = mysql_fetch_array($result);
  $total = $row['month01'] + $row['month02'] + $row['month03'] + $row['month04'] +$row['month05'] +$row['month06'] +$row['month07'] +$row['month08'] + $row['month09'] + $row['month10'] + $row['month11'] + $row['month12'];
$month01_total=$month01_total + $row['month01'];
$month02_total=$month02_total + $row['month02'];
$month03_total=$month03_total + $row['month03'];
$month04_total=$month04_total + $row['month04'];
$month05_total=$month05_total + $row['month05'];
$month06_total=$month06_total + $row['month06'];
$month07_total=$month07_total + $row['month07'];
$month08_total=$month08_total + $row['month08'];
$month09_total=$month09_total + $row['month09'];
$month10_total=$month10_total + $row['month10'];
$month11_total=$month11_total + $row['month11'];
$month12_total=$month12_total + $row['month12'];
$py_total=$py_total+$row['py'];


$item_code=$row['item_code'];

$total_total = $total_total + $total +$row['py'];


//*********************************************************************************
//   We Need a subloop here to count the bags of coffee sold for each product
//****************************Make the subquery*************************************

$subquery = "SELECT sum(li.quantity) as quantity
              FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li
              WHERE oh.header_id = oi.header_key
              AND oh.customer_key = cc.contact_id
              AND oi.item_code = '$item_code'
              and oi.item_id = li.item_id
              $warehouse_sql
              and oh.order_date Between '$from_date' and '$to_date' ";

$subresult = mysql_query($subquery, $db_conn);
$subnum_results = mysql_num_rows($subresult);
$item_quantity=0;



#for ($b=0; $b <$subnum_results;  $b++)
if ($subnum_results > 0) {
$subrow = mysql_fetch_array($subresult);
$item_quantity=$subrow['quantity'];
}
 
 $total = $total + $row['py'];
$remaining=$total-$item_quantity;
$remaining_total=$remaining_total+$remaining;



 echo '<tr><td align=center>'.$row['item_code'].'</td>';
 $sales_ytd = $total - $remaining;
 $sales_ytd_total += $sales_ytd;
 echo '<td align=right>'.$sales_ytd.'</td>';

 echo '<td align=right>'.$remaining.'</td>';
 echo "<td align=right>&nbsp;$total</td>";
 
 echo "<td align=right>".$row['py']."</td>";
 echo "<td align=right>".$row['month01']."</td>";
 echo "<td align=right>".$row['month02']."</td>";
 echo "<td align=right>".$row['month03']."</td>";
 echo "<td align=right>".$row['month04']."</td>";
 echo "<td align=right>".$row['month05']."</td>";
 echo "<td align=right>".$row['month06']."</td>";
 echo "<td align=right>".$row['month07']."</td>";
 echo "<td align=right>".$row['month08']."</td>";
 echo "<td align=right>".$row['month09']."</td>";
 echo "<td align=right>".$row['month10']."</td>";
 echo "<td align=right>".$row['month11']."</td>";
 echo "<td align=right>".$row['month12']."</td>";



 echo "</tr>";
  }
# end for loop.  

  echo '<tr bgcolor=palegreen><td align=center><font color=blue>Totals:</font></td>';
  echo '<td align=right><font color=blue>'.$sales_ytd_total.'</font></td>';
  echo '<td align=right><font color=blue>'.$remaining_total.'</font></td>';
  echo '<td align=right><font color=blue>'.$total_total.'</font></td>';
  echo '<td align=right><font color=blue>'.$py_total.'&nbsp;</font></td>';
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