<?php
#$PlaceField=new myTextBoxChoice($view_mode,);
#$PlaceField->displayBox('User2:','User2',5,$row['User2']);

class myTextBoxChoice {

    var $myViewMode = 1;
    var $box_size = 5;
    var $box_color = '#EC0000';

    function myTextBoxChoice($view_mode){
    	$this->$myViewMode =$view_mode;
    	# echo 'view mode is now set to '.$this->$myViewMode;
    }

    function setSize($value){
        $this->box_size=$value;
    }
    function setWidth($value){
        $this->box_width=$value;
    }
    function setColor($value){
        $this->box_color=$value;
    }

    function displayBox($heading,$name,$size,$value,$trailer){
    	/*
        echo sprintf('
            <div style="height:%spx;width:%spx;background-color:%s"> </div>
        ',$this->box_height,$this->box_width,$this->box_color);
        */
        # echo 'view mode is set to '.$this->$myViewMode;
        echo  $heading ;
        if ($this->$myViewMode == 1)
        {
            echo "<input type=text name=$name onchange='dirty="."'true'"."' size=$size value='".$value."'>";
        }
        else
        {
            echo  "<span class='label'> $value</span>";
            echo $trailer;
        }
        
    }
        
}



class UpdateLastMaint {
	
	var $myKey = 0;
	var $action = "Add";
	var $b_field_1 = "";
	var $before_row;
	var $after_row;	
	
	function UpdateLastMaint($key,$action){
    	    $this->$myKey =$key;
            $this->$action=$action;
           # echo "init action:".$this->$action;
         }
	
