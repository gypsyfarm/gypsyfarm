<?php
  require("phpclasses.php");
$trace1 = $HTTP_POST_VARS['trace1'];
$trace2 = $HTTP_POST_VARS['trace2'];



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
   parent.window.location.href = url_add;
   }
   
 
</script>

</HEAD>
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec">


<center>
<form name=frmMain method=post target="_top" action='lot_search.php?ft_id=$ListType'>


<table width=95%>
<tr>
<td>
 
 <div class="grey_heading2">
 <!-- http://www.coffeepath.org/index.php ->
 <a STYLE='text-decoration:none' href='index.php' target='_top'>
 <img  border=0 src="images/logohome.jpg">
  </a>
 </div>
 </td>
<td align='center'>
 
<?php
$RoasterBox = new myRoasterBox("");
$RoasterBox->setImage("images/tracerRinsideOFF.jpg");
$RoasterBox->displayBox();
?>
 </td>
 <td align='center'>

<?php
$CoopBox = new myCoopBox("");
$CoopBox->setImage("images/tracerCinsideON.jpg");
$CoopBox->displayBox();

?>
 </td>
 <td align="right">
 <div  class="corners">
 Our black background minimizes <br>energy, reducing climate change
 <p>
  </div>
  <div class="corners">
  Fair Trade Proof is maintained <br>by Cooperative Coffees 
</div>
 </td>
 </tr>
 </table>
 <p>
 
 
<hr>
 
</form>
</BODY>
</HTML>
