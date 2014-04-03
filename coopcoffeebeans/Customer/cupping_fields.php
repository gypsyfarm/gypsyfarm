<?php
//********************************************************************************
//********************* Cupping Maint Screen fields                     ************************
//********************************************************************************
  
  
     
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
echo '<b>Item Code: ';
echo $row['item_code'];
#newitemdropdown($row['item_code'],"item_code","readonly");
echo "\n";
echo '</td>';
echo '<td>';
echo '<b>Lot_ship:</b> ';
echo $row['lot_ship']; 
echo '</td>';
echo "<td>";
echo $row['item_description'];
echo "</td>";

echo '</tr></table>';


    echo "<table width=100%  border=0>";   




    echo "<tr><td colspan=2><hr></td></tr>";
    
        #bgcolor='lime'
        echo "<tr><td  colspan=2>";
        echo "<table width='100%'>";
        
        echo "<tr>";
        echo "<td>";
        echo "Cupping Notes:";
        echo "</td>";
        
        echo "<td colspan=5>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=300  onchange=\'dirty="true";\' type=text name=cupping_notes size=100 value="';
        echo $row['cupping_notes'];
        echo '">';
        
        echo "</tr>"; 
        
        echo "<tr><td>";
        echo "Roast Profile:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=50  onchange=\'dirty="true";\' type=text name=roast_profile size=30 value="';
        echo $row['roast_profile'];
        echo '">'; 
        echo "</td>";
        echo "<td>";
        echo "Roast Behavior:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=50  onchange=\'dirty="true";\' type=text name=roast_behavior size=30 value="';
        echo $row['roast_behavior'];
        echo '">'; 
        echo "</td>";
        echo "<td>";
        echo "Appearance Defects:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=appearance_defects size=30 value="';
        echo $row['appearance_defects'];
        echo '">'; 
        echo "</td>";
        
        echo "</tr><tr>";        
        
        
        
        
        
        echo "<tr><td>";
        echo "Fragrance:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=fragrance size=30 value="';
        echo $row['fragrance'];
        echo '">'; 
        echo "</td>";
        echo "<td>";
        echo "Aroma:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=aroma size=30 value="';
        echo $row['fragrance'];
        echo '">'; 
        echo "</td>";
        echo "<td>";
        echo "Acidity:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=acidity size=30 value="';
        echo $row['acidity'];
        echo '">'; 
        echo "</td>";
        
        echo "</tr><tr>";

        echo "<td>";
        echo "Body:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=body size=30 value="';
        echo $row['body'];
        echo '">'; 
        echo "</td>";   
        echo "<td>";
        echo "Flavor:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=flavor size=30 value="';
        echo $row['flavor'];
        echo '">'; 
        echo "</td>";   
        echo "<td>";
        echo "Aftertaste:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=aftertaste size=30 value="';
        echo $row['aftertaste'];
        echo '">'; 
        echo "</td>";
        
        echo "</tr><tr>"; 
        
       
        echo "<td>";
        echo "Moisture:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=moisture size=30 value="';
        echo $row['moisture'];
        echo '">'; 
        echo "</td>";
        
        echo "<td>";
        echo "Density:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=density size=30 value="';
        echo $row['density'];
        echo '">'; 
        echo "</td>";
        
        echo "<td>";
        echo "Color:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=color size=30 value="';
        echo $row['color'];
        echo '">'; 
        echo "</td>";  
        
        echo "</tr><tr>";
  
        echo "<td>";
        echo "Screen:";
        echo "</td>";
        echo "<td>";
        echo '<input  onblur=\'dirty="true"\' MAXLENGTH=25  onchange=\'dirty="true";\' type=text name=screen size=30 value="';
        echo $row['screen'];
        echo '">'; 
        echo "</td>";  
        echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
        
        echo "</tr>";  

        echo "</table>";
        
        echo "</td></tr>";
    
    echo "<tr><td colspan=2><hr></td></tr>";




echo "</table>";
?>
</form>
<center>
    