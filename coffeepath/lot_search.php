<?php
require("connection.php"); 
 
 require("phpclasses.php");

$coop_id  = $_REQUEST['coop_id'];
$rst_id  = $_REQUEST['rst_id'];
#$rst_id  = $HTTP_GET_VARS['rst_id'];
$trace1 = $HTTP_POST_VARS['trace1'];
$trace2 = $HTTP_POST_VARS['trace2'];
$btn1 = $HTTP_POST_VARS['btn1'];
$btn2 = $HTTP_POST_VARS['btn2'];

/*
if ($trace2 == 'Trace Lot # from a Farming Cooperative') {
	$type = 'Coop';
}
elseif ($trace1 == 'Trace Lot # from a Roaster') {
    $type = 'Roaster';
}
*/
if ($btn2 != "") {
	header('Location: http://www.scribd.com/doc/134638/GUA62Con' );
}
elseif ($btn1 != "") {
	header($doc_trail );
}
elseif ($rst_id > 0) {
	$type = 'Roaster';
}
elseif ($coop_id > 0) {
	$type = 'Coop';
}
	

 
function BuildLotList($item_code) {
	global $db_conn2;
	
	 mysql_select_db(coop_item);    
	 
    
               
               $query = "select ci.item_id, ci.item_code, ci.lot_ship, ci.mark  
                          from coop_item ci 
                         where ci.item_code like '$item_code' 
                           and ship_date >  '01/10/2007'";
                           
         $result = mysql_query($query, $db_conn2);
       $num_results = mysql_num_rows($result);
        $row = mysql_fetch_array($result);
 
     for ($i=0; $i <$num_results;  $i++)  {
	$item = $row['item_id'];
	$item_code = $row['item_code'];
	$lot_ship = $row['lot_ship'];
	$mark = $row['mark'];
	
	if ($mark != "") {
            echo '&nbsp;<a href="scribd_example.php"> ';
            
            echo "$item_code $lot_ship - $mark ";
            echo ' </a><br>';
        }

   $row = mysql_fetch_array($result);	
	}
# end for loop. 
}



function BuildRoasterList($customer) {
	global $db_conn2;
	
	 mysql_select_db(coop_item);    
	 
          $OneYearPast = mktime(0, 0, 0, date("m"), date("d"), date("y") -1);
 
          $FormatedDate = date("Y/m/d", $OneYearPast);
               
               $query = "SELECT ci.mark, oi.item_code,   ci.lot_ship 
          FROM item_description id, order_item oi, lot_item li,
           order_header oh, coop_item ci
          WHERE oi.item_id = li.item_id
          AND oi.item_code = id.item_code
          AND li.lot_ship = ci.item_id
          AND oi.header_key = oh.header_id
          AND oh.customer_key = '$customer'
          AND oh.order_date > '$FormatedDate'
          group by ci.mark, oi.item_code, ci.lot_ship
                    order by oi.item_code , ci.lot_ship"; 
   
       
                           
         $result = mysql_query($query, $db_conn2);
       $num_results = mysql_num_rows($result);
        $row = mysql_fetch_array($result);
        echo "Nbr Lots: $num_results <br>";
        
               
 
     for ($i=0; $i < $num_results;  $i++)  {
	$item = $row['item_id'];
	$item_code = $row['item_code'];
	$lot_ship = $row['lot_ship'];
	$mark = $row['mark'];
	
	if ($mark != "") {
            echo '<a href="scribd_example.php"> ';
            
            echo "$item_code $lot_ship - $mark ";
            echo ' </a><br>';
        }

   $row = mysql_fetch_array($result);	
	}
# end for loop. 
}

function GetRoasterRecord($rst_id) {
    global $db_conn;
    global $name;
    global $contact;
    global $content;
mysql_select_db('trf_roaster_content');


  $query = "select * 
            from trf_roaster_content
             where ft_id =  $rst_id;";

 
# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);
 $name = $row['roaster_name'];
 $name = str_replace(" '", "'", $name);
 $contact = $row['contact'];
 $content = $row['content'];
 
	
}

function GetCoopRecord($coop_id) {
    global $db_conn;
    global $name;
    global $contact;
    global $content;
mysql_select_db('trf_coop_content');


  $query = "select * 
            from trf_coop_content
             where coop_id =  '$coop_id';";

# echo "<br>$query <br>";
# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);
 $name = $row['coop_name'];
 $name = str_replace(" '", "'", $name);
 $contact = $row['contact'];
 $content = $row['content'];
 
	
}


