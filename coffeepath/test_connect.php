<?php
//********************************************************************************
//********************* Display announcement for Cooperative Coffees ************************
//********************************************************************************


 
$db_conn = mysql_connect('ldb105.siteprotect.com', 'coffeepathdata', 'cafe725');

mysql_select_db('coffeepathdata', $db_conn);

if (!$db_conn)
{
    echo 'Error: Could not connect to coffeepathdata database.  Please try again later.';
    exit;
}

 



       # set up connection string to database.
  $db_conn2 = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');
  
  mysql_select_db('greenbeans', $db_conn2);

  if (!$db_conn2)
  {
     echo 'Error: Could not connect to greenbeans database.  Please try again later.';
     exit;
  }
  
 
echo "Ok so far";

phpinfo(); 


exit();

?>