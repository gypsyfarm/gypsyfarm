<?php
require("../functions.php");
require("../tables.php");
session_start();



require("../check_login.php");



?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../general.css">

<!-- changed #228B22 to #9bbcc2 -->
</head>

<script language="Javascript">


function saveFirst() {
	
    alert("hitting save first");	
   // give client option to save change before adding a new record
   if (dirty == "true") {
      return (!confirm("You have modified one or more fields.  Discard changes?"));
   }
}
</script>
<?
require("left_menu.php");  


    echo '<td  valign="top">';
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
 
                echo '¤ ';
            $current_date = date('Y-m-d H:i:s');
            echo date('H:i, jS F');
            echo '</font>';
    
                        echo '</td>';
        echo '</tr>';
 
 
 
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';

 
 
//********Present the Menus*********************************************
if (isset($HTTP_SESSION_VARS['contact_id']))  {
 
$contact_id = stripslashes($HTTP_GET_VARS['contact_id']);
 
#echo"contact_id is ".$contact_id."<br>";
  $db_conn = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
 #echo "<br> ok we have ".$HTTP_POST_VARS['Add_Note']."  ... well<br>";
 if ($HTTP_POST_VARS['Add_Note'] == "add_note") {
     $Notes = $HTTP_POST_VARS['Notes']; 
     $userid = $HTTP_SESSION_VARS['valid_user'];
     $query = "insert tst_contact_notes (contact_id, note, last_change_user, last_change_date, 
               create_user, create_date) values
               ($contact_id, '$Notes','$userid','$current_date','$userid','$current_date')";
 
     if (mysql_query($query, $db_conn)) {
        echo "  ";
     }   
     else {
        echo "Action did not work!";   
     }  

}

#echo "submit is ".$HTTP_POST_VARS['SUBMIT'];

 
 if ($HTTP_POST_VARS['SUBMIT'] == "delete") {
      mysql_select_db('greenbeans', $db_conn);
     $query = "delete from tst_contact_contact where contact_id = $contact_id"; 
      if (mysql_query($query, $db_conn)) {
        echo "Record Deleted ";
        $delete = 'deleted';
     }   
     else {
        echo "Action did not work<br>";   
        echo $query."<br>";
     }      	     	
 }

 if ($HTTP_POST_VARS['SUBMIT'] == "update") {
 	
 	

      $Company = $HTTP_POST_VARS['Company']; 
      $Company = AddSlashes($Company);
      $Do_Not_Email = $HTTP_POST_VARS['Do_Not_Email']; 
      $First_Name = $HTTP_POST_VARS['First_Name']; 
      $Last_Name = $HTTP_POST_VARS['Last_Name']; 
      $Type = $HTTP_POST_VARS['Type']; 
      $Position = $HTTP_POST_VARS['Position']; 
      $Rank = $HTTP_POST_VARS['Rank']; 
      $Email = $HTTP_POST_VARS['Email']; 
      $WebSite = $HTTP_POST_VARS['WebSite']; 
      $Address1 = $HTTP_POST_VARS['Address1']; 
      $Address2 = $HTTP_POST_VARS['Address2']; 
      $City = $HTTP_POST_VARS['City']; 
      $State = $HTTP_POST_VARS['State']; 
      $Zip = $HTTP_POST_VARS['Zip']; 
      $Country = $HTTP_POST_VARS['Country']; 
      $Region = $HTTP_POST_VARS['Region']; 
      $Phone = $HTTP_POST_VARS['Phone']; 
      $Ext = $HTTP_POST_VARS['Ext']; 
      $Art_Title = $HTTP_POST_VARS['Art_Title'];
      $Art_Date = $HTTP_POST_VARS['Art_Date'];             
      $Mobile = $HTTP_POST_VARS['Mobile']; 
      $WorkFax = $HTTP_POST_VARS['WorkFax']; 
      if ($HTTP_POST_VARS['Newsletter'] == "on" )
       $Newsletter = 1;
      else
       $Newsletter = 0;       
  #    $Newsletter = $HTTP_POST_VARS['Newsletter']; 
      
      
      if ($HTTP_POST_VARS['Do_Not_Email'] == "on" )
       $Do_Not_Email = 1;
      else
       $Do_Not_Email = 0; 
  #    $Do_Not_Email = $HTTP_POST_VARS['Do_Not_Email']; 
      $Art_Title = $HTTP_POST_VARS['Art_Title']; 
      $Art_Date = $HTTP_POST_VARS['Art_Date']; 
      $User1 = $HTTP_POST_VARS['User1']; 
      $User2 = $HTTP_POST_VARS['User2']; 
      $User3 = $HTTP_POST_VARS['User3']; 
      $User4 = $HTTP_POST_VARS['User4']; 
      $User5 = $HTTP_POST_VARS['User5']; 
 	
 	
     mysql_select_db('greenbeans', $db_conn);	
#     $query =  "update tst_contact_contact set Company = '".$Company."' where contact_id = ".$contact_id;    
 
      $query =  "update tst_contact_contact set Company = '$Company',
      Do_Not_Email = '$Do_Not_Email', 
      First_Name  = '$First_Name',
      Last_Name = '$Last_Name', 
      Type  = '$Type',
      Position = '$Position', 
      Rank  = '$Rank',
      Email = '$Email',
      WebSite = '$WebSite', 
      Address1 = '$Address1', 
      Address2 = '$Address2',
      City  = '$City',
      State  = '$State',
      Zip = '$Zip',
      Country = '$Country', 
      Region  = '$Region',
      Phone = '$Phone',
      Ext = '$Ext',
      Art_Title = '$Art_Title',  
      Art_Date = '$Art_Date',           
      Mobile = '$Mobile', 
      WorkFax = '$WorkFax',
      Newsletter = '$Newsletter' ,
      Art_Title  = '$Art_Title',
      Art_Date  = '$Art_Date',
      User1 = '$User1',
      User2  = '$User2',
      User3  = '$User3',
      User4  = '$User4',
      User5  = '$User5'           
      where contact_id = $contact_id";    
 
 

     if (mysql_query($query, $db_conn)) {
        echo "Record Updated ";
     }   
     else {
        echo "Action did not work";   
     }   
} 	     










 $query = "select *  FROM tst_contact_contact    WHERE contact_id = $contact_id ";
 
 
