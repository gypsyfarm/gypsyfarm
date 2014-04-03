<?php
#$PlaceField=new myTextBoxChoice($view_mode,);
#$PlaceField->displayBox('User2:','User2',5,$row['User2']);

$site_name = "<a STYLE='text-decoration:none' href='../index.php'>FAIR TRADE <br> PROOF</a>";
function TraceHeading() {
     
     echo "\n";

    echo ' <div class="greytwo"> ';
    echo '<strong>TRACE YOUR BEANS FROM FARMER TO ROASTER. </strong>';
    echo 'A fair price is just the beginning. We practice Fair Trade as a long-term partnership between farmers and roasters, including pre-financing, ';
    echo 'sharing information and working together for higher quality coffee. Without proof, anyone can say anything. ';
    echo 'This site is part of our effort to provide total transparency in our process.';
    echo '</div>';
    echo "\n";
	
}

function NewTraceHeading($level) {	
	
        echo '<tr>';
        echo '<td rowspan=2 width="10%" valign="top" align="left">';
        echo ' <div class="greytwo"> ';
        echo "\n";
        echo "<a href='../index.php'>";
        echo '<img   border=0 src="../images/logoinside.jpg">';
        echo '</a>';
        echo '</td>';
        
        echo "<td colspan='2' width='70%'>";   
        echo ' <div class="greytwo"> '; 
        echo '<strong>TRACE YOUR BEANS FROM FARMER TO ROASTER. </strong>';
        echo 'We practice Fair Trade as a long-term partnership between farmers and roasters, including pre-financing, ';
        echo 'sharing information and working together for higher quality coffee. Without proof, anyone can say anything. ';
        echo 'This site is part of our effort to provide total transparency in our process.';
        echo '</div>';
        echo "\n";
        echo "</td>";
        
        echo '<td rowspan=2 width="20%" valign="top">';
        echo '<div class="corners">';
        echo "Our black background minimizes energy, reducing climate change";
        echo "<p>";
        echo "</div>";
        echo '<div class="corners">';
        echo "Fair Trade Proof is maintained <br> by Cooperative Coffees"; 
        echo "</div>";
        echo "</td>";
        echo "</tr>";
     
        
	
}

function TraceFooter($level,$query_string="") {

     echo "<div class='greylinks'>";
      echo "\n";
     echo '<a href="'.$level.'index.php" target="_top" >Home</a> &nbsp;&nbsp;| &nbsp;&nbsp;';

     echo "\n";
     echo '<a href="'.$level.'index.php" target="_top" >Trace lot # from Coop or Roaster.</a> &nbsp;&nbsp;| &nbsp;&nbsp;';
    echo "\n";
    echo  '<a href="'.$level.'transparent_document_trail.php'.$query_string.'" target="_top" >Learn what documents mean.</a>';
    echo "</div>";
    echo "\n";
    echo "<p>";
     echo "<div class='address'>";
   #  echo "<center>";
    echo "Cooperative Coffees, 302 W. Lamar Street, Suite C <br>";
    echo "Americus, GA 31709; USA<br>";
   # echo "</center>";
    echo "</div>";
 
	
}
 

