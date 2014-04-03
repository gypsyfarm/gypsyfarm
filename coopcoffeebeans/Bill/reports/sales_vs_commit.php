<?php



//********************************Start UP Sessions*******************************
//
//******************************Get the Includes**********************************
require("../../functions.php");
require("../../tables.php");
session_start();
// Check Security
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
  	echo'<title>Sales vs. Commited</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';


      echo '<table width=100%><tr bgcolor=palegree><td>';
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


# set up connection string to database.
  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

//***********************************************************************************
//								Take Care of Your Variables
//***********************************************************************************



$company=$_REQUEST['Company_Name'];
$company=stripslashes($company);

//***********************************************************************************
//							Start The Form
//***********************************************************************************

echo '<form method=POST action=sales_vs_commit.php>';



//***************Echo out todays date for the Report***********************
	echo '<font size=3 color=blue><Bold>Report Date: </bold></font>';
	//Report Date: Tuesday 01 2010f June 2010
	echo date("l d F Y");
	echo '<br>';
	echo '<font size=3 color=blue>Select a Company</font><br>';

//***************Build the Customer List (from functions)******************
    customerdropdown($company);

//*************Build Date Drop Down******************************************
//**Adding dates to dropdown here must add dates to if statements below******

$year_range = $current_year;   
# $from_year;
if (isset($_REQUEST['year_range'])) {
   $year_range=$_REQUEST['year_range'];
    
}

# Note the default is set in the functions include member.
# $import_yr=$_REQUEST['year_range'];

 
echo '<br><font size=3 color=blue>Select a date range</font><br>';


$date_range = $year_list;

echo "\n";
echo '<select name=year_range>';
echo "\n";
for ($i=0; $i < count($date_range);  $i++)
  {
    echo "<option value=$date_range[$i] ";
    if ($year_range == $date_range[$i]) {
       echo ' selected ';
    }

    echo "> $date_range[$i]";

    echo "\n";
  }

 echo '</select><br>';


echo '<br>';
//***************Display the Form Buttons for Selection*******************************
	  echo '<input type="SUBMIT" name="ACTION" value="View">';
	  echo '<input type="SUBMIT" name="ACTION" value="ALL">';
	  echo '<input type="SUBMIT" name="ACTION" value="Summary">';


//************************************************************************************
//************************************************************************************
//								Standard View By Company
//************************************************************************************
//************************************************************************************
if ($_REQUEST['ACTION'] == 'View')
{

//**************************Assign ranges to date for searching*********************



$from_date = $year_range.'-01-01';
$to_date = $year_range.'-12-31';

echo '<br>';
echo '<font size=5 color=blue><center>Sales Vs. Commitments</center></font><br>';
echo '<font size=3 color=blue>Commitment Summary for:</font>'.$company;
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: </font>';
echo date("m / d / y");
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Range: </font>';
echo $from_date.' to '.$to_date;
echo  '<br>';

$query = "SELECT * FROM $tbl_item_description order by item_code";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);

echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";
echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Description</font></th>';
echo '<th align=center><font size=2 color=blue>Item Code</font></th>';
echo '<th align=center><font size=2 color=blue>Commitment</font></th>';
echo '<th align=center><font size=2 color=blue>Sales To Date</font></th>';
echo '<th align=center><font size=2 color=blue>Remaining</font></th></tr>';
$commitment_total=0;
$item_quantity_total=0;
$remaining_total=0;


