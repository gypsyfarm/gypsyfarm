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
          print "<br>File is valid, and was successfully uploaded. ";

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

echo '<head>';
echo '<title>Green Report</title>';
echo '<style type="text/css" media="screen">';
echo  '#shiftright {';
echo '	float: right;';
echo 'width: 40%;';
echo '	}';
echo  '#clearboth {';
echo '	clear: both;';
echo 'width: 100%;';
echo '	}';
echo '</style>';


echo '<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
echo '<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
echo '<link REL="stylesheet" TYPE="text/css" media="print" HREF="printonly.css">';
echo '</head>';

echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';

// This is the top level menu: 
echo '<table class="noprint" width=100%><tr bgcolor=palegree><td>';
echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
echo '</td><td align=center>';
echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
echo '</td><td align=center>';
echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
echo '</td></tr></table>';


echo '<form enctype="multipart/form-data" method=POST action="green_rpt.php"  method="post">';



// create short variable names
# this field will need to come from login screen.
$company=$_SESSION['valid_user'];
$current_id=$_REQUEST['current_id'];

connect_to_db();

//******************************Start Building the Report********************************
//*****************************Carry the Variable Names**********************************

// hey hey might not need these ......
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
#echo '<tr><td colspan="2"><font size=3 color=blue><Bold>Choose a Date Range</bold></font></td></tr>';
echo '<tr>';
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

 
echo 'View the <a href="green_rpt_contracted.php">Contracted Green </a> and the 
      <a href="green_rpt_future.php">Future Green </a> reports for more green coffee deliveries info.';
echo '</td></tr></table><p>';
echo '<center>';

$from_date=$from_year.'-'.$from_month.'-'.$from_day;

$to_date=$to_year.'-'.$to_month.'-'.$to_day;

$remaining= $initial_quantity + $transfer_in - $transfer_out - $quantity_total;
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<font size=4 color=blue>Green Report by Warehouse / Product Code </font>&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<font size=3 color=blue>Date Range: </font>'.$from_date.'<font size=3 color=blue> to </font>'.$to_date.'</center><br> ';
 
$query = "SELECT id.item_code,   ci.lot_ship, id.weight as bag_lbs, id.on_allocation, 
          ci.item_description, ci.quantity as initial_quantity,
          ci.transfer_in, ci.transfer_out, id.item_code, ci.green_cb,
           ci.ship_date, ci.mark,ci.warehouse, ci.ft_item, ci.org_item, 
          ci.STATUS, ci.spot_available, ci.green_comment, ci.arrival_date, ci.lot_ship
          FROM $tbl_item_description id,  $tbl_coop_item ci
          WHERE id.item_code = ci.item_code
          AND ci.green_cb = 1
          AND ci.item_active != 1 
           AND ci.ship_date Between '$from_date' and '$to_date'
           and ci.warehouse in ('N','T','S','V','E','J','H','A')
	      ORDER by ci.warehouse, ci.item_code, ci.item_id, ci.lot_ship ";
	      
# echo '<br>'.$query.'<br>';
 
 /*
$filename = 'pdf_files/GUA31.pdf';
echo '<br> ok check if file exists';
if (file_exists($filename)) {
   echo "The file $filename exists<br>";
} else {
   echo "The file $filename does not exist<br>";
}
echo 'ok check over';
 */
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
#echo 'records = '.$num_results.'<br>';
echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";

echo '<tr bgcolor=palegreen>';
echo '<th align=center><font size=2 color=blue>Item</font></th>';
echo '<th align=center><font size=2 color=blue>Lot Ship</font></th>';
echo '<th align=center><font size=2 color=blue>Description</font></th>';
echo '<th align=center><font size=2 color=blue>Inventory</font></th>';
echo '<th align=center><font size=2 color=blue>Mark</font></th>';
echo '<th align=center><font size=2 color=blue>Purchase</font></th>';
echo '<th align=center><font size=2 color=blue>Ship Date</font></th>';
echo '<th align=center><font size=2 color=blue>Arrival</font></th>';
echo '<th align=center><font size=2 color=blue>Status</font></th>';
echo '<th align=center><font size=2 color=blue>Cup Rpt</font></th>';
echo '<th align=center><font size=2 color=blue>Spot</font></th>';
echo '<th align=center><font size=2 color=blue>Ft</font></th>';
echo '<th align=center><font size=2 color=blue>Org</font></th>';
echo '</tr>';
$quantity_total=0;
$weight_total=0;

