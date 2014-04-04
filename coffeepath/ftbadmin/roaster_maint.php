<?php
 
session_start();

  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
  header("Location: http://www.coopcoffeesbeans.com/coffeepath/ftbadmin/index.php");
  }
  
require("../connection.php"); 
 

 
# require("LogInFunctions.php");
  require("phpclasses.php");


 
$trace1 = $_POST['trace1'];
$update = $_POST['update'];

$roaster =  $_GET['roaster'];
$roaster_hidden =  $_POST['hidden_rst_id'];
 
$rst_id = $_SESSION['rst_id'];
 
$readme = "roaster = $roaster, roaster_hidden = $roaster_hidden, rst_id = $rst_id <br>";
$Coop = "";
if ($update == 'Update' && strlen($rst_id) > 0) {
  
         $roaster_name = $_POST['roaster_name'];
         $link_to_site = $_POST['link_to_site'];
         $organic_cert_link = $_POST['organic_cert_link'];
         $partner_since = $_POST['partner_since'];
         $coop_id = $_POST['coop_id'];
         $directory = $_POST['directory'];
         $program_sw = $_POST['program_sw'];
         $scribd_id = $_POST['scribd_id'];
         $guid = $_POST['guid'];
         $address1 = $_POST['address1'];
         $address2 = $_POST['address2'];
         $city = $_POST['city'];
         $state = $_POST['state'];
         $zip = $_POST['zip'];
         $country = $_POST['country'];
         $telephone = $_POST['telephone'];
         $email = $_POST['email'];
         $section_1 = mysql_real_escape_string($_POST['section_1']);
         $section_2 = mysql_real_escape_string($_POST['section_2']);
         $section_3 = mysql_real_escape_string($_POST['section_3']);
         $section_4 = mysql_real_escape_string($_POST['section_4']);
         $photo1 = $_POST['photo1'];
         $photo2 = $_POST['photo2'];
         $photo1_caption = $_POST['photo1_caption'];
         $photo2_caption = $_POST['photo2_caption'];

        
  	 mysql_select_db('trf_roaster_content');

      $query = " update trf_roaster_content 
                    set roaster_name =  '$roaster_name', 
                        link_to_site = '$link_to_site',
                        organic_cert_link = '$organic_cert_link',
                        partner_since = '$partner_since',
                        program_sw = '$program_sw',
                        scribd_id = '$scribd_id',
                        guid = '$guid',
                        address1 =  '$address1',
                        address2 =  '$address2',
                        city =  '$city',
                        state =  '$state',
                        zip =  '$zip',
                        country =  '$country',
                        telephone =  '$telephone',
                        email =  '$email',
                        section_1 =  '$section_1',
                        section_2 =  '$section_2',
                        section_3 =  '$section_3',
                        section_4 =  '$section_4',
                        photo1 = '$photo1', 
                        photo2 = '$photo2',
                        photo1_caption  = '$photo1_caption',
                        photo2_caption  = '$photo2_caption'                                                
                where ft_id =  $rst_id;";
           
     #echo "<br>$query <br>";           
                
      $update_lot = mysql_query($query, $db_conn);
      
    
}	

# $rst_id = $_SESSION['rst_id'];
$readme = $readme." now rst_id = $rst_id <br>";
if (strlen($rst_id)) {
   mysql_select_db('trf_roaster_content');
  
 # $rst_id = "1";
  $query = "select * 
            from trf_roaster_content
             where ft_id =  $rst_id;";

 $debug = $query;
 

# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);
 $roaster_name = $row['roaster_name'];
 $link_to_site = $row['link_to_site'];
 $organic_cert_link = $row['organic_cert_link'];
 $partner_since = $row['partner_since'];
 $coop_id = $row['coop_id'];
 $directory = $row['directory'];
 $scribd_id  = $row['scribd_id'];
 $guid   = $row['guid '];
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
 $photo1 = $row['photo1'];
 $photo2 = $row['photo2'];
 $photo1_caption = $row['photo1_caption'];
 $photo2_caption = $row['photo2_caption'];


}

function customerdropdown($company = "")
	{


   $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
   mysql_select_db('cbeans', $db_conn);

   if (!$db_conn)
   {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
   }


 //mysql_select_db('coop_contact');
  	echo  " \n ";
   global $tbl_coop_contact;
   $query = "SELECT * From coop_contact where type='C'order by Company";

	$ddresults = mysql_query($query, $db_conn);
    if (!$ddresults)
    { echo "too bad too sad"; }

	$ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   echo '<select name="coop_id">';
   echo '<br><option value="">';
   echo "\n";
      for ($i=0; $i <$ddnum_results; $i++)
 {
      echo '<option value="'.$ddrow['contact_id'].'"  ';
      if ($company == $ddrow['contact_id'])
      {
         echo ' selected ';
      }
      echo ' >'.$ddrow['Company'];
      echo "\n";


   $ddrow = mysql_fetch_array($ddresults);
   $ddnum_results = mysql_num_rows($ddresults);

   }
        echo "</select>";

}
 
?>


 
<HTML>
<HEAD>
    <TITLE>Roaster Maint page</TITLE>
  
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

echo "<form name=frmMain method=post enctype='multipart/form-data'  action='roaster_maint.php'>";

?>
<table width=100%>
<tr>
<td>
 <div class="greyone">
Fair Trade Proof
 </div>
 </td>
<td>
 

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

    
    
#   echo "roaster is  $roaster <br>";
 #  echo "<br> Current dir: ";
 #  echo getcwd() . "\n";
#   $d = dir("");
   
   # /home/3/f/8/13572/13572/public_html/ftbadmin 
 #  mkdir("/home/3/f/8/13572/13572/public_html/testme", 0700);
 
   
 #  echo $readme; 
if (isset($trace1)) {
 #  echo "You pushed the button that says: '$trace1' <br>";
   $type = 'Roaster';
}

if (isset($trace2)) {
 # echo "You pushed the button '$trace2' <br>";
  $type = 'Coop';
}


echo "<br> Welcome: ".$_SESSION['valid_user']."<br>";
$user_type = $_SESSION['user_type'];
echo "</div>";


/* 
echo "<br>roaster id of test are:  $rst_id <br>";
echo "<br>user is $user_type ";
echo "<br>rst_id = $rst_id <br>";
echo "<br> query = $debug <br>";
echo "<br> readme = $readme <br>";
 */

$user_type =  $_SESSION['user_type'];
$SetNav = new myNav($_SESSION['user_type']);
$SetNav->setRstId($rst_id);
$SetNav->displayNav(); 

$SetNav->displayRoasterForm("roaster",$rst_id);
     
 $LocalUpload = new ImageUpload("images/");  
 
 $directory = "../".$SetNav->directory."/images/";
 
 $LocalUpload->SetDirectory($directory); 
 
 $upload = $_REQUEST['upload'];

if (isset($upload)) {
  $LocalUpload->DoUpload();
}

 
          
 ?>   

</form>
</BODY>
</HTML>