for ($i=0; $i <$num_results;  $i++) {
    $row = mysql_fetch_array($result);
    
    $item_code=$row['item_code'];
    
    
    //*****************Make the commitment Subquery****************************
    $subquery = "SELECT com.*, cc.Company 
                   FROM $tbl_coop_commited com, $tbl_coop_contact cc 
                   WHERE com.customer_key=cc.contact_id 
                     and cc.Company='$company' and com.item_code = '$item_code' and com.import_yr='$year_range'";
    $subresult = mysql_query($subquery, $db_conn);
    $subrow = mysql_fetch_array($subresult);
    $commitment=0;
    $commitment=$subrow['py']+$subrow['month01']+$subrow['month02']+$subrow['month03']+$subrow['month04']+$subrow['month05']+$subrow['month06']+$subrow['month07']+$subrow['month08']+$subrow['month09']+$subrow['month10']+$subrow['month11']+$subrow['month12'];
    
    //**************If there are commitments then display the INFO**************
    if ($commitment!=0) {
        echo "<tr><td>".$row['item_description']."</td>";
        echo "<td>".$row['item_code']."</td>";
        echo "<td>".$commitment."</td>";
        $commitment_total=$commitment_total+$commitment;
        
        //****We Need a subloop here to count the bags of coffee sold for each product******
        //****************************Make the subquery*************************************
        
        
        $subquery = "SELECT oh.customer_key, oh.header_id, oi.item_code, li.quantity, cc.Company
        		FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_lot_item li, $tbl_coop_contact cc
        		WHERE oh.header_id = oi.header_key
        		AND oh.customer_key = cc.contact_id
        		AND cc.Company = '$company'
        		AND oi.item_code = '$item_code'
        		AND oi.item_id = li.item_id
        		and oh.order_date Between '$from_date' and '$to_date'";
        
        
        $subresult = mysql_query($subquery, $db_conn);
        $subnum_results = mysql_num_rows($subresult);
        $item_quantity=0;
        for ($b=0; $b <$subnum_results;  $b++) {
            $subrow = mysql_fetch_array($subresult);
            $item_quantity=$item_quantity + $subrow['quantity'];
        }
        

        //*******Display the results and add to the totals**********************************
        echo "<td>".$item_quantity."</td>";
        $item_quantity_total=$item_quantity_total+$item_quantity;
        $remaining=$commitment - $item_quantity;
        echo "<td>".$remaining." </td>";
        
        $remaining_total=$remaining_total+$remaining;
    }
    else {
    # ok now check for sales but not commitment:

    
        $subquery = "SELECT oh.customer_key, oh.header_id, oi.item_code, li.quantity, cc.Company
        		FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_lot_item li, $tbl_coop_contact cc
        		WHERE oh.header_id = oi.header_key
        		AND oh.customer_key = cc.contact_id
        		AND cc.Company = '$company'
        		AND oi.item_code = '$item_code'
        		AND oi.item_id = li.item_id
        		and oh.order_date Between '$from_date' and '$to_date'";
        
        
        $subresult = mysql_query($subquery, $db_conn);
        $subnum_results = mysql_num_rows($subresult);
        $item_quantity=0;
        for ($b=0; $b <$subnum_results;  $b++) {
            $subrow = mysql_fetch_array($subresult);
            $item_quantity=$item_quantity + $subrow['quantity'];
        }
        
        
        if ($item_quantity > 0 ) {
            echo "<tr bgcolor=pink><td> ".$row['item_description']."</td>";
             echo "<td>".$row['item_code']."</td>";
             echo "<td> 0</td>";    

        //*******Display the results and add to the totals**********************************
        echo "<td>".$item_quantity."</td>";
        $item_quantity_total=$item_quantity_total+$item_quantity;
        $remaining= 0 - $item_quantity;
        echo "<td>".$remaining." </td>";
        }
          
    }

}
//**************Display the Totals**************************************************
echo '<tr bgcolor=palegreen><td></td>';
echo '<td><font color=blue>Totals:</font></td>';
echo '<td><font color=blue>'.$commitment_total.'</font></td>';
echo '<td><font color=blue>'.$item_quantity_total.'</font></td>';
echo '<td><font color=blue>'.$remaining_total.'</font></td>';
echo '</table>';

}


