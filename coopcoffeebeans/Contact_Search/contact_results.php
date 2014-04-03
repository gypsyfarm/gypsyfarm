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
             echo date('H:i, jS F');    
        echo '</b></font></td>'; 
        echo '</tr>';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
    #        echo '<p align="right">¤ ';
     #       echo date('H:i, jS F');
     #       echo '</p>';
 
 
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
 

#echo 'document-root = '.$DOCUMENT_ROOT.'<BR>';

$quicksearch = $_REQUEST['quicksearch'];


#  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

 
if ($quicksearch != "no") {
   $media_val = " and TYPE != 'MEDIA' ";	
   if ($_SESSION['include_media'] == 'y') {
   	$media_val = "  ";
   }	
   if ($quicksearch == 'staff') {
      $query = "select * FROM $tbl_contact_contact    WHERE TYPE = 'Staff'  order by  Last_Name";
 
   }
   elseif  ($quicksearch == 'member') {
   	  if ($_REQUEST['type'] == 'first') {
      $query = "select * FROM $tbl_contact_contact    WHERE TYPE = 'Member'  order by  First_Name";  
    }
      else {
      	 $query = "select * FROM $tbl_contact_contact    WHERE TYPE = 'Member'  order by  Company";  
      }

    }
   else {		
       $query = "select * FROM $tbl_contact_contact    WHERE Company like '$quicksearch%'  $media_val order by Company, Last_Name";
   }
}   
else {
   	
   $and = " ";
   $where = " where ";
   $search_string = "";
   $Company = $_REQUEST['Company']; 
   $First_Name = $_REQUEST['First_Name'];   
   $Last_Name = $_REQUEST['Last_Name']; 
   $Rank = $_REQUEST['Rank'];  
   $Type = $_REQUEST['Type'];
   $Region = $_REQUEST['Region']; 
   $State = $_REQUEST['State'];
   $Zip = $_REQUEST['Zip']; 
   $Newsletter = $_REQUEST['Newsletter'];       
   $User1 = $_REQUEST['User1'];   
   $User2 = $_REQUEST['User2'];  
   $User3 = $_REQUEST['User3'];  
   $User4 = $_REQUEST['User4'];
   $phone = $_REQUEST['phone']; 
   $email = $_REQUEST['email'];
   $country = $_REQUEST['country'];
                   
   
   if (isset($Company) && $Company != "") {
   	$search_string = $where.$search_string.$and." Company like '".$Company."%' ";
   	$and = " and ";
   	$where = " ";
   } 	
  
   if (isset($First_Name) && $First_Name != "") {
   	$search_string = $where.$search_string.$and." First_Name like '".$First_Name."%' ";
   	$and = " and ";
   	$where = " ";
   }  
   
   if (isset($Last_Name) && $Last_Name != "") {
   	$search_string = $where.$search_string.$and." Last_Name like '".$Last_Name."%' ";
   	$and = " and ";
    	$where = " ";  	
   }  
     
   if (isset($Rank) && $Rank != "") {
   	$search_string = $where.$search_string.$and." Rank = '".$Rank."' ";
   	$and = " and ";
    	$where = " ";  	
   } 
   
   if (isset($Type) && $Type != "") {
   	$search_string = $where.$search_string.$and." Type = '".$Type."' ";
   	$and = " and ";
    	$where = " ";  	
   }  
   
   if (isset($Region) && $Region != "") {
   	$search_string = $where.$search_string.$and." Region =  '".$Region."' ";
   	$and = " and ";
    	$where = " ";  	
   }    
   
   
   if (isset($State) && $State != "") {
   	$search_string = $where.$search_string.$and." State like '".$State."%' ";
   	$and = " and ";
    	$where = " ";  	
   }  
   
   if (isset($Zip) && $Zip != "") {
   	$search_string = $where.$search_string.$and." Zip like '".$Zip."%' ";
   	$and = " and ";
    	$where = " ";  	
   }   
   
    if (isset($Newsletter) && $Newsletter = "On") {
   	$search_string = $where.$search_string.$and." Newsletter = 1 ";
   	$and = " and ";
    	$where = " ";  	
   }     
   
   
      if (isset($User1) && $User1 != "") {
   	$search_string = $where.$search_string.$and." User1 like '".$User1."%' ";
   	$and = " and ";
    	$where = " ";  	
   }   
   
   
         if (isset($User2) && $User2 != "") {
   	$search_string = $where.$search_string.$and." User2 like '".$User2."%' ";
   	$and = " and ";
    	$where = " ";  	
   }     
   
         if (isset($User3) && $User3 != "") {
   	$search_string = $where.$search_string.$and." User3 like '".$User3."%' ";
   	$and = " and ";
    	$where = " ";  	
   }  
   
         if (isset($User4) && $User4 != "") {
   	$search_string = $where.$search_string.$and." User4 like '".$User4."%' ";
   	$and = " and ";
    	$where = " ";  	
   } 
   
   if (isset($phone) && $phone != "") {
   	$phone = str_replace(')','',str_replace('(','',str_replace('-', '', $phone)));
   	$search_string = $where.$search_string.$and." REPLACE(REPLACE(REPLACE(Phone,'-',''),'(',''),')','') like '".$phone."%' ";
   	$and = " and ";
   	$where = " ";
   }   
   
   if (isset($email) && $email != "") {
   	$search_string = $where.$search_string.$and." Email like '".$email."%' ";
   	$and = " and ";
   	$where = " ";
   }  
   
      if (isset($country) && $country != "") {
   	$search_string = $where.$search_string.$and." Country like '".$country."%' ";
   	$and = " and ";
   	$where = " ";
   }  
    
   $query = "select Company, contact_id, First_Name, Last_Name, Phone,Ext, Mobile from $tbl_contact_contact ".$search_string.' order by Company, Last_Name';
}   	 
 
  require("quicksearch.php");
