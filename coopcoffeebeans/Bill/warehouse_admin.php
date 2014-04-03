<?php
//function showpassingvars(){
	//echo"Get: ";
 	//foreach($_GET as $pram=>$value){
 	//	echo"$pram: $value, ";
 	//}
	//echo"<br>Post: ";
 	//foreach($_POST as $pram=>$value){
 	//	echo"$pram: $value, ";
 	//}
 	//echo"<br>Session: ";
 	//foreach($_SESSION as $pram=>$value){
 	//	echo"$pram: $value, ";

// }
//showpassingvars();

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
  echo '<font size=3><a href="../logout.php">Log Out</a></font>';
  echo '<font size=6><center>Warehouse Table Maintenance</center></font><br><br><br><br><br>';
// create short variable names
# this field will need to come from login screen.

  $current_id=$_REQUEST['current_id'];
  $warehouse=$_REQUEST['warehouse'];


# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }
//*************************************************************************************
//							The Form Starts Here
//*************************************************************************************


      echo '<form method=POST action=warehouse_admin.php>';


      echo 'Choose a Mode!<br>';
	  echo '<input type="SUBMIT" name="ACTION" value="EDIT">';
	  echo '<input type="SUBMIT" name="ACTION" value="ADD">';
if ($_REQUEST['ACTION'] == 'ADD'){
	echo '<font size=3 color=blue>You are currently in ADD Mode';
	}
if ($_REQUEST['ACTION'] == 'EDIT'){
	echo '<font size=3 color=blue>You are currently in EDIT Mode';
	}
	echo '<br><br>';

//********************This section handles the add to the datbase and New Records*****
if (($_REQUEST['ACTION'] == 'ADD_Record') or ($_REQUEST['ACTION'] == 'ADD')){
      echo '<font size=3 color=blue>Select company, year range, and product code</font><br>';

     echo 'Company Name: ';
	  customerdropdown($company);
	  echo '<br>';

	  echo 'Year Range: ';
	  echo '<select name=year_range>';
	  echo '<option value=2000>2000';
	  echo '<option value=2001>2001';
	  echo '<option selected value=2002>2002';
	  echo '<option value=2003>2003';
	  echo '<option value=2004>2004';
	  echo '<option value=2005>2005';
	  echo '<option value=2006>2006';
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
      echo '<input type="SUBMIT" name="ACTION" value="ADD_Record">';
	//  echo '</form>';
}


if ($_REQUEST['ACTION'] == 'Edit_Record')
{
//echo $_REQUEST['RADIO'];
$radio=$_REQUEST['RADIO'];
//echo '<br>';

//$py=$_REQUEST['py'.$radio];
//$month01=$_REQUEST['month01'.$radio];
//$month02=$_REQUEST['month02'.$radio];
//$month03=$_REQUEST['month03'.$radio];
//$month04=$_REQUEST['month04'.$radio];
//$month05=$_REQUEST['month05'.$radio];
//$month06=$_REQUEST['month06'.$radio];
//$month07=$_REQUEST['month07'.$radio];
//$month08=$_REQUEST['month08'.$radio];
//$month09=$_REQUEST['month09'.$radio];
//$month10=$_REQUEST['month10'.$radio];
//$month11=$_REQUEST['month11'.$radio];
//$month12=$_REQUEST['month12'.$radio];
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


mysql_select_db($tbl_coop_commited);
$query = 'Update '.$tbl_coop_commited.' set py="'.$py.'", month01="'.$month01.'", month02="'.$month02.'", month03="'.$month03.'",month04="'.$month04.'",month05="'.$month05.'",month06="'.$month06.'", month07="'.$month07.'",month08="'.$month08.'",month09="'.$month09.'", month10="'.$month10.'", month11="'.$month11.'", month12="'.$month12.'" where commited_id="'.$radio.'"';
$result = mysql_query($query, $db_conn);


}

