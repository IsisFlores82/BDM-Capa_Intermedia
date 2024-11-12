 // Inicializar el tooltip para el input
 var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
 var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
   return new bootstrap.Tooltip(tooltipTriggerEl);
 });

 
 function previewImage(event) {
  const input = event.target;
  const file = input.files[0];
  
  if (file) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
          const preview = document.getElementById('imagePreview');
          preview.src = e.target.result;
          preview.style.display = 'block'; // Mostrar la imagen cuando se cargue
      }
      
      reader.readAsDataURL(file);
  }
}


 $(document).ready(function() {
  $('#addElementsBtn').click(function () {
    const levelList = $('#levelList');
    const index = levelList.children().length;

    const newLevel = `
      <div class="row level" data-index="${index}">
        <div class="card mb-3 p-3" style="max-width: 540px;">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="https://assetsio.gnwcdn.com/magic-the-gathering-hatsune-miku-secret-lair-music-video-screenshot.png?width=1200&height=1200&fit=bounds&quality=70&format=jpg&auto=webp" class="img-fluid rounded" alt="...">
              
              <div class="mt-3 form-check px-1"> 
                <label for="level-price-${index}" class="form-label mb-1">Precio:</label>
                <div class="ms-0 form-check d-flex align-items-center">
                  <input class="form-check-input me-2 level-free-checkbox" type="checkbox" value="0" id="flexCheckChecked-${index}" name="Nivel[${index}][Gratuito]" checked data-bs-toggle="tooltip" title="en caso de no estar activo, el nivel será gratuito" onchange="toggleFreeValueLvl(${index})">
                  <input type="hidden" name="Nivel[${index}][Gratuito]" value="" id="flexCheckCheckedHidden-${index}">

                  <div class="input-group" style="max-width: 240px;">
                    <span class="input-group-text px-2">MX $</span>
                    <input type="number" step=0.01 min=0 class="form-control level-price" id="level-price-${index}" name="Nivel[${index}][Costo_Nivel]">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <div class="row align-items-center">
                  <input type="text" class="level-title card-title mb-3 text-wrap" name="Nivel[${index}][Titulo]" placeholder="Titulo del nivel" required>
                  <button class="col-2 btn btn-outline-secondary align-self-start mb-3 removeCardBtn" type="button"> <i class="fa-solid fa-trash"></i></button>
                </div>
                
                <div class="row">
                  <div class="mb-3 row align-items-center">
                    <label for="formFile-${index}" class="col-form-label col-2">
                      <h3 class="mb-0"><i class="bi bi-file-earmark-text"></i></h3>
                    </label>
                    <div class="col-10">
                      <input class="form-control" type="file" id="formFile-${index}" name="Nivel[${index}][Adjunto]" accept=".pdf, .docx, .zip, .txt">
                    </div>
                  </div>

                  <div class="mb-3 row align-items-center">
                    <label for="formVideo-${index}" class="col-form-label col-2">
                      <h3 class="mb-0"><i class="bi bi-play-btn"></i></h3>
                    </label>
                    <div class="col-10">
                      <input class="form-control" type="file" id="formVideo-${index}" name="Nivel[${index}][Video]" accept="video/mp4">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;

    levelList.append(newLevel);
  });

  $('#levelList').on('click', '.removeCardBtn', function() {
    $(this).closest('.level').remove();

    // Reindexar los niveles después de eliminar uno
    $('#levelList .level').each(function(index) {
      // Actualizar el atributo 'data-index' de cada nivel
      $(this).attr('data-index', index);

      // Actualizar los nombres de los inputs dentro de este nivel
      $(this).find('input').each(function() {
        const name = $(this).attr('name');
        if (name) {
          // Cambiar el número de índice en el nombre para mantener la secuencia
          const newName = name.replace(/\d+/, index);
          $(this).attr('name', newName);
        }
      });

      // Actualizar los ID de cada input
      $(this).find('label, input').each(function() {
        const id = $(this).attr('id');
        if (id) {
          const newId = id.replace(/\d+/, index);
          $(this).attr('id', newId);
        }
      });
    });
  });
});