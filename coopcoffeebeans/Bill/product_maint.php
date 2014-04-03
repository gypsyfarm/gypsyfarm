<?php
require("../functions.php");
require("../tables.php");

session_start();



require("../check_login.php");
require("../phpclasses.php");
 
function set_last_maint($action = "x",$key = 0,$user_name = "y") {
	global $tbl_coop_item_last_maint;
	global $db_conn;
   $current_date =  date("m/d/y") ;
 
   if ($action == 'Update') {
     $query = "insert into $tbl_coop_item_last_maint
                           (item_id, updated_by, action, maint_date)
                     values ($key, '$user_name', '$action', CURDATE())";
					
					
    }
    
       if ($action == 'Add') {           
           $query = "insert into $tbl_coop_item_last_maint
                           (item_id, updated_by, action, maint_date)
                     values ($key, '$user_name', '$action', CURDATE())";
		    $LastMaintInfo=new UpdateLastMaint($key,"add");
    }
     # echo "<br>$query<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result){
       echo "<font size=2>Add Failed";
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
 
    function saveRec() {

     if ( confirm("Are you Sure you want to change this record?")) {
         document.frmMain.action_type.value = "Update";
         document.frmMain.submit();
    }
     else {
       document.frmMain.submit();
     }
}


    function delRec() {

     if ( confirm("Are you Sure you want to Delete this record?")) {
         document.frmMain.action_type.value = "Delete";
         document.frmMain.submit();
    }

}

 


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

 
 
 
 
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
 
$form_message = '';
# set up connection string to database.

/*
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

 */
$current_item_id=  stripslashes($_GET['item_id']);




  $action=$_REQUEST['form_action'];
  $action_type = $_REQUEST['action_type'];
   
   if ($action_type == "Update") {
   	$action = $action_type;
   }
   
   
      if ($action_type == "Delete") {
   //	echo "ok we have delete";
   	/*
   	SELECT count(*) as sold_count FROM order_header oh, order_item oi, coop_contact cc, lot_item li WHERE oh.header_id = oi.header_key AND oh.customer_key = cc.contact_id AND oi.item_id = li.item_id AND oi.item_code =  'COC' AND lot_ship =  '31
   	*/
   	
       $item_code=$_REQUEST[item_code];
       $lot_ship=$_REQUEST[lot_ship];

          
       $query = " SELECT count(*) as sold_count 
                  FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li 
                  WHERE oh.header_id = oi.header_key 
                    AND oh.customer_key = cc.contact_id 
                    AND oi.item_id = li.item_id 
                    AND oi.item_code =  '$item_code' AND lot_ship =  $current_item_id; ";  	
 
        //echo "<br>$query<br>";
        $result = mysql_query($query, $db_conn);
        $num_results = mysql_num_rows($result);
        $row = mysql_fetch_array($result);  	
        if ($row['sold_count'] > 0 ) {        	
              echo '<br> You can not delete this item code because it has  '.$row['sold_count'].' product sold records in the database.';      
        }   else {
      	      echo "Lot has been removed.";
      	     $query = "Delete from $tbl_coop_item  where item_id = $current_item_id ";
              $result = mysql_query($query, $db_conn);
              echo "<br> <br>";
             exit("<a href='product_start.php'>Return to Product Search Page</a>");
             
      	    }
   	
   }
  

   if ($action == "Update" || $action == "Add") {
	 $item_id=$_REQUEST[item_id];
     $item_code=$_REQUEST[item_code];
     $lot_ship=$_REQUEST[lot_ship];
     $warehouse=$_REQUEST[warehouse];
     $item_description=$_REQUEST[item_description];
     $member_price=$_REQUEST[member_price];
     $non_member_price=$_REQUEST[non_member_price];
     $mark=$_REQUEST[Mark];
     $warehouse_code=$_REQUEST[warehouse_code];
     $cost=$_REQUEST[cost];
     $quantity=$_REQUEST[quantity];
     $bag_lbs=$_REQUEST[bag_lbs];
     $status=$_REQUEST[status];
     $ship_date=$_REQUEST[ship_date];
     $arrival_date=$_REQUEST[arrival_date];
     $item_notes=$_REQUEST[item_notes];
     $spot_available=$_REQUEST[spot_available];
     $green_comment=$_REQUEST[green_comment];
     $scribd_id = $_REQUEST[scribd_id];
     $guid = $_REQUEST[guid];
     
    if ($_REQUEST[green_cb] == "on" )
       $green_cb = 1;
    else
       $green_cb = 0; 
     
    if ($_REQUEST[item_active] == "on" )
       $item_active = 1;
    else
       $item_active = 0;
       
    if ($_REQUEST[ft_item] == "on" )
       $ft_item = 1;
    else
       $ft_item = 0;       
       
    if ($_REQUEST[org_item] == "on" )
       $org_item = 1;
    else
       $org_item = 0;        
  
    $contract_date=$_REQUEST[contract_date];  
    $sample_shipped=$_REQUEST[sample_shipped];          
    $sample_approved=$_REQUEST[sample_approved];        
    $container=$_REQUEST[container];   
    $document=$_REQUEST[document]; 
    $fda_confirm=$_REQUEST[fda_confirm]; 
    $fda_date=$_REQUEST[fda_date]; 
    $customs_clear_date=$_REQUEST[customs_clear_date];
    $fixed_date=$_REQUEST[fixed_date]; 
    $fixed_price=$_REQUEST[fixed_price]; 
    $nyc=$_REQUEST[nyc];
    $prefinance=$_REQUEST[prefinance];
    $prefinance_amount=$_REQUEST[prefinance_amount];
    $flo_id=$_REQUEST[flo_id];

  }
  
  
   if ($action == "Add")

  {
 
    $query = "insert into $tbl_coop_item
              ( item_id, item_code, lot_ship, warehouse, item_description,
                member_price, non_member_price, mark, warehouse_code,
                cost, quantity,   status, ship_date, arrival_date,
                ft_item, org_item, item_notes, item_active, green_cb, spot_available, green_comment,
                contract_date, sample_shipped, sample_approved, container, document,
                fda_confirm, fda_date, customs_clear_date, fixed_date, fixed_price, nyc, prefinance, prefinance_amount, flo_id, scribd_id, guid)
              values ( NULL,'$item_code',
                  '$lot_ship','$warehouse','$item_description',
               '$member_price','$non_member_price','$mark',
               '$warehouse_code','$cost','$quantity',
               '$status','$ship_date','$arrival_date','$ft_item',
               '$org_item','$item_notes','$item_active','$green_cb','$spot_available','$green_comment',
               '$contract_date','$sample_shipped','$sample_approved','$container','$document',
               '$fda_confirm','$fda_date','$customs_clear_date','$fixed_date','$fixed_price','$nyc','$prefinance','$prefinance_amount', '$flo_id', '$scribd_id','$guid')";

    #   echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result) {
       $form_message = "<font size=2>Add Failed";
      }
     else {
        $current_item_id = mysql_insert_id();
         $item_id = $current_item_id;
        $form_message = "<font size=2>Record Added";
        set_last_maint($action,$current_item_id,$_SESSION['valid_user']);
      }
		

   }
   
   
   
     if ($action == "Update")
  {
  #   echo "name=".$Type."<br>";
  
 #     $query = "update $tbl_coop_item set item_code = '".$item_code."',".
  #             "  lot_ship = '".$lot_ship."',".
    $LastMaintInfo=new UpdateLastMaint($item_id,"update");  
    $LastMaintInfo->GetBefore($item_id);
    $query = "update $tbl_coop_item set ".
               "  warehouse = '".$warehouse."',".
               "  item_description = '".$item_description."',".
               "  member_price = '".$member_price."',".
               "  non_member_price = '".$non_member_price."',".
               "  mark = '".$mark."',".
               "  warehouse_code = '".$warehouse_code."',".
               "  cost = '".$cost."',".
               "  quantity = '".$quantity."',".
               "  status = '".$status."',".
               "  ship_date = '".$ship_date."',".
               "  arrival_date = '".$arrival_date."',".
               "  ft_item = '".$ft_item."',".
               "  org_item = '".$org_item."',".
               "  item_notes = '".$item_notes."',".
               "  green_cb = '".$green_cb."',".
               "  spot_available = '".$spot_available."',".  
               "  green_comment = '".$green_comment."',".  
               "  contract_date = '".$contract_date."',". 
               "  sample_shipped = '".$sample_shipped."',". 
               "  sample_approved = '".$sample_approved."',".  
               "  container = '".$container."',". 
               "  document = '".$document."',". 
               "  fda_confirm = '".$fda_confirm."',".  
               "  fda_date = '".$fda_date."',". 
               "  customs_clear_date = '".$customs_clear_date."',".  
               "  fixed_date = '".$fixed_date."',".  
               "  fixed_price = '".$fixed_price."',".
	       "  nyc = '".$nyc."',".   
	       "  prefinance = '".$prefinance."',".   
               "  prefinance_amount = '".$prefinance_amount."',".   
               "  scribd_id  = '".$scribd_id."',".
               "  guid = '".$guid."',".
               "  flo_id = '".$flo_id."',".  
               "  item_active = '".$item_active."' where item_id =".$item_id;
               
  #  echo "<br>$query<br>";          

     $result = mysql_query($query, $db_conn);
     if (!$result)
        $form_message = "<font size=2><br>Record was not updated";
     else
        $form_message = "<font size=2><br>Record has been Updated";
        
      # here we are no longer doing the update function, only the add function.  
      #  set_last_maint($action,$item_id,$_SESSION['valid_user']);
        $LastMaintInfo->GetAfter($item_id,$_SESSION['valid_user']);
        

  }  
  
  # Ok now do cupping notes:
  