//************************************************************************************
//************************************************************************************
//								View All Companies
//************************************************************************************
//************************************************************************************
if ($_REQUEST['ACTION'] == 'ALL')
{
	
$year_range = $to_year;
if (isset($_REQUEST['year_range'])) {
   $year_range=$_REQUEST['year_range'];
    
} 

//**************************Assign ranges to date for searching*********************


/*
if ($year_range=='2002') {
   $from_date='2002-01-01';
   $to_date='2002-12-31';
}

if ($year_range =='2003') {
   $from_date='2003-01-01';
   $to_date='2003-12-31';
}

if ($year_range =='2004') {
   $from_date='2004-01-01';
   $to_date='2004-12-31';
}

if ($year_range =='2005') {
   $from_date='2005-01-01';
    $to_date='2005-12-31';
}

if ($year_range =='2006') {
   $from_date='2006-01-01';
    $to_date='2006-12-31';
}

if ($year_range =='2007') {
   $from_date='2007-01-01';
    $to_date='2007-12-31';
}

if ($year_range =='2008') {
   $from_date='2008-01-01';
    $to_date='2008-12-31';
}

*/
   $from_date="$year_range-01-01";
    $to_date="$year_range-12-31";


echo '<br>';
echo '<font size=5 color=blue><center>Sales Vs. Commitments</center></font><br>';
echo '<font size=3 color=blue>All Active Companies</font>';
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: </font>';
echo date("m / d / y");
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Range: </font>';
echo $from_date.' to '.$to_date;
echo  '<br>';

//********************Get the List of Companies to Loop through*********************
$company_query = "SELECT Company FROM $tbl_coop_contact where type='C'";
$company_result = mysql_query($company_query, $db_conn);
$company_num_results = mysql_num_rows($company_result);
//*********************Start the Loop***********************************************

for ($c=0; $c <$company_num_results;  $c++){
$commitment_total=0;
$item_quantity_total=0;
$remaining_total=0;

$company_row = mysql_fetch_array($company_result);
$company=$company_row['Company'];
echo '<br><br><font color=blue>Company# </font>'.($c+1).'&nbsp;&nbsp;&nbsp;<font color=blue>Company Name: </font>'.$company;

$query = "SELECT * FROM $tbl_item_description order by item_code";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);

echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";

echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Description</font></th>';
echo '<th align=center><font size=2 color=blue>Item Code</font></th>';
echo '<th align=center><font size=2 color=blue>Commitment</font></th>';
echo '<th align=center><font size=2 color=blue>Sales To Date</font></th>';
echo '<th align=center><font size=2 color=blue>Remaining Bags</font></th></tr>';

for ($i=0; $i <$num_results;  $i++)
  {
$row = mysql_fetch_array($result);



//echo "<tr><td>".$row['item_description']."</td>";
//echo "<td>".$row['item_code']."</td>";
$item_code=$row['item_code'];

//****************************Make the commitment Subquery*******************************************
$subquery = "SELECT com.*, cc.Company 
               FROM $tbl_coop_commited com, $tbl_coop_contact cc 
               WHERE com.customer_key=cc.contact_id 
               and cc.Company='$company' and com.item_code = '$item_code' and com.import_yr='$year_range'";
$subresult = mysql_query($subquery, $db_conn);
$subrow = mysql_fetch_array($subresult);
$commitment=0;
$commitment=$subrow['py']+$subrow['month01']+$subrow['month02']+$subrow['month03']+$subrow['month04']+$subrow['month05']+$subrow['month06']+$subrow['month07']+$subrow['month08']+$subrow['month09']+$subrow['month10']+$subrow['month11']+$subrow['month12'];
If ($commitment!=0)
{
echo "<tr><td>".$row['item_description']."</td>";
echo "<td>".$row['item_code']."</td>";
echo "<td>".$commitment."</td>";
$commitment_total=$commitment_total+$commitment;
//****************************We Need a subloop here to count the bags of coffee that have been sold for each product


//****************************Make the subquery*******************************************

$subquery = "SELECT oh.customer_key, oh.header_id, oi.item_code, li.quantity, cc.Company
 FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc, $tbl_lot_item li
WHERE oh.header_id = oi.header_key
AND oh.customer_key = cc.contact_id
AND cc.Company = '$company'
AND oi.item_code = '$item_code'
AND oi.item_id = li.item_id
and oh.order_date Between '$from_date' and '$to_date'";


$subresult = mysql_query($subquery, $db_conn);
$subnum_results = mysql_num_rows($subresult);
$item_quantity=0;
for ($b=0; $b <$subnum_results;  $b++)
{
$subrow = mysql_fetch_array($subresult);
$item_quantity=$item_quantity + $subrow['quantity'];
}
echo "<td>".$item_quantity."</td>";
$item_quantity_total=$item_quantity_total+$item_quantity;
$remaining=$commitment - $item_quantity;
echo "<td>".$remaining."</td>";
$remaining_total=$remaining_total+$remaining;
}

}
echo '<tr bgcolor=palegreen><td></td>';
echo '<td><font color=blue>Totals:</font></td>';
echo '<td><font color=blue>'.$commitment_total.'</font></td>';
echo '<td><font color=blue>'.$item_quantity_total.'</font></td>';
echo '<td><font color=blue>'.$remaining_total.'</font></td></tr>';

echo '</table>';
}
}


