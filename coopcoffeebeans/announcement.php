<?php
//********************************************************************************
//********************* Display announcement for Cooperative Coffees ************************
//********************************************************************************

  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

if (!$db_conn)
{
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
}

#begin test  $_POST
  $test_array = $_POST['cmp'];
 if (isset($test_array)) {




	  $announce = "no";
	  echo '<input type="hidden" name="no_announce" id="no_announce" value="yes">';
  foreach($_POST['cmp'] as $ID) {
 # echo ("<p>Value: $ID<br><p>\n");
  
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }
     $query = "update $tbl_contact_notes set completed = 1 where seq = '".$ID."'";

    $ddresults = mysql_query($query, $db_conn);
}
 }	
#end test



   
# Begin Insert
$contact_id =  $_SESSION['auth_contact_id'];
# mysql_select_db('cbeans', $db_conn);

$query = "select cn.*, a.name as auth_name, cc.First_Name, cc.Last_Name, cc.Company, cc.Phone 
            FROM ($tbl_contact_notes cn, $tbl_contact_contact cc)   
            left join $tbl_auth a on a.cust_id = cn.assigned_to 
           WHERE  cn.assigned_to = '$contact_id' 
             and cn.contact_id = cc.contact_id 
             and cn.completed = '0' 
           order by seq desc";
 
# echo "<br>$query <br>";
$note_count = 0;
$result = mysql_query($query, $db_conn);
  
if (mysql_num_rows($result) >0 )   
{
    $num_results = mysql_num_rows($result);
    $note_count = $num_results;
    $message_message =  ' You have have '.$num_results.' note, call or task records<br>';
    echo $message_message.'</font><font size=2>';
}
# End Insert
 

$system_message = $_POST['system_message'];
if ($_POST['SUBMIT'] == 'updatemsg'){


   $query = "update $tbl_coop_message set system_message = '".$system_message."'";

    $ddresults = mysql_query($query, $db_conn);

    # $debug =  "<br>query = $query <br>";
}


if ($_POST['no_announce'] == "yes") {
    $announce = "no";
}
 
# pulled from here. 

    echo '<table width=100%><tr><td width=50% align=left>';	
    echo $welcome_message;
     echo '</td><td width=50% align=right>';
  #  echo $message_message;
     echo '</td></tr></table>';
    echo '<font size=2><div class=genText id="divAnnouncement" >';
   $query = "select * from $tbl_coop_message ";

    $ddresults = mysql_query($query, $db_conn);

   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);
   
   echo "<center>";

   echo "<table width=100% border=0 cellpadding=1>";
   echo "<tr align=top ><td align=top colspan=2><h3>";

   if ($user_type == 2) {
   	
   	   if ($announce == "no" and $note_count > 0) {
   	   	
   	   	           echo '<center>'; 
                           echo '<table width=96%><tr><td width=32%>&nbsp;</td>';
                          echo '<td width=32% align=center>';
                           echo'&nbsp;';  
                          echo '</td><td width=32% align=right> <input type="submit" value="Complete" name="SUBMIT"></td>';
                         echo '</tr></table>';  
            }             
   	   else {	
   	
                    if ($_POST['SUBMIT'] == "editmsg") {
 	                
                     echo '<textarea name="system_message" type="text"   maxlength="255" id="system_message" style="height:550px;width:800px;">'.$ddrow['system_message'].'</textarea><br>';
                    echo '<center>'; 
                    echo'<input type="submit" value="updatemsg" name="SUBMIT"><br>'; 
                     }   	
                    else {
                     echo $ddrow['system_message'];
                     echo '<center>'; 
                     echo '<table width=96%><tr><td width=32%>';
                     echo'<input type="submit" value="editmsg" name="SUBMIT">'; 
                     echo '</td><td width=32% align=center>';
                     echo '&nbsp;';
                     echo '</td><td width=32% align=right>';
                     if ($note_count > 0) {
                         echo '<input type="submit" value="Complete" name="SUBMIT">';
                     }
                     echo '&nbsp;</td>';
                     echo '</tr></table>';       
                    } 
          }          
   }         
   else {
       echo $ddrow['system_message'];
   } 	            
   echo "</h3></td>";
   
      echo "</tr>";
 
      
   echo "<tr><td colspan=2>";
# begin cut
# End Cut
  if (mysql_num_rows($result) >0 )
  {
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $num_results = mysql_num_rows($result);
    $alt = 'yes';
    echo '<table width=100%>'; 
  #   echo '<br>have '.$num_results.' note records<br>';
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
         	     echo '<a href="Contact_Search/maint_contact.php?contact_id='.$row['contact_id'].'&change_note='.$row['seq']."&checkval=234".'">';
    	     echo '<font color=blue>Change</font></a>';

    	      echo '</td>';

           echo '<td width=80%><font color=black>';

           echo '<font color=black>';
           echo $row['First_Name'].' '.$row['Last_Name'].'  <font color=green> of</font> '.$row['Company'];
           echo ' &nbsp;&nbsp;&nbsp;<font color=green> Phone: </font>'.$row['Phone'];
           echo ' <font color=green> &nbsp;&nbsp;&nbsp;Date: </font><font color=black>';
           echo $row['create_date'];
           echo '</font> <font color=green>&nbsp;&nbsp;&nbsp;Created By <font color=black>';
           echo $row['create_user'];
           echo '</font> <font color=green>&nbsp;&nbsp;&nbsp;Assigned To <font color=black>';
           echo $row['auth_name'];           
           
           echo '<br>';
           echo '</font>'; 
           echo '<font color=green>&nbsp;Type: </font>';
           echo ' <font color=black>';
           echo $row['type'];
           echo ' ('.$row['seq'].') ';
           echo $row['note'];  
           echo '</font>';         
           
           echo '</td><td width=10%>'; 
        # 	     echo '<a href="index.php?contact_id='.$row['contact_id'].'&change_note='.$row['seq']."&checkval=234".'">';
    	 #    echo '<font color=blue>Completed</font></a>';
    	  #   echo '<br>';
    	     $testseq = $row['seq'];
    	     echo ("<input type='checkbox' name='cmp[]' value='$testseq'>\n");
    	     echo '</td>';          
 
          echo '</tr>';
         #   echo '<hr>';
           $row = mysql_fetch_array($result);
     }
     
   echo '</table>';  
   }              
   
   
   echo "</td></tr>";
   
   
   echo "</table>";
 echo '</div>';

#$debug .= "<br>Ok just testing.";

#echo "<br>$debug <br>";
?>
