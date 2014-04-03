<html>
<head>
<title>Previous Order Selection:</title>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>
<BODY text=#000000  vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff >


<!--
<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>
-->
<br><center><h1>Previous Order Processing Page</h1></center> <br>
<font size=3><font size=3><a href="../index.php">Back to the Menu</a></font><br></font><br>
<font size=3><a href="../logout.php">Log out</a></font><br>
 

 <center>
 <form name="frmMain" action=orderorder1.php method=post>
 </center>

 

<?php

require("../tables.php");
require("../functions.php");


#
# create short variable names from from fields.
# -> did not work... $old_level = error_reporting(4);
  error_reporting (E_ALL ^ E_NOTICE);
  $form_nbr_days_past=$_REQUEST['form_nbr_days_past'];
if (!isSet($form_nbr_days_past)) {
    $form_nbr_days_past=60;
}


   echo "\n";
	echo '<b>Nbr of Days Past: ';
	echo '<input type=text name=form_nbr_days_past size=4 value="';
	echo $form_nbr_days_past;
	echo '">';
	  echo "\n";
 
 
  # get the current unix timestamp 
$ts = time(); 

# figure out what 7 days is in seconds 
$nbr_days_past = $form_nbr_days_past * 24 * 60 * 60; 

# make today's date based on current timestamp 
$today = date( "Y-m-d", $ts ); 

# make last week's date based on a past timestamp 
$past_date = date( "Y-m-d", ( $ts - $nbr_days_past ) ); 

echo '60 days past is '.$past_date.'<br>';
  
  
  
  echo "<br>";
  echo '<input type="SUBMIT" name="ACTION" value="View">';
  echo "<br>";


 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

     mysql_select_db('order_header');

//            AND oh.order_date between '$past_date' and '$today'
 $query = "SELECT cc.company, cc.name, oh.header_id, oh.order_nbr, oh.order_date
           FROM $tbl_order_header oh, $tbl_coop_contact cc
           WHERE oh.customer_key = cc.contact_id
           AND oh.status <> 'I'
           AND oh.order_date > '$past_date' 
           ORDER  BY oh.order_nbr DESC";
 # echo '<br>'.$query.'<br>';
   echo "<br>";
   $result = mysql_query($query, $db_conn);

   $row = mysql_fetch_array($result);
   $num_results = mysql_num_rows($result);


   echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
   
      echo '<tr bgcolor="cyan">';
   echo '<td>';
   echo '<B>Order Number</b>';
   echo '</td>';
   echo '<td>';
   echo '<B>Company</b>';
   echo '</td>';
      echo '<td>';
   echo '<B>Order Date </b>';
   echo '</td>';
   echo '</tr>';
   for ($i=0; $i <$num_results; $i++)
   {

   echo '<tr>';
   echo '<td>';
 #  echo $row['order_nbr'];
   echo "<font size=2 color=blue><a href='orderorder2.php?order_id=".$row['header_id']."'>".$row['order_nbr']."</font></a>";

   echo '</td>';
   echo '<td>';
   echo $row['company'];
   echo '</td>';
      echo '<td>';
   echo $row['order_date'];
#   echo "<font size=2 color=blue><a href='orderorder2.php?order_id=".$row['header_id']."'>".$row['order_date']."</font></a>";
   echo '</td>';
   echo '</tr>';
   
   $row = mysql_fetch_array($result);


  }
 echo '</table>';
 echo '<br>';







?>

</form>


</BODY>


</HTML>
