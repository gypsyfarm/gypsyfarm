<? 

 
echo '<body  bgcolor="#FFFFFF" text="#228B22" link="#008000" vlink="#006400 alink="#00FF00"  background="../two_lines.gifs">';

?>
<script language="Javascript">
var dirty = "false";

function subForm(url) {
  //	dirty="true";
  //  alert(dirty);
   if (dirty == "false") {
      location.href = url;
   }   
   else {
       if (confirm("You made changes and did not update the record. Press cancel then press update to save records. If you press OK you will lose your changes.")) { 
           location.href = url;  
        } 
        return false; 
   } 
}

 
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
   
           ?>
        <a href="javascript:poptastic('../Help.htm');"><font face="Verdana" size="1" color="#FFFFFF">help</font</a>
        <?

   #         echo '<u><a href="../Help.htm" target="help"><font face="Verdana" size="1" color="#FFFFFF"> Help </a></b></font></td>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
          echo '<td width="600" bordercolor="#228B22" bgcolor="#FFFFFF">';

           
if (isset($_SESSION['contact_id']))  {
    $user_type = $_SESSION['user_type'];
//********Present the Menus*********************************************
    if ($user_type == 1) {
	   echo '<font face="Verdana" size="1">*<a href="../Customer/cooporder.php">Create a new Order</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Customer/reports/index.php">View Reports<br>';
	   ?>
	   <hr>	
	   <font face="Verdana" size="1">*
	   <a href='#' onclick='javascript:subForm("../index.php");'>Back to Main Menu</a>
	   </font><br>
           <hr>	   
           <font face="Verdana" size="1">*
	   <a href='#' onclick='javascript:subForm("../Contact_Search/contact_start.php");'>Contact Database</a>
	   </font><br>
	   <hr>
	   <font face="Verdana" size="1">*
	   <a href='#' onclick='javascript:subForm("../Contact_Search/add_contact.php");'>Add New Contact</a>
	   </font><br>
	   <hr>
	   <font face="Verdana" size="1">*
	   <a href='#' onclick='javascript:subForm("../Contact_Search/contact_note_rpt.php");'>Note Report</a>
	   </font><br>
	   <hr>	   	   
	   
	   <?
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Contact_Search/Customer/password.php">Change Password</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../logout.php">Log out</a></font><br>';
	}
	else if ($user_type == 2) {
 	   ?>
 	   
 	   <font face="Verdana" size="1">*
	   <a href='#' onclick='javascript:subForm("../index.php");'>Back to Main Menu</a>
	   </font><br>
           <hr>
 
 
 	   <font face="Verdana" size="1">*<a href='#' onclick='javascript:subForm("product_start.php");'>Lot Maintenance</a>
 	   </font><br> 
          <hr>
          
 	   <font face="Verdana" size="1">*<a href='#' onclick='javascript:subForm("product_maint.php?item_id=0");'>Add Lot</a>
 	   </font><br> 
          <hr>          
           <!--
 	   <font face="Verdana" size="1">*<a href='#' onclick='javascript:subForm("index2.html");'>Product Desc.</a>
 	   </font><br> 
          <hr>          
           -->
 	   <font face="Verdana" size="1">*<a href='#' onclick='javascript:subForm("product_desc_start.php");'>Product Desc. Maint</a>
 	   </font><br> 
          <hr> 
          <font face="Verdana" size="1">*<a href='#' onclick='javascript:subForm("product_desc_maint.php?item_code=0");'>Add Product Desc</a>
 	   </font><br> 
          <hr>
 
           <font face="Verdana" size="1">*
	   <a href='#' onclick='javascript:subForm("../Contact_Search/contact_start.php");'>Contact Database</a>
	   </font><br>
	   <hr>
	   <font face="Verdana" size="1">*
	   <a href='#' onclick='javascript:subForm("../Contact_Search/add_contact.php");'>Add New Contact</a>
	   </font><br>
	   <hr>
	   <font face="Verdana" size="1">*
	   <a href='#' onclick='javascript:subForm("../Contact_Search/contact_note_rpt.php");'>Note Report</a>
	   </font><br>
	   <hr>	 
     <font face="Verdana" size="1">*
	   <a href='#' onclick='javascript:subForm("../logout.php");'>Log out</a>
	   </font><br>
	   <hr>
	   
<?php
 
	}
	else if ($user_type == 3) {
	   echo '<font face="Verdana" size="1">*<a href="../Contact_Search/Bank/bankorder1.php">Approve new Orders</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Contact_Search/Bank/bankreview1.php">Review Approved Orders</a></font><br>';
           echo '<hr>';
           echo '<font face="Verdana" size="1">*<a href="reports/product_detail.php">Inventory Report By Product Detail</a></font><br>';
           echo '<hr>';
           echo '<font face="Verdana" size="1">*<a href="reports/customer_sales.php">Sales by Customer Report</a></font><br>';
            echo '<hr>';
   	   echo '<font face="Verdana" size="1">*<a href="reports/sales_vs_commit.php">Sales vs. Commitments</a></font><br>';
            echo '<hr>';
   	   echo '<font face="Verdana" size="1">*<a href="reports/product_summary.php">Inventory Report Product Summary by Warehouse</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Customer/password.php">Change Password</a></font><br>';
           echo '<hr>';
     	   echo '<font face="Verdana" size="1">*<a href="../logout.php">Log out</a></font><br>';
  	}
	else if ($user_type == 4) {
	   echo '<font face="Verdana" size="1">*<a href="../warehouse/whorder1.php">Ship new Orders</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../warehouse/whreview1.php">Review Shipped Orders</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../Customer/password.php">Change Password</a></font><br>';
           echo '<hr>';
	   echo '<font face="Verdana" size="1">*<a href="../logout.php">Log out</a></font><br>';
	}
	else if ($user_type == 6) {
           echo '<font face="Verdana" size="1">*<a href="reports/product_detail.php">Inventory Report By Product Detail</a></font><br>';
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
            echo '<u>L</u>ogin</font></b></td>';
        echo '</tr>';
        echo '<tr>';
          echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
           echo '<center><br>';
           echo '<form name="login" method=post action="start.php">';
            echo '<input type="text" name="userid" size="20" style="font-family: Verdana; font-size: 10px; color: #228B22; background-color: #FFFFFF; border: 1 solid #228B22" value="User Name">';
            echo '<br>';
            echo '<input type="password" name="password" size="20" style="font-family: Verdana; font-size: 10px; color: #228B22; background-color: #FFFFFF; border: 1 solid #228B22" value="Password">';
            echo '<br>';
            echo '<input type="submit" value="Login" name="login" style="font-family: Verdana; font-size: 10px; color: #228B22; background-color: #FFFFFF; border: 1 solid #228B22">';
            echo '<input type="reset" value="Reset" name="reset" style="font-family: Verdana; font-size: 10px; color: #228B22; background-color: #FFFFFF; border: 1 solid #228B22">';
           echo '</form>';
           echo '</center>';
          echo '</td>';
        echo '</tr>';
  }      
 
      echo '</table>';
    echo '</td>';
    