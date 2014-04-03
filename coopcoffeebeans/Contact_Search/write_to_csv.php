<?php

require("../tables.php");
require("../functions.php");

session_start();

require("../check_login.php");


echo <<<EOD
<html>
<head>
<title>mySQL to TXT for Excel (Local Version 1.0)</title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Keywords" content=", ">
</head>
<body bgcolor="#FFFFFF" bottommargin="0" topmargin="0" leftmargin="0" rightmargin="0" marginwidth="0" marginheight="0">


EOD;




# begin part that I copied
#Here get $action and it should be a string with the select statementment in it? or the key values??

#  $action = $_SESSION['action'];

$action = 'select * from tst_contact_contact';

$foldername = 'data1';
$db = 'greenbeans';
$table = 'tst_contact_contact';

if ( $action ) {



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
$sql = $action;
 
$result = @mysql_query($action,$connection);


if ( !$foldername) {
echo "<br><br><br><center><font face=\"verdana\" size=\"2\" color=\"black\"><b>All fields must be fill.</b><br><br><a href=\"javascript:history.back();\">Back</a></font></center>";
}
elseif (!is_dir($foldername)) {
echo "<br><br><br><center><font face=\"verdana\" size=\"2\" color=\"black\"><b>Destination directory not found.</b><br><br><a href=\"javascript:history.back();\">Back</a></font></center>";
}
else {
unset($sql,$result);

if ( substr($foldername,-1) == "\\" ) { $foldername = substr_replace($foldername,"",-2,2); }

$fields = mysql_list_fields($db, $table, $connection);
$columns = mysql_num_fields($fields);
$dosyayeri = fopen($foldername."\\".$table.".txt","w+");

for ($i = 0; $i < $columns; $i++) {
	fputs ($dosyayeri,strtolower(mysql_field_name($fields, $i)."	"));
}

fputs ($dosyayeri,"
");

$sql = $action; 
$result = mysql_query($sql,$connection) or die("Error on table content.");


while ($row = @mysql_fetch_array($result)) 
{ 
	for ($i = 0; $i < $columns; $i++) {
		$line .= $row[mysql_field_name($fields, $i)]."	";
	}
	fputs ($dosyayeri,$line."	
");
	unset($line);
}


fclose($dosyayeri);

echo "<br><br><br><font face=\"verdana\" size=\"2\" color=\"black\"><b><center>".str_replace("\\\\","\\",$foldername)."\\".$table.".txt file is created.<br><br><a href=\"javascript:history.back();\">Back</a></b></center></font>";


}
db_kapat();

}

else {
echo <<<EOD

<font face="verdana" size="2" color="black">
<form action="$PHP_SELF" method="post">
<center><br>
<b>Folder Name</b>
<br>
<input type="Text" name="foldername" size="20" style="width:600;"><br>
<br><br>
<b>Database Name</b><br>
<input type="Text" name="db" size="20" style="width:600;"><br>
<br><br>
<b>Table Name</b><br>
<input type="Text" name="table" size="20" style="width:600;">
<br><br>
<input type="submit" value="Work!">
<input type="Hidden" name="action" value="ok">
</form>
</center></center>

</font>


EOD;
}











?>


</body>
</html>