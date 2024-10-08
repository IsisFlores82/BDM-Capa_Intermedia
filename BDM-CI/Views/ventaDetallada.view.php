<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas "Como ser cantante profesional"</title>
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
        <h1>Reporte de ventas: Como ser cantante profesional</h1>
        <form class="row g-3">
            <div class="col-md-4">
                <label for="startDate" class="form-label">Fecha de inscripcion (desde)</label>
                <input type="date" class="form-control" id="startDate">
            </div>
            <div class="col-md-4">
                <label for="endDate" class="form-label">Fecha de inscripcion (hasta)</label>
                <input type="date" class="form-control" id="endDate">
            </div>
            <div class="col-md-4">
                <label for="categoryFilter" class="form-label">Tipo de compra</label>
                <select id="categoryFilter" class="form-select">
                    <option value="">Todas las compras</option>
                    <option value="desarrollo">Compras Parciales</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Estado del curso</label>
                <select id="statusFilter" class="form-select">
                    <option value="todos">Todos</option>
                    <option value="activo">Solo alumnos graduados</option>
                </select>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
    </div>

    <!-- Kardex de Cursos -->
<div class="container mt-4">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Alumno</th>
                <th>Fecha de incripcion</th>
                <th>Progreso </th>
                <th>Pago realizado</th>
                <th>Forma de pago</th>
            </tr>
        </thead>
        <tbody>
            <!-- Ejemplo de curso incompleto -->
            <tr>
                <td>Isis Esmeralda Flores Montes</td>
                <td>15/04/2024</td>
                <td>82%</td>
                <td>MX $999.00</td>
                <td>Pago con tarjeta</td>
            </tr>
            <!-- Ejemplo de curso completado -->
            <tr>
                <td>Roberto Carlos Dominguez Espinoza</td>
                <td>03/11/2023</td>
                <td>100%</td>
                <td>MX $333.00</td>
                <td>Pago en PayPal</td>
            </tr>
            <!-- Más cursos aquí -->
        </tbody>
    </table>
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
            <p class="text-end">$999.00 </p>
          </div>
      </div>
    
      <div  class="row mt-0">
          <div class="col-lg-7 ">            
            <p>Pagos con efectivo:</p>
          </div>
          <div class="col-lg-5">            
            <p class="text-end">$0.00 </p>
          </div>
      </div>

      <div  class="row mt-0">
        <div class="col-lg-7 ">            
          <p>Pagos con paypal:</p>
        </div>
        <div class="col-lg-5">            
          <p class="text-end">$333.00 </p>
        </div>
      </div>

      </div>
      
    
    </div>        
  </div>

</div>

</body>
</html>
