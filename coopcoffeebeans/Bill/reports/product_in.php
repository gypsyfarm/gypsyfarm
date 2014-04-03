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
  	echo'<title>Product in By Date</title>';
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
#  $item=$_REQUEST['new_product'];
#  $lot=$_REQUEST['lot'];

  if ($_REQUEST['To_Year'] == '') {
    $_REQUEST['To_Year']= $to_year;
  }

  if ($_REQUEST['From_Year'] == '') {
    $_REQUEST['From_Year']= $from_year;
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




    echo '<form method=POST action=product_in.php>';


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
 

	  
	  /*
	  if (isset($_SESSION['To_Month'])){
	     $to_month=$_REQUEST['To_Month']; }
	  else {
	     $to_month = 12;
	  }      
	  */
	  $to_month=$_REQUEST['To_Month'];
	  to_monthdropdown($to_month);

	  echo 'Day: ';

	  $to_day=$_REQUEST['To_Day'];
	  to_daydropdown($to_day);

	  echo 'Year: ';

	  $to_year=$_REQUEST['To_Year'];
	  to_yeardropdown($from_year);

	  echo '<br>';

        echo '<input type="SUBMIT" name="ACTION" value="View">';

  

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

$query = " SELECT id.item_code,   ci.lot_ship, id.weight as bag_lbs,
          ci.item_description, ci.quantity as initial_quantity, ci.ship_date,
          ci.transfer_in, ci.transfer_out, id.item_code, ci.arrival_date, ci.mark
          FROM $tbl_item_description id,  $tbl_coop_item ci
          WHERE id.item_code = ci.item_code
           and ci.quantity > 0
           and ci.lot_ship <> ''
           AND ci.ship_date Between '$from_date' and '$to_date'
          order by id.item_code, ci.lot_ship";
		  
   
#echo "<br>$query <br>";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$quantity_total=0;
$remaining=0;

echo '<br>';
echo '<font size=5 color=blue><center>Coffee Shipping Report</center></font><br>';
echo '<font size=3 color=blue>Date Range: </font>'.$from_date.'<font size=3 color=blue> to </font>'.$to_date;

echo "\n";
echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";
echo "\n";
echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Item Code</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Lot #</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Shipping Date</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Arrival Date</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Mark</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Weight</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Quantity</font></th>';
echo "\n";
echo '<th align=center><font size=2 color=blue>Total Weight</font></th>';
echo "\n";

$prev_item_code = '';
$total_total_initial_quantity = 0;
$total_total_weight = 0;
$alt_sw = 0;
for ($i=0; $i <$num_results;  $i++) {
	
   $row=mysql_fetch_array($result); 
   
   
       if ($prev_item_code == $row['item_code'] and $prev_lot_ship ==  $row['lot_ship'])  {
        $curr_initial_quantity = $row['initial_quantity'];
        $curr_total_weight = $row['initial_quantity'] * $row['bag_lbs'];  
    }
   if ($prev_item_code == '') {
   	$prev_item_code = $row['item_code'];
        $prev_lot_ship = $row['lot_ship'];
        $prev_arrival_date = $row['arrival_date'];
        $prev_ship_date = $row['ship_date'];
        $prev_mark = $row['mark'];
        $prev_bag_lbs = $row['bag_lbs'];
        $prev_initial_quantity += $row['initial_quantity'];
        $prev_total_weight += $row['initial_quantity'] * $row['bag_lbs'];
    }
/*    
    echo "<tr><td colspan=5>";
    echo "prev = $prev_item_code / $prev_lot_ship <br>";
    echo "curr = ".$row['item_code']." / ".$row['lot_ship']."<br>";
    echo "amounts: current".$row['initial_quantity']." prev ".$prev_initial_quantity."<br>";
    echo "and var currents = $curr_initial_quantity <br>";
    echo "</td></tr>";
 */  
    if ( $prev_item_code <> $row['item_code']
                  or $prev_lot_ship <>  $row['lot_ship']
                  or $i == ($num_results - 1)) {
        echo "\n";
        if ($alt_sw == 1) {
          echo  "<tr bgcolor=lightgrey>";
          $alt_sw = 0;
        }
        else {
          echo "<tr>";
          $alt_sw = 1;
        }
        echo "<td>$prev_item_code &nbsp;</td>";
        echo "\n";
        echo "<td>$prev_lot_ship &nbsp;</td>";
        echo "\n";
        echo "<td>$prev_ship_date &nbsp;</td>";
        echo "\n";        
        echo "<td>$prev_arrival_date &nbsp;</td>";
        echo "\n";
        echo "<td>$prev_mark &nbsp;</td>";
        echo "\n";
        echo "<td>$prev_bag_lbs &nbsp;</td>";
        echo "\n";
        $prev_initial_quantity +=  $curr_initial_quantity;
        echo "<td>$prev_initial_quantity</td>";
        $total_total_initial_quantity += $prev_initial_quantity;
        echo "\n";
        $prev_total_weight += $curr_total_weight;
        echo "<td>$prev_total_weight</td>";
        $total_total_weight += $prev_total_weight;
        echo "\n"; 
   	$prev_item_code = $row['item_code'];
        $prev_lot_ship = $row['lot_ship'];
        $prev_ship_date = $row['ship_date'];        
        $prev_arrival_date = $row['arrival_date'];
        $prev_mark = $row['mark'];        
        $prev_bag_lbs = $row['bag_lbs'];
        $prev_initial_quantity = $row['initial_quantity'];
        $prev_total_weight =  $row['initial_quantity'] * $row['bag_lbs'];  
        $curr_initial_quantity = 0;      
        $curr_total_weight = 0; 
    }

   
}


# print the last record:
        echo "\n";
        echo "<tr><td>$prev_item_code &nbsp;</td>";
        echo "\n";
        echo "<td>$prev_lot_ship &nbsp;</td>";
        echo "\n";
        echo "<td>$prev_ship_date &nbsp;</td>";
        echo "\n";        
        echo "<td>$prev_arrival_date &nbsp;</td>";
        echo "\n";
        echo "<td>$prev_mark &nbsp;</td>";
        echo "\n";
        echo "<td>$prev_bag_lbs &nbsp;</td>";
        echo "\n";
        $prev_initial_quantity +=  $curr_initial_quantity;
        echo "<td>$prev_initial_quantity</td>";
        $total_total_initial_quantity += $prev_initial_quantity;
        echo "\n";
        $prev_total_weight += $curr_total_weight;
        echo "<td>$prev_total_weight</td>";
        $total_total_weight += $prev_total_weight;
        echo "\n"; 

echo "\n";
echo '<tr bgcolor=palegreen><td>&nbsp;</td>';
echo "\n";
echo '<td>&nbsp;</td>';
echo "\n";
echo '<td>&nbsp;</td>';
echo "\n";
echo '<td>&nbsp;</td>';
echo "\n";
echo '<td>&nbsp;</td>';
echo "\n";
echo '<td>Totals:</td>';
echo "\n";
echo "<td>$total_total_initial_quantity</td>";
echo "\n";
echo "<td>$total_total_weight</td>";
echo "\n";
echo '</tr>';
echo "\n";
echo '</table>';
 
echo "\n";
echo '</form>';

# end 



?>