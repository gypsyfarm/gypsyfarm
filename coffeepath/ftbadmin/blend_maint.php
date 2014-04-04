<?php
 
session_start();  

  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coffeepath.org/ftbadmin/index.php");
  }

require("../connection.php"); 
require("phpclasses.php");
 
 
$rst_id = $_SESSION['rst_id'];
$trace1 = $_POST['trace1'];
$update = $_POST['update'];
$ft_id = SetCoopId($rst_id);

$Coop = "";
if ($submit == 'Submit') {
  $test = "test";	
    
}


if ($_REQUEST['delete'] == "yes") {
	 mysql_select_db('trf_roaster_blend_table');
	 $seqkey = $_REQUEST['seqkey'];
	 $additionalkey = $_REQUEST['additionalkey'];
	 $roasterBlendCode =  $_REQUEST['bc'];
	 
	 $query = " delete from trf_roaster_blend_table 
	            where seq = '$seqkey' 
	              and ft_id = '$additionalkey'
	              and roaster_blend_code = '$roasterBlendCode' ";
	$delete_lot = mysql_query($query, $db_conn);
	
	 $test= $query;
	
	
}

	
 
if ($update == 'Enter') {


         $roaster_blend_code = $_POST['roaster_blend_code'];
         $green_lot_1 = $_POST['green_lot_1'];	
         $green_lot_2 = $_POST['green_lot_2'];
         $green_lot_3 = $_POST['green_lot_3'];
         $green_lot_4 = $_POST['green_lot_4'];
         $green_lot_5 = $_POST['green_lot_5'];
         $green_lot_6 = $_POST['green_lot_6'];
	
        mysql_select_db('trf_roaster_blend_table');
        $query = "Select * from trf_roaster_blend_table where roaster_blend_code = '$roaster_blend_code'";
        $update_lot = mysql_query($query, $db_conn);
        
        $RoasterLots = mysql_query($query, $db_conn);
        $num_lots = mysql_num_rows($RoasterLots);

 
      $coop_id = SetCoopId($rst_id);
     
      #$test = $test."test for lot = ".$num_lots.".<br>";
     
     mysql_select_db('trf_roaster_blend_table');
     if ($num_lots > 0) {  
     	 $query = " update trf_roaster_blend_table 
                     set roaster_blend_code =  '$roaster_blend_code', 
                        green_lot_1 = '$green_lot_1',
                        green_lot_2 = '$green_lot_2',
                        green_lot_3 = '$green_lot_3',
                        green_lot_4 = '$green_lot_4',
                        green_lot_5 = '$green_lot_5',
                        green_lot_6 = '$green_lot_6'
                    where ft_id =  $ft_id and roaster_blend_code = '$roaster_blend_code'";
                    
           $test = $test."Update sql = ".$query."<br>";
       
         $update_lot = mysql_query($query, $db_conn);
       }
       else {
       	 $query = " insert into trf_roaster_blend_table 
                     values(NULL,  '$coop_id', '$roaster_blend_code', 
                           '$green_lot_1',
                           '$green_lot_2',
                           '$green_lot_3',
                           '$green_lot_4',
                           '$green_lot_5',
                            '$green_lot_6')";
                    
            $test = $test."insert sql = ".$query."<br>";
          $insert_lot = mysql_query($query, $db_conn);
        }
      
    
}	

 
?>
 


 
<HTML>
<HEAD>
    <TITLE>Blend Maint page</TITLE>
  
<meta name="description" content="Fair Trade Proof is maintained by Cooperative Coffees">

<meta name="keywords" content="freetrade, cooperative coffees ">

  

<link rel="stylesheet" type="text/css" href="default.css">

<style>
#input_box1 { background-color:yellow; }
#input_box2 { background-color:yellow; }
</style>

</HEAD>
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec" background="images/bg.gif" bgproperties="fixed">


<center>


<form name=frmMain method=post action='blend_maint.php'>


<table width=100%>
<tr>
<td>
 <div class="grey_heading2">
FAIR TRADE PROOF
 </div> 
 </td>
<td>
 
&nbsp;
 </td>
 <td>
&nbsp;
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

#  echo "<br>$test<br>";
# echo " ft_id  is $ft_id <br>";
if (isset($trace1)) {
 #  echo "You pushed the button that says: '$trace1' <br>";
   $type = 'Roaster';
}

if (isset($trace2)) {
 # echo "You pushed the button '$trace2' <br>";
  $type = 'Coop';
}

