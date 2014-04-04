<?php
 require("../phpclasses.php");
 

function SetCoopId($rst_id) {
   	    global $db_conn;
   	
   	    if ( $rst_id <> "") {
   	    	
   	    	mysql_select_db('trf_roaster_content');


               $query = "select * 
                         from trf_roaster_content
                         where ft_id =  $rst_id;";

                # retrieve information:
                $result = mysql_query($query, $db_conn);
                $num_results = mysql_num_rows($result);


                # prepare to extract
                $row = mysql_fetch_array($result);
                $coop_id = $row['coop_id'];
                                
        }
        return $coop_id;
}

 function BuildBlendDD($rst_id,$ddName) {
	global $db_conn2;
	
	$BlendDropDown = "<SELECT NAME='$ddName'  >";
	$BlendDropDown =  $BlendDropDown."\n";
	
	 mysql_select_db(coop_item);    
	 
          $OneYearPast = mktime(0, 0, 0, date("m"), date("d"), date("y") -1);
 
          $FormatedDate = date("Y/m/d", $OneYearPast);
               
          $query = "SELECT ci.item_code 
                 FROM item_description id, order_item oi, lot_item li,
                  order_header oh, coop_item ci
                 WHERE oi.item_id = li.item_id
                 AND oi.item_code = id.item_code
                 AND li.lot_ship = ci.item_id
                 AND oi.header_key = oh.header_id
                 AND oh.customer_key = '$rst_id'
                 AND oh.order_date > '2007/07/01'
                 group by ci.item_code 
                    order by oi.item_code"; 
                   
        $result = mysql_query($query, $db_conn2);
        $num_results = mysql_num_rows($result);
        $row = mysql_fetch_array($result);
        
        $BlendDropDown =  $BlendDropDown.'<OPTION VALUE="">--Select One --';
        $BlendDropDown =  $BlendDropDown."\n";

     for ($i=0; $i < $num_results;  $i++)  {
	$item_code = $row['item_code'];
	
	$BlendDropDown =  $BlendDropDown."<OPTION VALUE='$item_code'>".$item_code;
	$BlendDropDown =  $BlendDropDown."\n";
        $row = mysql_fetch_array($result);	
	}
	
	$BlendDropDown =  $BlendDropDown.'</SELECT> ';
	$BlendDropDown =  $BlendDropDown."\n";
	return $BlendDropDown;

}
 
