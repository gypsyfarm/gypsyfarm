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
     
    
    #echo 'document-root = '.$DOCUMENT_ROOT.'<BR>';
    
    $quicksearch = $_REQUEST['quicksearch'];
    
    $sort_option = $_REQUEST['sort_option'];
    $local = $_REQUEST['local'];
    
    $my_session_var = $_SESSION['search_string'];	
    	
      $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
      mysql_select_db('cbeans', $db_conn);
 
      	
       if ($sort_option == '2') {
    	$sort_value = ' order by item_id ';
       }
       else {
    	$sort_value = 'order by warehouse, item_code, (lot_ship + 0) ';
       }
 
 
    
    if ($local == 'yes') {

       $query =  $my_session_var;
       $query_plus_sort =  $my_session_var.$sort_value;
    }
    	
    else {
        #  set if search should include inactive records or not
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
           $inactive_items_too = $_REQUEST['inactive_items_too']; 
         
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
           
           if (isset($warehouse) && $warehouse != "") {
           	$search_string = $where.$search_string.$and." warehouse like '".$warehouse."%' ";
           	$and = " and ";
            	$where = " ";  	
           }    
           
           if (isset($scribd_id) && $scribd_id != "") {
           	$search_string = $where.$search_string.$and." scribd_id like '".$scribd_id."%' ";
           	$and = " and ";
            	$where = " ";  	
           }      
           
            if (isset($arrival_date) && $arrival_date != "") {
           	$search_string = $where.$search_string.$and." arrival_date > '".$arrival_date."%' ";
           	$and = " and ";
            	$where = " ";  	
           }            
         
           if ($item_active_where == '') {
           	$and = "  ";
           }
           
           $query = "select * from $tbl_coop_item  $search_string  $and  $item_active_where ";
           $query_plus_sort = "select * from $tbl_coop_item  $search_string  $and  $item_active_where ".$sort_value;
        }   
    }    	 
    
    $keyway = $_REQUEST['keyway'];
    $key = $_REQUEST['key'];
    $rec_type = '0';
    
    $quicksearch = $_REQUEST['quicksearch'];
    if ($quicksearch != "no") {
        $query = "SELECT ci.*, info.* FROM cupping_info info, coop_item ci 
         WHERE info.lot_key = ci.item_id  and  cupping_notes != '' and rec_type = '0' and ci.item_code like '$quicksearch%';";        
   }   
    elseif  ($keyway =  "234") {
        $query = "SELECT ci.*, info.* FROM cupping_info info, coop_item ci 
         WHERE info.lot_key = ci.item_id  and  cupping_notes != '' and rec_type = '0' and ci.item_id =  '$key';";
        }
    else  {
    
    $query = "SELECT ci.*, info.* FROM cupping_info info, coop_item ci 
         WHERE info.lot_key = ci.item_id  and  cupping_notes != '' and rec_type = '0'; ";
         
        }
 
     # echo "<br>$query <br>";
