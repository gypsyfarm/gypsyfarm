<?php
//****************************************************************************************
require("../../tables.php");
require("../../functions.php");


$from_year = $current_year;
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
  
     
// create short variable names
# this field will need to come from login screen.
  $company=$_SESSION['valid_user'];
  $current_id=$_REQUEST['current_id'];
  $action=$_REQUEST['action'];
  


echo '<form method=POST action="admin_coop_commit_test.php">';

//*************Build Date Drop Down******************************************
//**Adding dates to dropdown here must add dates to if statements below******
 
if (!isset($_REQUEST['year_range'])) {
$_REQUEST['year_range']= $from_year;
}




 $import_yr = $_REQUEST['year_range'];

 
echo '<font size=3 color=blue>Select a date range</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
 
$date_range = $year_list;

echo "\n";
 
echo '<select name=year_range>';
echo "\n";
for ($i=0; $i < count($date_range);  $i++)
  {
    echo "<option value=$date_range[$i] ";
    if ($import_yr == $date_range[$i]) {
       echo ' selected ';
    }

    echo "> $date_range[$i]";

    echo "\n";
  }

 echo '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	  echo '<input type="SUBMIT" name="SUBMIT" value="view">';


#  echo '<br> ok sub is '.$_REQUEST['SUBMIT'].'<br>';

#  if ($_REQUEST['SUBMIT'] == 'view')
#  {

 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

$company=$_SESSION['valid_user'];



$year_range=$_REQUEST['year_range'];
//echo $company;

//echo $company;
//echo $year_range;

  $company=$_REQUEST['Company_Name'];
  
  if (!ISSET($company)) {
  $company = 'Cafe Campesino';
}


$company=addslashes($company);
$query = "select * from $tbl_coop_contact where Company = '$company'";
$company=stripslashes($company);

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$customer_key=$row['contact_id'];
//echo $customer_key;
//**************************Assign ranges to date for searching*********************

 


 $from_date = $year_range.'-01-01';
 $to_date = $year_range.'-12-31';


$query = "select cc.*, id.item_description, id.item_code
		 FROM $tbl_coop_commited cc, $tbl_item_description id
		 where cc.customer_key = '$customer_key'
		 and cc.import_yr = '$year_range'
		 and cc.item_code = id.item_code order by id.item_code";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);




 # echo "<br> $query <br>";

# begin new code:
$query = 
"SELECT o.customer_key, i.header_key, c.item_code, i.item_code as show_code, o.order_date, id.item_description, l.quantity, i.header_key 
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
 
 # echo "<br> $query <br>";

# end new code:


customerdropdown($company);

echo "<p>";



echo '&nbsp;&nbsp;&nbsp;<font size=3 color=blue>Now viewing commitments for,&nbsp;'.$company.'&nbsp;for the year, '.$year_range.'<br>';





echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";

echo '<tr bgcolor=palegreen><th align=center><font color=blue>Item</font></th>';
echo '<th align=center><font color=blue>Description</font></th>';
echo '<th align=center><font color=blue>Remain<br> Commits</font></th>';
echo '<th align=center><font color=blue>Sales <br>YTD</font></th>';
echo '<th align=center><font color=blue>Total Yr <br>Commits</font></th>';
echo '<th align=center><font color=blue>&nbsp;</font></th>';
echo '<th align=center><font color=blue>Jan</font></th>';
echo '<th align=center><font color=blue>Feb</font></th>';
echo '<th align=center><font color=blue>Mar</font></th>';
echo '<th align=center><font color=blue>Apr</font></th>';
echo '<th align=center><font color=blue>May</font></th>';
echo '<th align=center><font color=blue>Jun</font></th>';
echo '<th align=center><font color=blue>Jul</font></th>';
echo '<th align=center><font color=blue>Aug</font></th>';
echo '<th align=center><font color=blue>Sep</font></th>';
echo '<th align=center><font color=blue>Oct</font></th>';
echo '<th align=center><font color=blue>Nov</font></th>';
echo '<th align=center><font color=blue>Dec</font></th>';
echo '<th align=center><font color=blue>PY</font></th></tr>';
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
$py_total=0;
$total_total=0;
$used_total =0;
$remaining=0;
$remaining_total=0;

