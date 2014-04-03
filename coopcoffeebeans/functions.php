<?php
//********************************************************************************
//********************* Functions for Cooperative Coffees ************************
//********************************************************************************
// New Config Variables:

$current_year = date("Y"); 
$prev_year = $current_year - 1;
$green_c_from_year = $prev_year - 1;
$green_from_year = $green_c_from_year;
$green_to_year = $current_year;
$from_year = $current_year;
$to_year = $current_year + 1;
$import_year = $prev_year."-".$current_year;
$from_date = $current_year."-01-01";
$to_date = $current_year."-12-31";

/*
$current_year = '2011';
$prev_year = '2010';
$green_c_from_year ='2009'; 
$green_from_year ='2009';  
$green_to_year = '2011';
$from_year ='2011';
$to_year = '2012';
$import_year='2011-2012';
# bumped up to 2008 from 2007
$from_date='2011-01-01';
$to_date='2011-12-31';
 */
	
$producer_country_list = array("Bolivia","Colombia","Dom. Rep.","Ethiopia","Guatemala","Honduras","Mexico","Nicaragua","Peru","Salvador","Sumatra","Uganda");
$lot_colors = array('color1' => '#33FF33', 'color2' => '#FF66FF', 'color3' => '#999999');
$cc_type_list = array("Allies","Associate","Customer","Exporter","Importer","Media","Member","NGO","Other","Producer","Prospect","Staff","Vendor"); 
$region_list = array("NE","SE","MW","SW","NW","CA");
$rank_list = array("A","B","C");
$year_list = array("2003","2004","2005","2006","2007","2008","2009","2010","2011","2012","2013","2014","2015");        
$year_list_extended = array("2003","2004","2005","2006","2007","2008","2009","2010","2011","2012","2013","2014","2015");  
#note: had to redefine this array in note_fields.php
$note_type_list = array("Note","Task","Call"); 
$note_sort_options = array("Company, create_user, create_date","create_user, Company, create_date","create_date, Company, create_user");        
$status_list = array("Offered","Signed","Cancelled","Approved","On Water","Landed","Clearing","In Stock","Out Stock");        
$crlf = "/n";
$global_sales = 0;

         
// Do not change anything below this line. 
//********************************************************************************
//********************* Draw the LOGO and start HTML *****************************
//********************************************************************************


function logo(){
	echo'<html>';
	echo'<head>';
  	echo'<title>Contact Search Results</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
	echo'<img SRC="cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';

}


  function GenericCheckBox($cbname,$cbvalue = 0) {
     $onchange = 'dirty="true"'; 	
     echo "<input  onchange='$onchange' type=checkbox name='$cbname'";

     if ($cbvalue == "1")
         echo ' Checked>';
     else
         echo '>';
}  	

//*****************************************************************************************************
//****************** builds drop down list, pass in array of values, dd list name and selection Item   *
//*****************************************************************************************************
  function GenericDropDown($ddlist,$ddlist_name, $selected_item = "",$empty_item="yes", $disable= " ")  {
  #  echo "<br> looking to match ".$selected_item."<BR>";
 
  $onchange = 'dirty="true"'; 
   echo "<select  name=$ddlist_name $disable  onchange='$onchange' >";
   if ($empty_item == "yes") {
   echo "\n";
   echo "<option value=''>&nbsp";
   }
      echo "\n";
  foreach ($ddlist as $ddlist_item) {
     echo "<option value='$ddlist_item' ";
    
     if ($selected_item == $ddlist_item)  
        echo " selected>$ddlist_item";
     else
        echo ">$ddlist_item";
 
     echo "\n";
   
  }
  echo '</select>';
  echo "\n";

}


//********************************************************************************
//********************************NEW item Drop Down******************************
//********************************************************************************


  function newitemdropdown($item_code = "",$new_product = "new_product",$readonly = "",$all = "")
   {

   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

global $tbl_item_description;
global $tbl_order_item;
   $query = "SELECT DISTINCT i.item_code FROM $tbl_item_description i ";
       #     LEFT  OUTER  JOIN $tbl_order_item o ON o.item_code = i.item_code ";





 //  mysql_select_db('item_description');
      $ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "too bad too sad"; }


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);
 #  echo $ddrow['item_code'];

