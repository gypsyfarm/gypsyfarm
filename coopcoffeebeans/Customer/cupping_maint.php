<?php
require("../functions.php");
require("../tables.php");

session_start();



require("../check_login.php");
require("../phpclasses.php");
 


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

     if ( confirm("Are you Sure you want to update this record?")) {
         document.frmMain.action_type.value = "Update";
        
         document.frmMain.submit();
    }
     else {
       document.frmMain.submit();
     }
}


</script>
 

<?
#require("../left_menu.php");  


    echo '<td  valign="top">';
 
 /*
    echo " valid_user =   ".$_SESSION['valid_user']." <br>\n";
    echo " contact_id = ".$_SESSION['contact_id']."   <br> \n";
    echo " auth_contact_id = ".$_SESSION['auth_contact_id']." <br> \n";
    echo " user_type = ".$_SESSION['user_type']."  <br> \n";
    echo "userid =  ".$_SESSION_['userid']."  <br> \n";
*/
  
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
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }


$current_item_id=  stripslashes($_REQUEST['item_id']);

$action=$_REQUEST['form_action'];
$action_type = $_REQUEST['action_type'];

 
#$action = $action_type;
 
# Ok now do cupping notes:

 
$contact_id = $_SESSION['contact_id']; 
  
if ($action == "Update" || $action == "Add") {
     	
  	#check if need to add or update cupping notes:
    mysql_select_db($tbl_cupping_info);



    $query = "select count(*) as nbr_recs   
          from $tbl_cupping_info
          where lot_key = $current_item_id and  rec_type = 2 and roaster = '$contact_id' ";

   # echo "<br>$query<br>";
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
 
               "  where lot_key =".$current_item_id ." and rec_type = 2 and roaster = $contact_id ";
               
     #   echo "<br>$query<br>";          

     $result = mysql_query($query, $db_conn);
     if (!$result)
        $form_message = "<font size=2><br>Cupping Info was not updated";
    }
    else {
       	$cupping_action = "Add";
       	$query = "insert into $tbl_cupping_info
              ( seq, rec_type,  lot_key, roaster,  fragrance, aroma,
                acidity, body, flavor, aftertaste,
                moisture, density, color, screen, cupping_notes, roast_profile, 
                roast_behavior, appearance_defects)
              values ( NULL, 2, $current_item_id, '$contact_id', '$fragrance','$aroma',
                      '$acidity','$body','$flavor','$aftertaste',
                      '$moisture','$density','$color', '$screen','$cupping_notes', '$roast_profile', 
                      '$roast_behavior', '$appearance_defects')";
               
      # echo "<br>$query <br>";         
               
      $result = mysql_query($query, $db_conn);
      if (!$result) {
       $form_message = "<font size=2>Cupping Info Add Failed";
      }       

	  }
}
  
    
   

 echo '<form name=frmMain method=post action="cupping_maint.php?item_id='.$current_item_id.'">';
 
#echo "<br> current item is '$current_item_id' <br>";

 echo "<table width='80%'><tr><td align='left'>";
 echo '<h1 align=left><INPUT TYPE="SUBMIT" name="form_action" value="Update"></h1>';
 echo "</td><td align='right'>";
 echo "<a href='product_maint.php?item_id=$current_item_id'>Return to Item </a>";
 echo "</td></tr></table>";
 
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
          LEFT JOIN cupping_info c ON c.rec_type = 2  and roaster = '$contact_id' and c.lot_key = ci.item_id 
          where ci.item_id = $current_item_id
             and ci.item_code = id.item_code ";

#echo "<br>$query<br>";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);


 

 
 echo '<input type=hidden name=action_type size=10 value="transfer">';
echo '<input  type="hidden" name="r_action" value="';
if  ($num_results == 0)	{
    echo 'Add';
}
else {
    echo 'Update';
}

echo  '">';


require("cupping_fields.php");
  
 
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
