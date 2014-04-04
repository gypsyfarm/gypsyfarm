<?php
 
 
 session_start();
 # $ReadMe = "Start<br>";
     $key .=  "s1:".$_SESSION['valid_user'].",";
    $key .=  "s2:".$_SESSION['contact_id'].",";
    $key .=  "s3:".$_SESSION['auth_contact_id'].",";
    $key .=  "s4:".$_SESSION['user_type'].",";
    $key .=  "s5:".$_SESSION['userid'].",";
 
 if ($_GET['logout'] == "yes" ) {
 	$debug .= "Doing the unset and log out function / if statement <br>";
 	unset($_POST['userid']);
 	unset($_POST['password']);
 	unset($_SESSION['valid_user']);
        unset($_SESSION['contact_id']);
        unset($_SESSION['auth_contact_id']);
        unset($_SESSION['user_type']);
        unset($_SESSION['userid']);
}
 
 require("LogInFunctions.php");
  require("phpclasses.php");

 
 
$trace1 = $_POST['trace1'];
$SetBtn = $_POST['SetBtn'];

$Coop = "";
if ($submit == 'Submit') {
  $test = "test";	
    
}	


 
?>


 
<HTML>
<HEAD>
    <TITLE>Index page</TITLE>
  
<meta name="description" content="Fair Trade Proof is maintained by Cooperative Coffees">

<meta name="keywords" content="freetrade, cooperative coffees ">

  

<link rel="stylesheet" type="text/css" href="../default.css">

<style>
#input_box1 { background-color:yellow; }
#input_box2 { background-color:yellow; }
</style>

</HEAD>
<BODY BGCOLOR="#000000" text="ececec" link="F76B08" alink="ffffff" vlink="ececec" background="images/bg.gif" bgproperties="fixed">


<center>

<?php

if (! ISSET($_SESSION['rst_id'])) {
    if ($_SESSION['user_type'] == "1") {
        $db_conn = mysql_connect('mysql.coopcoffeesbeans.com', 'greenbeans3', 'annh401');
         mysql_select_db('cbeans', $db_conn);
                         
             if (!$db_conn) {
                  echo 'Error: Could not connect to coffeepathdata database.  Please try again later.';
                  exit;
             }
             
             $query = "select ft_id, coop_id 
                         from trf_roaster_content
                         where coop_id = '".$_SESSION['contact_id']."'";
                         
             $ReadMe .= "<br>" + $query;            
                         
             $result2 = mysql_query($query, $db_conn);
             if (mysql_num_rows($result2) >0 ) {
                 $row2 = mysql_fetch_array($result2);
                 $_SESSION['rst_id'] = $row2['ft_id'];
             	
              }
       }   
}

            
?>      
        
<table  width=100%>
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
 <div class="corners floatr">
  Fair Trade Proof is maintained by Cooperative Coffees<br>
 Our black background minimizes  <br>
 energy, reducing climate change
   </div>
 
 </td>
 </tr>
 </table>
 <p>
 
 
<hr>
 
  

<?php 

echo '<div class="whiteone">';
echo "</div>";

 /*
echo "<br>roaster id of test are:  $rst_id <br>";
echo "<br>user is $user_type ";
echo "<br>rst_id = $rst_id <br>";
echo "<br> query = $debug <br>";
echo "<br> Welcome: ".$_SESSION['valid_user']."<br>";
*/
 
 
$SetNav = new myNav($_SESSION['user_type']);

          
          #  echo "<br>Set = $SetBtn and ".$_POST['roaster'];
            if ($SetBtn == "Set" && ISSET($_POST['roaster'])) {
                 $_SESSION['rst_id'] = $_POST['roaster'];
                 $rst_id = $_SESSION['rst_id']; }
            else {  
            	$rst_id = $_SESSION['rst_id'];   	
            }
        
        
            if ($SetBtn == "Set" && ISSET($_POST['coop'])) {
                 $_SESSION['coop_id'] = $_POST['coop'];
                 $coop_id = $_SESSION['coop_id']; }
             else {    
                 $coop_id = $_SESSION['coop_id']; 
            }
    
       
            $SetNav->setRstId($rst_id);
            $SetNav->setCoopId($coop_id);
            
            $SetNav->displayNav();
        
?>
 

  <div class="yellow_heading">
 <br>
</div> 
<?php

 

            echo '<form name="login" method=post action="index.php">';
            
           echo "<br> Welcome: ".$_SESSION['valid_user']."<br>";
          # echo "<br>coop_id = ".$_SESSION['coop_id']."<br>";
          # echo "<br>Rst_id = ".$_SESSION['rst_id']."<br>";
           $SetNav->displayLogin($_SESSION['user_type']);
     
           echo '</form>';
  
           echo '</center>';

 
  /*
 echo $debug;
 echo $ReadMe;
 #printf('%s', print_r(get_defined_vars(), 1));
 
# $arrayObj = new ArrayObject(get_defined_vars());
 $arrayObj = new ArrayObject($_SESSION);

// loop over the array object and echo variables and values
for($iterator = $arrayObj->getIterator(); $iterator->valid(); $iterator->next())
        {
        echo $iterator->key() . ' => ' . $iterator->current() . '<br />';
        }
        
  */
  echo "<br><br><br><br><br><br><br><br><p>$key</p>";      
        
?>

  
 

 
</BODY>
</HTML>
