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

	echo'<html>';

	echo'<head>';
  	echo'<title>Green Report</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
	#echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';



       echo '<form enctype="multipart/form-data" method=POST action="test_upload.php"  method="post">';

	

      echo '<table width=100%><tr bgcolor=palegree><td>';
      echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
      echo '</td><td align=center>';
      echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';
        echo '<br>';
   
    echo ' <input type="hidden" name="MAX_FILE_SIZE" value="300000" />';
    echo ' <input name="userfile" type="file" />';
    echo ' <input type="submit" value="Upload Delivery Cupping Rpt." />';
    

 
        

// create short variable names
# this field will need to come from login screen.
  $company=$_SESSION['valid_user'];
  $current_id=$_REQUEST['current_id'];


# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }
//******************************Start Building the Report********************************
//*****************************Carry the Variable Names**********************************



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


    

 
# echo '<br>userfile = '.$_REQUEST['userfile'].' and name = '.$_FILES['userfile']['name'].'<br>';
# echo 'action is '.$_REQUEST['action'].'<br>';
 
 # $uploaddir = '../../pdf_files/';
   $uploaddir = '../../php_pdf/';
  $uploadfile = $uploaddir.$_FILES['userfile']['name'];
  
 # echo '<br> uploadfile is '.$uploadfile.'<br>';
 
if (ereg (".pdf$", $uploadfile, $regs)) {
   print "<pre>";
   if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
      print "File is valid, and was successfully uploaded. ";
      #  print "Here's some more debugging info:\n";
      # print_r($_FILES);
   } 
   elseif ($_FILES['userfile']['error'] != 4 ) {
      print "Possible file upload attack!  Here's some debugging info:\n";
      print_r($_FILES);
      echo "<br>";
      
      switch ($_FILES['userfile']['error']) {
   case UPLOAD_ERR_INI_SIZE:
       echo "The uploaded file exceeds the upload_max_filesize directive";
   break;
   case UPLOAD_ERR_FORM_SIZE:
        echo"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
   break;
   case UPLOAD_ERR_PARTIAL:
       echo"The uploaded file was only partially uploaded.";
   break;
   case UPLOAD_ERR_NO_FILE:
       echo"No file was uploaded.";
   break;
   case UPLOAD_ERR_NO_TMP_DIR:
       echo"Missing a temporary folder.";
   default:
       echo"An unknown file upload error occured";
}
      
      
   }
   print "</pre>";
} elseif( ! ereg ("pdf_files/$", $uploadfile, $regs)) {
   echo "<br>Invalid file type: $uploadfile <br>";
} 
 
 /*
 $uploaddir = '/var/www/uploads/';
$uploadfile = $uploaddir . $_FILES['userfile']['name'];

print "<pre>";
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
   print "File is valid, and was successfully uploaded. ";
   print "Here's some more debugging info:\n";
   print_r($_FILES);
} else {
   print "Possible file upload attack!  Here's some debugging info:\n";
   print_r($_FILES);
}
print "</pre>";



*/

	  echo '<font size=3 color=blue><Bold>Choose a Date Range</bold></font><br>';
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

	  echo '<br>';

	  echo '<br>';
	  echo '<input type="SUBMIT" name="ACTION" value="View">';




$from_date=$from_year.'-'.$from_month.'-'.$from_day;


$to_date=$to_year.'-'.$to_month.'-'.$to_day;


$remaining= $initial_quantity + $transfer_in - $transfer_out - $quantity_total;
echo '<br>';
echo '<font size=5 color=blue><center>Cupping Report (Pre-ship and Delivered) </center></font><br>';
echo '<font size=3 color=blue>Date Range: </font>'.$from_date.'<font size=3 color=blue> to </font>'.$to_date.'<br><br>';
 
   $query = "SELECT id.item_code,   ci.lot_ship, id.weight as bag_lbs,
          ci.item_description, ci.quantity as initial_quantity,
          ci.transfer_in, ci.transfer_out, id.item_code, ci.green_cb,
           ci.ship_date, ci.mark,ci.warehouse, ci.ft_item, ci.org_item, ci.contract_date,
           ci.sample_approved, ci.ship_date, ci.fda_confirm, 
          ci.STATUS, ci.spot_available, ci.green_comment, ci.arrival_date, ci.lot_ship
          FROM $tbl_item_description id,  $tbl_coop_item ci
          WHERE id.item_code = ci.item_code
          AND ci.green_cb = 1
          AND ci.ship_date Between \"$from_date\" and \"$to_date\"
	      ORDER by ci.warehouse, ci.item_code, ci.lot_ship desc ";

#           and ci.warehouse = 'C'	and ci.warehouse <> 'N'      

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
#echo 'records = '.$num_results.'<br>';
echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";

echo '<tr bgcolor=palegreen>';
echo '<th align=center><font size=2 color=blue>Item</font></th>';
echo '<th align=center><font size=2 color=blue>Lot Ship</font></th>';
echo '<th align=center><font size=2 color=blue>Description</font></th>';
echo '<th align=center><font size=2 color=blue>PreShip Cupping Rpt.</font></th>';
echo '<th align=center bgcolor=palegreen><font size=2 color=blue>&nbsp;</font></th>';
echo '<th align=center><font size=2 color=blue>Delivery Date</font></th>';
echo '<th align=center><font size=2 color=blue>Delivered Cupping Rpt</font></th>';

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
      else if ($row['warehouse'] == 'T') {
      	$warehouse_text = 'Toronto';
      } 
       else if ($row['warehouse'] == 'E') {
      	$warehouse_text = 'Enroute';
      }  
       else if ($row['warehouse'] == 'C') {
      	$warehouse_text = 'Contracted';
      }          
      else {    
     	$warehouse_text = $row['warehouse'];
      } 	 	
       	
      echo '<td colspan=10><font size=2 color=blue>Warehouse : '.$warehouse_text.'</font></td>';
      echo '</tr>';   	
      $prev_warehouse = $row['warehouse'];	
   } 	
   
   

 
 

   echo '<tr><td>&nbsp;'.$row['item_code'].'</td>';
   echo '<td align=center>&nbsp;'.$row['lot_ship'].'</td>';
   echo '<td>&nbsp;'.$row['item_description'];
   echo '</td>';
   
      echo '<td>&nbsp;';
   $filename = '../../pdf_files_p/'.$row['item_code'].$row['lot_ship'].'P.pdf';
 
   if (file_exists($filename)) {
      $link = '<A HREF="'.$filename.'" target="report">'.'Cup Rpt'.'</A>';
   } else {
      $link = 'N/A';
   }
   echo $link;
   echo '</td>';
   echo '<td  bgcolor=palegreen>&nbsp;</td>';     
   echo '<td>&nbsp;'.$row['arrival_date'].'</td>';
   



   echo '<td>&nbsp;';
   $filename = '../../pdf_files/'.$row['item_code'].$row['lot_ship'].'.pdf';
 
   if (file_exists($filename)) {
      $link = '<A HREF="'.$filename.'" target="report">'.'Cup Rpt'.'</A>';
   } else {
      $link = 'N/A';
   }
   echo $link;
   echo '</td>';

   echo '</tr>';

  

}

echo '</table>';
#}

echo '</form>';


?>