if ($action == "Update" || $action == "Add") {
     	
  	#check if need to add or update cupping notes:
    mysql_select_db($tbl_cupping_info);

    $query = "select count(*) as nbr_recs   
          from $tbl_cupping_info
          where lot_key = $current_item_id and rec_type = '0'; ";

    // echo "<br>$query<br>";
    $checkCnt = mysql_query($query, $db_conn);
    $Checkrow = mysql_fetch_array($checkCnt);
    
    $fragrance = $_REQUEST[fragrance];
    $aroma = $_REQUEST[aroma];
    $acidity = $_REQUEST[acidity];
    $body = $_REQUEST[body];
    $flavor = $_REQUEST[flavor];
    $aftertaste = $_REQUEST[aftertaste];
    $moisture = $_REQUEST[moisture];
    $density = $_REQUEST[density];
    $color = $_REQUEST[color];
    $screen = $_REQUEST[screen];
    $cupping_notes = $_REQUEST[cupping_notes];
    $roast_profile = $_REQUEST[roast_profile];
    $roast_behavior = $_REQUEST[roast_behavior];
    $appearance_defects = $_REQUEST[appearance_defects];

    
    
    if ($Checkrow['nbr_recs'] > 0 ) {
	      $cupping_action = "Update";
	      
	      $query = "update $tbl_cupping_info set ".
               "  fragrance = '".$fragrance."',".
               "  aroma = '".$aroma."',".
               "  acidity = '".$acidity."',".
               "  body = '".$body."',".
               "  flavor = '".$flavor."',".
               "  aftertaste = '".$aftertaste."',".
               "  moisture = '".$moisture."',".
               "  density = '".$density."',".
               "  color = '".$color."',".
               "  screen = '".$screen."',".
               "  roast_profile = '".$roast_profile."',".
               "  roast_behavior = '".$roast_behavior."',".
               "  appearance_defects = '".$appearance_defects."',".
               "  cupping_notes = '".$cupping_notes."' ".
 
               "  where lot_key =".$current_item_id ." and rec_type = 0 ";
               
   #  echo "<br>$query<br>";          

     $result = mysql_query($query, $db_conn);
     if (!$result)
        $form_message = "<font size=2><br>Cupping Info was not updated";
    }
    else {
    	$current_date =  date("m/d/y") ;
       	$cupping_action = "Add";
       	$query = "insert into $tbl_cupping_info
              ( seq, rec_type, lot_key, fragrance, aroma,
                acidity, body, flavor, aftertaste,
                moisture, density, color, screen, cupping_notes, roast_profile, 
                roast_behavior, appearance_defects, last_maint)
              values ( NULL, 0, $current_item_id, '$fragrance','$aroma',
                      '$acidity','$body','$flavor','$aftertaste',
                      '$moisture','$density','$color', '$screen','$cupping_notes', '$roast_profile', 
                      '$roast_behavior', '$appearance_defects', '$current_date')";
               
       # echo "<br>$query <br>";         
               
      $result = mysql_query($query, $db_conn);
      if (!$result) {
       $form_message = "<font size=2>Cupping Info Add Failed";
      }       

	  }
}
  
    
   

 echo '<form name=frmMain method=post action="product_maint.php?item_id='.$current_item_id.'">';
 
