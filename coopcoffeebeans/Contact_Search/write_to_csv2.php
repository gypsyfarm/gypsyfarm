<?php
require("../functions.php");
require("../tables.php");
session_start();


?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../general.css">

<!-- changed #228B22 to #9bbcc2 -->
</head>


<?
 function db_connect() {
        global $connection;
	$connection = mysql_connect('mysql9.siteprotect.com', 'greenbeans', 'annh401') or die ("<br><br><br><center><font face=\"verdana\" size=\"2\" color=\"black\"><b>Database connection failed.</b><br><br><a href=\"javascript:history.back();\">Back</a></font></center></body></html>");
	$db_select = @mysql_select_db('greenbeans', $connection);
}

function db_kapat() {
	global $connection;
	@mysql_close($connection);
}
 

db_connect();
#$sql = "SELECT COUNT(*) FROM $table";

# $sql = "select * from $tbl_contact_contact";
# echo "<br>session var is ".$_SESSION['contact_id_search']."<br>";
 $sql =  $_SESSION['contact_id_search'];
 
if ($sql == "") {
   $sql = "select * from $tbl_contact_contact";
}   

#echo "<br>sql = ".$sql."<br>";
 
$result = @mysql_query($sql,$connection);
 $db = 'greenbeans';
$table = "$tbl_contact_contact";
 
 $dosyayeri = fopen("coopfile.csv","w+");
 $fields = mysql_list_fields($db, $table, $connection);
$columns = mysql_num_fields($fields);


#  echo '<br> ok let us see <br>';
for ($i = 0; $i < $columns; $i++) {
    if ($i > 0) 
        $csv_output .= ",";
        
    $csv_output .= '"'.mysql_field_name($fields, $i).'"'; 
 #   echo $csv_output;

} 

 #   echo 'ok we have '.$csv.output;
    $csv_output_array[$ai] = $csv_output;
    fwrite ($dosyayeri,$csv_output_array[$ai]."\r\n");
   $csv_output = ""; 
   $ai += 1;
   
 

$result = mysql_query($sql,$connection) or die("Error on table content.");


while ($row = @mysql_fetch_array($result)) 
{ 
	for ($i = 0; $i < $columns; $i++) {
		if ($i > 0) 
		    $csv_output .= ",";
		$csv_output .= '"'.$row[mysql_field_name($fields, $i)].'"';
	}
    $csv_output_array[$ai] = $csv_output;
    fwrite ($dosyayeri,$csv_output_array[$ai]."\r\n");    
   $csv_output = ""; 
   $ai += 1;
   
}

#foreach ($csv_output_array as $output_line)
#        echo '<br>'.$output_line.'<br>';

    fclose ($dosyayeri); 
    echo "<br>";
    
    echo "<a href='coopfile.csv'> Right Click to Download, double Click to open </a>";

#   echo $csv_output;
   exit;  
 #  echo "the end !!!";
   ?>