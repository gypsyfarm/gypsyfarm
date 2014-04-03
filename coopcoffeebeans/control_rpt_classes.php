<?php

class myControlReport {

    var $rows = 0;
    var $row_class = "";
    var $nbr_cells = 0;
    var $cell_content = "";
    var $cell_class = '#EC0000';
    var $tablewidth = '95%';
    var $cellwidth = "";
    var $readme = "";
    var $item_code = "";
    var $db_conn = "";
    var $results;
    var $num_results = 0;  
    var $current_month = 1;
    var $on_hand_total = 0;
    var $on_water_total = 0;
    var $contract_total = 0;
    var $set_monthly_totals_output = "";
    var $difference = 0;
    
    var $OnWay01 = 0;
    var $OnWay02 = 0;
    var $OnWay03 = 0;
    var $OnWay04 = 0;
    var $OnWay05 = 0;
    var $OnWay06 = 0;
    var $OnWay07 = 0;
    var $OnWay08 = 0;
    var $OnWay09 = 0;
    var $OnWay10 = 0;
    var $OnWay11 = 0;
    var $OnWay12 = 0;
    
    var $prev_value = 0;
    


    function myControlReport($rows, $nbr_cells){
    	$this->rows = $rows;
    	$this->nbr_cells = nbr_cells;
    	$this->db_conn =  mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
    }

    function setRows($value){
        $this->rows = $value;
    }
    
    function StartTable(){
       return  "\n"." <TABLE cellSpacing=0 cellPadding=0 width='$this->tablewidth' border=1>";
    }
    
    function StartRow($class){
       return  "\n"." <tr class='$class'>";
    }
    
    
    function CreateCell($content,$class,$span=1){
    	return "\n"." <td colspan=$span valign='top' $this->cellwidth class='$class'>".$content."</td>";
    }


  function remaining_inventory($passed_item_code,$passed_warehouse)   {
     
        global $tbl_order_header;
        global $tbl_item_description;
        global $tbl_order_item;
        global $tbl_lot_item;
        global $tbl_coop_item;
        global $tbl_coop_contact;
        global $global_sales;
     
     
       $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
     
     
     # begin new code
       $query =   "SELECT  sum(quantity) as quantity, sum(transfer_in) as transfer_in, sum(transfer_out) as transfer_out
       FROM   coop_item li
               WHERE item_code='$passed_item_code'
               AND warehouse = '$passed_warehouse'
               and STATUS = 'In Stock'";

               
     
     $result = mysql_query($query, $db_conn);
     
     $row=mysql_fetch_array($result);
     
     
     
      $initial_quantity =$row['quantity'] + $row['transfer_in'] - $row['transfer_out'];
     
   #   $this->readme = "";


     $query =   "SELECT sum(li.quantity) as quantity
     FROM   item_description id,   order_item oi,   lot_item li,
                 order_header oh,  coop_item ci,   coop_contact cc
               WHERE oi.item_id = li.item_id
               AND oi.item_code = id.item_code
     		  AND oh.customer_key = cc.contact_id
               AND li.lot_ship = ci.item_id
               AND oi.header_key = oh.header_id
               AND oi.item_code='$passed_item_code'
               AND ci.warehouse = '$passed_warehouse' 
               and ci.STATUS = 'In Stock' ";
          
      
     $result = mysql_query($query, $db_conn);
     $num_results = mysql_num_rows($result);
     $quantity_total=0;
     $remaining=0;
     for ($i=0; $i <$num_results;  $i++)
       {
     $row=mysql_fetch_array($result);
     
     $quantity_total=$quantity_total+$row['quantity'];
     }
     $global_sales = $quantity_total;
     $remaining=$initial_quantity - $quantity_total;
     
     return $remaining;
     
     }
     

    function OnHandTable(){
    	
    	  global $tbl_order_header;
        global $tbl_item_description;
        global $tbl_order_item;
        global $tbl_lot_item;
        global $tbl_coop_item;
        global $tbl_coop_contact;
        global $global_sales;
       $class = "gbr1";
       $return_value = $this->StartTable();
       $total = 0;

       
       
       $return_value = $return_value.$this->StartRow($class);
       $content = "New Jersey";
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
 
       $content =  $this->remaining_inventory($this->item_code,'J');
       $total += $content;
       $return_value = $return_value.$this->CreateCell($content,$class,1);       
       $return_value = $return_value.$this->EndRow();
       
       #begin new code: 
        $class = "gbr2";
       $return_value = $return_value.$this->StartRow($class);
       $content = "All Jay's";
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
 
       $content =  $this->remaining_inventory($this->item_code,'H');
       $total += $content;
       $return_value = $return_value.$this->CreateCell($content,$class,1);       
       $return_value = $return_value.$this->EndRow();
       
       #end New 
       
        $class = "gbr1";
       $return_value = $return_value.$this->StartRow($class);
       $content = "Toronto";
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
 
       $content =  $this->remaining_inventory($this->item_code,'T');
       $total += $content;
       $return_value = $return_value.$this->CreateCell($content,$class,1);       
       $return_value = $return_value.$this->EndRow();
       
      
        $class = "gbr2";
       $return_value = $return_value.$this->StartRow($class);
       $content = "New Orleans";
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
 
       $content =  $this->remaining_inventory($this->item_code,'N');
       $total += $content;
       $return_value = $return_value.$this->CreateCell($content,$class,1);       
       $return_value = $return_value.$this->EndRow();
       
        $class = "gbr1";
       $return_value = $return_value.$this->StartRow($class);
       $content = "California";
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
  
       $content =  $this->remaining_inventory($this->item_code,'S');
       $return_value = $return_value.$this->CreateCell($content,$class,1);       
       $return_value = $return_value.$this->EndRow();   
       
       
        $class = "gbr2";
       $return_value = $return_value.$this->StartRow($class);
       $content = "Total";
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
       $content = $total;
       $this->on_hand_total = $total;
       $return_value = $return_value.$this->CreateCell($content,$class,1);       
       $return_value = $return_value.$this->EndRow();  
       
              
       
       $return_value = $return_value.$this->EndTable();
       
       return $return_value;
    }


  function OnWaterTable(){
        global $tbl_order_header;
        global $tbl_item_description;
        global $tbl_order_item;
        global $tbl_lot_item;
        global $tbl_coop_item;
        global $tbl_coop_contact;
        global $global_sales;	
  	
  	 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  	 
                  
       $query = "SELECT item_code, lot_ship, quantity, arrival_date 
                    FROM  coop_item
                    WHERE warehouse = 'E'
                    and item_active <> 1 
                    and item_code = '$this->item_code'";
          
 	
       $class = 'gbr1';
       $return_value = $this->StartTable();
       
       
        $return_value = $return_value.$this->StartRow($class);
       $content = 'Item/Lot';
       $return_value = $return_value.$this->CreateCell($content,$class,1);  
       $content = 'QTY';
       $return_value = $return_value.$this->CreateCell($content,$class,1);  
       $content = 'Available Date';
       $return_value = $return_value.$this->CreateCell($content,$class,1); 
       $return_value = $return_value.$this->EndRow();        
       
       $class_switch = 2;


     $result = mysql_query($query, $db_conn);
     $num_results = mysql_num_rows($result);
     $quantity_total=0;
     $remaining=0;
     for ($i=0; $i <$num_results;  $i++) {
         $row=mysql_fetch_array($result);
         
         if ($class_switch == 2 ) {
         	$class = 'gbr1';
         	$class_switch = 1;
        }
        else {
        	$class = 'gbr2';
        	$class_switch = 2;
        } 
     
        $quantity_total=$quantity_total+$row['quantity'];
 
       
       
       $return_value = $return_value.$this->StartRow($class);
       $content = $row['item_code'].$row['lot_ship'];
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
       $content = $row['quantity'];
       $return_value = $return_value.$this->CreateCell($content,$class,1);   
       $content = $row['arrival_date'];
       if (date("Y", strtotime($row['arrival_date'])) == date("Y")) {
       	  $this->on_water_total += $row['quantity'];
      }
      
      
       
       $ArrivalDate = $row['arrival_date'];
       $month = date("n",strtotime($ArrivalDate));

 
       $this->readme .= "On water  for ".$row['item_code'].$row['lot_ship']." and Month is ".$ArrivalDate ." month = ".$month."   with quantity is ".$row['quantity'] ."<br>";


       
       if ($month == 1) {
       	$this->OnWay01 += $row['quantity'];
       }
       
      if ($month == 2) {
       	$this->OnWay02 += $row['quantity'];
       }
       
      if ($month == 3) {
       	$this->OnWay03 += $row['quantity'];
       }
       
       if ($month == 4) {
       	$this->OnWay04 += $row['quantity'];
       }
       
       if ($month == 5) {
       	$this->OnWay05 += $row['quantity'];
       }
       
       if ($month == 6) {
       	$this->OnWay06 += $row['quantity'];
       }
       
       if ($month == 7) {
       	$this->OnWay07 += $row['quantity'];
       }
       
       if ($month == 8) {
       	$this->OnWay08 += $row['quantity'];
       }
       
       if ($month == 9) {
       	$this->OnWay09 += $row['quantity'];
       }
       
       if ($month == 10) {
       	$this->OnWay10 += $row['quantity'];
       }
       
       if ($month == 11) {
       	$this->OnWay11 += $row['quantity'];
       }
       
       if ($month == 12) {
       	$this->OnWay12 += $row['quantity'];
       }
       
       $return_value = $return_value.$this->CreateCell($content,$class,1);      
       $return_value = $return_value.$this->EndRow();
       
 
        }   
        
        
             	
        if ($class_switch == 2 ) {
         	$class = 'gbr1';
         	$class_switch = 1;
        }
        else {
        	$class = 'gbr2';
        	$class_switch = 2;
        } 
       
       $return_value = $return_value.$this->StartRow($class);
       $content = "Total";
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
       $content = $quantity_total;
       $return_value = $return_value.$this->CreateCell($content,$class,1);   
       if ($quantity_total == 0) {
       	   $content = "  ";
       	}
       else {
          $content = "  ";
       }
       $return_value = $return_value.$this->CreateCell($content,$class,1);      
       $return_value = $return_value.$this->EndRow();
       
   
       $return_value = $return_value.$this->EndTable();
       
       return $return_value;
}

