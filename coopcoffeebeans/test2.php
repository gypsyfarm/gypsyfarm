<?php


 

echo "<html>";

echo "<head>";
echo "<title>Cooperative Coffees - Order and Contact Database system</title>";

echo '<link REL="stylesheet" TYPE="text/css" HREF="general.css">';

echo "</head>";

 
echo '<body bgcolor="#FFFFFF" text="#228B22" link="#008000" vlink="#006400 alink="#00FF00" background="../two_lines.gifs">';

  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn) or die("opps did not work");
 
 
 $query = "select cn.*, (select a.name from auth a where a.cust_id = cn.assigned_to) as auth_name, cc.First_Name, cc.Last_Name, cc.Company, cc.Phone 
            FROM contact_notes cn, contact_contact cc   
           WHERE  cn.assigned_to = '$contact_id' 
             and cn.contact_id = cc.contact_id 
             and cn.completed = '0' 
           order by seq desc";
 
  echo "<br>$query <br>";
  
  $note_count = 0;
$result = mysql_query($query, $db_conn);
  
if (mysql_num_rows($result) >0 )   
{
    $num_results = mysql_num_rows($result);
    $note_count = $num_results;
    $message_message =  ' You have have '.$num_results.' note, call or task records<br>';
    echo $message_message.'</font><font size=2>';
}

echo "</body>";

echo  "</html>";

?>