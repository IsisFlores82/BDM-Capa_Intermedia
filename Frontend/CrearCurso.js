 // Inicializar el tooltip para el input
 var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
 var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
   return new bootstrap.Tooltip(tooltipTriggerEl);
 });


 $(document).ready(function() {
  $('#addElementsBtn').click(function() {
    // Define el HTML de los elementos que quieres agregar
    var newLevel = `
      <div class="row">
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
                      <input type="text" class="level-title card-title mb-3 text-wrap" value="" placeholder="Titulo del curso">
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
    `;
    
    // Agrega los nuevos elementos al contenedor
    $('#levelsContainer').append(newLevel);
  });

  //para eliminar cada tarjeta 
  $('#levelsContainer').on('click', '.removeCardBtn', function() {
    $(this).closest('.card').remove();
  });
});