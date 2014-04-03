<?php
$menu_user_type = $HTTP_GET_VARS['x'];;
?>
<html>
<head>
<title>Help</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<p align="left" style="margin-bottom: 0"><strong><font size="4">Cooperative Coffees 
  Order and Contact Management System</font></strong></p>
<p align="left" style="margin-top: 0;"><font size="4">Help Topics</font></p>
<p style="margin-bottom: 0;">&nbsp;</p>
<div align="left">
  <table width="578">
    <tr valign="top"> 
      <td width="294"><em><a name="HelpMenu"></a>Green Coffee Order System</em></td>
      <td width="272"><em>Contact Management System</em></td>
    </tr>
    <tr valign="top"> 
      <td><a href="#Order">Place an Order</a></td>
      <td><a href="#ContactMgt">Enter a New Contact</a></td>
    </tr>
    <tr valign="top"> 
      <td><a href="#Confirm">Edit Order After Confirmation</a></td>
      <td><a href="#SearchContact">Search for a Contact</a></td>
    </tr>
    <tr valign="top"> 
      <td><a href="#History">Review Past Orders</a></td>
      <td><a href="#Notes">Create and Edit Contact Notes</a></td>
    </tr>
    <tr valign="top"> 
      <td><a href="#Commitments">Review Commitments</a></td>
      <td><a href="#Email">Distribute Email to Contact List</a></td>
    </tr>
    <tr valign="top"> 
      <td>
      <?
      if ($menu_user_type == '47A2') {
         echo "<a href='admin_help.html'>Admin Help</a>";
      }
      else {
         echo "&nbsp;";
      }
       
      ?>
      
      
      </td>
      <td><a href="#Export">Export Contacts via CSV file</a></td>
    </tr>
  </table>
</div>
<p style="margin-bottom: 0;"><font size="4"><a name="Green"></a><em>Green 
  Coffee Order System</em></font></p>
<p style="margin-top: 0; margin-bottom: 0;"><font size="4"><a name="Order"></a></font></p>
<p style="margin-top: 0;"><font face="Arial, Helvetica, sans-serif">How 
  to Place an Order-</font></p>
<ul style="margin-bottom: 0;">
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">Click 
    on �Create a New Order� on the Main Menu if you wish to place an order. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">If 
    you would like to order Mexico Maya Vinic coffee, you need to look for its 
    corresponding item designation (ex. MEV). </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">Beside 
    the item designation that you are looking for, you will see an empty box. 
    In this box, type the number of bags of the coffee selected that you would 
    like to purchase. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">When 
    you have finished filling in all of the boxes for the coffees that you wish 
    to purchase, click on the confirm button. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">You 
    will now be taken to the order confirmation page. Please double-check your 
    order for accuracy. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">If 
    you want to change the shipping information that is listed on the page, please 
    type the change that you would like to make in the note field. When our staff 
    confirms your order, we will make the shipping changes that you asked us to 
    make. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">You 
    can delete this order by clicking on the delete order button. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">You 
    can edit this order by clicking on edit order. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">Click 
    on place order so that your order will be forwarded to us. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">Print 
    your invoice. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top:0;margin-bottom:0;">You 
    can now either log-off to leave the site, or you can click on back to the 
    main menu to look at other aspects of the website. </font></li>
</ul>
<p style="margin-top: 0;"><font size="3" face="Arial, Helvetica, sans-serif"><a href="#HelpMenu">Back 
  to Help Menu</a></font></p>
<p><font face="Arial, Helvetica, sans-serif"><a name="Confirm"></a>How 
  to Edit Order after Confirmation</font></p>
<ul style="margin-bottom: 0;">
  <li><font face="Arial, Helvetica, sans-serif">Once an order is placed, you cannot 
    edit this order. </font></li>
  <li><font face="Arial, Helvetica, sans-serif">Call the office at 229-924-3035 
    with the changes and we will handle it</font></li>
</ul>
<p style="margin-top: 0;"><font size="3" face="Arial, Helvetica, sans-serif"><a href="#HelpMenu">Back 
  to Help Menu</a></font></p>
<p><font face="Arial, Helvetica, sans-serif"><a name="History"></a>Reviewing 
  past order history</font></p>
<ul style="margin-bottom: 0;">
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top: 0; margin-bottom: 0;">You 
    can review past orders by clicking on the review orders link. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top: 0; margin-bottom: 0;">More 
    specifically, click on the order that you want to review in order to be able 
    to review your past order in more detail. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top: 0; margin-bottom: 0;">Click 
    on back to main menu to exit this page. </font></li>
