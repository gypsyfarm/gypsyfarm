<?php


session_start();
require("../../functions.php");
require("../../tables.php");


// check security
// check session variable
#  require("../../check_login.php");

#############
#  need to deal with security issues
#################################


      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
            echo 'Password update:</b></font></td>';
        echo '</tr>';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
         #   echo '<p align="right">¤ ';
         #   echo date('H:i, jS F');
             $temp_pw = date('H:i, jS F');
         #   echo '</p>';
 
# get id we are working with.
  $contact_id=$_GET['contact_id'];
  
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);


  $query = "select contact_id, cc.Name, cc.Type
 		   FROM  $tbl_coop_contact cc
           WHERE cc.contact_id ='$contact_id' ";
   # echo "<br> $query <br>";
    

  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 )
  {
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $contact_type = $row['Type']; 
    $contact_name = $row['Name'];
}
   else {
     $contact_type = '?'; 
    $contact_name = 'no_record';
}  	
  
  
 
 $query = "select a.cust_id as contact_id, cc.company, a.name, a.user_type, cc.Type
 		   FROM $tbl_auth a, $tbl_coop_contact cc
           WHERE a.cust_id='$contact_id'
		   AND a.cust_id=cc.contact_id ";
		   
	#	     echo "<br> $query <br>";
 
$user_type_field = '6';
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 )
  {
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $name = $row['name'];
    
 
 switch ($contact_type)
{
case 'C':
  $user_type_field = '1';
  break;
case 'V':
   $user_type_field = '6';
  break;
case '3':
    $user_type_field = '3';
  break;
case 'A':
    $user_type_field = '2';
  break;  
 case '4':
    $user_type_field = '4';
  break;  
 case '5':
    $user_type_field = '4';
  break;
 default:
  $user_type_field = '6';
}
   
    

  }
  else {
  	$name = 'New Record';
  	$user_type_field = '6';
  	
    
 switch ($contact_type)
{
case 'C':
  $user_type_field = '1';
  break;
case 'V':
   $user_type_field = '6';
  break;
case '3':
    $user_type_field = '3';
  break;
case 'A':
    $user_type_field = '2';
  break;  
 case '4':
    $user_type_field = '4';
  break;  
 case '5':
    $user_type_field = '4';
  break;
 default:
  $user_type_field = '6';
}
   
  	
  	
  }	


// provide form to log in
	if (!isset($_REQUEST['button']) &&  $contact_type <> '?')
	{
	#echo "<br><center><h1 >Password Update</h1></center><br><br><br><br>";
    echo "<font size=2 color=black>You are about to change the login ID or  password.";
    echo '<form method="post" action="setpassword.php?contact_id='.$contact_id.'">';
    echo '<table>';
    echo '<tr><td>Enter User ID:</td>';
    echo '<td><input type="input" name="user_id" value="'.$name.'"></td></tr>';
	echo '<tr><td><br></td></tr>';
    echo '<tr><td>Enter New Password:</td>';
    echo '<td><input type="password" name="New_Password:"></td></tr>';
	echo '<tr><td>Confirm New Password:</td>';
    echo '<td><input type="password" name="Confirm_Password:"></td></tr>';
    echo '<tr><td colspan="2" align="center">';
    echo '<input type="submit" name="button" value="Save Password"></td>';
	echo '<td colspan="2">';
	echo '&nbsp;</td></tr>';
    echo '</table></form>';
	}

	If ($_REQUEST['button'] == 'Save Password' &&  $contact_type <> '?') {
 

	$New=$_REQUEST['New_Password:'];
	$Confirm=$_REQUEST['Confirm_Password:'];
	$user_id = $_REQUEST['user_id'];


	$db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  	mysql_select_db('cbeans', $db_conn);

        $query = "select a.cust_id as contact_id, cc.company, a.name, a.user_type
 		   FROM $tbl_auth a, $tbl_coop_contact cc
           WHERE a.cust_id='$contact_id'
		   AND a.cust_id=cc.contact_id ";

  $result = mysql_query($query, $db_conn);
 //If they are not showing up in the datset with the password they entered then it must be wrong
  if (mysql_num_rows($result) == 0 ){
           $query = "insert $tbl_auth values
                      ('$user_id',password('$temp_pw'),$contact_id,$user_type_field) "; 	
 
  	$result = mysql_query($query, $db_conn);
  	
    
  }
 
   if (($New == $Confirm) and (isset($New)))  {
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  $query = "UPDATE  $tbl_auth  SET  pass  = old_password(  '$New' ), name='$user_id', user_type = $user_type_field WHERE  cust_id  =  '$contact_id' LIMIT 1 ";
 
  $result = mysql_query($query, $db_conn);
  echo '<br><font size=4 color=Red>password has been updated. </font><br>';
  }
//Otherwise the new password and confirmatin must not match
  else {
      echo '<font size=3><a href="setpassword.php?contact_id='.$contact_id.'">Back to try again</a></font><br>';
  echo '<br><br><font size=4 color=red>The new password and the confirmation do not match, you must have a typo!</font>';
 

  }
}
elseif ($contact_type == '?')  {
	  echo '<br><br><font size=4 color=red>You must select a contact before coming to this screen!</font>';

}

?>


            <hr noshade size="1" color="#228B22">
             
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>


</body>

</html>