?>


 
<HTML>
<HEAD>
    <TITLE>Fair Trade Proof page</TITLE>
  
<meta name="description" content="Fair Trade Proof is maintained by Cooperative Coffees">

<meta name="keywords" content="freetrade, cooperative coffees ">

  

<link rel="stylesheet" type="text/css" href="default.css">

<style>
#input_box1 { background-color:yellow; }
#input_box2 { background-color:yellow; }
</style>


<script language="Javascript">
 
function nav(dropdown)
   {
 
   var w = dropdown.selectedIndex;
   var url_add = dropdown.options[w].value;
   window.location.href = url_add;
   }
   

</script>

</HEAD>
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec" >


<center>
<form name=frmMain method=post action='lot_search.php?coop_id=Fondo_Paez'>


<table width=100%>
<tr>
<td>
 <div class="greyone">
  COFFEE <br> PATH
 </div>
 </td>
 <td align='center'>
<?php
$RoasterBox = new myRoasterBox("");
$RoasterBox->displayBox();
?>
 </td>
 <td align='center'>
<?php
$CoopBox = new myCoopBox("");
$CoopBox->displayBox();

?>
 </td>
 <td>
  <div class="corners">
 Our black background minimizes <br>energy, reducing climate change
 <p>
  </div>
  <div class="corners">
  Fair Trade Proof is maintained by Cooperative Coffees 
</div>
 </td>
 </tr>
 </table>
 <p>
 
 
<hr>
 
  
 
 <div class="whiteone">

 
 
<?php

 
#echo " type is $type <br>";
if (isset($trace1)) {
 #  echo "You pushed the button that says: '$trace1' <br>";
   $type = 'Roaster';
}

if (isset($trace2)) {
 # echo "You pushed the button '$trace2' <br>";
  $type = 'Coop';
}


echo "</div>";

 
if ($type == "Roaster") {

     GetRoasterRecord($rst_id);
  #   echo "<p>";
   #  BuildRoaster();
}
elseif ($type == "Coop") {
   # BuildCoop();
     GetCoopRecord($coop_id);	
}


 
?>  



<table width=90%>
<tr>
<td valign="top" align="left" width=75%>
<div class="yellow_heading">
<?php
echo $name;
?>
</div>

<div class="whiteone">
<?php
echo $contact;
?>
</div>

<div>
<?php
echo "$content";
?>
</div>
 
<!-- image 1 -->
<!-- image 2 -->
 

</td>
<td valign="top" width=25%>
<div style="width:160px;  ;border:3px solid yellow;">

<div>

 <div class="whiteone">
 <center>
Step 1<br>
</div>
 
<div  class="center">
<INPUT TYPE="SUBMIT" id="btn1" name="btn1" VALUE="Learn
what each
document
means" class="n1btn"> 
</div>

 
<div class="whitetwo">
step 2<br>
choose the<br> 
lot you want<br>
to trace
</div>

<p>
 
 <?php 
 if ($type == "Roaster") {
 	
     echo "<!--";	
    echo "<div class='whitetwo'>";
    echo '<input type="text" style="width:100px" name="lot_nbr"> <p />';
    echo '<INPUT TYPE="SUBMIT" id="btn2" name="btn2" VALUE="Search" class="n1btn"> ';
    echo '</div>';
    
    

    echo "<p>";
    echo '<div class="whitetwo">';
    echo 'How to Find <br>';
    echo 'Your Lot #';

    echo '</div>';
    
    echo "-->";
    
    
    
     echo '<div class="whitethree">';
     BuildRoasterList('18');
     
     echo '</div>';    
    
}
elseif ($type == "Coop") {
     echo '<div class="whitetwo">';
   #  echo '<a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank"> 16/2452/001 </a><br>';
    # echo '<a href="scribd_example.php"> 16/2452/006 </a><br>';
    # echo '<a href="scribd_example.php" >16/2452/004 </a><br>';
    # echo '<a href="scribd_example.php">16/2452/001 </a><br>';
    # echo '<a href="scribd_example.php">16/2454/003 </a><br>';
    
     
     echo '</div>';	
     
     echo '<div class="whitethree">';

     BuildLotList('COP');
     
     echo '</div>';	
     
}
 

?>



</center>
</div>

</div>
</td>
</tr>
</table>

</div>
</form>
</BODY>
</HTML>
