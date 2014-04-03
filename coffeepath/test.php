<?php
 
 class ImageUpload {
 	
 	var $directory = "";
 	
    function ImageUpload($directory){
    	$this->directory =$directory;
    	 echo 'directory is now set to '.$this->directory;
    	 echo "<p>";
    	 $this->SetHiddenFields();
    }
    
    function SetHiddenFields(){
    	 echo ' <input type="hidden" name="MAX_FILE_SIZE" value="300000" /><br>';
    	 echo "\n";
         echo ' <input name="userfile" type="file" /><br>';
         echo "\n";
         echo ' <input type="submit" name="upload" value="Upload Image" /><br>';
         echo "\n";
    }
    
    function SetDirectory($directory) {
    	$this->directory = $directory;
    	echo 'directory is now set to '.$this->directory;
    	echo "<p>";
    }
    
    function EchoDirectory() {
    	echo 'directory is now set to '.$this->directory;
    	echo "<p>";
    }
    
    function DoUpload() {
    	
    	echo "<br>This directory = ";
    	echo $this->directory;
    	echo "<br>";
    	echo "_files = ";
    	echo $_FILES['userfile']['name'];
    	echo "<br>";
    	$uploadfile = $this->directory.$_FILES['userfile']['name'];
    	
    	echo "<br>uploadfile name  = $uploadfile <br>";
    	
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                print "<br>File is valid, and was successfully uploaded. ";

                if (! chmod($uploadfile, 0544)) {
                    echo  ("<br>Unable to change file permissions");
                }
                 print_r($_FILES);
                 echo "<br>";
            } 
            elseif ($_FILES['userfile']['error'] != 4 ) {
                print "Possible file upload attack!  Here's some debugging info:\n";
                echo "<br>";
                print_r($_FILES);
            }
 
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
<form name=frmMain enctype="multipart/form-data"  method=post action='test.php'>


 
 
<INPUT TYPE="SUBMIT" id="postit" name="postit" VALUE="postit" class="ccbtn"> 
 
 
 
 
<hr>
 
  
 
 
 
<?php



$LocalUpload = new ImageUpload("images/");
 

echo "<p>";

$upload = $_REQUEST['upload'];

if (isset($upload)) {
  echo "You pushed the button that says: '$upload' <br>";
  $LocalUpload->DoUpload();
  
}
echo "<br>After wards-";
 print_r($_FILES);
 

 
?>  



 
</div>
</form>
</BODY>
</HTML>