# echo "<br> current item is '$current_item_id' <br>";

 if ($current_item_id == '0')
	{
	echo '<h1 align=left><INPUT TYPE="SUBMIT" name="form_action" value="Add"></h1>';
	}
 else {
     echo "<table  width=100%><tr><td width=20% align=left>";
     echo ' <button type=button id=btnSave name=btnSave btnAccessKey="u"';
     echo '    onclick="return saveRec();"> ';
     echo '   	<u>U</u>pdate';
     echo ' </button> '.$form_message; 
     echo "</td>";
     echo '<td align=center>';
     echo "<font color=red size=4> *</font>"; 
     echo "Indicates fields that are used for reporting";
     echo '</td>';
     echo "<td width=20% align=right>";
     echo ' <button type=button id=btnDelete name=btnDelete btnAccessKey="d"';
     echo '    onclick="return delRec();"> ';
     echo '   	<u>D</u>elete';
     echo ' </button> ';      
     echo "</td></tr></table>";

    }
 
# echo '&nbsp;&nbsp;&nbsp;'.$form_message;
 
 //**********************************Gets the DataSet************************************
mysql_select_db($tbl_coop_item);


 

$query = "select ci.item_id, ci.item_code, ci.lot_ship, ci.warehouse,
          ci.item_description, id.item_description as generic_description, ci.member_price, ci.non_member_price,
          ci.mark, ci.warehouse_code, ci.cost, ci.quantity, ci.transfer_in, ci.transfer_out,
          id.weight as bag_lbs,ci.green_cb, ci.spot_available, ci.green_comment,
          ci.STATUS, ci.ship_date, ci.arrival_date, ci.ft_item, ci.org_item,
          ci.contract_date, ci.sample_shipped, ci.sample_approved, ci.container,
          ci.document, ci.fda_confirm, ci.fda_date, ci.customs_clear_date,
          ci.item_notes, ci.item_active, id.rank, ci.fixed_date, ci.fixed_price, ci.nyc, ci.prefinance, ci.prefinance_amount, 
          ci.flo_id, ci.scribd_id, ci.guid,
          c.fragrance, c.aroma, c.acidity, c.body, c.flavor, 
          c.aftertaste, c.moisture, c.density, c.color, c.screen, c.cupping_notes, c.roast_profile,
          c.roast_behavior, c.appearance_defects 
          from $tbl_item_description id,  $tbl_coop_item ci
          LEFT JOIN cupping_info c ON c.rec_type = 0 and c.lot_key = ci.item_id 
          where ci.item_id = $current_item_id
             and ci.item_code = id.item_code ";