class myRightSideContent {
	var $db_conn;
	var $type = "";
        var $name;
        var $contact;
        var $content;
        var $item_code;
        var $coop_id;
        var $directory;
        var $partner_since;
        var $readme; 
        var $scribd_id;
        var $doc_id;
        var $guid;
        var $rst_id;
        var $program_sw;
        var $search;
        var $lot_nbr;
        var $gorp_id;
        var $cookie_value;
        var $address1;
        var $address2;
        var $city;
        var $state;
        var $zip;
        var $country;
        var $telephone;
        var $email;
        var $section_1;
        var $section_2;
        var $section_3;
        var $section_4;
        var $organic_cert_link;
        var $photo1;
        var $photo2;
        var $photo1_caption;
        var $photo2_caption;
        var $url_base = "http://www.coffeepath.com/";
        
        
         
  
    
	
	function myRightSideContent($db_conn) {
		$this->db_conn = $db_conn;
	}


function BuildScribdLink($document_id,$access_key,$rst_id,$item_code) {
	
     echo "<a href=\"javascript:poptastic('";
     echo '../scribd_example5.php?document_id='.$document_id.'&access_key='.$access_key.'&rst_id='.$rst_id.'&item_code='.$item_code;
     echo "');\">Organic Cert Link</a>";
     echo "<br><br><hr class='yellow_hr'>";
} 
 

function SearchLotList($search_value,$customer) {
	 global $db_conn;
	 
	 $clean_search_value = str_replace('-','',str_replace(' ','',$search_value));
	 
	 mysql_select_db(trf_roaster_lot_table);    
	 $query = "SELECT *
                   FROM trf_roaster_lot_table ci 
                   WHERE ft_id =  $customer
                   AND roaster_lot_code = '$clean_search_value' ";
       
     #  AND CONCAT(CONCAT(CONCAT( ci.item_code,ci.lot_ship), '-' ), ci.mark )   LIKE  '%$search_value%'";
       
     # echo "<br>$query <br>";
                           
       $result = mysql_query($query, $db_conn);
       $num_results = mysql_num_rows($result);
       $row = mysql_fetch_array($result);
 
       for ($x=0; $x <$num_results;  $x++)  {
           $roaster_lot_code = $row['roaster_lot_code'];
           $green_lot_1 =  $row['green_lot_1'];
           $green_lot_2 =  $row['green_lot_2'];
           $green_lot_3 =  $row['green_lot_3'];
           $green_lot_4 =  $row['green_lot_4'];
           $green_lot_5 =  $row['green_lot_5'];
           $green_lot_6 =  $row['green_lot_6'];
     
            echo "Code $roaster_lot_code<br>";
            if ( $green_lot_1 != "")  {
              $this->BuildLotList($green_lot_1,'Y');
            }
           if ($green_lot_2  != "") {
              $this->BuildLotList($green_lot_2,'Y');
            }
           if ($green_lot_3  != "") {
              $this->BuildLotList($green_lot_3,'Y');
            }
            if ($green_lot_4  != "") {
              $this->BuildLotList($green_lot_4,'Y');
            }
            if ($green_lot_5 != "") {
              $this->BuildLotList($green_lot_5,'Y');;
            }
            if ($green_lot_6  != "") {
              $this->BuildLotList($green_lot_6,'Y');
            }
     
           $row = mysql_fetch_array($result);
       
       }     
 
}



function BuildBlendList($item_code) {
	global $db_conn2;

        $query = "select DISTINCT  ci.item_code, ci.lot_ship, ci.mark,  ci.scribd_id, ci.guid   
                        from coop_item ci 
                        where  ci.scribd_id <> '' 
                          and ci.item_code = '$item_code' 
                         and ship_date >  '2011-06-30'";
	 
	
	 mysql_select_db(coop_item);    
      #   echo "<br>$query<br>";      
                           
        $result = mysql_query($query, $db_conn2);
        $num_results = mysql_num_rows($result);
        $row = mysql_fetch_array($result);
        
     for ($i=0; $i <$num_results;  $i++)  {
	$item = $row['item_id'];
	$item_code = $row['item_code'];
	$lot_ship = $row['lot_ship'];
	$mark = $row['mark'];
	$scribd_id = $row['scribd_id'];
	$guid = $row['guid'];
	
       echo '<a href="../scribd_example4.php?document_id='.$scribd_id.'&item_code='.$item_code.'&access_key='.$guid.'&rst_id='.$this->rst_id.'&program_sw='.$this->program_sw.'&search='.$this->search.'&lot_nbr='.$this->lot_nbr.'&gorp_id='.$this->gorp_id.'&called_from=buildblendlist"> ';
        echo "$item_code $lot_ship - $mark ";
        echo ' </a><br>';
        
        $row = mysql_fetch_array($result);
        }

}
 

function SearchBlendList($search_value,$customer) {
	 global $db_conn;
	# echo "<br>search value is ".$search_value."<br>";
	 $clean_search_value = str_replace('-','',str_replace(' ','',$search_value));
	 
	 mysql_select_db(trf_roaster_blend_table);    
	 $query = "SELECT *
                   FROM trf_roaster_blend_table ci 
                   WHERE ft_id =  $customer
                   AND roaster_blend_code = '$clean_search_value' ";
       
     #  AND CONCAT(CONCAT(CONCAT( ci.item_code,ci.lot_ship), '-' ), ci.mark )   LIKE  '%$search_value%'";
       
      # echo "<br>$query <br>";
      #echo "</center>";
       echo '<div class="whitefour">';            
       $result = mysql_query($query, $db_conn);
       $num_results = mysql_num_rows($result);
       $row = mysql_fetch_array($result);
 
       for ($x=0; $x <$num_results;  $x++)  {
           $roaster_blend_code = $row['roaster_blend_code'];
           $blend_code_1 =  $row['green_lot_1'];
           $blend_code_2 =  $row['green_lot_2'];
           $blend_code_3 =  $row['green_lot_3'];
           $blend_code_4 =  $row['green_lot_4'];
           $blend_code_5 =  $row['green_lot_5'];
           $blend_code_6 =  $row['green_lot_6'];
      
            if ( $blend_code_1 != "")  {
              $this->BuildBlendList($blend_code_1);
            }
           if ($blend_code_2  != "") {
              $this->BuildBlendList($blend_code_2);
            }
           if ($blend_code_3  != "") {
              $this->BuildBlendList($blend_code_3);
            }
            if ($blend_code_4  != "") {
              $this->BuildBlendList($blend_code_4);
            }
            if ($blend_code_5 != "") {
              $this->BuildBlendList($blend_code_5);;
            }
            if ($blend_code_6  != "") {
              $this->BuildBlendList($blend_code_6);
            }
     
           $row = mysql_fetch_array($result);
       
       }     
            echo "</div>";
}


function CoopStep2() {
	echo "</div>"; 
              echo "<hr class='yellow_hr'>";
        echo "</td>"; 
        echo "<td valign='top' width=25%>"; 
        echo "<div style='width:200px;  ;border:4px solid yellow;'>"; 

        echo "<div>"; 

        echo "<div class='whiteone'>"; 
        echo "<center>"; 
        echo "Step 1<br>"; 
        echo "</div>"; 
        echo "<div class='center'>"; 

        echo "<br><input type='image' id='btn1' name='btn1'  value='btn1' alt='btn1' src='../images/learn.jpg'><br>&nbsp;<br>"; 
        echo "</div>"; 
        
        $UrlParm = "";
        if ($this->coop_id <> "") {
        	$UrlParm = "coop_id=".$this->coop_id;
        }
        else {
        	$UrlParm = "rst_id=".$this->rst_id;
        }
        	
        echo '<center>';
         echo  '<SELECT NAME="stepone" onChange="nav(this)">';
        # echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?">-- Select One --</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'">--Complete Trail--</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'">Complete Trail</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'&step=FarmerContract">Farmer Contract</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'&step=PreFinancing">Pre-Financing </option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'&step=PreShip">Pre Cupping</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'&step=FarmerInvoice">Farmer Invoice</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'&step=LadingBill">Bill Of Lading</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'&step=LandedCupping">Landed Cupping</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'&step=OrganicTrans">Organic Transaction</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'&step=RoasterInvoice">Roaster Invoice</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?'.$UrlParm.'&step=RoasterDelivery">Roaster Delivery</option>';
         echo '</SELECT> ';
         echo '</center>';
         echo "<br>";
       # echo "<div>"; 
       # echo "&nbsp;"; 
        echo "</div>"; 
        echo "<div class='whitetwo'>"; 

        echo "Step 2<br>"; 

        echo "<image src='../images/choose.jpg'><br> "; 
        echo "</div>"; 

        echo "<p>"; 
	
}

function Step1Step2($program_sw, $search, $lot_nbr, $gorp_id) {
	
	 $this->program_sw = $program_sw;
	 $this->search = $search;
	 $this->lot_nbr = $lot_nbr;
	 $this->gorp_id = $gorp_id;
 
	 echo '<div class="whiteone">'; 
	 echo "\n";
         echo '<center>';
         echo 'STEP 1<br>';
         echo '</div>';
         
         echo '<div class="center">';
         
         echo '<br><input type="image" id="btn1" name="btn1"  value="btn1" alt="btn1" src="../images/learn.jpg"><br>';
         echo '</div>';
         
         
         echo  '<SELECT NAME="stepone" onChange="nav(this)">';
        # echo '<OPTION VALUE="'.$levelOfImage.'index.php">--Select One--</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'">--Complete Trail--</option>';
        echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'">Complete Trail</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'&step=FarmerContract">Farmer Contract</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'&step=PreFinancing">Pre-Financing </option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'&step=PreShip">Pre Cupping</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'&step=FarmerInvoice">Farmer Invoice</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'&step=LadingBill">Bill Of Lading</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'&step=LandedCupping">Landed Cupping</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'&step=OrganicTrans">Organic Transaction</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'&step=RoasterInvoice">Roaster Invoice</option>';
         echo '<OPTION VALUE="'.$levelOfImage.'../transparent_document_trail.php?rst_id='.$this->rst_id.'&step=RoasterDelivery">Roaster Delivery</option>';
         echo '</SELECT> ';
         echo "<br><br>";
         echo 'STEP 2<br>';

 
         if ($program_sw == 'Y') {
             echo 'ENTER THE LOT #<br> ';
             echo 'FROM THE BAG<br>';
             echo 'YOU WANT TO TRACE<br>';
             echo ' <br>';

             echo '<input type="text" name="lot_nbr" value="'.$lot_nbr.'"> <br>';
             echo '<input class="n1btn"  name="search" type="submit" value="Search" /><br />';
            
             
             if (ISSET($search)) {
      	        echo " <center> <br>THIS BAG CONTAINS <br></center>";
      	         if ($program_sw == 'A') {
      	            $this->SearchLotList($lot_nbr,$gorp_id);
      	         }
      	         else {
      	        $this->SearchLotList($lot_nbr,$gorp_id);
             }
        }
              echo '<br> OR <br>';
        }
        elseif ($program_sw == 'A') {
        	  
        	
             if (isset($_POST['blend_code'])) {
             	$blend_code = $_POST['blend_code'];
             } 
             else {
        	 $blend_code = $this->cookie_value;
             }
             
             echo 'ENTER THE BLEND CODE<br> ';
             echo 'FROM THE BAG<br>';
             echo 'YOU WANT TO TRACE<br>';
             echo ' <br>';
             echo '<input type="text" name="blend_code" value="'.$blend_code.'"> <br>';
             echo '<input class="n1btn"  name="search" type="submit" value="Search" /><br />';
            
             
             if (ISSET($search)) {
             	$blend_code = $_POST['blend_code'];
             	#echo "<center>blend_code = $blend_code <br>";
      	        echo "<br>THIS BAG CONTAINS <br></center>";
   	        
      	        $this->SearchBlendList($blend_code,$gorp_id);
             }
              echo '<br> OR <br>';
        }
        
        echo "<p> ";  
        echo "<image src='../images/choose.jpg'><br>";
      #  echo ' CHOOSE A LOT <br>';
        echo ' </center>';
          $this->BuildRoasterList($gorp_id);
        echo '</div>'; 
}




function GetCoopRecord($coop_id) {
    global $db_conn;

mysql_select_db('trf_coop_content');
  $this->coop_id = $coop_id;

  $query = "select * 
            from trf_coop_content
             where coop_id =  '$coop_id';";
   # echo "<br>$query <br>";
# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);
  $this->name = $row['coop_name'];
  $this->name = str_replace(" '", "'", $this->name);
  $this->contact = $row['contact'];
  $this->content = $row['content'];
  $this->item_code = $row['item_code'];
  $this->directory = $row['directory'];
  $this->scribd_id = $row['scribd_id'];
  $this->guid = $row['guid'];
  $this->coop_id = $coop_id;
 
	
}

function GetRoasterRecord($rst_id) {
      
      /*
  #  global $name;
    global $contact;
    global $content;
    global $link_to_site;
    global $organic_cert_link;
    global $partner_since;
    global $directory;
    global $program_sw;
    
    */
mysql_select_db('trf_roaster_content');


  $query = "select * 
            from trf_roaster_content
             where ft_id =  $rst_id;";
             
             $this->rst_id = $rst_id;
             $this->readme = $query;

 
# retrieve information:
  $result = mysql_query($query, $this->db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);

  $this->name =  $row['roaster_name'];
  $this->name = str_replace(" '", "'", $this->name);
  $this->contact = $row['contact'];
  $this->link_to_site = $row['link_to_site'];
  $this->organic_cert_link = $row['organic_cert_link'];
  $this->partner_since = $row['partner_since'];
  $this->directory =  $row['directory'];
  $this->directory = $row['directory'];
  $this->program_sw = $row['program_sw'];
  $this->scribd_id = $row['scribd_id'];
  $this->guid = $row['guid'];
  $this->rst_id =  $rst_id;
  $this->photo1 = $row['photo1'];
  $this->photo2 = $row['photo2'];
  $this->photo1_caption = $row['photo1_caption'];
  $this->photo2_caption = $row['photo2_caption'];
  
  $this->address1 = $row['address1'];
  $this->address2 = $row['address2'];
  $this->city = $row['city'];
  $this->state = $row['state'];
  $this->zip = $row['zip'];
  $this->country = $row['country'];
  $this->telephone = $row['telephone'];
  $this->email = $row['email'];
  $this->section_1 = $row['section_1'];
  $this->section_2 = $row['section_2'];
  $this->section_3 = $row['section_3'];
  $this->section_4 = $row['section_4'];
 
	
}	

function EchoIfSet($title,$value, $break="<br>") {
	if (isset($value) && strlen($value) > 1){
		echo $title.$value.$break;
	}
}


function RoasterLeftSideContent() {
	
	echo "<table width='90%'>";
	echo "\n";
        echo "<tr>";
        echo "\n";
        echo "<td valign='top' align='left' width='75%'>";
        echo "\n";
        echo "<div class='yellow_heading'>";
        echo "\n";
        echo $this->name;
        echo "\n";
        echo "</div>";
        echo "\n";
	
        echo "<div class='whiteone'>";
        $this->EchoIfSet("",$this->name);
        $this->EchoIfSet("",$this->address1);
        $this->EchoIfSet("",$this->address2);
        $this->EchoIfSet("",$this->city,", ");
        $this->EchoIfSet("",$this->state," ");
        $this->EchoIfSet("",$this->zip);
        $this->EchoIfSet("",$this->country);
        echo "<br>";
        $this->EchoIfSet("Telephone: ",$this->telephone);
      #  $this->EchoIfSet("Email: ",$this->email);
        
        if ($this->email <> "") {	
           echo "<a href='mailto:$this->email'> $this->email </a> <br>";
        }
                
        $this->EchoIfSet("",$this->partner_since);
        
       
        if ($this->link_to_site <> "") {	
           echo "<a href='http://$this->link_to_site'  target='_blank'> $this->link_to_site </a> <br>";
        }
	
	 if ($this->scribd_id != "") {
            $this->BuildScribdLink($this->scribd_id,$this->guid,$this->rst_id,'');
         }
         
         if ($this->organic_cert_link <> ""){
            echo "<a href='$this->url_base$this->organic_cert_link'  target='_blank'> Organic Cert Link </a> <br>";
         }
         
         
         echo "</div>";
 
        
         $this->EchoIfSet("<p><div>",$this->section_1,"</div>");
         $this->EchoIfSet("<p><div>",$this->section_2,"</div> ");
         $this->EchoIfSet("<p><div>",$this->section_3,"</div> ");
         $this->EchoIfSet("<p><div>",$this->section_4,"</div> ");
         $this->EchoIfSet("<br><img src='images/",$this->photo1,"'> ");
         $this->EchoIfSet("<br>",$this->photo1_caption,"<br>");
         $this->EchoIfSet("<br><img src='images/",$this->photo2,"'> ");
         $this->EchoIfSet("<br>",$this->photo2_caption,"<br>");
         
         
        # </div>
         echo "</td>";
         echo "<td valign='top' width='25%'>";
         echo "<div style='width:200px; border:4px solid yellow;'>";

         echo "<div>";
          echo "<p>";
 
  
        echo '<div class="whitethree">';
   
        $SetRightNav->cookie_value = $cookie_value;  

        $this->Step1Step2($this->program_sw,$this->search,$this->lot_nbr, $this->gorp_id);    
  
         
          
	
}

	
function BuildLotList($item_code,$split_sw = 'N') {
	global $db_conn2;
	
	

        $pieces = explode(",", $item_code);
        
        $where = "";
        foreach ($pieces as $piece) {
        	
            if ($where <> "") {
            	$where = $where." or ";
            } 		
        	
            if ($where == "") {
            	$where = $where." and ( ";
            } 

            $where = $where." ci.item_code like '$piece' ";
         }
         
         if ($where <> "") {
            	$where = $where." ) ";
            }
         
        # where ci.item_code like '$item_code'
	
 	if ($split_sw == 'Y') {
		#list($code, $lot) = split('[-]',$item_code);		
               $query = "select ci.item_id, ci.item_code, ci.lot_ship, ci.mark,  ci.scribd_id, ci.guid   
                          from coop_item ci 
                         where ci.item_id = '$item_code' order by ci.item_code, ci.lot_ship";	
	}
	else {
              $query = "select DISTINCT  ci.item_code, ci.lot_ship, ci.mark,  ci.scribd_id, ci.guid   
                        from coop_item ci 
                        where  ci.scribd_id <> '' 
                          $where 
                         and ship_date >  '2011-06-30' order by ci.item_code, ci.lot_ship";
	}
	
	 mysql_select_db(coop_item);    
	 
    
       #  echo "<br>$query<br>";      
                           
        $result = mysql_query($query, $db_conn2);
        $num_results = mysql_num_rows($result);
        $row = mysql_fetch_array($result);
        
        echo '<div class="whitefour">';
        if ($split_sw == 'N') {
             echo "Number of Lots: $num_results <br>";
         }
 

     for ($i=0; $i <$num_results;  $i++)  {
	$item = $row['item_id'];
	$item_code = $row['item_code'];
	$lot_ship = $row['lot_ship'];
	$mark = $row['mark'];
	$scribd_id = $row['scribd_id'];
	$guid = $row['guid'];
	$coop_id = $this->coop_id;
	
	

	
	if ($mark != "") {
           # echo '<a href="scribd_example4.php"> ';
           
           	if ($mark != "" && $guid !="") {
            echo '<a href="../scribd_example4.php?document_id='.$scribd_id.'&item_code='.$item_code.'&access_key='.$guid.'&coop_id='.$coop_id.'&called_from=buildlotlist"> ';
       
        }
        else {
            echo '<a href="../scribd_example4.php?document_id=447922&item_code='.$item_code.'&access_key=dp16lee9f98tv&called_from=buildlotlistx"> ';
        }

            
            echo "$item_code $lot_ship - $mark ";
            echo ' </a><br>';
        }

   $row = mysql_fetch_array($result);	
	}
	
	echo '</div';
# end for loop. 
}
	
         


	
	
function BuildRoasterList($customer) {
	global $db_conn2;
	 echo '<div class="whitefour">';
	 mysql_select_db(coop_item);    
	 
          $OneYearPast = mktime(0, 0, 0, date("m"), date("d"), date("y") -1);
 
          $FormatedDate = date("Y/m/d", $OneYearPast);
               
               $query = "SELECT ci.mark, oi.item_code,   ci.lot_ship, ci.scribd_id, ci.guid  
          FROM item_description id, order_item oi, lot_item li,
           order_header oh, coop_item ci
          WHERE oi.item_id = li.item_id
          AND oi.item_code = id.item_code
          AND li.lot_ship = ci.item_id
          AND oi.header_key = oh.header_id
          AND oh.customer_key = '$customer'
          AND oh.order_date > '2011-06-30'
          group by ci.mark, oi.item_code, ci.lot_ship
                    order by oi.item_code , ci.lot_ship"; 
   
        
          $this->readme = $query;             
         $result = mysql_query($query, $db_conn2);
       $num_results = mysql_num_rows($result);
        $row = mysql_fetch_array($result);
        echo "Number of Lots: $num_results <br>";
        
               
 
     for ($i=0; $i < $num_results;  $i++)  {
	$item_code = $row['item_code'];
	$lot_ship = $row['lot_ship'];
	$mark = $row['mark'];
	$scribd_id = $row['scribd_id'];
	$guid = $row['guid'];
	
	
	 
	
	if ($guid == "") {
	
	$alt_query = "select  item_code, lot_ship,  warehouse, scribd_id, guid
                from coop_item
                where item_code = '$item_code' 
                  and lot_ship = '$lot_ship'
                  and guid != ''";
  $alt_result = mysql_query($alt_query, $db_conn2);
  $alt_num_results = mysql_num_rows($alt_result);
  if ($alt_num_results > 0) {
        $alt_row = mysql_fetch_array($alt_result); 
        	$scribd_id = $alt_row['scribd_id'];
        	$guid = $alt_row['guid']; 
      }              

  }
	
  	
	
	
	
	if ($mark != "" && $guid !="") {
            echo '<a href="../scribd_example4.php?document_id='.$scribd_id.'&rst_id='.$this->rst_id.'&access_key='.$guid.'&program_sw='.$this->program_sw.'&search='.$this->search.'&lot_nbr='.$this->lot_nbr.'&gorp_id='.$this->gorp_id.'"> ';
            
            echo "$item_code $lot_ship - $mark ";
            echo ' </a><br>';
        }
        else {
                echo '<a href="../scribd_example4.php?document_id=447922&rst_id='.$this->rst_id.'&access_key=dp16lee9f98tv&program_sw='.$this->program_sw.'&search='.$this->search.'&lot_nbr='.$this->lot_nbr.'&gorp_id='.$this->gorp_id.'"> ';
             #    echo '<a href="../scribd_example4.php?document_id=447922&rst_id='.$customer.'&access_key=dp16lee9f98tv"> ';
            
            echo "$item_code $lot_ship - $mark ";
            echo ' </a><br>';
           	
        }

   $row = mysql_fetch_array($result);	
	}
	
	 echo "</div>";
# end for loop. 
}
	
}

