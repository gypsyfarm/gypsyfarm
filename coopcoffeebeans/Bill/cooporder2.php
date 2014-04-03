<?php

require("../tables.php");

// Note: Eric: I did not use functions in this require, may change latter.
//require("functions.php");

// check security
 session_start();

// check session variable

  if (isset($_SESSION['valid_user']))
  {
   // $contact_id = $_SESSION['contact_id'];
    $order_id=$_REQUEST['order_id'];

  }
  else
  {
   header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
  }
?>
<html>
<head>
  <title>Delivery Order Page:</title>
  <META http-equiv=Content-Type content="text/html; charset=windows-1252">

</head>
 <!-- come back and add latter: CSS: {font-weight: bold} instead of bold tags. -->
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff >
<link rel="stylesheet"
   type="text/css"
   media="print" href="../print.css" />
   


<SCRIPT LANGUAGE="JavaScript">
  <!-- Begin
  function varitext(text){
  text=document
  print(text)
  }
  // End -->
  </script>
  </HEAD>

<!-- new code  -->
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
<img SRC="cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>
-->
<table>
<tr>
<td width=20%>


  <FORM>
  <div class='no_print'>
  <INPUT NAME="print" TYPE="button" class=button VALUE="Print Order"
  ONCLICK="varitext()">
  </div>
  </FORM>
   &nbsp;
</td>
<td width=80% align=center>
 <center><h1>Delivery Order</h1></center>
</td>
</tr>
</table>



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

# get order info.
# this sections gets all information for the order being displayed on the invoice
  mysql_select_db($tbl_coop_contact);

 
  $query = 'select oh.header_id, oh.order_nbr, li.item_id, li.lot_id, ci2.lot_ship,oh.customer_key,'.
           'oi.cost, li.quantity AS lot_quantity,  ci.weight as bag_lbs, oi.item_code,'.
           'ci2.item_description, ci2.mark, ci2.warehouse, ci2.warehouse_code, oh.order_date, oh.ship_date, '.
           'oh.load_type, oh.stack_type, oh.Ship_Note,cc.WorkPhone, '.
           'cc.ShipAddress1,cc.ShipAddress2,cc.ShipAddress3,cc.ShipCity,'.
           'cc.ShipState,cc.ShipZip,cc.ShipPhone,'.
           'cc.name, cc.company, oh.fob_city, oh.truck, oh.warehouse_th, oh.frt_charges, oh.comments'.
           ' from (('.$tbl_lot_item.' li,'.$tbl_order_item.' oi, '.$tbl_order_header.' oh, '.
           $tbl_item_description.' ci, '.$tbl_coop_contact.' cc  )'.
           'LEFT JOIN '.$tbl_coop_item.' ci2 ON ci2.item_id = li.lot_ship ) '.
           ' where  li.item_id = oi.item_id '.
           ' and li.header_id = oh.header_id '.
           ' and oh.customer_key = cc.contact_id '.
           ' and oi.item_code = ci.item_code '.
           ' and oh.header_id = "'.$order_id.'"'.
           ' order by li.header_id, li.item_id, li.lot_id ';


#  echo '<br>'.$query.'<br>';

# retrieve information:

  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);

# now use  warehouse code to get address:
#echo "<br> ok warehouse is ".$row['warehouse'];
$warehouse_code = $row['warehouse'];

if ( !isset($warehouse_code)) {
	$warehouse_code = 'Z';
	echo 'setting to z';
}
 $queryw = "select cc.contact_id,
                  cc.company,
                  cc.ShipAddress1,
                  cc.ShipAddress2,
                  cc.ShipAddress3,
                  cc.ShipAddress4,
                  cc.ShipCity,
                  cc.ShipState,
                  cc.ShipZip,
                  cc.ShipCountry,
                  cc.ShipPhone
           from $tbl_coop_contact cc, $tbl_coop_warehouse cw
           where cc.contact_id = cw.contact_id_key
             and cw.warehouse_code = '$warehouse_code' ";
             
             
 # echo '<br>'.$queryw.'<br>';


# retrieve information:
   mysql_select_db('cbeans', $db_conn); 
  $resultw = mysql_query($queryw, $db_conn);
  $num_resultsw = mysql_num_rows($resultw);
 #$num_resultsw = 1;


# prepare to extract
  $row_warehouse = mysql_fetch_array($resultw);



?>
<TABLE cellSpacing=0 cellPadding=0 width='100%' border=0>
<tr>
<td width='75%'>
<b> To:</b>
<?
echo $row['warehouse_th'];
?>
 <br><b>
 CC:</b>
<?
echo $row['name'];
?>
 <br>&nbsp;<br>
<b> From: </b>Abby Trantham - Cooperative Coffees
<br>
 Please call (229)924-3035 if there is any question or problem concerning
this order. Thank you!
</td>

<td width='25%'>
 Cooperative Coffees, Inc.<br>
302 West Lamar Street<br>
Americus, GA  31709<br>


</td>
</tr>

<tr>
<td>
<br>


 

<?
 echo "<table width=100%><tr><td width=50% valign=top>"; 
 echo "<b>Release to:</b>";
 echo "<br>";
 if  ($row['ShipAddress1'] != "") 
  echo $row['ShipAddress1']."<br>";
if  ($row['ShipAddress2'] != "")        
  echo $row['ShipAddress2']."<br>";
