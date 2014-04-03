<?php
// check security
 session_start();
require("../check_login.php");
//check_login(1);
require("../functions.php");
require("../tables.php");

session_start(); 
if ( $_SESSION['valid_user'] == "") {
      header("Location: http://www.coopcoffeesbeans.com/index.php");
      exit;
}

$contact_id = $_SESSION['auth_contact_id']; 
// $debug = "Start debugging<br>";
// $debug .= "submit is ".$_REQUEST['SUBMIT'];
  function item_inventory($passed_item_code,$fob_code)
   {

   global $tbl_order_header;
   global $tbl_item_description;
   global $tbl_order_item;
   global $tbl_lot_item;
   global $tbl_coop_item;
   global $tbl_coop_contact;
   global $from_year;
   global $db_conn;

/*
set initial_quantity
then loop thru and add all quantity to get quantity purchased

remaining will be initial_quantity - total_quantity

*/

//  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);


# begin new code
  $query =   "SELECT sum(ci.quantity) as quantity, sum(ci.transfer_in) as transfer_in, sum(ci.transfer_out) as transfer_out 
              FROM  $tbl_coop_item ci 
               WHERE ci.item_code = '$passed_item_code' and ci.warehouse = '$fob_code' ";

 

$result = mysql_query($query, $db_conn);


$num_results = mysql_num_rows($result);


$row=mysql_fetch_array($result);

$initial_quantity =$row['quantity'] + $row['transfer_in'] - $row['transfer_out'];


#end new code


  $query =   "SELECT ci.warehouse,  oi.item_code, li.quantity, ci.lot_ship, id.weight as bag_lbs,
             ci.item_description, ci.quantity as initial_quantity,  oh.order_date, oh.header_id, cc.Company
             FROM  $tbl_item_description id,  $tbl_order_item oi,  $tbl_lot_item li,
           $tbl_order_header oh, $tbl_coop_item ci,  $tbl_coop_contact cc
          WHERE oi.item_id = li.item_id
          AND oi.item_code = id.item_code
           AND oh.customer_key = cc.contact_id
          AND li.lot_ship = ci.item_id
          AND oi.header_key = oh.header_id
          AND oi.item_code='$passed_item_code' 
          AND ci.warehouse = '$fob_code'   order by id.category, id.rank, id.item_code;";

 

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$quantity_total=0;
$remaining=0;
for ($i=0; $i <$num_results;  $i++)
  {
$row=mysql_fetch_array($result);

$quantity_total=$quantity_total+$row['quantity'];
}
$remaining=$initial_quantity - $quantity_total;


return $remaining;


}


