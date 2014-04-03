<?php
require("../functions.php");
require("../tables.php");

session_start();

include("rasmail_102.php"); 
require("../check_login.php");



?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../general.css">

<!-- changed #228B22 to #9bbcc2 -->
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
echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
echo '<p align="right">¤ ';
echo date('H:i, jS F');
echo '</p>';
 
 
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
   $contact_id = stripslashes($HTTP_GET_VARS['contact_id']);
   if ($_REQUEST['remove_attachment'] == "remove_attachment")   {  
      unset($_SESSION['upload_file']);
   }
 

   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('greenbeans', $db_conn);
 
   $query = $_SESSION['contact_id_search'];
   $result = mysql_query($query, $db_conn);
   if (mysql_num_rows($result) >0 )
   {
    // if they are in the database register the user id
   $row = mysql_fetch_array($result);
   $num_results = mysql_num_rows($result);

    # begin area where I will put form data.  will need to pull this into the loop (see above later).
 
    echo '<form enctype="multipart/form-data"   name=frmMain method=post action="write_email.php?contact_id='.$contact_id.'">';
   $email_list = $_REQUEST['email_list'];
  
   echo '<table border="0"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
 
   print "<tr><td colspan=2>";
   echo ' <input type="hidden" name="MAX_FILE_SIZE" value="400000" />';
   echo ' <input name="userfile" type="file" />';
   echo ' <input type="submit" value="Upload Attachment" />';
  
   $uploaddir = 'attachments/';
 
   $uploadfile = $uploaddir.$_FILES['userfile']['name'];
   
   if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
      unset($_SESSION['upload_file']);
      $_SESSION['upload_file'] = $uploadfile;
   } 
   elseif ($_FILES['userfile']['error'] != 4  && $_FILES['userfile']['error'] > 0) {
      echo "<br> error is ".$_FILES['userfile']['error']."<br>";
      print "<br>Possible file upload attack!  Here's some debugging info:\n";
      print "<pre>";     
      print_r($_FILES);
      echo "</pre>";
   }
   
   echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;File Attachment: ".$_SESSION['upload_file'];

   echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="remove_attachment" name="remove_attachment">';  
   echo '<p>';
   echo '</td></tr>';
   print "<tr><td>";
    
   echo '<b>From: </td><td>';
   echo '<input type=text name=from_email size=40 value="';
   echo $_REQUEST['from_email'];
   echo '">';
   
   echo '</td></tr>';

   print "<tr><td>";
   echo '<b>Subject:';
   print "</td><td>";
   echo '<input type=text name=subject size=40 value="';
   echo $_REQUEST['subject'];;
   echo '">';
   print "</td></tr>";
   print "<tr><td>";
   echo '<b>Body:';
   print "</td><td>";
   echo '<textarea name="body" type="text" width=200 maxlength="255" id="body" style="height:50px;width:300px;">'.$_REQUEST['body'].'</textarea>';

   print "</td></tr>";

   print "<tr><td >";
   echo'<input type="submit" value="email_list" name="email_list">';  
 
   print "</td><td align=center>";
   echo '<font color=red><h3>-»<a href="contact_start.php"><font color=red>Cancel</a></h3> </font>';
   echo "</td>";
   print "</tr>";
  
   echo '</table>'; 
   echo '<hr>';
     
   mysql_select_db('greenbeans', $db_conn);

   $subject = $_REQUEST['subject'];
   $subject_length = strlen($subject);
   $body = $_REQUEST['body'];
   $body_length = strlen($body);


   $sender = $_REQUEST['from_email'];
   $sender_length = strlen($sender);


   $result = mysql_query($query, $db_conn);
   if (mysql_num_rows($result) >0 )  {
       // if they are in the database register the user id
      $row = mysql_fetch_array($result);
       $num_results = mysql_num_rows($result);
  
      if ($subject_length == 0 || $body_length == 0 || $sender_length == 0) {
         echo "<br> <font color=blue>Subject, Body and sender are required fields, no message will be sent without them!</font><br>";
	 $email_list = 'do_not_email';
      }

      $NewMail=new MailSender(); 
      echo '<font color="blue">You have '.$num_results.' records to email. Note: will skip do not email records:<br></font>';
      echo '<hr>'; 
      for ($i=0; $i <$num_results;  $i++) {
    	
         if ($row['Email'] != "" && $row['Do_Not_Email'] != 1) { 
            echo '('.$i.')'.$row['Email'].'  Name: '.$row['First_Name'].' '.$row['Last_Name'].'<br>';
         }

      if ($email_list == "email_list")   {  
         $message = stripslashes($_REQUEST['body']);
         $sender = $_REQUEST['from_email'];

         if ($sender == "") 
            $sender = "pkn@gypsyfarm.com";
         
         $NewMail->Subject(stripslashes($_REQUEST['subject'])); 
         $NewMail->Body($message); 
         $NewMail->Mailformat("0"); 
         $NewMail->Priority("3");   

         if ( $_SESSION['upload_file']) {
            $NewMail->Attachment($_SESSION['upload_file']);
         } 
         #echo '<br>'.$row['Email'].'  ';
         #echo eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,4}$", $row['Email']);
         #echo '<br>';
         if ($row['Email'] != "" && $row['Do_Not_Email'] != 1) {  
            if (!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,4}$", $row['Email'])){	
               echo 'skipping record: bad email address = '.$row['Email'].' flag = '.$row['Do_Not_Email']; 
            }
            else  {
               $NewMail->Sender($sender); 
               $NewMail->Recipient($row['Email']); 
               $NewMail->Execute();
            }
         }    
         else {
            echo 'skipping record: email address = '.$row['Email'].' flag = '.$row['Do_Not_Email']; 
         } 
         echo '<hr>';        
      }      
    
      $row = mysql_fetch_array($result);   

     }
   }  
   else {   
      echo 'No records!';
      echo '<hr>';
        
  }   
  
 
# end   if (mysql_num_rows($result) >0 )
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

           echo '</form>';
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