class myRoasterBox {

    var $myViewMode = 1;
    var $box_size = 5;
    var $box_color = '#EC0000';
    var $level = "";
    var $image = "images/buttonsbig.jpg";

    function myRoasterBox($level){
    	$this->level =$level;
    }

    function setSize($value){
        $this->box_size=$value;
    }
    function setWidth($value) {
        $this->box_width=$value;
    }
    function setImage($value){
        $this->image=$value;
    }
    
    
    function displayAdminList($rst_id,$coop_id) {
    	$levelOfImage =  $this->level;
      echo "Roaster: <br>";
      echo  '<SELECT NAME="roaster"  >';
      echo '<OPTION VALUE="">--Select One --';
 
       echo '<OPTION VALUE="12"';
      if ($rst_id == "12") {
      	 echo "  selected ";
       }
      echo '>Alternative Grounds';
      
       echo '<OPTION VALUE="14"';
      if ($rst_id == "14") {
      	 echo "  selected ";
       }
      echo '>Amavida';      
      
      echo '<OPTION VALUE="8"';
      if ($rst_id == "8") {
      	 echo "  selected ";
       }
      echo '>Bean North';
      
      echo '<OPTION VALUE="7"';
      if ($rst_id == "7") {
      	 echo "  selected ";
       }
      echo '>Bongo Java';
      
      echo '<OPTION VALUE="4"';
      if ($rst_id == "4") {
      	 echo "  selected ";
       }
      echo '>Cafe Campesino';
      
      
      echo '<OPTION VALUE="22"';
      if ($rst_id == "22") {
      	 echo "  selected ";
       }
      echo '>Cloudforest Initiatives'; 
      
      echo '<OPTION VALUE="13"';
      if ($rst_id == "13") {
      	 echo "  selected ";
       }
      echo '>Coffee Exchange';    
      
     echo '<OPTION VALUE="20"';
      if ($rst_id == "20") {
      	 echo "  selected ";
       }
      echo '>Cafe Cambio';     
      
           echo '<OPTION VALUE="21"';
      if ($rst_id == "21") {
      	 echo "  selected ";
       }
      echo '>Cafe Rico';  
      
      
     echo '<OPTION VALUE="18"';
      if ($rst_id == "18") {
      	 echo "  selected ";
       }
      echo '>Conscious Coffees';    
      
      echo '<OPTION VALUE="27"';
      if ($rst_id == "27") {
      	 echo "  selected ";
       }
      echo '>Coutts and Company';  
      
       
           
      echo '<OPTION VALUE="15"';
      if ($rst_id == "15") {
      	 echo "  selected ";
       }
      echo '>Desert Sun';   
      
      echo '<OPTION VALUE="23"';
      if ($rst_id == "23") {
      	 echo "  selected ";
       }
      echo '>Doma Coffee';  
      
      echo '<OPTION VALUE="16"';
      if ($rst_id == "16") {
      	 echo "  selected ";
       }
      echo '>Equator Coffee';                
      
      echo '<OPTION VALUE="9"';
      if ($rst_id == "9") {
      	 echo "  selected ";
       }
      echo '>Heine Brothers';
      
      echo '<OPTION VALUE="5"';
      if ($rst_id == "5") {
      	 echo "  selected ";
       }
      echo '>Higher Grounds';
      
      echo '<OPTION VALUE="10"';
      if ($rst_id == "10") {
      	 echo "  selected ";
       }
      echo '>Just Coffee';
      
       echo '<OPTION VALUE="17"';
      if ($rst_id == "17") {
      	 echo "  selected ";
       }
      echo '>Kickapoo Coffee';    
      
      
     echo '<OPTION VALUE="25"';
      if ($rst_id == "25") {
      	 echo "  selected ";
       }
      echo '>La Tierra Coop'; 
      
      echo '<OPTION VALUE="1"';
      if ($rst_id == "1") {
      	 echo "  selected ";
       }
      echo '>Larry\'s Beans';
     
      
      echo '<OPTION VALUE="3"';
      if ($rst_id == "3") {
      	 echo "  selected ";
       }
      echo '>Peace Coffee';
      
      echo '<OPTION VALUE="28"';
      if ($rst_id == "28") {
      	 echo "  selected ";
       }
      echo '>Santropol';
      
      echo '<OPTION VALUE="26"';
      if ($rst_id == "26") {
      	 echo "  selected ";
       }
      echo '>Sweetwater Organic Coffee';
       
  
      echo '<OPTION VALUE="24"';
      if ($rst_id == "24") {
      	 echo "  selected ";
       }
      echo '>Third Coast Coffee';
      
      
     echo '<OPTION VALUE="19"';
      if ($rst_id == "19") {
      	 echo "  selected ";
       }
      echo '>Vermont Artisan';
      echo '</SELECT> ';    
      
      echo "<p>";
      
      echo "Coop : <br>";
      echo '<SELECT NAME="coop" >';
      echo '<OPTION VALUE="">--Select One --';
      
      echo '<OPTION VALUE="1"';
      if ($coop_id == "1") {
      	echo " selected ";
      }
      echo '>Bolivia - FECAFEB';
      
      echo '<OPTION VALUE="28"';
      if ($coop_id == "28") {
      	echo " selected ";
      }
      echo '>Brazil - Coopervitae';    
      
      echo '<OPTION VALUE="29"';
      if ($coop_id == "29") {
      	echo " selected ";
      }
      echo '>Brazil - Coopfam';     
      
             echo '<OPTION VALUE="34"';
      if ($coop_id == "34") {
      	echo " selected ";
      }
      echo '>DR Congo - SOPACDI/Furaha';   
      

      echo '<OPTION VALUE="32"';
      if ($coop_id == "32") {
      	echo " selected ";
      }
      echo '>Ecuador - Fapecafes';   
           
      
      
      echo '<OPTION VALUE="2"';
      if ($coop_id == "2") {
      	echo " selected ";
      }
      echo '>Fondo Paez - Colombia';
      
      echo '<OPTION VALUE="23"';
      if ($coop_id == "23") {
      	echo " selected ";
      }
      echo '>Ocamonte - Colombia';      
    
       echo '<OPTION VALUE="3"';
      if ($coop_id == "3") {
      	echo " selected ";
      }
      echo '>Mexico - Maya Vinic';
       
       
      echo '<OPTION VALUE="10"';
      if ($coop_id == "10") {
      	echo " selected ";
      }
      echo '>Mexico - Michiza';
    
      echo '<OPTION VALUE="33"';
      if ($coop_id == "33") {
      	echo " selected ";
      }
      echo '>Mexico - RedCafes';
      
            echo '<OPTION VALUE="11"';
      if ($coop_id == "11") {
      	echo " selected ";
      }
      echo '>Mexico - Yachil'; 
        
      echo '<OPTION VALUE="20"';
      if ($coop_id == "20") {
      	echo " selected ";
      }
      echo '>Peru - Cenfrocafe'; 
      
      echo '<OPTION VALUE="4"';
      if ($coop_id == "4") {
      	echo " selected ";
      }
      echo '>Peru - Pangoa ';
      
      echo '<OPTION VALUE="5"';
      if ($coop_id == "5") {
      	echo " selected ";
      }
      echo '>Guatemala -  Chajul';
      
     echo '<OPTION VALUE="25"';
      if ($coop_id == "25") {
      	echo " selected ";
      }
      echo '>Indonesia - KBQB';
      
      echo '<OPTION VALUE="6"';
      if ($coop_id == "6") {
      	echo " selected ";
      }
      echo '>Indonesia - APKO';
      
      
      echo '<OPTION VALUE="7"';
      if ($coop_id == "7") {
      	echo " selected ";
      }
      echo '>East Timor - CCT';
      
      echo '<OPTION VALUE="8"';
      if ($coop_id == "8") {
      	echo " selected ";
      }
      echo '>Dom Republic - FEDECARES';
      
      echo '<OPTION VALUE="9"';
      if ($coop_id == "9") {
      	echo " selected ";
      }
      echo '>Ethiopia - OCFCU';
      
      echo '<OPTION VALUE="30"';
      if ($coop_id == "30") {
      	echo " selected ";
      }
      echo '>Ethiopia - SCFCU';
      
      
      
        echo '<OPTION VALUE="24"';
      if ($coop_id == "24") {
      	echo " selected ";
      }
      echo '>El Salvador - Marias 93';      
      

      
      
      echo '<OPTION VALUE="19"';
      if ($coop_id == "19") {
      	echo " selected ";
      }
      echo '>Guatemala - Apecaform';
      
      
      echo '<OPTION VALUE="14"';
      if ($coop_id == "14") {
      	echo " selected ";
      }
      echo '>Guatemala - Rio Azul';
      
      echo '<OPTION VALUE="15"';
      if ($coop_id == "15") {
      	echo " selected ";
      }
      echo '>Guatemala - CCDA';
      
      echo '<OPTION VALUE="31"';
      if ($coop_id == "31") {
      	echo " selected ";
      }
      echo '>Honduras - COPROCAEL';
      
      echo '<OPTION VALUE="16"';
      if ($coop_id == "16") {
      	echo " selected ";
      }
      echo '>Nicaragua - CECOCAFEN';
      
      echo '<OPTION VALUE="17"';
      if ($coop_id == "17") {
      	echo " selected ";
      }
      echo '>Nicaragua - La Fem';
      
 
      
      echo '<OPTION VALUE="27"';
      if ($coop_id == "27") {
      	echo " selected ";
      }
      echo '>Tanzania - KNCU';
      
    
      echo '<OPTION VALUE="26"';
      if ($coop_id == "26") {
      	echo " selected ";
      }
      echo '>Uganda - Gumutindo';
      
      
      echo '</SELECT> ';
      
      
}    
    

