<?php
require("../tables.php");
require("../functions.php");
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
	echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';
	echo '<font size=3 color=blue>You are logged in as '.$_SESSION['valid_user'].'</font><br>';
	echo '<font size=3><a href="../index.php">Back to the main Menu</a></font><br>';
    echo '<font size=3><a href="../logout.php">Log Out</a></font><br><br><br><br><br>';
// create short variable names
# this field will need to come from login screen.
  $current_id=$_REQUEST['current_id'];
  $action=$_REQUEST['action'];


# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

if ($_REQUEST['SUBMIT'] == 'ADD')
{
$company=$_REQUEST['Company_Name'];
$year_range=$_REQUEST['year_range'];
$item_code=$_REQUEST['new_product'];
$py=$_REQUEST['py'];
$month01=$_REQUEST['month01'];
$month02=$_REQUEST['month02'];
$month03=$_REQUEST['month03'];
$month04=$_REQUEST['month04'];
$month05=$_REQUEST['month05'];
$month06=$_REQUEST['month06'];
$month07=$_REQUEST['month07'];
$month08=$_REQUEST['month08'];
$month09=$_REQUEST['month09'];
$month10=$_REQUEST['month10'];
$month11=$_REQUEST['month11'];
$month12=$_REQUEST['month12'];

mysql_select_db($tbl_coop_contact);
$query = "select $tbl_contact_id from coop_contact where Company = '".$company."'";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$customer_key=$row['contact_id'];

//echo 'OK Dokey Smokey';

mysql_select_db($tbl_coop_commited);
$query = "INSERT INTO $tbl_coop_commited ( commited_id, customer_key, import_yr, 
                      item_code, py, month01, month02, month03, month04, month05, month06, month07, month08, 
                      month09, month10, month11, month12 ) 
                      VALUES (NULL, '".$customer_key."', '".$year_range."', '".$item_code."', '".$py."', 
                      '".$month01."', '".$month02."', '".$month03."', '".$month04."', '".$month05."', '".$month06."', 
                      '".$month07."', '".$month08."', '".$month09."', '".$month10."', '".$month11."', 
                      '".$month12."')";

$result = mysql_query($query, $db_conn);
echo "<font size=3 color=blue>You have added the commitment schedual for product $item_code, company $company for the years, $year_range</font>";

//echo "$num_results Records updated";

//echo "customer key= $customer_key<br>";
//echo "$company $year_range $item_code<br>";
//echo "$py<br>";

//echo "$month01<br>";
//echo "$month02<br>";
//echo "$month03<br>";
//echo "$month04<br>";
//echo "$month05<br>";
//echo "$month06<br>";
//echo "$month07<br>";
//echo "$month08<br>";
//echo "$month09<br>";
//echo "$month10<br>";
//echo "$month11<br>";
//echo "$month12<br>";

}

echo '<form method=POST action=commited.php>';
echo '<font size=3 color=blue>Select company, year range, and product code</font><br>';

      echo 'Company Name: ';
	  customerdropdown();
	  echo '<br>';

	  echo 'Year Range: ';
	  echo '<select name=year_range>';
	  echo '<option>2000';
	  echo '<option>2001';
	  echo '<option selected value=2003>2003';
	  echo '<option>2004';
	  echo '<option>2005';
	  echo '<option>2006';
	  echo '</select>';
	  echo '<br>';

	  echo 'Item code: ';
	  newitemdropdown();
	  echo '<br>';
	  echo '<br>';

	  echo '<font size=3 color=blue>Enter the commitments for the product code</font><br>';

echo " <TABLE cellSpacing=0 cellPadding=0 width='100' border=1>";
	  echo '<tr><td>Roll over:</td><td><input type=text name=py></td><tr>';
	  echo '<tr><td>Jan:</td><td><input type=text name=month01></td></tr>';
	  echo '<tr><td>Feb:</td><td><input type=text name=month02></td></tr>';
	  echo '<tr><td>Mar:</td><td><input type=text name=month03></td></tr>';
	  echo '<tr><td>Apr:</td><td><input type=text name=month04></td></tr>';
	  echo '<tr><td>May:</td><td><input type=text name=month05></td></tr>';
	  echo '<tr><td>Jun:</td><td><input type=text name=month06></td></tr>';
	  echo '<tr><td>Jul:</td><td><input type=text name=month07></td></tr>';
	  echo '<tr><td>Aug:</td><td><input type=text name=month08></td></tr>';
	  echo '<tr><td>Sep:</td><td><input type=text name=month09></td></tr>';
	  echo '<tr><td>Oct:</td><td><input type=text name=month10></td></tr>';
	  echo '<tr><td>Nov:</td><td><input type=text name=month11></td></tr>';
	  echo '<tr><td>Dec:</td><td><input type=text name=month12></td></tr>';
echo '</table>';


	  echo '<br><font size=3 color=blue>Click the button to add the record</font><br>';
	  echo '<input type="SUBMIT" name="SUBMIT" value="ADD"';
	  echo '</form>';


?>