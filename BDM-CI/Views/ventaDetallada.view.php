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
   <!-- Filtros -->
<div class="container mt-4">
    <h1>Reporte de ventas: <?php echo htmlspecialchars($courseDb->getCourseTitle($courseId)); ?></h1>
    <form class="row g-3" method="GET">
        <input type="hidden" name="id_curso" value="<?php echo htmlspecialchars($courseId); ?>">
        <div class="col-md-4">
            <label for="startDate" class="form-label">Fecha de inscripción (desde)</label>
            <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo htmlspecialchars($start_date); ?>">
        </div>
        <div class="col-md-4">
            <label for="endDate" class="form-label">Fecha de inscripción (hasta)</label>
            <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo htmlspecialchars($end_date); ?>">
        </div>
            <div class="col-md-4">
                <label class="form-label">Estado del alumno</label>
                <select id="statusFilter" name="statusFilter" class="form-select">
                    <option value="todos" <?= $estado_curso == 'todos' ? 'selected' : '' ?>>Todos</option>
                    <option value="progreso" <?= $estado_curso == 'progreso' ? 'selected' : '' ?>>Solo alumnos  en progreso</option>
                    <option value="completado" <?= $estado_curso == 'completado' ? 'selected' : '' ?>>Solo alumnos certificados</option>
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
                <th>Fecha de inscripción</th>
                <th>Progreso</th>
                <th>Pago realizado</th>
                <th>Forma de pago</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($alumnos)): ?>
                <?php foreach ($alumnos as $alumno): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($alumno['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($alumno['Fecha_Inscripcion']))); ?></td>
                        <td><?php echo htmlspecialchars($alumno['Progreso']); ?>%</td>
                        <td>MX $<?php echo htmlspecialchars(number_format($alumno['Monto_Pagado'], 2)); ?></td>
                        <td><?php echo htmlspecialchars($alumno['Forma_de_Pago']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No se encontraron registros.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Resumen -->
<?php
$total = array_sum(array_column($alumnos, 'Monto_Pagado'));
$paymentsByType = array_reduce($alumnos, function ($carry, $alumno) {
    $carry[$alumno['Forma_de_Pago']] = ($carry[$alumno['Forma_de_Pago']] ?? 0) + $alumno['Monto_Pagado'];
    return $carry;
}, []);
?>
<div class="container mt-4">
    <div class="col">
        <div class="row">
            <h3>Resumen</h3>
            <div class="row mt-4">
                <div class="col-lg-7">            
                    <h5>Total estimado:</h5> 
                </div>
                <div class="col-lg-5">            
                    <h5 class="text-end">MX $<?php echo htmlspecialchars(number_format($total, 2)); ?></h5> 
                </div>
            </div>
            <?php foreach ($paymentsByType as $type => $amount): ?>
                <div class="row mt-0">
                    <div class="col-lg-7">            
                        <p>Pagos con <?php echo htmlspecialchars($type); ?>:</p>
                    </div>
                    <div class="col-lg-5">            
                        <p class="text-end">MX $<?php echo htmlspecialchars(number_format($amount, 2)); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


</body>
</html>
