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



#functions: 
   $coop = $HTTP_GET_VARS['coop'];
   if ($coop == "") {
   	$coop = "Default";
   }

$ListType = $HTTP_GET_VARS['ft_id'];

  mysql_select_db('trf_roaster_content');



if ($submit == 'Submit') {
	
	$logo =  $HTTP_POST_VARS['logo'];
	$contact =  $HTTP_POST_VARS['contact'];
	$photo =  $HTTP_POST_VARS['photo'];
	$profile =  $HTTP_POST_VARS['profile'];
	$front_bag_img =  $HTTP_POST_VARS['front_bag_img'];
	$back_bag_img =  $HTTP_POST_VARS['back_bag_img'];
 
	
	 mysql_select_db('trf_coop_content');

      $query = " update trf_coop_content 
                    set cA1_logo =  '$logo', 
                        cB1_contact = '$contact',
                        cA2_photo = '$photo',
                        cB2_profile = '$profile',
                        cA3_front_bags = '$front_bag_img',
                        cB3_back_bags = '$back_bag_img'  
                where coop_id =  '$coop';";
                
     #  echo '<br>'.$query.'<br>';          
                
      $update_lot = mysql_query($query, $db_conn);

}


  $query = "select * 
            from trf_coop_content
             where coop_id =  '$coop';";


  # echo '<br>'.$query.'<br>';

# retrieve information:
  $result = mysql_query($query, $db_conn);
  $num_results = mysql_num_rows($result);


