<?php

 
$trace1 = $HTTP_POST_VARS['trace1'];
$trace2 = $HTTP_POST_VARS['trace2'];
$btn1 = $HTTP_POST_VARS['btn1'];

if ($trace2 == 'Trace Lot # from a Farming Cooperative') {
	$type = 'Coop';
}
elseif ($trace1 == 'Trace Lot # from a Roaster') {
    $type = 'Roaster';
}
elseif ($btn1 != "") {
	header('Location: http://www.coffeepath.org/what.html' );
}
	

function BuildCoop() {
?>	
<table width=90%>
<tr>
<td align="left" width=75%>
<div class="yellow_heading">
Fondo_Paez,<br>
Columbia
</div>

<div class="whiteone">
FLO ID #<br>
www.fondopaez.com<br>
Partner since 2000<br>
Total beans purchased: 104,000 lbs.<br>
Organic Certificate Link<br>
Cordillera, Colombia<br>
Purchases pre-financed by EcoLogic<br>
</div>

<div>
The Paez (who also call themselves Nasa, or “the people”) is
the largest indigenous group in Colombia. Their land is in the
Cordillera Central - centered around the mountains of the Cauca
departamento<br>
Fondo Paez was founded in 1992, with the primary goal of
recuperating traditional agricultural knowledge and indigenous
culture which had been buried by centuries of conflict and
oppression. Paez community leaders teamed up with Fundacion
Colombia Nuestra, a Colombian-based non-profit, to start the
“Recovering Agricultural Knowledge” program. The main cash crop
of this region is still coffee, and, to ensure a stable income
for their members, Fondo Paez organized community based coffee
cooperatives. They became more organized, and, by 2000, they
were selling coffee through the Coffee Federation’s Specialty
Coffee program. In 2003, they produced seven containers of
coffee, both conventional and organic certified.
</div>
 
<img src="images/fondo_p2.png">
<img src="images/fondo_p.png">
 

</td>
<td valign="top" width=25%>
<div style="width:150px;  ;border:3px solid yellow;">

<div>

 <div class="whiteone">
 <center>
Step 1<br>
</div>
<div class="float">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<div>
<INPUT TYPE="SUBMIT" id="btn1" name="btn1" VALUE="Learn
what each
document
means" class="n1btn"> 
</div>

<div>
&nbsp;
</div>
<div class="whitetwo">
step 2<br>
choose the<br>
lot you want<br>
to trace
</div>

<p>
<div class="whitetwo">
LOT# 478685<br>
LOT# 478685<br>
LOT# 478685<br>
LOT# 478685<br>
LOT# 478685<br>
</div>
</center>
</div>

</div>
</td>
</tr>
</table>
	
<?php	
}	

function BuildRoaster() {
?>	
<table width=90%>
<tr>
<td align="left" width=75%>
<div class="yellow_heading">
Larry's Beans
</div>

<div class="whiteone">
FLO ID # <br>
ww.larrysbeans.com<br>
Partner since 2000<br>
Organic Certificate Link<br>
Raleigh, NC<br>
</div>

<div>
The Paez (who also call themselves Nasa, or “the people”) is
the largest indigenous group in Colombia. Their land is in the
Cordillera Central - centered around the mountains of the Cauca
departamento <br>
Fondo Paez was founded in 1992, with the primary goal of
recuperating traditional agricultural knowledge and indigenous
culture which had been buried by centuries of conflict and
oppression. Paez community leaders teamed up with Fundacion
Colombia Nuestra, a Colombian-based non-profit, to start the
“Recovering Agricultural Knowledge” program. The main cash crop
of this region is still coffee, and, to ensure a stable income
for their members, Fondo Paez organized community based coffee
cooperatives. They became more organized, and, by 2000, they
were selling coffee through the Coffee Federation’s Specialty
Coffee program. In 2003, they produced seven containers of
coffee, both conventional and organic certified.
</div>
 
<img src="images/bus.png">
<img src="images/maya_bag.png">
 

</td>
<td valign="top" width=25%>
<div style="width:150px;  ;border:3px solid yellow;">

<div>

 <div class="whiteone">
 <center>
Step 1<br>
</div>
<div class="float">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<div>
<INPUT TYPE="SUBMIT" id="btn1" name="btn1" VALUE="Learn
what each
document
means" class="n1btn"> 
</div>

<div>
&nbsp;
</div>
<div class="whitetwo">
step 2<br>
choose the<br>
lot you want<br>
to trace
</div>

<p>
<div class="whitetwo">
LOT# 478685<br>
LOT# 478685<br>
LOT# 478685<br>
LOT# 478685<br>
LOT# 478685<br>
</div>
</center>
</div>

</div>
</td>
</tr>
</table>
		
<?php	
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

</HEAD>
<BODY BGCOLOR="#333333" text="ececec" link="F76B08" alink="ffffff" vlink="ececec">


<center>
<form name=frmMain method=post action='lot_search_backup.php?ft_id=$ListType'>


<table width=100%>
<tr>
<td>
 <div class="greyone">
  COFFEE <br> PATH
 </div>
 </td>
<td>
 
<INPUT TYPE="SUBMIT" id="trace1" name="trace1" VALUE="Trace Lot # 
from a Roaster" class="ccbtn"> 
 </td>
 <td>
 <INPUT TYPE="SUBMIT" id="trace2" name="trace2" VALUE="Trace Lot # 
from a Farming Cooperative" class="ccbtn"> 
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

 echo " after type is $type <br>";
echo "</div>";

 
if ($type == "Roaster") {
    BuildRoaster();
}
elseif ($type == "Coop") {
    BuildCoop();	
}

 
?>  

</div>
</form>
</BODY>
</HTML>
