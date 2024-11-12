<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear curso</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> 
  <link rel="stylesheet" href="Views/dashboard.css">
  <link rel="stylesheet" href="Views/crearCurso.css">
</head>

<body>
  <?php require 'Components/headerInstructor.php'; ?>
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
                window.location.href = '/BDM-CI/crearCurso';
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
                window.location.href = '/BDM-CI/crearCurso';
            });
        </script>";
    }

    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}
?>
  <form id="courseForm" method="POST" action="/BDM-CI/crearCurso" enctype="multipart/form-data" onsubmit="return validateCourse();">
<div class="container">
      <!-- Course Information Section -->
      <div class="row d-flex align-items-center mb-3">
        <h2 class="col-9">Crear Curso</h2>
        <button type="submit" class="col-2 btn btn-outline-info" id="publishCourseBtn">Publicar Curso</button>
      </div>

      <div class="row">
        <!-- Course Main Information -->
        <div class="col-xl-5 mb-5">
          <div class="col p-3 bg-body-secondary rounded">
            <h2 class="mb-4">Información del curso</h2>
            <hr>

            <!-- Banner Upload -->
            <div class="row px-2">
              <label for="courseBanner" class="form-label">Banner del Curso</label>
              <div class="mb-3 row justify-content-center align-items-center">
                <label for="courseBanner" class="col-form-label col-2 text-center">
                  <h3 class="mb-0"><i class="bi bi-card-image"></i></h3>
                </label>
                <div class="col-10 d-flex justify-content-center">
                  <input type="file" id="courseBanner" name="Imagen" class="form-control mb-2" accept="image/*" required onchange="previewImage(event)" style="max-width: 400px;">
                </div>
              </div>
              <img id="imagePreview" src="" alt="Vista previa" class="course-image img-fluid rounded" style="display: none;">
            </div>

            <!-- Course Title -->
            <input type="text" name="Titulo" class="couse-title" placeholder="Título del curso" required>

            <!-- Course Description -->
            <div class="row">
            <textarea name="Descripcion" class="course-desc" placeholder="Descripción del curso" required></textarea>
            </div>

            <!-- Category Selection -->
           <div class="mb-3 col-7" style="max-width: 280px;">
               <label for="category" class="form-label">Categoría</label>
               <select id="category" name="ID_Categoria" class="form-select" required>
                   <option value="">Selecciona una categoría</option>
                   <?php foreach ($categories as $category): ?>
                       <option value="<?= htmlspecialchars($category['ID_Categoria']); ?>">
                           <?= htmlspecialchars($category['Nombre']); ?>
                       </option>
                   <?php endforeach; ?>
               </select>
           </div>

            <!-- Course Price -->
            <div class="row">
              <label for="couse-price" class="form-label">Precio</label>
              <div class="ms-3 form-check d-flex align-items-center">
                <input type="checkbox" name="Gratuito" class="form-check-input me-2" value="1" id="isFree" data-bs-toggle="tooltip" title="en caso de no estar activo, el curso será gratuito" onchange="toggleFreeValue()">
                <div class="input-group" style="max-width: 280px;">
                <input type="hidden" name="Gratuito" value="1" id="isFreeHidden">
                  <span class="input-group-text">MX $</span>
                  <input type="number" step=0.01 min=0 name="Costo_Total" class="form-control" id="couse-price">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Levels Section -->
        <div class="col-xl-6 mb-5">
          <div class="col p-3 bg-body-secondary rounded" id="levelsContainer">
            <div class="row mb-0">
              <h2 class="col">Niveles</h2>
              <button type="button" class="col-1 me-5 btn btn-info rounded-circle" id="addElementsBtn"> <i class="bi bi-plus fs-5"></i> </button>
            </div>
            <hr>
            
            <!-- Level Cards -->
            <div id="levelList">
              <div class="row level" data-index="0">
               <div class="card mb-3 p-3 level-card" style="max-width: 540px;">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="https://assetsio.gnwcdn.com/magic-the-gathering-hatsune-miku-secret-lair-music-video-screenshot.png?width=1200&height=1200&fit=bounds&quality=70&format=jpg&auto=webp" class="img-fluid rounded" alt="Nivel Image">

                    <div class="mt-3 form-check px-1">
                      <label for="level-price-0" class="form-label mb-1">Precio:</label>
                      <div class="ms-0 form-check d-flex align-items-center">
                        <input class="form-check-input me-2 level-free-checkbox" type="checkbox" value="0" id="flexCheckChecked-0" name="Nivel[0][Gratuito]" checked data-bs-toggle="tooltip" title="en caso de no estar activo, el nivel será gratuito" onchange="toggleFreeValueLvl(0)">
                        <input type="hidden" name="Nivel[0][Gratuito]" value="0" id="flexCheckCheckedHidden-0">

                        <div class="input-group" style="max-width: 240px;">
                          <span class="input-group-text px-2">MX $</span>
                          <input type="number" step=0.01 min=0 name="Nivel[0][Costo_Nivel]" id="level-price-0" class="form-control level-price">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                    <div class="row align-items-center">
                    <input type="text" name="Nivel[0][Titulo]" class="form-control level-title mb-3 text-wrap" placeholder="Titulo del nivel" required>
                    </div>
                    <div class="row">
                      <div class="mb-3 row align-items-center">
                        <label for="formFile-0" class="col-form-label col-2">
                          <h3 class="mb-0"><i class="bi bi-file-earmark-text"></i></h3>
                        </label>
                        <div class="col-10">
                          <input class="form-control" type="file" id="formFile-0" name="Nivel[0][Adjunto]" accept=".pdf, .docx, .zip, .txt">
                        </div>
                      </div>

                      <div class="mb-3 row align-items-center">
                        <label for="formVideo-0" class="col-form-label col-2">
                          <h3 class="mb-0"><i class="bi bi-play-btn"></i></h3>
                        </label>
                        <div class="col-10">
                          <input class="form-control" type="file" id="formVideo-0" name="Nivel[0][Video]" accept="video/mp4" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               </div>
              </div>
              <!-- Additional level cards will be added here via JavaScript -->
            </div>
          </div>
        </div>
      </div>
    </div>

  </form>
