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


</head>
<?

require("left_menu.php"); 

    echo '<td  valign="top">';
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
         #   echo '<u>C</u>ontent:</b></font></td>';  
             echo date('H:i, jS F');    
        echo '</b></font></td>'; 
        echo '</tr>';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
  #          echo '<p align="right">¤ ';
  #          echo date('H:i, jS F');
  #          echo '</p>';
 
 
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
 
    echo 'Orders Ready to Ship:';
    echo '<center>'; 

   # type 4 = Dupey
   $warehouse_code = '%';
    
  if ($_SESSION['user_type'] == 4) {
  	$warehouse_code = 'N';
  }  
  elseif ($_SESSION['user_type'] == 5) {
  	$warehouse_code = 'T';
  }  	
  elseif ($_SESSION['user_type'] == 7) {
  	$warehouse_code = 'J';
  }  
 
#
# create short variable names from from fields.
# -> did not work... $old_level = error_reporting(4);
  error_reporting (E_ALL ^ E_NOTICE);

 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

     mysql_select_db('order_header');

 $query = "SELECT oh.warehouse, cc.company, cc.name, oh.header_id, oh.order_nbr, oh.order_date, oh.status
           FROM $tbl_order_header oh, $tbl_coop_contact cc
           WHERE oh.customer_key = cc.contact_id
           AND ( oh.status = 'H' or oh.status = 'B' or oh.status = 'A')
           AND oh.warehouse like '$warehouse_code'
           ORDER  BY oh.customer_key, oh.header_id";
#  echo '<br>'.$query.'<br>';
 
  /*
  echo "warehouse code is  $warehouse_code <br>";
  echo 'user type is '.$_SESSION['user_type'].'<br>';
  echo 'valid user   '.$_SESSION['valid_user'].'<br>';
  echo 'contact id is '.$_SESSION['contact_id'].'<br>';
  echo ' auth contact id is '.$_SESSION['auth_contact_id'].'<br>';
  */
 	
   echo "<br>";
   $result = mysql_query($query, $db_conn);

   $row = mysql_fetch_array($result);
   $num_results = mysql_num_rows($result);
    echo '</center>';      
   
   echo "<TABLE cellSpacing=0 cellPadding=0  width=95% border=1>\n";
      echo "<tr><td width=30%>Company Name</td><td width=70%>Click on order number to view detail - orders in red have been shipped and waiting for bank approval.</td></tr>";
   for ($i=0; $i <$num_results; $i++)
   {

      if ($prev_account <>  $row['company']) {
         echo "<tr>\n<td>";
         echo "<p><font size=2 color=blue>  ".$row['company']."</font></td>\n<td>";
      }
      $prev_account = $row['company'];
      if ($row['status'] == 'H' ) {
      	         echo "&nbsp;&nbsp;&nbsp;<font size=2 color=red>".$row['header_id']."(".$row['order_date'].") </font>\n";

      }
      else {
         echo "&nbsp;&nbsp;&nbsp;<font size=2 color=blue><a href='whorder2.php?order_id=".$row['header_id']."&status=".$row['status']."'>".$row['header_id']."(".$row['order_date'].")</font></a>\n";
      }
      $row = mysql_fetch_array($result);

      if ($prev_account <>  $row['company']) {
       echo "</td> \n</tr>";
     }


  }
    echo '</table>';
    echo '<br>';
       
    echo '</td></tr></table>';    
  
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
