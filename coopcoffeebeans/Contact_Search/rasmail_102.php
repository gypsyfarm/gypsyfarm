<?php
/******************************************
* Script:   RasMail
* Author:   Alberto "RaS!" Sartori
* Contact:  ras78@caltanet.it
* Version:  1.02
* Created:  12/06/2002 12:19:37
* Revision: 11/03/2003 23:54:21
* License:  GNU Lesser General Public License
http://phpmailer.sourceforge.net/extending.html
********************************************/

//Building class
class MailSender {

    var $sender;
    var $recipient;
    var $oggetto;
    var $body;
    var $mailformat;
    var $priority;
    var $recipient_CC;
    var $recipient_BCC;
    var $attachedfile;

//Check sender
function Sender($sender) {
  if ($sender=="") {
   if ($_SERVER["SERVER_ADMIN"]) {
    if (!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,4}$", $_SERVER["SERVER_ADMIN"])) {
     $this->ErrorOutput(13);
    } else {
     $this->mittente=$_SERVER["SERVER_ADMIN"];
    }
   } else {
    $this->ErrorOutput(2);
   }
  } else {
  if (!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,4}$", $sender)) {
   $this->ErrorOutput(4);   
   } else $this->mittente=$sender;
  }
}

//Check recipient
function Recipient($recipient) {
  if ($recipient=="") {
   $this->ErrorOutput(1);
   exit;
  } else {
  if (!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,4}$", $recipient)) {
   $this->ErrorOutput(3);
   } else $this->destinatario=$recipient;
  }
}

//Check subject
function Subject($oggetto) {
  if ($oggetto!="") {
  $oggetto=str_replace("\'","'",$oggetto);
  $this->oggetto=$oggetto;   
  }
}

//Check body
function Body($body) {
  if ($body!="") {
   $this->body=$body;
  }
}

//Check mailformat
function Mailformat($mailformat) {
  if ($mailformat!="") {
   if ($mailformat!="1" && $mailformat!="0") {
     $this->ErrorOutput(5);  
   } else $this->formato=$mailformat;
  }
}

//Check priority
function Priority($priority) {
  if ($priority!="") {
   if ($priority!="5" && $priority!="3" && $priority!="1") {
     $this->ErrorOutput(6);  
   } else $this->priorita=$priority;
  }
}

//Check recipient CC
function RecipientCC($recipientCC) {
  if ($recipientCC!="") {
   if (!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,4}$", $recipientCC)) {
     $this->ErrorOutput(7);
   } else $this->destinatarioCC=$recipientCC;
  }
}

//Check recipient BCC
function RecipientBCC($recipientBCC) {
  if ($recipientBCC!="") {
   if (!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,4}$", $recipientBCC)) {
     $this->ErrorOutput(8);
   } else $this->destinatarioBCC=$recipientBCC;
  }
}

//Check attachment(s)
function Attachment($attachedfile) {
  if ($attachedfile) {
   if (is_file($attachedfile)) { #Single file detected
    $this->TypeOfAttachment="SINGLE";
    if (is_readable($attachedfile)) {
     $attachedfile_name=basename($attachedfile);
     $pf=@fopen($attachedfile,"r") or die($this->ErrorOutput(9));
     $bytes=fread($pf,filesize($attachedfile));
     $file=chunk_split(base64_encode($bytes));
     fclose($pf);
     echo "<br> ok we have a single attachment";
   #Check mime type, thanks to Markus Ernst
   $mimetype = array(
   'doc'=>'application/msword',
   'eps'=>'application/postscript',
   'htm'=>'text/html',
   'html'=>'text/html',
   'gif'=>'image/gif',
   'bmp'=>'image/bmp',
   'jpg'=>'image/jpeg',
   'pdf'=>'application/pdf',
   'txt'=>'text/plain',
   'xls'=>'application/vnd.ms-excel');
   $p = explode('.', $attachedfile_name);
   $pc = count($p);
    if ($pc > 1 AND isset($mimetype[$p[$pc - 1]])) {
     $mi = $mimetype[$p[$pc - 1]];
    } else {
    $mi = "application/octet-stream";
    }
   }
   $this->nome=$attachedfile_name;
   $this->allegato="OK";
   $this->mimetype=$mi;
   $this->filestream=$file;
  }

   if (is_array($attachedfile)) { #Multiple files detected (using array)
    $this->TypeOfAttachment="MULTIPLE";
    if (count($attachedfile)<=0 or count($attachedfile)=="") {
     $this->ErrorOutput(11);
    } else {
     unset($ai);
      #Creating an associative array with filenames(as key) and another
      #array with its filestream (as element[0]), and MIMETYPE (as element[1])
      for ($ai=0; $ai<=count($attachedfile)-1; $ai++) {
       $attachedfile_name=basename($attachedfile[$ai]);
       $pf=@fopen($attachedfile[$ai],"r") or die($this->ErrorOutput(9));
       $bytes=fread($pf,filesize($attachedfile[$ai]));
       $file=chunk_split(base64_encode($bytes));
       fclose($pf);
     #Check mime type, thanks to Markus Ernst
     $mimetype = array(
     'doc'=>'application/msword',
     'eps'=>'application/postscript',
     'htm'=>'text/html',
     'html'=>'text/html',
     'gif'=>'image/gif',
     'bmp'=>'image/bmp',
     'jpg'=>'image/jpeg',
     'pdf'=>'application/pdf',
     'txt'=>'text/plain',
     'xls'=>'application/vnd.ms-excel');
     $p = explode('.', $attachedfile_name);
     $pc = count($p);
      if ($pc > 1 AND isset($mimetype[$p[$pc - 1]])) {
       $mi = $mimetype[$p[$pc - 1]];
      } else {
       $mi = "application/octet-stream";
      }
     $this->allegato="OK";
     $Attachments[$attachedfile_name]=array($file,$mi);
    }
    $this->Allegati=$Attachments;
    }
   }
  }
  if (!$file and !$Attachments)
   $this->ErrorOutput(9);
}

