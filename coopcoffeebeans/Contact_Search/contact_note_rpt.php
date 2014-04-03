<?php
require("../functions.php");
require("../tables.php");
session_start();

require("../check_login.php");


   function getMonthRange(&$start_date, &$end_date, $offset=0) {
        $start_date = '';
        $end_date = '';   
        $test_date1 = "";
        $test_date2 = "";
        $date = date('Y-m-d');
       
        list($yr, $mo, $da) = explode('-', $date);
        $start_date = date('Y-m-d', mktime(0, 0, 0, $mo - $offset, 1, $yr));
        
        $test_date1 = date('Y-m-d', mktime(0, 0, 0, $mo - $offset, 2, $yr));
       
        $i = 2;
       
        list($yr, $mo, $da) = explode('-', $start_date);
       
        while(date('d', mktime(0, 0, 0, $mo, $i, $yr)) > 1) {
            $end_date = date('Y-m-d', mktime(0, 0, 0, $mo, $i, $yr));
            $i++;
        }
        
  
}    

?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../general.css">


</head>
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
 
    echo '<table  width="100%" bordercolor="#FFFFFF" cellspacing="0" cellpadding="2">';
    echo '<tr>';
    echo '<td>';
    echo '<form name=frmMain method=post action="contact_note_rpt.php">';
    echo'<input type="submit" value="Run" name="SUBMIT">';
    echo ' <b>Note search options</b> ';
    echo '</td>';
    echo '<td align="center">';
    echo'<input type="submit" value="Quick Prospect Search" name="SUBMIT">(Current and Previous Month)';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    
    
    
    $current_date = strtotime("now");  
   # echo "<br>Current date is $current_date <br>";
    # echo getMonthRange($from_month, $to_date, 0);
    getMonthRange($start_date, $end_date, 4);
    
 #   echo "<br>from $from_date to $end_date <br> ";
    
    $default_start_date = strtotime($start_date);
    
    $default_start_month = Date(m,$default_start_date);
    $default_end_month = Date(m,$current_date);
    
    $default_start_day = Date(d,$default_start_date);
    $default_end_day = Date(d,$current_date);
    
    $default_start_year = Date(Y,$default_start_date);
    $default_end_year = Date(Y,$current_date);


   # echo "<br> start $default_start_year - $default_start_month - $default_start_day ";
   # echo "<br> end $default_end_year - $default_end_month - $default_end_day ";

   # echo "<p>";
 

/*

$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));
echo "Tomorrow is ".date("m/d/y", $tomorrow); 

*/
 
  # now put in search fields 
 

  
  


 echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';

echo '<tr>';
echo '<td>';

 #  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }
 $sql = "SELECT create_user FROM $tbl_contact_notes  GROUP BY create_user";
 # echo '<br>'.$sql.'<br>';

      $ddresults = mysql_query($sql, $db_conn);
    if (!$ddresults)
    { echo "too bad too sad"; }


   $ddrow = mysql_fetch_array($ddresults);
   
   $num_results = mysql_num_rows($ddresults);
  for ($i=0; $i <$num_results;  $i++) {  
  	$authors[$i] = $ddrow['create_user'];
  	 
        $ddrow = mysql_fetch_array($ddresults);	
 } 	
   echo 'Note Author:';
   GenericDropDown($authors,"note_author",$_REQUEST['note_author']);

echo '</td>';



echo '<td>';
//***************************Create the Date Drop Downs from Functions****************


