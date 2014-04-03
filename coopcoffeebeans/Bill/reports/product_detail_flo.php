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
  	echo'<title>Product Detail</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">';
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
//******************************Start Building the Report********************************
//*****************************Carry the Variable Names**********************************
  $warehouse=$_REQUEST['warehouse'];
  if (isset($_REQUEST['warehouse'])){
  	$warehouse=$_REQUEST['warehouse'];
   }
  else {
       $warehouse = '%';
   #   $warehouse = 'H';
  }
  
  $item=$_REQUEST['new_product'];
  $lot=$_REQUEST['lot'];
  $do_kilos = $_REQUEST['do_kilos'];
  
  
     if ($_REQUEST['do_kilos'] == "on") {
       $do_kilos = 1; 
    } 
  
  $convert_value = 0.45;

  if ($_REQUEST['To_Year'] == '') {
    $_REQUEST['To_Year'] = $to_year;
  }

  if ($_REQUEST['From_Year'] == '') {
    $_REQUEST['From_Year'] = $from_year;
  }
  if ($_REQUEST['To_Day'] == '') {
    $_REQUEST['To_Day']=31;
  }
  if ($_REQUEST['From_Day'] == '') {
    $_REQUEST['From_Day']=01;
  }




    echo '<form method=POST action=product_detail_flo.php>';

	echo '<br>';
	echo '<font size=3 color=blue>Select a Warehouse</font>';
	echo '<br>';

        
	report_warehousedropdown($warehouse);
	
	
	
	
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Weight In Metric ?:';
     GenericCheckBox("do_kilos",$do_kilos);

	echo '<br><br>';



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
 

	  
	 
	  if (isset($_SESSION['To_Month'])){
	     $to_month=$_REQUEST['To_Month']; }
	  else {
	     $to_month = 12;
	  }      
	  
	  to_monthdropdown($to_month);

	  echo 'Day: ';

	  $to_day=$_REQUEST['To_Day'];
	  to_daydropdown($to_day);

	  echo 'Year: ';

	  $to_year=$_REQUEST['To_Year'];
	  to_yeardropdown($to_year);

	  echo '<br>';





	  echo '<br>';
	  echo 'Choose an Item:';
	  newitemdropdown($item);
	  echo '&nbsp;&nbsp;Enter Lot# ';
	  echo "<input type=text size=5 name=lot value=\"$lot\">";

	  echo '<br>';
	  echo '<input type="SUBMIT" name="ACTION" value="View">';

