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
#  require("left_menu.php");  


 #   echo '<td  valign="top">';
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
 
 /*

  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
    mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }
  
  */
# start
$key_to_use = $_GET['key_to_use'];
$query2 = "SELECT * FROM $tbl_coop_item_last_maint WHERE item_id =  '$key_to_use'";
// echo "<br>$query2 <br>";


$result2 = mysql_query($query2, $db_conn);
  
$row2 = mysql_fetch_array($result2);
$num_results = mysql_num_rows($result2);
//echo 'Last Maint by: '.$row2['updated_by'].' &nbsp;&nbsp;&nbsp;';
//echo 'Date: '.$row2['maint_date'].' &nbsp;&nbsp;&nbsp;';
//echo 'Type: '.$row2['action'].' &nbsp;&nbsp;&nbsp;';
/*

echo '<a href="javascript:poptastic(\'last_maint_detail.php\');"><font face="Verdana" size="1" color="#000000">Last Maint Detail</font</a>';
 */
#end 
  $alt = 'yes';
 echo '<table>';
 echo '<tr><td>';
 echo 'Last Maint by';
 echo '</td>';
 echo '<td>';
 echo 'Date';
 echo '</td>';
 echo '<td>';
 echo 'Action';
 echo '</td>';
 echo '<tr>';
 for ($i=0; $i <$num_results;  $i++) {    	     
     echo '<tr bgcolor="';
      if ($alt == 'yes' ){
         echo '#FFFFAA';
         $alt = 'no';
      }
      else {      
    	 echo '#FFFFFF';
    	 $alt = 'yes';
      }    
      echo '">';
    
      echo '<td>';
      echo $row2['updated_by'];
      echo '</td>';
      echo '<td>';
      echo $row2['maint_date'];
      echo '</td>';
      echo '<td>';
      echo $row2['action'];
      echo '</td>';
      echo '<tr>';	
      $row2 = mysql_fetch_array($result2);
}
echo '</table>';
 

            echo '<hr noshade size="1" color="#228B22">';
            echo "<br>";
            
# start3
$query3 = "SELECT * FROM $tbl_coop_item_last_maint2 WHERE item_id =  '$key_to_use' order by seq desc;";
//echo "<br>$query3 <br>";


$result3 = mysql_query($query3, $db_conn);
  
