<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Curso</title>
  
  <!-- Styles and Scripts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="Views/dashboard.css">
  <link rel="stylesheet" href="Views/crearCurso.css">
</head>
<body>
  <?php require 'Components/headerInstructor.php'; ?>

  <form id="editCourseForm" method="POST" action="/BDM-CI/editarCurso" enctype="multipart/form-data" onsubmit="return validateEditCourse();">
    <input type="hidden" name="ID_Curso" value="<?= htmlspecialchars($course['ID_Curso']); ?>">
    
    <div class="container">
      <div class="row mb-3">
        <h2 class="col-9">Editar Curso</h2>
        <button type="submit" class="col-2 btn btn-outline-info">Guardar Cambios</button>
      </div>

      <!-- Course Information Section -->
      <div class="row">
        <div class="col-xl-5 mb-5">
          <div class="p-3 bg-body-secondary rounded">
            <h2 class="mb-4">Información del Curso</h2>
            <hr>

            <!-- Course Banner -->
            <div class="mb-3">
                <label for="courseBanner" class="form-label">Banner del Curso</label>
                <input type="file" id="courseBanner" name="Imagen" class="form-control" accept="image/*" onchange="previewImage(event)">

                <?php 
                // Verificar si la imagen del curso existe y es un BLOB
                if (!empty($course['Imagen'])) {
                    // Obtener el tipo MIME de la imagen desde el BLOB
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->buffer($course['Imagen']);

                    // Convertir la imagen en base64
                    $imagenBase64 = base64_encode($course['Imagen']);

                    // Crear la cadena de imagen base64
                    $imageSrc = "data:" . $mimeType . ";base64," . $imagenBase64;
                } else {
                    // Imagen por defecto en caso de que no exista una imagen
                    $imageSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
                }
                ?>

                <img id="imagePreview" src="<?= $imageSrc ?>" alt="Vista previa" class="course-image img-fluid rounded">
            </div>

            <!-- Course Title -->
            <input type="text" name="Titulo" class="form-control mb-3" value="<?= htmlspecialchars($course['Titulo']); ?>" required>

            <!-- Course Description -->
            <textarea name="Descripcion" class="form-control mb-3" required><?= htmlspecialchars($course['Descripcion']); ?></textarea>

            <!-- Course Category -->
            <select id="category" name="ID_Categoria" class="form-select mb-3" required>
              <option value="">Selecciona una categoría</option>
              <?php foreach ($categories as $category): ?>
                  <option value="<?= htmlspecialchars($category['ID_Categoria']); ?>" <?= $course['ID_Categoria'] == $category['ID_Categoria'] ? 'selected' : ''; ?>>
                      <?= htmlspecialchars($category['Nombre']); ?>
                  </option>
              <?php endforeach; ?>
            </select>

            <!-- Course Price -->
            <div class="form-check d-flex align-items-center">
              <input type="checkbox" name="Gratuito" class="form-check-input me-2" value="<?= htmlspecialchars($course['Gratuito']); ?>" id="isFree" <?= $course['Gratuito'] == 0 ? 'checked' : ''; ?> onchange="toggleFreeValue()">
              <div class="input-group" style="max-width: 280px;">
                <input type="hidden" name="Gratuito" value="<?= htmlspecialchars($course['Gratuito']); ?>" id="isFreeHidden">
                <span class="input-group-text">MX $</span>
                <input type="number" name="Costo_Total" class="form-control" value="<?= htmlspecialchars($course['Costo_Total']); ?>" id="course-price">
              </div>
            </div>
          </div>
        </div>

        <!-- Levels Section -->
        <div class="col-xl-6 mb-5">
          <div class="p-3 bg-body-secondary rounded">
            <div class="row mb-0">
              <h2 class="col">Niveles</h2>
              <button type="button" class="col-1 btn btn-info rounded-circle" id="addLevelBtn"><i class="bi bi-plus"></i></button>
            </div>
            <hr>
            
            <div id="levelList">
              <?php foreach ($levels as $index => $level): ?>
                <div class="row level" data-index="<?= $index ?>">
                  <input type="hidden" name="Nivel[<?= $index ?>][ID_Nivel]" value="<?= $level['ID_Nivel'] ?>">
                  <div class="card mb-3 p-3" style="max-width: 540px;">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <!-- Imagen de vista previa o imagen actual del nivel -->
                        <img src="https://assetsio.gnwcdn.com/magic-the-gathering-hatsune-miku-secret-lair-music-video-screenshot.png?width=1200&height=1200&fit=bounds&quality=70&format=jpg&auto=webp" class="img-fluid rounded" alt="...">           

                        <div class="mt-3 form-check px-1">
                          <label for="level-price-<?= $index ?>" class="form-label mb-1">Precio:</label>
                          <div class="ms-0 form-check d-flex align-items-center">
                            <input class="form-check-input me-2 level-free-checkbox" type="checkbox" value="0" id="flexCheckChecked-<?= $index ?>" name="Nivel[<?= $index ?>][Gratuito]" <?= $level['Costo_Nivel'] != '0.00' ? 'checked' : '' ?> data-bs-toggle="tooltip" title="En caso de no estar activo, el nivel será gratuito" onchange="toggleFreeValueLvl(<?= $index ?>)">
                            <input type="hidden" name="Nivel[<?= $index ?>][Gratuito]" value="<?= $level['Costo_Nivel'] == '0.00' ? '1' : '0' ?>" id="flexCheckCheckedHidden-<?= $index ?>">
                            <div class="input-group" style="max-width: 240px;">
                              <span class="input-group-text px-2">MX $</span>
                              <input type="text" class="form-control level-price" id="level-price-<?= $index ?>" name="Nivel[<?= $index ?>][Costo_Nivel]" value="<?= $level['Costo_Nivel'] ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <div class="row align-items-center">
                            <button class="col-4 btn btn-outline-danger align-self-end mb-3 removeLevelBtn" type="button"> <i class="fa-solid fa-trash"></i> Eliminar Nivel</button>
                            <!-- Titulo del nivel -->
                            <input type="text" class="level-title card-title mb-3 text-wrap" name="Nivel[<?= $index ?>][Titulo]" placeholder="Titulo del nivel" value="<?= htmlspecialchars($level['Titulo']) ?>" required>
                          </div>

                          <div class="row">
                            <!-- Input para el archivo adjunto -->
                            <div class="mb-3 row align-items-center">
                              <label for="formFile-<?= $index ?>" class="col-form-label col-2">
                                <h3 class="mb-0"><i class="bi bi-file-earmark-text"></i></h3>
                              </label>
                              <div class="col-10">
                                <input class="form-control" type="file" id="formFile-<?= $index ?>" name="Nivel[<?= $index ?>][Adjunto]" accept=".pdf, .docx, .zip, .txt">
                              </div>
                            </div>

                            <!-- Input para el video -->
                            <div class="mb-3 row align-items-center">
                              <label for="formVideo-<?= $index ?>" class="col-form-label col-2">
                                <h3 class="mb-0"><i class="bi bi-play-btn"></i></h3>
                              </label>
                              <div class="col-10">
                                <input class="form-control" type="file" id="formVideo-<?= $index ?>" name="Nivel[<?= $index ?>][Video]" accept="video/mp4">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <script>
    $(document).ready(function() {
     let levelIndex = $('.level').length; // Start with the number of existing levels

        // Function to dynamically add a new level
        $('#addLevelBtn').click(function() {
            // Clone an existing level structure or create a new one
            const newLevelHtml = `
                <div class="row level" data-index="${levelIndex}">
                  <input type="hidden" name="Nivel[${levelIndex}][ID_Nivel]" value="">

                    <div class="card mb-3 p-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="https://assetsio.gnwcdn.com/magic-the-gathering-hatsune-miku-secret-lair-music-video-screenshot.png?width=1200&height=1200&fit=bounds&quality=70&format=jpg&auto=webp" class="img-fluid rounded" alt="...">
                                <div class="mt-3 form-check px-1">
                                    <label for="level-price-${levelIndex}" class="form-label mb-1">Precio:</label>
                                    <div class="ms-0 form-check d-flex align-items-center">
                                    <input class="form-check-input me-2 level-free-checkbox" type="checkbox" value="0" id="flexCheckChecked-${levelIndex}" name="Nivel[${levelIndex}][Gratuito]" data-bs-toggle="tooltip" title="Nivel gratuito si está desactivado" onchange="toggleFreeValueLvl(${levelIndex})">
                                    <input type="hidden" name="Nivel[${levelIndex}][Gratuito]" value="" id="flexCheckCheckedHidden-${levelIndex}">    
                                    <div class="input-group" style="max-width: 240px;">
                                            <span class="input-group-text px-2">MX $</span>
                                            <input type="text" class="form-control level-price" id="level-price-${levelIndex}" name="Nivel[${levelIndex}][Costo_Nivel]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <button type="button" class="col-4 btn btn-outline-danger align-self-end mb-3 removeLevelBtn"><i class="fa-solid fa-trash"></i> Eliminar Nivel</button>
                                        <input type="text" class="level-title card-title mb-3 text-wrap" name="Nivel[${levelIndex}][Titulo]" placeholder="Titulo del nivel" required>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 row align-items-center">
                                            <label for="formFile-${levelIndex}" class="col-form-label col-2">
                                                <h3 class="mb-0"><i class="bi bi-file-earmark-text"></i></h3>
                                            </label>
                                            <div class="col-10">
                                                <input class="form-control" type="file" id="formFile-${levelIndex}" name="Nivel[${levelIndex}][Adjunto]" accept=".pdf, .docx, .zip, .txt">
                                            </div>
                                        </div>
                                        <div class="mb-3 row align-items-center">
                                            <label for="formVideo-${levelIndex}" class="col-form-label col-2">
                                                <h3 class="mb-0"><i class="bi bi-play-btn"></i></h3>
                                            </label>
                                            <div class="col-10">
                                                <input class="form-control" type="file" id="formVideo-${levelIndex}" name="Nivel[${levelIndex}][Video]" accept="video/mp4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        
            $('#levelList').append(newLevelHtml);
            levelIndex++; // Increment index for the next level
        });
      
        // Function to mark a level as deleted
           // Delegación de eventos para los botones de eliminación
        $('#levelList').on('click', '.removeLevelBtn', function() {
            const levelCard = $(this).closest('.level');
            const levelId = levelCard.find('input[name^="Nivel"][name$="[ID_Nivel]"]').val();
        
            // Si no se encuentra un ID de nivel (es decir, es nuevo o no tiene ID asignado)
            if (!levelId) {
                // Simplemente ocultamos la tarjeta sin agregar el input oculto
                levelCard.remove();
            } else {
                // Si tiene un ID de nivel, agregamos el input oculto para marcarlo como eliminado
                levelCard.append('<input type="hidden" name="NivelEliminar[]" value="' + levelId + '">');
                // Y luego ocultamos la tarjeta
                levelCard.hide();
            }
        });
    });

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

    function validateEditCourse() {
      // Validation logic for Edit Course
      return true;
    }
  </script>
  <script src="Views/crearCurso.js"></script>
</body>
</html>