#echo " after type is $type <br>";
echo "</div>";


 
?>  
 
<div class="float">  
	  <ul id="nav">
		<li id="t-home"><a href="index.php">&nbsp;&nbsp;Home&nbsp;&nbsp;</a><p>&nbsp;<p></li>
		<li id="t-lot"><a href="lot_maint.php"> Lot Maint </a><p>&nbsp;<p></li>
		<li id="t-blend"><a href="blend_maint.php"> Blend Maint </a><p>&nbsp;<p></li>
		<li id="t-roaster"><a href="roaster_maint.php"> Roaster Maint </a><p>&nbsp;<p></li>
	 </ul>

  </div>
<div class="yellow_heading">
Blend Bag code Maint<p/>
</div>	



               <?php
               
               
               echo "<table>";
               echo "</td><td>";
               echo "$update <br>";
               echo '<INPUT TYPE="SUBMIT" id="update" name="update" VALUE="Enter" class="ccbtn"> (Update or Add)  ';
               echo "</td></tr>";
               
               echo "<tr><td>";
               echo "Roaster Blend Code  ";
               echo "</td><td>";
               echo '<input type=text name=roaster_blend_code size=40 value="';
               echo $roaster_blend_code;
               echo '">';
               echo "</td></tr>";
               
               echo "<tr><td valign='top'>";
               echo "Green Lot 1:";
               echo "</td><td>";
               echo BuildBlendDD($ft_id,'green_lot_1');
               echo "</td>";
               echo "</tr><tr><td valign='top'>";
               echo "Green Lot 2:";
               echo "</td><td>";
               echo BuildBlendDD($ft_id,'green_lot_2');    
               echo "</td>";
               
               echo "</tr><tr><td valign='top'>";
               echo "Green Lot 3:";
               echo "</td><td>";
               echo BuildBlendDD($ft_id,'green_lot_3');    
               echo "</td>";  
               
               echo "</tr><tr><td valign='top'>";
               echo "Green Lot 4:";
               echo "</td><td>";
               echo BuildBlendDD($ft_id,'green_lot_4');  
               echo "</td>";
               
               echo "</tr><tr><td valign='top'>";
               echo "Green Lot 5:";
               echo "</td><td>";
               echo BuildBlendDD($ft_id,'green_lot_5');    
               echo "</td>";
               
               echo "</tr><tr><td valign='top'>";
               echo "Green Lot 6:";
               echo "</td><td>";
               echo BuildBlendDD($ft_id,'green_lot_6');     
               echo "</td>";
               
               
               echo "</tr>";
               echo "</table>";          
  
               
               echo "<table width=80%><tr><td>";
               
               echo "<br>";
               echo "Press the Enter botton above to add a new record <br>";
               echo "if the roaster code exist below, it will update the record rather than add it <br>";

 mysql_select_db('trf_roaster_blend_table');
$query = "Select * from trf_roaster_blend_table where ft_id = '$ft_id' order by roaster_blend_code";
$update_lot = mysql_query($query, $db_conn);

$RoasterLots = mysql_query($query, $db_conn);
$num_lots = mysql_num_rows($RoasterLots);
$RoasterRow = mysql_fetch_array($RoasterLots);
for ($x=0; $x < $num_lots; $x++) {

$roaster_blend_code = $RoasterRow['roaster_blend_code'];
$roaster_seq = $RoasterRow['seq'];

$blend_array = array($RoasterRow['green_lot_1'], 
              $RoasterRow['green_lot_2'],
              $RoasterRow['green_lot_3'],
              $RoasterRow['green_lot_4'],
              $RoasterRow['green_lot_5'],
              $RoasterRow['green_lot_6']);
              
 
              
              echo "<br>------------------ <br>"; 
              

echo "<a href='blend_maint.php?delete=yes&seqkey=$roaster_seq&additionalkey=$ft_id&bc=$roaster_blend_code'><img src='img/delete.png'></a>";
echo " Roaster lot: $roaster_blend_code ";
echo "<br>";   
              
foreach ($blend_array as $v)    {           

      	if ($v != "") {
                echo "$v : ";
            }
    
    }
  
  $RoasterRow = mysql_fetch_array($RoasterLots);  
}    
     
                   

               echo "</td>";
               
               
               echo "</tr>";
               echo "</table>";
                
?>   

  
 

</form>
</BODY>
</HTML>