# prepare to extract
 $row = mysql_fetch_array($result);
 $logo = $row['cA1_logo'];
 $contact = $row['cB1_contact'];
 $photo = $row['cA2_photo'];
 $profile = $row['cB2_profile'];
 $front_bag_img = $row['cA3_front_bags'];
 $back_bag_img = $row['cB3_back_bags'];






   function Buildlogo($coop) {
 
   	if ($coop == "FECAFEB" ) {
           echo " <img src='logos/fecafeb.png'>";
   	}
   	elseif ($coop == "Fondo_Paez" ) {
   	    echo " <img src='logos/fondo-paez.png'>";;
   	}
   	elseif ($coop == "Maya_Vinic" ) {
           echo " <img src='logos/maya-vinic.jpg'>";
   	   
   	}
   	else {
   	      echo "no image";  
   	}
   	
   }
   
   
      function BuildPhoto($coop) {
 
   	if ($coop == "FECAFEB" ) {
           echo " <img src='coop_photos/fecafeb.jpg'>";
   	}
   	elseif ($coop == "Fondo_Paez" ) {
   	    echo " <img src='coop_photos/col-map.gif'>";;
   	}
   	elseif ($coop == "Maya_Vinic" ) {
           echo " <img src='coop_photos/maya-vinic.jpg'>";
   	   
   	}
   	else {
   	      echo "no image";  
   	}
   	
   }
   
   
      function BuildContact($coop) {
 
   	if ($coop == "FECAFEB" ) {
              	   echo "FECAFEB<br>";
                   echo "La Paz, Bolivia<br>";
                   echo "FLO ID # <br> ";
                   echo "www.fecafeb.com/<br>";
                   echo "Partner since 2005<br>";
                   echo "Organic Certificate Link<br>";
   	}
   	elseif ($coop == "Fondo_Paez" ) {
   	            echo "Fondo_Paez<br>";
                   echo "Colombia<br>";
                   echo "FLO ID # <br> ";
                   echo "www.fondo_paez.com<br>";
                   echo "Partner since 2000<br>";
                   echo "Organic Certificate Link<br>";
   	}
   	elseif ($coop == "Maya_Vinic" ) {
                   echo "Maya Vinic<br>";
                   echo "Chiapas, Mexico<br>";
                   echo "FLO ID # <br> ";
                   echo "www.mayavinic.com<br>";
                   echo "Partner since 2003<br>";
                   echo "Organic Certificate Link<br>";
   	   
   	}
   	else {
   	      echo "no contact info";  
   	}
   	
   }
   
   
         function BuildProfile($coop) {
 
   	if ($coop == "FECAFEB" ) {
         ?>
                 Profile of FECAFEB
        <p> 
        The Federation of Exporting Coffee Producers (FECAFEB) was founded in 1991 as a national organization to defend the rights and 
        needs of small-scale coffee farmers. FECAFEB has taken huge steps forward and seems to be right in stride with 
        the new Bolivian political reality in support of Indigenous voice and rights...
        <a href="javascript:;" onmousedown="if(document.getElementById('mydiv').style.display == 'none'){ document.getElementById('mydiv').style.display = 'block'; }else{ document.getElementById('mydiv').style.display = 'none'; }">([More/Less]</a></p>

          
        
        <div  id="mydiv" class="left" style="display: none">
         
        FECAFEB is currently comprised of 30 coffee producer organizations, representing some 8,700 families. FECAFEB and 
        its member coops have developed in important ways, including: the consolidation of its now 30 cooperative members; a 
        widespread training program for administrative, leadership and quality control improvements offered to 470 cooperative leaders 
        old and new; creating a political space for the voice of small-scale coffee producers to be heard and amplified; and 
        in the sale of 120 containers of coffee primarily into the Fair Trade, Organic and other specialty markets.
         </div>
         <?php
   	}
   	elseif ($coop == "Fondo_Paez" ) {
         ?>
                 Profile of Fondo Paez
        <p> 
        The Paez (who also call themselves Nasa, or "the people") is the largest indigenous group in Colombia. 
        Their land is in the Cordillera Central - centered around the mountains of the Cauca departamento (state)...
        <a href="javascript:;" onmousedown="if(document.getElementById('mydiv').style.display == 'none'){ document.getElementById('mydiv').style.display = 'block'; }else{ document.getElementById('mydiv').style.display = 'none'; }">([More/Less]</a></p>

          
        
        <div  id="mydiv" class="left" style="display: none">
         
          Fondo Paez was founded in 1992, with the primary goal of recuperating traditional agricultural knowledge and 
          indigenous culture which had been buried by centuries of conflict and oppression.  Paez community leaders teamed up with
           Fundacion Colombia Nuestra, a Colombian-based non-profit, to start the "Recovering Agricultural Knowledge" program.  
           The main cash crop of this region is still coffee, and, to ensure a stable income for their members, Fondo Paez organized
            community based coffee cooperatives. They became more organized, and, by 2000, they were selling coffee through
             the Coffee Federation's Specialty Coffee program. In 2003, they produced seven containers of coffee, both conventional 
             and organic certified.
         </div>
         <?php
   	}
   	elseif ($coop == "Maya_Vinic" ) {
         ?>
                 Profile of Maya Vinic
        <p> 
        The Cooperative "Producers' Union Maya Vinic" is comprised of some 700 coffee farming families located in 36 highland communities 
        in the municipalities of Chenalho, Pantelho and Chalchihuitan... 
        <a href="javascript:;" onmousedown="if(document.getElementById('mydiv').style.display == 'none'){ document.getElementById('mydiv').style.display = 'block'; }else{ document.getElementById('mydiv').style.display = 'none'; }">([More/Less]</a></p>

          
        
        <div  id="mydiv" class="left" style="display: none">
         
        in the Highlands of Chiapas. Maya Vinic means "Mayan Man" in the Mayan Tzotzil language. 
        The cooperative chose Maya Vinic for their name because they are motivated and inspired by the knowledge and wisdom of their 
        Mayan ancestors who organized themselves and made decisions collectively. Keeping with their ancestral traditions, the 
        members of Maya Vinic have chosen to utilize a portion of the entire coffee revenue to develop their business with all 
        remaining earnings distributed to farmer families and their communities. Fair trade revenues is providing Maya Vinic with 
        a much deserved income.
         </div>
         <?php
   	   
   	}
   	else {
   	      echo "no profile info";  
   	}
   	
   }


      function BuildDocLinks($coop) {
 
   	if ($coop == "FECAFEB" ) {
   		?>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank"> BOT71 - 16/2452/001 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">BOT63 - 16/2452/006 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">BOT62 - 16/2452/004 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">BOT61 - 16/2452/001 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">BOT52 - 16/2454/003 </a><br>
        <?php
   	}
   	elseif ($coop == "Fondo_Paez" ) {
   		?>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">COP71 - 16/2452/001 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">COP63 - 16/2452/006 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">COP62 - 16/2452/004 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">COP61 - 16/2452/001 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">COP52 - 16/2454/003 </a><br>
        <?php
   	}
   	elseif ($coop == "Maya_Vinic" ) {
   		?>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">MEV71 - 16/2452/001 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">MEV63 - 16/2452/006 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">MEV62 - 16/2452/004 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">MEV61 - 16/2452/001 </a><br>
        <a href="http://www.scribd.com/doc/134638/GUA62Con" target="_blank">MEV52 - 16/2454/003 </a><br>
        <?php
   	   
   	}
   	else {
   	      echo "no contact info";  
   	}
   	
   }


       function BuildFormTag($ListType, $coop) {
       	    echo "<form name=frmMain method=post action='edit_coop_detail.php?ft_id=$ListType&coop=$coop'>";
       }
   
?>

<html>
<head>
<style type="text/css">
<!--
body { font:normal 10px verdana; }
#header { width:100%; float:left; background:#fc0; } 
#header div { width:50%;  float:left; } 
#header .left {  text-align:left; background:#fc0; } 
#header .right { text-align:right; background:#fc0; width:49.9%; } 
#menu, #footer { width:100%; float:left; background: #c3c3c3; text-align:center; height:22px; } 
#footer { background:#666; } 
#content .leftcol { float:left; width:150px; height:200px; background:#ffc; } 
#content .centercol { height:200px; background:#ff3; } 
#content .rightcol { text-align:center; float:right; width:150px; height:200px; background:#fc0; } 
-->
</style>
<script language="javascript">
  function toggleDiv(divid){
    if(document.getElementById(divid).style.display == 'none'){
      document.getElementById(divid).style.display = 'block';
    }else{
      document.getElementById(divid).style.display = 'none';
    }
  }
</script>
</head>
<body>
 
 
            <?php
           

            BuildFormTag($ListType, $coop);
            ?>
 
             <input type="submit" value="Submit" name="submit"> &nbsp;&nbsp;
<table border=0 cellPadding=4 cellSpacing=4 >
<tr>
<td colspan=2>
<?php

echo "<a href='sample.php?ft_id=$ListType'> <strong>Back </strong> </a>";

echo "<br>";
echo "coop is $coop <br>";

?>
<tr>
 
<td>  
<?php
# Buildlogo($coop);
               echo "<strong>Logo</strong><br>:";
               echo '<input type=text name=logo size=40 value="';
               echo $logo;
                 echo '">';
?>    
        
</td>
<td>
 
 <?php
#  BuildContact($coop);
             echo "<strong>Contact:<br>";
             echo '<textarea name="contact" type="text" maxlength="1000" id="leftcol" style="height:150px;width:450px;">';
               echo $contact;
             echo '</textarea>';
?> 

     
</td>
</tr>

<tr>
<td>
 <?php
# BuildPhoto($coop);
              echo "<strong>Photo:<br>";
               echo '<input type=text name=photo size=40 value="';
               echo $photo;
                 echo '">';
?> 
       
        </td>
        <td>
        
                
 <?php
#BuildProfile($coop);

           echo "<strong>Profile:<br>";
             echo '<textarea name="profile" type="text" maxlength="1000" id="leftcol" style="height:150px;width:450px;">';
               echo $profile;
             echo '</textarea>';
?> 
 

        </td>
 </tr>
 
 <tr>
 <td>
 <table>
 <tr>
 <td>
 <?php
     #   <img src='bags/maya-vinic-front.jpg'>
           echo "<strong>Front Bag Image:<br>";
               echo '<input type=text name=front_bag_img size=40 value="';
               echo $front_bag_img;
                 echo '">';
                 
?>
   </td><td>            
         
         <?php
     #   <img src='bags/maya-vinic-back.jpg'>   
        
               echo "<strong>Back Bag Image:<br>";
               echo '<input type=text name=back_bag_img size=40 value="';
               echo $back_bag_img;
                 echo '">';
                 
?>
        </td></tr>
        </table>   
</td>
<td>
        Link Import Documents - Last 5 lots
        <p>
   <?php
BuildDocLinks($coop);
?>       
	Link to next five =>
</td>
</tr>
</table>
</body>
</html>
