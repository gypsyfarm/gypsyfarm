<?php


session_start();
require("../functions.php");
require("../tables.php");


// check security
// check session variable

  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
	$valid_user = $_SESSION['valid_user'];
  }
  else
  {
  header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
  }

       echo "\n";
  $alt_contact_id = $_REQUEST['Company_Name'];

    echo '<form method="post" action="alt_adminpw.php">';
   echo '<input type=hidden name="Company_Name" Id="Company_Name" value="'.$alt_contact_id.'" >';
      echo "\n";
	$db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  	mysql_select_db('cbeans', $db_conn);

 	$query ="select a.name as pwname, a.pass, a.cust_id as contact_id, cc.company, cc.name, a.user_type
	       FROM $tbl_auth a, $tbl_coop_contact cc
           WHERE a.cust_id = cc.contact_id
		   AND a.cust_id=$alt_contact_id";

 	echo '<font size=3><a href="../index.php">Back to the main Menu</a></font><br>';
   echo '<font size=3><a href="../logout.php">Log Out</a></font><br><br> ';





// provide form to log in
if (!isset($_REQUEST['button']))
{
	//logo();


  $result = mysql_query($query, $db_conn);
  $row = mysql_fetch_array($result);

	echo "<br><center><h1 >Password Update</h1></center><br>";
   $contact_name = $row['company'];
    echo "<font size=4 color=black>You are about to change the login password for $contact_name </font>";

    echo '<table>';

	echo '<tr><td colspan=2>Contact Name is : '.$row['name'].'</td></tr>';

    echo '<tr><td>sign on Name:</td>';
    echo '<td><input  name="pwname" disabled value="'.$row['pwname'].'"></td></tr>';
    echo '<tr><td>User Type:</td>';

   echo '<td>';
   echo '<select name="User Type"  disabled >';
   echo '<br><option value="">';
   echo "\n";
   echo '<option value="1"  ';
      if ($row['user_type'] == 1)
      {
         echo ' selected ';
      }
      echo ' >Customer';
      echo "\n";

      echo '<option value="2"  ';
      if ($row['user_type'] == 2)
      {
         echo ' selected ';
      }
      echo ' >Bill';
      echo "\n";

      echo '<option value="3"  ';
      if ($row['user_type'] == 3)
      {
         echo ' selected ';
      }
      echo ' >Bank';

      echo "\n";
      echo '<option value="4"  ';
      if ($row['user_type'] == 4)
      {
         echo ' selected ';
      }
      echo ' >Warehouse';
      echo "\n";

      echo "</select>";
    echo '</td></tr>';
    echo '<tr><td colspan=2><br></td></tr>';

    echo '<tr><td>Enter New Password:</td>';
    echo '<td><input type="password" name="New_Password:"></td></tr>';

    echo '<tr><td>Confirm New Password:</td>';
    echo '<td><input type="password" name="Confirm_Password:"></td></tr>';

    echo '<tr><td   align="center">';
    echo '<input type="submit" name="button" value="Save Password"> ';
       echo '</td><td align="center">';
	echo '<input type="submit" name="button" value="Cancel">';
	echo '</td></tr>';
    echo '</table>';
	}

	If ($_REQUEST['button'] == 'Save Password'){
	logo();
	echo "<br><center><h1 >Update Password</h1></center><br><br><br><br>";
	echo '<font size=3><a href="../index.php">Back to Main Menu</font><br>';

	echo '<font size=3><a href="../logout.php">Log out</a></font><br>';

	$New=$_REQUEST['New_Password:'];
	$Confirm=$_REQUEST['Confirm_Password:'];
	$password = $_REQUEST['current'];




 //If its right and the new matches the confirm and at least one of them is set then update the password

     if ( isset($Confirm) and isset($New) and ($New == $Confirm) ) {
          $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
          mysql_select_db('cbeans', $db_conn);
         $query = "UPDATE   $tbl_auth  SET   pass   = password(  '$New' ) WHERE cust_id  =  '$alt_contact_id'  LIMIT 1 ";

        $result = mysql_query($query, $db_conn);
         echo '<br><font size=4 color=Red>Your password has been changed. Please make a note of it,</font><br>';
         echo '<font size=4 color=Red>you will need it the next time you log in.</font>';
         }
     else {
          echo '<font size=3><a href="alt_adminpw.php">Back to Change Password</a></font><br>';
          echo '<br><br><font size=4 color=red>The new password and the confirmation do not match, you must have a typo!</font>';
        }


}

echo '</form>';
//They just canceled out of the page altogether
	If ($_REQUEST['button'] == 'Cancel'){
	header("Location: http://www.coopcoffeesbeans.com/demo/index.php");
	echo 'You have chosen cancel';
	}
?>


