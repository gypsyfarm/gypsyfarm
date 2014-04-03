<?php
//********************************************************************************
//********************* Product Maint Screen fields                     ************************
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

echo "<table width=100% border=1>";
 
echo"<tr><td>";
echo '<input type=hidden name=item_id  size=10 value="';
echo stripslashes($row['item_id']);
echo '">';
echo "</td><td>";

echo "\n";
echo '<tr><td colspan=2>';
echo '<table width=100%><tr>';
echo '<td>';
echo "<div class='left'>";
echo '<b>Item Code: ';
newitemdropdown($row['item_code'],"item_code","disabled");
echo "\n";
#echo '&nbsp;&nbsp;&nbsp;';
echo "</div>";
echo '</td>';
echo '<td>';
echo "<div class='left'>";
echo '<b>Lot_ship: ';
echo '<input type=text name=lot_ship  disabled size=4 value="';
echo $row['lot_ship'].'">';
#echo "&nbsp;&nbsp;&nbsp;";  
echo "</div>";
echo '</td>';
echo '<td>';
echo "<div class='left'>";
echo "<span>"; 
echo "<font color=red size=4> *</font>"; 
echo 'Inactive: </span><input  disabled type=checkbox name="item_active"';

if ($row['item_active'] == "1")
   echo ' Checked>';
else
   echo '>';

#echo "&nbsp;&nbsp;&nbsp;";   
echo "</div>";
echo '</td>';
echo '<td>';
echo "<div class='left'>"; 
echo "<span>";
echo "<font color=red size=4> *</font>"; 
echo 'Green Report: </span><input  disabled type=checkbox name="green_cb"';

if ($row['green_cb'] == "1")
   echo ' Checked>';
else
   echo '>';     
    
#echo "&nbsp;&nbsp;&nbsp;";
echo "</div>";
echo '</td>';
echo '<td>';
echo "<div class='left'>";
echo '<b>Ft Item: ';
echo '<input type=checkbox  disabled name="ft_item"';

if ($row['ft_item'] == "1")
   echo ' Checked>';
else
   echo '>';

#echo "&nbsp;&nbsp;&nbsp;";
echo "</div>";
echo '</td>';
echo '<td>';
echo "<div class='left'>";
echo '<b>Org Item: ';
echo '<input type=checkbox  Disabled  name="org_item"';

if ($row['org_item'] == "1")
   echo ' Checked>';
else
   echo '>';    
echo "</span>";
echo '</td>';
echo '<td>';
echo '</tr></table>';
echo '</td></tr>';


#echo "<tr><td colspan=2>";
echo '</td></tr>';
echo "<tr><td colspan=2>";

#echo "<div class='left'>";	
echo "<span>"; 
echo "<font color=red size=4> *</font>"; 
echo '<b>Warehouse:';
echo "&nbsp;&nbsp;&nbsp;";
$warehouse =  $row['warehouse'];
if (!isSet($warehouse)) {
    $warehouse='N';
}

echo  " \n ";
warehousedropdown($warehouse, "DISABLED");
echo "</span>";
#echo "</div>";
echo  " \n ";


echo "&nbsp;&nbsp;&nbsp;";
#echo "<div class='left'>";
echo '<b>Quantity: ';
echo '<input type=text  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\'  name=quantity size=10 value="';
echo $row['quantity'];
echo '">';
echo  " \n ";
#echo "</div>";

echo "&nbsp;&nbsp;&nbsp;";
#echo "<div class='left'>";
# was using class = highlight
echo "<span>";
echo "<font color=red size=4> *</font>"; 
echo '<b>Status: ';
echo "</span>";

GenericDropDown($status_list,"status", $row['STATUS'], "yes", "DISABLED"); 
#echo "</div>";

echo "&nbsp;&nbsp;&nbsp;";
#echo "<div class='left'>";
echo '<b>Spot Available:';
echo "</span>";
echo '<input type=text  onblur=\'dirty="true"\' disabled  onchange=\'dirty="true";\' name=spot_available size=10 value="';
echo $row['spot_available'];
echo '">';

#echo "</div>";

