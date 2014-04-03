<?php
require("connection.php"); 

$coop_id  = $HTTP_POST_VARS['coop_id'];
$rst_id  = $HTTP_POST_VARS['rst_id'];
$trace1 = $HTTP_POST_VARS['trace1'];
$trace2 = $HTTP_POST_VARS['trace2'];
$btn1 = $HTTP_POST_VARS['btn1'];
$btn2 = $HTTP_POST_VARS['btn2'];

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
	

 


function GetRoasterRecord($rst_id) {
    global $db_conn;
    global $name;
    global $contact;
    global $content;
mysql_select_db('trf_roaster_content');


  $query = "select * 
            from trf_roaster_content
             where ft_id =  $rst_id;";

 
# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);
 $name = $row['roaster_name'];
 $name = str_replace(" '", "'", $name);
 $contact = $row['contact'];
 $content = $row['content'];
 
	
}

function GetCoopRecord($coop_id) {
    global $db_conn;
    global $name;
    global $contact;
    global $content;
mysql_select_db('trf_coop_content');


  $query = "select * 
            from trf_coop_content
             where coop_id =  '$coop_id';";

# echo "<br>$query <br>";
# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);
 $name = $row['coop_name'];
 $name = str_replace(" '", "'", $name);
 $contact = $row['contact'];
 $content = $row['content'];
 
	
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
<form name=frmMain method=post action='lot_search.php?coop_id=Fondo_Paez'>


<table width=100%>
<tr>
<td>
 <div class="greyone">
  Fair Trade Proof
 </div>
 </td>
<td>
 
<INPUT TYPE="SUBMIT" id="trace1" name="trace1" VALUE="Trace Lot # 
from a Roaster" class="ccbtn"> 
<br>
<select name="rst_id">
<option value="1">Larry's Beans</option>
<option value="2">Another roaster</option>
</select>
 </td>
 <td>
 <INPUT TYPE="SUBMIT" id="trace2" name="trace2" VALUE="Trace Lot # 
from a Farming Cooperative" class="ccbtn"> 


<br>
<select name="coop_id">
<option value="Fondo_Paez">Fondo_Paez, Columbia</option>
<option value="2">Another Coop</option>
</select
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
 
 


 
 
<?php
 
echo ' <object width="650" height="700"><param name="allowScriptAccess" value="SameDomain" /><param name="movie" value="http://static.scribd.com/FlashPaperS3_6.swf?guid=ctssr2ieouzmc&document_id=134638" /><embed width="650" height="700" src="http://static.scribd.com/FlashPaperS3_6.swf?guid=ctssr2ieouzmc&document_id=134638" type="application/x-shockwave-flash"></embed> </object>';

?>
 
 
 
</form>
</BODY>
</HTML>