$prev_warehouse ='';
for ($i=0; $i <$num_results;  $i++) {
   $row = mysql_fetch_array($result);
   
   
   if ($row['warehouse'] != $prev_warehouse) {
      echo '<tr bgcolor=palegreen>';
      if ($row['warehouse'] == 'N') {
      	$warehouse_text = 'New Orleans';
      }
      else if ($row['warehouse'] == 'H') {
      	$warehouse_text = 'Hill Side, New Jersey';
      }  
      else if ($row['warehouse'] == 'J') {
      	$warehouse_text = 'Kearney, New Jersey';
      }      
      else if ($row['warehouse'] == 'T') {
      	$warehouse_text = 'Toronto';
      } 
       else if ($row['warehouse'] == 'E') {
      	$warehouse_text = 'Enroute';
      }   
      else if ($row['warehouse'] == 'S') {
      	$warehouse_text = 'San Leandro, CA';
      }       
      else {    
     	$warehouse_text = $row['Warehouse'];
      } 	 	
       	
      echo '<td colspan=3><font size=2 color=blue>Warehouse : '.$warehouse_text.'</font></td>';
      
    #  echo '<td colspan=1 bgcolor="#FFFF66">Short</td>';
      
      if ($row['warehouse'] == 'E') {
           echo '<td colspan=1 bgcolor="#FFFF66">Short</td>';
        } else {
            echo '<td colspan=1>&nbsp;</td>';
        }
        
        
      echo '</tr>';   	
      $prev_warehouse = $row['warehouse'];	
   } 	
   
   

 
   echo '<tr>';
 
   echo '<td>&nbsp;'.$row['item_code'].'</td>';
   echo '<td align=center>&nbsp;'.$row['lot_ship'].'</td>';
   echo '<td>&nbsp;'.$row['item_description'].'</td>';
   
   
      if ($row['on_allocation'] == 1) {
   	echo '<td bgcolor=#FFFF66>';
} else {
   echo '<td>';
}
   
      echo '&nbsp;';
        echo remaining_inventory($row['item_code'],$row['lot_ship'],$row['warehouse']);
     #   echo " $global_sales ";
      echo '</td>';
   
   echo '<td>&nbsp;'.$row['mark'].'</td>';
   echo '<td>&nbsp;'.$row['initial_quantity'].'</td>';   
   echo '<td>&nbsp;'.$row['ship_date'].'</td>';
   echo '<td>&nbsp;'.$row['arrival_date'].'</td>';
   echo '<td>&nbsp;'.$row['STATUS'].'</td>';
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
   echo '<td align=center>&nbsp;';
   if ($row['spot_available'] == 'Yes') {
   	 echo 'Y';
   }
   else {
   	echo 'N';
   }	   	
   echo '</td>';
   echo '<td align=center>';
   if ($row['ft_item'] == 1) {
    	echo 'Y';
   }
   else {
   	echo 'N';
   }	
   	
   echo '</td>';
   echo '<td align=center>';
   if ($row['org_item'] == 1) {
 	echo 'Y';
   }
   else {
   	echo 'N';
   }
   echo '</td>';
   echo '</tr>';

   If ( $row['green_comment'] != "" ) {
   echo '<tr><td colspan=2>&nbsp;</td>';
   echo '<td colspan=11>';
   echo '&nbsp;'.$row['green_comment'];
   echo '</td></tr>';
   }
   

}

echo '</table>';
#}

echo '</form>';


?>