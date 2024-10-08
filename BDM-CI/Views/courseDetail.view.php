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
    <link rel="stylesheet" href="Views/dashboard.css">
    <link rel="stylesheet" href="Views/courseDetail.css">
</head>
<body>
<?php include 'Components/headerStudent.php'; ?>
    <div class="container mt-5">
        <div class="row">
            <!-- Contenedor Principal -->
            <div class="col-md-8">
                <div class="banner-container mb-3">
                        <!-- Imagen de Banner -->
                    <img src="https://www.mundodeportivo.com/alfabeta/hero/2024/07/hatsune-miku-tendra-su-gran-pelicula-de-anime.jpg?width=1200&aspect_ratio=16:9" alt="Banner del curso" class="img-fluid w-100">
                </div>
                <!-- Sección del título -->
                <div class="mb-4">
                    <h1>Curso: Cómo hacer una base de datos profesional</h1>
                    <a href="/BDM-CI/mensajeria">Instructor: John Doe</a>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span>(4.5/5 estrellas)</span>
                    </div>
                    <p>Categoría: Bases de Datos</p>
                </div>

                <!-- Sección de niveles y precios -->
                <div class="mb-4">
                    <h3>Niveles del curso</h3>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Nivel 1: Introducción a las Bases de Datos
                            <a href="#" class="badge bg-success rounded-pill add-to-cart" onclick="addToCart()">$49.99</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Nivel 2: Diseño de Bases de Datos
                            <a href="#" class="badge bg-success rounded-pill add-to-cart" onclick="addToCart()">$59.99</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Nivel 3: Optimización de Bases de Datos
                            <a href="#" class="badge bg-success rounded-pill add-to-cart" onclick="addToCart()">$69.99</a>
                        </li>
                    </ul>
                </div>

                <!-- Sección de descripción del curso -->
                <div class="mb-4">
                    <h3>Descripción del Curso</h3>
                    <p>En este curso aprenderás a diseñar, construir y optimizar bases de datos desde lo más básico hasta conceptos avanzados. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ultricies, libero id interdum lacinia, neque dolor ornare risus, sed accumsan ipsum turpis sed dui. Aliquam a mattis mi, pulvinar ornare velit. Integer semper tortor tempor, blandit lorem ac, gravida tellus. Praesent sed velit pulvinar, porta urna non, interdum ipsum. Suspendisse ut rhoncus erat. Nunc id ante vel ante luctus volutpat at a magna. Donec vitae odio eget dui interdum tempor ut at eros. Quisque orci lorem, lobortis a faucibus sit amet, molestie at quam. Nullam at nisl tincidunt, sodales leo id, fringilla lacus. Nulla turpis purus, tincidunt eget consequat ut, tempus sed nunc. Quisque at turpis purus. Aliquam a lectus non odio feugiat consectetur non eget massa.

                        In euismod felis a turpis tincidunt, eget ornare arcu viverra. Suspendisse fringilla lobortis odio, vitae elementum velit semper non. Etiam vulputate sem ac commodo congue. Curabitur fermentum sem id enim lobortis, vel maximus dui aliquet. In neque sem, placerat dictum iaculis tristique, cursus et dui. Etiam rutrum turpis felis, non pretium nisi venenatis sit amet. Aenean dictum lorem nunc, ut ultrices lorem scelerisque eu. Suspendisse elementum varius sodales. Pellentesque mattis mauris in rutrum dapibus. Donec commodo enim vel orci placerat scelerisque. Donec viverra turpis augue, id dapibus mi tempor ut. Suspendisse potenti. Praesent dui neque, ornare a vehicula sit amet, facilisis in est. Nullam sed justo lobortis, facilisis mi vel, fermentum elit. Aliquam suscipit lectus ac ultricies sollicitudin.
                        
                        Morbi tristique erat id lorem condimentum, id luctus est maximus. Nunc ultricies facilisis mi in pellentesque. Vivamus ligula dui, ultricies eu mollis a, convallis eget magna. Cras quis justo ultrices ipsum euismod tristique. Nulla lectus erat, fringilla et laoreet sit amet, efficitur nec augue. Phasellus vel lorem arcu. Nam dapibus pharetra sapien, mattis rutrum augue elementum nec. Praesent egestas dolor ut faucibus euismod. Suspendisse potenti. Nulla facilisi. Donec ante massa, ultricies eu ante vitae, mollis hendrerit augue. Aenean porta a purus ultrices maximus. Etiam risus lectus, efficitur id sapien a, accumsan mollis lectus.
                        
                        Sed eget tincidunt leo. Etiam pellentesque, lacus et suscipit cursus, magna magna aliquet elit, in sodales nulla enim at tellus. Curabitur egestas finibus tempus. Vivamus a massa consequat, blandit libero nec, laoreet massa. Etiam vitae feugiat massa. Suspendisse eu nulla eu quam commodo auctor at ac est. Duis efficitur nulla commodo, accumsan nulla sodales, varius eros. Sed aliquet, nisi vel pharetra placerat, massa dui mollis sem, in cursus nisl arcu non dolor. Proin semper arcu diam, sed feugiat risus mattis sed. Integer in commodo tellus. Praesent elementum elit eget erat vehicula, ac gravida purus vestibulum. Praesent elit nunc, auctor in convallis eu, viverra vel justo. Integer malesuada venenatis interdum. Sed at enim scelerisque, pellentesque libero volutpat, bibendum justo. Suspendisse in vehicula dolor.
                        
                        Curabitur sodales, lectus a pulvinar sodales, quam ex varius purus, at tristique mi lorem vitae mi. Suspendisse ut blandit magna, et sagittis massa. Nam gravida efficitur odio at sollicitudin. Nulla vehicula urna eu erat vehicula, eget maximus odio tristique. Sed bibendum vehicula nisi, eu commodo ligula vehicula et. Donec efficitur nibh ultricies, gravida mauris at, pretium nibh. Morbi vitae tristique metus.</p>
                </div>