function BuildRoasterDD($rst_id,$ddName) {
	global $db_conn2;
	
	$RoasterDropDown = "<SELECT NAME='$ddName'  >";
	$RoasterDropDown =  $RoasterDropDown."\n";
	
	 mysql_select_db(coop_item);    
	 
          $OneYearPast = mktime(0, 0, 0, date("m"), date("d"), date("y") -1);
 
          $FormatedDate = date("Y/m/d", $OneYearPast);
               
          $query = "SELECT ci.item_id, ci.mark, ci.item_code,   ci.lot_ship, ci.scribd_id, ci.guid  
                 FROM item_description id, order_item oi, lot_item li,
                  order_header oh, coop_item ci
                 WHERE oi.item_id = li.item_id
                 AND oi.item_code = id.item_code
                 AND li.lot_ship = ci.item_id
                 AND oi.header_key = oh.header_id
                 AND oh.customer_key = '$rst_id'
                 AND oh.order_date > '2007/07/01'
                 group by ci.mark, oi.item_code, ci.lot_ship
                    order by oi.item_code , ci.lot_ship"; 
                   
        $result = mysql_query($query, $db_conn2);
        $num_results = mysql_num_rows($result);
        $row = mysql_fetch_array($result);
        
        $RoasterDropDown =  $RoasterDropDown.'<OPTION VALUE="">--Select One --';
        $RoasterDropDown =  $RoasterDropDown."\n";

     for ($i=0; $i < $num_results;  $i++)  {
     	$item_id = $row['item_id'];
	$item = $row['item_id'];
	$item_code = $row['item_code'];
	$lot_ship = $row['lot_ship'];
	$mark = $row['mark'];
	$scribd_id = $row['scribd_id'];
	$guid = $row['guid'];
	
	$RoasterDropDown =  $RoasterDropDown."<OPTION VALUE='$item_id'>".$item_code."-".$lot_ship." ".$mark;
	$RoasterDropDown =  $RoasterDropDown."\n";
        $row = mysql_fetch_array($result);	
	}
	
	$RoasterDropDown =  $RoasterDropDown.'</SELECT> ';
	$RoasterDropDown =  $RoasterDropDown."\n";
	return $RoasterDropDown;

}


 class ImageUpload {
 	
 	var $directory = "";
 	
    function ImageUpload($directory){
    	$this->directory =$directory;
    	 $this->SetHiddenFields();
    }
    
    function SetHiddenFields(){
    	 echo ' <input type="hidden" name="MAX_FILE_SIZE" value="300000" /><br>';
    	 echo "\n";
         echo ' <input name="userfile" type="file" /><br>';
         echo "\n";
         echo ' <input type="submit" name="upload" value="Upload Image" /><br>';
         echo "\n";
    }
    
    function SetDirectory($directory) {
    	$this->directory = $directory;
    }
    
    function EchoDirectory() {
    	echo 'directory is now set to '.$this->directory;
    	echo "<p>";
    }
    
    function DoUpload() {
    	
    	echo $this->directory;

    	$uploadfile = $this->directory.$_FILES['userfile']['name'];
    	
    	
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                print "<br>File is valid, and was successfully uploaded. ";

                if (! chmod($uploadfile, 0544)) {
                    echo  ("<br>Unable to change file permissions");
                }
            } 
            elseif ($_FILES['userfile']['error'] != 4 ) {
                print "Possible file upload attack!  Here's some debugging info:\n";
                echo "<br>";
                print_r($_FILES);
            }
 
    }
 	
 	
}
 
class myNav {

    var $myViewMode = 1;
    var $box_size = 5;
    var $box_color = '#EC0000';
    var $level = "";
    var $image = "images/buttonsbig2.jpg";
    var $rst_id = "";
    var $coop_id = "";
    var $directory = "";
    var $photo1;
    var $photo2;
    var $photo1_caption;
    var $photo2_caption;

    function myNav($security){
    	$this->level =$security;
    }
    
   function setRstId($value){
        $this->rst_id = $value;
    }
    
       function setCoopId($value){
        $this->coop_id = $value;
    }



