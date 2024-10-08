<?php

$uri=parse_url($_SERVER['REQUEST_URI'])['path'];
dd($uri);
$basePath = '/BDM-CI';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
$routes = [
    '/' => 'Controller/logIn.controller.php',
    '/signUp' => 'Controller/signUp.controller.php',
    '/logIn' => 'Controller/logIn.controller.php',
    '/dashboard' => 'Controller/dashboard.controller.php',
    '/carrito' => 'Controller/carrito.controller.php',
    '/search' => 'Controller/search.controller.php',
    '/courseDetail' => 'Controller/courseDetail.controller.php',
    '/profile' => 'Controller/profile.controller.php',
    '/kardex' => 'Controller/kardex.controller.php',
    '/mensajeria' => 'Controller/mensajeria.controller.php',
    '/cursarCurso' => 'Controller/cursarCurso.controller.php',
    '/profileAdmin' => 'Controller/profileAdmin.controller.php',
    '/reporteUsuarios' => 'Controller/reporteUsuarios.controller.php',
    '/profileInstructor' => 'Controller/profileInstructor.controller.php',
    '/reporteDeVentas' => 'Controller/reporteDeVentas.controller.php',
    '/ventaDetallada' => 'Controller/ventaDetallada.controller.php',
    '/crearCurso' => 'Controller/crearCurso.controller.php',
];



function routeToController($uri,$routes){
    if(array_key_exists($uri,$routes)){
        require $routes[$uri];
    }else{
        abort();
    }
}

function abort($code=404){
    http_response_code($code);
    echo "valio madres jeje 404";
    die();
}

routeToController($uri,$routes);