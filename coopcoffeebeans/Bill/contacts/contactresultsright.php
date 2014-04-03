<?php

require("../../functions.php");
require("../../tables.php");
// check security
 session_start();
 require("../../check_login.php");


// function:
function fobdropdown($warehouse = "")
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

   echo '<select name="fob_code">';
   #echo '<br><option value="">';
   echo "\n";
      for ($i=0; $i <$ddnum_results; $i++)
 {
      echo '<option value="'.$ddrow['warehouse_code'].'"  ';
      if ($warehouse == $ddrow['warehouse_code'])
      {
         echo ' selected ';
      }
      echo ' >'.$ddrow['warehouse_description'];



   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";

}


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
  	echo'<title>Product Summary</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';

?>
<SCRIPT language="javascript">
function createWindow(cUrl,cName,cFeatures) {
var xWin = window.open(cUrl,cName,cFeatures)
}
</SCRIPT> 

<?






  // create short variable names


  $searchtype=$_GET['searchtype'];
  $searchterm=$_GET['searchterm'];
  $pw_update =$_GET['pw_update'];
 # echo $searchtype;
#  echo $searchterm;
  $searchterm= trim($searchterm);
  $searchtype = addslashes($searchtype);
  $searchterm = addslashes($searchterm);
        echo '<table width=100%>';
        echo '<tr><td width=70%>';
	#echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';
	echo '<font size=3 color=blue>You are logged in as '.$_SESSION['valid_user'].'</font><br>';
	echo '<font size=3><a href="../../index.php" target="_top">Back to the main Menu</a></font><br>';
  echo '<font size=3><a href="../../logout.php" target="_top">Log Out</a></font><br><br><br><br><br>'; 	

 echo '<center>';                        
 echo '<form name=frmMain action=contactresultsleft.php method=post target=BUTTONSFRAME>';
 echo '</center>';   
 
 echo '</td><td width=30%>';
 
 if ($searchterm == '0') {
	
     echo '<INPUT TYPE=SUBMIT value=Add>';
  }
 else { 
         echo '<INPUT TYPE=SUBMIT value=Update>';
         
 echo '<p><A href="javascript:createWindow(';
 echo "'setpassword.php?contact_id=$searchterm','pw_window','width=400,height=350,status,location,resizable=yes')";
 echo '">Set login Name or Password</A>';        
}
echo '</td></tr></table>';

  $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  mysql_select_db('cbeans', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

  mysql_select_db('coop_contact');
#  $query = "select * from coop_contact where ".$searchtype." = '%".$searchterm."%'";

 $query = "select * from $tbl_coop_contact where ".$searchtype." =  '".$searchterm."' ";


  if (!$searchtype || !$searchterm)
  {
      $query = "select * from $tbl_coop_contact  where contact_id = 0 order by Company";
      echo '&nbsp;&nbsp;Select record on Left to Edit';
  }


# $query = 'SELECT * FROM coop_contact WHERE name LIKE \'%Jones%\' LIMIT 0, 30';
 # $query = 'SELECT * FROM coop_contact;

#  echo $query;

    $result = mysql_query($query, $db_conn);

  $num_results = mysql_num_rows($result);

## echo '<br>'.$num_results;

#  echo '<p>Number of Contacts found: '.$num_results.'</p>';
#   if not $num_results   {
#     echo 'No records found, sorry, try another search';
 #  }


 # echo '<form name="frmMain" action=contactresultsleft.php method=post target="BUTTONSFRAME">';

  
  print "<table>";
#  for ($i=0; $i <$num_results; $i++)
 # {


     echo '<input  type="hidden" name="action" value="';

   if  ($num_results == 0)
      echo 'Add';
   else
      echo 'Update';


   echo  '">';



     $row = mysql_fetch_array($result);

     print"<tr><td>";

     echo '<input type=hidden name=contact_id size=10 value="';
     echo stripslashes($row['contact_id']);
     echo '">';

     echo '<b>('.$row['contact_id'].')   company: ';

     print "</td><td>";

     echo '<input type=text name=Company size=40 value="';
     echo stripslashes($row['Company']);
     echo '"></td></tr>';

     print"<tr><td>";
     echo '<b>Type:</td><td><select name=Type>';
     echo '<option value="C" ';
     if ($row['Type'] == "C")
         echo ' selected>Customer';
      else
         echo '>Customer';


     echo "<br>";
     echo '<option value="V"';
      if ($row['Type'] == "V")
           echo ' selected>Vendor';
      else
         echo '>Vendor';
     echo "<br>";

     echo "<br>";
     echo '<option value="3"';
      if ($row['Type'] == "3")
           echo ' selected>Bank';
      else
         echo '>Bank';
     echo "<br>";

     echo "<br>";
     echo '<option value="A"';
      if ($row['Type'] == "A")
           echo ' selected>Admin';
      else
         echo '>Bill';
     echo "<br>";


     echo "<br>";
     echo '<option value="4"';
      if ($row['Type'] == "4")
           echo ' selected>Dupuy';
      else
         echo '>Dupuy';
     echo "<br>";


     echo "<br>";
     echo '<option value="5"';
      if ($row['Type'] == "5")
           echo ' selected>Affiliated';
      else
         echo '>Affiliated';
     echo "<br>";
     
      echo "<br>";
     echo '<option value="7"';
      if ($row['Type'] == "7")
           echo ' selected>Continental';
      else
         echo '>Continental';
     echo "<br>";
    
   
     echo '<option value="8"';
      if ($row['Type'] == "8")
           echo ' selected>All Jays';
      else
         echo '>All Jays';
     echo "<br>";
    
    
         echo '<option value="9"';
      if ($row['Type'] == "9")
           echo ' selected>Annex Consolidation Center';
      else
         echo '>Annex Consolidation Center';
     echo "<br>";

 
     
       echo '<option value="10"';
      if ($row['Type'] == "10")
           echo ' selected>Spectrum';
      else
         echo '>Spectrum';
     echo "<br>";

     echo '</select>';


     echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Inactive: <input type=checkbox name="Inactive"';

     if ($row['Inactive'] == "1")
         echo ' Checked>';
      else
         echo '>';

     print "</td></tr>";

     print "<tr><td>";
     echo '<b>Name: </td><td>';
     echo '<input type=text name=Name size=40 value="';
     echo $row['Name'];
     echo '"></td></tr>';

     print "<tr><td>";
      echo '<b>Email Address:';
     print "</td><td>";
     echo '<input type=text name=Email size=40 value="';
     echo $row['Email'];
     echo '">';
     print "</td></tr>";


     print "<tr><td>";
      echo '<b>Work Phone:';
     print "</td><td>";
     echo '<input type=text name=WorkPhone size=40 value="';
     echo $row['WorkPhone'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Work Fax:';
     print "</td><td>";
     echo '<input type=text name=WorkFax size=40 value="';
     echo $row['WorkFax'];
     echo '">';
     print "</td></tr>";

     print "<tr><td colspan=2><hr></td></tr>";

     print "<tr><td>";
      echo '<b>Billing Address 1:';
     print "</td><td>";
     echo '<input type=text name=BillAddress1 size=40 value="';
     echo $row['BillAddress1'];
     echo '">';
     print "</td></tr>";


     print "<tr><td>";
      echo '<b>Billing Address 2:';
     print "</td><td>";
     echo '<input type=text name=BillAddress2 size=40 value="';
     echo $row['BillAddress2'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Billing Address 3:';
     print "</td><td>";
     echo '<input type=text name=BillAddress3 size=40 value="';
     echo $row['BillAddress3'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Billing Address 4:';
     print "</td><td>";
     echo '<input type=text name=BillAddress4 size=40 value="';
     echo $row['BillAddress4'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>City:';
     print "</td><td>";
     echo '<input type=text name=BillCity size=40 value="';
     echo $row['BillCity'];
     echo '">';
     print "</td></tr>";


     print "<tr><td>";
      echo '<b>State / Zip:';
     print "</td><td>";
     echo '<input type=text name=BillState size=10 value="';
     echo $row['BillState'];
     echo '">&nbsp;&nbsp;';
     echo '<input type=text name=BillZip size=15 value="';
     echo $row['BillZip'];
     echo '">';

     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Country:';
     print "</td><td>";
     echo '<input type=text name=BillCountry size=40 value="';
     echo $row['BillCountry'];
     echo '">';
     print "</td></tr>";


     print "<tr><td colspan=2><hr></td></tr>";

     print '<tr><td>';
     print '<b>FOB City:</b>';
     print '</td><td>';
     fobdropdown($row['fob_code']);
     print "</td></tr>";

     print "<tr><td colspan=2><hr></td></tr>";
   # now shipping address if different
     print "<tr><td>";
      echo '<b>Shipping Address 1:';
     print "</td><td>";
     echo '<input type=text name=ShipAddress1 size=40 value="';
     echo $row['ShipAddress1'];
     echo '">';
     print "</td></tr>";


     print "<tr><td>";
      echo '<b>Shipping Address 2:';
     print "</td><td>";
     echo '<input type=text name=ShipAddress2 size=40 value="';
     echo $row['ShipAddress2'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Shipping Address 3:';
     print "</td><td>";
     echo '<input type=text name=ShipAddress3 size=40 value="';
     echo $row['ShipAddress3'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Shipping Address 4:';
     print "</td><td>";
     echo '<input type=text name=ShipAddress4 size=40 value="';
     echo $row['ShipAddress4'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>City:';
     print "</td><td>";
     echo '<input type=text name=ShipCity size=40 value="';
     echo $row['ShipCity'];
     echo '">';
     print "</td></tr>";


     print "<tr><td>";
      echo '<b>State / Zip:';
     print "</td><td>";
     echo '<input type=text name=ShipState size=10 value="';
     echo $row['ShipState'];
     echo '">&nbsp;&nbsp;';
     echo '<input type=text name=ShipZip size=15 value="';
     echo $row['ShipZip'];
     echo '">';

     print "</td></tr>";


     print "<tr><td>";
      echo '<b>Country:';
     print "</td><td>";
     echo '<input type=text name=ShipCountry size=40 value="';
     echo $row['ShipCountry'];
     echo '">';
     print "</td></tr>";

     print "<tr><td colspan=2><hr></td></tr>";

     print "<tr><td>";
      echo '<b>Ship Phone:';
     print "</td><td>";
     echo '<input type=text name=ShipPhone size=40 value="';
     echo $row['ShipPhone'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Ship Fax:';
     print "</td><td>";
     echo '<input type=text name=ShipFax size=40 value="';
     echo $row['ShipFax'];
     echo '">';
     print "</td></tr>";

     print "<tr><td colspan=2><hr></td></tr>";


     print "<tr><td>";
     echo '<b>Alternative Name: </td><td>';
     echo '<input type=text name=AltName size=40 value="';
     echo $row['AltName'];
     echo '"></td></tr>';

     print "<tr><td>";
      echo '<b>Alternative Email:';
     print "</td><td>";
     echo '<input type=text name=AltEmail size=40 value="';
     echo $row['AltEmail'];
     echo '">';
     print "</td></tr>";



     print "<tr><td>";
      echo '<b>Alternative Phone:';
     print "</td><td>";
     echo '<input type=text name=AltPhone size=40 value="';
     echo $row['AltPhone'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Alternative Fax:';
     print "</td><td>";
     echo '<input type=text name=AltFax size=40 value="';
     echo $row['AltFax'];
     echo '">';
     print "</td></tr>";

     print "<tr><td colspan=2><hr></td></tr>";

     print "<tr><td>";
     echo '<b>Shiping Note: </td><td>';
     echo '<textarea name="ShipNote" cols=50 rows=4>';
     echo $row['ShipNote'];
     echo '</textarea></td></tr>';


     print "<tr><td>";
      echo '<b>Ft Track:';
     print "</td><td>";
     echo '<input type=text name=FTTrack size=10 value="';
     echo $row['FTTrack'];
     echo '">';
     echo '&nbsp;&nbsp;<strong>FLO-ID:</strong>&nbsp;';
     echo '<input type=text name=flo_id size=10 value="';
     echo $row['flo_id'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Org Track:';
     print "</td><td>";
     echo '<input type=text name=OrgTrack size=50 value="';
     echo $row['OrgTrack'];
     echo '">';
     print "</td></tr>";

     print "<tr><td>";
      echo '<b>Truck:';
     print "</td><td>";
     echo '<input type=text name=Truck size=50 value="';
     echo $row['Truck'];
     echo '">';
     print "</td></tr>";


     print "<tr><td>";
      echo '<b>Warehouse:';
     print "</td><td>";
     echo '<input type=text name=Warehouse size=50 value="';
     echo $row['Warehouse'];
     echo '">';
     print "</td></tr>";




 #    echo '<b>Inactive:</td><td><input type=checkbox name="Inactive"';

#     if ($row['Inactive'] == "1")
 #        echo ' Checked>';
 #     else
  #       echo '>';


  #  echo '<p><b>'.($i+1).'. company: ';
#    echo htmlspecialchars(stripslashes($row['title']));
 #    echo  $row['Company'];

 # next line
#  }

      echo "</table>";


?>
</form>

<CENTER>| <A href="http://www.coopcoffeesbeans.com/index.html"
target=_top>Home Page</A> |<BR>
<P></P>
<P align=center><FONT size=-2>This online environment created
by:<BR><ALIGN=CENTER><A href="mailto:goshawk@gypsyfarm.com">Gypsyfarm
(sm)</A></FONT> </P></CENTER>

</BODY>


</HTML>
