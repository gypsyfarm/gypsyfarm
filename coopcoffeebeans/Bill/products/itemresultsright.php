<html>
<head>
<title>Lott and Product Maintenance</title>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>
<img SRC="cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>
<br><center><h1>Lot and Product Maintenance</h1></center><br><br><br><br>
<center>
<form name="frmMain" action=itemresultsleft.php method=post target="BUTTONSFRAME">
</center>

<SCRIPT LANGUAGE="JavaScript">
<!--
  function transfer()
  {
    // alter the action and submit the form
   // document.frmMain.action.value = "transfer";
   //document.frmMain['action'].value = "transfer";   
   
 //  alert(document.frmMain.transwarehouse.options.selectedIndex);    
 
   
     if ( document.frmMain.transwarehouse.options.selectedIndex > 0) {
        document.frmMain.action = "transfer.php";
        document.frmMain.target = "_parent";
        document.frmMain.submit();
     }
     else {
        alert("You must select a warehouse for transfer.");
     }      
  }


// -->
</SCRIPT>

<?php
require("../../tables.php");
require("../../functions.php");


// create short variable names




# set up connection string to database.
  $db_conn = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');
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
    if ($searchterm == 0)
	{
	//echo 'We should be adding a record here
	echo '<h1 align=left><INPUT TYPE="SUBMIT" value="Add"></h1>';
	echo '<font size=3 color=blue>Click Link on the Left side of this Page to Edit,<br>';
	echo 'or to add a new lot click the Add button located above.</font>';

	}
  else
    {
   echo '<font size=3 color=blue>Edit item and press update, or select a new item to edit,<br>';
   echo 'or click on Add a new Product</font>';
   echo '<h1 align=left><INPUT TYPE="SUBMIT" value="Update"></h1>';
    }
//**********************************Gets the DataSet************************************
mysql_select_db($tbl_coop_item);

# $query = "select * from $tbl_coop_item ci, $tbl_item_description id where item_id = $searchterm";

$query = "select ci.item_id, ci.item_code, ci.lot_ship, ci.warehouse,
          ci.item_description, id.item_description as generic_description, ci.member_price, ci.non_member_price,
          ci.mark, ci.warehouse_code, ci.cost, ci.quantity, ci.transfer_in, ci.transfer_out,
          id.weight as bag_lbs,ci.green_cb, ci.spot_available, ci.green_comment,
          ci.STATUS, ci.ship_date, ci.arrival_date, ci.ft_item, ci.org_item,
          ci.item_notes, ci.item_active, id.rank
          from $tbl_coop_item ci, $tbl_item_description id
          where ci.item_id = $searchterm
             and ci.item_code = id.item_code ";


$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);


echo '<input type=hidden name=action_type size=10 value="transfer">';
echo '<input  type="hidden" name="r_action" value="';
if  ($num_results == 0)	{
    echo 'Add';
}
else {
    echo 'Update';
}
echo  '">';

//************************************************************************************
//********************************Begin Drawing the TABLE*****************************
//************************************************************************************




echo "<table>";

# cut was here...
//********************************Gets the item ID**********************************
     echo"<tr><td>";
	 echo '<input type=hidden name=item_id size=10 value="';
     echo stripslashes($row['item_id']);
     echo '">';
	 echo "</td><td>";
//*******************************If adding echo the Dropdown Box******************
#	 if ($searchterm == 0)
#	 {

    echo "\n";
	 echo '<tr><td>';
	 echo '<b>Item Code:</td><td>';
	 newitemdropdown($row['item_code'],"item_code");
	 echo '<tr><td>';
#	 }
//*******************************Show the item Code********************************
#	echo '<tr><td>';
#	echo '<b>Item Code:    </td><td>';
#	echo "<input type=text name=item_code size=10 value=".stripslashes($row['item_code'])."></td></tr>";
#	echo "<tr><td>";
//*******************************Show Lot Ship**************************************
   echo "\n";
	echo '<b>Lot_ship: </td><td>';
	echo '<input type=text name=lot_ship size=4 value="';
	echo $row['lot_ship'];
	echo '"></td></tr>';
//******************************Is the item Active**********************************
	echo "<tr><td>";
	echo "<br>";
    echo 'Inactive: <input type=checkbox name="item_active"';

     if ($row['item_active'] == "1")
         echo ' Checked>';
     else
         echo '>';
         
    #	echo "<br>";
    echo 'Green Report: <input type=checkbox name="green_cb"';

     if ($row['green_cb'] == "1")
         echo ' Checked>';
     else
         echo '>';     
         
         
     echo '</td></tr>';
//****************************Show the Warehouse*************************************
	echo "<tr><td>";
	echo '<b>Warehouse:';
	echo "</td><td>";


#	echo '<input type=text name=warehouse size=6 value="';
#	echo $row['warehouse'];
#	echo '">';

