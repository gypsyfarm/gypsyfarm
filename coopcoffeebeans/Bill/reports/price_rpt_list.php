<?php
require("../../functions.php");
require("../../tables.php");
// check security
 session_start();
// check session variable

  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
  }

	echo'<html>';

	echo'<head>';
  	echo'<title>Monthly Price List</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
        echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>'; 
	#echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';


      echo '<form enctype="multipart/form-data" method=POST action="price_rpt_list.php"  method="post">';

      echo '<table width=100%><tr bgcolor=palegree><td>';
      echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
      echo '</td><td align=center>';
      echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';
        echo '<center ><h2> Price List Report </h2></center>';

 
        
//define the path as relative
#$path = "/home/yoursite/public_html/whatever";

//using the opendir function
#$dir_handle = @opendir($path) or die("Unable to open $path");


/*


Comment/Reply (w/o sign-up)
electriic ink
May 1 2006, 12:37 PM
So you want to display the files/folders in a directory alphabetically? The code is as follows:

CODE
<?
$path = "";
$files_gathered = array();

$dir_handle = @opendir($path) or die("Unable to open $path");
echo "Directory Listing of $path<br/>";

while($file = readdir($dir_handle)) {

if(is_dir($file)) {
continue;
} else if($file != '.' && $file != '..') {
$files_gathered[] = $file;
}

}

//closing the directory
closedir($dir_handle);

// begin sorting and displaying the files

$files_gathered = sort ($files_gathered);
$count = count ($files_gathered);

for ($loop_start = 0; isset($files_gathered[$loop_start]); $loopstart++) {
echo "<a href='" . $path . $files_gathered[$loop_start] .
"' title="' . $files_gathered[$loop_start] . "'> " . $files_gathered[$loop_start] . " </a> <br />";
}

*/



 
echo '<TABLE border=1 cellPadding=0 cellSpacing=0 width="100%">';
echo '<tr bgcolor="#9bbcc2"><td colspan=3>';

echo "Directory Listing of  files with current or Price in Name: Location: $path<br/>";
$history = "";

  echo '<br> <input type="hidden" name="MAX_FILE_SIZE" value="400000" />';
  echo ' <input name="userfile" type="file" />';
  echo ' <input type="submit" value="Upload Current Price Sheet." /> (Use for pricesheet.pdf (current pricesheet)<br>';
  
  
 // echo '<br>userfile = '.$_REQUEST['userfile'].' and name = '.$_FILES['userfile']['name'].'<br>';
//  echo 'action is '.$_REQUEST['action'].'<br>';  
    
  $uploaddir = '../../pdf_files/';
  $uploadfile = $uploaddir.$_FILES['userfile']['name'];
  
 # echo '<br> uploadfile is '.$uploadfile.'<br>';
 
if (ereg ("currentpricesheet.pdf$", $uploadfile, $regs)) {
   print "<pre>";
   $today = date('Y-m-d');
  // echo "today  = ". $today . "\n";
   $new_file_name = "/home/coffeebeans/coopcoffeesbeans.com/demo/pdf_files/pricesheet_".$today.".pdf";
   rename("/home/coffeebeans/coopcoffeesbeans.com/demo/pdf_files/currentpricesheet.pdf", $new_file_name);
   if (move_uploaded_file($_FILES['userfile']['tmp_name'], "../../pdf_files/currentpricesheet.pdf")) {
      print "File is valid, and was successfully uploaded. ";
      
      if (! chmod($uploadfile, 0544)) {
          echo  ("<br>Unable to change file permissions");
       }
      #  print "Here's some more debugging info:\n";
      # print_r($_FILES);
   } 
   elseif ($_FILES['userfile']['error'] != 4 ) {
      print "Possible file upload attack!  Here's some debugging info:\n";
      print_r($_FILES);
   }
   print "</pre>";
} elseif( ! ereg ("pdf_files/$", $uploadfile, $regs)) {
   echo "<br>Invalid file: $uploadfile <br>";
} 
    
echo '</td></tr>';

  $path = '../../pdf_files/';
$dir_handle = @opendir($path) or die("Unable to open $path");

//running the while loop
while ($file = readdir($dir_handle)) 
{
	
	   if($file!="." && $file!=".." &&   strchr($file,"current")) {
        echo '<tr bgcolor="lightgreen"><td><br>';
        $info = stat($path.$file); 
        $stat1 = round($info['size'] / 1024, 2); 
        $stat2 = date('j-n-Y H:i:s', $info['mtime']); 
       echo "<h2><a href='".$path.$file."'  target='report'>Current Price List  </a></h2>";
       echo "<p>";
       echo '</td>';
       echo '<td valign"center">';
       echo " <h2>Date:$stat2 </h2>";
       echo '</td></tr>';
       echo '<tr><td> Previous Lists </td><td> </td></tr>';
   } 
	 elseif($file!="." && $file!=".." &&    strchr($file,"price")) {
        $history .= '<tr><td valign="center">';
        $info = stat($path.$file); 
        $stat1 = round($info['size'] / 1024, 2); 
        $stat2 = date('j-n-Y H:i:s', $info['mtime']); 
        $history .=  " <a href='".$path.$file."'  target='report'>File: $file  </h4>";
        $history .=  '</td>';
        $history .=  '<td>';
        $history .=  "Date:$stat2 ";
        $history .=  '</td></tr>';
   }    
}

echo $history;
echo '</table>';

echo "</form>";

//closing the directory
closedir($dir_handle);
 


?>