    function displayList() {
    	$levelOfImage =  $this->level;
    	      echo  '<SELECT NAME="roaster" onChange="nav(this)">';
      echo '<OPTION VALUE="index.php">--Select One --</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'alternative-grounds/index.php?rst_id=12">Alternative Grounds</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'amavida/index.php?rst_id=14">Amavida</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'bean-north/index.php?rst_id=8">Bean North</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'bongo-java/index.php?rst_id=7">Bongo Java</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'cafe-campesino/index.php?rst_id=4">Cafe Campesino</option>'; 
      echo '<OPTION VALUE="'.$levelOfImage.'cafe-cambio/index.php?rst_id=20">Cafe Cambio</option>'; 
      echo '<OPTION VALUE="'.$levelOfImage.'cafe-rico/index.php?rst_id=21">Cafe Rico</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'cloudforest-initiatives/index.php?rst_id=22">Cloudforest Initiatives</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'coffee-exchange/index.php?rst_id=13">Coffee Exchange</option>';  
      echo '<OPTION VALUE="'.$levelOfImage.'conscious-coffees/index.php?rst_id=18">Conscious Coffees</option>';  
      echo '<OPTION VALUE="'.$levelOfImage.'coutts-company/index.php?rst_id=27">Coutts Company</option>'; 
      echo '<OPTION VALUE="'.$levelOfImage.'desert-sun/index.php?rst_id=15">Desert Sun Coffee</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'doma-coffee/index.php?rst_id=23">Doma Coffee</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'equator-coffee/index.php?rst_id=16">Equator Coffee</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'heine-brothers/index.php?rst_id=9">Heine Brothers</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'higher-grounds/index.php?rst_id=5">Higher Grounds</option>';  
      echo '<OPTION VALUE="'.$levelOfImage.'just-coffee/index.php?rst_id=10">Just Coffee</option>';  
      echo '<OPTION VALUE="'.$levelOfImage.'kickapoo-coffee/index.php?rst_id=17">Kickapoo Coffee</option>'; 
      echo '<OPTION VALUE="'.$levelOfImage.'la-tierra-coop/index.php?rst_id=25">La Tierra Coop</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'larrys-beans/index.php?rst_id=1">Larry'."'".'s Beans</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'peace-coffee/index.php?rst_id=3">Peace Coffee</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'santropol/index.php?rst_id=28">Santropol</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'sweet_water/index.php?rst_id=26">Sweetwater Organic Coffee</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'third-coast-coffee/index.php?rst_id=24">Third Coast Coffee</option>';
      echo '<OPTION VALUE="'.$levelOfImage.'vermont-artisan/index.php?rst_id=19">Vermont Artisan</option>';
      echo '</SELECT> ';
}

 

