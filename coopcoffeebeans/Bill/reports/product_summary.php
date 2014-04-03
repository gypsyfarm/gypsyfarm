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
  	echo'<title>Product Summary</title>';
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


    if ($_REQUEST[show_zero] == "on" ) {
       $show_zero = 1;
       $show_zero_text = '  ';
    }   
    else {

       $show_zero_text = ' and remaining <> 0 ';
       $show_zero = 0; 
    }   


    echo '<form method=POST action=product_summary.php>';

	//***************Echo out todays date for the Report***********************
	echo '<font size=3 color=blue><Bold>Report Date: </bold></font>';
	echo date("l d of F Y");
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

//*******************Display the Warehouse dropdown box************************
	$warehouse=$_REQUEST['warehouse'];
	$search_date=$_REQUEST['search_date'];
	echo '<font size=3 color=blue>Select a Warehouse</font>';
	
	if  ($search_date == '') {
	        $search_date = date("Y-m-d");
	}
   		
		
if ($warehouse == "") {
	$warehouse = 'H';
}	 
		
#echo "<br>warehouse=$warehouse<br>";
report_warehousedropdown($warehouse);

	echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<font color=blue>YYYY-MM-DD (ex. 2003-06-21)</font>';
	echo '<input type=text size=10 name=search_date value="'.$search_date.'">';
	    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<label for="show_zero">';
    echo 'Show Zero Amounts';
    echo '<input type=checkbox name="show_zero"';
    if ($show_zero == "1")
        echo ' Checked>';
    else
        echo '>';  	
	echo '</label>';
	echo '<br><input type="SUBMIT" name="ACTION" value="View">';


echo '<font size=2> Note: Warehouse "ALL" excludes Loss </font>';


	if ($_REQUEST['ACTION'] == 'View')
{

//**************************************************************************************
//								Bring in the Warehouse Name
//**************************************************************************************

$query = "SELECT * From $tbl_coop_warehouse where warehouse_code = \"$warehouse\" ";
$ddresults = mysql_query($query, $db_conn);
$ddrow = mysql_fetch_array($ddresults);
 if ($warehouse == '%'){$warehouse_hold = 'All';}
	else{$warehouse_hold=$ddrow['warehouse_description'];}
//**************************************************************************************

echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<font size=5 color=blue><center>Inventory Report Summary by Warehouse</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<font size=3 color=blue>Warehouse: '.$warehouse_hold.'</font>';



echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search Ending Date: </font>';
if ($warehouse == 'E') {
	echo ' N/A ';
} else {
	echo $search_date;
}

echo  '</center>';
 
if ($warehouse == "%") {
  $warehouse_where = "and warehouse !=  " . "'X'";;
}
Else {
     $warehouse_where =  "and warehouse = " . "'$warehouse'";
}	


if ($warehouse == 'E') {
	$arrival_where = " " ;
} else {
	$arrival_where = " and ci.arrival_date <= '$search_date' ";
}
 
#          and ci.arrival_date <= '$search_date'  
 
$query = "SELECT ci.*
         FROM $tbl_coop_item ci, $tbl_item_description id 
         WHERE ci.item_code=id.item_code 
         $warehouse_where
         and ci.item_active='0' 
          $arrival_where
          order by ci.item_code , ci.item_id, ci.lot_ship";
 

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);

$item_left_total=0;
$cost_total=0;

echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";

echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Item</font></th>';
echo '<th align=center><font size=2 color=blue>Lot</font></th>';
echo '<th align=center><font size=2 color=blue>Description</font></th>';
echo '<th align=center><font size=2 color=blue>Mark</font></th>';
echo '<th align=center><font size=2 color=blue>Whse</font></th>';
echo '<th align=center><font size=2 color=blue>Quantity</font></th>';
echo '<th align=center><font size=2 color=blue>Sales</font></th>';
echo '<th align=center><font size=2 color=blue>Remaining</font></th>';
echo '<th align=center><font size=2 color=blue>Value</font></th></tr>';

for ($i=0; $i <$num_results;  $i++)
  {
$row = mysql_fetch_array($result);


//****************************We Need a subloop here to count the bags of coffee that have been sold for each product
$item_code=$row['item_code'];
$lot=$row['item_id'];
//****************************Make the subquery*******************************************
/*
$subquery = "SELECT li.quantity, li.lot_ship, oh.order_date 
            FROM $tbl_order_item oi, $tbl_lot_item li, $tbl_order_header oh 
            WHERE oh.header_id=li.header_id and oi.item_id = li.item_id 
            and oi.item_code = '$item_code' and li.lot_ship='$lot'
            and oh.order_date < '$search_date'";
*/

$subquery = "SELECT  sum(li.quantity) as quantity
            FROM $tbl_order_item oi, $tbl_lot_item li, $tbl_order_header oh 
            WHERE oh.header_id=li.header_id and oi.item_id = li.item_id 
            and oi.item_code = '$item_code' and li.lot_ship='$lot'
            and oh.order_date < '$search_date'";
            
$subresult = mysql_query($subquery, $db_conn);
$subnum_results = mysql_num_rows($subresult);
$item_quantity=0;

$subrow = mysql_fetch_array($subresult);
if ($subnum_results > 0) {
    $item_quantity=  $subrow['quantity'];
} else { 
   $item_quantity = 0;
}

if (!isset($item_quantity)) {
	$item_quantity = 0;
}
/*
for ($b=0; $b <$subnum_results;  $b++)
{
$subrow = mysql_fetch_array($subresult);
$item_quantity=$item_quantity + $subrow['quantity'];
}


*/
#$item_quantity =  remaining_inventory($row['item_code'],$row['lot_ship'],$row['warehouse']);

$item_left=$row['quantity']-$item_quantity + $row['transfer_in'] - $row['transfer_out'] ;

if ($show_zero ==1 || $item_left > 0) {

    echo '<tr><td>'.$row['item_code'].'</td>';
    echo '<td>'.$row['lot_ship'].'</td>';
    echo '<td>'.$row['item_description'].'</td>';
    echo '<td>'.$row['mark'].'</td>';
    echo '<td>'.$row['warehouse'].'</td>';
    echo '<td align=right>'.$row['quantity'].'</td>';


     echo '<td align=right>'.$item_quantity.'</td>';

     echo '<td align=right>'.$item_left;  

      echo '</td>';
     $cost=$row['cost']*$item_left;
      $cost_total=$cost_total+$cost;
      $item_left_total=$item_left_total+$item_left;

      echo '<td align=right>$'.number_format($cost, 2, '.', ',').'</td>';
      //echo "$".number_format($total, 2, '.', ',');
 }     

}
echo '<tr bgcolor=palegreen><td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td><font color=blue><center>Totals</center></font></td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td align=right><font color=blue>'.$item_left_total.'</font></td>';
echo '<td align=right><font color=blue>$'.number_format($cost_total, 2, '.', ',').'</font></td></tr>';
echo '</table>';

}
echo '</form>';
?>