if ($_REQUEST['ACTION'] == 'View')
{

//**********************Make Proper the Dates from the Functions**********************
$from_month=$_REQUEST['From_Month'];
$from_year=$_REQUEST['From_Year'];
$from_day=$_REQUEST['From_Day'];
$from_date=$from_year.'-'.$from_month.'-'.$from_day;

$to_month=$_REQUEST['To_Month'];
$to_year=$_REQUEST['To_Year'];
$to_day=$_REQUEST['To_Day'];
$to_date=$to_year.'-'.$to_month.'-'.$to_day;
//*************************************************************************************

$query = "SELECT * From $tbl_coop_warehouse where warehouse_code = \"$warehouse\" ";

	$ddresults = mysql_query($query, $db_conn);
	$ddrow = mysql_fetch_array($ddresults);

    if ($warehouse == '%'){$warehouse_hold = 'All';}
	 else{$warehouse_hold=$ddrow['warehouse_description'];}

$query = "SELECT IFNULL(ci.flo_id,''), IFNULL(cc.FTTrack,'N') as FTTrack, oi.item_code, li.quantity, ci.lot_ship, id.weight as bag_lbs,
          ci.item_description, ci.quantity as initial_quantity, ci.mark,
          ci.transfer_in, ci.transfer_out, id.item_code, oh.order_date, oh.header_id, cc.Company
          FROM $tbl_item_description id, $tbl_order_item oi, $tbl_lot_item li,
          $tbl_order_header oh, $tbl_coop_item ci, $tbl_coop_contact cc
          WHERE oi.item_id = li.item_id
          AND oi.item_code = id.item_code
		  AND oh.customer_key = cc.contact_id
          AND li.lot_ship = ci.item_id
          AND oi.header_key = oh.header_id
          AND oi.item_code=\"$item\"
          AND oh.order_date Between \"$from_date\" and \"$to_date\"
           AND ci.lot_ship= \"$lot\"  
           AND ci.warehouse LIKE \"$warehouse\"	 	  
           order by IFNULL(cc.FTTrack,'N') DESC, cc.Company ";
       	   
		  
#  echo "<br> #1 $query <br>"; 

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$quantity_total=0;
$remaining=0;

for ($i=0; $i <$num_results;  $i++) {
   $row=mysql_fetch_array($result);
   $quantity_total=$quantity_total+$row['quantity'];
}

if ($num_results == 0) {

   $query = "SELECT ci.flo_id, id.item_code,   ci.lot_ship, id.weight as bag_lbs,
          ci.item_description, ci.quantity as initial_quantity,
          ci.transfer_in, ci.transfer_out, id.item_code
          FROM $tbl_item_description id,  $tbl_coop_item ci
          WHERE id.item_code = ci.item_code
          AND id.item_code=\"$item\"
		    AND ci.lot_ship= \"$lot\"
		    AND ci.warehouse LIKE \"$warehouse\"";


   $result = mysql_query($query, $db_conn);
   $num_results = mysql_num_rows($result);
   
 #    echo "<br>#2 $query <br>"; 
   if ($num_results > 0 ) {
      $row=mysql_fetch_array($result);
   }


}
#echo "<br>warehouse_hold = $warehouse_hold<br>";
 if ($warehouse_hold == 'All') {
    $query2 = "SELECT sum(ci.quantity) as initial_quantity,
                      sum(ci.transfer_in) as transfer_in,
                      sum(ci.transfer_out) as transfer_out
                FROM $tbl_coop_item ci 
                WHERE  ci.item_code='$item' 
                AND ci.lot_ship= '$lot'";  	
    $result2 = mysql_query($query2, $db_conn); 
    $row2=mysql_fetch_array($result2); 
    $initial_quantity = $row2['initial_quantity'];
    $transfer_in = $row2['transfer_in'];
    $transfer_out = $row2['transfer_out'];
  }
   else {
   $initial_quantity = $row['initial_quantity'];
    $transfer_in = $row['transfer_in'];
    $transfer_out = $row['transfer_out'];
   }
           

$remaining= $initial_quantity + $transfer_in - $transfer_out - $quantity_total;
echo '<br>';
echo '<font size=5 color=blue><center>Inventory Report by Product - Detail</center></font><br>';
echo '<font size=3 color=blue>Date Range: </font>'.$from_date.'<font size=3 color=blue> to </font>'.$to_date;
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=3 color=blue>Warehouse: </font>'.$warehouse_hold;
$quantity_and_transfers = $initial_quantity + $transfer_in - $transfer_out;
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Initial Quantity:</font>'.$initial_quantity;
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Remaining: </font>'.$remaining.'<br>';
echo '<font size=3 color=blue>Product: </font>'.$row['item_description'].'<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;Item: </font>'.$item.'<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lot: </font>'.$lot.'  '.'&nbsp;&nbsp;&nbsp;<font size=3 color=blue> Flo_ID: </font>'.$row['flo_id'];
if ($row['flo_id'] == '') {
	echo ' N/A  ';
}
else {
      echo '  ';
}
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;Transfer In:</font>'.$transfer_in.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp <font size=3 color=blue> Transfer out: </font>'.$transfer_out.'<br><br>';



$query = "SELECT IFNULL(cc.FTTrack,'N') as FTTrack, oi.item_code, li.quantity, ci.lot_ship, id.weight as bag_lbs,
          ci.item_description, ci.quantity as initial_quantity, ci.transfer_in, ci.transfer_out,
          id.item_code, oh.order_date, oh.header_id, cc.Company, ci.mark
          FROM $tbl_item_description id, $tbl_order_item oi, $tbl_lot_item li,
          $tbl_order_header oh, $tbl_coop_item ci, $tbl_coop_contact cc
          WHERE oi.item_id = li.item_id
          AND oi.item_code = id.item_code
		  AND oh.customer_key = cc.contact_id
          AND li.lot_ship = ci.item_id
          AND oi.header_key = oh.header_id
          AND oi.item_code=\"$item\"
		  AND oh.order_date Between \"$from_date\" and \"$to_date\"
		  AND ci.lot_ship= \"$lot\"
		  Order by IFNULL(cc.FTTrack,'N') DESC, cc.Company, oh.header_id";
 
 
 
 
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);

#echo "<br> #3 $query <br>";

echo "\n";
echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";
echo "\n";
echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Order#</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Item</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Description</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Company Name</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Mark</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Date</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Quantity</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Weight';
 if ($do_kilos == 1) {
     echo '(Kgs)';
}
else {
	echo '(lbs)';
}
echo '</font></th></tr>';
echo "\n";
$quantity_total=0;
$weight_total=0;
$alt_sw = 0;
$prev_company = "first_time";
$flo_sw = 'Y';

