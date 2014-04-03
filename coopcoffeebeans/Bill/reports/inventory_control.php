<?php
require("../../functions.php");
require("../../tables.php");
// check security
 session_start();
// check session variable
 
  if (isset($_SESSION['valid_user']))
  {
    $valid_user =  $_SESSION['valid_user'];	
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
  }
  
 

require("../../control_rpt_classes.php");
 

function IUD_coop_item_notes($IUD_flag, $seq, $item_code,$year,$user)  {
 
   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('greenbeans', $db_conn);
   global $note;

   if (!$db_conn)
   {
     $message .=  'Error: Could not connect to database.  Please try again later.';
     return $message;
   }
   
    $current_date = date('Y-m-d H:i:s');
 
   $note  = $_REQUEST['note'];
   $create_date  = "";
   $create_user  = $_SESSION['valid_user'];
   $modify_date  = "";
   $modify_user  = $_SESSION['valid_user'];
 
    mysql_select_db(coop_item_misc);
    
    if ($IUD_flag == 'I') {
    $create_date  = $current_date;
    $query = "INSERT INTO coop_item_notes 
    ( item_code, year, note, create_date, create_user, modify_date, modify_user) 
     VALUES ('$item_code', '$year', '$note', '$create_date', '$user', '$modify_date', '' )";
     }
     else {
     $create_date  = $_REQUEST['create_date'];
     $modify_date  = $current_date;
     $query = "UPDATE coop_item_notes 
               set note = '$note',
                   modify_date = '$modify_date',
                   modify_user = '$user' 
               where item_code = '$item_code'
                 and $year = '$year'";
     }
    
    $result = mysql_query($query, $db_conn);
    
    

    # echo "<br>$query <br>";
}

 
 
 function IUD_coop_item_misc($IUD_flag, $seq, $item_code,$year)
   {
   
   $message .= "Start in Function";

   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('greenbeans', $db_conn);

   if (!$db_conn)
   {
     $message .=  'Error: Could not connect to database.  Please try again later.';
     return $message;
   }
 
   $lead_time  = $_REQUEST['lead_time'];
   $safety_stock  = $_REQUEST['safety_stock'];
   $year_end_target  = $_REQUEST['year_end_target'];
   $shipping_season  = $_REQUEST['shipping_season'];
   $form_contact_id  = $_REQUEST['form_contact_id'];
   $spot  = $_REQUEST['spot'];
   $spot_with_safety  = $_REQUEST['spot_with_safety'];
 
    mysql_select_db(coop_item_misc);
    
    if ($IUD_flag == 'I') {
    $query = "INSERT INTO coop_item_misc 
    ( item_code, year, lead_time, safety_stock, year_end_target, shipping_season, contact_id) 
     VALUES ('$item_code', '$year', '$lead_time', '$safety_stock', '$year_end_target', '$shipping_season','$form_contact_id' )";
     }
     else {
     $query = "UPDATE coop_item_misc 
               set lead_time = '$lead_time',
                   safety_stock = '$safety_stock',
                   year_end_target = '$year_end_target', 
                   shipping_season = '$shipping_season',
                   contact_id = '$form_contact_id',
                   spot = '$spot',
                   spot_with_safety = '$spot_with_safety'
               where item_code = '$item_code'
                 and $year = '$year'";
     }
    
    $result = mysql_query($query, $db_conn);

   #   echo "<br>$query <br>";
}


  function GetItemDescription($item_code = "")
   {

   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('greenbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }

global $tbl_item_description;
global $tbl_order_item;
   $query = "SELECT DISTINCT i.item_description FROM $tbl_item_description i where i.item_code = '$item_code'  ";

 #  echo "<br> $query <br>";
   mysql_select_db('item_description');
      $ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "too bad too sad"; }


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);
    echo $ddrow['item_description'];


}


echo'<html>';
echo'<head>';
echo'<title>Product Inventory Report</title>';
echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
echo'<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">';
echo'</head>';
echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';

