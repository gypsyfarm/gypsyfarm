<?php
require("../functions.php");
require("../tables.php");
session_start();

require("../check_login.php");

?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../general.css">

<!-- changed #228B22 to #9bbcc2 -->
</head>


<?
require("left_menu.php");    
    
echo '<td  valign="top">';
echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
echo '<tr>';
echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
echo '<u>C</u>ontent:</b></font></td>';
echo '</tr>';
echo '<tr>';
echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
echo '<p align="right">¤ ';
echo date('H:i, jS F');
echo '</p>';
 
 
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {

    $quicksearch = $_REQUEST['quicksearch'];    
    $sort_option = $_REQUEST['sort_option'];
   // $local = $_REQUEST['local'];    
   // $my_session_var = $_SESSION['search_string'];	
   	
    if ($sort_option == '2') {
    	$sort_value = ' order by item_id ';
    }
    else {
    	$sort_value = 'order by warehouse, item_code, (lot_ship + 0) ';
    }

    #  set if search should include inactive records or not
        $inactive_items_too = $_REQUEST['inactive_items_too']; 
        if ( $inactive_items_too == "on") {
          $item_active_where = '';
        }
        else {  	
          $item_active_where = ' item_active = 0 ';
        }
        
        if ($quicksearch != "no") {
           $query = "select * FROM $tbl_coop_item    WHERE item_code like '$quicksearch%' and $item_active_where ";
           $query_plus_sort = "select * FROM $tbl_coop_item    WHERE item_code like '$quicksearch%' and $item_active_where ".$sort_value;
        }   
        else {   	
           $and = " ";
           $where = " where ";
           $search_string = "";
           $item_code = $_REQUEST['item_code']; 
           $lot_ship = $_REQUEST['lot_ship'];  
         
           if (isset($item_code) && $item_code != "") {
           	$search_string = $where.$search_string.$and." item_code like '".$item_code."%' ";
           	$and = " and ";
           	$where = " ";
           } 	
          
           if (isset($lot_ship) && $lot_ship != "") {
           	$search_string = $where.$search_string.$and." lot_ship like '".$lot_ship."%' ";
           	$and = " and ";
           	$where = " ";
           }  
           
           $warehouse = $_REQUEST['warehouse']; 
           
           if (isset($warehouse) && $warehouse != "") {
           	$search_string = $where.$search_string.$and." warehouse like '".$warehouse."%' ";
           	$and = " and ";
            	$where = " ";  	
           }    
            $scribd_id = $_REQUEST['scribd_id'];           
           if (isset($scribd_id) && $scribd_id != "") {
           	$search_string = $where.$search_string.$and." scribd_id like '".$scribd_id."%' ";
           	$and = " and ";
            	$where = " ";  	
           }      
           
           $arrival_date = $_REQUEST['arrival_date']; 
            if (isset($arrival_date) && $arrival_date != "") {
           	$search_string = $where.$search_string.$and." arrival_date > '".$arrival_date."%' ";
           	$and = " and ";
            	$where = " ";  	
           }          
           
            $container = $_REQUEST['container']; 
            if (isset($container) && $container != "") {
           	$search_string = $where.$search_string.$and." container like '".$container."%' ";
           	$and = " and ";
            $where = " ";  	
           }      
           
            $mark = $_REQUEST['mark']; 
            if (isset($mark) && $mark != "") {
           	$search_string = $where.$search_string.$and." mark like '".$mark."%' ";
           	$and = " and ";
            $where = " ";  	
           }   
         
           if ($item_active_where == '') {
           	$and = "  ";
           }
           
           $query = "select * from $tbl_coop_item  $search_string  $and  $item_active_where ";
           $query_plus_sort = "select * from $tbl_coop_item  $search_string  $and  $item_active_where ".$sort_value;
          
    }    	 
         
   //  $_SESSION['search_string'] = $query;

   //  echo "<br>$query <br>";
   //  echo "<br>$query_plus_sort <br>";
     $result = mysql_query($query_plus_sort, $db_conn);
     if (mysql_num_rows($result) >0 )  {
        // if they are in the database register the user id
        $row = mysql_fetch_array($result);
        $num_results = mysql_num_rows($result);
        echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
        echo "<td><a href='product_results.php?sort_option=2&local=yes'>Item Nbr. </a> </td>";
        echo "<td><a href='product_results.php?sort_option=1&local=yes'>Item / Lot </a></td>";
        echo '<td colspan=2>Click on heading to left to change sort </td>'; 
      
        echo '</tr>';
     
        for ($i=0; $i <$num_results;  $i++) {
            $Company = $row['Company'];
            if ($Company == "") 
               $Company = "No Company Name";
                        
            echo '<tr>';
            echo '<td>'.$row['item_id'].'</td>';
            echo '<td><a href="product_maint.php?item_id=';
            echo "'".$row['item_id']."'";
            echo '">'.$row['item_code'].' / '.$row['lot_ship'].'</a></td>';
            echo '<td>'.$row['warehouse'].'</td>'; 
            echo '<td>'.$row['item_description'].'</td>';                 
            echo '</tr>';
    
            $row = mysql_fetch_array($result);
        }   
       
        echo '</table>';
    
    }  # end   if (mysql_num_rows($result) >0 )
          
}   # bad login id:  
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