/*

$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));
echo "Tomorrow is ".date("m/d/y", $tomorrow); 

*/




 if ($_REQUEST['To_Year'] == '') {
    $_REQUEST['To_Year']= $default_end_year;  
  }
  
  if ($_REQUEST['From_Year'] == '') {
    $_REQUEST['From_Year']= $default_start_year;  
  }
  if ($_REQUEST['To_Day'] == '') {
    $_REQUEST['To_Day']= 31;  
  }
  if ($_REQUEST['From_Day'] == '') {
    $_REQUEST['From_Day']= 01;  
  }
    if ($_REQUEST['To_Month'] == '') {
    $_REQUEST['To_Month']= $default_end_month;  
  }
  if ($_REQUEST['From_Month'] == '') {
    $_REQUEST['From_Month']= $default_start_month;  
  }

	  echo 'Starting Month';

      $from_month=$_REQUEST['From_Month'];
	  from_monthdropdown($from_month);
	  
	  	  echo 'Day: ';

      $from_day=$_REQUEST['From_Day'];
	  from_daydropdown($from_day);

      echo 'Year: ';

	  $from_year=$_REQUEST['From_Year'];
	  from_yeardropdown($from_year);


	  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	  echo 'Ending Month: ';

	  $to_month=$_REQUEST['To_Month'];
	  to_monthdropdown($to_month);
	  
	  echo 'Day: ';

	  $to_day=$_REQUEST['To_Day'];
	  to_daydropdown($to_day);

	  echo 'Year: ';

	  $to_year=$_REQUEST['To_Year'];
	  to_yeardropdown($to_year);
         
 
	  echo '<br>';

    echo '</td>';
    echo '</tr>';

    echo '</table>';

   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }



   echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
   echo '<tr>';
   echo '<td>';
   echo 'Sort Option: ';
   GenericDropDown($note_sort_options,"note_sort_option",$_REQUEST['note_sort_option']);
   echo '<br><i>Defaults to Company, Create Date.</i></td><td>';     
   
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
       echo '</td><td>';   
       echo '<b>Type: </b>';
       GenericDropDown($note_type_list,"note_type","","yes");
       echo "</td>";
       echo '<td>';
       echo '<b>Completed? </b>';
       GenericCheckBox("completed",""); 
       echo '<br><b>Not Completed? </b>';
       GenericCheckBox("no_completed","");      
       echo '</td>';
       echo "</tr>";
       echo '</table>';
   
       echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';

     # set default value:    
     
            $to_date = $to_year.'-'.$to_month.'-'.$to_day;
       $from_date = $from_year.'-'.$from_month.'-'.$from_day; 
       $sql_where .= ' and n.create_date between "'.$from_date.'" and "'.$to_date.'"';     

       $sql = "SELECT  c.TYPE, c.contact_id,  n.create_date, n.create_user, c.Company, 
               c.First_Name, c.Last_Name, n.note 
               FROM $tbl_contact_contact c, $tbl_contact_notes n 
               WHERE c.contact_id = n.contact_id 
               and n.create_date between '$from_date.' and '$to_date'  
               ORDER BY c.Company, n.create_date DESC LIMIT 0, 500";
 
       if ($_REQUEST['SUBMIT'] == "Run") {
      # break into three parts, select, where and order by.
      # select is the easiest since it does not change.
        $sql_select =  	"SELECT c.TYPE, c.contact_id, n.create_date, n.create_user, 
                         c.Company, c.First_Name, c.Last_Name, n.note 
                         FROM $tbl_contact_contact c, $tbl_contact_notes n ";
       $sql_where = ' WHERE c.contact_id = n.contact_id  ';

       if (isset($_REQUEST['note_author'] ) && $_REQUEST['note_author'] != '' ) {
    	     $sql_where .= ' and n.create_user = "'.$_REQUEST['note_author'].'"';
       } 	
     
       if (isset($_REQUEST['note_type'] ) && $_REQUEST['note_type'] != '' ) {
    	    $sql_where .= ' and n.type = "'.$_REQUEST['note_type'].'"';
       } 	
     
       if (isset($_REQUEST['assigned_to'] ) && $_REQUEST['assigned_to'] != '' ) {
         	$sql_where .= ' and n.assigned_to = "'.$_REQUEST['assigned_to'].'"';
       } 	          

       if (isset($completed) && $completed = "On") {
       	  $sql_where .= ' and n.completed = 1 ';
       }     
       elseif (isset($no_completed) && $no_completed = "On") {
    	    $sql_where .= ' and n.completed = 0 ';
       }    

       $to_date = $to_year.'-'.$to_month.'-'.$to_day;
       $from_date = $from_year.'-'.$from_month.'-'.$from_day; 
       $sql_where .= ' and n.create_date between "'.$from_date.'" and "'.$to_date.'"';     

       $sql_order = ' ORDER BY c.Company, n.create_date DESC LIMIT 0, 500';

       if (isset($_REQUEST['note_sort_option']) && $_REQUEST['note_sort_option'] != '' ) {
          $sql_order = 'order by '.$_REQUEST['note_sort_option'].'  DESC LIMIT 0, 500';
        } 	

       $sql = $sql_select.$sql_where.$sql_order; 	
    } 
    # Check if Quick Prospect Search.	   
    elseif ($_REQUEST['SUBMIT'] == "Quick Prospect Search") {
    	
    	   $to_date = date('Y-m-d');
    	 # echo getMonthRange($from_month, $to_date, 0);
    	  echo getMonthRange($from_date, $end_date, 1);
 
    	
    	  $sql_select =  	"SELECT c.TYPE, c.contact_id, n.create_date, n.create_user, 
                         c.Company, c.First_Name, c.Last_Name, n.note 
                         FROM $tbl_contact_contact c, $tbl_contact_notes n ";
        $sql_where = ' WHERE c.contact_id = n.contact_id  ';
          $sql_where .= ' and n.create_date between "'.$from_date.'" and "'.$to_date.'"';   
        $sql_where .= ' and c.TYPE = "PROSPECT" ';
        $sql_order = ' ORDER BY c.Company, n.create_date DESC LIMIT 0, 500';
        $sql = $sql_select.$sql_where.$sql_order; 
    }
   
   #echo "<br>sql=$sql<br>";
   
    $ddresults = mysql_query($sql, $db_conn);
   $ddrow = mysql_fetch_array($ddresults);   
   $num_results = mysql_num_rows($ddresults);

    if ($num_results == 0) { 
    	echo "Select did not return any records"; 
    }
    else {



       echo '<th>';
       echo 'Create Date';
       echo '</th>';  
       echo '<th>';
       echo 'Create User';
       echo '</th>';   
       echo '<th>';
       echo 'Company(link)';
       echo '</th>'; 
       echo '<th>';
       echo 'First Name';
       echo '</th>';  
       echo '<th>';
       echo 'Last_Name';
       echo '</th>';      
       echo '<th>';
       echo 'Note';
       echo '</th>';  
       echo "</tr>";        




    $alt = 'yes';

  for ($i=0; $i <$num_results;  $i++) { 
#echo '<tr>';  	

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

echo '<td width=80>';
 $strDate = strtotime($ddrow['create_date']);
 echo date("M d, Y",$strDate);
 echo '&nbsp;';
  echo '</td>';  
echo '<td>';
 echo $ddrow['create_user'];
 echo '&nbsp;'; 
  echo '</td>';   
echo '<td>';
 echo '<a href="';
 echo "maint_contact.php?contact_id='".$ddrow['contact_id']."'";
 echo '">';
 echo $ddrow['Company'];
 echo '</a>';
 echo '&nbsp;'; 
  echo '</td>'; 
echo '<td>';
 echo $ddrow['First_Name'];
 echo '&nbsp;'; 
  echo '</td>';  
echo '<td>';
 echo $ddrow['Last_Name'];
 echo '&nbsp;'; 
  echo '</td>';      
 echo '<td>';
 echo $ddrow['note'];
 echo '&nbsp;'; 
  echo '</td>';  
         $ddrow = mysql_fetch_array($ddresults);	
      echo "</tr>";        
}  
   
}  
   
   
   echo '</table>';
   
 
   
   
  #      echo'<input type="submit" value="search" name="search">';  
 
 
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
