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
#require("../left_menu.php"); 

 
$current_item_id=  stripslashes($_GET['item_id']);

 echo '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
  echo '<tr>';
    echo '<td width="150" valign="top">';
      echo '<table border="1" width="140" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
      echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
        
        echo "<a href=\"javascript:poptastic('Help.php?x=47A$menu_user_type');\"><font face='Verdana' size='1' color='#FFFFFF'>help</font</a>";
        
        echo '</tr>';
        echo '<tr>';
          echo '<td width="600" bordercolor="#228B22" bgcolor="#FFFFFF">';
          
                     echo '<font face="Verdana" size="1">*<a href="../index.php">Back to Main Menu</a></font><br>';
           echo '<hr>';   	
	   echo '<font face="Verdana" size="1">*<a href="cooporder.php">Create a new Order</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="reports/index.php">View Reports</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Contact_Search/contact_start.php">Contact Database</a></font><br>';
	   echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="product_start.php">Lot Review</a></font><br>';
           echo '<hr>';
           
  	   echo '<font face="Verdana" size="1">*<a href="cupping_maint.php?item_id='.$current_item_id.'">Add Cupping Notes </a></font><br>';
           echo '<hr>';         
  
           
	   echo '<font face="Verdana" size="1">*<a href="password.php">Change Password</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../logout.php">Log out</a></font><br>';
	   
	           
            echo '</td>';
        echo '</tr>';
        
              echo '</table>';
    echo '</td>';


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
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }






  $action=$_REQUEST['form_action'];
  $action_type = $_REQUEST['action_type'];
   
 
   
  
   
   
 echo '<form name=frmMain method=post action="product_maint.php?item_id='.$current_item_id.'">';


 //**********************************Gets the DataSet************************************
mysql_select_db($tbl_coop_item);


$query = "select ci.item_id, ci.item_code, ci.lot_ship, ci.warehouse,
          ci.item_description, id.item_description as generic_description, ci.member_price, ci.non_member_price,
          ci.mark, ci.warehouse_code, ci.cost, ci.quantity, ci.transfer_in, ci.transfer_out,
          id.weight as bag_lbs,ci.green_cb, ci.spot_available, ci.green_comment,
          ci.STATUS, ci.ship_date, ci.arrival_date, ci.ft_item, ci.org_item,
          ci.contract_date, ci.sample_shipped, ci.sample_approved, ci.container,
          ci.document, ci.fda_confirm, ci.fda_date, ci.customs_clear_date,
          ci.item_notes, ci.item_active, id.rank, ci.fixed_date, ci.fixed_price, ci.nyc, ci.prefinance, ci.prefinance_amount, ci.flo_id, ci.scribd_id, ci.guid 
          from $tbl_coop_item ci, $tbl_item_description id
          where ci.item_id = $current_item_id
             and ci.item_code = id.item_code ";

 # echo "<br>$query<br>";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);


# start
$key_to_use = $row['item_id'];
$query2 = "SELECT max( seq ) as seq FROM $tbl_coop_item_last_maint WHERE item_id =  '$key_to_use'";
$result2 = mysql_query($query2, $db_conn);




 
$row2 = mysql_fetch_array($result2);
$record_to_get = $row2['seq'];
$query2 = "SELECT *  FROM $tbl_coop_item_last_maint WHERE seq =  '$record_to_get'";
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

 echo "<h1>Review</h1>";
 
  
 require("product_fields.php");
  
  
 
 
  
  
   
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
