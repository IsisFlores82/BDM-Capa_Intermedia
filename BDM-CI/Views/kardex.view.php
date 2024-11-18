<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kardex de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Usar SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script> 

    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="Views/dashboard.css">
    <link rel="stylesheet" href="Views/kardex.css">
</head>
<body>
    <?php require 'Components/headerStudent.php'; ?>

    <?php
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $alertType = $mensaje['type'] == 'success' ? 'success' : 'error';
    // Escapar los caracteres especiales del mensaje
    $text = htmlspecialchars($mensaje['text'], ENT_QUOTES, 'UTF-8');
    echo "<script>
        Swal.fire({
            title: '$alertType',
            text: '$text',
            icon: '$alertType',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = '/BDM-CI/kardex';
        });
    </script>";
    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}
?>

    <!-- Filtros del Kardex -->
    <div class="container mt-4">
    <h1>Kardex de Cursos</h1>
    <!-- Filtros -->
    <form class="row g-3">
        <div class="col-md-4">
            <label for="startDate" class="form-label">Fecha de inscripción (desde)</label>
            <input type="date" class="form-control" id="startDate" name="startDate">
        </div>
        <div class="col-md-4">
            <label for="endDate" class="form-label">Fecha de inscripción (hasta)</label>
            <input type="date" class="form-control" id="endDate" name="endDate">
        </div>
        <div class="col-md-4">
            <label for="categoryFilter" class="form-label">Categoría</label>
            <select id="categoryFilter" name="categoryFilter" class="form-select">
                <option value="">Todas las categorías</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['ID_Categoria']; ?>"><?= $category['Nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Estado del curso</label>
            <select id="statusFilter" name="statusFilter" class="form-select">
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
                <th>Certificado</th>
                <th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se renderizan los cursos dinámicamente -->
            <?php foreach ($kardexCursos as $curso): ?>
                <tr>
                    <td><?= htmlspecialchars($curso['Curso']) ?></td>
                    <td><?= htmlspecialchars($curso['Fecha_Inscripcion']) ?></td>
                    <td><?= htmlspecialchars($curso['Fecha_Ultimo_Ingreso']) ?></td>
                    <td><?= htmlspecialchars($curso['Progreso']) ?>%</td>
                    <td><?= htmlspecialchars($curso['Estado']) ?></td>
                    <td><?= $curso['Fecha_Terminacion'] ? htmlspecialchars($curso['Fecha_Terminacion']) : '-' ?></td>
                    <td>
                        <?php if ($curso['Certificado']): ?>
                            <a href="<?= htmlspecialchars($curso['Certificado']) ?>" class="btn btn-primary btn-sm" download>
                                Descargar PDF
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                    <button 
                        class="btn btn-primary btn-sm" 
                        data-bs-toggle="modal" 
                        <?= $curso['Estado'] === 'Completado' ? '' : 'disabled' ?> 
                        data-bs-target="#commentModal" 
                        data-id-curso="<?= $curso['ID_Curso'] ?>">
                        Realizar Comentarios
                    </button>
                    </td>
                </tr>
            <?php endforeach; ?>
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
                <form id="commentForm" action="/BDM-CI/kardex" method="POST">
                    <!-- ID del Curso -->
                    <input type="hidden" id="commentCourseId" name="ID_Curso">
                    <input type="hidden" id="userId" name="ID_Usuario" value="<?= $user['ID_Usuario']; ?>">
                    
                    <!-- Título del Comentario -->
                    <div class="mb-3">
                        <label for="commentTitle" class="form-label">Título del Comentario</label>
                        <input type="text" class="form-control" id="commentTitle" name="TituloComentario" placeholder="Escribe el título de tu comentario" required>
                    </div>
                    
                    <!-- Calificación -->
                    <div class="mb-3">
                        <label class="form-label">Calificación (1 a 5 estrellas)</label>
                        <select id="rating" name="Calificacion" class="form-select" required>
                            <option value="1">1 Estrella</option>
                            <option value="2">2 Estrellas</option>
                            <option value="3">3 Estrellas</option>
                            <option value="4">4 Estrellas</option>
                            <option value="5" selected>5 Estrellas</option>
                        </select>
                    </div>
                    
                    <!-- Descripción del Comentario -->
                    <div class="mb-3">
                        <label for="commentDescription" class="form-label">Descripción</label>
                        <textarea class="form-control" id="commentDescription" name="Comentario" rows="4" placeholder="Escribe tus comentarios aquí" required></textarea>
                    </div>
                    
                    <!-- Botón de Envío -->
                    <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Escucha el evento de mostrar el modal
    document.addEventListener('DOMContentLoaded', function () {
        const commentModal = document.getElementById('commentModal');
        const commentCourseIdInput = document.getElementById('commentCourseId');

        commentModal.addEventListener('show.bs.modal', function (event) {
            // Botón que activa el modal
            const button = event.relatedTarget;

            // Obtiene el valor de data-id-curso del botón
            const courseId = button.getAttribute('data-id-curso');

            // Asigna el valor al input oculto
            commentCourseIdInput.value = courseId;
        });
    });
</script>

</body>
</html>
