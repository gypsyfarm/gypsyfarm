 <?php
 
 require("phpclasses.php");
 
 ?> 
<HTML>
<HEAD>
    <TITLE>Fair Trade Proof Index</TITLE>
  
<meta name="description" content="Fair Trade Proof is maintained by Cooperative Coffees">

<meta name="keywords" content="freetrade, cooperative coffees ">

  
<link rel="stylesheet" type="text/css" href="reset.css">
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
   
</script>

</HEAD>
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec">

<center>
<form name=frmMain method=post action='lot_search.php?ft_id=1'>
<img   border=0 align="left" src="images/logoinside.jpg"/>

<table    border=0>

<tr>
 <td>
 &nbsp;
 </td>
 <td  width="20%" align="right" valign="top">
<div class="corners">
 Our black background minimizes <br>energy, reducing climate change
 </div>
 <p>
 <div class="corners">
  Fair Trade Proof is maintained<br> by Cooperative Coffees 
</div>
 </td>
 </tr>
 </tr>

 <td    align="center" valign="top">

 <img   border=0  src="images/namehome4.jpg"/> 
 </td>
 <td>
 &nbsp;
 </td>
 </tr>
<tr>
<td align="center">
 <p>
 

  <!--
<div class="yellow_heading_big"><strong>
 FAIR TRADE PROOF </strong>
  </div>
--> 
&nbsp; 
  <p>
 <div class="whiteone">
TRACE YOUR BEANS FROM FARMER TO ROASTER.
  </div>
  <p>
  <div class="greynew">
We are a  cooperative of independent roasters  committed to  Fair Trade  as a  
 long-term partnership between farmers and roasters. Paying a  
fair price is just the     beginning  of this relationship. Our 
trade model includes pre-financing, sharing   
information, and working together for higher quality coffee. 
</div>
<p>
  <div class="greynew">
Transparency makes fairness possible because it makes hiding the truth   
impossible.  Use this site to trace your coffee or to learn about our deep commitment to a  
higher standard of trade.
</div>
<p>
 <div class="whiteone">
FOLLOW THE COFFEE
</div>
<p>

</td>
 <td>
 &nbsp;
 </td>
</tr>
<tr>
<td align="center">

<table width=50%>
<tr>
<td align=center>

<?php
$RoasterBox = new myRoasterBox("");
$RoasterBox->image = "images/tracerRbig.jpg";
$RoasterBox->displayBox();
?>
</td>

<td align=center>

<?php
$CoopBox = new myCoopBox("");
$CoopBox->image = "images/tracerCbig.jpg";
$CoopBox->displayBox();

?>
</td>
</tr>
</table>

</td>

 <td>
 &nbsp;
 </td>
</tr>
<tr>
<td align="center"> 
<div class="overaddress">
<p>
This site was created by Cooperative Coffees because we are committed to Fair Trade
<br>
which means we are committed to transparency.
<br>
</div>
 
  <table width="68%">
 	<tr>
 	<td width="22%"> <div class="address"><a STYLE="text-decoration:none" href="javascript:poptastic('FTF2010cert.pdf');"><u>Fair Trade Federation Member </u></a>  </div></td>
 	<td width="9%">|</td>
 	<td width="14%"> <div class="address"><a STYLE="text-decoration:none" href="javascript:poptastic('CC.OTCO.2010.pdf');"><u>Organic Certified </u></a>  </div></td>
  <td width="9%">|</td>
 	<td width="14%"> <div class="address"><a STYLE="text-decoration:none" href="javascript:poptastic('2011TFCAcert.pdf');"><u>Fair Trade Certified </u></a></div></td>
</tr>
</table>
 
<p>
<div class="address">
Cooperative Coffees, 302 W. Lamar Street, Suite C <br>
Americus, GA 31709; USA
</div>
</center>
</td>
 <td>
 &nbsp;
 </td>
 </tr>
 </table>
 <p>&nbsp;</p>
 <div class="address">

</div>
</form>
</BODY>
</HTML>
