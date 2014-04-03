<?php

 session_start();
 session_destroy();
 
 function CoopHeader($coop_id) {

 	$host  = $_SERVER['HTTP_HOST'];
  $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  $extra = 'transparent_document_trail.php?rst_id=$rst_id';
  $NewLocation = "Location: http://".$host."/transparent_document_trail.php?coop_id=$coop_id";
  return $NewLocation;
}

 ?>