//************************************************************************************
//************************************************************************************
//								Summary For the BANK
//************************************************************************************
//************************************************************************************
if ($_REQUEST['ACTION'] == 'Summary')
{

$year_range = $from_year;
if (isset($_REQUEST['year_range'])) {
   $year_range=$_REQUEST['year_range'];
    
}


//**************************Assign ranges to date for searching*********************

if ($year_range == '2002') {
   $from_date='2002-01-01';
   $to_date='2002-12-31';
}

if ($year_range == '2003') {
   $from_date='2003-01-01';
   $to_date='2003-12-31';
}

if ($year_range == '2004') {
   $from_date='2004-01-01';
   $to_date='2004-12-31';
}

if ($year_range =='2005') {
   $from_date='2005-01-01';
    $to_date='2005-12-31';
}

if ($year_range =='2006') {
   $from_date='2006-01-01';
    $to_date='2006-12-31';
}

if ($year_range =='2007') {
   $from_date='2007-01-01';
    $to_date='2007-12-31';
}

if ($year_range =='2008') {
   $from_date='2008-01-01';
    $to_date='2008-12-31';
}

echo '<br>';
echo '<font size=5 color=blue><center>Sales Vs. Commitments</center></font><br>';
echo '<font size=3 color=blue>Commitment Summary for All Active Companies</font>';
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: </font>';
echo date("m / d / y");
echo '<font size=3 color=blue>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Range: </font>';
echo $from_date.' to '.$to_date;
echo  '<br>';

//****************************Draw out the Table Headers****************************
echo " <TABLE cellSpacing=0 cellPadding=0 width='100%' border=1>";

echo '<tr bgcolor=palegreen><th align=center><font size=2 color=blue>Description</font></th>';
echo '<th align=center><font size=2 color=blue>Item Code</font></th>';
echo '<th align=center><font size=2 color=blue>Commit</font></th>';
echo '<th align=center><font size=2 color=blue>Sales To Date</font></th>';
echo '<th align=center><font size=2 color=blue>Remain</font></th>';
echo '<th align=center><font size=2 color=blue>&nbsp;</font></th>';
echo '<th align=center><font size=2 color=blue>Purchases</font></th>';
echo '<th align=center><font size=2 color=blue>Spot</font></th>';
echo '<th align=center><font size=2 color=blue>Next Yr</font></th></tr>';

//**************************Crazy Loop de Loop Starts Here**************************
//**********************************************************************************
$query = "SELECT id.*, b.beginning_balance 
          FROM $tbl_item_description id
          left join  $tbl_item_yr_balance b  on b.item_code = id.item_code and b.yr_begin = '$year_range'         
          order by id.item_code";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
#  echo "<br> $query";
# echo 'The total of all items is = '.$num_results ;

$total_commitment_total=0;
$item_quantity_total=0;
$remaining_total=0;
#$total_pur=$row['beginning_balance'];
#echo "<br>total_pur=".$row['beginning_balance'];
$difference=0;


for ($a=0; $a <$num_results;  $a++)  {
    $commitment=0;
    $item_quantity=0;
    $row = mysql_fetch_array($result);

    
    # Now get current new product purchased for current year
 
     $item_code=$row['item_code'];  
    # echo "<br>ok item code is $item_code"; 
    $sumquery = "SELECT sum(quantity) as total_this_year
               FROM $tbl_coop_item ci 
               WHERE ci.item_code ='$item_code' 
                 AND YEAR(ci.arrival_date ) = '$year_range'"; 
    $sumresult = mysql_query($sumquery, $db_conn);
    $sumrow = mysql_fetch_array($sumresult);
  #  echo "<br> $sumquery";
 #   echo "<br>total_pur=".$row['beginning_balance']." + ".$sumrow['total_this_year'];  
    $total_pur=$row['beginning_balance'] + $sumrow['total_this_year']; 
    $total_total_pur += $total_pur;
    
    echo '<tr><td>'.$row['item_description'].'</td>';
    echo '<td>'.$row['item_code'].'</td>';


    //******************Now loop through commitments and get Counts*******************

   //****************************Make the commitment Subquery*******************************************

    $subquery = "SELECT com.* 
               FROM $tbl_coop_commited com 
               WHERE com.item_code ='$item_code' 
               and com.import_yr='$year_range'";
               
               
    $subresult = mysql_query($subquery, $db_conn);
    $subnum_results = mysql_num_rows($subresult);
    $commitment_total=0;
    for ($b=0; $b <$subnum_results;  $b++) {
       $subrow = mysql_fetch_array($subresult);
       $commitment=0;
       $commitment=$subrow['py']+$subrow['month01']+$subrow['month02']+$subrow['month03']+$subrow['month04']+$subrow['month05']+$subrow['month06']+$subrow['month07']+$subrow['month08']+$subrow['month09']+$subrow['month10']+$subrow['month11']+$subrow['month12'];
       $commitment_total=$commitment_total+$commitment;
     }
     
  # Now get next year's committment:
     //****************************Make the commitment Subquery*******************************************

    $next_year_range = $year_range + 1;
    $nysubquery = "SELECT com.* 
               FROM $tbl_coop_commited com 
               WHERE com.item_code ='$item_code' 
               and com.import_yr='$next_year_range'";
     
    $nysubresult = mysql_query($nysubquery, $db_conn);
    $nysubnum_results = mysql_num_rows($nysubresult);
    $nycommitment_total=0;
    for ($b=0; $b <$nysubnum_results;  $b++) {
       $nysubrow = mysql_fetch_array($nysubresult);
       $nycommitment=0;
       $nycommitment=$nysubrow['py']+$nysubrow['month01']+$nysubrow['month02']+$nysubrow['month03']+$nysubrow['month04']+$nysubrow['month05']+$nysubrow['month06']+$nysubrow['month07']+$nysubrow['month08']+$nysubrow['month09']+$nysubrow['month10']+$nysubrow['month11']+$nysubrow['month12'];
       $nycommitment_total=$nycommitment_total+$nycommitment;
     }   
     
     

     //Now find how many have been bought of this item

     $subquery = "SELECT oi.item_code, li.quantity
               FROM $tbl_order_item oi , $tbl_order_header oh, $tbl_lot_item li
              WHERE oi.header_key=oh.header_id
                and oi.item_code = '$item_code'
                and oi.item_id = li.item_id
                and oh.order_date Between '$from_date' and '$to_date'";


    $subresult = mysql_query($subquery, $db_conn);
    $subnum_results = mysql_num_rows($subresult);

    for ($c=0; $c <$subnum_results;  $c++) {
        $subrow = mysql_fetch_array($subresult);
        $item_quantity=$item_quantity + $subrow['quantity'];

    }
    //Now we should be ready to ouput the data and get a new item
    echo '<td>'.$commitment_total.'</td>';
    $total_commitment_total=$total_commitment_total+$commitment_total;
    echo '<td>'.$item_quantity.'</td>';
    $item_quantity_total=$item_quantity_total+$item_quantity;
    $remaining=$commitment_total-$item_quantity;
    echo '<td>'.$remaining.'</td>';
    echo '<td bgcolor=palegreen>&nbsp;</td>';
    echo '<td>'.$total_pur.'</td>';
    $difference=$total_pur-$commitment_total;
    echo '<td>'.$difference.'</td>';
    echo "<td>$nycommitment_total</td>";
    $total_nycommitment_total = $total_nycommitment_total + $nycommitment_total;
    echo '</tr>';
    $remaining_total=$remaining_total+$remaining;
}

echo '<tr bgcolor=palegreen><td></td>';
echo '<td><font color=blue>Totals:</font></td>';
echo '<td><font color=blue>'.$total_commitment_total.'</font></td>';
echo '<td><font color=blue>'.$item_quantity_total.'</font></td>';
echo '<td><font color=blue>'.$remaining_total.'</font></td> ';
echo '<td><font color=blue>&nbsp;</font></td> ';
echo "<td><font color=blue>$total_total_pur</font></td> ";
echo '<td><font color=blue>&nbsp;</font></td> ';
echo "<td><font color=blue>$total_nycommitment_total</font></td></tr>";
echo '</table>';
}
echo '</form>';
?>