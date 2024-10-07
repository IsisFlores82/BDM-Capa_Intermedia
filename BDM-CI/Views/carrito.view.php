<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="Views/dashboard.css">
  <link rel="stylesheet" href="Views/carrito.css">
  
</head>


<body>
<?php include 'Components/headerStudent.php'; ?>

  <br>
  <div class="container">
   <div class="row">   
    <!--parte izquierda, donde van los productos-->
    <h2 class=""> Tu carrito de compra</h2>
    <div class="col-md-8 each-side">
      <!-- Course Item -->
      <div class="row car-item border-bottom border-secondary-subtle position-relative">
        <div class="col-lg-4">
          <img src="https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg" alt="Curso" class="img-fluid course-image">
        </div>
        <div class="col-lg-8">
          <div class="d-flex flex-column h-100">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h3>Como ser cantante profesional</h3>
                <h5>Hatsune Miku</h5>
              </div>
              <button class="btn btn-link p-0 position-absolute top-0 end-0 mt-2 me-2 delete-btn" aria-label="Eliminar curso">
                <i class="fa-solid fa-trash text-secondary"></i>
              </button>
            </div>
            <p class="text-end price mt-auto">$999</p>
          </div>
        </div>
      </div>
    
      <!-- Repeat for other items -->
      <div class="row car-item border-bottom border-secondary-subtle position-relative">
        <div class="col-lg-4">
          <img src="https://bs-uploads.toptal.io/blackfish-uploads/components/open_graph_image/8959179/og_image/optimized/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png" alt="Curso" class="img-fluid course-image">
        </div>
        <div class="col-lg-8">
          <div class="d-flex flex-column h-100">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h3>Como hacer una base de datos mamastrosa</h3>
                <h5>Villatrue</h5>
              </div>
              <button class="btn btn-link p-0 position-absolute top-0 end-0 mt-2 me-2 delete-btn" aria-label="Eliminar curso">
                <i class="fa-solid fa-trash text-secondary"></i>
              </button>
            </div>
            <p class="text-end price mt-auto">$850</p>
          </div>
        </div>
      </div>
    
      <div class="row car-item border-bottom border-secondary-subtle position-relative">
        <div class="col-lg-4">
          <img src="https://mastermetrics.com/wp-content/uploads/2024/07/meta-ai.jpg" alt="Curso" class="img-fluid course-image">
        </div>
        <div class="col-lg-8">
          <div class="d-flex flex-column h-100">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h3>Como hacer que Meta AI no trolee</h3>
                <h5>Dream Team</h5>
              </div>
              <button class="btn btn-link p-0 position-absolute top-0 end-0 mt-2 me-2 delete-btn" aria-label="Eliminar curso">
                <i class="fa-solid fa-trash text-secondary"></i>
              </button>
            </div>
            <p class="text-end price mt-auto">$500</p>
          </div>
        </div>
      </div>
    </div>
    <!--parte derecha, donde va el total de los productos--> 
      <div class="col-md-3  each-side right-side">
       
        <div class="row">
          <h3>Resumen</h3>
          <br><br><br>
          <div class="col-lg-8">            
            <h5>Total estimado:</h5> 
          </div>
          <div class="col-lg-4">            
            <h5 class="text-end">$2,349</h5> 
          </div>
          </div>
          <br>
          <div class="row  each-side">
          <button type="button" class="btn btn-primary btn-pagar" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Continuar al Pago
          </button>
        </div>

        <div class="row">

        </div>
      </div>        

    </div>   
  </div>

 <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Datos de pago</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form id="paymentForm">
                  <div class="mb-3">
                      <label for="cardHolderName" class="form-label">Nombre del titular</label>
                      <input type="text" class="form-control" id="cardHolderName" placeholder="" required>
                      <div class="invalid-feedback" id="cardNameError">Ingrese su nombre de manera correcta.</div>
                  </div>
                  <div class="mb-3">
                      <label for="cardNumber" class="form-label">Número de Tarjeta</label>
                      <input type="text" class="form-control" id="cardNumber" placeholder="" maxlength="16" required>
                      <div class="invalid-feedback" id="cardNumberError">Debe tener 16 dígitos.</div>
                  </div>
                  <div class="mb-3 row">
                      <div class="col-6">
                          <label for="expirationMonth" class="form-label">Fecha Vencimiento</label>
                          <div class="input-group has-validation">
                              <input type="text" class="form-control" id="expirationMonth" placeholder="MM" maxlength="2" required>
                              <span class="input-group-text">/</span>
                              <input type="text" class="form-control" id="expirationYear" placeholder="YY" maxlength="2" required>
                          </div>
                          <div class="invalid-feedback" id="expirationError">Mes y año deben ser de 2 dígitos.</div>
                      </div>
                      <div class="col-6">
                          <label for="cvv" class="form-label">CVV</label>
                          <div class="input-group has-validation">
                              <input type="text" class="form-control" id="cvv" placeholder="" maxlength="3" required>
                          </div>
                          <div class="invalid-feedback" id="cvvError">El CVV debe tener 3 dígitos.</div>
                      </div>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="submitPayment">Realizar Pago</button>
              <!-- Botón de PayPal -->
              <button type="button" class="btn btn-outline-primary d-flex align-items-center" id="payWithPayPal">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/1200px-PayPal.svg.png" alt="PayPal" style="width: 80px; height: 24px; margin-right: 8px;">
              </button>
          </div>
      </div>
  </div>
</div>

  <script src="Views/carrito.js"></script>
</body>
</html>