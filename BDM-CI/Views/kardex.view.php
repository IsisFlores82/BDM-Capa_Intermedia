<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kardex de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="Views/dashboard.css">
    <link rel="stylesheet" href="Views/kardex.css">
</head>
<body>
    <?php require 'Components/headerStudent.php'; ?>
    <!-- Filtros del Kardex -->
    <div class="container mt-4">
        <h1>Kardex de Cursos</h1>
        <form class="row g-3">
            <div class="col-md-4">
                <label for="startDate" class="form-label">Fecha de inscripción (desde)</label>
                <input type="date" class="form-control" id="startDate">
            </div>
            <div class="col-md-4">
                <label for="endDate" class="form-label">Fecha de inscripción (hasta)</label>
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
                    <option value="completado">Solo cursos completados</option>
                    <option value="activo">Solo cursos activos</option>
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
                <th>Curso</th>
                <th>Fecha de inscripción</th>
                <th>Última fecha de ingreso</th>
                <th>Progreso</th>
                <th>Estado</th>
                <th>Fecha de terminación</th>
                <th>Certificado</th> <!-- Nueva columna para descargar PDF -->
                <th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            <!-- Ejemplo de curso incompleto -->
            <tr>
                <td>Como ser cantante profesional</td>
                <td>01/09/2024</td>
                <td>10/09/2024</td>
                <td>70%</td>
                <td>Activo</td>
                <td>-</td>
                <td>-</td> <!-- Sin certificado porque no está completado -->
                <th>-</th>
            </tr>
            <!-- Ejemplo de curso completado -->
            <tr>
                <td>Como hacer una base de datos mamastrosa</td>
                <td>15/08/2024</td>
                <td>05/09/2024</td>
                <td>100%</td>
                <td>Completado</td>
                <td>05/09/2024</td>
                <td>
                    <a href="Resources/Certificado Miky Academy.pdf" class="btn btn-primary btn-sm" download>
                        Descargar PDF
                    </a>
                </td> <!-- Botón para descargar PDF porque está completado -->
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal">
                        Realizar Comentarios
                    </button>
                </td>
            </tr>
            <!-- Más cursos aquí -->
        </tbody>
    </table>
</div>

<!-- Ventana Modal para Realizar Comentarios -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Realizar Comentario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="commentForm">
                    <!-- Título del comentario -->
                    <div class="mb-3">
                        <label for="commentTitle" class="form-label">Título del Comentario</label>
                        <input type="text" class="form-control" id="commentTitle" placeholder="Escribe el título de tu comentario" required>
                    </div>

                    <!-- Selección de Estrellas -->
                    <div class="mb-3">
                        <label class="form-label">Calificación (1 a 5 estrellas)</label>
                        <select id="rating" class="form-select">
                            <option value="1">1 Estrella</option>
                            <option value="2">2 Estrellas</option>
                            <option value="3">3 Estrellas</option>
                            <option value="4">4 Estrellas</option>
                            <option value="5" selected>5 Estrellas</option>
                        </select>
                    </div>

                    <!-- Descripción del comentario -->
                    <div class="mb-3">
                        <label for="commentDescription" class="form-label">Descripción</label>
                        <textarea class="form-control" id="commentDescription" rows="4" placeholder="Escribe tus comentarios aquí" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
