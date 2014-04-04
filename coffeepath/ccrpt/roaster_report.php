<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Daily Roast Report</title>
 
</head>
<body>
<form id="frmRoasterRpt" method="post">
<center>
<h1> Daily Roast Report  </h1>
</center>
<?php


if(!function_exists("stripos")){
    function stripos(  $str, $needle, $offset = 0  ){
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  );
    }/* endfunction stripos */
}/* endfunction exists stripos */

if(!function_exists("strripos")){
    function strripos(  $haystack, $needle, $offset = 0  ) {
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  );
        if(  $offset < 0  ){
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  );
        }
        else{
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    );
        }
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE;
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   );
        return $pos;
    }/* endfunction strripos */
}/* endfunction exists strripos */

# Make this into an include latter on:
########################
# define Blend Arrays:
#######################


$c150 = array('Chiapas - ','C124','.6','Sumatra - ','C123','.4');
$c151 = array('Sumatra - ','C123','.4','Nicaragua Medium - ','C111','.3','Colombia Medium - ','C116','.3');
$c152 = array('Columbia Dark - ','C136','.4','Sidamo - ','C125','.4','Sumatra - ','C123','.2');
$c153 = array('Yirg - ','C118','.6','East Timor - ','C139','.3','Guatemala - ','C122','.1');
$c154 = array('Chiapas- ','C124','.4','Sidamo - ','C125','.4','Col MD - ','C116','.2');
$c157 = array('Chiapas - ','C124','.4','Sumatra - ','C123','.4','Nicaragua Dark - ','C131','.2');
$c159 = array('Colombia Medium - ','C116','.5','Sidamo - ','C125','.5');
$c160 = array('Espresso Base  - ','C175','.7','Sidamo - ','C125','.2','Nic MD - ','C111','.1');
$c161 = array('Chiapas  - ','C124','.4','Sumatra - ','C123','.4','Nicaragua Dark - ','C131','.2');
$c162 = array('Espresso Base  - ','C175','.85','Sidamo - ','C125','.15');
$c165 = array('Chiapas - ','C124','.5','Decaf FC - ','C170','.5');
$c166 = array('Col DK  - ','C136','.5','Decaf DK - ','C171','.5');
$c172 = array('Decaf Dark  - ','C171','.25','Decaf FC - ','C170','.75');
$c179 = array('Espresso Base  - ','C175','.7','Sidamo - ','C125','.2','East Timor - ','C139','.1');
$c182 = array('Harrar  - ','C127','.4','Sumatra - ','C123','.4','Chiapas  - ','C124','.2');




$blend_formulas = array('C150' => $c150,
                        'C151' => $c151,
                        'C152' => $c152,
                        'C153' => $c153,
                        'C154' => $c154,
                        'C155' => $c157,
                        'C156' => $c151,
                        'C157' => $c157,
                        'C159' => $c159,
                        'C160' => $c160,
                        'C162' => $c162,
                        'C165' => $c165,
                        'C166' => $c166,
                        'C172' => $c172,
                        'C179' => $c179,
                        'C182' => $c182);

                  
$product_names = array(
                 'C109' => 'Dominican Republic Medium Roast',
                 'C111' => 'Nicaragua, Medium Roast',
                 'C116' => 'Colombia, Medium Roast',
                 'C117' => 'El Salvador Medium Roast Coffee',
                 'C118' => 'Ethiopia Yirgacheffe, Medium Roast',
                 'C122' => 'Guatemala, Full City Roast',
                 'C123' => 'Sumatra, Full City Roast',
                 'C124' => 'Mexico Chiapas, Full City Roast',
                 'C125' => 'Ethiopia Sidamo, Full City Roast',
                 'C126' => 'Uganda Viennese Roast Coffee',
                 'C127' => 'Ethiopia Harrar, Full City Roast',
                 'C129' => 'Peru, Full City Roast',
                 'C131' => 'Nicaragua, Dark Roast',
                 'C136' => 'Colombia, Dark Roast',
                 'C137' => 'Bolivia, Dark Roast',
                 'C139' => 'East Timor, Dark Roast',
                 'C144' => 'Brazil Viennese Roast',
                 'C150' => 'Justice Blend, Full City Roast',
                 'C151' => 'Benevolent Blend, Medium Roast',
                 'C152' => 'Critical Mass Blend, Dark Roast',
                 'C153' => 'Mad Poet Blend, Dark Roast',
                 'C154' => 'Mondo Kawan Blend, Full City Roast',
                 'C155' => 'BRAG Brew, Full City Roast',
                 'C156' => 'Georgia Organics Special Blend, Medium Roast',                 
                 'C157' => 'Georgia River Network Blend, Full City Roast',
                 'C159' => 'Maty\'s Blend, Full City Roast ',
                 'C160' => 'Original Espresso Blend, Medium Roast',
                 'C161' => 'A Sign of Relief Full City Roast',
                 'C162' => 'Easygoing Espresso Blend, Full City Roast',
                 'C165' => 'Half Caff Blend, Full City Roast',
                 'C166' => 'Half Caff Blend, Dark Roast',
                 'C170' => 'House Blend Decaf, Full City Roast',
                 'C171' => 'House Blend Decaf, Dark Roast',
                 'C172' => 'Decaf Espresso Blend, Full City Roast',
                 'C175' => 'Espresso Base',
                 'C179' => 'Type A Espresso Blend, Dark Roast',
                 'C182' => 'Mocha Java Blend, Full City Roast' );


