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
<?
 
require("left_menu.php");  
 

    echo '<td  valign="top">';
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
              echo '¤ ';
            echo date('H:i, jS F');
            echo '</font></td>';
        echo '</tr>';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';

 
 
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
 
  # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
    mysql_select_db('cbeans', $db_conn);
 
 
 
  if ($_REQUEST['SUBMIT'] == "add") {
       $Company = $_REQUEST['Company']; 
      $Company = AddSlashes($Company);
      $Do_Not_Email = $_REQUEST['Do_Not_Email']; 
      $First_Name = $_REQUEST['First_Name']; 
      $Last_Name = $_REQUEST['Last_Name']; 
      $Type = $_REQUEST['TYPE'];  
      $Position = $_REQUEST['Position']; 
      $Rank = $_REQUEST['Rank']; 
      $Email = $_REQUEST['Email']; 
      $WebSite = $_REQUEST['WebSite']; 
      $Address1 = $_REQUEST['Address1']; 
      $Address2 = $_REQUEST['Address2']; 
      $City = $_REQUEST['City']; 
      $State = $_REQUEST['State']; 
      $Zip = $_REQUEST['Zip']; 
      $Country = $_REQUEST['Country']; 
      $Region = $_REQUEST['Region']; 
      $Phone = $_REQUEST['Phone']; 
      $Ext = $_REQUEST['Ext']; 
      $Art_Title = $_REQUEST['Art_Title'];
      $Art_Date = $_REQUEST['Art_Date'];         
      $Mobile = $_REQUEST['Mobile']; 
      $WorkFax = $_REQUEST['WorkFax']; 
      if ($_REQUEST['Newsletter'] == "on" )
       $Newsletter = 1;
      else
       $Newsletter = 0;       
      
      
      if ($_REQUEST['Do_Not_Email'] == "on" )
       $Do_Not_Email = 1;
      else
       $Do_Not_Email = 0; 
      $Art_Title = $_REQUEST['Art_Title']; 
      $Art_Date = $_REQUEST['Art_Date']; 
      $User1 = $_REQUEST['User1']; 
      $User2 = $_REQUEST['User2']; 
      $User3 = $_REQUEST['User3']; 
      $User4 = $_REQUEST['User4']; 
      $User5 = $_REQUEST['User5']; 
      $userid = $_SESSION['valid_user'];
      $current_date = date('Y-m-d H:i:s');  
      $Alt_Email = $_REQUEST['Alt_Email']; 
      $Alt_Phone = $_REQUEST['Alt_Phone'];
      $Key_Info = $_REQUEST['Key_Info'];                  	
 	
   #  mysql_select_db('greenbeans', $db_conn);	

      $query =  "insert $tbl_contact_contact values('','$Company',
      '$Do_Not_Email', 
      '$First_Name',
      '$Last_Name', 
      '$Type',
      '$Position', 
      '$Rank',
      '$Email',
      '$WebSite', 
      '$Address1', 
      '$Address2',
      '$City',
      '$State',
      '$Zip',
      '$Country', 
      '$Region',
      '$Phone',
      '$Ext',
      '$Mobile', 
      '$WorkFax',
      '$Newsletter' ,
      '$Art_Title',
      '$Art_Date',
      '$User1',
      '$User2',
      '$User3',
      '$User4',
      '$User5',
       '$userid',
       '$current_date',
       '$userid',
       '$current_date',
       '$Key_Info',
       '$Alt_Phone',
       '$Alt_Email')";           
    
 
 
   
   #   echo "<br> $query <br>"; 
  #   echo "<br> update = ";
     if (mysql_query($query, $db_conn)) {
        echo "Record has been added!";
        
        $new_id = mysql_insert_id();
         $query = "select *  FROM $tbl_contact_contact    WHERE contact_id = $new_id ";
 
 
      #   echo "<br> $query <br>";
        $result = mysql_query($query, $db_conn);
       if (mysql_num_rows($result) >0 )  {
         $row = mysql_fetch_array($result);
         $num_results = mysql_num_rows($result);
       }
        
        
        
        
        
     }   
     else {
        echo "Record Not Insert, please report problem.";   
     }   
} 	     

 
 echo '<form name=frmMain method=post action="add_contact.php">';
 
 
   if ($_REQUEST['SUBMIT'] == "add") {
         echo '<br><a href="maint_contact.php?contact_id=';
         echo "'$new_id'";
         echo '"> Click here to change this record </a><br>';
           print "<tr><td colspan=2>";
 }
 else {
$Adding_Record = "Yes";
require("contact_fields.php");
 
        print "<tr><td colspan=2>";
  echo'<input type="submit" value="add" name="SUBMIT">';
}
       echo '<hr>';
     echo '</td>';
     echo '<td>';
     echo " ";
     echo '</td>';
     echo '</tr>';
     
    echo '</table>';      
         
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
