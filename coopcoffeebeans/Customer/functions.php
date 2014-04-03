<?php 


//********************* Functions for Cooperative Coffees ************************
//********************************************************************************


//********************* Draw the LOGO and start HTML *****************************

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
//********************************************************************************
  function newitemdropdown()
   {

   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }
  #  echo '<br>vars are:'.$order_id.':<br>';
  # get production items to create drop down list for specific product.
 # $query = 'SELECT item_code FROM item_description ';


   $query = 'SELECT  DISTINCT i.item_code FROM item_description i '.
            ' LEFT  OUTER  JOIN order_item o ON o.item_code = i.item_code ';
         //   ' AND header_key = "'.$order_id.'" WHERE o.item_code IS  NULL ';




   mysql_select_db('item_description');
      $ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "too bad too sad"; }


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);
 #  echo $ddrow['item_code'];

#  build drop down list.
   echo '<select name="new_product">';
   echo '<option value="">';
      for ($i=0; $i <$ddnum_results; $i++)
 {
      echo '<option value="'.$ddrow['item_code'].'" >'.$ddrow['item_code'];


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";
   #   echo "<a href='order_processing.php?order_id=".$order_id."&new_item=".$customer_key."'> New Item</a>";

}




?> 
