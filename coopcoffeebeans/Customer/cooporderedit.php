
<?php
// check security
 session_start();
// check session variable

  if (isset($_SESSION['valid_user']))
    {
    $contact_id = $_SESSION['contact_id'];
	}
  else
    {
	header("Location: http://www.coopcoffeesbeans.com/badlogin.php");
 	}

// create short variable names
// action is not used right now but might be, id of course is required.
  $current_id=$_REQUEST['current_id'];
  $action=$_REQUEST['action'];
  $edit_value=$_REQUEST['edit'];
  echo $edit_value;
  
  $total_bags = 0;



# to control loops.
  	$num_products = $_REQUEST['nbr_products'];
  	$test_name = "p0";
	$product[0] = $_REQUEST[$test_name];
   	$amount_name = $product[0];
   	$product_amount[0] = $_REQUEST[$amount_name];
	


//*********************Begin Order Confirmation Screen**********************************
//**************************************************************************************

echo'
<html>
<head>
<title>Order Confirmation</title>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" HREF="general.css">
</head>';
echo '
<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>
<img SRC="cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>
<br><center><h1>Order Confirmation</h1></center><br><br><br><br>
<font size=3><a href="../index.php">Back to the Customer Menu</a></font><br>
<font size=3><a href="../logout.php">Log out</a></font><br>
<br>';



# pull each item that was available on the previous page.
    echo '<bold><font size=4 color=red>You are about to order for the following items:</font></bold>';
    echo " <TABLE cellSpacing=0 cellPadding=0 width='95%' border=1>";
    echo '<tr>';
	echo '<th align=center>Name of the Product</th>';
	echo '<th align=center>Number of Bags</th>';
	echo '</tr>';
	
  for ($i=0; $i <$num_products;  $i++)
  {
   
   $test_name = 'p'.$i;
   $product[$i] = $_REQUEST[$test_name];
   $amount_name = $product[$i];
   $product_amount[$i] = $_REQUEST[$amount_name];
    if ($product_amount[$i] != 0){
	echo '<tr>';
	echo "<td><font color=black>".$amount_name."&nbsp;</font></td>";
	echo "<td><font color=black>".$product_amount[$i]."&nbsp;</font></td>";
	echo "</tr>";
	echo "<input type=hidden name=\"$amount_name\" value=\"$product_amount[$i]\">";

	}
  }
  echo '<form name=edit method=post action="cooporder.php">';
  echo'<input type="submit" value="edit order" name="edit">';
  echo'<input type="submit" value="delete order" name="edit">';
  echo'<input type="submit" value="place order" name="edit">';
  echo'</form>';
   
 ?>
 
</BODY>


</HTML>
