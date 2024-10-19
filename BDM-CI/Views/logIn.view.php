<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Cuenta</title>

  

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
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
                // Redirigir a la página de iniciar sesion después de cerrar la alerta
                window.location.href = '/BDM-CI/signUp';
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
                // Redirigir a la página de logIn después de cerrar la alerta
                window.location.href = '/BDM-CI/logIn';
            });
        </script>";
    }

    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}
?>

<?php // for each de testeo para ver que jale los datos de la bd
  foreach ($users as $user): ?>
        
  <p class="">
    <?= htmlspecialchars($user['Email']) ?> / <?= htmlspecialchars($user['Nombre']) ?>
  </p>
<?php endforeach; ?> 


  <div class="d-flex flex-column w-100 vh-100 align-items-center justify-content-center bg-light-subtle">

    <div class="container bg-info-subtle text-primary-emphasis rounded p-5">
      <div class="row mx-auto align-items-center justify-content-center d-flex">
  
        <div class="col-lg-6">
          <h1>¡Bienvenido!</h1>
          <p class="fs-4 text">Ahora necesitamos que nos cuentes un poco de ti :)</p>
        </div>
    
        <div class="col-lg-6">
          <form class="row g-3 needs-validation"  method="POST" enctype="multipart/form-data" novalidate>
            <div class="col-md-4">
              <label for="Nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="Nombre" name="Nombre" required>
              <div class="valid-feedback">
                Todo bien!
              </div>
              <div class="invalid-feedback">
                Ingresa tu nombre.
              </div>
            </div>
            <div class="col-md-4">
              <label for="Apellido" class="form-label">Apellido</label>
              <input type="text" class="form-control" id="Apellido" name="Apellido" required>
              <div class="valid-feedback">
                Todo bien!
              </div>
              <div class="invalid-feedback">
                Ingresa tu apellido.
              </div>
            </div>
            <div class="col-md-4">
              <label for="Genero" class="form-label">¿Qué género eres?</label>
              <select class="form-select" id="Genero" name="Genero" required>
                <option selected value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
              </select>
              <div class="invalid-feedback">
                Selecciona tu género.
              </div>
            </div>

            <div class="col-md-12">
                <label for="Foto" class="form-label">Foto de Perfil</label>
                <input type="file" class="form-control" id="Foto" name="Foto" accept="image/*" required>
                <div class="invalid-feedback">
                    Debes seleccionar una imagen.
                </div>
            </div>
            <div class="col-md-6">
              <label for="Rol" class="form-label">¿Qué rol eres?</label>
              <select class="form-select" id="Rol" name="Rol" required>
                <option selected value="Alumno">Alumno</option>
                <option value="Instructor">Instructor</option>
              </select>
              <div class="invalid-feedback">
                Selecciona tu rol.
              </div>
            </div>
            <div class="col-md-6">
              <label for="FechaDeNacimiento" class="form-label">Fecha de Nacimiento</label>
              <input type="date" class="form-control" id="FechaDeNacimiento" name="FechaDeNacimiento" required>
              <div class="invalid-feedback">
                Ingresa tu fecha de nacimiento
              </div>
            </div>
            <div class="col-md-12">
              <label for="Email" class="form-label">Correo Electronico</label>
              <input type="email" class="form-control" id="Email" name="Email" required>
              <div class="invalid-feedback">
                Ingresa una dirección de correo válida.
              </div>
            </div>

            <div class="col-md-12">
              <label for="Password" class="form-label">Contraseña</label>
              <input type="password" id="Password" name="Password" class="input-pass" aria-describedby="passwordHelpBlock" required>
              <div id="passwordHelpBlock" class="form-text">
                Tu contraseña debe de tener más de 8 caracteres, minimo una mayúscula, un caracter especial y un número
              </div>
              <div class="invalid-feedback">
                  Ingresa una contraseña correcta.
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

  const submitButton = $("#CrearCuenta");
  const passwordInput = $("#Password");
  const nameInput = $("#Nombre");
  const surnameInput = $("#Apellido");
  const genderSelect = $("#Genero");
  const roleSelect = $("#Rol");
  const birthdateInput = $("#FechaDeNacimiento");
  const emailInput = $("#Email");
  const termsCheckbox = $("#invalidCheck"); 
  const profilePhotoInput = $("#Foto");

  submitButton.on("click", function(event) {

    let valid = true;

    // Validar nombre y apellido (no vacíos ni solo espacios)
    if (nameInput.val().trim() === "" || surnameInput.val().trim() === "") {
      nameInput.addClass("is-invalid");
      surnameInput.addClass("is-invalid");
      valid = false;
    } else {
      nameInput.removeClass("is-invalid").addClass("is-valid");
      surnameInput.removeClass("is-invalid").addClass("is-valid");
    }

    // Validar género
    if (genderSelect.val() === "") {
      genderSelect.addClass("is-invalid");
      valid = false;
    } else {
      genderSelect.removeClass("is-invalid").addClass("is-valid");
    }

    // Validar rol
    if (roleSelect.val() === "") {
      roleSelect.addClass("is-invalid");
      valid = false;
    } else {
      roleSelect.removeClass("is-invalid").addClass("is-valid");
    }

    // Validar fecha de nacimiento (no en el futuro)
    const today = new Date();
    const birthdate = new Date(birthdateInput.val());
    if (birthdate > today || isNaN(birthdate.getTime())) {
      birthdateInput.addClass("is-invalid");
      valid = false;
    } else {
      birthdateInput.removeClass("is-invalid").addClass("is-valid");
    }

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

    if (!termsCheckbox.is(':checked')) {
      termsCheckbox.addClass("is-invalid");
      valid = false;
    } else {
      termsCheckbox.removeClass("is-invalid").addClass("is-valid");
    }

    // Validar foto de perfil (no nula y solo imágenes permitidas)
    const file = profilePhotoInput[0].files[0];
    const validImageTypes = ["image/jpeg", "image/png", "image/jpg"];
    
    if (!file || !validImageTypes.includes(file.type)) {
      profilePhotoInput.addClass("is-invalid");
      valid = false;
    } else {
      profilePhotoInput.removeClass("is-invalid").addClass("is-valid");
    }

    if (!valid) {
      event.preventDefault(); // Prevent form submission if any validation fails
    }

  });
});
</script>
  

</body>

</html>