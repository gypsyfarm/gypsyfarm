<?php
require("../../functions.php");
require("../../tables.php");
// check security
 session_start();
 require("../../check_login.php");
// check session variable

$contact_id = $_SESSION['contact_id'];

	echo'<html>';

	echo'<head>';
  	echo'<title>Cupping Report List</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
        echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';
	#echo'<img SRC="../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';

 
	
      echo '<table width=100%><tr bgcolor=palegreen><td>';
      echo '<font size=3><a href="../../logout.php">Log Out</a></font> ';
      echo '</td><td align=center>';
      echo '<font size=3><a href="index.php">Back to the Report Menu</a></font>';
      echo '</td><td align=center>'; 
      echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font>';
      echo '</td></tr></table>';
  
  
  
        echo '<center><h2> Cupping report List </h2></center>';

 
        
//define the path as relative
#$path = "/home/yoursite/public_html/whatever";

//using the opendir function
#$dir_handle = @opendir($path) or die("Unable to open $path");


$path = '../../pdf_files/';
$dir_handle = @opendir($path) or die("Unable to open $path");
 
echo '<TABLE border=1 cellPadding=0 cellSpacing=0 width="100%">';
echo '<tr bgcolor="#9bbcc2"><td colspan=3>';

echo "Directory Listing of $path<br/>";
echo '</td></tr>';

//running the while loop
$filenames = array();


while ($file = readdir($dir_handle)) 
{
	
   if($file!="." && $file!=".." &&    !strchr($file,"price")) {
   	
       	$filenames[] = $file;
       	/*
        echo '<tr><td>';
        $info = stat($path.$file); 
        $stat1 = round($info['size'] / 1024, 2); 
        $stat2 = date('j-n-Y H:i:s', $info['mtime']); 
       echo "<a href='".$path.$file."'  target='report'>File: $file  </a>";
       echo '</td><td>';
       echo "Size:$stat1 K  ";
       echo '</td><td>';
       echo "Date:$stat2 ";
       echo '</td></tr>';
       */
   }    
}

// echo "<tr><td colspan='3'>xxxxx</td></tr>";

sort($filenames);
 
 
foreach($filenames as $file) {
     // echo $file . '<br/>';
 
        echo '<tr><td>';
        $info = stat($path.$file); 
        $stat1 = round($info['size'] / 1024, 2); 
        $stat2 = date('j-n-Y H:i:s', $info['mtime']); 
       echo "<a href='".$path.$file."'  target='report'>File: $file  </a>";
       echo '</td><td>';
       echo "Size:$stat1 K  ";
       echo '</td><td>';
       echo "Date:$stat2 ";
       echo '</td></tr>';
        
}
 
echo '</table>';

//closing the directory
closedir($dir_handle);



 
/*
$filenames = array();
while ($filename = readdir($dir)) {
$filenames[] = $filename;
}

sort($filenames);

foreach($filename in $filenames) {
echo $filename . '<br/>';
}

*/

?>