$row3 = mysql_fetch_array($result3);
$num_results = mysql_num_rows($result3);   


  $alt = 'yes';
 echo '<table width=100%>';
 echo '<tr><td>';
 echo 'Last Maint by';
 echo '</td>';
 echo '<td>';
 echo 'Date';
 echo '</td>';
 echo '<td>';
 echo 'Field';
 echo '</td>';
 echo '<tr>';


 $field_count = 0;
 for ($i=0; $i <$num_results;  $i++) {   
     extract($row3, EXTR_OVERWRITE, ""); 
     #echo "<br>Update by : $updated_by on $maint_date <br>";  
     
     echo '<tr bgcolor="';
      if ($alt == 'yes' ){
         echo '#FFFFAA';
         $alt = 'no';
      }
      else {      
    	 echo '#FFFFFF';
    	 $alt = 'yes';
      }    
      echo '">';
    
      echo '<td>';
      echo $updated_by;
      echo '</td>';
      echo '<td>';
      echo $maint_date;
      echo '</td>';
      echo '<td>';
   
     
 #    $field_count = 0;
 #    echo "processing record $seq and field_count is $field_count";
     if ($b_item_id <>  $a_item_id) {
      $field_count += 1;
      echo "item_id before: $b_item_id -> ";  
      echo "after : $a_item_id <br>";
     }

     if ($b_item_code <>  $a_item_code) {
      $field_count += 1;
      echo "Item Code before: $b_item_code -> ";  
      echo "after : $a_item_code <br>";
     }
     
     if ($b_lot_ship <>  $a_lot_ship) {
      $field_count += 1;
      echo "lot_ship before: $b_lot_ship -> ";  
      echo "after : $a_lot_ship <br>";
     }   
     
     if ($b_warehouse <>  $a_warehouse) {
      $field_count += 1;
      echo "warehouse before: $b_warehouse -> ";  
      echo "after : $a_warehouse <br>";
     }  
   
     if ($b_item_description <> $a_item_description) {
      $field_count += 1;
      echo "item description before: $b_item_description -> ";  
      echo "after : $a_item_description <br>";
    }    
    
     if ($b_non_member_price <> $a_non_member_price) {
      $field_count += 1;
      echo "non_member_price before: $b_non_member_price -> ";  
      echo "after : $a_non_member_price <br>";
    }    
    
     if ($b_mark <> $a_mark) {
      $field_count += 1;
      echo "mark before: $b_mark -> ";  
      echo "after : $a_mark <br>";
    }     
    
     if ($b_warehouse_code <> $a_warehouse_code) {
      $field_count += 1;
      echo "warehouse_code before: $b_warehouse_code -> ";  
      echo "after : $a_warehouse_code <br>";
    }       
 
     if ($b_cost <> $a_cost) {
      $field_count += 1;
      echo "cost before: $b_cost -> ";  
      echo "after : $a_cost <br>";
    }    
    
     if ($b_quantity <> $a_quantity) {
      $field_count += 1;
      echo "quantity before: $b_quantity -> ";  
      echo "after : $a_quantity <br>";
    }    
    
    
     if ($b_bag_lbs <> $a_bag_lbs) {
      $field_count += 1;
      echo "bag_lbs before: $b_bag_lbs -> ";  
      echo "after : $a_bag_lbs <br>";
    }        

     if ($b_STATUS <> $a_STATUS) {
      $field_count += 1;
      echo "STATUS before: $b_STATUS -> ";  
      echo "after : $a_STATUS <br>";
    }  
    
     if ($b_ship_date <> $a_ship_date) {
      $field_count += 1;
      echo "ship_date before: $b_ship_date -> ";  
      echo "after : $a_ship_date <br>";
    }           
     
     
     if ($b_arrival_date <> $a_arrival_date) {
      $field_count += 1;
      echo "arrival_date before: $b_arrival_date -> ";  
      echo "after : $a_arrival_date <br>";
    }   
    
     if ($b_ft_item <> $a_ft_item) {
      $field_count += 1;
      echo "ft_item was ";  
      if ($b_ft_item == 1) 
         echo " Changed to No";
      else
         echo " Changed to Yes "; 
    }     
    
     if ($b_org_item <> $a_org_item) {
      $field_count += 1;
      echo "<br>org_item was ";  
      if ($b_org_item == 1) 
         echo " Changed to No";
      else
         echo " Changed to Yes ";     
      
      
    }   
    
     if ($b_item_active <> $a_item_active) {
      $field_count += 1;
      echo "<br>item_active was "; 
      if ($b_item_active == 1) 
         echo " Changed to No";
      else
         echo " Changed to Yes ";
     # echo "item_active before: $b_item_active -> ";  
      #echo "after : $a_item_active <br>";
    }               

     if ($b_green_cb <> $a_green_cb) {
      $field_count += 1;
      echo "<br>Green Check box  "; 
      if ($b_green_cb == 1) 
          echo  " Changed to No ";
      else
          echo "  Changed to Yes ";
    #  echo "green_cb before: $b_green_cb -> ";  
     # echo "after : $a_green_cb <br>";
    }

     if ($b_spot_available <> $a_spot_available) {
      $field_count += 1;
      echo "spot_available before: $b_spot_available -> ";  
      echo "after : $a_spot_available <br>";
    }
    
     if ($b_contract_date <> $a_contract_date) {
      $field_count += 1;
      echo "contract_date before: $b_contract_date -> ";  
      echo "after : $a_contract_date <br>";
    }
    
     if ($b_sample_shipped <> $a_sample_shipped) {
      $field_count += 1;
      echo "sample_shipped before: $b_sample_shipped -> ";  
      echo "after : $a_sample_shipped <br>";
    }    
    
     if ($b_sample_approved <> $a_sample_approved) {
      $field_count += 1;
      echo "sample_approved before: $b_sample_approved -> ";  
      echo "after : $a_sample_approved <br>";
    }  
    
     if ($b_container <> $a_container) {
      $field_count += 1;
      echo "container before: $b_container -> ";  
      echo "after : $a_container <br>";
    }  
    
      if ($b_document <> $a_document) {
      echo "document before: $b_document -> ";  
      echo "after : $a_document <br>";
    }   
    
      if ($b_fda_confirm <> $a_fda_confirm) {
      $field_count += 1;
      echo "fda_confirm before: $b_fda_confirm -> ";  
      echo "after : $a_fda_confirm <br>";
    }  
    
      if ($b_fda_date <> $a_fda_date) {
      $field_count += 1;
      echo "fda_date before: $b_fda_date -> ";  
      echo "after : $a_fda_date <br>";
    }  
    
      if ($b_customs_clear_date <> $a_customs_clear_date) {
      $field_count += 1;
      echo "customs_clear_date before: $b_customs_clear_date -> ";  
      echo "after : $a_customs_clear_date <br>";
    }             

      if ($b_fixed_date <> $a_fixed_date) {
      $field_count += 1;
      echo "fixed_date before: $b_fixed_date -> ";  
      echo "after : $a_fixed_date <br>";
    }  
 
      if ($b_nyc <> $a_nyc) {
      $field_count += 1;
      echo "NYC before: $b_nyc -> ";  
      echo "after : $a_nyc <br>";
    }  
 
    
      if ($b_fixed_price <> $a_fixed_price) {
      $field_count += 1;
      echo "fixed_price before: $b_fixed_price -> ";  
      echo "after : $a_fixed_price <br>";
    } 
    
      if ($b_prefinance <> $a_prefinance) {
      $field_count += 1;
      echo "Prefinace before: $b_prefinance -> ";  
      echo "after : $a_prefinance <br>";
    }   
    
      if ($b_prefinance_amount <> $a_prefinance_amount) {
      $field_count += 1;
      echo "Prefinace before: $b_prefinance_amount -> ";  
      echo "after : $a_prefinance_amount <br>";
    }   
    
      if ($b_flo_id <> $a_flo_id) {
      $field_count += 1;
      echo "flo_id before: $b_flo_id -> ";  
      echo "after : $a_flo_id <br>";
    }                               
  
      if ($field_count == 0) {
      	  echo "nothing was changed";
      }
      
      $field_count = 0;
  
  
        echo '</td>';
      echo '<tr>';  
     
    $row3 = mysql_fetch_array($result3);        
 }           
            ?>
            
             
          </td>
        </tr>
      </table>
      
      <!--
    </td>
  </tr>
</table>

-->
</body>

</html>
