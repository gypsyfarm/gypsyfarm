var req = createXMLHttpRequest();  
  
function createXMLHttpRequest() {  
 var ua;  
 if(window.XMLHttpRequest) {  
 try {  
  ua = new XMLHttpRequest();  
 } catch(e) {  
  ua = false;  
 }  
 } else if(window.ActiveXObject) {  
  try {  
    ua = new ActiveXObject("Microsoft.XMLHTTP");  
  } catch(e) {  
    ua = false;  
  }  
 }  
return ua;  
}  
  
function sendRequest(frm, file) {  
//alert("hello alert");
 var rnd982g = Math.random();  
 var str = "";  
 if(str = getForm(frm)) {  
  req.open('GET', file+'?'+str+'&rnd982g='+rnd982g);  
 //  alert(file+'?'+str+'&rnd982g='+rnd982g); 
  req.onreadystatechange = handleResponse;  
  req.send(null);  
 }  
 return false;  
}  
  
function handleResponse() {  
 if(req.readyState == 4){  
  var response = req.responseText;  
 // response  += "what about this...";
 // alert("response = " + response);
  document.getElementById("results").innerHTML = response;  
 }  
}  
  
function getForm(fobj) {  
 var str = "";  
 var ft = "";  
 var fv = "";  
 var fn = "";  
 var els = "";  
 for(var i = 0;i < fobj.elements.length;i++) {  
  els = fobj.elements[i];  
  ft = els.title;  
  fv = els.value;  
  fn = els.name;  
 switch(els.type) {  
  case "text":  
  case "hidden":  
  case "password":  
  case "textarea":  
  // is it a required field?  
  if(encodeURI(ft) == "required" && encodeURI(fv).length < 1) {  
    alert('\''+fn+'\' is a required field, please complete.');  
    els.focus();  
    return false;  
  }  
  str += fn + "=" + encodeURI(fv) + "&";  
  break;   
  
  case "checkbox":  
  case "radio":  
   if(els.checked) str += fn + "=" + encodeURI(fv) + "&";  
  break;      
  
  case "select-one":  
    str += fn + "=" +  
    els.options[els.selectedIndex].value + "&";  
  break;  
  } // switch  
 } // for  
 str = str.substr(0,(str.length - 1));  
 return str;  
}  