# echo "<br> $query <br>";
 #echo "now setting sesson vars <br>";
 $_SESSION['contact_id_search'] = $query;
 #echo "and thus = ".$_SESSION['contact_id_search'];
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 )
  {
    // if they are in the database register the user id
    $row = mysql_fetch_array($result);
    $num_results = mysql_num_rows($result);
    echo 'number of records is '.$num_results.'<br>';
  #   echo 'one field is '.$row['Company'].'<br>';

      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
 
 
         echo '<tr>';
        echo '<td>Contact ID</td>';
        echo '<td>Company </td>';
        echo '<td>First Name </td>'; 
        echo '<td>Last Name </td>';    
        echo '<td>Phone </td>'; 
        echo '<td>Ext </td>';
        echo '<td>Moble</td>';              
        echo '</tr>';
 
 
 for ($i=0; $i <$num_results;  $i++) {

        $Company = $row['Company'];
        if ($Company == "") 
           $Company = "No Company Name";
           
           
           
                    
        echo '<tr>';
        echo '<td>&nbsp;'.$row['contact_id'].'</td>';
        echo '<td>&nbsp;<a href="maint_contact.php?contact_id=';
        echo "'".$row['contact_id']."'";
        echo '">&nbsp;'.$Company.'</a></td>';
        echo '<td>'.$row['First_Name'].'</td>'; 
        echo '<td>&nbsp;'.$row['Last_Name'].'</td>';    
        echo '<td>&nbsp;'.$row['Phone'].'</td>'; 
         echo '<td>&nbsp;'.$row['Ext'].'</td>'; 
        echo '<td>&nbsp;'.$row['Mobile'].'</td>';              
        echo '</tr>';

   $row = mysql_fetch_array($result);
}   
   
   echo '</table>';


     echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
echo '<tr><td>';
  echo '<p>';
     echo '<A HREF="write_to_csv2.php" target="result">'.'CSV version of File'.'</A>';
     
     
 echo '</td><td>';
  echo '<p>';
     echo '<A HREF="write_email.php" target="result">'.'Email Message'.'</A>';
    
echo '</td></tr></table>';

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
