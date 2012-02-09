/**
 * validate the recipe input
 */
function validateFormOnSubmit() {
	
	var reason = "";
	var theForm=document.getElementById('form');

  reason += validateEmpty(theForm.name);
  reason += validateTextFields(theForm.ingredients);
  reason += validateTextFields(theForm.steps);
      
  if (reason != "") {
    alert("Some fields need correction:\n" + reason);
   return false;
  }

  return true;
}
function validateEmpty(fld) {
    var error = "";
  
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "The required field has not been filled in.\n"
    } else {
        fld.style.background = 'White';
    }
    return error;   
}
function validateTextFields(fld) {
    var error = "";
  
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "The required field has not been filled in.\n"
    }
    else if(fld.value.length<20){
    	fld.style.background = 'Yellow'; 
        error = "Textfield must have more than 20 characters.\n"
    }else {
        fld.style.background = 'White';
    }
    return error;   
}