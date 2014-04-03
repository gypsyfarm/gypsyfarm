<?php

  session_start();
  session_destroy();
 
  if (isset( $_POST['blend_code'])) {  	
     $cookie_value = $_POST['blend_code'];
  } elseif   (isset( $_POST['lot_nbr']))  {
  	 $cookie_value = $_POST['lot_nbr'];
  } else {  
         $cookie_value = $HTTP_COOKIE_VARS["search1"]; 	 
}
  setcookie("search1", $cookie_value, time()+604800,"/"); /* Expires in a week */


function RoasterHeader($rst_id) {

 	$host  = $_SERVER['HTTP_HOST'];
  $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  $extra = 'transparent_document_trail.php?rst_id=$rst_id';
  $NewLocation = "Location: http://".$host."/transparent_document_trail.php?rst_id=$rst_id";
  return $NewLocation;
}


 ?>