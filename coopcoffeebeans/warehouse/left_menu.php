<? 
echo '<body bgcolor="#FFFFFF" text="#228B22" link="#008000" vlink="#006400 alink="#00FF00" background="../two_lines.gifs">';

?>
<script language="Javascript">
var newwindow;
function poptastic(url)
{
	newwindow=window.open(url,'help','height=300,width=650,resizable=yes,scrollbars=yes,left=200,top=150');
	if (window.focus) {newwindow.focus()}
}
</script>
<?
echo '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#228B22">';
  echo '<tr>';
    echo '<td width="100%">';
      echo '<p align="center"><font color="#FFFFFF" face="Verdana" size="4"><b><i>Cooperative Coffees - Order and Contact Database system';
     
      echo '</i></b></td>';
  echo '</tr>';
echo '</table>';

echo '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
  echo '<tr>';
    echo '<td width="150" valign="top">';
      echo '<table border="1" width="140" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
      echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
       $menu_user_type = $_SESSION['user_type'];
        
        echo "<a href=\"javascript:poptastic('../Help.php?x=47A$menu_user_type');\"><font face='Verdana' size='1' color='#FFFFFF'>help</font</a>";
         
       echo '</tr>';
        echo '<tr>';
          echo '<td width="600" bordercolor="#228B22" bgcolor="#FFFFFF">';

           
if (isset($_SESSION['contact_id']))  {
    $user_type = $_SESSION['user_type'];
//********Present the Menus*********************************************
           echo '<form name="login" method=post action="index.php">';
    if ($user_type == 1) {
           echo '<font face="Verdana" size="1">*<a href="../index.php">Back to Main Menu</a></font><br>';
           echo '<hr>';   	
	   echo '<font face="Verdana" size="1">*<a href="../Customer/cooporder.php">Create a new Order</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Customer/reports/index.php">View Reports</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Contact_Search/contact_start.php">Contact Database</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Customer/password.php">Change Password</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../logout.php">Log out</a></font><br>';
	}
	else if ($user_type == 2) {
           echo '<font face="Verdana" size="1">*<a href="../index.php">Back to Main Menu</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Bank/bankreview1.php">Review Approved<br>&nbsp;&nbsp; Orders</a></font><br>';
           echo '<hr>';
 	   echo '<font face="Verdana" size="1">*<a href="../warehouse/whreview1.php">Review Shipped<br>&nbsp;&nbsp; Orders</a></font><br>';	
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../logout.php">Log out</a></font><br>';
 
	}
	else if ($user_type == 3) {
	   echo '<font face="Verdana" size="1">*<a href="../Bank/bankorder1.php">Approve new Orders</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Bank/bankreview1.php">Review Approved Orders</a></font><br>';
           echo '<hr>';
           echo '<font face="Verdana" size="1">*<a href="../reports/product_detail.php">Inventory Report By Product Detail</a></font><br>';
           echo '<hr>';
           echo '<font face="Verdana" size="1">*<a href="../reports/customer_sales.php">Sales by Customer Report</a></font><br>';
           echo '<hr>';
  	   echo '<font face="Verdana" size="1">*<a href="../reports/sales_vs_commit.php">Sales vs. Commitments</a></font><br>';
            echo '<hr>';
   	   echo '<font face="Verdana" size="1">*<a href="../reports/product_summary.php">Inventory Report Product Summary by Warehouse</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Customer/password.php">Change Password</a></font><br>';
            echo '<hr>';
     	   echo '<font face="Verdana" size="1">*<a href="../logout.php">Log out</a></font><br>';
  	}
	else if ($user_type == 4 || $user_type == 5 || $user_type == 7) {
	   echo '<font face="Verdana" size="1">*<a href="../warehouse/whorder1.php">Ship new Orders</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../warehouse/whreview1.php">Review Shipped Orders</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Customer/password.php">Change Password</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../logout.php">Log out</a></font><br>';
	}
	else if ($user_type == 6) {
           echo '<font face="Verdana" size="1">*<a href="product_detail.php">Inventory Report By Product Detail</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Customer/password.php">Change Password</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../logout.php">Log out</a></font><br>';
	}
}

 
        
            echo '</td>';
        echo '</tr>';
if (!isset($_SESSION['contact_id']))  {  
        
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><b><font color="#FFFFFF" face="Verdana" size="1">::';
            echo ' &nbsp;</font></b></td>';
        echo '</tr>';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
            echo '<form name="login" method=post action="index.php">';
            echo 'Login ID:<br><input type="text" name="userid" size="20" style="font-family: Verdana; font-size: 10px; color: #228B22; background-color: #FFFF44; border: 1 solid #228B22" value="User Name">';
            echo '<br> Password:<br>';
            echo '<input type="password" name="password" size="20" style="font-family: Verdana; font-size: 10px; color: #228B22; background-color: FFFF44; border: 1 solid #228B22" value="Password">';
            echo '&nbsp;<center><br>';
            echo '<input type="submit" value="Login" name="login" style="font-family: Verdana; font-size: 10px; color: #000000; background-color: #FFFFCC; border: 4 solid #228B22">&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<input type="reset" value="Reset" name="reset" style="font-family: Verdana; font-size: 10px; color: #000000; background-color: #FFFFCC; border: 4 solid #228B22">';
           echo '</form>';
           echo '</center>';
          echo '</td>';
        echo '</tr>';
  }      
#        <tr>
#          <td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::
#            <u>L</u>inks:</b></font></td>
#        </tr>
#        <tr>
#          <td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">&nbsp;<font face="Verdana" size="1">*
#          
#        
#            <a href="http://www.freelayouts.com" target="_blank">Free Layouts</a><br>
#            </font>&nbsp;<font face="Verdana" size="1">* <a href="mailto:rupak86@hotmail.com" target="_blank">Badrul
#            Rupak</a><br>
#            </font>&nbsp;<font face="Verdana" size="1">* <a href="http://www.mp3.com/thatbandcalledturd" target="_blank">Turd</a></font>
#  
#       
#         </td>
#        </tr>
 
      echo '</table>';
    echo '</td>';
    