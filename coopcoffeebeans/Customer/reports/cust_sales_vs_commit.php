<?php

//********************************Start UP Sessions*******************************
//
//******************************Get the Includes**********************************
require("../../functions.php");
require("../../tables.php");

session_start();
// Check Security
require("../../check_login.php");
// check session variable

$contact_id = $_SESSION['contact_id'];
 

	echo'<html>';

	echo'<head>';
  	echo'<title>Sales vs. Commited</title>';
 //   echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	//echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
 

        
       echo '<table width=100%><tr  bgcolor=palegreen>';
    # 	echo '<td><font size=3 color=blue>You are logged in as '.$_SESSION['valid_user'].'</font></td>';
      echo '<td><font size=3><a href="../../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
      echo '</td><td align=center>';
      echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';       
        
// create short variable names
# this field will need to come from login screen.
  $company=$_SESSION['valid_user'];
  $current_id=$_REQUEST['current_id'];


# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

//***********************************************************************************
//								Take Care of Your Variables
//***********************************************************************************



$company=$_REQUEST['Company_Name'];
$company=stripslashes($company);


//***********************************************************************************
//							Start The Form
//***********************************************************************************

echo '<form method=POST action=cust_sales_vs_commit.php>';



//***************Echo out todays date for the Report***********************


//***************Build the Customer List (from functions)******************
//   customerdropdown($company);
$company=$_SESSION['valid_user'];
//*************Build Date Drop Down******************************************
//**Adding dates to dropdown here must add dates to if statements below******
$year_range = $current_year;
if (isset($_REQUEST['year_range'])) {
   $year_range=$_REQUEST['year_range'];
    
}

#  echo '<br><font size=3 color=blue>Select a date range</font><br>';
$date_range = $year_list;
echo "<table width=100% border=0  ><tr><td width=50% align=left>";
echo "\n";
echo '<select name=year_range>';
echo "\n";
for ($i=0; $i < count($date_range);  $i++)
  {
    echo "<option value=$date_range[$i] ";
    if ($year_range == $date_range[$i]) {
       echo ' selected ';
    }

    echo "> $date_range[$i]";

    echo "\n";
  }

 echo '</select>&nbsp;&nbsp;&nbsp;&nbsp;';


//***************Display the Form Buttons for Selection*******************************
	  echo '<input type="SUBMIT" name="ACTION" value="View">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo "</td><td width=50%  align=right>";
	echo '<font size=3 color=blue><Bold>Report Date: </bold></font>';
	echo date("l d  F Y");
	# echo '<br>';
  echo "</td></tr></table>";
//************************************************************************************
//************************************************************************************
//								Standard View By Company
//************************************************************************************
//************************************************************************************
#if ($_REQUEST['ACTION'] == 'View')
#{

//**************************Assign ranges to date for searching*********************
$from_date = $year_range.'-01-01';
$to_date = $year_range.'-12-31';


#echo '<br>';
echo '<font size=5 color=blue><center>Sales Vs. Commitments</center></font><br>';
echo '<font size=3 color=blue>Commitment Summary for:</font>'.$company;
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: </font>';
echo date("m / d / y");
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Range: </font>';
echo $from_date.' to '.$to_date;
echo  '<br>';

$query = "SELECT * FROM $tbl_item_description order by item_code";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);

echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";
echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Description</font></th>';
echo '<th align=center><font size=2 color=blue>Item Code</font></th>';
echo '<th align=center><font size=2 color=blue>Commitment</font></th>';
echo '<th align=center><font size=2 color=blue>Sales To Date</font></th>';
echo '<th align=center><font size=2 color=blue>Remaining Bags</font></th></tr>';
$commitment_total=0;
$item_quantity_total=0;
$remaining_total=0;


for ($i=0; $i <$num_results;  $i++)
  {
$row = mysql_fetch_array($result);

$item_code=$row['item_code'];

//*****************Make the commitment Subquery****************************
$subquery = "SELECT com.*, cc.Company 
            FROM $tbl_coop_commited com, $tbl_coop_contact cc 
            WHERE com.customer_key=cc.contact_id 
            and cc.Company='$company' and com.item_code = '$item_code' and com.import_yr='$year_range'";
            
            
$subresult = mysql_query($subquery, $db_conn);
$subrow = mysql_fetch_array($subresult);
$commitment=0;
$commitment=$subrow['py']+$subrow['month01']+$subrow['month02']+$subrow['month03']+$subrow['month04']+$subrow['month05']+$subrow['month06']+$subrow['month07']+$subrow['month08']+$subrow['month09']+$subrow['month10']+$subrow['month11']+$subrow['month12'];

//**************If there are commitments then display the INFO**************
If ($commitment!=0)
{
echo "<tr><td>".$row['item_description']."</td>";
echo "<td>".$row['item_code']."</td>";
echo "<td>".$commitment."</td>";
$commitment_total=$commitment_total+$commitment;

//****We Need a subloop here to count the bags of coffee sold for each product******
//****************************Make the subquery*************************************

$subquery = "SELECT oh.customer_key, oh.header_id, oi.item_code, li.quantity, cc.Company
 FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li
       WHERE oh.header_id = oi.header_key
       AND oh.customer_key = cc.contact_id
       AND cc.Company = '$company'
       AND oi.item_code = '$item_code'
       AND oi.item_id = li.item_id
       and oh.order_date Between '$from_date' and '$to_date'";

$subresult = mysql_query($subquery, $db_conn);
$subnum_results = mysql_num_rows($subresult);
$item_quantity=0;
for ($b=0; $b <$subnum_results;  $b++)
{
$subrow = mysql_fetch_array($subresult);
$item_quantity=$item_quantity + $subrow['quantity'];
}

//*******Display the results and add to the totals**********************************
echo "<td>".$item_quantity."</td>";
$item_quantity_total=$item_quantity_total+$item_quantity;
$remaining=$commitment - $item_quantity;
echo "<td>".$remaining."</td>";
$remaining_total=$remaining_total+$remaining;
}

}
//**************Display the Totals**************************************************
echo '<tr bgcolor=palegreen><td></td>';
echo '<td><font color=blue>Totals:</font></td>';
echo '<td><font color=blue>'.$commitment_total.'</font></td>';
echo '<td><font color=blue>'.$item_quantity_total.'</font></td>';
echo '<td><font color=blue>'.$remaining_total.'</font></td>';
echo '</table>';

# }



echo '</form>';
?>