echo '<script src="../../js/prototype.js" type="text/javascript"></script>';  
echo '<script type="text/javascript">';  
echo 'function ajaxUpdater(id,url) {';  
 echo 'new Ajax.Updater(id,url,{asynchronous:true}); '; 
echo '}';  
echo '</script>';  


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

$item_code  = $_REQUEST['new_product'];

if ( !isset($item_code) || $item_code == "") {
	$item_code = 'BOA';
}


echo '<form method=POST action=inventory_control.php>';


echo '<br>';
echo "<table><tr><td>";
echo 'Choose an Item:';
newitemdropdown($item_code);
 echo "&nbsp;&nbsp;&nbsp;";
 GetItemDescription($item_code);
echo "</td><td>";
echo '<input type="SUBMIT" name="ACTION" value="View">';

echo "</td><td>";
$year_range = $current_year;   
# $from_year;
if (isset($_REQUEST['year_range'])) {
   $year_range=$_REQUEST['year_range'];
    
}

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

 echo '</select> ';
 
 echo '<br>'; 

echo "</td>";
echo "<td  width='50%' align='right'>";
echo "<br>";
echo "<span class='blueBold'>$button_message </span>";
echo "<br>";
echo "\n";

echo '<input type="SUBMIT" name="ACTION" value="Update">';
echo "</td>";
echo "</tr></table>";



echo "<p>";


if ($_REQUEST['ACTION'] == 'View') {
	# nothing yet.
}





 $ControlReport = new myControlReport(1,2);


$ControlReport->item_code = $item_code;
echo "\n";
echo $ControlReport->StartTable();

$ControlReport->Startrow("");

$content =  "Current Inventory On Hand";
$class = 'color1';
echo $ControlReport->CreateCell($content,$class,1);

$content =  "Containers On Water";
$class = 'color1';
echo $ControlReport->CreateCell($content,$class,1);

$content =  "Confirmed Contracts";
$class = 'color1';
echo $ControlReport->CreateCell($content,$class,1);

echo $ControlReport->EndRow();
 

 
echo $ControlReport->Startrow(""); 

$content =  $ControlReport->OnHandTable();
$class = 'gbr1';
echo $ControlReport->CreateCell($content,$class,1);


$content =  $ControlReport->OnWaterTable();
$class = 'gbr1';
echo $ControlReport->CreateCell($content,$class,1);


$content =  $ControlReport->FutureTable();
$class = 'gbr1';
echo $ControlReport->CreateCell($content,$class,1);

echo $ControlReport->EndRow(); 
 
echo $ControlReport->EndTable(); 

echo "<p>"; 
 
echo "\n";


echo "<TABLE cellSpacing=2 cellPadding=2 width='100%' border=3>";

$ControlReport->Startrow("");

echo "<td width='50%' >";

$ControlReport->set_other_totals($year_range,$ControlReport->item_code);


