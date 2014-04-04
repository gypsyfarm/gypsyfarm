<html>
<head>
 <STYLE type="text/css">
 body {
    font: 69% "Lucida Grande", Verdana, Lucida, Helvetica, Arial, sans-serif;
     background-color: #a6c749;
      color: Black;
     margin: 0;
     padding: 0;
}
 </style>
  <title>Follow the Bean select</title>
  <META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">

<!--
 
 <script type="text/javascript">
function displaymessage(myMessage) {
alert("hello world");
}
</script>
 
 
</head>


<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff  >


<!--
  <a href="ftbright.php?searchtype=contact_id&searchterm=0"  TARGET="TEXTFRAME" >
  Add New Record </a>
  
  -->

<?php
require("../order/tables.php");

$db_conn = mysql_connect('ldb105.siteprotect.com', 'coffeepathdata', 'cafe725');
mysql_select_db('coffeepathdata', $db_conn);

  if (!$db_conn)
  {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }



#functions: 
   $ListType = $HTTP_POST_VARS['follow_type'];
   if ($ListType == "") {
   	$ListType = "Country";
   }

   function BuildList($ListType) {
 
   	if ($ListType == "Country" ) {
   	   BuildCountryList();
   	}
   	elseif ($ListType == "Coop" ) {
   	   BuildCoopList();
   	}
   	elseif ($ListType == "Lot" ) {
   	   BuildLotList();
   	}
   	else {
   	  BuildCountryList();
   	}
   	
   }
  
  
  function BuildRadioButtons($ListType) {
  	
  	echo "<input type=radio name=follow_type ";
  	 if ($ListType == "Country") {
  	 	echo " checked ";
  	 }
  	 echo " value='Country' > Country &nbsp;&nbsp;";
        echo "<input type=radio name=follow_type ";
        if ($ListType == "Coop") {
  	 	echo " checked ";
  	 }
        echo "  value='Coop' > Coop &nbsp;&nbsp";
        echo "<input type=radio name=follow_type ";
        if ($ListType == "Lot") {
  	 	echo " checked ";
  	 }
        echo "  value='Lot' > Lot &nbsp;&nbsp";
  	
}
 
 
    function BuildLotList() {
   	?>
   	<center>
   	<strong> Click one to Follow: </strong>
<a href="http://www.cooperativecoffees.com/docs/index.php?subdir=me" TARGET="TEXTFRAME"> Mexican Lots </a> &nbsp; &nbsp;| &nbsp;&nbsp;
<a href="http://www.cooperativecoffees.com/docs/index.php?subdir=bo" TARGET="TEXTFRAME"> Bolivian Lots </a> &nbsp; &nbsp;| &nbsp;&nbsp;
<a href="http://www.cooperativecoffees.com/docs/index.php?subdir=co" TARGET="TEXTFRAME"> Columbian Lots </a>  
</center>
   	
   	<?php
   	
  }   
 
 
   function BuildCoopList() {
   	?>
   	<center>
   	<strong> Click one to Follow: </strong>
<a href="http://coopcoffees.com/what/producers/maya-vinic-mexico/maya-vinic-mexico" TARGET="TEXTFRAME"> Maya_Vinic </a> &nbsp; &nbsp;| &nbsp;&nbsp;
<a href="http://coopcoffees.com/what/producers/fecafeb-bolivia/fecafeb" TARGET="TEXTFRAME"> FECAFEB </a> &nbsp; &nbsp;| &nbsp;&nbsp;
<a href="http://coopcoffees.com/what/producers/fondo-paez-colombia/fondo-paez" TARGET="TEXTFRAME"> Fondo_Paez </a>  
</center>
   	
   	<?php
   	
  }   
   
   
   function BuildCountryList() {
   	?>
   	<center>
   	<strong> Click one to Follow: 
<a href="http://coopcoffees.com/what/producers/mexico" TARGET="TEXTFRAME"> Mexico </a> &nbsp; &nbsp;| &nbsp;&nbsp;
<a href="http://coopcoffees.com/what/producers/bolivia" TARGET="TEXTFRAME"> Bolivia </a> &nbsp; &nbsp;| &nbsp;&nbsp;
<a href="http://coopcoffees.com/what/producers/ethiopia" TARGET="TEXTFRAME"> Ethiopia </a>  
</strong>
   	
   	<?php
   	
  }


    function first_table_display() {
    ?>
    
yada...

<?php
}
 # end of  function section. 
?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../general.css">


</head>
<body  bgcolor="#FFFFFF" text="#228B22" link="#008000" vlink="#006400 alink="#00FF00"  background="../two_lines.gifs">
<form name=frmMain method=post action="ftbleft2.php" >


 <table border="0"  width="90%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2"> 
 
<tr>

<td align="center">

<input type="submit" value="Select One to" name="follow">  ->
 
Follow the Bean by: 
 
 <?php
 BuildRadioButtons($ListType)


?>
</td>
 
  </tr>
  
</table>
      
<hr noshade size="1" width=100% color="#228B22">
 
 
 <?php
 
     BuildList($ListType);
 ?>

</form>

</BODY>


</HTML>