$array_header = array( );
$array_row  = array();
$array_table = array();

$array_blend_name = array( );
$array_blend_sku = array( );

# File name is hard coded: Other option might be to select from a list. 

$handle = fopen("daily_roast_report.csv", "r");

# Read thru CSV file and load into an arry. First Row contains column names.

$row = 1;
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);
    for ($c=0; $c < $num; $c++) {
     	if ($row==1) {
         $array_header []  = $data[$c];
        }
        else {
           $array_row []   =  $data[$c];
    	}
    }
    
    $array_table [] = $array_row;
    $array_row  = array();
    
    $row++; 
}

# CSV file has now been loaded.
fclose($handle);
 
 # now create arrays that match the column names, 
 # Use the same index for each product across all arrays.
 
$product_array  = array ( );
$product_size  = array ( );
$product_quantity  = array ( );
$batch_nbr_array  = array ( );

$rpt_table_sku = array ( );
 
$array_seq = 0;
 
# loop thru csv file table
#  Table Layout is as follow:
#  0 = Batch Number
#  1 = Order Date
#  2 = Order ID
#  3 = Product Code
#  4 = Product Name
#  5 = Quantity
#  6 = Product Price
#  7 = Product Wieght
#  8 = Date Record was pulled


$Select = $HTTP_POST_VARS['Select'];
$dropdown  = $HTTP_POST_VARS['mydropdown'];
 
$dropdown = 'All';
if ($Select == 'Refresh') {
    
   $dropdown  = $HTTP_POST_VARS['mydropdown'];
   $message = "ok in the if statement setting drop down to $dropdown";
}
 

foreach($array_table as $r) {
        $batch_nbr_array[] = $r[0];
        if ($r[0] == $dropdown || $dropdown == 'All') {
 	
	    if (substr($r[3],0,1) == 'C') {
	    	$product_seq [] = $array_seq;
	    	$product_array [] = substr($r[3],0,4);
	    	$product_size [] = $r[7];
	    	$product_quantity [] = $r[5];
	    	$product_name [] = $r[4];	    	
	    }
       }
}
 
# Now sort the product array to get all coffees types together in one section. 
asort($product_array);
  
$single_product_array = array ( );
$prev_value = "";

# Now load each product only one time into single product array.
  
foreach($product_array as $k => $v) {
  	if ($v <> $prev_value) {
  	   $single_product_array[] = $v;
  	}
  	   $prev_value = $v;
}


$single_batch_nbr_array = array( );

#load each batch number only one time into a single batch number array to build a drop down list.

$prev_value = "";
foreach($batch_nbr_array as $k => $v) {
  	if ($v <> $prev_value) {
  	   $single_batch_nbr_array[] = $v;
  	}
  	   $prev_value = $v;
}

$batch_dd_list = "\n";
$batch_dd_list  = $batch_dd_list.'<select name="mydropdown">';
$batch_dd_list = $batch_dd_list."\n";
$batch_dd_list = $batch_dd_list."<option value='All'>All</option>";
foreach($single_batch_nbr_array as $v) {
	$batch_dd_list = $batch_dd_list."<option value='$v' ";
	if ($v == $dropdown) {
		$batch_dd_list = $batch_dd_list." selected ";
	}
	$batch_dd_list = $batch_dd_list.">$v</option>";
	$batch_dd_list = $batch_dd_list."\n";
}
$batch_dd_list = $batch_dd_list.'</select>';

echo "<center>";
echo "($dropdown) ";
echo "Batch Number: ".$batch_dd_list;
echo "&nbsp;&nbsp;&nbsp;";
echo '<input type="submit" value="Refresh" name="Select" style="font-family: Verdana; font-size: 12px; color: #228B22; background-color: #FFFFFF; border: 1 solid #228B22">';

echo "<p>";


# Build Headings for Table/Report.

 foreach($product_array as $k1 => $v1) {
        # Time to check if this is really a blend.
       $blend     = strripos($product_name[$k1], "Blend");
       
       if ($v1 == 'C170' || $v1 == 'C171') {
       	   $blend = 0;
       	}
              
       if ($blend === false) {
       	   $dummy = 0;
       	}
       else {       
       	   $the_formula = $blend_formulas[$v1];
           $size_of_formula = count($the_formula);
           $index = 0;
           if  ($size_of_formula  > 0) { 
           	
           	# Now loop thru each part of the formula: 
           	# Formula has two parts, name of coffee and percentage of formula
           	 
               while($index < $size_of_formula)  {   	
                    $index +=  2;
                    $lbs = $product_quantity[$k1] * $product_size[$k1];
                    $portion =  $lbs * $the_formula[$index];
                    
                    $a = "B".$the_formula[$index -1];
                                    
                    $$a += $portion;
                    $result_of_search = array_search($the_formula[$index -1],$single_product_array);

                    
                    if ($result_of_search === false) {
                    	$second_search = array_search($the_formula[$index -1],$array_blend_sku);

                        if ($second_search === false ) {
                    	   $array_blend_name[] = $the_formula[$index -2].$the_formula[$index -1];
                    	   $array_blend_sku[] = $the_formula[$index -1];
                        }
                        
                   } 
                   $index +=  1;
               }
                $lbs = 0;
           }
       	
       	
       }
}


