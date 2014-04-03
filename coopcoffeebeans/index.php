<?php
require("functions.php");
require("tables.php");
session_start();

require("check_login.php");

?>

<!-- replace #228B22 with #228B22 -->
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>
<META NAME="ROBOTS" NONE=NOINDEX,NOFOLLOW>

<link REL="stylesheet" TYPE="text/css" HREF="general.css">

</head>
 
<?
#echo "<br>User id is $userid <br>";
require("left_menu.php");   
    echo '<td  valign="top">';
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
            echo '<u>C</u>ontent:</b></font></td>';
        echo '</tr>';
        echo '<tr>';
          echo '<td align=top width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
            echo '<p align="right">¤ ';
            echo date('H:i, jS F');
            echo '</p>';
 
 
 # ok do update to complete for Note:
# echo "<br>check val is ".$_REQUEST['checkval']."<br>";
   if ($_REQUEST['checkval'] == "234") {
   	
   	  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
       mysql_select_db('cbeans', $db_conn) or die("opps did not work");
  
      
      $change_note =  $_REQUEST['change_note'];

     $query = "update $tbl_contact_notes set completed = 1 where seq = $change_note";


echo $query."<br>";
      if (mysql_query($query, $db_conn)) {
        $note_updated = 'yes';
     }   
     else {
        echo "Note was not updated<br>";   
        echo $query."<br>";
     }   

}
 
 require("button1.php");
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
	
    $user_type = $_SESSION['user_type'];
    if ($user_type == 1) {
	   echo '<font size=4>Welcome Cooperative Customer '.$_SESSION['valid_user'].'</font><br><br>';
        require("announcement.php");	   
     }
    else if ($user_type == 2) {
    	echo '<form name="login" method=post action="index.php">';
#        echo '<font size=4>Welcome '.$_SESSION['valid_user'].'</font><br><br></font>';
#        echo '<font size=2><div class=genText id="divAnnouncement" >';

        echo '<div class=genText id="divAnnouncement" >';
        echo '<font size=4>Welcome '.$_SESSION['valid_user'];
        echo ' &nbsp; &nbsp;';

        require("announcement.php"); 
            echo '</div>';
        echo '<hr>';
        echo '<center>';    
        echo'<input type="submit" value="backup" name="SUBMIT">';
        echo ' &nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp; ';
        echo '<input type="submit" value="copytotest" name="SUBMIT">';    
        echo '</center>';
        echo '</form';
    }
    else if ($user_type == 3) {
        echo '<font size=4>Welcome To Cooperative Coffees '.$_SESSION['valid_user'].'</font><br><br>';
        require("announcement.php");        
    }
  #  else if ($user_type == 4) {
     else {
        echo '<font size=4>Welcome To Cooperative Coffees '.$_SESSION['valid_user'].'</font><br><br>';
        require("announcement.php");        
     }
}     
else {  
    if (isset($userid)) {
      // if they've tried and failed to log in
        echo 'Could not log you in';
    }
    else {
      // they have not tried to log in yet or have logged out
      echo '<font size=4 color=black>You are not logged in, please enter a valid userid and password.</font>';
    }
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