# get misc fields:

 
   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('greenbeans', $db_conn);

   if (!$db_conn)
   {
     $message .=  'Error: Could not connect to database.  Please try again later.';
     return $message;
   }
 
 /*
 SELECT m.*, c.First_Name, c.Last_Name, c.Email, c.Phone FROM coop_item_misc m
             left join contact_contact c on c.contact_id = 137
             where item_code = 'BOA' 
               and year = '2008' ";
      
 
 */
 
 
  $contact_id  = $_REQUEST['form_contact_id'];
 
   $query = "SELECT item_code   FROM coop_item_misc  
             where item_code = '$ControlReport->item_code' 
               and year = '$year_range' ";
      
        
               
               
    $myresults = mysql_query($query, $db_conn);
    if (!$myresults) { 
    	$message .=  "warehouse query failed"; 
    }
    
    
 
    $action = $_REQUEST['ACTION'];
    
    
    $mynum_results = mysql_num_rows($myresults);
    

 
     if ($_REQUEST['ACTION'] == 'Update') {
     	     $lead_time  = $_REQUEST['lead_time'];
             $safety_stock  = $_REQUEST['safety_stock'];
             $year_end_target  = $_REQUEST['year_end_target'];
             $shipping_season  = $_REQUEST['shipping_season'];
             $form_contact_id  = $_REQUEST['form_contact_id'];
            
         if ($mynum_results == 0 ) {
    	    $message .= IUD_coop_item_misc("I",$seq, $ControlReport->item_code,$year_range);
          }
         else {
	     $message .= IUD_coop_item_misc("U",$seq, $ControlReport->item_code,$year_range);
          }
         
     }


   $query = "SELECT m.*,  c.First_Name, c.Last_Name, c.Email, c.Phone   FROM coop_item_misc m 
             left join contact_contact c on c.contact_id = m.contact_id  
             where item_code = '$ControlReport->item_code' 
               and year = '$year_range' ";
      
        
               
               
    $myresults = mysql_query($query, $db_conn);
    if (!$myresults) { 
    	$message .=  "warehouse query failed"; 
    }

   

        if ($mynum_results == 0 ) {
    	   $button_message = "press update to add record";
    	   $seq = 0;
    	   $lead_time = "";
    	   $safety_stock = "";
    	   $year_end_target = "";
    	   $shipping_season = "";
    	   $form_contact_id = "";
    	   $spot = "";
    	   $spot_with_safety = "";
         }
         else {
  	         	    $myrow = mysql_fetch_array($myresults);
    	    $seq = $myrow['seq'];
    	    $lead_time = $myrow['lead_time'];
    	    $safety_stock = $myrow['safety_stock'];
    	    $year_end_target = $myrow['year_end_target'];
    	    $shipping_season = $myrow['shipping_season'];
    	    $First_Name = $myrow['First_Name'];
    	    $Last_Name = $myrow['Last_Name'];
    	    $form_contact_id = $myrow['contact_id'];
    	    $Email = $myrow['Email'];
    	    $Phone = $myrow['Phone'];
    	    $spot = $myrow['spot'];
    	    $spot_with_safety = $myrow['spot_with_safety'];
	    $button_message = "Use update button to modify record";
         }

 
 


#end get misc fields


#start get noes


 
   mysql_select_db('greenbeans', $db_conn);

   if (!$db_conn)
   {
     $message .=  'Error: Could not connect to database.  Please try again later.';
     return $message;
   }
 
   $query = "SELECT * FROM coop_item_notes 
             where item_code = '$ControlReport->item_code' 
               and year = '$year_range' ";
               
               
    $myresults = mysql_query($query, $db_conn);
    if (!$myresults) { 
    	$message .=  "Note query failed"; 
    }
    
    
 
    $action = $_REQUEST['ACTION'];
 
    
    $mynum_results = mysql_num_rows($myresults);
 
  
 
  
    if ($action == 'Update Note') {           
         if ($mynum_results == 0 ) {
    	    $message .= IUD_coop_item_notes("I",$seq, $ControlReport->item_code,$year_range,$_SESSION['valid_user']);
          }
         else {
	     $message .= IUD_coop_item_notes("U",$seq, $ControlReport->item_code,$year_range,$_SESSION['valid_user']);
          }
        }
     else {
          if ($mynum_results == 0 ) {
    	   $note_message = "press update to add record";
    	   $note= "";
         }
         else {
    	    $myrow = mysql_fetch_array($myresults);
    	    $note= $myrow['note'];
    	    $create_date= $myrow['create_date'];
    	    $modify_date= $myrow['modify_date'];
    	    $create_user= $myrow['create_user'];
    	    $modify_user= $myrow['modify_user'];
	    $note_message = "Use update button to modify note";
         }   
    } 
 

#end Get notes




echo "</td> <td  align='left'> ";

echo "<input type='hidden' name='seq' value='$seq'>";
echo "\n";
echo "\n";

echo "<table><tr><td>";
echo "Lead: <br>"; 
echo "<input type='text' name='lead_time' value='$lead_time' >";
echo "</td>";
echo "\n";

 echo "<td>";