$result = mysql_query($query, $db_conn);
if (mysql_num_rows($result) >0 )  {     
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $num_results = mysql_num_rows($result);
   # echo "<br>num results are $num_results  <br> ";
    echo '<table border="0"  width="80%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
 
     
    for ($i=0; $i <$num_results;  $i++) {
    	   # echo "<tr><td colspan='4'>i=$i: ".$row['item_code']."-".$row['lot_ship']."<br></td></tr>";
         $key = $row['item_id'];           
         echo '<tr bgcolor="#FFFF66">';
         echo '<td>'.$row['item_code'];
         echo '-'.$row['lot_ship'].'</td>';
         echo '<td>'.$row['item_description'].'</td>'; 
         echo '<td>'.$row['mark'].'</td>';   
         echo '<td> Inventory</td>';             
         echo '</tr>';
         echo '<tr> ';
         echo "<td colspan='4'>Coop Coffees Profile:	<br>";
         echo $row['cupping_notes'];
         echo "</td>";
         echo '</tr>';
            
         echo "<tr>";
         echo "<td>Roast Profile: ".$row['roast_profile']." </td>";
         echo "<td>Roast Behavior: ".$row['roast_behavior']." </td>";
         echo "<td>Green Appearance Defects: ".$row['appearance_defects']." </td>";
         echo "<td>&nbsp;</td>";            
         echo "</tr>";
            
         echo "<tr>";
         echo "<td>Fragrance: ".$row['fragrance']." </td>";
         echo "<td>Body: ".$row['body']." </td>";
         echo "<td>Moisture: ".$row['moisture']." </td>";
         echo "<td>&nbsp;</td>";            
         echo "</tr>";
         
         echo "<tr>";
         echo "<td>Aroma: ".$row['aroma']." </td>";
         echo "<td>Flavor: ".$row['flavor']." </td>";
         echo "<td>Density: ".$row['density']." </td>";
         echo "<td>&nbsp;</td>";            
         echo "</tr>";
         
         echo "<tr>";
         echo "<td>Acidity: ".$row['acidity']." </td>";
         echo "<td>Aftertaste: ".$row['aftertaste']." </td>";
         echo "<td>Color: ".$row['color']." </td>";
         echo "<td>Screen: ".$row['screen']." </td>";            
         echo "</tr>";
            
            /*
            Need to do roaster loop here: 

               */
           $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
           mysql_select_db('cbeans', $db_conn);    
               
           $roaster_query = "SELECT cc.Company, cc.name, ci.*, info.* FROM cupping_info info, coop_item ci, coop_contact cc 
                             WHERE info.lot_key = ci.item_id  and  cupping_notes != '' and info.roaster = cc.contact_id 
                             and rec_type = '2' and ci.item_id =  '$key';";    
                             
           # echo "<br>$query <br>";
         # echo "<tr><td colspan='4'> <br>$roaster_query</td></tr>";
           $roaster_result = mysql_query($roaster_query, $db_conn);
           $roaster_num_results = mysql_num_rows($roaster_result); 
          # echo "<tr><td colspan='4'> <br>Roaster Results: $roaster_num_results</td></tr>";
           if (mysql_num_rows($roaster_result) >0 )  {
              $roaster_row = mysql_fetch_array($roaster_result);
              $roaster_num_results = mysql_num_rows($roaster_result);  
                for ($x=0; $x <$roaster_num_results;  $x++) {
      
      
                  echo "<tr><td colspan='4'><hr><br></td></tr>";
                  echo "<tr><td bgcolor='#CCFF66'  colspan='4'>".$roaster_row['Company']." - ".$roaster_row['name']."</td></tr>";
                 
                 /*
                  echo '<tr>';
                  echo '<td>'.$roaster_row['item_code'];
                  echo '-'.$roaster_row['lot_ship'].'</td>';
                  echo '<td>'.$roaster_row['item_description'].'</td>'; 
                  echo '<td>'.$roaster_row['mark'].'</td>';   
                  echo '<td> Inventory</td>';             
                  echo '</tr>';
                  
                  */
                  echo '<tr>';
                  echo "<td colspan='4'>Roaster Profile:	<br>";
                  echo $roaster_row['cupping_notes'];
                  echo "</td>";
                  echo '</tr>';
            
                  echo "<tr>";
                  echo "<td>Roast Profile: ".$roaster_row['roast_profile']." </td>";
                  echo "<td>Roast Behavior: ".$roaster_row['roast_behavior']." </td>";
                  echo "<td>Green Appearance Defects: ".$roaster_row['appearance_defects']." </td>";
                  echo "<td>&nbsp;</td>";            
                  echo "</tr>";
                  
                  echo "<tr>";
                  echo "<td>Fragrance: ".$roaster_row['fragrance']." </td>";
                  echo "<td>Body: ".$roaster_row['body']." </td>";
                  echo "<td>Moisture: ".$roaster_row['moisture']." </td>";
                  echo "<td>&nbsp;</td>";            
                  echo "</tr>";
                  
                  echo "<tr>";
                  echo "<td>Aroma: ".$roaster_row['aroma']." </td>";
                  echo "<td>Flavor: ".$roaster_row['flavor']." </td>";
                  echo "<td>Density: ".$roaster_row['density']." </td>";
                  echo "<td>&nbsp;</td>";            
                  echo "</tr>";
                  
                  echo "<tr>";
                  echo "<td>Acidity: ".$roaster_row['acidity']." </td>";
                  echo "<td>Aftertaste: ".$roaster_row['aftertaste']." </td>";
                  echo "<td>Color: ".$roaster_row['color']." </td>";
                  echo "<td>Screen: ".$roaster_row['screen']." </td>";            
                  echo "</tr>";
                  
                  $roaster_row = mysql_fetch_array($roaster_result);
                  echo "<tr><td colspan='4'><hr></td></tr>";
     
              
           }        # for roaster loop end        
               
           }  #end if results > 0 
          #  echo "<tr><td colspan='4'><hr><br> Next item goes here</td></tr>";
            
            
    
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
