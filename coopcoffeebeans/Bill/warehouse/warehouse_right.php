
<html>
<head>
<title>Warehouse Update</title>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>
<img SRC="cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>
<br><center><h1>Warehouse Maintenance</h1></center><br><br><br><br>
<center>
<form name="frmMain" action=warehouse_left.php method=post target="BUTTONSFRAME">
</center>


<?php
require("../../tables.php");
require("../../functions.php");
// create short variable names




# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }



//**********************************Extract the Variables*************************
$searchtype=$HTTP_GET_VARS['searchtype'];
$searchterm=$HTTP_GET_VARS['searchterm'];


//****************Fixes Errors on startup if no searchterm is present**************

if (!isset($searchterm)){
$searchterm=0;
}
else
{

  $searchterm = trim($searchterm);
  $searchtype = addslashes($searchtype);
  $searchterm = addslashes($searchterm);
}
//***********************************Puts in the appropriate buttons*******************
    if ($searchterm == 0)
	{
	//echo 'We should be adding a record here
	echo '<font size=3 color=blue>Select record on Left to Edit,<br>';
	echo 'or add your product and click the Add button</font>';
	echo '<h1 align=right><INPUT TYPE="SUBMIT" value="Add"></h1>';
	}
  else
    {
   echo '<font size=3 color=blue>Edit item and press update, or select a new item to edit,<br>';
   echo 'or click on Add a new Product</font>';
   echo '<h1 align=right><INPUT TYPE="SUBMIT" value="Update"></h1>';
    }
//**********************************Gets the DataSet************************************
mysql_select_db($tbl_coop_warehouse);

//echo $searchterm;
$query = "select * from $tbl_coop_warehouse where warehouse_code = \"$searchterm\"";


$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result); 

echo 'The search results are'.$num_results;    


//************************************************************************************
//********************************Begin Drawing the TABLE*****************************
//************************************************************************************
echo "<table>";


	echo '<input  type="hidden" name="action" value="';
	if  ($num_results == 0)
	{
	//echo 'Add';
	}
    else
	{
    //echo 'Update';
	}
	echo  '">';
//**************************Displays Warehouse Code**********************************
     echo"<tr><td>";
	 echo '<b>Warehouse Code: </td><td>';
	 echo '<input type=text name=warehouse_code size=10 value="';
     echo stripslashes($row['warehouse_code']);
     echo '">';
	 echo "</td><td>";

//*******************************Show Lot Ship**************************************
   echo "\n";
	echo '<b>Warehouse Description: </td><td>';
	echo '<input type=text name=warehouse_description size=25 value="';
	echo $row['warehouse_description'];
	echo '"></td></tr>';

echo "</table>";
?>
</form>


</BODY>


</HTML>