   function displayRoasterForm($type,$rst_id) {
   	    global $db_conn;
   	
   	    if ($type == "roaster" && $rst_id <> "") {
   	    	
   	    	mysql_select_db('trf_roaster_content');


               $query = "select * 
                         from trf_roaster_content
                         where ft_id =  $rst_id;";

                # retrieve information:
                $result = mysql_query($query, $db_conn);
                $num_results = mysql_num_rows($result);


                # prepare to extract
                $row = mysql_fetch_array($result);
                $roaster_name = $row['roaster_name'];
                $contact = $row['contact'];
                $content = $row['content'];
                $link_to_site = $row['link_to_site'];
                $organic_cert_link = $row['organic_cert_link'];
                $partner_since = $row['partner_since'];
                $coop_id = $row['coop_id'];
                $scribd_id = $row['scribd_id'];
                $guid = $row['guid'];
                $directory = $row['directory'];
                $address1 = $row['address1'];
                $address2 = $row['address2'];
                $city = $row['city'];
                $state = $row['state'];
                $zip = $row['zip'];
                $country = $row['country'];
                $telephone = $row['telephone'];
                $email = $row['email'];
                $section_1 = $row['section_1'];
                $section_2 = $row['section_2'];
                $section_3 = $row['section_3'];
                $section_4 = $row['section_4'];
                $this->directory = $row['directory'];
                $this->photo1 = $row['photo1'];
                $this->photo2 = $row['photo2'];
                $this->photo1_caption = $row['photo1_caption'];
                $this->photo2_caption = $row['photo2_caption'];
                
               # echo "setting the directory ";
              # echo $row['directory'];
                $program_sw = $row['program_sw'];
        }
 

   	       echo "<input type=hidden name='hidden_rst_id' value='$rst_id'>";	

               
               
               echo "<table>";
               
               echo "<tr><td valign='top'>";
 
               echo "Address 1: ";
               echo "<br>";
               echo '<input type=text name=address1 size=50 value="';
               echo $address1;
               echo '">';
               echo "<br>";
               
               echo "Address 2: ";
               echo "<br>";
               echo '<input type=text name=address2 size=50 value="';
               echo $address2;
               echo '">';
               echo "<br>";

               echo "City: ";
               echo "<br>";
               echo '<input type=text name=city size=50 value="';
               echo $city;
               echo '">';
               echo "<br>";

               echo "State / Zip: ";
               echo "<br>";
               echo '<input type=text name=state size=5 value="';
               echo $state;
               echo '">,  ';               
               echo '<input type=text name=zip size=10 value="';
               echo $zip;
               echo '">';
               echo "<br> ";
               
               echo "Country: ";
               echo "<br>";
               echo '<input type=text name=country size=50 value="';
               echo $country;
               echo '">';
               echo "<br>";    
               
               echo "Telephone: ";
               echo "<br>";
               echo '<input type=text name=telephone size=25 value="';
               echo $telephone;
               echo '">';
               echo "<br>";                
               
               echo "Email: ";
               echo "<br>";
               echo '<input type=text name=email size=50 value="';
               echo $email;
               echo '">';
               echo "<br>"; 
               
               echo "</td><td>";
   	       echo "<table>";
   	       echo '<tr><td>';
   	       echo '<INPUT TYPE="SUBMIT" id="update" name="update" VALUE="Update" class="ccbtn"> ';
   	   
   	        
               echo "Roaster Name ";
               echo "</td><td>";
               echo '<input type=text name=roaster_name size=40 value="';
               echo $roaster_name;
               echo '">';
               echo "</td></tr>";
               
               echo "<tr><td>";
               echo "Program Switch: ";
               echo "</td><td>";
               
               /*
               echo '<input type="checkbox" name="program_sw" ';
               if ($program_sw == 'Y') {
               	   echo " checked ";
               }
               */
                echo '<SELECT NAME="program_sw">';
               echo '<OPTION VALUE="N" ';
               if ($program_sw == 'N') {
               	   echo " selected ";
               }
               echo '>No Program ';
               echo '<OPTION VALUE="Y" ';
               if ($program_sw == 'Y') {
               	   echo " selected ";
               }
               echo '>Custom Program';
               echo '<OPTION VALUE="A" ';
               if ($program_sw == 'A') {
               	   echo " selected ";
               }
               echo '>Blend Program';
               echo '</SELECT>';

               echo "</td></tr>";               
               
               echo "<tr><td>";
               echo "Link to Site: ";
               echo "</td><td>Do not put http:// in link.<br>";
               echo '<input type=text name=link_to_site size=40 value="';
               echo $link_to_site;
               echo '"> ';
               echo "</td></tr>";
               
               echo "<tr><td>";
               echo "Member Since: ";
               echo "</td><td>";
               echo '<input type=text name=partner_since size=40 value="';
               echo $partner_since;
               echo '">';
               echo "</td></tr>";  
               
               
               echo "<tr><td>";
               echo "Organic Cert: ";
               echo "</td><td>";
               echo '<input type=text name=organic_cert_link size=40 value="';
               echo $organic_cert_link;
               echo '">';
               echo "</td></tr>";   
               
               echo "<tr><td>";
               echo "Scribd ID: ";
               echo "</td><td>";
               echo '<input type=text name=scribd_id size=40 value="';
               echo $scribd_id;
               echo '">';
               echo "</td></tr>";   
               
               echo "<tr><td>";
               echo "GUID: ";
               echo "</td><td>";
               echo '<input type=text name=guid size=40 value="';
               echo $guid;
               echo '">';
               echo "</td></tr>";                              
               
               echo "<tr><td>";
               echo "Directory: ";
               echo "</td><td>";
               echo '<input type=text name=directory disabled size=40 value="';
               echo $directory;
               echo '">';
               echo "</td></tr>";                 
                                           
               
       
               echo "<tr><td>";
               echo "Coop ID: ";
               echo "</td><td>";
               customerdropdown($coop_id);
               echo "</td></tr>";
               
                            
               echo "</table>";
               
   
               echo "</td></tr>";
               
               
       # start
                       echo "<tr><td valign='top'>";
                echo "Paragraph 1:<br>";
               echo '<textarea name="section_1" type="text" maxlength="255" id="content"  style="height:250px;width:350px;">';
               echo $section_1;
               echo '</textarea><br>';  
               
               echo "</td><td valign='top'>";

               
               echo "Paragraph 2:<br>";
               echo '<textarea name="section_2" type="text" maxlength="255" id="content"  style="height:250px;width:350px;">';
               echo $section_2;
               echo '</textarea><br>';  
                  
               echo "</td></tr>";
               
                                      echo "<tr><td valign='top'>";
                echo "Paragraph 3:<br>";
               echo '<textarea name="section_3" type="text" maxlength="255" id="content"  style="height:250px;width:350px;">';
               echo $section_3;
               echo '</textarea><br>';  
               
               echo "</td><td valign='top'>";

               
               echo "Paragraph 4:<br>";
               echo '<textarea name="section_4" type="text" maxlength="255" id="content"  style="height:250px;width:350px;">';
               echo $section_4;
               echo '</textarea><br>';  
               
        
               echo "</td></tr>";
               echo "<tr>";
               
               echo "<td>";
               echo "photo one and caption";
               
               $image_directory = "../".$this->directory."/images/"; 
             #  echo "directory is $image_directory";
               
              
               $dir_handle = @opendir($image_directory) or die("Unable to open $image_directory");
               $dd_image1 = "\n";
               $dd_image2 = "\n";
               
                
               $dd_image1 .= '<br><select name="photo1">';
               $dd_image1 .= '<br><option value="">none';   
   
               $dd_image2 .= '<select name="photo2">';
               $dd_image2 .= '><option value="">none';
 
while ($file = readdir($dir_handle))  {
	
   if($file!="." && $file!="..") {
 
     $dd_image1 .= '<option value="'.$file.'"  ';
     if ($this->photo1 == $file)
      {
         $dd_image1 .=  ' selected ';
      }
      $dd_image1 .=  ' >'.$file;
      $dd_image1 .=  "\n";
      
     $dd_image2 .= '<option value="'.$file.'"  ';
     if ($this->photo2 == $file)
      {
         $dd_image2 .=  ' selected ';
      }
      $dd_image2 .=  ' >'.$file;
      $dd_image2 .=  "\n";      
   	
   }    
}
   $dd_image1 .= "</select>"; 	
   $dd_image2 .= "</select>";
   echo $dd_image1;
   echo "\n";
                echo "<br>Caption for Photo one:<br> ";
               echo '<input type=text name=photo1_caption size=40 value="';
               echo $this->photo1_caption;
               echo '">';
   
                  
               echo "</td>";
               echo "<td>";
               echo "photo two and caption<br>";
               echo $dd_image2;
               echo "<br>Caption for Photo two:<br> ";
               echo '<input type=text name=photo2_caption size=40 value="';
               echo $this->photo2_caption;
               echo '">';
   
               echo "</td>";
               echo "<tr>";
        
       # end        
               
               
               echo "</table>";      
         
 
               
   	
   	
}





