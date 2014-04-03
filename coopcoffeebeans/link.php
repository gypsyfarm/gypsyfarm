<?php

if (file_exists("links/link1.html")) {
    if (file_exists("links/link1.desc")) {	
	echo "<font face='Verdana' size='1'>*<a href='links/link1.html'>";
	readfile("links/link1.desc");
	echo "</a></font><br>" ;
	echo '<hr>';
     }	
}

if (file_exists("links/link2.html")) {
    if (file_exists("links/link2.desc")) {	
	echo "<font face='Verdana' size='1'>*<a href='links/link2.html'>";
	readfile("links/link2.desc");
	echo "</a></font><br>" ;
	echo '<hr>';
     }	
}


if (file_exists("links/link3.html")) {
    if (file_exists("links/link3.desc")) {	
	echo "<font face='Verdana' size='1'>*<a href='links/link3.html'>";
	readfile("links/link3.desc");
	echo "</a></font><br>" ;
	echo '<hr>';
     }	
}	


if (file_exists("links/link4.html")) {
    if (file_exists("links/link4.desc")) {	
	echo "<font face='Verdana' size='1'>*<a href='links/link4.html'>";
	readfile("links/link4.desc");
	echo "</a></font><br>" ;
	echo '<hr>';
     }	
}


if (file_exists("links/link5.html")) {
    if (file_exists("links/link5.desc")) {	
	echo "<font face='Verdana' size='1'>*<a href='links/link5.html'>";
	readfile("links/link5.desc");
	echo "</a></font><br>" ;
	echo '<hr>';
     }	
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
 
