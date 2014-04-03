<html>
<head>
  <title>Contact Search Results</title>
  <META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff></BODY>

<font size=3><a href="../../index.php" target="_top">Back to the Menu</a></font><br>
<font size=3><a href="../../logout.php" target="_top">Log out</a></font><br>
<font size=3><a href='index2.html' target='_top'> Add New Product</a><br></font> 
<br>
<form name="frmMain" action="itemresultsleft.php" method="post" target="BUTTONSFRAME">

 <a href="itemresultsright.php?searchtype=item_id&searchterm=0"  TARGET="TEXTFRAME" >
  Add a new Lot </a>

<?php

require("../../tables.php");

  // create short variable names
  $searchtype=$_REQUEST['searchtype'];
  $searchterm=$_REQUEST['searchterm'];
  $action=$_REQUEST['r_action'];


  $searchterm= trim($searchterm);

  $searchtype = addslashes($searchtype);
  $searchterm = addslashes($searchterm);


  $show_inactive=$_REQUEST['show_inactive'];

    echo '<br>Show inactive: <input type="checkbox" name="show_inactive"';
    $value_active = 0;

     if ($show_inactive == "on") {
         $value_active = 1;
         echo ' Checked ';
     }
     else   {

         echo ' ';
       }

     echo ' onclick="';
     echo "submit();";
     echo '"';

	echo "> <br>";




  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }


#  echo "action is ".$action."<br>";
   if ($action == "Update" || $action == "Add") {
	 $item_id=$_REQUEST[item_id];
     $item_code=$_REQUEST[item_code];
     $lot_ship=$_REQUEST[lot_ship];
     $warehouse=$_REQUEST[warehouse];
     $item_description=$_REQUEST[item_description];
     $member_price=$_REQUEST[member_price];
     $non_member_price=$_REQUEST[non_member_price];
     $mark=$_REQUEST[Mark];
     $warehouse_code=$_REQUEST[warehouse_code];
     $cost=$_REQUEST[cost];
     $quantity=$_REQUEST[quantity];
     $bag_lbs=$_REQUEST[bag_lbs];
     $status=$_REQUEST[status];
     $ship_date=$_REQUEST[ship_date];
     $arrival_date=$_REQUEST[arrival_date];
     $ft_item=$_REQUEST[ft_item];
     $item_notes=$_REQUEST[item_notes];
     $org_item=$_REQUEST[org_item];
          $spot_available=$_REQUEST[spot_available];
     $green_comment=$_REQUEST[green_comment];
     
    if ($_REQUEST[green_cb] == "on" )
       $green_cb = 1;
    else
       $green_cb = 0; 
     
    if ($_REQUEST[item_active] == "on" )
       $item_active = 1;
    else
       $item_active = 0;
       
     
     

  }

# Notes For transfer, make like add but put in new warehouse on added,fill in
# transfer_out field with amount.
# plus need to update original record by updating the transfer_out field.



  if ($action == "Add")

  {

    $query = "insert into $tbl_coop_item
              ( item_id, item_code, lot_ship, warehouse, item_description,
                member_price, non_member_price, mark, warehouse_code,
                cost, quantity,   status, ship_date, arrival_date,
                ft_item, org_item, item_notes, item_active, green_cb, spot_available, green_comment)
              values ( NULL,'$item_code',
                  '$lot_ship','$warehouse','$item_description',
               '$member_price','$non_member_price','$mark',
               '$warehouse_code','$cost','$quantity',
               '$status','$ship_date','$arrival_date','$ft_item',
               '$org_item','$item_notes','$item_active','$green_cb','$spot_available','$green_comment')";

    #   echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result)
        echo "<br><font size=2>Add Failed";
     else
        echo "<br><font size=2>Record Added";

   }


  if ($action == "Update")
  {
  #   echo "name=".$Type."<br>";
    $query = "update $tbl_coop_item set item_code = '".$item_code."',".
               "  lot_ship = '".$lot_ship."',".
               "  warehouse = '".$warehouse."',".
               "  item_description = '".$item_description."',".
               "  member_price = '".$member_price."',".
               "  non_member_price = '".$non_member_price."',".
               "  mark = '".$mark."',".
               "  warehouse_code = '".$warehouse_code."',".
               "  cost = '".$cost."',".
               "  quantity = '".$quantity."',".
               "  status = '".$status."',".
               "  ship_date = '".$ship_date."',".
               "  arrival_date = '".$arrival_date."',".
               "  ft_item = '".$ft_item."',".
               "  ft_item = '".$org_item."',".
               "  item_notes = '".$item_notes."',".
               "  green_cb = '".$green_cb."',".
               "  spot_available = '".$spot_available."',".  
               "  green_comment = '".$green_comment."',".   
              "  item_active = '".$item_active."' where item_id =".$item_id;


     $result = mysql_query($query, $db_conn);
     if (!$result)
        echo "<br><font size=2>Record was not updated";
     else
        echo "<br><font size=2>Record has been Updated";

  }




  mysql_select_db($tbl_coop_item);
#  $query = "select * from $tbl_coop_item where ".$searchtype." like '%".$searchterm."%'";



   if ($value_active == 0 )
   {
      $query = "select * from $tbl_coop_item where item_active = 0 order by warehouse, item_code, lot_ship ";
  }
  else  {
      $query = "select * from $tbl_coop_item order by warehouse, item_code, lot_ship ";
  }

 # echo "<br>$query <br>";
$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
echo '<font size=3 color=blue> Total items found: '.$num_results.' ';



  for ($i=0; $i <$num_results; $i++)
  {


     $row = mysql_fetch_array($result);

     echo '<p><font size=2>('.$row['item_id'].') <a href="itemresultsright.php?searchtype=item_id&searchterm='.$row['item_id'].'"';
	 echo '  TARGET="TEXTFRAME" >';
     echo ' '.$row['warehouse'].'  '.$row['item_code'].' '.$row['lot_ship']. '</a>';
	 echo '</p>';
	 }



?>


</form>
</BODY>


</HTML>
