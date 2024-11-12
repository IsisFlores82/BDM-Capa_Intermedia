<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miku Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Usar SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script> 

    <link rel="stylesheet" href="Views/dashboard.css">
    <link rel="stylesheet" href="Views/courseDetail.css">
</head>
<body>
<?php
if(!isset($_SESSION['user'])){
require 'Components/headerGuest.php';
}else if($_SESSION['user']['Rol']==='Alumno'){
require 'Components/headerStudent.php';
}else if($_SESSION['user']['Rol']==='Administrador'){
require 'Components/headerAdmin.php';
}
?>

<?php
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $alertType = $mensaje['type'] == 'success' ? 'success' : 'error';
    // Escapar los caracteres especiales del mensaje
    $text = htmlspecialchars($mensaje['text'], ENT_QUOTES, 'UTF-8');

    // Usando SweetAlert2 para mostrar la alerta
    echo "<script>
        Swal.fire({
            title: '$alertType',
            text: '$text',
            icon: '$alertType',
            confirmButtonText: 'OK'
        });
    </script>";
    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}
?>
<div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="banner-container mb-3">
                    <img src="data:image/jpeg;base64,<?= base64_encode($course['Imagen']) ?>" alt="Banner del curso" class="img-fluid w-100">
                </div>
                
                <div class="mb-4">
                    <h1>Curso: <?= htmlspecialchars($course['Titulo']) ?></h1>
                    <a href="/BDM-CI/mensajeria">Instructor: <?= htmlspecialchars($instructor) ?></a>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span>(4.5/5 estrellas)</span>
                    </div>
                    <p>Categoría: <?= htmlspecialchars($category['Nombre']) ?></p>
                </div>

                <!-- Niveles y Precios -->
                <div class="mb-4">
                    <h3>Niveles del curso</h3>
                    <ul class="list-group">
                        <?php foreach ($levels as $level): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($level['Titulo']) ?>
                                <!-- Formulario para agregar al carrito -->
                                <form action="/BDM-CI/courseDetail" method="POST" class="d-inline">
                                    <input type="hidden" name="tipo" value="nivel">
                                    <input type="hidden" name="id_curso" value="<?= htmlspecialchars($courseId) ?>">
                                    <input type="hidden" name="id_nivel" value="<?= $level['ID_Nivel'] ?>">
                                    <input type="hidden" name="id_usuario" value="<?= $user['ID_Usuario'] ?>"> <!-- ID del usuario -->
                                    <button type="submit" class="badge bg-success rounded-pill" <?= ($user['Rol'] === 'Alumno') ? '' : 'disabled' ?>>
                                        <?= htmlspecialchars(number_format($level['Costo_Nivel'], 2)) ?>
                                    </button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Descripción del Curso -->
                <div class="mb-4">
                    <h3>Descripción del Curso</h3>
                    <p><?= htmlspecialchars($course['Descripcion']) ?></p>
                </div>

                <div class="mb-4">
                <h3>Comentarios</h3>
                <?php if (empty($comentarios)) : ?>
                    <p class="text-muted">Sin comentarios</p>
                <?php else : ?>
                    <?php foreach ($comentarios as $comentario) : ?>
                        <div class="card comment-card mb-3 position-relative">
                            <div class="card-body">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-btn" onclick="deleteComment(this)">Eliminar</button>
                                <div class="d-flex align-items-start">
                                    <img src="<?= htmlspecialchars($comentario['avatar']) ?>" alt="Usuario" class="rounded-circle me-3" width="50" height="50">
                                    <div>
                                        <h5 class="card-title"><?= htmlspecialchars($comentario['nombre_usuario']) ?></h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Calificación: <?= htmlspecialchars($comentario['calificacion']) ?>/5</h6>
                                        <p class="card-text"><?= htmlspecialchars($comentario['texto']) ?></p>
                                        <small class="text-muted">Fecha y hora de creación: <?= htmlspecialchars($comentario['fecha']) ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

            <!-- Sidebar Sticky -->
            <div class="col-md-4">
                <div class="card sticky-sidebar">
                    <div class="card-body">
                        <h4>Precio Total del Curso</h4>
                        <p>$<?= htmlspecialchars(number_format($course['Costo_Total'], 2)) ?></p>
                        <!-- Agregar curso al carrito -->
                        <form action="/BDM-CI/courseDetail" method="POST" class="mb-4">
                            <input type="hidden" name="tipo" value="curso">
                            <input type="hidden" name="id_curso" value="<?= $course['ID_Curso'] ?>">
                            <input type="hidden" name="id_usuario" value="<?= $user['ID_Usuario'] ?>"> <!-- ID del usuario -->
                            <button type="submit" class="btn btn-success w-100" <?= ($user['Rol'] === 'Alumno') ? '' : 'disabled' ?> >
                                Agregar al carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteComment(button) {
            const reason = prompt("Por favor, ingresa el motivo para eliminar este comentario:");
            if (reason) {
                const commentCard = button.closest('.comment-card');
                commentCard.innerHTML = `<div class="card-body"><p class="card-text text-danger">Comentario eliminado, motivo: ${reason}</p></div>`;
            } else {
                alert('No se ha proporcionado un motivo para eliminar el comentario.');
            }
        }
    </script>
</body>
</html>
