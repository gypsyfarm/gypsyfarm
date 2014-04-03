<html>
<head>
  <title>Contact Search Results</title>
  <META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">
</head>
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>



  <a href="contactresultsright.php?searchtype=contact_id&searchterm=0"  TARGET="TEXTFRAME" >
  Add New Record </a>

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
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }


#  echo "action is ".$action."<br>";
   if ($action == "Update" || $action == "Add") {
     $contact_id=$_REQUEST[contact_id];
     $Company=  str_replace("'","''",$_REQUEST[Company]);
  #    echo $Company." has been retrived";
     $Name=$_REQUEST[Name];
     $Type=$_REQUEST[Type];
     $Email=$_REQUEST[Email];
     $BillAddress1=$_REQUEST[BillAddress1];
     $BillAddress2=$_REQUEST[BillAddress2];
     $BillAddress3=$_REQUEST[BillAddress3];
     $BillAddress4=$_REQUEST[BillAddress4];
     $BillCity=$_REQUEST[BillCity];
     $BillState=$_REQUEST[BillState];
     $BillZip=$_REQUEST[BillZip];
     $BillCountry=$_REQUEST[BillCountry];
     $WorkPhone=$_REQUEST[WorkPhone];
     $WorkFax=$_REQUEST[WorkFax];
     $ShipAddress1=$_REQUEST[ShipAddress1];
     $ShipAddress2=$_REQUEST[ShipAddress2];
     $ShipAddress3=$_REQUEST[ShipAddress3];
     $ShipAddress4=$_REQUEST[ShipAddress4];
     $ShipCity=$_REQUEST[ShipCity];
     $ShipState=$_REQUEST[ShipState];
     $ShipZip=$_REQUEST[ShipZip];
     $ShipCountry=$_REQUEST[ShipCountry];
     $ShipPhone=$_REQUEST[ShipPhone];
     $ShipFax=$_REQUEST[ShipFax];
     $AltName=$_REQUEST[AltName];
     $AltPhone=$_REQUEST[AltPhone];
     $AltEmail=$_REQUEST[AltEmail];
     $ShipNote=$_REQUEST[ShipNote];
     $FTTrack=$_REQUEST[FTTrack];
     $OrgTrack=$_REQUEST[OrgTrack];
     $fob_code=$_REQUEST[fob_code];
     $Truck=$_REQUEST[Truck];
   #  $Inactive=$_REQUEST[Inactive];
    if ($_REQUEST[Inactive] == "on" )
       $Inactive = 1;
    else
       $Inactive = 0;

     $Warehouse=$_REQUEST[Warehouse];
     $flo_id=$_REQUEST[flo_id];


  }



  if ($action == "Add")
  {
   # echo "Hey I am adding<br>".$Company."<br>";
    $query = "insert into  $tbl_coop_contact values ( NULL,'".$Company."',".
               "'".$Name."',".
               "'".$Type."',".
               "'".$Email."',".
               "'".$BillAddress1."',".
               "'".$BillAddress2."',".
               "'".$BillAddress3."',".
               "'".$BillAddress4."',".
               "'".$BillCity."',".
               "'".$BillState."',".
               "'".$BillZip."',".
               "'".$BillCountry."',".
               "'".$WorkPhone."',".
               "'".$WorkFax."',".
               "'".$ShipAddress1."',".
               "'".$ShipAddress2."',".
               "'".$ShipAddress3."',".
               "'".$ShipAddress4."',".
               "'".$ShipCity."',".
               "'".$ShipState."',".
               "'".$ShipZip."',".
               "'".$ShipCountry."',".
               "'".$ShipPhone."',".
              "'".$ShipFax."',".
              "'".$AltName."',".
              "'".$AltPhone."',".
              "'".$AltEmail."',".
              "'".$ShipNote."',".
              "'".$FTTrack."',".
              "'".$OrgTrack."',".
              "'".$Truck."',".
              "'".$Inactive."',".
              "'".$Warehouse."','".$fob_code."',NULL,NULL,NULL,NULL,'".$flo_id."')";
    #  echo "<br>string=".$query."<br>";
      $result = mysql_query($query, $db_conn);
      if (!$result) {
        echo "<br><font size=2>Add Failed";
	  }
     else {
       echo '<SCRIPT LANGUAGE="JavaScript"> parent.location.href = "index.html"  </script>';
       echo "Your record has been added";
	  }
   }


  if ($action == "Update") {
  #   echo "name=".$Type."<br>";
    $query = "update $tbl_coop_contact set Company = '".$Company."',".
               "  Name = '".$Name."',".
               "  Type = '".$Type."',".
               "  Email = '".$Email."',".
               "  BillAddress1 = '".$BillAddress1."',".
               "  BillAddress2 = '".$BillAddress2."',".
               "  BillAddress3 = '".$BillAddress3."',".
               "  BillAddress4 = '".$BillAddress4."',".
               "  BillCity = '".$BillCity."',".
               "  BillState = '".$BillState."',".
               "  BillZip = '".$BillZip."',".
               "  BillCountry = '".$BillCountry."',".
               "  WorkPhone = '".$WorkPhone."',".
               "  WorkFax = '".$WorkFax."',".
               "  ShipAddress1 = '".$ShipAddress1."',".
               "  ShipAddress2 = '".$ShipAddress2."',".
               "  ShipAddress3 = '".$ShipAddress3."',".
               "  ShipAddress4 = '".$ShipAddress4."',".
               "  ShipCity = '".$ShipCity."',".
               "  ShipState = '".$ShipState."',".
               "  ShipZip = '".$ShipZip."',".
               "  ShipCountry = '".$ShipCountry."',".
               "  ShipPhone = '".$ShipPhone."',".
              "  ShipFax = '".$ShipFax."',".
              "  AltName = '".$AltName."',".
              "  AltPhone = '".$AltPhone."',".
              "  AltEmail = '".$AltEmail."',".
              "  ShipNote = '".$ShipNote."',".
              "  FTTrack = '".$FTTrack."',".
              "  OrgTrack = '".$OrgTrack."',".
              "  Truck = '".$Truck."',".
              "  Inactive = '".$Inactive."',".
              "  fob_code = '".$fob_code."',".
              "  flo_id = '".$flo_id."',".
              "  Warehouse = '".mysql_real_escape_string($Warehouse)."' where contact_id =".$contact_id;
    #echo "<br>string=".$query."<br>";


     $result = mysql_query($query, $db_conn);
     if (!$result)
        echo "<br><font size=2>Record was not updated";
     else
        echo "<br><font size=2>Record has been Updated";

  }




  mysql_select_db('coop_contact');
  $query = "select * from $tbl_coop_contact where ".$searchtype." like '%".$searchterm."%'";



  if (!$searchtype || !$searchterm)
  {
      $query = "select * from $tbl_coop_contact order by Type, Company";
  }


# $query = 'SELECT * FROM coop_contact WHERE name LIKE \'%Jones%\' LIMIT 0, 30';
 # $query = 'SELECT * FROM coop_contact;

 #  echo "<br>string=".$query."<br>";

    $result = mysql_query($query, $db_conn);

  $num_results = mysql_num_rows($result);



  echo '<font size=2> Total Contacts found: '.$num_results.' ';
#   if not $num_results   {
#     echo 'No records found, sorry, try another search';
 #  }


  $old_type = 'x';

  for ($i=0; $i <$num_results; $i++)
  {




     $row = mysql_fetch_array($result);


     if ($row['Type'] <> $old_type ) {
        echo '<hr>';
        echo "Type: ".$row['Type']."<br>";
        $old_type = $row['Type'];
     }

     echo '<p><font size=2> <a href="contactresultsright.php?searchtype=contact_id&searchterm='.$row['contact_id'].'"';
   #  echo $row['contact_id'];
     echo '  TARGET="TEXTFRAME" >(';

#    echo htmlspecialchars(stripslashes($row['contact_id']));
     echo  $row['contact_id'];

     echo ') ';
     echo stripslashes($row['Company']).'</a>';


     echo '</p>';


  }



?>

</BODY>


</HTML>