    function displayLogin($level) {
    	 
    	      
    	   if ($_GET['logout'] == "yes" ) {
 	        $level="";
           }
    	      
    	     if ($level == "") {
    	     echo "<table><tr><td>"; 	
    	     echo 'Login ID:<br><input type="text" name="userid" size="20" style="font-family: Verdana; font-size: 10px; color: #228B22; background-color: #FFFF44; border: 1 solid #228B22" value="User Name">';
            echo '</td></tr><tr><td> Password:<br>';
            echo '<input type="password" name="password" size="20" style="font-family: Verdana; font-size: 10px; color: #228B22; background-color: FFFF44; border: 1 solid #228B22" value="Password">';
            echo '</td></tr><tr><td>';
            echo '<input type="submit" value="Login" name="login" style="font-family: Verdana; font-size: 10px; color: #000000; background-color: #FFFFCC; border: 4 solid #228B22">&nbsp;&nbsp;&nbsp;&nbsp;';
            echo '<input type="reset" value="Reset" name="reset" style="font-family: Verdana; font-size: 10px; color: #000000; background-color: #FFFFCC; border: 4 solid #228B22">';
            echo "</td></tr></table>";
        }
            elseif ($level == '2') {
            	echo "<h3>Steps to set up Coop or Roaster</h3>";
            	echo "<ul>";
            	echo "<li>Create Directory for new coop or roaster";
            	echo "<li>Set up Index.php in this new directory.";
            	echo "</ul>";
            	echo "<br>";
                 $RoasterBox = new myRoasterBox("");
                 echo "<br>";
                 $RoasterBox->displayAdminList($this->rst_id, $this->coop_id);
                 echo '<INPUT TYPE="SUBMIT" name="SetBtn" value="Set"><br>';
        }
            elseif ($level == '1') {
            	echo "<br>";
                echo "You are now logged in.";
        }
        else {
        	Echo "You are now logged in.";
        }


}