if  ($row['ShipAddress3'] != "") 
  echo $row['ShipAddress3']."<br>";
 echo $row['ShipCity'].", ".$row['ShipState']."  ".$row['ShipZip']."<br>";
 echo "<b>Phone:</b> ".$row['WorkPhone'];
 
 echo "</td><td width=50% valign=top>";
 
  if ($num_resultsw > 0 ) {
      echo "<strong>Pickup Location:</strong>";
      echo $row_warehouse['company_name'];
      echo '<br>';
      if  ($row_warehouse['ShipAddress1'] != "") {
          echo $row_warehouse['ShipAddress1'];
          echo '<br>';
      }
      if  ($row_warehouse['ShipAddress2'] != "") {
          echo $row_warehouse['ShipAddress2'];
          echo '<br>';
      }    
          
      if  ($row_warehouse['ShipAddress3'] != "") {      
          echo $row_warehouse['ShipAddress3'];
          echo '<br>';
      }    
      
      if  ($row_warehouse['ShipAddress4'] != "") {      
          echo $row_warehouse['ShipAddress4'];
          echo '<br>';
      }    
      
      
      echo $row_warehouse['ShipCity'];
      echo ', ';
      echo $row_warehouse['ShipState'];
      echo '&nbsp;&nbsp;';
      echo $row_warehouse['ShipZip'];
      echo '<br>';
      echo "<strong>Phone:";
      echo "</strong>";
      echo $row_warehouse['ShipPhone'];

  
  /*
      echo "<br>Continental Terminal<br>";
      echo "Ray Hutchinson<br>";
      echo "River Terminal<br>";
      echo "Hackensack Ave, Bldg 54<br>";
      echo "Kearny, NJ  07032 <br>";
      echo "<strong>Phone:973-578-2702 </strong>";
      */
}
    
 
    
    
    echo "</td></tr></table>";
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
Order :</b>

<?
  echo $row['order_nbr'];
?>
<br>
</td>
<tr>
</table>
<p>
<TABLE cellSpacing=0 cellPadding=0 width='95%' border=0>
<tr bgcolor="#9bbcc2">
<td><b>Item</td>
<td><b>Lot</td>
<td><b>Mark</td>
<td><b>Control No.</td>
<td><b>Bags</td>
<td align=left><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Weight</td>
<td><b>Description</b></td>
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
  $ShipPhone = $row['ShipPhone'];


  for ($i=0; $i <$num_results; $i++)
  {

    echo '<tr>';

    echo '<td>';
    echo  $row['item_code'].'</td>';

    echo '<td>'.$row['lot_ship'].' ';
    echo '</td>';

    echo '<td>'.$row['mark'].'&nbsp;&nbsp;&nbsp; ';
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

  echo '<tr bgcolor="#9bbcc2"><td>&nbsp;&nbsp</td><td>&nbsp;&nbsp;</td><td>&nbsp</td><td><b>Totals:<b></td><td>';
  echo $total_bags;

  echo '</td><td align=right> ';
  echo'<script language="Javascript"> document.write(fmtmoney("'.$total_weight.'"));';
  echo '</script>';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;</td><td> &nbsp;</td></tr>';

  echo '<tr>';
  echo '<td colspan=3><br>';
  echo '<b>Trucking Company:&nbsp;&nbsp;&nbsp;</b><br>'.$truck.'&nbsp;<br>';
  echo '</td>';
  echo '<td colspan=3>';
  echo '<b><br>Ship Date:&nbsp;&nbsp;&nbsp;</b><br>'.$ship_date.'&nbsp;<br>';
  echo '</td>';
  echo '<td><br>';
  echo '<b>Ship Phone:&nbsp;&nbsp;&nbsp;</b><br>'.$ShipPhone.'&nbsp;<br>';
  echo '</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td colspan=3>';
  echo '<b>FOB City:&nbsp;&nbsp;&nbsp;</b><br>'.$fob_city.'&nbsp;<br>';
  echo '</td>';
  echo '<td colspan=3>';
  echo '<b>Freight Charges To:&nbsp;&nbsp;&nbsp;</b><br>'.$frt_charges.'&nbsp;<br>';
  echo '</td>';
  echo '<td>';
  echo '<b>Ship Note:</b><br>'.$Ship_Note.'<br>';
  echo '</td>';

  echo '</tr>';

  echo '<tr><td colspan=7>';
  echo '<hr><b>comments:</b><br>'.$comments.' ';
  echo '<hr></td> ';
  echo '</tr>';

  echo '<tr><td colspan=6>';
    echo ' <b>Pallet Note:</b><br>';

    if ($load_type == "pallet" )
    {
       echo 'Please carefully palletize, shrinkwrap and slipsheet this order. Thank You</td><td>  ';
      echo '<b>Load Type:</b>'.$load_type.'  <br>';
       echo '<b>Stack Type: </b>'.$stack_type.' ';
       if ( $stack_type > 0) {
       	echo ' <b>bags per pallet</b>';
       }
    }
    else {
         echo '</td><td> <b>Load Type:</b>'.$load_type.' ';
    }
  echo '</td>';

  echo '</tr>';
  echo '</table>';


 ?>

&nbsp;
 
<hr>
<table width=100%>
<tr>
<td>
<div class='no_print'>
<font size=3><a href="../index.php">Back to the Menu</a></font> 
</div>
</td><td>
<div class='no_print'>
<font size=3><a href="../logout.php">Log out</a></font> 
</div>
</td></tr>
</table>
<hr>
</BODY>


</HTML>
