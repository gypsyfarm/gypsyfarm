<?php

require("sql_config.php");

/*
     echo "<br> $query <br>";
     echo '<pre>';
     print_r($_REQUEST);
     echo '</pre>'; 
     echo "<p>";
          echo '<pre>';
     print_r($_POST);
     echo '</pre>'; 
   

 echo phpinfo();

*/
if (isset($_REQUEST['userid']) && isset($_REQUEST['password']))
{
  // if the user has just tried to log in
  $userid = $_REQUEST['userid'];
  $password = $_REQUEST['password'];

 $query = "select a.cust_id as contact_id, cc.company, cc.name, a.user_type, a.name as userid
 		   FROM $tbl_auth a, $tbl_coop_contact cc
           WHERE a.name='$userid'
		   AND a.cust_id=cc.contact_id
           AND a.pass = old_password('$password')";
 # echo "<br> $query <br>";
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 )
  {
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $_SESSION['valid_user'] = $row['company'];
    $_SESSION['contact_id'] = $row['contact_id'];
    $_SESSION['auth_contact_id'] = $row['contact_id'];
    $_SESSION['user_type'] = $row['user_type'];
    $_SESSION_['userid'] = $row['userid'];
	  $userid = $row['userid'];
    
    /*
      echo "<br>Session vars<br>";
      echo '<pre>';
      print_r($_SESSION);
      echo '</pre>'; 
      */
  }
  
}  

 
 
?>