    function displayBox(){
   	$levelOfImage =  $this->level;
   	$image = $this->image;
    #  echo '<img src="'.$levelOfImage.' echo '<img src="'.$levelOfImage.$this->image.">';>';
       echo '<img src="'.$levelOfImage.$this->image.'">';
     # echo '<img src="images/buttonsbig.jpg">';
      echo '<br>';
      $this->displayList();                
    }

}

class myCoopBox {

    var $myViewMode = 1;
    var $box_size = 5;
    var $box_color = '#EC0000';
    var $level = '';
    var $image = "images/buttonsbig2.jpg";

    function myCoopBox($level){
    	$this->level =$level;
    }

    function setSize($value){
        $this->box_size=$value;
    }
    function setWidth($value) {
        $this->box_width=$value;
    }
    function setImage($value){
        $this->image=$value;
    }



    function displayBox(){
     	$levelOfImage =$this->level;
     	$image = $this->image;
       echo '<img src="'.$levelOfImage.$image.'">';
    #echo '<img src="images/buttonsbig2.jpg">';
      echo '<br>';


      echo '<SELECT NAME="coop" onChange="nav(this)">';
      echo '<OPTION VALUE="index.php">--Select One --';
      echo '<OPTION VALUE="'.$levelOfImage.'fecafeb-bolivia/index.php?coop_id=1">Bolivia - FECAFEB';
      echo '<OPTION VALUE="'.$levelOfImage.'coopervitae-brazil/index.php?coop_id=28">Brazil - Coopervitae';
      echo '<OPTION VALUE="'.$levelOfImage.'coopfam-brazil/index.php?coop_id=29">Brazil - Coopfam';
      echo '<OPTION VALUE="'.$levelOfImage.'fondo-paez-colombia/index.php?coop_id=2">Colombia - Fondo Paez';
      echo '<OPTION VALUE="'.$levelOfImage.'ocamonte-colombia/index.php?coop_id=23">Colombia - Ocamonte';
      echo '<OPTION VALUE="'.$levelOfImage.'fedecares-dom-republic/index.php?coop_id=8">Dom Republic - FEDECARES';      
      echo '<OPTION VALUE="'.$levelOfImage.'sopacdi-furaha-dr-congo/index.php?coop_id=8">DR Congo - SOPACDI/Furaha';
      echo '<OPTION VALUE="'.$levelOfImage.'cct-east-timor/index.php?coop_id=7">East Timor - CCT';
      echo '<OPTION VALUE="'.$levelOfImage.'fapecafes-ecuador/index.php?coop_id=32">Ecuador - Fapecafes';
      echo '<OPTION VALUE="'.$levelOfImage.'marias-93-el-salvador/index.php?coop_id=24">El Salvador - Marias 93';
      echo '<OPTION VALUE="'.$levelOfImage.'ocfcu-ethiopia/index.php?coop_id=9">Ethiopia - OCFCU';
      echo '<OPTION VALUE="'.$levelOfImage.'scfcu-ethiopia/index.php?coop_id=30">Ethiopia - SCFCU';
      echo '<OPTION VALUE="'.$levelOfImage.'apecaform-guatemala/index.php?coop_id=19">Guatemala - Apecaform';        
      echo '<OPTION VALUE="'.$levelOfImage.'chajul-guatemala/index.php?coop_id=5">Guatemala -  Chajul'; 
      echo '<OPTION VALUE="'.$levelOfImage.'rio-azul-guatemala/index.php?coop_id=14">Guatemala - Rio Azul';
      echo '<OPTION VALUE="'.$levelOfImage.'ccda-guatemala/index.php?coop_id=15">Guatemala - CCDA';
      echo '<OPTION VALUE="'.$levelOfImage.'coprocael-honduras/index.php?coop_id=31">Honduras - COPROCAEL';
      echo '<OPTION VALUE="'.$levelOfImage.'apko-indonesia/index.php?coop_id=6">Indonesia - APKO';
      echo '<OPTION VALUE="'.$levelOfImage.'KBQB-Indonesia/index.php?coop_id=25">Indonesia - KBQB';
      echo '<OPTION VALUE="'.$levelOfImage.'maya-vinic-mexico/index.php?coop_id=3">Mexico - Maya Vinic'; 
      echo '<OPTION VALUE="'.$levelOfImage.'michiza-mexico/index.php?coop_id=10">Mexico - Michiza'; 
      echo '<OPTION VALUE="'.$levelOfImage.'red-cafes-mexico/index.php?coop_id=33">Mexico - RedCafes'; 
      echo '<OPTION VALUE="'.$levelOfImage.'yachil-mexico/index.php?coop_id=11">Mexico - Yachil';
      echo '<OPTION VALUE="'.$levelOfImage.'cecocafen-nicaragua/index.php?coop_id=16">Nicaragua - CECOCAFEN';
      echo '<OPTION VALUE="'.$levelOfImage.'la-fem-nicaragua/index.php?coop_id=17">Nicaragua - La Fem';
      echo '<OPTION VALUE="'.$levelOfImage.'cenfrocafe-peru/index.php?coop_id=20">Peru - Cenfrocafe';   
      echo '<OPTION VALUE="'.$levelOfImage.'pangoa-peru/index.php?coop_id=4">Peru - Pangoa';   
      echo '<OPTION VALUE="'.$levelOfImage.'kncu-tanzania/index.php?coop_id=27">Tanzania - KNCU';
      echo '<OPTION VALUE="'.$levelOfImage.'gumutindo-uganda/index.php?coop_id=26">Uganda - Gumutindo';
      
      echo '</SELECT> ';
        
    }
        
}


 ?>