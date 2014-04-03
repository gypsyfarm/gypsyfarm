<?php

// check security
 session_start();
 require("../../check_login.php");
// check session variable

 

	echo'<html>';
	echo'<head>';
  	echo'<title>Reports</title>';
    echo'<META http-equiv=Content-Type content="text/html; charset=windows-1252">';
	echo'<link REL="stylesheet" TYPE="text/css" HREF="general.css">';
	echo'</head>';
    echo'<BODY text=#000000 vLink=#800080 aLink=#ff0000 link=#0000ff bgColor=#ffffff>';


    echo '<table width=100%>';
    echo '<tr>';
    echo '<td width=25%>';
	echo'<img SRC="../../cclogo.jpeg" BORDER=0 height=122 width=133 align=LEFT>';
	echo '</td><td width=25%>';
	echo '<font size=3 color=blue>You are logged in as '.$_SESSION['valid_user'].'</font><br>';
		echo '</td><td width=25%>';
	echo '<font size=3><a href="../../index.php">Back to the main Menu</a></font><br>';
		echo '</td><td width=25%>';
    echo '<font size=3><a href="../../logout.php">Log Out</a></font><br> ';
    	echo '</td></tr></table>';
	
	
	
	echo '<font size=4 color=blue>Choose a report to view:</font><br>';
	
	echo '<ul>';
	echo '<li><font size=3><a href="coop_commits_rpt.php">Commit & Sales Report - Shows total commitments for the year by month along with the Sales by month YTD.</a></font><br>';

        echo '<li><font size=3><a href="review_orders.php">View Orders</a></font><br>';
	echo '<li><font size=3><a href="coop_commit.php">View Commitments</a></font><br>';
	echo '<li><font size=3><a href="cust_sales_vs_commit.php">Sales vs. Commitments</a></font><br>';
	echo '<li><font size=3><a href="sales.php">Sales Report</a></font><br>';

        echo '<li><font size=3><a href="green_rpt.php">Green report</a></font><br>';
        echo '<li><font size=3><a href="green_rpt_contracted.php">Contract Green report</a></font><br>';
        echo '<li><font size=3><a href="green_rpt_future.php">Future Green report</a></font><br>';
        echo '<li><font size=3><a href="cupping_rpt_list.php">Cupping Report List</a></font><br>';
        echo '<li><font size=3><a href="cust_sales_plus_report.php">Monthly Sales Report</a></font><br>';
        echo '<li><font size=3><a href="../product_start.php"><span title="Coffee Lot Review - View all details associated with a container of coffee  including key shipping and available dates, price and differential paid">Lot Review</span></a></font><br>';
        echo '</ul>';
	#echo '<font size=3>Inventory Report</a></font><br>';
?>