#  build drop down list.
   echo "<select name='$new_product'";
   echo $readonly;
   echo " >";
   echo "\n";
   echo "<option value='$all'>$all";
   echo "\n";
      for ($i=0; $i <$ddnum_results; $i++)
 {
      echo '<option value="'.$ddrow['item_code'].'" ';
      if ($item_code == $ddrow['item_code'])
      {
         echo ' selected ';
      }
      echo ' >'.$ddrow['item_code'];
      echo "\n";



   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";
   #   echo "<a href='order_processing.php?order_id=".$order_id."&new_item=".$customer_key."'> New Item</a>";

}

//**************************************************************************************
//***************************Customer Drop Down Menu************************************
//**************************************************************************************

function customerdropdown($company = "")
	{


   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }


 //mysql_select_db('coop_contact');
  	echo  " \n ";
   global $tbl_coop_contact;
   $query = "SELECT * From $tbl_coop_contact where type='C'order by Company";

	$ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "too bad too sad"; }

	$ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   echo '<select name="Company_Name">';
   echo '<br><option value="">';
   echo "\n";
      for ($i=0; $i <$ddnum_results; $i++)
 {
      echo '<option value="'.$ddrow['Company'].'"  ';
      if ($company == $ddrow['Company'])
      {
         echo ' selected ';
      }
      echo ' >'.$ddrow['Company'];
      echo "\n";


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";

}



//**************************************************************************************
//***************************Warehouse Drop Down Menu************************************
//**************************************************************************************

function warehousedropdown($warehouse = "", $disable= " ")
	{
   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }
   echo  " \n ";
   global $tbl_coop_warehouse;
   $query = "SELECT * From $tbl_coop_warehouse order by sort_order ";

	$ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "warehouse query failed"; }

	$ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   echo "<select $disable name='warehouse'>";
  # echo '<br><option value="">';
   echo "\n";
      for ($i=0; $i <$ddnum_results; $i++)
 {
      echo '<option value="'.$ddrow['warehouse_code'].'"  ';
      if ($warehouse == $ddrow['warehouse_code'])
      {
         echo ' selected ';
      }
      echo ' >'.$ddrow['warehouse_description'];
      echo "\n";


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";

}

//**************************************************************************************
//							Warehouse Drop Down Menu
//							  With All For Reports
//**************************************************************************************

function report_warehousedropdown($warehouse = "J"){
	
	
   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if ($warehouse == "") {
   	$warehouse = "J";
   }

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }
   echo  " \n ";
   global $tbl_coop_warehouse;
   $query = "SELECT * From $tbl_coop_warehouse order by sort_order";

	$ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "warehouse query failed"; }

	$ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   echo '<select name="warehouse">';
  # echo '<br><option value="">';
   echo "\n";
      for ($i=0; $i <$ddnum_results; $i++)
 {
      echo '<option value="'.$ddrow['warehouse_code'].'"  ';
      if ($warehouse == $ddrow['warehouse_code'])
      {
         echo ' selected ';
      }
      echo ' >'.$ddrow['warehouse_description'];
      echo "\n";


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
    echo '<option value="%"';
	if ($warehouse=='%'){echo 'selected';}
	echo '>All';
        echo "</select>";

}




//*************************************************************************************
//                               From Month Function
//*************************************************************************************


function from_monthdropdown($my_month = "") {

$month_number = array( '01','02','03','04','05','06','07','08','09','10','11','12');
$month_name = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

echo "\n";

echo '<select name=From_Month>';
echo "\n";
for ($i=0; $i < 12;  $i++)
  {
    echo "<option value=$month_number[$i] ";
    if ($my_month == $month_number[$i]) {
       echo ' selected ';
    }

    echo "> $month_name[$i]";

    echo "\n";
  }

 echo '</select>';
}

//*************************************************************************************
//                               To Year
//*************************************************************************************


function from_yeardropdown($my_year = "") {

global $year_list;
$year_number = $year_list;
// array( '2000','2001','2002','2003','2004','2005','2006');
//$year_name = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

echo "\n";

echo '<select name=From_Year>';
echo "\n";
for ($i=0; $i < count($year_number);  $i++)
  {
    echo "<option value=$year_number[$i] ";
    if ($my_year == $year_number[$i]) {
       echo ' selected ';
    }

    echo "> $year_number[$i]";

    echo "\n";
  }

 echo '</select>';
}


//*************************************************************************************
//                               To Month Function
//*************************************************************************************


function to_monthdropdown($my_month = "") {

$month_number = array( '01','02','03','04','05','06','07','08','09','10','11','12');
$month_name = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

echo "\n";

echo '<select name=To_Month>';
echo "\n";
for ($i=0; $i < 12;  $i++)
  {
    echo "<option value=$month_number[$i] ";
    if ($my_month == $month_number[$i]) {
       echo ' selected ';
    }

    echo "> $month_name[$i]";

    echo "\n";
  }

 echo '</select>';
}


