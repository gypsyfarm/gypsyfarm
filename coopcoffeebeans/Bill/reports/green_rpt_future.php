<?php
require("../../functions.php");
require("../../tables.php");
// check security
 session_start();
// check session variable

  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
  }

// local functions go here

function connect_to_db() {
    # set up connection string to database.
    global $db_conn; 
    $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
    mysql_select_db('cbeans', $db_conn);

    if (!$db_conn) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
    }
  
}

function uploadcode(){ 
   
    echo ' <input type="hidden" name="MAX_FILE_SIZE" value="400000" />';
    echo ' <input name="userfile" type="file" /><br>';
    echo ' <input type="submit" value="Upload PreShip Cupping Rpt" /><br>File name: LOT + Item nbr  + P example GUL101P.pdf';
    
    $uploaddir = '../../pdf_files_p/';
    $uploadfile = $uploaddir.$_FILES['userfile']['name'];
  
    if (ereg (".pdf$", $uploadfile, $regs)) {
       if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
          print "File is valid, and was successfully uploaded. ";
          if (! chmod($uploadfile, 0544)) {
          echo  ("<br>Unable to change file permissions");
           }
         # print_r($_FILES);
       } 
    elseif ($_FILES['userfile']['error'] != 4 ) {
      print "Possible file upload attack!  Here's some debugging info:\n";
      print_r($_FILES);
    }
    } 
    elseif( ! ereg ("pdf_files_p/$", $uploadfile, $regs)) {
       echo "<br>Invalid file type: $uploadfile <br>";
    }     
    
}


	echo'<html>';

	echo'<head>';
  	echo'<title>Future Green Report</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo '<link REL="stylesheet" TYPE="text/css" media="print" HREF="printonly.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
	#echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';



       echo '<form enctype="multipart/form-data" method=POST action="green_rpt_future.php"  method="post">';

	

      echo '<table class="noprint" width=100%><tr bgcolor=palegree><td>';
      echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
      echo '</td><td align=center>';
      echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';
        echo '<br>';
   
 
        

// create short variable names
# this field will need to come from login screen.
  $company=$_SESSION['valid_user'];
  $current_id=$_REQUEST['current_id'];


connect_to_db();

//******************************Start Building the Report********************************
//*****************************Carry the Variable Names**********************************

// hey hey might not need these ......
#echo "<br>sort1 = ".$_REQUEST['sort1']."<br>";
$sort1 = $_REQUEST['sort1'];
$lot_srt = '';
$del_dt = '';
$ship_dt = '';
if ($sort1 == 'del_dt') {
	$del_dt = 'checked';
}
elseif  ($sort1 == 'ship_dt'){
	$ship_dt = 'checked';
}
else {
	$lot_srt = 'checked';
}

$warehouse=$_REQUEST['warehouse'];
$item=$_REQUEST['new_product'];
$lot=$_REQUEST['lot'];

if ($_REQUEST['To_Year'] == '') {
    $_REQUEST['To_Year']=$green_to_year;
  }

if ($_REQUEST['From_Year'] == '') {
    $_REQUEST['From_Year']=$green_from_year;
  }
if ($_REQUEST['To_Day'] == '') {
    $_REQUEST['To_Day']=31;
  }
if ($_REQUEST['From_Day'] == '') {
    $_REQUEST['From_Day']=01;
  }
  
if ($_REQUEST['To_Month'] == '') {
    $_REQUEST['To_Month']=12;
  }
if ($_REQUEST['From_Month'] == '') {
    $_REQUEST['From_Month']=01;
  }


echo '<table border=0 width=100%>' ;
#echo '<tr class="noprint"><td colspan="2"><font size=3 color=blue><Bold>Choose a Date Range</bold></font></td></tr>';
echo '<tr class="noprint">';
echo '<td>From ';

$from_month=$_REQUEST['From_Month'];
from_monthdropdown($from_month);

echo 'Day: ';

$from_day=$_REQUEST['From_Day'];
from_daydropdown($from_day);

echo 'Year: ';

$from_year=$_REQUEST['From_Year'];
from_yeardropdown($from_year);


echo ' &nbsp;&nbsp;&nbsp;To: ';
#echo 'Ending Month: ';
 

	  
	 
if (isset($_SESSION['To_Month'])){
   $to_month=$_REQUEST['To_Month']; }
else {
   $to_month = 12;
}      

to_monthdropdown($to_month);

echo 'Day: ';

$to_day=$_REQUEST['To_Day'];
to_daydropdown($to_day);

echo 'Year: ';

$to_year=$_REQUEST['To_Year'];
to_yeardropdown($to_year);
echo '&nbsp;&nbsp;<span class="noprint"><input type="SUBMIT" name="ACTION" value="Refresh Report"></span>';
echo '</td><td align="center">';
echo '<span class="noprint">';
uploadcode();  
echo '</span>';
echo '</td></tr>';

echo '<tr class="noprint"><td colspan="2">';
 
echo 'View the <a href="green_rpt_contracted.php">Contracted Green </a> and the <a href="green_rpt.php">Green Report</a> for more green coffee deliveries info.';
echo '</td></tr></table><p>';
echo '<center>';




$from_date=$from_year.'-'.$from_month.'-'.$from_day;


$to_date=$to_year.'-'.$to_month.'-'.$to_day;


