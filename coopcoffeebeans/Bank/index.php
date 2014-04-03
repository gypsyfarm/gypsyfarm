<?php
require("../functions.php");
#require("../tables.php");
session_start();

require("../check_login.php");

?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../general.css">


</head>
<?

require("left_menu.php"); 

$set_media = $_REQUEST['set_media'];
if (isset($set_media)) {
    if ($set_media == 'yes') {
       $HTTP_SESSION_VARS['include_media'] = 'y';
    }
    else {
       $HTTP_SESSION_VARS['include_media'] = 'n';	
    }
}	

    echo '<td  valign="top">';
      echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
         #   echo '<u>C</u>ontent:</b></font></td>';  
             echo date('H:i, jS F');    
        echo '</b></font></td>'; 
        echo '</tr>';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
  #          echo '<p align="right">¤ ';
  #          echo date('H:i, jS F');
  #          echo '</p>';
 
 
//********Present the Menus*********************************************
if (isset($HTTP_SESSION_VARS['contact_id']))  {
 
 
	echo '<div class="box"><font size=3><h3>Select A report to Run:</h3></font><br>';

		
        echo '<ul>';
        echo '<li>';
        echo '<font size=3><a href="product_in.php">Coffee Shipping Report</a></font><br>';        
        echo '<li>';
        echo '<font size=3><a href="product_detail.php"> Inventory Report By Product Detail</a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="customer_sales.php"> Sales by Customer Report</a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="sales_vs_commit.php"> Sales vs. Commitments</a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="commit_report.php">Commitment Summary Report - by Product Only</a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="commit_report_by_cust.php"> Commitment Detail Report - by Product and Customer</a></font><br>';
        echo '<li>';

	#echo '<font size=3><a href="admin_cust_sales_report.php"> Customer Monthly Sales Report</a></font><br>';
	echo '<font size=3><a href="cust_sales_plus_report.php"> Customer Monthly Sales Report</a></font><br>';

        echo '<li>';
        echo '<font size=3><a href="sales_report.php"> Monthly Sales Report </a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="../commit_admin.php"> Commitment Maintenance</a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="product_summary.php"> Inventory Report Product Summary by Warehouse</a></font><br>';
        echo '<li>';
        echo '<font size=3><a href="transfer_detail.php"> Transfer Detail Report</a></font><br>';
        echo '<li>';
        echo '<font size=3><a href="green_rpt.php"> Green Report</a></font><br>';
        echo '<li>';
        echo '<font size=3><a href="green_rpt_contracted.php"> Contract Green Report</a></font><br>';   
        echo '<li>';
        echo '<font size=3><a href="green_rpt_future.php"> Future Green Report</a></font><br>';              
        echo '<li>';
        echo '<font size=3><a href="cupping_rpt_list.php"> Cupping Report List</a></font><br>';
        echo '<li>';
        echo '<font size=3><a href="cupping_rpt_delivered.php"> Delivered Cupping Report List</a></font><br>';
        echo '</ul></div>';

   
       
    echo '</td></tr></table>';    
 
 
           
}     
else {  
    if (isset($userid)) {
      // if they've tried and failed to log in
        echo 'Could not log you in';
    }
    else {
      // they have not tried to log in yet or have logged out
      echo '<font size=4 color=black>You are not logged in, please enter a valid userid and password.</font>';
    }
}
?>


            <hr noshade size="1" color="#228B22">
             
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>


</body>

</html>