    function displayNav() {
     	  $security =$this->level;
     	 # echo  "<br> Level is $this->level <br> ";
        echo "<div class='float'>";  
        echo "<br>";
        
      	echo "<ul id='nav'>";
      	echo "<br>";
        echo "<li id='t-home'><a href='index.php'>&nbsp;&nbsp;Home&nbsp;&nbsp;</a><p>&nbsp;<p></li>";

      

        if ($this->level == "1" || $this->level == "2" ) {
            if ($this->rst_id != "") {
	              echo "<li id='t-lot'><a href='lot_maint.php'> Lot Maint </a><p>&nbsp;<p></li>";
	              echo "<li id='t-blend'><a href='blend_maint.php'> Blend Maint </a><p>&nbsp;<p></li>";
	              echo "<li id='t-roaster'><a href='roaster_maint.php'> Roaster Maint </a><p>&nbsp;<p></li>";
	            }
	    
	          if ($this->coop_id != "" && $this->level == "2") {
	               echo "<li id='t-coop'><a href='coop_maint.php'> Coop Maint </a><p>&nbsp;<p></li>";
	          }
	          
	          if ( $this->level == "2") {
	               echo "<li id='t-coop'><a href='edit_what.php'> Edit Transparent Document </a><p>&nbsp;<p></li>";
	          }	          
	    
	          echo "<li id='t-logout'><a href='index.php?logout=yes' >&nbsp;&nbsp;Logout&nbsp;&nbsp;</a><p>&nbsp;<p></li>";
	    
	           #echo "<li id='t-login'><a href='index.php' >&nbsp;&nbsp;Login&nbsp;&nbsp;</a><p>&nbsp;<p></li>";
         }
	       echo "</ul>";	 
	

        echo "</div>";
        
    }
        
}


 ?>