echo  "\n";
# Ok now spin thru the single product array.

foreach($single_product_array as $r => $v) {

       # Now spin thru the all products array to add up all amounts for a single product.
       $lbs = 0;             
       foreach($product_array as $k1 => $v1) {
              if ($v == $v1) {
                 $lbs += $product_quantity[$k1] * $product_size[$k1];
                  $p_name = $product_name[$k1];
              }
       }

       # Now check if this is a blend: Don't want blends in this section.    
       $blend     = strripos($p_name, "Blend");
       
       if ($v == 'C170' || $v == 'C171') {
       	   $blend = false;
       	}
           
        $a = "B".$v;   
        $t = "T".$v;
         
              
       if ($blend === false) {
           $blend_amount = ${$a} + 0;
           $rpt_table_sku[] = $v;
           
           
         if ($blend_amount > 0  ) {
             $$t = $lbs + $blend_amount;
          }
          else {
             $$t = $lbs;   
           }

           $lbs = 0;
       }
           
}

# Now do coffees that are part of blends, but not order by themselves.





 foreach($array_blend_sku as $k => $v) {
 	  $a = "B".$v;
          $t = "T".$v;
           $rpt_table_sku[] = $v;
           $$t = ${$a};
}


# new section


asort($rpt_table_sku);

echo "<table border=1 width=90%>";
   echo "<tr>";
  
       echo "<td>";
           echo "<strong>SKU</strong>";
       echo "</td> ";  
   
       echo "<td>";
           echo "<strong>SKU Name</strong>";
       echo "</td>";
 
       echo "<td>";
           echo "<strong>Lbs</strong>";
       echo "</td>  "; 
   echo "</tr>";

foreach ($rpt_table_sku as $k => $v) {

          $t = "T".$v;

   echo "<tr>";
  
       echo "<td>";
           echo $v;
       echo "</td> ";  
   
       echo "<td>";
        echo $product_names[$v];
       echo "</td>";
 
       echo "<td>";
           echo ${$t};
       echo "</td>  "; 
   echo "</tr>";
}
   
   echo "</table";

#end new section


# now lets do the Blends we skipped in the last section:


echo "<table border=1 width=90%>";

echo "<tr><td colspan=4> &nbsp; </td></tr>";
echo  "\n";
echo "<tr><td colspan=4 align='center'><font color='blue' face='arial' size='4'>Blends</font></td></tr>";
echo  "\n";                 

# Got to Loop thru the single product array again so we only get each blend once.

foreach($single_product_array as $r => $v) {
       $lbs = 0;
       foreach($product_array as $k1 => $v1) {
               if ($v == $v1) {
               	    # this is lbs of the blend, it will need to be used against the bend formulas.
                   $lbs += $product_quantity[$k1] * $product_size[$k1];
                   $p_name = $product_name[$k1];
               }
       }
    
       # Time to check if this is really a blend.
       $blend     = strripos($p_name, "Blend");
       
       if ($v == 'C170' || $v == 'C171') {
       	   $blend = 0;
       	}
              
       if ($blend > 0) {    
           echo  "\n";          	
           echo "<tr><td>";
           echo   "Blend: See Above";
           echo "</td>";             	
           echo "<td colspan=3><strong>"; 
           echo $v.'-'.$p_name.' ('.$lbs.')';        	
           echo "</strong></td></tr>";     
           echo  "\n";         	
           $the_formula = $blend_formulas[$v];
           $size_of_formula = count($the_formula);
           $index = 0;
           if  ($size_of_formula  > 0) { 
           	
           	# Now loop thru each part of the formula: 
           	# Formula has two parts, name of coffee and percentage of formula
           	 
               while($index < $size_of_formula)  {  
                    echo  "\n"; 	
                    echo "<tr><td>";
                    $percent = 100 * $the_formula[$index + 2];
                    echo   "    ".$percent."%";
                    echo "</td><td>";
                    echo $the_formula[$index];
                    $index +=  2;
                    echo "</td><td>";
                    echo $lbs * $the_formula[$index];

                    echo "</td><td>";
                   # echo $the_formula[$index -1];
                    echo $product_names[$the_formula[$index -1]];
                    echo "</td>";
                    echo "</tr>";
                    echo  "\n";
                    $index +=  1;
               }
                $lbs = 0;
           }
       }
}
echo  "\n";
echo " </table>";
echo  "\n";
echo "</form>";
echo  "\n";
echo "</body>";
echo  "\n";
echo "</html>";

 
?>    