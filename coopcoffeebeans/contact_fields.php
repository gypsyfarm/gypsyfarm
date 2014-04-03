 <?php
//********************************************************************************
//********************* Maint Screen fields                     ************************
//********************************************************************************
     
       echo '<table border="0"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';

   
        print"<tr><td>";

     echo '<input type=hidden name=contact_id size=10 value="';
     echo $row['contact_id'];
     echo '">';

     echo '<p><b>('.$row['contact_id'].')   company: ';
     

     print "</td><td>";

     echo '<input type=text name=Company size=40 value="';
     echo $row['Company'];
     echo '">';
     
 
     echo '</td>';
     echo '<td>Type: ';
    GenericDropDown($cc_type_list,"Type",$row['Type']);
     echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Position: ';
     echo '<input type=text name=Position size=25 value="';
     echo $row['Position'];
     echo '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rank: ';
     echo $row['Rank'];
     GenericDropDown($rank_list,"Rank",$row['Rank']);
     echo '</td>';
     echo '</tr>';

  

     print "<tr><td>";
     echo '<b>First Name: </td><td>';
     echo '<input type=text name=First_Name size=40 value="';
     echo $row['First_Name'];
     echo '">';

     echo '</td>';
     echo '<td>Last Name: ';

     echo '<input type=text name=Last_Name size=40 value="';
     echo $row['Last_Name'];     
     echo '">';
     echo '</td>';
     echo '</tr>';

     print "<tr><td>";
      echo '<b>Email Address:';
     print "</td><td>";
     echo '<input type=text name=Email size=40 value="';
     echo $row['Email'];
     echo '">';
     echo '</td>';
     echo '<td>WebSite: ';
      echo '<input type=text name=WebSite size=40 value="';
     echo $row['WebSite'];
     echo '">';
     echo '</td>';
     echo '</tr>';


     print "<tr><td>";
      echo '<b>Phone:';
     print "</td><td>";
     echo '<input type=text name=Phone size=40 value="';
     echo $row['Phone'];
     echo '">';
     echo '</td>';
     echo '<td> Ext: ';
     echo '<input type=text name=Ext size=6 value="';
     echo $row['Ext'];
     echo '">';
     echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Mobile: ';
     echo '<input type=text name=Mobile size=20 value="';
     echo $row['Mobile'];
     echo '">';     
     
     echo '</td>';
     echo '</tr>';

     print "<tr><td>";
      echo '<b>Work Fax:';
     print "</td><td>";
     echo '<input type=text name=WorkFax size=40 value="';
     echo $row['WorkFax'];
     echo '">';
     echo '</td>';
     echo '<td>';
     
     echo 'NewsLetter:';
     GenericCheckBox("Newsletter",$row['Newsletter']);
     echo '&nbsp;&nbsp;&nbsp;Do Not Email:';
     GenericCheckBox("Do_Not_Email",$row['Do_Not_Email']);     
     echo '</td>';
     echo '</tr>';

     print "<tr><td>";
      echo '<b>Address 1:';
     print "</td><td>";
     echo '<input type=text name=Address1 size=40 value="';
     echo $row['Address1'];
     echo '">';
     echo '</td>';
     echo '<td>';
     echo 'User1: ';
     echo '<input type=text name=User1 size=25 value="';
     echo $row['User1'];
     echo '">';
     echo '</td>';
     echo '</tr>';


     print "<tr><td>";
      echo '<b>Address 2:';
     print "</td><td>";
     echo '<input type=text name=Address2 size=40 value="';
     echo $row['Address2'];
     echo '">';
     echo '</td>';
     echo '<td>';
     echo 'User2: ';
     echo '<input type=text name=User2 size=25 value="';
     echo $row['User2'];
     echo '">';
     echo '</td>';
     echo '</tr>';




     print "<tr><td>";
      echo '<b>City:';
     print "</td><td>";
     echo '<input type=text name=City size=40 value="';
     echo $row['City'];
     echo '">';
     echo '</td>';
     echo '<td>';
     echo 'User3: ';
     echo '<input type=text name=User3 size=25 value="';
     echo $row['User3'];
     echo '">';
     echo '</td>';
     echo '</tr>';


     print "<tr><td>";
      echo '<b>State / Zip:';

          echo '</td><td>';
       echo '<input type=text name=State size=10 value="';
     echo $row['State'];
     echo '">&nbsp;&nbsp;&nbsp;&nbsp;';
     echo '<input type=text name=Zip size=15 value="';
     echo $row['Zip'];
     echo '">';
     echo '</td><td>';
     echo 'User4: ';
     echo '<input type=text name=User4 size=25 value="';
     echo $row['User4'];
     echo '">';
     echo '</td>';
     echo '<td>';

     echo '</td>';
     echo '</tr>';

     print "<tr><td>";
      echo '<b>Country:';
     print "</td><td>";
     echo '<input type=text name=Country size=25 value="';
     echo $row['Country'];
     echo '">';
     echo '&nbsp;&nbsp;&nbsp;Region';
     GenericDropDown($region_list,"Region",$row['Region']);     
     echo '</td>';
     echo '<td>';
      echo '<b>Art Title: ';
     echo '<input type=text name=Art_Title size=50 value="';
     echo $row['Art_Title'];
     echo '">';
     echo '</td>';
     echo '</tr>';
     
 
     print "<tr><td>";
      echo ' ';
     print "</td><td>";
     echo ' ';
     echo '</td>';
     echo '<td>';
     echo '<b>Art Date:';
     echo '<input type=text name=Art_Date size=12 value="';
     echo $row['Art_Date'];
     echo '">';
     echo '</td>';
     echo '</tr>';   


     
 

#  } 

/*
        print "<tr><td colspan=2>";
  echo'<input type="submit" value="update" name="SUBMIT">';
       echo '<hr>';
     echo '</td>';
     echo '<td>';
     echo " ";
     echo '</td>';
     echo '</tr>';
     
     
    echo '</table>'; 
    
    
      echo '<hr>';
*/     
     ?>