<?php
//****************************************************************************************
require("../tables.php");


// check security
 session_start();
// check session variable

  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coopcoffeesbeans.com/member_area/order/badlogin.php");
  }

	echo'<html>';

	echo'<head>';
  	echo'<title>Commitments</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
	#  echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';
	echo '<font size=3 color=blue>You are logged in as '.$_SESSION['valid_user'].'</font><br>';
	echo '<font size=3><a href="../index.php">Back to the main Menu</a></font><br>';
  echo '<font size=3><a href="../logout.php">Log Out</a></font><br><br><br><br><br>';
// create short variable names
# this field will need to come from login screen.
  $company=$_SESSION['valid_user'];
  $current_id=$_REQUEST['current_id'];
  $action=$_REQUEST['action'];


echo '<form method=POST action=coop_commit.php>';
echo '<font size=3 color=blue>Select year range</font><br>';

//echo 'Company Name: ';
//echo $company;



	  echo 'Year Range: ';
	  echo '<select name=year_range>';
	  echo '<option value="2000">2000';
	  echo '<option value="2001">2001';
	  echo '<option value="2002">2002
	  echo '<option value="2003">2003';
	  echo '<option value="2004" >2004';
	  echo '<option  value="2005">2005';
	   echo '<option value="2006" >2006';
	    echo '<option value="2007" >2007';
	     echo '<option selected value="2008" >2008';
	  echo '</select>';
	  echo '<br>';
	  echo '<input type="SUBMIT" name="SUBMIT" value="view">';

echo '<br> submit is '.$_REQUEST['SUBMIT'].'<br>';

