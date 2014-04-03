<?
require("functions.php");
require("tables.php");
session_start();



require("check_login.php");



?>

<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="general.css">

</head>
 
<?
#require("left_menu.php");   

##echo "<br> submit = ".$HTTP_POST_VARS['SUBMIT']."<br>";

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
if (isset($HTTP_SESSION_VARS['contact_id']))  {
    $user_type = $HTTP_SESSION_VARS['user_type'];
 	
   $db_conn = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

 echo '<table border="1"  width="100%">';

  $query = "select * FROM $tbl_events  order by event_date";
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 ) {
      $row = mysql_fetch_array($result);
      $num_results = mysql_num_rows($result);	
     # echo '<br>';
       
      for ($i=0; $i <$num_results;  $i++) {
      	echo '<tr><td>';
      	echo '('.$row['seq'].') ';

      	echo ' </td><td> <font color=black>'.$row['event_date'].' </font></td><td> <font color=black>'.$row['event_time'].'</font></td><td>';
      	echo '<font color=black>'.$row['event_desc'].'</font></td><td>';
  	
      	echo '</td></tr>';
       $row = mysql_fetch_array($result);
      }	    
  	echo '</table>';
  }



         echo '</form';


  }        
     




 
        echo '<hr noshade size="1" color="#228B22">';
        echo '</td> </tr></table></td></tr></table></body></html>';