# echo "<br> $query <br>";
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 )  {
    $row = mysql_fetch_array($result);
    $num_results = mysql_num_rows($result);

  # $row = mysql_fetch_array($result);
  
   
 
 echo '<form name=frmMain method=post action="maint_contact.php?contact_id='.$contact_id.'">';
 
  #    echo $crlf; 
 #     echo '<br> add_note = '.$HTTP_POST_VARS['Add_Note'].'<br>';
 #           echo $crlf;
 #     echo '<br> submit = '.$HTTP_POST_VARS['SUBMIT'].'<br>';
      
      

      
   
  require("contact_fields.php");
  
  
        print "<tr><td>";
        
   if ($delete != "deleted") {
  echo'<input type="submit" value="update" name="SUBMIT">';
}
  else {
  	echo "select new record to continue updating";
 } 	
     echo '</td>';
     echo '<td>';
    echo'&nbsp;';
     echo '</td>';
      echo '<td align=right>';
    echo'<input type="submit" value="delete" name="SUBMIT">';
     echo '</td>';    
     echo '</tr>';  

    echo '</table>'; 

  
  require("notes_fields.php");
     
     #start notes loop here
       mysql_select_db('greenbeans', $db_conn);

 $query = "select *  FROM tst_contact_notes  WHERE contact_id = $contact_id  order by seq desc";
 
 
 #echo "<br> $query <br>";
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 )
  {
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $num_results = mysql_num_rows($result);
 
  #  echo 'have '.$num_results.' note records';
    for ($i=0; $i <$num_results;  $i++) {
           echo '('.$row['seq'].')'.$row['note'].'  Date: '.$row['create_date'].' Created by '.$row['create_user'].'<br>';
         #  echo '<hr>';
           $row = mysql_fetch_array($result);
     }
   }  
   else {   
      echo 'No Comment records';
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
