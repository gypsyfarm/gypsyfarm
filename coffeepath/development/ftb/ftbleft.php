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


    function first_table_display() {
    ?>
    


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
<form name=frmMain method=post action="displaymessage(5)" >
<?







 
echo '<table border="0"  width="90%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
 
?>
<tr>
<td>
<b>Lot Number: </b>
</td>
<td>

<input type=text name=lot_number size=10 value="">
<td>

 

<td> Country: 

</td>

<td>
<select  name="Country"    >
<option value=''>&nbsp
<option value='Bolivia' >Bolivia
<option value='Mexico' >Mexico
<option value='Ethiopia' >Ethiopia
</select>
</td>

 



<td >

  <a href="http://coopcoffees.com/what/producers/mexico"  TARGET="TEXTFRAME" >
  Mexico </a>
</td>
 

<td>Coop: 
</td>
<td>
<select  name="Coop"  >
<option value=''>&nbsp
<option value='Maya_Vinic' >Maya Vinic
<option value='FECAFEB' >FECAFEB
<option value='Fondo_Paez' >Fondo Paez 
</select>
</td>

  </tr>
<table>
<tr>
<td>      
<div> 
<input type="reset" value="reset" name="reset"> 
</div>
</td>
<td>
<div>
<input type="submit" value="submit" name="submit"> 
</div>
</td>
<td>
<div>
<input type="submit" value="home" name="home"> 
</div>
</td>
</tr>
</table>            <hr noshade size="1" color="#228B22">
</form>

</BODY>


</HTML>
