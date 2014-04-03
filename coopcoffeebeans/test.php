<form name="sample">
<input type="text" 
       name="info" 
       value="o knows what evil lurks in the hearts of men?" 
       size=80> 
<br>
<input type="button" 
       name="click" 
       value="Again"
       onClick="document.sample.info.value='Dont screw with me'">
<input type="button" 
       name="clickme" 
       value="Click Me"
       onClick="document.sample.info.value='The Shadow Knows'">



<INPUT TYPE="text" VALUE="Enter email address" NAME="userEmail" onblur=validateInput(this.value)>
</form>
<script type="text/javascript" language="JavaScript">

this.sample.userEmail.focus()
this.sample.userEmail.select()

function validateInput() {
userInput = new String()
userInput = this.sample.userEmail.value
 if (userInput.match("@"))
    
    alert("Thanks for your interest.")
 else
    alert("Please check your email details are correct before submitting")
}

</script> 



