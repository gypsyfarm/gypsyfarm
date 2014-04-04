<?php
require("../connection.php"); 
require("../phpclasses.php");
require("../coop_pages.php");

#$coop_id  = $_REQUEST['coop_id'];
$coop_id = '5';
$rst_id  = $_REQUEST['rst_id'];
$btn1  = $_REQUEST['btn1'];

 $SetRightNav = new myRightSideContent($db_conn);
 
 
 $work_around = $_REQUEST['btn1_x'];

 
if ($work_around != "") {
	$btn1 = "btn1";
}


 if ($btn2 != "") {
	header('Location: http://www.scribd.com/doc/134638/GUA62Con' );
}
elseif ($btn1 != "") {
	header(CoopHeader($coop_id));
}
 


?>


 
<HTML>
<HEAD>
    <TITLE>Fair Trade Proof page</TITLE>
  
<meta name="description" content="Fair Trade Proof is maintained by Cooperative Coffees">

<meta name="keywords" content="freetrade, cooperative coffees ">

<link rel="stylesheet" type="text/css" href="../default.css">
<script language="Javascript" src="../scripts/coffeepath.js"></script>

<style>
#input_box1 { background-color:yellow; }
#input_box2 { background-color:yellow; }
</style>

</HEAD>
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec" >


<center>
<form name=frmMain method=post action='index.php?coop_id=5'>


<?php
echo '<table border=0  width="100%">';   
        
 NewTraceHeading(".."); 
 echo "<tr>";
 echo "<td width='15%'>";
$RoasterBox = new myRoasterBox("../");
$RoasterBox->setImage("images/tracerRinsideOFF.jpg");
$RoasterBox->displayBox();
 echo "</td>";
 echo "<td align='left'>";
$CoopBox = new myCoopBox("../");
$CoopBox->setImage("images/tracerCinsideON.jpg");
$CoopBox->displayBox();
echo "</td>";
echo "</tr>";
echo "</table";
?>
 
<hr>
 
  
 
 <div class="whiteone">

 
 
<?php

 
   $type = 'Coop';
 

echo "</div>";

 
if ($type == "Coop") {
          $SetRightNav->GetCoopRecord($coop_id);
}
 
?>  



<table width=90%>
<tr>
<td valign="top" align="left" width=75%>

<div class="yellow_heading">
<?php
echo $SetRightNav->name;
?>
</div>

<div class="whiteone">
<?php
echo $SetRightNav->contact;
?>
</div>

<div>
<?php
 $scribd_id = $SetRightNav->scribd_id;
 $guid = $SetRightNav->guid;
 $item_code = $SetRightNav->item_code;
if ($scribd_id != "") {

 $SetRightNav->BuildScribdLink($scribd_id,$guid,'',$item_code);
}
echo "$SetRightNav->content";
 $SetRightNav->CoopStep2();
 
if ($type == "Coop") {
     echo '<div class="whitetwo">';    
     echo '</div>';     
     echo '<div class="whitethree">';
     $SetRightNav->BuildLotList($SetRightNav->item_code);    
     echo '</div>';	     
}
 

?>



</center>
</div>

</div>
</td>
</tr>

<tr>
<td colspan=2>
<?php
$querystring = "?coop_id=$coop_id";
TraceFooter("../",$querystring);
?>
</td>
</tr>
</table>

</div>
</form>
</BODY>
</HTML>
