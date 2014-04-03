<?php 
//Example of use 
include("rasmail_102.php"); 

$NewMail=new MailSender(); 
$NewMail->Sender("pkn@gypsyfarm.com"); 
$NewMail->Recipient("pnewberry@hfhi.org"); 
$NewMail->Subject("Hello World!"); 
$NewMail->Body("The subject sucks!"); 
$NewMail->Mailformat("1"); 
$NewMail->Priority("3"); 
$NewMail->Attachment("attachments/gv&dc_two.doc");
$NewMail->Execute(); 
?>    
 
