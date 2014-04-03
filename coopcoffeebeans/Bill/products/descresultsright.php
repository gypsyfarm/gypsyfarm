<html>
<head>
<title>Product Description Update</title>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>
<img SRC="cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>
<br><center><h1>Product Description Maintenance</h1></center><br><br><br><br>
<center>
<form name="frmMain" action=descresultsleft.php method=post target="BUTTONSFRAME">
</center>


<?php
require("../../tables.php");
require("../../functions.php");
// create short variable names




# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

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



    if ($searchterm == '0')
	{

	echo '<font size=3 color=blue>Select Link on Left to Edit,<br>';
	echo 'or add to your product and click the Add button</font>';
	echo '<h4 align=left><INPUT TYPE="SUBMIT" value="Add"></h4>';
	}
  else
    {
   echo '<font size=3 color=blue>Edit item and press update, or select a new item to edit,<br>';
   echo 'or click on Add a new Product Description</font>';
   echo '<h4 align=left><INPUT TYPE="SUBMIT" value="Update"></h4>';
    }
//**********************************Gets the DataSet************************************
mysql_select_db($tbl_coop_item);

$query = "select * from  $tbl_item_description id where item_code = '$searchterm'";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);


//************************************************************************************
//********************************Begin Drawing the TABLE*****************************
//************************************************************************************
echo "<table>";


	echo '<input  type="hidden" name="action" value="';
	if  ($num_results == 0)
	{
	echo 'Add';
	}
    else
	{
    echo 'Update';
	}
	echo  '">';

    echo "\n";

//*******************************Show the item Code********************************
	echo '<tr><td>';
	echo '<b>Item Code:    </td><td>';
	echo "<input type=text name=item_code size=10 value=".stripslashes($row['item_code']).">";

       echo 'Inactive: <input type=checkbox name="item_active"';

     if ($row['item_active'] == "1")
         echo ' Checked>';
     else
         echo '>';


	echo "</td></tr>";
	echo "<tr><td>";


//****************************Show the Desciption *************************************

    echo '<tr><td>';
    echo '<b>Item Desc:</b>';
    echo '</td><td>';

    echo '<input type=text name=item_description size=100 value="';
    echo $row['item_description'];
    echo '">';
    echo '</td></tr>';



    echo "<tr><td colspan=2><hr></td></tr>";

    echo "<tr><td>";
    echo '<b>Rank:';
    echo "</td><td>";
    echo '<input type=text name=rank size=6 value="';
    echo $row['rank'];
    echo '">';
    echo "</td></tr>";


    echo "<tr><td>";
    echo '<b>Category:';
    echo "</td><td>";
#    echo '<input type=text name=category size=6 value="';
#    echo $row['category'];
#    echo '">';

    echo '<select name="category">';
    echo '<option value="1" ';
    if ($row['category'] == 1 ) {
       echo ' selected ';
    }
    echo '> Regular';
    echo '<option value="2" ';
        if ($row['category'] == 2 ) {
       echo ' selected ';
    }
    echo '> Decaffeinated';
    echo '<option value="3" ';
    if ($row['category'] == 3 ) {
       echo ' selected ';
    }
    echo '> Special Orders';
    echo "</select>";
    echo "</td></tr>";


    echo "<tr><td>";
    echo '<b>Weight (Bags Lbs):';
    echo "</td><td>";
    echo '<input type=text name=weight size=40 value="';
    echo $row['weight'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Total Purchase:';
    echo "</td><td>";
    echo '<input type=text name=total_pur size=15 value="';
    echo $row['total_pur'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Desc Notes:</b>';
    echo "</td><td>";
    echo '<textarea name="desc_notes" type="text" width=200 maxlength="255" id="desc_notes" style="height:50px;width:300px;">'.$row['desc_notes'].'</textarea>';
    echo "</td></tr>";



echo "</table>";
?>
</form>
 
</BODY>


</HTML>