if ($_REQUEST['ACTION'] == 'ADD_Record')
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
$query = "select contact_id from $tbl_coop_contact where Company = '".$company."'";
//echo $query;

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$customer_key=$row['contact_id'];

//echo 'OK Dokey Smokey';

mysql_select_db($tbl_coop_commited);
$query = "INSERT INTO $tbl_coop_commited ( commited_id, customer_key, import_yr, item_code, 
                      py, month01, month02, month03, month04, month05, month06, month07, month08,
                       month09, month10, month11, month12 ) 
                       VALUES (NULL, '".$customer_key."', '".$year_range."', '".$item_code."',
                        '".$py."', '".$month01."', '".$month02."', '".$month03."', '".$month04."',
                         '".$month05."', '".$month06."', '".$month07."', '".$month08."', 
                         '".$month09."', '".$month10."', '".$month11."', '".$month12."')";

$result = mysql_query($query, $db_conn);
//echo "<font size=3 color=blue>You have added the commitment schedual for product $item_code, company $company for the years, $year_range</font>";

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


//************************************************************************************
//								Edit an Existing Record
//************************************************************************************


if (($_REQUEST['ACTION'] == 'EDIT') or ($_REQUEST['ACTION'] == 'View_Record') or ($_REQUEST['ACTION'] == 'Delete_Record') or ($_REQUEST['ACTION'] == 'Edit_Record'))
{

$warehouse=$_REQUEST['warehouse'];
      echo '<font size=3 color=blue>Select a Warehouse</font><br>';
	  warehousedropdown($warehouse);
	  
	  echo '<br>';
	  echo '<input type="SUBMIT" name="ACTION" value="View_Record">';

}
if ($_REQUEST['ACTION'] == 'Delete_Record'){

echo '<br><br>You have Deleted Record# '.$_REQUEST['RADIO'].' from the Dataset';

$radio=$_REQUEST['RADIO'];
mysql_select_db($tbl_coop_commited);
$query = "Delete from $tbl_coop_commited where commited_id = \"$radio\" ";
$result = mysql_query($query, $db_conn);

}



if (($_REQUEST['ACTION'] == 'View_Record') or ($_REQUEST['ACTION'] == 'Delete_Record') or ($_REQUEST['ACTION'] == 'Edit_Record')){

 $company=$_REQUEST['Company_Name'];
 echo '<input type=hidden name=Save_Company_Name value="'.$company.'">';

//*********This if statement reselects the previous table if there was a delete********
//******************So you can see the result of your delete***************************

 if (($_REQUEST['ACTION'] == 'Delete_Record') or ($_REQUEST['ACTION'] == 'Edit_Record'))
 {
 $company=$_REQUEST['Save_Company_Name'];
 echo '<input type=hidden name=Save_Company_Name value="'.$company.'">';
 }
//**************************************************************************************
 
$db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');

mysql_select_db($tbl_coop_warehouse);
$query = "select * from $tbl_coop_warehouse where warehouse_code=\"$warehouse\"";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);

echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";
echo '<tr><th align=center><font size=2 color=blue>Warehouse Code</font></th>';
echo '<th align=center><font size=2 color=blue>Warehouse Description</font></th>';
echo '<th align=center><font size=2 color=blue>Select</font></th><tr>';



for ($i=0; $i <$num_results;  $i++)
  {
  
  $row = mysql_fetch_array($result);
  $warehouse_id = $i;
 
 echo "<tr><td><input type=text size=25 name=Code$record_id value=>".$row['warehouse_code']."</td>";
 echo "<td><input type=text size=25 name=Description\"$record_id\" value=";
 echo $row['warehouse_description'];
 echo '></td>';
 echo "<td><INPUT TYPE=\"RADIO\" NAME=\"RADIO\" Value=\"$record_id\" size=2></td></tr>";
  }
    
  echo '</table>';
  echo '<input type="SUBMIT" name="ACTION" value="Delete_Record">';
  echo '<input type="SUBMIT" name="ACTION" value="Edit_Record">';
}
echo '</form>';

?>