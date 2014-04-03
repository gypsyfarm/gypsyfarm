<?php

require("connection.php"); 
 require("phpclasses.php");
 
$trace1 = $HTTP_POST_VARS['trace1'];
$trace2 = $HTTP_POST_VARS['trace2'];


#$rst_id  = $_REQUEST['rst_id'];
$rst_id  = $HTTP_GET_VARS['rst_id'];
$coop_id  = $HTTP_GET_VARS['coop_id'];
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

function BuildWhat() {
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

<img src="images/thumb_farm_cont.jpg">
</a>


<div class="center1">
This shows that our purchase price is always a minimum of $1.50 a lb. We raised independent
of the established Fair Trade price based on feedback from growers at
General Meeting in Xela, Guatemala. The contract also indicates that the coffee
our sampling and quality analyses. This is important to us as roasters, because
quality. But it’s a two-way street. At the core of our Fair system is long- partnerships
between farmer and roaster. We do not walk away from our cooperative partners.
the beans. They grow the cherries and process them into beans. By applying our
market side to the farmer’s capacities on the growing/processing side, we work
create coffees that are higher quality and more desirable. helps them gain customers.
In fact, all the cooperatives we began buying from have eventually built
other importers. There are instances, when it has taken over a year for a cooperative
our standards. Once they do, we remain committed to them.
</div>

<img src="images/arrow_down.png">
<br>

<a name="PreFinancing"><div class="whitetwo">
PRE-FINANCING CONTRACT
</div> </a>

<a STYLE="text-decoration:none" href="javascript:poptastic('coffee_financing_example.html');">

<img src="images/thumb_pre_fin.jpg">
</a>

<div class="center1">
A key tool for farmers in the U.S. is capitalization. Loans are widely available to farmers
America and Europe. is not the case for small farmers in remote coffee-growing regions. key element of our Fair Trade system is pre-financing, which we offer via loans up to the amount of 60% of our ultimate purchase price from Eco Logic, our financing partner. This means, we
a portion of the purchase price of the coffee in advance of taking delivery, enabling farmers to get through the growing season.<br>
As an absolute rule, we always offer pre-financing to our farming partners. This is critical because most cooperatives are uncomfortable about seeking pre-financing. Although pre-financing is a standard tenet of Fair Trade practices and partnerships in general, most importers do
overtly offer it.<br>
Due to the structure of pre-financing, it is not a part of our document path. You can see a sample
contract by clicking the thumbnail photo. And you’ll see a cooperative’s pre-finance status when you use Fair Trade Proof to trace a lot # from a farming cooperative
<div>	

<img src="images/arrow_down.png">


<a name="PreShip">
<div class="whitetwo">
PRE-SHIPMENT CUPPING EVALUATION
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('pre_shipping_cupping_report_example.html');">
 
<img src="images/thumb_pre_cup.jpg">
</a>

 <br>
 <div class="center1"> 
This is how we evaluate coffees for quality. It used to be that cuppings were importers -- a 
practice that facilitates an uneven balance of power between farmers importers. 
Since 2001, our members have been working with farmers to train them to cup 
coffee and therefore raise their quality to meet the desires of the market. The 
farmers cupping their own coffee is now increasingly common.

</div>

 
<img src="images/arrow_down.png">
 

<a name="FarmerInvoice">
<div class="whitetwo">
FARMER INVOICE
</div>
</a>

<a STYLE="text-decoration:none" href="javascript:poptastic('cooperative_invoice_example.html');">


<img src="images/thumb_farm_inv.jpg">
</a>

 <div class="center1"> 
Shows the name of the farmer cooperative, number of bags
to be paid.
</div>

 <div class="center1"> 
This is a more radical document than it seems. Before Fair Trade, it was unheard of for small family farmers to have invoices, because they could not export directly. Over 70% of the world’s coffee comes from small family farmers of 10 hectares or less. It’s not possible for a farm of this size to fill a container for export. The Fair Trade system encourages farmers to form cooperatives that enable them to export their coffee themselves, substantially increasing
their revenue. In many coffee-growing countries, the government offers little if any services
in the remote regions where coffee is grown. Fair Trade cooperatives frequently do what the government does not. For example, Cacocafen in Nicaragua has built village schools and even roads, both of which are open to their entire communities, not just the coffee farmers.
</div>

 <br>
 
<img src="images/arrow_down.png">

<a name="LadingBill">
<div class="whitetwo">
FARMER BILL OF LADING
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('bill_of_lading_example.html');">

<img src="images/thumb_farm_bl.jpg">
</a>
 <div class="center1">
Documents the original shipper of the coffee, who it is being shipped to, weight of the coffee and U.S. destination port, which in our case is our warehouse in New Orleans.
<br>
To give you a sense of the importance of long-term partnerships, on this site under each cooperative's
information, we have indicated the total pounds we have purchased over the duration of our partnership.
</div>

  <br>
 
<img src="../images/arrow_down.png">

<a name="LandedCupping">
<div class="whitetwo">
LANDED CUPPING EVALUATION
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('landed_cupping_evaluation_example.html');">

<img src="images/thumb_land_cup.jpg">
</a>

 <div class="center1">
We evaluate coffee in our U.S. cupping laboratory after shipping to ensure the quality we are receiving matches the quality we anticipated. (This form is not a part of our traceable document
bundle. See sample by clicking thumbnail photo.)
</div>


  <br>
 
 
 
<img src="images/arrow_down.png">

<a name="OrganicTrans">
<div class="whitetwo">
ORGANIC TRANSACTION
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('organic_transaction_certification_example.html');">

<img src="images/thumb_org_cert.jpg">
</a>

 <div class="center1">
Documents the Organic Certification of the farmer cooperative.
We encourage all of our farming partners to get their organic certification. We do this because organic farming is better for the environment as well as the health of the farmers and their families. It’s also highly beneficial to their business as it adds 20 cents per pound or more to their revenue. As a result, nearly all of our coffee is organic-certified as well as Fair Trade.
<br>
The most critical way we support Organic certification is to purchase coffee from cooperatives during the transition process -- a time when they must adhere to the practices of organic farming
without being able to demand the price premium associated with organic certification (frequently
termed "transitional organic").
</div> 
 
 
   <br>
 
<img src="images/arrow_down.png">

<a name="RoasterInvoice">
<div class="whitetwo">
ROASTER INVOICE
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('roaster_invoice_example.html');">

<img src="images/thumb_roast_inv.jpg">
</a>
 <div class="center1">
This is Cooperative Coffees invoice to the individual member for its portion
Just as farming cooperatives enable farmers to form communities of common
export, we use our cooperative to empower us to directly import. As communities
common interests over mere profits, cooperatives represent alternatives to
to support this concept in every way possible.
</div> 

 
   <br>
 
<img src="images/arrow_down.png">

<a name="RoasterDelivery">
<div class="whitetwo">
ROASTER DELIVERY
</div>
</a>
<a STYLE="text-decoration:none" href="javascript:poptastic('roaster_delivery_order_example.html');">

<img src="images/thumb_del_ord.jpg">
</a>
 <div class="center1">
Documents delivery of the coffee to our warehouse. It closes the loop.
</div> 

<p>
<div class="whitetwo">
Step 2. Click on the search button
</div>



<div>

<!--
<input type="text" name="lot_nbr"> &nbsp;&nbsp;

-->
<INPUT TYPE="SUBMIT" id="btnSubmit" name="btnSubmit" VALUE="Search" class="n1btn"> 
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


<center>

<?php
 /*
  echo "<br>directory = $directory <br>";
  echo "<br>alt directory = ".$SetBuildLink->directory."<br>";
  echo "<br>".$SetBuildLink->readme."<br>";
  echo "<br> $debug <br>";
*/  
  
if (ISSET($SetBuildLink->directory)) {
	echo "<form name=frmMain method=post  target='_top' action='".$SetBuildLink->directory."/index.php' >";
}
else {
	echo "<form name=frmMain method=post  target='_top' action='index.php' >";
}

# <form name=frmMain method=post  target="_top" action='xindex.php' >

?>

 <div class="whiteone">
<?php 
    BuildWhat();

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
