<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miku Academy - Resultados de Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Views/dashboard.js"></script>
    <link rel="stylesheet" href="Views/dashboard.css">
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

<div class="container">
    <main>
        <h1 class="mt-4">Resultados de Búsqueda</h1>

        <?php if (empty($cursos)): ?>
            <p class="text-muted">No se encontraron resultados para los filtros aplicados.</p>
        <?php else: ?>
            <!-- Sección de cursos encontrados -->
            <section class="my-4">
                <h2 class="h5 mb-3">Cursos Encontrados</h2>
                <div class="row">
                    <?php foreach ($cursos as $curso): ?>
                        <div class="col-md-4">
                            <a href="/BDM-CI/courseDetail?id=<?= $curso['ID_Curso']; ?>" class="card-link">
                                <div class="card mb-4 shadow-sm">
                                    <img src="data:image/jpeg;base64,<?= base64_encode($curso['Course_Image']); ?>" 
                                         alt="Imagen del Curso" 
                                         class="card-img-top course-image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($curso['Course_Title']); ?></h5>
                                        <p class="card-text text-muted"><?= htmlspecialchars($curso['Instructor_Nombre'] . ' ' . $curso['Instructor_Apellidos']); ?></p>
                                        <p class="card-text fw-bold"><?= htmlspecialchars($curso['Course_Price']); ?>$</p>
                                        <div class="text-warning">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <i class="fas fa-star<?= $i < $curso['Calificacion'] ? '' : '-o'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>
</div>

    
</body>
</html>