$remaining= $initial_quantity + $transfer_in - $transfer_out - $quantity_total;
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo '</span><span><font size=5 color=blue>Future Green Report by Warehouse / Product Code </font></span><span"><br>';
echo '<font size=3 color=blue>Date Range: </font></span>'.$from_date.'<font size=3 color=blue> to </font>'.$to_date.'</center><br> ';
 
 if ($sort1 == 'del_dt') {
	$sort_method = 'ORDER by  ci.arrival_date desc, ci.item_code, ci.lot_ship  ';
}
elseif  ($sort1 == 'ship_dt'){
	$sort_method = 'ORDER by  ci.ship_date desc, ci.item_code, ci.lot_ship  ';
}
else {
	$sort_method = 'ORDER by  ci.item_code, ci.lot_ship';
}
 
 
   $query = "SELECT id.item_code,   ci.lot_ship, id.weight as bag_lbs,
          ci.item_description, ci.quantity as initial_quantity,
          ci.transfer_in, ci.transfer_out, id.item_code, ci.green_cb,
           ci.ship_date, ci.mark,ci.warehouse, ci.ft_item, ci.org_item, ci.contract_date,
           ci.sample_approved, ci.ship_date, ci.fda_confirm, 
          ci.STATUS, ci.spot_available, ci.green_comment, ci.arrival_date, ci.lot_ship
          FROM $tbl_item_description id,  $tbl_coop_item ci
          WHERE id.item_code = ci.item_code
          AND ci.green_cb = 1
          AND ci.item_active != 1 
           AND ci.ship_date Between \"$from_date\" and \"$to_date\"
           and ci.warehouse = 'F'
	      $sort_method ";
	      

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
# echo 'records = '.$num_results.'<br>';
echo  " \n ";

echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";
 
echo '<tr bgcolor=palegreen>';
echo '<th align=center><font size=2 color=blue>Item</font></th>';
echo  " \n "; 
echo "<th align=center><font size=2 color=blue>Lot Ship</font><span class='noprint'><input type='radio' name='sort1' $lot_srt value='lot_srt'></span></th>";
echo  " \n ";
echo '<th align=center><font size=2 color=blue>Description</font></th>';
echo  " \n ";
echo '<th align=center><font size=2 color=blue>Quantity</font></th>';
echo  " \n ";
echo '<th align=center bgcolor=palegreen><font size=2 color=blue>&nbsp;</font></th>';
echo  " \n ";
echo "<th align=center><font size=2 color=blue>Delivery Date</font><span class='noprint'><input type='radio' name='sort1' $del_dt value='del_dt'></span></th>";
echo  " \n ";
echo '<th align=center><font size=2 color=blue>Contract Date</font></th>';
echo  " \n ";
echo '<th align=center><font size=2 color=blue>Sample Approved</font></th>';
echo "<th align=center><font size=2 color=blue>Est. Shipping Dt.</font><span class='noprint'><input type='radio' name='sort1' $ship_dt value='ship_dt'></span></th>";
echo '<th align=center><font size=2 color=blue>Cupping Report</font></th>';


echo '</tr>';
$quantity_total=0;
$weight_total=0;

$prev_warehouse ='';
for ($i=0; $i <$num_results;  $i++) {
   $row = mysql_fetch_array($result);
   
   
   if ($row['warehouse'] != $prev_warehouse) {
      echo '<tr bgcolor=palegreen>';
      if ($row['warehouse'] == 'C') {
      	$warehouse_text = 'Contracted';
      }        
      else {    
     	$warehouse_text = $row['warehouse'];
      } 	 	
       	
      echo '<td colspan=10><font size=2 color=blue>Warehouse : '.$warehouse_text.'</font></td>';
      echo '</tr>';   	
      $prev_warehouse = $row['warehouse'];	
   } 	
   
   

 
 
echo  " \n ";
   echo '<tr><td>&nbsp;'.$row['item_code'].'</td>';
   echo '<td align=center>&nbsp;'.$row['lot_ship'].'</td>';
   echo '<td>&nbsp;'.$row['item_description'];
   if ($row['green_comment']) {
   	echo '<br>';
   	echo '<font color=green>'.$row['green_comment'].'</font>';
  } 	
   echo '</td>';
   echo '<td>&nbsp;'.$row['initial_quantity'].'</td>';   
      echo '<td  bgcolor=palegreen>&nbsp;</td>';     
   echo '<td>&nbsp;'.$row['arrival_date'].'</td>';
   echo '<td>&nbsp;'.$row['contract_date'].'</td>';
   echo '<td>&nbsp;'.$row['sample_approved'].'</td>';
   echo '<td>&nbsp;'.$row['ship_date'].'</td>';
   echo '<td>&nbsp;';
   $filename = '../../pdf_files/'.$row['item_code'].$row['lot_ship'].'.pdf';

 
if (file_exists($filename)) {
   $link = '<A HREF="'.$filename.'" target="report">'.'Cup Rpt'.'</A>';
} 
else {
   $filename = '../../pdf_files_p/'.$row['item_code'].$row['lot_ship'].'P.pdf';
   if (file_exists($filename)) {
       $link = '<A HREF="'.$filename.'" target="report">'.'Cup Rpt'.'</A>'; 
   }
   else {
      $link = 'N/A';
   }

}
   echo $link;
   
   echo '</td>';


   echo '</tr>';

#   If ( $row['green_comment'] != "" ) {
#   echo '<tr><td colspan=2>&nbsp;</td>';
#   echo '<td colspan=8>';
#   echo '&nbsp;'.$row['green_comment'];
#   echo '</td></tr>';
#   }
   

}
echo  " \n ";
echo '</table>';
#}

echo '</body></html></form>';


?>