//*************************************************************************************
//                               To Year
//*************************************************************************************


function to_yeardropdown($my_year = "") {

global $year_list;

$year_number =$year_list;
//  array( '2000','2001','2002','2003','2004','2005','2006');
//$year_name = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

echo "\n";

echo '<select name=To_Year>';
echo "\n";
for ($i=0; $i < count($year_number);  $i++)
  {
    echo "<option value=$year_number[$i] ";
    if ($my_year == $year_number[$i]) {
       echo ' selected ';
    }

    echo "> $year_number[$i]";

    echo "\n";
  }

 echo '</select>';
}

//*************************************************************************************
//                               From Month Function
//*************************************************************************************


function from_daydropdown($my_day = "") {

$day_number = array( '01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');

echo "\n";

echo '<select name=From_Day>';
echo "\n";
for ($i=0; $i < 31;  $i++)
  {
    echo "<option value=$day_number[$i] ";
    if ($my_day == $day_number[$i]) {
       echo ' selected ';
    }

    echo "> $day_number[$i]";

    echo "\n";
  }

 echo '</select>';
}

function to_daydropdown($my_day = "") {

$day_number = array( '01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');

echo "\n";

echo '<select name=To_Day>';
echo "\n";
for ($i=0; $i < 31;  $i++)
  {
    echo "<option value=$day_number[$i] ";
    if ($my_day == $day_number[$i]) {
       echo ' selected ';
    }

    echo "> $day_number[$i]";

    echo "\n";
  }

 echo '</select>';
}

//*************************************************************************************
//                               Find Commitment for a particular coffee
//*************************************************************************************


function find_commitment_code($customer_key,$item_code,$year_range) {
   global $tbl_coop_commited;


   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }


$query = "select cc.*
		 FROM $tbl_coop_commited cc 
		 where cc.customer_key = '$customer_key'
		 and cc.item_code = '$item_code'
		 and cc.import_yr = '$year_range'";
		 
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$row = mysql_fetch_array($result);

$total = $row['py'] + $row['month01'] + $row['month02'] + $row['month03'] + $row['month04'] +$row['month05'] +$row['month06'] +$row['month07'] +$row['month08'] + $row['month09'] + $row['month10'] + $row['month11'] + $row['month12'];
//echo $total;
return $total;
}
//*********************************************************************************
//   Find total purchase for a Coffee
//****************************Make the subquery*************************************

function find_code_total($customer_key,$item_code,$from_date,$to_date) {
   global $tbl_order_header;
   global $tbl_order_item;
   global $tbl_coop_contact;
   global $tbl_lot_item;
      $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

//$subquery = "SELECT oh.customer_key, oh.header_id, oi.item_code, oi.quantity, cc.Company 
//			FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_coop_contact cc 
//			WHERE oh.header_id = oi.header_key 
//			AND oh.customer_key = cc.contact_id 
//			AND cc.Company = \"$company\" 
//			AND oi.item_code = \"$item_code\" 
	//		and oh.order_date Between \"$from_date\" 
	//		and \"$to_date\"";

$subquery = "SELECT oh.customer_key, oh.header_id, oi.item_code, li.quantity, cc.Company 
		FROM $tbl_order_header oh, $tbl_order_item oi, $tbl_lot_item li, $tbl_coop_contact cc 
		WHERE oh.header_id = oi.header_key 
		AND oh.customer_key = cc.contact_id 
		AND cc.contact_id = \"$customer_key\" 
		AND oi.item_code = \"$item_code\"   
		AND oi.item_id = li.item_id 
		and oh.order_date Between \"$from_date\" and \"$to_date\"";
		
$subresult = mysql_query($subquery, $db_conn);
$subnum_results = mysql_num_rows($subresult);
$item_quantity=0;
for ($b=0; $b <$subnum_results;  $b++)
{
$subrow = mysql_fetch_array($subresult);
$item_quantity=$item_quantity + $subrow['quantity'];
}
return $item_quantity;
}
//$remaining=$total-$item_quantity;
//$remaining_total=$remaining_total+$remaining;




