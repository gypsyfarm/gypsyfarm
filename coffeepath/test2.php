<?php
 
 
 function uploadcode(){ 
   
    echo ' <input type="hidden" name="MAX_FILE_SIZE" value="300000" />';
    echo ' <input name="userfile" type="file" /><br>';
    echo ' <input type="submit" name="upload" value="Upload PreShip Cupping Rpt" />';
    
    $uploaddir = 'images/';
    $uploadfile = $uploaddir.$_FILES['userfile']['name'];
    echo "<br>uploadfile = $uploadfile <br>";
  
    if (ereg (".pdf$", $uploadfile, $regs)) {
       if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
          print "<br>File is valid, and was successfully uploaded. ";

          if (! chmod($uploadfile, 0544)) {
          echo  ("<br>Unable to change file permissions");
           }
          print_r($_FILES);
       } 
    elseif ($_FILES['userfile']['error'] != 4 ) {
      print "Possible file upload attack!  Here's some debugging info:\n";
      print_r($_FILES);
    }
    } 
    elseif( ! ereg ("pdf_files_p/$", $uploadfile, $regs)) {
       echo "<br>Invalid file type: $uploadfile <br>";
       print_r($_FILES);
    }     
    
}

?>


 
<HTML>
<HEAD>
    <TITLE>Coffee Path Upload test page</TITLE>
  
<meta name="description" content="Coffee Path is maintained by Cooperative Coffees">

<meta name="keywords" content="freetrade, cooperative coffees ">

  

<link rel="stylesheet" type="text/css" href="default.css">

<style>
#input_box1 { background-color:yellow; }
#input_box2 { background-color:yellow; }
</style>

</HEAD>
<BODY BGCOLOR="#333333" text="ececec" link="F76B08" alink="ffffff" vlink="ececec" background="images/bg.gif" bgproperties="fixed">


<center>
<form name=frmMain method=post action='test2.php'>


 
 
<INPUT TYPE="SUBMIT" id="postit" name="postit" VALUE="postit" class="ccbtn"> 
 
 
 
 
<hr>
 
  
 
 
 
<?php



 echo '<span class="noprint">';
uploadcode();  
echo '</span>';

 
 

 
?>  



 
</div>
</form>
</BODY>
</HTML>