//**************************This is the Main Order First ORDER Screen*****************
//************************************************************************************
if ((!isset($_REQUEST['SUBMIT'])) or ($_REQUEST['SUBMIT'] == 'edit order')){
	echo '<html>';
	echo '<head>';
        echo '<title>Review Orders</title>';
        echo '<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo '<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo '<head>';

	echo '<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';

	echo '<font size=3 color=blue>You are logged in as '.$_SESSION['valid_user'].'</font><br>';
	echo '<font size=3><a href="../index.php">Back to the Customer Menu</a></font><br>';
        echo '<a href="../logout.php">Log Out</a><br>';
        // create short variable names
        # this field will need to come from login screen.
        
          $action=$_REQUEST['action'];
         echo "<br>";
        # set up connection string to database.
          $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
          mysql_select_db('cbeans', $db_conn);
        
          if (!$db_conn)
          {
             echo 'Error: Could not connect to database.  Please try again later.';
             exit;
          }
        
        # select information on customer:
          $query = "select cc.*, cw.* from $tbl_coop_contact cc, $tbl_coop_warehouse cw where contact_id = '".$contact_id."' and cc.fob_code = cw.warehouse_code";
        
       // $debug .= "<br>query = $query ";
        
        # get record set from DB.
          $result = mysql_query($query, $db_conn);
        
        # should only have one record.
          $num_results = mysql_num_rows($result);
        
        # pull that one row out of record set.
        $row = mysql_fetch_array($result);
        $truck = $row['Truck'];
        $customer_key=$row['contact_id'];
      //  $debug .= "<br> customer_key = $customer_key ";


        $ship_date = date ("Y-m-d", mktime (0,0,0,date("m"),date("d")+1,date("Y")));
        
        $ShipNote = $row['ShipNote'];
        $load_type= $row['load_type'];
        $stack_type= $row['stack_type'];
        $warehouse_to_whom= $row['Warehouse'];
        $fob_city= $row['warehouse_description'];
        $fob_code= $row['warehouse_code'];
        //echo $ship_date;
        

        ?>
        <!-- this section now places the customer info on the screen -->
        <table>
        <tr>
        <td>
         To:
        <?
        echo $row['Warehouse'];
        ?>
         <br>
         CC:
        <?
        echo $row['Name'];
        ?>
        <p>
        From: Abby Trantham - Cooperative Coffees
        <br>
         Please call 229-924-3035 if there are any questions or problems concerning
        this order.  Thank you!
        </td>
        
        <td>
        Cooperative Coffees, Inc. <br>
        302 West Lamar Street <b>
        Americus, GA  31709
        
        </td>
        </tr>
        
        <tr>
        <td>
        Release to:
        <br>
        <?
        echo "<P>";
        echo $row['ShipAddress1']."<br>";
if (strLen($row['ShipAddress2']) > 0 ) {
   echo $row['ShipAddress2']."<br>";
}
if (strLen($row['ShipAddress3']) > 0 ) {
   echo $row['ShipAddress3']."<br>";
}
        echo $row['ShipCity'].", ".$row['ShipState']."  ".$row['ShipZip']."<br>";
        ?>
        </td>
        <td>
        DELIVERY ORDER
        <BR>
        Date:
        <?
        echo date('d F Y');
        ?>
        
        
        <BR>
        Invoice: New Order <br>
        </td>
        </tr>
        </table>
        
        
        <form name=frmMain method=post action="cooporder.php">
        <?
        echo '<input  type="hidden" name="action" value="Add" >';
        
        ?>
        
        
        <table width=600 border=1>
        <tr>
        
        <th>
        Item
        </th>
        
        <th>
        Bags
        </th>
        
        <th width=100>
        Description
        </th>
        
        <th align=left width=6>
        Commit
        </th>
        <th align=left width=6>
        Purch
        </th>
        <th align=left width=6>
        Remain
        </th>
        <th align=left width=6>
        Inventory
        
        <?
        
 
        
 
        
        //******************************now get info on products*****************************
        
        
            mysql_select_db('item_discription');
            $query = "select item_code as product_code, item_description, price, on_allocation, 
              	weight as bag_lbs, rank, category from $tbl_item_description
                 where item_active = 0 order by  category, rank, item_code ";
        
           $result = mysql_query($query, $db_conn);
           $num_results = mysql_num_rows($result);
        
           $printed_category1 = "N";
           $printed_category2 = "N";
           $printed_category3 = "N";
        
        # this field is used by edit screen to determine how many products to check
        echo '<input type=hidden name=nbr_products value="'.$num_results.'">';
         #   echo '<br>records found ='.$num_results;
         
         echo '</th>';
         echo '</font>';
        
         echo '</tr>';
          for ($i=0; $i <$num_results; $i++)
          {
        
        
          $row = mysql_fetch_array($result);
        
             if ($row['category'] == '1' && $printed_category1 == "N") {
                $printed_category1 = "Y";
                echo '<tr><td colspan=6 bgcolor="#9bbcc2">Regular Coffees </td><td colspan=1  bgcolor="#FFFF66">Short </td></tr>';
             }
             if ($row['category'] == '2' && $printed_category2 == "N") {
                $printed_category2 = "Y";
                echo '<tr><td colspan=6 bgcolor="#9bbcc2">Decaf Coffees </td><td colspan=1  bgcolor="#FFFF66">Short </td></tr>';
             }
        
             if ($row['category'] == '3' && $printed_category3 == "N") {
                $printed_category3 = "Y";
                echo '<tr><td colspan=6 bgcolor="#9bbcc2">Special Order Coffees </td><td colspan=1  bgcolor="#FFFF66">Short </td></tr>';
             }
        
                
        	echo '<input type=hidden name="p'.$i.'" value="'.$row['product_code'].'">';
        	echo '<input type=hidden name="pounds'.$i.'" value="'.$row['bag_lbs'].'">';
        	echo '<input type=hidden name="discription'.$i.'" value="'.$row['item_description'].'">';
        
 
                    echo '<tr>';
               	
   	    	
           	
          	echo '<td>';
        	echo $row['product_code'];
        	 
  
        
          	echo '</td><td>';
          	$P_code=$row['product_code'];
          	$P_value=$_REQUEST["$P_code"];
        
          	echo '<input type=text size=5 value="'.$P_value.'" name="'.$row['product_code'].'">';
          	echo '</td><td align=left>'.$row['item_description'].'</td>';
        	
        //************************************************************************************
        //*************************Do Function Calls to Display Commitment Info***************
        //************************************************************************************
        	
        	//Customer Key is assigned above**************************************************
        	//These are the date ranges that are hard coded in********************************
          // find-me
        	$item_code=$row['product_code'];
        //	$debug .= "<br> committment section ";
        //  $debug .= "<br>item code = $item_code <br>";
        //  $debug .= "customer key = $customer_key <br>";
        //  $debug .= "import year = $import_year <br>";
        // 	$debug .= find_commitment_code($customer_key,$item_code,$import_year);
        	
        	$total_commitment_code=find_commitment_code($customer_key,$item_code,$from_year);
        	
                if ($row['on_allocation'] == 1) {
   	           echo '<td align="center" bgcolor="#FFFF66">';
               } else {
                    echo '<td  align="center" >';
               }  
        	
        	echo ' <font color=blue>'.$total_commitment_code.'</font></td>';
        	
        	$total_code_sales=find_code_total($customer_key,$item_code,$from_date,$to_date);
        	
               if ($row['on_allocation'] == 1) {
   	           echo '<td align="center" bgcolor="#FFFF66">';
               } else {
                    echo '<td  align="center" >';
               }  
        	
        	echo '<font color=green>'.$total_code_sales.'</font></td>';
        	$remaining_code=$total_commitment_code-$total_code_sales;
        	
                if ($row['on_allocation'] == 1) {
   	           echo '<td align="center" bgcolor="#FFFF66">';
               } else {
                    echo '<td  align="center" >';
               }  
        	
        	if ($remaining_code <= '0') 
        	{
        	echo '<font color=green>'.$remaining_code.'</font></td>';
        	}
        	else
        	{
        	echo '<font color=red>'.$remaining_code.'</font></td>';
        	}
        	
                if ($row['on_allocation'] == 1) {
   	           echo '<td align="center" bgcolor="#FFFF66">';
               } else {
                    echo '<td  align="center" >';
               }  
        	#echo '<td>';
        	echo item_inventory($item_code,$fob_code);
        	echo '</td>';
 
        	if ($row['price'] != '' && $row['price'] != 0.00) {
        	   # echo '$'.$row['price'];
        	    echo '<input type=hidden name="price'.$i.'" value="'.$row['price'].'">';
        	}
        	else {
        		echo '<input type=hidden name="price'.$i.'" value="">';
                  #  echo '&nbsp;&nbsp;&nbsp;&nbsp; ';
                }    
        	#echo '</td>';	
        	

        	echo "</tr>";
        	
        	
        }
        //****************************************************************************************
        //*****************************************Shipping Static Box****************************
        //****************************************************************************************
        
          	echo '</tr></table>';
        	echo '<font size=3 color=blue>Click to be taken to an order confirmation screen: </font>';
        	echo '<INPUT TYPE="SUBMIT" name="SUBMIT" accesskey="c" value="Confirm">';
        	echo '<br><br>';
        	echo '<table border=1 Bordercolor="#9bbcc2" width=200 align=left>';
        	echo '<tr><td>';
        	echo '<font size=2 color=blue><center>Shipping Information</center></font>';
        	echo '</td></tr>';
        
        	echo '<tr><td>';
        	echo "<font size=1 color=black>Shipping Date: $ship_date</font><br>";
        	echo '<input type=hidden name=ship_date value="'.$ship_date.'">';
        	echo '</td></tr>';
        
          	echo '<tr><td>';
        	echo "<font size=1 color=black>Warehouse Notify: $warehouse_to_whom</font><br>";
        	echo '<input type=hidden name=warehouse_to_whom value="'.$warehouse_to_whom.'">';
            	echo '</td></tr>';
        
          	echo '<tr><td>';
        	echo "<font size=1 color=black>FOB City: $fob_city</font><br>";
        	echo '<input type=hidden name=fob_city value="'.$fob_city.'">';
        	echo '<input type=hidden name=fob_code value="'.$fob_code.'">';
            	echo '</td></tr>';
        
        	echo '<tr><td>';
        	echo "<font size=1 color=black>Trucking Company: $truck</font><br>";
        	echo '<input type=hidden name=truck value="'.$truck.'">';
        	echo '</td></tr>';
        
        	echo '<tr><td>';
        	echo "<font size=1 color=black>Load Type: $load_type</font><br>";
        	echo '<input type=hidden name=load_type value="'.$load_type.'">';
        	echo '</td></tr>';
        
        	echo '<tr><td>';
        	echo "<font size=1 color=black>Stack Type: $stack_type</font><br>";
        	echo '<input type=hidden name=stack_type value="'.$stack_type.'">';
        	echo '</td></tr>';
        
        	echo '<tr><td>';
        	echo "<font size=1 color=black>Shipping Note: $ShipNote</font><br>";
        	echo '<input type=hidden name=ShipNote value="'.$ShipNote.'">';
        	echo '</td></tr>';
        
        	echo '</table>';
        	echo '</center>';
        
        	echo '</form>';
        	echo '</BODY>';
        	echo '</HTML>';
}

