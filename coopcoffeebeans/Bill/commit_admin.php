<?php

require("../tables.php");
require("../functions.php");
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
  	echo'<title>Commitments Administration</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';


      echo '<table width=100%><tr bgcolor=palegree><td>';
      echo '<font size=3><a href="../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="reports/index.php">Report Menu</a></font>';
      echo '</td><td align=center>';
      echo '<font size=3><a href="../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';


// create short variable names
# this field will need to come from login screen.

//The command below tells if magic quotes is on or off a returned value of 1 means on a 0 means off
//if magic quotes is on, all characters that need escaping post variables automatically get escaped.
//The trick is to strip slashes after the post variable is assigned to a regular variable
//ideally this would be done dynamically but for now

//echo get_magic_quotes_gpc();

$company=$_REQUEST['Company_Name'];
$company=stripslashes($company);
//echo'The company name is '.$company;


$current_id=$_REQUEST['current_id'];
 $remain_percent = 0.0;
 $remaining = 0.0;
 $total = 0.0;

# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }



?>

<script language="Javascript"> 
<!-- 
function open_window(url) {
 	notes = window.open(url,"notes","toolbar=1,location=1,directories=0,status=1,menubar=1,scrollbars=1,resizable=1,width=420,height=150,screenX=350,screenY=100");
//	alert("made it here");   
} 


 


  -->
 
</script>

<?

      echo '<form method=POST action=commit_admin.php>';

# was here
#  far right cell 


      echo '<table width=100%><tr><td>';
      echo 'Choose a New Mode!<br>';
	  echo '<input type="SUBMIT" name="ACTION" value="EDIT">';

	  echo '</td><td>';
	  echo '<input type="SUBMIT" name="ACTION" value="ADD">';
  echo '</td></tr></table>';
  
	  

    

if (!isset($_REQUEST['ACTION'])) {
	$action = "EDIT";
}
else {	
	$action = $_REQUEST['ACTION'];
}
 
#  echo '<br> action is :'.$action.'<br>'; 	 

if ($action  == 'ADD'){
	echo '<font size=3 color=blue>You are currently in ADD Mode';
	}
if ($action  == 'EDIT'){
	echo '<font size=3 color=blue>You are currently in EDIT Mode';
	}
	echo ' ';


	

	
	
   
 
if (($action == 'ADD_Record') or ($action == 'ADD')){
      echo '<font size=3 color=blue>Select company, year range and item code</font><br>';

     echo 'Company Name: ';
	  customerdropdown($company);


//*************Build Date Drop Down******************************************
//**Adding dates to dropdown here must add dates to if statements below******
if (!isset($_REQUEST['year_range'])) {
    $_REQUEST['year_range']= $current_year;

}
$import_yr=$_REQUEST['year_range'];
 



echo '<br><font size=3 color=blue>Select a date range</font>';


#$year_list_extended = array("2003","2004","2005","2006","2007","2008","2009","2010"); 
$date_range = $year_list_extended;
$nbr_in_array = count($date_range);
echo "<br> import year is $import_yr  <br>";
echo "\n";
echo '<select name=year_range>';
echo "\n";
for ($i=0; $i < $nbr_in_array;  $i++)
  {
    echo "<option value=$date_range[$i] ";
    if ($import_yr == $date_range[$i]) {
       echo ' selected ';
    }

    echo "> $date_range[$i]";

    echo "\n";
  }

 echo '</select><br>';



	  echo 'Item code: ';
	  newitemdropdown();
	  echo '<br>';
	  echo '<br>';

	  echo '<font size=3 color=blue>Enter the commitments for the product code</font><br>';
          echo '<input type="SUBMIT" name="ACTION" value="ADD_Record">';
	  echo " <TABLE cellSpacing=0 cellPadding=0 width='100' border=1>";
	  echo '<tr><td>Roll over:</td><td><input size=2 type=text name=py></td><tr>';
	  echo '<tr><td>Jan:</td><td><input size=2 type=text name=month01></td></tr>';
	  echo '<tr><td>Feb:</td><td><input size=2 type=text name=month02></td></tr>';
	  echo '<tr><td>Mar:</td><td><input size=2 type=text name=month03></td></tr>';
	  echo '<tr><td>Apr:</td><td><input size=2 type=text name=month04></td></tr>';
	  echo '<tr><td>May:</td><td><input size=2 type=text name=month05></td></tr>';
	  echo '<tr><td>Jun:</td><td><input size=2 type=text name=month06></td></tr>';
	  echo '<tr><td>Jul:</td><td><input size=2 type=text name=month07></td></tr>';
	  echo '<tr><td>Aug:</td><td><input size=2 type=text name=month08></td></tr>';
	  echo '<tr><td>Sep:</td><td><input size=2 type=text name=month09></td></tr>';
	  echo '<tr><td>Oct:</td><td><input size=2 type=text name=month10></td></tr>';
	  echo '<tr><td>Nov:</td><td><input size=2 type=text name=month11></td></tr>';
	  echo '<tr><td>Dec:</td><td><input size=2 type=text name=month12></td></tr>';
	  echo '</table>';


	#  echo '<br><font size=3 color=blue>Click the button to add the record</font><br>';
# add was here alone...

}

 


