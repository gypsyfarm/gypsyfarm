<?
require("functions.php");
require("tables.php");
session_start();



require("check_login.php");



?>

<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="general.css">

</head>
 
<?
#require("left_menu.php");   

##echo "<br> submit = ".$_REQUEST['SUBMIT']."<br>";

    echo '<td  valign="top">';
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
            echo '<u>C</u>ontent:</b></font></td>';
        echo '</tr>';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
            echo '<p align="right">¤ ';
            echo date('H:i, jS F');
            echo '</p>';
 

//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
    $user_type = $_SESSION['user_type'];
    if ($user_type == 2) {
 
        $event_date = $_REQUEST['event_date'];
        $event_time = $_REQUEST['event_time'];
        $event_desc = $_REQUEST['event_desc'];  
        $update_id = $_REQUEST['update_id'];              
    	
        if ($_REQUEST['SUBMIT'] == 'addevent') {
          # $db_conn = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');
           mysql_select_db('cbeans', $db_conn);
           if (!$db_conn) {
              echo 'Error: Could not connect to database.  Please try again later.';
              exit;
           }
           mysql_select_db($tbl_events); 
           $query = "insert  $tbl_events values (NULL,'$event_date','$event_time','$event_desc',NULL,NULL)";
           $result = mysql_query($query, $db_conn);
           $event_date = '';
           $event_time = '';
           $event_desc = '';  
           $update_id = '';      
           
           
        }
        
        
        if ($_REQUEST['SUBMIT'] == 'editevent') {
          # $db_conn = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');
           mysql_select_db('cbeans', $db_conn);
           if (!$db_conn) {
              echo 'Error: Could not connect to database.  Please try again later.';
              exit;
           }
           mysql_select_db($tbl_events); 
           $query = "update  $tbl_events set event_desc = '$event_desc', event_date = '$event_date', event_time = '$event_time' where seq = '$update_id';";
           $result = mysql_query($query, $db_conn);
     
           $event_date = '';
           $event_time = '';
           $event_desc = '';  
           $update_id = '';           
                   
        }        
        
        
        
        

        $edit_event = stripslashes($_REQUEST['edit_event']);
        $edit_id = stripslashes($_REQUEST['edit_id']);        
         
        if ($_REQUEST['edit_event'] == 'yes') {
         #  $db_conn = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');        	
           mysql_select_db('cbeans', $db_conn);
           if (!$db_conn){
              echo 'Error: Could not connect to database.  Please try again later.';
              exit;
            }
           $query = "select *  from $tbl_events where seq = '$edit_id';";
 
           mysql_select_db($tbl_events);  
           $result = mysql_query($query, $db_conn);
           $row = mysql_fetch_array($result);  
           $event_desc = $row['event_desc'];
           $event_date = $row['event_date'];           
           $event_time = $row['event_time'];        	
        }	



        $delete_event = stripslashes($_REQUEST['delete_event']);
       # echo "<br> delete_event is $delete_event <br>";
        if ($_REQUEST['event_confirm'] == 'yes') {
         #  $db_conn = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');
           mysql_select_db('cbeans', $db_conn);
           if (!$db_conn){
              echo 'Error: Could not connect to database.  Please try again later.';
              exit;
            }
           $query = "delete  from $tbl_events where seq = '$delete_event';";

           mysql_select_db($tbl_events);  
           $result = mysql_query($query, $db_conn);
        }    	
    	
    	
    	
    	echo '<form name="form_action" method=post action="addevent.php">';
    	echo '<input type=hidden name=update_id value="'.$edit_id.'">';
 
  echo '<table border="0"  width="100%">';
       echo '<tr><td align=center>';
        if ($edit_event == 'yes' ) {
    	    echo'<input type="submit" value="editevent" name="SUBMIT"><br>';         	
         }		
         else {   	
    	    echo'<input type="submit" value="addevent" name="SUBMIT">&nbsp;&nbsp;&nbsp;'; 
         }
         echo '</td><td>';
         echo 'Event Desc: <input type=text name=event_desc size=35 maxlength=35 value="'.$event_desc.'">&nbsp;&nbsp;&nbsp;&nbsp;';  
         echo '</td></tr><tr><td>';
    	echo 'Event Date: <input type=text name="event_date" size=10 value="'.$event_date.'">&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '</td><td>';
    	 echo 'Event Time: <input type=text name="event_time" size=20 value="'.$event_time.'">&nbsp;&nbsp;&nbsp;&nbsp;';
         echo '</tr>';
  	echo '</table>';
    	
 #  $db_conn = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

#echo '<br>event confirm is '.$_REQUEST['event_confirm'].' <br>';
     echo '<br>';
$delete_event = stripslashes($_REQUEST['delete_event']);


 echo '<table border="1"  width="100%">';

  $query = "select * FROM $tbl_events  order by event_date";
  $result = mysql_query($query, $db_conn);
  if (mysql_num_rows($result) >0 ) {
      $row = mysql_fetch_array($result);
      $num_results = mysql_num_rows($result);	
     # echo '<br>';
      $alt = 'yes';     
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
      	echo '<td>';
      	echo '<a href="addevent.php?edit_event=yes&edit_id='.$row['seq'].'">';
      	echo '('.$row['seq'].') ';
      	echo '</a>';

      	echo ' </td><td> <font color=black>'.$row['event_date'].' </font></td><td> <font color=black>'.$row['event_time'].'</font></td><td>';
      	echo '<font color=black>'.$row['event_desc'].'</font></td><td>';
      	
    #  	    echo "<br>delete_event = ".$delete_event." and row is ".$row['seq']."<br>";
            if ($delete_event == $row['seq']) {
              echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==><a href="addevent.php?event_confirm=yes&delete_event='.$row['seq']."&checkval=213".'">';
    	     echo '<font color=red>&nbsp;&nbsp;Confirm</font></a></td><td>';        	
           }
           else {	
           echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==><a href="addevent.php?delete_event='.$row['seq']."&checkval=214".'">';
    	     echo '<font color=blue>&nbsp;&nbsp;Delete</font></a></td><td>';
    	   }       	
      	
      	
      	
      	echo '</td></tr>';
       $row = mysql_fetch_array($result);
      }	    
  	echo '</table>';
  }



         echo '</form';
    }
    else if ($user_type == 3) {
         echo "Invalid screen";      
    }
     else {
         echo "Invalid Screen";
          }
  }        
     




 
        echo '<hr noshade size="1" color="#228B22">';
        echo '<center> Click on message number to edit </center>';
        echo '</td> </tr></table></td></tr></table></body></html>';
