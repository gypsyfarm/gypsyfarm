<?php
require("../../functions.php");
#require("../../tables.php");
session_start();

require("../../check_login.php");

?>
<html>

<head>
<title>Cooperative Coffees - Order and Contact Database system</title>

<link REL="stylesheet" TYPE="text/css" HREF="../../general.css">


</head>
<?

require("left_menu.php"); 

$set_media = $_REQUEST['set_media'];
if (isset($set_media)) {
    if ($set_media == 'yes') {
       $_SESSION['include_media'] = 'y';
    }
    else {
       $_SESSION['include_media'] = 'n';	
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
if (isset($_SESSION['contact_id']))  {
 
 
	echo '<div class="box"><font size=3><h3>Select A report to Run:</h3></font><br>';

		
	echo '<table border="0"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="0">';

        echo '<td bordercolor="#228B22" bgcolor="#FFFFFF" valign="top">';		
		
        echo '<ul>';
        echo '<li>';
        echo '<font size=3><a href="product_in.php"><span title="This is the Coffee Shipping Report'."\n".' among other things!">Coffee Shipping Report</span></a></font><br>';        
        echo '<li>';
        echo '<font size=3><a href="product_detail.php"><span title="This is the Inventory Report By Product Detail report"> Inventory Report By Product Detail</span></a></font><br>';
        echo '<li>';
        echo '<font size=3><a href="product_detail_flo.php"> <span title="This is the Flow Report"> Flo  Report</span></a></font><br>';
        echo '<li>';        
	echo '<font size=3><a href="customer_sales.php"><span title="This is the Sales by Customer Report"> Sales by Customer Report</span></a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="sales_vs_commit.php"><span title="This is the sales vs. commitments report"> Sales vs. Commitments</span></a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="commit_report.php"><span title="This is the commitment summary report (product only)">Commitment Summary Report - by Product Only</span></a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="commit_report_by_cust.php"> <span title="This is the commitment detail report by product and customer.">Commitment Detail Report - by Product and Customer</span></a></font><br>';
        echo '<li>';

	echo '<font size=3><a href="cust_sales_plus_report.php"><span title="This is the Customer Monthly Sales Report"> Customer Monthly Sales Report</span></a></font><br>';

        echo '<li>';
        echo '<font size=3><a href="sales_report.php"> <span title="This is a monthly sales report">Monthly Sales Report </span></a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="../commit_admin.php"><span title="This is a commitment Maintenance report."> Commitment Maintenance </span></a></font><br>';
        echo '<li>';
	echo '<font size=3><a href="product_summary.php"><span title="This is the Inventory Report Product Summary by warehouse report. "> Inventory Report Product Summary by Warehouse </span></a></font><br>';
        echo '<li>';
        echo '<font size=3><a href="transfer_detail.php"><span title="This is the transfer detail report"> Transfer Detail Report </span></a></font><br>';


        echo '</ul>';
        
        echo '</td><td bordercolor="#228B22" bgcolor="#FFFFFF" valign="top">';
        echo '<ul>';
        echo '<li>';
        echo '<font size=3><a href="admin_coop_commit_test.php" ><span title="This is the New customer commitments & sales report">New!  Customer Committments & Sales Report</span></a></font><br>';
         echo '<li>';
        echo '<font size=3><a href="admin_coffee_commit.php"><span title="This is the Coffee commitments & sales report.">New Coffee Committments & Sales Report</a></font><br>';

        echo '<li>';
        echo '<font size=3><a href="inventory_control.php"><span title="This is the new inventory control report.">New! Inventory Control Report</span></a></font><br>';
        
        echo '<li>';
        echo '<font size=3><a href="green_rpt.php"> <span title="This is the  Green Report">Green Report</span></a></font><br>';
        echo '<li>';
        echo '<font size=3><a href="green_rpt_contracted.php"><span title="This is the  Contract Green Report"> Contract Green Report</span></a></font><br>';   
        echo '<li>';
        echo '<font size=3><a href="green_rpt_future.php"><span title="This is the Future Green Report"> Future Green Report</span></a></font><br>';              
        echo '<li>';
        echo '<font size=3><a href="cupping_rpt_list.php"> <span title="This is the cupping report">Cupping Report List</span></a></font><br>';
        echo '<li>';
        echo '<font size=3><a href="cupping_rpt_delivered.php"><span title="This is the delivered cupping report."> Delivered Cupping Report List</span></a></font><br>';
        echo '</ul>';
        
            echo '</td></tr></table>';    
            
            echo "</div>";
 

   
       
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
