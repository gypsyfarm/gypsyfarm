<?php

session_start();
require("../../tables.php");
require("../../check_login.php");

	$user=$_SESSION['valid_user'];
	$id=$_SESSION['contact_id'];
	$order_id=$_GET['order_id'];
 



?>
<html>
<head>
<title>Review Orders</title>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>

<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>

     <table width=100%><tr bgcolor=palegreen><td> 
   <font size=3><a href="../../logout.php">Log Out</a></font>  
       </td><td align=center> 
     <font size=3><a href="index.php">Back to the Report Menu</a></font> 
       </td><td align=center>  
     <font size=3><a href="../../index.php">Back to the main Menu</a></font> 
       </td></tr></table> 
 <center><h1>Review Orders</h1></center> 
<?php


//*****************************************************************************
//********************Make a connection to the Database*********************
//*****************************************************************************

  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }
//*****************************************************************************
//*****************************************************************************




   $query = "SELECT cc.company, cc.Warehouse, cc.ShipCity, cc.name, oh.ship_date,
    oh.customer_key, oh.header_id, oh.order_date, oh.fob_city, oh.order_nbr
	FROM $tbl_order_header oh, $tbl_coop_contact cc
    WHERE oh.customer_key = cc.contact_id AND oh.customer_key = '$id' 
     ORDER BY oh.ship_date desc;";


  # echo "<br>";
   $result = mysql_query($query, $db_conn);
   $num_results = mysql_num_rows($result);

   if ($num_results==0)   {
   echo '<font size=3 color=blue>Your organization has no orders to review</font>';
   }
   else {
   echo '<font size=3 color=blue>To date, your organization has placed '.$num_results.' orders with Cooperative Coffees</font>';


//***********Draw the TABLE*************************************************************

   	echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";
    echo '<tr bgcolor=palegreen>';
	echo '<th align=center>Order#(Date)</th>';
	echo '<th align=center>Company Name</th>';
	echo '<th align=center>Shipping City</th>';
	echo '<th align=center>Shipping Date</th>';
	echo '<th align=center>Warehouse</th>';
	echo '</tr>';
   for ($i=0; $i <$num_results; $i++)
   {
	$row = mysql_fetch_array($result);


    echo '<tr>';
# 	echo "<td>&nbsp;&nbsp;&nbsp;<font color=blue><a href='review_orders.php?order_id=".$row['header_id']."'>".$row['order_nbr']." (".$row['order_date'].")</font></a></td>";
	echo "<td>&nbsp;&nbsp;&nbsp;<font color=blue><a href='review_orders.php?order_id=".$row['header_id']."'>".$row['header_id']." (".$row['order_date'].")</font></a></td>";

    echo "<td><font color=black>".$row['company']."&nbsp;</font></td>";
	echo "<td><font color=black>".$row['fob_city']."&nbsp;</font></td>";
	echo "<td><font color=black>".$row['ship_date']."&nbsp;</font></td>";
	echo "<td><font color=black>".$row['Warehouse']."&nbsp;</font></td>";
 	echo "</tr>";
   }
 echo "</table>";
 echo "<p>";


$query = "select oh.header_id, oh.order_date, li.item_id, li.lot_id, li.lot_ship,
          oi.cost, oi.quantity AS item_quantity,  li.quantity AS lot_quantity,  ci.weight as bag_lbs,
		  oi.item_code, ci.item_description, ci2.mark, ci2.member_price,cc.name, cc.company
          FROM ($tbl_lot_item li,$tbl_order_item oi,$tbl_order_header oh,$tbl_item_description ci,$tbl_coop_contact cc)
          LEFT JOIN $tbl_coop_item ci2 ON ci2.item_id = li.lot_ship
          WHERE  li.item_id = oi.item_id
          AND li.header_id = oh.header_id
          AND oh.customer_key = cc.contact_id
          AND oi.item_code = ci.item_code
          AND oh.header_id = '$order_id'
          order by li.header_id, li.item_id, li.lot_id ";



   $result = mysql_query($query, $db_conn);
   $num_results = mysql_num_rows($result);

   if ($num_results==0)   {
   echo '<br><font size=3 color=blue>Please Select an order to see the associated items</font>';
   }
   else {
    echo '<br><font size=3 color=blue>There are '.$num_results.' items associated with this order</font>';
   	echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";
    echo '<tr bgcolor=palegreen>';
	//echo '<th align=center>Header ID</th>';
	//echo '<th align=center>Item ID</th>';
	//echo '<th align=center>Lot ID</th>';
	echo '<th align=center>Order Date</th>';
	echo '<th align=center>Item Code</th>';
	echo '<th align=center>Quantity</th>';
	echo '<th align=center>Pounds</th>';
	echo '<th align=center>Discription</th>';
	echo '<th align=center>Mark</th>';
	echo '</tr>';

   for ($i=0; $i <$num_results; $i++)

   {
	$row = mysql_fetch_array($result);

	echo '<tr>';
	//echo "<td><font color=black>".$row['header_id']."&nbsp;</font></td>";
	//echo "<td><font color=black>".$row['item_id']."&nbsp;</font></td>";
    //echo "<td><font color=black>".$row['lot_id']."&nbsp;</font></td>";
	echo "<td><font color=black>".$row['order_date']."&nbsp;</font></td>";
	echo "<td><font color=black>".$row['item_code']."&nbsp;</font></td>";
	echo "<td><font color=black>".$row['lot_quantity']."&nbsp;</font></td>";
	echo "<td><font color=black>".$row['bag_lbs'] * $row['lot_quantity']."&nbsp;</font></td>";
	echo "<td><font color=black>".$row['item_description']."&nbsp;</font></td>";
	echo "<td><font color=black>".$row['mark']."&nbsp;</font></td>";
 	echo "</tr>";
	$total_bags = $total_bags + $row['lot_quantity'];
   }

 	echo "</table>";
	echo '<font size=3 color=blue><bold>Total amount of bags ordered ='.$total_bags.'</bold></font>';
 	echo "<p>";
 }
}
?>
</form>
 

</BODY>


</HTML>