if ($action == 'Edit_Record') {


#echo "<br>Ok in Edit record<br>";
#begin test  $_POST
  $test_array = $_POST['editbox'];
  if (isset($test_array)) {
       $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
       mysql_select_db('cbeans', $db_conn);
       if (!$db_conn)  {
           echo 'Error: Could not connect to database.  Please try again later.';
         #  exit;
        }
     foreach($_POST['editbox'] as $ID) {
        # echo ("<p>Value: $ID<br><p>\n");  
        $py=$_REQUEST['py'.$ID];
        $month01=$_REQUEST['month01'.$ID];
        $month02=$_REQUEST['month02'.$ID];
        $month03=$_REQUEST['month03'.$ID];
        $month04=$_REQUEST['month04'.$ID];
        $month05=$_REQUEST['month05'.$ID];
        $month06=$_REQUEST['month06'.$ID];
        $month07=$_REQUEST['month07'.$ID];
        $month08=$_REQUEST['month08'.$ID];
        $month09=$_REQUEST['month09'.$ID];
        $month10=$_REQUEST['month10'.$ID];
        $month11=$_REQUEST['month11'.$ID];
        $month12=$_REQUEST['month12'.$ID];
        
       # mysql_select_db($tbl_coop_commited);
       $query = 'Update '.$tbl_coop_commited.' set py="'.$py.'", month01="'.$month01.'", month02="'.$month02.'", month03="'.$month03.'",month04="'.$month04.'",month05="'.$month05.'",month06="'.$month06.'", month07="'.$month07.'",month08="'.$month08.'",month09="'.$month09.'", month10="'.$month10.'", month11="'.$month11.'", month12="'.$month12.'" where commited_id="'.$ID.'"';
      # echo "<br>$query <br>";
       $result = mysql_query($query, $db_conn);        
     }
 }	
#end test



}


if ($action == 'ADD_Record') {
    $company=$_REQUEST['Company_Name'];
    $company=stripslashes($company);
    $year_range=$_REQUEST['year_range'];
    $item_code=$_REQUEST['new_product'];
    $py=$_REQUEST['py'];
    $month01=$_REQUEST['month01'];
    $month02=$_REQUEST['month02'];
    $month03=$_REQUEST['month03'];
    $month04=$_REQUEST['month04'];
    $month05=$_REQUEST['month05'];
    $month06=$_REQUEST['month06'];
    $month07=$_REQUEST['month07'];
    $month08=$_REQUEST['month08'];
    $month09=$_REQUEST['month09'];
    $month10=$_REQUEST['month10'];
    $month11=$_REQUEST['month11'];
    $month12=$_REQUEST['month12'];



    mysql_select_db($tbl_coop_contact);
    $company=addslashes($company);
    $query = "select contact_id from $tbl_coop_contact where Company = '".$company."'";
    

    $result = mysql_query($query, $db_conn);
    $num_results = mysql_num_rows($result);
    $row = mysql_fetch_array($result);
    $company=stripslashes($company);
    $customer_key=$row['contact_id'];


    mysql_select_db($tbl_coop_commited);
    $query = "INSERT INTO $tbl_coop_commited ( commited_id, customer_key, import_yr, item_code, py, month01, month02, month03, month04, month05, month06, month07, month08, month09, month10, month11, month12 ) VALUES (NULL, '".$customer_key."', '".$year_range."', '".$item_code."', '".$py."', '".$month01."', '".$month02."', '".$month03."', '".$month04."', '".$month05."', '".$month06."', '".$month07."', '".$month08."', '".$month09."', '".$month10."', '".$month11."', '".$month12."')";
    
    $result = mysql_query($query, $db_conn);
    
}

