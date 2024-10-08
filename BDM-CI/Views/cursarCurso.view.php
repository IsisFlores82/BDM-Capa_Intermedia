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
    <link rel="stylesheet" href="Views/cursarCurso.css">
</head>
<body>
<?php require 'Components/headerStudent.php'; ?>
<!-- Contenedor principal con fondo blanco y sombra -->
<div class="container my-5 course-container">
        
    <!-- Imagen del curso -->
    <img src="https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg" alt="Curso Banner" class="course-banner mb-4">

    <!-- Título del curso e instructor -->
    <h1>Cómo ser cantante profesional</h1>
    <h3>Instructor: Hatsune Miku</h3>
    <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras elementum, libero vel tempor dapibus, quam felis tempus justo, id fringilla erat nibh eget mauris. Sed ipsum mi, tempus eget auctor sit amet, pellentesque id massa. Donec rutrum turpis vitae libero convallis, ut ultrices sapien tincidunt. Sed ut dapibus magna, nec ullamcorper magna. Nullam et nisl felis. Phasellus id ex semper, efficitur sapien a, ornare dolor. Nulla ac odio velit. Mauris nec ligula non justo dignissim varius. Praesent in purus viverra, bibendum lectus eget, faucibus odio. Donec et dui sit amet nibh gravida eleifend at malesuada tellus. Mauris eu augue quis justo pulvinar maximus. Curabitur sit amet felis tellus.

        Aenean accumsan tincidunt ante quis sodales. Aliquam in mauris eget risus lacinia egestas vitae eget justo. Donec eu ornare velit. Praesent efficitur hendrerit ipsum, ac euismod lectus. Aliquam mollis ex in augue posuere, rhoncus mattis nisi bibendum. Etiam fringilla varius libero ac imperdiet. Sed nisl elit, blandit sit amet nulla id, semper dictum ante. Duis viverra quam eget congue bibendum. Vestibulum tristique eros sed mauris malesuada euismod. Maecenas lacinia semper dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget porttitor dolor, sit amet maximus lectus.
        
        Cras venenatis lacus quis neque venenatis, quis posuere nisl porttitor. Suspendisse in euismod erat, sit amet pellentesque odio. Maecenas euismod egestas mi, in luctus nunc elementum eget. Nulla tristique porttitor ex, eget fermentum nunc hendrerit eget. Cras vitae ipsum at est interdum vulputate. Curabitur ipsum nisl, consequat non ex ac, euismod luctus mi. Fusce quis sem sit amet nibh volutpat molestie. Vestibulum sagittis neque augue. Vestibulum eget porta ligula, sit amet cursus quam. Mauris sed eleifend enim.
        
        Phasellus ac tellus sapien. Morbi ac lorem tempor, imperdiet massa sit amet, ornare diam. Sed finibus tempus velit, id placerat massa tincidunt a. Suspendisse posuere, lorem in vehicula scelerisque, nisl velit accumsan velit, ut aliquam massa risus ut orci. Vestibulum lacinia nec mi vitae dictum. Mauris eget semper tellus. Integer vel sapien nec risus pretium sagittis. Cras tristique lectus nulla, et varius erat pellentesque sed. Quisque condimentum convallis ante sit amet vulputate. In varius dolor tellus, eget facilisis ipsum volutpat sed. Pellentesque luctus, tellus eget porta convallis, nibh erat tempus nulla, sit amet rhoncus metus felis at nulla. Etiam hendrerit sollicitudin leo, et posuere urna molestie a. Donec convallis bibendum imperdiet. In vel elit et lacus maximus aliquet id sed sapien.
        
        Praesent felis nisi, laoreet ut scelerisque ut, finibus et justo. Curabitur nisl dui, feugiat et malesuada vitae, mattis eget dolor. Vestibulum feugiat gravida nisi, non sollicitudin diam maximus vitae. Nulla tempus dictum tincidunt. Sed dignissim non augue ut varius. Phasellus luctus viverra vehicula. Sed et felis sit amet risus aliquam consequat a vel ligula. Nullam vitae nisi nec libero luctus efficitur. Nullam et tincidunt lorem, non feugiat nunc. In facilisis tempus dapibus.</h6>
    <!-- Barra de progreso -->
    <div class="progress my-4">
        <div class="progress-bar bg-success" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60% Completado</div>
    </div>

    <!-- Niveles que posees -->
    <div class="accordion" id="courseLevels">

        <!-- Nivel 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Nivel 1: Introducción al HTML
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#courseLevels">
                <div class="accordion-body">
                    <ul>
                        <video controls width="95%">
                            <source src="Resources/Cucaracha.mp4" type="video/mp4">
                            Tu navegador no soporta la etiqueta de video.
                          </video>
                        <li><a href="#">Archivo: html-introduccion.pdf</a></li>
                        <li><a href="#">Imagen: estructura-basica-html.png</a></li>
                    </ul>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="completedLevel1">
                        <label class="form-check-label" for="completedLevel1">
                            Marcar como completado
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nivel 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Nivel 2: Introducción al CSS
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#courseLevels">
                <div class="accordion-body">
                    <ul>
                        <video controls width="95%">
                            <source src="Resources/Cucaracha.mp4" type="video/mp4">
                            Tu navegador no soporta la etiqueta de video.
                          </video>
                        <li><a href="#">Archivo: css-basico.pdf</a></li>
                        <li><a href="#">Imagen: ejemplo-css.png</a></li>
                    </ul>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="completedLevel2">
                        <label class="form-check-label" for="completedLevel2">
                            Marcar como completado
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nivel 3 - No poseído -->
        <div class="accordion-item disabled">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed disabled" type="button">
                    Nivel 3: JavaScript Avanzado (No Poseído)
                </button>
            </h2>
        </div>

    </div>
</div>

</body>
</html>