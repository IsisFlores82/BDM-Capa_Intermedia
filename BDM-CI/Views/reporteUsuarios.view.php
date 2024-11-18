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
<h1 class="text-center">Reporte de Usuarios</h1>

<!-- Instructores -->
<div class="container mt-4">
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
            <?php foreach ($instructores as $instructor): ?>
                <tr>
                    <td><?php echo htmlspecialchars($instructor['Usuario']); ?></td>
                    <td><?php echo htmlspecialchars($instructor['Nombre']); ?></td>
                    <td><?php echo htmlspecialchars(date('d/M/Y', strtotime($instructor['FechaIngreso']))); ?></td>
                    <td><?php echo htmlspecialchars($instructor['CursosOfrecidos']); ?></td>
                    <td>MX $<?php echo htmlspecialchars(number_format($instructor['Ganancias'], 2)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Alumnos -->
<div class="container mt-4">
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
            <?php foreach ($alumnos as $alumno): ?>
                <tr>
                    <td><?php echo htmlspecialchars($alumno['Usuario']); ?></td>
                    <td><?php echo htmlspecialchars($alumno['Nombre']); ?></td>
                    <td><?php echo htmlspecialchars(date('d/M/Y', strtotime($alumno['FechaIngreso']))); ?></td>
                    <td><?php echo htmlspecialchars($alumno['CursosInscritos']); ?></td>
                    <td><?php echo htmlspecialchars($alumno['PorcentajeCursosTerminados']); ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Resumen -->
<div class="container mt-4">
    <h3>Resumen</h3>
    <hr>
    <div class="row">
        <div class="col-lg-6">Total Alumnos:</div>
        <div class="col-lg-6 text-end"><?php echo htmlspecialchars($totalAlumnos); ?></div>
    </div>
    <div class="row">
        <div class="col-lg-6">Total Instructores:</div>
        <div class="col-lg-6 text-end"><?php echo htmlspecialchars($totalInstructores); ?></div>
    </div>
    <div class="row">
        <div class="col-lg-6">Total cursos ofertados:</div>
        <div class="col-lg-6 text-end"><?php echo htmlspecialchars($totalCursos); ?></div>
    </div>
    <div class="row">
        <div class="col-lg-6">Total categorias:</div>
        <div class="col-lg-6 text-end"><?php echo htmlspecialchars($totalCategorias); ?></div>
    </div>
</div>



</body>

</html>
