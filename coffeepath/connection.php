<?php
//********************************************************************************
//********************* Display announcement for Cooperative Coffees ************************
//********************************************************************************

$doc_trail = "Location: http://www.coopcoffeesbeans.com/coffeepath/transparent_document_trail.php";

$db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
#$db_conn = mysql_connect('ldb105.siteprotect.com', 'coffeepathdata', 'cafe725');
mysql_select_db('cbeans', $db_conn);

if (!$db_conn)
{
    echo 'Error: Could not connect to fair Trade database.  Please try again later.';
    exit;
}



       # set up connection string to database.
$db_conn2 = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
#$db_conn2 = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');
  mysql_select_db('cbeans', $db_conn2);

  if (!$db_conn2)
  {
     echo 'Error: Could not connect to greenbeans database.  Please try again later.';
     exit;
  }
  

?>