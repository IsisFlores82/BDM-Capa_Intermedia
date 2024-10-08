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
   <?php require 'Components/headerInstructor.php'; ?>

    <!-- Filtros del Kardex -->
    <div class="container mt-4">
        <h1>Reporte de ventas</h1>
        <form class="row g-3">
          <div class="col-md-4">
            <label for="startDate" class="form-label">Fecha de creacion (desde)</label>
            <input type="date" class="form-control" id="startDate">
          </div>
          <div class="col-md-4">
            <label for="endDate" class="form-label">Fecha de creacion (hasta)</label>
            <input type="date" class="form-control" id="endDate">
          </div>
          <div class="col-md-4">
            <label for="categoryFilter" class="form-label">Categoría</label>
            <select id="categoryFilter" class="form-select">
              <option value="">Todas las categorías</option>
              <option value="desarrollo">Desarrollo</option>
              <option value="base-datos">Bases de Datos</option>
              <option value="marketing">Marketing</option>
              <option value="diseno">Diseño</option>
              <option value="unreal">Unreal</option>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label">Estado del curso</label>
            <select id="statusFilter" class="form-select">
              <option value="todos">Todos</option>
              <option value="activo">Solo cursos activos</option>
            </select>
          </div
          >
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Filtrar</button>
          </div>
        </form>
    </div>

    <!-- resumen de Cursos -->
<div class="container">

  <div class="row d-flex justify-content-around align-items-top">

    <div class="col">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Alumnos inscritos</th>
                <th>Promedio de progreso general</th>
                <th>Estado</th>
                <th>Ventas totales</th>
            </tr>
        </thead>
        <tbody>
            <!-- Ejemplo de curso incompleto -->
            <tr>
                <td><a href="/BDM-CI/ventaDetallada">Como ser cantante profesional</a></td>
                <td>243</td>
                <td>82%</td>
                <td>Activo</td>
                <td>MX $242,757.00</td>
            </tr>
            <!-- Ejemplo de curso completado -->
            <tr>
              <td><a href="/BDM-CI/ventaDetallada">Como crear una base de datos mamastrosa</a></td>
              <td>37</td>
              <td>52%</td>
              <td>Activo</td>
              <td>MX $31,450.00</td>
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
        
        <div  class="row mt-4">
          <div class="col-lg-7 ">            
            <h5>Total estimado:</h5> 
          </div>
          <div class="col-lg-5">            
            <h5 class="text-end">$274,207.00</h5> 
            </div>
        </div>
      
        <div  class="row mt-4">
            <div class="col-lg-7 ">            
              <p>Pagos con tarjeta:</p>
            </div>
            <div class="col-lg-5">            
              <p class="text-end">$242,000.00 </p>
            </div>
        </div>
      
        <div  class="row mt-0">
            <div class="col-lg-7 ">            
              <p>Pagos con efectivo:</p>
            </div>
            <div class="col-lg-5">            
              <p class="text-end">$2,207.00 </p>
            </div>
        </div>

        <div  class="row mt-0">
          <div class="col-lg-7 ">            
            <p>Pagos con PayPal:</p>
          </div>
          <div class="col-lg-5">            
            <p class="text-end">$30,000.00 </p>
          </div>
        </div>

        </div>
        
      
      </div>        
    </div>
 
</div>


</body>
</html>
