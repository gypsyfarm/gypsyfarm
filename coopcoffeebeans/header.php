<?php
 session_start();
  if (isset($HTTP_SESSION_VARS['valid_user']))
  {
    $contact_id = $HTTP_SESSION_VARS['contact_id'];
  }
  else
  {
  header("Location: http://www.cooperativecoffees.com/member_area/order/badlogin.php");

  }

 
?>
