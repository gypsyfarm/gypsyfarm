<?php

require("../tables.php");
require("../functions.php");

$subbtn=$_REQUEST['subbtn'];


// check security
 session_start();

// check session variable

  if (isset($_SESSION['valid_user']))
  {
    $valid_user = $_SESSION['valid_user'];
    $order_id = $_GET['order_id'];
    $status = $_REQUEST['status'];
  }
  else
  {
   header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
  }

?>
<html>
<head>
  <title>Bank Processing Page 2:</title>
  <META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="../general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff >

<SCRIPT LANGUAGE="JavaScript">
  <!-- Begin
  function varitext(text){
  text=document
  print(text)
  }
  // End -->
  </script>


<script language="Javascript">

function isinteger(num) {
   var status;
   status = true;
   if ((!isFinite(num)) || (num.indexOf(".") != -1) || (num < 0))
      status = false;
   return status;
}

function addCommas(num) {
   if (!isinteger(num)) return num;

   var i, cnt, val
   cnt = 0;
   val = "";
   for(i = num.length ; i > 0 ; i--) {
      val = num.substr(i - 1, 1) + val;
      cnt = cnt + 1;
      if ((cnt == 3) && (i > 1)) {
         val = "," + val;
         cnt = 0;
      }
   }
   return val;
}


function fmtmoney(str) {
   var nmbr, decimal, before, after;
   nmbr = str.replace(/[$,]/g,[]);

   if (!isFinite(nmbr)) return false;

   decimal = nmbr.indexOf(".");
   if (decimal == -1) {
      before = nmbr;
      after = "00";
   }
   else {
      before = nmbr.substr(0, decimal);
      if (before.length == 0) before = "0";

      after = nmbr.substr(decimal + 1, 2);
      if (after.length == 0) after = "00";
      if (after.length == 1) after = after + "0";
   }

   before = addCommas(before);
   return before + "." + after;
}


function tstmoney(str) {
       var nmbr, decimal, before, after;
      nmbr = str.replace(/[$,]/g,[]);

   if (!isFinite(nmbr)) return false;

   decimal = nmbr.indexOf(".");
   if (decimal == -1) {
      before = nmbr;
      after = "00";
   }
   else {
      before = nmbr.substr(0, decimal);
      if (before.length == 0) before = "0";

      after = nmbr.substr(decimal + 1, 2);
      if (after.length == 0) after = "00";
      if (after.length == 1) after = after + "0";
   }
     before = addCommas(before);
     return before + "." + after;
}

</script>
<!--
<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>
-->
<?PHP
 echo "<form name='frmMain' action=bankorder2.php?order_id=".$order_id." method=post>";
 
 ?>

 
<table width=100%>
<tr>
<td>
<font size=3><a href="../index.php">Back to the Menu</a></font><br>
<font size=3><a href="bankorder1.php">Process more Orders</a></font><br>
<font size=3><a href="../logout.php">Log out</a></font><br>
</td> 
 
 <td colspan=2 align=center>
 <h2>
Cooperative Coffee Bank Approval Page

</td>
<td>
  <INPUT NAME="print" TYPE="button" VALUE="Print DO"
  ONCLICK="varitext()">
</td>

</tr>
</table>

</h2></center><br> 
 


<?php

//**************************************************************************************
//******************************Order Invoice Section********************************
//**************************************************************************************

# connect to database
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }


 if ($subbtn == "Approve") {
   mysql_select_db($tbl_order_header);
      if ($status == 'H') {
         $status = 'S';
      } 
      else {
         $status = 'A';
      }
      $query = " update $tbl_order_header set STATUS = '$status',
                        approval_by = '$valid_user',
                        approval_date = now()
                where header_id =  '$order_id';";


      $update_lot = mysql_query($query, $db_conn);

    echo "<font color=red><b> Order has been approved by $valid_user </b></font> ";

 }


  if ($subbtn == "Reject") {
   mysql_select_db($tbl_order_header);

      $query = " update $tbl_order_header set STATUS = 'I'
                where header_id =  '$order_id';";
      $update_lot = mysql_query($query, $db_conn);

    echo "<font color=red><b> Order has been Rejected by $valid_user </b></font> ";

 }

# get order info.
# this sections gets all information for the order being displayed on the invoice
  mysql_select_db($tbl_coop_contact);


  $query = 'select oh.header_id, oh.STATUS, oh.order_nbr, li.item_id, li.lot_id, ci2.lot_ship,oh.customer_key,'.
           'oi.cost, li.quantity AS lot_quantity,  ci.weight as bag_lbs, oi.item_code,'.
           'ci2.item_description, ci2.mark, ci2.warehouse, ci2.warehouse_code, oh.order_date, oh.ship_date, '.
           'oh.load_type, oh.stack_type, oh.Ship_Note, '.
           'cc.ShipAddress1,cc.ShipAddress2,cc.ShipAddress3,cc.ShipCity,'.
           'cc.ShipState,cc.ShipZip,oh.approval_date, oh.approval_by, '.
           'cc.name, cc.company, oh.fob_city, oh.truck, oh.warehouse_th, oh.frt_charges, oh.comments'.
           ' from '.$tbl_lot_item.' li,'.$tbl_order_item.' oi, '.$tbl_order_header.' oh, '.
           $tbl_item_description.' ci, '.$tbl_coop_contact.' cc  '.
           'LEFT JOIN '.$tbl_coop_item.' ci2 ON ci2.item_id = li.lot_ship '.
           ' where  li.item_id = oi.item_id '.
           ' and li.header_id = oh.header_id '.
           ' and oh.customer_key = cc.contact_id '.
           ' and oi.item_code = ci.item_code '.
           ' and oh.header_id = "'.$order_id.'"'.
           ' order by li.header_id, li.item_id, li.lot_id ';


