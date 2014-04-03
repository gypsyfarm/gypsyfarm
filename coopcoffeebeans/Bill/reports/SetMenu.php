<?php
require("../../functions.php");
require("../../tables.php");
session_start();

require("../../check_login.php");

  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
  }

	echo'<html>';

	echo'<head>';
  	echo'<title>Commitments</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	 echo'<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
	 # echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';
	 

      echo '<table width=100%><tr bgcolor=palegreen><td>';
      echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
      echo '</td><td align=center>'; 
      echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';
  

 // echo "Ok do the for each:". $_POST['link_name']. "<br>";
//  echo print_r($_REQUEST['link_name']) . "<br/>";

 $i = 0;
 if (ISSET($_REQUEST['link_name'])) {
 
 foreach($_REQUEST['link_name'] as $value) {
 	   //  echo "for link name- $i value is $value and seq is ";
 	   //  echo $_REQUEST['seq'][$i];
 	    // echo "<br>";
 	     $seq = $_REQUEST['seq'][$i];
 	     $sort_order = $_REQUEST['sort_order'][$i];
 	     $link_desc = $_REQUEST['link_desc'][$i];
 	     $link_name =  $value;
 	     
 	     $i=$i + 1;
 	     
 	      $query = " update $tbl_report_menu_order
 	                        set sort_order = '$sort_order', 
 	                            link_name = '$link_name',
 	                            link_desc = '$link_desc'
 	                 where seq = $seq;";
 	      mysql_query($query, $db_conn);  
 	      
 	   //   echo "<br>Query is $query <br>";             
 	                        
 	                        
       //      "quantity = '$quantityval' where lot_id = '".$row['lot_id']."'";

   //  
   //  $row = mysql_fetch_array($result);

 }
 
}
 
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
      echo '<tr>';
      echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
      echo date('H:i, jS F');    
      echo '</b></font></td>'; 
      echo '</tr>';
      echo '<tr>';
      echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
 
 
 
 
echo '<form method=POST action=SetMenu.php>';

	echo '<div class="box"><font size=3><h3>Current List of Reports.:</h3></font><br>';
	
	$query = "SELECT * from $tbl_report_menu_order 
	      ORDER by sort_order, link_name asc ";
	      
// echo "Query = $query <br>";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$half_way = ($num_results / 2  - 1);
//echo "<br>Nbr of recs = $num_results";

	echo '<table border="0"  width="90%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="0">';
  echo "<tr>";
  echo '<td bordercolor="#228B22" bgcolor="#FFFFFF" valign="top">';		
		
  echo '<ul>';
for ($i=0; $i <$num_results;  $i++) {
   $row = mysql_fetch_array($result);
   $sort_order = $row['sort_order']; 
   $link_program = $row['link_program']; 
   $link_name = $row['link_name'];
   $link_desc = $row['link_desc'];
   $seq = $row['seq'];
   $linkid = 'link_name'.i;
   $linkdescid = 'link_desc'.i;
   $linkorder = 'sort_order'.i;
   $seqid = 'seq'.i;
   
   
   echo "<li> (program is $link_program)<br><font size=3>";  
        	echo "Link: <input type='text' name='link_name[]' id='$linkid' size=50 value='$link_name'> <br>\n";
        	echo "Rank (sort order): <input type=text name='sort_order[]'  id='$linkorder'  size=5 value='$sort_order'><br>\n";
        	echo "<textarea name='link_desc[]' rows='4' id='$linkdescid'   cols='100'>$link_desc</textarea>\n ";
        	echo "<input type='hidden' name='seq[]' id='$seq' value='$seq' value='$seq'> </font>\n";
        	
   if ($i == $half_way) {
   	 echo '</ul></td><td bordercolor="#228B22" bgcolor="#FFFFFF" valign="top"><ul>';	
   }
}
  
echo '</ul>';
        
echo '</td></tr></table>';    
            


  echo "<center>";
  echo '<input type="SUBMIT" name="ACTION" value="Update">';
 echo "</center>";
  echo '</form>';        
  
 
 
 echo "</body> \n";
  echo "</html> \n";

?>

 