         function GetBefore($key) {
         	
            global $tbl_coop_item;
	    global $tbl_item_description;
	    global $db_conn;
          
          $query = "select ci.item_id, ci.item_code, ci.lot_ship, ci.warehouse,
                    ci.item_description, id.item_description as generic_description, ci.member_price, ci.non_member_price,
                    ci.mark, ci.warehouse_code, ci.cost, ci.quantity, ci.transfer_in, ci.transfer_out,
                    id.weight as bag_lbs,ci.green_cb, ci.spot_available, ci.green_comment,
                    ci.STATUS, ci.ship_date, ci.arrival_date, ci.ft_item, ci.org_item,
                    ci.contract_date, ci.sample_shipped, ci.sample_approved, ci.container,
                    ci.document, ci.fda_confirm, ci.fda_date, ci.customs_clear_date,
                    ci.item_notes, ci.item_active, id.rank, ci.fixed_date, ci.fixed_price, ci.nyc, ci.prefinance, ci.prefinance_amount 
                    from $tbl_coop_item ci, $tbl_item_description id
                    where ci.item_id = $key 
                      and ci.item_code = id.item_code;";

          $result = mysql_query($query, $db_conn);
          $num_results = mysql_num_rows($result);
          $row = mysql_fetch_array($result);
          $this->$before_row = $row;
           $row2 = $this->$before_row['item_id'];
           }
          
          
         function GetAfter($key,$user_name) {
            global $tbl_coop_item;
	    global $tbl_item_description;
	    global $tbl_coop_item_last_maint2;
	    global $db_conn;
         #    echo "init action:".$this->$action;
          
          $query = "select ci.item_id, ci.item_code, ci.lot_ship, ci.warehouse,
                    ci.item_description, id.item_description as generic_description, ci.member_price, ci.non_member_price,
                    ci.mark, ci.warehouse_code, ci.cost, ci.quantity, ci.transfer_in, ci.transfer_out,
                    id.weight as bag_lbs,ci.green_cb, ci.spot_available, ci.green_comment,
                    ci.STATUS, ci.ship_date, ci.arrival_date, ci.ft_item, ci.org_item,
                    ci.contract_date, ci.sample_shipped, ci.sample_approved, ci.container,
                    ci.document, ci.fda_confirm, ci.fda_date, ci.customs_clear_date,
                    ci.item_notes, ci.item_active, id.rank, ci.fixed_date, ci.fixed_price, ci.nyc, ci.prefinance, ci.prefinance_amount 
                    from $tbl_coop_item ci, $tbl_item_description id
                    where ci.item_id = $key 
                      and ci.item_code = id.item_code;";

  
          $result = mysql_query($query, $db_conn);
          $num_results = mysql_num_rows($result);
          $row = mysql_fetch_array($result);

   #       $this->$action = "UPDATE";
     #    echo "<br>Ok,<br>";
     #    print_r ($this->$action);
     #    echo "<br>End";
          $row2 = $this->$before_row['item_id'];
  
  $query = "insert into $tbl_coop_item_last_maint2 ".
   " (item_id, updated_by, ACTION, maint_date, b_item_code, b_lot_ship, b_warehouse, b_item_description, b_member_price, b_non_member_price, b_mark, b_warehouse_code, b_cost, b_quantity, b_transfer_out, b_transfer_in, b_bag_lbs, b_STATUS, b_ship_date, b_arrival_date, b_ft_item, b_org_item, b_item_notes, b_item_active, b_green_cb, b_spot_available, b_green_comment, b_contract_date, b_sample_shipped, b_sample_approved, b_container, b_document, b_fda_confirm, b_fda_date, b_customs_clear_date, b_fixed_date, b_fixed_price, a_item_code, a_lot_ship, a_warehouse, a_item_description, a_member_price, a_non_member_price, a_mark, a_warehouse_code, a_cost, a_quantity, a_transfer_out, a_transfer_in, a_bag_lbs, a_STATUS, a_ship_date, a_arrival_date, a_ft_item, a_org_item, a_item_notes, a_item_active, a_green_cb, a_spot_available, a_green_comment, a_contract_date, a_sample_shipped, a_sample_approved, a_container, a_document, a_fda_confirm, a_fda_date, a_customs_clear_date, a_fixed_date, a_fixed_price, b_nyc, a_nyc, b_prefinance, a_prefinance, b_prefinance_amount, a_prefinance_amount) ".
   " values('".$row['item_id']."','".                   
   $user_name."','".              
   'Update'."',".                                
   'CURDATE()'.",'".                               
   $row2['item_code']."','".                     
   $row2['lot_ship']."','".                       
   $row2['warehouse']."','".                      
   $row2['item_description']."','".               
   $row2['member_price']."','".                   
   $row2['non_member_price']."','".               
   $row2['mark']."','".                            
   $row2['warehouse_code']."','".                
   $row2['cost']."','".                           
   $row2['quantity']."','".                       
   $row2['transfer_out']."','".                   
   $row2['transfer_in']."','".                   
   $row2['bag_lbs']."','".                         
   $row2['STATUS']."','".                          
   $row2['ship_date']."','".                      
   $row2['arrival_date']."','".                   
   $row2['ft_item']."','".                        
   $row2['org_item']."','".                        
   $row2['item_notes']."','".                      
   $row2['item_active']."','".                     
   $row2['green_cb']."','".                        
   $row2['spot_available']."','".                
   $row2['green_comment']."','".                  
   $row2['contract_date']."','".                  
   $row2['sample_shipped']."','".                 
   $row2['sample_approved']."','".                 
   $row2['container']."','".                      
   $row2['document']."','".                        
   $row2['fda_confirm']."','".                    
   $row2['fda_date']."','".                        
   $row2['customs_clear_date']."','".            
   $row2['fixed_date']."','".                     
   $row2['fixed_price']."','".                    
   $row['item_code']."','".                       
   $row['lot_ship']."','".                         
   $row['warehouse']."','".                        
   $row['item_description']."','".                
   $row['member_price']."','".                   
   $row['non_member_price']."','".                
   $row['mark']."','".                             
   $row['warehouse_code']."','".                
   $row['cost']."','".                             
   $row['quantity']."','".                        
   $row['transfer_out']."','".                    
   $row['transfer_in']."','".                     
   $row['bag_lbs']."','".                         
   $row['STATUS']."','".                          
   $row['ship_date']."','".                       
   $row['arrival_date']."','".                    
   $row['ft_item']."','".                          
   $row['org_item']."','".                        
   $row['item_notes']."','".                      
   $row['item_active']."','".                      
   $row['green_cb']."','".                         
   $row['spot_available']."','".                   
   $row['green_comment']."','".                    
   $row['contract_date']."','".                    
   $row['sample_shipped']."','".                  
   $row['sample_approved']."','".                  
   $row['container']."','".                       
   $row['document']."','".                        
   $row['fda_confirm']."','".                    
   $row['fda_date']."','".                         
   $row['customs_clear_date']."','".              
   $row['fixed_date']."','".                     
   $row['fixed_price']."','".
   $row2['nyc']."','".
   $row['nyc']."','".
   $row2['prefinance']."','".
   $row['prefinance']."','".
   $row2['prefinance_amount']."','".
   $row['prefinance_amount']."')"; 
   
 #  echo "<br>$query <br>";

            $result = mysql_query($query, $db_conn);
            if (!$result){
             echo "<font size=2>Last Maint Add Failed";
           }
            
 

          }          
			
		
	
}
?> 

 