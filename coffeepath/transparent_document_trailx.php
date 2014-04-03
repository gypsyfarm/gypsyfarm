<?php

$coop_id  = $_REQUEST['coop_id'];
$rst_id  = $_REQUEST['rst_id'];
$step  = $_REQUEST['step'];
 

?>
<html lang="en-US">
<head>

<title>Follow the Bean</title>
<script language="Javascript">
//  alert("Re-Loaded222");
 // parent.TEXTFRAME.location.hash='PreFinancing';
  </script>
</head>
<frameset ROWS="22%,*" border="0" frameborder="0" framespacing="0"
scrolling="no" noresize title=
"Frame for Fair Trade Proof Web Site" >

<frame border="0" framespacing="0" frameborder="0" marginwidth="0"
marginheight="0" name="BUTTONSFRAME" scrolling="AUTO" src=
"top_what.php" title="Top What">

<frameset border="0" frameborder="0" framespacing="0">  
 

<frame border="0" frameborder="0" framespacing="10" marginwidth=
"10" marginheight="10" name="TEXTFRAME"  scrolling="AUTO"
<?php
$step  = $_REQUEST['step'];
if (isset($rst_id)) {
   echo "src='bottom_whatx.php?rst_id=$rst_id&step=$step' title='Bottom What'>";
}
elseif (isset($coop_id)) {
   echo "src='bottom_whatx.php?coop_id=$coop_id&step=$step' title='Bottom What'>";
}
else {
   echo "src='bottom_whatx.php?coop_id=20' title='Bottom What'>";	
}
?>
</frameset>
<noframes>
<body>
<p>Here is the <a href="boo.html">non-frame based
version of the document.</a></p>
</body>
</noframes>
</frameset>
</html>

