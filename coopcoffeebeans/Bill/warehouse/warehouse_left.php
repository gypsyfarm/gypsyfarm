<html>
<head>
  <title>Warehouse Search Results</title>
  <META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff></BODY>

<font size=3><a href="../../index.php" target="_top">Back to the Menu</a></font><br>
<font size=3><a href="../../logout.php" target="_top">Log out</a></font><br>
<br>


  <a href="warehouse_right.php?searchtype=warehouse_id&searchterm=0"  TARGET="TEXTFRAME" >
  Add a new Product </a>

<?php

require("../../tables.php");

  // create short variable names
  $searchtype=$_REQUEST['searchtype'];
  $searchterm=$_REQUEST['searchterm'];
  $action=$_REQUEST['action'];


  $searchterm= trim($searchterm);

  $searchtype = addslashes($searchtype);
  $searchterm = addslashes($searchterm);


  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('greenbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }
$warehouse_code=$_REQUEST[warehouse_code];
$warehouse_descripton=$_REQUEST[warehouse_description];

#  echo "action is ".$action."<br>";
   if ($action == "Update" || $action == "Add") {
	
     

    if ($_REQUEST[item_active] == "on" )
       $item_active = 1;
    else
       $item_active = 0;


  }



  if ($action == "Add")

  {
 
    $query = "insert into $tbl_coop_warehouse
              ( warehouse_code, warehouse_description)
              values ('$warehouse_code','$warehouse_description')";

       //echo "<br>string=".$query."<br>";
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
               "  bag_lbs = '".$bag_lbs."',".
               "  status = '".$status."',".
               "  ship_date = '".$ship_date."',".
               "  arrival_date = '".$arrival_date."',".
               "  ft_item = '".$ft_item."',".
               "  ft_item = '".$org_item."',".
               "  item_notes = '".$item_notes."',".
              "  item_active = '".$item_active."' where item_id =".$item_id;


     $result = mysql_query($query, $db_conn);
     if (!$result)
        echo "<br><font size=2>Record was not updated";
     else
        echo "<br><font size=2>Record has been Updated";

  }




 // mysql_select_db($tbl_coop_item);
  //$query = "select * from $tbl_coop_item where ".$searchtype." like '%".$searchterm."%'";



  if (!$searchtype || !$searchterm)
  {
      $query = "select * from $tbl_coop_warehouse order by warehouse_description";
  }


$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
echo '<font size=3 color=blue> Total items found: '.$num_results.' ';



  for ($i=0; $i <$num_results; $i++)
  {


     $row = mysql_fetch_array($result);

     echo '<p><font size=2> <a href="warehouse_right.php?searchtype=warehouse_code&searchterm='.$row['warehouse_code'].'"';
	 echo '  TARGET="TEXTFRAME" >(';
	 echo   $row['warehouse_code'];
	 echo ')';
	  echo ' '.$row['warehouse_description'].' </a>';
     //echo ' '.$row['warehouse_description'].' '.$row['lot_ship']. '</a>';
	 echo '</p>';
	 }



?>

</BODY>


</HTML>
