<?php
//********************************************************************************
//********************* Display announcement for Cooperative Coffees ************************
//********************************************************************************

$db_conn = mysql_connect('ldb105.siteprotect.com', 'coffeepathdata', 'cafe725');
mysql_select_db('coffeepathdata', $db_conn);

if (!$db_conn)
{
    echo 'Error: Could not connect to database.  Please try again later.';
    exit;
}


#associative arrays:

$arrCountry=array("Mexico"=>"http://coopcoffees.com/what/producers/mexico",
                  "Bolivia"=> "http://coopcoffees.com/what/producers/bolivia",
                  "Ethiopia"=> "http://coopcoffees.com/what/producers/ethiopia");
                  
                  
$arrCoop=array("Maya_Vinic"=>"http://coopcoffees.com/what/producers/maya-vinic-mexico/maya-vinic-mexico",
                  "FECAFEB"=> "http://coopcoffees.com/what/producers/fecafeb-bolivia/fecafebhttp://coopcoffees.com/what/producers/fecafeb-bolivia/fecafeb",
                  "Fondo_Paez"=> "http://coopcoffees.com/what/producers/fondo-paez-colombia/fondo-paez");



#  header ("Location: $URL");

$submit = $HTTP_POST_VARS['submit'];
 $ListType = $HTTP_GET_VARS['ft_id'];
$Coop = "";
 
if ($submit == 'Submit') {
	
	$Coop =  $HTTP_POST_VARS['Coop'];
	$banner =  $HTTP_POST_VARS['banner'];
	$leftcol =  $HTTP_POST_VARS['leftcol'];
	$centercol =  $HTTP_POST_VARS['centercol'];
	$rightcol =  $HTTP_POST_VARS['rightcol'];
 
	
	
	 mysql_select_db('trf_roaster_content');

      $query = " update trf_roaster_content 
                    set banner =  '$banner', 
                        left_cell = '$leftcol',
                        center_cell = '$centercol',
                        right_cell = '$rightcol'
                where ft_id =  $ListType;";
      $update_lot = mysql_query($query, $db_conn);
      
 

	#if ($Coop <> "") {
        #  $ListType = $HTTP_GET_VARS['ft_id'];
	#   $URL = "coop_detail.php?coop=$Coop&ft_id=$ListType";
	#    header ("Location: $URL");
	#}
}	

#functions: 
  
   if ($ListType == "") {
   	$ListType = "4";
   }
   
   
     mysql_select_db('trf_roaster_content');


  $query = "select * 
            from trf_roaster_content
             where ft_id =  $ListType;";


#  echo '<br>'.$query.'<br>';

# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
  $row = mysql_fetch_array($result);
 $banner = $row['banner'];
 $leftcol = $row['left_cell'];
 $centercol = $row['center_cell'];
 $rightcol = $row['right_cell'];

   function BuildLeftCol($ListType) {
 
   	if ($ListType == "1" ) {
   	  # echo " left column type 1";
   	    echo  "Store Hours <br>";
            echo "M - T: 7am - 7pm<br>";
            echo "F: 7am - 8pm<br>";
            echo "S: 8am - 8pm<br>";
            echo "S: 8am - 7pm<br>";
   	}
   	elseif ($ListType == "2" ) {
   	    echo "Hours<br>";
            echo "Monday - Friday 7am - 11pm<br>";
            echo "Saturday & Sunday 8am - 11pm<br>";

            echo "<strong>Phone  (615) 385-JAVA </strong>";
   	}
   	elseif ($ListType == "3" ) {
   		echo "phone (612) 870-3440<br>";
                echo "call toll free 1-888-324-7872";
                echo "fax (612) 677-3989";
   	   
   	}
   	else {
   	      echo "229-924-2468";  
   	}
   	
   }
   
   function BuildRightCol($ListType) {
 
   	if ($ListType == "1" ) {
   	  # echo " Right column type 1";
   	    echo "Alternative Grounds <br>";
            echo "333 Roncesvalles Avenue<br>";
            echo "Toronto, ON M6H 1T5<br>";
            echo "Canada<br>";
            echo "416-534-6335";
   	}
   	elseif ($ListType == "2" ) {
   	   echo "2007 Belmont Blvd.<br>";
           echo "Nashville, TN 37212"; 
   	}
   	elseif ($ListType == "3" ) {
           echo "Peace Coffee <br>";
           echo "2801 21st Ave S #120";
           echo "Minneapolis, MN 55407";
   	}
   	else {
   	     echo "Cafe Campesino<br>";
             echo "302 West lamar Street<br>";
             echo "Americus, GA 31709<br>";
             
   	}
   	
   }
 
   function BuildCenterCol($ListType) {
 
   	if ($ListType == "1" ) {
   	  # echo " Center column type 1";
   	   
   	   echo "&nbsp;<p>At Alternative Grounds, we began by roasting only fairly traded coffees. That was five years ago, and there was little attention paid to fairtrade and why it was important. It wasn't until 1998 that Fair TradeMark Canada, an independent fairtrade licensing and regulatory body, came into being. We were proud to be one of the first licensees, and proud of our contribution to a growing awareness of fairtrade and freshly roasted coffee. None of this would have happened, if it weren't important to you! In fact, your growing awareness lead to a new home for our roaster and a new look for our cafe! No more stopping traffic on Roncesvalles while loyal customers and a neighbouring shopkeeper helped unload 152 lb coffee bags, 1 bag at a time, in through the front door and then down to the basement! Hooray for loading dock doors and a pallet wagon!!";
   	}
   	elseif ($ListType == "2" ) {
   	  echo "<strong> Bean Philosophy </strong>";
          echo "Bongo Java believes in an expanded definition of quality that adds concerns about the way the beans were grown and purchased to the usual criteria of cup taste.";

          echo "<strong>Thus, all of our coffee is Organic and Fair Trade, which we purchase from small farmer cooperatives.</strong>";

          echo "We agree that many Estate coffees taste mighty fine. However, after visiting estates throughout Central America and hearing about how the workers live in company housing, shop at company stores and are educated at company schools, the coffee left us with a bad taste in our mouth.";
   	}
   	elseif ($ListType == "3" ) {
   	  echo "Peace Coffee today includes a staff of twelve and coffee varieties of fifteen and growing. We roast, pack and distribute our coffee beans all under one eco-friendly roof in Minneapolis. In the Twin Cities metro, Peace Coffee still delivers by bike year-round and our suburban accounts get their coffee from a big, bright biodiesel van. What remains unchanged is our complete devotion to the idea of a fairly traded, farmer-friendly product and the wonders of a great cup of coffee.";
   	}
   	else {
           echo "Cafe Campesino is Georgia 's 100% Fair Trade, organic, shade-grown coffee roaster supplying individuals, coffee houses, markets, co-ops, and fundraising groups with great roasted-to-order, specialty-grade coffee. As we continue to change, improve, define and redefine this company, we stand by our original mission of helping to create a system of trade that ensures that the farmers receive a fair price for their product.";
   	}
   	
   } 
 
    function BuildBanner($ListType) {
 
   	if ($ListType == "1" ) {
   	   echo "banners/ag-logo.png";
   	}
   	elseif ($ListType == "2" ) {
   	  echo "banners/bongo_java.png";
   	}
   	elseif ($ListType == "3" ) {
   	   echo "banners/peace_coffee.png";
   	}
   	else {
           echo "banners/default_banner.jpg"; 
   	}
   	
   } 
   
       function BuildFormTag($ListType) {
       	    echo "<form name=frmMain method=post action='edit_sample.php?ft_id=$ListType'>";
       }
   
