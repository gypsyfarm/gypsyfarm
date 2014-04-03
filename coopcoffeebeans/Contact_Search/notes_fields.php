<?php  
  

   
    echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';

     
     
     
      print "<tr><td align=left >";

 
       if ($change_note > 0) {

         mysql_select_db('cbeans', $db_conn);

        $query = "select *  FROM $tbl_contact_notes  WHERE seq = $change_note ";
      #  echo "<br> $query <br>";
        $result = mysql_query($query, $db_conn);
         if (mysql_num_rows($result) >0 )
           $row = mysql_fetch_array($result);  
        echo'<input type="submit" value="update_note" name="SUBMIT">';     	  
       	 echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
       	 echo '&nbsp;';
         echo'<input type="submit" value="Return to add Mode" name="SUBMIT">';
         echo '&nbsp;';
       }
       else {	  
       echo'<input type="submit" value="add_note" name="SUBMIT">';    
        }
        
    # begin
    
         echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Type: </b>';
        $note_type = array("Note","Task","Call"); 
          GenericDropDown($note_type_list,"note_type","","No");
          
    # echo '<br>';
     
     
             $query = "select name, cust_id  FROM $tbl_auth  WHERE user_type = 2 order by name";
        $admin_users = mysql_query($query, $db_conn);  
        echo "&nbsp;&nbsp;&nbsp;&nbsp;Assigned To:";  
         $row2 = mysql_fetch_array($admin_users);
         
           $onchange = 'dirty="true"'; 
   echo "<select  name='assigned_to'   onchange='$onchange' >";

   echo "\n";
   
      echo "<option value=''>&nbsp";
      for ($i=0; $i < mysql_num_rows($admin_users);  $i++) {
          echo $row2['note'];
          echo "\n";
          echo "<option value='".$row2['cust_id']."' ";
    
         if ($row2['cust_id'] == $row['assigned_to'])  
            echo " selected>".$row2['name'];
         else
            echo ">".$row2['name'];
     
         $row2 = mysql_fetch_array($admin_users);
         
      } 	  
      echo '</select>';
      echo "\n";
      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Completed? </b>';
      GenericCheckBox("completed",$row['completed']); 
    
      # end    
       
      echo "\n";   
      echo '<input type=hidden name="hidden_seq" value='.$row['seq']. '>';
      echo '</td></tr><tr><td>Notes: ';
  
      echo "\n";
	/*  
      echo '<input type=text name=Notes maxlength=500 size=100 value="';
      echo str_replace('"', '&#34', $row['note']);

      #   echo addslashes($row['note']);
      echo '">'; 
*/
	  echo "<textarea name='Notes' cols=135 rows=6>";
	  echo str_replace('"', '&#34', $row['note']);
	  echo "</textarea>";
      echo "\n";
      echo '</td></tr>';
     
      echo '</table>'; 
      echo '<hr>';
     
 ?>