//*********************************************************************************
//***************************This is where the edit Page Starts********************
//*********************************************************************************

//echo $_REQUEST['SUBMIT'];
if ($_REQUEST['SUBMIT'] == 'Confirm') {
               // create short variable names
               // action is not used right now but might be, id of course is required.
               
                 $action=$_REQUEST['action'];
                 $edit_value=$_REQUEST['edit'];
                 $ship_date=$_REQUEST['ship_date'];
                 $warehouse_to_whom=$_REQUEST['warehouse_to_whom'];
                 $truck=$_REQUEST['truck'];
                 $load_type=$_REQUEST['load_type'];
                 $stack_type=$_REQUEST['stack_type'];
                 $fob_city=$_REQUEST['fob_city'];
                 $fob_code=$_REQUEST['fob_code'];
                 $ShipNote=$_REQUEST['ShipNote'];
                 $warehouse_name=$_REQUEST['warehouse_name'];
               
               
                 $total_bags = 0;
                 $total_pounds= 0;
                 $pounds=0;
               
               
               
               # to control loops.
                 	$num_products = $_REQUEST['nbr_products'];
                 	$test_name = "p0";
               	$product[0] = $_REQUEST[$test_name];
                  	$amount_name = $product[0];
                  	$product_amount[0] = $_REQUEST[$amount_name];
               
               
               //**************************************************************************************
               //*********************Begin Order Confirmation Screen**********************************
               //**************************************************************************************
               
               
               logo();
               
                 $email = "orders@coopcoffees.com";
                 $message = "Customer ".$_SESSION['valid_user']." has placed an order";
               
                 mail( "abby@coopcoffees.com,bill@coopcoffees.com,pnewberry@hfhi.org", "New Order",
                   $message, "From: $email" );
                 #header( "Location: http://www.example.com/thankyou.html" );
               
               
               
               echo '<br><center><h1>Order Confirmation</h1></center><br><br><br><br>';
               
               print 'confirm order';
               # pull each item that was available on the previous page.
                   echo '<bold><font size=4 color=blue>You are about to order the following items:</font></bold>';
                   echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1 Bordercolor='#9bbcc2'>";
                   echo '<tr>';
               	echo '<th align=center>Item</th>';
               	echo '<th align=center>Product Discription</th>';
               	echo '<th align=center>Bags</th>';
               	echo '<th align=center>Weight</th>';
               	echo '</tr>';
               
               	echo '<form name=frmMain method=post action="cooporder.php">';
               	echo '<input type=hidden name=nbr_products value="'.$num_products.'">';
               
               
               
                 for ($i=0; $i <$num_products;  $i++)
                 {
               
                  $test_name = 'p'.$i;
                  $pricev =  'price'.$i;
                  $pounds='pounds'.$i;
                  $product[$i] = $_REQUEST[$test_name];
                  $pound[$i] = $_REQUEST[$pounds];
                  $price[$i] = $_REQUEST[$pricev];
                  $amount_name = $product[$i];
                  $product_amount[$i] = $_REQUEST[$amount_name];
                  $discription=$_REQUEST["'discription'.$i"];
               
               
                  echo "<input type=hidden name=product$i value=\"$amount_name\">";
                  echo "<input type=hidden name=product_amount$i value=\"$product_amount[$i]\">";
                  echo "<input type=hidden name=pounds$i value=\"$pound[$i]\">";
                  echo "<input type=hidden name=price$i value =\"$price[$i]\">";
                   if ($product_amount[$i] != 0){
                 	echo '<tr>';
                	echo "<td><font color=black>".$amount_name."&nbsp;</font></td>";
                	echo "<td><font color=black>".$_REQUEST['discription'.$i]."&nbsp;</font></td>";
                	echo "<td><font color=black>".$product_amount[$i]."&nbsp;</font></td>";
                	echo "<td><font color=black>".$product_amount[$i]*$pound[$i]."&nbsp;</font></td>";
                	echo "</tr>";
                	echo "<input type=hidden name=\"$amount_name\" value=\"$product_amount[$i]\">";
                       $total_pounds=$total_pounds + ($product_amount[$i]*$pound[$i]);
                	$total_bags=$total_bags + $product_amount[$i];
               	   }
               
                 }
                 echo '<tr><th align=center></th>&nbsp;<th align=center>&nbsp;</th><th align=center><font size=1 color=blue>Total Bags</font></th><th align=center><font size=1 color=blue>Total Weight</font></th></tr>';
                 echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>$total_bags</td><td>$total_pounds</td><td>&nbsp;</td></tr>";
                 echo "</table>";
               
                 	echo '<br><table border=1 Bordercolor="#9bbcc2" width=200 align=right>';
               
               	echo '<tr><td>';
               	echo '<font size=2 color=blue><center>Shipping Information</center></font>';
               	echo '</tr></td>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Shipping Date: $ship_date</font><br>";
               	echo '<input type=hidden name=ship_date value="'.$ship_date.'">';
               	echo '</tr></td>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Warehouse Notify: $warehouse_to_whom</font><br>";
               	echo '<input type=hidden name=warehouse_to_whom value="'.$warehouse_to_whom.'">';
               	echo '</tr></td>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Warehouse: $fob_city</font><br>";
               	echo '<input type=hidden name=fob_city value="'.$fob_city.'">';
               	echo '<input type=hidden name=fob_code value="'.$fob_code.'">';
               	echo '</tr></td>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Trucking Company: $truck</font><br>";
               	echo '<input type=hidden name=truck value="'.$truck.'">';
               	echo '</td><tr>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Load Type: $load_type</font><br>";
               	echo '<input type=hidden name=load_type value="'.$load_type.'">';
               	echo '</td></tr>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Stack Type: $stack_type</font><br>";
               	echo '<input type=hidden name=stack_type value="'.$stack_type.'">';
               	echo '</td></tr>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Shipping Note: $ShipNote</font><br>";
               	echo '<input type=hidden name=ShipNote value="'.$ShipNote.'">';
               	echo '</td></tr>';
               
               	echo '</table>';
               
               
                 echo'<input type="submit" value="edit order" accesskey="e" name="SUBMIT">';
                 echo'<input type="submit" value="delete order" accesskey="d" name="SUBMIT">';
                 echo'<input type="submit" value="place order" accesskey="o" name="SUBMIT">';
                 echo'<br><br>';
               
                 echo '<font size=3 color=blue>Please leave a note - <br>especially concerning shipping requirements</font><br>';
                 echo '<textarea name="note" cols="50" rows="5"></textarea>';
                 echo'</form>';

}

