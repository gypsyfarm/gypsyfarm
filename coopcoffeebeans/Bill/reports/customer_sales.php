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
  	echo'<title>Customer Sales</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
	#echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';
	
	


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


      echo '<form method=POST action=customer_sales.php>';

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

	  echo '<br>';

//**************************Assign the Company Name to Company*****************
 

    $company=$_REQUEST['Company_Name'];
 
    
    if ($_REQUEST['ft_item_select'] == "on"  && $_REQUEST['org_item_select'] == "on"  ) {
       $ft_item_select = 1; 
       $org_item_select = 1;  
       $ft_item_extra = ' and ( ci.ft_item = 1  or ci.org_item = 1 ) ';	
    }
    else {
       if ($_REQUEST['ft_item_select'] == "on" ) {
          $ft_item_select = 1;
          $ft_item_extra = ' and ci.ft_item = 1 ';
       }   
       else {
          $ft_item_select = 0; 
          $ft_item_extra = '  ';   
       }   
       
       if ($_REQUEST['org_item_select'] == "on" ) {
          $org_item_select = 1;
          $org_item_extra = ' and ci.org_item = 1 ';   
       }   
       else  {
          $org_item_select = 0;  
          $org_item_extra = ' ';            
       } 
    }
     
     
 
    echo '<table width=100%>';
    echo '<tr>';

      echo '<td>';
  echo '<input type="SUBMIT" name="ACTION" value="View">';
     echo '</td>';

    echo '<td>';


	  echo '<font size=3 color=blue>Select a Company</font><br>';
	  customerdropdown($company);


$sort_order=$_REQUEST['sort_order'];


    echo '</td>';
    echo '<td>';

echo 'Select a sort Order <br>';
$order_value = array( 'invoice','item','item_lot');
$order_name = array('Invoice Number','Item Code','Item Code & Lot');

echo "\n";

echo '<select name=sort_order>';
echo "\n";
for ($i=0; $i < 3;  $i++)
  {
    echo "<option value=$order_value[$i] ";
    if ($sort_order == $order_value[$i]) {
       echo ' selected ';
    }

    echo "> $order_name[$i]";

    echo "\n";
  }

 echo '</select><br>';
 
     echo '</td>';
    echo '<td>';
    echo '<b>Only Include these items:</b>&nbsp;&nbsp; ';
         echo 'Ft Items:';
     GenericCheckBox("ft_item_select",$ft_item_select);
 
     echo '&nbsp;&nbsp;&nbsp;&nbsp;';
         echo 'Org Items:';
     GenericCheckBox("org_item_select",$org_item_select);
     echo '</td>';    
    echo '</tr></table>';

