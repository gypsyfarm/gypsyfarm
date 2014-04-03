<?php
require("connection.php"); 
 require("phpclasses.php");

 $access_key  = $_REQUEST['access_key'];
 $document_id  = $_REQUEST['document_id'];

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


<?php

	echo "\n";

	echo '<script type="text/javascript" src=\'http://www.scribd.com/javascripts/view.js\'></script>'; 
	echo "\n";
	
        echo '<!-- The contents of this div will get replaced with the iPaper -- >';
        
        echo "\n";
        
        echo "<div id='embedded_flash' >"; 
        
        echo "\n";
        echo " <a href='http://www.scribd.com'>Scribd</a>";
       
        echo "\n";
        
        echo "</div>";
        echo "\n";
        
        echo '<script type="text/javascript">';
        echo "\n";
        
        echo "var scribd_doc = scribd.Document.getDoc($document_id, '$access_key');";
         echo "scribd_doc.write('embedded_flash');";  
        echo "</script>";
        echo "\n";

 
TraceFooter("../","?rst_id=1");
 
 ?>
 

 
</form>
</BODY>
</HTML>
