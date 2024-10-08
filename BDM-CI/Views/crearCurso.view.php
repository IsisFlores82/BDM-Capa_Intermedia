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
  <link rel="stylesheet" href="Views/dashboard.css">
  <link rel="stylesheet" href="Views/crearCurso.css">
</head>

<body>
  <?php require 'Components/headerInstructor.php'; ?>
  <div class="container ">
    <div class="row d-flex align-items-center mb-3">
      <h2 class="col-9">Crear Curso</h2>
      <button class="col-2 btn btn-outline-info" type="button" id="publishCourseBtn">Publicar Curso</button>

    </div>
    
    <div class="row">
      <div class="col-xl-5 mb-5">
        <div class="col p-3 bg-body-secondary rounded">
          <h2 class="mb-4">Información del curso</h2>
          <hr>
          <div class="row px-2">
            <!-- Añadir el input para seleccionar un archivo -->
            <label for="courseBanner" class="form-label">Banner del Curso</label>

            <div class="mb-3 row justify-content-center align-items-center">              
              <label for="courseBanner" class="col-form-label col-2 text-center">
                  <h3 class="mb-0"><i class="bi bi-card-image"></i></h3>
              </label>          
              <div class="col-10 d-flex justify-content-center">
                  <input type="file" id="courseBanner" class="form-control mb-2" accept="image/*" required onchange="previewImage(event)" style="max-width: 400px;">
              </div>
            </div>
            

            <img id="imagePreview" src="" alt="Vista previa" class="course-image img-fluid rounded" style="display: none;">

            <input type="text" class="couse-title" value="Como ser cantante profesional" placeholder="Título del curso" required>
            <h4 class="mt-1">Hatsune Miku</h4>

            <div class="row">
              <textarea name="" id="" class="course-desc" placeholder="Descripción del curso" required>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores possimus corporis, tempora placeat ratione eligendi quos cum! Ducimus, dolorem odio ad, ipsum accusantium nostrum nisi itaque ratione fugiat, odit dolore.</textarea>
            </div>

            <div class="mb-3 col-7" style="max-width: 280px;">
              <label for="category" class="form-label">Categoría</label>
              <select id="category" class="form-select" required>
                <option value="">Selecciona una categoría</option>
                <option value="desarrollo">Desarrollo</option>
                <option value="base-datos">Bases de Datos</option> 
                <option value="marketing">Marketing</option> 
                <option value="diseno">Diseño</option> 
                <option value="unreal">Unreal</option> 
              </select>
            </div>

            <div class="row">
              <div class="col">
                <label for="couse-price" class="form-label">Precio</label>
                <div class="ms-3 form-check d-flex align-items-center">
                <!-- Checkbox -->
                <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckChecked" checked data-bs-toggle="tooltip" title="en caso de no estar activo, el curso será gratuito">
          
                <!-- Input text con icono ($) -->
                <div class="input-group" style="max-width: 280px;">
                  <span class="input-group-text">MX $</span>
                  <input type="text" class="form-control" id="couse-price" aria-label="Amount (to the nearest dollar)">
                </div>
              </div>
              
            </div>

            </div>
            

          </div>
        </div>
      </div>
      
      <div class="col-xl-6 mb-5">

        <div class="col p-3 bg-body-secondary rounded" id="levelsContainer">
          <div class="row mb-0">                       
            <h2 class="col">Niveles</h2>
            <button class="col-1 me-5 btn btn-info rounded-circle" id="addElementsBtn"> <i class="bi bi-plus fs-5"></i> </button>
          </div>         
          <hr>
          <div class="row ">
            <div class="card mb-3 p-3" style="max-width: 540px;">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="https://assetsio.gnwcdn.com/magic-the-gathering-hatsune-miku-secret-lair-music-video-screenshot.png?width=1200&height=1200&fit=bounds&quality=70&format=jpg&auto=webp" class="img-fluid rounded" alt="...">
                  
                  <div class="mt-3 form-check px-1"> 
                    <label for="level-price" class="form-label mb-1">Precio:</label>
                    <div class="ms-0 form-check d-flex align-items-center">
                      <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckChecked" checked checked data-bs-toggle="tooltip" title="en caso de no estar activo, el nivel será gratuito">
                  
                      <div class="input-group" style="max-width: 240px;">
                        <span class="input-group-text px-2">MX $</span>
                        <input type="text" class="form-control" id="level-price" aria-label="Amount (to the nearest dollar)">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <input type="text" class="level-title card-title mb-3 text-wrap" value="Nivel 1" placeholder="Titulo del curso">
                      <button class="col-2 btn btn-outline-secondary align-self-start mb-3 removeCardBtn"> <i class="fa-solid fa-trash"></i></button>
                    </div>
                                        
                    <div class="row">
                      <div class="mb-3 row align-items-center">
                        <label for="formFile" class="col-form-label col-2">
                          <h3 class="mb-0"><i class="bi bi-file-earmark-text"></i></h3>
                        </label>
                        <div class="col-10">
                            <input class="form-control" type="file" id="formFile" multiple>
                        </div>
                      </div>

                      <div class="mb-3 row align-items-center">
                        <label for="formVideo" class="col-form-label col-2">
                          <h3 class="mb-0"><i class="bi bi-play-btn"></i></h3>
                        </label>
                        <div class="col-10">
                            <input class="form-control" type="file" id="formVideo" accept="video/mp4" multiple>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>            
          </div>
        </div>

      </div>

    </div>    
  </div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel"><i class="bi bi-check-circle"></i> Curso publicado correctamente!</h1>
        
      </div>
      <div class="modal-body">
        
        Ahora todos podran acceder a él! 
      </div>
      <div class="modal-footer">
        <a href="ProfileInstructor.html" type="button" class="btn btn-primary text-ligh">Ver </a>
      </div>
    </div>
  </div>
</div>
    <script>
// Escucha el evento click en el botón de publicar
document.getElementById('publishCourseBtn').addEventListener('click', function () {
    validateCourse();
});

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
    const isPaidCheckbox = document.getElementById('flexCheckChecked');
    const priceInput = document.getElementById('couse-price');
    if (isPaidCheckbox.checked && priceInput.value.trim() === "") {
        alert("Debes ingresar un precio para el curso.");
        valid = false;
    }

    // Validar los niveles
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
    });

    // Si todo está validado, crear el curso (mostrar el modal)
    if (valid) {
        let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
            keyboard: false
        });
        myModal.show();
    }
}
  </script>
    <script src="Views/crearCurso.js"></script>
</body>
</html>