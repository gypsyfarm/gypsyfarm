<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<html lang="en-US">
<head>

<title>Follow the Bean</title>

  <STYLE type="text/css">
 body {
    font: 69% "Lucida Grande", Verdana, Lucida, Helvetica, Arial, sans-serif;
     background-color: light_green;
      color: Black;
     margin: 0;
     padding: 0;
}
 </style>
 

</head>
 
<frameset ROWS="10%,*" border="1" frameborder="1" framespacing="0"
scrolling="yes" noresize title="Frame for Coffee Cooperative Web Site" >

<?php

#associative arrays:


$URL = '';
$arrCountry=array("Mexico"=>"http://coopcoffees.com/what/producers/mexico",
                  "Bolivia"=> "http://coopcoffees.com/what/producers/bolivia",
                  "Ethiopia"=> "http://coopcoffees.com/what/producers/ethiopia");
                  
                  
$arrCoop=array("Maya_Vinic"=>"http://coopcoffees.com/what/producers/maya-vinic-mexico/maya-vinic-mexico",
                  "FECAFEB"=> "http://coopcoffees.com/what/producers/fecafeb-bolivia/fecafeb",
                  "Fondo_Paez"=> "http://coopcoffees.com/what/producers/fondo-paez-colombia/fondo-paez");

 
 /*
    if ($arrCountry[$country] <> ''){
    	$URL = $arrCountry[$country];
    	#header ("Location: $URL");
    }
    
     if ($arrCoop[$coop] <> ''){
    	$URL = $arrCoop[$coop];
    #	header ("Location: $URL");
    }

 
*/

if ($HTTP_POST_VARS['parm_1']  == 'yada') {
	
  echo '<frame border="0" framespacing="0" frameborder="0" marginwidth="0" ';
  echo ' marginheight="0" name="BUTTONSFRAME" noresize scrolling="AUTO" src="ftbleft.php?parm=xxxx" title="selection screen">';
}
else {
      echo '<frame border="0" framespacing="0" frameborder="0" marginwidth="0" ';
      echo ' marginheight="0" name="BUTTONSFRAME" noresize scrolling="AUTO" src="ftbleft.php?parm=xxxx" title="selection screen">';
}  

?>
<frameset border="0" frameborder="0" framespacing="0">  
 
<?php

if ($URL <> '') {
    echo '<frame border="0" frameborder="0" framespacing="10" marginwidth="10" marginheight="10" name="TEXTFRAME" noresize scrolling="AUTO" ';
    echo 'src="'.$URL.'" title="Enter_data">';
}
else {
     echo '<frame border="0" frameborder="0" framespacing="10" marginwidth="10" marginheight="10" name="TEXTFRAME" noresize scrolling="AUTO" ';
    echo 'src="http://www.gypsyfarm.com" title="Enter_data">';
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

