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

    echo '<td  valign="top">';
    echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
    echo '<tr>';
    echo '<td width="100%" bordercolor="#228B22" bgcolor="#228B22"><font face="Verdana" size="1" color="#FFFFFF"><b>::';
    echo '<u>C</u>ontent:</b></font></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td width="100%" bordercolor="#228B22" bgcolor="#FFFFFF">';
    echo '<p align="right">¤ ';
    echo date('H:i, jS F');
    echo '</p>';
 
 
//********Present the Menus*********************************************
if (isset($_SESSION['contact_id']))  {
 
  echo '<center> <b>Quick search for Lots by Item Code</b> </center><br>';
  echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="1" bordercolorlight="#FFFF44" bordercolordark="#44FFFF" cellpadding="2">';
  echo '<tr bgcolor="FFFF44">';
  echo '<td align=center>';
  echo '<a href="product_results.php?quicksearch=A"> A </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=B"> B </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=C"> C </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=D"> D </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=E"> E </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=F"> F </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=G"> G </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=H"> H </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=I"> I </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=J"> J </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=K"> K </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=L"> L </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=M"> M </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=N"> N </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=O"> O </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=P"> P </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=Q"> Q </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=R"> R </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=S"> S </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=T"> T </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=U"> U </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=V"> V </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=W"> W </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=X"> X </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=Y"> Y </a></td>';
  echo '<td align=center><a href="product_results.php?quicksearch=Z"> Z </a></td>';
  echo '</tr></table>';    

  # now put in search fields 
  echo '<p>&nbsp<p>';
  echo '<form name=frmMain method=post action="product_results.php?quicksearch=no">';
  echo '<center> <b>Manual Search [You Can Combine fields. Text fields can be partial (e.g "C" will get "CRG"  and "COP")]</b> </center><br>';

  echo '<table border="0"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
  echo '<tr>';
  echo '<td>';
  echo 'Item Code: <input type=text name=item_code size=5 value="';
  echo '">';
      
  echo '</td><td>';     
  echo '<b>Lot Ship: ';
  echo '<input type=text name=lot_ship size=10 value="">';
  echo '</td><td>';   
  echo '<b>Warehouse: ';
  echo '<input type=text name=warehouse size=5 value="">';
  echo "</td>";
  echo "<td>";
  echo 'Include Inactive Items: <input type=checkbox name="inactive_items_too"';
  echo '<br>';
  echo '<font color=red>Must use manual search to get inactive items</font>';
  echo "</td>"; 
  echo "<td>";
  echo 'Sort: <select name="sort_option">';
  echo '<option value="1" ';
  echo '> warehouse, item_code';
  echo '<option value="2" ';
  echo '> Item Nbr.';
  echo "</select>";          
  echo "</td>"; 
  echo "</tr>";
  echo '</table>';
  
   echo '<table width=100%><tr>';
   
   echo '<td>';
    echo '<b>Container #: ';
   echo '<input type=text name=container size=10 value="">';
   echo '</td>';
   
   echo '<td align=left>';
   echo '<b>Mark: ';
   echo '<input type=text name=mark size=10 value="">';   
   echo '</td>';
   
   echo '<td>';
   echo '<b>Date in Warehouse: ';
   echo '<input type=text name=arrival_date size=10 value="">';  
   echo '</td>';
   
   echo '<td>&nbsp;</td>';
   
   echo '<td>&nbsp;</td>';
   
   echo '</tr>';
   echo '</table>';
   

   
   echo '<table width=100%><tr>';
   echo '<td width=50% align=center>';
        
   echo'<input type="submit" value="search" name="search">';  
   echo '</td><td width=50% align=center>';
   echo'<input type="reset" value="reset" name="reset">';  
   echo '</tr></table>';    
 
 
 echo '</form>';           
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