if ($_REQUEST['ACTION'] == 'View')
{

//*********************Set the Dates up for the Query Statement***********
$from_date=$from_year.'-'.$from_month.'-'.$from_day;
$to_date=$to_year.'-'.$to_month.'-'.$to_day;

//*********************Set up the Sort Order Variables********************
//$sort_order=$_REQUEST['sort_order'];

if ($sort_order=='invoice')
{
$sort_order='oh.header_id, oi.item_code';
$sub_id='header_id';
}
if ($sort_order=='item_lot')
{
$sort_order='oi.item_code';
$sub_id='lot_ship';
}
if ($sort_order=='item')
{
$sort_order='oi.item_code';
$sub_id='item_code';
}
//***************************Extract the contact_id from coop_contact tale and put it in a variable
$company=addslashes($company);

mysql_select_db('coop_contact');
$query = "select contact_id, flo_id from $tbl_coop_contact where Company = '".$company."'";
$result = mysql_query($query, $db_conn);

$company=stripslashes($company);

$row = mysql_fetch_array($result);
$customer_key = $row['contact_id'];
$flo_id = $row['flo_id'];

//echo $customer_key;

//****************Make the Main Query that builds the Dataset for the Report*************
//**************** changed oi.quantity to li.quantity
$query = "SELECT ci.mark, oi.item_code, li.quantity, id.weight as bag_lbs, ci.lot_ship,
          id.item_description, oh.order_date, oh.header_id
          FROM $tbl_item_description id, $tbl_order_item oi, $tbl_lot_item li,
          $tbl_order_header oh, $tbl_coop_item ci
          WHERE oi.item_id = li.item_id
          $ft_item_extra
          $org_item_extra 
          AND oi.item_code = id.item_code
          AND li.lot_ship = ci.item_id
          AND oi.header_key = oh.header_id
          AND oh.customer_key = \"$customer_key\"
          AND oh.order_date Between \"$from_date\" and \"$to_date\"
          order by $sort_order , ci.lot_ship ";


#  echo "<br> select = $query <br>";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);

echo '<br>';
echo '<font size=5 color=blue><center>Sales By Customer Report</center></font><br>';
echo '<font size=3 color=blue>Date Range: </font>'.$from_date.'<font size=3 color=blue> to </font>'.$to_date.'<br>';
echo '<font size=3 color=blue>Customer: </font>'.$company;

echo '    <font size=3 color=blue>Flo ID: </font>'.$flo_id;

echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";

echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Order#</font></th>';
echo '<th align=center><font size=2 color=blue>Description</font></th>';
echo '<th align=center><font size=2 color=blue>Item</font></th>';
echo '<th align=center><font size=2 color=blue>Mark</font></th>';
echo '<th align=center><font size=2 color=blue>Lot#</font></th>';
echo '<th align=center><font size=2 color=blue>Date</font></th>';
echo '<th align=center><font size=2 color=blue>Quantity</font></th>';
//echo '<th align=center><font size=2 color=blue>Bag_lbs</font></th>';
echo '<th align=center><font size=2 color=blue>Weight</font></th></tr>';
$weight=0;
$weight_total=0;
$quantity_total=0;
$alt_sw = 0;

$row = mysql_fetch_array($result);

for ($i=0; $i <$num_results;  $i++)
  {
//$row = mysql_fetch_array($result);  
//echo $sub_id;
if ($sub_id=='lot_ship')
{
$track=$row[$sub_id].$row['item_code'];
$item_hold='item_code';
}
else
{
$track=$row[$sub_id];
$item_hold=$row['sub_id'];
}
//echo $track;

      if ($alt_sw == 1) {
         echo  "<tr bgcolor=lightgrey>";
         $alt_sw = 0;
         }
      else {
         echo "<tr>";
         $alt_sw = 1;
      };

echo "<td>".$row['header_id']."</td>";
echo "<td>".$row['item_description']."</td>";
echo "<td>".$row['item_code']."</td>";
echo "<td>".$row['mark']."</td>";
echo "<td>".$row['lot_ship']."</td>";
echo "<td>".$row['order_date']."</td>";
echo "<td align=right>".$row['quantity']."</td>";
//echo "<td>".$row['bag_lbs']."</td>";
$weight=$row['bag_lbs']*$row['quantity'];
echo "<td align=right>".$weight."</td>";
$weight_total=$weight_total+$weight;
$quantity_total=$quantity_total+$row['quantity'];

$row = mysql_fetch_array($result);

if ($row[$sub_id].$row[$item_hold]!=$track)
{
echo '<tr><td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td align=center><font color=blue>Sub-Total</font></td>';
echo '<td align=right><font color=blue>'.$quantity_total.'</font></td>';
$total_quantity_total += $quantity_total;
echo '<td align=right><font color=blue>'.$weight_total.'</font></td>';
$total_weight_total += $weight_total;
 
$quantity_total=0;
$weight_total=0;
}
}


echo '<tr><td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td align=center><font color=blue>Grand-Total</font></td>';
echo '<td align=right><font color=blue>'.$total_quantity_total.'</font></td>';
echo '<td align=right><font color=blue>'.$total_weight_total.'</font></td>';

echo '</table>';
}

echo '</form>';





?>