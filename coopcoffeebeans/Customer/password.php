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
  header("Location: http://www.coopercoffeesbeans.com/badlogin.php");
  }

// provide form to log in
	if (!isset($_REQUEST['button']))
	{
	logo();
	echo "<br><center><h1 >Password Update</h1></center><br><br><br><br>";
    echo "<font size=4 color=black>You are about to change the login password for $valid_user</font>";
    echo '<form method="post" action="password.php">';
    echo '<table>';
    echo '<tr><td>Enter Current Password:</td>';
    echo '<td><input type="password" name="current"></td></tr>';
	echo '<tr><td><br></td></tr>';
    echo '<tr><td>Enter New Password:</td>';
    echo '<td><input type="password" name="New_Password:"></td></tr>';
	echo '<tr><td>Confirm New Password:</td>';
    echo '<td><input type="password" name="Confirm_Password:"></td></tr>';
    echo '<tr><td colspan="2" align="center">';
    echo '<input type="submit" name="button" value="Save Password"></td>';
	echo '<td colspan="2">';
	echo '<input type="submit" name="button" value="Cancel"></td></tr>';
    echo '</table></form>';
	}

	If ($_REQUEST['button'] == 'Save Password'){
	logo();
	echo "<br><center><h1 >Update Password</h1></center><br><br><br><br>";
	echo '<font size=3><a href="../index.php">Back to Main Menu</font><br>';

	echo '<font size=3><a href="../logout.php">Log out</a></font><br>';

	$New=$_REQUEST['New_Password:'];
	$Confirm=$_REQUEST['Confirm_Password:'];
	$password = $_REQUEST['current'];

	$db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  	mysql_select_db('cbeans', $db_conn);

 	$query ="select a.cust_id as contact_id, cc.company, cc.name, a.user_type
	       FROM $tbl_auth a, $tbl_coop_contact cc
           WHERE a.cust_id='$contact_id'
		   AND a.cust_id=cc.contact_id
           AND a.pass = old_password('$password')";
           
# echo "<br>$query<br>";          

  $result = mysql_query($query, $db_conn);
 //If they are not showing up in the datset with the password they entered then it must be wrong
  if (mysql_num_rows($result) == 0 ){
  echo '<font size=3><a href="password.php">Back to Change Password</a></font><br>';
  echo '<br><br><font size=4 color=red>You need to enter a valid password before the change can be made</font>';
  }
//If its right and the new matches the confirm and at least one of them is set then update the password
  else if (($New == $Confirm) and (isset($New)))  {

  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);

 // $query = "UPDATE  `auth`  SET  `pass`  = password(  '$New' ) WHERE  `name`  =  '$contact_id' LIMIT 1 ";
  $query = "UPDATE   $tbl_auth   SET   pass   = old_password('$New') WHERE  cust_id  =  '$contact_id' LIMIT 1 ";

  $result = mysql_query($query, $db_conn);
  echo '<br><font size=4 color=Red>Your password has been changed. Please make a note of it,</font><br>';
  echo '<font size=4 color=Red>you will need it the next time you log in.</font>';
  }
//Otherwise the new password and confirmatin must not match
  else {
  echo '<font size=3><a href="password.php">Back to Change Password</a></font><br>';
  echo '<br><br><font size=4 color=red>The new password and the confirmation do not match, you must have a typo!</font>';
  }
}
//They just canceled out of the page altogether
	If ($_REQUEST['button'] == 'Cancel'){
	header("Location: http://www.coopercoffeesbeans.com/index.php");
	echo 'You have chosen cancel';
	}
?>


