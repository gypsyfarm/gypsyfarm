<?php
$dir = "/home/3/f/8/13572/13572/tmp/";
$dir = "/tmp";


// Open a known directory, and proceed to read its contents
$stop = 0;
 
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
         while (($file = readdir($dh)) !== false) {
         	   echo substr($file, 0, 4)."<br> \n";
         	   if (substr($file, 0, 4) == 'sess' ) {
                echo "filename: $file " . " <br>\n";
                if ($stop == 0 ) {
                	 echo "trying to delete the file <br>";
                   unlink("$dir$myFile");
                   echo "after the unlink command";
                   $stop = 1;
                }

            }
        }
     }
        closedir($dh);
        echo "close the file <br> \n";
    } 
else {
	 echo "is not a dir <br> \n";
	}

/*

$dir    = '/tmp';
$files1 = scandir($dir);
$files2 = scandir($dir, 1);

print_r($files1);
print_r($files2);

 */

echo "hello world";
?>
