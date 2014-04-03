 <?php
//********************************************************************************
//********************* Product Desc Maint Screen fields                     ************************
//********************************************************************************
  
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
  function transfer()
  {
    // alter the action and submit the form
   // document.frmMain.action.value = "transfer";
   //document.frmMain['action'].value = "transfer";   
   
 //  alert(document.frmMain.transwarehouse.options.selectedIndex);    
 
   
     if ( document.frmMain.transwarehouse.options.selectedIndex > 0) {
        document.frmMain.action = "transfer.php";
        document.frmMain.target = "_parent";
        document.frmMain.submit();
     }
     else {
        alert("You must select a warehouse for transfer.");
     }      
  }


// -->
</SCRIPT>
<?  
     
//************************************************************************************
//********************************Begin Drawing the TABLE*****************************
//************************************************************************************


 

echo "<table width=100% border=0>";

 
	echo '<input  type="hidden" name="action" value="';
	if  ($num_results == 0)
	{
	echo 'Add';
	}
    else
	{
    echo 'Update';
	}
	echo  '">';

    echo "\n";

//*******************************Show the item Code********************************
	echo '<tr><td>';
	echo '<b>Item Code:    </td><td>';
	echo "<input type=text name=item_code size=10 value=".stripslashes($row['item_code']).">";

       echo ' &nbsp;&nbsp;&nbsp;Inactive: <input type=checkbox name="item_active"';

     if ($row['item_active'] == "1")
         echo ' Checked>';
     else
         echo '>';

       echo ' &nbsp;&nbsp;&nbsp;On Allocation: <input type=checkbox name="on_allocation"';

     if ($row['on_allocation'] == "1")
         echo ' Checked>';
     else
         echo '>';

	echo "</td></tr>";
	echo "<tr><td>";


//****************************Show the Desciption *************************************

    echo '<tr><td>';
    echo '<b>Item Desc:</b>';
    echo '</td><td>';

    echo '<input type=text name=item_description size=100 value="';
    echo $row['item_description'];
    echo '">';
    echo '</td></tr>';



    echo "<tr><td colspan=2><hr></td></tr>";

    echo "<tr><td>";
    echo '<b>Rank:';
    echo "</td><td>";
    echo '<input type=text name=rank size=6 value="';
    echo $row['rank'];
    echo '">';
    echo "</td></tr>";


    echo "<tr><td>";
    echo '<b>Category:';
    echo "</td><td>";
#    echo '<input type=text name=category size=6 value="';
#    echo $row['category'];
#    echo '">';

    echo '<select name="category">';
    echo '<option value="1" ';
    if ($row['category'] == 1 ) {
       echo ' selected ';
    }
    echo '> Regular';
    echo '<option value="2" ';
        if ($row['category'] == 2 ) {
       echo ' selected ';
    }
    echo '> Decaffeinated';
    echo '<option value="3" ';
    if ($row['category'] == 3 ) {
       echo ' selected ';
    }
    echo '> Special Orders';
    echo "</select>";
    echo "</td></tr>";


    echo "<tr><td>";
    echo '<b>Weight (Bags Lbs):';
    echo "</td><td>";
    echo '<input type=text name=weight size=40 value="';
    echo $row['weight'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Total Purchase:';
    echo "</td><td>";
    echo '<input type=text name=total_pur size=15 value="';
    echo $row['total_pur'];
    echo '">';
    
    
    echo "  &nbsp;&nbsp;&nbsp;&nbsp;Year of balance:";
      GenericDropDown($year_list,"yr_begin",$yr_begin); 
  
  
    if ($row['beginning_balance'] == '') {
  	$beginning_balance = 0;
    }
    else {
  	$beginning_balance = 	$row['beginning_balance'];
    }	
  
    echo '<b>Beginning Balance: ';
    echo '<input type=text name=beginning_balance size=10 value="';
    echo  $beginning_balance;  
    echo '">';

    echo  " \n ";
    
    
    	echo '<INPUT TYPE="submit" name="submit" value="change_year">';
  
      echo  " \n ";
    
    
    
    
    echo "</td></tr>";
    
        echo "<tr><td>";
    echo '<b>Price:';
    echo "</td><td>";
    echo '<input type=text name=price size=15 value="';
    echo $row['price'];
    echo '">';
    echo "</td></tr>";

    echo "<tr><td>";
    echo '<b>Desc Notes:</b>';
    echo "</td><td>";
    echo '<textarea name="desc_notes" type="text" width=200 maxlength="255" id="desc_notes" style="height:50px;width:300px;">'.$row['desc_notes'].'</textarea>';
    echo "</td></tr>";







echo "</table>";
?>
 
<center>
    