if ($_REQUEST['SUBMIT'] == 'view')
{

 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

$company=$_SESSION['valid_user'];
$year_range=$_REQUEST['year_range'];
//echo $company;

//echo $company;
//echo $year_range;

$company=addslashes($company);
$query = "select * from $tbl_coop_contact where Company = '$company'";
$company=stripslashes($company);

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$customer_key=$row['contact_id'];
//echo $customer_key;
//**************************Assign ranges to date for searching*********************
 

$from_date= "$year_range-01-01";
$to_date="$year_range-12-31";



$query = "select cc.*, id.item_description, id.item_code
		 FROM $tbl_coop_commited cc, $tbl_item_description id
		 where cc.customer_key = '$customer_key'
		 and cc.import_yr = '$year_range'
		 and cc.item_code = id.item_code order by id_item_code";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);




# begin new code:
$query = 
"SELECT o.customer_key, i.header_key, c.item_code, i.item_code as show_code, o.order_date, l.quantity, i.header_key 
FROM $tbl_order_header o, $tbl_order_item i, $tbl_lot_item l 
LEFT  JOIN $tbl_coop_commited c 
ON c.customer_key = o.customer_key 
AND c.item_code = i.item_code 
AND import_yr =  '$year_range' 
WHERE i.header_key = o.header_id 
AND l.header_id = o.header_id
AND l.item_id = i.item_id
AND o.order_date  Between '$from_date' and '$to_date'
AND c.item_code IS  NULL  
AND l.quantity > 0
AND o.customer_key = $customer_key ";

$result2 = mysql_query($query, $db_conn);
$num_result2 = mysql_num_rows($result2);
 
echo "<br> $query <br>";

# end new code:





echo '<br><br><font size=3 color=blue>Now viewing commitments for,&nbsp;'.$company.'&nbsp;for the years, '.$year_range.'<br>';





echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";

echo '<tr bgcolor=palegreen><th align=center><font color=blue>Item</font></th>';
echo '<th align=center><font color=blue>Description</font></th>';
echo '<th align=center><font color=blue>Remain</font></th>';
echo '<th align=center><font color=blue>Total</font></th>';
echo '<th align=center><font color=blue>Jan</font></th>';
echo '<th align=center><font color=blue>Feb</font></th>';
echo '<th align=center><font color=blue>Mar</font></th>';
echo '<th align=center><font color=blue>Apr</font></th>';
echo '<th align=center><font color=blue>May</font></th>';
echo '<th align=center><font color=blue>Jun</font></th>';
echo '<th align=center><font color=blue>Jul</font></th>';
echo '<th align=center><font color=blue>Aug</font></th>';
echo '<th align=center><font color=blue>Sep</font></th>';
echo '<th align=center><font color=blue>Oct</font></th>';
echo '<th align=center><font color=blue>Nov</font></th>';
echo '<th align=center><font color=blue>Dec</font></th>';
echo '<th align=center><font color=blue>PY</font></th></tr>';
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
$py_total=0;
$total_total=0;
$remaining=0;
$remaining_total=0;

for ($i=0; $i <$num_results;  $i++)
  {
  $row = mysql_fetch_array($result);
  $item_code=$row['item_code'];
  $total = $row['month01'] + $row['month02'] + $row['month03'] + $row['month04'] +$row['month05'] +$row['month06'] +$row['month07'] +$row['month08'] + $row['month09'] + $row['month10'] + $row['month11'] + $row['month12'];
//***************************************Sum up the Totals************************
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
$total_total=$total_total + $total;
$py_total=$py_total+$row['py'];

//*********************************************************************************
//   We Need a subloop here to count the bags of coffee sold for each product
//****************************Make the subquery*************************************

$subquery = "SELECT oh.customer_key, oh.header_id, oi.item_code, li.quantity, cc.Company
FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li
WHERE oh.header_id = oi.header_key
AND oh.customer_key = cc.contact_id
AND cc.Company = '$company'
AND oi.item_code = '$item_code'
and oi.item_id = li.item_id
and oh.order_date Between '$from_date' and '$to_date' order by oi.item_code ";

echo '<br>'.$subquery.'<br>';

$subresult = mysql_query($subquery, $db_conn);
$subnum_results = mysql_num_rows($subresult);
$item_quantity=0;
for ($b=0; $b <$subnum_results;  $b++)
{
$subrow = mysql_fetch_array($subresult);
$item_quantity=$item_quantity + $subrow['quantity'];
}
$remaining=$total-$item_quantity;
$remaining_total=$remaining_total+$remaining;

 echo "<tr><td>".$row['item_code']."</td>";
 echo "<td>".$row['item_description']."</td>";
 echo '<td>'.$remaining.'</td>';
 echo "<td>&nbsp;$total</td>";
 echo "<td>&nbsp;".$row['month01']."</td>";
 echo "<td>&nbsp;".$row['month02']."</td>";
 echo "<td>&nbsp;".$row['month03']."</td>";
 echo "<td>&nbsp;".$row['month04']."</td>";
 echo "<td>&nbsp;".$row['month05']."</td>";
 echo "<td>&nbsp;".$row['month06']."</td>";
 echo "<td>&nbsp;".$row['month07']."</td>";
 echo "<td>&nbsp;".$row['month08']."</td>";
 echo "<td>&nbsp;".$row['month09']."</td>";
 echo "<td>&nbsp;".$row['month10']."</td>";
 echo "<td>&nbsp;".$row['month11']."</td>";
 echo "<td>&nbsp;".$row['month12']."</td>";
 echo "<td>&nbsp;".$row['py']."</td></tr>";




  }
  echo "<tr bgcolor=palegreen><td>&nbsp;</td>";
  echo "<td><font color=blue><center>Totals:</center></font></td>";
  echo "<td><font color=blue>$remaining_total</font></td>";
  echo "<td><font color=blue>$total_total</font></td>";
  echo "<td><font color=blue>$month01_total</font></td>";
  echo "<td><font color=blue>$month02_total</font></td>";
  echo "<td><font color=blue>$month03_total</font></td>";
  echo "<td><font color=blue>$month04_total</font></td>";
  echo "<td><font color=blue>$month05_total</font></td>";
  echo "<td><font color=blue>$month06_total</font></td>";
  echo "<td><font color=blue>$month07_total</font></td>";
  echo "<td><font color=blue>$month08_total</font></td>";
  echo "<td><font color=blue>$month09_total</font></td>";
  echo "<td><font color=blue>$month10_total</font></td>";
  echo "<td><font color=blue>$month11_total</font></td>";
  echo "<td><font color=blue>$month12_total</font></td>";
  echo "<td><font color=blue>$py_total</font></td></tr>";

  echo '</table>';
  
  
  echo "<br>nbr of results are: $num_result2";
if ($num_result2 > 0) {
#echo "<br> we have $num_result2 records <br>"; 

#echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
echo '<tr bgcolor=mistyrose><th align=center><font size=2 color=black>Item</font></th>';
echo '<th colspan=2 align=center><font size=2 color=black>Purchased without commitmentt</font></th>';
echo '<th  colspan=7 align=center><font size=2 color=black>&nbsp;</font></th>';
echo '<th  colspan=7 align=center><font  size=2 color=black>&nbsp;</font></th></tr>';

for ($i=0; $i <$num_result2;  $i++)
  {
  $row2 = mysql_fetch_array($result2);
     $print_code = $row2['show_code'];
     $print_amt = $row2['quantity'];
#  echo "<br> Purchased  $print_code ";
 #  echo '<br> Purchased  '.$row2['show_code'].'  Quantity =  '.$row2['quantity'].' <br>';	
 
   echo "<td><font color=blue>$print_code</font></td>";
  echo "<td colspan=2><font color=blue>$print_amt</font></td>";
  echo "<td colspan=7 ><font   color=blue>&nbsp;</font></td>";
  echo "<td colspan=7><font color=blue>&nbsp;</font></td></tr>";
  	
}


  echo '</table>';

}  
  
  
  
  
}


?>