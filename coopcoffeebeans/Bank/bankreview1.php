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

$set_media = $_REQUEST['set_media'];
if (isset($set_media)) {
    if ($set_media == 'yes') {
       $_SESSION['include_media'] = 'y';
    }
    else {
       $_SESSION['include_media'] = 'n';	
    }
}	

    echo '<td  valign="top">';
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
         #   echo '<u>C</u>ontent:</b></font></td>';  
             echo date('H:i, jS F');    
        echo '</b></font></td>'; 
        echo '</tr>';
        echo "<tr>\n";
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
          echo "\n";

 
 
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
 
    echo 'Bank Order Review Page:';
    echo "<center>\n";
    echo '<form name="frmMain" action=bankreview1.php method=post>';

 
#
# create short variable names from from fields. 
# -> did not work... $old_level = error_reporting(4);
  error_reporting (E_ALL ^ E_NOTICE);

 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

     mysql_select_db('order_header');

$ts = time();
$form_nbr_days_past = 7; 
$nbr_days_past = $form_nbr_days_past * 24 * 60 * 7; 
# make today's date based on current timestamp 
$today = date( "Y-m-d", $ts ); 

 
# make last week's date based on a past timestamp  

echo "<br> ";
#echo   strtotime("+1 week"), "\n";
$time_value = $ts - $nbr_days_past;
#echo "nbr of days paste = $nbr_days_past and ts = $ts  and the diff is $time_value";
$time_value = $ts - (7 * $nbr_days_past);
#echo "<br>";

$past_date = date( "Y-m-d", ( $time_value ) );


 $query = "SELECT cc.company, cc.name, oh.header_id, oh.order_nbr, oh.order_date
           FROM $tbl_order_header oh, $tbl_coop_contact cc
           WHERE oh.customer_key = cc.contact_id
           AND ( oh.status = 'H' or oh.status = 'A')
           AND oh.order_date between '$past_date' and '$today'
           ORDER  BY oh.customer_key, oh.header_id";
           
#           AND oh.order_date between '$past_date' and '$today'           
#  echo '<br>'.$query.'<br>';
   echo "<br>\n";
   $result = mysql_query($query, $db_conn);

   $row = mysql_fetch_array($result);
   $num_results = mysql_num_rows($result);


   echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>\n";
   for ($i=0; $i <$num_results; $i++) 
   {

      if ($prev_account <>  $row['company']) {
         echo "<tr><td>";
         echo "<p><font size=2 color=blue>  ".$row['company']."</font></td>\n<td>";
      }
      $prev_account = $row['company'];

      echo "&nbsp;&nbsp;&nbsp;<font size=2 color=blue><a href='bankreview2.php?order_id=".$row['header_id']."'>".$row['header_id']."(".$row['order_date'].")</font></a>\n";
      $row = mysql_fetch_array($result);

      if ($prev_account <>  $row['company']) {
       echo "</td>\n</tr>";
     }


  }

    echo '</table>';
    echo '<br>';
       
    echo '</td></tr></table>';    
    echo '</center>';        
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
