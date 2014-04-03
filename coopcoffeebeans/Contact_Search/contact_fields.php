 <?php
//********************************************************************************
//********************* Maint Screen fields                     ************************
//********************************************************************************
require("../phpclasses.php");
if (isset($_REQUEST['SUBMIT']) || $Adding_Record == "Yes")
{
   $view_mode = 1;  
   $PlaceField=new myTextBoxChoice($view_mode);
}
else
{
   $view_mode = 0; 
   $PlaceField=new myTextBoxChoice($view_mode);
}  

# $view_mode = 1;
    
echo '<table border="1"  width="100%" bordercolor="#FFFFFF" cellspacing="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" cellpadding="2">';
echo "<tr><td>";

echo '<input type=hidden name=contact_id size=10 value="';
echo $row['contact_id'];
echo '">';
echo '<p><b>('.$row['contact_id'].')   company: ';
echo "</td><td>";

#title,name,size,value,trailer
$PlaceField->displayBox('','Company',40,$row['Company'],''); 	
		
echo '</td>';

echo "<td> Type: ";

if ($view_mode == 1) 
{
    GenericDropDown($cc_type_list,"TYPE",$row['TYPE']);
    echo ',Position: ';
    echo '<input type=text name=Position size=5 value="';
    echo $row['Position'];
    echo '">,Rank: ';
    GenericDropDown($rank_list,"Rank",$row['Rank']);
}
else
{
    echo "<span class='label'>".$row['TYPE']." </span>";	
    echo ",&nbsp;&nbsp;&nbsp;Position: ";
    echo  "<span class='label'>".$row['Position']."</span>";
    echo ",&nbsp;&nbsp;&nbsp;Rank: ";
    echo "<span class='label'>".$row['Rank']."</span>";
}
         
     
     
echo '</td>';
echo '</tr>';

  

echo "<tr><td>";
echo '<b>First Name: </td><td>';

#title,name,size,value,trailer
$PlaceField->displayBox('','First_Name',40,$row['First_Name'],''); 	

echo '</td>';
echo '<td>Last Name: ';

#title,name,size,value,trailer
$PlaceField->displayBox('','Last_Name',40,$row['Last_Name'],''); 

echo '</td>';
echo '</tr>';

echo "<tr><td>";
echo '<b>Email Address:';
echo "</td><td>";

#title,name,size,value,trailer
$PlaceField->displayBox('','Email',40,$row['Email'],'');

echo '</td>';
echo '<td>WebSite: ';

#title,name,size,value,trailer
$PlaceField->displayBox('','WebSite',40,$row['WebSite'],'');

echo '</td>';
echo '</tr>';


echo "<tr><td>";
echo '<b>Phone:';
echo "</td><td>";

#title,name,size,value,trailer
$PlaceField->displayBox('','Phone',40,$row['Phone'],'');
    
     echo '</td>';
     echo '<td> Ext: ';
     
#title,name,size,value,trailer
$PlaceField->displayBox('','Ext',6,$row['Ext'],'');     
     
echo '&nbsp;&nbsp;&nbsp;&nbsp; ';

       
#title,name,size,value,trailer
$PlaceField->displayBox('Mobile:','Mobile',20,$row['Mobile'],'');       
   
echo '</td>';
echo '</tr>';

echo "<tr><td>";
echo '<b>Work Fax:';
echo "</td><td>";

#title,name,size,value,trailer
$PlaceField->displayBox('','WorkFax',20,$row['WorkFax'],'');       
     
     
     echo '</td>';
     echo '<td>';
     
     echo 'NewsLetter:';
     
if ($view_mode == 1) 
{      
     GenericCheckBox("Newsletter",$row['Newsletter']);
}
else
{
    # echo $row['Newsletter'];
        echo "<span class='label'>";
    if ($row['Newsletter'] == 1 )  
    	echo ' Yes';
    else
        echo ' No';
        
    echo '</span>';     
}


#find_me	     
echo '&nbsp;&nbsp;&nbsp;Do Not Email:';
 

