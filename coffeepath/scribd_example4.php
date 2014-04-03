<?php
  $cookie_value = $HTTP_COOKIE_VARS["search1"];
require("connection.php"); 
require("phpclasses.php");


session_start();

$coop_id  = $HTTP_POST_VARS['coop_id'];
$rst_id  = $_REQUEST['rst_id'];
$trace1 = $HTTP_POST_VARS['trace1'];
$trace2 = $HTTP_POST_VARS['trace2'];
$btn1 = $HTTP_POST_VARS['btn1'];
$btn2 = $HTTP_POST_VARS['btn2'];
$scribd_id  = $_REQUEST['scribd_id'];
$guid  = $_REQUEST['guid'];
$access_key = $_REQUEST['access_key'];
$document_id  = $_REQUEST['document_id'];
$item_code = $_REQUEST['item_code'];
$program_sw = $_REQUEST['program_sw'];
$search = $_REQUEST['search'];
$lot_nbr = $_REQUEST['lot_nbr'];
$gorp_id = $_REQUEST['gorp_id'];
$rst_id = $_REQUEST['rst_id'];
$coop_id = $_REQUEST['coop_id'];

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
<link rel="stylesheet" type="text/css" href="print.css" media="print">

<style>
#input_box1 { background-color:yellow; }
#input_box2 { background-color:yellow; }
</style>
<script type="text/javascript" src='http://www.scribd.com/javascripts/view.js'></script> 

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

<?php

$ref =   $_SESSION['ref'];
   
if (!isset($ref)) {
     $ref = getenv("HTTP_REFERER");
     $ref = str_replace('http://www.coffeepath.com/','',$ref);
     $_SESSION['ref'] = $ref;
}else { 
     $ref =  $_SESSION['ref'];
}

echo "<form name=frmMain method=post action='$ref'> ";
 
?>

<table width=100%>
<tr>
<td>

 <div class="grey_heading">

 <a STYLE='text-decoration:none' href='http://www.coffeepath.com/index.php' target='_top'>
 <img  border=0 src="images/logohome.jpg">
  </a>

 </div>
 
 
 </td>
<td align=center>
<?php
$RoasterBox = new myRoasterBox("");
$RoasterBox->setImage("images/tracerRinsideOFF.jpg");
$RoasterBox->displayBox();
?> 
 </td>
 <td align=center>
<?php
$CoopBox = new myCoopBox("");
$CoopBox->setImage("images/tracerCinsideON.jpg");
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

  echo "<table>";
  echo "<tr>";
  echo '<td  align="center" valign="top">';
  echo "Use the buttons on the window below to navigate and view the document.<br> ";
  $SetRightNav = new myRightSideContent($db_conn);
  
   
  if (ISSET($item_code) && $rst_id == "") {
  	$SetRightNav->GetCoopRecord($coop_id);
  	echo "To return to <font class='yellow_link'>".$SetRightNav->name." </font><a href='$ref'> click here </a><br>";
  	      }
      elseif (ISSET($rst_id)) {
      	 $SetRightNav->GetRoasterRecord($rst_id);
      #	 echo "<br>";
      	 echo "To return to <font class='yellow_link'>".$SetRightNav->name." </font> <a href='$ref'> click here </a><br>";
}

 echo "<p>";
        
    # <!-- The contents of this div will get replaced with the iPaper -- >
     
  
  echo "<div id='embedded_flash' >"; 
   echo " <a href='http://www.scribd.com'>Scribd</a>";
  echo " </div>";

  echo '<script type="text/javascript"> ';
  echo "var scribd_doc = scribd.Document.getDoc('$document_id', '$access_key');"; 
   echo " scribd_doc.addParam('height', 700);";
 echo " scribd_doc.addParam('width', 600);";
  echo " scribd_doc.write('embedded_flash');";  
echo " </script>";

 
 
echo " </td>";
echo "<td>&nbsp;</td>";
 
 echo '<td valign="top">';
 
echo ' <div style="width:200px;  ;border:3px solid yellow;">';

echo '<div>';
echo "<p>";


       echo '<div class="whitethree">';
    #   echo "item code = $item_code and rst_id = $rst_id <br>";
      if (ISSET($item_code) && $rst_id == "") { 
         echo '<div class="whiteone">';
	 echo "\n";
         echo '<center>';
         echo 'Step 1<br>';
         echo '</div>';
         
         echo '<div class="center">';
         
         echo '<br><input type="image" id="btn1" name="btn1"  value="btn1" alt="btn1" src="../images/learn.jpg"><br>&nbsp;<br>';
         echo '</div>';
         
         echo 'STEP 2<br>';
      #	echo "<br>have item code<br>";
      	$SetRightNav->BuildLotList($item_code);
      }
      elseif (ISSET($rst_id)) {
       $SetRightNav->cookie_value = $cookie_value;  
       $SetRightNav->Step1Step2($program_sw,$search,$lot_nbr, $gorp_id);    
                
               
       echo "<p> "; 
       
  
       echo '</div>';  
      	
      	
      }
      else { 
      #	  echo "<br>Default<br>";
          $SetRightNav->BuildRoasterList('18');
       }
  
     echo '</div>';   
 
 echo '</div>';
 echo '</div>';
echo '</div>';
 
  
 
 echo '</td>';

 echo '</tr>';
 
 echo  "<tr><td colspan=3>";
     echo '<div class="whitethree">';
     $QueryString = "?$rst_id=1";
TraceFooter("../",$QueryString);
echo '</div>';
 echo "</td></tr>";
 echo '</table>';
?>
 
 
 
 
 

 
</form>
</BODY>
</HTML>