echo "Safety: <br>"; 
echo "<input type='text' name='safety_stock' value='$safety_stock'>";
echo "</td>";
echo "</tr>";
echo "\n";


$ControlReport->set_monthly_totals($year_range,$ControlReport->item_code);
echo "<tr><td>";
echo "Year End Estimate: ";
echo "<br>";

$year_end_estimate = ($ControlReport->on_hand_total + $ControlReport->on_water_total + $ControlReport->contract_total) - $ControlReport->difference;
 
echo "<input type='text' name='year_end_estimate' value='$year_end_estimate'>";
echo "</td><td>";

echo "Year End Needed: "; 
echo "<br>";
echo "<input type='text' name='year_end_target' value='$year_end_target'>";
echo "<br>";
echo "</td></tr>";

echo "<tr><td>";
echo "Spot: <br>"; 
echo "<input type='text' name='spot' value='$spot' >";
echo "</td>";
echo "\n";

 echo "<td>";
echo "Spot with Safety: <br>"; 
echo "<input type='text' name='spot_with_safety' value='$spot_with_safety'>";
echo "</td>";
echo "</tr>";
echo "\n";

echo "</table>";
echo "\n";

echo "</td>";

echo "<td align='center'>";
 

echo "Shipping Season: ";
echo "<input type='text' maxlength=25 size=20 name='shipping_season' value='$shipping_season'>";
echo "<br>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact : ";  
 
echo '<input type="text" name="form_contact_id"  size=20  title="Contact_id" value="'.$form_contact_id.'"> '; 
echo "\n";



echo "<br>";
echo "<span class='blueBold'>$button_message </span>";
echo "<br>";
echo "\n";
/*
echo '<input type="SUBMIT" name="ACTION" value="Update">';

*/
echo "<br>";
echo $message;

echo "</td>";
 


echo $ControlReport->EndRow(); 
 
echo $ControlReport->EndTable(); 

echo "<p>"; 
 
echo "\n";


#Item totals

 $ControlReport->tablewidth = '100%';

#$ControlReport->set_monthly_totals($year_range,$ControlReport->item_code);
echo $ControlReport->set_monthly_totals_output;
echo "<p>"; 
 
echo "\n";


$next_year = $year_range + 1;
$ControlReport->set_next_year_commits($next_year,$ControlReport->item_code); 

#  echo  $ControlReport->readme;
#echo "<br>action =  $action <br>";
#echo "<br> user is ".$_SESSION['valid_user']."<br>";


echo "<TABLE cellSpacing=2 cellPadding=2 width='100%' border=3>";

$ControlReport->Startrow("");
echo "<td>";
#echo "Contact : ";  
#echo '<input type="text" name="form_contact_id" title="Contact_id" value="'.$form_contact_id.'"> '; 

echo "<br>";
echo "Contact: $First_Name $Last_Name   ";
echo "<br>";
echo "Phone: $Phone  "; 
echo "<br>";
echo "Email: $Email    ";

# echo '<input type="button" value=" go " onClick="sendRequest(this.form, \'process.php\')"> '; 

echo "  ";
#echo '<input type="button" value="Check Contact" onClick="ajaxUpdater(\'updateme\',\'updateme.php\')"> '; 
echo "<p>";
echo '<div id="updateme"></div>'; 

echo "</td><td>";
 echo 'Notes: ';
  
      echo "\n";
 
	  echo "<textarea name='note' cols=100 rows=3>";
	  echo str_replace('"', '&#34', $note);
	  echo "</textarea>";
      echo "\n";
      echo "</td><td>";
              echo "Created By $create_user on $create_date <br>";
              echo "last modified by $modify_user on $modify_date <br>";
              echo '<input type="SUBMIT" name="ACTION" value="Update Note">';
echo "</td>";
echo $ControlReport->EndRow(); 
 
echo $ControlReport->EndTable(); 

echo '</form>';

//echo "ok debug<br>";
//echo  $ControlReport->readme;

 if (!ISSET($_SESSION['contact_id'])) {
       $_SESSION['contact_id']	 = 'xxxx';
}

?>