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

    <!-- Filtros del Reporte de Ventas -->
    <div class="container mt-4">
        <h1>Reporte de ventas</h1>
        <form class="row g-3">
            <div class="col-md-4">
                <label for="startDate" class="form-label">Fecha de creacion (desde)</label>
                <input type="date" class="form-control" id="startDate" value="<?= $start_date ?>">
            </div>
            <div class="col-md-4">
                <label for="endDate" class="form-label">Fecha de creacion (hasta)</label>
                <input type="date" class="form-control" id="endDate" value="<?= $end_date ?>">
            </div>
            <div class="col-md-4">
                <label for="categoryFilter" class="form-label">Categoría</label>
                <select id="categoryFilter" class="form-select">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['ID_Categoria'] ?>" <?= $category_id == $category['ID_Categoria'] ? 'selected' : '' ?>><?= $category['Nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Estado del curso</label>
                <select id="statusFilter" class="form-select">
                    <option value="todos" <?= $estado_curso == 'todos' ? 'selected' : '' ?>>Todos</option>
                    <option value="activo" <?= $estado_curso == 'activo' ? 'selected' : '' ?>>Solo cursos activos</option>
                </select>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
    </div>

    <!-- Resumen de Ventas -->
    <div class="container mt-4">
        <h3>Resumen de Pagos</h3>
        <div class="row mt-4">
            <?php foreach ($salesSummary as $payment): ?>
                <div class="col-lg-4">
                    <h5><?= $payment['Forma_de_Pago'] ?>:</h5>
                    <p>$<?= number_format($payment['TotalPagado'], 2) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tabla de Reporte de Ventas por Curso -->
    <div class="container">
        <div class="row d-flex justify-content-around align-items-top">
            <div class="col">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Curso</th>
                            <th>Alumnos Inscritos</th>
                            <th>Promedio de Progreso General</th>
                            <th>Estado</th>
                            <th>Ventas Totales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coursesSummary as $course): ?>
                            <tr>
                                <td><a href="/BDM-CI/ventaDetallada?id_curso=<?= $course['ID_Curso'] ?>"><?= $course['Titulo'] ?></a></td>
                                <td><?= $course['AlumnosInscritos'] ?></td>
                                <td><?= number_format($course['PromedioProgreso'], 2) ?>%</td>
                                <td><?= $course['Estado'] ?></td>
                                <td>$<?= number_format($course['VentasTotales'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
