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

<link REL="stylesheet" TYPE="text/css" HREF="general.css">

</head>
 
<?
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
 
 
 
 require("button1.php");
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
	
    $user_type = $_SESSION['user_type'];
    if ($user_type == 1) {
	   echo '<font size=4>Welcome Cooperative Customer '.$_SESSION['valid_user'].'</font><br><br>';
        echo '<iframe src ="pdf_files/currentpricesheet.pdf" width="100%" height="1300"> </iframe> ';
           
     }
    else if ($user_type == 2) {
 
        echo '<font size=4>Welcome '.$_SESSION['valid_user'];
          echo '<iframe src ="pdf_files/currentpricesheet.pdf" width="100%" height="1300"> </iframe> ';
 
    }
    else if ($user_type == 3) {
        echo '<font size=4>Welcome To Cooperative Coffees '.$_SESSION['valid_user'].'</font><br><br>';
        echo "announcement 3";       
    }
  #  else if ($user_type == 4) {
     else {
        echo '<font size=4>Welcome To Cooperative Coffees '.$_SESSION['valid_user'].'</font><br><br>';
        echo "announcement 4";    
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
