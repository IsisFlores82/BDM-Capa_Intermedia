<?php

// return [
//     '/' => 'Controller/logIn.controller.php',
//     '/signUp' => 'Controller/signUp.controller.php',
//     '/logIn' => 'Controller/logIn.controller.php',
//     '/dashboard' => 'Controller/dashboard.controller.php',
//     '/carrito' => 'Controller/carrito.controller.php',
//     '/search' => 'Controller/search.controller.php',
//     '/courseDetail' => 'Controller/courseDetail.controller.php',
//     '/profile' => 'Controller/profile.controller.php',
//     '/kardex' => 'Controller/kardex.controller.php',
//     '/mensajeria' => 'Controller/mensajeria.controller.php',
//     '/cursarCurso' => 'Controller/cursarCurso.controller.php',
//     '/profileAdmin' => 'Controller/profileAdmin.controller.php',
//     '/reporteUsuarios' => 'Controller/reporteUsuarios.controller.php',
//     '/profileInstructor' => 'Controller/profileInstructor.controller.php',
//     '/reporteDeVentas' => 'Controller/reporteDeVentas.controller.php',
//     '/ventaDetallada' => 'Controller/ventaDetallada.controller.php',
//     '/crearCurso' => 'Controller/crearCurso.controller.php',
// ];

$router->get('/BDM-CI/','Controller/dashboard.controller.php')->only('NoInstructor');
$router->get('/BDM-CI/dashboard','Controller/dashboard.controller.php')->only('NoInstructor');
$router->get('/BDM-CI/logIn','Controller/logIn.controller.php')->only('guest');
$router->get('/BDM-CI/signUp','Controller/signUp.controller.php')->only('guest');
$router->get('/BDM-CI/carrito','Controller/carrito.controller.php')->only('Alumno');
$router->get('/BDM-CI/carrito/eliminarDelCarrito','Controller/eliminarDelCarrito.controller.php')->only('Alumno');
$router->get('/BDM-CI/search','Controller/search.controller.php')->only('NoInstructor');
$router->get('/BDM-CI/courseDetail','Controller/courseDetail.controller.php')->only('NoInstructor');
$router->get('/BDM-CI/profile','Controller/profile.controller.php')->only('Alumno');
$router->get('/BDM-CI/kardex','Controller/kardex.controller.php')->only('Alumno');
$router->get('/BDM-CI/mensajeria','Controller/mensajeria.controller.php')->only('AlumnoInstructor');
$router->get('/BDM-CI/cursarCurso','Controller/cursarCurso.controller.php')->only('Alumno');
$router->get('/BDM-CI/profileAdmin','Controller/profileAdmin.controller.php')->only('Admin');
$router->get('/BDM-CI/profileAdmin/rehabilitate','Controller/rehabilitate.controller.php')->only('Admin');
$router->get('/BDM-CI/reporteUsuarios','Controller/reporteUsuarios.controller.php');
$router->get('/BDM-CI/profileInstructor','Controller/profileInstructor.controller.php')->only('Instructor');
$router->get('/BDM-CI/profileInstructor/deleteCourse','Controller/deleteCourse.controller.php')->only('Instructor');
$router->get('/BDM-CI/reporteDeVentas','Controller/reporteDeVentas.controller.php')->only('Instructor');
$router->get('/BDM-CI/ventaDetallada','Controller/ventaDetallada.controller.php')->only('Instructor');
$router->get('/BDM-CI/crearCurso','Controller/crearCurso.controller.php')->only('Instructor');
$router->get('/BDM-CI/editarCurso','Controller/editCourse.controller.php')->only('Instructor');
$router->get('/BDM-CI/logOut','Controller/logOut.controller.php');
$router->get('/BDM-CI/generatePDF','Controller/generatePDF.controller.php');
$router->get('/BDM-CI/privacidad','Controller/privacidad.controller.php');


$router->post('/BDM-CI/logIn','Controller/logIn.controller.php')->only('guest');
$router->post('/BDM-CI/signUp','Controller/signUp.controller.php')->only('guest');

$router->post('/BDM-CI/profile','Controller/profile.controller.php')->only('Alumno');
$router->patch('/BDM-CI/profile','Controller/profile.controller.php')->only('Alumno');
$router->post('/BDM-CI/kardex','Controller/kardex.controller.php')->only('Alumno');

$router->post('/BDM-CI/profileAdmin','Controller/profileAdmin.controller.php')->only('Admin');
$router->patch('/BDM-CI/profileAdmin','Controller/profileAdmin.controller.php')->only('Admin');

$router->post('/BDM-CI/profileInstructor','Controller/profileInstructor.controller.php')->only('Instructor');
$router->patch('/BDM-CI/profileInstructor','Controller/profileInstructor.controller.php')->only('Instructor');

$router->post('/BDM-CI/courseDetail','Controller/courseDetail.controller.php')->only('NoInstructor');
$router->post('/BDM-CI/carrito','Controller/carrito.controller.php')->only('Alumno');
$router->post('/BDM-CI/carrito/eliminarDelCarrito','Controller/eliminarDelCarrito.controller.php')->only('Alumno');
$router->post('/BDM-CI/cursarCurso/checkLevelProgress','Controller/checkLevelProgress.controller.php')->only('NoInstructor');
$router->delete('/BDM-CI/courseDetail','Controller/courseDetail.controller.php')->only('Admin');

$router->post('/BDM-CI/crearCurso','Controller/crearCurso.controller.php')->only('Instructor');
$router->post('/BDM-CI/editarCurso','Controller/editCourse.controller.php')->only('Instructor');
$router->patch('/BDM-CI/editarCurso','Controller/editCourse.controller.php')->only('Instructor');
$router->delete('/BDM-CI/editarCurso','Controller/editCourse.controller.php')->only('Instructor');
$router->post('/BDM-CI/profileInstructor/deleteCourse','Controller/deleteCourse.controller.php')->only('Instructor');

$router->post('/BDM-CI/generatePDF','Controller/generatePDF.controller.php');

// Ruta para obtener mensajes
$router->post('/BDM-CI/fetchMessages', 'Controller/fetchMessages.php')->only('AlumnoInstructor');

// Ruta para enviar mensajes
$router->post('/BDM-CI/sendMessage', 'Controller/sendMessage.php')->only('AlumnoInstructor');

// Ruta para obtener mensajes
$router->get('/BDM-CI/fetchMessages', 'Controller/fetchMessages.php')->only('AlumnoInstructor');

// Ruta para enviar mensajes
$router->get('/BDM-CI/sendMessage', 'Controller/sendMessage.php')->only('AlumnoInstructor');

