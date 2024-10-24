<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de Sesion</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="Views/logIn.css">

  
</head>
<body>

<?php
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $alertType = $mensaje['type'] == 'success' ? '¡Éxito!' : 'Error';

    // Check if the message is for a successful registration
    if ($mensaje['type'] == 'success') {
        echo "<script>
            swal({
                title: '$alertType',
                text: '{$mensaje['text']}',
                type: '{$mensaje['type']}',
                showConfirmButton: true
            }, function() {
                // Redirigir al dashboard
                window.location.href = '/BDM-CI/';
            });
        </script>";
    } else {
        echo "<script>
            swal({
                title: '$alertType',
                text: '{$mensaje['text']}',
                type: '{$mensaje['type']}',
                showConfirmButton: true
            }, function() {
                // Redirigir a la página de signUp después de cerrar la alerta
                window.location.href = '/BDM-CI/signUp';
            });
        </script>";
    }

    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}
?>
  <div class="d-flex flex-column w-100 vh-100 align-items-center justify-content-center bg-light-subtle">

    <div class="container bg-info-subtle text-primary-emphasis rounded p-5">
      <div class="row mx-auto align-items-center justify-content-center d-flex">
  
        <div class="col-lg-6">
          <h1>¡Bienvenido!</h1>
          <p class="fs-4 text">Inicia sesión y continua aprendiendo :)</p>
        </div>
    
        <div class="col-lg-6">
          
          <form class="row g-3 needs-validation" method = "post" id="loginForm">
            <div class="col-md-12">
              <label for="Email" class="form-label">Correo Electronico</label>
              <input type="email" class="form-control" id="Email" name="Email" required>
              <div class="invalid-feedback">
                Ingresa una dirección de correo válida.
              </div>
            </div>

            <br>

            <div class="col-md-12">
              <label for="Password" class="form-label">Contraseña</label>
              <input type="password" id="Password" class="form-control" name="Password" aria-describedby="passwordHelpBlock" required>
              <div class="invalid-feedback">
                 Contraseña incorrecta
              </div>
            </div>

            <br><br>

            <div class="col-12 align-items-center justify-content-center d-flex">
              <button class="btn btn-primary fs-4 text" type="submit" name="Login" id="login">Iniciar Sesión</button>
            </div>
            <div class="col-12 align-items-center justify-content-center d-flex">
              <a href="/BDM-CI/logIn" class="btn btn-outline-secondary"> Crear cuenta</a>
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
  const emailInput = $("#Email");
  const passwordInput = $("#Password");
  const loginButton = $("#login");

  loginButton.on("click", function(event) {

    let valid = true;

    // Validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.val())) {
      emailInput.addClass("is-invalid");
      valid = false;  
    } else {
      emailInput.removeClass("is-invalid").addClass("is-valid");
    }

    // Validar contraseña
    const passwordValue = passwordInput.val();
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*()_+.])[A-Za-z\d!@#$%^&*()_+\\.]{8,}$/;

    if (passwordRegex.test(passwordValue)) {
      passwordInput.removeClass("is-invalid").addClass("is-valid");
    } else {
      passwordInput.addClass("is-invalid");
      valid = false;
    }

    if (!valid) {
      event.preventDefault(); // Prevent form submission if any validation fails
    }

  });
});


  </script>
  
</body>

</html>