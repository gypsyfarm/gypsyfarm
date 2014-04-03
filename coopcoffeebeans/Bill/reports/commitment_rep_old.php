<?php

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
  	echo'<title>Commitments</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
	echo'<img SRC="../../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';
	echo '<font size=3 color=blue>You are logged in as '.$_SESSION['valid_user'].'</font><br>';
	echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font><br>';
	echo '<font size=3><a href="index.php">Back to the Reports Menu</a></font><br>';
	echo '<font size=3><a href="../commited.php">ADD Commitments</a></font><br>';
    echo '<font size=3><a href="../../logout.php">Log Out</a></font><br><br><br><br><br>';
// create short variable names
# this field will need to come from login screen.
  $current_id=$_REQUEST['current_id'];
  $action=$_REQUEST['action'];


echo '<form method=POST action=commitment_rep.php>';
echo '<font size=3 color=blue>Select company and year range</font><br>';

      echo 'Company Name: ';
	  customerdropdown();
	  echo '<br>';


	  echo 'Year Range: ';
	  echo '<select name=year_range>';
	  echo '<option>2000-2001';
	  echo '<option>2001-2002';
	  echo '<option selected value=2003-2004>2003-2004';
	  echo '<option>2004-2005';
	  echo '</select>';
	  echo '<br>';
	  echo '<input type="SUBMIT" name="SUBMIT" value="view">';


if ($_REQUEST['SUBMIT'] == 'view')
{

 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }
$company=$_REQUEST['Company_Name'];
$year_range=$_REQUEST['year_range'];

//echo $company;
//echo $year_range;

mysql_select_db('coop_contact');
$query = "select * from coop_contact where Company = \"$company\"";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$customer_key=$row['contact_id'];
//echo $customer_key;


mysql_select_db('coop_commited');
$query = "select * from coop_commited where customer_key = \"$customer_key\" and import_yr = \"$year_range\"";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);





echo "<br><br><font size=3 color=blue>Now viewing commitments for, $company for the years, $year_range<br>";





echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
//echo '<tr><th align=center><font size=2 color=blue>Description</font></th>';
echo '<tr><th align=center><font size=2 color=blue>Item Code</font></th>';
echo '<th align=center><font size=2 color=blue>Remaining in Whse</font></th>';
echo '<th align=center><font size=2 color=blue>Commitment Total</font></th>';
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
echo '<th align=center><font size=2 color=blue>Dec</font></th></tr>';


for ($i=0; $i <$num_results;  $i++)
  {
  $row = mysql_fetch_array($result);
  $total = $row['month01'] + $row['month02'] + $row['month03'] + $row['month04'] +$row['month05'] +$row['month06'] +$row['month07'] +$row['month08'] + $row['month09'] + $row['month10'] + $row['month11'] + $row['month12'];
 // echo "Num results = $num_results";
 // echo $row['item_code'];
// echo "<tr><td>&nbsp;</td>";
 echo "<tr><td>".$row['item_code']."</td>";
 echo "<td>&nbsp;</td>";
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
 echo "<td>&nbsp;".$row['month12']."</td></tr>";



  }
  echo '</table>';
}


?>