</ul>
<p style="margin-top: 0;"><font size="3" face="Arial, Helvetica, sans-serif"><a href="#HelpMenu">Back 
  to Help Menu</a></font></p>
<p style="margin-bottom: 0;"><font face="Arial, Helvetica, sans-serif"><strong><font size="3"><a name="Commitments"></a>Review 
  Commitments</font></strong></font></p>
<ul style="margin-top: 0; margin-bottom: 0;">
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top: 0; margin-bottom: 0;">You 
    can review your commitments by clicking on review commitments. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top: 0; margin-bottom: 0;">Highlight 
    the desired year, and click on view. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top: 0; margin-bottom: 0;">You 
    will be taken to a spreadsheet that details your commitments. </font></li>
  <li><font size="3" face="Arial, Helvetica, sans-serif" style="margin-top: 0; margin-bottom: 0;">Click 
    on back to the main menu for more options. </font></li>
</ul>
<p style="margin-top: 0;"><font size="3" face="Arial, Helvetica, sans-serif"><a href="#HelpMenu">Back 
  to Help Menu</a></font></p>
<p style="margin-bottom: 0;">&nbsp;</p>
<p style="margin-top: 0;"><font face="Arial, Helvetica, sans-serif"><em><a name="ContactMgt"></a>Contact 
  Management System</em></font></p>
<p style="margin-bottom: 0;"><strong><font face="Arial, Helvetica, sans-serif">Enter 
  a New Contact</font></strong></p>
<ul style="margin-top: 0; margin-bottom: 0;">
  <li><font face="Arial, Helvetica, sans-serif">From Main Menu, click Contact 
    Database in left column</font></li>
  <li><font face="Arial, Helvetica, sans-serif">Click &quot;Add New Contact&quot;</font></li>
  <li><font face="Arial, Helvetica, sans-serif">Enter data noting that Company 
    field is required. If no company know, repeat persons name.</font></li>
  <li><font face="Arial, Helvetica, sans-serif">The User Fields are for future 
    use, Check Newsletter to make contact automatically receive. Check &quot;Do 
    Not Receive&quot; to prevent contact from ever receiving email from this database.</font></li>
  <li><font face="Arial, Helvetica, sans-serif">Must click Update to save entered 
    data.</font></li>
</ul>
<p style="margin-top: 0;"><font size="3" face="Arial, Helvetica, sans-serif"><a href="#HelpMenu">Back 
  to Help Menu</a></font></p>
<p style="margin-bottom: 0;"><font face="Arial, Helvetica, sans-serif"><a name="SearchContact"></a><strong>Search 
  for a Contact</strong></font></p>
<ul style="margin-top: 0; margin-bottom: 0;">
  <li><font face="Arial, Helvetica, sans-serif">Click Contact Database to visit 
    the main search screen</font></li>
  <li><font face="Arial, Helvetica, sans-serif">Use the Quick Search Alpha List 
    at top of screen to quickly find all contact company names.</font></li>
  <li><font face="Arial, Helvetica, sans-serif">Use any combination of the Search 
    Fields to create a list specific to exactly who you are looking for.</font></li>
  <li><font face="Arial, Helvetica, sans-serif">Notice that once you locate the 
    contact in a list, you can click on the company name to edit the details</font></li>
</ul>
<p style="margin-top: 0;"><font size="3" face="Arial, Helvetica, sans-serif"><a href="#HelpMenu">Back 
  to Help Menu</a></font></p>
<p><font face="Arial, Helvetica, sans-serif"><a name="Notes"></a>Create 
  and Edit Contact Notes</font></p>
<p><font size="3" face="Arial, Helvetica, sans-serif"><a href="#HelpMenu">Back 
  to Help Menu</a></font></p>
<p><font face="Arial, Helvetica, sans-serif"><a name="Email"></a>Distribute 
  Email to Contact List</font></p>
<p><font size="3" face="Arial, Helvetica, sans-serif"><a href="#HelpMenu">Back 
  to Help Menu</a></font></p>
<p><font face="Arial, Helvetica, sans-serif"><a name="Export"></a>Export 
  Contacts via CSV file</font></p>
<p><font size="3" face="Arial, Helvetica, sans-serif"><a href="#HelpMenu">Back 
  to Help Menu</a></font></p>
</body>
</html>
