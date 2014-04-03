 <html>
<head>
<title>Transfer </title>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>

<table width=100% border=0 >
<tr>
<td>
<img SRC="cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT> 
</td>
<td>
<br><center><h1>Product Transfer</h1></center><br><br><br><br> 
</td>
<td >

<font size=3><a href="index.html" target="_top">Back to Products</a></font><br>
<font size=3><a href="../../index.php" target="_top">Back to the Menu</a></font><br>
<font size=3><a href="../../logout.php" target="_top">Log out</a></font><br>
</td>
</tr>
</table>
<br>
<center>
<form name="frmMain" action=transfer.php method=post >
</center>


<SCRIPT LANGUAGE="JavaScript">
<!--
  function transfer()
  {

  // document.frmMain['action_type'].value = "xxdo_it";
   document.frmMain.submit();
  }


// -->
</SCRIPT>


<?php
require("../../tables.php");
require("../../functions.php");
     $action_type=$_REQUEST['action_type'];
#  echo "action is ".$action_type."<br>";

# Get form variables:

$item_id=$_REQUEST['item_id'];
$item_code=$_REQUEST['item_code'];
$lot_ship=$_REQUEST['lot_ship'];
$item_active=$_REQUEST['item_active'];
$warehouse=$_REQUEST['warehouse'];
$item_description=$_REQUEST['item_description'];
$member_price=$_REQUEST['member_price'];
$transfer_in=$_REQUEST['transfer_in'];
$non_member_price=$_REQUEST['non_member_price'];
$mark=$_REQUEST['Mark'];
$warehouse_code=$_REQUEST['warehouse_code'];
$cost=$_REQUEST['cost'];
$quantity=$_REQUEST['quantity'];
$bags_lbs=$_REQUEST['bags_lbs'];
$status=$_REQUEST['status'];
$ship_date=$_REQUEST['ship_date'];
$arrival_date=$_REQUEST['arrival_date'];
$ft_item=$_REQUEST['ft_item'];
$org_item=$_REQUEST['org_item'];
$item_notes=$_REQUEST['item_notes'];
$transwarehouse=$_REQUEST['transwarehouse'];
$oldwarehouse=$_REQUEST['old_warehouse'];
$item_id = $_REQUEST['item_id'];
$new_id = $_REQUEST['new_id'];



# Now lets see what we need

#echo 'item_code is '.$item_code;
#echo 'lot_ship is '.$lot_ship;
#echo 'warehouse is '.$warehouse;
#echo 'new warehouse is '.$transwarehouse;
echo '<br>';


 if ($action_type == "add")

  {
#  echo "add....action_type is $action_type";

 # $warehouse=$_REQUEST['old_warehouse'];

   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

    $query = "insert into $tbl_coop_item
              ( item_id, item_code, lot_ship, warehouse, item_description,
                member_price, non_member_price, mark, warehouse_code,
                cost, quantity,   transfer_in, status, ship_date, arrival_date,
                ft_item, org_item, item_notes, item_active)
              values ( NULL,'$item_code',
                  '$lot_ship','$warehouse','$item_description',
               '$member_price','$non_member_price','$mark',
               '$warehouse_code','$cost','$quantity','$transfer_in',
               '$status','$ship_date','$arrival_date','$ft_item',
               '$org_item','$item_notes','$item_active')";

      # echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result)
        echo "<br><font size=2>Add Failed";
     else
        echo "<br><font size=2>Record Added";


  $new_id=mysql_insert_id();
 # echo '<br> new id is '.$new_id.'<br>';


# Now update
    $query = "update  $tbl_coop_item
                       set transfer_out = transfer_out + $transfer_in
                       where item_id = $item_id";

     #  echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result)
        echo "<br><font size=2>Add Failed";
     else
        echo "<br><font size=2>Record Added";



   $query = "insert into $tbl_transfer_detail
              ( detail_id, transfer_amt, item_id_from, item_id_to, transfer_date)
              values ( NULL ,'$transfer_in','$item_id',
                  '$new_id',CURDATE())";

      # echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result)
        echo "<br><font size=2>Transfer detail Add Failed";
     else
        echo "<br><font size=2>Transfer Detail Record Added";



   }


 if ($action_type == "update")

  {
#  echo "update....action_type is $action_type";

 # $warehouse=$_REQUEST['old_warehouse'];

   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

    $query = "update $tbl_coop_item
                     set transfer_in = transfer_in + $transfer_in
              where item_id = $new_id ";


    #   echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result)
        echo "<br><font size=2>updated for transfer in Failed";
     else
        echo "<br><font size=2>Transfer in Record updated";

  echo '<br> new id is '.$new_id.'<br>';


# Now update
    $query = "update  $tbl_coop_item
                       set transfer_out = transfer_out + $transfer_in
                       where item_id = $item_id";

    #   echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result)
        echo "<br><font size=2>Update transfer out Failed";
     else
        echo "<br><font size=2>Transfer out Record updated";



   $query = "insert into $tbl_transfer_detail
              ( detail_id, transfer_amt, item_id_from, item_id_to, transfer_date)
              values ( NULL ,'$transfer_in','$item_id',
                  '$new_id',CURDATE())";

   #    echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result)
        echo "<br><font size=2>Transfer detail Add Failed";
     else
        echo "<br><font size=2>Transfer Detail Record Added";



   }