for ($i=0; $i <$num_results;  $i++) {

    if ($prev_company <> "first_time") {
    	$prev_company = $row['Company'];
    }  		

    $row = mysql_fetch_array($result); 
     if ($flo_sw <> 'S') {
        $flo_sw = $row['FTTrack'];
     }
     
  
     
     if ($prev_company  <> $row['Company']) {
     	
       if ($prev_company <> "first_time") {  	
     	   echo "<tr bgcolor=yellow>";
     	   echo "<td colspan=5>&nbsp;";
           echo "</td>";
           echo "<td> Total </td>";
           echo "<td>";
           echo $quantity_total;
           echo "</td>";
            echo "<td>";
            if ($do_kilos == 1) {
            	$weight_total = $weight_total * $convert_value;
             }             
           echo $weight_total;
           echo "</td>";          
           echo "</tr>";   
           $sub1_quantity_total += $quantity_total;
           $sub1_weight_total += $weight_total;
           $quantity_total = 0; 
           $weight_total =0;
        }	
 
   	
   	
        if ($flo_sw <> 'Y' && $flo_sw <> 'S') {
        	
     	   echo "<tr bgcolor=lightgreen>";
     	   echo "<td colspan=5>&nbsp;";
           echo "</td>";
           echo "<td>  Flo Total </td>";
           echo "<td>";
           echo $sub1_quantity_total;
           echo "</td>";
            echo "<td>";
           echo  $sub1_weight_total;
           echo "</td>";          
           echo "</tr>";         	
           $total_quantity_total += $sub1_quantity_total;
           $total_weight_total += $sub1_weight_total;        	
           $sub1_quantity_total = 0; 	
           $sub1_weight_total = 0; 
        /*	
        echo  "<tr bgcolor=red>";
        echo "<td colspan=8> ";
        echo "Swithing to non flo orders: $flo_sw";
        echo "</td>";
        echo "</tr>";
        */
        $flo_sw = 'S';
     }      	        	
     	
        echo  "<tr bgcolor=lightblue>";
        echo "<td colspan=8> ";
        echo $row['Company'];
        echo "</td>";
        echo "</tr>";
        $prev_company = $row['Company'];
  
     }

    echo "\n";
    if ($alt_sw == 1) {
       echo  "<tr bgcolor=lightgrey>";
       $alt_sw = 0;
    }
     else {
     echo "<tr>";
        $alt_sw = 1;
       }
      
echo "<td>".$row['header_id']."</td>";
echo "\n";
echo "<td>".$row['item_code']."</td>";
echo "\n";
echo "<td>".$row['item_description'].":".$row['FTTrack']."</td>";
echo "\n";
echo "<td>".$row['Company']."</td>";
echo "\n";
echo "<td>".$row['mark']."</td>";
echo "\n";
echo "<td>".$row['order_date']."</td>";
echo "\n";
echo "<td>".$row['quantity']."</td>";
$sub_total_1 += $row['quantity'];
echo "\n";
$quantity_total=$quantity_total+$row['quantity'];
$weight=$row['bag_lbs']*$row['quantity'];
$weight_total=$weight_total+$weight;
echo "\n";
echo "<td>";
            if ($do_kilos == 1) {
            	$weight = $weight * $convert_value;
             } 
echo     $weight; 

echo "</td>";
$sub_total_weight += $weight;

}
#end of for loop:

       if ($quantity_total  > 0) {  	
     	   echo "<tr bgcolor=yellow>";
     	   echo "<td colspan=5>&nbsp;";
           echo "</td>";
           echo "<td> Total </td>";
           echo "<td>";
           echo $quantity_total;
           echo "</td>";
            echo "<td>";
            if ($do_kilos == 1) {
            	$weight_total = $weight_total * $convert_value;
             }               
           echo $weight_total;
           echo "</td>";          
           echo "</tr>";   
           $quantity_total = 0; 
           $weight_total =0;
        }	



     	   echo "<tr bgcolor=lightgreen>";
     	   echo "<td colspan=5>&nbsp;";
           echo "</td>";
           echo "<td>  Non-Flo Total </td>";
           echo "<td>";
           echo $sub1_quantity_total;
           echo "</td>";
            echo "<td>";
           echo $sub1_weight_total;
           echo "</td>";          
           echo "</tr>";   
           $total_quantity_total += $sub1_quantity_total;
           $total_weight_total += $sub1_weight_total;

echo "\n";
echo '<tr bgcolor=paleblue><td>&nbsp;</td>';
echo "\n";
echo '<td>&nbsp;</td>';
echo "\n";
echo '<td>&nbsp;</td>';
echo "\n";
echo '<td>&nbsp;</td>';
echo "\n";
echo '<td>&nbsp;</td>';
echo "\n";
echo '<td><font color=blue>Total:</font></td>';
echo "\n";
echo '<td><font color=blue>'.$total_quantity_total.'</font></td>';
echo "\n";
echo '<td><font color=blue>'.$total_weight_total.'</td>';
echo "\n";
echo '</tr>';
echo "\n";
echo '</table>';
}
echo "\n";
echo '</form>';


?>