#  echo '<br>'.$query.'<br>';

# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);
 $approval_date = $row['approval_date'];
 if (isset($approval_date)) {
 echo '<br>Order approved on '.$row['approval_date'].' by '.$row['approval_by'].'<br>';
}



?>

<TABLE cellSpacing=0 cellPadding=0 width='95%' border=0>
<tr><td>
<INPUT name=subbtn TYPE="SUBMIT" value="Approve">
</td>
<td>
<INPUT name=subbtn TYPE="SUBMIT" value="Reject">

</td>
</tr>

<tr>
<td>
<b> To:</b>
<?
echo $row['warehouse_th'];
?>
 <br><b>
 CC:</b>
<?
echo $row['name'];
echo '<br><input  type="hidden" name="status" value="'.$row['STATUS'].'" >';
echo '<br>';
?>
 
<b> From: </b>Bill Harris - Cooperative Coffees
<br>
 Please call (229)924-3035 if there is any questions or problems concerning
this order.<br> Thank you!
</td>

<td>
 Cooperative Coffees, Inc.
<br>
302 West Lamar Street
Americus, GA  31709

</td>
</tr>

<tr>
<td><b>
Release to:</b>
<br>

<?

 echo "<P>";
 echo $row['ShipAddress1']."<br>";
 echo $row['ShipAddress2']."<br>";
 echo $row['ShipAddress3']."<br>";
 echo $row['ShipCity'].", ".$row['ShipState']."  ".$row['ShipZip']."<br>";

?>
</td>
<td><b>
DELIVERY ORDER</b>
<BR><b>
Date:</b>
<?
echo $row['ship_date'];
?>

 <BR><b>
Invoice:</b>

<?
  echo $row['order_nbr'];
?>
<br>
</td>
<tr>
</table>

<TABLE cellSpacing=0 cellPadding=0 width='95%' border=0>
<tr bgcolor="#9bbcc2">
<td>Item</td>
<td>Lot</td>
<td>Mark</td>
<td>Control No.</td>
<td>Bags</td>
<td align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Weight</td>
<td>Description</td>
</tr>

<?


  $comments = $row['comments'];
  $load_type = $row['load_type'];
  $stack_type = $row['stack_type'];
  $Ship_Note = $row['Ship_Note'];
  $ship_date = $row['ship_date'];
  $fob_city = $row['fob_city'];
  $truck = $row['truck'];
  $frt_charges = $row['frt_charges'];


  for ($i=0; $i <$num_results; $i++)
  {

    echo '<tr>';

    echo '<td>';
    echo  $row['item_code'].'</td>';

    echo '<td>'.$row['lot_ship'].' ';
    echo '</td>';

    echo '<td>'.$row['mark'].' ';
    echo '</td>';

	echo '<td>'.$row['warehouse_code'].' ';
	echo '</td>';

    echo '<td>'.$row['lot_quantity'];
    echo '</td>';

    $current_weight = $row['lot_quantity'] * $row['bag_lbs'];

    echo '<td align=right>';

  echo'<script language="Javascript"> document.write(fmtmoney("'.$current_weight.'"));';
  echo '</script>';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
  echo '</td>';



    $total_weight = $total_weight + ($row['lot_quantity'] * $row['bag_lbs']);
    $total_bags = $total_bags + $row['lot_quantity'];



    echo '<td>'.$row['item_description'].'</td>';
   $row = mysql_fetch_array($result);
# end for loop.
  }


  echo '</tr>';

  echo '<tr bgcolor="#9bbcc2"><td>&nbsp;&nbsp</td><td>&nbsp;&nbsp;</td><td>&nbsp</td><td>Totals:</td><td>';
  echo $total_bags;

  echo '</td><td align=right> ';
  echo'<script language="Javascript"> document.write(fmtmoney("'.$total_weight.'"));';
  echo '</script>';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;</td><td> &nbsp;</td></tr>';

  echo '</table> <table width=100%>';

  echo '<tr>';
  echo '<td colspan=3>';
  echo '<b>Trucking Company:&nbsp;&nbsp;&nbsp;</b><br>'.$truck.'&nbsp;<br>';
  echo '</td>';
  echo '<td colspan=3>';
  echo '<b>Ship Date:&nbsp;&nbsp;&nbsp;</b><br>'.$ship_date.'&nbsp;<br>';
  echo '</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td colspan=3>';
  echo '<b>FOB City:&nbsp;&nbsp;&nbsp;</b><br>'.$fob_city.'&nbsp;<br>';
  echo '</td>';
  echo '<td colspan=3>';
  echo '<b>Freight Charges:&nbsp;&nbsp;&nbsp;</b><br>'.$frt_charges.'&nbsp;<br>';
  echo '</td>';

  echo '</tr>';

  echo '<tr><td colspan=3>';
  echo '<b>comments:</b><br>'.$comments.'<br>';
  echo '</td> ';

  echo ' <td colspan=3>';
  echo '<b>Ship Note:</b><br>'.$Ship_Note.'<br>';
  echo '</td></tr>';

  echo '<tr><td colspan=3>&nbsp</td><td colspan=3>';
    echo '<p><b>Pallet Note:</b><br>';
    if ($load_type == "pallet" )
    {
       echo 'Please carefully palletize, shrinkwrap and slipsheet this order. Thanks You<br> ';
       echo '<b>Stack Type:</b>'.$stack_type.'<br>';
    }
    else {
         echo '<b>Load Type:</b>'.$load_type.' <b>';
    }




  echo '</td></tr>';   
  
  echo '</table>';


 ?>     

 </form>

</BODY>


</HTML>
