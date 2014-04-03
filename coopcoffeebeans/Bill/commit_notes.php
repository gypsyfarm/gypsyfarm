<?php

require("../tables.php");
require("../functions.php");
// check security
 session_start();
// check session variable

  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
  }

	echo'<html>';
	echo'<head>';
  	echo'<title>Commitment Notes Screen</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=palegreen>';
 

//The command below tells if magic quotes is on or off a returned value of 1 means on a 0 means off
//if magic quotes is on, all characters that need escaping post variables automatically get escaped.
//The trick is to strip slashes after the post variable is assigned to a regular variable
//ideally this would be done dynamically but for now

//echo get_magic_quotes_gpc();


 
$record=$_GET['record'];
$Notes = $_REQUEST['Notes'];
 
//echo'The company name is '.$company;
 $current_date = date('Y-m-d H:i:s');
$userid = $_SESSION['valid_user']; 


# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }



      echo '<form method=POST action=commit_notes.php>';
  
   
      echo '<font color=blue><center><h3>Press update key to update notes:<br></font></center></h3>';
      echo '<table width=100%><tr><td align=left>';
      echo '<input type="SUBMIT" name="ACTION" value="Update">';
      echo '</td><td align=right>';
      echo '<INPUT type="button" value="Close Window" onClick="window.close()">';
      echo '</td></tr></table>'; 	  


	
	
 #  echo "<br>".$_REQUEST['ACTION']."<br>";
 
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db($tbl_coop_contact);
 
if (($_REQUEST['ACTION'] == 'Update')){
  $record=$_REQUEST['record'];
  $query = "update $tbl_coop_commited set Notes =  '$Notes', notes_date = '$current_date', notes_operator = '$userid' where commited_id = '$record'";
  
 echo "<br>$query<br>";
  $result = mysql_query($query, $db_conn);
       if (!$result)
        echo "<br><font size=2>Update Failed";
    
}

 

echo "<input type=hidden name='record' id='record' value='$record'>";
 

mysql_select_db($tbl_coop_contact);

#  $company=addslashes($company);
$query = "select * from $tbl_coop_commited where commited_id = $record";


$result = mysql_query($query, $db_conn);

  echo "<br>$query <br>";
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);

$customer_notes=$row['Notes'];


# echo "<br> $customer_notes <br>";

    echo '<textarea name="Notes" type="text" width=350 maxlength="255" id="Notes" style="height:50px;width:350px;">'.$customer_notes.'</textarea>';



echo '</form>';

?>