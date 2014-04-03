<?php
require("connection.php"); 
 require("phpclasses.php");

$coop_id  = $HTTP_POST_VARS['coop_id'];
$rst_id  = $_REQUEST['rst_id'];
$trace1 = $HTTP_POST_VARS['trace1'];
$trace2 = $HTTP_POST_VARS['trace2'];
$btn1 = $HTTP_POST_VARS['btn1'];
$btn2 = $HTTP_POST_VARS['btn2'];
$scribd_id  = $_REQUEST['scribd_id'];
$guid  = $_REQUEST['guid'];
$item_code = $_REQUEST['item_code'];

if ($trace2 == 'Trace Lot # from a Farming Cooperative') {
	$type = 'Coop';
}
elseif ($trace1 == 'Trace Lot # from a Roaster') {
    $type = 'Roaster';
}
elseif ($btn2 != "") {
	header('Location: http://www.scribd.com/doc/134638/GUA62Con' );
}
elseif ($btn1 != "") {
	header('Location: http://www.coffeepath.com/what.html' );
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
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec">


<center>
<form name=frmMain method=post action='lot_search.php?coop_id=Fondo_Paez'>


<table width=100%>
<tr>
<td>

 <div class="grey_heading">

  Fair Trade Proof 

 </div>
 
 
 </td>
<td align=center>
<?php
$RoasterBox = new myRoasterBox("");
$RoasterBox->setImage("images/buttonssmY.jpg");
$RoasterBox->displayBox();
?> 
 </td>
 <td align=center>
<?php
$CoopBox = new myCoopBox("../");
$CoopBox->setImage("../images/buttonssmY2.jpg");
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


echo "</div>";

 
?>  

<table width=90%>
<tr>
<td align="center" valign="top" width=75%>
 
 
<?php

echo "Use the buttons on the window below to navigate and view the document.";

echo '<div style="width:610px; height=710px">';
echo "<iframe width='600px' height='700px' "; 
echo "src ='http://www.scribd.com/doc/$scribd_id/'> ";
echo "</iframe>";
 
# echo "src ='http://www.scribd.com/word/download/$scribd_id?extension=pdf'> ";
# echo "src ='http://www.scribd.com/doc/$scribd_id/'> ";
# http://www.scribd.com/doc/415595/Oromia-BCS07
#echo "<P>&nbsp;<br>&nbsp;<P>&nbsp;<br>&nbsp;<P>&nbsp;<br><P><br><P><br><P><br><P><br><P><br><P><br><P><br><P><br>";
echo '</div>';
?>
 
 
<!-- image 1 -->
<!-- image 2 -->
 

</td>
<td valign="top" width=25%>
<div style="width:180px;  ;border:3px solid yellow;">

<div>

 <div class="whiteone">
 <center>
Step 1<br>
</div>

<div class="center">
<INPUT TYPE="SUBMIT" id="btn1" name="btn1" VALUE="Learn
what each
document
means" class="n1btn"> 
</div>

<div>
&nbsp;
</div>
<div class="whitetwo">
STEP 2<br>
CHOSE A<br> 
LOT YOU WANT<br>
TO TRACE
</div>

<p>
 
 <?php 
     
      echo '<div class="whitethree">';
      $SetRightNav = new myRightSideContent($db_conn);
      if (ISSET($item_code)) { 
      	echo "<br>have item code<br>";
      	$SetRightNav->BuildLotList($item_code);
      }
      elseif (ISSET($rst_id)) {
      	echo "<br>have roaster id $rst_id<br>";
      	$SetRightNav->BuildRoasterList($rst_id);
      }
      else { 
      	  echo "<br>Default<br>";
          $SetRightNav->BuildRoasterList('18');
       }
  
     echo '</div>';        
 
 

?>



</center>
</div>

</div>
</td>
</tr>
<?php
echo  "<tr><td colspan=2>";
     echo '<div class="whitethree">';
     $QueryString = "?rst_id=$rst_id";
TraceFooter("../",$QueryString );
echo '</div>';
 echo "</td></tr>";
 ?>
</table>
 

 
</form>
</BODY>
</HTML>
