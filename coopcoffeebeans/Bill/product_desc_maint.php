<?php
require("../functions.php");
require("../tables.php");
session_start();



require("../check_login.php");
class UpdateLotPrice{
    var $item_code;
    var $item_price;
    
    
function UpdateLotPrice($item_code,$price){
	$this->item_code = $item_code;
	$this->item_price = $price; 
    }
    
    // use a function without variables 
    function Update_Price(){ 
    	global $tbl_coop_item;
         $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
         mysql_select_db('cbeans', $db_conn);

         if (!$db_conn)  {
            echo 'Error: Could not connect to database.  Please try again later.';
            exit;
          }
          $non_member_price = $this->item_price + .15;
          $query = "update $tbl_coop_item
                    set member_price = $this->item_price,
                        non_member_price = $non_member_price
                    where item_code = '$this->item_code'
                      and STATUS = 'In Stock'"; 
          
         $result = mysql_query($query, $db_conn);
         if (!$result)
            $Message =  " However Update failed:<br>$query <br>";
         else
            $Message = " and <font size=2>Lot Prices Updated";          
          
          
          return $Message;
     }
    
} 

?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../general.css">

<!-- changed #228B22 to #9bbcc2 -->
</head>
<!-- Javascript Routines  -->
<script language="Javascript">

</script>

<?
require("left_menu.php");  


    echo '<td  valign="top">';
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
 
                echo '¤ ';
            $current_date = date('Y-m-d H:i:s');
            echo date('H:i, jS F');
            echo '</font>';
    
                        echo '</td>';
        echo '</tr>';
 
 
 
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';

 
 
//********Present the Main Area  *********************************************
if (isset($_SESSION['contact_id']))  {
 
  
# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }


$yr_begin=$_REQUEST[yr_begin];
$action =  $_REQUEST['submit'];


if ($action == 'change_year') {
	echo "<br>changing value of action";
	$action="change_year";
}
 
if (!ISSET($yr_begin)) {
	$yr_begin = '2005';
}

$searchterm = stripslashes($_GET['item_code']);
$searchterm = trim($searchterm);


if (!isset($searchterm)){
$searchterm=0;
}

# do updates or add as needed

#  Return form variables.

   if ($action == "Update" || $action == "Add") {
     $item_code=$_REQUEST[item_code];
     $category=$_REQUEST[category];
     $item_description=$_REQUEST[item_description];
     $desc_notes=$_REQUEST[desc_notes];
     $rank=$_REQUEST[rank];
     $weight=$_REQUEST[weight];
     $total_pur=$_REQUEST[total_pur];
     $price=$_REQUEST[price];
     $beginning_balance =$_REQUEST[beginning_balance];   
    if ($_REQUEST[item_active] == "on" )
       $item_active = 1;
    else
       $item_active = 0;
    
    if ($_REQUEST[on_allocation] == "on" )
       $on_allocation = 1;
    else
       $on_allocation = 0;  
     

  }


# process an add request

 
  if ($action == "Add")

  {

    $query = "insert into $tbl_item_description
              ( item_code, item_description,
                weight, rank, category, item_active, desc_notes,total_pur, price, on_allocation)
              values ( '$item_code', '$item_description',
                  '$weight','$rank','$category','$item_active', '$desc_notes', '$total_pur','$price', '$on_allocation')";
                  
                  
          
      $result = mysql_query($query, $db_conn);
      if (!$result)
        echo "<br><font size=2>Add Failed";
     else
        $searchterm = $item_code;
        echo "<br><font size=2>Record Added";
        
          
  # begin new section:     
       
        $query = "select lot_key from $tbl_item_yr_balance   
                 where item_code = '$item_code' and yr_begin = '$yr_begin'"; 
        
        
     
        $result = mysql_query($query, $db_conn);               
        $num_results = mysql_num_rows($result);            
      if ($num_results == 0) {


    $query = "insert into $tbl_item_yr_balance 
              ( lot_key, item_code,  beginning_balance, yr_begin)
              values ( NULL,'$item_code', '$beginning_balance','$yr_begin')";
     }             
     else   {                 
        
     $query = "update $tbl_item_yr_balance set beginning_balance = '$beginning_balance' 
                 where item_code ='$item_code' and yr_begin = '$yr_begin'";
     }            
 

     $result = mysql_query($query, $db_conn);
     if (!$result)
        $form_message = "<font size=2>Yearly Balance was not updated";       
        
        
        
        
        # end section            
        
        
        

   }

# process update request.
 
  if ($action == "Update")
  {
    $query = "update $tbl_item_description set item_code = '".$item_code."',".
               "  item_description = '".$item_description."',".
               "  weight = '".$weight."',".
               "  rank = '".$rank."',".
               "  category = '".$category."',".
               "  desc_notes = '".$desc_notes."',".
               "  total_pur = '".$total_pur."',".
               "  price = '".$price."',".
                "  on_allocation = '".$on_allocation."',".
              "  item_active = '".$item_active."' where item_code ='".$item_code."'";

   #  echo "<br>query = $query <br>";
     $result = mysql_query($query, $db_conn);
     if (!$result) {
        echo "<br><font size=2>Record was not updated";
      }
     else {
        echo "<br><font size=2>Record has been Updated";
         $ThisLot = new UpdateLotPrice($item_code,$price);
         echo $ThisLot->Update_Price();
     }
        
        
        
  # begin new section:     
       
        $query = "select lot_key from $tbl_item_yr_balance   
                 where item_code = '$item_code' and yr_begin = '$yr_begin'"; 
        
        
     
        $result = mysql_query($query, $db_conn);               
        $num_results = mysql_num_rows($result);            
      if ($num_results == 0) {


    $query = "insert into $tbl_item_yr_balance 
              ( lot_key, item_code,  beginning_balance, yr_begin)
              values ( NULL,'$item_code', '$beginning_balance','$yr_begin')";
     }             
     else   {                 
        
     $query = "update $tbl_item_yr_balance set beginning_balance = '$beginning_balance' 
                 where item_code ='$item_code' and yr_begin = '$yr_begin'";
     }            
 

     $result = mysql_query($query, $db_conn);
     if (!$result)
        $form_message = "<font size=2>Yearly Balance was not updated";       
        
        
        
        
        # end section        
        

  }

 

 echo '<form name=frmMain method=post action="product_desc_maint.php?item_code='.$searchterm.'">';

 

    if ($searchterm == '0'){
	echo '<INPUT TYPE="SUBMIT" name="submit" value="Add">';
	}
  else
    {
   echo '<INPUT TYPE="SUBMIT" name="submit" value="Update">';
    }
//**********************************Gets the DataSet************************************
mysql_select_db($tbl_coop_item);

$query = "select id.*, b.beginning_balance, b.yr_begin from  (($tbl_item_description id )
          left join  $tbl_item_yr_balance b  on b.item_code = id.item_code and b.yr_begin = '$yr_begin') 
          where id.item_code = '$searchterm'";
 
 
# echo "<br>$query<br>";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
 
$row = mysql_fetch_array($result);

require("product_desc_fields.php");


}     
else {  
    if (isset($userid)) {
      // if they've tried and failed to log in
        echo 'Could not log you in';
    }
    else {
      // they have not tried to log in yet or have logged out
      echo '<font size=4 color=black>You are not logged in, please enter a valid userid and password.</font>';
    }
}


           echo '</form>';
?>


            <hr noshade size="1" color="#228B22">
             
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>


</body>

</html>
