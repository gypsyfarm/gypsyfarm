<html>
<head>
  <title>Contact Search Results</title>
  <META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>
 
 <TABLE cellSpacing=0 cellPadding=0 width="95%" border=0>
 
  <TR>
    <TD><IMG height=155 alt="Green Bean Co-op Logo"
      src="CoopContact_files/cclogo.jpeg" width=160> </TD>
    <TD><IMG height=50 src="CoopContact_files/spacer.gif" width=25> </TD>
    <TD><IMG src="CoopContact_files/title.gif"> </TD>
    <TD>&nbsp;</TD>

  </TR>    
  </table>
 
 
<h1>Cooperative Coffees Contact Search Results</h1>



<?php
  // create short variable names
  $searchtype=$_REQUEST['searchtype'];
  $searchterm=$_REQUEST['searchterm'];

  $searchterm= trim($searchterm);

  $searchtype = addslashes($searchtype);
  $searchterm = addslashes($searchterm);           
  
 
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }
  
  mysql_select_db('coop_contact');
  $query = "select * from coop_contact where ".$searchtype." like '%".$searchterm."%'";   
  
  
  
  if (!$searchtype || !$searchterm)
  {
      $query = "select * from coop_contact order by Company"; 
  }

  
# $query = 'SELECT * FROM coop_contact WHERE name LIKE \'%Jones%\' LIMIT 0, 30';     
 # $query = 'SELECT * FROM coop_contact;
  
    $result = mysql_query($query, $db_conn);

  $num_results = mysql_num_rows($result);

  echo $num_results;
  
  echo '<p>Number of Contacts found: '.$num_results.'</p>';
#   if not $num_results   {
#     echo 'No records found, sorry, try another search';
 #  }




  for ($i=0; $i <$num_results; $i++)
  {    
       echo 'row..';

     $row = mysql_fetch_array($result); 
 
     echo '<p><strong>'.($i+1).'. company: ';
         
#    echo htmlspecialchars(stripslashes($row['title']));
     echo  $row['Company'];    
     
     echo '</strong><br />Name: ';
     echo stripslashes($row['Name']);
       
     echo '<br />City: ';
     echo stripslashes($row['BillCity']);
     echo '<br />BillState: ';
     echo stripslashes($row['BillState']);
     echo '<br />Contact Type: ';
     echo stripslashes($row['Type']);
     echo '</p>';       
   
     
  }


 
?>

<CENTER>| <A href="http://www.coopcoffeesbeans.com/index.html"
target=_top>Home Page</A> |<BR>
<P></P>
 

</BODY>


</HTML>