?>


<html>
<head>
<style type="text/css">
<!--
body { font:normal 10px verdana; }
#header { width:100%; float:left; background:#ff0; } 
#header div { width:50%; height:40px; float:left; } 
#header .left { background:#fc0; } 
#header .right { text-align:right; background:#f90; width:49.9%; } 
#menu  { width:100%; float:left; background: #c3c3c3; text-align:center; height:22px; } 
#footer { width:100%; float:left; background: #c3c3c3; text-align:center; height:22px; } 
#footer { background:#666; } 
#content .leftcol { float:left; width:150px; height:200px; background:#ffc; } 
#content .centercol { height:400px; background:#ffc; } 
#content .rightcol { text-align:center; float:right; width:150px; height:200px; background:#ffc; } 
-->
</style>
</head>
<body>




           <?php
           

            BuildFormTag($ListType);
            ?>

<div id="main">
    <div id="header"><center>
           
             <!--  BuildBanner($ListType)Banner: -->
           <?php
         
               echo '<input type=text name=banner size=40 value="';
               echo $banner;
                 echo '">';
                 
                 ?>
           
       </center>
    </div>
    <div id="menu">
    
              <strong>  Follow Bean To -> &nbsp; </strong>
                
    
    
                <select  disabled name=Coop>
                <option value=''>&nbsp; 
                <option value='FECAFEB' >Bolivia: FECAFEB  
                <option value='Fondo_Paez' >Columbia: Fondo Paez                  
                <option value='Maya_Vinic' >Mexico: Maya Vinic
            </select>
            &nbsp;&nbsp;
            
            <input type="submit" value="Submit" name="submit"> &nbsp;&nbsp;
    
    </div>
    
    In put data  here
    <table width=100% border=0 cellPadding=4 cellSpacing=4 >
    <tr>
    <td>
         left cell <br>
         <!--  width=350   style="height:50px;width:350px;" -->
               <?php
             echo '<textarea name="leftcol" type="text" maxlength="255" id="leftcol" style="height:250px;width:250px;">';
               echo $leftcol;
             echo '</textarea>';
             ?>
          
        </td>
        
        <td> middle cell <br>
               <?php
             echo '<textarea name="centercol" type="text" maxlength="255" id="centercol"  style="height:250px;width:350px;">';
             echo $centercol;
             echo '</textarea>';
             ?>
          
          </td>
        <td>  right cell <br>
               <?php
             echo '<textarea name="rightcol" type="text" maxlength="255" id="rightcol"  style="height:250px;width:250px;">';
             echo $rightcol;
             echo '</textarea>';
             ?>
          
        </td>

          </tr>
          </table>
    </div>
    <div id="footer">FOOTER</div>
</div>
</form>
</body>
</html>
