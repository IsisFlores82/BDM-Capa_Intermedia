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
// Cargar la configuración de Facebook desde el archivo config.php
$config = require('config.php');
$facebookConfig = $config['facebook'];
?>
    <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $facebookConfig['id']; ?>',
      cookie     : true,
      xfbml      : true,
      version    : '<?php echo $facebookConfig['version']; ?>'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
   
FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
});


function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

function statusChangeCallback(response) {
  console.log('Facebook login status:', response);

  // Verifica el estado de la conexión
  if (response.status === 'connected') {
    // El usuario está conectado a Facebook y tiene un token de acceso válido
    console.log('Conectado a Facebook con el token:', response.authResponse.accessToken);
    // Puedes hacer una llamada para obtener información del usuario aquí
    obtenerInfoUsuario();
  } else {
    // El usuario no está conectado
    console.log('No está conectado a Facebook');
    // Puedes mostrar un mensaje de error o redirigir al usuario para que se loguee
  }
}

// Función para obtener información del usuario después de iniciar sesión
function obtenerInfoUsuario() {
  FB.api('/me', { fields: 'id,name,email' }, function(response) {
    console.log('Información del usuario:', response);
 // Extraer nombre completo y separar en nombre y apellido
    var fullName = response.name; // El nombre completo (nombre y apellido)
    var nameParts = fullName.split(" "); // Divide el nombre completo por el espacio
    var firstName = nameParts[0]; // El primer nombre
    var lastName = nameParts.slice(1).join(" "); // El apellido (puede contener más de una palabra)

    // Rellenar los campos del formulario con los datos
    document.getElementById('Nombre').value = firstName;
    document.getElementById('Apellido').value = lastName;
    document.getElementById('Email').value = response.email;
  });
}

</script>

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
            <div class="col-12 align-items-center justify-content-center d-flex">
                              <fb:login-button 
  scope="public_profile,email"
  onlogin="checkLoginState();"> Rellenar con Datos Facebook
</fb:login-button>
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
    console.log(today);
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