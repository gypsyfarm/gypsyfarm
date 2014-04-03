<?   
##########################################################
## This is a sample script and documentation for using
## the class.label.inc library
##
## This class requires the base classes class.pdf.inc
## and class.ezpdf.inc both of which are available
## from the author Wayne Munro:
## wayne munro - R&OS ltd
## pdf@ros.co.nz
## http://www.ros.co.nz/pdf
##
## This class's author:
## Craig Heydenburg
## craigh@mac.com
## April 18, 2002
##########################################################

## include the class
include ('class.label.php');

##########################################################
## currently you have three choices for $labeltype:
## 'Av5160' - this is an Avery 5160 label used for mailing labels
## 'CB7-OC' - this is an Avery nametag 'label' that makes nametags - duh!
## 'sign' -  this makes full page signs
## 
## The last two options currently are very personalized - i.e. they have
## graphics for my organization (MSBOA) and are graphically set up for me
## the Av5160 is pretty basic and could be used by anyone 'off the shelf'

## choose a labeltype
$labeltype="Av5160";

## create a new instance of the class of that labeltype
$label= new Clabel($labeltype);

##########################################################
## create some bogus data just for this example
## of course, you would probably be pulling this info from a database...
## you would need to loop through your resultset and assign it to an array in this format
$info=array(1=>array('line1'=>'John Smith', 'line2'=>'1000 First Street', 'line3'=>'PO Box 123', 'line4'=>'Anytown, CA 41000'),
			2=>array('line1'=>'Bill Gates', 'line2'=>'456 Money Way', 'line4'=>'Seattle, WA 16456'),
			3=>array('line1'=>'Steve Jobs', 'line2'=>'1 Inifinite Loop', 'line4'=>'Cupertino, CA 42389'));
reset($info); ## just to be sure

##########################################################
## The Av5160 is expecting an array of four values
## array ('line1'=> first line of address label (typically first and last name)
##        'line2'=> second line of address label (typically streeet address)
##        'line3'=> third line of address label (typically PO BOX)
##        'line4'=> fourth line of address label (typically city,state zip)
##       )
## the third line is optional and if it is not present, the class will omit it and
## move the fourth line up on the label

##########################################################
## The CB7-OC is expecting an array of two values
## array ('line1'=> first line of name tag (typically first and last name)
##        'line2'=> second line of nametag (typically duty or title or location)
##       )
## I guess either value could be null if you want it!

##########################################################
## The sign is expecting an array of three values
## array ('line1'=> top line of sign
##        'line2'=> main line of sign
##        'line3'=> bottom line of sign
##       )
## any of the three lines may be left null if desired

##########################################################
## make the labels! its that simple!
$label->makeLabel($info);

?>
