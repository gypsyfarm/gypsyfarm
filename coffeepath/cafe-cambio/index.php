<?php
require("../connection.php"); 
require("../phpclasses.php");

require("../roaster_pages.php");
 
$gorp_id = 68;

$coop_id  = $_REQUEST['coop_id'];
$rst_id  = "20";  # $_REQUEST['rst_id'];
$btn1  = $_REQUEST['btn1'];
$search  = $_REQUEST['search'];
$lot_nbr = $_REQUEST['lot_nbr'];
$work_around = $_REQUEST['btn1_x'];

#$program_sw = "N";
 
if ($work_around != "") {
	$btn1 = "btn1";
}

 
 $SetRightNav = new myRightSideContent($db_conn);

$SetRightNav->program_sw = "N";

if ($btn2 != "") {
	header('Location: http://www.scribd.com/doc/134638/GUA62Con' );
}
elseif ($btn1 != "") {
	header(RoasterHeader($rst_id));
}
 
$type = 'Roaster';
 
?>


 
<HTML>
<HEAD>
    <TITLE>Fair Trade Proof page</TITLE>
  
<meta name="description" content="Fair Trade Proof is maintained by Cooperative Coffees">

<meta name="keywords" content="freetrade, cooperative coffees ">

<link rel="stylesheet" type="text/css" href="../default.css">
<script language="Javascript" src="../scripts/coffeepath.js"></script>

</HEAD>
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec">


<center>
<form name=frmMain method=post action='index.php?rst_id=4'>

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
echo "</table>";
echo "<p>";
echo "<hr>";
echo "<div class='whiteone'>";
 
$type = 'Roaster';

echo "</div>";

   $SetRightNav->GetRoasterRecord($rst_id);
 
   $SetRightNav->cookie_value = $cookie_value;  
   $SetRightNav->search = $search;
   $SetRightNav->lot_nbr = $lot_nbr;
   $SetRightNav->gorp_id = $gorp_id;
  
   $SetRightNav->RoasterLeftSideContent();  
  
#print_r($_POST);
echo "<p>";
 
   

?>



</center>
</div>

<!-- </div> -->


</td>
</tr>
<tr>
<td colspan=2>
<?php
TraceFooter("../","?rst_id=4");
?>
</td>
</tr>
</table>



</div>
</form>
</BODY>
</HTML>
