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

$router->get('/BDM-CI/','controller/dashboard.controller.php');
$router->get('/BDM-CI/dashboard','controller/dashboard.controller.php');
$router->get('/BDM-CI/logIn','controller/logIn.controller.php')->only('guest');
$router->get('/BDM-CI/signUp','controller/signUp.controller.php')->only('guest');
$router->get('/BDM-CI/carrito','controller/carrito.controller.php')->only('Alumno');
$router->get('/BDM-CI/search','controller/search.controller.php');
$router->get('/BDM-CI/courseDetail','controller/courseDetail.controller.php');
$router->get('/BDM-CI/profile','controller/profile.controller.php');
$router->get('/BDM-CI/kardex','controller/kardex.controller.php');
$router->get('/BDM-CI/mensajeria','controller/mensajeria.controller.php');
$router->get('/BDM-CI/cursarCurso','controller/cursarCurso.controller.php');
$router->get('/BDM-CI/profileAdmin','controller/profileAdmin.controller.php');
$router->get('/BDM-CI/reporteUsuarios','controller/reporteUsuarios.controller.php');
$router->get('/BDM-CI/profileInstructor','controller/profileInstructor.controller.php');
$router->get('/BDM-CI/reporteDeVentas','controller/reporteDeVentas.controller.php');
$router->get('/BDM-CI/ventaDetallada','controller/ventaDetallada.controller.php');
$router->get('/BDM-CI/crearCurso','controller/crearCurso.controller.php');
$router->get('/BDM-CI/logOut','controller/logOut.controller.php');

$router->post('/BDM-CI/logIn','controller/logIn.controller.php');
$router->post('/BDM-CI/signUp','controller/signUp.controller.php');

$router->post('/BDM-CI/profile','controller/profile.controller.php');
$router->patch('/BDM-CI/profile','controller/profile.controller.php');