//*************************************************************************************
//********************************Delete Order*****************************************
//*************************************************************************************


if ($_REQUEST['SUBMIT'] == 'delete order'){
header("Location: http://www.coopcoffeesbeans.com/index.php");
}


//**************************************************************************************
//******************************Order Processing Section********************************
//**************************************************************************************

if ($_REQUEST['SUBMIT'] == 'place order'){

               # connect to database
                 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
                 mysql_select_db('cbeans', $db_conn);
               
                 if (!$db_conn)
                 {
                    echo 'Error: Could not connect to database.  Please try again later.';
                    exit;
                 }
               ?>
               
               <SCRIPT LANGUAGE="JavaScript">
                 <!-- Begin
                 function varitext(text){
                 text=document
                 print(text)
                 }
                 // End -->
                 </script>
                 </HEAD>
               
               <?
               
                $note = $_REQUEST['note'];
                $warehouse_to_whom = addslashes($_REQUEST['warehouse_to_whom']);
                $fob_city = $_REQUEST['fob_city'];
                $fob_code = $_REQUEST['fob_code'];
                $ship_date=$_REQUEST['ship_date'];
                $truck=$_REQUEST['truck'];
                $load_type=$_REQUEST['load_type'];
                $stack_type=$_REQUEST['stack_type'];
                $ShipNote=$_REQUEST['ShipNote'];
               
               # create header record.
               
               $note=addslashes($note);
               $ShipNote=addslashes($ShipNote);
               
               $query = "INSERT INTO $tbl_order_header (header_id, order_nbr, customer_key,order_date,STATUS,warehouse_th,comments,ship_date,fob_city, truck,load_type,stack_type, warehouse,Ship_Note) VALUES (NULL ,0,'$contact_id', CURDATE(),'I','$warehouse_to_whom', '$note', '$ship_date', '$fob_city', '$truck','$load_type','$stack_type','$fob_code', '$ShipNote' )";
               $note=stripslashes($note);
               $ShipNote=stripslashes($ShipNote);
               
              // $debug .= "<br> inserting: $query ";
               
               # insert header record.
                 $return = mysql_query($query, $db_conn);
               //  echo 'return is a returen'.$return;
               
               
               # get last id added
                 //$query = "select LAST_INSERT_ID();";
                 $id = mysql_insert_id();
               //  $debug .= "<br>The id is $id ";
                 
                 $num_products = $_REQUEST['nbr_products'];
              //  .= "The number of products are $num_products";
               
             //  $debug .= "added id ".$id;
               # now loop thru products, find any that have amounts, create item and lot records.
               # only one lot item is initally added, more can be added by bill as needed.
               
                for ($i=0; $i <$num_products;  $i++)
                 {
                 $product_amount[$i]=$_REQUEST["product_amount$i"];
                 $product[$i]=$_REQUEST["product$i"];
                 $pounds[$i]=$_REQUEST["pounds$i"];
                 $price[$i]=$_REQUEST["price$i"];
               
               
                   if ($product_amount[$i] > 0) {
               
               	$query = "insert into $tbl_order_item values (NULL,'".$id."','".$product[$i]."', 0,".$product_amount[$i].",".$pounds[$i].", 'I',0)";
               	$result = mysql_query($query, $db_conn);
               	$id2=mysql_insert_id();
               	$query = "insert into $tbl_lot_item values (NULL,'".$id."','".$id2."', 0,0,NULL,NULL,".$product_amount[$i].",0.00,'I',NULL,NULL,NULL,NULL)";
               	$result = mysql_query($query, $db_conn);
               
                   }
                 }
               
               
               # get customer info.
                 mysql_select_db('coop_contact');
                 $query = "select * from $tbl_coop_contact where contact_id = '".$contact_id."'";
               
               # retrieve information:
                 $result = mysql_query($query, $db_conn);
                 $num_results = mysql_num_rows($result);
               
               # prepare to extract
                 $row = mysql_fetch_array($result);
               
               
               ?>
               <table>
               <tr>
               <td>
                To:
               <?
               echo $row['Warehouse'];
               ?>
                <br>
                CC:
               <?
               echo $row['Name'];
               ?>
                <br>
                From: Abby Trantham - Cooperative Coffees
               <br>
                Please call (229)924-3035 or <br> email <a href="mailto:abby@coopcoffees.com" >abby@coopcoffees.com </a> 
                <br> if there is any questions or problems concerning
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
               <td>
               Release to:
               <br>
               <?
               echo "<P>";
               echo $row['ShipAddress1']."<br>";
if (strLen($row['ShipAddress2']) > 0 ) {
   echo $row['ShipAddress2']."<br>";
}
if (strLen($row['ShipAddress3']) > 0 ) {
   echo $row['ShipAddress3']."<br>";
}
               echo $row['ShipCity'].", ".$row['ShipState']."  ".$row['ShipZip']."<br>";
               echo "Phone: ".$row['WorkPhone']."<br>";
               
               
               
               
               ?>
               </td>
               <td>
               Confirmation Number #
               <?
               echo $id;
               ?>
               <BR>
               Date:
               <?
               echo date('d F Y');
               ?>
               
               <br>
               </td>
               <tr>
               </table>
               
               <table cellSpacing=0 Bordercolor="#9bbcc2"  cellPadding=0 width='95%' border=1>
               <tr>
               <td>Item</td>
               <td>Bags</td>
               <td>Weight</td>
               <td>Description</td>
               </tr>
               
               <?
               
               //  mysql_select_db('lot_item');
               //echo 'this is the id I am a searching on'.$id;
                 $query = "select distinct li.header_id, li.item_id, li.lot_id,
                      ci.item_code, ci.item_description, ci.weight, oi.cost, oi.quantity, ci.price
                      from $tbl_lot_item li, $tbl_order_item oi , $tbl_order_header oh, $tbl_item_description ci
                      where li.item_id = oi.item_id
                      and ci.item_code = oi.item_code
                      and li.header_id = oh.header_id
                      and oh.header_id = $id
                      order by li.header_id, li.item_id, li.lot_id ";
               
               
                 $result = mysql_query($query, $db_conn);
               
                 $num_results = mysql_num_rows($result);
               
               
                 for ($i=0; $i <$num_results; $i++)
                 {
               
                 $row = mysql_fetch_array($result);
               
               
                  echo '<tr>';
                  echo '<td>';
               
                  echo  $row['item_code'].'</td>';
               
                  $total_bags = $total_bags + $row['quantity'];
                  echo '<td>'.$row['quantity'];
                  echo '</td>';
               
                  $pounds = $row['weight'] * $row['quantity'];
                  echo '<td>'.$pounds;
                  echo '</td>';
                  $total_pounds=$total_pounds + $pounds;
               
   
                  echo '<td align="left">'.$row['item_description'].'</td>';
  
               }
                 echo '</tr>';
                 echo '<tr><td><font size=3 color=blue>Totals:</font></td><td><font size=3 color=blue>'.$total_bags.'</font></td><td><font size=3 color=blue>'.$total_pounds.'</font></td><td>&nbsp;</td></tr>';
                 echo '</table>';
                 echo '<br><br>';
               
               echo '<table border=1 Bordercolor="#9bbcc2" width=200 align=left>';
               
               	echo '<tr><td>';
               	echo '<font size=2 color=blue><center>Shipping Information</center></font>';
               	echo '</tr></td>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Shipping Date: $ship_date</font><br>";
               	echo '</tr></td>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Warehouse Notify: $warehouse_to_whom</font><br>";
               	echo '</tr></td>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Fob City: $fob_city</font><br>";
               	echo '</tr></td>';
               
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Trucking Company: $truck</font><br>";
               	echo '</td><tr>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Load Type: $load_type</font><br>";
               	echo '</td></tr>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Stack Type: $stack_type</font><br>";
               	echo '<tr><td>';
               
               	echo '<tr><td>';
               	echo "<font size=1 color=black>Shipping Note: $ShipNote</font><br>";
               	echo '<tr><td>';
               
               	echo '</table>';
               
               
               
               
               ?>
               
                 <BODY>
                 <DIV ALIGN="CENTER">
                 <FORM>
                 <INPUT NAME="print" TYPE="button" VALUE="Print DO"
                 ONCLICK="varitext()">
                 </FORM>
                 </DIV>
               <?
               
               echo '<br><br><br><br><br><br><br>';
               echo '<font size=3><a href="../index.php">Back to the Customer Menu</a></font><br>';
               echo '<a href="../logout.php">Log Out</a><br>';
}

// echo "debug info";
// echo $debug;
?>


