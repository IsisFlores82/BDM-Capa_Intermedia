<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de Sesion</title>

  

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
          <p class="fs-4 text">Inicia sesión y continua aprendiendo :)</p>
        </div>
    
        <div class="col-lg-6">
          
          <form class="row g-3 needs-validation" id="loginForm">
            <div class="col-md-12">
              <label for="validationCustom07" class="form-label">Correo Electronico</label>
              <input type="email" class="form-control" id="validationCustom07" required>
              <div class="invalid-feedback">
                Ingresa una dirección de correo válida.
              </div>
            </div>

            <br>

            <div class="col-md-12">
              <label for="inputPassword5" class="form-label">Contraseña</label>
              <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" required>
              <div class="invalid-feedback">
                <!-- contraseña incorrecta cuando el back lo regrese-->
                 Contraseña incorrecta
              </div>
              <div  class="text-end">
                <a href="">Olvidé mi contraseña</a>
              </div>
            </div>

            <br><br>

            <div class="col-12 align-items-center justify-content-center d-flex">
              <button class="btn btn-primary fs-4 text" type="submit" id="CrearCuenta">Iniciar Sesión</button>

              <!-- Botón para Iniciar Sesión con Google -->
              <button class="btn btn-outline-secondary fs-4 d-flex align-items-center" type="button" style="margin-left: 1rem; background: #fff;">
                <img src="https://cdn4.iconfinder.com/data/icons/logos-brands-7/512/google_logo-google_icongoogle-512.png" alt="Google" style="width: 20px; height: 20px; margin-right: 8px;">
                Iniciar con Google
              </button>
            </div>
            <div class="col-12 align-items-center justify-content-center d-flex">
              <a href="/BDM-CI/logIn" class="btn btn-outline-secondary"> Crear cuenta</a>
            </div>
          </form>
        </div>s
  
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

      
document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("validationCustom07").value.trim();
    const password = document.getElementById("inputPassword5").value.trim();
    
    if (email === "" || password === "") {
        alert("Por favor, ingresa tu correo y contraseña.");
    } else {
        // Si todo está bien, redirige manualmente
        window.location.href = "/BDM-CI/dashboard";
    }
});


  </script>
  
</body>

</html>