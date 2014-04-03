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
$access_key = $_REQUEST['access_key'];
$document_id  = $_REQUEST['document_id'];
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


<link rel="stylesheet" type="text/css" href="print.css">
 
 


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


 
   Use the buttons on the window below to navigate and view the document.<br> 

 
     <!-- The contents of this div will get replaced with the iPaper -- >
     
     <?php
  echo "<div id='embedded_flash' >"; 
   echo " <a href='http://www.scribd.com'>Scribd</a>";
  echo " </div>";

  echo '<script type="text/javascript"> ';
  echo "var scribd_doc = scribd.Document.getDoc('$document_id', '$access_key');"; 
  # echo " scribd_doc.addParam('height', 700);";
 #echo " scribd_doc.addParam('width', 600);";
  echo " scribd_doc.write('embedded_flash');";  
echo " </script>";

?>
 
 </td>

 </form>
</BODY>
</HTML>
