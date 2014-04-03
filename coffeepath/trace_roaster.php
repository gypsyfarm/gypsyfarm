<?php
require("connection.php"); 

$action  = $_REQUEST['action'];


	
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
var newwindow;
function poptastic(url)
{
 // was h=300, w650
	newwindow=window.open(url,'help','height=450,width=800,resizable=yes,scrollbars=yes,left=300,top=150');
	if (window.focus) {newwindow.focus()}
}



function nav(dropdown)
   {
   var w = dropdown.selectedIndex;
   var url_add = dropdown.options[w].value;
   window.location.href = url_add;
   }
   
   /*
Jump to:
<SELECT NAME="mylist" onChange="nav()">
<OPTION VALUE="../../index.html">Home Page
<OPTION VALUE="../../basics/index.php3">Basics
<OPTION VALUE="../../tutorials/index.php3">Tutorials
<OPTION VALUE="../../templates/index.php3">Web Design Templates
<OPTION VALUE="../../graphics/index.php3">Web Graphics Design
<OPTION VALUE="../index.php3">Tips and Tricks
<OPTION VALUE="../../design/index.php3">Web Page Design
<OPTION VALUE="../../services/index.php3">Services
</SELECT>   
   
   */
</script>

</HEAD>
<BODY BGCOLOR="#333333" text="ececec" link="F76B08" alink="ffffff" vlink="ececec" >

<center>
<form name=frmMain method=post action='trace_roaster.php?action=list'>
<table width=100%>
<tr>
<td align=left>
<div class="corners">
  Fair Trade Proof  is maintained by Cooperative Coffees 
</div>
 </td>
 <td align=right>
<div class="corners">
 Our black background minimizes <br>energy, reducing climate change
 </div>
 </td>
 </tr>
 </table>
 <p>
 
 <p>
 <div class="greyone">
 welcome to
 </div>
 
  
<div class="yellow_heading">
 Fair Trade Proof
  </div>
 <div class="whiteone">
 WHERE YOU CAN TRACE THE BEANS OF THE 22 MEMBERS OF  <br>
 COOPERATIVE COFFEES ALL THE WAY FROM THE FARM TO THE ROASTER.
  </div>
  <p>
  <div class="greyone">
Cooperative Coffees is based on the model of trade as long-term <br>
partnerships between farmers and roasters. By scrutinizing our document<br>
trail, you can see how we put this idea into action. 
</div>
<p>
  <div class="greyone">
This site is for those tracing a specific lot # of coffee - and for anyone<br>
interested in learning about a higher standard of Fair Trade.
</div>
<p>
 <div class="whiteone">
FOLLOW THE COFFEE
</div>
<p>

<table width=50%>
<tr>
<td align=center>


<?php

if ($action == 'list') {
	
	echo '<a href="lot_search.php?rst_id=1">Larry\'s Beans </a><br>';
	echo '<a href="lot_search.php?rst_id=2">Bongo Java </a><br>';
	echo '<a href="lot_search.php?rst_id=3">Peace Coffee </a><br>';
	echo '<a href="lot_search.php?rst_id=4">Cooperative Coffees </a><br>';

 
}
else {
	
	echo '<INPUT TYPE="SUBMIT" id="trace1" name="trace1" VALUE="Trace Lot # ';
	echo "\n";
        echo 'from a Roaster" class="ccbtn"> ';
        echo '<br>';
}

?>


 
</td>

</tr>
</table>

<p>
This site was created by cooperative coffees because we are committed to Fair Trade
<br>
which means we are committed to transparency.
<br>
<p>
Cooperative Coffees, 302 W. Lamar Street, Suite C <br>
Americus, GA 31709; USA
</center>

</form>
</BODY>
</HTML>
