<?php

require("../../functions.php");
require("../../tables.php");
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
  	echo'<title>Transfer Detail</title>'; 
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';


      echo '<table width=100%><tr bgcolor=palegree><td>';
      echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
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



    echo '<form method=POST action=transfer_detail.php>';

	//***************Echo out todays date for the Report***********************
#	echo '<font size=3 color=blue><Bold>Report Date: </bold></font>';
#	echo date("l d of F Y");
#	echo '<br>';

//*******************Display the Warehouse dropdown box************************
	$warehouse=$_REQUEST['warehouse'];
	$search_date=$_REQUEST['search_date'];
	#echo '<font size=3 color=blue>Select a Warehouse</font>';

#    report_warehousedropdown($warehouse);

#	echo '<br>';
#	echo '<font color=blue>YYYY-MM-DD (ex. 2003-06-21)</font>';
#	echo '<input type=text size=10 name=search_date value="'.$search_date.'"><br>';
	echo '<input type="SUBMIT" name="ACTION" value="View">';

	$form_action = $_REQUEST['ACTION'];
	$form_action = 'View';

	if ($form_action == 'View')
{

//**************************************************************************************
//								Bring in the Warehouse Name
//**************************************************************************************

#  $query = "SELECT * From $tbl_coop_warehouse where warehouse_code = \"$warehouse\" ";




#$ddresults = mysql_query($query, $db_conn);

#$ddrow = mysql_fetch_array($ddresults);

# if ($warehouse == '%'){$warehouse_hold = 'All';}
#	else{$warehouse_hold=$ddrow['warehouse_description'];}
//**************************************************************************************

echo '<br>';
echo '<font size=5 color=blue><center>Warehouse Transfer Report</center></font><br>';
#echo '<font size=3 color=blue>Warehouse: '.$warehouse_hold.'</font>';



#echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search Ending Date: </font>';
#echo $search_date;
echo  '<br>';

/*
  $query = "SELECT ci.* 
            FROM $tbl_coop_item ci, $tbl_item_description id 
            WHERE ci.item_code=id.item_code 
            and warehouse LIKE '$warehouse' 
            and ci.item_active='0' 
            and ci.arrival_date <= '$search_date' 
            order by ci.item_code , ci.lot_ship";
            
            */

$query = "SELECT ci.item_code, td.transfer_date, td.transfer_amt, 
                 ci.quantity AS from_quantity, ci.item_description AS from_description, 
                 ci2.quantity AS to_quantity, ci.warehouse AS from_warehouse, 
                 ci2.warehouse AS to_warehouse, ci.mark AS from_mark,ci.warehouse_code as from_warehouse_code, ci2.mark AS to_mark,
                 ci2.warehouse_code as to_warehouse_code
         FROM $tbl_transfer_detail td, $tbl_coop_item ci,  $tbl_coop_item ci2 
         WHERE td.item_id_from = ci.item_id 
         AND td.item_id_to = ci2.item_id  order by td.transfer_date "; 

//$query = "SELECT * FROM $tbl_coop_item ci, $tbl_item_description id WHERE warehouse LIKE \"$warehouse\" and item_active='0'";

$result = mysql_query($query, $db_conn);


$num_results = mysql_num_rows($result);

$item_left_total=0;
$cost_total=0;

echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";

echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Item Code</font></th>';
echo '<th align=center><font size=2 color=blue>Transfer Date</font></th>';
echo '<th align=center><font size=2 color=blue>Description</font></th>';
echo '<th align=center><font size=2 color=blue>Amount</font></th>';
echo '<th align=center><font size=2 color=blue>Mark</font></th>';
echo '<th align=center><font size=2 color=blue>From</font></th>';
echo '<th align=center><font size=2 color=blue>Warehouse CD</font></th>';
echo '<th align=center><font size=2 color=blue>To</font></th>';
echo '<th align=center><font size=2 color=blue>Warehouse CD</font></th></tr>';


$date_subtotal = 0;
$current_td = "first_time";
$total_total = 0;

for ($i=0; $i <$num_results;  $i++)
  {
  	
  	
  	
$row = mysql_fetch_array($result);

if ($current_td != "first_time" && $current_td != $row['transfer_date']) {	
echo '<tr bgcolor=palegreen><td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td><font color=blue><center>Sub Totals</center></font></td>';
echo '<td align=left><font color=blue>'.$date_subtotal.'</font></td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td align=right><font color=blue>&nbsp</font></td></tr>';	
$date_subtotal = 0;
	
}	

$date_subtotal = $date_subtotal + $row['transfer_amt'];
$total_total = $total_total + $row['transfer_amt'];
$current_td = $row['transfer_date'];

echo '<tr><td>'.$row['item_code'].'</td>';
echo '<td>'.$row['transfer_date'].'</td>';
echo '<td>'.$row['from_description'].'</td>';
echo '<td>'.$row['transfer_amt'].'</td>';
echo '<td>'.$row['from_mark'].'</td>';
echo '<td>'.$row['from_warehouse'].'</td>';
echo '<td>'.$row['from_warehouse_code'].'</td>';
echo '<td>'.$row['to_warehouse'].'</td>';
echo '<td>'.$row['to_warehouse_code'].'</td>';
echo '</tr>';





}

 
 echo '<tr bgcolor=palegreen><td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td><font color=blue><center>Sub Totals</center></font></td>';
echo '<td align=left><font color=blue>'.$date_subtotal.'</font></td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td align=right><font color=blue>&nbsp</font></td></tr>';	
 
 
 
echo '<tr bgcolor=green><td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td><font color=white><center>Total Total</center></font></td>';
echo '<td align=right><font color=white>'.$total_total.'</font></td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td align=left><font color=white>&nbsp</font></td></tr>';
 


echo '</table>';

}
echo '</form>';
?>