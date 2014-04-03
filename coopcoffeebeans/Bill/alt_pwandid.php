<?php
// check security
#require("../header.php");
require("../check_login.php");

//********************************local functions *******************************
//**************************************************************************************
//***************************Customer Drop Down Menu************************************
//**************************************************************************************

function alt_customerdropdown($company = "")
	{


   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }


 //mysql_select_db('coop_contact');
  	echo  " \n ";
   global $tbl_coop_contact;
   $query = "SELECT * From $tbl_coop_contact  order by Company";

	$ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "too bad too sad"; }

	$ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   echo '<select name="Company_Name">';
   echo '<br><option value="">';
   echo "\n";
      for ($i=0; $i <$ddnum_results; $i++)
 {
      echo '<option value="'.$ddrow['contact_id'].'"  ';
      if ($company == $ddrow['Company'])
      {
         echo ' selected ';
      }
      echo ' >'.$ddrow['Company'];
      echo "\n";


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";

}


//
//******************************Get the Includes**********************************
require("../functions.php");
require("../tables.php");


	echo'<html>';

	echo'<head>';
  	echo'<title>Pw word Admin </title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
	echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';
 	echo '<font size=3><a href="../index.php">Back to the main Menu</a></font><br>';
  echo '<font size=3><a href="../logout.php">Log Out</a></font><br><br><br><br><br>';

// create short variable names
# this field will need to come from login screen.
  $company=$_SESSION['valid_user'];
  $current_id=$_REQUEST['current_id'];


# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

//***********************************************************************************
//								Take Care of Your Variables
//***********************************************************************************



$company=$_REQUEST['Company_Name'];


//***********************************************************************************
//							Start The Form
//***********************************************************************************

echo '<form method=POST action=alt_adminpw.php>';


	echo '<br>';
	echo '<font size=3 color=blue>Select a Company</font><br>';

//***************Build the Customer List (from functions)******************
    alt_customerdropdown();


echo '<br>';
//***************Display the Form Buttons for Selection*******************************
	  echo '<input type="SUBMIT" name="ACTION" value="Reset Password">';


echo '</form>';
?>