<script>
function validateCourse() {
    let valid = true;

    // Validar el banner
    const bannerInput = document.getElementById('courseBanner');
    if (!bannerInput.files.length) {
        alert("Debes seleccionar un banner para el curso.");
        valid = false;
    }

    // Validar el título del curso
    const courseTitle = document.querySelector('.couse-title');
    if (courseTitle.value.trim() === "") {
        alert("El título del curso es obligatorio.");
        valid = false;
    }

    // Validar la descripción del curso
    const courseDesc = document.querySelector('.course-desc');
    if (courseDesc.value.trim() === "") {
        alert("La descripción del curso es obligatoria.");
        valid = false;
    }

    // Validar la categoría
    const category = document.getElementById('category');
    if (category.value === "") {
        alert("Debes seleccionar una categoría.");
        valid = false;
    }

    // Validar el precio solo si el curso no es gratuito
    const isPaidCheckbox = document.getElementById('isFree');
    const priceInput = document.getElementById('couse-price');
    const price = parseFloat(priceInput.value.trim());

    // Verificar si el curso no es gratuito y el precio es menor o igual a 0
    if (isPaidCheckbox.checked && (price <= 0 || isNaN(price))) {
        alert('El precio del curso debe ser mayor que 0 si no es gratuito.'); 
        valid = false;
    }

    const levels = document.querySelectorAll('#levelsContainer .card');
levels.forEach((level, index) => {
    // Validar título del nivel
    const levelTitle = level.querySelector('.level-title');
    if (levelTitle.value.trim() === "") {
        alert(`El título del Nivel ${index + 1} es obligatorio.`);
        valid = false;
    }

    // Validar video del nivel
    const videoInput = level.querySelector('input[type="file"][accept="video/mp4"]');
    if (!videoInput.files.length) {
        alert(`Debes subir un video para el Nivel ${index + 1}.`);
        valid = false;
    }

    // Validar el precio del nivel solo si no es gratuito
    const levelIsFreeCheckbox = level.querySelector('.level-free-checkbox'); 
    const levelPriceInput = level.querySelector('.level-price');
    const levelPrice = parseFloat(levelPriceInput.value.trim());

    // Verificar si el nivel no es gratuito y el precio es menor o igual a 0
    if (levelIsFreeCheckbox.checked && (levelPrice <= 0 || isNaN(levelPrice))) {
        alert(`El precio del Nivel ${index + 1} debe ser mayor que 0 si no es gratuito.`);
        valid = false;
    }
});

return valid;
}

function toggleFreeValue() {
    const checkbox = document.getElementById('isFree');
    const hiddenInput = document.getElementById('isFreeHidden');
    // Cambia el valor a "1" si está desmarcado (gratuito) o "0" si está marcado (no gratuito)
    checkbox.value = checkbox.checked ? '0' : '1';
    hiddenInput.value = checkbox.checked ? '0' : '1';
}

function toggleFreeValueLvl(index) {
    const checkbox = document.getElementById('flexCheckChecked-' + index);
    const hiddenInput = document.getElementById('flexCheckCheckedHidden-' + index);

    // Cambia el valor del campo oculto dependiendo del estado del checkbox
    if (checkbox.checked) {
        checkbox.value = '0';  // No gratuito (marcado)
        hiddenInput.value = '0';  // No gratuito (marcado)
    } else {
        checkbox.value = '1';  // Gratuito (desmarcado)
        hiddenInput.value = '1';  // Gratuito (desmarcado)
    }
}
</script>
    <script src="Views/crearCurso.js"></script>
</body>
</html>