<!-- Sección de comentarios -->
<div class="mb-4">
    <h3>Comentarios</h3>
    <!-- Comentario 1 -->
    <div class="card comment-card mb-3 position-relative">
        <div class="card-body">
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-btn" onclick="deleteComment(this)">Eliminar</button>
            <div class="d-flex align-items-start">
                <img src="https://i.pinimg.com/736x/22/ff/8a/22ff8afb93f9341702464368314aaaa2.jpg" alt="Usuario 1" class="rounded-circle me-3" width="50" height="50">
                <div>
                    <h5 class="card-title">Usuario 1</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Calificación: 5/5</h6>
                    <p class="card-text">Este curso me ayudó a mejorar mi entendimiento sobre bases de datos. ¡Muy recomendado!</p>
                    <small class="text-muted">Fecha y hora de creación: 2024-09-18 14:30</small>
                </div>
            </div>
        </div>
    </div>
    <!-- Comentario 2 -->
    <div class="card comment-card mb-3 position-relative">
        <div class="card-body">
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-btn" onclick="deleteComment(this)">Eliminar</button>
            <div class="d-flex align-items-start">
                <img src="https://www.mundodeportivo.com/alfabeta/hero/2024/07/hatsune-miku-tendra-su-gran-pelicula-de-anime.jpg?width=1200&aspect_ratio=16:9" alt="Usuario 2" class="rounded-circle me-3" width="50" height="50">
                <div>
                    <h5 class="card-title">Usuario 2</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Calificación: 4/5</h6>
                    <p class="card-text">El curso está bien, aunque esperaba más en la parte de optimización.</p>
                    <small class="text-muted">Fecha y hora de creación: 2024-09-17 09:15</small>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>

            <!-- Sidebar Sticky -->
            <div class="col-md-4">
                <div class="card sticky-sidebar">
                    <div class="card-body">
                        <h4>Precio Total del Curso</h4>
                        <p>$179.97</p>
                        <button class="btn btn-success w-100" onclick="addToCart()">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function addToCart() {
            alert("Agregado al carrito");
        }

        function deleteComment(button) {
    // Solicitar motivo de eliminación
    const reason = prompt("Por favor, ingresa el motivo para eliminar este comentario:");
    
    // Verificar si se ingresó un motivo
    if (reason) {
        // Obtener el contenedor del comentario (tarjeta)
        const commentCard = button.closest('.comment-card');

        // Limpiar el contenido del comentario
        commentCard.innerHTML = `
            <div class="card-body">
                <p class="card-text text-danger">Comentario eliminado, motivo: ${reason}</p>
            </div>
        `;
    } else {
        alert('No se ha proporcionado un motivo para eliminar el comentario.');
    }
}
    </script>
    
</body>
</html>