if ($action_type == "transfer") {
//**********************************Gets the DataSet************************************

 # echo "transfer....action_type is $action_type";
  $transfer_in = $_REQUEST['transfer_amt'];
 # echo 'transfer amount is '.$transfer_in;

      echo ' <INPUT TYPE=BUTTON VALUE="Transfer" ONCLICK="transfer();">';
    echo '<b> From '.$warehouse.' To '. $transwarehouse.'</b>';


   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

mysql_select_db($tbl_coop_item);


$query = "select ci.item_id, ci.item_code, ci.lot_ship, ci.warehouse,
          ci.item_description, id.item_description as generic_description, ci.member_price, ci.non_member_price,
          ci.mark, ci.warehouse_code, ci.cost, ci.quantity, ci.transfer_in, ci.transfer_out,
          id.weight as bag_lbs,
          ci.STATUS, ci.ship_date, ci.arrival_date, ci.ft_item, ci.org_item,
          ci.item_notes, ci.item_active, id.rank
          from $tbl_coop_item ci, $tbl_item_description id
            where ci.item_code ='$item_code'
              and ci.lot_ship = '$lot_ship'
              and ci.warehouse = '$transwarehouse'
              and ci.item_code = id.item_code";

# echo "<br>$query <br>";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);

if ($num_results == 0) {
   echo "<br> in add mode<br>";
   $action_type = 'add';   
   $read_only = '  ';
}
else {
   echo "<br> in update mode <br>";
   $read_only = 'readonly';
   $action_type = 'update';
   $row = mysql_fetch_array($result);
   $item_code=$row['item_code'];
   $lot_ship=$row['lot_ship'];
   $item_active=$row['item_active'];
   $warehouse=$row['warehouse'];
   $item_description=$row['item_description'];
   $member_price=$row['member_price'];
   $transfer_in=$row['transfer_in'];
   $non_member_price=$row['non_member_price'];
   $mark=$row['mark'];
   $warehouse_code=$row['warehouse_code'];
   $cost=$row['cost'];
   $quantity=$row['quantity'];
   $bags_lbs=$row['bags_lbs'];
   $status=$row['status'];
   $ship_date=$row['ship_date'];
   $arrival_date=$row['arrival_date'];
   $ft_item=$row['ft_item'];
   $org_item=$row['org_item'];
   $item_notes=$row['item_notes'];
   $new_id = $row['item_id'];


}
# echo "<br>results from query is $num_results <br>";



}








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



if ($action_type == "create") {
//**********************************Gets the DataSet************************************
mysql_select_db($tbl_coop_item);

# $query = "select * from $tbl_coop_item ci, $tbl_item_description id where item_id = $searchterm";

$query = "select ci.item_id, ci.item_code, ci.lot_ship, ci.warehouse,
          ci.item_description, id.item_description as generic_description, ci.member_price, ci.non_member_price,
          ci.mark, ci.warehouse_code, ci.cost, ci.quantity, ci.transfer_in, ci.transfer_out,
          id.weight as bag_lbs,
          ci.STATUS, ci.ship_date, ci.arrival_date, ci.ft_item, ci.org_item,
          ci.item_notes, ci.item_active, id.rank
          from $tbl_coop_item ci, $tbl_item_description id
          where ci.item_id = $searchterm
             and ci.item_code = id.item_code ";


$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);

}


//************************************************************************************
//********************************Begin Drawing the TABLE*****************************
//************************************************************************************
echo "<table>";

	 echo '<input type=hidden name=action_type size=10 value="'.$action_type.'">';


//********************************Gets the item ID**********************************
     echo"<tr><td colspan=2>";  
     
     echo "<table width=75%>";
     echo '<tr>';
     echo '<td>';

	 echo '<input type=hidden name=item_id size=10 value="'.$item_id.'">';
	 echo '<input type=hidden name=new_id size=10 value="'.$new_id.'">';


//*******************************If adding echo the Dropdown Box******************


         echo '<input type=hidden name=item_code value="'.$item_code.'">';

         echo "\n";

	 echo '<b>Item Code: '.$item_code.'</td></tr>';


	 echo "<br>";
	 echo '</td><td>';

//*******************************Show Lot Ship**************************************
   echo "\n";
	echo '<b>Lot_ship:  ';

	echo '<input type=text name=lot_ship size=4  readonly  value="';
	echo $lot_ship;
	echo '"></td> ';
//******************************Is the item Active**********************************
	echo " <td>";
     #	echo "<br>";

    echo 'Inactive: <input type=checkbox '.$read_only.' name="item_active"  ';

     if ($item_active == "1")
         echo ' Checked>';
     else
         echo '></td> ';
