<html>
<head>
  <title>Order Processing Page:</title>
  <META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="../general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff
background=CoopContact_files/cooperativecoffees.html>

<!-- new code  -->
<script language="Javascript">
   function saveRec() {
  //  document.frmMain.order_status.value = "B";
    alert (document.frmMain.contact_id.value);
    alert (document.frmMain.order_id.value);
    document.frmMain.submit();

    }

</script>

<img SRC="cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>
<br><center><h1>Process Orders</h1></center><br><br><br><br>
<font size=3><a href="../index.php">Back to the Menu</a></font><br>
<font size=3><a href="../logout.php">Log out</a></font><br>
<br>

 <center>
 <form name="frmMain" action=order_processing.php method=post>
 </center>

<p>
<?php

// declare functions
   function makedropdown($code, $warehouse, $lot_id, $lot_ship)
   {
  #  echo '<br>vars are:'.$code.':'.$warehouse.':'.$lot_id.':'.$lot_ship.' <br>';
   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

# get production items to create drop down list for specific product.
 $query = "SELECT item_id, item_code, lot_ship, warehouse
           FROM coop_item
           WHERE warehouse  = '".$warehouse."'  AND item_code = '".$code."'";

    mysql_select_db('coop_item');
    $ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "too bad too sad"; }


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);
   echo $ddrow['item_code'];

#  build drop down list.
   echo "<select name='lotship".$lot_id."'>";

      for ($i=0; $i <$ddnum_results; $i++)
 {
        echo "<option value='".$ddrow['item_id'];
        echo "'";
        if ($lot_ship == $ddrow['lot_ship'] )
        {
           echo ' selected ';
        }
        echo ' > '.$ddrow['item_code'].' / '.$ddrow['lot_ship'].' / '.$ddrow['warehouse'].'   ';

   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";

   }

  function newitemdropdown($order_id,$customer_key)
   {

   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }
  #  echo '<br>vars are:'.$order_id.':<br>';
  # get production items to create drop down list for specific product.
 # $query = 'SELECT item_code FROM item_description ';


   $query = 'SELECT  DISTINCT i.item_code FROM item_description i '.
            ' LEFT  OUTER  JOIN order_item o ON o.item_code = i.item_code '.
            ' AND header_key = "'.$order_id.'" WHERE o.item_code IS  NULL ';




   mysql_select_db('item_description');
      $ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "too bad too sad"; }


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);
 #  echo $ddrow['item_code'];

#  build drop down list.
   echo '<select name="new_product">';
   echo '<option value="">';
      for ($i=0; $i <$ddnum_results; $i++)
 {
      echo '<option value="'.$ddrow['item_code'].'" >'.$ddrow['item_code'];


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";
   #   echo "<a href='order_processing.php?order_id=".$order_id."&new_item=".$customer_key."'> New Item</a>";

}


  // create short variable names





# $old_level = error_reporting(4);
 error_reporting (E_ALL ^ E_NOTICE);

 #echo "error level was ".$old_level;
  $searchtype=$_GET['searchtype'];
  $order_id=$_GET['order_id'];
  $new_lot=$_GET['new_lot'];
  $delete_lot=$_GET['delete_lot'];
  $delete_item=$_GET['delete_item'];
   $delete_order=$_GET['delete_order'];
  $action=$_REQUEST['action'];
  $new_item = $_GET['new_item'];
  $new_product=$_REQUEST['new_product'];
    $order_status=$_REQUEST['order_status'];
  $update_order = "N";
# echo '<br>order status is  '.$order_status.'<br>';

  if ($action == 'update') {
     $order_id = $_REQUEST['order_id'];
     $update_order = "Y";


  }

  $action_value = 'hold';
   if (isSet($order_id)) {
      echo '<input  type="hidden" name="order_id" value="'.$order_id.'">';
      $action_value = 'update';
   }


$warehouse = $_REQUEST['warehouse'];