$warehouse =  $row['warehouse'];
if (!isSet($warehouse)) {
    $warehouse='N';
}

    echo  " \n ";
    echo '<br>';
    warehousedropdown($warehouse);
    echo '<br>';
    echo  " \n ";

	echo "</td></tr>";



    echo '<tr><td>';
    echo '<b>Item Desc:</b>';
    echo '</td><td>';

    echo '<input type=text name=item_description size=100 value="';
    echo $row['item_description'];
    echo '">';
    echo '</td></tr>';


       echo '<tr><td>';
     echo '<b>DD Desc:</b>';
    echo '</td><td>';
     echo '<input disabled type=text name=generic_description size=100 value="';
    echo $row['generic_description'];
    echo '">';
    echo '</td></tr>';
    
   
       echo "<tr><td>";
    echo '<b>Spot Available:';
    echo "</td><td>";
    echo '<input type=text name=spot_available size=10 value="';
    echo $row['spot_available'];
    echo '">';
    echo "</td></tr>";
   
    
           echo '<tr><td>';
     echo '<b>Green Comment:</b>';
    echo '</td><td>';
     echo '<input type=text name=green_comment size=50 value="';
    echo $row['green_comment'];
    echo '">';
    echo '</td></tr>';


    echo "<tr><td colspan=2><hr></td></tr>";

    echo "<tr><td>";
    echo '<b>Member Price:';
    echo "</td><td>";
    echo '$'.'<input type=text name=member_price size=6 value="';
    echo $row['member_price'];
    echo '">';
    echo "</td></tr>";


    echo "<tr><td>";
    echo '<b>Non Member Price:';
    echo "</td><td>";
    echo '<input type=text name=non_member_price size=6 value="';
    echo $row['non_member_price'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Mark:';
    echo "</td><td>";
    echo '<input type=text name=Mark size=40 value="';
    echo $row['mark'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Warehouse code:';
    echo "</td><td>";
    echo '<input type=text name=warehouse_code size=40 value="';
    echo $row['warehouse_code'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Cost:';
    echo "</td><td>";
    echo '<input type=text name=cost size=40 value="';
    echo $row['cost'];
    echo '">';
    echo "</td></tr>";


    echo "<tr><td>";
    echo '<b>Quantity:';
    echo "</td><td>";
    echo '<input type=text name=quantity size=40 value="';
    echo $row['quantity'];
    echo '">';

    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Prev In:';
    echo "</td><td>";
    echo '<input type=text name=transfer_in size=40 readonly value="';
    echo $row['transfer_in'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Prev Out:';
    echo "</td><td>";
    echo '<input type=text name=transfer_in readonly size=40 value="';
    echo $row['transfer_out'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
   # echo '<INPUT TYPE="SUBMIT" value="transfer">';
    echo ' <INPUT TYPE=BUTTON VALUE="Transfer" ONCLICK="transfer();">';
    echo "</td><td>";
    echo '<input type=text name=transfer_amt size=40 value="0">';


    transferwarehouse($warehouse);
    echo "</td></tr>";


    echo "<tr><td>";
    echo '<b>Bags Lbs:';
    echo "</td><td>";
    echo '<input type=text name=bags_lbs disabled size=40 value="';
    echo $row['bag_lbs'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Status:';
    echo "</td><td>";
    echo '<input type=text name=status size=40 value="';
    echo $row['STATUS'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Shipping Date:';
    echo "</td><td>";
    echo '<input type=text name=ship_date size=40 value="';
    echo $row['ship_date'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Arrival Date:';
    echo "</td><td>";
    echo '<input type=text name=darrival_date size=40 value="';
    echo $row['arrival_date'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Ft Item:';
    echo "</td><td>";
    echo '<input type=text name=ft_item size=10 value="';
    echo $row['ft_item'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Org Item:';
    echo "</td><td>";
    echo '<input type=text name=org_item size=10 value="';
    echo $row['org_item'];
    echo '">';
    echo "</td></tr>";


    echo "<tr><td>";
    echo '<b>Item Notes:</b>';
    echo "</td><td>";
    echo '<textarea name="item_notes" type="text" width=200 maxlength="255" id="item_notes" style="height:50px;width:300px;">'.$row['item_notes'].'</textarea>';
    echo "</td></tr>";


	echo "<tr><td colspan=2><hr></td></tr>";


echo "</table>";
?>
</form>
<center>

<BR>
<CENTER>| <A href="http://www.cooperativecoffees.com/index.html"
target=_top>Home Page</A> |<BR>
<P></P>
<P align=center><FONT size=-2>This online environment created
by:<BR><ALIGN=CENTER><A href="mailto:goshawk@gypsyfarm.com">Gypsyfarm
(sm)</A></FONT> </P></CENTER>

</BODY>


</HTML>