if (($action == 'EDIT') or ($action == 'View_Report') or ($action == 'Delete_Record') or ($action == 'Edit_Record'))
{

$company=$_REQUEST['Company_Name'];
$company=stripslashes($company);
      echo '<font size=3 color=blue>Select company, year range, and product code</font><br>';

      echo 'Company Name: ';
	  customerdropdown($company);


//*************Build Date Drop Down******************************************
//**Adding dates to dropdown here must add dates to if statements below******
if (!isset($_REQUEST['year_range'])) {
$_REQUEST['year_range']= $current_year;

}
$import_yr=$_REQUEST['year_range'];

echo '<br><font size=3 color=blue>Select a date range</font>';
 

#$year_list_extended = array("2003","2004","2005","2006","2007","2008","2009","2010"); 
$date_range = $year_list_extended;
$nbr_in_array = count($date_range);

echo "\n";
echo '<select name=year_range>';
echo "\n";
for ($i=0; $i < $nbr_in_array;  $i++)
  {
    echo "<option value=$date_range[$i] ";
    if ($import_yr == $date_range[$i]) {
       echo ' selected ';
    }

    echo "> $date_range[$i]";

    echo "\n";
  }

 echo '</select><br>';




	  echo '<input type="SUBMIT" name="ACTION" value="View_Report">';

}
if ($action == 'Delete_Record'){
	
 
  $test_array = $_POST['editbox'];
  if (isset($test_array)) {
       $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
       mysql_select_db('cbeans', $db_conn);
       if (!$db_conn)  {
           echo 'Error: Could not connect to database.  Please try again later.';
         #  exit;
        }
     foreach($_POST['editbox'] as $ID) {
        echo '<br>You have Deleted Record# '.$ID.' from the Dataset';  
        $query = "Delete from $tbl_coop_commited where commited_id = '$ID' ";
        $result = mysql_query($query, $db_conn);
      }	
  }

}



