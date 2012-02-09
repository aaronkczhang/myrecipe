/**
 * validate the upload format
 * 
 */

function validateFormOnSubmit() {
	
	var reason = "";
	var theForm=document.getElementById('form');

  reason += validateEmpty(theForm.file);
  
  
 
      
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


