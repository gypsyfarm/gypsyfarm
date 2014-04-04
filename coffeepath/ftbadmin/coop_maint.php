<?php

 session_start();
 
  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coffeepath.com/ftbadmin/index.php");
  }
  
require("../connection.php"); 
  

 
$trace1 = $_POST['trace1'];
$update = $_POST['update'];
 
 
 #$coop_id = 2;
 

$coop_id = $_SESSION['coop_id'];

  
$test = "Just before update button check: $update using key $coop_id "; 

$Coop = "";
if ($update == 'Update') {
  $test = "The update button was pushed";
  
         $coop_name = $_POST['coop_name'];
         $contact = addslashes($_POST['contact']);	
         $content = addslashes($_POST['content']);
         $scribd_id = $_POST['scribd_id'];
         $guid = $_POST['guid'];
        # $directory = $_POST['directory'];
         $link_to_site = $_POST['link_to_site'];
         $item_code = $_POST['item_code'];

  
  	 mysql_select_db('trf_coop_content');

      $query = " update trf_coop_content 
                    set coop_name =  '$coop_name', 
                        contact = '$contact',
                        content = '$content',
                        link_to_site = '$link_to_site',
                        item_code = '$item_code',
                        scribd_id = '$scribd_id',
                        guid = '$guid'  
                where coop_id =  '$coop_id';";
                
      $query_string = $query;          
      $update_lot = mysql_query($query, $db_conn);
      
    
}	



mysql_select_db('trf_coop_content');


  $query = "select * 
            from trf_coop_content
             where coop_id =  '$coop_id';";


#  echo '<br>'.$query.'<br>';

# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);
 $coop_name = $row['coop_name'];
 $contact = $row['contact'];
 $content = $row['content'];
 $directory = $row['directory'];
 $link_to_site = $row['link_to_site'];
 $item_code = $row['item_code'];
 $scribd_id = $row['scribd_id'];
 $guid = $row['guid'];

 
?>


 
<HTML>
<HEAD>
    <TITLE>Coop Maint page</TITLE>
  
<meta name="description" content="Fair Trade Proof is maintained by Cooperative Coffees">

<meta name="keywords" content="freetrade, cooperative coffees ">

  

<link rel="stylesheet" type="text/css" href="default.css">

<style>
#input_box1 { background-color:yellow; }
#input_box2 { background-color:yellow; }
</style>

</HEAD>
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec" background="images/bg.gif" bgproperties="fixed">


<center>
<?php

echo "<form name=frmMain method=post action='coop_maint.php'>";

?>
<table width=100%>
<tr>
<td>
 <div class="grey_heading2">
FAIR TRADE PROOF
 </div> 
 </td>
<td>
 
&nbsp;
 </td>
 <td>
&nbsp;
 </td>
 <td>
 <div class="corners">
 Our black background minimizes <br>energy, reducing climate change
 <p>
  </div>
  <div class="corners">
  Fair Trade Proof is maintained by Cooperative Coffees 
</div>
 </td>
 </tr>
 </table>
 <p>
 
 
<hr>
 
  
 
 <div class="whiteone">
<?php 

if (isset($trace2)) {
  $type = 'Coop';
}
 
echo "</div>";


 
?>  
 
<div class="float">  
  	  <ul id="nav">
		<li id="t-home"><a href="index.php">&nbsp;&nbsp;Home&nbsp;&nbsp;</a><p>&nbsp;<p></li>
		<li id="t-coop"><a href="coop_maint.php"> Coop Maint </a><p>&nbsp;<p></li>

	</ul>

  </div>
 
              <?php
               echo "<table><tr>";
               
                     echo "<td colspan=2>";  	       
   	       echo '<INPUT TYPE="SUBMIT" id="update" name="update" VALUE="Update" class="ccbtn"> ';
   	       echo "</td>";
   	       
   	       echo "</tr><tr>";
               echo "<td>";
               echo "Coop Name ";
               echo "</td><td>";
               echo '<input type=text name=coop_name size=40 value="';
               echo $coop_name;
               echo '">';
               echo "</td>";
               
               echo "</tr>";
               echo "<tr>";
               
               echo "<td>";
               echo "Directory (Do Not Change unless Authorized)";
               echo "</td><td>";
               echo '<input disabled type=text name=directory size=40 value="';
               echo $directory;
               echo '">';
               echo "</td>";
               
               echo "</tr>";
               echo "<tr>";
               
               echo "<td>";
               echo "Link to Site ";
               echo "</td><td>";
               echo '<input type=text name=link_to_site size=40 value="';
               echo $link_to_site;
               echo '">';
               echo "</td>";  
               
               echo "</tr>";
               
               
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
               
               
               
               
               
               echo "<tr>";
               
               echo "<td>";
               echo "Item Codes ";
               echo "</td><td>";
               echo '<input type=text name=item_code size=50 value="';
               echo $item_code;
               echo '">';
               echo "</td>";                             
               
               
               echo "</tr></table>";
               
               echo "<table><tr><td valign='top'>";              
               echo "Contact:";
               echo "</td><td>";
               echo '<textarea name="contact" type="text"  id="contact"  style="height:250px;width:350px;">';
               echo $contact;
               echo '</textarea>';
               
               echo "</td><td  VALIGN='top'>";
               echo "Content:";
               echo "</td><td>";
               echo '<textarea name="content" type="text"  id="content"  style="height:250px;width:350px;">';
               echo $content;
               echo '</textarea>'; 
               
                echo "</td></tr>";             
               echo "</table>"; 
               
               
              ?>   

  





 
 

</form>
</BODY>
</HTML>