//Main function of sendmail
function Execute() {
	
  #Check some settings before send the message
  if (!$this->mittente)
   $this->ErrorOutput(2);
  if (!$this->destinatario)
   $this->ErrorOutput(1);
  if (!$this->formato)
   $this->formato=1;
  #Setting up headers
  $forma=($this->formato==1)? "plain" : "html";
    $headers= "Date: ".date("D, d M Y H:m:s O",time())."\n";
  $headers.= "From: $this->mittente\n";

 # removed by pat newberry: mail() function adds to: section to header:
 #  $headers.= "To: $this->destinatario\n";

  if ($this->destinatarioCC)
   $headers.= "cc: $this->destinatarioCC\n";
  if ($this->destinatarioBCC)
   $headers.= "Bcc: $this->destinatarioBCC\n";

#  Removed to prevent duplicate subject.
#  if ($this->oggetto)
#   $headers.= "Subject: $this->oggetto\n";

  if ($this->priorita)
   $headers.= "X-Priority: $this->priorita\n";
  $headers.= "X-Mailer: RasMail-p_newberry 1.02\n";
 
 # removed by pat newberry as content type gets added latter 
 
 if (!$this->allegato) {
   $headers.= "Content-Type: text/$forma; charset=ISO-88592\n";  
 }
  
  $headers.= "Content-Transfer-Encoding: quoted-printable\n";
  if ($this->allegato) {
   $headers.= "MIME-Version: 1.0\n";
   $headers.= "Content-Type: multipart/mixed; ";  
   $headers.= "boundary=\"Message-Boundary\"\n";
  }
  $this->headers=$headers;

#Reset the body's headers if we have the attachment(s)
if ($this->allegato) {
  $body = "--Message-Boundary\n";
  $body .= "Content-Transfer-Encoding: 7bit\n";
  # changed to more generic charset - Pat Newberry
  # $body .= "Content-Type: text/$forma; charset=ISO-88592\n\n"; 
    $body .= "Content-Type: text/$forma; charset=us-ascii\n\n";  
  $body .= $this->body."\n\n";
if ($this->TypeOfAttachment=="SINGLE") {
  $body .= "--Message-Boundary\n";
  $body .= "Content-Type: ".$this->mimetype."; name=\"".$this->nome."\"\n";
  $body .= "Content-Transfer-Encoding: base64\n";
  $body .= "Content-Disposition: attachment; filename=\"".$this->nome."\"\n\n";
  $body .= $this->filestream."\n";
} elseif ($this->TypeOfAttachment=="MULTIPLE") {
  foreach($this->Allegati as $fn=>$filedata) {
   $body .= "--Message-Boundary\n";
   $body .= "Content-Type: ".$filedata[1]."; name=\"".$fn."\"\n";
   $body .= "Content-Transfer-Encoding: base64\n";
   $body .= "Content-Disposition: attachment; filename=\"".$fn."\"\n\n";
   $body .= $filedata[0]."\n";
  }
} else {
  $this->ErrorOutput(12);
}
  $body .= "--Message-Boundary--\n";
  $this->body=$body;
}

//Sending mail


@mail($this->destinatario, $this->oggetto, $this->body, $this->headers) or die($this->ErrorOutput(10));
//CUSTOMIZE YOUR RETURN MESSAGE
$end_message="->Mail succesfully delivered to <strong>$this->destinatario</strong><br> ";

echo $end_message;
return $end_message;
}

//Error trapping
function ErrorOutput($err_code) {
  if ($err_code!="") {
   switch($err_code) {
    case 1  : $err_msg="ERROR: Enter the recipient address!";
              break;
    case 2  : $err_msg="ERROR: Enter the sender address!";
              break;
    case 3  : $err_msg="ERROR: Mail address of recipient is not valid!";
              break;
    case 4  : $err_msg="ERROR: Mail address of sender is not valid!";
              break;
    case 5  : $err_msg="ERROR: The mailformat must be 0(textplain) or 1(html)";
              break;
    case 6  : $err_msg="ERROR: Set the priority 5(low), 3(normal), 1(high)";
              break;
    case 7  : $err_msg="ERROR: Mail address of CC recipient is not valid!";
              break;
    case 8  : $err_msg="ERROR: Mail address of BCC recipient is not valid!";
              break;
    case 9  : $err_msg="ERROR: File(s) doesn't exists, the path is incorrect or the filesize is null!";
              break;
    case 10 : $err_msg="ERROR: There's a problem sending mail. Check settings of your mailserver.";
              break;
    case 11 : $err_msg="ERROR: Array of attachments is empty or have invalid size (0).";
              break;
    case 12 : $err_msg="ERROR: Undefined kind of attachment!";
              break;
    case 13 : $err_msg="ERROR: You didn't specified the sender addresses, so it has been used the email address from php settings; but this is not valid (".$_SERVER["SERVER_ADMIN"].")";
              break;
    default : $err_msg="ERROR: Generic error!";
              break;
   }
  echo $err_msg;
  exit;
  }
}
}
?> 