#echo "<br>$query<br>";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);


# start
$key_to_use = $row['item_id'];
$query2 = "SELECT max( seq ) as seq FROM $tbl_coop_item_last_maint2 WHERE item_id =  '$key_to_use'";
$result2 = mysql_query($query2, $db_conn);




 
$row2 = mysql_fetch_array($result2);
$record_to_get = $row2['seq'];
$query2 = "SELECT *  FROM $tbl_coop_item_last_maint2 WHERE seq =  '$record_to_get'";
$result2 = mysql_query($query2, $db_conn);
  
$row2 = mysql_fetch_array($result2);
echo 'Last Maint by: '.$row2['updated_by'].' &nbsp;&nbsp;&nbsp;';
echo 'Date: '.$row2['maint_date'].' &nbsp;&nbsp;&nbsp;';
echo 'Type: '.$row2['action'].' &nbsp;&nbsp;&nbsp;';

echo '<a href="javascript:poptastic(\'last_maint_detail.php?key_to_use='.$key_to_use.'\');"><font face="Verdana" size="1" color="#000000">Last Maint Detail</font></a>';
 
#end 



 
 echo '<input type=hidden name=action_type size=10 value="transfer">';
echo '<input  type="hidden" name="r_action" value="';
if  ($num_results == 0)	{
    echo 'Add';
}
else {
    echo 'Update';
}
echo  '">';

 
 
  
 require("product_fields.php");
  
  
 
 
   echo "<a href='cupping_maint.php?item_id=$current_item_id'>Add Cupping Notes </a>";
  
   
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