#
#   this functions creates a drop down list for selecting lot number
#
   function makedropdown($code, $warehouse, $lot_id, $lot_ship)
   {

   global $tbl_coop_item;

   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

#
# get production items to create drop down list
# for all products by ware house and item_code
#

 $query = "SELECT item_id, item_code, lot_ship, warehouse
           FROM $tbl_coop_item
           WHERE warehouse  = '$warehouse'  AND item_code = '$code'";
 /* 
    mysql_select_db($tbl_coop_item);
    $ddresults = mysql_query($query, $db_conn);

    if (!$ddresults)
    { echo "Select failed for $tbl_coop_item"; }

   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);  
   
   
        for ($i=0; $i <$ddnum_results; $i++)
 {  
 
 
    $test_value =  remaining_inventory($ddrow['item_code'], $ddrow['lot_ship'],$ddrow['warehouse']);
     $ddrow = mysql_fetch_array($ddresults);  
    
 #  echo $test_value;
 
 }   
*/ 
    mysql_select_db($tbl_coop_item);
    $ddresults = mysql_query($query, $db_conn); 
   
   
   
  $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);  
    

#
#  build drop down list for lot item
#  NOTE: item_id is lot_ship, I know a bit confusing...
#
   echo "<select name='lotship".$lot_id."'>";

      for ($i=0; $i <$ddnum_results; $i++)
 {  
 
 
  $test_value =  remaining_inventory($ddrow['item_code'], $ddrow['lot_ship'],$ddrow['warehouse']);
    
    
 #  echo $test_value;


 
        echo "<option value='".$ddrow['item_id'];
        echo "'";
        if ($lot_ship == $ddrow['item_id'] )
        {
           echo ' selected ';
        }
        echo ' > '.$ddrow['item_code'].' / '.$ddrow['lot_ship'].' / '.$ddrow['warehouse'].' /  '.$test_value.'   ';

   $ddrow = mysql_fetch_array($ddresults);
  # $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";

   }



function transferwarehouse($warehouse = "")
	{
   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }
   echo  " \n ";
   global $tbl_coop_warehouse;
   $query = "SELECT * From $tbl_coop_warehouse ";

	$ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "warehouse query failed"; }

	$ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   echo '<select name="transwarehouse">';
   echo '<br><option value="">';
   echo "\n";
      for ($i=0; $i <$ddnum_results; $i++)
 {


      if ($warehouse != $ddrow['warehouse_code'])
      {
        echo '<option value="'.$ddrow['warehouse_code'].'"  ';
        echo ' >'.$ddrow['warehouse_description'];
        echo "\n";
      }


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";

}





  function remaining_inventory($passed_item_code,$passed_lot_ship,$passed_warehouse)
   {

   global $tbl_order_header;
   global $tbl_item_description;
   global $tbl_order_item;
   global $tbl_lot_item;
   global $tbl_coop_item;
   global $tbl_coop_contact;
   global $global_sales;

/*
set initial_quantity
then loop thru and add all quantity to get quantity purchased

remaining will be initial_quantity - total_quantity

*/

  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');


# begin new code
  $query =   "SELECT quantity, transfer_in, transfer_out
FROM  $tbl_coop_item li
          WHERE item_code='$passed_item_code'
          AND lot_ship= '$passed_lot_ship'
          AND warehouse = '$passed_warehouse'";


$result = mysql_query($query, $db_conn);

#$initial_quantity=0;

$row=mysql_fetch_array($result);

$initial_quantity =$row['quantity'] + $row['transfer_in'] - $row['transfer_out'];
#echo "<br>initial quantity is ".$row['quantity']."<br>";

#end new code


#$query = "xxx";
  $query =   "SELECT ci.warehouse,  oi.item_code, li.quantity, ci.lot_ship, id.weight as bag_lbs,
ci.item_description, ci.quantity as initial_quantity,  oh.order_date, oh.header_id, cc.Company
FROM  $tbl_item_description id,  $tbl_order_item oi,  $tbl_lot_item li,
           $tbl_order_header oh, $tbl_coop_item ci,  $tbl_coop_contact cc
          WHERE oi.item_id = li.item_id
          AND oi.item_code = id.item_code
		  AND oh.customer_key = cc.contact_id
          AND li.lot_ship = ci.item_id
          AND oi.header_key = oh.header_id
          AND oi.item_code='$passed_item_code'
          AND ci.lot_ship= '$passed_lot_ship'
          AND ci.warehouse = '$passed_warehouse'";

$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
$quantity_total=0;
$remaining=0;
for ($i=0; $i <$num_results;  $i++)
  {
$row=mysql_fetch_array($result);

$quantity_total=$quantity_total+$row['quantity'];
}
$global_sales = $quantity_total;
$remaining=$initial_quantity - $quantity_total;


return $remaining;


}

?>
