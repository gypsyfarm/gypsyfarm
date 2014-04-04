<?php
//********************************************************************************
//********************* Display announcement for Cooperative Coffees ************************
//********************************************************************************

$db_conn = mysql_connect('ldb105.siteprotect.com', 'coffeepathdata', 'cafe725');
mysql_select_db('coffeepathdata', $db_conn);

if (!$db_conn)
{
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
}


#associative arrays:

$arrCountry=array("Mexico"=>"http://coopcoffees.com/what/producers/mexico",
                  "Bolivia"=> "http://coopcoffees.com/what/producers/bolivia",
                  "Ethiopia"=> "http://coopcoffees.com/what/producers/ethiopia");
                  
                  
$arrCoop=array("Maya_Vinic"=>"http://coopcoffees.com/what/producers/maya-vinic-mexico/maya-vinic-mexico",
                  "FECAFEB"=> "http://coopcoffees.com/what/producers/fecafeb-bolivia/fecafebhttp://coopcoffees.com/what/producers/fecafeb-bolivia/fecafeb",
                  "Fondo_Paez"=> "http://coopcoffees.com/what/producers/fondo-paez-colombia/fondo-paez");

# determine if need to redirect before sending anything in the buffer.

// Change to the URL you want to redirect to
$URL="http://coopcoffees.com/what/producers/fondo-paez-colombia/fondo-paez";

$submit = $HTTP_POST_VARS['submit'];
$coop = $HTTP_POST_VARS['Coop'];
$country  = $HTTP_POST_VARS['Country'];
#echo " submit = $submit"; 

if ($submit == 'submit') {

    if ($arrCountry[$country] <> ''){
    	$URL = $arrCountry[$country];
    	header ("Location: $URL");
    }
    
     if ($arrCoop[$coop] <> ''){
    	$URL = $arrCoop[$coop];
    	header ("Location: $URL");
    }
    
        echo '<br>Show some results';
    echo "<br>country = $arrCountry[$country]";
    echo "<br>coop = $arrCoop[$coop]";
}
 
#  header ("Location: $URL");
 

#functions:


    function first_table_display() {
    ?>
<tr>
<td>
<b>Lot Number: </b>
</td>
<td>

<input type=text name=lot_number size=30 value="">
<td>

</tr>

<tr>

<td> Country: 

</td>
 
<td>
<select  name=Country>
<option value=''>&nbsp
<option value='Bolivia' >Bolivia
<option value='Mexico' >Mexico
<option value='Ethiopia' >Ethiopia
</select>
</td>
</tr>

<tr>


<td>Coop: 
</td>
<td>
<select  name=Coop>
<option value=''>&nbsp
<option value='Maya_Vinic' >Maya Vinic
<option value='FECAFEB' >FECAFEB
<option value='Fondo_Paez' >Fondo Paez 
</select>
</td>

  </tr>
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
<form name=frmMain method=post action="follow_step_1.php">
<?







 
echo '<table border="0"  width="90%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
first_table_display();
echo '</table>';
 
?>

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
</body>

</html>
