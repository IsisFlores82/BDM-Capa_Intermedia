
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()


const submitButton = $("#CrearCuenta"); // Corrected selector based on feedback
const passwordInput = $("#inputPassword5");
const passwordValue = passwordInput.val();


submitButton.click(function(event) {
  event.preventDefault(); // Prevent default form submission  aaaa

  const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

  if (passwordRegex.test(passwordValue)) {
    passwordInput.addClass("is-valid");
    passwordInput.addClass("was-validated");
  } else {
    passwordInput.addClass("is-invalid");
    passwordInput.removeClass("was-validated");

    // Optionally, display an error message:
    alert("Please enter a strong password that meets the requirements.");
  }
});




  
  /*function checkPass( passToCheck ){
    const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/

    if (regex.test(passToCheck)){
       inputPass.addClass("was-validated")
    }
    else{
      inputPass.removeClass("was-validated")
    }

  }*/




  