//****************************Show the Warehouse*************************************
	echo " <td>";
	echo '<b>Warehouse:';
	echo "  ";

        echo $transwarehouse;
        echo  " \n ";
        echo '<input type=hidden name=warehouse size=10 value="'.$transwarehouse.'">';
        echo '<input type=hidden name=old_warehouse size=10 value="'.$warehouse.'">';


    echo  " \n ";

	echo "</td></tr>";    
	echo '</table>';
	echo '</td></tr>';


        echo "\n";
    echo '<tr><td>';
    echo '<b>Item Desc:</b>';
    echo '</td><td>';

    echo '<input type=text name=item_description size=75 '.$read_only.' value="';
    echo $item_description;
    echo '">';
    echo '</td></tr>';

            echo "\n";
    echo "<tr><td colspan=2><hr></td></tr>";
            echo "\n";
    echo "<tr><td>";

    echo '<b>Member Price:';
    echo "</td><td>";
    echo '$'.'<input type=text name=member_price  '.$read_only.' size=6 value="';
    echo $member_price;
    echo '">';
    echo "</td></tr>";

            echo "\n";
    echo "<tr><td>";

    echo '<b>Non Member Price:';
    echo "</td><td>";
    echo '<input type=text name=non_member_price '.$read_only.'  size=6 value="';
    echo $non_member_price;
    echo '">';
    echo "</td></tr>";
            echo "\n";
    echo "<tr><td>";

    echo '<b>Mark:';
    echo "</td><td>";
    echo '<input type=text name=Mark '.$read_only.'  size=40 value="';
    echo $mark;
    echo '">';
    echo "</td></tr>";
            echo "\n";
    echo "<tr><td>";

    echo '<b>Warehouse code:';
    echo "</td><td>";
    echo '<input type=text name=warehouse_code '.$read_only.'  size=40 value="';
    echo $warehouse_code;
    echo '">';
    echo "</td></tr>";
           echo "\n";
    echo "<tr><td>";

    echo '<b>Cost:';
    echo "</td><td>";
    echo '<input type=text name=cost '.$read_only.'   size=40 value="';
    echo $cost;
    echo '">';
    echo "</td></tr>";

           echo "\n";
    echo "<tr><td>";

    echo '<b>Quantity:';
    echo "</td><td>";
    echo '<input type=text name=quantity '.$read_only.'  size=40 value="';
    if   ($action_type == 'add') 
        echo 0;
    else    
        echo $quantity;
        
    echo '">';

    echo "</td></tr>";
           echo "\n";
    echo "<tr><td>";
    echo '<b>transfer In:';
    echo "</td><td>";
    echo '<input type=text name=transfer_in size=40 value="'.$transfer_in.'">';

    echo "</td></tr>";

            echo "\n";
    echo "<tr><td>";

    echo '<b>Bags Lbs:';
    echo "</td><td>";
    echo '<input type=text name=bags_lbs readonly size=40 value="';
    echo $bags_lbs;
    echo '">';
    echo "</td></tr>";
         echo "\n";
    echo "<tr><td>";

    echo '<b>Status:';
    echo "</td><td>";
    echo '<input type=text name=status '.$read_only.'  size=40 value="';
    echo $status;
    echo '">';
    echo "</td></tr>";
          echo "\n";
    echo "<tr><td>";

    echo '<b>Shipping Date:';
    echo "</td><td>";
    echo '<input type=text name=ship_date '.$read_only.'  size=40 value="';
    echo $ship_date;
    echo '">';
    echo "</td></tr>";
          echo "\n";
    echo "<tr><td>";

    echo '<b>Arrival Date:';
    echo "</td><td>";
    echo '<input type=text name=arrival_date '.$read_only.'  size=40 value="';
    echo $arrival_date;
    echo '">';
    echo "</td></tr>";
           echo "\n";
    echo "<tr><td>";

    echo '<b>Ft Item:';
    echo "</td><td>";
    echo '<input type=text name=ft_item '.$read_only.'  size=10 value="';
    echo $ft_item;
    echo '">';
    echo "</td></tr>";
           echo "\n";
    echo "<tr><td>";

    echo '<b>Org Item:';
    echo "</td><td>";
    echo '<input type=text name=org_item '.$read_only.'  size=10 value="';
    echo $org_item;
    echo '">';
    echo "</td></tr>";

          echo "\n";
    echo "<tr><td>";

    echo '<b>Item Notes:</b>';
    echo "</td><td>";
    echo '<textarea name="item_notes" type="text" '.$read_only.' width=200 maxlength="255" id="item_notes" style="height:50px;width:300px;">'.$item_notes.'</textarea>';
    echo "</td></tr>";

            echo "\n";
	echo "<tr><td colspan=2><hr></td></tr>";


echo "</table>";
?>
</form>


</BODY>


</HTML>
