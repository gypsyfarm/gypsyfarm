var newwindow;
function poptastic(url)
{
 
 // was h=300, w650
 	newwindow=window.open(url,'sample','width=850,height=600,resizable=yes,scrollbars=yes,left=300,top=150');
 	if (window.focus) {newwindow.focus()}
}
 
function nav(dropdown)
   {
 
   var w = dropdown.selectedIndex;
   var url_add = dropdown.options[w].value;
   window.location.href = url_add;
   }