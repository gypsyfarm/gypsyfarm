<?php
require("../functions.php");
#require("../tables.php");
session_start();

require("../check_login.php");

?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../general.css">


</head>
<?

require("left_menu.php"); 

$set_media = $_REQUEST['set_media'];
if (isset($set_media)) {
    if ($set_media == 'yes') {
       $_SESSION['include_media'] = 'y';
    }
    else {
       $_SESSION['include_media'] = 'n';	
    }
}	

    echo '<td  valign="top">';
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
         #   echo '<u>C</u>ontent:</b></font></td>';  
             echo date('H:i, jS F');    
        echo '</b></font></td>'; 
        echo '</tr>';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
  #          echo '<p align="right">¤ ';
  #          echo date('H:i, jS F');
  #          echo '</p>';
 
 
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
 
 echo '<center> <b>Quick search by Company Name</b> </center><br>';
 
      require("quicksearch.php");
 
  # now put in search fields   
  
  echo '<form name=frmMain method=post action="contact_results.php?quicksearch=no">';


 echo '<table border="0"  width="90%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
echo '<tr>';
echo '<td>';
      echo 'Company: <input type=text name=Company size=30 value="';
      echo $row['Company'];
      echo '">';
 echo '</td><td>';     
     echo '<b>First Name: ';
     echo '<input type=text name=First_Name size=30 value="">';
  echo '</td><td>';   
          echo '<b>Last Name: ';
     echo '<input type=text name=Last_Name size=30 value="">';
     
     echo "</td></tr>";
     echo '<tr>';
     echo '<td>Type: ';
      GenericDropDown($cc_type_list,"Type",$row['Type']);
   echo '</td>';
     echo '<td> Rank: ';
    GenericDropDown($rank_list,"Rank","");
   echo '</td>';

    echo '<td>Region';
    GenericDropDown($region_list,"Region",$row['Region']);  
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo 'Newsletter';
      GenericCheckBox("Newsletter","");    
   echo '</td>';
   echo '</tr>';
   
     echo '<tr>';
     echo '<td> '; 
     echo 'State:';
     echo '<input type=text name=State size=10 value="';
     echo '">';     
    echo '</td>';     
     echo '<td> ';
     echo 'Postal Code';
     echo '<input type=text name=Zip size=15 value="';
     echo $row['Zip'];
     echo '">';     
    echo '</td>';      
     echo '<td> ';
          echo 'User1: ';
     echo '<input type=text name=User1   size=5 >'; 
     echo '&nbsp;&nbsp;'; 
           echo 'User2: ';
     echo '<input type=text name=User2   size=5 >';   
          echo '&nbsp;&nbsp;';    
       echo 'User3: ';
     echo '<input type=text name=User3   size=5 >';  
       echo 'User4: ';
     echo '<input type=text name=User4   size=5 >';               
    echo '</td>';       
     echo '</tr>';      
   
        echo '<tr>';
     echo '<td> '; 
     echo '<b>Phone:</b> ';
     echo '<input type=text name=phone size=30 value="">';
     echo '</td>';     
     echo '<td> ';
     echo '<b>Email:</b> ';
     echo '<input type=text name=email size=30 value="">';
    echo '</td>';      
     echo '<td> ';
     echo '<b>Country:</b> ';
     echo '<input type=text name=country size=30 value="">';
    echo '</td>';       
     echo '</tr>';   
   
        echo '<tr>';
     echo '<td> '; 
     echo '&nbsp;';
   
    echo '</td>';     
     echo '<td> ';
    
    echo '</td>';      
     echo '<td> ';
      echo '&nbsp;';
    echo '</td>';       
     echo '</tr>';     
   
   
   
   echo '</table>';
   echo '<table width=100%><tr>';
   echo '<td  width=33% align=center>';
        echo'<input type="submit" value="search" name="search">';  
    echo '</td><td width=33% align=center>';
         echo'<input type="reset" value="reset" name="reset">';  
         
    echo '</td><td width=33% align=center>';

   echo '<table width=100% bordercolor="#228B22" bgcolor="#FFFF44"><tr><td>';
     if ($_SESSION['include_media'] == 'y') {
         echo '<a href="contact_start.php?set_media=no">Media will be included in search</a> ';
       }
      else {
      	 echo '<a href="contact_start.php?set_media=yes">Media will be excluded from search</a> ';
      } 	
       echo '</td></tr >';

   echo '</table>';   
   
       
    echo '</td></tr></table>';    
 
 
 echo '</form>';           
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