if (($action == 'View_Report') or ($action == 'Delete_Record') or ($action == 'Edit_Record')){

$company=$_REQUEST['Company_Name'];
$company=stripslashes($company);
// echo '<input type=hidden name=Save_Company_Name value="'.$company.'">';

//*********This if statement reselects the previous table if there was a delete********
//******************So you can see the result of your delete***************************

// if (($action == 'Delete_Record') or ($action == 'Edit_Record'))
// {
// $company=$_REQUEST['Save_Company_Name'];
// echo '<input type=hidden name=Save_Company_Name value="'.$company.'">';
// }
//**************************************************************************************
 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
 $year_range=$_REQUEST['year_range'];

mysql_select_db($tbl_coop_contact);

$company=addslashes($company);
$query = "select * from $tbl_coop_contact where Company = '$company'";

#echo "<br> $query <br>";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$company=stripslashes($company);
$customer_key=$row['contact_id'];

//echo $customer_key;

//**************************Assign ranges to date for searching*********************

$from_date = $year_range.'-01-01';
$to_date = $year_range.'-12-31';


mysql_select_db($tbl_coop_commited);
$query = "select * from $tbl_coop_commited 
                  where customer_key = '$customer_key' 
                  and import_yr = '$year_range'
                  order by item_code";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);


if (!isset($customer_key)) {
	$customer_key = 0;
}
# begin new code:
$query = "SELECT o.customer_key, i.header_key, c.item_code, i.item_code as show_code, o.order_date, 
                 id.item_description, l.quantity, i.header_key 
            FROM ($tbl_order_header o, $tbl_order_item i, $tbl_lot_item l, $tbl_item_description id) 
            LEFT  JOIN $tbl_coop_commited c 
              ON c.customer_key = o.customer_key 
             AND c.item_code = i.item_code 
             AND import_yr =  '$year_range' 
           WHERE i.header_key = o.header_id 
             AND l.header_id = o.header_id
             AND l.item_id = i.item_id
             AND o.order_date  Between '$from_date' and '$to_date'
             AND c.item_code IS  NULL  
             AND l.quantity > 0
             and i.item_code = id.item_code
             AND o.customer_key = $customer_key ";

$result2 = mysql_query($query, $db_conn);

$num_result2 = mysql_num_rows($result2);

# echo "<br>$query <br>";
# echo "and we got $num_result2 records back";

     
 


# end new code:



echo "<br><br><font size=3 color=blue>Now viewing commitments for, $company for the years, $year_range<br>";

echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=0>";
echo "<tr><td align=left>";
   echo '<input type="SUBMIT" name="ACTION" value="Delete_Record">';
   echo "</td><td align=right>";
  echo '<input type="SUBMIT" name="ACTION" value="Edit_Record">';
  echo "</td></tr></table>";


echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
//echo '<tr><th align=center><font size=2 color=blue>Description</font></th>';
echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Item</font></th>';
echo '<th align=center><font size=2 color=blue>Commit</font></th>';
echo '<th align=center><font size=2 color=blue>Used</font></th>';
echo '<th align=center><font size=2 color=blue>Remain</font></th>';

echo '<th align=center><font size=2 color=blue>PY</font></th>';
echo '<th align=center><font size=2 color=blue>Jan</font></th>';
echo '<th align=center><font size=2 color=blue>Feb</font></th>';
echo '<th align=center><font size=2 color=blue>Mar</font></th>';
echo '<th align=center><font size=2 color=blue>Apr</font></th>';
echo '<th align=center><font size=2 color=blue>May</font></th>';
echo '<th align=center><font size=2 color=blue>Jun</font></th>';
echo '<th align=center><font size=2 color=blue>Jul</font></th>';
echo '<th align=center><font size=2 color=blue>Aug</font></th>';
echo '<th align=center><font size=2 color=blue>Sep</font></th>';
echo '<th align=center><font size=2 color=blue>Oct</font></th>';
echo '<th align=center><font size=2 color=blue>Nov</font></th>';
echo '<th align=center><font size=2 color=blue>Dec</font></th>';
echo '<th align=center><font size=2 color=blue>Select</font></th></tr>';
$month01_total=0;
$month02_total=0;
$month03_total=0;
$month04_total=0;
$month05_total=0;
$month06_total=0;
$month07_total=0;
$month08_total=0;
$month09_total=0;
$month10_total=0;
$month11_total=0;
$month12_total=0;

$item_quantity=0;

$total_total=0;
$remaining=0;
$reamining_total=0;
$py_total=0;


for ($i=0; $i <$num_results;  $i++)
  {
  	
  	if ($i==13) {
  	    echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Item</font></th>';
            echo '<th align=center><font size=2 color=blue>Commit</font></th>';
            echo '<th align=center><font size=2 color=blue>Used</font></th>';
            echo '<th align=center><font size=2 color=blue>Remain</font></th>';
            
            echo '<th align=center><font size=2 color=blue>PY</font></th>';
            echo '<th align=center><font size=2 color=blue>Jan</font></th>';
            echo '<th align=center><font size=2 color=blue>Feb</font></th>';
            echo '<th align=center><font size=2 color=blue>Mar</font></th>';
            echo '<th align=center><font size=2 color=blue>Apr</font></th>';
            echo '<th align=center><font size=2 color=blue>May</font></th>';
            echo '<th align=center><font size=2 color=blue>Jun</font></th>';
            echo '<th align=center><font size=2 color=blue>Jul</font></th>';
            echo '<th align=center><font size=2 color=blue>Aug</font></th>';
            echo '<th align=center><font size=2 color=blue>Sep</font></th>';
            echo '<th align=center><font size=2 color=blue>Oct</font></th>';
            echo '<th align=center><font size=2 color=blue>Nov</font></th>';
            echo '<th align=center><font size=2 color=blue>Dec</font></th>';
            echo '<th align=center><font size=2 color=blue>Select</font></th></tr>';
        }
  	    
  	
  	
  	
  	
  	
  $row = mysql_fetch_array($result);
  $total = $row['month01'] + $row['month02'] + $row['month03'] + $row['month04'] +$row['month05'] +$row['month06'] +$row['month07'] +$row['month08'] + $row['month09'] + $row['month10'] + $row['month11'] + $row['month12'];
$month01_total=$month01_total + $row['month01'];
$month02_total=$month02_total + $row['month02'];
$month03_total=$month03_total + $row['month03'];
$month04_total=$month04_total + $row['month04'];
$month05_total=$month05_total + $row['month05'];
$month06_total=$month06_total + $row['month06'];
$month07_total=$month07_total + $row['month07'];
$month08_total=$month08_total + $row['month08'];
$month09_total=$month09_total + $row['month09'];
$month10_total=$month10_total + $row['month10'];
$month11_total=$month11_total + $row['month11'];
$month12_total=$month12_total + $row['month12'];


$item_code=$row['item_code'];
$py_total=$py_total+$row['py'];
$total_total = $total_total + $total +$row['py'];


//*********************************************************************************
//   We Need a subloop here to count the bags of coffee sold for each product
//****************************Make the subquery*************************************
$company=addslashes($company);

$subquery = "SELECT oh.customer_key, oh.header_id, oi.item_code,
                    li.quantity, cc.Company
               FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li
              WHERE oh.header_id = oi.header_key
                AND oh.customer_key = cc.contact_id
                AND cc.Company = '$company'
                AND oi.item_code = '$item_code'
                and oi.item_id = li.item_id
                and oh.order_date Between '$from_date' and '$to_date'";

$subresult = mysql_query($subquery, $db_conn);
$subnum_results = mysql_num_rows($subresult);
$company=stripslashes($company);
$item_quantity=0;
for ($b=0; $b <$subnum_results;  $b++)
{
$subrow = mysql_fetch_array($subresult);
$item_quantity=$item_quantity + $subrow['quantity'];
}
$remaining=$total-$item_quantity + $row['py'];
$remaining_total=$remaining_total+$remaining;


 $commit_id = $row['commited_id'];

 echo '<tr><td align=center>';
  echo " <a href=";
 echo '"javascript:open_window(';
 echo "'commit_notes.php?record=$commit_id')";
 echo '"';
 echo "  alt='view notes'>";
 echo $row['item_code']; 
  echo "</a>";
 echo '</td>';

 $total = $total + $row['py'];
 echo "<td align=center>&nbsp;$total";

 echo "</td>";
 
 $used = $total - $remaining;
 
  echo "<td align=center>&nbsp;$used</td>";
    if ($total > 0) {
 $remain_percent = $remaining / $total;
}
 else {
 	$remain_percent = 0;
}
 $remain_percent = sprintf('%.2f', $remain_percent);
# $remain_percent = floor($remain_percent);
 echo '<td align=center>'.$remaining.' (';
 $remain_percent = $remain_percent * 100;
# printf('%.1f', $remain_percent);
# $remain_percent = floor($remain_percent);
 echo $remain_percent;
 echo '%)'.'</td>';


 echo "<td align=center><input  type=text size=2 maxlength=3 name=py$commit_id value=".$row['py']."></td>";
 echo "<td align=center><input  type=text size=2 maxlength=3 name=month01$commit_id value=".$row['month01']."></td>";
 echo "<td align=center><input  type=text size=2 maxlength=3 name=month02$commit_id value=".$row['month02']."></td>";
 echo "<td align=center><input  type=text size=2 maxlength=3 name=month03$commit_id value=".$row['month03']."></td>";
 echo "<td align=center><input type=text size=2 maxlength=3 name=month04$commit_id value=".$row['month04']."></td>";
 echo "<td align=center><input type=text size=2 maxlength=3 name=month05$commit_id value=".$row['month05']."></td>";
 echo "<td align=center><input type=text size=2 maxlength=3 name=month06$commit_id value=".$row['month06']."></td>";
 echo "<td align=center><input type=text size=2 maxlength=3 name=month07$commit_id value=".$row['month07']."></td>";
 echo "<td align=center><input type=text size=2 maxlength=3 name=month08$commit_id value=".$row['month08']."></td>";
 echo "<td align=center><input type=text size=2 maxlength=3 name=month09$commit_id value=".$row['month09']."></td>";
 echo "<td align=center><input type=text size=2 maxlength=3 name=month10$commit_id value=".$row['month10']."></td>";
 echo "<td align=center><input type=text size=2 maxlength=3 name=month11$commit_id value=".$row['month11']."></td>";
 echo "<td align=center><input type=text size=2 maxlength=3 name=month12$commit_id value=".$row['month12']."></td>";



 echo "<td><!--<INPUT TYPE='RADIO' NAME='RADIO' Value='$commit_id'>";
 echo " <a href=";
 echo '"javascript:open_window(';
 echo "'commit_notes.php?record=$commit_id')";
 echo '"';
 echo "  alt='view notes'";
 echo '><img src=';
 echo "'../sgr.gif'></a>-->";
  echo "<input type='checkbox' name='editbox[]' value='$commit_id'>\n";
 echo "</td></tr>";
  }

  echo '<tr bgcolor=palegreen><td><font color=blue>Totals:</font></td>';
  echo '<td><font color=blue>'.$total_total.'</font></td>';
  $total_used = $total_total - $remaining_total;
  echo '<td><font color=blue>'.$total_used.'</font></td>';
  $true_remaining_total = $total_total - $remaining_total;
  
  
  //
      if ($total_total > 0) {
 $total_remain_percent = $remaining_total / $total_total;
}
 else {
 	$total_remain_percent = 0;
}
 $total_remain_percent = sprintf('%.2f', $total_remain_percent);
 $total_remain_percent = $total_remain_percent * 100;

  //
  
  echo "<td><font color=blue> $remaining_total ($total_remain_percent%)</font></td>";
    echo '<td><font color=blue>'.$py_total.'&nbsp;</font></td>';
  echo "<td><font color=blue>$month01_total</font></td>";
  echo "<td><font color=blue>$month02_total</font></td>";
  echo "<td><font color=blue>$month03_total</font></td>";
  echo "<td><font color=blue>$month04_total</font></td>";
  echo "<td><font color=blue>$month05_total</font></td>";
  echo "<td><font color=blue>$month06_total</font></td>";
  echo "<td><font color=blue>$month07_total</font></td>";
  echo "<td><font color=blue>$month08_total</font></td>";
  echo "<td><font color=blue>$month09_total</font></td>";
  echo "<td><font color=blue>$month10_total</font></td>";
  echo "<td><font color=blue>$month11_total</font></td>";
  echo "<td><font color=blue>$month12_total</font></td><td>&nbsp;</td></tr>";


#  echo '</table>';
  # was here


if ($num_result2 > 0) {
echo "<br> we have $num_result2 records <br>"; 

#echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
echo '<tr bgcolor=mistyrose><th align=center><font size=2 color=black>Item</font></th>';
echo '<th colspan=2 align=center><font size=2 color=black>Purchased without commitment</font></th>';
echo '<th  colspan=1 align=center><font size=2 color=black>Quantity</font></th>';
echo '<th  colspan=7 align=center><font size=2 color=black>&nbsp;</font></th>';
echo '<th  colspan=6 align=center><font  size=2 color=black>&nbsp;</font></th></tr>';

for ($i=0; $i <$num_result2;  $i++)
  {
  $row2 = mysql_fetch_array($result2);
     $print_code = $row2['show_code'];
     $print_amt = $row2['quantity'];
     $print_desc = $row2['item_description'];
#  echo "<br> Purchased  $print_code ";
 #  echo '<br> Purchased  '.$row2['show_code'].'  Quantity =  '.$row2['quantity'].' <br>';	
 
   echo "<tr><td><font color=blue>$print_code</font></td>";
  echo "<td colspan=2><font color=blue>$print_desc</font></td>";
    echo "<td><font color=blue>$print_amt</font></td>";
  echo "<td colspan=7 ><font   color=blue>&nbsp;</font></td>";
  echo "<td colspan=6><font color=blue>&nbsp;</font></td></tr>";  	
}

}
 mysql_select_db($tbl_coop_commited);
$query = "select item_code, Notes, notes_date, notes_operator 
            from $tbl_coop_commited 
            where customer_key = '$customer_key' 
            and import_yr = '$year_range' 
            and Notes is not NULL 
            order by item_code";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);


#echo "<br> $query <br>";
if ($num_results > 0) {
 
echo '<tr bgcolor=palegreen><th align=center><font size=2 color=black>Item</font></th>';
echo '<th colspan=17 align=center><font size=2 color=black>Notes</font></th></tr>';


for ($i=0; $i <$num_results;  $i++)
  {
        $row = mysql_fetch_array($result);
       $print_code = $row['item_code'];
       $print_desc = $row['Notes'];
       if ($row['notes_operator'] != '') {
       $print_desc = $print_desc."<br>Notes Updated by ".$row['notes_operator']." On:".$row['notes_date'];
}
        echo "<tr><td><font color=blue>$print_code</font></td>";
        echo "<td colspan=17><font color=blue>$print_desc&nbsp;</font></td></tr>";         
       
}

}

 
echo '</table>';
}



echo '</form>';

?>