echo "</td></tr>";



    echo '<tr><td>';
    echo '<b>Item Desc:</b>';
    echo '</td><td>';

    echo '<input type=text  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' name=item_description size=75 value="';
    echo $row['item_description'];
    echo '">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FLO-ID:&nbsp;&nbsp;';
    echo '<input type=text  onblur=\'dirty="true"\'   onchange=\'dirty="true";\' name=flo_id size=8 value="';
    echo $row['flo_id'];
    echo '">';    
    echo '</td></tr>';


       echo '<tr><td>';
     echo '<b>DD Desc:</b>';
    echo '</td><td>';
     echo '<input disabled type=text name=generic_description size=75 value="';
    echo $row['generic_description'];
    echo '">';
    echo '</td></tr>';
    
   


#  New Row.
    echo "<tr><td>";
    echo "<font color=red size=4> *</font>"; 
    echo '<b>Contract Date: ';
    echo "</td><td>";
    echo '<input type=text  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' name=contract_date size=15 value="';
    echo $row['contract_date'];
    echo '">';   
    
    
       echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo '<b>Fixed Date:';
    echo '<input type=text onblur=\'dirty="true"\' disabled  onchange=\'dirty="true";\'  name=fixed_date size=15 value="';
    echo $row['fixed_date'];
    echo '">';   


    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    echo '<b>NYC: ';
    echo '<input type=text  onblur=\'dirty="true"\' disabled onchange=\'dirty="true";\' name=nyc size=5 value="';
    echo $row['nyc'];
    echo '">'; 
    
    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    echo '<b>Fixed Price: ';
    echo '<input type=text  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' name=fixed_price size=5 value="';
    echo $row['fixed_price'];
    echo '">'; 	
	
    echo "</td></tr>";
    
    
 #  row one
    echo "<tr><td>";
    echo '<b>Sample Shipped: ';
    echo "</td><td>";
    echo '<input  onblur=\'dirty="true"\' disabled  onchange=\'dirty="true";\' type=text name=sample_shipped size=20 value="';
    echo $row['sample_shipped'];
    echo '">';   


    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    echo '<b>Sample Approved: ';
    echo '<input  onblur=\'dirty="true"\' disabled  onchange=\'dirty="true";\' type=text name=sample_approved size=10 value="';
    echo $row['sample_approved'];
    echo '">'; 
    
    echo "</td></tr>";   
# row one.

    echo "<tr><td colspan=2><hr></td></tr>";
    
    #  begin row two
        echo "<tr><td colspan=2>";
    echo "<span>";
    echo "<font color=red size=4> *</font>"; 
    echo '<b>Shipping Date: ';
    
  #  echo "</td><td>";
    
    echo '<input  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' type=text name=ship_date size=15 value="';
    echo $row['ship_date'];
    echo '">';
    echo "</span>";
     echo "&nbsp;&nbsp;&nbsp;";
    echo '<b>Container #: ';
    echo '<input  onblur=\'dirty="true"\' disabled  onchange=\'dirty="true";\' type=text name=container size=10 value="';
    echo $row['container'];
    echo '">';   
   
   
         echo "&nbsp;&nbsp;&nbsp;";
    echo '<b>Documents: ';
    echo '<input  onblur=\'dirty="true"\'   disabled onchange=\'dirty="true";\' type=text name=document size=20 value="';
    echo $row['document'];
    echo '">';
    
    echo "</td></tr>";  
    
  #  end row two
    
    

    
    
    
    
    echo "<tr><td>";
    echo '<b>ETA Port:';
    echo "</td><td>";
    echo '<input  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' type=text name=fda_confirm size=15 value="';
    echo $row['fda_confirm'];
    echo '">';
    
    
#    echo "&nbsp;&nbsp;&nbsp;";
#    echo '<b>FDA Date: ';
#    echo '<input  onblur=\'dirty="true"\' disabled  onchange=\'dirty="true";\' type=text name=fda_date size=15 value="';
#    echo $row['fda_date'];
#    echo '">';

    
    echo "&nbsp;&nbsp;&nbsp;";
    echo '<b>FDA & Customs Clear Date: ';
    echo '<input  onblur=\'dirty="true"\'   onchange=\'dirty="true";\' type=text name=customs_clear_date size=15 value="';
    echo $row['customs_clear_date'];
    echo '">';
             
    
    echo "</td></tr>";    
    # begin test
    echo "</table>";
    echo "<table width=100% border=0>";
            echo '<tr><td width=50%>';
     echo '<b>Green Comment:</b>(Visable On Reports)<BR>';

     echo '<input  onblur=\'dirty="true"\'   disabled onchange=\'dirty="true";\' type=text  onblur=\'dirty="true"\'   onchange=\'dirty="true";\' name=green_comment size=50 value="';
    echo $row['green_comment'];
    echo '">';
	echo "<br>";
	echo '<b>Pre-Finance:</b>';
	GenericDropDown($dd_q_list,"prefinance",$row['prefinance'],"No"); 

    echo "&nbsp;&nbsp;&nbsp;";
	echo '<b>Pre-Finance Amount:</b>';
    echo '$<input  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' type=text name=prefinance_amount size=10 value="';
    echo $row['prefinance_amount'];
    echo '">'; 

    echo "</td>";
    echo "<td width=50%>";
    echo '<b>Item Notes:</b>(Visable in Lot Maint)<BR>';
    echo '<textarea  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' name="item_notes" type="text" width=200 maxlength="255" id="item_notes" style="height:50px;width:300px;">'.$row['item_notes'].'</textarea>';
    echo "</td></tr>";   
     echo "</table>";
    echo "<table width=100%  border=0>";   
    # end test

   
    



