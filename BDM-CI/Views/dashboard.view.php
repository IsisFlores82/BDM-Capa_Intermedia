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
                        <div class="carousel-item active">
                            <div class="d-flex justify-content-center align-items-center py-4">
                                <h3 class="fs-4">Desarrollo</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center py-4">
                                <h3 class="fs-4">Bases de Datos</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center py-4">
                                <h3 class="fs-4">Marketing</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center py-4">
                                <h3 class="fs-4">Diseño</h3>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center py-4">
                                <h3 class="fs-4">Unreal</h3>
                            </div>
                        </div>
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
                    <div class="col-md-6">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como ser cantante profesional</h5>
                                <p class="card-text">Hatsune Miku</p>
                                <p class="card-text">999$</p>
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
                    <div class="col-md-6">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://bs-uploads.toptal.io/blackfish-uploads/components/open_graph_image/8959179/og_image/optimized/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer una base de datos mamastrosa</h5>
                                <p class="card-text">Villatrue</p>
                                <p class="card-text">850$</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </section>

            <!-- All courses section -->
            <section>
                <h2 class="h5 mt-4">Todos los Cursos</h2>
                <div class="row g-2">
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como ser cantante profesional</h5>
                                <p class="card-text">Hatsune Miku</p>
                                <p class="card-text">999$</p>
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
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                           <div class="card-body">
                               <img src="https://bs-uploads.toptal.io/blackfish-uploads/components/open_graph_image/8959179/og_image/optimized/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer una base de datos mamastrosa</h5>
                                <p class="card-text">Villatrue</p>
                                <p class="card-text">850$</p>
                               <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://mastermetrics.com/wp-content/uploads/2024/07/meta-ai.jpg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer que meta ai no trolee</h5>
                                <p class="card-text">Dream Team</p>
                                <p class="card-text">500$</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://keystoneacademic-res.cloudinary.com/image/upload/f_auto/q_auto/g_auto/c_fill/w_1280/element/17/172834_default-meta-image-v2.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Curso Udemy</h5>
                                <p class="card-text">Persona Generica 3</p>
                                <p class="card-text">0$</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como ser cantante profesional</h5>
                                <p class="card-text">Hatsune Miku</p>
                                <p class="card-text">999$</p>
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
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                           <div class="card-body">
                               <img src="https://bs-uploads.toptal.io/blackfish-uploads/components/open_graph_image/8959179/og_image/optimized/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer una base de datos mamastrosa</h5>
                                <p class="card-text">Villatrue</p>
                                <p class="card-text">850$</p>
                               <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como ser cantante profesional</h5>
                                <p class="card-text">Hatsune Miku</p>
                                <p class="card-text">999$</p>
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
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                           <div class="card-body">
                               <img src="https://bs-uploads.toptal.io/blackfish-uploads/components/open_graph_image/8959179/og_image/optimized/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer una base de datos mamastrosa</h5>
                                <p class="card-text">Villatrue</p>
                                <p class="card-text">850$</p>
                               <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://mastermetrics.com/wp-content/uploads/2024/07/meta-ai.jpg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer que meta ai no trolee</h5>
                                <p class="card-text">Dream Team</p>
                                <p class="card-text">500$</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://keystoneacademic-res.cloudinary.com/image/upload/f_auto/q_auto/g_auto/c_fill/w_1280/element/17/172834_default-meta-image-v2.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Curso Udemy</h5>
                                <p class="card-text">Persona Generica 3</p>
                                <p class="card-text">0$</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como ser cantante profesional</h5>
                                <p class="card-text">Hatsune Miku</p>
                                <p class="card-text">999$</p>
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
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                           <div class="card-body">
                               <img src="https://bs-uploads.toptal.io/blackfish-uploads/components/open_graph_image/8959179/og_image/optimized/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer una base de datos mamastrosa</h5>
                                <p class="card-text">Villatrue</p>
                                <p class="card-text">850$</p>
                               <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://mastermetrics.com/wp-content/uploads/2024/07/meta-ai.jpg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer que meta ai no trolee</h5>
                                <p class="card-text">Dream Team</p>
                                <p class="card-text">500$</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://keystoneacademic-res.cloudinary.com/image/upload/f_auto/q_auto/g_auto/c_fill/w_1280/element/17/172834_default-meta-image-v2.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Curso Udemy</h5>
                                <p class="card-text">Persona Generica 3</p>
                                <p class="card-text">0$</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como ser cantante profesional</h5>
                                <p class="card-text">Hatsune Miku</p>
                                <p class="card-text">999$</p>
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
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                           <div class="card-body">
                               <img src="https://bs-uploads.toptal.io/blackfish-uploads/components/open_graph_image/8959179/og_image/optimized/0712-Bad_Practices_in_Database_Design_-_Are_You_Making_These_Mistakes_Dan_Social-754bc73011e057dc76e55a44a954e0c3.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer una base de datos mamastrosa</h5>
                                <p class="card-text">Villatrue</p>
                                <p class="card-text">850$</p>
                               <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://mastermetrics.com/wp-content/uploads/2024/07/meta-ai.jpg" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Como hacer que meta ai no trolee</h5>
                                <p class="card-text">Dream Team</p>
                                <p class="card-text">500$</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="/BDM-CI/courseDetail" class="card-link">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://keystoneacademic-res.cloudinary.com/image/upload/f_auto/q_auto/g_auto/c_fill/w_1280/element/17/172834_default-meta-image-v2.png" alt="Curso" class="img-fluid course-image">
                                <h5 class="card-title">Curso Udemy</h5>
                                <p class="card-text">Persona Generica 3</p>
                                <p class="card-text">0$</p>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                
                </div>
            </section>

        </main>
    </div>

</body>
</html>