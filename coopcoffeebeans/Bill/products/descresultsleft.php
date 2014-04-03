<html>
<head>
  <title>Product Description Results</title>
  <META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff></BODY>

<font size=3><a href="../../index.php" target="_top">Back to the Menu</a></font><br>
<font size=3><a href="../../logout.php" target="_top">Log out</a></font><br>
<font size=3><a href='index.html' target='_top'> Add New lots for Products </a><br> 
<br>

<form name="frmMain" action=itemresultsleft.php method=post target="BUTTONSFRAME">
  <a href="descresultsright.php?searchtype=item_id&searchterm=0"  TARGET="TEXTFRAME" >
  Add a new Product</a>

<?php

require("../../tables.php");

  // create short variable names
  $searchtype=$_REQUEST['searchtype'];
  $searchterm=$_REQUEST['searchterm'];
  $action=$_REQUEST['action'];


  $searchterm= trim($searchterm);

  $searchtype = addslashes($searchtype);
  $searchterm = addslashes($searchterm);


   $show_inactive=$_REQUEST['show_inactive'];

    echo 'Show inactive: <input type="checkbox" name="show_inactive"';
    $value_active = 0;

     if ($show_inactive == "on") {
         $value_active = 1;
         echo ' Checked ';
     }
     else   {

         echo ' ';
       }


     echo ' onchange="';
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


#  Return form variables.

   if ($action == "Update" || $action == "Add") {
     $item_code=$_REQUEST[item_code];
     $category=$_REQUEST[category];
     $item_description=$_REQUEST[item_description];
     $desc_notes=$_REQUEST[desc_notes];
     $rank=$_REQUEST[rank];
     $weight=$_REQUEST[weight];
     $total_pur=$_REQUEST[total_pur];
    if ($_REQUEST[item_active] == "on" )
       $item_active = 1;
    else
       $item_active = 0;

  }


# process an add request

  if ($action == "Add")

  {

    $query = "insert into $tbl_item_description
              ( item_code, item_description,
                weight, rank, category, item_active, desc_notes,total_pur)
              values ( '$item_code', '$item_description',
                  '$weight','$rank','$category','$item_active', '$desc_notes', '$total_pur')";

       echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result)
        echo "<br><font size=2>Add Failed";
     else
        echo "<br><font size=2>Record Added";

   }


# process update request.

  if ($action == "Update")
  {
  #   echo "name=".$Type."<br>";
    $query = "update $tbl_item_description set item_code = '".$item_code."',".
               "  item_description = '".$item_description."',".
               "  weight = '".$weight."',".
               "  rank = '".$rank."',".
               "  category = '".$category."',".
               "  desc_notes = '".$desc_notes."',".
               "  total_pur = '".$total_pur."',".
              "  item_active = '".$item_active."' where item_code ='".$item_code."'";

     $result = mysql_query($query, $db_conn);
     if (!$result)
        echo "<br><font size=2>Record was not updated";
     else
        echo "<br><font size=2>Record has been Updated";

  }




  mysql_select_db($tbl_item_description);

#  $query = "select * from $tbl_item_description order by category, rank ";

  if ($value_active == 0 )
   {
      $query = "select * from $tbl_item_description where item_active = 0 order by category, rank";
  }
  else  {
      $query = "select * from $tbl_item_description order by category, rank ";
  }



$result = mysql_query($query, $db_conn);
$num_results = mysql_num_rows($result);
echo '<font size=3 color=blue> Total items found: '.$num_results.' ';


  $print_category = 0;
  for ($i=0; $i <$num_results; $i++)
  {


     $row = mysql_fetch_array($result);


     if ($print_category != $row['category'] ) {
        $print_category = $row['category'];
        if ($print_category == '1') {
           echo '<font color=red><b><ul> Regular </b></ul></font>';
         }
        else
        if ($print_category == '2')  {
           echo '<font color=red><b><ul>Decaffeinated </b></ul></font>';
         }
        else
        if ($print_category == '3')   {
           echo '<font color=red><b><ul>Special Order </b></ul></font>';
        }
     }

     echo '<br><font size=2>('.$row['item_code'].') <a href="descresultsright.php?searchtype=item_id&searchterm='.$row['item_code'].'"';
	 echo '  TARGET="TEXTFRAME" >';
	 echo   $row['item_code'].'('.$row['rank'].')';
	 echo  '</a>';
         echo '<br>&nbsp';
	 }



?>
</form>
</BODY>


</HTML>