# test
    echo "<tr><td colspan=2>";
    echo '<b>Member Price / lb:';
      echo "&nbsp;&nbsp;&nbsp;";
    echo '$'.'<input  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' type=text name=member_price size=6 value="';
    echo $row['member_price'];
    echo '">';
    
    
      echo "&nbsp;&nbsp;&nbsp;";
    echo '<b>Non Member Price:';

    echo '<input  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' type=text name=non_member_price size=6 value="';
    echo $row['non_member_price'];
    echo '">';  
 
 
        echo "&nbsp;&nbsp;&nbsp;";
 #spot went here
    
    echo "</td></tr>";
#end test







    echo "<tr><td colspan=2>";
    echo "<span>";
    echo "<font color=red size=4> *</font>"; 
    echo '<b>Mark:';
    echo "</span>";
    echo '<input  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' type=text name=Mark size=20 value="';
    echo $row['mark'];
    echo '">';
    
    echo "&nbsp;&nbsp;&nbsp;";
    echo '<b>Warehouse code: ';
    echo '<input  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' type=text name=warehouse_code size=20 value="';
    echo $row['warehouse_code'];
    echo '">';

    echo "&nbsp;&nbsp;&nbsp;";
    echo '<b>Cost per Bag: ';
    echo '<input  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' type=text name=cost size=10 value="';
    echo $row['cost'];
    echo '">';    
    
    echo "</td></tr>";





    echo "<tr><td colspan=2>";

    echo '<b>Bags Lbs:';
    echo '<input  onblur=\'dirty="true"\'  disabled onchange=\'dirty="true";\' type=text name=bags_lbs disabled size=15 value="';
    echo $row['bag_lbs'];
    echo '">';

    echo "&nbsp;&nbsp;&nbsp;";
    echo "<span>";
    echo "<font color=red size=4> *</font>"; 
    echo '<b>Available In Warehouse:';
    echo "</span>";
    echo '<input  onblur=\'dirty="true"\'  disabled    type=text name=arrival_date size=15 value="';
    echo $row['arrival_date'];
    echo '">';
    
    
                echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    echo '<b>Scribd ID: ';
    echo '<input  onblur=\'dirty="true"\'  disabled   type=text name=scribd_id size=10 value="';
    echo $row['scribd_id'];
    echo '">'; 
    
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    echo '<b>GUID ID: ';
    echo '<input  onblur=\'dirty="true"\'   disabled   type=text name=guid size=13 value="';
    echo $row['guid'];
    echo '">'; 
    echo "</td></tr>";


    echo "<tr><td colspan=2><hr></td></tr>";


    echo "<tr><td colspan=2>";
    echo '<b>Prev In:';
    echo '<input type=text  disabled name=transfer_in size=10 readonly value="';
    echo $row['transfer_in'];
    echo '">';
    echo '&nbsp;&nbsp;&nbsp;';
    echo '<b>Prev Out: ';
    echo '<input  onblur=\'dirty="true"\'   disabled type=text name=transfer_in readonly size=10 value="';
    echo $row['transfer_out'];
    echo '">';
    echo '&nbsp;&nbsp;&nbsp;';
  
    echo '&nbsp;&nbsp;&nbsp;';  
 
    echo '&nbsp;&nbsp;&nbsp;';    
 
    echo "</td></tr>";

    echo "<tr><td colspan=2><hr></td></tr>";



echo "</table>";
?>
</form>
<center>
    