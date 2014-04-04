<?php

 session_start();
 
  if (isset($_SESSION['valid_user']))
  {
    $contact_id = $_SESSION['contact_id'];
  }
  else
  {
    
  }

require("../connection.php"); 
 require("LogInFunctions.php");

 require("phpclasses.php");
 
$trace1 = $_POST['trace1'];
$trace2 = $_POST['trace2'];


#$rst_id  = $_REQUEST['rst_id'];
$rst_id  = $_GET['rst_id'];
$coop_id  = $_GET['coop_id'];
$step =  $_REQUEST['step'];

$debug = "Ok begin debug <br>";
$directory = "";

$SetBuildLink = new myRightSideContent($db_conn);
if (ISSET($rst_id)) {
      
   $SetBuildLink->GetRoasterRecord($rst_id);
   $debug = $debug." <br>  setting rst_id <br>";
}


if (ISSET($coop_id)) {
      
   $SetBuildLink->GetCoopRecord($coop_id);
   $debug = $debug." <br>  setting coop_id <br>";
}

$Debug = $debug."<br> coop id = ".$coop_id;
$debug = $debug."<br> directory is ".$SetBuildLink->directory."<br>";

if ($trace2 == 'Trace Lot # from a Farming Cooperative') {
	$type = 'Coop';
}
elseif ($trace1 == 'Trace Lot # from a Roaster') {
    $type = 'Roaster';
}
 
	
$Coop = "";
if ($submit == 'Submit') {
  $test = "test";	
    
}
?>
<script language="Javascript">
var newwindow;
function poptastic(url)
{
 
 // was h=300, w650
 	newwindow=window.open(url,'sample','width=800,height=600,resizable=yes,scrollbars=yes,left=300,top=150');
 	if (window.focus) {newwindow.focus()}
}

 
</script>

<?php	


function BuildWhat($farmer_contract,  $pre_finance_contract, $pre_ship_cupping, $farmer_invoice,
                     $farmer_bill_lading, $organic_transaction, $landed_cupping, $roaster_invoice, $roaster_delivery) {
?>	
 <center>
 Step 1.
 
<div class="yellow_heading">
What Each<br>
Document Means
</div>

<a name="FarmerContract"> <div class="whitetwo">
FARMER CONTRACT
</div></a>
<a STYLE="text-decoration:none" href="javascript:poptastic('contract_example.html');">

<img src="../images/thumb_farm_cont.jpg">
</a>


<div class="center1">

<?php
echo ' <textarea rows="8" cols="100" name="farmer_contract">';
echo "$farmer_contract <br>";
echo '</textarea>';

?>
</div>

<img src="../images/arrow_down.png">
<br>

<a name="PreFinancing"><div class="whitetwo">
PRE-FINANCING CONTRACT
</div> </a>

<a STYLE="text-decoration:none" href="javascript:poptastic('coffee_financing_example.html');">

<img src="../images/thumb_pre_fin.jpg">
</a>

<div class="center1">
 
<?php
echo ' <textarea rows="8" cols="100" name="pre_finance_contract">';
echo "$pre_finance_contract ";
echo '</textarea>';


?>
<div>	

<img src="../images/arrow_down.png">


<a name="PreShip">
<div class="whitetwo">
PRE-SHIPMENT CUPPING EVALUATION
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('pre_shipping_cupping_report_example.html');">
 
<img src="../images/thumb_pre_cup.jpg">
</a>

 <br>
 <div class="center1"> 
 
<?php
echo ' <textarea rows="8" cols="100" name="pre_ship_cupping">';
echo "$pre_ship_cupping ";
echo '</textarea>';


?>

</div>

 
<img src="../images/arrow_down.png">
 

<a name="FarmerInvoice">
<div class="whitetwo">
FARMER INVOICE
</div>
</a>

<a STYLE="text-decoration:none" href="javascript:poptastic('cooperative_invoice_example.html');">


<img src="../images/thumb_farm_inv.jpg">
</a>


 <div class="center1"> 
 

<?php
echo ' <textarea rows="8" cols="100" name="farmer_invoice">';
echo "$farmer_invoice ";
echo '</textarea>';


?>

</div>

 <br>
 
<img src="../images/arrow_down.png">

<a name="LadingBill">
<div class="whitetwo">
FARMER BILL OF LADING
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('bill_of_lading_example.html');">

<img src="../images/thumb_farm_bl.jpg">
</a>
 <div class="center1">
 
<?php
echo ' <textarea rows="8" cols="100" name="farmer_bill_lading">';
echo "$farmer_bill_lading ";
echo '</textarea>';


?>
</div>

  <br>
 
<img src="../images/arrow_down.png">

<a name="LandedCupping">
<div class="whitetwo">
LANDED CUPPING EVALUATION
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('landed_cupping_evaluation_example.html');">

<img src="../images/thumb_land_cup.jpg">
</a>

 <div class="center1">
 
<?php
echo ' <textarea rows="8" cols="100" name="landed_cupping">';
echo "$landed_cupping  ";
echo '</textarea>';


?>
</div>


  <br>
 
 
 
<img src="../images/arrow_down.png">

<a name="OrganicTrans">
<div class="whitetwo">
ORGANIC TRANSACTION
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('organic_transaction_certification_example.html');">

<img src="../images/thumb_org_cert.jpg">
</a>

 <div class="center1">
 
<?php
echo ' <textarea rows="8" cols="100" name="organic_transaction">';
echo "$organic_transaction   ";
echo '</textarea>';


?>
</div> 
 
 
   <br>
 
<img src="../images/arrow_down.png">

<a name="RoasterInvoice">
<div class="whitetwo">
ROASTER INVOICE
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('roaster_invoice_example.html');">

<img src="../images/thumb_roast_inv.jpg">
</a>
 <div class="center1">
 
<?php
echo ' <textarea rows="8" cols="100" name="roaster_invoice">';
echo "$roaster_invoice    ";
echo '</textarea>';


?>
</div> 

 
   <br>
 
<img src="../images/arrow_down.png">

<a name="RoasterDelivery">
<div class="whitetwo">
ROASTER DELIVERY
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('roaster_delivery_order_example.html');">

<img src="../images/thumb_del_ord.jpg">
</a>
 <div class="center1">
 

<?php
echo ' <textarea rows="8" cols="100" name="roaster_delivery">';
echo "$roaster_delivery     ";
echo '</textarea>';


?>
</div> 

 



<div>

<!--
<input type="text" name="lot_nbr"> &nbsp;&nbsp;

-->
<INPUT TYPE="SUBMIT" id="btnSubmit" name="btnSubmit" VALUE="Update" class="n1btn"> 


</div>
<p>

 
 <?php	
 
 }	

 