if (!isSet($warehouse)) {
    $warehouse='N';
}



   echo '<input  type="hidden" name="action" value="'.$action_value.'">';
      echo '<input  type="hidden" name="order_status" value="I">';


 #  echo '<br>action is '.$action.' <br>action value is '.$action_value.' <br>for order '.$order_id;
 # echo $searchtype;
#  echo $searchterm;
  $searchterm= trim($searchterm);
  $searchtype = addslashes($searchtype);
  $searchterm = addslashes($searchterm);


  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }


# see if we are updating a an order
 if ($update_order == "Y") {
#  echo '<br>the update switch is set<br>';
  mysql_select_db('order_header');


  $query = 'select oh.header_id, li.item_id, li.lot_id, li.lot_ship,'.
           'oi.cost, oi.quantity AS item_quantity, li.quantity AS lot_quantity,  ci.weight as bag_lbs, oi.item_code,'.
           'ci.item_description,li.mark,'.
           'cc.name, cc.company '.
           ' from lot_item li,order_item oi, order_header oh, item_description ci, coop_contact cc '.
           ' where  li.item_id = oi.item_id '.
           ' and li.header_id = oh.header_id '.
           ' and oh.customer_key = cc.contact_id '.
           ' and oi.item_code = ci.item_code '.
           ' and oh.header_id = "'.$order_id.'"'.
         #  ' and oh.STATUS = "I" '.
           ' order by li.header_id, li.item_id, li.lot_id ';

 #   echo '<br>in update select order with '.$query.'<br>';
   $result = mysql_query($query, $db_conn);

   $row = mysql_fetch_array($result);
   $num_results = mysql_num_rows($result);
 #  echo '<br>got '.$num_results.' records back<br>';


      for ($i=0; $i <$num_results; $i++)
  {

   $lotvar =  'lotship'.$row['lot_id'];
   $qvar = 'q'.$row['lot_id'];
#   echo "lotid is:".$row['lot_id'].":";
#   echo '<br>lotvar is '.$lotvar;
    $lotshipval =   $_REQUEST[$lotvar];
    $quantityval = $_REQUEST[$qvar];
#   echo '<br> lotship value is '.$lotshipval.' with value of '.$quantityval.'<br>';

      if (empty($lotshipval)) {
      $lotshipval = 0;
      }

     if (empty($quantityval)) {
      $quantityval = 0;
      }

    $query = " update lot_item set lot_ship = '".$lotshipval."',".
             " quantity = '".$quantityval."' where lot_id = '".$row['lot_id']."'";

 #    echo "<br>".$query."<br>";

     $update_lot = mysql_query($query, $db_conn);
     $row = mysql_fetch_array($result);



   }


    $order_date=$_REQUEST['order_date'];
    $comments=$_REQUEST['comments'];
    $fbo_city=$_REQUEST['fbo_city'];
    $warehouse_th =$_REQUEST['warehouse_th'];
    $truck=$_REQUEST['truck'];
    $ship_date=$_REQUEST['ship_date'];
    $frt_charges=$_REQUEST['frt_charges'];
    $query = ' update order_header set order_date = "'.$order_date.'", '.
             ' STATUS = "'.$order_status.'",'.
             ' fbo_city = "'.$fbo_city.'", '.
             ' warehouse_th = "'.$warehouse_th.'", '.
             ' truck = "'.$truck.'", '.
              ' frt_charges = "'.$frt_charges.'", '.
             ' ship_date  = "'.$ship_date.'", '.
             ' comments = "'.$comments.'" '.
             ' where header_id = "'.$order_id.'"';
 # echo '<br>update header '.$query.'<br>';

   $update_lot = mysql_query($query, $db_conn);

 if ($new_product <> '') {
    echo '<br>new product is  set<br>';
     	$query = 'insert into order_item (item_id,header_key,item_code,cost,quantity,bag_lbs,STATUS, order_active) values (NULL,"'.$order_id.'","'.$new_product.'", 0,0,0, "I",0)';
 #  echo '<br>insert order_item: '.$query.'<br>';
 	$result = mysql_query($query, $db_conn);
 	$id2=mysql_insert_id();
 	$query = 'insert into lot_item (lot_id,header_id,item_id,lot_ship,quantity,bag_lbs,STATUS) values (NULL,"'.$order_id.'","'.$id2.'", 0,0,0.00,"I")';
#   echo '<br>insert lot_item: '.$query.'<br>';
  	$result = mysql_query($query, $db_conn);

 }

  }



