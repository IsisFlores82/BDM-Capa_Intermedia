<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="Views/dashboard.css">
    <link rel="stylesheet" href="Views/kardex.css">
</head>
<body>
<?php require 'Components/headerAdmin.php'; ?>
    <!-- Filtros del Kardex -->
    <h1 class="text-center">Reporte de Usuarios</h1>
    <!-- resumen de Cursos -->
  <div class="container">

    <div class="row d-flex justify-content-around align-items-top">

      <div class="col">
        <h2>Instructores</h2>
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
              <tr>
                  <th>Usuario</th>
                  <th>Nombre</th>
                  <th>Fecha ingreso</th>
                  <th>Cursos ofrecidos</th>
                  <th>Total de ganancias</th>
              </tr>
          </thead>
          <tbody>
              <!-- Ejemplo de curso incompleto -->
              <tr>
                  <td>Hatsune Miku</td>
                  <td>Hatsune Miku</td>
                  <td>31/Ago/2024</td>
                  <td>2</td>
                  <td>MX $242,757.00</td>
              </tr>
              <!-- Ejemplo de curso completado -->
              <tr>
                <td>Villareal</td>
                <td>Juan Alejandro Villareal</td>
                <td>05/02/2023</td>
                <td>1</td>
                <td>MX $31,450.00</td>
              </tr>
              <!-- Más cursos aquí -->
          </tbody>
        </table>
      </div>


      </div>


    </div>
    
  </div>

  <div class="container">

    <div class="row d-flex justify-content-around align-items-top">

      <div class="col">
        <h2>Alumnos</h2>
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>Usuario</th>
              <th>Nombre</th>
              <th>Fecha ingreso</th>
              <th>Cursos Inscritos</th>
              <th>% Cursos terminados</th>
            </tr>
          </thead>

          <tbody>
            <!-- Ejemplo de curso incompleto -->
            <tr>
                <td>Isis</td>
                <td>Isis Esmeralda Flores Montes</td>
                <td>15/024/2024</td>
                <td>3</td>
                <td>72%</td>
            </tr>
            <!-- Ejemplo de curso completado -->
            <tr>
              <td>Pinkus</a></td>
              <td>Carlos Daniel Pinkus Martinez</td>
              <td>18/09/2024</td>
              <td>2</td>
              <td>92%</td>
            </tr>
            <!-- Más cursos aquí -->
          </tbody>
        </table>
      </div>
    </div>    
  </div>


  <div class="container mt-4">
          
      <div class="col ">
        <div class="row">
          <h3>Resumen</h3>
          <hr>
          
          <div  class="row mt-1s">
            <div class="col-lg-7 ">            
              <p>Total Alumnos:</p>
            </div>
            <div class="col-lg-5">            
              <p class="text-end">120</p>
              </div>
          </div>
        
          <div  class="row mt-1">
            <div class="col-lg-7 ">            
              <p>Total Instructores:</p>
            </div>
            <div class="col-lg-5">            
              <p class="text-end">35 </p>
              </div>
          </div>
        
          <div  class="row mt-1">
            <div class="col-lg-7 ">            
              <p>Total cursos ofertados:</p>
            </div>
            <div class="col-lg-5">            
              <p class="text-end">82 </p>
              </div>
          </div>

          <div  class="row mt-1">
            <div class="col-lg-7 ">            
              <p>Total categorias:</p>
            </div>
            <div class="col-lg-5">            
              <p class="text-end">7 </p>
              </div>
          </div>



          </div>
          
        
        </div>        
      </div>
  
  </div>


</body>

</html>
