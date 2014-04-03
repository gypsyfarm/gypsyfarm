<?php


$start = getdate();
echo $start;
$tomorrow = date ("m-d-Y", mktime (0,0,0,date("m"),date("d")+1,date("Y"))); 

echo $tomorrow."<br>";




?>