<?php
//********************************************************************************
//********************* Display announcement for Cooperative Coffees ************************
//********************************************************************************

if (isset($_POST['userid']) && isset($_POST['password'])) {
  // if the user has just tried to log in
  $userid = $_POST['userid'];
  $password = $_POST['password'];
  $debug .= "in log in section";

  $db_conn2 = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn2);

 $query = "select a.cust_id as contact_id, cc.company, cc.name, a.user_type, a.name as userid
 		   FROM  auth a,  coop_contact cc
           WHERE a.name='$userid'
		   AND a.cust_id=cc.contact_id
           AND a.pass= old_password('$password')";

 # $ReadMe = $ReadMe + "<br>" + $query;
  $result = mysql_query($query, $db_conn2);
  if (mysql_num_rows($result) >0 ) {
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $_SESSION['valid_user'] = $row['company'];
    $_SESSION['contact_id'] = $row['contact_id'];
    $_SESSION['auth_contact_id'] = $row['contact_id'];
    $_SESSION['user_type'] = $row['user_type'];
    $_SESSION['userid'] = $row['userid'];
    
    if ($row['user_type'] == "1") {
    	
    	$db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
        mysql_select_db('cbeans', $db_conn);

        if (!$db_conn) {
             echo 'Error: Could not connect to coffeepathdata database.  Please try again later.';
             exit;
        }
        
        $query = "select ft_id, coop_id 
                    from trf_roaster_content
                    where coop_id = '".$row['contact_id']."'";
                    
                 #   $ReadMe = $ReadMe + "<br>" + $query;
                    
        $result2 = mysql_query($query, $db_conn);
        if (mysql_num_rows($result2) >0 ) {
            $row2 = mysql_fetch_array($result2);
            $_SESSION['rst_id'] = $row2['ft_id'];
        	
        }
                  
    	
    }


  }
  
}  

?>