# add new lot item if needed
 if (isSet($new_lot)) {
# echo '<br> insert new lot item <br>';
 $query = "insert into lot_item values(null,".$order_id.",".$new_lot.",0,0,null,null,null,null,'I',null,null,null,null);";
 $result = mysql_query($query, $db_conn);
# echo '<br> insert is '.$query.'<br>';

 unSet($new_lot);
#header("Location: http://".$_SERVER['HTTP_HOST']
#                      .dirname($_SERVER['PHP_SELF'])
 #                     ."/order_processing.php?order_id=".$order_id);


 }


# delete lot item if needed
 if (isSet($delete_lot)) {
 # echo 'going to delete item now ';
 $query = "delete from lot_item where lot_id = '".$delete_lot."';";
#  echo "<br>".$query."<br>";

  $result = mysql_query($query, $db_conn);
  unSet($delete_lot);
#  header("Location: http://".$_SERVER['HTTP_HOST']
#                       .dirname($_SERVER['PHP_SELF'])
#                       ."/order_processing.php?order_id=".$order_id);


 }

# delete product item if needed
 if (isSet($delete_item)) {
 # echo 'going to product item now ';
 $query = "delete from lot_item where item_id = '".$delete_item."';";
#  echo "<br>".$query."<br>";

  $result = mysql_query($query, $db_conn);
  $query = "delete from order_item where item_id = '".$delete_item."';";
 #   echo "<br>".$query."<br>";
    $result = mysql_query($query, $db_conn);

  unSet($delete_item);


 }



# delete customer order if needed
 if (isSet($delete_order)) {
 # echo 'going to product item now ';
 $query = "delete from lot_item where header_id = '".$delete_order."';";
 # echo "<br>".$query."<br>";

  $result = mysql_query($query, $db_conn);
  $query = "delete from order_item where header_key = '".$delete_order."';";
  #  echo "<br>".$query."<br>";
    $result = mysql_query($query, $db_conn);

  $query = "delete from order_header where header_id = '".$delete_order."';";
  #  echo "<br>".$query."<br>";
    $result = mysql_query($query, $db_conn);

  unSet($delete_order);


 }




  mysql_select_db('order_header');

 $query = "SELECT cc.company, cc.name, oh.header_id, oh.order_date
           FROM order_header oh, coop_contact cc
           WHERE oh.customer_key = cc.contact_id
           AND oh.status = 'I'
           ORDER  BY oh.customer_key, oh.header_id";

   echo "<br>";
   $result = mysql_query($query, $db_conn);

   $row = mysql_fetch_array($result);
   $num_results = mysql_num_rows($result);

   $prev_account =  'x';

   echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
   for ($i=0; $i <$num_results; $i++)
   {

      if ($prev_account <>  $row['company']) {
         echo "<tr><td>";
         echo "<p><font size=2 color=blue>  ".$row['company']."</font></td><td>";
      }
      $prev_account = $row['company'];

      echo "&nbsp;&nbsp;&nbsp;<font size=2 color=blue><a href='order_processing.php?order_id=".$row['header_id']."'>".$row['header_id']."(".$row['order_date'].")</font></a>";
      $row = mysql_fetch_array($result);

      if ($prev_account <>  $row['company']) {
       echo '<td/></tr>';
     }


  }
 echo '</table>';
 echo '<form name=frmMain method=post action=contactresultsleft.php action="cooporderedit.php">';
 echo '<br>';