?>


 
<HTML>
<HEAD>
    <TITLE>Fair Trade Proof Page</TITLE>
  
<meta name="description" content="Fair Trade Proof is maintained by Cooperative Coffees">

<meta name="keywords" content="freetrade, cooperative coffees ">

  

<link rel="stylesheet" type="text/css" href="default.css">

<style>
#input_box1 { background-color:yellow; }
#input_box2 { background-color:yellow; }
</style>

</HEAD>
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec">


 
 

<?php
 
  echo "<div class='float'>";
 echo "<ul id='nav'>";
  echo "<li id='t-coop'><a href='index.php'> Back to Home Page </a><p>&nbsp;<p></li>";
  echo "</ul>";	
   echo "</div>";
 
 
 
 echo "<center>";
 $btnSubmit = $_POST['btnSubmit'];
 
 
if ($btnSubmit == 'Update') {
  
    $farmer_contract = $_POST['farmer_contract'];
    $pre_finance_contract = $_POST['pre_finance_contract'];
    $pre_ship_cupping = $_POST['pre_ship_cupping'];
    $farmer_invoice = $_POST['farmer_invoice'];
    $farmer_bill_lading = $_POST['farmer_bill_lading'];
    $organic_transaction = $_POST['organic_transaction'];
    $landed_cupping  = $_POST['landed_cupping'];
    $roaster_invoice = $_POST['roaster_invoice'];
    $roaster_delivery = $_POST['roaster_delivery'];
  
        
  	 mysql_select_db('what_page_content');
  	 
 

      $query = " update what_page_content 
                    set farmer_contract =  '$farmer_contract',
                    pre_finance_contract = '$pre_finance_contract',
                        pre_ship_cupping = '$pre_ship_cupping',
                        farmer_invoice = '$farmer_invoice',
                        farmer_bill_lading = '$farmer_bill_lading',
                        organic_transaction = '$organic_transaction',
                        landed_cupping = '$landed_cupping',
                        roaster_invoice =  '$roaster_invoice',
                        roaster_delivery =  '$roaster_delivery'                                         
                where seq =  1;";
           
 #     echo "<br>$query <br>";           
                
      $update_lot = mysql_query($query, $db_conn);
      
    
}	 
 
 
 
 
 
	echo "<form name=frmMain method=post   action='edit_what.php' >";
 
 
 echo '<div class="whiteone">';
  
  $query = "select * 
            from what_page_content
             where seq =  1;"; 
             
  $result = mysql_query($query, $db_conn); 
  $row = mysql_fetch_array($result);
  $farmer_contract = $row['farmer_contract'];
  $pre_finance_contract = $row['pre_finance_contract'];
  $pre_ship_cupping = $row['pre_ship_cupping'];
  $farmer_invoice = $row['farmer_invoice'];
  $farmer_bill_lading = $row['farmer_bill_lading'];
  $organic_transaction = $row['organic_transaction'];
  $landed_cupping  = $row['landed_cupping'];
  $roaster_invoice = $row['roaster_invoice'];
  $roaster_delivery = $row['roaster_delivery'];



   # echo "<br> $farmer_contract <br>";


    BuildWhat($farmer_contract, $pre_finance_contract, $pre_ship_cupping, $farmer_invoice,
              $farmer_bill_lading, $organic_transaction, $landed_cupping, $roaster_invoice, $roaster_delivery  );

        echo "<div class='greylinks'>";
      echo "\n";
     echo '<a href="'.$level.'index.php" target="_top" >Home</a> &nbsp;&nbsp;| &nbsp;&nbsp;';

     echo "\n";
     echo '<a href="'.$SetBuildLink->directory.'/index.php" target="_top" >Trace lot # from Coop or Roaster.</a> &nbsp;&nbsp;| &nbsp;&nbsp;';
    echo "\n";
    echo  '<a href="'.$level.'transparent_document_trail.php'.$query_string.'" target="_top" >Learn what documents mean.</a>';
    echo "</div>";
    echo "\n";
    echo "<p>";
     echo "<div class='address'>";
     echo "<center>";
    echo "Cooperative Coffees, 302 W. Lamar Street, Suite C <br>";
    echo "Americus, GA 31709; USA<br>";
    echo "</center>";
    echo "</div>";
 
	
 


?>  
 
</form>

<script language="Javascript">
 // alert("Re-Loaded");

//window.scroll(0,200);
<?php
 if (strlen($step) > 3) {
 echo "parent.TEXTFRAME.location.hash='$step';";
}
 
?> 
 
//parent.TEXTFRAME.location.hash='PreFinancing';

//TEXTFRAME.location.reload()
//test1.scrollTo();

 // window.scrollTo(0,500);
//window.location.href = "test1";
</script>
</BODY>
</HTML>