  function FutureTable(){
  	
  	global $tbl_order_header;
        global $tbl_item_description;
        global $tbl_order_item;
        global $tbl_lot_item;
        global $tbl_coop_item;
        global $tbl_coop_contact;
        global $global_sales;	
  	
  	 $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
  	 
                  
          $query = "SELECT item_code, lot_ship, quantity, arrival_date 
                    FROM  coop_item
                    WHERE warehouse in ('F','C')
                    and Status <> 'Cancelled'
                    and item_active = 0 
                    and item_code = '$this->item_code'";
         $class = "";
         

         
       $return_value = $this->StartTable();
       
       
       $return_value = $return_value.$this->StartRow($class);
       $content = 'Item/Lot';
       $return_value = $return_value.$this->CreateCell($content,$class,1);  
       $content = 'QTY';
       $return_value = $return_value.$this->CreateCell($content,$class,1);  
       $content = 'Available Date';
       $return_value = $return_value.$this->CreateCell($content,$class,1); 
       $return_value = $return_value.$this->EndRow();       
       
 
       
     $result = mysql_query($query, $db_conn);
     $num_results = mysql_num_rows($result);
     $quantity_total=0;
     $remaining=0;
     $class_switch = 2;
     
     for ($i=0; $i <$num_results;  $i++) {
     	$row=mysql_fetch_array($result);
     	
     	
        if ($class_switch == 2 ) {
         	$class = 'gbr1';
         	$class_switch = 1;
        }
        else {
        	$class = 'gbr2';
        	$class_switch = 2;
        } 
       
       $return_value = $return_value.$this->StartRow($class);
       $content = $content = $row['item_code'].$row['lot_ship'];
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
       $content = $row['quantity'];
       $quantity_total += $content;
       $return_value = $return_value.$this->CreateCell($content,$class,1);   
       $content = $row['arrival_date'];

       $ArrivalDate = $row['arrival_date'];
       $month = date("n",strtotime($ArrivalDate));
       
       $this->readme .= "Future for ".$row['item_code'].$row['lot_ship']." and Month is ".$ArrivalDate ." month = ".$month."  with quantity is ".$row['quantity'] ."<br>";

       if ($month == 1) {
       	$this->OnWay01 += $row['quantity'];
       }
       
      if ($month == 2) {
       	$this->OnWay02 += $row['quantity'];
       }
       
      if ($month == 3) {
       	$this->OnWay03 += $row['quantity'];
       }
       
       if ($month == 4) {
       	$this->OnWay04 += $row['quantity'];
       }
       
       if ($month == 5) {
       	$this->OnWay05 += $row['quantity'];
       }
       
       if ($month == 6) {
       	$this->OnWay06 += $row['quantity'];
       }
       
       if ($month == 7) {
       	$this->OnWay07 += $row['quantity'];
       }
       
       if ($month == 8) {
       	$this->OnWay08 += $row['quantity'];
       }
       
       if ($month == 9) {
       	$this->OnWay09 += $row['quantity'];
       }
       
       if ($month == 10) {
       	$this->OnWay10 += $row['quantity'];
       }
       
       if ($month == 11) {
       	$this->OnWay11 += $row['quantity'];
       }
       
       if ($month == 12) {
       	$this->OnWay12 += $row['quantity'];
       }

 
      if (date("Y", strtotime($row['arrival_date'])) == date("Y")) {
       	  $this->contract_total += $row['quantity'];
      }
      

       
       $return_value = $return_value.$this->CreateCell($content,$class,1);      
       $return_value = $return_value.$this->EndRow();
       
      }  
       
            	
        if ($class_switch == 2 ) {
         	$class = 'gbr1';
         	$class_switch = 1;
        }
        else {
        	$class = 'gbr2';
        	$class_switch = 2;
        } 
       
       $return_value = $return_value.$this->StartRow($class);
       $content = "Total";
       $return_value = $return_value.$this->CreateCell($content,$class,1);
       
       $content = $quantity_total;
       $return_value = $return_value.$this->CreateCell($content,$class,1);   
       if ($quantity_total == 0) {
       	   $content = "  ";
       	}
       else {
          $content = "  ";
       }
       $return_value = $return_value.$this->CreateCell($content,$class,1);      
       $return_value = $return_value.$this->EndRow();
       
   
       $return_value = $return_value.$this->EndTable();
       
       return $return_value;
}
  
  
    function set_monthly_totals($year_range,$item_code)   {
    
        global $tbl_coop_commited;
        global $tbl_coop_contact; 
        global $tbl_order_header;
        global $tbl_item_description;
        global $tbl_order_item;
        global $tbl_lot_item;
        global $tbl_coop_item;
 
 
        $month01_total=0;
        $month02_total=0;
        $month03_total=0;
        $month04_total=0;
        $month05_total=0;
        $month06_total=0;
        $month07_total=0;
        $month08_total=0;
        $month09_total=0;
        $month10_total=0;
        $month11_total=0;
        $month12_total=0;     
        
        $month01_sales=0;
        $month02_sales=0;
        $month03_sales=0;
        $month04_sales=0;
        $month05_sales=0;
        $month06_sales=0;
        $month07_sales=0;
        $month08_sales=0;
        $month09_sales=0;
        $month10_sales=0;
        $month11_sales=0;
        $month12_sales=0; 
        $month_sales =0;
        
        $this->set_monthly_totals_output .= $this->StartTable(); 

        $class = 'color1';
        $this->set_monthly_totals_output .=  $this->Startrow($class); 
        $this->cellwidth = " ";
        $content = "Item Totals";
         
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Yr Total";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Jan";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Feb";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Mar";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Apr";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "May";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Jun";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Jul";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Aug";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Sep";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Oct";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Nov";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $content = "Dec";
        $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
        $this->set_monthly_totals_output .=  $this->EndRow(); 
                
        
     
       $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
       # we are not selecting by warehouse at this point, might never.
       $warehouse_sql = "";
       $query = "select item_code,
                 sum(month01) as month01,
                 sum(month02) as month02,
                 sum(month03) as month03,
                 sum(month04) as month04,
                 sum(month05) as month05,
                 sum(month06) as month06,
                 sum(month07) as month07,
                 sum(month08) as month08,
                 sum(month09) as month09,
                 sum(month10) as month10,
                 sum(month11) as month11,
                 sum(month12) as month12,
                 sum(py) as py        
          from  coop_commited c,  coop_contact cc 
          where  import_yr ='$year_range'
            and c.customer_key = cc.contact_id 
           $warehouse_sql 
           and item_code = '$this->item_code'   
           group by item_code 
          order by item_code";
          
          
       $queryP = "select item_code,
                 sum(month01) as month01,
                 sum(month02) as month02,
                 sum(month03) as month03,
                 sum(month04) as month04,
                 sum(month05) as month05,
                 sum(month06) as month06,
                 sum(month07) as month07,
                 sum(month08) as month08,
                 sum(month09) as month09,
                 sum(month10) as month10,
                 sum(month11) as month11,
                 sum(month12) as month12,
                 sum(py) as py        
          from  coop_commited c,  coop_contact cc 
          where  import_yr ='$prev_year_range'
            and c.customer_key = cc.contact_id 
           $warehouse_sql 
           and item_code = '$this->item_code'   
           group by item_code 
          order by item_code";
          
           
        $result = mysql_query($query, $db_conn);
        $num_results = mysql_num_rows($result); 
        
        $resultP = mysql_query($queryP, $db_conn);
        $num_resultsP = mysql_num_rows($result); 
        
          
       for ($i=0; $i <$num_results;  $i++) {
          $row = mysql_fetch_array($result);
          $total = $row['month01'] + $row['month02'] + $row['month03'] + $row['month04'] +$row['month05'] +$row['month06'] +$row['month07'] +$row['month08'] + $row['month09'] + $row['month10'] + $row['month11'] + $row['month12'];
          $month01_total=$month01_total + $row['month01'];
          $month02_total=$month02_total + $row['month02'];
          $month03_total=$month03_total + $row['month03'];
          $month04_total=$month04_total + $row['month04'];
          $month05_total=$month05_total + $row['month05'];
          $month06_total=$month06_total + $row['month06'];
          $month07_total=$month07_total + $row['month07'];
          $month08_total=$month08_total + $row['month08'];
          $month09_total=$month09_total + $row['month09'];
          $month10_total=$month10_total + $row['month10'];
          $month11_total=$month11_total + $row['month11'];
          $month12_total=$month12_total + $row['month12'];
          $py_total=$py_total+$row['py'];

          $item_code=$row['item_code'];

          $total_total = $total_total + $total +$row['py']; 
        $to_date =  $year_range.'-12-31';
        $from_date =  $year_range.'-01-01';
          
         $subquery = "SELECT MONTH(oh.order_date) as month,  sum(li.quantity) as quantity
              FROM   order_header oh,   order_item oi,   coop_contact cc,   lot_item li
              WHERE oh.header_id = oi.header_key   
              AND oh.customer_key = cc.contact_id  
              AND oi.item_code = '$item_code'   
              and oi.item_id = li.item_id  
              and oh.order_date Between '$from_date' and '$to_date'   
              group by MONTH(oh.order_date)";
              
             
  
         $subresult = mysql_query($subquery, $db_conn);
         $subnum_results = mysql_num_rows($subresult);
         $item_quantity=0;  
         $month_sales = 0;
         
         for ($b=0; $b <$subnum_results;  $b++) {
           $subrow = mysql_fetch_array($subresult);
           $month_sales += $subrow['quantity'];
           switch ($subrow['month']) {
             case 1:
                    $month01_sales = $subrow['quantity'];
                    break;
             case 2:
                    $month02_sales = $subrow['quantity'];
                    break;
             case 3:
                    $month03_sales = $subrow['quantity'];
                    break;
             case 4:
                    $month04_sales = $subrow['quantity'];
                    break;
             case 5:
                    $month05_sales = $subrow['quantity'];
                    break; 
             case 6:
                    $month06_sales = $subrow['quantity'];
                    break; 
             case 7:
                    $month07_sales = $subrow['quantity'];
                    break;  
             case 8:
                    $month08_sales = $subrow['quantity'];
                    break;   
             case 9:
                    $month09_sales = $subrow['quantity'];
                    break;  
             case 10:
                    $month10_sales = $subrow['quantity'];
                    break;    
             case 11:
                    $month11_sales = $subrow['quantity'];
                    break;  
             case 12:
                    $month12_sales = $subrow['quantity'];
                    break;                                                                                                                                   
            }
         }   
        $total = $total + $row['py'];
        $remaining=$total-$item_quantity;
        $remaining_total=$remaining_total+$remaining;
              
       }
       
       

       
       $class = 'gbr1';
       $this->set_monthly_totals_output .=  $this->Startrow($class); 
       $content = "$this->item_code Commits"; 
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
 

       #total goes here
       $content = $total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
          
       if ($this->current_month == 1) {
          $class = 'heading1';
       }     
       $content = $month01_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 2) {
          $class = 'heading1';
       }
       $content = $month02_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 3) {
          $class = 'heading1';
       }
       $content = $month03_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 4) {
          $class = 'heading1';
       }
       $content = $month04_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
 
       if ($this->current_month == 5) {
          $class = 'heading1';
       }
       $content = $month05_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 6) {
          $class = 'heading1';
       }
       $content = $month06_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 7) {
          $class = 'heading1';
       }
       $content = $month07_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 8) {
          $class = 'heading1';
       }
       $content = $month08_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 9) {
          $class = 'heading1';
       }
       $content = $month09_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 10) {
          $class = 'heading1';
       }
       $content = $month10_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 11) {
          $class = 'heading1';
       }
       $content = $month11_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 12) {
          $class = 'heading1';
       }
       $content = $month12_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       $this->set_monthly_totals_output .=  $this->EndRow(); 
              
       $class = 'gbr2';
       $this->set_monthly_totals_output .=  $this->Startrow($class); 
       $content = "$this->item_code Sales"; 
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       $content = $month_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 1) {
          $class = 'heading1';
       }
       $content = $month01_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 2) {
          $class = 'heading1';
       }
       $content = $month02_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 3) {
          $class = 'heading1';
       }
       $content = $month03_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 4) {
          $class = 'heading1';
       }
       $content = $month04_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 5) {
          $class = 'heading1';
       }
       $content = $month05_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 6) {
          $class = 'heading1';
       }
       $content = $month06_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 7) {
          $class = 'heading1';
       }
       $content = $month07_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 8) {
          $class = 'heading1';
       }
       $content = $month08_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 9) {
          $class = 'heading1';
       }
       $content = $month09_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 10) {
          $class = 'heading1';
       }
       $content = $month10_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 11) {
          $class = 'heading1';
       }
       $content = $month11_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 12) {
          $class = 'heading1';
       }
       $content = $month12_sales;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       $this->set_monthly_totals_output .=  $this->EndRow();   
       
       
       $class = 'gbr1';
       $this->set_monthly_totals_output .=  $this->Startrow($class); 
       
       $content = "Difference"; 
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
 
       $content = $total - $month_sales;
       $this->difference = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 1) {
          $class = 'heading1';
       }
       $content = $month01_total - $month01_sales;
       $Diff_01 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 2) {
          $class = 'heading1';
       }
       $content = $month02_total - $month02_sales;
       $Diff_02 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 3) {
          $class = 'heading1';
       }
       $content = $month03_total - $month03_sales;
       $Diff_03 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 4) {
          $class = 'heading1';
       }
       $content = $month04_total - $month04_sales;
       $Diff_04 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 5) {
          $class = 'heading1';
       }
       $content = $month05_total - $month05_sales;
       $Diff_05 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 6) {
          $class = 'heading1';
       }
       $content = $month06_total - $month06_sales;
       $Diff_06 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 7) {
          $class = 'heading1';
       }
       $content = $month07_total - $month07_sales;
       $Diff_07 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 8) {
          $class = 'heading1';
       }
       $content = $month08_total - $month08_sales;
       $Diff_08 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 9) {
          $class = 'heading1';
       }
       $content = $month09_total - $month09_sales;
       $Diff_09 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 10) {
          $class = 'heading1';
       }
       $content = $month10_total - $month10_sales;
       $Diff_10 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 11) {
          $class = 'heading1';
       }
       $content = $month11_total - $month11_sales;
       $Diff_11 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 12) {
          $class = 'heading1';
       }
       $content = $month12_total - $month12_sales;
       $Diff_12 = $content;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       $this->set_monthly_totals_output .=  $this->EndRow();     
       
       
       //Stock End Of Month 1
       $prev_value = 0;
       $class = 'gbr1';
       $this->set_monthly_totals_output .=  $this->Startrow($class); 
       
       $content = "Stock end of month"; 
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
 
       $content = " ";
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       $this->readme .= "<br>On way one is  $this->OnWay01 <br>";
       if ($this->current_month == 1) {
          $class = 'heading1';
       }
       
       if ($this->current_month  > 1) 
       {
       	    $content = "-";
       	    $prev_value = 0;
       } 
       else 
       {
      	    $content =   ($this->on_hand_total + $this->OnWay01) - $month01_total;
      	    $prev_value = $content;
        }
    
       $prev_value = $content;
     
      # $content =   ($this->on_hand_total + $this->OnWay01) - $month01_total;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       
       $this->readme .= "<br>On way two is  $this->OnWay02 <br>";
       
       $this->readme .= "<br>On way three is  $this->OnWay03 <br>";
       if ($this->current_month == 2) {
          $class = 'heading1';
          $content = 0;
       }

       if ($this->current_month  > 2) 
       {
       	    $content = "-";
       	    $prev_value = 0;
       } 
       elseif ($this->current_month == 2) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay02  - $Diff_02;
      	    $prev_value = $content;
      	  #  $content .= "($this->on_hand_total +  $this->OnWay02  - $Diff_02 )";
      	    
       }
       else {
       	    $content = $this->on_hand_total  + $this->OnWay02  - $Diff_02;
      	    $prev_value = $content;
      	  #  $content .= "($this->on_hand_total +  $this->OnWay02  - $Diff_02 )";
      }
       
       
      # $content .= "( ". $this->on_hand_total . " + ". $this->OnWay02 . " - $Diff_02 )";
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 3) {
          $class = 'heading1';
       }
       
       
        if ($this->current_month > 3) {
          $content = 0;
       }
       elseif ($this->current_month == 3) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay03  - $Diff_03;
      	    $prev_value = $content;
     	    
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay03  - $Diff_03;
       }
       $prev_value = $content;
       
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 4) {
          $class = 'heading1';
       }
 
       
       if ($this->current_month > 4) {
          $content = 0;
       }
       elseif ($this->current_month == 4) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay04  - $Diff_04;
      	    $prev_value = $content;
      	  #  $content .= "Form4:($this->on_hand_total +  $this->OnWay04  - $Diff_04 )";
      	    
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay04  - $Diff_04;
      	   # $content .= " --($prev_value +  $this->OnWay04  - $Diff_04 )";
       }
       $prev_value = $content;

       
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       if ($this->current_month == 5) {
          $class = 'heading1';
       }
       
       if ($this->current_month > 5) {
          $content = 0;
       }
       elseif ($this->current_month == 5) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay05  - $Diff_05;
      	    $prev_value = $content;
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay05  - $Diff_05;
       }
       $prev_value = $content;
 
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 6) {
          $class = 'heading1';
       }
      
       if ($this->current_month > 6) {
          $content = 0;
       }
       elseif ($this->current_month == 6) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay06  - $Diff_06;
      	    $prev_value = $content;
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay06  - $Diff_06;
       }
       $prev_value = $content;    
      
      # $content = $this->on_hand_total  + $this->OnWay06  - $Diff_06;
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 7) {
          $class = 'heading1';
       }
 
       if ($this->current_month > 7) {
          $content = 0;
       }
       elseif ($this->current_month == 7) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay07  - $Diff_07;
      	    $prev_value = $content;
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay07  - $Diff_07;
       }
       $prev_value = $content;
       
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 8) {
          $class = 'heading1';
       }
 
       if ($this->current_month > 8) {
          $content = 0;
       }
       elseif ($this->current_month == 8) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay08  - $Diff_08;
      	    $prev_value = $content;
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay08  - $Diff_08;
       }
       $prev_value = $content;
       
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       if ($this->current_month == 9) {
          $class = 'heading1';
       }
       
       if ($this->current_month > 9) {
          $content = 0;
       }
       elseif ($this->current_month == 9) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay09  - $Diff_09;
      	    $prev_value = $content;
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay09  - $Diff_09;
       }
       $prev_value = $content;
       
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 10) {
          $class = 'heading1';
       }
      
       if ($this->current_month > 10) {
          $content = 0;
       }
       elseif ($this->current_month == 10) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay010  - $Diff_10;
      	    $prev_value = $content;
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay10  - $Diff_10;
       }
       $prev_value = $content;     
      
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 11) {
          $class = 'heading1';
       }
       
       if ($this->current_month > 11) {
          $content = 0;
       }
       elseif ($this->current_month == 11) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay11  - $Diff_11;
      	    $prev_value = $content;
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay11  - $Diff_11;
       }
       $prev_value = $content;
     
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 12) {
          $class = 'heading1';
       }
       
       if ($this->current_month > 12) {
          $content = 0;
       }
       elseif ($this->current_month == 12) 
       {
      	    $content = $this->on_hand_total  + $this->OnWay12  - $Diff_12;
      	    $prev_value = $content;
       }
       else  
       {
      	    $content = $prev_value  + $this->OnWay12  - $Diff_12;
       }
       $prev_value = $content;
       
       
       $this->set_monthly_totals_output .=  $this->CreateCell($content,$class,1);
       
       $this->set_monthly_totals_output .=  $this->EndRow();        

       $this->prev_value = $prev_value;
              
       $this->set_monthly_totals_output .=  $this->EndTable();    

        $this->set_monthly_totals_output .=  "<p>";
    
    }   


    function getMonthRange(&$start_date, &$end_date, $offset=0) {
        $start_date = '';
        $end_date = '';   
        $test_date1 = "";
        $test_date2 = "";
        $date = date('Y-m-d');
       
        list($yr, $mo, $da) = explode('-', $date);
        $start_date = date('Y-m-d', mktime(0, 0, 0, $mo - $offset, 1, $yr));
        
        $test_date1 = date('Y-m-d', mktime(0, 0, 0, $mo - $offset, 2, $yr));
       
        $i = 2;
       
        list($yr, $mo, $da) = explode('-', $start_date);
       
        while(date('d', mktime(0, 0, 0, $mo, $i, $yr)) > 1) {
            $end_date = date('Y-m-d', mktime(0, 0, 0, $mo, $i, $yr));
            $i++;
        }
        
  
}    
    
    function set_other_totals($year_range,$item_code)   {
        global $tbl_coop_commited;
        global $tbl_item_description;
        global $tbl_coop_item;
    
        $prev_year_range = $year_range - 1;    
        global $tbl_order_header;
        global $tbl_order_item; 
        global $tbl_coop_contact; 
        global $tbl_lot_item;
        
        $to_date =  $year_range.'-12-31';
        $from_date =  $year_range.'-01-01';
        
        $prev_to_date =  $prev_year_range.'-12-31';
        $prev_from_date =  $prev_year_range.'-01-01';
        
        $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
        
        $query = "SELECT oi.item_code, Month(oh.order_date) as order_month, sum(li.quantity) as quantity
              FROM  order_header oh,  order_item oi,  coop_contact cc,  lot_item li
              WHERE oh.header_id = oi.header_key
              AND oh.customer_key = cc.contact_id
              and oi.item_id = li.item_id
              and oh.order_date Between '$from_date'
              and '$to_date'
              and oh.STATUS <> 'I'
              and oi.item_code = '$item_code' 
              group by  Month(oh.order_date)
              order by  Month(oh.order_date)"; 
              
    #    $this->readme .= "Select to determine monthly sales<br> $query <br>";      
              
        $monthly_sales  = array (0,0,0,0,0,0,0,0,0,0,0,0,0); 
              
        $this->result = mysql_query($query, $db_conn);
        $this->num_results = mysql_num_rows($this->result); 
          
       for ($i=0; $i <$this->num_results;  $i++) {
          $row = mysql_fetch_array($this->result);
          $monthly_sales[$row["order_month"]] = $row["quantity"];
        
        }
    
    
    
             $query = "select item_code,
                 sum(month01) as month01,
                 sum(month02) as month02,
                 sum(month03) as month03,
                 sum(month04) as month04,
                 sum(month05) as month05,
                 sum(month06) as month06,
                 sum(month07) as month07,
                 sum(month08) as month08,
                 sum(month09) as month09,
                 sum(month10) as month10,
                 sum(month11) as month11,
                 sum(month12) as month12,
                 sum(py) as py        
          from  coop_commited c,  coop_contact cc 
          where  import_yr ='$year_range'
            and c.customer_key = cc.contact_id 
           $warehouse_sql 
           and item_code = '$this->item_code'   
           group by item_code 
          order by item_code";
    
        $result = mysql_query($query, $db_conn);
        $num_results = mysql_num_rows($result);  
        
        $month_index =   substr(date("m/d/Y"),0,2);
        $i =  0 + $month_index;
        $month_index = $i;
        $this->current_month = $month_index;
        $prev_monthly_commit = 0;
        $back2_monthly_commit = 0;
        $back12_month_commit = 0;
        
        if ($num_results > 0) {
          $rowC = mysql_fetch_array($result);
           
          $monthly_sales[] = $rowC["quantity"];
          $total_commit = $rowC["month01"] +
                          $rowC["month02"] +
                          $rowC["month03"] +
                          $rowC["month04"] +
                          $rowC["month05"] +
                          $rowC["month06"] +
                          $rowC["month07"] +
                          $rowC["month08"] +
                          $rowC["month09"] +
                          $rowC["month10"] +
                          $rowC["month11"] +
                          $rowC["month012"];
                          
             $back3_month_commit = 0;   
             $back12_month_commit =  $total_commit;      
             
            # $this->readme = $this->readme."ok current month = ".$this->current_month."<br>";
            # $this->readme = $this->readme."ok commits for July = ".$rowC["month07"]."<br>";
            # $this->readme = $this->readme."ok commits for July? = ".$rowC[7]."<br>";
           
       for ($x=1; $x < $this->current_month;  $x++) {
             $ytd_commit += $rowC[$x];
        
        }
        $ytd_commit += $rowC[$x];
       # $this->readme = $this->readme."ok YTD? = ".$ytd_commit."<br>";
                 
                          
             switch ($i) {
             case 1:
                    $monthly_commit = $rowC["month01"];
                      break;
             case 2:
                    $monthly_commit = $rowC["month02"];
                    $prev_monthly_commit = $rowC["month01"];  
                    $back3_month_commit = 0;                  
                    break;
             case 3:
                    $monthly_commit = $rowC["month03"];
                    $prev_monthly_commit = $rowC["month02"];
                    $back2_monthly_commit =  $rowC["month01"];
                    $back3_month_commit = $rowC["month01"] +
                                          $rowC["month02"];
                    break;
             case 4:
                    $monthly_commit = $rowC["month04"]; 
                    $prev_monthly_commit = $rowC["month03"];
                    $back2_monthly_commit =  $rowC["month02"];
                    $back3_month_commit = $rowC["month01"] +
                                          $rowC["month02"] +
                                          $rowC["month03"];
                    break;
             case 5:
                    $monthly_commit = $rowC["month05"];
                    $prev_monthly_commit = $rowC["month04"];
                    $back2_monthly_commit =  $rowC["month03"];
                    $back3_month_commit = $rowC["month02"] +
                                          $rowC["month03"] +
                                          $rowC["month04"];
                    break; 
             case 6:
                    $monthly_commit = $rowC["month06"];
                    $prev_monthly_commit = $rowC["month05"];
                    $back2_monthly_commit =  $rowC["month04"];
                    $back3_month_commit = $rowC["month03"] +
                                          $rowC["month04"] +
                                          $rowC["month05"];
                    break; 
             case 7:
                    $monthly_commit = $rowC["month07"];
                    $prev_monthly_commit = $rowC["month06"];
                    $back2_monthly_commit =  $rowC["month05"];
                    $back3_month_commit = $rowC["month04"] +
                                          $rowC["month05"] +
                                          $rowC["month06"];
                    break;  
             case 8:
                    $monthly_commit = $rowC["month08"];
                    $prev_monthly_commit = $rowC["month07"];
                    $back2_monthly_commit =  $rowC["month05"];
                    $back3_month_commit = $rowC["month05"] +
                                          $rowC["month06"] +
                                          $rowC["month07"];
                    break;   
             case 9:
                    $monthly_commit = $rowC["month09"];
                    $prev_monthly_commit = $rowC["month08"];
                    $back2_monthly_commit =  $rowC["month07"];
                    $back3_month_commit = $rowC["month06"] +
                                          $rowC["month07"] +
                                          $rowC["month08"];
                    break;  
             case 10:
                    $monthly_commit = $rowC["month010"];
                    $prev_monthly_commit = $rowC["month09"];
                    $back2_monthly_commit =  $rowC["month08"];
                    $back3_month_commit = $rowC["month07"] +
                                          $rowC["month08"] +
                                          $rowC["month09"];
                    break;    
             case 11:
                    $monthly_commit = $rowC["month11"];
                    $prev_monthly_commit = $rowC["month10"];
                    $back2_monthly_commit =  $rowC["month09"];
                    $back3_month_commit = $rowC["month08"] +
                                          $rowC["month09"] +
                                          $rowC["month10"];
                    break;  
             case 12:
                    $monthly_commit = $rowC["month12"];
                    $prev_monthly_commit = $rowC["month11"];
                    $back2_monthly_commit =  $rowC["month10"];
                    $back3_month_commit = $rowC["month09"] +
                                          $rowC["month10"] +
                                          $rowC["month11"];
                    break;                                                                                                                                   
            }
        
        }
        
  
  
         $queryP = "select item_code,
                 sum(month01) as month01,
                 sum(month02) as month02,
                 sum(month03) as month03,
                 sum(month04) as month04,
                 sum(month05) as month05,
                 sum(month06) as month06,
                 sum(month07) as month07,
                 sum(month08) as month08,
                 sum(month09) as month09,
                 sum(month10) as month10,
                 sum(month11) as month11,
                 sum(month12) as month12,
                 sum(py) as py        
          from  coop_commited c,  coop_contact cc 
          where  import_yr ='$prev_year_range'
            and c.customer_key = cc.contact_id 
           $warehouse_sql 
           and item_code = '$this->item_code'   
           group by item_code 
          order by item_code";
          
          
    
        $resultP = mysql_query($queryP, $db_conn);
        $num_resultsP = mysql_num_rows($resultP);  
        
        $month_indexP =   substr(date("m/d/Y"),0,2);
        $i =  0 + $month_indexP;
        $month_indexP = $i;
        
        if ($num_resultsP > 0) {
          $rowP = mysql_fetch_array($resultP);
           
          $monthly_salesP[] = $rowP["quantity"];
          $total_commitP = $rowP["month01"] +
                          $rowP["month02"] +
                          $rowP["month03"] +
                          $rowP["month04"] +
                          $rowP["month05"] +
                          $rowP["month06"] +
                          $rowP["month07"] +
                          $rowP["month08"] +
                          $rowP["month09"] +
                          $rowP["month10"] +
                          $rowP["month11"] +
                          $rowP["month012"];
       
         }  
  
  
  # Heading:
  
        $this->tablewidth = '100%';
        echo $this->StartTable(); 
        echo $this->Startrow($class); 
        
        $content = " "; 
        $class = 'color1';
        echo $this->CreateCell($content,$class,1);
        
        # sales
        $content = "Sales";
        echo $this->CreateCell($content,$class,1);
        
        # Commits
        $content = "Commits";
        echo $this->CreateCell($content,$class,1);
        
        
        # Difference
        $content = "Difference";
        echo $this->CreateCell($content,$class,1);
         
        echo $this->EndRow();    
        
        

        #This Month:
        echo $this->Startrow($class); 
        $class = 'gbr1';
        $content = "This Month"; 
        echo $this->CreateCell($content,$class,1);
 
        # sales
  
        $current_month_sales = $monthly_sales[$i];
        $content = $monthly_sales[$i];
        echo $this->CreateCell($content,$class,1);
        
      #  $this->readme .= "Ok at this month and sales = $monthly_sales[$i] with i being $i <br>";
        
        # Commits
        $content = $monthly_commit;
        echo $this->CreateCell($content,$class,1);
        
        
        # Difference
        $content =  $monthly_commit - $monthly_sales[$i];
        echo $this->CreateCell($content,$class,1);
         
        echo $this->EndRow();  
  
        $current_month = $month_index;
        
        $query_to_date = $to_date;
        $query_from_date = $from_date;
        if ($current_month == 1) {
        	$previous_month = 12;
        	$prev_monthly_commit =  $rowP["month012"];
        	$query_to_date = $prev_to_date;
          $query_from_date = $prev_from_date;
        	
        }else {
           $previous_month = $current_month - 1;
        }
  
        $query = "SELECT oi.item_code,  sum(li.quantity) as quantity
              FROM   order_header oh,   order_item oi,   coop_contact cc,   lot_item li
              WHERE oh.header_id = oi.header_key
              AND oh.customer_key = cc.contact_id
              and oi.item_id = li.item_id
              and oh.order_date Between '$query_from_date'
              and '$query_to_date'
              and oh.STATUS <> 'I'
              and oi.item_code = '$item_code'  
              and   Month(oh.order_date) =  $previous_month 
              group by oi.item_code";
              
     
        $result = mysql_query($query, $db_conn);
        $num_results = mysql_num_rows($result);  

        $this_month_sales = 0;
        if ($num_results > 0) {
          $row = mysql_fetch_array($result);
          $this_month_sales = $row["quantity"];
        }
 
       
        
        #Last Month
        echo $this->Startrow($class); 
        $class = 'gbr2';
        $content = "Last Month"; 
        echo $this->CreateCell($content,$class,1);
 
        #sales
        $content = $this_month_sales;
        echo $this->CreateCell($content,$class,1);
        
         #commits
        $content = $prev_monthly_commit;
        echo $this->CreateCell($content,$class,1);
        
         #Difference
        $content = $prev_monthly_commit - $this_month_sales;
        echo $this->CreateCell($content,$class,1);
        
        echo $this->EndRow();    
        
        # Two months back now.      
                
       
        if ($current_month == 1) {
        	$previous_month = 11;
        	$prev_monthly_commit =  $rowP["month011"];
        }
        elseif ($current_month == 2) {
        	$previous_month = 12;
        	$prev_monthly_commit =  $rowP["month012"];
        }
        else {
           $previous_month = $current_month - 2;
        } 
  
        $query = "SELECT oi.item_code,  sum(li.quantity) as quantity
              FROM   order_header oh,   order_item oi,   coop_contact cc,   lot_item li
              WHERE oh.header_id = oi.header_key
              AND oh.customer_key = cc.contact_id
              and oi.item_id = li.item_id
              and oh.order_date Between '$query_from_date'
              and '$query_to_date'
              and oh.STATUS <> 'I'
              and oi.item_code = '$item_code' 
              and   Month(oh.order_date) =   $previous_month  
              group by oi.item_code";
              
      
        $result = mysql_query($query, $db_conn);
        $num_results = mysql_num_rows($result);  

        $two_months_back_sales = 0;
        if ($num_results > 0) {
          $row = mysql_fetch_array($result);
          $two_months_back_sales = $row["quantity"];
        }
              
   
        
        #2  Months
        echo $this->Startrow($class); 
        $class = 'gbr1';
        $content = "2 Months Prior"; 
        echo $this->CreateCell($content,$class,1);
 
        #sales
        $content = $two_months_back_sales;
        echo $this->CreateCell($content,$class,1);
        
        #commits 
        $content = $back2_monthly_commit;
        echo $this->CreateCell($content,$class,1);
        
         #Difference
        $content = $back2_monthly_commit - $two_months_back_sales;
        echo $this->CreateCell($content,$class,1);
        
       echo $this->EndRow(); 
        
       #ytd average:
        # Year To Date.      
                
        $query = "SELECT oi.item_code,  sum(li.quantity) as quantity
              FROM   order_header oh,   order_item oi,   coop_contact cc,   lot_item li
              WHERE oh.header_id = oi.header_key
              AND oh.customer_key = cc.contact_id
              and oi.item_id = li.item_id
              and oh.order_date Between '$from_date'
              and '$to_date'
              and oh.STATUS <> 'I'
              and oi.item_code = '$item_code'
              group by oi.item_code";
              
      
        $result = mysql_query($query, $db_conn);
        $num_results = mysql_num_rows($result);  
        $YTD_sales = 0;
        if ($num_results > 0) {
          $row = mysql_fetch_array($result);
          $YTD_sales = $row["quantity"];
        }
              
        if ($YTD_sales > 0) {
           $avg_YTD = $YTD_sales / 12;
        } else {
           $avg_YTD = 0;
           }
        
     #   YTD  Months
        echo $this->Startrow($class); 
        $class = 'gbr2';
        $content = "YTD"; 
        echo $this->CreateCell($content,$class,1);
 
        #sales
       # $content = number_format($avg_YTD, 2);
       # $YTD_sales
     #  $YTD_sales = $YTD_sales - $current_month_sales;
       $content = $YTD_sales;  # number_format($YTD_sales, 2);
        echo $this->CreateCell($content,$class,1);
        
        /*
        if ($total_commit > 0 ) {
           $avg_total_commit = $total_commit / 12;
        } else {
           $avg_total_commit = 0;
        }
        
        */
 
        #commits 
       # $content = $total_commit;   #  number_format($avg_total_commit, 2);

        $content = $ytd_commit;
        echo $this->CreateCell($content,$class,1);
        
         #Difference
      #  $content = number_format($avg_total_commit - $avg_YTD, 2);
         $content = $ytd_commit - $YTD_sales;
        echo $this->CreateCell($content,$class,1);         
        
         echo $this->EndRow();    
         
         
      #Last 3 Months average:
         
         echo $this->getMonthRange($start_date, $end_date, 1); 
         $to_date = $end_date;
         
         echo $this->getMonthRange($start_date, $end_date, 3); 
         $from_date = $start_date;         
 
 
        $query = "SELECT oi.item_code,  sum(li.quantity) as quantity
              FROM   order_header oh,   order_item oi,   coop_contact cc,   lot_item li
              WHERE oh.header_id = oi.header_key
              AND oh.customer_key = cc.contact_id
              and oi.item_id = li.item_id
              and oh.order_date Between '$from_date'
              and '$to_date'
              and oh.STATUS <> 'I'
              and oi.item_code = '$item_code'
              group by oi.item_code";
              
    
        $result = mysql_query($query, $db_conn);
        $num_results = mysql_num_rows($result);  
        $three_months_sales = 0;
        if ($num_results > 0) {
          $row = mysql_fetch_array($result);
          $three_months_sales = $row["quantity"];
        }
              
        if ($three_months_sales > 0) {
           $avg_three_months = $three_months_sales / 3;
        } else {
           $avg_three_months = 0;
           }
        
     #   3 Months average
        echo $this->Startrow($class); 
        $class = 'gbr1';
        $content = "Average Last 3 Months"; 
        echo $this->CreateCell($content,$class,1);
 
        #sales
        $content = number_format($avg_three_months, 2);
        echo $this->CreateCell($content,$class,1);
        
         
        if ($current_month == 1) {
        	$back3_month_commit =  $rowP["month011"] +  $rowP["month12"]  + $rowC["month01"];
        }
        elseif ($current_month == 2) {
        	$back3_month_commit =  $rowP["month012"] +  $rowC["month01"]  + $rowC["month02"];
        }
  
          if ($back3_month_commit > 0 ) {
           $avg_three_month_commit = $back3_month_commit / 3;
        } else {
           $avg_three_month_commit = 0;
        }
                 
        
 
        #commits 
        $content = number_format($avg_three_month_commit, 2);
        echo $this->CreateCell($content,$class,1);
        
         #Difference
        $content = number_format($avg_three_months - $avg_three_month_commit, 2);
        echo $this->CreateCell($content,$class,1);         
        
         echo $this->EndRow();            
                 
 # average last 12 Months.
       #Last 12 Months average:
         
         echo $this->getMonthRange($start_date, $end_date, 1); 
         $to_date = $end_date;
         
         echo $this->getMonthRange($start_date, $end_date, 12); 
         $from_date = $start_date;         
 
 
        $query = "SELECT oi.item_code,  sum(li.quantity) as quantity
              FROM   order_header oh,   order_item oi,   coop_contact cc,   lot_item li
              WHERE oh.header_id = oi.header_key
              AND oh.customer_key = cc.contact_id
              and oi.item_id = li.item_id
              and oh.order_date Between '$from_date'
              and '$to_date'
              and oh.STATUS <> 'I'
              and oi.item_code = '$item_code'
              group by oi.item_code";
              
          #    $this->readme = $this->readme.$query;
              
    
        $result = mysql_query($query, $db_conn);
        $num_results = mysql_num_rows($result);  
        $twelve_months_sales = 0;
        if ($num_results > 0) {
          $row = mysql_fetch_array($result);
          $twelve_months_sales = $row["quantity"];
        }
              
        if ($twelve_months_sales > 0) {
           $avg_twelve_months = $twelve_months_sales / 12;
        } else {
           $avg_twelve_months = 0;
           }
        
     #   12 Months average
        echo $this->Startrow($class); 
        $class = 'gbr2';
        $content = "Average Last 12 Months"; 
        echo $this->CreateCell($content,$class,1);
 
        #sales
        $content = number_format($avg_twelve_months, 2);
        echo $this->CreateCell($content,$class,1);


        if ($current_month == 1) {
        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowP["month09"]  +
        	                        $rowP["month08"]  +
        	                        $rowP["month07"]  +
        	                        $rowP["month06"]  +
        	                        $rowP["month05"]  +
        	                        $rowP["month04"]  +
        	                        $rowP["month03"]  +
        	                        $rowP["month02"];
        }
        elseif ($current_month == 2) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowP["month09"]  +
        	                        $rowP["month08"]  +
        	                        $rowP["month07"]  +
        	                        $rowP["month06"]  +
        	                        $rowP["month05"]  +
        	                        $rowP["month04"]  +
        	                        $rowP["month03"]  +
        	                        $rowC["month02"];
        }
        elseif ($current_month == 3) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowP["month09"]  +
        	                        $rowP["month08"]  +
        	                        $rowP["month07"]  +
        	                        $rowP["month06"]  +
        	                        $rowP["month05"]  +
        	                        $rowP["month04"]  +
        	                        $rowC["month03"]  +
        	                        $rowC["month02"];
           }     
                elseif ($current_month == 4) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowP["month09"]  +
        	                        $rowP["month08"]  +
        	                        $rowP["month07"]  +
        	                        $rowP["month06"]  +
        	                        $rowP["month05"]  +
        	                        $rowC["month04"]  +
        	                        $rowC["month03"]  +
        	                        $rowC["month02"];
           }  
            elseif ($current_month == 5) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowP["month09"]  +
        	                        $rowP["month08"]  +
        	                        $rowP["month07"]  +
        	                        $rowP["month06"]  +
        	                        $rowC["month05"]  +
        	                        $rowC["month04"]  +
        	                        $rowC["month03"]  +
        	                        $rowC["month02"];
           }    
            elseif ($current_month == 6) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowP["month09"]  +
        	                        $rowP["month08"]  +
        	                        $rowP["month07"]  +
        	                        $rowC["month06"]  +
        	                        $rowC["month05"]  +
        	                        $rowC["month04"]  +
        	                        $rowC["month03"]  +
        	                        $rowC["month02"];
           } 
            elseif ($current_month == 7) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowP["month09"]  +
        	                        $rowP["month08"]  +
        	                        $rowC["month07"]  +
        	                        $rowC["month06"]  +
        	                        $rowC["month05"]  +
        	                        $rowC["month04"]  +
        	                        $rowC["month03"]  +
        	                        $rowC["month02"];
           }  
            elseif ($current_month == 8) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowP["month09"]  +
        	                        $rowC["month08"]  +
        	                        $rowC["month07"]  +
        	                        $rowC["month06"]  +
        	                        $rowC["month05"]  +
        	                        $rowC["month04"]  +
        	                        $rowC["month03"]  +
        	                        $rowC["month02"];
           }   
            elseif ($current_month == 9) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowC["month09"]  +
        	                        $rowC["month08"]  +
        	                        $rowC["month07"]  +
        	                        $rowC["month06"]  +
        	                        $rowC["month05"]  +
        	                        $rowC["month04"]  +
        	                        $rowC["month03"]  +
        	                        $rowC["month02"];
           } 
            elseif ($current_month == 10) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowC["month09"]  +
        	                        $rowC["month08"]  +
        	                        $rowC["month07"]  +
        	                        $rowC["month06"]  +
        	                        $rowC["month05"]  +
        	                        $rowC["month04"]  +
        	                        $rowC["month03"]  +
        	                        $rowC["month02"];
           }    
            elseif ($current_month == 11) {
        	        	$back12_month_commit =  $rowC["month01"] + 
        	                        $rowP["month12"]  + 
        	                        $rowP["month11"]  +
        	                        $rowP["month10"]  +
        	                        $rowC["month09"]  +
        	                        $rowC["month08"]  +
        	                        $rowC["month07"]  +
        	                        $rowC["month06"]  +
        	                        $rowC["month05"]  +
        	                        $rowC["month04"]  +
        	                        $rowC["month03"]  +
        	                        $rowC["month02"];
           }  
      	                        
         
        if ($back12_month_commit > 0 ) {
           $avg_twelve_month_commit = $back12_month_commit / 12;
        } else {
           $avg_twelve_month_commit = 0;
        }
 
        #commits 
        $content = number_format($avg_twelve_month_commit, 2);
        echo $this->CreateCell($content,$class,1);
        
         #Difference
        $content = number_format($avg_twelve_months - $avg_twelve_month_commit, 2);
        echo $this->CreateCell($content,$class,1);         
        
         echo $this->EndRow();                    
        
        echo $this->EndTable();      
        
               
}    
    
    
    function EndRow(){
       return "\n"." </tr>";
    }
    
    
    function EndTable(){
       return "\n"." </table>";
    }


    function set_next_year_commits($year_range,$item_code)   {
    
        global $tbl_coop_commited;
        global $tbl_coop_commited; 
        global $tbl_coop_contact; 
 
        $month01_total=0;
        $month02_total=0;
        $month03_total=0;
        $month04_total=0;
        $month05_total=0;
        $month06_total=0;
        $month07_total=0;
        $month08_total=0;
        $month09_total=0;
        $month10_total=0;
        $month11_total=0;
        $month12_total=0;     
        
        $month01_sales=0;
        $month02_sales=0;
        $month03_sales=0;
        $month04_sales=0;
        $month05_sales=0;
        $month06_sales=0;
        $month07_sales=0;
        $month08_sales=0;
        $month09_sales=0;
        $month10_sales=0;
        $month11_sales=0;
        $month12_sales=0; 
        $month_sales =0;
        
        
        echo $this->StartTable(); 

        $class = 'color1';
        echo $this->Startrow($class); 
        $this->cellwidth = " ";
        $content = "$year_range Commits";
         
        echo $this->CreateCell($content,$class,1);
        $content = "$year_range Total";
     #   echo $this->CreateCell($content,$class,1);
     #   $content = "PYT";
        echo $this->CreateCell($content,$class,1);
        $content = "Jan";
        echo $this->CreateCell($content,$class,1);
        $content = "Feb";
        echo $this->CreateCell($content,$class,1);
        $content = "Mar";
        echo $this->CreateCell($content,$class,1);
        $content = "Apr";
        echo $this->CreateCell($content,$class,1);
        $content = "May";
        echo $this->CreateCell($content,$class,1);
        $content = "Jun";
        echo $this->CreateCell($content,$class,1);
        $content = "Jul";
        echo $this->CreateCell($content,$class,1);
        $content = "Aug";
        echo $this->CreateCell($content,$class,1);
        $content = "Sep";
        echo $this->CreateCell($content,$class,1);
        $content = "Oct";
        echo $this->CreateCell($content,$class,1);
        $content = "Nov";
        echo $this->CreateCell($content,$class,1);
        $content = "Dec";
        echo $this->CreateCell($content,$class,1);
        echo $this->EndRow(); 
                
        
     
       $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
       # we are not selecting by warehouse at this point, might never.
       $warehouse_sql = "";
       $query = "select item_code,
                 sum(month01) as month01,
                 sum(month02) as month02,
                 sum(month03) as month03,
                 sum(month04) as month04,
                 sum(month05) as month05,
                 sum(month06) as month06,
                 sum(month07) as month07,
                 sum(month08) as month08,
                 sum(month09) as month09,
                 sum(month10) as month10,
                 sum(month11) as month11,
                 sum(month12) as month12,
                 sum(py) as py        
          from  coop_commited c,  coop_contact cc 
          where  import_yr ='$year_range'
            and c.customer_key = cc.contact_id 
           $warehouse_sql 
           and item_code = '$this->item_code'   
           group by item_code 
          order by item_code";
          
          
       $queryP = "select item_code,
                 sum(month01) as month01,
                 sum(month02) as month02,
                 sum(month03) as month03,
                 sum(month04) as month04,
                 sum(month05) as month05,
                 sum(month06) as month06,
                 sum(month07) as month07,
                 sum(month08) as month08,
                 sum(month09) as month09,
                 sum(month10) as month10,
                 sum(month11) as month11,
                 sum(month12) as month12,
                 sum(py) as py        
          from  coop_commited c,  coop_contact cc 
          where  import_yr ='$prev_year_range'
            and c.customer_key = cc.contact_id 
           $warehouse_sql 
           and item_code = '$this->item_code'   
           group by item_code 
          order by item_code";
          
           
        $result = mysql_query($query, $db_conn);
        $num_results = mysql_num_rows($result); 
        
        $resultP = mysql_query($queryP, $db_conn);
        $num_resultsP = mysql_num_rows($result); 
        
          
       for ($i=0; $i <$num_results;  $i++) {
          $row = mysql_fetch_array($result);
          $total = $row['month01'] + $row['month02'] + $row['month03'] + $row['month04'] +$row['month05'] +$row['month06'] +$row['month07'] +$row['month08'] + $row['month09'] + $row['month10'] + $row['month11'] + $row['month12'];
          $month01_total=$month01_total + $row['month01'];
          $month02_total=$month02_total + $row['month02'];
          $month03_total=$month03_total + $row['month03'];
          $month04_total=$month04_total + $row['month04'];
          $month05_total=$month05_total + $row['month05'];
          $month06_total=$month06_total + $row['month06'];
          $month07_total=$month07_total + $row['month07'];
          $month08_total=$month08_total + $row['month08'];
          $month09_total=$month09_total + $row['month09'];
          $month10_total=$month10_total + $row['month10'];
          $month11_total=$month11_total + $row['month11'];
          $month12_total=$month12_total + $row['month12'];
          $py_total=$py_total+$row['py'];

          $item_code=$row['item_code'];

          $total_total = $total_total + $total +$row['py']; 
        $to_date =  $year_range.'-12-31';
        $from_date =  $year_range.'-01-01';
          
         $subquery = "SELECT MONTH(oh.order_date) as month,  sum(li.quantity) as quantity
              FROM   order_header oh,   order_item oi,   coop_contact cc,   lot_item li
              WHERE oh.header_id = oi.header_key   
              AND oh.customer_key = cc.contact_id  
              AND oi.item_code = '$item_code'   
              and oi.item_id = li.item_id  
              and oh.order_date Between '$from_date' and '$to_date'   
              group by MONTH(oh.order_date)";
              
             
  
         $subresult = mysql_query($subquery, $db_conn);
         $subnum_results = mysql_num_rows($subresult);
         $item_quantity=0;  
         $month_sales = 0;
         
         for ($b=0; $b <$subnum_results;  $b++) {
           $subrow = mysql_fetch_array($subresult);
           $month_sales += $subrow['quantity'];
           switch ($subrow['month']) {
             case 1:
                    $month01_sales = $subrow['quantity'];
                    break;
             case 2:
                    $month02_sales = $subrow['quantity'];
                    break;
             case 3:
                    $month03_sales = $subrow['quantity'];
                    break;
             case 4:
                    $month04_sales = $subrow['quantity'];
                    break;
             case 5:
                    $month05_sales = $subrow['quantity'];
                    break; 
             case 6:
                    $month06_sales = $subrow['quantity'];
                    break; 
             case 7:
                    $month07_sales = $subrow['quantity'];
                    break;  
             case 8:
                    $month08_sales = $subrow['quantity'];
                    break;   
             case 9:
                    $month09_sales = $subrow['quantity'];
                    break;  
             case 10:
                    $month10_sales = $subrow['quantity'];
                    break;    
             case 11:
                    $month11_sales = $subrow['quantity'];
                    break;  
             case 12:
                    $month12_sales = $subrow['quantity'];
                    break;                                                                                                                                   
            }
         }   
        $total = $total + $row['py'];
        $remaining=$total-$item_quantity;
        $remaining_total=$remaining_total+$remaining;
              
       }
       
       

       
       $class = 'gbr1';
       echo $this->Startrow($class); 
       $content = "$this->item_code Commits"; 
       echo $this->CreateCell($content,$class,1);
 

       #total goes here
       $content = $total;
       echo $this->CreateCell($content,$class,1);

   #    $content = $py_total;
   #    echo $this->CreateCell($content,$class,1);       
              
       if ($this->current_month == 1) {
          $class = 'heading1';
       }     
       $content = $month01_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 5) {
          $class = 'heading1';
       }
       $content = $month02_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 3) {
          $class = 'heading1';
       }
       $content = $month03_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 4) {
          $class = 'heading1';
       }
       $content = $month04_total;
       echo $this->CreateCell($content,$class,1);
 
       if ($this->current_month == 5) {
          $class = 'heading1';
       }
       $content = $month05_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 6) {
          $class = 'heading1';
       }
       $content = $month06_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 7) {
          $class = 'heading1';
       }
       $content = $month07_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 8) {
          $class = 'heading1';
       }
       $content = $month08_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 9) {
          $class = 'heading1';
       }
       $content = $month09_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 10) {
          $class = 'heading1';
       }
       $content = $month10_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 11) {
          $class = 'heading1';
       }
       $content = $month11_total;
       echo $this->CreateCell($content,$class,1);
       if ($this->current_month == 12) {
          $class = 'heading1';
       }
       $content = $month12_total;
       echo $this->CreateCell($content,$class,1);
       echo $this->EndRow(); 
       
       
       // Stock End of Month 2:
            $class = 'gbr1';
       echo  $this->Startrow($class); 
       
       $content = "Stock end of month"; 
       echo  $this->CreateCell($content,$class,1);
 
       $content = "&nbsp;  ";
       echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 1) {
          $class = 'heading1';
       }
       $content =  $this->prev_value - $month01_total;
       echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 2) {
          $class = 'heading1';
       }
        $content =  $this->prev_value - $month02_total;
       echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 3) {
          $class = 'heading1';
       }
        $content =  $this->prev_value - $month03_total;
      echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 4) {
          $class = 'heading1';
       }
       $content =  $this->prev_value - $month04_total;
       echo  $this->CreateCell($content,$class,1);
       
       if ($this->current_month == 5) {
          $class = 'heading1';
       }
        $content =  $this->prev_value - $month05_total;
       echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 6) {
          $class = 'heading1';
       }
       $content =  $this->prev_value - $month06_total;
       echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 7) {
          $class = 'heading1';
       }
       $content =  $this->prev_value - $month07_total;
       echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 8) {
          $class = 'heading1';
       }
       $content =  $this->prev_value - $month08_total;
       echo  $this->CreateCell($content,$class,1);
       if ($this->current_month == 9) {
          $class = 'heading1';
       }
       $content =  $this->prev_value - $month09_total;
       echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 10) {
          $class = 'heading1';
       }
       $content =  $this->prev_value - $month10_total;
       echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 11) {
          $class = 'heading1';
       }
       $content =  $this->prev_value - $month11_total;
       echo  $this->CreateCell($content,$class,1);
       
       
       if ($this->current_month == 12) {
          $class = 'heading1';
       }
       $content =  $this->prev_value - $month12_total;
       echo  $this->CreateCell($content,$class,1);
       
       echo  $this->EndRow();        

              
             
       echo $this->EndTable();    

        echo "<p>";
    
    }   


}


?> 

 