?>
<table border=1 width=100%><tr><td>
<!-- new code  -->
<p><INPUT TYPE="SUBMIT" value="update">
<!-- new code  -->
</td>
<td align=right>
 <button type=button id=btnSave name=btnSave btnAccessKey="a"
		    onclick="saveRec();">
		   	<u>A</u>pproved
	 </button>



</td>
</tr></table>


<table  border=1 width=100%>
<tr bgcolor="#9bbcc2">
<td>Warehouse:


<?
# --- Begin New Code

# get customer info.

   mysql_select_db('lot_item');


  $query = 'select oh.header_id, li.item_id, li.lot_id, li.lot_ship,oh.customer_key,'.
           'oi.cost, oi.quantity AS item_quantity, li.quantity AS lot_quantity,  ci.weight as bag_lbs, oi.item_code,'.
           'ci.item_description, ci2.mark, oh.order_date, oh.ship_date, '.
           'cc.name, cc.company, oh.fbo_city, oh.truck, oh.warehouse_th, oh.frt_charges, oh.comments'.
           ' from lot_item li,order_item oi, order_header oh, item_description ci, coop_contact cc  '.
           'LEFT JOIN coop_item ci2 ON ci2.item_id = li.lot_ship '.
           ' where  li.item_id = oi.item_id '.
           ' and li.header_id = oh.header_id '.
           ' and oh.customer_key = cc.contact_id '.
           ' and oi.item_code = ci.item_code '.
           ' and oh.STATUS = "I" '.
           ' and oh.header_id = "'.$order_id.'"'.
           ' order by li.header_id, li.item_id, li.lot_id ';



# echo "big one is <br>".$query."<br>";

# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);

# prepare to extract
  $row = mysql_fetch_array($result);
#  echo '<br>customer is '.$row['customer_key'].'<br>';

  echo '<input type=hidden name=contact_id value="'.$row['customer_key'].'" >';
  $num_results = mysql_num_rows($result);





    echo '<select name="warehouse">';
    echo '<option value="N"';
    if ($warehouse == "N" )
    {
       echo ' selected ';
    }
    echo '> New Orleans';
    echo '<option value="T"';
    if ($warehouse == "T")
    {
      echo ' selected ';
    }
    echo ' > Toronto';
    echo '</selected>';
    echo '</select>';

echo '<br>';
echo 'Order Notes:<br>';
echo '<textarea name="comments" type="text" width=100 maxlength="300" id="comments" style="height:50px;width:300px;">'.$row['comments'].'</textarea>';
echo '<br>Order Nbr:'.$row['header_id'].' ';
echo '<br>'.$row['name'].' ';
echo '<br>'.$row['company'].' ';
echo '<br>';
echo "<a href='order_processing.php?order_id=".$order_id."&delete_order=".$order_id."'> Delete Order</a>";

echo '</td>';




 #  echo 'got back '.$num_results.' records';
 #    echo $row['order_date']." <-- ";
echo '<td colspan=2 ><table><tr><td>Order Date:';
echo '</td><td><input type=text name="order_date" value="'.$row['order_date'].'">';
echo '</td></tr><tr><td>';
echo 'Ship Date:';
echo '</td><td><input type=text name="ship_date" value="'.$row['ship_date'].'">';
echo '</td><tr><tr><td>To Whom:';
echo '</td><td><input type=text name="warehouse_th" value="'.$row['warehouse_th'].'">';
echo '</td></tr><tr><td>FBO City:';
echo '</td><td><input type=text name="fbo_city" value="'.$row['fbo_city'].'">';
echo '</td></tr><tr><td>Truck:';
echo '</td><td><input type=text name="truck" value="'.$row['truck'].'">';
echo '</td></tr><tr><td>Frt. Charges:';
echo '</td><td><input type=text name="frt_charges" value="'.$row['frt_charges'].'">';

echo '</td></tr>';
echo '<tr><td>';
echo  'add New Item to Order:';
echo '</td><td>';
newitemdropdown($order_id,$row['customer_key']);
echo '</td></tr>';
echo '</table>';
?>

