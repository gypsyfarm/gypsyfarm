<?php
require("../../functions.php");
require("../../tables.php");
session_start();

require("../../check_login.php");

?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">


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
 
 
	echo '<div class="box"><font size=3><h3>Select A report to Run:</h3></font><br>';


	$query = "SELECT * from $tbl_report_menu_order  
	      ORDER by sort_order, link_name asc ";
	      
// echo "Query = $query <br>";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$half_way = ($num_results / 2  - 1);


	echo '<table border="0"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="0">';
  echo "<tr>";
  echo '<td bordercolor="#228B22" bgcolor="#FFFFFF" valign="top">';		
		
  echo '<ul>';
  
  for ($i=0; $i <$num_results;  $i++) {
     $row = mysql_fetch_array($result);
     $sort_order = $row['sort_order']; 
     $link_program = $row['link_program']; 
     $link_name = $row['link_name'];
     $link_desc = $row['link_desc'];
     echo '<li>';
     echo "<font size=3><a href='$link_program'><span title='$link_desc'>$link_name</span></a></font><br>";        
       	
     if ($i == $half_way) {
   	   echo '</ul></td><td bordercolor="#228B22" bgcolor="#FFFFFF" valign="top"><ul>';	
     }
  }
  
echo '</ul>';
        
echo '</td></tr></table>'; 


 
            
    echo "</div>";
 

   
       
    echo '</td></tr></table>';    
    
    
    echo "<center><a href='SetMenu.php'><span title='Adjust Report Screen.'>Adjust Report Screen.</span></a></center> ";
 
 
           
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