$sales_col01_total = 0;
$sales_col02_total = 0;
$sales_col03_total = 0;
$sales_col04_total = 0;
$sales_col05_total = 0;
$sales_col06_total = 0;
$sales_col07_total = 0;
$sales_col08_total = 0;
$sales_col09_total = 0;
$sales_col10_total = 0;
$sales_col11_total = 0;
$sales_col12_total = 0;

for ($i=0; $i <$num_results;  $i++)
  {
  $row = mysql_fetch_array($result);
  $item_code=$row['item_code'];
  $total = $row['py'] + $row['month01'] + $row['month02'] + $row['month03'] + $row['month04'] +$row['month05'] +$row['month06'] +$row['month07'] +$row['month08'] + $row['month09'] + $row['month10'] + $row['month11'] + $row['month12'];
//***************************************Sum up the Totals************************
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
$total_total=$total_total + $total;
$py_total=$py_total+$row['py'];

//*********************************************************************************
//   We Need a subloop here to count the bags of coffee sold for each product
//****************************Make the subquery*************************************

/*
$subquery = "SELECT oh.customer_key, oh.header_id, oi.item_code, li.quantity, cc.Company 
              FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li
             WHERE oh.header_id = oi.header_key
               AND oh.customer_key = cc.contact_id AND cc.Company = '$company'
               AND oi.item_code = '$item_code'
               and oi.item_id = li.item_id
               and oh.order_date Between '$from_date' and '$to_date'";
               
               */
               
               $subquery = "SELECT MONTH(oh.order_date) as month, sum(li.quantity) as quantity
              FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li
             WHERE oh.header_id = oi.header_key
               AND oh.customer_key = cc.contact_id AND cc.Company = '$company'
               AND oi.item_code = '$item_code'
               and oi.item_id = li.item_id
               and oh.order_date Between '$from_date' and '$to_date'
               group by MONTH(oh.order_date)";

$subresult = mysql_query($subquery, $db_conn);
$subnum_results = mysql_num_rows($subresult);
$item_quantity=0;
$sales_by_month = array(0,0,0,0,0,0,0,0,0,0,0,0,0);

for ($b=0; $b <$subnum_results;  $b++)  {
   $subrow = mysql_fetch_array($subresult);
   $item_quantity=$item_quantity + $subrow['quantity'];
   $sales_by_month[$subrow['month']] = $subrow['quantity'];
}

$remaining=$total-$item_quantity;
$remaining_total=$remaining_total+$remaining;

 echo "<tr><td>".$row['item_code']."</td>";
 echo "<td>".$row['item_description']."</td>";
 echo '<td>'.$remaining.'</td>';
 $used = $total - $remaining;
 $used_total = $used_total + $used;
  echo '<td  bgcolor=palegreen>'.$used.'</td>';
 echo "<td>&nbsp;$total"."</td>";
 
 
 # begin New code
# echo "<td  bgcolor=palegreen >&nbsp;<table width='100%'><tr><td  bgcolor=white align='center'>".$col_one." </td><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";
 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'> C </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> S </td></tr></table></td>";
 
       # get the current month.
         $month_index =   substr(date("m/d/Y"),0,2);
        $current_month =  0 + $month_index;
 
 # end new code 
 
 
 
 
#if ($row['month01'] != "") { 
  if (isset($row['month01']) &&  $row['month01']  > 0) {
   $col_one = $row['month01'];
} 
     else {
   $col_one = "0";	
}

$test_month = 1;
 if ($sales_by_month[1] > 0) {
   $sales_col = $sales_by_month[1];
   $sales_col01_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
 else {
   $sales_col  = "0";	
}
# echo "<td  bgcolor=palegreen >&nbsp;<table width='100%'><tr><td  bgcolor=white align='center'>".$col_one." </td><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";
 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";


$test_month += 1;
 if (isset($row['month02']) &&  $row['month02']  > 0) {
   $col_one = $row['month02'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[2] > 0) {
   $sales_col = $sales_by_month[2];
   $sales_col02_total += $sales_col;
} 
 elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }     	
     else {
   $sales_col  = "0";	
}
 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";

$test_month += 1;
 if (isset($row['month03']) &&  $row['month03']  > 0) {
   $col_one = $row['month03'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[3] > 0) {
   $sales_col = $sales_by_month[3];
   $sales_col03_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
     else {
   $sales_col  = "0";	
}

 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";


$test_month += 1;
  if (isset($row['month04']) &&  $row['month04']  > 0) {
   $col_one = $row['month04'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[4] > 0) {
   $sales_col = $sales_by_month[4];
   $sales_col04_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }  
      else {   	
   $sales_col  = "0";	
}

 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";



$test_month += 1;
 if (isset($row['month05']) &&  $row['month05']  > 0) {
   $col_one = $row['month05'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[5] > 0) {
   $sales_col = $sales_by_month[5];
   $sales_col05_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
     else {
   $sales_col  = "0";	
}

 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";


$test_month += 1;
 if (isset($row['month06']) &&  $row['month06']  > 0) {
   $col_one = $row['month06'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[6] > 0) {
   $sales_col = $sales_by_month[6];
   $sales_col06_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
     else {
   $sales_col  = "0";	
}

 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";



$test_month += 1;
 if (isset($row['month07']) &&  $row['month07']  > 0) {
   $col_one = $row['month07'];  
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[7] > 0) {
   $sales_col = $sales_by_month[7];
   $sales_col07_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
     else {
   $sales_col  = "0";	
}


 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";


$test_month += 1;
  if (isset($row['month08']) &&  $row['month08']  > 0) {
   $col_one = $row['month08'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[8] > 0) {
   $sales_col = $sales_by_month[8];
   $sales_col08_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
     else {
   $sales_col  = "0";	
}

 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";



$test_month += 1;
  if (isset($row['month09']) &&  $row['month09']  > 0) {
   $col_one = $row['month09'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[9] > 0) {
   $sales_col = $sales_by_month[9];
   $sales_col09_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
     else {
   $sales_col  = "0";	
}


 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";


$test_month += 1;
 if (isset($row['month10']) &&  $row['month10']  > 0) {
   $col_one = $row['month10'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[10] > 0) {
   $sales_col = $sales_by_month[10];
   $sales_col10_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
     else {
   $sales_col  = "0";	
}

 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";


$test_month += 1;
  if (isset($row['month11']) &&  $row['month11']  > 0) {
   $col_one = $row['month11'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[11] > 0) {
   $sales_col = $sales_by_month[11];
   $sales_col11_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
     else {
   $sales_col  = "0";	
}

 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";


$test_month += 1;
  if (isset($row['month12']) &&  $row['month12']  > 0) {
   $col_one = $row['month12'];
} 
     else {
   $col_one = "0";	
}
 if ($sales_by_month[12] > 0) {
   $sales_col = $sales_by_month[12];
   $sales_col12_total += $sales_col;
} 
elseif ($test_month > $current_month) {
	$sales_col = "&nbsp;"; 
 }
     else {
   $sales_col  = "0";	
}


 echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$col_one." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> ".$sales_col."</td></tr></table></td>";



$py = 0;
if ($row['py'] > 0 ) {
	$py = $row['py'];
}  
	
 
 
 echo "<td  bgcolor=white >&nbsp;".$py."</td>";
 


  }
  echo "<tr bgcolor=palegreen><td>&nbsp;</td>";
  echo "<td><font color=blue><center>Totals:</center></font></td>";
  echo "<td><font color=blue>$remaining_total</font></td>";
   echo "<td><font color=blue>$used_total</font></td>";
  echo "<td><font color=blue>$total_total</font></td>";
  
 # echo "<td><font color=blue>&nbsp;</font></td>";
   echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'> C </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'> S </td></tr></table></td>";
  
  
 # echo "<td><font color=blue>$month01_total</font></td>";
   echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month01_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col01_total."</td></tr></table></td>";

 
  
  
 # echo "<td><font color=blue>$month02_total</font></td>";
     echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month02_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col02_total."</td></tr></table></td>";

  
  
#  echo "<td><font color=blue>$month03_total</font></td>";
      echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month03_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col03_total."</td></tr></table></td>"; 
  
  
  
#  echo "<td><font color=blue>$month04_total</font></td>";
      echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month04_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col04_total."</td></tr></table></td>";   
  
  
#  echo "<td><font color=blue>$month05_total</font></td>";
      echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month05_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col05_total."</td></tr></table></td>"; 


 # echo "<td><font color=blue>$month06_total</font></td>";
      echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month06_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col06_total."</td></tr></table></td>";   
  
  
 # echo "<td><font color=blue>$month07_total</font></td>";
      echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month07_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col07_total."</td></tr></table></td>";   
  
  
#  echo "<td><font color=blue>$month08_total</font></td>";
        echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month08_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col08_total."</td></tr></table></td>"; 
  
  
  
 # echo "<td><font color=blue>$month09_total</font></td>";
      echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month09_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col09_total."</td></tr></table></td>";   
  
  
  
#  echo "<td><font color=blue>$month10_total</font></td>";
      echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month10_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col10_total."</td></tr></table></td>"; 



 # echo "<td><font color=blue>$month11_total</font></td>";
       echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month11_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col11_total."</td></tr></table></td>"; 
 
 
# echo "<td><font color=blue>$month12_total</font></td>";
      echo "<td  bgcolor=palegreen ><table border=1 rules=rows width='100%'>";
 echo "\n";
 echo "<tr><td  bgcolor=white align='center'>".$month12_total." </td> </tr>";
  echo "\n";
 echo "<tr><td bgcolor=palegreen align='center'>".$sales_col12_total."</td></tr></table></td>";   
  
  
  echo "<td><font color=white>$py_total</font></td></tr>";

if ($num_result2 > 0) {
echo '<tr bgcolor=mistyrose><th align=center><font size=2 color=black>Item</font></th>';
echo '<th colspan=2 align=center><font size=2 color=black>Purchased without commitment</font></th>';
echo '<th  colspan=1 align=center><font size=2 color=black>Quantity</font></th>';
echo '<th  colspan=1 align=center><font size=2 color=black>&nbsp;</font></th>';
echo '<th  colspan=7 align=center><font size=2 color=black>&nbsp;</font></th>';
echo '<th  colspan=7 align=center><font  size=2 color=black>&nbsp;</font></th></tr>';

for ($i=0; $i <$num_result2;  $i++)
  {
  $row2 = mysql_fetch_array($result2);
     $print_code = $row2['show_code'];
     $print_amt = $row2['quantity'];
     $print_desc = $row2['item_description'];
#  echo "<br> Purchased  $print_code ";
 #  echo '<br> Purchased  '.$row2['show_code'].'  Quantity =  '.$row2['quantity'].' <br>';	
 
   echo "<td><font color=blue>$print_code</font></td>";
  echo "<td colspan=2><font color=blue>$print_desc</font></td>";
    echo "<td><font color=blue>$print_amt</font></td>";
     echo "<td><font color=blue>&nbsp;</font></td>";
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
                echo "<td><font color=blue>&nbsp;</font></td>";
        echo "<td colspan=17><font color=blue>$print_desc&nbsp;</font></td></tr>";         
       
}

}

 echo '</table>';
?>