</td>
</tr>
<tr>
<td>
Item
</td>

<td>
Bags
</td>

<td>
Description
</td>
</tr>

<?

  $total_total_weight = 0;
  # echo 'got back '.$num_results.' records';
  for ($i=0; $i <$num_results; $i++)
  {



   echo '<tr bgcolor="#9bbcc2">';
   echo '<td >';
   echo '<input type=hidden name="product'.$row['lot_id'].'" value="'.$row['item_code'].'">';
   echo $row['item_code'];
   $code=$row['item_code'];

   echo "&nbsp;&nbsp;&nbsp;";
   echo "<a href='order_processing.php?order_id=".$order_id."&new_lot=".$row['item_id']."'> new lot </a>";
   echo '</td>';

   echo '<td>'.$row['item_quantity'];

   echo '</td>';

   echo '<td>'.$row['item_description'].' &nbsp;';
   echo "&nbsp;&nbsp;&nbsp;";
   echo "<a href='order_processing.php?order_id=".$order_id."&delete_item=".$row['item_id']."'> Delete Item</a>";

   echo '</td></tr>';


   echo '<tr>';
   echo '<td>';

   echo $row['lot_id']."Lot Ship ";
    makedropdown($code, $warehouse, $row['lot_id'],$row['lot_ship']);
 #  echo "<input type=text name='lotship".$row['lot_id']."' value='".$row['lot_ship']."'>";
  echo "</td>";
   echo '<td>';
   echo "Mark ";
   echo $row['mark'];
  echo "</td>";

  echo "<td>Quantity:<input type=text name='q".$row['lot_id']."'";
        $total_bags = $total_bags + $row['lot_quantity'];
  $total_weight = $row['lot_quantity'] * $row['bag_lbs'];
  $total_total_weight = $total_total_weight + $total_weight;
   echo ' value="'.$row['lot_quantity'].'"> &nbsp;&nbsp; weight='.$total_weight.' ';
     $prev_item_id = $row['item_id'];

  $row = mysql_fetch_array($result);
 # echo "<br>1-current item = ".$row['item_id']." prev item = ".$prev_item_id;

   echo "</td>";
   echo"</tr>";




  while ($prev_item_id == $row['item_id']) {

     echo '<tr>';
     echo '<td>';
     echo $row['lot_id']."-Lot Ship ";
   #  echo "<input type=text name='lotship".$row['lot_id']."' value='".$row['lot_ship']."'>";
     makedropdown($code, $warehouse, $row['lot_id'],$row['lot_ship']);
     echo "</td>";
     echo '<td>';
    echo " ";
     echo $row['mark'];
     echo "</td>";

     echo "<td>Quantity:<input type=text name='q".$row['lot_id']."'";
     echo " value='".$row['lot_quantity']."'>";

    echo "<a href='order_processing.php?order_id=".$order_id."&delete_lot=".$row['lot_id']."'> Remove Lot </a>";

     $prev_item_id = $row['item_id'];
     $row = mysql_fetch_array($result);
  #  echo "<br>2-current item = ".$row['item_id']." prev item = ".$prev_item_id;
     $total_bags = $total_bags + $row['lot_quantity'];


     echo "</td></tr>";

     $i = $i + 1;

  }
     echo "<tr><td colspan=3> <hr>";
  #   echo "<br> end of group";
  #         echo "<br>3-current item = ".$row['item_id']." prev item = ".$prev_item_id;
     echo "</td>";


}


  echo '</tr>';
  echo '<tr bgcolor="#9bbcc2">';
  echo '<td align=right>Total Weight: '.$total_total_weight.'  lbs.</td>';
  echo '<td>Total Bags:</td>';
  echo '<td>'.$total_bags.'</td>';

  echo '</tr>';
  echo '</table>';

# --- end new code

?>


</form>


</BODY>


</HTML>
