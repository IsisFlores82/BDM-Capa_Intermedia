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
            <h1 class="mt-4">Miku Academy</h1>

            <section class="my-4">
                <h2 class="h5 mb-3">Nuestras Categorías!</h2>
                <div id="categoriesCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($categories as $index => $category): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="d-flex justify-content-center align-items-center py-4">
                                    <h3 class="fs-4"><?= htmlspecialchars($category['Nombre']) ?></h3>
                                </div>
                                <div class="d-flex justify-content-center align-items-center py-2">
                                    <h5 class="fs-6"><?= htmlspecialchars($category['Descripcion']) ?></h5>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#categoriesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#categoriesCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </section>

            <!-- Favorites section -->
            <section>
                <h2 class="h5 mt-4">Los Favoritos</h2>
                <div class="row">
                    <?php foreach ($coursesFav as $course): ?>
                        <div class="col-md-6">
                            <a href="/BDM-CI/courseDetail?id=<?= $course['ID_Curso'] ?>" class="card-link">
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                        // Procesamiento del BLOB de imagen para mostrarla correctamente
                                        if (!empty($course['Course_Image'])) {
                                            $finfo = new finfo(FILEINFO_MIME_TYPE);
                                            $mimeType = $finfo->buffer($course['Course_Image']); // Detecta el tipo MIME
                                            $fotoBase64 = base64_encode($course['Course_Image']); // Codifica la imagen en base64
                                            $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
                                        } else {
                                            // Imagen de respaldo si no hay una imagen guardada en el curso
                                            $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
                                        }
                                        ?>
                                        <img src="<?= $fotoSrc ?>" alt="Curso" class="img-fluid course-image">
                                    
                                        <!-- Título, Autor y costo del curso -->
                                        <h5 class="card-title"><?= htmlspecialchars($course['Course_Title']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($course['Instructor_Nombre']) . " " . htmlspecialchars($course['Instructor_Apellidos']) ?></p>
                                        <p class="card-text"><?= $course['Course_Price'] ?>$</p>
                                    
                                        <!-- Reseñas de estrellas (puedes reemplazarlo si tienes datos de calificación) -->
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- All courses section -->
            <section>
                <h2 class="h5 mt-4">Todos los Cursos</h2>
                <div class="row g-2">
                    <?php foreach ($generalCourses as $course): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                            <a href="/BDM-CI/courseDetail?id=<?= $course['ID_Curso'] ?>" class="card-link">
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                        // Handle BLOB image or use default
                                        if (!empty($course['Course_Image'])) {
                                            $finfo = new finfo(FILEINFO_MIME_TYPE);
                                            $mimeType = $finfo->buffer($course['Course_Image']);
                                            $fotoBase64 = base64_encode($course['Course_Image']);
                                            $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
                                        } else {
                                            $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
                                        }
                                        ?>
                                        <img src="<?= $fotoSrc ?>" alt="Curso" class="img-fluid course-image">
                                        <h5 class="card-title"><?= htmlspecialchars($course['Course_Title']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($course['Instructor_Nombre']) . " " . htmlspecialchars($course['Instructor_Apellidos']) ?></p>
                                        <p class="card-text"><?= htmlspecialchars($course['Course_Price']) ?>$</p>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

        </main>
    </div>

</body>
</html>