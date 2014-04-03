<?php
require("functions.php");
session_start();
#logo();

  $old_user = $_SESSION['valid_user'];  // store  to test if they *were*   logged in
  unset($_SESSION['valid_user']);   
  unset($_SESSION['contact_id']);
  session_destroy();
  header("Location: http://www.coopcoffeesbeans.com/index.php")
  
?>
<h1><center>Log out Screen</center></h1>
<?php 
  if (!empty($old_user))
  {
    echo '<br><br><br>You have logged out!<br>';
  }
  else
  {
    // if they weren't logged in but came to this page somehow
    echo 'You were not logged in, and so have not been logged out.<br />'; 
  }
?> 
<a href="index.php">Back to login page</a>
</body>
</html>