if ($view_mode == 1) 
{  
     GenericCheckBox("Do_Not_Email",$row['Do_Not_Email']);    
}
else
{
    # echo $row['Do_Not_Email'];
    echo "<span class='label'>";
    if ($row['Do_Not_Email'] == 1 )  
    	echo ' Yes';
    else
        echo ' No';    
        
    echo '</span>';     
}
     
      
     echo '</td>';
     echo '</tr>';

     print "<tr><td>";
      echo '<b>Address 1:';
     print "</td><td>";

 #title,name,size,value,trailer
$PlaceField->displayBox('','Address1',40,$row['Address1'],'');         

     echo '</td>';
     echo '<td>';


$PlaceField->displayBox('User1:','User1',3,$row['User1'],',&nbsp;&nbsp;');    
   
$PlaceField->displayBox('User2:','User2',3,$row['User2'],',&nbsp;&nbsp;');     
 
$PlaceField->displayBox('User3:','User3',3,$row['User3'],',&nbsp;&nbsp;');    
 
$PlaceField->displayBox('User4:','User4',3,$row['User4'],',&nbsp;&nbsp;');       
     echo '</td>';
     echo '</tr>';


     print "<tr><td>";
      echo '<b>Address 2:';
     print "</td><td>";
     
     
if ($view_mode == 1) 
{     
     echo '<input type=text name=Address2 onchange="dirty='."'true'".'" size=40 value="';
     echo $row['Address2'];
     echo '">';
}
else
{
     echo $row['Address2'];
}

 #title,name,size,value,trailer
#$PlaceField->displayBox('','Address2',40,$row['Address2'],''); 
       
     echo '</td>';
     echo '<td>';
     
 #title,name,size,value,trailer
$PlaceField->displayBox('Article Title:','Art_Title',25,$row['Art_Title'],' '); 



     echo '</td>';
     echo '</tr>';

     print "<tr><td>";
      echo '<b>City/State/Zip:';
     print "</td><td>";
     
#title,name,size,value,trailer
$PlaceField->displayBox('','City',20,$row['City'],', ');  
 
#title,name,size,value,trailer
$PlaceField->displayBox('','State',3,$row['State'],'&nbsp;&nbsp;');  
#title,name,size,value,trailer
$PlaceField->displayBox('','Zip',10,$row['Zip'],'');  

     echo '</td>';
     echo '<td>';
#title,name,size,value,trailer
$PlaceField->displayBox('Article Date:','Art_Date',10,$row['Art_Date'],'');   
     echo '</td>';
     echo '</tr>';


     print "<tr><td>";
      echo '<b>Country:';
     print "</td><td>";
     
if ($view_mode == 1) 
{     
     echo '<input type=text name=Country onchange="dirty='."'true'".'" size=25 value="';
     echo $row['Country'];
     echo '">';
     echo '&nbsp;&nbsp;&nbsp;Region';
     GenericDropDown($region_list,"Region",$row['Region']);   
}
else
{
     echo $row['Country'];
     echo '&nbsp;&nbsp;&nbsp;Region';
     echo $row['Region'];   
}
       
     echo '</td>';
     echo '<td>';

      echo 'Last Change User <font color=black>'.$row['last_change_user'].'</font>';

     echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';

     echo '<b>Last Change Date: <font color=black>';
     echo $row['last_change_date'];
     echo '</font>';
     
     echo '</td>';
     echo '</tr>';
     
 
     print "<tr><td colspan=1>";

     echo '<b>Key Info:';
     echo '</td><td colspan=2>';
     
if ($view_mode == 1) 
{     
     echo '<input type=text name=Key_Info onchange="dirty='."'true'".'" size=100 value="';
     echo $row['Key_Info'];
     echo '">';
}
else
{
     echo $row['Key_Info'];
}     
     echo '</td>';
     echo '</tr>';

     print "<tr><td colspan=3>";

     echo '</tr>';  

     echo '</table>';
 

 ?>