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
<!-- Javascript Routines  -->
<script language="Javascript">
   function saveRec() {

    //document.frmMain.submit();
    if ( confirm("Order is complete?")) {
       document.frmMain.submit();
    }
    else
       return false;

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
if (isset($_SESSION['contact_id']))  {
 
       require("quicksearch.php");
 
 
$userid = $_SESSION['valid_user']; 
$contact_id = stripslashes($_REQUEST['contact_id']);
$delete_note = stripslashes($_REQUEST['delete_note']);
$note_confirm = stripslashes($_REQUEST['note_confirm']);
$change_note = stripslashes($_REQUEST['change_note']);
$hidden_seq = stripslashes($_REQUEST['hidden_seq']);
$Notes =  stripslashes($_REQUEST['Notes']);
$note_type =  stripslashes($_REQUEST['note_type']);
$assigned_to =  stripslashes($_REQUEST['assigned_to']);
if ($_REQUEST['completed'] == "on" )
       $completed = 1;
      else
       $completed = 0; 


#echo"contact_id is ".$contact_id."<br>";
# echo "hidden_seq is ".$hidden_seq."<br>";
 # $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);
 

 
 
 # $delete_note = $_REQUEST['$delete_note'];
 # echo '<br>well how about '.$contact_id.'<br>';
 # echo '<br>ok delete note = '.$delete_note.'<br>';
  if ($delete_note > '0' && $note_confirm == 'yes') {

   #    mysql_select_db('greenbeans', $db_conn);	
    #   echo '<br>'.$query.'<br>';
       $query = "delete  FROM $tbl_contact_notes  WHERE seq = $delete_note";	
  	     if (mysql_query($query, $db_conn)) {
        echo " ";
     }   
     else {
        echo "Delete of Note did not work!";   
     } 
}
else
 

 if ($_REQUEST['SUBMIT'] == "add_note") {
     $Notes = $_REQUEST['Notes']; 
     $note_type = $_REQUEST['note_type']; 

     $userid = $_SESSION['valid_user'];
     $query = "insert $tbl_contact_notes (contact_id, note, type, last_change_user, last_change_date, 
               create_user, create_date, assigned_to, completed) values
               ($contact_id, '$Notes','$note_type','$userid','$current_date','$userid','$current_date','$assigned_to','$completed')";
 
    # echo "<br> quwry is $query <br>";
     if (mysql_query($query, $db_conn)) {
        echo "  ";
     }   
     else {
        echo "Action did not work!";   
     }  

}


 
  if ($_REQUEST['SUBMIT'] == "update_note") {
      mysql_select_db('cbeans', $db_conn);
      
      $Notes =  addslashes($Notes);

     $query = "update $tbl_contact_notes set note = '$Notes', type = '$note_type', last_change_user = '$userid', last_change_date = '$current_date', assigned_to = '$assigned_to', completed = '$completed' where seq = $hidden_seq";

      if (mysql_query($query, $db_conn)) {
        echo "Note record saved";
        $note_updated = 'yes';
     }   
     else {
        echo "Note was not saved<br>";   
        echo $query."<br>";
     }   

} 




 
 if ($_REQUEST['SUBMIT'] == "delete") {
      mysql_select_db('cbeans', $db_conn);
     $query = "delete from $tbl_contact_contact where contact_id = $contact_id"; 
      if (mysql_query($query, $db_conn)) {
        echo "Record Deleted ";
        $delete = 'deleted';
     }   
     else {
        echo "Action did not work<br>";   
        echo $query."<br>";
     }     
     
    #    mysql_select_db('greenbeans', $db_conn);	
    #   echo '<br>'.$query.'<br>';
       $query = "delete  FROM $tbl_contact_notes  WHERE contact_id = $contact_id";	
    if (mysql_query($query, $db_conn)) {
        echo " ";
     }   
     else {
        echo "Delete of Note did not work!";   
     }     
     
     
      	     	
 }

 if ($_REQUEST['SUBMIT'] == "save") {
 	
 	

      $Company = $_REQUEST['Company']; 
      $Company = AddSlashes($Company);
      $Do_Not_Email = $_REQUEST['Do_Not_Email']; 
      $First_Name = $_REQUEST['First_Name']; 
      $Last_Name = $_REQUEST['Last_Name']; 
      $TYPE = $_REQUEST['TYPE']; 
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
  #    $Newsletter = $_REQUEST['Newsletter']; 
      
      
      if ($_REQUEST['Do_Not_Email'] == "on" )
       $Do_Not_Email = 1;
      else
       $Do_Not_Email = 0; 
  #    $Do_Not_Email = $_REQUEST['Do_Not_Email']; 
      $Art_Title = $_REQUEST['Art_Title']; 
      $Art_Date = $_REQUEST['Art_Date']; 
      $User1 = $_REQUEST['User1']; 
      $User2 = $_REQUEST['User2']; 
      $User3 = $_REQUEST['User3']; 
      $User4 = $_REQUEST['User4']; 
      $User5 = $_REQUEST['User5'];
       $Alt_Email = $_REQUEST['Alt_Email']; 
      $Alt_Phone = $_REQUEST['Alt_Phone'];
      $Key_Info = $_REQUEST['Key_Info'];       
 	
  #   echo "Key_Info is ".$Key_Info."<br>"; 	
     mysql_select_db('cbeans', $db_conn);	
  #    $query =  "update $tbl_contact_contact set Company = '".$Company."' where contact_id = ".$contact_id;    
 
      $query =  "update $tbl_contact_contact set Company = '$Company',
      Do_Not_Email = '$Do_Not_Email', 
      First_Name  = '$First_Name',
      Last_Name = '$Last_Name', 
      TYPE  = '$TYPE',
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
      User5  = '$User5',
      last_change_user = '$userid',
      last_change_date = '$current_date',           
        Alt_Email = '$Alt_Email',  
      Alt_Phone = '$Alt_Phone', 
      Key_Info = '$Key_Info'            
      where contact_id = $contact_id";   
 
 

     if (mysql_query($query, $db_conn)) {
        echo "Record saved ";
     }   
     else {
        echo "Action did not work";   
     }   
} 	     


 $query = "select *  FROM $tbl_contact_contact    WHERE contact_id = $contact_id ";
 
 
# echo "<br> $query <br>";
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 )  {
    $row = mysql_fetch_array($result);
    $num_results = mysql_num_rows($result);

 echo '<form name=frmMain method=post action="maint_contact.php?contact_id='.$contact_id.'">';
 
   if ($_REQUEST['SUBMIT'] == 'delete?') {
    	
      echo '<font color=red> Are you sure? Pressing delete again will remove this record permanently! </font>';  
    echo'<input type="submit" value="delete" name="SUBMIT">'; 	
}
 
require("contact_fields.php");
  
  
  # begin
          echo '<table width=100%>';
          echo "<tr><td colspan=2>";
        
if ($_REQUEST['SUBMIT'] != 'delete?'  && $_REQUEST['SUBMIT']!= 'delete' ) {
  if ($_REQUEST['SUBMIT'] == 'edit' || $_REQUEST['SUBMIT'] == 'save') 
  {	
   echo'<input type="submit" value="save" name="SUBMIT"> <- Click here to save contact information Above';
   echo '<input type=hidden name="view_mode"  value="1"';
  }
  else
  {
    echo'<input type="submit" value="edit" name="SUBMIT"> <- Click here to edit contact information Above';
    echo '<input type=hidden name="view_mode"   value="0"';;
  }
}
  elseif ($delete == "deleted")  {
  	echo "select new record to continue updating";
 } 	
  else {
  	  echo'<input type="submit" value="Return to Edit Mode" name="SUBMIT">';
  	}
  	 echo '<hr>';
     echo '</td>';
     echo '<td>';
     echo '&nbsp';
     echo '</td>';

      echo '<td align=right>';
      
      
   if ($_REQUEST['SUBMIT'] != 'delete?'  && $_REQUEST['SUBMIT']!= 'delete' ){

      echo'Will Delete Contact record -> <input type="submit" value="delete?" name="SUBMIT">';
      	 echo '<hr>';
   }   
            
     echo '</td>';    
     echo '</tr>';  

  #end 

    echo '</table>'; 
 
	
  
  require("notes_fields.php");
     
     #start notes loop here
       mysql_select_db('cbeans', $db_conn);

 $query = "select cn.*, a.name as auth_name  FROM $tbl_contact_notes cn   left join $tbl_auth a on a.cust_id = cn.assigned_to WHERE  cn.contact_id = $contact_id  order by seq desc";
 
 
  #echo "<br> $query <br>";
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 )
  {
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $num_results = mysql_num_rows($result);
    $alt = 'yes';
    echo '<table width=100%>'; 
   #  echo '<br>have '.$num_results.' note records<br>';
    for ($i=0; $i <$num_results;  $i++) {
    	     
    	     echo '<tr bgcolor="';
             if ($alt == 'yes' ){
                  echo '#FFFFCC';
                  $alt = 'no';
             }
             else {      
    	          echo '#FFFFFF';
    	          $alt = 'yes';
    	     }     
    	     echo '">';
    	     echo '<td width=10%>';
    #	      echo'<input type="submit" value="change_note" name="SUBMIT">';
         	     echo '<a href="maint_contact.php?contact_id='.$contact_id.'&change_note='.$row['seq']."&checkval=234".'">';
    	     echo '<font color=blue>Change</font></a>';

    	      echo '</td>';

           echo '<td width=80%><font color=black>';
           echo '('.$row['seq'].')';


        #   echo '<DIV STYLE="width:80%;">';
           echo $row['note'];
       #    echo '</DIV>';
           echo '<br>';
           echo '<font color=green>&nbsp;&nbsp;&nbsp;Type: </font>';
           echo $row['type'];
           echo ' <font color=green> &nbsp;&nbsp;&nbsp;Date: </font><font color=black>';
           echo $row['create_date'];
           echo '</font> <font color=green>&nbsp;&nbsp;&nbsp;Created by <font color=black>';
           echo $row['create_user'];
           echo '</font> <font color=green>&nbsp;&nbsp;&nbsp;assigned_to <font color=black>';
           if (isset($row['auth_name'])) {
               echo $row['auth_name'];     
           }
           else {           
               echo 'N/A';
           }     
           
           echo '</font> <font color=green>&nbsp;&nbsp;&nbsp;Completed? <font color=black>';
           if ($row['completed'] == 1) {
              echo 'Yes';
           }
           else {
              echo 'No';
           }   	   
                  
           echo '</font></td><td width=10%>';
           
           if ($delete_note == $row['seq']) {
              echo '<a href="maint_contact.php?note_confirm=yes&contact_id='.$contact_id.'&delete_note='.$row['seq']."&checkval=343".'">';
    	     echo '<font color=red>Confirm</font></a>';        	
           }
           else {	
           echo '<a href="maint_contact.php?contact_id='.$contact_id.'&delete_note='.$row['seq']."&checkval=343".'">';
    	     echo '<font color=blue>Delete</font></a>';
    	   }  

 
 #         echo'<input type="submit" value="delete_note" name="SUBMIT">';
          echo '</td>';
          echo '</tr>';
         #   echo '<hr>';
           $row = mysql_fetch_array($result);
     }
     
   echo '</table>';  
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
