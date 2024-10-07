<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Cuenta</title>

  

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="Views/logIn.css">

  
</head>
<body>

  <div class="d-flex flex-column w-100 vh-100 align-items-center justify-content-center bg-light-subtle">

    <div class="container bg-info-subtle text-primary-emphasis rounded p-5">
      <div class="row mx-auto align-items-center justify-content-center d-flex">
  
        <div class="col-lg-6">
          <h1>¡Bienvenido!</h1>
          <p class="fs-4 text">Ahora necesitamos que nos cuentes un poco de ti :)</p>
        </div>
    
        <div class="col-lg-6">
          <form class="row g-3 needs-validation" novalidate>
            <div class="col-md-4">
              <label for="validationCustom01" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="validationCustom01" required>
              <div class="valid-feedback">
                Todo bien!
              </div>
            </div>
            <div class="col-md-4">
              <label for="validationCustom02" class="form-label">Apellido</label>
              <input type="text" class="form-control" id="validationCustom02" required>
              <div class="valid-feedback">
                Todo bien!
              </div>
            </div>
            <div class="col-md-4">
              <label for="validationCustom04" class="form-label">¿Qué eres?</label>
              <select class="form-select" id="validationCustom04" required>
                <option selected disabled value=""> Selecciona</option>
                <option value="Mujer">Mujer</option>
                <option value="Hombre">Hombre</option>
                <option value="Otro">Prefiero no decirlo</option>
              </select>
              <div class="invalid-feedback">
                Selecciona tu género.
              </div>
            </div>
           
            <div class="col-md-6">
              <label for="validationCustom04" class="form-label">¿Qué eres?</label>
              <select class="form-select" id="validationCustom05" required>
                <option selected disabled value=""> Rol</option>
                <option>Alumno</option>
                <option>Instructor</option>
              </select>
              <div class="invalid-feedback">
                Selecciona tu rol.
              </div>
            </div>
            <div class="col-md-6">
              <label for="validationCustom05" class="form-label">Fecha de Nacimiento</label>
              <input type="date" class="form-control" id="validationCustom06" required>
              <div class="invalid-feedback">
                Ingresa tu fecha de nacimiento
              </div>
            </div>
            <div class="col-md-12">
              <label for="validationCustom03" class="form-label">Correo Electronico</label>
              <input type="email" class="form-control" id="validationCustom07" required>
              <div class="invalid-feedback">
                Ingresa una dirección de correo válida.
              </div>
            </div>

            <div class="col-md-12">
              <label for="inputPassword5" class="form-label">Contraseña</label>
              <input type="password" id="inputPassword5" class="input-pass" aria-describedby="passwordHelpBlock" required>
              <div id="passwordHelpBlock" class="form-text">
                Tu contraseña debe de tener más de 8 caracteres, minimo una mayúscula, un caracter especial y un número
              </div>
            </div>

            
            
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                <label class="form-check-label" for="invalidCheck">
                  Acepto términos y condiciones.
                </label>
                <div class="invalid-feedback">
                  Debes de aceptar antes de continuar.
                </div>
              </div>
            </div>
            
            <div class="col-12 align-items-center justify-content-center d-flex">
              <button class="btn btn-primary fs-4 text" type="submit" id="CrearCuenta">Empieza a aprender!</button>
            </div>

            <div class="col-12 align-items-center justify-content-center d-flex">
            <a href="/BDM-CI/signUp" class="btn btn-outline-secondary"> Ya tengo cuenta</a>
            </div>
          </form>
        </div>
  
      </div>
      
    </div>

  </div>
  

  <script>


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

      
$(document).ready(function() {
    
    const submitButton = $("#CrearCuenta"); // Corrected selector based on feedback
    const passwordInput = $("#inputPassword5");
  
  
    /*passwordInput.on("input", function(event) {
      //event.preventDefault(); // Prevent default form submission  aaaa
      console.log("entra a checar pass");
      
      const passwordValue = passwordInput.val();
      const regex = new RegExp("^(?=.*[A-Z])(?=.*\\d)(?=.*[a-z])(?=.*[!@#$%^&*()_+.])[A-Za-z\\d!@#$%^&*()_+\\.]{8,}$");
  
      if (regex.test(passwordValue)) {
        
        //passwordInput.removeClass("form-control");
        console.log("pass valida");
        console.log(passwordValue);
        passwordInput.addClass("is-valid");
        passwordInput.addClass("was-validated");
  
      } else {
        passwordInput.removeClass("form-control");
        passwordInput.removeClass("is-valid");
        passwordInput.addClass("is-invalid");   
        passwordInput.addClass(":invalid");        
        
        console.log("pass invalida"); 
  
        // Optionally, display an error message:
        console.log("ingresa una mejor contraseña, tonto");
        console.log(passwordValue);
        console.log("Regex usado:", regex);
        console.log("Resultado del test:", regex.test(passwordValue));

      }
    });*/

    submitButton.on("click", function(event) {
      
      console.log("entra a checar pass");
      
      const passwordValue = passwordInput.val();
      const regex = new RegExp("^(?=.*[A-Z])(?=.*\\d)(?=.*[a-z])(?=.*[!@#$%^&*()_+.])[A-Za-z\\d!@#$%^&*()_+\\.]{8,}$");
  
      if (regex.test(passwordValue)) {
        
        passwordInput.addClass("form-control");
        console.log("pass valida");
        console.log(passwordValue);
        passwordInput.addClass("is-valid");
        //passwordInput.addClass("was-validated");
  
      } else {
        passwordInput.addClass("form-control");
        passwordInput.removeClass("is-valid");
        passwordInput.addClass("is-invalid");   
        passwordInput.addClass(":invalid");        
        
        console.log("pass invalida"); 
  
        // Optionally, display an error message:
        console.log("ingresa una mejor contraseña, tonto");
        console.log(passwordValue);
        console.log("Regex usado:", regex);
        console.log("Resultado del test:", regex.test(passwordValue));
        event.preventDefault(); // Prevent default form submission  aaaa

      }
    });
  
  
  
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

  </script>
  

</body>

</html>