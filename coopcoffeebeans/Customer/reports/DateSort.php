<?php
// this is used by usort()

function cmp($a, $b) {
    if ($a['mtime'] == $b['mtime']) {
        return 0;
    }
    return ($a['mtime'] > $b['mtime']) ? -1 : 1;
}


// read dir and save name,size,date in array


 $path = '../../pdf_files/';
//$dir_handle = @opendir($path) or die("Unable to open $path");


$file_list = array();

$dp = opendir($path);
$file_list = array();
while ($item = readdir($dp)) {
	 // echo "$item <br>";
    if (strchr($item,".pdf")) {
    	  $info = stat($path.$item); 
        $stat1 = round($info['size'] / 1024, 2); 
       // echo $info['mtime']."<br>";
        $stat2 = date('j-n-Y H:i:s', $info['mtime']); 
        $file_list[] = array('name' => $item, 'size' => $stat1, 'mtime' => $info['mtime']);
    }
}
// Sort $file_list
usort($file_list, "cmp");
// Create a table header.
print '<hr /><br />
<table cellpadding="2" cellspacing="2" align="left">
<tr>
<td><b>File Name</b></td>
<td><b>File Size</b></td>
<td><b>Last Modified</b></td>
</tr>';
foreach($file_list as $one_file) {
    // Print the information.
    print "<tr>
    <td><a href=\"" . $one_file['name'] . "\">" . $one_file['name'] . "</a></td>
    <td>" . $one_file['size'] . " bytes</td>
    <td>" . date('F j, Y', $one_file['mtime']) . "</td>
    </tr>\n";
}
print '</table>'; // Close the HTML table.
closedir($dp); // Close the directory.
