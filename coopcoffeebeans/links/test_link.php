<?
require("functions.php");
require("tables.php");
session_start();



#require("check_login.php");



?>

<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="general.css">

</head>
 
<?php


if (file_exists("links/page1.html")) {
	echo "<a href='index2.html'>";
	readfile("links/page1.desc");
	echo "</a>" ;
}	


/*
if ($handle = opendir('.')) {
   while (false !== ($file = readdir($handle))) {
       if ($file != "." && $file != "..") {
           echo "$file <br>\n";
       }
   }
   closedir($handle); 
}   

*/
?>
</body></html> 
