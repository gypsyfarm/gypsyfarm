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

  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

 
if ($quicksearch != "no") {
	
   $query = "select * FROM $tbl_item_description   WHERE item_code like '$quicksearch%' order by category, rank";

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
  

   
    
 
  
    
   $query = "select * from $tbl_item_description  ".$search_string.' order by category, rank';
}   	 
 
 
 # echo "<br> $query <br>";
 #echo "now setting sesson vars <br>";
 # $_SESSION['contact_id_search'] = $query;
 #echo "and thus = ".$_SESSION['contact_id_search'];
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 )
  {
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $num_results = mysql_num_rows($result);
    echo 'number of records is '.$num_results.'<br>';
  #   echo 'one field is '.$row['Company'].'<br>';

      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
 
         echo '<tr>';

        echo '<td>Item Code</td>';
 
        echo '<td>Item Description</td>';
        echo '<td>Rank </td>'; 
        echo '<td>Category </td>';                 
        echo '</tr>';
 
 
 for ($i=0; $i <$num_results;  $i++) {

        
                   
        echo '<tr>';

        echo '<td><a href="product_desc_maint.php?item_code=';
        echo $row['item_code'];
        echo '">'.$row['item_code'].'  </a></td>';
        echo '<td>'.$row['item_description'].'</td>';
        echo '<td>'.$row['rank'].'</td>'; 
        echo '<td>';

        
        switch ($row['category']) {
           case 1:
              echo "Regular";
              break;
           case 2:
              echo "Decaffeinated";
              break;
           case 3:
              echo "Special Orders";
              break;
           default:  
              echo "N/A";
           }
        
        
        
        echo '</td>';                 
        echo '</tr>';

   $row = mysql_fetch_array($result);
}   
   
   echo '</table>';




# end   if (mysql_num_rows($result) >0 )
  }







         
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
